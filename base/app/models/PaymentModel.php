<?php
namespace App\Models;

class PaymentModel extends BaseModel
{
    protected $table = "payments";

    // Lấy tất cả payments
    public function getAllPayments()
    {
        $sql = "SELECT p.*, b.id AS booking_id, t.name AS tour_name, b.start_date, b.end_date
                FROM {$this->table} p
                JOIN bookings b ON p.booking_id = b.id
                JOIN departures d ON b.departure_id = d.id
                JOIN tours t ON d.tour_id = t.id
                ORDER BY p.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy payment theo ID
    public function getPaymentById($id)
    {
        $sql = "SELECT p.*, b.id AS booking_id
                FROM {$this->table} p
                JOIN bookings b ON p.booking_id = b.id
                WHERE p.id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Lấy tất cả payments theo booking_id
    public function getPaymentsByBooking($booking_id)
    {
        $sql = "SELECT p.*, b.id AS booking_id
                FROM {$this->table} p
                JOIN bookings b ON p.booking_id = b.id
                WHERE p.booking_id=?";
        $this->setQuery($sql);
        return $this->loadAllRows([$booking_id]);
    }

    // Thêm payment mới
    public function addPayment($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (booking_id, booking_service_id, amount, method, transaction_code, status, paid_at, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['booking_service_id'] ?? null,
            $data['amount'],
            $data['method'] ?? 'cash',
            $data['transaction_code'] ?? null,
            $data['status'] ?? 'pending',
            $data['paid_at'] ?? null,
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật payment
    public function updatePayment($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        booking_id=?, booking_service_id=?, amount=?, method=?, transaction_code=?, status=?, paid_at=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['booking_service_id'] ?? null,
            $data['amount'],
            $data['method'] ?? 'cash',
            $data['transaction_code'] ?? null,
            $data['status'] ?? 'pending',
            $data['paid_at'] ?? null,
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa payment
    public function deletePayment($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>