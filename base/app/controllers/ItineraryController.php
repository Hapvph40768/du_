<?php

namespace App\Controllers;

use App\Models\ItineraryModel;
use App\Models\TourModel;
use App\Models\DepartureModel;

class ItineraryController extends BaseController
{
    protected $itinerary;
    protected $departure;

    public function __construct()
    {
        $this->itinerary  = new ItineraryModel();
        $this->departure  = new DepartureModel();
    }

    // Danh sách tất cả itinerary
    public function getItinerary()
    {
        $itinerary = $this->itinerary->getAllItineraries();
        $this->render("admin.itinerary.listItinerary", ['itinerary' => $itinerary]);
    }

    // Danh sách itinerary theo departure_id
    public function detailItinerariesByDeparture($departure_id)
    {
        $itineraries = $this->itinerary->getItinerariesByDeparture($departure_id);
        $departure   = $this->departure->getDepartureById($departure_id);

        // If called via AJAX, return only partial content (no layout)
        if (isset($_GET['ajax']) && $_GET['ajax']) {
            // render partial table only
            $this->render('admin.itinerary._partialItineraries', [
                'itineraries' => $itineraries,
                'departure'   => $departure
            ]);
            return;
        }

        $this->render('admin.itinerary.listItineraryId', [
            'itineraries' => $itineraries,
            'departure'   => $departure
        ]);
    }

    // Form thêm itinerary
    public function createItinerary()
    {
        $tourModel   = new TourModel();
        $tours       = $tourModel->getAllTours();
        $departures  = $this->departure->getAllDepartures();

        $this->render("admin.itinerary.addItinerary", [
            'tours'      => $tours,
            'departures' => $departures
        ]);
    }

    // Xử lý thêm itinerary
    public function postItinerary()
    {
        $tour_id      = $_POST['tour_id'] ?? '';
        $departure_id = $_POST['departure_id'] ?? '';
        $day_number   = $_POST['day_number'] ?? '';
        $title        = $_POST['title'] ?? '';
        $description  = $_POST['description'] ?? '';
        $errors       = [];

        // validate
        if (!$tour_id) $errors['tour_id'] = "Tên tour không được để trống";
        if (!$departure_id) $errors['departure_id'] = "Bạn phải chọn lịch khởi hành";
        if (!$day_number || !is_numeric($day_number) || $day_number <= 0) $errors['day_number'] = "Số ngày phải là số nguyên dương";
        if (!$title) $errors['title'] = "Tiêu đề không được để trống";
        if (!$description) $errors['description'] = "Nội dung chi tiết không được để trống";

        if ($errors) {
            redirect('errors', $errors, 'add-itinerary');
        } else {
            $check = $this->itinerary->addItinerary([
                'tour_id'      => $tour_id,
                'departure_id' => $departure_id,
                'day_number'   => $day_number,
                'title'        => $title,
                'description'  => $description,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);

            if ($check) {
                // Redirect về list theo departure
                redirect('success', "Thêm thành công", 'list-itinerary/' . $departure_id);
            } else {
                redirect('errors', "Thêm thất bại", 'add-itinerary');
            }
        }
    }

    // Chi tiết để sửa
    public function detailItinerary($id)
    {
        $detail      = $this->itinerary->getItineraryById($id);
        $tourModel   = new TourModel();
        $tours       = $tourModel->getAllTours();
        $departures  = $this->departure->getAllDepartures();

        $this->render('admin.itinerary.editItinerary', [
            'detail'     => $detail,
            'tours'      => $tours,
            'departures' => $departures
        ]);
    }

    // Xử lý sửa
    public function editItinerary($id)
    {
        if (isset($_POST['btn-submit'])) {
            $tour_id      = $_POST['tour_id'] ?? '';
            $departure_id = $_POST['departure_id'] ?? '';
            $day_number   = $_POST['day_number'] ?? '';
            $title        = $_POST['title'] ?? '';
            $description  = $_POST['description'] ?? '';
            $errors       = [];

            // validate
            if (!$tour_id) $errors['tour_id'] = "Tên tour không được để trống";
            if (!$departure_id) $errors['departure_id'] = "Bạn phải chọn lịch khởi hành";
            if (!$day_number || !is_numeric($day_number) || $day_number <= 0) $errors['day_number'] = "Số ngày phải là số nguyên dương";
            if (!$title) $errors['title'] = "Tiêu đề không được để trống";
            if (!$description) $errors['description'] = "Nội dung chi tiết không được để trống";

            $route = 'detail-itinerary/' . $id;

            if ($errors) {
                redirect('errors', $errors, $route);
            } else {
                $check = $this->itinerary->updateItinerary($id, [
                    'tour_id'      => $tour_id,
                    'departure_id' => $departure_id,
                    'day_number'   => $day_number,
                    'title'        => $title,
                    'description'  => $description,
                    'updated_at'   => date('Y-m-d H:i:s'),
                ]);

                if ($check) {
                    redirect('success', "Sửa thành công", 'list-itinerary/' . $departure_id);
                } else {
                    redirect('error', "Sửa thất bại", $route);
                }
            }
        }
    }

    // Xóa
    public function deleteItinerary($id)
    {
        $itinerary = $this->itinerary->getItineraryById($id);
        $departure_id = $itinerary->departure_id ?? 0;

        $check = $this->itinerary->deleteItinerary($id);

        if ($check) {
            redirect('success', "Xóa thành công", 'list-itinerary/' . $departure_id);
        } else {
            redirect('error', "Xóa thất bại", 'list-itinerary/' . $departure_id);
        }
    }
}
