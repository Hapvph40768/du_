<?php
namespace App\Models;

class BookingCustomerModel extends BaseModel
{
    protected $table = "booking_customers";

    // Lấy tất cả khách trong booking_customers
    public function getAllBookingCustomers($tour_id = null, $start_date = null, $end_date = null)
    {
        $sql = "SELECT bc.*, b.id AS booking_id, b.start_date, b.end_date, t.name as tour_name, c.fullname as customer_name
                FROM {$this->table} bc
                JOIN bookings b ON bc.booking_id = b.id
                LEFT JOIN customers c ON b.customer_id = c.id
                LEFT JOIN departures d ON b.departure_id = d.id
                LEFT JOIN tours t ON d.tour_id = t.id
                WHERE 1=1";
        
        $params = [];

        if ($tour_id) {
            $sql .= " AND t.id = ?";
            $params[] = $tour_id;
        }

        if ($start_date) {
            $sql .= " AND b.start_date >= ?";
            $params[] = $start_date;
        }

        if ($end_date) {
            $sql .= " AND b.end_date <= ?";
            $params[] = $end_date;
        }

        $sql .= " ORDER BY bc.id DESC";

        $this->setQuery($sql);
        return $this->loadAllRows($params);
    }

    // Lấy khách theo ID
    public function getBookingCustomerById($id)
    {
        $sql = "SELECT bc.*, b.id AS booking_id, b.start_date, b.end_date, t.name as tour_name
                FROM {$this->table} bc
                JOIN bookings b ON bc.booking_id = b.id
                LEFT JOIN departures d ON b.departure_id = d.id
                LEFT JOIN tours t ON d.tour_id = t.id
                WHERE bc.id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Lấy tất cả khách theo booking_id
    public function getCustomersByBooking($booking_id)
    {
        $sql = "SELECT bc.*
                FROM {$this->table} bc
                WHERE bc.booking_id=?";
        $this->setQuery($sql);
        return $this->loadAllRows([$booking_id]);
    }

    // Thêm khách vào booking
    public function addBookingCustomer($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (booking_id, fullname, phone, id_card, gender, dob, note, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['fullname'] ?? null,
            $data['phone'] ?? null,
            $data['id_card'] ?? null,
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
        booking_id=?, fullname=?, phone=?, id_card=?, gender=?, dob=?, note=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['fullname'] ?? null,
            $data['phone'] ?? null,
            $data['id_card'] ?? null,
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

    // Lấy khách hàng thuộc các tour mà guide được phân công (Bao gồm cả người đặt)
    public function getBookingCustomersByGuide($guide_id, $filter_tour_id = null, $start_date = null, $end_date = null, $booking_id = null)
    {
        // 1. Members from booking_customers
        $sql = "
        SELECT 
            bc.id, bc.booking_id, bc.fullname, bc.phone, bc.id_card, bc.gender, bc.dob, bc.note, bc.created_at,
            b.id AS booking_alias_id, b.start_date, b.end_date, t.id as tour_id, t.name as tour_name, c.fullname as customer_name
        FROM booking_customers bc
        JOIN bookings b ON bc.booking_id = b.id
        LEFT JOIN customers c ON b.customer_id = c.id
        JOIN departures d ON b.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        JOIN tour_guides tg ON tg.departure_id = d.id
        WHERE tg.guide_id = ?
        ";

        $params = [$guide_id];

        // Filters for Query 1
        if ($filter_tour_id) { $sql .= " AND t.id = ?"; $params[] = $filter_tour_id; }
        if ($start_date)     { $sql .= " AND b.start_date >= ?"; $params[] = $start_date; }
        if ($end_date)       { $sql .= " AND b.end_date <= ?"; $params[] = $end_date; }
        if ($booking_id)     { $sql .= " AND b.id = ?"; $params[] = $booking_id; }

        $sql .= " UNION ALL ";

        // 2. Booker from bookings (Masquerading as a member)
        $sql .= "
        SELECT 
            0 as id, b.id as booking_id, c.fullname, c.phone, NULL as id_card, c.gender, c.dob, 'Người đặt' as note, b.created_at,
            b.id AS booking_alias_id, b.start_date, b.end_date, t.id as tour_id, t.name as tour_name, c.fullname as customer_name
        FROM bookings b
        JOIN customers c ON b.customer_id = c.id
        JOIN departures d ON b.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        JOIN tour_guides tg ON tg.departure_id = d.id
        WHERE tg.guide_id = ?
        ";

        $params[] = $guide_id;

        // Filters for Query 2 (Must repeat parameters)
        if ($filter_tour_id) { $sql .= " AND t.id = ?"; $params[] = $filter_tour_id; }
        if ($start_date)     { $sql .= " AND b.start_date >= ?"; $params[] = $start_date; }
        if ($end_date)       { $sql .= " AND b.end_date <= ?"; $params[] = $end_date; }
        if ($booking_id)     { $sql .= " AND b.id = ?"; $params[] = $booking_id; }

        $sql .= " ORDER BY start_date DESC, id DESC";

        $this->setQuery($sql);
        return $this->loadAllRows($params);
    }
}
?>