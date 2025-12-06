<?php
namespace App\Controllers;

use App\Models\BookingServiceModel;
use App\Models\BookingModel;
use App\Models\ServiceModel;

class BookingServiceController extends BaseController
{
    protected $bookingService;

    public function __construct()
    {
        $this->bookingService = new BookingServiceModel();
    }

    // 1. Danh sách dịch vụ kèm theo booking
    public function listBookingServices()
    {
        $bookingServices = $this->bookingService->getAllBookingServices();
        return $this->render("admin.booking_service.listBookingService", [
            'bookingServices' => $bookingServices
        ]);
    }

    // 2. Form thêm mới
    public function createBookingService()
    {
        $bookings = (new BookingModel())->getAllBookings();
        $services = (new ServiceModel())->getAllServices();

        return $this->render("admin.booking_service.addBookingService", [
            'bookings' => $bookings,
            'services' => $services
        ]);
    }

    // 3. Xử lý thêm mới
    public function postBookingService()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('errors', "Yêu cầu không hợp lệ", 'list-booking-service');
        }

        $data = [
            'booking_id' => trim($_POST['booking_id'] ?? ''),
            'service_id' => trim($_POST['service_id'] ?? ''),
            'quantity'   => $_POST['quantity'] ?? 1,
            'price'      => $_POST['price'] ?? 0.00,
        ];

        $error = $this->validate($data);

        if (!empty($error)) {
            redirect('errors', $error, 'add-booking-service');
        }

        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        $check = $this->bookingService->addBookingService($data);

        if ($check) {
            redirect('success', "Thêm dịch vụ vào booking thành công", 'list-booking-service');
        } else {
            redirect('errors', "Thêm thất bại", 'add-booking-service');
        }
    }

    // 4. Chi tiết để sửa
    public function detailBookingService($id)
    {
        $detail   = $this->bookingService->getBookingServiceById($id);
        $bookings = (new BookingModel())->getAllBookings();
        $services = (new ServiceModel())->getAllServices();

        return $this->render("admin.booking_service.editBookingService", [
            'detail'   => $detail,
            'bookings' => $bookings,
            'services' => $services
        ]);
    }

    // 5. Xử lý sửa
    public function editBookingService($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['btn-submit'])) {
            redirect('errors', "Yêu cầu không hợp lệ", 'list-booking-service');
        }

        $data = [
            'booking_id' => trim($_POST['booking_id'] ?? ''),
            'service_id' => trim($_POST['service_id'] ?? ''),
            'quantity'   => $_POST['quantity'] ?? 1,
            'price'      => $_POST['price'] ?? 0.00,
        ];

        $error = $this->validate($data);
        $route = 'detail-booking-service/' . $id;

        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $data['updated_at'] = date("Y-m-d H:i:s");

        $check = $this->bookingService->updateBookingService($id, $data);

        if ($check) {
            redirect('success', "Cập nhật dịch vụ thành công", 'list-booking-service');
        } else {
            redirect('errors', "Cập nhật thất bại", $route);
        }
    }

    // 6. Xóa
    public function deleteBookingService($id)
    {
        $check = $this->bookingService->deleteBookingService($id);

        if ($check) {
            redirect('success', "Xóa dịch vụ khỏi booking thành công", 'list-booking-service');
        } else {
            redirect('errors', "Xóa thất bại", 'list-booking-service');
        }
    }

    // Hàm validate chung
    private function validate($data)
    {
        $error = [];

        if (empty($data['booking_id'])) {
            $error['booking_id'] = "Phải chọn booking.";
        }
        if (empty($data['service_id'])) {
            $error['service_id'] = "Phải chọn dịch vụ.";
        }
        if (!is_numeric($data['quantity']) || $data['quantity'] <= 0) {
            $error['quantity'] = "Số lượng phải là số dương.";
        }
        if (!is_numeric($data['price']) || $data['price'] < 0) {
            $error['price'] = "Giá phải là số không âm.";
        }

        return $error;
    }
}
?>
