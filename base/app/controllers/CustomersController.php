<?php

namespace App\Controllers;

use App\Models\CustomersModel;

class CustomersController extends BaseController
{
    protected $customer;

    public function __construct()
    {
        $this->customer = new CustomersModel();
    }

    // ======================= LIST =========================
    public function index()
    {
        $customers = $this->customer->getAll();

        $this->render('customers.list', compact('customers'));
    }

    // ======================= SHOW FORM ADD =========================
    public function create()
    {
        $this->render('customers.add');
    }

    // ======================= HANDLE ADD =========================
    public function store()
    {
        $data = [
            'user_id'   => $_POST['user_id'] ?? null,
            'full_name' => $_POST['full_name'],
            'email'     => $_POST['email'],
            'phone'     => $_POST['phone'],
            'address'   => $_POST['address'],
            'notes'     => $_POST['notes']
        ];

        // Validate đơn giản
        $errors = [];

        if (empty($data['full_name'])) {
            $errors[] = "Tên khách hàng không được để trống!";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . 'customers/create?msg=error');
            exit;
        }

        $this->customer->add($data);

        $_SESSION['success'] = "Thêm khách hàng thành công!";
        header('Location: ' . BASE_URL . 'customers');
        exit;
    }

    // ======================= SHOW FORM EDIT =========================
    public function edit($id)
    {
        $customer = $this->customer->getById($id);

        if (!$customer) {
            die("Không tìm thấy khách hàng!");
        }

        $this->render('customers.edit', compact('customer'));
    }

    // ======================= HANDLE UPDATE =========================
    public function update($id)
    {
        $data = [
            'user_id'   => $_POST['user_id'] ?? null,
            'full_name' => $_POST['full_name'],
            'email'     => $_POST['email'],
            'phone'     => $_POST['phone'],
            'address'   => $_POST['address'],
            'notes'     => $_POST['notes']
        ];

        $errors = [];

        if (empty($data['full_name'])) {
            $errors[] = "Tên khách hàng không được để trống!";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . 'customers/edit/' . $id . '?msg=error');
            exit;
        }

        $this->customer->updateCustomer($id, $data);

        $_SESSION['success'] = "Cập nhật thành công!";
        header('Location: ' . BASE_URL . 'customers');
        exit;
    }

    // ======================= DELETE =========================
    public function delete($id)
    {
        $this->customer->deleteCustomer($id);

        $_SESSION['success'] = "Xóa khách hàng thành công!";
        header('Location: ' . BASE_URL . 'customers');
        exit;
    }
}
