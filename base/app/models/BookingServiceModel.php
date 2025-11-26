<?php
namespace App\Models;

class BookingServiceModel extends BaseModel
{
    protected $table = "booking_services";

    public function getAllBookingServices()
    {
        $sql = "
        SELECT bs.*, s.name AS service_name, b.customer_name
        FROM {$this->table} bs
        JOIN services s ON bs.service_id = s.id
        JOIN bookings b ON bs.booking_id = b.id
        ORDER BY bs.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getBookingServiceById($id)
    {
        $sql = "
        SELECT bs.*, s.name AS service_name, b.customer_name
        FROM {$this->table} bs
        JOIN services s ON bs.service_id = s.id
        JOIN bookings b ON bs.booking_id = b.id
        WHERE bs.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addBookingService($data)
    {
        $sql = "INSERT INTO {$this->table} (booking_id, service_id, price, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['service_id'],
            $data['price'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateBookingService($id, $data)
    {
        $sql = "UPDATE {$this->table} SET booking_id=?, service_id=?, price=?, updated_at=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['service_id'],
            $data['price'],
            $data['updated_at'],
            $id
        ]);
    }

    public function deleteBookingService($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
