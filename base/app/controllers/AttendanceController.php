<?php
namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\DepartureModel;
use App\Models\CustomerModel;
use App\Models\BookingCustomerModel;

class AttendanceController extends BaseController
{
    protected $attendance;

    public function __construct()
    {
        $this->attendance = new AttendanceModel();
    }

    // Danh sách attendance
    public function listAttendance()
    {
        $status = $_GET['status'] ?? null;
        $start_date = $_GET['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? null;
        $tour_id = $_GET['tour_id'] ?? null;

        $attendances = $this->attendance->getAllAttendance($status, $start_date, $end_date, $tour_id);
        
        // Fetch tours for dropdown
        $tourModel = new \App\Models\TourModel();
        $tours = $tourModel->getAllTours();

        return $this->render('admin.attendance.listAttendance', [
            'attendances' => $attendances,
            'currentStatus' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tour_id' => $tour_id,
            'tours' => $tours
        ]);
    }

    // Form thêm attendance
    public function createAttendance()
    {
        $departureModel = new DepartureModel();
        $departures = $departureModel->getAllDepartures();

        $customerModel = new CustomerModel();
        $customers = $customerModel->getAllCustomers();

        $bookingCustomerModel = new BookingCustomerModel();
        $bookingCustomers = $bookingCustomerModel->getAllBookingCustomers();

        return $this->render('admin.attendance.addAttendance', [
            'departures'       => $departures,
            'customers'        => $customers,
            'bookingCustomers' => $bookingCustomers
        ]);
    }

    // Xử lý thêm attendance
    public function postAttendance()
    {
        $error = [];

        $departure_id       = $_POST['departure_id'] ?? '';
        $customer_id        = $_POST['customer_id'] ?? '';
        $booking_customer_id= !empty($_POST['booking_customer_id']) ? $_POST['booking_customer_id'] : null;
        $status             = $_POST['status'] ?? 'present';
        $checkin_time       = $_POST['checkin_time'] ?? null;
        $note               = $_POST['note'] ?? null;

        // validate
        if (empty($departure_id)) {
            $error['departure_id'] = "Departure không được để trống";
        }
        // customer_id is optional
        if (!in_array($status, ['present','absent'])) {
            $error['status'] = "Trạng thái không hợp lệ";
        }

        if (!empty($error)) {
            redirect('error', $error, 'add-attendance');
        }

        $check = $this->attendance->addAttendance([
            'departure_id'       => $departure_id,
            'customer_id'        => $customer_id,
            'booking_customer_id'=> $booking_customer_id,
            'status'             => $status,
            'checkin_time'       => $checkin_time,
            'note'               => $note,
            'created_at'         => date("Y-m-d H:i:s"),
            'updated_at'         => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', 'Thêm attendance thành công', 'list-attendance');
        } else {
            redirect('error', 'Thêm thất bại', 'add-attendance');
        }
    }

    // Chi tiết attendance để sửa
    public function detailAttendance($id)
    {
        $detail = $this->attendance->getAttendanceById($id);

        $departureModel = new DepartureModel();
        $departures = $departureModel->getAllDepartures();

        $customerModel = new CustomerModel();
        $customers = $customerModel->getAllCustomers();

        $bookingCustomerModel = new BookingCustomerModel();
        $bookingCustomers = $bookingCustomerModel->getAllBookingCustomers();

        return $this->render('admin.attendance.editAttendance', [
            'detail'           => $detail,
            'departures'       => $departures,
            'customers'        => $customers,
            'bookingCustomers' => $bookingCustomers
        ]);
    }

    // Xử lý sửa attendance
    public function updateAttendance($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $error = [];

        $departure_id       = $_POST['departure_id'] ?? '';
        $customer_id        = $_POST['customer_id'] ?? '';
        $booking_customer_id= !empty($_POST['booking_customer_id']) ? $_POST['booking_customer_id'] : null;
        $status             = $_POST['status'] ?? 'present';
        $checkin_time       = $_POST['checkin_time'] ?? null;
        $note               = $_POST['note'] ?? null;

        if (empty($departure_id)) {
            $error['departure_id'] = "Departure không được để trống";
        }
        if (empty($customer_id)) {
            $error['customer_id'] = "Customer không được để trống";
        }
        if (!in_array($status, ['present','absent'])) {
            $error['status'] = "Trạng thái không hợp lệ";
        }

        $route = 'detail-attendance/' . $id;
        if (!empty($error)) {
            redirect('error', $error, $route);
        }

        $check = $this->attendance->updateAttendance($id, [
            'departure_id'       => $departure_id,
            'customer_id'        => $customer_id,
            'booking_customer_id'=> $booking_customer_id,
            'status'             => $status,
            'checkin_time'       => $checkin_time,
            'note'               => $note,
            'updated_at'         => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', 'Cập nhật thành công', 'list-attendance');
        } else {
            redirect('error', 'Cập nhật thất bại', $route);
        }
    }

    // Xóa attendance
    public function deleteAttendance($id)
    {
        $check = $this->attendance->deleteAttendance($id);

        if ($check) {
            redirect('success', 'Xóa thành công', 'list-attendance');
        } else {
            redirect('error', 'Xóa thất bại', 'list-attendance');
        }
    }
}
?>