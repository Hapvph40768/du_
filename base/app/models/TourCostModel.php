<?php
namespace App\Models;

class TourCostModel extends BaseModel
{
    protected $table = 'tour_costs';

    // Lấy tất cả chi phí
    public function getAllCosts($departure_id = null)
    {
        $sql = "SELECT tc.*, d.start_date, t.name as tour_name 
                FROM {$this->table} tc
                JOIN departures d ON tc.departure_id = d.id
                JOIN tours t ON d.tour_id = t.id";
        
        $params = [];
        if ($departure_id) {
            $sql .= " WHERE tc.departure_id = ?";
            $params[] = $departure_id;
        }

        $sql .= " ORDER BY tc.created_at DESC";

        $this->setQuery($sql);
        return $this->loadAllRows($params);
    }

    // Lấy chi tiết chi phí
    public function getCostById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm chi phí
    public function addCost($data)
    {
        $sql = "INSERT INTO {$this->table} (departure_id, title, amount, created_at) VALUES (?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['title'],
            $data['amount'],
            date('Y-m-d H:i:s')
        ]);
    }

    // Cập nhật chi phí
    public function updateCost($id, $data)
    {
        $sql = "UPDATE {$this->table} SET departure_id = ?, title = ?, amount = ? WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['title'],
            $data['amount'],
            $id
        ]);
    }

    // Xóa chi phí
    public function deleteCost($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }

    // Tổng chi phí theo departure
    public function getTotalCostByDeparture($departure_id)
    {
        $sql = "SELECT SUM(amount) as total FROM {$this->table} WHERE departure_id = ?";
        $this->setQuery($sql);
        $res = $this->loadRow([$departure_id]);
        return $res->total ?? 0;
    }
}
