<?php
namespace App\Controllers;
use App\Models\TourModel;

class TourController extends BaseController
{
    public $tour;
    public function __construct()
    {
        $this->tour = new TourModel();
    }
    public function getTours()
    {
        $tours = $this->tour->getAllTours();
        $this->render("tour.listTour", ['tours' => $tours]);
    }
    public function CreateTour()
    {
        $this->render("tour.addTour");
    }
    public function postTour()
    {
        $error = [];
        if (empty($_POST['name'])) {
            $error['name'] = "Tên tour không được để trống";
        }
        if (empty($_POST['description'])) {
            $error['description'] = "mo ta không được để trống";
        }
        if (empty($_POST['price'])) {
            $error['price'] = "Giá không được để trống";
        }
        if (empty($_POST['days'])) {
            $error['days'] = "so ngay không được để trống";
        }
        if (!isset($_POST['status']) || $_POST['status'] === "") {

            $error['status'] = "trang thai không được để trống";
        }
        $status = $_POST['status'] ?? 1;

        if (count($error) >= 1) {
            redirect('errors', $error, 'add-tour');
        } else {

            $check = $this->tour->addTour(
                [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'days' => $_POST['days'],
                    'status' => $status,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]
            );
            if ($check) {
                redirect('success', "Thêm thành công", 'list-tours');
            }

        }

    }
    public function deleteTour($id)
    {
        $check = $this->tour->deleteTour($id);
        if ($check) {
            redirect('success', "Xóa thành công", 'list-tours');
        }
    }

    public function detailTour($id)
    {
        $detail = $this->tour->getTourById($id);
        return $this->render('tour.editTour', compact('detail'));
    }
    public function editTour($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];
            // echo 123;
            // validate rỗng
            if (empty($_POST['name'])) {
                $error['name'] = "Tên tour không được để trống";
            }
            if (empty($_POST['description'])) {
                $error['description'] = "mo ta không được để trống";
            }
            if (empty($_POST['price'])) {
                $error['price'] = "Giá không được để trống";
            }
            if (empty($_POST['days'])) {
                $error['days'] = "so ngay không được để trống";
            }
            $status = $_POST['status'] ?? 1;
            $route = 'detail-tour/' . $id;
            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            } else {
                $check = $this->tour->updateTour(
                    $id,
                    [
                        'name' => $_POST['name'],
                        'description' => $_POST['description'],
                        'price' => $_POST['price'],
                        'days' => $_POST['days'],
                        'status' => $status,
                        'updated_at' => date("Y-m-d H:i:s"),
                    ]
                );
                if ($check) {
                    redirect('success', "Sửa thành công", 'list-tours');
                }

            }

        }
    }

}