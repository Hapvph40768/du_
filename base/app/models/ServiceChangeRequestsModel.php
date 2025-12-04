<?php
namespace App\Models;

class ServiceChangeRequestsModel extends BaseModel
{
    protected $table = "service_change_requests";

    // Lấy tất cả yêu cầu thay đổi dịch vụ
    public function getAllRequests()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy yêu cầu theo ID
    public function getRequestById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm yêu cầu mới
    public function addRequest($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (booking_id, request, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['request'],
            $data['status'] ?? 'pending',
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? date("Y-m-d H:i:s")
        ]);
    }

    // Cập nhật yêu cầu
    public function updateRequest($id, $data)
    {
        $sql = "UPDATE {$this->table} 
        SET booking_id=?, request=?, status=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['request'],
            $data['status'] ?? 'pending',
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