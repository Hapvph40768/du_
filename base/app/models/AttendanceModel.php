<?php
namespace App\Models;

class AttendanceModel extends BaseModel
{
    protected $table = "attendance";

    public function getAllAttendance()
    {
        $sql = "
        SELECT a.*, bc.fullname AS customer_name, d.date_start, d.date_end
        FROM {$this->table} a
        JOIN booking_customers bc ON a.customer_id = bc.id
        JOIN departures d ON a.departure_id = d.id
        ORDER BY a.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getAttendanceById($id)
    {
        $sql = "
        SELECT a.*, bc.fullname AS customer_name, d.date_start, d.date_end
        FROM {$this->table} a
        JOIN booking_customers bc ON a.customer_id = bc.id
        JOIN departures d ON a.departure_id = d.id
        WHERE a.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addAttendance($data)
    {
        $sql = "INSERT INTO {$this->table} (departure_id, customer_id, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['customer_id'],
            $data['status'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateAttendance($id, $data)
    {
        $sql = "UPDATE {$this->table} SET departure_id=?, customer_id=?, status=?, updated_at=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['customer_id'],
            $data['status'],
            $data['updated_at'],
            $id
        ]);
    }

    public function deleteAttendance($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
