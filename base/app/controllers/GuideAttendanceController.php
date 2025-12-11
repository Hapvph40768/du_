<?php
namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\DepartureModel;
use App\Models\CustomerModel;
use App\Models\BookingCustomerModel;

class GuideAttendanceController extends BaseController
{
    protected $attendance;

    public function __construct()
    {
        $this->attendance = new AttendanceModel();
    }

    // Danh sách attendance
    public function listAttendance()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $guideModel = new \App\Models\GuidesModel();
        $guide = $guideModel->getGuideByUserId($userId);

        $attendances = [];
        if ($guide) {
            $attendances = $this->attendance->getAttendanceByGuide($guide->id);
        }

        return $this->render('guide.guide_attendance.listAttendance', ['attendances' => $attendances]);
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

        return $this->render('guide.guide_attendance.editAttendance', [
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
        $booking_customer_id= $_POST['booking_customer_id'] ?? null;
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
            redirect('success', 'Cập nhật thành công', 'list-guide-attendance');
        } else {
            redirect('error', 'Cập nhật thất bại', $route);
        }
    }

}
?>