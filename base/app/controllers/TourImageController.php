<?php
namespace App\Controllers;

use App\Models\TourImageModel;
use App\Models\TourModel;

class TourImageController extends BaseController
{
    protected $tourImg;
    protected $tour;

    public function __construct()
    {
        $this->tourImg = new TourImageModel();
        $this->tour = new TourModel();
    }

    // Danh sách ảnh tour
    public function listImages()
    {
        $images = $this->tourImg->getAllImages();
        return $this->render('admin.tour_image.listImage', compact('images'));
    }

    // Danh sách ảnh theo ID tour
    public function listImagesByTour($id)
    {
        $images = $this->tourImg->getImagesByTourId($id);
        return $this->render('admin.tour_image.listImage', compact('images'));
    }

    // Form thêm ảnh
    public function createImage()
    {
        $tours = $this->tour->getAllTours();
        return $this->render('admin.tour_image.addImage', compact('tours'));
    }

    // Xử lý thêm ảnh
    public function postImage()
    {
        $error = [];

        // Validate dữ liệu
        if (empty($_POST['tour_id'])) {
            $error['tour_id'] = "Tour không được để trống";
        }

        // Xử lý ảnh
        $imagePath = null;
        if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['image_path']['tmp_name'];
            $fileName = time() . '_' . basename($_FILES['image_path']['name']);
            $targetDir = 'public/src/img/tours/';

            // Tạo thư mục nếu chưa tồn tại
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $imagePath = '/' . $targetPath;
            } else {
                $error['image_path'] = "Không thể tải lên ảnh";
            }
        } else {
            $error['image_path'] = "Vui lòng chọn ảnh";
        }

        if (count($error) > 0) {
            redirect('errors', $error, 'add-tour-image');
        } else {
            $check = $this->tourImg->addImage([
                'tour_id' => $_POST['tour_id'],
                'image_url' => $imagePath,
                'alt_text' => $_POST['alt_text'] ?? '',
                'is_thumbnail' => isset($_POST['is_thumbnail']) ? 1 : 0,
                'created_at' => date("Y-m-d H:i:s"),
            ]);

            if ($check) {
                redirect('success', "Thêm ảnh thành công", 'list-tour-images');
            } else {
                redirect('error', "Thêm ảnh thất bại", 'add-tour-image');
            }
        }
    }

    // Chi tiết ảnh để sửa
    public function detailImage($id)
    {
        $detail = $this->tourImg->getImageById($id);
        $tours = $this->tour->getAllTours();

        if (!$detail) {
            redirect('error', 'Ảnh không tồn tại', 'list-tour-images');
            return;
        }

        return $this->render('admin.tour_image.editImage', compact('detail', 'tours'));
    }

    // Xử lý sửa ảnh
    public function editImage($id)
    {
        if (!isset($_POST['btn-submit'])) {
            return;
        }

        $error = [];
        $detail = $this->tourImg->getImageById($id);

        if (!$detail) {
            redirect('error', "Ảnh không tồn tại", 'list-tour-images');
            return;
        }

        // Validate dữ liệu
        if (empty($_POST['tour_id'])) {
            $error['tour_id'] = "Tour không được để trống";
        }

        $route = 'detail-tour-image/' . $id;

        // Xử lý ảnh
        $imagePath = $_POST['old_image'] ?? $detail['image_url'];
        if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['image_path']['tmp_name'];
            $fileName = time() . '_' . basename($_FILES['image_path']['name']);
            $targetDir = 'public/src/img/tours/';

            // Tạo thư mục nếu chưa tồn tại
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $imagePath = '/' . $targetPath;
            } else {
                $error['image_path'] = "Không thể tải lên ảnh";
            }
        }

        if (count($error) > 0) {
            redirect('errors', $error, $route);
        } else {
            $check = $this->tourImg->updateImage($id, [
                'tour_id' => $_POST['tour_id'],
                'image_url' => $imagePath,
                'alt_text' => $_POST['alt_text'] ?? '',
                'is_thumbnail' => isset($_POST['is_thumbnail']) ? 1 : 0,
            ]);

            if ($check) {
                redirect('success', "Cập nhật ảnh thành công", 'list-tour-images');
            } else {
                redirect('error', "Cập nhật ảnh thất bại", $route);
            }
        }
    }

    // Xóa ảnh
    public function deleteImage($id)
    {
        $check = $this->tourImg->deleteImage($id);
        if ($check) {
            redirect('success', "Xóa ảnh thành công", 'list-tour-images');
        } else {
            redirect('error', "Xóa ảnh thất bại", 'list-tour-images');
        }
    }
}
?>