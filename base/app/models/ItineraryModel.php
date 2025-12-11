<?php

namespace App\Models;

class ItineraryModel extends BaseModel
{
    protected $table = "itinerary";

    // Lấy tất cả itinerary kèm thông tin tour và lịch khởi hành
    public function getAllItineraries()
    {
        $sql = "
        SELECT i.*, 
               t.name AS tour_name,
               t.price AS departure_price,
               d.status AS departure_status
        FROM {$this->table} i
        JOIN tours t ON i.tour_id = t.id
        JOIN departures d ON i.departure_id = d.id
        ORDER BY i.tour_id, i.departure_id, i.day_number
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy tất cả itinerary theo departure_id
    public function getItinerariesByDeparture($departure_id)
    {
        $sql = "
    SELECT i.*, 
           t.name AS tour_name,
           t.price AS departure_price,
           d.status AS departure_status
    FROM {$this->table} i
    JOIN tours t ON i.tour_id = t.id
    JOIN departures d ON i.departure_id = d.id
    WHERE i.departure_id = ?
    ORDER BY i.day_number
    ";
        $this->setQuery($sql);
        return $this->loadAllRows([$departure_id]);
    }

    // Lấy itinerary theo ID kèm thông tin tour và lịch khởi hành
    public function getItineraryById($id)
    {
        $sql = "
        SELECT i.*, 
               t.name AS tour_name,
               t.price AS departure_price,
               d.status AS departure_status
        FROM {$this->table} i
        JOIN tours t ON i.tour_id = t.id
        JOIN departures d ON i.departure_id = d.id
        WHERE i.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm itinerary với departure_id
    public function addItinerary($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (`tour_id`, `departure_id`, `day_number`, `title`, `description`, `created_at`, `updated_at`) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['departure_id'],
            $data['day_number'],
            $data['title'],
            $data['description'],
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật itinerary với departure_id
    public function updateItinerary($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        `tour_id`=?, `departure_id`=?, `day_number`=?, `title`=?, `description`=?, `updated_at`=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['departure_id'],
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
