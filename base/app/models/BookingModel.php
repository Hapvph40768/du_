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
}
?>