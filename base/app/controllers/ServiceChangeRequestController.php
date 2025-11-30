<?php
namespace App\Controllers;

use App\Models\ServiceChangeRequestsModel;

/**
 * Class ServiceChangeRequestController
 * Manage service change requests
 */
class ServiceChangeRequestController extends BaseController
{
    public $requests;

    public function __construct()
    {
        $this->requests = new ServiceChangeRequestsModel();
    }

    // List requests
    public function getRequests()
    {
        $items = $this->requests->getAllRequests();
        $this->render('service_change_request.listRequests', ['requests' => $items]);
    }

    // Show create form
    public function createRequest()
    {
        $this->render('service_change_request.addRequest');
    }

    // Handle create
    public function postRequest()
    {
        $error = [];

        $booking_id = $_POST['booking_id'] ?? '';
        $request = $_POST['request'] ?? '';

        if (empty($booking_id)) {
            $error['booking_id'] = 'ID Booking không được để trống';
        }
        if (empty($request)) {
            $error['request'] = 'Nội dung yêu cầu không được để trống';
        }

        if (count($error) >= 1) {
            redirect('errors', $error, 'add-service-change-request');
        }

        $check = $this->requests->addRequest([
            'booking_id' => $booking_id,
            'request' => $request,
            'status' => $_POST['status'] ?? 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($check) {
            redirect('success', 'Thêm yêu cầu thay đổi dịch vụ thành công', 'list-service-change-requests');
        } else {
            redirect('errors', 'Thêm thất bại', 'add-service-change-request');
        }
    }

    // Delete request
    public function deleteRequest($id)
    {
        $check = $this->requests->deleteRequest($id);
        if ($check) {
            redirect('success', 'Xóa thành công', 'list-service-change-requests');
        }
    }

    public function detailRequest($id)
    {
        $detail = $this->requests->getRequestById($id);
        return $this->render('service_change_request.editRequest', ['detail' => $detail]);
    }

    public function editRequest($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            $booking_id = $_POST['booking_id'] ?? '';
            $request = $_POST['request'] ?? '';

            if (empty($booking_id)) {
                $error['booking_id'] = 'ID Booking không được để trống';
            }
            if (empty($request)) {
                $error['request'] = 'Nội dung yêu cầu không được để trống';
            }

            $route = 'detail-service-change-request/' . $id;
            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            }

            $check = $this->requests->updateRequest($id, [
                'booking_id' => $booking_id,
                'request' => $request,
                'status' => $_POST['status'] ?? 'pending',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($check) {
                redirect('success', 'Sửa thành công', 'list-service-change-requests');
            } else {
                redirect('errors', 'Sửa thất bại', $route);
            }
        }
    }

}

?>
