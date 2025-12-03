<?php
namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Hiển thị form đăng ký
    public function showRegister()
    {
        $this->render("auth.register");
    }

    // Xử lý đăng ký
    public function register()
    {
        $username = $_POST["username"];
        $email    = $_POST["email"];
        $password = $_POST["password"];

        // Kiểm tra trùng username
        if ($this->userModel->getUserByUsername($username)) {
            echo "Username đã tồn tại!";
            return;
        }

        $this->userModel->register($username, $email, $password);
        echo "Đăng ký thành công!";
    }

    // Hiển thị form đăng nhập
    public function showLogin()
    {
        $this->render("auth.login");
    }

    // Xử lý đăng nhập
    public function login()
    {
        session_start();
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION["user_id"] = $user->id;
            $_SESSION["username"] = $user->username;
            $_SESSION["role"] = $user->role;

            $this->userModel->updateLastLogin($user->id);

            echo "Đăng nhập thành công!";
            // Ví dụ: chuyển hướng dashboard
            header("Location: index.php?controller=dashboard");
            exit;
        } else {
            echo "Sai username hoặc password!";
        }
    }
}