<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\RolesModel;

class UserController extends BaseController
{
    public $user;
    public function __construct()
    {
        $this->user = new UserModel();
    }
    public function getUser()
    {
        $users = $this->user->getAll();
        $this->render('user.listUser', ['users' => $users]);
    }

    public function createUser()
    {
        $rolesModel = new RolesModel();
        $roles = $rolesModel->getAllRoles();
        $this->render('user.addUser', ['roles' => $roles]);
    }
    public function postUser()
    {
        $error = [];
        $role_id = trim($_POST['role_id']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $fullname = trim($_POST['fullname']);
        $phone = trim($_POST['phone']);
        $status = trim($_POST['status']);

        if (empty($role_id)) {
            $error['role_id'] = "chuc nang khong duoc de trong";
        }
        if (empty($username)) {
            $error['username'] = "ten dang nhap khong duoc de trong";
        } else {
            $checkUser = $this->user->findByUsername($username);
            if ($checkUser) {
                $error['username'] = "Tên đăng nhập đã tồn tại";
            }
        }
        if (empty($password)) {
            $error['password'] = "mat khau khong duoc de trong";
        }
        if (empty($fullname)) {
            $error['fullname'] = "ho ten  khong duoc de trong";
        }
        if (empty($phone)) {
            $error['phone'] = "sdt khong duoc de trong";
        }
        if (!isset($_POST['status']) || $_POST['status'] === "") {
            $error['status'] = "trang thai không được để trống";
        }
        if (count($error) >= 1) {
            redirect('error', $error, 'register');
        } else {
            $check = $this->user->addUser([
                'role_id' => $role_id,
                'username' => $username,
                'password' => $password,
                'fullname' => $fullname,
                'phone' => $phone,
                'status' => $status
            ]);
            if ($check) {
                redirect('success', 'Them thanh cong', 'list-user');
            }
        }
    }

    public function detailUser($id)
    {
        $detail = $this->user->getByID($id);
        $role = new RolesModel();
        $roles = $role->getAllRoles();
        return $this->render('user.editUser', ['detail' => $detail, 'roles' => $roles]);
    }
    public function editUser($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];
            if (empty($_POST['role_id'])) {
                $error['role_id'] = "chuc nang khong duoc de trong";
            }
            if (empty($_POST['username'])) {
                $error['username'] = "ten dang nhap khong duoc de trong";
            }
            if (empty($_POST['password'])) {
                $error['password'] = "mat khau khong duoc de trong";
            }
            if (empty($_POST['fullname'])) {
                $error['fullname'] = "ho ten  khong duoc de trong";
            }
            if (empty($_POST['phone'])) {
                $error['phone'] = "sdt khong duoc de trong";
            }
            if (empty($_POST['status'])) {
                $error['status'] = "trang thai khong duoc de trong";
            }
            $route = 'detail-user/' . $id;
            if (count($error) >= 1) {
                redirect('error', $error, $route);
            } else {
                $check = $this->user->updateUser(
                    $id,
                    [
                        'role_id' => $_POST['role_id'],
                        'username' => $_POST['username'],
                        'password' => $_POST['password'],
                        'fullname' => $_POST['fullname'],
                        'phone' => $_POST['phone'],
                        'status' => $_POST['status']
                    ]
                );
                if($check){
                    redirect('success', 'cap nhat thanh cong', 'list-user');
                }
            }
        }
    }
}