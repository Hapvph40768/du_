<?php
namespace App\Controllers;

use App\Models\GuidesModel;
use App\Models\UserModel;

class GuidesController extends BaseController
{
    protected $guide;

    public function __construct()
    {
        $this->guide = new GuidesModel();
    }

    // 1. Danh sách hướng dẫn viên
    public function listGuides()
    {
        $guides = $this->guide->getAllGuides();
        return $this->render("admin.guides.listGuides", ['guides' => $guides]);
    }

    // 2. Form thêm hướng dẫn viên
    public function createGuide()
    {
        $users = (new UserModel())->getAllUsers();
        return $this->render("admin.guides.addGuides", ['users' => $users]);
    }

    // 3. Xử lý thêm hướng dẫn viên
    public function postGuide()
    {
        $error = [];

        $fullname = $_POST['fullname'] ?? '';
        $phone    = $_POST['phone'] ?? '';
        $email    = $_POST['email'] ?? '';

        if (empty($fullname)) $error['fullname'] = "Tên không được bỏ trống";
        if (empty($phone))    $error['phone']    = "Số điện thoại không được bỏ trống";
        if (empty($email))    $error['email']    = "Email không được bỏ trống";

        if (!empty($error)) {
            redirect('error', $error, 'add-guide');
        }

        $check = $this->guide->addGuide([
            'user_id'          => $_POST['user_id'] ?? null,
            'fullname'         => $fullname,
            'phone'            => $phone,
            'email'            => $email,
            'gender'           => $_POST['gender'] ?? null,
            'languages'        => $_POST['languages'] ?? null,
            'experience_years' => $_POST['experience_years'] ?? 0,
            'experience'       => $_POST['experience'] ?? null,
            'certificate_url'  => $_POST['certificate_url'] ?? null,
            'avatar'           => $_POST['avatar'] ?? null,
            'status'           => $_POST['status'] ?? 'active',
            'created_at'       => date("Y-m-d H:i:s"),
            'updated_at'       => date("Y-m-d H:i:s")
        ]);

        $check
            ? redirect('success', "Thêm hướng dẫn viên thành công", 'list-guides')
            : redirect('error', "Thêm hướng dẫn viên thất bại", 'add-guide');
    }

    // 4. Chi tiết hướng dẫn viên để sửa
    public function detailGuide($id)
    {
        $detail = $this->guide->getGuideById($id);
        $users  = (new UserModel())->getAllUsers();

        return $this->render("admin.guides.editGuides", [
            'detail' => $detail,
            'users'  => $users
        ]);
    }

    // 5. Xử lý sửa hướng dẫn viên
    public function editGuide($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $error = [];

        $fullname = $_POST['fullname'] ?? '';
        $phone    = $_POST['phone'] ?? '';
        $email    = $_POST['email'] ?? '';

        if (empty($fullname)) $error['fullname'] = "Tên không được bỏ trống";
        if (empty($phone))    $error['phone']    = "Số điện thoại không được bỏ trống";
        if (empty($email))    $error['email']    = "Email không được bỏ trống";

        $route = 'detail-guide/' . $id;
        if (!empty($error)) {
            redirect('error', $error, $route);
        }

        $check = $this->guide->updateGuide($id, [
            'user_id'          => $_POST['user_id'] ?? null,
            'fullname'         => $fullname,
            'phone'            => $phone,
            'email'            => $email,
            'gender'           => $_POST['gender'] ?? null,
            'languages'        => $_POST['languages'] ?? null,
            'experience_years' => $_POST['experience_years'] ?? 0,
            'experience'       => $_POST['experience'] ?? null,
            'certificate_url'  => $_POST['certificate_url'] ?? null,
            'avatar'           => $_POST['avatar'] ?? null,
            'status'           => $_POST['status'] ?? 'active',
            'updated_at'       => date("Y-m-d H:i:s")
        ]);

        $check
            ? redirect('success', "Cập nhật hướng dẫn viên thành công", 'list-guides')
            : redirect('error', "Cập nhật hướng dẫn viên thất bại", $route);
    }

    // 6. Xóa hướng dẫn viên
    public function deleteGuide($id)
    {
        $check = $this->guide->deleteGuide($id);

        $check
            ? redirect('success', "Xóa hướng dẫn viên thành công", 'list-guides')
            : redirect('error', "Xóa hướng dẫn viên thất bại", 'list-guides');
    }
}