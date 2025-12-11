<?php
namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\TourCostModel;
use App\Models\DepartureModel;

class ReportController extends BaseController
{
    protected $bookingModel;
    protected $tourCostModel;
    protected $departureModel; // Need to get departures to calculate stuff

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->tourCostModel = new TourCostModel();
        $this->departureModel = new DepartureModel();
    }

    public function revenueReport()
    {
        $month = $_GET['month'] ?? date('m');
        $year = $_GET['year'] ?? date('Y');

        // 1. Get all departures in this month/year
        // Custom query to get departures + Revenue + Cost in one go would be optimized,
        // but sticking to "User's Style" (Simple Models), we loop.
        
        // Let's modify DepartureModel or just fetch raw here?
        // Ideally we should add getDeparturesByMonth to DepartureModel.
        // For now, I will fetch all and filter in PHP or add a method.
        // Let's add a method to DepartureModel via raw SQL here using BaseModel features if possible, 
        // OR instantiate DepartureModel and use existing methods.
        
        // Actually, let's just get All Departures and filter in SQL.
        // But DepartureModel doesn't have a specific date filter method yet maybe.
        // I will use a custom query in this controller or add to Model.
        // Adding to Model is cleaner. I will skip editing Model for now and use a direct query via a Helper approach
        // or just iterate. Iterating ALL departures is bad.
        // I will add a method to DepartureModel in next step. For now, assume it exists or I use getAllDepartures().
        
        // Let's cheat and use direct SQL here for the Report logic to ensure performance?
        // No, user wants "their style".
        // I'll grab all departures and filter efficiently?
        // Better: Add "getDeparturesByDateRange" to DepartureModel.
        
        $departures = $this->departureModel->getAllDepartures(); 
        
        $reportData = [];
        $totalRevenue = 0;
        $totalCost = 0;
        $totalProfit = 0;

        foreach ($departures as $d) {
            if (empty($d->start_date)) continue;
            
            $depDate = strtotime($d->start_date);
            if (date('m', $depDate) == $month && date('Y', $depDate) == $year) {
                // Relevant Departure
                
                // Revenue: Sum of Bookings for this departure
                // BookingModel::getBookingsByDeparture returns array. We sum total_price.
                $bookings = $this->bookingModel->getBookingsByDeparture($d->id);
                $dRevenue = 0;
                foreach($bookings as $b) {
                   // User request: Only count PAID bookings.
                   if ($b->payment_status == 'paid') {
                       $dRevenue += $b->total_price;
                   }
                }

                // Cost: Sum of TourCosts
                $dCost = $this->tourCostModel->getTotalCostByDeparture($d->id);

                // Profit
                $dProfit = $dRevenue - $dCost;

                $reportData[] = [
                    'departure_id' => $d->id,
                    'tour_name' => $d->tour_name,
                    'start_date' => $d->start_date,
                    'revenue' => $dRevenue,
                    'cost' => $dCost,
                    'profit' => $dProfit
                ];

                $totalRevenue += $dRevenue;
                $totalCost += $dCost;
                $totalProfit += $dProfit;
            }
        }

        return $this->render('admin.report.revenue', [
            'reportData' => $reportData,
            'month' => $month,
            'year' => $year,
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'totalProfit' => $totalProfit
        ]);
    }

    // Add Cost Action
    public function addCost() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'departure_id' => $_POST['departure_id'],
                'title' => $_POST['title'],
                'amount' => $_POST['amount']
            ];
            $this->tourCostModel->addCost($data);
            redirect('success', 'Thêm chi phí thành công', 'revenue-report?month=' . date('m') . '&year=' . date('Y'));
        }
    }
    
    // Delete Cost Action
    public function deleteCost($id) {
         $this->tourCostModel->deleteCost($id);
         redirect('success', 'Xóa chi phí thành công', 'revenue-report');
    }
}
