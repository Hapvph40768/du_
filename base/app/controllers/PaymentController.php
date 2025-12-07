<?php
namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\BookingModel;

class PaymentController extends BaseController
{
    protected $payment;

    public function __construct()
    {
        $this->payment = new PaymentModel();
    }

    // 1. Danh sách payments
    public function listPayments()
    {
        $payments = $this->payment->getAllPayments();
        return $this->render("admin.payment.listPayment", ['payments' => $payments]);
    }

    // 2. Form thêm payment
    public function createPayment()
    {
        $bookingModel = new BookingModel();
        $bookings = $bookingModel->getAllBookings();

        return $this->render("admin.payment.addPayment", ['bookings' => $bookings]);
    }

    // 3. Xử lý thêm payment
    public function postPayment()
    {
        $error = [];

        $booking_id       = $_POST['booking_id'] ?? '';
        $amount           = $_POST['amount'] ?? 0;
        $method           = $_POST['method'] ?? 'cash';
        $transaction_code = $_POST['transaction_code'] ?? null;
        $status           = $_POST['status'] ?? 'pending';
        $paid_at          = $_POST['paid_at'] ?? null;

        // Validate
        if (empty($booking_id) || !is_numeric($booking_id)) $error['booking_id'] = "Phải chọn booking hợp lệ.";
        if (!is_numeric($amount) || $amount <= 0) $error['amount'] = "Số tiền phải là số dương.";
        if (!in_array($method, ['cash','bank','card','momo','zalo'])) $error['method'] = "Phương thức thanh toán không hợp lệ.";
        if (!in_array($status, ['pending','success','failed'])) $error['status'] = "Trạng thái không hợp lệ.";

        if (!empty($error)) {
            redirect('errors', $error, 'add-payment');
        }

        $check = $this->payment->addPayment([
            'booking_id'       => $booking_id,
            'amount'           => $amount,
            'method'           => $method,
            'transaction_code' => $transaction_code,
            'status'           => $status,
            'paid_at'          => $paid_at,
            'created_at'       => date("Y-m-d H:i:s"),
            'updated_at'       => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Thêm payment thành công", 'list-payment');
        } else {
            redirect('errors', "Thêm payment thất bại", 'add-payment');
        }
    }

    // 4. Chi tiết payment để sửa
    public function detailPayment($id)
    {
        $detail = $this->payment->getPaymentById($id);

        $bookingModel = new BookingModel();
        $bookings = $bookingModel->getAllBookings();

        return $this->render("admin.payment.editPayment", [
            'detail'   => $detail,
            'bookings' => $bookings
        ]);
    }

    // 5. Xử lý sửa payment
    public function editPayment($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $error = [];

        $booking_id       = $_POST['booking_id'] ?? '';
        $amount           = $_POST['amount'] ?? 0;
        $method           = $_POST['method'] ?? 'cash';
        $transaction_code = $_POST['transaction_code'] ?? null;
        $status           = $_POST['status'] ?? 'pending';
        $paid_at          = $_POST['paid_at'] ?? null;

        if (empty($booking_id) || !is_numeric($booking_id)) $error['booking_id'] = "Phải chọn booking hợp lệ.";
        if (!is_numeric($amount) || $amount <= 0) $error['amount'] = "Số tiền phải là số dương.";
        if (!in_array($method, ['cash','bank','card','momo','zalo'])) $error['method'] = "Phương thức thanh toán không hợp lệ.";
        if (!in_array($status, ['pending','success','failed'])) $error['status'] = "Trạng thái không hợp lệ.";

        $route = 'detail-payment/' . $id;
        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $check = $this->payment->updatePayment($id, [
            'booking_id'       => $booking_id,
            'amount'           => $amount,
            'method'           => $method,
            'transaction_code' => $transaction_code,
            'status'           => $status,
            'paid_at'          => $paid_at,
            'updated_at'       => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Cập nhật payment thành công", 'list-payment');
        } else {
            redirect('errors', "Cập nhật payment thất bại", $route);
        }
    }

    // 6. Xóa payment
    public function deletePayment($id)
    {
        $check = $this->payment->deletePayment($id);

        if ($check) {
            redirect('success', "Xóa payment thành công", 'list-payment');
        } else {
            redirect('errors', "Xóa payment thất bại", 'list-payment');
        }
    }
}