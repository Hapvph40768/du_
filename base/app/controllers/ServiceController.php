<?php
namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\SupplierModel;
use App\Models\TourModel;

class ServiceController extends BaseController
{
    protected $service;

    public function __construct()
    {
        $this->service = new ServiceModel();
    }

    // 1. Danh sách dịch vụ
    public function listServices()
    {
        $services = $this->service->getAllServices();
        return $this->render("admin.service.listService", ['services' => $services]);
    }

    // 2. Form thêm dịch vụ
    public function createService()
    {
        $suppliers = (new SupplierModel())->getAll();
        $tours     = (new TourModel())->getAllTours();

        return $this->render("admin.service.addService", [
            'suppliers' => $suppliers,
            'tours'     => $tours
        ]);
    }

    // 3. Xử lý thêm dịch vụ
    public function postService()
    {
        $data  = $this->collectServiceData();
        $error = $this->validateServiceData($data);

        if (!empty($error)) {
            redirect('errors', $error, 'add-service');
        }

        $data['created_at'] = $data['updated_at'] = date("Y-m-d H:i:s");

        $check = $this->service->addService($data);

        $check
            ? redirect('success', "Thêm dịch vụ thành công", 'list-service')
            : redirect('errors', "Thêm dịch vụ thất bại", 'add-service');
    }

    // 4. Chi tiết dịch vụ để sửa
    public function detailService($id)
    {
        $detail    = $this->service->getServiceById($id);
        $suppliers = (new SupplierModel())->getAll();
        $tours     = (new TourModel())->getAllTours();

        return $this->render("admin.service.editService", [
            'detail'    => $detail,
            'suppliers' => $suppliers,
            'tours'     => $tours
        ]);
    }

    // 5. Xử lý sửa dịch vụ
    public function editService($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $data  = $this->collectServiceData();
        $error = $this->validateServiceData($data);
        $route = 'detail-service/' . $id;

        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $data['updated_at'] = date("Y-m-d H:i:s");

        $check = $this->service->updateService($id, $data);

        $check
            ? redirect('success', "Cập nhật dịch vụ thành công", 'list-service')
            : redirect('errors', "Cập nhật thất bại", $route);
    }

    // 6. Xóa dịch vụ
    public function deleteService($id)
    {
        $check = $this->service->deleteService($id);

        $check
            ? redirect('success', "Xóa dịch vụ thành công", 'list-service')
            : redirect('errors', "Xóa thất bại", 'list-service');
    }

    // --- Hỗ trợ: thu thập dữ liệu từ form ---
    private function collectServiceData()
    {
        return [
            'tour_id'      => $_POST['tour_id'] ?? null,
            'package_name' => $_POST['package_name'] ?? '',
            'name'         => $_POST['name'] ?? '',
            'description'  => $_POST['description'] ?? null,
            'type'         => $_POST['type'] ?? null,
            'supplier_id'  => $_POST['supplier_id'] ?? null,
            'price'        => $_POST['price'] ?? 0,
            'default_price'=> $_POST['default_price'] ?? 0,
            'currency'     => $_POST['currency'] ?? 'VND',
            'is_optional'  => isset($_POST['is_optional']) ? 1 : 0,
            'is_active'    => isset($_POST['is_active']) ? 1 : 0
        ];
    }

    // --- Hỗ trợ: validate dữ liệu dịch vụ ---
    private function validateServiceData($data)
    {
        $error = [];

        if (empty($data['name'])) {
            $error['name'] = "Tên dịch vụ không được để trống.";
        }
        if (!is_numeric($data['price']) || $data['price'] < 0) {
            $error['price'] = "Giá dịch vụ phải là số không âm.";
        }
        if (!is_numeric($data['default_price']) || $data['default_price'] < 0) {
            $error['default_price'] = "Giá mặc định phải là số không âm.";
        }
        if (strlen($data['currency']) !== 3) {
            $error['currency'] = "Đơn vị tiền tệ phải gồm 3 ký tự (VD: VND, USD).";
        }

        return $error;
    }
}
?>
