<?php
namespace App\Controllers;
use App\Models\UserModel;

class LoginController extends BaseController
{
    protected $user;
    public function __construct()
    {
        $this->user = new UserModel();
    }
    public function loginFrom()
    {
        $this->render('auth.login');
    }
    public function loginPost()
    {
        $username = trim($_POST['username']) ?? '';
        $password = trim($_POST['password']) ?? '';
        $error = [];

        if (empty($username)) {
            $error['username'] = "Ten dang nhap khong duoc bo trong";
        }
        if (empty($password)) {
            $error['password'] = "mat khau dang nhap khong duoc bo trong";
        }
        if (!empty($error)) {
            $_SESSION['error'] = $error;
            redirect('login');
        }
        $users = $this->user->getAll();
        $users = array_filter($users, fn($u) => $u->username === $username);
        $users = array_shift($users);

        if (!$users || !password_verify($password, $users->password)) {
            $_SESSION['error'] = ['login' => 'username hoac pass khong dung'];
            redirect('login');
        }
        //luu thong tin user vao session

        $_SESSION['auth'] = [
            'id' => $users->id,
            'username' => $users->username,
            'fullname' => $users->fullname
        ];
        //role admin

        if ($users->username === 'admin') {
            $_SESSION['auth']['role'] = 'admin';
            redirect('admin-dashboard');
        } elseif ($users->username === 'guide') {
            $_SESSION['auth']['role'] = 'guide';
            redirect('guide-dashboard'); // trang hướng dẫn viên
        } else {
            $_SESSION['auth']['role'] = 'customer';
            redirect('customer-dashboard'); // trang khách hàng
        }
    }
    public function logout()
    {
        unset($_SESSION['auth']);
        redirect('login');
    }
}