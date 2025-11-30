<?php
namespace App\Controllers;

use App\Models\TourLogsModel;
use App\Models\DepartureModel;

/**
 * Class TourLogController
 * Manage per-day logs for tours/departures
 */
class TourLogController extends BaseController
{
    public $logModel;

    public function __construct()
    {
        $this->logModel = new TourLogsModel();
    }

    // List all logs
    public function getLogs()
    {
        $logs = $this->logModel->getAllLogs();
        $this->render('tour.listTourLog', ['logs' => $logs]);
    }

    // Show add form
    public function createLog()
    {
        $depModel = new DepartureModel();
        $departures = $depModel->getAllDepartures();
        $this->render('tour.addTourLog', ['departures' => $departures]);
    }

    // Handle add
    public function postLog()
    {
        $error = [];

        $departure_id = $_POST['departure_id'] ?? '';
        $day_number = $_POST['day_number'] ?? '';
        $note = $_POST['note'] ?? '';

        if (empty($departure_id)) {
            $error['departure_id'] = 'Vui lòng chọn đợt khởi hành';
        }
        if ($day_number === '' || !is_numeric($day_number)) {
            $error['day_number'] = 'Số ngày phải là số và không được để trống';
        }
        if (empty($note)) {
            $error['note'] = 'Ghi chú không được để trống';
        }

        if (count($error) >= 1) {
            redirect('errors', $error, 'add-tour-log');
        }

        $check = $this->logModel->addLog([
            'departure_id' => $departure_id,
            'day_number' => $day_number,
            'note' => $note,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($check) {
            redirect('success', 'Thêm log thành công', 'list-tour-log');
        } else {
            redirect('errors', 'Thêm log thất bại', 'add-tour-log');
        }
    }

    public function deleteLog($id)
    {
        $check = $this->logModel->deleteLog($id);
        if ($check) {
            redirect('success', 'Xóa thành công', 'list-tour-log');
        }
    }

    public function detailLog($id)
    {
        $detail = $this->logModel->getLogById($id);
        $depModel = new DepartureModel();
        $departures = $depModel->getAllDepartures();
        return $this->render('tour.editTourLog', ['detail' => $detail, 'departures' => $departures]);
    }

    public function editLog($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            $departure_id = $_POST['departure_id'] ?? '';
            $day_number = $_POST['day_number'] ?? '';
            $note = $_POST['note'] ?? '';

            if (empty($departure_id)) {
                $error['departure_id'] = 'Vui lòng chọn đợt khởi hành';
            }
            if ($day_number === '' || !is_numeric($day_number)) {
                $error['day_number'] = 'Số ngày phải là số và không được để trống';
            }
            if (empty($note)) {
                $error['note'] = 'Ghi chú không được để trống';
            }

            $route = 'detail-tour-log/' . $id;
            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            }

            $check = $this->logModel->updateLog($id, [
                'departure_id' => $departure_id,
                'day_number' => $day_number,
                'note' => $note,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($check) {
                redirect('success', 'Sửa log thành công', 'list-tour-log');
            } else {
                redirect('errors', 'Sửa thất bại', $route);
            }
        }
    }

}

?>
