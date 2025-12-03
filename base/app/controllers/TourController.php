<?php
namespace App\Controllers;
use App\Models\TourModel;

class TourController extends BaseController
{
    protected $tour;

    public function __construct()
    {
        $this->tour = new TourModel();
    }

    // Danh sách tour
    public function getTours()
    {
        $tours = $this->tour->getAllTours();
        $this->render("admin.tour.listTour", ['tours' => $tours]);
    }

    // Form thêm tour
    public function createTour()
    {
        $this->render("admin.tour.addTour");
    }

    // Xử lý thêm tour
    public function postTour()
    {
        $error = [];

        if (empty($_POST['name'])) {
            $error['name'] = "Tên tour không được để trống";
        }
        if (empty($_POST['description'])) {
            $error['description'] = "Mô tả không được để trống";
        }
        if (empty($_POST['price'])) {
            $error['price'] = "Giá không được để trống";
        }
        if (empty($_POST['days'])) {
            $error['days'] = "Số ngày không được để trống";
        }
        if (!isset($_POST['status']) || $_POST['status'] === "") {
            $error['status'] = "Trạng thái không được để trống";
        } elseif (!in_array($_POST['status'], ['active','inactive'])) {
            $error['status'] = "Trạng thái không hợp lệ";
        }

        if (count($error) > 0) {
            redirect('errors', $error, 'add-tour');
        } else {
            $check = $this->tour->addTour([
                'name'          => $_POST['name'],
                'slug'          => $_POST['slug'] ?? null,
                'description'   => $_POST['description'],
                'price'         => $_POST['price'],
                'days'          => $_POST['days'],
                'start_location'=> $_POST['start_location'] ?? null,
                'destination'   => $_POST['destination'] ?? null,
                'thumbnail'     => $_POST['thumbnail'] ?? null,
                'status'        => $_POST['status'],
                'category'      => $_POST['category'] ?? null,
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s"),
            ]);
            if ($check) {
                redirect('success', "Thêm thành công", 'list-tours');
            } else {
                redirect('error', "Thêm thất bại", 'add-tour');
            }
        }
    }

    // Xóa tour
    public function deleteTour($id)
    {
        $check = $this->tour->deleteTour($id);
        if ($check) {
            redirect('success', "Xóa thành công", 'list-tours');
        } else {
            redirect('error', "Xóa thất bại", 'list-tours');
        }
    }

    // Chi tiết tour để sửa
    public function detailTour($id)
    {
        $detail = $this->tour->getTourById($id);
        return $this->render('admin.tour.editTour', compact('detail'));
    }

    // Xử lý sửa tour
    public function editTour($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            if (empty($_POST['name'])) {
                $error['name'] = "Tên tour không được để trống";
            }
            if (empty($_POST['description'])) {
                $error['description'] = "Mô tả không được để trống";
            }
            if (empty($_POST['price'])) {
                $error['price'] = "Giá không được để trống";
            }
            if (empty($_POST['days'])) {
                $error['days'] = "Số ngày không được để trống";
            }
            if (!isset($_POST['status']) || $_POST['status'] === "") {
                $error['status'] = "Trạng thái không được để trống";
            } elseif (!in_array($_POST['status'], ['active','inactive'])) {
                $error['status'] = "Trạng thái không hợp lệ";
            }

            $route = 'detail-tour/' . $id;

            if (count($error) > 0) {
                redirect('errors', $error, $route);
            } else {
                $check = $this->tour->updateTour($id, [
                    'name'          => $_POST['name'],
                    'slug'          => $_POST['slug'] ?? null,
                    'description'   => $_POST['description'],
                    'price'         => $_POST['price'],
                    'days'          => $_POST['days'],
                    'start_location'=> $_POST['start_location'] ?? null,
                    'destination'   => $_POST['destination'] ?? null,
                    'thumbnail'     => $_POST['thumbnail'] ?? null,
                    'status'        => $_POST['status'],
                    'category'      => $_POST['category'] ?? null,
                    'updated_at'    => date("Y-m-d H:i:s"),
                ]);
                if ($check) {
                    redirect('success', "Sửa thành công", 'list-tours');
                } else {
                    redirect('error', "Sửa thất bại", $route);
                }
            }
        }
    }
}