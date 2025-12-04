<?php
namespace App\Controllers;
use App\Models\BookingModel;
use App\Models\DepartureModel;
use App\Models\CustomerModel; // nếu có model customers

class BookingController extends BaseController
{
    protected $booking;

    public function __construct()
    {
        $this->booking = new BookingModel();
    }

    // Danh sách bookings
    public function getBookings()
    {
        $bookings = $this->booking->getAllBookings();
        $this->render("admin.booking.listBooking", ['bookings' => $bookings]);
    }

    // Form thêm booking
    public function createBooking()
    {
        $departureModel = new DepartureModel();
        $departures = $departureModel->getAllDepartures();

        $customerModel = new CustomerModel();
        $customers = $customerModel->getAllCustomers();

        $this->render("admin.booking.addBooking", [
            'departures' => $departures,
            'customers'  => $customers
        ]);
    }

    // Xử lý thêm booking
    public function postBooking()
    {
        $error = [];

        $departure_id   = $_POST['departure_id'] ?? '';
        $customer_id    = $_POST['customer_id'] ?? null;
        $num_people     = $_POST['num_people'] ?? '';
        $total_price    = $_POST['total_price'] ?? '';
        $payment_status = $_POST['payment_status'] ?? 'unpaid';
        $status         = $_POST['status'] ?? 'pending';
        $note           = $_POST['note'] ?? null;

        // validate
        if (empty($departure_id)) {
            $error['departure_id'] = "Departure không được bỏ trống";
        }
        if (empty($num_people) || !is_numeric($num_people)) {
            $error['num_people'] = "Số lượng người không hợp lệ";
        }
        if (empty($total_price) || !is_numeric($total_price)) {
            $error['total_price'] = "Giá không hợp lệ";
        }
        if (!in_array($payment_status, ['unpaid','partial','paid'])) {
            $error['payment_status'] = "Trạng thái thanh toán không hợp lệ";
        }
        if (!in_array($status, ['pending','confirmed','cancelled'])) {
            $error['status'] = "Trạng thái booking không hợp lệ";
        }

        if (count($error) > 0) {
            redirect('error', $error, "add-booking");
        } else {
            $check = $this->booking->addBooking([
                'customer_id'    => $customer_id,
                'departure_id'   => $departure_id,
                'num_people'     => $num_people,
                'total_price'    => $total_price,
                'payment_status' => $payment_status,
                'status'         => $status,
                'note'           => $note,
                'created_at'     => date("Y-m-d H:i:s"),
                'updated_at'     => date("Y-m-d H:i:s"),
            ]);
            if ($check) {
                redirect('success', "Thêm thành công", 'list-booking');
            } else {
                redirect('error', "Thêm thất bại", 'add-booking');
            }
        }
    }

    // Chi tiết booking để sửa
    public function detailBooking($id)
    {
        $detail = $this->booking->getBookingById($id);

        $departureModel = new DepartureModel();
        $departures = $departureModel->getAllDepartures();

        $customerModel = new CustomerModel();
        $customers = $customerModel->getAllCustomers();

        return $this->render('admin.booking.editBooking', [
            'departures' => $departures,
            'customers'  => $customers,
            'detail'     => $detail
        ]);
    }

    // Xử lý sửa booking
    public function editBooking($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            $departure_id   = $_POST['departure_id'] ?? '';
            $customer_id    = $_POST['customer_id'] ?? null;
            $num_people     = $_POST['num_people'] ?? '';
            $total_price    = $_POST['total_price'] ?? '';
            $payment_status = $_POST['payment_status'] ?? 'unpaid';
            $status         = $_POST['status'] ?? 'pending';
            $note           = $_POST['note'] ?? null;

            if (empty($departure_id)) {
                $error['departure_id'] = "Departure không được bỏ trống";
            }
            if (empty($num_people) || !is_numeric($num_people)) {
                $error['num_people'] = "Số lượng người không hợp lệ";
            }
            if (empty($total_price) || !is_numeric($total_price)) {
                $error['total_price'] = "Giá không hợp lệ";
            }
            if (!in_array($payment_status, ['unpaid','partial','paid'])) {
                $error['payment_status'] = "Trạng thái thanh toán không hợp lệ";
            }
            if (!in_array($status, ['pending','confirmed','cancelled'])) {
                $error['status'] = "Trạng thái booking không hợp lệ";
            }

            $route = 'detail-booking/' . $id;

            if (count($error) > 0) {
                redirect('error', $error, $route);
            } else {
                $check = $this->booking->updateBooking($id, [
                    'customer_id'    => $customer_id,
                    'departure_id'   => $departure_id,
                    'num_people'     => $num_people,
                    'total_price'    => $total_price,
                    'payment_status' => $payment_status,
                    'status'         => $status,
                    'note'           => $note,
                    'updated_at'     => date("Y-m-d H:i:s"),
                ]);
                if ($check) {
                    redirect('success', 'Sửa thành công', 'list-booking');
                } else {
                    redirect('error', 'Sửa thất bại', $route);
                }
            }
        }
    }

    // Xóa booking
    public function deleteBooking($id)
    {
        $check = $this->booking->deleteBooking($id);
        if ($check) {
            redirect('success', 'Xóa thành công', 'list-booking');
        } else {
            redirect('error', 'Xóa thất bại', 'list-booking');
        }
    }
}