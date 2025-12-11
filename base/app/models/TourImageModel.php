<?php
namespace App\Models;

class TourImageModel extends BaseModel
{
    protected $table = "tour_images";

    public function getAllImages()
    {
        $sql = "
        SELECT ti.*, t.name AS tour_name
        FROM {$this->table} ti
        JOIN tours t ON ti.tour_id = t.id
        ORDER BY ti.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getImageById($id)
    {
        $sql = "
        SELECT ti.*, t.name AS tour_name
        FROM {$this->table} ti
        JOIN tours t ON ti.tour_id = t.id
        WHERE ti.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function getImagesByTourId($tour_id)
    {
        $sql = "
        SELECT ti.*, t.name AS tour_name
        FROM {$this->table} ti
        JOIN tours t ON ti.tour_id = t.id
        WHERE ti.tour_id = ?
        ORDER BY ti.is_thumbnail DESC, ti.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows([$tour_id]);
    }

    public function addImage($data)
    {
        $sql = "INSERT INTO {$this->table} (`tour_id`, `image_url`, `alt_text`, `is_thumbnail`, `created_at`) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['image_url'],
            $data['alt_text'] ?? NULL,
            $data['is_thumbnail'] ?? 0,
            $data['created_at']
        ]);
    }

    public function updateImage($id, $data)
    {
        // Note: The provided CREATE TABLE does not have updated_at, so we remove it from update query
        $sql = "UPDATE {$this->table} SET `tour_id`=?, `image_url`=?, `alt_text`=?, `is_thumbnail`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['image_url'],
            $data['alt_text'] ?? NULL,
            $data['is_thumbnail'] ?? 0,
            $id
        ]);
    }

    public function deleteImage($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>