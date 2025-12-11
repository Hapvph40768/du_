<?php
namespace App\Controllers;

use App\Models\TourLogsModel;
use App\Models\DepartureModel;

class TourLogController extends BaseController
{
    protected $tourLog;
    protected $departure;

    public function __construct()
    {
        $this->tourLog = new TourLogsModel();
        $this->departure = new DepartureModel();
    }

    // Danh sách tour log
    public function listLogs()
    {
        $logs = $this->tourLog->getAllLogs();
        return $this->render('admin.tourlog.listLog', compact('logs'));
    }

    // Form thêm tour log
    public function createLog()
    {
        $departures = $this->departure->getAllDepartures();
        $guides = (new \App\Models\UserModel())->getGuidesOnly();
        return $this->render('admin.tourlog.addLog', compact('departures', 'guides'));
    }

    // Xử lý thêm tour log
    public function postLog()
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
            redirect('errors', $error, 'add-tour-log');
            return;
        }

        // Derive tour_id from departure_id
        $departure = $this->departure->getDepartureById($_POST['departure_id']);
        if (!$departure) {
            redirect('error', "Chuyến đi không hợp lệ", 'add-tour-log');
            return;
        }

        // Determine assigned user: if provided in form, use it; else fallback to session user
        $userId = !empty($_POST['user_id']) ? $_POST['user_id'] : ($_SESSION['user_id'] ?? null);

        $check = $this->tourLog->addLog([
            'tour_id' => $departure->tour_id,
            'departure_id' => $_POST['departure_id'],
            'user_id' => $userId,
            'action' => $_POST['action'],
            'message' => $_POST['message'],
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        if ($check) {
            redirect('success', "Thêm nhật ký thành công", 'list-tour-logs');
        } else {
            redirect('error', "Thêm nhật ký thất bại", 'add-tour-log');
        }
    }

    // Chi tiết tour log để sửa
    public function detailLog($id)
    {
        $detail = $this->tourLog->getLogById($id);
        $departures = $this->departure->getAllDepartures();
        $guides = (new \App\Models\UserModel())->getGuidesOnly();

        if (!$detail) {
            redirect('error', 'Nhật ký không tồn tại', 'list-tour-logs');
            return;
        }

        return $this->render('admin.tourlog.editLog', compact('detail', 'departures', 'guides'));
    }

    // Xử lý sửa tour log
    public function editLog($id)
    {
        if (!isset($_POST['btn-submit'])) {
            return;
        }

        $error = [];
        $detail = $this->tourLog->getLogById($id);

        if (!$detail) {
            redirect('error', "Nhật ký không tồn tại", 'list-tour-logs');
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

        $route = 'detail-tour-log/' . $id;

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
            redirect('success', "Cập nhật nhật ký thành công", 'list-tour-logs');
        } else {
            redirect('error', "Cập nhật nhật ký thất bại", $route);
        }
    }

    // Xóa tour log
    public function deleteLog($id)
    {
        $check = $this->tourLog->deleteLog($id);
        if ($check) {
            redirect('success', "Xóa tour log thành công", 'list-tour-logs');
        } else {
            redirect('error', "Xóa tour log thất bại", 'list-tour-logs');
        }
    }
}
?>