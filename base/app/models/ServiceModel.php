<?php
namespace App\Models;

class ServiceModel extends BaseModel
{
    protected $table = "services";

    // Lấy tất cả dịch vụ
    public function getAllServices()
    {
        $sql = "
        SELECT s.*, sup.name AS supplier_name
        FROM {$this->table} s
        LEFT JOIN suppliers sup ON s.supplier_id = sup.id
        ORDER BY s.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy dịch vụ theo ID
    public function getServiceById($id)
    {
        $sql = "
        SELECT s.*, sup.name AS supplier_name
        FROM {$this->table} s
        LEFT JOIN suppliers sup ON s.supplier_id = sup.id
        WHERE s.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm dịch vụ
    public function addService($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (package_name, name, description, type, supplier_id, price, default_price, currency, is_optional, is_active, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['package_name'] ?? null,
            $data['name'],
            $data['description'] ?? null,
            $data['type'] ?? null,
            $data['supplier_id'] ?? null,
            $data['price'] ?? 0.00,
            $data['default_price'] ?? 0.00,
            $data['currency'] ?? 'VND',
            $data['is_optional'] ?? 0,
            $data['is_active'] ?? 1,
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật dịch vụ
    public function updateService($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        package_name=?, name=?, description=?, type=?, supplier_id=?, price=?, default_price=?, currency=?, is_optional=?, is_active=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['package_name'] ?? null,
            $data['name'],
            $data['description'] ?? null,
            $data['type'] ?? null,
            $data['supplier_id'] ?? null,
            $data['price'] ?? 0.00,
            $data['default_price'] ?? 0.00,
            $data['currency'] ?? 'VND',
            $data['is_optional'] ?? 0,
            $data['is_active'] ?? 1,
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa dịch vụ
    public function deleteService($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>