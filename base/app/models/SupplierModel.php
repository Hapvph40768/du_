<?php
namespace App\Models;

class SupplierModel extends BaseModel
{
    protected $table = 'suppliers';

    public function getAll()
    {
        $this->setQuery("SELECT * FROM {$this->table}");
        return $this->loadAllRows();
    }

    public function getById($id)
    {
        $this->setQuery("SELECT * FROM {$this->table} WHERE id=?");
        return $this->loadRow([$id]);
    }

    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (name, type, phone, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['name'],
            $data['type'] ?? null,
            $data['phone'] ?? null,
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `name`=?, `type`=?, `phone`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['name'],
            $data['type'] ?? null,
            $data['phone'] ?? null,
            $data['updated_at'],
            $id
        ]);
    }

    public function delete($id)
    {
        $this->setQuery("DELETE FROM {$this->table} WHERE id=?");
        return $this->execute([$id]);
    }
}
?>
