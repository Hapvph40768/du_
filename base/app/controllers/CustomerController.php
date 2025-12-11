<?php
namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    protected $customer;

    public function __construct()
    {
        $this->customer = new CustomerModel();
    }

    // Hiển thị danh sách khách hàng
    public function getCustomers()
    {
        $customers = $this->customer->getAllCustomers();
        $this->render("admin.customer.listCustomer", ['customers' => $customers]);
    }

    // Hiển thị form thêm khách hàng
    public function createCustomer()
    {
        $this->render("admin.customer.addCustomer");
    }

    // Xử lý thêm khách hàng
    public function postCustomer()
    {
        $error = [];

        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Tên không được bỏ trống";
        }
        if (empty($_POST['phone'])) {
            $error['phone'] = "Số điện thoại không được bỏ trống";
        }

        if (!empty($error)) {
            redirect('error', $error, "add-customer");
        } else {
            $check = $this->customer->addCustomer([
                'user_id'     => $_POST['user_id'] ?? null,
                'fullname'    => $_POST['fullname'],
                'phone'       => $_POST['phone'] ?? null,
                'email'       => $_POST['email'] ?? null,
                'nationality' => $_POST['nationality'] ?? null,
                'dob'         => $_POST['dob'] ?? null,
                'gender'      => $_POST['gender'] ?? null,
                'address'     => $_POST['address'] ?? null,
                'note'        => $_POST['note'] ?? null,
            ]);

            if ($check) {
                redirect('success', "Thêm khách hàng thành công", 'list-customer');
            } else {
                redirect('error', "Thêm khách hàng thất bại", 'add-customer');
            }
        }
    }

    // Hiển thị chi tiết khách hàng để sửa
    public function detailCustomer($id)
    {
        $detail = $this->customer->getCustomerById($id);
        return $this->render('admin.customer.editCustomer', ['detail' => $detail]);
    }

    // Xử lý sửa khách hàng
    public function editCustomer($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            if (empty($_POST['fullname'])) {
                $error['fullname'] = "Tên không được bỏ trống";
            }
            if (empty($_POST['phone'])) {
                $error['phone'] = "Số điện thoại không được bỏ trống";
            }

            $route = 'detail-customer/' . $id;
            if (!empty($error)) {
                redirect('error', $error, $route);
            } else {
                $check = $this->customer->updateCustomer($id, [
                    'user_id'     => $_POST['user_id'] ?? null,
                    'fullname'    => $_POST['fullname'],
                    'phone'       => $_POST['phone'] ?? null,
                    'email'       => $_POST['email'] ?? null,
                    'nationality' => $_POST['nationality'] ?? null,
                    'dob'         => $_POST['dob'] ?? null,
                    'gender'      => $_POST['gender'] ?? null,
                    'address'     => $_POST['address'] ?? null,
                    'note'        => $_POST['note'] ?? null,
                ]);

                if ($check) {
                    redirect('success', 'Sửa khách hàng thành công', 'list-customer');
                } else {
                    redirect('error', 'Sửa khách hàng thất bại', $route);
                }
            }
        }
    }

    // Xóa khách hàng
    public function deleteCustomer($id)
    {
        $check = $this->customer->deleteCustomer($id);
        if ($check) {
            redirect('success', 'Xóa khách hàng thành công', 'list-customer');
        } else {
            redirect('error', 'Xóa khách hàng thất bại', 'list-customer');
        }
    }


    // ======================================
    // CLIENT SIDE: PROFILE SETUP
    // ======================================
    public function profileSetup()
    {
        // Must be logged in
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        $this->render('client.auth.profile_setup');
    }

    public function postProfileSetup()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $user_id = $_SESSION['user']['id'];
        
        $fullname = $_POST['fullname'] ?? '';
        $phone    = $_POST['phone'] ?? '';
        $address  = $_POST['address'] ?? '';
        $gender   = $_POST['gender'] ?? '';
        $dob      = $_POST['dob'] ?? null;
        $nationality = $_POST['nationality'] ?? 'Việt Nam';

        $error = [];
        if (empty($fullname)) $error[] = "Vui lòng nhập họ tên.";
        if (empty($phone)) $error[] = "Vui lòng nhập số điện thoại.";

        if (!empty($error)) {
            $this->render('client.auth.profile_setup', ['errors' => $error]);
            return;
        }

        // Create customer record
        $this->customer->addCustomer([
            'user_id' => $user_id,
            'fullname' => $fullname,
            'phone' => $phone,
            'address' => $address,
            'gender' => $gender,
            'dob' => $dob,
            'nationality' => $nationality,
            'email' => '', // Optional or fetch from users table if needed
            'note' => 'Self-registered'
        ]);

        // Redirect home
        header('Location: ' . BASE_URL);
        exit;
    }
}