<?php

namespace App\Models;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    protected $table = 'users';

    // Lấy tất cả user
    public function getAllUsers()
    {
        $sql = "SELECT u.*, r.name as role_name 
                FROM {$this->table} u 
                LEFT JOIN roles r ON u.role_id = r.id 
                ORDER BY u.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getCustomersOnly()
    {
        $sql = "SELECT u.*, r.name as role_name 
                FROM {$this->table} u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE r.name = 'customer'
                ORDER BY u.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getGuidesOnly()
    {
        $sql = "SELECT u.*, r.name as role_name 
                FROM {$this->table} u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE r.name = 'guide'
                ORDER BY u.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy tất cả roles
    public function getAllRoles()
    {
        $sql = "SELECT * FROM roles ORDER BY id ASC";
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

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email=?";
        $this->setQuery($sql);
        return $this->loadRow([$email]);
    }

    public function updatePassword($id, $newPassword)
    {
        $sql = "UPDATE {$this->table} SET password = ? WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$newPassword, $id]);
    }

    // Thêm user mới
    public function createUser($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (username, email, password, role_id, avatar, is_active, last_login) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['username'],
            $data['email'] ?? null,
            $data['password'], // Controller must hash this
            $data['role_id'] ?? 1,
            $data['avatar'] ?? null,
            $data['is_active'] ?? 1,
            $data['last_login'] ?? null
        ]);
    }

    // Cập nhật user
    public function updateUser($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        username=?, email=?, password=?, role_id=?, avatar=?, is_active=?, last_login=?
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['username'],
            $data['email'] ?? null,
            $data['password'], // Controller must hash this
            $data['role_id'] ?? 1,
            $data['avatar'] ?? null,
            $data['is_active'] ?? 1,
            $data['last_login'] ?? null,
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
    public function getUsersByRole($role_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE role_id=?";
        $this->setQuery($sql);
        return $this->loadAllRows([$role_id]);
    }
}
