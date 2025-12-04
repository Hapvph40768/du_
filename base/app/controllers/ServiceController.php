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
        $supplierModel = new SupplierModel();
        $suppliers = $supplierModel->getAll();

        $tourModel = new TourModel();
        $tours = $tourModel->getAllTours();

        return $this->render("admin.service.addService", [
            'suppliers' => $suppliers,
            'tours'     => $tours
        ]);
    }

    // 3. Xử lý thêm dịch vụ
    public function postService()
    {
        $error = [];

        $name         = $_POST['name'] ?? '';
        $package_name = $_POST['package_name'] ?? '';
        $tour_id      = $_POST['tour_id'] ?? null;
        $supplier_id  = $_POST['supplier_id'] ?? null;
        $price        = $_POST['price'] ?? 0;
        $default_price= $_POST['default_price'] ?? 0;
        $currency     = $_POST['currency'] ?? 'VND';
        $type         = $_POST['type'] ?? null;
        $description  = $_POST['description'] ?? null;
        $is_optional  = isset($_POST['is_optional']) ? 1 : 0;
        $is_active    = isset($_POST['is_active']) ? 1 : 0;

        // Validate
        if (empty($name)) {
            $error['name'] = "Tên dịch vụ không được để trống.";
        }
        if (!is_numeric($price) || $price < 0) {
            $error['price'] = "Giá dịch vụ phải là số không âm.";
        }
        if (!is_numeric($default_price) || $default_price < 0) {
            $error['default_price'] = "Giá mặc định phải là số không âm.";
        }
        if (strlen($currency) !== 3) {
            $error['currency'] = "Đơn vị tiền tệ phải gồm 3 ký tự (VD: VND, USD).";
        }

        if (!empty($error)) {
            redirect('errors', $error, 'add-service');
        }

        $check = $this->service->addService([
            'tour_id'      => $tour_id,
            'package_name' => $package_name,
            'name'         => $name,
            'description'  => $description,
            'type'         => $type,
            'supplier_id'  => $supplier_id,
            'price'        => $price,
            'default_price'=> $default_price,
            'currency'     => $currency,
            'is_optional'  => $is_optional,
            'is_active'    => $is_active,
            'created_at'   => date("Y-m-d H:i:s"),
            'updated_at'   => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Thêm dịch vụ thành công", 'list-service');
        } else {
            redirect('errors', "Thêm dịch vụ thất bại", 'add-service');
        }
    }

    // 4. Chi tiết dịch vụ để sửa
    public function detailService($id)
    {
        $detail = $this->service->getServiceById($id);

        $supplierModel = new SupplierModel();
        $suppliers = $supplierModel->getAll();

        $tourModel = new TourModel();
        $tours = $tourModel->getAllTours();

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

        $error = [];

        $name         = $_POST['name'] ?? '';
        $package_name = $_POST['package_name'] ?? '';
        $tour_id      = $_POST['tour_id'] ?? null;
        $supplier_id  = $_POST['supplier_id'] ?? null;
        $price        = $_POST['price'] ?? 0;
        $default_price= $_POST['default_price'] ?? 0;
        $currency     = $_POST['currency'] ?? 'VND';
        $type         = $_POST['type'] ?? null;
        $description  = $_POST['description'] ?? null;
        $is_optional  = isset($_POST['is_optional']) ? 1 : 0;
        $is_active    = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            $error['name'] = "Tên dịch vụ không được để trống.";
        }
        if (!is_numeric($price) || $price < 0) {
            $error['price'] = "Giá dịch vụ phải là số không âm.";
        }
        if (!is_numeric($default_price) || $default_price < 0) {
            $error['default_price'] = "Giá mặc định phải là số không âm.";
        }
        if (strlen($currency) !== 3) {
            $error['currency'] = "Đơn vị tiền tệ phải gồm 3 ký tự.";
        }

        $route = 'detail-service/' . $id;
        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $check = $this->service->updateService($id, [
            'tour_id'      => $tour_id,
            'package_name' => $package_name,
            'name'         => $name,
            'description'  => $description,
            'type'         => $type,
            'supplier_id'  => $supplier_id,
            'price'        => $price,
            'default_price'=> $default_price,
            'currency'     => $currency,
            'is_optional'  => $is_optional,
            'is_active'    => $is_active,
            'updated_at'   => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Cập nhật dịch vụ thành công", 'list-service');
        } else {
            redirect('errors', "Cập nhật thất bại", $route);
        }
    }

    // 6. Xóa dịch vụ
    public function deleteService($id)
    {
        $check = $this->service->deleteService($id);

        if ($check) {
            redirect('success', "Xóa dịch vụ thành công", 'list-service');
        } else {
            redirect('errors', "Xóa thất bại", 'list-service');
        }
    }
}
?>