<?php
namespace App\Controllers;

use App\Models\TourGuideModel;

class TourGuideController extends BaseController
{
    protected $tourGuide;

    public function __construct()
    {
        $this->tourGuide = new TourGuideModel();
    }

    // ==============================
    // ADMIN SIDE
    // ==============================

    // Hiển thị danh sách tour guide
    public function listTourGuides()
    {
        $guides = $this->tourGuide->getAllGuides();
        $this->render("admin.tour_guide.listTourGuide", ['guides' => $guides]);
    }

    // Hiển thị form thêm tour guide
    public function createTourGuide()
    {
        $departureModel = new \App\Models\DepartureModel();
        $departures = $departureModel->getAllDepartures();

        $guidesModel = new \App\Models\GuidesModel();
        $guides = $guidesModel->getAllGuides();

        $this->render("admin.tour_guide.addTourGuide", [
            'departures' => $departures,
            'guides' => $guides
        ]);
    }

    // Xử lý thêm tour guide
    public function postTourGuide()
    {
        $error = [];

        if (empty($_POST['departure_id'])) {
            $error['departure_id'] = "Chuyến đi không được bỏ trống";
        }
        if (empty($_POST['guide_id'])) {
            $error['guide_id'] = "Hướng dẫn viên không được bỏ trống";
        }

        if (!empty($error)) {
            redirect('error', $error, "add-tour-guide");
        } else {
            // Check for overlapping assignment
            $overlapTour = $this->tourGuide->checkOverlappingAssignment($_POST['guide_id'], $_POST['departure_id']);
            if ($overlapTour) {
                redirect('error', "Hướng dẫn viên này đã có lịch trình khác ($overlapTour) trong khoảng thời gian này.", "add-tour-guide");
            }

            // JOIN GUIDE STATUS CHECK
            $guideModel = new \App\Models\GuidesModel();
            $guideInfo = $guideModel->getGuideById($_POST['guide_id']);
            if ($guideInfo && isset($guideInfo->status) && $guideInfo->status === 'busy') {
                redirect('error', "Hướng dẫn viên này đang bật trạng thái BẬN (Busy), không thể phân công.", "add-tour-guide");
            }

            $check = $this->tourGuide->addGuide([
                'departure_id' => $_POST['departure_id'],
                'guide_id'     => $_POST['guide_id'],
                'role'         => $_POST['role'] ?? 'assistant',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]);

            if ($check) {
                redirect('success', "Thêm tour guide thành công", 'list-tour-guide');
            } else {
                redirect('error', "Thêm tour guide thất bại", 'add-tour-guide');
            }
        }
    }

    // Hiển thị chi tiết tour guide để sửa
    public function detailTourGuide($id)
    {
        $detail = $this->tourGuide->getGuideById($id);

        $departureModel = new \App\Models\DepartureModel();
        $departures = $departureModel->getAllDepartures();

        $guidesModel = new \App\Models\GuidesModel();
        $guides = $guidesModel->getAllGuides();

        return $this->render('admin.tour_guide.editTourGuide', [
            'detail' => $detail,
            'departures' => $departures,
            'guides' => $guides
        ]);
    }

    // Xử lý sửa tour guide
    public function editTourGuide($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            if (empty($_POST['departure_id'])) {
                $error['departure_id'] = "Chuyến đi không được bỏ trống";
            }
            if (empty($_POST['guide_id'])) {
                $error['guide_id'] = "Hướng dẫn viên không được bỏ trống";
            }

            $route = 'detail-tour-guide/' . $id;
            if (!empty($error)) {
                redirect('error', $error, $route);
            } else {
                // Check for overlapping assignment (exclude current one)
                $overlapTour = $this->tourGuide->checkOverlappingAssignment($_POST['guide_id'], $_POST['departure_id'], $id);
                if ($overlapTour) {
                    redirect('error', "Hướng dẫn viên này đã có lịch trình khác ($overlapTour) trong khoảng thời gian này.", $route);
                }

                // JOIN GUIDE STATUS CHECK
                $guideModel = new \App\Models\GuidesModel();
                $guideInfo = $guideModel->getGuideById($_POST['guide_id']);
                if ($guideInfo && isset($guideInfo->status) && $guideInfo->status === 'busy') {
                    redirect('error', "Hướng dẫn viên này đang bật trạng thái BẬN (Busy), không thể phân công.", $route);
                }

                $check = $this->tourGuide->updateGuide($id, [
                    'departure_id' => $_POST['departure_id'],
                    'guide_id'     => $_POST['guide_id'],
                    'role'         => $_POST['role'] ?? 'assistant',
                    'updated_at'   => date('Y-m-d H:i:s')
                ]);

                if ($check) {
                    redirect('success', 'Sửa tour guide thành công', 'list-tour-guide');
                } else {
                    redirect('error', 'Sửa tour guide thất bại', $route);
                }
            }
        }
    }

    // Xóa tour guide
    public function deleteTourGuide($id)
    {
        $check = $this->tourGuide->deleteGuide($id);
        if ($check) {
            redirect('success', 'Xóa tour guide thành công', 'list-tour-guide');
        } else {
            redirect('error', 'Xóa tour guide thất bại', 'list-tour-guide');
        }
    }
}