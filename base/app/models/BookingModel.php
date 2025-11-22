<?php
namespace App\Models;

class BookingModel extends BaseModel
{
    protected $table = "bookings";

    public function getAllBooking()
    {
        $sql = "
        SELECT b.*, d.date_start, d.date_end, d.tour_id
        FROM {$this->table} b
        JOIN departures d ON b.departure_id = d.id
        ORDER BY b.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    public function getBookingById($id)
    {
        $sql = "
        SELECT b.*, d.date_start, d.date_end, d.tour_id
        FROM {$this->table} b
        JOIN departures d ON b.departure_id = d.id
        WHERE b.id = ?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function addBooking($data)
    {
        $sql = "INSERT INTO $this->table (departure_id, customer_name, customer_phone, people, total_price, status)VALUES (?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['people'],
            $data['total_price'],
            $data['status'],
        ]);
    }
    public function updateBooking($id, $data)
    {
        $sql = "UPDATE $this->table SET 'departure_id' = ?, 'customer_name' = ?, 'customer_phone' = ?, 'people' = ?, 'total_price' = ?, 'status' = ? WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['people'],
            $data['total_price'],
            $data['status'],
            $id,
        ]);
    }
    public function deleteBooking($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>