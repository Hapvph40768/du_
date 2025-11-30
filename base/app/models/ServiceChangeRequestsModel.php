<?php
namespace App\Models;

class ServiceChangeRequestsModel extends BaseModel
{
    protected $table = "service_change_requests";

    public function getAllRequests()
    {
        $sql = "
        SELECT scr.*, b.booking_code, c.full_name AS customer_name
        FROM {$this->table} scr
        JOIN bookings b ON scr.booking_id = b.id
        LEFT JOIN customers c ON b.customer_primary_id = c.id
        ORDER BY scr.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getRequestById($id)
    {
        $sql = "
        SELECT scr.*, b.booking_code, c.full_name AS customer_name
        FROM {$this->table} scr
        JOIN bookings b ON scr.booking_id = b.id
        LEFT JOIN customers c ON b.customer_primary_id = c.id
        WHERE scr.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addRequest($data)
    {
        $sql = "INSERT INTO {$this->table} (`booking_id`, `request`, `status`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['request'],
            $data['status'] ?? 'pending',
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateRequest($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `booking_id`=?, `request`=?, `status`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['request'],
            $data['status'] ?? 'pending',
            $data['updated_at'],
            $id
        ]);
    }

    public function deleteRequest($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
