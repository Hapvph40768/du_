<?php
namespace App\Controllers;

use App\Models\TourSupplierModel;
use App\Models\SupplierModel;
use App\Models\TourModel;

/**
 * Class TourSupplierController
 * Quản lý gán Nhà cung cấp cho Tour
 */
class TourSupplierController extends BaseController
{
    public $tourSupplier;
    public $supplier;
    public $tour;

    public function __construct()
    {
        $this->tourSupplier = new TourSupplierModel();
        $this->supplier = new SupplierModel();
        $this->tour = new TourModel();
    }

    /**
     * 1. Danh sách gán NCC cho tour
     */
    public function getTourSuppliers()
    {
        $data = $this->tourSupplier->getAll();
        return $this->render("tour_supplier.listTourSupplier", ['data' => $data]);
    }

    /**
     * 2. Form thêm gán nhà cung cấp
     */
    public function createTourSupplier()
    {
        $suppliers = $this->supplier->getListSuppliers();
        $tours = $this->tour->getListTours();

        return $this->render("tour_supplier.addTourSupplier", [
            'suppliers' => $suppliers,
            'tours' => $tours
        ]);
    }

    /**
     * 3. Xử lý thêm mới
     */
    public function postTourSupplier()
    {
        $tour_id = $_POST['tour_id'] ?? '';
        $supplier_id = $_POST['supplier_id'] ?? '';
        $role = $_POST['role'] ?? '';

        $error = [];

        if (empty($tour_id)) $error['tour_id'] = "Vui lòng chọn tour.";
        if (empty($supplier_id)) $error['supplier_id'] = "Vui lòng chọn nhà cung cấp.";
        if (empty($role)) $error['role'] = "Vai trò không được để trống.";

        if ($this->tourSupplier->existsAssignment($tour_id, $supplier_id)) {
            $error['exists'] = "Nhà cung cấp này đã được gán cho tour trước đó.";
        }

        if (!empty($error)) {
            redirect('errors', $error, 'add-tour-supplier');
            return;
        }

        $check = $this->tourSupplier->addTourSupplier($tour_id, $supplier_id, $role);

        if ($check) {
            redirect('success', "Gán nhà cung cấp thành công", 'list-tour-supplier');
        } else {
            redirect('errors', "Thêm thất bại, vui lòng thử lại", 'add-tour-supplier');
        }
    }

    /**
     * 4. Hiển thị form sửa
     */
    public function detailTourSupplier($id)
    {
        $detail = $this->tourSupplier->getById($id);
        if (!$detail) {
            redirect('errors', "Không tìm thấy dữ liệu.", 'list-tour-supplier');
            return;
        }
        return $this->render("tour_supplier.editTourSupplier", ['detail' => $detail]);
    }

    /**
     * 5. Xử lý cập nhật
     */
    public function editTourSupplier($id)
    {
        $role = $_POST['role'] ?? '';
        $error = [];

        if (empty($role)) {
            $error['role'] = "Vai trò không được để trống.";
        }

        $route = 'detail-tour-supplier/' . $id;

        if (!empty($error)) {
            redirect('errors', $error, $route);
            return;
        }

        $check = $this->tourSupplier->editTourSupplier($id, $role);

        if ($check) {
            redirect('success', "Cập nhật thành công", 'list-tour-supplier');
        } else {
            redirect('errors', "Cập nhật thất bại", $route);
        }
    }

    /**
     * 6. Xóa gán NCC
     */
    public function deleteTourSupplier($id)
    {
        $check = $this->tourSupplier->deleteTourSupplier($id);

        if ($check) {
            redirect('success', "Xóa thành công", 'list-tour-supplier');
        } else {
            redirect('errors', "Xóa thất bại", 'list-tour-supplier');
        }
    }
}
