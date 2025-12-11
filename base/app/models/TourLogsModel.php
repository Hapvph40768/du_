<?php
namespace App\Models;

class TourLogsModel extends BaseModel
{
    protected $table = "tour_logs";

    public function getAllLogs()
    {
        $sql = "
        SELECT tl.*, t.name as tour_name, d.start_date as departure_date, u.username as user_name
        FROM {$this->table} tl
        JOIN tours t ON tl.tour_id = t.id
        LEFT JOIN departures d ON tl.departure_id = d.id
        LEFT JOIN users u ON tl.user_id = u.id
        ORDER BY tl.created_at DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getLogById($id)
    {
        $sql = "
        SELECT tl.*
        FROM {$this->table} tl
        WHERE tl.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addLog($data)
    {
        $sql = "INSERT INTO {$this->table} (`tour_id`, `departure_id`, `user_id`, `action`, `message`, `created_at`) VALUES (?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['departure_id'] ?? null,
            $data['user_id'] ?? null,
            $data['action'] ?? null,
            $data['message'] ?? null,
            $data['created_at']
        ]);
    }

    public function updateLog($id, $data)
    {
        // Typically logs are immutable, but if edit is allowed:
        $sql = "UPDATE {$this->table} SET `tour_id`=?, `departure_id`=?, `user_id`=?, `action`=?, `message`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['departure_id'] ?? null,
            $data['user_id'] ?? null,
            $data['action'] ?? null,
            $data['message'] ?? null,
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
