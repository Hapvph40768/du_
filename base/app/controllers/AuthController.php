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
            $_SESSION['user'] = $user;
            if ($user->role === 'admin') {
                $this->render('admin.dashboard');
            } else {
                header('Location: /'); // hoặc /user/home nếu bạn có route riêng cho user
            }
            exit;

        } else {
            $this->render('admin.auth.login', ['error' => 'Sai tài khoản hoặc mật khẩu']);
        }
    }

    public function register()
    {
        $data = [
            $_POST['username'] ?? '',
            $_POST['email'] ?? '',
            password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT)
        ];

        $userModel = new UserModel();
        $userModel->createUser($data);

        header('Location: login');
    }

    public function logout()
    {
        session_destroy();
        header('Location: login');
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']->role !== 'admin') {
            header('Location: /login');
            exit;
        }

        $this->render('admin.dashboard', ['user' => $_SESSION['user']]);
    }
}