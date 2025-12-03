<?php
namespace App\Controllers;

use App\Models\TourImgModel;
use App\Models\TourModel;

class TourImgController extends BaseController
{
	public $imgModel;

	public function __construct()
	{
		$this->imgModel = new TourImgModel();
	}

	// list images
	public function getImages()
	{
		$images = $this->imgModel->getAllImages();
		$this->render('tourimg.listImg', ['images' => $images]);
	}

	// show add form
	public function createImage()
	{
		$tourModel = new TourModel();
		$tours = $tourModel->getAllTours();
		$this->render('tourimg.addImg', ['tours' => $tours]);
	}

	// handle add POST (with file upload)
	public function postImage()
	{
		$error = [];
		$tour_id = $_POST['tour_id'] ?? '';

		if (empty($tour_id)) {
			$error['tour_id'] = 'Vui lòng chọn tour';
		}

		// check file
		if (!isset($_FILES['image']) || empty($_FILES['image']['name'])) {
			$error['image'] = 'Vui lòng chọn ảnh để tải lên';
		}

		if (count($error) >= 1) {
			redirect('errors', $error, 'add-tourimg');
			return;
		}

		$uploadDir = __DIR__ . '/../../public/uploads/tour_images';
		if (!file_exists($uploadDir)) {
			mkdir($uploadDir, 0755, true);
		}

		$file = $_FILES['image'];
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		$allowed = ['jpg','jpeg','png','gif'];
		if (!in_array(strtolower($ext), $allowed)) {
			redirect('errors', ['image' => 'Chỉ cho phép ảnh JPG/PNG/GIF'], 'add-tourimg');
			return;
		}

		$filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file['name']);
		$destPath = $uploadDir . '/' . $filename;

		if (!move_uploaded_file($file['tmp_name'], $destPath)) {
			redirect('errors', ['image' => 'Không thể lưu file'], 'add-tourimg');
			return;
		}

		// store path relative to BASE_URL (use public/uploads/...)
		$imagePath = 'public/uploads/tour_images/' . $filename;

		$data = [
			'tour_id' => $tour_id,
			'image_path' => $imagePath,
			'is_thumbnail' => isset($_POST['is_thumbnail']) ? 1 : 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		$check = $this->imgModel->addImage($data);
		if ($check) {
			redirect('success', 'Thêm ảnh thành công', 'list-tourimg');
		} else {
			redirect('errors', 'Thêm thất bại', 'add-tourimg');
		}
	}

	// delete image and remove file
	public function deleteImage($id)
	{
		$detail = $this->imgModel->getImageById($id);
		if ($detail && !empty($detail->image_path)) {
			$filePath = __DIR__ . '/../../' . $detail->image_path; // convert to filesystem path
			if (file_exists($filePath)) {
				@unlink($filePath);
			}
		}

		$check = $this->imgModel->deleteImage($id);
		if ($check) {
			redirect('success', 'Xóa thành công', 'list-tourimg');
		}
	}

	// show edit details
	public function detailImage($id)
	{
		$detail = $this->imgModel->getImageById($id);
		$tourModel = new TourModel();
		$tours = $tourModel->getAllTours();
		return $this->render('tourimg.editImg', ['detail' => $detail, 'tours' => $tours]);
	}

	// handle update (supports replacing uploaded file)
	public function editImage($id)
	{
		if (isset($_POST['btn-submit'])) {
			$error = [];
			if (empty($_POST['tour_id'])) {
				$error['tour_id'] = 'Vui lòng chọn tour';
			}

			$route = 'detail-tourimg/' . $id;
			if (count($error) >= 1) {
				redirect('errors', $error, $route);
				return;
			}

			$updateData = [
				'tour_id' => $_POST['tour_id'],
				'image_path' => '',
				'is_thumbnail' => isset($_POST['is_thumbnail']) ? 1 : 0,
				'updated_at' => date('Y-m-d H:i:s')
			];

			$detail = $this->imgModel->getImageById($id);

			// If new file uploaded, move and replace
			if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
				$uploadDir = __DIR__ . '/../../public/uploads/tour_images';
				if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

				$file = $_FILES['image'];
				$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
				$allowed = ['jpg','jpeg','png','gif'];
				if (!in_array(strtolower($ext), $allowed)) {
					redirect('errors', ['image' => 'Chỉ cho phép ảnh JPG/PNG/GIF'], $route);
					return;
				}

				$filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file['name']);
				$destPath = $uploadDir . '/' . $filename;
				if (move_uploaded_file($file['tmp_name'], $destPath)) {
					// remove old file
					if ($detail && !empty($detail->image_path)) {
						$old = __DIR__ . '/../../' . $detail->image_path;
						if (file_exists($old)) @unlink($old);
					}
					$updateData['image_path'] = 'public/uploads/tour_images/' . $filename;
				} else {
					redirect('errors', ['image' => 'Không thể lưu file'], $route);
					return;
				}
			} else {
				// keep existing path
				$updateData['image_path'] = $detail ? $detail->image_path : '';
			}

			$check = $this->imgModel->updateImage($id, $updateData);
			if ($check) redirect('success', 'Cập nhật thành công', 'list-tourimg');
		}
	}

}
