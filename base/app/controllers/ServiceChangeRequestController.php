<?php
namespace App\Controllers;

use App\Models\ServiceChangeRequestsModel;

class ServiceChangeRequestController extends BaseController
{
    protected $requestModel;

    public function __construct()
    {
        $this->requestModel = new ServiceChangeRequestsModel();
    }

    // 1. Danh sách yêu cầu thay đổi dịch vụ
    public function listRequests()
    {
        $requests = $this->requestModel->getAllRequests();
        return $this->render("admin.service_change_requests.listRequest", ['requests' => $requests]);
    }

    // 2. Form thêm yêu cầu mới
    public function createRequest()
    {
        return $this->render("admin.service_change_requests.addRequest");
    }

    // 3. Xử lý thêm yêu cầu mới
    public function postRequest()
    {
        $error = [];

        $booking_id = $_POST['booking_id'] ?? '';
        $request    = $_POST['request'] ?? '';
        $status     = $_POST['status'] ?? 'pending';

        // Validate
        if (empty($booking_id) || !is_numeric($booking_id)) {
            $error['booking_id'] = "Booking ID phải là số và không được để trống.";
        }
        if (empty($request)) {
            $error['request'] = "Nội dung yêu cầu không được để trống.";
        }
        if (!in_array($status, ['pending','approved','rejected'])) {
            $error['status'] = "Trạng thái không hợp lệ.";
        }

        if (!empty($error)) {
            redirect('errors', $error, 'add-request');
        }

        $check = $this->requestModel->addRequest([
            'booking_id' => $booking_id,
            'request'    => $request,
            'status'     => $status,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Thêm yêu cầu thành công", 'list-request');
        } else {
            redirect('errors', "Thêm yêu cầu thất bại", 'add-request');
        }
    }

    // 4. Chi tiết yêu cầu để sửa
    public function detailRequest($id)
    {
        $detail = $this->requestModel->getRequestById($id);
        return $this->render("admin.service_change_requests.editRequest", ['detail' => $detail]);
    }

    // 5. Xử lý sửa yêu cầu
    public function editRequest($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $error = [];

        $booking_id = $_POST['booking_id'] ?? '';
        $request    = $_POST['request'] ?? '';
        $status     = $_POST['status'] ?? 'pending';

        if (empty($booking_id) || !is_numeric($booking_id)) {
            $error['booking_id'] = "Booking ID phải là số và không được để trống.";
        }
        if (empty($request)) {
            $error['request'] = "Nội dung yêu cầu không được để trống.";
        }
        if (!in_array($status, ['pending','approved','rejected'])) {
            $error['status'] = "Trạng thái không hợp lệ.";
        }

        $route = 'detail-request/' . $id;
        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $check = $this->requestModel->updateRequest($id, [
            'booking_id' => $booking_id,
            'request'    => $request,
            'status'     => $status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Cập nhật yêu cầu thành công", 'list-request');
        } else {
            redirect('errors', "Cập nhật thất bại", $route);
        }
    }

    // 6. Xóa yêu cầu
    public function deleteRequest($id)
    {
        $check = $this->requestModel->deleteRequest($id);

        if ($check) {
            redirect('success', "Xóa yêu cầu thành công", 'list-request');
        } else {
            redirect('errors', "Xóa thất bại", 'list-request');
        }
    }
}