<?php
namespace App\Controllers;

use App\Models\BookingCustomerModel;
use App\Models\BookingModel;
use App\Models\CustomerModel;

class BookingCustomerController extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new BookingCustomerModel();
    }

    // Danh sách khách trong booking
    public function listCustomers()
    {
        $customers = $this->customerModel->getAllCustomers();
        return $this->render('bookingCustomer.list', ['customers' => $customers]);
    }

    // Form thêm khách
    public function createCustomer()
    {
        $bookingModel = new BookingModel();
        $bookings = $bookingModel->getAllBookings();

        $customerModel = new CustomerModel();
        $customers = $customerModel->getAllCustomers();

        return $this->render('bookingCustomer.add', [
            'bookings'  => $bookings,
            'customers' => $customers
        ]);
    }

    // Xử lý thêm khách
    public function postCustomer()
    {
        $error = [];

        if (empty($_POST['booking_id'])) {
            $error['booking_id'] = "Booking không được để trống";
        }
        if (empty($_POST['customer_id'])) {
            $error['customer_id'] = "Customer không được để trống";
        }
        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Tên khách hàng không được để trống";
        }
        if (empty($_POST['gender']) || !in_array($_POST['gender'], ['male', 'female', 'other'])) {
            $error['gender'] = "Giới tính không hợp lệ";
        }
        if (empty($_POST['dob'])) {
            $error['dob'] = "Ngày sinh không được để trống";
        }

        if (!empty($error)) {
            redirect('error', $error, 'add-customer');
        }

        $check = $this->customerModel->addCustomer([
            'booking_id' => $_POST['booking_id'],
            'customer_id'=> $_POST['customer_id'],
            'fullname'   => $_POST['fullname'],
            'gender'     => $_POST['gender'],
            'dob'        => $_POST['dob'],
            'note'       => $_POST['note'] ?? null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', 'Thêm khách hàng thành công', 'list-customer');
        } else {
            redirect('error', 'Thêm thất bại', 'add-customer');
        }
    }

    // Chi tiết khách để sửa
    public function detailCustomer($id)
    {
        $customer = $this->customerModel->getCustomerById($id);

        $bookingModel = new BookingModel();
        $bookings = $bookingModel->getAllBookings();

        $customerModel = new CustomerModel();
        $customers = $customerModel->getAllCustomers();

        return $this->render('bookingCustomer.edit', [
            'customer'  => $customer,
            'bookings'  => $bookings,
            'customers' => $customers
        ]);
    }

    // Xử lý sửa khách
    public function updateCustomer($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $error = [];

        if (empty($_POST['booking_id'])) {
            $error['booking_id'] = "Booking không được để trống";
        }
        if (empty($_POST['customer_id'])) {
            $error['customer_id'] = "Customer không được để trống";
        }
        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Tên khách hàng không được để trống";
        }
        if (empty($_POST['gender']) || !in_array($_POST['gender'], ['male', 'female', 'other'])) {
            $error['gender'] = "Giới tính không hợp lệ";
        }
        if (empty($_POST['dob'])) {
            $error['dob'] = "Ngày sinh không được để trống";
        }

        $route = 'detail-customer/' . $id;
        if (!empty($error)) {
            redirect('error', $error, $route);
        }

        $check = $this->customerModel->updateCustomer($id, [
            'booking_id' => $_POST['booking_id'],
            'customer_id'=> $_POST['customer_id'],
            'fullname'   => $_POST['fullname'],
            'gender'     => $_POST['gender'],
            'dob'        => $_POST['dob'],
            'note'       => $_POST['note'] ?? null,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', 'Cập nhật thành công', 'list-customer');
        } else {
            redirect('error', 'Cập nhật thất bại', $route);
        }
    }

    // Xóa khách
    public function deleteCustomer($id)
    {
        $check = $this->customerModel->deleteCustomer($id);

        if ($check) {
            redirect('success', 'Xóa thành công', 'list-customer');
        } else {
            redirect('error', 'Xóa thất bại', 'list-customer');
        }
    }
}
?>