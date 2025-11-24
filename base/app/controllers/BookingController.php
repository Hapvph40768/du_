<?php
namespace App\Controllers;
use App\Models\BookingModel;
use App\Models\DepartureModel;

class BookingController extends BaseController
{
    public $booking;
    public function __construct()
    {
        $this->booking = new BookingModel();
    }
    public function getBookings()
    {
        $bookings = $this->booking->getAllBooking();
        $this->render("booking.listBooking", ['bookings' => $bookings]);
    }
    public function createBooking()
    {
        $departure = new DepartureModel();
        $departures = $departure->getAllDepartures();
        $this->render("booking.addBooking", ['departures' => $departures]);
    }
    public function postBooking()
    {
        $error = [];

        if (empty($_POST['departure_id'])) {
            $error['departure_id'] = "departure khong duoc bo trong";
        }
        if (empty($_POST['customer_name'])) {
            $error['customer_name'] = "ten khong duoc bo trong";
        }
        if (empty($_POST['customer_phone'])) {
            $error['customer_phone'] = "sdt khong duoc bo trong";
        }
        if (empty($_POST['people'])) {
            $error['people'] = "so luong khong duoc bo trong";
        }
        if (empty($_POST['total_price'])) {
            $error['total_price'] = "gia khong duoc bo trong";
        }
        $valStatus = ['pending', 'paid', 'cancelled'];
        $status = $_POST['status'] ?? 'pending';
        if (!in_array($status, $valStatus)) {
            $error['status'] = "Trạng thái không hợp lệ";
        }
        if (count($error) >= 1) {
            redirect('error', $error, "add-booking");
        } else {
            $check = $this->booking->addBooking([
                'departure_id' => $_POST['departure_id'],
                'customer_name' => $_POST['customer_name'],
                'customer_phone' => $_POST['customer_phone'],
                'people' => $_POST['people'],
                'total_price' => $_POST['total_price'],
                'status' => $_POST['status'],
            ]);
            if ($check) {
                redirect('success', "them thanh cong", 'list-booking');
            } else {
                redirect('error', "them that bai", 'add-booking');
            }
        }

    }
    public function detailBooking($id)
    {
        $detail = $this->booking->getBookingById($id);
        $departure = new DepartureModel();
        $departures = $departure->getAllDepartures();
        return $this->render('booking.editBooking', ['departures' => $departures, 'detail' => $detail]);

    }
    public function editBooking($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];
            if (empty($_POST['departure_id'])) {
                $error['departure_id'] = "departure khong duoc bo trong";
            }
            if (empty($_POST['customer_name'])) {
                $error['customer_name'] = "ten khong duoc bo trong";
            }
            if (empty($_POST['customer_phone'])) {
                $error['customer_phone'] = "sdt khong duoc bo trong";
            }
            if (empty($_POST['people'])) {
                $error['people'] = "so luong khong duoc bo trong";
            }
            if (empty($_POST['total_price'])) {
                $error['total_price'] = "gia khong duoc bo trong";
            }
            $valStatus = ['pending', 'paid', 'cancelled'];
            $status = $_POST['status'] ?? 'pending';
            if (!in_array($status, $valStatus)) {
                $error['status'] = "Trạng thái không hợp lệ";
            }
            $route = 'detail-booking/' . $id;
            if (count($error) >= 1) {
                redirect('error', $error, $route);
            } else {
                $check = $this->booking->updateBooking(
                    $id,
                    [
                        'departure_id' => $_POST['departure'],
                        'customer_name' => $_POST['customer_name'],
                        'customer_phone' => $_POST['customer_phone'],
                        'people' => $_POST['people'],
                        'total_price' => $_POST['total_price'],
                        'status' => $_POST['status'],
                    ]
                );
                if ($check) {
                    redirect('success', 'sua thanh cong', 'list-booking');
                }

            }
        }
    }
    public function deleteBooking($id)
    {
        $check = $this->booking->deleteBooking($id);
        if ($check) {
            redirect('success', 'xoa thanh cong', 'list-booking');
        }
    }
}