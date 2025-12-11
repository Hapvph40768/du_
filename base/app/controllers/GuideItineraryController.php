<?php

namespace App\Controllers;

use App\Models\ItineraryModel;
use App\Models\TourModel;
use App\Models\DepartureModel;

class GuideItineraryController extends BaseController
{
    protected $itinerary;
    protected $departure;

    public function __construct()
    {
        $this->itinerary  = new ItineraryModel();
        $this->departure  = new DepartureModel();
    }

    // Danh sách tất cả itinerary
    public function listGuideItinerary()
    {
        $itinerary = $this->itinerary->getAllItineraries();
        $this->render("guide.guide_itinerary.listGuideItinerary", ['itinerary' => $itinerary]);
    }

    // Danh sách itinerary theo departure_id
    public function detailGuideItinerariesByDeparture($departure_id)
    {
        $itineraries = $this->itinerary->getItinerariesByDeparture($departure_id);
        $departure   = $this->departure->getDepartureById($departure_id);

        // If called via AJAX, return only partial content (no layout)
        if (isset($_GET['ajax']) && $_GET['ajax']) {
            // render partial table only
            $this->render('guide.guide_itinerary._partialGuideItineraries', [
                'itineraries' => $itineraries,
                'departure'   => $departure
            ]);
            return;
        }

        $this->render('guide.guide_itinerary.listGuideItineraryId', [
            'itineraries' => $itineraries,
            'departure'   => $departure
        ]);
    }

}
