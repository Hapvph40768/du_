<?php
namespace App\Models;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    public $table = 'users';
    public function getAllUsers()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy user theo ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Lấy user theo username
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username=?";
        $this->setQuery($sql);
        return $this->loadRow([$username]);
    }

    // Thêm user mới
    public function createUser($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (username, email, password, role, avatar, is_active, last_login, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['username'],
            $data['email'] ?? null,
            $data['password'],
            $data['role'] ?? 'customer',
            $data['avatar'] ?? null,
            $data['is_active'] ?? 1,
            $data['last_login'] ?? null,
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật user
    public function updateUser($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        username=?, email=?, password=?, role=?, avatar=?, is_active=?, last_login=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['username'],
            $data['email'] ?? null,
            $data['password'],
            $data['role'] ?? 'customer',
            $data['avatar'] ?? null,
            $data['is_active'] ?? 1,
            $data['last_login'] ?? null,
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }

}