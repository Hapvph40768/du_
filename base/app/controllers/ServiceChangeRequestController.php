<?php
namespace App\Controllers;

use App\Models\ServiceChangeRequestsModel;
use App\Models\BookingModel;

class ServiceChangeRequestController extends BaseController
{
    protected $requestModel;
    protected $booking;

    public function __construct()
    {
        $this->requestModel = new ServiceChangeRequestsModel();
        $this->booking = new BookingModel();
    }

    // 1. Danh sách yêu cầu thay đổi dịch vụ
    public function listRequests()
    {
        $requests = $this->requestModel->getAllRequests();
        return $this->render("admin.service_change_requests.listRequest", [
            'requests' => $requests
        ]);
    }

    // 2. Form thêm yêu cầu mới
    public function createRequest()
    {
        $bookings = $this->booking->getAllBookings();
        return $this->render("admin.service_change_requests.addRequest", [
            'bookings' => $bookings
        ]);
    }

    // 3. Xử lý thêm yêu cầu mới
    public function postRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('errors', "Yêu cầu không hợp lệ", 'list-request');
        }

        $booking_id = trim($_POST['booking_id'] ?? '');
        $request    = trim($_POST['request'] ?? '');
        $status     = $_POST['status'] ?? 'pending';

        $error = [];

        if (empty($booking_id) || !is_numeric($booking_id)) {
            $error['booking_id'] = "Booking ID phải là số và không được để trống.";
        }
        if (empty($request)) {
            $error['request'] = "Nội dung yêu cầu không được để trống.";
        }
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            $error['status'] = "Trạng thái không hợp lệ.";
        }

        if (!empty($error)) {
            redirect('errors', $error, 'add-request');
        }

        $check = $this->requestModel->addRequest([
            'booking_id'  => $booking_id,
            'requester_id'=> $_SESSION['user']['id'] ?? null, // ai gửi yêu cầu
            'request'     => $request,
            'status'      => $status
        ]);

        $check
            ? redirect('success', "Thêm yêu cầu thành công", 'list-request')
            : redirect('errors', "Thêm yêu cầu thất bại", 'add-request');
    }

    // 4. Chi tiết yêu cầu để sửa
    public function detailRequest($id)
    {
        $detail = $this->requestModel->getRequestById($id);
        $bookings = $this->booking->getAllBookings();

        return $this->render("admin.service_change_requests.editRequest", [
            'detail'   => $detail,
            'bookings' => $bookings
        ]);
    }

    // 5. Xử lý sửa yêu cầu
    public function editRequest($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['btn-submit'])) {
            redirect('errors', "Yêu cầu không hợp lệ", 'list-request');
        }

        $booking_id = trim($_POST['booking_id'] ?? '');
        $request    = trim($_POST['request'] ?? '');
        $status     = $_POST['status'] ?? 'pending';

        $error = [];

        if (empty($booking_id) || !is_numeric($booking_id)) {
            $error['booking_id'] = "Booking ID phải là số và không được để trống.";
        }
        if (empty($request)) {
            $error['request'] = "Nội dung yêu cầu không được để trống.";
        }
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            $error['status'] = "Trạng thái không hợp lệ.";
        }

        $route = 'detail-request/' . $id;

        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $check = $this->requestModel->updateRequest($id, [
            'booking_id'  => $booking_id,
            'requester_id'=> $_SESSION['user']['id'] ?? null,
            'request'     => $request,
            'status'      => $status,
            'decision_by' => $_SESSION['user']['id'] ?? null,
            'decided_at'  => ($status !== 'pending') ? date("Y-m-d H:i:s") : null
        ]);

        $check
            ? redirect('success', "Cập nhật yêu cầu thành công", 'list-request')
            : redirect('errors', "Cập nhật thất bại", $route);
    }

    // 6. Xóa yêu cầu
    public function deleteRequest($id)
    {
        $check = $this->requestModel->deleteRequest($id);

        $check
            ? redirect('success', 'Xóa yêu cầu thành công', 'list-request')
            : redirect('errors', 'Xóa yêu cầu thất bại', 'list-request');
    }
}