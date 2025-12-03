<?php
namespace App\Controllers;

use App\Models\TourLogsModel;
use App\Models\DepartureModel;

class TourLogController extends BaseController
{
	public $logs;

	public function __construct()
	{
		$this->logs = new TourLogsModel();
	}

	// List all tour logs
	public function getLogs()
	{
		$all = $this->logs->getAllLogs();
		$this->render('tourlog.listLog', ['logs' => $all]);
	}

	// Show form to create a new log
	public function createLog()
	{
		$departureModel = new DepartureModel();
		$departures = $departureModel->getAllDepartures();
		$this->render('tourlog.addLog', ['departures' => $departures]);
	}

	// Handle POST to add a log
	public function postLog()
	{
		$error = [];

		$departure_id = $_POST['departure_id'] ?? '';
		$day_number = $_POST['day_number'] ?? '';
		$note = $_POST['note'] ?? '';

		if (empty($departure_id)) {
			$error['departure_id'] = "Vui lòng chọn đợt khởi hành";
		}
		if ($day_number === '' || !is_numeric($day_number)) {
			$error['day_number'] = "Số ngày (day number) không hợp lệ";
		}

		if (count($error) >= 1) {
			redirect('errors', $error, 'add-tourlog');
			return;
		}

		$data = [
			'departure_id' => $departure_id,
			'day_number' => $day_number,
			'note' => $note,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];

		$check = $this->logs->addLog($data);
		if ($check) {
			redirect('success', "Thêm thành công", 'list-tourlog');
		} else {
			redirect('errors', "Thêm thất bại, vui lòng thử lại", 'add-tourlog');
		}
	}

	// Delete a log
	public function deleteLog($id)
	{
		$check = $this->logs->deleteLog($id);
		if ($check) {
			redirect('success', "Xóa thành công", 'list-tourlog');
		}
	}

	// Show details/edit form
	public function detailLog($id)
	{
		$detail = $this->logs->getLogById($id);
		$departureModel = new DepartureModel();
		$departures = $departureModel->getAllDepartures();
		return $this->render('tourlog.editLog', ['detail' => $detail, 'departures' => $departures]);
	}

	// Handle edit POST
	public function editLog($id)
	{
		if (isset($_POST['btn-submit'])) {
			$error = [];

			if (empty($_POST['departure_id'])) {
				$error['departure_id'] = "Vui lòng chọn đợt khởi hành";
			}
			if ($_POST['day_number'] === '' || !is_numeric($_POST['day_number'])) {
				$error['day_number'] = "Số ngày (day number) không hợp lệ";
			}

			$route = 'detail-tourlog/' . $id;
			if (count($error) >= 1) {
				redirect('errors', $error, $route);
				return;
			}

			$check = $this->logs->updateLog($id, [
				'departure_id' => $_POST['departure_id'],
				'day_number' => $_POST['day_number'],
				'note' => $_POST['note'] ?? '',
				'updated_at' => date('Y-m-d H:i:s'),
			]);

			if ($check) {
				redirect('success', "Sửa thành công", 'list-tourlog');
			}
		}
	}

}
