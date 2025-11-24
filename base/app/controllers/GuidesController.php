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
        $guidesModel = new GuidesModel();
        $guides = $guidesModel->getAllGuides();
        $this->render("guides.addGuides", ['guides' => $guides]);
    }
    public function postGuides()
    {
        $error = [];

        // validate
        $user_id = $_POST['user_id'] ?? '';
        $dob = $_POST['dob'] ?? '';
        $avatar = $_POST['avatar'] ?? '';
        $certificates = $_POST['certificates'] ?? '';
        $languages = $_POST['languages'] ?? '';
        $experience_years = $_POST['experience_years'] ?? '';
        if (empty($_POST['user_id'])) {
            $error['user_id'] = "Tên User không được để trống";
        }
        if (empty($_POST['dob'])) {
            $error['dob'] = "Ngay Sinh không được để trống";
        }
        if (empty($_POST['avatar'])) {
            $error['avatar'] = "Ảnh không được để trống";
        }
        if (!empty($_POST['certificates'])) {
            $error['certificates'] = "Chứng Chỉ Chuyên Môn Không được để trống";
        }
        if (empty($_POST['languages']) ) {
            $error['languages'] = "Ngôn Ngữ không được để trống";
        }
        if (empty($_POST['experience_years']) ) {
            $error['experience_years'] = "Năm Kinh Nghiêm không được để trống";
        }
        if (count($error) >= 1) {
            redirect('errors', $error, 'add-guide');
        } else {

            $check = $this->guides->addGuides([
                'user_id' => $user_id,
                'dob' => $dob,
                'avatar' => $avatar,
                'certificates' => $certificates,
                'languages' => $languages,
                'experience_years' => $experience_years,
            ]);
            if ($check) {
                redirect('success', "Thêm thành công", 'list-guide');
            } else {
                redirect('errors', "Thêm thất bại, vui lòng thử lại", 'add-guide');
            }

        }

    }
    public function deleteGuides($id)
    {
        $check = $this->guides->deleteGuides($id);
        if ($check) {
            redirect('success', "Xóa thành công", 'list-guide');
        }
    }
    public function detailDeparture($id)
    {
        $detail = $this->departure->getDepartureById($id);
        $tour = new TourModel();
        $tours = $tour->getListTours();
        return $this->render('departure.editDeparture', ['detail' => $detail, 'tours' => $tours]);
    }
    public function editGuides($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];
            // validate rỗng
             if (empty($_POST['user_id'])) {
            $error['user_id'] = "Tên User không được để trống";
        }
        if (empty($_POST['dob'])) {
            $error['dob'] = "Ngay Sinh không được để trống";
        }
        if (empty($_POST['avatar'])) {
            $error['avatar'] = "Ảnh không được để trống";
        }
        if (!empty($_POST['certificates'])) {
            $error['certificates'] = "Chứng Chỉ Chuyên Môn Không được để trống";
        }
        if (empty($_POST['languages']) ) {
            $error['languages'] = "Ngôn Ngữ không được để trống";
        }
        if (empty($_POST['experience_years']) ) {
            $error['experience_years'] = "Năm Kinh Nghiêm không được để trống";
        }
            if(count($error) >=1 ){
                redirect('errors',  $error, $route);
            }else{
                $check = $this->guides->updateGuides(
                    $id,
                      [
                        'user_id' => $_POST['user_id'],
                        'dob' => $_POST['dob'],
                        'avatar' => $_POST['avatar'],
                        'certificates' => $_POST['certificates'],
                        'languages' => $_POST['languages'],
                        'experience_years' => $_POST['experience_years'],
                    ]
                    );
                    if($check){
                        redirect('success',  "Sửa thành công", 'list-guide');
                    }
            }
        }
    }
 }