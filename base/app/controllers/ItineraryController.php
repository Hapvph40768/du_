<?php
namespace App\Controllers;
use App\Models\ItineraryModel;
use App\Models\TourModel;
class ItineraryController extends BaseController
{
    public $itinerary;
    public function __construct()
    {
        $this->itinerary = new ItineraryModel();
    }
    public function getItinerary()
    {
        $itineraries = $this->itinerary->getAllItinerary();
        $this->render("itinerary.listItinerary", ['itinerary' => $itineraries]);
    }
    public function createItinerary()
    {
        $tourModel = new TourModel();
        $tours = $tourModel->getListTours();
        $this->render("itinerary.addItinerary", ['tours' => $tours]);
    }
    public function postItinerary()
    {
        $error = [];

        // validate
        $tour_id = $_POST['tour_id'] ?? '';
        $day_number = $_POST['day_number'] ?? '';
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        if (empty($_POST['tour_id'])) {
            $error['tour_id'] = "Tên tour không được để trống";
        }
        if (empty($_POST['day_number'])) {
            $error['day_number'] = "So ngay không được để trống";
        }
        if (empty($_POST['title'])) {
            $error['title'] = "Tieu de không được để trống";
        }
        if (empty($_POST['content'])) {
            $error['content'] = "Noi dung chi tiet không được để trống";
        }
        if (count($error) >= 1) {
            redirect('errors', $error, 'add-itinerary');
        } else {

            $check = $this->itinerary->addItinerary([
                'tour_id' => $tour_id,
                'day_number' => $day_number,
                'title' => $title,
                'content' => $content,
            ]);
            if ($check) {
                redirect('success', "Thêm thành công", 'list-itinerary');
            } else {
                redirect('errors', "Thêm thất bại, vui lòng thử lại", 'add-itinerary');
            }

        }

    }
    public function deleteItinerary($id)
    {
        $check = $this->itinerary->deleteItinerary($id);
        if ($check) {
            redirect('success', "Xóa thành công", 'list-itinerary');
        }
    }
    public function detailItinerary($id)
    {
        $detail = $this->itinerary->getItineraryById($id);
        $tour = new TourModel();
        $tours = $tour->getListTours();
        return $this->render('itinerary.editItinerary', ['detail' => $detail, 'tours' => $tours]);
    }
    public function editItinerary($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];
            // validate rỗng
            if (empty($_POST['tour_id'])) {
                $error['tour_id'] = "Tên tour không được để trống";
            }
            if (empty($_POST['day_number'])) {
                $error['day_number'] = "So ngay không được để trống";
            }
            if (empty($_POST['title'])) {
                $error['title'] = "Tieu de không được để trống";
            }
            if (empty($_POST['content'])) {
                $error['content'] = "Noi dung chi tiet không được để trống";
            }
            $route = 'detail-itinerary/' . $id;
            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            } else {
                $check = $this->itinerary->updateItinerary(
                    $id,
                    [
                        'tour_id' => $_POST['tour_id'],
                        'day_number' => $_POST['day_number'],
                        'title' => $_POST['title'],
                        'content' => $_POST['content'],
                    ]
                );
                if ($check) {
                    redirect('success', "Sửa thành công", 'list-itinerary');
                }
            }
        }
    }
}