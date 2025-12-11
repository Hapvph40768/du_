<?php
namespace App\Controllers;

use App\Models\TourGuideModel;
use App\Models\GuidesModel;

class GuideTourController extends BaseController
{   
    protected $tourGuide;
    protected $guide;

    public function __construct()
    {
        $this->tourGuide = new TourGuideModel();
        $this->guide = new GuidesModel();
    }

    // Hiển thị danh sách tour được phân công
    public function listTourGuides()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . route('login'));
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $guide = $this->guide->getGuideByUserId($userId);

        if (!$guide) {
            $tours = []; // User is not a guide
        } else {
            $tours = $this->tourGuide->getAssignedTours($guide->id);
        }

        $this->render("guide.guide_tour.listTourGuide", ['tours' => $tours]);
    }

}