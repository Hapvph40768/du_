<?php
namespace App\Models;

class ServiceModel extends BaseModel
{
    protected $table = "services";

    public function getAllServices()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getServiceById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addService($data)
    {
        $sql = "INSERT INTO {$this->table} (`name`, `default_price`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['name'],
            $data['default_price'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateService($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `name`=?, `default_price`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['name'],
            $data['default_price'],
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
