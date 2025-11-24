<?php
namespace App\Controllers;
use App\Models\BookingCustomerModel;
use App\Models\BookingModel;

class BookingCustomerController extends BaseController
{
    protected $customer;
    protected $booking;

    public function __construct(){
        $this->customer = new BookingCustomerModel();
        $this->booking  = new BookingModel();
    }

    // Danh sách khách theo booking
    public function getBookId($booking_id){
        $customers = $this->customer->getByBookingId($booking_id);
        $this->render('bookingCus.listBookCus', [
            'customers' => $customers,
            'booking_id'=> $booking_id
        ]);
    }

    // Form thêm khách
    public function createBookCus($booking_id){
        $this->render('bookingCus.addBookCus', ['booking_id' => $booking_id]);
    }

    // Xử lý thêm khách với validate
    public function postBookCus(){
        $booking_id = $_POST['booking_id'] ?? null;
        $fullname   = trim($_POST['fullname'] ?? '');
        $gender     = $_POST['gender'] ?? '';
        $dob        = $_POST['dob'] ?? '';

        $errors = [];

        if(empty($booking_id)){
            $errors['booking_id'] = "Booking không được bỏ trống";
        }
        if(empty($fullname)){
            $errors['fullname'] = "Tên khách không được bỏ trống";
        }
        if(!in_array($gender, ['Nam','Nữ'])){
            $errors['gender'] = "Giới tính không hợp lệ";
        }
        if(empty($dob)){
            $errors['dob'] = "Ngày sinh không được bỏ trống";
        }

        if(!empty($errors)){
            // redirect về form thêm với booking_id
            redirect('error', $errors, "add-bookingCus");
            return;
        }

        // Thêm khách
        $check = $this->customer->addBooking($booking_id, $fullname, $gender, $dob);

        if($check){
            redirect('success', 'Thêm khách thành công', "list-bookingCus");
        } else {
            redirect('error', 'Thêm khách thất bại', "add-bookingCus");
        }
    }

    // Chi tiết khách
    public function detailBookCus($id){
        $detail = $this->customer->getById($id);
        $booking = $this->booking->getAllBooking();

        $this->render('bookingCus.detailBookCus', [
            'detail'   => $detail,
            'bookings' => $booking
        ]);
    }
    
}
