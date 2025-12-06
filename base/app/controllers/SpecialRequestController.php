<?php
namespace App\Controllers;

use App\Models\SpecialRequestsModel;
use App\Models\CustomerModel;

class SpecialRequestController extends BaseController
{
    protected $requestModel;

    public function __construct()
    {
        $this->requestModel = new SpecialRequestsModel();
    }

    // 1. Danh sách yêu cầu đặc biệt
    public function listSpecialRequests()
    {
        $requests = $this->requestModel->getAllSpecialRequests();
        return $this->render("admin.special_request.listSpecialRequest", ['requests' => $requests]);
    }

    // 2. Form thêm mới
    public function createSpecialRequest()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->getAllCustomers();
        return $this->render("admin.special_request.addSpecialRequest", ['customers' => $customers]);
    }

    // 3. Xử lý thêm mới
    public function postSpecialRequest()
    {
        $error = [];
        $customer_id = $_POST['customer_id'] ?? '';
        $request     = $_POST['request'] ?? '';

        if (empty($customer_id)) $error['customer_id'] = "Phải chọn khách hàng.";
        if (empty($request)) $error['request'] = "Nội dung yêu cầu không được để trống.";

        if (!empty($error)) {
            redirect('errors', $error, 'add-special-request');
        }

        $check = $this->requestModel->addSpecialRequest([
            'customer_id' => $customer_id,
            'request'     => $request,
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Thêm yêu cầu đặc biệt thành công", 'list-special-request');
        } else {
            redirect('errors', "Thêm thất bại", 'add-special-request');
        }
    }

    // 4. Chi tiết để sửa
    public function detailSpecialRequest($id)
    {
        $detail = $this->requestModel->getSpecialRequestById($id);
        $customerModel = new CustomerModel();
        $customers = $customerModel->getAllCustomers();
        return $this->render("admin.special_request.editSpecialRequest", [
            'detail'    => $detail,
            'customers' => $customers
        ]);
    }

    // 5. Xử lý sửa
    public function editSpecialRequest($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $customer_id = $_POST['customer_id'] ?? '';
        $request     = $_POST['request'] ?? '';

        $error = [];
        if (empty($customer_id)) $error['customer_id'] = "Phải chọn khách hàng.";
        if (empty($request)) $error['request'] = "Nội dung yêu cầu không được để trống.";

        $route = 'detail-special-request/' . $id;
        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $check = $this->requestModel->updateSpecialRequest($id, [
            'customer_id' => $customer_id,
            'request'     => $request,
            'updated_at'  => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Cập nhật yêu cầu thành công", 'list-special-request');
        } else {
            redirect('errors', "Cập nhật thất bại", $route);
        }
    }

    // 6. Xóa
    public function deleteSpecialRequest($id)
    {
        $check = $this->requestModel->deleteSpecialRequest($id);
        if ($check) {
            redirect('success', "Xóa yêu cầu thành công", 'list-special-request');
        } else {
            redirect('errors', "Xóa thất bại", 'list-special-request');
        }
    }
}