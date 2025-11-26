<?php
namespace App\Models;

class BookingModel extends BaseModel
{
    protected $table = "bookings";

    public function getAllBookings()
    {
        $sql = "
        SELECT b.*, d.date_start, d.date_end, t.name AS tour_name
        FROM {$this->table} b
        JOIN departures d ON b.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        ORDER BY b.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    public function getBookingById($id)
    {
        $sql = "
        SELECT b.*, d.date_start, d.date_end, t.name AS tour_name
        FROM {$this->table} b
        JOIN departures d ON b.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        WHERE b.id = ?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function addBooking($data)
    {
        $sql = "INSERT INTO $this->table 
        (`departure_id`, `customer_name`, `customer_phone`, `people`, `total_price`, `status`, `created_at`, `updated_at`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['people'],
            $data['total_price'],
            $data['status'] ?? 'pending',
            $data['created_at'],
            $data['updated_at']
        ]);
    }
    public function updateBooking($id, $data)
    {
        $sql = "UPDATE $this->table SET 
        `departure_id`=?, `customer_name`=?, `customer_phone`=?, `people`=?, `total_price`=?, `status`=?, `updated_at`=?
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['people'],
            $data['total_price'],
            $data['status'] ?? 'pending',
            $data['updated_at'],
            $id
        ]);
    }
    public function deleteBooking($id)
    {
        $sql = "DELETE FROM $this->table WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
