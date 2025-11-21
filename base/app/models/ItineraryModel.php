<?php
namespace App\Models;

class ItineraryModel extends BaseModel
{
    protected $table = "itinerary";
    public function getAllItinerary()
    {
        $sql = "
        SELECT i.*, t.name AS tour_name
        FROM $this->table i
        JOIN tours t ON i.tour_id = t.id
        ORDER BY i.day_number ASC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    public function getItineraryById($id)
    {
        $sql = "
        SELECT i.*, t.name AS tour_name
        FROM $this->table i
        JOIN tours t ON i.tour_id = t.id
        wHERE i.id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function addItinerary($data)
    {
        $sql = "INSERT INTO $this->table (tour_id, day_number, title, content) VALUES (?, ?, ?, ?)"; 
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['day_number'],
            $data['title'],
            $data['content']
        ]);
    }
    public function updateItinerary($id, $data)
    {
        $sql = "UPDATE $this->table SET tour_id = ?, day_number = ?, title = ?, content = ? WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['day_number'],
            $data['title'],
            $data['content'],
            $id
        ]);
    }
    public function deleteItinerary($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?"; 
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
