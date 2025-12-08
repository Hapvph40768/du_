<?php
namespace App\Controllers;

use App\Models\TourLogsModel;
use App\Models\DepartureModel;

class GuideTourLogController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TourLogsModel();
    }

    // Danh sách nhật ký tour
    public function list()
    {
        $logs = $this->model->getAllLogs();
        return $this->render('guide.tourlog.list', compact('logs'));
    }

    // Form thêm
    public function create()
    {
        $departureModel = new DepartureModel();
        $departures = $departureModel->getAllDepartures();

        return $this->render('guide.tourlog.add', compact('departures'));
    }

    // Lưu mới
    public function store()
    {
        $data = [
            'departure_id' => $_POST['departure_id'],
            'day_number'   => $_POST['day_number'],
            'note'         => $_POST['note'],
            'created_at'   => date("Y-m-d H:i:s"),
            'updated_at'   => date("Y-m-d H:i:s"),
        ];

        $this->model->addLog($data);

        $_SESSION['success'] = "Thêm nhật ký thành công";
        header("Location: " . route('list-guide-tourlog?msg=success'));
        exit;
    }

    // Chi tiết / form sửa
    public function detail($id)
    {
        $log = $this->model->getLogById($id);

        if (!$log) {
            $_SESSION['errors'] = ["Không tìm thấy nhật ký"];
            header("Location: " . route('list-guide-tourlog?msg=error'));
            exit;
        }

        $departureModel = new DepartureModel();
        $departures = $departureModel->getAllDepartures();

        return $this->render('guide.tourlog.detail', compact('log', 'departures'));
    }

    // Xử lý update
    public function update($id)
    {
        $data = [
            'departure_id' => $_POST['departure_id'],
            'day_number'   => $_POST['day_number'],
            'note'         => $_POST['note'],
            'updated_at'   => date("Y-m-d H:i:s"),
        ];

        $this->model->updateLog($id, $data);

        $_SESSION['success'] = "Cập nhật thành công";
        header("Location: " . route('detail-guide-tourlog/' . $id . '?msg=success'));
        exit;
    }

    // Xóa nhật ký
    public function delete($id)
    {
        $this->model->deleteLog($id);

        $_SESSION['success'] = "Xóa thành công";
        header("Location: " . route('list-guide-tourlog?msg=success'));
        exit;
    }
}
