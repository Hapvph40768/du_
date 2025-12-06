<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\DepartureModel;
use App\Models\CustomerModel;

class BookingController extends BaseController
{
    protected $booking;

    public function __construct()
    {
        $this->booking = new BookingModel();
    }

    /**
     * Danh sách bookings
     */
    public function getBookings()
    {
        $bookings = $this->booking->getAllBookings();
        $this->render("admin.booking.listBooking", ['bookings' => $bookings]);
    }

    /**
     * Form thêm booking
     */
    public function createBooking()
    {
        $departures = (new DepartureModel())->getAllDepartures();
        $customers  = (new CustomerModel())->getAllCustomers();

        $this->render("admin.booking.addBooking", [
            'departures' => $departures,
            'customers'  => $customers
        ]);
    }

    /**
     * Xử lý thêm booking
     */
    public function postBooking()
    {
        $error = [];

        $departure_id   = $_POST['departure_id'] ?? '';
        $customer_id    = $_POST['customer_id'] ?? null;
        $num_people     = (int)($_POST['num_people'] ?? 0);
        $payment_status = $_POST['payment_status'] ?? 'unpaid';
        $status         = $_POST['status'] ?? 'pending';
        $note           = $_POST['note'] ?? null;

        if (!$departure_id) $error['departure_id'] = "Vui lòng chọn lịch khởi hành";
        if (!$customer_id) $error['customer_id'] = "Vui lòng chọn khách hàng";
        if ($num_people <= 0) $error['num_people'] = "Số lượng người không hợp lệ";

        $departure = (new DepartureModel())->getDepartureById($departure_id);
        if (!$departure) {
            $error['departure_id'] = "Lịch khởi hành không tồn tại";
        } elseif ($num_people > $departure->remaining_seats) {
            $error['num_people'] = "Chỉ còn {$departure->remaining_seats} ghế trống";
        }

        if (!empty($error)) {
            redirect('error', $error, 'add-booking');
            return;
        }

        // Lưu booking
        $check = $this->booking->addBooking([
            'customer_id'    => $customer_id,
            'departure_id'   => $departure_id,
            'num_people'     => $num_people,
            'payment_status' => $payment_status,
            'status'         => $status,
            'note'           => $note,
            'created_by'     => $_SESSION['user_id'] ?? null
        ]);

        if ($check) {
            // Cập nhật seats_booked & remaining_seats
            $dep = new DepartureModel();
            $newSeatsBooked = $departure->seats_booked + $num_people;

            redirect('success', "Thêm booking thành công", 'list-booking');
        } else {
            redirect('error', "Thêm thất bại", 'add-booking');
        }
    }

    /**
     * Form sửa booking
     */
    public function detailBooking($id)
    {
        $detail     = $this->booking->getBookingById($id);
        $departures = (new DepartureModel())->getAllDepartures();
        $customers  = (new CustomerModel())->getAllCustomers();

        $this->render("admin.booking.editBooking", [
            'detail'     => $detail,
            'departures' => $departures,
            'customers'  => $customers
        ]);
    }

    /**
     * Xử lý sửa booking
     */
    public function editBooking($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $error = [];

        $departure_id   = $_POST['departure_id'] ?? '';
        $customer_id    = $_POST['customer_id'] ?? '';
        $num_people     = (int)($_POST['num_people'] ?? 0);
        $payment_status = $_POST['payment_status'] ?? 'unpaid';
        $status         = $_POST['status'] ?? 'pending';
        $note           = $_POST['note'] ?? null;

        $route = 'detail-booking/' . $id;

        if (!$departure_id || !$customer_id) {
            $error['departure_id'] = "Thiếu thông tin bắt buộc";
        }
        if ($num_people <= 0) {
            $error['num_people'] = "Số lượng người không hợp lệ";
        }

        $departure  = (new DepartureModel())->getDepartureById($departure_id);
        $oldBooking = $this->booking->getBookingById($id);

        if (!$departure) {
            $error['departure_id'] = "Lịch khởi hành không tồn tại";
        } else {
            // Chỉ tính ghế tăng thêm
            $diff = $num_people - $oldBooking->num_people;

            if ($diff > 0 && $diff > $departure->remaining_seats) {
                $error['num_people'] = "Không đủ ghế để tăng. Chỉ còn {$departure->remaining_seats} ghế trống.";
            }
        }

        if (!empty($error)) {
            redirect('error', $error, $route);
            return;
        }

        // Update booking DB
        $check = $this->booking->updateBooking($id, [
            'customer_id'    => $customer_id,
            'departure_id'   => $departure_id,
            'num_people'     => $num_people,
            'payment_status' => $payment_status,
            'status'         => $status,
            'note'           => $note,
            'updated_by'     => $_SESSION['user_id'] ?? null
        ]);

        if ($check) {
            // Tính seats mới
            $dep = new DepartureModel();
            $newSeatsBooked = $departure->seats_booked + ($num_people - $oldBooking->num_people);


            redirect('success', "Sửa booking thành công", 'list-booking');
        } else {
            redirect('error', "Sửa thất bại", $route);
        }
    }

    /**
     * Xóa booking
     */
    public function deleteBooking($id)
    {
        $booking = $this->booking->getBookingById($id);
        $departure = (new DepartureModel())->getDepartureById($booking->departure_id);

        $check = $this->booking->deleteBooking($id);

        if ($check) {
            // Giảm số ghế
            $newSeatsBooked = $departure->seats_booked - $booking->num_people;
            redirect('success', "Xóa booking thành công", 'list-booking');
        } else {
            redirect('error', "Xóa booking thất bại", 'list-booking');
        }
    }
}

