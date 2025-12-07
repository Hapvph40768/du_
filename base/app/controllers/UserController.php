<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    // Danh sách user
    public function listUsers()
    {
        $users = $this->user->getAllUsers();
        return $this->render("user.listUser", ['users' => $users]);
    }

    // Form thêm
    public function createUser()
    {
        return $this->render("user.addUser");
    }

    // Xử lý thêm
    public function postUser()
    {
        $error = [];
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'customer';

        if (empty($username)) $error['username'] = "Username không được để trống.";
        if (empty($password)) $error['password'] = "Password không được để trống.";

        if (!empty($error)) {
            redirect('errors', $error, 'add-user');
        }

        $check = $this->user->createUser([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => $role,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Thêm user thành công", 'list-user');
        } else {
            redirect('errors', "Thêm thất bại", 'add-user');
        }
    }

    // Chi tiết để sửa
    public function detailUser($id)
    {
        $detail = $this->user->getUserById($id);
        return $this->render("user.editUser", ['detail' => $detail]);
    }

    // Xử lý sửa
    public function editUser($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'customer';
        $is_active = $_POST['is_active'] ?? 1;

        $check = $this->user->updateUser($id, [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => $role,
            'is_active' => $is_active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Cập nhật thành công", 'list-user');
        } else {
            redirect('errors', "Cập nhật thất bại", 'detail-user/' . $id);
        }
    }

    // Xóa
    public function deleteUser($id)
    {
        $check = $this->user->deleteUser($id);
        if ($check) {
            redirect('success', "Xóa thành công", 'list-user');
        } else {
            redirect('errors', "Xóa thất bại", 'list-user');
        }
    }
}
?>