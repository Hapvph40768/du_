<?php
use Phroute\Phroute\RouteCollector;

$url = !isset($_GET['url']) ? "/" : $_GET['url'];
$router = new RouteCollector();

// ===================
// TRANG CHỦ
// ===================
$router->get('/', function () {
    return "Trang chủ";
});

// ===================
// AUTH (Đăng nhập/Đăng ký)
// ===================
$router->get('login', [App\Controllers\AuthController::class, 'showLogin']);
$router->post('login', [App\Controllers\AuthController::class, 'login']);

$router->get('register', [App\Controllers\AuthController::class, 'showRegister']);
$router->post('register', [App\Controllers\AuthController::class, 'register']);

$router->get('logout', [App\Controllers\AuthController::class, 'logout']);
$router->get('dashboard', [App\Controllers\AuthController::class, 'dashboard']);

// ===================
// USER (Người dùng) - Commented out for now
// ===================
// $router->get('list-user', [App\Controllers\UserController::class, 'index']);
// $router->get('add-user', [App\Controllers\UserController::class, 'create']);
// $router->post('store-user', [App\Controllers\UserController::class, 'store']);
// $router->get('edit-user/{id}', [App\Controllers\UserController::class, 'edit']);
// $router->post('update-user/{id}', [App\Controllers\UserController::class, 'update']);
// $router->get('delete-user/{id}', [App\Controllers\UserController::class, 'delete']);

// ===================
// TOURS (Tour du lịch)
// ===================
$router->get('list-tours', [App\Controllers\TourController::class, 'getTours']);
$router->get('add-tour', [App\Controllers\TourController::class, 'createTour']);
$router->post('post-tour', [App\Controllers\TourController::class, 'postTour']);
$router->get('detail-tour/{id}', [App\Controllers\TourController::class, 'detailTour']);
$router->post('edit-tour/{id}', [App\Controllers\TourController::class, 'editTour']);
$router->get('delete-tour/{id}', [App\Controllers\TourController::class, 'deleteTour']);

// ===================
// DEPARTURES (Lịch khởi hành)
// ===================
$router->get('list-departure', [App\Controllers\DepartureController::class, 'getDepartures']);
$router->get('add-departure', [App\Controllers\DepartureController::class, 'createDeparture']);
$router->post('post-departure', [App\Controllers\DepartureController::class, 'postDeparture']);
$router->get('detail-departure/{id}', [App\Controllers\DepartureController::class, 'detailDeparture']);
$router->post('edit-departure/{id}', [App\Controllers\DepartureController::class, 'editDeparture']);
$router->get('delete-departure/{id}', [App\Controllers\DepartureController::class, 'deleteDeparture']);

// ===================
// SUPPLIER (Nhà cung cấp)
// ===================
$router->get('list-supplier', [App\Controllers\SupplierController::class, 'getSuppliers']);
$router->get('add-supplier', [App\Controllers\SupplierController::class, 'createSupplier']);
$router->post('post-supplier', [App\Controllers\SupplierController::class, 'postSupplier']);
$router->get('detail-supplier/{id}', [App\Controllers\SupplierController::class, 'detailSupplier']);
$router->post('edit-supplier/{id}', [App\Controllers\SupplierController::class, 'editSupplier']);
$router->get('delete-supplier/{id}', [App\Controllers\SupplierController::class, 'deleteSupplier']);

// ===================
// ITINERARY (Lịch trình)
// ===================
$router->get('list-itinerary', [App\Controllers\ItineraryController::class, 'getItinerary']);
$router->get('add-itinerary', [App\Controllers\ItineraryController::class, 'createItinerary']);
$router->post('post-itinerary', [App\Controllers\ItineraryController::class, 'postItinerary']);
$router->get('detail-itinerary/{id}', [App\Controllers\ItineraryController::class, 'detailItinerary']);
$router->post('edit-itinerary/{id}', [App\Controllers\ItineraryController::class, 'editItinerary']);
$router->get('delete-itinerary/{id}', [App\Controllers\ItineraryController::class, 'deleteItinerary']);

// ===================
// GUIDES (Hướng dẫn viên)
// ===================
$router->get('list-guides', [App\Controllers\GuidesController::class, 'listGuides']);
$router->get('add-guide', [App\Controllers\GuidesController::class, 'createGuide']);
$router->post('add-guide', [App\Controllers\GuidesController::class, 'postGuide']);
$router->get('detail-guide/{id}', [App\Controllers\GuidesController::class, 'detailGuide']);
$router->get('edit-guide/{id}', [App\Controllers\GuidesController::class, 'editGuide']);
$router->get('delete-guide/{id}', [App\Controllers\GuidesController::class, 'deleteGuide']);

// ===================
// BOOKINGS (Đặt tour)
// ===================
$router->get('list-booking', [App\Controllers\BookingController::class, 'getBookings']);
$router->get('add-booking', [App\Controllers\BookingController::class, 'createBooking']);
$router->post('post-booking', [App\Controllers\BookingController::class, 'postBooking']);
$router->get('detail-booking/{id}', [App\Controllers\BookingController::class, 'detailBooking']);
$router->post('edit-booking/{id}', [App\Controllers\BookingController::class, 'editBooking']);
$router->get('delete-booking/{id}', [App\Controllers\BookingController::class, 'deleteBooking']);

// ===========================
// BOOKING CUSTOMERS (Khách đi kèm trong booking)
// ===========================
$router->get('list-booking-customer', [App\Controllers\BookingCustomerController::class, 'listBookingCustomers']);       
$router->get('add-booking-customer', [App\Controllers\BookingCustomerController::class, 'createBookingCustomer']);      
$router->post('post-booking-customer', [App\Controllers\BookingCustomerController::class, 'postBookingCustomer']);      
$router->get('detail-booking-customer/{id}', [App\Controllers\BookingCustomerController::class, 'detailBookingCustomer']); 
$router->post('edit-booking-customer/{id}', [App\Controllers\BookingCustomerController::class, 'editBookingCustomer']);  
$router->get('delete-booking-customer/{id}', [App\Controllers\BookingCustomerController::class, 'deleteBookingCustomer']); 

// ===================
// CUSTOMERS (Khách hàng)
// ===================
$router->get('list-customer', [App\Controllers\CustomerController::class, 'getCustomers']);          
$router->get('add-customer', [App\Controllers\CustomerController::class, 'createCustomer']);      
$router->post('post-customer', [App\Controllers\CustomerController::class, 'postCustomer']);     
$router->get('detail-customer/{id}', [App\Controllers\CustomerController::class, 'detailCustomer']); 
$router->post('edit-customer/{id}', [App\Controllers\CustomerController::class, 'editCustomer']);  
$router->get('delete-customer/{id}', [App\Controllers\CustomerController::class, 'deleteCustomer']);

// ===================
// SERVICES (Dịch vụ)
// ===================
$router->get('list-service', [App\Controllers\ServiceController::class, 'listServices']);         
$router->get('add-service', [App\Controllers\ServiceController::class, 'createService']);       
$router->post('post-service', [App\Controllers\ServiceController::class, 'postService']);         
$router->get('detail-service/{id}', [App\Controllers\ServiceController::class, 'detailService']);  
$router->post('edit-service/{id}', [App\Controllers\ServiceController::class, 'editService']);     
$router->get('delete-service/{id}', [App\Controllers\ServiceController::class, 'deleteService']); 

// ===========================
// BOOKING SERVICES (Dịch vụ kèm theo booking)
// ===========================
$router->get('list-booking-service', [App\Controllers\BookingServiceController::class, 'listBookingServices']);        
$router->get('add-booking-service', [App\Controllers\BookingServiceController::class, 'createBookingService']);        
$router->post('post-booking-service', [App\Controllers\BookingServiceController::class, 'postBookingService']);       
$router->get('detail-booking-service/{id}', [App\Controllers\BookingServiceController::class, 'detailBookingService']); 
$router->post('edit-booking-service/{id}', [App\Controllers\BookingServiceController::class, 'editBookingService']);    
$router->get('delete-booking-service/{id}', [App\Controllers\BookingServiceController::class, 'deleteBookingService']); 

// =======================================
// SERVICE CHANGE REQUESTS (Yêu cầu thay đổi dịch vụ)
// =======================================
$router->get('list-request', [App\Controllers\ServiceChangeRequestController::class, 'listRequests']);         
$router->get('add-request', [App\Controllers\ServiceChangeRequestController::class, 'createRequest']);      
$router->post('post-request', [App\Controllers\ServiceChangeRequestController::class, 'postRequest']);     
$router->get('detail-request/{id}', [App\Controllers\ServiceChangeRequestController::class, 'detailRequest']);
$router->post('edit-request/{id}', [App\Controllers\ServiceChangeRequestController::class, 'editRequest']);   
$router->get('delete-request/{id}', [App\Controllers\ServiceChangeRequestController::class, 'deleteRequest']);

// =======================================
// SPECIAL REQUESTS (Yêu cầu đặc biệt)
// =======================================
$router->get('list-special-request', [App\Controllers\SpecialRequestController::class, 'listSpecialRequests']);         
$router->get('add-special-request', [App\Controllers\SpecialRequestController::class, 'createSpecialRequest']);       
$router->post('post-special-request', [App\Controllers\SpecialRequestController::class, 'postSpecialRequest']);         
$router->get('detail-special-request/{id}', [App\Controllers\SpecialRequestController::class, 'detailSpecialRequest']);
$router->post('edit-special-request/{id}', [App\Controllers\SpecialRequestController::class, 'editSpecialRequest']);  
$router->get('delete-special-request/{id}', [App\Controllers\SpecialRequestController::class, 'deleteSpecialRequest']);

// ===================
// PAYMENTS (Thanh toán)
// ===================
$router->get('list-payment', [App\Controllers\PaymentController::class, 'listPayments']);       
$router->get('add-payment', [App\Controllers\PaymentController::class, 'createPayment']);      
$router->post('post-payment', [App\Controllers\PaymentController::class, 'postPayment']);        
$router->get('detail-payment/{id}', [App\Controllers\PaymentController::class, 'detailPayment']);  
$router->post('edit-payment/{id}', [App\Controllers\PaymentController::class, 'editPayment']);     
$router->get('delete-payment/{id}', [App\Controllers\PaymentController::class, 'deletePayment']);  

// ===================
// ATTENDANCE (Điểm danh khách)
// ===================
$router->get('list-attendance', [App\Controllers\AttendanceController::class, 'listAttendance']);          
$router->get('add-attendance', [App\Controllers\AttendanceController::class, 'createAttendance']);         
$router->post('post-attendance', [App\Controllers\AttendanceController::class, 'postAttendance']);       
$router->get('detail-attendance/{id}', [App\Controllers\AttendanceController::class, 'detailAttendance']); 
$router->post('edit-attendance/{id}', [App\Controllers\AttendanceController::class, 'updateAttendance']);  
$router->get('delete-attendance/{id}', [App\Controllers\AttendanceController::class, 'deleteAttendance']); 

// ===================
// DISPATCHER
// ===================
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
echo $response;
