<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\DepartureModel;
use App\Models\CustomerModel;

class BookingController extends BaseController
{
    protected $booking;

    public function __construct()
    {
        $this->booking = new BookingModel();
    }

    /**
     * Danh sách bookings
     */
    public function getBookings()
    {
        $status = $_GET['status'] ?? null;
        $bookings = $this->booking->getAllBookings($status);

        $this->render("admin.booking.listBooking", [
            'bookings' => $bookings,
            'currentStatus' => $status
        ]);
    }

    /**
     * Form thêm booking
     */
    public function createBooking()
    {
        $departures = (new DepartureModel())->getAllDepartures();
        $services   = (new \App\Models\ServiceModel())->getAllServices();
        
        $customers = [];
        $currentCustomer = null;
        
        // Check Role
        $role = $_SESSION['user']['role'] ?? 'customer'; 
        
        // Fetch all customers unconditionally as requested by user
        $customers = (new CustomerModel())->getAllCustomers();

        if ($role !== 'admin' && $role !== 'staff' && $role !== 'guide') {
             // Fetch current customer profile for auto-fill if needed
             $userId = $_SESSION['user']['id'] ?? 0;
             $currentCustomer = (new CustomerModel())->getCustomerByUserId($userId);
        }

        $this->render("admin.booking.addBooking", [
            'departures' => $departures,
            'services'   => $services,
            'customers'  => $customers,
            'currentCustomer' => $currentCustomer,
            'userRole'   => $role
        ]);
    }

    /**
     * Xử lý thêm booking
     */
    public function postBooking()
    {
        $error = [];

        $departure_id   = $_POST['departure_id'] ?? '';
        $selected_services = $_POST['services'] ?? [];
        $service_id     = $selected_services[0] ?? null;
        
        // Customer Logic
        $customer_id = null;
        $role = $_SESSION['user']['role'] ?? 'customer';
        
        if (isset($_POST['customer_id'])) {
             $customer_id = $_POST['customer_id'];
             if ($customer_id === '') $customer_id = null;
        } elseif ($role !== 'admin' && $role !== 'staff' && $role !== 'guide') {
             // Fallback: Force current customer if not provided and not admin/staff/guide
             $userId = $_SESSION['user']['id'] ?? 0;
             $currCus = (new CustomerModel())->getCustomerByUserId($userId);
             if ($currCus) {
                 $customer_id = $currCus->id;
             }
        }

        $start_date     = $_POST['start_date'] ?? '';
        $end_date       = $_POST['end_date'] ?? '';
        $num_people     = (int)($_POST['num_people'] ?? 0);
        $payment_status = $_POST['payment_status'] ?? 'unpaid';
        $status         = $_POST['status'] ?? 'pending';
        $note           = $_POST['note'] ?? null;
        $pickup_location= $_POST['pickup_location'] ?? null;



        if (!$departure_id) $error['departure_id'] = "Vui lòng chọn lịch khởi hành";
        // if (!$customer_id) $error['customer_id'] = "Vui lòng chọn khách hàng (hoặc cập nhật hồ sơ cá nhân)";
        if (!$start_date) $error['start_date'] = "Vui lòng chọn ngày đi";
        if (!$end_date) $error['end_date'] = "Vui lòng chọn ngày về";
        if (strtotime($start_date) > strtotime($end_date)) $error['end_date'] = "Ngày về không được nhỏ hơn ngày đi";
        if ($num_people <= 0) $error['num_people'] = "Số lượng người không hợp lệ";

        $departure = (new DepartureModel())->getDepartureById($departure_id);
        if (!$departure) {
            $error['departure_id'] = "Lịch khởi hành không tồn tại";
        } elseif ($departure->status == 'closed') {
            $error['departure_id'] = "Lịch khởi hành này đã đóng, không thể đặt chỗ.";
        } elseif ($departure->total_seats > 0 && $departure->remaining_seats !== null && $num_people > $departure->remaining_seats) {
            $error['num_people'] = "Chỉ còn {$departure->remaining_seats} ghế trống";
        }

        if (!empty($error)) {
            redirect('errors', $error, 'add-booking');
            return;
        }

        // Calculate total service price (Multiplier)
        $sum_service_price = 0;
        $serviceModel = new \App\Models\ServiceModel();
        
        // Fetch service details for calculation and saving later
        $services_data = []; 
        if (!empty($selected_services)) {
            foreach ($selected_services as $srvId) {
                $srv = $serviceModel->getServiceById($srvId);
                if ($srv) {
                    $actualPrice = ($srv->price > 0) ? (float)$srv->price : (float)($srv->default_price ?? 0);
                    $sum_service_price += $actualPrice;
                    $services_data[] = $srv;
                }
            }
        }
        $final_service_price = $sum_service_price;
        
        // New Formula: (TourPrice + ServiceSum) * Days * NumPeople
        $departure = (new DepartureModel())->getDepartureById($departure_id);
        $tour_price = ($departure && $departure->tour_price) ? (float)$departure->tour_price : 0;
        
        $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
        $days = ($days >= 0) ? $days + 1 : 1;
        
        $calc_num_people = ($num_people > 0) ? $num_people : 1; 

        try {
            // Lưu booking
            $check = $this->booking->addBooking([
                'departure_id'   => $departure_id,
                'service_id'     => $service_id, 
                'customer_id'    => $customer_id,
                'start_date'     => $start_date,
                'end_date'       => $end_date,
                'num_people'     => $num_people,
                'service_price'  => $final_service_price, 
                'payment_status' => $payment_status,
                'status'         => $status,
                'note'           => $note,
                'pickup_location'=> $pickup_location,
                'created_by'     => $_SESSION['user_id'] ?? null
            ]);

            if ($check) {
                // Get new booking ID
                $bookingId = $this->booking->getLastInsertId();

                // Save services to booking_services table
                if (!empty($services_data)) {
                     $bookingServiceModel = new \App\Models\BookingServiceModel();
                     foreach ($services_data as $srv) {
                         $bookingServiceModel->addBookingService([
                             'booking_id' => $bookingId,
                             'service_id' => $srv->id,
                             'quantity'   => 1, // Default quantity 1
                             'price'      => $srv->price,
                             'created_at' => date("Y-m-d H:i:s")
                         ]);
                     }
                }

                // Save Guests if num_people > 1 and guests array exists
                $guests = $_POST['guests'] ?? [];
                if ($num_people > 1 && !empty($guests) && is_array($guests)) {
                     $bookingCustomerModel = new \App\Models\BookingCustomerModel();
                     foreach ($guests as $guest) {
                         if (!empty($guest['fullname'])) {
                             $bookingCustomerModel->addBookingCustomer([
                                 'booking_id' => $bookingId,
                                 'fullname'   => $guest['fullname'],
                                 'phone'      => $guest['phone'] ?? null,
                                 'id_card'    => $guest['id_card'] ?? null,
                                 'gender'     => $guest['gender'] ?? 'other',
                                 'dob'        => !empty($guest['dob']) ? $guest['dob'] : null,
                                 'note'       => null,
                                 'created_at' => date("Y-m-d H:i:s")
                             ]);
                         }
                     }
                }
                
                redirect('success', "Thêm booking thành công", 'list-booking');
            } else {
                redirect('errors', ["Thêm thất bại (Lỗi hệ thống)"], 'add-booking');
            }
        } catch (\Exception $e) {
            redirect('errors', ["Thêm thất bại: " . $e->getMessage()], 'add-booking');
        }
    }

    /**
     * Form sửa booking
     */
    public function detailBooking($id)
    {
        $detail     = $this->booking->getBookingById($id);
        $departures = (new DepartureModel())->getAllDepartures();
        $services   = (new \App\Models\ServiceModel())->getAllServices();
        
        // Fetch current services from booking_services table
        $bookingServiceModel = new \App\Models\BookingServiceModel();
        $detail->services = $bookingServiceModel->getServicesByBooking($id);

        $customers = [];
        $userRole = $_SESSION['user']['role'] ?? 'customer'; 
        
        // Fetch all customers unconditionally
        $customers = (new CustomerModel())->getAllCustomers();

        $this->render("admin.booking.editBooking", [
            'detail'     => $detail,
            'departures' => $departures,
            'services'   => $services,
            'customers'  => $customers,
            'userRole'   => $userRole
        ]);
    }

    /**
     * Xử lý sửa booking
     */
    public function editBooking($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $error = [];

        $departure_id   = $_POST['departure_id'] ?? '';
        $selected_services = $_POST['services'] ?? [];
        $service_id     = $selected_services[0] ?? null;

        // Customer Logic for Edit
        $customer_id = null;
        $role = $_SESSION['user']['role'] ?? 'customer';

        // Allow updating customer_id if provided in form
        if (isset($_POST['customer_id'])) {
            $customer_id = $_POST['customer_id'];
            if ($customer_id === '') $customer_id = null; 
        } else {
            // Keep existing if not provided
            $existingBooking = $this->booking->getBookingById($id);
            $customer_id = $existingBooking->customer_id ?? null;
        }

        $start_date     = $_POST['start_date'] ?? '';
        $end_date       = $_POST['end_date'] ?? '';
        $num_people     = (int)($_POST['num_people'] ?? 0);
        $payment_status = $_POST['payment_status'] ?? 'unpaid';
        $status         = $_POST['status'] ?? 'pending';
        $note           = $_POST['note'] ?? null;
        $pickup_location= $_POST['pickup_location'] ?? null;


        $route = 'detail-booking/' . $id;

        if (!$departure_id) $error['departure_id'] = "Vui lòng chọn lịch khởi hành";
        // if (!$customer_id) $error['customer_id'] = "Thiếu thông tin khách hàng";
        if (!$start_date) $error['start_date'] = "Vui lòng chọn ngày đi";
        if (!$end_date) $error['end_date'] = "Vui lòng chọn ngày về";
        if (strtotime($start_date) > strtotime($end_date)) $error['end_date'] = "Ngày về không được nhỏ hơn ngày đi";

        if ($num_people <= 0) {
            $error['num_people'] = "Số lượng người không hợp lệ";
        }

        $departure  = (new DepartureModel())->getDepartureById($departure_id);
        $oldBooking = $this->booking->getBookingById($id);

        if (!$departure) {
            $error['departure_id'] = "Lịch khởi hành không tồn tại";
        } elseif ($departure->status == 'closed') {
            $error['departure_id'] = "Lịch khởi hành này đã đóng, không thể đặt chỗ.";
        } else {
            // Chỉ tính ghế tăng thêm
            $diff = $num_people - $oldBooking->num_people;

            if ($diff > 0 && $departure->total_seats > 0 && $departure->remaining_seats !== null && $diff > $departure->remaining_seats) {
                $error['num_people'] = "Không đủ ghế để tăng. Chỉ còn {$departure->remaining_seats} ghế trống.";
            }
        }

        if (!empty($error)) {
            redirect('errors', $error, $route);
            return;
        }

        // Calculate service price
        $sum_service_price = 0;
        $serviceModel = new \App\Models\ServiceModel();
        $services_data = [];

        if (!empty($selected_services)) {
            foreach ($selected_services as $srvId) {
                $srv = $serviceModel->getServiceById($srvId);
                if ($srv) {
                    $actualPrice = ($srv->price > 0) ? (float)$srv->price : (float)($srv->default_price ?? 0);
                    $sum_service_price += $actualPrice;
                    $services_data[] = $srv;
                }
            }
        }
        
        // Sum without fallback to 1 
        $final_service_price = $sum_service_price;

        $check = $this->booking->updateBooking($id, [
            'departure_id'   => $departure_id,
            'service_id'     => $service_id,
            'customer_id'    => $customer_id,
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'num_people'     => $num_people,
            'service_price'  => $final_service_price,
            'payment_status' => $payment_status,
            'status'         => $status,
            'note'           => $note,
            'pickup_location'=> $pickup_location,
            'updated_by'     => $_SESSION['user_id'] ?? null
        ]);

        if ($check) {
            // Update Services: Delete old, add new
            $bookingServiceModel = new \App\Models\BookingServiceModel();
            
            // Delete existing services for this booking (Naive but effective for syncing)
            // Note: BookingServiceModel delete is by ID, not BookingID. Need 'deleteByBookingId'? 
            // Checking BookingServiceModel... it has deleteBookingService($id). 
            // It lacks deleteByBookingId! I must implement it or loop delete.
            // Loop delete:
            $currentServices = $bookingServiceModel->getServicesByBooking($id);
            foreach($currentServices as $cs) {
                $bookingServiceModel->deleteBookingService($cs->id);
            }
            
            // Add new
            if (!empty($services_data)) {
                 foreach ($services_data as $srv) {
                     $bookingServiceModel->addBookingService([
                         'booking_id' => $id,
                         'service_id' => $srv->id,
                         'quantity'   => 1,
                         'price'      => $srv->price,
                         'created_at' => date("Y-m-d H:i:s")
                     ]);
                 }
            }
            
            redirect('success', "Sửa booking thành công", 'list-booking');
        } else {
            redirect('errors', ["Sửa thất bại"], $route);
        }
    }

    /**
     * Xem chi tiết booking
     */
    public function viewBooking($id)
    {
        $detail = $this->booking->getBookingById($id);
        
        if (!$detail) {
            redirect('errors', ["Không tìm thấy booking"], 'list-booking');
        }

        // Fetch booking customers (guests)
        $bookingCustomerModel = new \App\Models\BookingCustomerModel();
        $currCustomers = $bookingCustomerModel->getCustomersByBooking($id);

        $this->render("admin.booking.viewBooking", [
            'booking' => $detail,
            'currCustomers' => $currCustomers
        ]);
    }

    /**
     * Xóa booking
     */
    public function deleteBooking($id)
    {
        $booking = $this->booking->getBookingById($id);
        $departure = (new DepartureModel())->getDepartureById($booking->departure_id);

        $check = $this->booking->deleteBooking($id);

        if ($check) {
            redirect('success', "Xóa booking thành công", 'list-booking');
        } else {
            redirect('errors', ["Xóa booking thất bại"], 'list-booking');
        }
    }
}
