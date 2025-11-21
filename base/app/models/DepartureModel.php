<?php
namespace App\Models;

class DepartureModel extends BaseModel
{
    protected $table = "departures";
    public function getAllDepartures()
    {
        $sql = "
        SELECT d.*, t.name AS tour_name
        FROM $this->table d
        JOIN tours t ON d.tour_id = t.id
        ORDER BY d.date_start DESC
    ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getDepartureById($id)
    {
        $sql = "
        SELECT d.*, t.name AS tour_name
        FROM $this->table d
        JOIN tours t ON d.tour_id = t.id
        WHERE d.id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function addDeparture($data){
        $sql = "INSERT INTO $this->table (tour_id, date_start, date_end, seats_total, seats_remaining) VALUES (?, ?, ?, ?, ?)"; 
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['date_start'],
            $data['date_end'],
            $data['seats_total'],
            $data['seats_remaining']
        ]);
    }
    public function updateDeparture($id, $data){
        $sql = "UPDATE $this->table SET tour_id = ?, date_start = ?, date_end = ?, seats_total = ?, seats_remaining = ? WHERE id = ?"; 
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['date_start'],
            $data['date_end'],
            $data['seats_total'],
            $data['seats_remaining'],
            $id
        ]);
    }
    public function deleteDeparture($id){
        $sql = "DELETE FROM $this->table WHERE id = ?"; 
        $this->setQuery($sql);
        return $this->execute([$id]);
    }


}