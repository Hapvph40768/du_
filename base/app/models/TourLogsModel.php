<?php
namespace App\Models;

class TourLogsModel extends BaseModel
{
    protected $table = "tour_logs";

    public function getAllLogs()
    {
        $sql = "
            SELECT 
                tl.*, 
                d.start_date, 
                d.end_date,
                t.name AS tour_name,
                u.username AS user_name
            FROM {$this->table} tl
            LEFT JOIN departures d ON tl.departure_id = d.id
            LEFT JOIN tours t ON tl.tour_id = t.id
            LEFT JOIN users u ON tl.user_id = u.id
            ORDER BY tl.id DESC
        ";

        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getLogById($id)
    {
        $sql = "
            SELECT 
                tl.*, 
                d.start_date, 
                d.end_date,
                t.name AS tour_name,
                u.username AS user_name
            FROM {$this->table} tl
            LEFT JOIN departures d ON tl.departure_id = d.id
            LEFT JOIN tours t ON tl.tour_id = t.id
            LEFT JOIN users u ON tl.user_id = u.id
            WHERE tl.id = ?
        ";

        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addLog($data)
    {
        $sql = "
            INSERT INTO {$this->table} 
            (`tour_id`, `departure_id`, `user_id`, `action`, `message`, `created_at`)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['departure_id'],
            $data['user_id'],
            $data['action'],
            $data['message'],
            $data['created_at']
        ]);
    }

    public function updateLog($id, $data)
    {
        $sql = "
            UPDATE {$this->table} 
            SET `tour_id`=?, `departure_id`=?, `user_id`=?, `action`=?, `message`=? 
            WHERE id=?
        ";

        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['departure_id'],
            $data['user_id'],
            $data['action'],
            $data['message'],
            $id
        ]);
    }

    public function deleteLog($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
