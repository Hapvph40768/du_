<?php
namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    // ==========================
    // LOGIN
    // ==========================
    public function login()
    {
        $this->render("auth.login");
    }

    public function loginPost()
{
    $error = [];
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $user = $this->user->findByUsername($username);

    // VALIDATION
    if (empty($username)) {
        $error['username'] = "Tên đăng nhập không được để trống";
    } elseif (!$user) {
        $error['username'] = "Tên đăng nhập không tồn tại";
    }

    if (empty($password)) {
        $error['password'] = "Mật khẩu không được để trống";
    } elseif ($user && $password !== $user->password) { 
        $error['password'] = "Mật khẩu không đúng";
    }

    // Nếu có lỗi, redirect về login với thông báo
    if (!empty($error)) {
        redirect('error', $error, 'login');
        return;
    }

    // Lưu session
    $_SESSION['auth'] = [
        'id' => $user->id,
        'username' => $user->username,
        'role_id' => $user->role_id
    ];

    header("Location: " . BASE_URL . "dashboard");
    exit;
}

    // ==========================
    // REGISTER
    // ==========================
    public function register()
    {
        $this->render("auth.register");
    }

    public function registerPost()
    {
        $error = [];

        $fullname = trim($_POST['fullname'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // VALIDATION
        if (empty($fullname)) {
            $error['fullname'] = "Họ tên không được để trống";
        }

        if (empty($phone)) {
            $error['phone'] = "Số điện thoại không được để trống";
        } elseif (!preg_match('/^[0-9]{9,11}$/', $phone)) {
            $error['phone'] = "Số điện thoại không hợp lệ";
        } elseif ($this->user->getPhone($phone)) {
            $error['phone'] = "Số điện thoại đã được sử dụng";
        }

        if (empty($username)) {
            $error['username'] = "Tên đăng nhập không được để trống";
        } elseif ($this->user->findByUsername($username)) {
            $error['username'] = "Tên đăng nhập đã tồn tại";
        }

        if (empty($password)) {
            $error['password'] = "Mật khẩu không được để trống";
        } elseif (strlen($password) < 6) {
            $error['password'] = "Mật khẩu phải ≥ 6 ký tự";
        }

        if (!empty($error)) {
            $_SESSION['error_register'] = $error;
            header("Location: " . BASE_URL . "register");
            exit;
        }

        // THÊM USER
        $data = [
            'role_id' => 2, // user thường
            'username' => $username,
            'password' => $password,
            'fullname' => $fullname,
            'phone' => $phone,
            'status' => 1
        ];

        $this->user->addUser($data);

        $_SESSION['success'] = "Đăng ký thành công!";
        header("Location: " . BASE_URL . "login");
        exit;
    }

    // ==========================
    // LOGOUT
    // ==========================
    public function logout()
    {
        unset($_SESSION['auth']);
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }
}
