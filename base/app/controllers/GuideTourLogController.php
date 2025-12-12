<?php
namespace App\Controllers;

use App\Models\TourLogsModel;
use App\Models\DepartureModel;
use App\Models\TourGuideModel;
use App\Models\GuidesModel;

class GuideTourLogController extends BaseController
{
    protected $tourLog;
    protected $departure;
    protected $tourGuide;

    public function __construct()
    {
        $this->tourLog = new TourLogsModel();
        $this->departure = new DepartureModel();
        $this->tourGuide = new TourGuideModel();
    }

    // Danh sách tour log
    public function listGuideTourLogs()
    {
        $allLogs = $this->tourLog->getAllLogs();
        $userId = $_SESSION['user']['id'] ?? 0;
        
        // Filter logs: only show logs belonging to the current user
        $logs = array_filter($allLogs, function($log) use ($userId) {
            return $log->user_id == $userId;
        });
        
        return $this->render('guide.guide_tour_log.listGuideTourLog', compact('logs'));
    }

    // Form thêm tour log
    public function createGuideTourLog()
    {
        $userId = $_SESSION['user']['id'] ?? 0;
        
        // Find Guide ID from User ID
        $guidesModel = new GuidesModel();
        $guideProfile = $guidesModel->getGuideByUserId($userId);
        
        $departures = [];
        if ($guideProfile) {
            // Get tours assigned to this guide
            $departures = $this->tourGuide->getAssignedTours($guideProfile->id);
        }
        
        // Only show the current user in the Executor list (as requested)
        $currentUser = (new \App\Models\UserModel())->getUserById($userId);
        $guides = $currentUser ? [$currentUser] : [];
        
        return $this->render('guide.guide_tour_log.addGuideTourLog', compact('departures', 'guides'));
    }

    // Xử lý thêm tour log
    public function postGuideTourLog()
    {
        $error = [];

        // Validate dữ liệu
        if (empty($_POST['departure_id'])) {
            $error['departure_id'] = "Chuyến đi không được để trống";
        }
        if (empty($_POST['action'])) {
            $error['action'] = "Hành động không được để trống";
        }
        if (empty($_POST['message'])) {
            $error['message'] = "Mô tả không được để trống";
        }

        if (count($error) > 0) {
            redirect('errors', $error, 'add-guide-tour-log');
            return;
        }

        // Derive tour_id from departure_id
        $departure = $this->departure->getDepartureById($_POST['departure_id']);
        if (!$departure) {
            redirect('error', "Chuyến đi không hợp lệ", 'add-guide-tour-log');
            return;
        }

        // Determine assigned user
        $sessionUserId = $_SESSION['user']['id'] ?? null;
        $postUserId = !empty($_POST['user_id']) ? $_POST['user_id'] : null;
        $userId = $postUserId ?: $sessionUserId;

        if (!$userId) {
            redirect('error', "Không xác định được người thực hiện. Vui lòng đăng nhập lại.", 'add-guide-tour-log');
            return;
        }

        // Prepare data with explicit casting
        $data = [
            'tour_id' => (int)$departure->tour_id,
            'departure_id' => (int)$_POST['departure_id'],
            'user_id' => (int)$userId,
            'action' => trim($_POST['action']),
            'message' => trim($_POST['message']),
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $check = $this->tourLog->addLog($data);

        if ($check) {
            redirect('success', "Thêm nhật ký thành công", 'list-guide-tour-log');
        } else {
            redirect('error', "Lỗi hệ thống: Không thể lưu vào cơ sở dữ liệu.", 'add-guide-tour-log');
        }
    }

    // Chi tiết tour log để sửa
    public function detailGuideTourLog($id)
    {
        $detail = $this->tourLog->getLogById($id);
        $departures = $this->departure->getAllDepartures();
        $guides = (new \App\Models\UserModel())->getGuidesOnly();

        if (!$detail) {
            redirect('error', 'Nhật ký không tồn tại', 'list-guide-tour-log');
            return;
        }

        // Ownership Check
        $currentUserId = $_SESSION['user']['id'] ?? 0;
        if ($detail->user_id != $currentUserId) {
            redirect('error', 'Bạn không có quyền chỉnh sửa nhật ký này', 'list-guide-tour-log');
            return;
        }

        return $this->render('guide.guide_tour_log.editGuideTourLog', compact('detail', 'departures', 'guides'));
    }

    // Xử lý sửa tour log
    public function editGuideTourLog($id)
    {
        if (!isset($_POST['btn-submit'])) {
            return;
        }

        $error = [];
        $detail = $this->tourLog->getLogById($id);

        if (!$detail) {
            redirect('error', "Nhật ký không tồn tại", 'list-guide-tour-log');
            return;
        }

        // Ownership Check
        $currentUserId = $_SESSION['user']['id'] ?? 0;
        if ($detail->user_id != $currentUserId) {
            redirect('error', 'Bạn không có quyền chỉnh sửa nhật ký này', 'list-guide-tour-log');
            return;
        }

        // Validate dữ liệu
        if (empty($_POST['departure_id'])) {
            $error['departure_id'] = "Chuyến đi không được để trống";
        }
        if (empty($_POST['action'])) {
            $error['action'] = "Hành động không được để trống";
        }
        if (empty($_POST['message'])) {
            $error['message'] = "Mô tả không được để trống";
        }

        $route = 'detail-guide-tour-log/' . $id;

        if (count($error) > 0) {
            redirect('errors', $error, $route);
            return;
        }

        // Derive tour_id from departure_id
        $departure = $this->departure->getDepartureById($_POST['departure_id']);
        
        // Determine assigned user
        $userId = !empty($_POST['user_id']) ? $_POST['user_id'] : $detail->user_id;

        $check = $this->tourLog->updateLog($id, [
            'tour_id' => $departure->tour_id,
            'departure_id' => $_POST['departure_id'],
            'user_id' => $userId, 
            'action' => $_POST['action'],
            'message' => $_POST['message']
        ]);

        if ($check) {
            redirect('success', "Cập nhật nhật ký thành công", 'list-guide-tour-log');
        } else {
            redirect('error', "Cập nhật nhật ký thất bại", $route);
        }
    }

    // Xóa tour log
    public function deleteGuideTourLog($id)
    {
        $detail = $this->tourLog->getLogById($id);
        if (!$detail) {
             redirect('error', "Nhật ký không tồn tại", 'list-guide-tour-log');
             return;
        }

        // Ownership Check
        $currentUserId = $_SESSION['user']['id'] ?? 0;
        if ($detail->user_id != $currentUserId) {
            redirect('error', 'Bạn không có quyền xóa nhật ký này', 'list-guide-tour-log');
            return;
        }

        $check = $this->tourLog->deleteLog($id);
        if ($check) {
            redirect('success', "Xóa tour log thành công", 'list-guide-tour-log');
        } else {
            redirect('error', "Xóa tour log thất bại", 'list-guide-tour-log');
        }

    }

    // AJAX: Get Info for Departure (Guides Only)
    // Kept but unused in basic version
    public function getDepartureInfo($id)
    {
        header('Content-Type: application/json');
        
        $guides = $this->tourGuide->getGuidesByDeparture($id);
        
        echo json_encode([
            'guides' => $guides
        ]);
        exit;
    }
}
?>