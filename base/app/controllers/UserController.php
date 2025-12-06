<?php
namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
    private $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }
  public function index()
{
    $users = $this->user->getAll();
    $this->render('user.listUser', compact('users')); // phải là 'users'
}
    public function create()
    {
        $this->render('user.addUser');
    }
    public function postUser()
    {
        $error = [];

        if (empty($_POST['username'])) {
            $error['username'] = "Username không được để trống";
        }
        if (empty($_POST['password'])) {
            $error['password'] = "Password không được để trống";
        }
        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Họ tên không được để trống";
        }
        if (!empty($_POST['phone']) && !preg_match('/^[0-9]{9,11}$/', $_POST['phone'])) {
            $error['phone'] = "Số điện thoại không hợp lệ";
        }
        $roleFixed = in_array($_POST['username'], ['admin', 'guide']) ? $_POST['username'] : 'customer';
        if (count($error) >= 1) {
            redirect('error', $error, 'add-user');
        } else {
            $check = $this->user->insert([
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'fullname' => $_POST['fullname'],
                'phone' => $_POST['phone'] ?? null,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'role_fixed' => $roleFixed,
            ]);

            if ($check) {
                redirect('success', 'Thêm user thành công', 'list-users');
            } else {
                redirect('error', 'Thêm user thất bại', 'add-user');
            }
        }
    }

    public function updateUser($id)
    {
        if (!isset($_POST['btn-submit'])) {
            $error = [];

            if (empty($_POST['username'])) {
                $error['username'] = "Username không được để trống";
            }
            if (!empty($_POST['password']) && strlen($_POST['password']) < 6) {
                $error['password'] = "Password phải ít nhất 6 ký tự";
            }
            if (empty($_POST['fullname'])) {
                $error['fullname'] = "Họ tên không được để trống";
            }
            if (!empty($_POST['phone']) && !preg_match('/^[0-9]{9,11}$/', $_POST['phone'])) {
                $error['phone'] = "Số điện thoại không hợp lệ";
            }

            $route = 'edit-user/' . $id;

            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            }
            $updateData = [
                'username' => $_POST['username'],
                'fullname' => $_POST['fullname'],
                'phone' => $_POST['phone'] ?? null,
                'status' => 1,
                'updated_at' => date("Y-m-d H:i:s"),
            ];

            if (!empty($_POST['password'])) {
                $updateData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            $check = $this->user->update($id, $updateData);

            if ($check) {
                redirect('success', 'Cập nhật user thành công', 'list-user');
            } else {
                redirect('error', 'Cập nhật user thất bại', $route);
            }
        }

    }

}