<?php
namespace App\Models;

class AttendanceModel extends BaseModel
{
    protected $table = "attendance";

    // Lấy tất cả attendance
    public function getAllAttendance()
    {
        $sql = "
        SELECT a.*, 
               c.fullname AS customer_name, 
               bc.fullname AS booking_customer_name,
               d.start_date, d.end_date, d.tour_id
        FROM {$this->table} a
        JOIN customers c ON a.customer_id = c.id
        LEFT JOIN booking_customers bc ON a.booking_customer_id = bc.id
        JOIN departures d ON a.departure_id = d.id
        ORDER BY a.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy attendance theo ID
    public function getAttendanceById($id)
    {
        $sql = "
        SELECT a.*, 
               c.fullname AS customer_name, 
               bc.fullname AS booking_customer_name,
               d.start_date, d.end_date, d.tour_id
        FROM {$this->table} a
        JOIN customers c ON a.customer_id = c.id
        LEFT JOIN booking_customers bc ON a.booking_customer_id = bc.id
        JOIN departures d ON a.departure_id = d.id
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