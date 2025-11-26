<?php
namespace App\Models;

class TourGuideModel extends BaseModel
{
    protected $table = "tour_guides";

    public function getAllGuides()
    {
        $sql = "
        SELECT tg.*, u.fullname AS guide_name, d.date_start, d.date_end
        FROM {$this->table} tg
        JOIN users u ON tg.guide_id = u.id
        JOIN departures d ON tg.departure_id = d.id
        ORDER BY tg.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getGuideById($id)
    {
        $sql = "
        SELECT tg.*, u.fullname AS guide_name, d.date_start, d.date_end
        FROM {$this->table} tg
        JOIN users u ON tg.guide_id = u.id
        JOIN departures d ON tg.departure_id = d.id
        WHERE tg.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addGuide($data)
    {
        $sql = "INSERT INTO {$this->table} (`departure_id`, `guide_id`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['guide_id'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateGuide($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `departure_id`=?, `guide_id`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['guide_id'],
            $data['updated_at'],
            $id
        ]);
    }

    public function deleteGuide($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
