<?php
namespace App\Models;

class TourImgModel extends BaseModel
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

    public function addImage($data)
    {
        $sql = "INSERT INTO {$this->table} (`tour_id`, `image_path`, `is_thumbnail`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['image_path'],
            $data['is_thumbnail'] ?? 0,
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updateImage($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `tour_id`=?, `image_path`=?, `is_thumbnail`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['image_path'],
            $data['is_thumbnail'] ?? 0,
            $data['updated_at'],
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
