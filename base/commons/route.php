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


# NB. You can cache the return value from $router->getData() so you don't have to create the routes each request - massive speed gains
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);

// Print out the value returned from the dispatched function
echo $response;

?>