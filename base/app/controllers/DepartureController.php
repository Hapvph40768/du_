<?php
namespace App\Controllers;
use App\Models\DepartureModel;
use App\Models\TourModel;

class DepartureController extends BaseController
{
    public $departure;
    public function __construct()
    {
        $this->departure = new DepartureModel();
    }
    public function getDepartures()
    {
        $departures = $this->departure->getAllDepartures();
        $this->render("departure.listDeparture", ['departures' => $departures]);
    }
    public function createDeparture()
    {
        $tourModel = new TourModel();
        $tours = $tourModel->getAllTours();
        $this->render("departure.addDeparture", ['tours' => $tours]);
    }
    public function postDeparture()
    {
        $error = [];

        // validate
        $tour_id = $_POST['tour_id'] ?? '';
        $depart_date = $_POST['depart_date'] ?? '';
        $seats_total = $_POST['seats_total'] ?? '';
        $seats_remaining = $_POST['seats_remaining'] ?? '';
        if (empty($_POST['tour_id'])) {
            $error['tour_id'] = "Tên tour không được để trống";
        }
        if (empty($_POST['depart_date'])) {
            $error['depart_date'] = "Ngày khởi hành không được để trống";
        }
        if (empty($_POST['seats_total']) || !is_numeric($seats_total)) {
            $error['seats_total'] = "Tổng số chỗ không được để trống";
        }
        // seats_booked can be zero
        $seats_booked = $_POST['seats_booked'] ?? 0;
        if ($seats_booked === '' || !is_numeric($seats_booked)) {
            $error['seats_booked'] = "Số chỗ đã đặt phải là số";
        }
        if ($seats_booked > $seats_total) {
            $error['seats_booked'] = "Số chỗ đã đặt không được lớn hơn tổng số chỗ";
        }
        if (count($error) >= 1) {
            redirect('errors', $error, 'add-departure');
        } else {

            $check = $this->departure->addDeparture([
                'tour_id' => $tour_id,
                'depart_date' => $depart_date,
                'seats_total' => $seats_total,
                'seats_booked' => $seats_booked,
                'note' => $_POST['note'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if ($check) {
                redirect('success', "Thêm thành công", 'list-departure');
            } else {
                redirect('errors', "Thêm thất bại, vui lòng thử lại", 'add-departure');
            }

        }

    }
    public function deleteDeparture($id)
    {
        $check = $this->departure->deleteDeparture($id);
        if ($check) {
            redirect('success', "Xóa thành công", 'list-departure');
        }
    }
    public function detailDeparture($id)
    {
        $detail = $this->departure->getDepartureById($id);
        $tour = new TourModel();
        $tours = $tour->getAllTours();
        return $this->render('departure.editDeparture', ['detail' => $detail, 'tours' => $tours]);
    }
    public function editDeparture($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];
            // validate rỗng
            if (empty($_POST['tour_id'])) {
                $error['tour_id'] = "Tên tour không được để trống";
            }
            if (empty($_POST['depart_date'])) {
                $error['depart_date'] = "Ngày khởi hành không được để trống";
            }
            if (empty($_POST['seats_total'])) {
                $error['seats_total'] = "Tổng số chỗ không được để trống";
            }
            if (empty($_POST['seats_remaining'])) {
                $error['seats_remaining'] = "Số chỗ còn lại không được để trống";
            }
            $route = 'detail-departure/' . $id;
            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            } else {
                $check = $this->departure->updateDeparture(
                    $id,
                    [
                        'tour_id' => $_POST['tour_id'],
                        'depart_date' => $_POST['depart_date'],
                        'seats_total' => $_POST['seats_total'],
                        'seats_booked' => $_POST['seats_booked'] ?? 0,
                        'note' => $_POST['note'] ?? '',
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
                if ($check) {
                    redirect('success', "Sửa thành công", 'list-departure');
                }
            }
        }
    }
}