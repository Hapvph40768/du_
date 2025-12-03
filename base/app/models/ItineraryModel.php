<?php
namespace App\Models;

class ItineraryModel extends BaseModel
{
    protected $table = "itinerary";

    // Lấy tất cả itinerary
    public function getAllItineraries()
    {
        $sql = "
        SELECT i.*, t.name AS tour_name
        FROM {$this->table} i
        JOIN tours t ON i.tour_id = t.id
        ORDER BY i.tour_id, i.day_number
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy itinerary theo ID
    public function getItineraryById($id)
    {
        $sql = "
        SELECT i.*, t.name AS tour_name
        FROM {$this->table} i
        JOIN tours t ON i.tour_id = t.id
        WHERE i.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm itinerary
    public function addItinerary($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (`tour_id`, `day_number`, `title`, `description`, `created_at`, `updated_at`) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['day_number'],
            $data['title'],
            $data['description'],
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật itinerary
    public function updateItinerary($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        `tour_id`=?, `day_number`=?, `title`=?, `description`=?, `updated_at`=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['day_number'],
            $data['title'],
            $data['description'],
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa itinerary
    public function deleteItinerary($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>