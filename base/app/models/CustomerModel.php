<?php
namespace App\Models;

class CustomerModel extends BaseModel
{
    protected $table = "customers";

    // Lấy tất cả khách hàng
    public function getAllCustomers()
    {
        $sql = "SELECT c.*, u.username 
                FROM {$this->table} c 
                LEFT JOIN users u ON c.user_id = u.id 
                ORDER BY c.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy khách hàng theo ID
    public function getCustomerById($id)
    {
        $sql = "SELECT c.*, u.username 
                FROM {$this->table} c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Lấy khách hàng theo User ID
    public function getCustomerByUserId($user_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$user_id]);
    }

    // Thêm khách hàng mới
    public function addCustomer($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (`user_id`, `fullname`, `phone`, `email`, `nationality`, `dob`, `gender`, `address`, `note`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'] ?? null,
            $data['fullname'],
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['nationality'] ?? null,
            $data['dob'] ?? null,
            $data['gender'] ?? null,
            $data['address'] ?? null,
            $data['note'] ?? null
        ]);
    }

    // Cập nhật khách hàng
    public function updateCustomer($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        `user_id`=?, `fullname`=?, `phone`=?, `email`=?, `nationality`=?, `dob`=?, `gender`=?, `address`=?, `note`=? 
        WHERE id=?";
        
        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'] ?? null,
            $data['fullname'],
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['nationality'] ?? null,
            $data['dob'] ?? null,
            $data['gender'] ?? null,
            $data['address'] ?? null,
            $data['note'] ?? null,
            $id
        ]);
    }

    // Xóa khách hàng
    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>