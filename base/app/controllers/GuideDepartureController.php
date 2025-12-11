<?php

namespace App\Controllers;

use App\Models\DepartureModel;
use App\Models\TourModel;

class GuideDepartureController extends BaseController
{
    protected $guideModel;
    protected $tourGuideModel;
    protected $departure;

    public function __construct()
    {
        $this->departure = new DepartureModel();
        $this->guideModel = new \App\Models\GuidesModel();
        $this->tourGuideModel = new \App\Models\TourGuideModel();
    }

    // Danh sách departures
    public function listGuideDepartures()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $guide = $this->guideModel->getGuideByUserId($userId);

        if (!$guide) {
            // Nếu chưa là guide hoặc lỗi
            $departures = []; 
        } else {
            // Get assignments
            $departures = $this->tourGuideModel->getAssignedTours($guide->id);
        }

        $this->render("guide.guide_departure.listGuideDeparture", ['departures' => $departures]);
    }

}