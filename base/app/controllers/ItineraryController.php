<?php

namespace App\Controllers;

use App\Models\ItineraryModel;
use App\Models\TourModel;

class ItineraryController extends BaseController
{
    protected $itinerary;

    public function __construct()
    {
        $this->itinerary = new ItineraryModel();
    }

    // Danh sách itinerary
    public function getItinerary()
    {
        $itineraries = $this->itinerary->getAllItineraries();
        $this->render("admin.itinerary.listItinerary", ['itinerary' => $itineraries]);
    }

    // Form thêm itinerary
    public function createItinerary()
    {
        $tourModel = new TourModel();
        $tours = $tourModel->getAllTours();
        $this->render("admin.itinerary.addItinerary", ['tours' => $tours]);
    }

    // Xử lý thêm itinerary
    public function postItinerary()
    {
        $error = [];

        $tour_id     = $_POST['tour_id'] ?? '';
        $day_number  = $_POST['day_number'] ?? '';
        $title       = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        // validate
        if (empty($tour_id)) {
            $error['tour_id'] = "Tên tour không được để trống";
        }
        if (empty($day_number) || !is_numeric($day_number) || $day_number <= 0) {
            $error['day_number'] = "Số ngày phải là số nguyên dương";
        }
        if (empty($title)) {
            $error['title'] = "Tiêu đề không được để trống";
        }
        if (empty($description)) {
            $error['description'] = "Nội dung chi tiết không được để trống";
        }

        if (!empty($error)) {
            redirect('errors', $error, 'add-itinerary');
        } else {
            $check = $this->itinerary->addItinerary([
                'tour_id'     => $tour_id,
                'day_number'  => $day_number,
                'title'       => $title,
                'description' => $description,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);
            if ($check) {
                redirect('success', "Thêm thành công", 'list-itinerary');
            } else {
                redirect('errors', "Thêm thất bại, vui lòng thử lại", 'add-itinerary');
            }
        }
    }

    // Xóa itinerary
    public function deleteItinerary($id)
    {
        $check = $this->itinerary->deleteItinerary($id);
        if ($check) {
            redirect('success', "Xóa thành công", 'list-itinerary');
        } else {
            redirect('error', "Xóa thất bại", 'list-itinerary');
        }
    }

    // Chi tiết itinerary để sửa
    public function detailItinerary($id)
    {
        $detail = $this->itinerary->getItineraryById($id);
        $tourModel = new TourModel();
        $tours = $tourModel->getAllTours();
        return $this->render('admin.itinerary.editItinerary', ['detail' => $detail, 'tours' => $tours]);
    }

    // Xử lý sửa itinerary
    public function editItinerary($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            $tour_id     = $_POST['tour_id'] ?? '';
            $day_number  = $_POST['day_number'] ?? '';
            $title       = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';

            if (empty($tour_id)) {
                $error['tour_id'] = "Tên tour không được để trống";
            }
            if (empty($day_number) || !is_numeric($day_number) || $day_number <= 0) {
                $error['day_number'] = "Số ngày phải là số nguyên dương";
            }
            if (empty($title)) {
                $error['title'] = "Tiêu đề không được để trống";
            }
            if (empty($description)) {
                $error['description'] = "Nội dung chi tiết không được để trống";
            }

            $route = 'detail-itinerary/' . $id;
            if (!empty($error)) {
                redirect('errors', $error, $route);
            } else {
                $check = $this->itinerary->updateItinerary(
                    $id,
                    [
                        'tour_id'     => $tour_id,
                        'day_number'  => $day_number,
                        'title'       => $title,
                        'description' => $description,
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ]
                );
                if ($check) {
                    redirect('success', "Sửa thành công", 'list-itinerary');
                } else {
                    redirect('error', "Sửa thất bại", $route);
                }
            }
        }
    }
}