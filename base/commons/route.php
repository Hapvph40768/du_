<?php

use Phroute\Phroute\RouteCollector;

$url = !isset($_GET['url']) ? "/" : $_GET['url'];

$router = new RouteCollector();

// filter check đăng nhập
$router->filter('auth', function(){
    if(!isset($_SESSION['auth']) || empty($_SESSION['auth'])){
        header('location: ' . BASE_URL . 'login');die;
    }
});


// bắt đầu định nghĩa ra các đường dẫn
$router->get('/', function(){
    return "trang chủ";
});

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
# NB. You can cache the return value from $router->getData() so you don't have to create the routes each request - massive speed gains
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);

// Print out the value returned from the dispatched function
echo $response;


?>