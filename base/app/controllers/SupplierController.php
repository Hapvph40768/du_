<?php
namespace App\Controllers;

use App\Models\SupplierModel;

/**
 * Class SupplierController
 * Quản lý các chức năng liên quan đến Nhà cung cấp (Suppliers)
 */
class SupplierController extends BaseController
{
    public $supplier;

    public function __construct()
    {
        // Khởi tạo SupplierModel
        $this->supplier = new SupplierModel();
    }

    // 1. Xem Danh sách Nhà cung cấp
    public function getSuppliers()
    {
        $suppliers = $this->supplier->getAll();
        // Giả định view là 'supplier.listSupplier'
        $this->render("supplier.listSupplier", ['suppliers' => $suppliers]);
    }

    // 2. Hiển thị Form Thêm mới Nhà cung cấp
    public function createSupplier()
    {
        // Giả định view là 'supplier.addSupplier'
        $this->render("supplier.addSupplier");
    }

    // 3. Xử lý logic Thêm mới Nhà cung cấp
    public function postSupplier()
    {
        $error = [];

        // Lấy dữ liệu từ POST
        $name = $_POST['name'] ?? '';
        $type = $_POST['type'] ?? '';
        $phone = $_POST['phone'] ?? '';

        // Validate
        if (empty($name)) {
            $error['name'] = "Tên nhà cung cấp không được để trống.";
        }
        if (empty($type)) {
            $error['type'] = "Tên người liên hệ không được để trống.";
        }
        if (empty($phone)) {
            $error['phone'] = "Số điện thoại không được để trống.";
        } elseif (!is_numeric($phone)) {
            $error['phone'] = "Số điện thoại phải là định dạng số.";
        }

        if (count($error) >= 1) {
            // Quay lại trang thêm mới kèm thông báo lỗi
            redirect('errors', $error, 'add-supplier');
        } else {
            // Thực hiện thêm vào CSDL
            $check = $this->supplier->insert(
                [
                    'name' => $name,
                    'type' => $type,
                    'phone' => $phone,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );

            if ($check) {
                redirect('success', "Thêm nhà cung cấp thành công", 'list-supplier');
            } else {
                redirect('errors', "Thêm nhà cung cấp thất bại, vui lòng thử lại", 'add-supplier');
            }
        }
    }

    // 4. Hiển thị Form Chỉnh sửa Nhà cung cấp (chi tiết)
    public function detailSupplier($id)
    {
        $detail = $this->supplier->getById($id);
        return $this->render('supplier.editSpupplier', ['detail' => $detail]);
    }

    // 5. Xử lý logic Chỉnh sửa Nhà cung cấp
    public function editSupplier($id)
    {
        // Kiểm tra xem form đã được submit chưa (Giả định sử dụng POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $error = [];

            // Lấy dữ liệu từ POST
            $name = $_POST['name'] ?? '';
            $type = $_POST['type'] ?? '';
            $phone = $_POST['phone'] ?? '';

            // Validate (tương tự như postSupplier)
            if (empty($name)) {
                $error['name'] = "Tên nhà cung cấp không được để trống.";
            }
            if (empty($type)) {
                $error['type'] = "Tên người liên hệ không được để trống.";
            }
            if (empty($phone)) {
                $error['phone'] = "Số điện thoại không được để trống.";
            } elseif (!is_numeric($phone)) {
                $error['phone'] = "Số điện thoại phải là định dạng số.";
            }

            // Route quay lại trang chi tiết nếu có lỗi
            $route = 'detail-supplier/' . $id;

            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            } else {
                // Thực hiện cập nhật vào CSDL
                $check = $this->supplier->update(
                    $id,
                    [
                        'name' => $name,
                        'type' => $type,
                        'phone' => $phone,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );

                if ($check) {
                    redirect('success', "Sửa nhà cung cấp thành công", 'list-supplier');
                } else {
                    redirect('errors', "Sửa thất bại, vui lòng thử lại", $route);
                }
            }
        } else {
            // Nếu không phải phương thức POST, chuyển hướng về trang chi tiết để hiển thị form
            redirect('errors', "Yêu cầu không hợp lệ.", 'list-supplier');
        }
    }

    // 6. Xử lý logic Xóa Nhà cung cấp
    public function deleteSupplier($id)
    {
        $check = $this->supplier->delete($id); 

        if ($check) {
            redirect('success', "Xóa nhà cung cấp thành công", 'list-supplier');
        } else {
            redirect('errors', "Xóa thất bại, có thể nhà cung cấp này đang liên kết với tour.", 'list-supplier');
        }
    }
}