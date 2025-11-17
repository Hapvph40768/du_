<?php 
namespace App\Controllers;
use App\Models\TourModel;

class TourController extends BaseController
{
    public $tour;
    public function __construct(){
        $this->tour = new TourModel();
    }
    public function getTours()
    {
        $tours = $this->tour->getListTours();
        $this->render("tour.list", ['tours' => $tours]);
    }
    public function createTour()
    {
        
    }
}