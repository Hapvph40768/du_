<?php
namespace App\Models;

class SpecialRequestsModel extends BaseModel
{
    protected $table = "special_requests";

    public function getAllRequests()
    {
        $sql = "
        SELECT sr.*, bc.fullname AS customer_name
        FROM {$this->table} sr
        JOIN booking_customers bc ON sr.customer_id = bc.id
        ORDER BY sr.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getRequestById($id)
    {
        $sql = "
        SELECT sr.*, bc.fullname AS customer_name
        FROM {$this->table} sr
        JOIN booking_customers bc ON sr.customer_id = bc.id
        WHERE sr.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addRequest($data)
    {
        $sql = "INSERT INTO {$this->table} (`customer_id`, `request`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['customer_id'],
            $data['request'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateRequest($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `customer_id`=?, `request`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['customer_id'],
            $data['request'],
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
