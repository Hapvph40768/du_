<?php
namespace App\Models;

class BookingCustomerModel extends BaseModel
{
    protected $table = "booking_customers";

    // Lấy tất cả khách trong booking
    public function getAllCustomers()
    {
        $sql = "
        SELECT bc.*, b.departure_id, c.fullname AS customer_name, c.phone AS customer_phone
        FROM {$this->table} bc
        JOIN bookings b ON bc.booking_id = b.id
        JOIN customers c ON bc.customer_id = c.id
        ORDER BY bc.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy khách theo ID
    public function getCustomerById($id)
    {
        $sql = "
        SELECT bc.*, b.departure_id, c.fullname AS customer_name, c.phone AS customer_phone
        FROM {$this->table} bc
        JOIN bookings b ON bc.booking_id = b.id
        JOIN customers c ON bc.customer_id = c.id
        WHERE bc.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm khách vào booking
    public function addCustomer($data)
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
    public function updateCustomer($id, $data)
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

    // Xóa khách trong booking
    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>