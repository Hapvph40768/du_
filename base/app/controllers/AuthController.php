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
    // Hiển thị form login
    public function login()
    {
        $errors = $_SESSION['error_login'] ?? [];
        unset($_SESSION['error_login']);
        $this->render("auth.login", ['errors' => $errors]);
    }

    // Xử lý POST login
    public function loginPost()
    {
        $errors = [];
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $user = $this->user->findByUsername($username);

        // VALIDATION
        if (empty($username)) {
            $errors['username'] = "Tên đăng nhập không được để trống";
        } elseif (!$user) {
            $errors['username'] = "Tên đăng nhập không tồn tại";
        }

        if (empty($password)) {
            $errors['password'] = "Mật khẩu không được để trống";
        } elseif ($user && !password_verify($password, $user->password)) {
            $errors['password'] = "Mật khẩu không đúng";
        }

        if (!empty($errors)) {
            $_SESSION['error_login'] = $errors;
            header("Location: " . BASE_URL . "login");
            exit;
        }

        // Lưu session
        if (password_verify($password, $user->password)) {
            $_SESSION['auth'] = [
                'id' => $user->id,
                'username' => $user->username,
                'role_id' => $user->role_id
            ];

            if ($user->role_id == 1) {
                header("Location: dashboard"); // admin
            } else {
                header("Location: home"); // user thường
            }
            exit;
        }
    }

    // ==========================
    // REGISTER
    // ==========================
    // Hiển thị form register
    public function register()
    {
        $errors = $_SESSION['error_register'] ?? [];
        unset($_SESSION['error_register']);
        $this->render("auth.register", ['errors' => $errors]);
    }

    // Xử lý POST register
    public function registerPost()
    {
        $errors = [];
        $fullname = trim($_POST['fullname'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // VALIDATION
        if (empty($fullname)) {
            $errors['fullname'] = "Họ tên không được để trống";
        }

        if (empty($phone)) {
            $errors['phone'] = "Số điện thoại không được để trống";
        } elseif (!preg_match('/^[0-9]{9,11}$/', $phone)) {
            $errors['phone'] = "Số điện thoại không hợp lệ";
        } elseif ($this->user->getPhone($phone)) {
            $errors['phone'] = "Số điện thoại đã được sử dụng";
        }

        if (empty($username)) {
            $errors['username'] = "Tên đăng nhập không được để trống";
        } elseif ($this->user->findByUsername($username)) {
            $errors['username'] = "Tên đăng nhập đã tồn tại";
        }

        if (empty($password)) {
            $errors['password'] = "Mật khẩu không được để trống";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Mật khẩu phải ≥ 6 ký tự";
        }

        if (!empty($errors)) {
            $_SESSION['error_register'] = $errors;
            header("Location: " . BASE_URL . "register");
            exit;
        }

        // Thêm user mới với mật khẩu hash
        $data = [
            'role_id' => 5, // user thường
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'fullname' => $fullname,
            'phone' => $phone,
            'status' => 4,
            'is_admin' => 0 // mặc định user thường
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
    public function dashboard() {
    // Chỉ cho admin
    if(!isset($_SESSION['auth'])) {
        header("Location: login");
        exit;
    }

    if($_SESSION['auth']['role_id'] != 4){ // role_id 1 = admin
        echo "Bạn không có quyền truy cập dashboard!";
        exit;
    }

    // Hiển thị view dashboard
    $this->render('auth.dashboard');
}

}
