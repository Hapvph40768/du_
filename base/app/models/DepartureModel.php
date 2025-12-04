<?php
namespace App\Models;

class DepartureModel extends BaseModel
{
    protected $table = "departures";

    // Lấy tất cả departures
    public function getAllDepartures()
    {
        $sql = "
        SELECT d.*, t.name AS tour_name, t.price AS tour_price
        FROM {$this->table} d
        JOIN tours t ON d.tour_id = t.id
        ORDER BY d.start_date DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy departure theo ID
    public function getDepartureById($id)
    {
        $sql = "
        SELECT d.*, t.name AS tour_name, t.price AS tour_price
        FROM {$this->table} d
        JOIN tours t ON d.tour_id = t.id
        WHERE d.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm departure mới
    public function addDeparture($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (tour_id, start_date, end_date, price, available_seats, status, guide_price, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);

        return $this->execute([
            $data['tour_id'],
            $data['start_date'],
            $data['end_date'],
            // nếu price rỗng thì lấy giá tour
            ($data['price'] === '' || $data['price'] === null) ? $data['tour_price'] : $data['price'],
            $data['available_seats'] ?? 0,
            $data['status'] ?? 'open',
            $data['guide_price'] === '' ? null : $data['guide_price'],
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? date("Y-m-d H:i:s")
        ]);
    }

    // Cập nhật departure
    public function updateDeparture($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        tour_id=?, start_date=?, end_date=?, price=?, available_seats=?, status=?, guide_price=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);

        return $this->execute([
            $data['tour_id'],
            $data['start_date'],
            $data['end_date'],
            // nếu price rỗng thì lấy giá tour
            ($data['price'] === '' || $data['price'] === null) ? $data['tour_price'] : $data['price'],
            $data['available_seats'] ?? 0,
            $data['status'] ?? 'open',
            $data['guide_price'] === '' ? null : $data['guide_price'],
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa departure
    public function deleteDeparture($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>