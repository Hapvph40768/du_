<?php
namespace App\Controllers;

use App\Models\BookingCustomerModel;
use App\Models\BookingModel;
use App\Models\CustomerModel;

class BookingCustomerController extends BaseController
{
    protected $bookingCustomer;

    public function __construct()
    {
        $this->bookingCustomer = new BookingCustomerModel();
    }

    // 1. Danh sách khách trong booking
    public function listBookingCustomers()
    {
        $customers = $this->bookingCustomer->getAllBookingCustomers();
        return $this->render('admin.bookingCus.listBookCus', ['customers' => $customers]);
    }

    // 2. Form thêm khách
    public function createBookingCustomer()
    {
        $bookings  = (new BookingModel())->getAllBookings();
        $customers = (new CustomerModel())->getAllCustomers();

        return $this->render('admin.bookingCus.addBookCus', [
            'bookings'  => $bookings,
            'customers' => $customers
        ]);
    }

    // 3. Xử lý thêm khách
    public function postBookingCustomer()
    {
        $data = [
            'booking_id'  => $_POST['booking_id'] ?? '',
            'customer_id' => $_POST['customer_id'] ?? '',
            'fullname'    => $_POST['fullname'] ?? '',
            'gender'      => $_POST['gender'] ?? '',
            'dob'         => $_POST['dob'] ?? '',
            'note'        => $_POST['note'] ?? null,
        ];

        $error = $this->validate($data);

        if (!empty($error)) {
            redirect('error', $error, 'add-booking-customer');
        }

        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        $check = $this->bookingCustomer->addBookingCustomer($data);

        $check
            ? redirect('success', 'Thêm khách vào booking thành công', 'list-booking-customer')
            : redirect('error', 'Thêm thất bại', 'add-booking-customer');
    }

    // 4. Chi tiết khách để sửa
    public function detailBookingCustomer($id)
    {
        $detail    = $this->bookingCustomer->getBookingCustomerById($id);
        $bookings  = (new BookingModel())->getAllBookings();
        $customers = (new CustomerModel())->getAllCustomers();

        return $this->render('admin.bookingCus.editBookCus', [
            'detail'    => $detail,
            'bookings'  => $bookings,
            'customers' => $customers
        ]);
    }

    // 5. Xử lý sửa khách
    public function editBookingCustomer($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $data = [
            'booking_id'  => $_POST['booking_id'] ?? '',
            'customer_id' => $_POST['customer_id'] ?? '',
            'fullname'    => $_POST['fullname'] ?? '',
            'gender'      => $_POST['gender'] ?? '',
            'dob'         => $_POST['dob'] ?? '',
            'note'        => $_POST['note'] ?? null,
        ];

        $error = $this->validate($data);
        $route = 'detail-booking-customer/' . $id;

        if (!empty($error)) {
            redirect('error', $error, $route);
        }

        $data['updated_at'] = date("Y-m-d H:i:s");

        $check = $this->bookingCustomer->updateBookingCustomer($id, $data);

        $check
            ? redirect('success', 'Cập nhật khách thành công', 'list-booking-customer')
            : redirect('error', 'Cập nhật thất bại', $route);
    }

    // 6. Xóa khách
    public function deleteBookingCustomer($id)
    {
        $check = $this->bookingCustomer->deleteBookingCustomer($id);

        $check
            ? redirect('success', 'Xóa khách thành công', 'list-booking-customer')
            : redirect('error', 'Xóa thất bại', 'list-booking-customer');
    }

    // Hàm validate chung
    private function validate($data)
    {
        $error = [];

        if (empty($data['booking_id'])) {
            $error['booking_id'] = "Booking không được bỏ trống";
        }
        if (empty($data['customer_id'])) {
            $error['customer_id'] = "Customer không được bỏ trống";
        }
        if (empty($data['fullname'])) {
            $error['fullname'] = "Tên khách hàng không được bỏ trống";
        }
        if (empty($data['gender']) || !in_array($data['gender'], ['male','female','other'])) {
            $error['gender'] = "Giới tính không hợp lệ";
        }
        if (empty($data['dob'])) {
            $error['dob'] = "Ngày sinh không được bỏ trống";
        }

        return $error;
    }
}
?>