<?php
use Phroute\Phroute\RouteCollector;

$url = !isset($_GET['url']) ? "/" : $_GET['url'];
$router = new RouteCollector();

// -------------------
// Trang chủ
// -------------------
$router->get('/', function () {
    return "Trang chủ";
});

// -------------------
// AUTH
// -------------------
$router->get('login', [App\Controllers\AuthController::class, 'showLogin']);
$router->post('login', [App\Controllers\AuthController::class, 'login']);

$router->get('register', [App\Controllers\AuthController::class, 'showRegister']);
$router->post('register', [App\Controllers\AuthController::class, 'register']);

$router->get('logout', [App\Controllers\AuthController::class, 'logout']);
$router->get('dashboard', [App\Controllers\AuthController::class, 'dashboard']);

// //USER

// $router->get('list-user', [App\Controllers\UserController::class, 'index']);
// $router->get('add-user', [App\Controllers\UserController::class, 'create']);
// $router->post('store-user', [App\Controllers\UserController::class, 'store']);
// $router->get('edit-user/{id}', [App\Controllers\UserController::class, 'edit']);
// $router->post('update-user/{id}', [App\Controllers\UserController::class, 'update']);
// $router->get('delete-user/{id}', [App\Controllers\UserController::class, 'delete']);


//TOURS: Tour du lịch

//danh sách tour
$router->get('list-tours', [App\Controllers\TourController::class, 'getTours']);
//them tour
$router->get('add-tour', handler: [App\Controllers\TourController::class, 'createTour']);
$router->post('post-tour', [App\Controllers\TourController::class, 'postTour']);
// chức năng sửa
$router->get('detail-tour/{id}', [App\Controllers\TourController::class, 'detailTour']);
$router->post('edit-tour/{id}', [App\Controllers\TourController::class, 'editTour']);
//xoa tour
$router->get('delete-tour/{id}', [App\Controllers\TourController::class, 'deleteTour']);


// DEPARTURES: Lịch khởi hành của tour

//Danh sách đợt khởi hành
$router->get('list-departure', [App\Controllers\DepartureController::class, 'getDepartures']);
//Thêm đợt khởi hành
$router->get('add-departure', [App\Controllers\DepartureController::class, 'createDeparture']);
$router->post('post-departure', [App\Controllers\DepartureController::class, 'postDeparture']);
// sua đợt khởi hành
$router->get('detail-departure/{id}', [App\Controllers\DepartureController::class, 'detailDeparture']);
$router->post('edit-departure/{id}', [App\Controllers\DepartureController::class, 'editDeparture']);
//xoa đợt khởi hành
$router->get('delete-departure/{id}', [App\Controllers\DepartureController::class, 'deleteDeparture']);

//================================================================
// QUẢN LÝ NHÀ CUNG CẤP (SUPPLIER)
//================================================================
// Danh sách nhà cung cấp
$router->get('list-supplier', [App\Controllers\SupplierController::class, 'getSuppliers']);
// Thêm nhà cung cấp
$router->get('add-supplier', [App\Controllers\SupplierController::class, 'createSupplier']);
$router->post('post-supplier', [App\Controllers\SupplierController::class, 'postSupplier']);
// Sửa nhà cung cấp (Hiển thị chi tiết và xử lý POST)
$router->get('detail-supplier/{id}', [App\Controllers\SupplierController::class, 'detailSupplier']);
$router->post('edit-supplier/{id}', [App\Controllers\SupplierController::class, 'editSupplier']);
// Xóa nhà cung cấp
$router->get('delete-supplier/{id}', [App\Controllers\SupplierController::class, 'deleteSupplier']);


//ITINERARY: Lịch trình theo ngày

// danh sach
$router->get('list-itinerary', [App\Controllers\ItineraryController::class, 'getItinerary']);
// them moi
$router->get('add-itinerary', [App\Controllers\ItineraryController::class, 'createItinerary']);
$router->post('post-itinerary', [App\Controllers\ItineraryController::class, 'postItinerary']);
// sửa 
$router->get('detail-itinerary/{id}', [App\Controllers\ItineraryController::class, 'detailItinerary']);
$router->post('edit-itinerary/{id}', [App\Controllers\ItineraryController::class, 'editItinerary']);
//xoa
$router->get('delete-itinerary/{id}', [App\Controllers\ItineraryController::class, 'deleteItinerary']);

// GUIDES:HDV
$router->get('list-guides', [App\Controllers\GuidesController::class, 'getGuides']);
$router->get('add-guide', [App\Controllers\GuidesController::class, 'createGuides']);
$router->post('add-guide', [App\Controllers\GuidesController::class, 'postGuides']);
$router->get('detail-guide/{id}', [App\Controllers\GuidesController::class, 'detailGuides']);
$router->get('edit-guide/{id}', [App\Controllers\GuidesController::class, 'editGuides']);
$router->get('delete-guid/{id}', [App\Controllers\GuidesController::class, 'deleteGuide']);

//BOOKINGS: Đặt tour

//danh sach
$router->get('list-booking',[App\Controllers\BookingController::class,'getBookings']);
//them
$router->get('add-booking',[App\Controllers\BookingController::class,'createBooking']);
$router->post('post-booking',[App\Controllers\BookingController::class, 'postBooking']);
//sua
$router->get('detail-booking/{id}', [App\Controllers\BookingController::class, 'detailBooking']);
$router->post('edit-booking/{id}', [App\Controllers\BookingController::class, 'editBooking']);
//xoa
$router->get('delete-booking/{id}',[App\Controllers\BookingController::class,'deleteBooking']);

//booking_customers
//danh sach
$router->get('list-bookingCus/{booking_id}',[App\Controllers\BookingCustomerController::class,'getBookId']);
// -------------------
// Dispatcher
// -------------------
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
echo $response;