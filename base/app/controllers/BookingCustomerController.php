<?php
namespace App\Controllers;

use App\Models\BookingCustomerModel;
use App\Models\BookingModel;

class BookingCustomerController extends BaseController
{
    public $customerModel;

    public function __construct()
    {
        $this->customerModel = new BookingCustomerModel();
    }

    public function listCustomers()
    {
        $customers = $this->customerModel->getAllCustomers();
        return $this->render('bookingCustomer.list', ['customers' => $customers]);
    }

    public function createCustomer()
    {
        $booking = new BookingModel();
        $bookings = $booking->getAllBookings();

        return $this->render('bookingCustomer.add', ['bookings' => $bookings]);
    }

    public function postCustomer()
    {
        $error = [];

        if (empty($_POST['booking_id'])) {
            $error['booking_id'] = "booking_id không được để trống";
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

        // Nếu có lỗi → redirect
        if (!empty($error)) {
            redirect('error', $error, 'add-customer');
        }

        // Nếu không lỗi → thêm mới
        $check = $this->customerModel->addCustomer([
            'booking_id' => $_POST['booking_id'],
            'fullname' => $_POST['fullname'],
            'gender' => $_POST['gender'],
            'dob' => $_POST['dob'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', 'Thêm khách hàng thành công', 'list-customer');
        } else {
            redirect('error', 'Thêm thất bại', 'add-customer');
        }
    }

    public function detailCustomer($id)
    {
        $customer = $this->customerModel->getCustomerById($id);

        $booking = new BookingModel();
        $bookings = $booking->getAllBookings();

        return $this->render(
            'bookingCustomer.edit',
            [
                'customer' => $customer,
                'bookings' => $bookings
            ]
        );
    }

    public function updateCustomer($id)
    {
        if (!isset($_POST['btn-submit']))
            return;

        $error = [];

        if (empty($_POST['booking_id'])) {
            $error['booking_id'] = "booking_id không được để trống";
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
            'fullname' => $_POST['fullname'],
            'gender' => $_POST['gender'],
            'dob' => $_POST['dob'],
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', 'Cập nhật thành công', 'list-customer');
        } else {
            redirect('error', 'Cập nhật thất bại', $route);
        }
    }

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