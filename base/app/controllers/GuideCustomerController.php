<?php
namespace App\Controllers;

use App\Models\CustomerModel;

class GuideCustomerController extends BaseController
{
    protected $bookingCustomerModel;
    protected $guideModel;
    protected $tourGuideModel;

    public function __construct()
    {
        $this->bookingCustomerModel = new \App\Models\BookingCustomerModel();
        $this->guideModel = new \App\Models\GuidesModel();
        $this->tourGuideModel = new \App\Models\TourGuideModel();
    }

    // Hiển thị danh sách khách hàng
    public function getGuideCustomers()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $guide = $this->guideModel->getGuideByUserId($userId);

        $filter_tour_id = $_GET['filter_tour_id'] ?? null;
        $start_date     = $_GET['filter_start_date'] ?? null;
        $end_date       = $_GET['filter_end_date'] ?? null;
        $booking_id     = $_GET['booking_id'] ?? null;

        $customers = [];
        $assignedTours = [];

        if ($guide) {
            // Get all assigned tours for filter dropdown (unique tours)
            $assignedToursRaw = $this->tourGuideModel->getAssignedTours($guide->id);
            
            // Deduplicate tours by tour_id for the dropdown
            $tempTours = [];
            foreach ($assignedToursRaw as $at) {
                if (!isset($tempTours[$at->tour_id])) {
                    $tempTours[$at->tour_id] = (object)[
                        'id' => $at->tour_id,
                        'name' => $at->tour_name
                    ];
                }
            }
            $assignedTours = array_values($tempTours);

            if ($booking_id) {
                 $customers = $this->bookingCustomerModel->getBookingCustomersByGuide($guide->id, $filter_tour_id, $start_date, $end_date, $booking_id);
            } else {
                 $customers = $this->bookingCustomerModel->getBookingCustomersByGuide($guide->id, $filter_tour_id, $start_date, $end_date);
            }
        }

        $this->render("guide.guide_customer.listGuideCustomer", [
            'customers' => $customers,
            'tours' => $assignedTours,
            'filter_tour_id' => $filter_tour_id,
            'filter_start_date' => $start_date,
            'filter_end_date' => $end_date,
            'booking_id' => $booking_id
        ]);
    }

}