<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function showLogin()
    {
        $this->render('admin.auth.login');
    }

    public function showRegister()
    {
        $this->render('admin.auth.register');
    }

    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            // Lưu session gọn gàng
            $_SESSION['user'] = [
                'id'       => $user->id,
                'username' => $user->username,
                'role_id'  => $user->role_id
            ];

            // Nếu role_id = 1 (admin) thì vào dashboard
            if ($user->role_id == 1) {
                $this->render('layout.dashboard', ['user' => $user]);
            } else {
                header('Location: /'); // hoặc /user/home
            }
            exit;

        } else {
            $this->render('admin.auth.login', ['error' => 'Sai tài khoản hoặc mật khẩu']);
        }
    }

    public function register()
    {
        $userModel = new UserModel();
        $userModel->createUser([
            'username' => $_POST['username'] ?? '',
            'email'    => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'role_id'  => 2 // mặc định role user thường
        ]);

        header('Location: login');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: login');
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
            header('Location: /login');
            exit;
        }

        $this->render('layout.dashboard', ['user' => $_SESSION['user']]);
    }
}