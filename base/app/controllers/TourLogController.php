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
        return $this->render('admin/tourlog/listLogs', compact('logs'));
    }

    // Form thêm tour log
    public function createLog()
    {
        $departures = $this->departure->getAllDepartures();
        return $this->render('admin/tourlog/addLog', compact('departures'));
    }

    // Xử lý thêm tour log
    public function postLog()
    {
        $error = [];

        // Validate dữ liệu
        if (empty($_POST['departure_id'])) {
            $error['departure_id'] = "Chuyến đi không được để trống";
        }

        if (count($error) > 0) {
            redirect('errors', $error, 'add-tour-log');
        } else {
            $check = $this->tourLog->addLog([
                'departure_id' => $_POST['departure_id'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

            if ($check) {
                redirect('success', "Thêm tour log thành công", 'list-tour-logs');
            } else {
                redirect('error', "Thêm tour log thất bại", 'add-tour-log');
            }
        }
    }

    // Chi tiết tour log để sửa
    public function detailLog($id)
    {
        $detail = $this->tourLog->getLogById($id);
        $departures = $this->departure->getAllDepartures();

        if (!$detail) {
            redirect('error', 'Tour log không tồn tại', 'list-tour-logs');
            return;
        }

        return $this->render('admin/tourlog/editLog', compact('detail', 'departures'));
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
            redirect('error', "Tour log không tồn tại", 'list-tour-logs');
            return;
        }

        // Validate dữ liệu
        if (empty($_POST['departure_id'])) {
            $error['departure_id'] = "Chuyến đi không được để trống";
        }

        $route = 'detail-tour-log/' . $id;

        if (count($error) > 0) {
            redirect('errors', $error, $route);
        } else {
            $check = $this->tourLog->updateLog($id, [
                'departure_id' => $_POST['departure_id'],
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

            if ($check) {
                redirect('success', "Cập nhật tour log thành công", 'list-tour-logs');
            } else {
                redirect('error', "Cập nhật tour log thất bại", $route);
            }
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