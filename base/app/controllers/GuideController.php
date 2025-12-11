<?php
namespace App\Controllers;

use App\Models\GuidesModel;

class GuideController extends BaseController
{
    protected $guideModel;

    public function __construct()
    {
        $this->guideModel = new GuidesModel();
    }

    public function updateStatus()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header("Location: " . route('login'));
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $guide = $this->guideModel->getGuideByUserId($userId);

        if ($guide) {
            $status = $_POST['status'] ?? 'active'; // 'active' (Available) or 'busy' (Busy)
            
            // Validate status
            if (!in_array($status, ['active', 'inactive'])) {
                 redirect('error', 'Trạng thái không hợp lệ', 'guide-dashboard');
            }

            $this->guideModel->updateStatus($guide->id, $status);
            redirect('success', 'Cập nhật trạng thái thành công', 'guide-dashboard');
        } else {
            redirect('error', 'Không tìm thấy thông tin hướng dẫn viên', 'guide-dashboard');
        }
    }
}
