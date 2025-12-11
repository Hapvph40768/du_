<?php
use Phroute\Phroute\RouteCollector;

$url = !isset($_GET['url']) ? "/" : $_GET['url'];
$router = new RouteCollector();

// ===================
// FILTERS (Middleware)
// ===================
$router->filter('auth', function(){
    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . 'login');
        return false;
    }
});

$router->filter('admin', function(){
    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header('Location: ' . BASE_URL . 'login');
        return false;
    }
});

$router->filter('guide', function(){
    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
        header('Location: ' . BASE_URL . 'login');
        return false;
    }
});

// ===================
// PUBLIC ROUTES
// ===================
// Auth (Login/Register)
$router->get('/', [App\Controllers\AuthController::class, 'index']);
$router->get('login', [App\Controllers\AuthController::class, 'showLogin']);
$router->post('login', [App\Controllers\AuthController::class, 'login']);
$router->get('register', [App\Controllers\AuthController::class, 'showRegister']);
$router->post('register', [App\Controllers\AuthController::class, 'register']);

// ===================
// AUTHENTICATED ROUTES
// ===================
$router->group(['before' => 'auth'], function($router) {
    $router->get('logout', [App\Controllers\AuthController::class, 'logout']);
    
    // Client Profile Setup
    $router->get('profile-setup', [App\Controllers\CustomerController::class, 'profileSetup']);
    $router->post('profile-setup', [App\Controllers\CustomerController::class, 'postProfileSetup']);
    
    // Client Dashboard
    $router->get('client-dashboard', [App\Controllers\AuthController::class, 'clientDashboard']);
});

// ===================
// GUIDE ROUTES
// ===================
$router->group(['before' => 'guide'], function($router) {
    $router->get('guide-dashboard', [App\Controllers\AuthController::class, 'guideDashboard']);
    
    // Attendance for Guides
    $router->get('list-guide-attendance', [App\Controllers\GuideAttendanceController::class, 'listAttendance']);          
    $router->get('detail-guide-attendance/{id}', [App\Controllers\GuideAttendanceController::class, 'detailAttendance']); 
    $router->post('edit-guide-attendance/{id}', [App\Controllers\GuideAttendanceController::class, 'updateAttendance']);  
    
    // Guide SCR Requests
    $router->get('list-guide-scr', [App\Controllers\GuideScrController::class, 'listGuideScrRequests']);
    $router->get('add-guide-scr', [App\Controllers\GuideScrController::class, 'createGuideScrRequest']);
    $router->post('post-guide-scr', [App\Controllers\GuideScrController::class, 'postGuideScrRequest']);
    $router->get('detail-guide-scr/{id}', [App\Controllers\GuideScrController::class, 'detailGuideScrRequest']);
    $router->post('edit-guide-scr/{id}', [App\Controllers\GuideScrController::class, 'editGuideScrRequest']);
    $router->get('delete-guide-scr/{id}', [App\Controllers\GuideScrController::class, 'deleteGuideScrRequest']);

    // Guide Special Requests (SR)
    $router->get('list-guide-sr', [App\Controllers\GuideSrController::class, 'listGuideSr']);
    $router->get('add-guide-sr', [App\Controllers\GuideSrController::class, 'createGuideSr']);
    $router->post('post-guide-sr', [App\Controllers\GuideSrController::class, 'postGuideSr']);
    $router->get('detail-guide-sr/{id}', [App\Controllers\GuideSrController::class, 'detailGuideSr']);
    $router->post('edit-guide-sr/{id}', [App\Controllers\GuideSrController::class, 'editGuideSr']);

    // Guide Departures
    $router->get('list-guide-departure', [App\Controllers\GuideDepartureController::class, 'listGuideDepartures']);

    // Guide Itineraries
    $router->get('list-guide-itinerary', [App\Controllers\GuideItineraryController::class, 'listGuideItinerary']);
    $router->get('detail-guide-itinerary-departure/{departure_id}', [App\Controllers\GuideItineraryController::class, 'detailGuideItinerariesByDeparture']);

    // Guide Tour (List Guides)
    $router->get('list-guide-tour', [App\Controllers\GuideTourController::class, 'listTourGuides']);

    // Guide Customers
    $router->get('list-guide-customer', [App\Controllers\GuideCustomerController::class, 'getGuideCustomers']);

    // GUIDE DASHBOARD ACTIONS
    $router->post('post-guide-status', [App\Controllers\GuideController::class, 'updateStatus']);
});

// ===================
// ADMIN ROUTES
// ===================
$router->group(['before' => 'admin'], function($router) {
    $router->get('dashboard', [App\Controllers\AuthController::class, 'dashboard']);

    // USER (Người dùng)
    $router->get('list-user', [App\Controllers\UserController::class, 'listUsers']);
    $router->get('add-user', [App\Controllers\UserController::class, 'createUser']);
    $router->post('post-user', [App\Controllers\UserController::class, 'postUser']);
    $router->get('detail-user/{id}', [App\Controllers\UserController::class, 'detailUser']);
    $router->post('edit-user/{id}', [App\Controllers\UserController::class, 'editUser']);
    $router->get('delete-user/{id}', [App\Controllers\UserController::class, 'deleteUser']);

    // TOURS (Tour du lịch)
    $router->get('list-tours', [App\Controllers\TourController::class, 'getTours']);
    $router->get('add-tour', [App\Controllers\TourController::class, 'createTour']);
    $router->post('post-tour', [App\Controllers\TourController::class, 'postTour']);
    $router->get('detail-tour/{id}', [App\Controllers\TourController::class, 'detailTour']);
    $router->get('show-tour/{id}', [App\Controllers\TourController::class, 'showTour']);
    $router->post('edit-tour/{id}', [App\Controllers\TourController::class, 'editTour']);
    $router->get('delete-tour/{id}', [App\Controllers\TourController::class, 'deleteTour']);

    // TOUR IMAGES (Thư viện ảnh)
    $router->get('tour-images/{id}', [App\Controllers\TourImageController::class, 'listImagesByTour']);
    $router->get('list-tour-images', [App\Controllers\TourImageController::class, 'listImages']);
    $router->get('add-tour-image', [App\Controllers\TourImageController::class, 'createImage']);
    $router->post('post-tour-image', [App\Controllers\TourImageController::class, 'postImage']);
    $router->get('detail-tour-image/{id}', [App\Controllers\TourImageController::class, 'detailImage']);
    $router->post('edit-tour-image/{id}', [App\Controllers\TourImageController::class, 'editImage']);
    $router->get('delete-tour-image/{id}', [App\Controllers\TourImageController::class, 'deleteImage']);

    // TOUR LOGS (Nhật ký hoạt động)
    $router->get('list-tour-logs', [App\Controllers\TourLogController::class, 'listLogs']);
    $router->get('add-tour-log', [App\Controllers\TourLogController::class, 'createLog']);
    $router->post('post-tour-log', [App\Controllers\TourLogController::class, 'postLog']);
    $router->get('detail-tour-log/{id}', [App\Controllers\TourLogController::class, 'detailLog']);
    $router->post('edit-tour-log/{id}', [App\Controllers\TourLogController::class, 'editLog']);
    $router->get('delete-tour-log/{id}', [App\Controllers\TourLogController::class, 'deleteLog']);

    // TOUR GUIDE (Phân công HDV)
    $router->get('list-tour-guide', [App\Controllers\TourGuideController::class, 'listTourGuides']);
    $router->get('add-tour-guide', [App\Controllers\TourGuideController::class, 'createTourGuide']);
    $router->post('post-tour-guide', [App\Controllers\TourGuideController::class, 'postTourGuide']);
    $router->get('detail-tour-guide/{id}', [App\Controllers\TourGuideController::class, 'detailTourGuide']);
    $router->post('edit-tour-guide/{id}', [App\Controllers\TourGuideController::class, 'editTourGuide']);
    $router->get('delete-tour-guide/{id}', [App\Controllers\TourGuideController::class, 'deleteTourGuide']);

    // DEPARTURES (Lịch khởi hành)
    $router->get('list-departure', [App\Controllers\DepartureController::class, 'getDepartures']);
    $router->get('add-departure', [App\Controllers\DepartureController::class, 'createDeparture']);
    $router->post('post-departure', [App\Controllers\DepartureController::class, 'postDeparture']);
    $router->get('detail-departure/{id}', [App\Controllers\DepartureController::class, 'detailDeparture']);
    $router->get('ajax-detail-departure/{id}', [App\Controllers\DepartureController::class, 'ajaxDetailDeparture']);
    $router->get('edit-departure/{id}', [App\Controllers\DepartureController::class, 'detailDeparture']);
    $router->post('edit-departure/{id}', [App\Controllers\DepartureController::class, 'editDeparture']);
    $router->get('delete-departure/{id}', [App\Controllers\DepartureController::class, 'deleteDeparture']);

    // SUPPLIER (Nhà cung cấp)
    $router->get('list-supplier', [App\Controllers\SupplierController::class, 'getSuppliers']);
    $router->get('add-supplier', [App\Controllers\SupplierController::class, 'createSupplier']);
    $router->post('post-supplier', [App\Controllers\SupplierController::class, 'postSupplier']);
    $router->get('detail-supplier/{id}', [App\Controllers\SupplierController::class, 'detailSupplier']);
    $router->post('edit-supplier/{id}', [App\Controllers\SupplierController::class, 'editSupplier']);
    $router->get('delete-supplier/{id}', [App\Controllers\SupplierController::class, 'deleteSupplier']);

    // ITINERARY (Lịch trình)
    $router->get('list-itinerary', [App\Controllers\ItineraryController::class, 'getItinerary']);
    $router->get('list-itinerary/{departure_id}', [App\Controllers\ItineraryController::class, 'detailItinerariesByDeparture']);
    $router->get('add-itinerary', [App\Controllers\ItineraryController::class, 'createItinerary']);
    $router->post('post-itinerary', [App\Controllers\ItineraryController::class, 'postItinerary']);
    $router->get('detail-itinerary/{id}', [App\Controllers\ItineraryController::class, 'detailItinerary']);
    $router->post('edit-itinerary/{id}', [App\Controllers\ItineraryController::class, 'editItinerary']);
    $router->get('delete-itinerary/{id}', [App\Controllers\ItineraryController::class, 'deleteItinerary']);

    // GUIDES (Quản lý hồ sơ HDV)
    $router->get('list-guides', [App\Controllers\GuidesController::class, 'listGuide']);
    $router->get('add-guide', [App\Controllers\GuidesController::class, 'createGuide']);
    $router->post('post-guide', [App\Controllers\GuidesController::class, 'postGuide']);
    $router->get('detail-guide/{id}', [App\Controllers\GuidesController::class, 'detailGuide']);
    $router->get('edit-guide/{id}', [App\Controllers\GuidesController::class, 'editGuide']);
    $router->get('delete-guide/{id}', [App\Controllers\GuidesController::class, 'deleteGuide']);

    // GUIDE DASHBOARD ACTIONS
    // GUIDE DASHBOARD ACTIONS - Moved to Guide Group

    // BOOKINGS (Đặt tour)
    $router->get('list-booking', [App\Controllers\BookingController::class, 'getBookings']);
    $router->get('add-booking', [App\Controllers\BookingController::class, 'createBooking']);
    $router->post('post-booking', [App\Controllers\BookingController::class, 'postBooking']);
    $router->get('detail-booking/{id}', [App\Controllers\BookingController::class, 'detailBooking']);
    $router->get('view-booking/{id}', [App\Controllers\BookingController::class, 'viewBooking']);
    $router->post('edit-booking/{id}', [App\Controllers\BookingController::class, 'editBooking']);
    $router->get('delete-booking/{id}', [App\Controllers\BookingController::class, 'deleteBooking']);

    // BOOKING CUSTOMERS
    $router->get('list-booking-customer', [App\Controllers\BookingCustomerController::class, 'listBookingCustomers']);       
    $router->get('add-booking-customer', [App\Controllers\BookingCustomerController::class, 'createBookingCustomer']);      
    $router->post('post-booking-customer', [App\Controllers\BookingCustomerController::class, 'postBookingCustomer']);      
    $router->get('detail-booking-customer/{id}', [App\Controllers\BookingCustomerController::class, 'detailBookingCustomer']); 
    $router->post('edit-booking-customer/{id}', [App\Controllers\BookingCustomerController::class, 'editBookingCustomer']);  
    $router->get('delete-booking-customer/{id}', [App\Controllers\BookingCustomerController::class, 'deleteBookingCustomer']); 
    $router->post('import-booking-customer', [App\Controllers\BookingCustomerController::class, 'importBookingCustomer']); 

    // CUSTOMERS
    $router->get('list-customer', [App\Controllers\CustomerController::class, 'getCustomers']);          
    $router->get('add-customer', [App\Controllers\CustomerController::class, 'createCustomer']);      
    $router->post('post-customer', [App\Controllers\CustomerController::class, 'postCustomer']);     
    $router->get('detail-customer/{id}', [App\Controllers\CustomerController::class, 'detailCustomer']); 
    $router->post('edit-customer/{id}', [App\Controllers\CustomerController::class, 'editCustomer']);  
    $router->get('delete-customer/{id}', [App\Controllers\CustomerController::class, 'deleteCustomer']);

    // SERVICES
    $router->get('list-service', [App\Controllers\ServiceController::class, 'listServices']);         
    $router->get('add-service', [App\Controllers\ServiceController::class, 'createService']);       
    $router->post('post-service', [App\Controllers\ServiceController::class, 'postService']);         
    $router->get('detail-service/{id}', [App\Controllers\ServiceController::class, 'detailService']);  
    $router->post('edit-service/{id}', [App\Controllers\ServiceController::class, 'editService']);     
    $router->get('delete-service/{id}', [App\Controllers\ServiceController::class, 'deleteService']); 

    // BOOKING SERVICES
    $router->get('list-booking-service', [App\Controllers\BookingServiceController::class, 'listBookingServices']);        
    $router->get('add-booking-service', [App\Controllers\BookingServiceController::class, 'createBookingService']);        
    $router->post('post-booking-service', [App\Controllers\BookingServiceController::class, 'postBookingService']);       
    $router->get('detail-booking-service/{id}', [App\Controllers\BookingServiceController::class, 'detailBookingService']); 
    $router->post('edit-booking-service/{id}', [App\Controllers\BookingServiceController::class, 'editBookingService']);    
    $router->get('delete-booking-service/{id}', [App\Controllers\BookingServiceController::class, 'deleteBookingService']); 

    // SERVICE CHANGE REQUESTS
    $router->get('list-request', [App\Controllers\ServiceChangeRequestController::class, 'listRequests']);         
    $router->get('add-request', [App\Controllers\ServiceChangeRequestController::class, 'createRequest']);      
    $router->post('post-request', [App\Controllers\ServiceChangeRequestController::class, 'postRequest']);     
    $router->get('detail-request/{id}', [App\Controllers\ServiceChangeRequestController::class, 'detailRequest']);
    $router->post('edit-request/{id}', [App\Controllers\ServiceChangeRequestController::class, 'editRequest']);   
    $router->get('delete-request/{id}', [App\Controllers\ServiceChangeRequestController::class, 'deleteRequest']);

    // SPECIAL REQUESTS
    $router->get('list-special-request', [App\Controllers\SpecialRequestController::class, 'listSpecialRequests']);         
    $router->get('add-special-request', [App\Controllers\SpecialRequestController::class, 'createSpecialRequest']);       
    $router->post('post-special-request', [App\Controllers\SpecialRequestController::class, 'postSpecialRequest']);         
    $router->get('detail-special-request/{id}', [App\Controllers\SpecialRequestController::class, 'detailSpecialRequest']);
    $router->post('edit-special-request/{id}', [App\Controllers\SpecialRequestController::class, 'editSpecialRequest']);  
    $router->get('delete-special-request/{id}', [App\Controllers\SpecialRequestController::class, 'deleteSpecialRequest']);

    // PAYMENTS
    $router->get('list-payment', [App\Controllers\PaymentController::class, 'listPayments']);       
    $router->get('add-payment', [App\Controllers\PaymentController::class, 'createPayment']);      
    $router->post('post-payment', [App\Controllers\PaymentController::class, 'postPayment']);        
    $router->get('detail-payment/{id}', [App\Controllers\PaymentController::class, 'detailPayment']);  
    $router->post('edit-payment/{id}', [App\Controllers\PaymentController::class, 'editPayment']);     
    $router->get('delete-payment/{id}', [App\Controllers\PaymentController::class, 'deletePayment']);  

    // ATTENDANCE (Admin)
    $router->get('list-attendance', [App\Controllers\AttendanceController::class, 'listAttendance']);          
    $router->get('add-attendance', [App\Controllers\AttendanceController::class, 'createAttendance']);
    // Alias to satisfy user preference for "detail/update" URL context
    $router->get('detail-attendance', [App\Controllers\AttendanceController::class, 'createAttendance']);         
    $router->post('post-attendance', [App\Controllers\AttendanceController::class, 'postAttendance']);       
    $router->get('detail-attendance/{id}', [App\Controllers\AttendanceController::class, 'detailAttendance']); 
    $router->post('edit-attendance/{id}', [App\Controllers\AttendanceController::class, 'updateAttendance']);  
    $router->get('delete-attendance/{id}', [App\Controllers\AttendanceController::class, 'deleteAttendance']); 

    // FINANCIAL REPORTS
    $router->get('revenue-report', [App\Controllers\ReportController::class, 'revenueReport']);
    $router->post('add-cost', [App\Controllers\ReportController::class, 'addCost']);
    $router->get('delete-cost/{id}', [App\Controllers\ReportController::class, 'deleteCost']);
});

// ===================
// DISPATCHER
// ===================
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
echo $response;
