<?php
namespace App\Controllers;
use App\Models\GuidesModel;
use App\Models\TourModel;

class GuidesController extends BaseController
{
    public $guides;
    public function __construct()
    {
        $this->guides = new GuidesModel();
    }
    public function getGuides()
    {
        $guides = $this->guides->getAllGuides();
        $this->render("guides.listGuides", ['guides' => $guides]);
    }
    public function createGuides()
    {
        $tour = new TourModel();
        $tours = $tour->getAllTours();
        $this->render("guides.addGuides", ['tours' => $tours]);
    }
    public function postGuides()
    {
        $error = [];
        if (empty($_POST['user_id'])) {
            $error['user_id'] = "vui long dien vao cho trong";
        }
        if (empty($_POST['experience_years'])) {
            $error['experience_years'] = "vui long dien vao cho trong";
        }
        if (empty($_POST['certificate'])) {
            $error['certificate'] = "vui long dien vao cho trong";
        }
        if (empty($_POST['status'])) {
            $error['status'] = "vui long dien vao cho trong";
        }
        $experience_years = $_POST['experience_years'] ?? 0;
        $status = $_POST['status'] ?? 1;
        if (count($error) >= 1) {
            redirect('error', $error, 'add-guide');
        } else {
            $check = $this->guides->addGuide([
                'user_id' => $_POST['user_id'],
                'experience_years' => $experience_years,
                'certificate' => $_POST['certificate'],
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if ($check) {
                redirect('success', 'Them thanh cong', 'list-guide');
            }
        }
    }
    public function editGuides($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];
            if (empty($_POST['user_id'])) {
                $error['user_id'] = "vui long dien vao cho trong";
            }
            if (empty($_POST['experience_years'])) {
                $error['experience_years'] = "vui long dien vao cho trong";
            }
            if (empty($_POST['certificate'])) {
                $error['certificate'] = "vui long dien vao cho trong";
            }
            if (empty($_POST['status'])) {
                $error['status'] = "vui long dien vao cho trong";
            }
            $experience_years = $_POST['experience_years'] ?? 0;
            $status = $_POST['status'] ?? 1;
            $route = 'detail-guide' . $id;
            if (count($error) >= 1) {
                redirect('error', $error, $route);
            } else {
                $check = $this->guides->updateGuide(
                    $id,
                    [
                        'user_id' => $_POST['user_id'],
                        'experience_years' => $experience_years,
                        'certificate' => $_POST['certificate'],
                        'status' => $status,
                        'updated_at' => date('Y-m-d H:i:s'),

                    ]
                );
                if($check){
                    redirect('success', 'sua thanh cong', 'list-guide');
                }else{
                    redirect('error', 'sua that bai', 'detail-guide');
                }
            }
        }
    }
    public function deleteGuide($id){
        $check = $this->guides->deleteGuide([$id]);
        if($check){
            redirect('success', 'xoa thanh cong', 'list-guide');
        }
    }
}