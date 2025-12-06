<?php
namespace App\Models;

class CustomersModel extends BaseModel
{
    protected $table = "customers";

    // =================== Lấy tất cả khách hàng ===================
    public function getAll()
    {
        $sql = "
            SELECT c.*, u.full_name AS username
            FROM {$this->table} c
            LEFT JOIN users u ON c.user_id = u.id
            ORDER BY c.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // =================== Lấy khách hàng theo ID ===================
    public function getById($id)
    {
        $sql = "
            SELECT c.*, u.full_name AS username
            FROM {$this->table} c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.id = ?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // =================== Thêm khách hàng ===================
    public function add($data)
    {
        $sql = "
            INSERT INTO {$this->table}
            (user_id, full_name, email, phone, address, notes, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'],
            $data['full_name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['address'] ?? null,
            $data['notes'] ?? null,
            date('Y-m-d H:i:s')
        ]);
    }

    // =================== Cập nhật khách hàng ===================
    public function updateCustomer($id, $data)
    {
        $sql = "
            UPDATE {$this->table}
            SET user_id = ?, full_name = ?, email = ?, phone = ?, address = ?, notes = ?, updated_at = ?
            WHERE id = ?
        ";

        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'],
            $data['full_name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['address'] ?? null,
            $data['notes'] ?? null,
            date('Y-m-d H:i:s'),
            $id
        ]);
    }

    // =================== Xóa khách hàng ===================
    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }

    // =================== Lấy danh sách tất cả user ===================
    // Dùng để chọn user khi thêm/sửa khách hàng
    public function getUsers()
    {
        $sql = "SELECT id, full_name FROM users ORDER BY full_name ASC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
}
