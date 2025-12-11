<?php
namespace App\Models;

class AttendanceModel extends BaseModel
{
    protected $table = "attendance";

    // Lấy tất cả attendance (từ booking_customers LEFT JOIN)
    public function getAllAttendance($status = null, $start_date = null, $end_date = null, $tour_id = null)
    {
        $sql = "
        SELECT 
            a.id,
            a.status,
            a.checkin_time,
            a.note,
            a.note,
            bk.id AS booking_id,
            bc.id AS booking_customer_id,
            bc.fullname AS booking_customer_name,
            -- c.id AS customer_id, 
            bc.fullname AS customer_name,
            d.id AS departure_id,
            d.start_date, 
            d.end_date,
            bk.start_date AS booking_start_date,
            bk.end_date AS booking_end_date, 
            t.id AS tour_id,
            t.name AS tour_name
        FROM booking_customers bc
        JOIN bookings bk ON bc.booking_id = bk.id
        -- LEFT JOIN customers c ON bk.email = c.email
        JOIN departures d ON bk.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        LEFT JOIN attendance a ON a.booking_customer_id = bc.id
        WHERE 1=1 
        ";
        
        $params = [];

        if ($status && in_array($status, ['present', 'absent'])) {
            $sql .= " AND a.status = ? ";
            $params[] = $status;
        }

        if ($start_date) {
            $sql .= " AND d.start_date >= ? ";
            $params[] = $start_date;
        }

        if ($end_date) {
            $sql .= " AND d.end_date <= ? ";
            $params[] = $end_date;
        }

        if ($tour_id) {
            $sql .= " AND t.id = ? ";
            $params[] = $tour_id;
        }

        $sql .= " ORDER BY d.start_date DESC, bc.id DESC ";

        $this->setQuery($sql);
        return $this->loadAllRows($params);
    }

    // Lấy attendance theo guide_id
    public function getAttendanceByGuide($guide_id, $status = null, $start_date = null, $end_date = null, $tour_id = null)
    {
        $sql = "
        SELECT 
            a.id,
            a.status,
            a.checkin_time,
            a.note,
            a.note,
            bk.id AS booking_id,
            bc.id AS booking_customer_id,
            bc.fullname AS booking_customer_name,
            -- c.id AS customer_id,
            bc.fullname AS customer_name,
            d.id AS departure_id,
            d.start_date, 
            d.end_date,
            bk.start_date AS booking_start_date,
            bk.end_date AS booking_end_date, 
            t.id AS tour_id,
            t.name AS tour_name
        FROM booking_customers bc
        JOIN bookings bk ON bc.booking_id = bk.id
        -- LEFT JOIN customers c ON bk.email = c.email
        JOIN departures d ON bk.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        JOIN tour_guides tg ON tg.departure_id = d.id  -- Filter by assignment
        LEFT JOIN attendance a ON a.booking_customer_id = bc.id
        WHERE tg.guide_id = ? 
        ";
        
        $params = [$guide_id];

        if ($status && in_array($status, ['present', 'absent'])) {
            $sql .= " AND a.status = ? ";
            $params[] = $status;
        }

        if ($start_date) {
            $sql .= " AND d.start_date >= ? ";
            $params[] = $start_date;
        }

        if ($end_date) {
            $sql .= " AND d.end_date <= ? ";
            $params[] = $end_date;
        }

        if ($tour_id) {
            $sql .= " AND t.id = ? ";
            $params[] = $tour_id;
        }

        $sql .= " ORDER BY d.start_date DESC, bc.id DESC ";

        $this->setQuery($sql);
        return $this->loadAllRows($params);
    }

    // Lấy attendance theo ID
    public function getAttendanceById($id)
    {
        $sql = "
        SELECT a.*, 
               c.fullname AS customer_name, 
               bc.fullname AS booking_customer_name,
               d.start_date, d.end_date, d.tour_id,
               t.name AS tour_name
        FROM {$this->table} a
        JOIN customers c ON a.customer_id = c.id
        LEFT JOIN booking_customers bc ON a.booking_customer_id = bc.id
        JOIN departures d ON a.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        WHERE a.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm attendance
    public function addAttendance($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (departure_id, customer_id, booking_customer_id, status, checkin_time, note, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['customer_id'],
            $data['booking_customer_id'] ?? null,
            $data['status'] ?? 'present',
            $data['checkin_time'] ?? null,
            $data['note'] ?? null,
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật attendance
    public function updateAttendance($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        departure_id=?, customer_id=?, booking_customer_id=?, status=?, checkin_time=?, note=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['customer_id'],
            $data['booking_customer_id'] ?? null,
            $data['status'] ?? 'present',
            $data['checkin_time'] ?? null,
            $data['note'] ?? null,
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa attendance
    public function deleteAttendance($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>