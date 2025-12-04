<?php
namespace App\Models;

class SpecialRequestsModel extends BaseModel
{
    protected $table = "special_requests";

    // Lấy tất cả yêu cầu đặc biệt
    public function getAllRequests()
    {
        $sql = "SELECT sr.*, c.fullname AS customer_name
                FROM {$this->table} sr
                JOIN customers c ON sr.customer_id = c.id
                ORDER BY sr.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy yêu cầu theo ID
    public function getRequestById($id)
    {
        $sql = "SELECT sr.*, c.fullname AS customer_name
                FROM {$this->table} sr
                JOIN customers c ON sr.customer_id = c.id
                WHERE sr.id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Lấy tất cả yêu cầu theo customer_id
    public function getRequestsByCustomer($customer_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE customer_id=? ORDER BY created_at DESC";
        $this->setQuery($sql);
        return $this->loadAllRows([$customer_id]);
    }

    // Thêm yêu cầu mới
    public function addRequest($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (customer_id, request, created_at, updated_at) 
        VALUES (?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['customer_id'],
            $data['request'],
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật yêu cầu
    public function updateRequest($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        customer_id=?, request=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['customer_id'],
            $data['request'],
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa yêu cầu
    public function deleteRequest($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>