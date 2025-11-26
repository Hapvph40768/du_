<?php
namespace App\Models;

class BookingCustomerModel extends BaseModel
{
    protected $table = "booking_customers";

    public function getAllCustomers()
    {
        $sql = "
        SELECT bc.*, b.customer_name, b.departure_id
        FROM {$this->table} bc
        JOIN bookings b ON bc.booking_id = b.id
        ORDER BY bc.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getCustomerById($id)
    {
        $sql = "
        SELECT bc.*, b.customer_name, b.departure_id
        FROM {$this->table} bc
        JOIN bookings b ON bc.booking_id = b.id
        WHERE bc.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addCustomer($data)
    {
        $sql = "INSERT INTO {$this->table} (booking_id, fullname, gender, dob, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['fullname'],
            $data['gender'],
            $data['dob'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateCustomer($id, $data)
    {
        $sql = "UPDATE {$this->table} SET booking_id=?, fullname=?, gender=?, dob=?, updated_at=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['fullname'],
            $data['gender'],
            $data['dob'],
            $data['updated_at'],
            $id
        ]);
    }

    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
