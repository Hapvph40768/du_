<?php
namespace App\Controllers;

use App\Models\BookingServiceModel;
use App\Models\BookingModel;
use App\Models\ServiceModel;

class BookingServiceController extends BaseController
{
    protected $bookingService;

    public function __construct()
    {
        $this->bookingService = new BookingServiceModel();
    }

    // 1. Danh sách dịch vụ kèm theo booking
    public function listBookingServices()
    {
        $bookingServices = $this->bookingService->getAllBookingServices();
        return $this->render("admin.booking_service.listBookingService", [
            'bookingServices' => $bookingServices
        ]);
    }

    // 2. Form thêm mới
    public function createBookingService()
    {
        $bookings = (new BookingModel())->getAllBookings();
        $services = (new ServiceModel())->getAllServices();

        return $this->render("admin.booking_service.addBookingService", [
            'bookings' => $bookings,
            'services' => $services
        ]);
    }

    // 3. Xử lý thêm mới (Multiple Services)
    public function postBookingService()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('errors', "Yêu cầu không hợp lệ", 'list-booking-service');
        }

        $booking_id = trim($_POST['booking_id'] ?? '');
        if (empty($booking_id)) {
            redirect('errors', "Phải chọn booking.", 'add-booking-service');
        }

        $services = $_POST['services'] ?? [];
        $countSuccess = 0;

        foreach ($services as $srvId => $sData) {
            // Check if this service was checked
            if (isset($sData['selected']) && $sData['selected'] == 1) {
                
                $price = $sData['price'] ?? 0;
                $quantity = $sData['quantity'] ?? 1;

                // Fallback: If price is 0 or empty, use default service price
                if (empty($price) || $price == 0) {
                    $srv = (new ServiceModel())->getServiceById($srvId);
                    if ($srv) {
                        $price = ($srv->price > 0) ? $srv->price : $srv->default_price;
                    }
                }

                $data = [
                    'booking_id' => $booking_id,
                    'service_id' => $srvId,
                    'quantity'   => $quantity,
                    'price'      => $price,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                
                // Simple validation for quantity
                if ($data['quantity'] <= 0) continue;

                $this->bookingService->addBookingService($data);
                $countSuccess++;
            }
        }

        if ($countSuccess > 0) {
            redirect('success', "Thêm thành công $countSuccess dịch vụ vào booking", 'list-booking-service');
        } else {
            redirect('errors', "Vui lòng chọn ít nhất một dịch vụ.", 'add-booking-service');
        }
    }

    // 4. Chi tiết để làm chức năng "Quản lý dịch vụ cho Booking"
    public function detailBookingService($id)
    {
        // Get the specific service record first to know which booking we are talking about
        $detail = $this->bookingService->getBookingServiceById($id);
        
        if (!$detail) {
             redirect('errors', "Dịch vụ không tồn tại", 'list-booking-service');
        }

        $bookings = (new BookingModel())->getAllBookings();
        $services = (new ServiceModel())->getAllServices();
        
        // Get ALL services currently assigned to this booking
        $activeServices = $this->bookingService->getServicesByBooking($detail->booking_id);

        return $this->render("admin.booking_service.editBookingService", [
            'detail'   => $detail,
            'bookings' => $bookings,
            'services' => $services,
            'activeServices' => $activeServices
        ]);
    }

    // 5. Xử lý sửa (Bulk Update)
    public function editBookingService($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('errors', "Yêu cầu không hợp lệ", 'list-booking-service');
        }
        
        // Use the ID to find the booking, OR use the posted booking_id
        $booking_id = trim($_POST['booking_id'] ?? '');

        if (empty($booking_id)) {
             // Fallback to finding by ID if not posted
             $current = $this->bookingService->getBookingServiceById($id);
             if ($current) {
                 $booking_id = $current->booking_id;
             } else {
                 redirect('errors', "Booking không xác định", 'list-booking-service');
             }
        }

        $servicesInput = $_POST['services'] ?? [];
        
        // 1. Get existing services for this booking
        $existingServices = $this->bookingService->getServicesByBooking($booking_id);
        $existingMap = []; // Map by service_id
        foreach($existingServices as $es) {
            $existingMap[$es->service_id] = $es;
        }

        $countUpdated = 0;
        $countAdded = 0;
        $countDeleted = 0;

        // 2. Process submitted services
        foreach ($servicesInput as $srvId => $sData) {
            // If checked
            if (isset($sData['selected']) && $sData['selected'] == 1) {
                
                $price = $sData['price'] ?? 0;
                $quantity = $sData['quantity'] ?? 1;

                // Price Fallback
                if (empty($price) || $price == 0) {
                    $srv = (new ServiceModel())->getServiceById($srvId);
                    if ($srv) {
                        $price = ($srv->price > 0) ? $srv->price : $srv->default_price;
                    }
                }

                if (isset($existingMap[$srvId])) {
                    // Update existing
                    $currentBS = $existingMap[$srvId];
                    $updateData = [
                        'booking_id' => $booking_id,
                        'service_id' => $srvId,
                        'quantity'   => $quantity,
                        'price'      => $price,
                    ];
                    $this->bookingService->updateBookingService($currentBS->id, $updateData);
                    $countUpdated++;
                    
                    // Remove from map so we know it's handled
                    unset($existingMap[$srvId]);
                } else {
                    // Add new
                    $newData = [
                        'booking_id' => $booking_id,
                        'service_id' => $srvId,
                        'quantity'   => $quantity,
                        'price'      => $price,
                        'created_at' => date("Y-m-d H:i:s")
                    ];
                    $this->bookingService->addBookingService($newData);
                    $countAdded++;
                }

            }
        }

        // 3. Delete unchecked services (remaining in map)
        foreach ($existingMap as $srvId => $remnant) {
            $this->bookingService->deleteBookingService($remnant->id);
            $countDeleted++;
        }

        $msgParts = [];
        if ($countAdded > 0) $msgParts[] = "Thêm thành công $countAdded dịch vụ";
        if ($countUpdated > 0) $msgParts[] = "Sửa thành công $countUpdated dịch vụ";
        if ($countDeleted > 0) $msgParts[] = "Xóa thành công $countDeleted dịch vụ";

        $msg = !empty($msgParts) ? implode(". ", $msgParts) : "Cập nhật thành công";
        
        redirect('success', $msg, 'list-booking-service');
    }

    // 6. Xóa
    public function deleteBookingService($id)
    {
        $check = $this->bookingService->deleteBookingService($id);

        if ($check) {
            redirect('success', "Xóa thành công dịch vụ khỏi booking", 'list-booking-service');
        } else {
            redirect('errors', "Xóa thất bại", 'list-booking-service');
        }
    }

    // Hàm validate chung
    private function validate($data)
    {
        $error = [];

        if (empty($data['booking_id'])) {
            $error['booking_id'] = "Phải chọn booking.";
        }
        if (empty($data['service_id'])) {
            $error['service_id'] = "Phải chọn dịch vụ.";
        }
        if (!is_numeric($data['quantity']) || $data['quantity'] <= 0) {
            $error['quantity'] = "Số lượng phải là số dương.";
        }
        if (!is_numeric($data['price']) || $data['price'] < 0) {
            $error['price'] = "Giá phải là số không âm.";
        }

        return $error;
    }
}
?>
