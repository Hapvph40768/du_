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
        $tours = $tourModel->getListTours();
        $this->render("departure.addDeparture", ['tours' => $tours]);
    }
    public function postDeparture()
    {
        $error = [];

        // validate
        $tour_id = $_POST['tour_id'] ?? '';
        $date_start = $_POST['date_start'] ?? '';
        $date_end = $_POST['date_end'] ?? '';
        $seats_total = $_POST['seats_total'] ?? '';
        $seats_remaining = $_POST['seats_remaining'] ?? '';
        if (empty($_POST['tour_id'])) {
            $error['tour_id'] = "Tên tour không được để trống";
        }
        if (empty($_POST['date_start'])) {
            $error['date_start'] = "Ngày khởi hành không được để trống";
        }
        if (empty($_POST['date_end'])) {
            $error['date_end'] = "Ngày kết thúc không được để trống";
        }
        if (!empty($_POST['date_start']) && !empty($_POST['date_end']) && $date_start > $date_end) {
            $error['date_invalid'] = "Ngày kết thúc phải sau ngày khởi hành";
        }
        if (empty($_POST['seats_total']) || !is_numeric($seats_total)) {
            $error['seats_total'] = "Tổng số chỗ không được để trống";
        }
        if (empty($_POST['seats_remaining']) || !is_numeric($seats_remaining)) {
            $error['seats_remaining'] = "Số chỗ còn lại không được để trống";
        }
        if ($seats_remaining > $seats_total)
            $error['seats_remaining'] = "Số chỗ còn lại không được lớn hơn tổng số chỗ";
        if (count($error) >= 1) {
            redirect('errors', $error, 'add-departure');
        } else {

            $check = $this->departure->addDeparture([
                'tour_id' => $tour_id,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'seats_total' => $seats_total,
                'seats_remaining' => $seats_remaining,
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
        $tours = $tour->getListTours();
        return $this->render('departure.editDeparture', ['detail' => $detail, 'tours' => $tours]);
    }
    public function editDeparture($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];
            // validate rỗng
            if(empty($_POST['tour_id'])){
                $error['tour_id'] = "Tên tour không được để trống";
            }
            if(empty($_POST['date_start'])){
                $error['date_start'] = "Ngày khởi hành không được để trống";
            }
            if(empty($_POST['date_end'])){
                $error['date_end'] = "Ngày kết thúc không được để trống";
            }
            if(empty($_POST['seats_total'])){
                $error['seats_total'] = "Tổng số chỗ không được để trống";
            }
            if(empty($_POST['seats_remaining'])){
                $error['seats_remaining'] = "Số chỗ còn lại không được để trống";
            }
            $route = 'detail-departure/'.$id;
            if(count($error) >=1 ){
                redirect('errors',  $error, $route);
            }else{
                $check = $this->departure->updateDeparture(
                    $id,
                      [
                        'tour_id' => $_POST['tour_id'],
                        'date_start' => $_POST['date_start'],
                        'date_end' => $_POST['date_end'],
                        'seats_total' => $_POST['seats_total'],
                        'seats_remaining' => $_POST['seats_remaining'],
                    ]
                    );
                    if($check){
                        redirect('success',  "Sửa thành công", 'list-departure');
                    }
            }
        }
    }
}