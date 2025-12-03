<?php
namespace App\Controllers;

use App\Models\GuidesModel;
use App\Models\TourModel;

class GuidesController extends BaseController
{
    protected $guides;

    public function __construct()
    {
        $this->guides = new GuidesModel();
    }

    // Danh sách hướng dẫn viên
    public function getGuides()
    {
        $guides = $this->guides->getAllGuides();
        $this->render("admin.guides.listGuides", ['guides' => $guides]);
    }

    // Form thêm hướng dẫn viên
    public function createGuides()
    {
        $tour = new TourModel();
        $tours = $tour->getAllTours();
        $this->render("admin.guides.addGuides", ['tours' => $tours]);
    }

    // Xử lý thêm mới
    public function postGuides()
    {
        $error = [];

        if (empty($_POST['user_id'])) {
            $error['user_id'] = "Vui lòng điền vào chỗ trống";
        }
        if (empty($_POST['experience_years'])) {
            $error['experience_years'] = "Vui lòng điền vào chỗ trống";
        }
        if (empty($_POST['certificate_url'])) {
            $error['certificate_url'] = "Vui lòng điền vào chỗ trống";
        }
        if (empty($_POST['status'])) {
            $error['status'] = "Vui lòng chọn trạng thái";
        }

        $experience_years = $_POST['experience_years'] ?? 0;
        $status = $_POST['status'] ?? 'active';

        if (count($error) >= 1) {
            redirect('error', $error, 'add-guide');
        } else {
            $check = $this->guides->addGuide([
                'user_id'         => $_POST['user_id'],
                'fullname'        => $_POST['fullname'] ?? null,
                'phone'           => $_POST['phone'] ?? null,
                'email'           => $_POST['email'] ?? null,
                'gender'          => $_POST['gender'] ?? null,
                'languages'       => $_POST['languages'] ?? null, // JSON string
                'experience_years'=> $experience_years,
                'experience'      => $_POST['experience'] ?? null,
                'certificate_url' => $_POST['certificate_url'],
                'avatar'          => $_POST['avatar'] ?? null,
                'status'          => $status,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);

            if ($check) {
                redirect('success', 'Thêm thành công', 'list-guide');
            } else {
                redirect('error', 'Thêm thất bại', 'add-guide');
            }
        }
    }

    // Sửa hướng dẫn viên
    public function editGuides($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            if (empty($_POST['user_id'])) {
                $error['user_id'] = "Vui lòng điền vào chỗ trống";
            }
            if (empty($_POST['experience_years'])) {
                $error['experience_years'] = "Vui lòng điền vào chỗ trống";
            }
            if (empty($_POST['certificate_url'])) {
                $error['certificate_url'] = "Vui lòng điền vào chỗ trống";
            }
            if (empty($_POST['status'])) {
                $error['status'] = "Vui lòng chọn trạng thái";
            }

            $experience_years = $_POST['experience_years'] ?? 0;
            $status = $_POST['status'] ?? 'active';
            $route = 'detail-guide/' . $id;

            if (count($error) >= 1) {
                redirect('error', $error, $route);
            } else {
                $check = $this->guides->updateGuide($id, [
                    'user_id'         => $_POST['user_id'],
                    'fullname'        => $_POST['fullname'] ?? null,
                    'phone'           => $_POST['phone'] ?? null,
                    'email'           => $_POST['email'] ?? null,
                    'gender'          => $_POST['gender'] ?? null,
                    'languages'       => $_POST['languages'] ?? null,
                    'experience_years'=> $experience_years,
                    'experience'      => $_POST['experience'] ?? null,
                    'certificate_url' => $_POST['certificate_url'],
                    'avatar'          => $_POST['avatar'] ?? null,
                    'status'          => $status,
                    'updated_at'      => date('Y-m-d H:i:s'),
                ]);

                if ($check) {
                    redirect('success', 'Sửa thành công', 'list-guide');
                } else {
                    redirect('error', 'Sửa thất bại', $route);
                }
            }
        }
    }

    // Xóa hướng dẫn viên
    public function deleteGuide($id)
    {
        $check = $this->guides->deleteGuide($id);
        if ($check) {
            redirect('success', 'Xóa thành công', 'list-guide');
        } else {
            redirect('error', 'Xóa thất bại', 'list-guide');
        }
    }
}