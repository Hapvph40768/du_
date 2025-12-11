<?php

namespace App\Controllers;

use App\Models\DepartureModel;
use App\Models\TourModel;

class DepartureController extends BaseController
{
    protected $departure;

    public function __construct()
    {
        $this->departure = new DepartureModel();
    }

    // Danh sách departures
    public function getDepartures()
    {
        $departures = $this->departure->getAllDepartures();
        $this->render("admin.departure.listDeparture", ['departures' => $departures]);
    }

    // Form thêm departure
    public function createDeparture()
    {
        $tourModel = new TourModel();
        $tours = $tourModel->getAllTours();
        $this->render("admin.departure.addDeparture", ['tours' => $tours]);
    }

    // Xử lý thêm departure
    public function postDeparture()
    {
        $error = [];

        $tour_id     = $_POST['tour_id'] ?? '';
        $start_date  = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
        $end_date    = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
        $start_time  = !empty($_POST['start_time']) ? $_POST['start_time'] : null;
        $total_seats = $_POST['total_seats'] ?? '';   // dùng total_seats
        $status      = $_POST['status'] ?? 'open';

        // validate
        if (empty($tour_id)) {
            $error['tour_id'] = "Tên tour không được để trống";
        }
        // Dates are optional now
        
        if (empty($total_seats) || !is_numeric($total_seats) || $total_seats <= 0) {
            $error['total_seats'] = "Số ghế không hợp lệ";
        }
        if (!in_array($status, ['open', 'closed', 'full'])) {
            $error['status'] = "Trạng thái không hợp lệ";
        }

        if (count($error) > 0) {
            redirect('errors', $error, 'add-departure');
        } else {
            $check = $this->departure->addDeparture([
                'tour_id'         => $tour_id,
                'start_date'      => $start_date,
                'end_date'        => $end_date,
                'start_time'      => $start_time,
                'total_seats'     => $total_seats,
                'remaining_seats' => $total_seats, // khi tạo mới remaining = total
                'status'          => $status,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
            if ($check) {
                redirect('success', "Thêm thành công", 'list-departure');
            } else {
                redirect('errors', "Thêm thất bại, vui lòng thử lại", 'add-departure');
            }
        }
    }

    // Xóa departure
    public function deleteDeparture($id)
    {
        $check = $this->departure->deleteDeparture($id);
        if ($check) {
            redirect('success', "Xóa thành công", 'list-departure');
        } else {
            redirect('error', "Xóa thất bại", 'list-departure');
        }
    }

    // AJAX Detail for Modal
    public function ajaxDetailDeparture($id)
    {
        $departureModel = new DepartureModel();
        $itineraryModel = new \App\Models\ItineraryModel();

        $detail      = $departureModel->getDepartureById($id);
        $itineraries = $itineraryModel->getItinerariesByDeparture($id);

        $this->render('admin.departure._partialDetail', [
            'departure'   => $detail,
            'itineraries' => $itineraries
        ]);
    }

    // Chi tiết departure để sửa
    public function detailDeparture($id)
    {
        $detail = $this->departure->getDepartureById($id);
        $tour = new TourModel();
        $tours = $tour->getAllTours();
        return $this->render('admin.departure.editDeparture', ['detail' => $detail, 'tours' => $tours]);
    }

    // Xử lý sửa departure
    public function editDeparture($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            $tour_id     = $_POST['tour_id'] ?? '';
            $start_date  = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
            $end_date    = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
            $start_time  = !empty($_POST['start_time']) ? $_POST['start_time'] : null;
            $total_seats = $_POST['total_seats'] ?? '';   // dùng total_seats
            $status      = $_POST['status'] ?? 'open';

            if (empty($tour_id)) {
                $error['tour_id'] = "Tên tour không được để trống";
            }
            // Dates are optional now
            
            if (empty($total_seats) || !is_numeric($total_seats) || $total_seats <= 0) {
                $error['total_seats'] = "Số ghế không hợp lệ";
            }
            if (!in_array($status, ['open', 'closed', 'full'])) {
                $error['status'] = "Trạng thái không hợp lệ";
            }

            $route = 'detail-departure/' . $id;
            $detail = $this->departure->getDepartureById($id);

            // Block edit if closed, UNLESS status is being changed
            if ($detail && $detail->status == 'closed' && $status == 'closed') {
                redirect('error', "Lịch khởi hành này đã đóng. Vui lòng mở lại trạng thái trước khi sửa.", $route);
                return;
            }

            $bookedSeats = $detail->seats_booked;

            // kiểm tra tổng ghế mới không nhỏ hơn số ghế đã đặt
            if (is_numeric($total_seats) && $total_seats < $bookedSeats) {
                $error['total_seats'] = "Tổng số ghế không được nhỏ hơn số ghế đã đặt ($bookedSeats).";
            }

            if (count($error) > 0) {
                redirect('errors', $error, $route);
            } else {
                $newRemaining = max(0, $total_seats - $bookedSeats);

                $check = $this->departure->updateDeparture($id, [
                    'tour_id'         => $tour_id,
                    'start_date'      => $start_date,
                    'end_date'        => $end_date,
                    'start_time'      => $start_time,
                    'total_seats'     => $total_seats,
                    'remaining_seats' => $newRemaining,
                    'status'          => $status,
                    'updated_at'      => date('Y-m-d H:i:s'),
                ]);
                if ($check) {
                    redirect('success', "Sửa thành công", 'list-departure');
                } else {
                    redirect('error', "Sửa thất bại", $route);
                }
            }
        }
    }
}