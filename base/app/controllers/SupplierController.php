<?php
namespace App\Controllers;

use App\Models\SupplierModel;

/**
 * Class SupplierController
 * Quản lý các chức năng liên quan đến Nhà cung cấp (Suppliers)
 */
class SupplierController extends BaseController
{
    protected $supplier;

    public function __construct()
    {
        $this->supplier = new SupplierModel();
    }

    // 1. Xem danh sách nhà cung cấp
    public function getSuppliers()
    {
        $suppliers = $this->supplier->getAll();
        $this->render("supplier.listSupplier", ['suppliers' => $suppliers]);
    }

    // 2. Hiển thị form thêm mới
    public function createSupplier()
    {
        $this->render("supplier.addSupplier");
    }

    // 3. Xử lý thêm mới
    public function postSupplier()
    {
        $error = [];

        $name    = $_POST['name'] ?? '';
        $type    = $_POST['type'] ?? '';
        $phone   = $_POST['phone'] ?? '';
        $email   = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';

        // Validate
        if (empty($name)) {
            $error['name'] = "Tên nhà cung cấp không được để trống.";
        }
        if (empty($type)) {
            $error['type'] = "Loại nhà cung cấp không được để trống.";
        }
        if (!empty($phone) && !is_numeric($phone)) {
            $error['phone'] = "Số điện thoại phải là định dạng số.";
        }
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Email không hợp lệ.";
        }

        if (!empty($error)) {
            redirect('errors', $error, 'add-supplier');
        } else {
            $check = $this->supplier->insert([
                'name'       => $name,
                'type'       => $type,
                'phone'      => $phone,
                'email'      => $email,
                'address'    => $address,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($check) {
                redirect('success', "Thêm nhà cung cấp thành công", 'list-supplier');
            } else {
                redirect('errors', "Thêm nhà cung cấp thất bại, vui lòng thử lại", 'add-supplier');
            }
        }
    }

    // 4. Hiển thị form chỉnh sửa
    public function detailSupplier($id)
    {
        $detail = $this->supplier->getById($id);
        return $this->render('supplier.editSupplier', ['detail' => $detail]);
    }

    // 5. Xử lý chỉnh sửa
    public function editSupplier($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $error = [];

            $name    = $_POST['name'] ?? '';
            $type    = $_POST['type'] ?? '';
            $phone   = $_POST['phone'] ?? '';
            $email   = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';

            if (empty($name)) {
                $error['name'] = "Tên nhà cung cấp không được để trống.";
            }
            if (empty($type)) {
                $error['type'] = "Loại nhà cung cấp không được để trống.";
            }
            if (!empty($phone) && !is_numeric($phone)) {
                $error['phone'] = "Số điện thoại phải là định dạng số.";
            }
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Email không hợp lệ.";
            }

            $route = 'detail-supplier/' . $id;

            if (!empty($error)) {
                redirect('errors', $error, $route);
            } else {
                $check = $this->supplier->update($id, [
                    'name'       => $name,
                    'type'       => $type,
                    'phone'      => $phone,
                    'email'      => $email,
                    'address'    => $address,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                if ($check) {
                    redirect('success', "Sửa nhà cung cấp thành công", 'list-supplier');
                } else {
                    redirect('errors', "Sửa thất bại, vui lòng thử lại", $route);
                }
            }
        } else {
            redirect('errors', "Yêu cầu không hợp lệ.", 'list-supplier');
        }
    }

    // 6. Xóa nhà cung cấp
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