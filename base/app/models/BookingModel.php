<?php

namespace App\Models;

class BookingModel extends BaseModel
{
    protected $table = 'bookings';

    /* ===============================
       LẤY DANH SÁCH BOOKING
    ================================== */
    public function getAllBookings($status = null)
    {
        $sql = "
            SELECT b.*, 
                   c.fullname, c.phone, c.email,
                   t.price AS departure_price, d.remaining_seats,
                   t.name AS tour_name,
                   ts.service_names
            FROM {$this->table} b
            LEFT JOIN customers c ON b.customer_id = c.id
            JOIN departures d ON b.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            LEFT JOIN (
                SELECT bs.booking_id, GROUP_CONCAT(s.name SEPARATOR ', ') as service_names
                FROM booking_services bs
                JOIN services s ON bs.service_id = s.id
                GROUP BY bs.booking_id
            ) ts ON b.id = ts.booking_id
        ";

        if ($status) {
            $sql .= " WHERE b.status = '$status' ";
        }

        $sql .= " ORDER BY b.created_at DESC";

        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getBookingById($id)
    {
        $sql = "
            SELECT b.*, 
                   c.fullname, c.phone, c.email,
                   t.price AS departure_price, d.remaining_seats,
                   t.name AS tour_name,
                   ts.service_names
            FROM {$this->table} b
            LEFT JOIN customers c ON b.customer_id = c.id
            JOIN departures d ON b.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            LEFT JOIN (
                SELECT bs.booking_id, GROUP_CONCAT(s.name SEPARATOR ', ') as service_names
                FROM booking_services bs
                JOIN services s ON bs.service_id = s.id
                GROUP BY bs.booking_id
            ) ts ON b.id = ts.booking_id
            WHERE b.id = ?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function getBookingsByDeparture($departure_id)
    {
        $sql = "
            SELECT b.*, 
                   c.fullname, c.phone, c.email,
                   t.price AS departure_price,
                   t.name AS tour_name,
                   ts.service_names
            FROM {$this->table} b
            LEFT JOIN customers c ON b.customer_id = c.id
            JOIN departures d ON b.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            LEFT JOIN (
                SELECT bs.booking_id, GROUP_CONCAT(s.name SEPARATOR ', ') as service_names
                FROM booking_services bs
                JOIN services s ON bs.service_id = s.id
                GROUP BY bs.booking_id
            ) ts ON b.id = ts.booking_id
            WHERE b.departure_id = ?
            ORDER BY b.created_at DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows([$departure_id]);
    }

    /* ===============================
       THÊM BOOKING
    ================================== */
    public function addBooking($data)
    {
        // Validate
        if (empty($data['num_people']) || $data['num_people'] <= 0) {
            throw new \Exception("Số lượng khách không hợp lệ!");
        }

        // Lấy giá từ tour
        $sql = "SELECT t.price, t.id as tour_id 
                FROM departures d
                JOIN tours t ON d.tour_id = t.id
                WHERE d.id = ?";
        $this->setQuery($sql);
        $departure = $this->loadRow([$data['departure_id']]);

        if (!$departure) {
            throw new \Exception("Departure không tồn tại!");
        }

        $tour_price = (float)$departure->price;

        $days = (strtotime($data['end_date']) - strtotime($data['start_date'])) / (60 * 60 * 24);
        $days = ($days >= 0) ? $days + 1 : 1; 

        // Calculation Formula: Total = (TourPrice + ServiceSum) * Days * Num
        $service_sum = (float)($data['service_price'] ?? 0);
        
        $total_price = ($tour_price + $service_sum) * $days * (int)$data['num_people'];

        // Thêm booking
        $sql = "INSERT INTO {$this->table} 
                (tour_id, days, departure_id, service_id, customer_id, booking_date, start_date, end_date, num_people, total_price, 
                 payment_status, status, note, pickup_location, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->setQuery($sql);
        return $this->execute([
            $departure->tour_id,
            $days,
            $data['departure_id'],
            $data['service_id'] ?? null, 
            $data['customer_id'],
            date('Y-m-d'),
            $data['start_date'],
            $data['end_date'],
            $data['num_people'],
            $total_price,
            $data['payment_status'],
            $data['status'],
            $data['note'] ?? null,
            $data['pickup_location'] ?? null,
            date('Y-m-d H:i:s')
        ]);
    }

    /* ===============================
       UPDATE BOOKING
    ================================== */
    public function updateBooking($id, $data)
    {
        $sql = "SELECT t.price, t.id as tour_id 
                FROM departures d
                JOIN tours t ON d.tour_id = t.id
                WHERE d.id = ?";
        $this->setQuery($sql);
        $departure = $this->loadRow([$data['departure_id']]);
        if (!$departure) throw new \Exception("Departure không tồn tại!");
        
        $tour_price = (float)$departure->price;
        
        $days = (strtotime($data['end_date']) - strtotime($data['start_date'])) / (60 * 60 * 24);
        $days = ($days >= 0) ? $days + 1 : 1;

        $service_sum = (float)($data['service_price'] ?? 0);

        $total_price = ($tour_price + $service_sum) * $days * (int)$data['num_people'];

        $sql = "UPDATE {$this->table} SET 
                    tour_id = ?,
                    days = ?,
                    departure_id = ?, 
                    service_id = ?,
                    customer_id = ?,
                    start_date = ?,
                    end_date = ?,
                    num_people = ?, 
                    total_price = ?, 
                    payment_status = ?, 
                    status = ?, 
                    note = ?, 
                    pickup_location = ?,
                    updated_at = ?
                WHERE id = ?";

        $this->setQuery($sql);
        return $this->execute([
            $departure->tour_id,
            $days,
            $data['departure_id'],
            $data['service_id'] ?? null,
            $data['customer_id'],
            $data['start_date'],
            $data['end_date'],
            $data['num_people'],
            $total_price,
            $data['payment_status'],
            $data['status'],
            $data['note'] ?? null,
            $data['pickup_location'] ?? null,
            date('Y-m-d H:i:s'),
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

    /* ===============================
       THỐNG KÊ DOANH THU
    ================================== */
    public function getRevenue()
    {
        $sql = "SELECT SUM(total_price) as revenue FROM {$this->table} WHERE payment_status = 'paid'";
        $this->setQuery($sql);
        $result = $this->loadRow();
        return $result->revenue ?? 0;
    }
}
