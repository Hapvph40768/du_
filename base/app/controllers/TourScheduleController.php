<?php
namespace App\Controllers;

use App\Models\TourScheduleModel;

class TourScheduleController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TourScheduleModel();
    }

    // List lịch trình theo tour
    public function index($tour_id)
    {
        $schedules = $this->model->getByTour($tour_id);
        $this->render('tourSchedule.list', [
            'schedules' => $schedules,
            'tour_id' => $tour_id
        ]);
    }

    // Form tạo mới
    public function create($tour_id)
    {
        $this->render('tourSchedule.create', ['tour_id' => $tour_id]);
    }

    // Lưu mới
    public function store($tour_id)
    {
        $errors = [];
        $day_number = isset($_POST['day_number']) ? intval($_POST['day_number']) : null;
        $title = trim($_POST['title'] ?? '');
        if (!$day_number) $errors[] = "Số thứ tự ngày (day_number) bắt buộc.";
        if ($title === '') $errors[] = "Tiêu đề (title) bắt buộc.";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: " . BASE_URL . "tours/{$tour_id}/schedules/create");
            exit;
        }

        $activities_raw = trim($_POST['activities'] ?? '');
        $activities_arr = $activities_raw !== '' ? preg_split('/\r\n|\r|\n/', $activities_raw) : [];

        $data = [
            'tour_id' => $tour_id,
            'day_number' => $day_number,
            'date' => $_POST['date'] ?? null,
            'title' => $title,
            'description' => $_POST['description'] ?? null,
            'activities' => !empty($activities_arr) ? json_encode($activities_arr, JSON_UNESCAPED_UNICODE) : null,
            'meals' => $_POST['meals'] ?? null,
            'accommodation' => $_POST['accommodation'] ?? null,
            'transport' => $_POST['transport'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->model->create($data);
        $_SESSION['success'] = "Thêm lịch trình thành công.";
        header("Location: " . BASE_URL . "tours/{$tour_id}/schedules");
        exit;
    }

    // Form edit
    public function edit($tour_id, $id)
    {
        $schedule = $this->model->find($id);
        if (!$schedule) {
            $_SESSION['errors'] = ["Lịch trình không tồn tại."];
            header("Location: " . BASE_URL . "tours/{$tour_id}/schedules");
            exit;
        }

        $activities_text = '';
        if (!empty($schedule->activities)) {
            $arr = json_decode($schedule->activities, true);
            if (is_array($arr)) $activities_text = implode("\n", $arr);
        }

        $this->render('tourSchedule.edit', [
            'tour_id' => $tour_id,
            'schedule' => $schedule,
            'activities_text' => $activities_text
        ]);
    }

    // Update
    public function update($tour_id, $id)
    {
        $schedule = $this->model->find($id);
        if (!$schedule) {
            $_SESSION['errors'] = ["Lịch trình không tồn tại."];
            header("Location: " . BASE_URL . "tours/{$tour_id}/schedules");
            exit;
        }

        $errors = [];
        $day_number = isset($_POST['day_number']) ? intval($_POST['day_number']) : null;
        $title = trim($_POST['title'] ?? '');
        if (!$day_number) $errors[] = "Số thứ tự ngày (day_number) bắt buộc.";
        if ($title === '') $errors[] = "Tiêu đề (title) bắt buộc.";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: " . BASE_URL . "tours/{$tour_id}/schedules/{$id}/edit");
            exit;
        }

        $activities_raw = trim($_POST['activities'] ?? '');
        $activities_arr = $activities_raw !== '' ? preg_split('/\r\n|\r|\n/', $activities_raw) : [];

        $data = [
            'day_number' => $day_number,
            'date' => $_POST['date'] ?? null,
            'title' => $title,
            'description' => $_POST['description'] ?? null,
            'activities' => !empty($activities_arr) ? json_encode($activities_arr, JSON_UNESCAPED_UNICODE) : null,
            'meals' => $_POST['meals'] ?? null,
            'accommodation' => $_POST['accommodation'] ?? null,
            'transport' => $_POST['transport'] ?? null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->model->updateById($id, $data);
        $_SESSION['success'] = "Cập nhật lịch trình thành công.";
        header("Location: " . BASE_URL . "tours/{$tour_id}/schedules");
        exit;
    }

    // Delete
    public function delete($tour_id, $id)
    {
        $schedule = $this->model->find($id);
        if (!$schedule) {
            $_SESSION['errors'] = ["Lịch trình không tồn tại."];
            header("Location: " . BASE_URL . "tours/{$tour_id}/schedules");
            exit;
        }

        $this->model->deleteById($id);
        $_SESSION['success'] = "Xóa lịch trình thành công.";
        header("Location: " . BASE_URL . "tours/{$tour_id}/schedules");
        exit;
    }

    // Show 1 ngày chi tiết
    public function show($tour_id, $id)
    {
        $schedule = $this->model->find($id);
        if (!$schedule) {
            $_SESSION['errors'] = ["Lịch trình không tồn tại."];
            header("Location: " . BASE_URL . "tours/{$tour_id}/schedules");
            exit;
        }
        $this->render('tourSchedule.show', [
            'schedule' => $schedule,
            'tour_id' => $tour_id
        ]);
    }
}
