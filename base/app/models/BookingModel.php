<?php

namespace App\Models;

class BookingModel extends BaseModel
{
    protected $table = 'bookings';

    /* ===============================
       LẤY DANH SÁCH BOOKING
    ================================== */
    public function getAllBookings()
    {
        $sql = "
            SELECT b.*, 
                   c.fullname AS customer_name, 
                   d.start_date, d.end_date, d.price AS departure_price,
                   t.name AS tour_name
            FROM {$this->table} b
            JOIN customers c ON b.customer_id = c.id
            JOIN departures d ON b.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            ORDER BY b.created_at DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getBookingById($id)
    {
        $sql = "
            SELECT b.*, 
                   c.fullname AS customer_name, 
                   d.start_date, d.end_date, d.price AS departure_price,
                   t.name AS tour_name
            FROM {$this->table} b
            JOIN customers c ON b.customer_id = c.id
            JOIN departures d ON b.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            WHERE b.id = ?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    /* ===============================
       THÊM BOOKING
    ================================== */
    public function addBooking($data)
    {
        // Validate cơ bản trước khi tới trigger
        if (empty($data['num_people']) || $data['num_people'] <= 0) {
            throw new \Exception("Số lượng khách không hợp lệ!");
        }

        // Lấy giá từ departure
        $sql = "SELECT price FROM departures WHERE id = ?";
        $this->setQuery($sql);
        $departure = $this->loadRow([$data['departure_id']]);

        if (!$departure) {
            throw new \Exception("Departure không tồn tại!");
        }

        $price = (float)$departure->price;
        $total_price = $price * (int)$data['num_people'];

        // Thêm booking
        $sql = "INSERT INTO {$this->table} 
                (customer_id, departure_id, booking_date, num_people, total_price, 
                 payment_status, status, note, created_at, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->setQuery($sql);
        return $this->execute([
            $data['customer_id'],
            $data['departure_id'],
            date('Y-m-d'),
            $data['num_people'],
            $total_price,
            $data['payment_status'],
            $data['status'],
            $data['note'] ?? null,
            date('Y-m-d H:i:s'),
            $data['created_by'] ?? null
        ]);
    }

    /* ===============================
       UPDATE BOOKING
    ================================== */
    public function updateBooking($id, $data)
    {
        // Validate
        if (empty($data['num_people']) || $data['num_people'] <= 0) {
            throw new \Exception("Số lượng khách không hợp lệ!");
        }

        $sql = "SELECT price FROM departures WHERE id = ?";
        $this->setQuery($sql);
        $departure = $this->loadRow([$data['departure_id']]);

        if (!$departure) {
            throw new \Exception("Departure không tồn tại!");
        }

        $price = (float)$departure->price;
        $total_price = $price * (int)$data['num_people'];

        $sql = "UPDATE {$this->table} SET 
                    customer_id = ?, 
                    departure_id = ?, 
                    num_people = ?, 
                    total_price = ?, 
                    payment_status = ?, 
                    status = ?, 
                    note = ?, 
                    updated_at = ?, 
                    updated_by = ?
                WHERE id = ?";

        $this->setQuery($sql);
        return $this->execute([
            $data['customer_id'],
            $data['departure_id'],
            $data['num_people'],
            $total_price,
            $data['payment_status'],
            $data['status'],
            $data['note'] ?? null,
            date('Y-m-d H:i:s'),
            $data['updated_by'] ?? null,
            $id
        ]);
    }

    /* ===============================
       XÓA BOOKING
    ================================== */
    public function deleteBooking($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
