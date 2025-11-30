<?php
namespace App\Models;

class TourLogsModel extends BaseModel
{
    protected $table = "tour_logs";

    public function getAllLogs()
    {
        $sql = "
        SELECT tl.*, ds.depart_date
        FROM {$this->table} tl
        JOIN departure_schedules ds ON tl.departure_id = ds.id
        ORDER BY tl.day_number ASC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getLogById($id)
    {
        $sql = "
        SELECT tl.*, ds.depart_date
        FROM {$this->table} tl
        JOIN departure_schedules ds ON tl.departure_id = ds.id
        WHERE tl.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addLog($data)
    {
        $sql = "INSERT INTO {$this->table} (`departure_id`, `day_number`, `note`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['day_number'],
            $data['note'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateLog($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `departure_id`=?, `day_number`=?, `note`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['day_number'],
            $data['note'],
            $data['updated_at'],
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
