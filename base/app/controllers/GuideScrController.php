<?php
namespace App\Controllers;

use App\Models\ServiceChangeRequestsModel;
use App\Models\BookingModel;

class GuideScrController extends BaseController
{
    protected $requestModel;
    protected $booking;
    protected $service;

    public function __construct()
    {
        $this->requestModel = new ServiceChangeRequestsModel();
        $this->booking = new BookingModel();
        $this->service = new \App\Models\ServiceModel();
    }

    // 1. Danh sách yêu cầu thay đổi dịch vụ
    public function listGuideScrRequests()
    {
        $requests = $this->requestModel->getAllRequests();
        return $this->render("guide.guide_scr.listGuideScr", [
            'requests' => $requests
        ]);
    }

    // 2. Form thêm yêu cầu mới
    public function createGuideScrRequest()
    {
        $bookings = $this->booking->getAllBookings();
        $services = $this->service->getAllServices();
        return $this->render("guide.guide_scr.addGuideScr", [
            'bookings' => $bookings,
            'services' => $services
        ]);
    }

    // 3. Xử lý thêm yêu cầu mới
    public function postGuideScrRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('errors', "Yêu cầu không hợp lệ", 'list-guide-scr');
        }

        $booking_id = trim($_POST['booking_id'] ?? '');
        $service_ids = $_POST['service_ids'] ?? []; // Expect array
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
            redirect('errors', $error, 'add-guide-scr');
        }

        // Logic: Create one request per selected service. 
        // If no service selected, create one general request.
        $successCount = 0;

        if (!empty($service_ids) && is_array($service_ids)) {
            foreach ($service_ids as $sid) {
                $check = $this->requestModel->addRequest([
                    'booking_id'  => $booking_id,
                    'service_id'  => $sid,
                    'requester_id'=> $_SESSION['user']['id'] ?? null,
                    'request'     => $request,
                    'status'      => $status
                ]);
                if ($check) $successCount++;
            }
        } else {
            // General request (no service linked)
            $check = $this->requestModel->addRequest([
                'booking_id'  => $booking_id,
                'service_id'  => null,
                'requester_id'=> $_SESSION['user']['id'] ?? null,
                'request'     => $request,
                'status'      => $status
            ]);
            if ($check) $successCount++;
        }

        $successCount > 0
            ? redirect('success', "Thêm yêu cầu thành công ($successCount yêu cầu)", 'list-guide-scr')
            : redirect('errors', "Thêm yêu cầu thất bại", 'add-guide-scr');
    }

    // 4. Chi tiết yêu cầu để sửa
    public function detailGuideScrRequest($id)
    {
        $detail = $this->requestModel->getRequestById($id);
        $bookings = $this->booking->getAllBookings();
        $services = $this->service->getAllServices();

        return $this->render("guide.guide_scr.editGuideScr", [
            'detail'   => $detail,
            'bookings' => $bookings,
            'services' => $services
        ]);
    }

    // 5. Xử lý sửa yêu cầu
    public function editGuideScrRequest($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['btn-submit'])) {
            redirect('errors', "Yêu cầu không hợp lệ", 'list-guide-scr');
        }

        $booking_id = trim($_POST['booking_id'] ?? '');
        $service_id = trim($_POST['service_id'] ?? '');
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

        $route = 'detail-guide-scr/' . $id;

        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $check = $this->requestModel->updateRequest($id, [
            'booking_id'  => $booking_id,
            'service_id'  => !empty($service_id) ? $service_id : null,
            'requester_id'=> $_SESSION['user']['id'] ?? null,
            'request'     => $request,
            'status'      => $status,
            'decision_by' => $_SESSION['user']['id'] ?? null,
            'decided_at'  => ($status !== 'pending') ? date("Y-m-d H:i:s") : null
        ]);

        $check
            ? redirect('success', "Cập nhật yêu cầu thành công", 'list-guide-scr')
            : redirect('errors', "Cập nhật thất bại", $route);
    }
}