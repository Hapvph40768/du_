<?php
namespace App\Models;

class ServiceModel extends BaseModel
{
    // map to tour_service_packages table in your DB
    protected $table = "tour_service_packages";

    public function getAllServices()
    {
        $sql = "SELECT p.*, t.name AS tour_name FROM {$this->table} p LEFT JOIN tours t ON p.tour_id = t.id ORDER BY p.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getServiceById($id)
    {
        $sql = "SELECT p.*, t.name AS tour_name FROM {$this->table} p LEFT JOIN tours t ON p.tour_id = t.id WHERE p.id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addService($data)
    {
        $sql = "INSERT INTO {$this->table} (`tour_id`, `package_name`, `description`, `price`, `currency`, `is_optional`, `is_active`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'] ?? null,
            $data['package_name'],
            $data['description'] ?? null,
            $data['price'],
            $data['currency'] ?? 'VND',
            $data['is_optional'] ?? 1,
            $data['is_active'] ?? 1,
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateService($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `tour_id`=?, `package_name`=?, `description`=?, `price`=?, `currency`=?, `is_optional`=?, `is_active`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'] ?? null,
            $data['package_name'],
            $data['description'] ?? null,
            $data['price'],
            $data['currency'] ?? 'VND',
            $data['is_optional'] ?? 1,
            $data['is_active'] ?? 1,
            $data['updated_at'],
            $id
        ]);
    }

    public function deleteService($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
