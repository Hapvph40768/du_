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
        $users = $this->user->getCustomersOnly();
        return $this->render("admin.user.listUser", ['users' => $users]);
    }

    // Form thêm
    public function createUser()
    {
        $roles = $this->user->getAllRoles();
        return $this->render("admin.user.addUser", ['roles' => $roles]);
    }

    // Xử lý thêm
    public function postUser()
    {
        $error = [];
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $fullname = $_POST['fullname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $role_id = $_POST['role_id'] ?? 2; // Default to customer (assumed ID 2) if not set
        $is_active = $_POST['status'] ?? 1;

        if (empty($username)) $error['username'] = "Tên đăng nhập không được để trống.";
        if (empty($password)) $error['password'] = "Mật khẩu không được để trống.";
        if ($this->user->getUserByUsername($username)) $error['username'] = "Tên đăng nhập đã tồn tại.";

        if (!empty($error)) {
            redirect('errors', $error, 'add-user');
        }

        $check = $this->user->createUser([
            'username' => $username,
            'email' => $email,
            'fullname' => $fullname,
            'phone' => $phone,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role_id' => $role_id,
            'is_active' => $is_active,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Thêm người dùng thành công", 'list-user');
        } else {
            redirect('errors', "Thêm thất bại", 'add-user');
        }
    }

    // Chi tiết để sửa
    public function detailUser($id)
    {
        $detail = $this->user->getUserById($id);
        $roles = $this->user->getAllRoles();
        return $this->render("admin.user.editUser", ['detail' => $detail, 'roles' => $roles]);
    }

    // Xử lý sửa
    public function editUser($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $fullname = $_POST['fullname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $role_id = $_POST['role_id'] ?? 2;
        $is_active = $_POST['status'] ?? 1;

        $data = [
            'username' => $username,
            'email' => $email,
            'fullname' => $fullname,
            'phone' => $phone,
            'role_id' => $role_id,
            'is_active' => $is_active,
            'updated_at' => date("Y-m-d H:i:s")
        ];

        // Only update password if provided
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT); 
        } else {
             // Retrieve existing password if not changing
             $currentUser = $this->user->getUserById($id);
             $data['password'] = $currentUser->password; 
        }
        
        $check = $this->user->updateUser($id, $data);

        if ($check) {
            redirect('success', "Cập nhật thành công", 'list-user');
        } else {
            redirect('error', "Cập nhật thất bại", 'detail-user/' . $id);
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