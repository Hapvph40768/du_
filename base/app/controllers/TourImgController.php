<?php
namespace App\Controllers;

use App\Models\TourImgModel;
use App\Models\TourModel;

/**
 * Class TourImgController
 * Manage tour images (CRUD + upload)
 */
class TourImgController extends BaseController
{
    public $imgModel;

    public function __construct()
    {
        $this->imgModel = new TourImgModel();
    }

    // List images
    public function getImages()
    {
        $images = $this->imgModel->getAllImages();
        $this->render('tour.listTourImg', ['images' => $images]);
    }

    // Form to add image
    public function createImage()
    {
        $tourModel = new TourModel();
        $tours = $tourModel->getAllTours();
        $this->render('tour.addTourImg', ['tours' => $tours]);
    }

    // Save new image
    public function postImage()
    {
        $error = [];

        $tour_id = $_POST['tour_id'] ?? '';
        $is_thumbnail = isset($_POST['is_thumbnail']) ? 1 : 0;
        $image_path = $_POST['image_path'] ?? '';

        if (empty($tour_id)) {
            $error['tour_id'] = 'Vui lòng chọn tour';
        }

        // Handle uploaded file
        if (!empty($_FILES['image']['tmp_name'])) {
            $uploadsDir = './public/uploads/tour_images/';
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }
            $name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target = $uploadsDir . $name;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $error['image'] = 'Không thể upload file ảnh';
            } else {
                $image_path = 'public/uploads/tour_images/' . $name;
            }
        }

        if (empty($image_path)) {
            $error['image_path'] = 'Ảnh không được để trống';
        }

        if (count($error) >= 1) {
            redirect('errors', $error, 'add-tour-img');
        }

        $check = $this->imgModel->addImage([
            'tour_id' => $tour_id,
            'image_path' => $image_path,
            'is_thumbnail' => $is_thumbnail,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($check) {
            redirect('success', 'Thêm ảnh thành công', 'list-tour-img');
        } else {
            redirect('errors', 'Thêm ảnh thất bại', 'add-tour-img');
        }
    }

    public function deleteImage($id)
    {
        $check = $this->imgModel->deleteImage($id);
        if ($check) {
            redirect('success', 'Xóa thành công', 'list-tour-img');
        }
    }

    public function detailImage($id)
    {
        $detail = $this->imgModel->getImageById($id);
        $tourModel = new TourModel();
        $tours = $tourModel->getAllTours();
        return $this->render('tour.editTourImg', ['detail' => $detail, 'tours' => $tours]);
    }

    public function editImage($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            $tour_id = $_POST['tour_id'] ?? '';
            $is_thumbnail = isset($_POST['is_thumbnail']) ? 1 : 0;
            $image_path = $_POST['image_path'] ?? '';

            if (empty($tour_id)) {
                $error['tour_id'] = 'Vui lòng chọn tour';
            }

            // Handle new uploaded file if present
            if (!empty($_FILES['image']['tmp_name'])) {
                $uploadsDir = './public/uploads/tour_images/';
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0755, true);
                }
                $name = uniqid() . '_' . basename($_FILES['image']['name']);
                $target = $uploadsDir . $name;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $error['image'] = 'Không thể upload file ảnh';
                } else {
                    $image_path = 'public/uploads/tour_images/' . $name;
                }
            }

            $route = 'detail-tour-img/' . $id;
            if (empty($image_path)) {
                $error['image_path'] = 'Ảnh không được để trống';
            }

            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            }

            $check = $this->imgModel->updateImage($id, [
                'tour_id' => $tour_id,
                'image_path' => $image_path,
                'is_thumbnail' => $is_thumbnail,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($check) {
                redirect('success', 'Sửa ảnh thành công', 'list-tour-img');
            } else {
                redirect('errors', 'Sửa ảnh thất bại', $route);
            }
        }
    }

}

?>
