<?php
namespace App\Models;

class DepartureModel extends BaseModel
{
    protected $table = "departures";

    public function getAllDepartures()
    {
        $sql = "
        SELECT d.*, t.name AS tour_title
        FROM {$this->table} d
        JOIN tours t ON d.tour_id = t.id
        ORDER BY d.depart_date DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getDepartureById($id)
    {
        $sql = "
        SELECT d.*, t.name AS tour_title
        FROM {$this->table} d
        JOIN tours t ON d.tour_id = t.id
        WHERE d.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addDeparture($data)
    {
        $sql = "INSERT INTO {$this->table} (tour_id, depart_date, seats_total, seats_booked, note, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['depart_date'],
            $data['seats_total'],
            $data['seats_booked'],
            $data['note'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateDeparture($id, $data)
    {
        $sql = "UPDATE {$this->table} SET tour_id=?, depart_date=?, seats_total=?, seats_booked=?, note=?, updated_at=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['depart_date'],
            $data['seats_total'],
            $data['seats_booked'],
            $data['note'],
            $data['updated_at'],
            $id
        ]);
    }

    public function deleteDeparture($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
