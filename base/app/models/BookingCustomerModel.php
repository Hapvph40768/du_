<?php
namespace App\Models;

class BookingCustomerModel extends BaseModel
{
    protected $table = "booking_customers";

    // Lấy tất cả khách trong booking_customers
    public function getAllBookingCustomers()
    {
        $sql = "SELECT bc.*, b.id AS booking_id, c.fullname AS customer_name
                FROM {$this->table} bc
                JOIN bookings b ON bc.booking_id = b.id
                JOIN customers c ON bc.customer_id = c.id
                ORDER BY bc.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy khách theo ID
    public function getBookingCustomerById($id)
    {
        $sql = "SELECT bc.*, b.id AS booking_id, c.fullname AS customer_name
                FROM {$this->table} bc
                JOIN bookings b ON bc.booking_id = b.id
                JOIN customers c ON bc.customer_id = c.id
                WHERE bc.id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Lấy tất cả khách theo booking_id
    public function getCustomersByBooking($booking_id)
    {
        $sql = "SELECT bc.*, c.fullname AS customer_name
                FROM {$this->table} bc
                JOIN customers c ON bc.customer_id = c.id
                WHERE bc.booking_id=?";
        $this->setQuery($sql);
        return $this->loadAllRows([$booking_id]);
    }

    // Thêm khách vào booking
    public function addBookingCustomer($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (booking_id, customer_id, fullname, gender, dob, note, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['customer_id'],
            $data['fullname'] ?? null,
            $data['gender'] ?? null,
            $data['dob'] ?? null,
            $data['note'] ?? null,
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật khách trong booking
    public function updateBookingCustomer($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        booking_id=?, customer_id=?, fullname=?, gender=?, dob=?, note=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['customer_id'],
            $data['fullname'] ?? null,
            $data['gender'] ?? null,
            $data['dob'] ?? null,
            $data['note'] ?? null,
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa khách khỏi booking
    public function deleteBookingCustomer($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>