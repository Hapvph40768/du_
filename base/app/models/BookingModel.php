<?php
namespace App\Models;

class BookingModel extends BaseModel
{
    protected $table = "bookings";

    // Lấy tất cả bookings
    public function getAllBookings()
    {
        $sql = "
        SELECT b.*, d.start_date, d.end_date, t.name AS tour_name, c.fullname AS customer_name, c.phone AS customer_phone
        FROM {$this->table} b
        JOIN departures d ON b.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        LEFT JOIN customers c ON b.customer_id = c.id
        ORDER BY b.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy booking theo ID
    public function getBookingById($id)
    {
        $sql = "
        SELECT b.*, d.start_date, d.end_date, t.name AS tour_name, c.fullname AS customer_name, c.phone AS customer_phone
        FROM {$this->table} b
        JOIN departures d ON b.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        LEFT JOIN customers c ON b.customer_id = c.id
        WHERE b.id = ?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm booking mới
    public function addBooking($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (`customer_id`, `departure_id`, `booking_date`, `num_people`, `total_price`, `payment_status`, `status`, `note`, `created_at`, `updated_at`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['customer_id'] ?? null,
            $data['departure_id'],
            $data['booking_date'] ?? date("Y-m-d H:i:s"),
            $data['num_people'] ?? 1,
            $data['total_price'] ?? 0.00,
            $data['payment_status'] ?? 'unpaid',
            $data['status'] ?? 'pending',
            $data['note'] ?? null,
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật booking
    public function updateBooking($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        `customer_id`=?, `departure_id`=?, `num_people`=?, `total_price`=?, `payment_status`=?, `status`=?, `note`=?, `updated_at`=?
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['customer_id'] ?? null,
            $data['departure_id'],
            $data['num_people'] ?? 1,
            $data['total_price'] ?? 0.00,
            $data['payment_status'] ?? 'unpaid',
            $data['status'] ?? 'pending',
            $data['note'] ?? null,
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa booking
    public function deleteBooking($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>