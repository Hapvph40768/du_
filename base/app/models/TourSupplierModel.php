<?php
namespace App\Models;

class TourSupplierModel extends BaseModel
{
    protected $table = "tour_suppliers";

    public function getAllTourSuppliers()
    {
        $sql = "
        SELECT ts.*, t.name AS tour_name, s.name AS supplier_name
        FROM {$this->table} ts
        JOIN tours t ON ts.tour_id = t.id
        JOIN suppliers s ON ts.supplier_id = s.id
        ORDER BY ts.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getTourSupplierById($id)
    {
        $sql = "
        SELECT ts.*, t.name AS tour_name, s.name AS supplier_name
        FROM {$this->table} ts
        JOIN tours t ON ts.tour_id = t.id
        JOIN suppliers s ON ts.supplier_id = s.id
        WHERE ts.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addTourSupplier($data)
    {
        $sql = "INSERT INTO {$this->table} (`tour_id`, `supplier_id`, `role`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['supplier_id'],
            $data['role'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateTourSupplier($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `tour_id`=?, `supplier_id`=?, `role`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['supplier_id'],
            $data['role'],
            $data['updated_at'],
            $id
        ]);
    }

    public function deleteTourSupplier($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
