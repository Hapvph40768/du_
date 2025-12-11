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

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $user = $_SESSION['user'];
        if ($user['role_id'] == 1) {
            header('Location: ' . BASE_URL . 'dashboard');
        } elseif ($user['role_id'] == 2) {
            header('Location: ' . BASE_URL . 'guide-dashboard');
        } elseif ($user['role_id'] == 3) {
             header('Location: ' . BASE_URL . 'client-dashboard');
        } else {
             header('Location: ' . BASE_URL . 'login');
        }
        exit;
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
                // Admin
                $this->render('layout.dashboard', ['user' => $user]);
            } elseif ($user->role_id == 2) {
                // Guide -> Render Guide Dashboard View
                $this->render('guide.dashboard', ['user' => $user]);
            } elseif ($user->role_id == 3) {
                // Customer
                $customerModel = new \App\Models\CustomerModel();
                $customer = $customerModel->getCustomerByUserId($user->id);

                if ($customer) {
                    header('Location: ' . BASE_URL);
                } else {
                    header('Location: ' . BASE_URL . 'profile-setup');
                    exit;
                }
            } else {
                header('Location: ' . BASE_URL);
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
            'password' => password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT),
            'role_id'  => 3 // mặc định role user thường
        ]);

        header('Location: ' . BASE_URL . 'login');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: ' . BASE_URL . 'login');
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $this->render('layout.dashboard', ['user' => $_SESSION['user']]);
    }

    public function guideDashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $guideModel = new \App\Models\GuidesModel();
        $guide = $guideModel->getGuideByUserId($_SESSION['user']['id']);

        $nextTour = null;
        if ($guide) {
             $tourGuideModel = new \App\Models\TourGuideModel();
             $nextTour = $tourGuideModel->getNextTour($guide->id);
        }

        $this->render('guide.dashboard', [
            'user' => $_SESSION['user'],
            'guide' => $guide,
            'nextTour' => $nextTour
        ]);
    }

    public function clientDashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 3) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $this->render('layout.client.ClientLayout', ['user' => $_SESSION['user']]);
    }
}