<?php

use Phroute\Phroute\RouteCollector;

$url = !isset($_GET['url']) ? "/" : $_GET['url'];
$router = new RouteCollector();

//====================
// FILTERS
//====================
$router->filter('auth', function(){
    if(!isset($_SESSION['auth']) || empty($_SESSION['auth'])){
        header('location: ' . BASE_URL . 'login'); die;
    }
});

//====================
// TRANG CHỦ
//====================
$router->get('/', function(){
    return "trang chủ";
});

//====================
// AUTH (Login / Register / Logout)
//====================
$router->get('login', [App\Controllers\AuthController::class, 'login']);
$router->post('login', [App\Controllers\AuthController::class, 'loginPost']); 
$router->get('register', [App\Controllers\AuthController::class, 'register']);
$router->post('register', [App\Controllers\AuthController::class, 'registerPost']); 
$router->get('logout', [App\Controllers\AuthController::class, 'logout']);
$router->get('dashboard', [App\Controllers\AuthController::class, 'dashboard']);

//====================
// USER
//====================
$router->get('list-users', [App\Controllers\UserController::class, 'index']); // danh sách
$router->get('add-user', [App\Controllers\UserController::class, 'create']); // form thêm
$router->post('post-user', [App\Controllers\UserController::class,'postUser']); // xử lý thêm
$router->get('detail-user/{id}', [App\Controllers\UserController::class, 'updateUser']); // form sửa
$router->post('edit-user/{id}', [App\Controllers\UserController::class, 'updateUser']); // xử lý sửa
$router->get('delete-user/{id}', [App\Controllers\UserController::class, 'deleteUser']); // xóa

//====================
// ROLES
//====================
$router->get('list-roles', [App\Controllers\RolesController::class,'getRoles']);
$router->get('add-roles', [App\Controllers\RolesController::class,'createRoles']);
$router->post('post-roles', [App\Controllers\RolesController::class,'postRoles']);
$router->get('detail-roles/{id}', [App\Controllers\RolesController::class,'detailRoles']);
$router->post('edit-roles/{id}', [App\Controllers\RolesController::class,'editRoles']);
$router->get('delete-roles/{id}', [App\Controllers\RolesController::class,'deleteRoles']);

//====================
// TOURS
//====================
$router->get('list-tours', [App\Controllers\TourController::class, 'getTours']);
$router->get('add-tour', [App\Controllers\TourController::class, 'createTour']);
$router->post('post-tour', [App\Controllers\TourController::class, 'postTour']);
$router->get('detail-tour/{id}', [App\Controllers\TourController::class, 'detailTour']);
$router->post('edit-tour/{id}', [App\Controllers\TourController::class, 'editTour']);
$router->get('delete-tour/{id}', [App\Controllers\TourController::class, 'deleteTour']);

//====================
// DEPARTURE
//====================
$router->get('list-departure', [App\Controllers\DepartureController::class, 'getDepartures']);
$router->get('add-departure', [App\Controllers\DepartureController::class, 'createDeparture']);
$router->post('post-departure', [App\Controllers\DepartureController::class, 'postDeparture']);
$router->get('detail-departure/{id}', [App\Controllers\DepartureController::class, 'detailDeparture']);
$router->post('edit-departure/{id}', [App\Controllers\DepartureController::class, 'editDeparture']);
$router->get('delete-departure/{id}', [App\Controllers\DepartureController::class, 'deleteDeparture']);

//====================
// SUPPLIER
//====================
$router->get('list-supplier', [App\Controllers\SupplierController::class, 'getSuppliers']);
$router->get('add-supplier', [App\Controllers\SupplierController::class, 'createSupplier']);
$router->post('post-supplier', [App\Controllers\SupplierController::class, 'postSupplier']);
$router->get('detail-supplier/{id}', [App\Controllers\SupplierController::class, 'detailSupplier']);
$router->post('edit-supplier/{id}', [App\Controllers\SupplierController::class, 'editSupplier']);
$router->get('delete-supplier/{id}', [App\Controllers\SupplierController::class, 'deleteSupplier']);

//====================
// TOUR LOGS
//====================
$router->get('list-tourlog', [App\Controllers\TourLogController::class, 'getLogs']);
$router->get('add-tourlog', [App\Controllers\TourLogController::class, 'createLog']);
$router->post('post-tourlog', [App\Controllers\TourLogController::class, 'postLog']);
$router->get('detail-tourlog/{id}', [App\Controllers\TourLogController::class, 'detailLog']);
$router->post('edit-tourlog/{id}', [App\Controllers\TourLogController::class, 'editLog']);
$router->get('delete-tourlog/{id}', [App\Controllers\TourLogController::class, 'deleteLog']);

//====================
// TOUR IMAGES
//====================
$router->get('list-tourimg', [App\Controllers\TourImgController::class, 'getImages']);
$router->get('add-tourimg', [App\Controllers\TourImgController::class, 'createImage']);
$router->post('post-tourimg', [App\Controllers\TourImgController::class, 'postImage']);
$router->get('detail-tourimg/{id}', [App\Controllers\TourImgController::class, 'detailImage']);
$router->post('edit-tourimg/{id}', [App\Controllers\TourImgController::class, 'editImage']);
$router->get('delete-tourimg/{id}', [App\Controllers\TourImgController::class, 'deleteImage']);

//====================
// ITINERARY
//====================
$router->get('list-itinerary', [App\Controllers\ItineraryController::class, 'getItinerary']);
$router->get('add-itinerary', [App\Controllers\ItineraryController::class, 'createItinerary']);
$router->post('post-itinerary', [App\Controllers\ItineraryController::class, 'postItinerary']);
$router->get('detail-itinerary/{id}', [App\Controllers\ItineraryController::class, 'detailItinerary']);
$router->post('edit-itinerary/{id}', [App\Controllers\ItineraryController::class, 'editItinerary']);
$router->get('delete-itinerary/{id}', [App\Controllers\ItineraryController::class, 'deleteItinerary']);

//====================
// GUIDES (HDV)
//====================
$router->get('list-guides', [App\Controllers\GuidesController::class, 'getGuides']);
$router->get('add-guide', [App\Controllers\GuidesController::class, 'createGuides']);
$router->post('post-guides', [App\Controllers\GuidesController::class, 'postGuides']);
$router->get('detail-guide/{id}', [App\Controllers\GuidesController::class, 'detailGuides']);
$router->post('edit-guide/{id}', [App\Controllers\GuidesController::class, 'editGuides']);
$router->get('delete-guide/{id}', [App\Controllers\GuidesController::class, 'deleteGuides']);

//====================
// BOOKINGS
//====================
$router->get('list-booking', [App\Controllers\BookingController::class,'getBookings']);
$router->get('add-booking', [App\Controllers\BookingController::class,'createBooking']);
$router->post('post-booking', [App\Controllers\BookingController::class, 'postBooking']);
$router->get('detail-booking/{id}', [App\Controllers\BookingController::class,'detailBooking']);
$router->post('edit-booking/{id}', [App\Controllers\BookingController::class,'editBooking']);
$router->get('delete-booking/{id}', [App\Controllers\BookingController::class,'deleteBooking']);

// booking_customers
$router->get('list-bookingCus/{booking_id}', [App\Controllers\BookingCustomerController::class,'getBookId']);

//====================
// DISPATCH
//====================
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
echo $response;

