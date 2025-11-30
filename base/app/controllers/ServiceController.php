<?php
namespace App\Controllers;

use App\Models\ServiceModel;

/**
 * Class ServiceController
 * CRUD actions for services
 */
class ServiceController extends BaseController
{
    public $service;

    public function __construct()
    {
        $this->service = new ServiceModel();
    }

    // List services
    public function getServices()
    {
        $services = $this->service->getAllServices();
        $this->render("service.listService", ['services' => $services]);
    }

    // Show add form
    public function createService()
    {
        // show list of tours so user can attach package to a tour
        $tourModel = new \App\Models\TourModel();
        $tours = $tourModel->getAllTours();
        $this->render('service.addService', ['tours' => $tours]);
    }

    // Handle add form submit
    public function postService()
    {
        $error = [];

        $package_name = $_POST['package_name'] ?? '';
        $price = $_POST['price'] ?? '';
        $currency = $_POST['currency'] ?? 'VND';
        $tour_id = $_POST['tour_id'] ?? null;
        $is_optional = isset($_POST['is_optional']) ? 1 : 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($package_name)) {
            $error['package_name'] = 'Tên gói/dịch vụ không được để trống';
        }
        if ($price === '' || !is_numeric($price)) {
            $error['price'] = 'Giá phải là số và không được để trống';
        }

        if (count($error) >= 1) {
            redirect('errors', $error, 'add-service');
        }

            $check = $this->service->addService([
                'tour_id' => $tour_id,
                'package_name' => $package_name,
                'description' => $_POST['description'] ?? null,
                'price' => $price,
                'currency' => $currency,
                'is_optional' => $is_optional,
                'is_active' => $is_active,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($check) {
            redirect('success', 'Thêm dịch vụ thành công', 'list-service');
        } else {
            redirect('errors', 'Thêm thất bại, vui lòng thử lại', 'add-service');
        }
    }

    // Delete service
    public function deleteService($id)
    {
        $check = $this->service->deleteService($id);
        if ($check) {
            redirect('success', 'Xóa thành công', 'list-service');
        } else {
            redirect('errors', 'Xóa thất bại', 'list-service');
        }
    }

    // Detail / edit form
    public function detailService($id)
    {
        $detail = $this->service->getServiceById($id);
            $tourModel = new \App\Models\TourModel();
            $tours = $tourModel->getAllTours();
            return $this->render('service.editService', ['detail' => $detail, 'tours' => $tours]);
    }

    // Handle edit submit
    public function editService($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            $package_name = $_POST['package_name'] ?? '';
            $price = $_POST['price'] ?? '';
            $currency = $_POST['currency'] ?? 'VND';
            $tour_id = $_POST['tour_id'] ?? null;
            $is_optional = isset($_POST['is_optional']) ? 1 : 0;
            $is_active = isset($_POST['is_active']) ? 1 : 0;

            if (empty($package_name)) {
                $error['package_name'] = 'Tên gói/dịch vụ không được để trống';
            }
            if ($price === '' || !is_numeric($price)) {
                $error['price'] = 'Giá phải là số và không được để trống';
            }

            $route = 'detail-service/' . $id;
            if (count($error) >= 1) {
                redirect('errors', $error, $route);
            }

            $check = $this->service->updateService($id, [
                'tour_id' => $tour_id,
                'package_name' => $package_name,
                'description' => $_POST['description'] ?? null,
                'price' => $price,
                'currency' => $currency,
                'is_optional' => $is_optional,
                'is_active' => $is_active,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($check) {
                redirect('success', 'Sửa dịch vụ thành công', 'list-service');
            } else {
                redirect('errors', 'Sửa thất bại, vui lòng thử lại', $route);
            }
        }
    }

}

?>
