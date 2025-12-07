<?php
namespace App\Models;

class SupplierModel extends BaseModel
{
    protected $table = 'suppliers';

    // Lấy tất cả suppliers
    public function getAll()
    {
        $this->setQuery("SELECT * FROM {$this->table}");
        return $this->loadAllRows();
    }

    // Lấy supplier theo ID
    public function getById($id)
    {
        $this->setQuery("SELECT * FROM {$this->table} WHERE id=?");
        return $this->loadRow([$id]);
    }

    // Thêm supplier
    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (name, type, phone, email, address, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['name'],
            $data['type'] ?? 'other',
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['address'] ?? null,
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật supplier
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        `name`=?, `type`=?, `phone`=?, `email`=?, `address`=?, `updated_at`=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['name'],
            $data['type'] ?? 'other',
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['address'] ?? null,
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa supplier
    public function delete($id)
    {
        $this->setQuery("DELETE FROM {$this->table} WHERE id=?");
        return $this->execute([$id]);
    }
}
?>