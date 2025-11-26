<?php
namespace App\Models;

class GuidesModel extends BaseModel
{
    protected $table = "guides";

    // Lấy tất cả hướng dẫn viên kèm thông tin user
    public function getAllGuides()
    {
        $sql = "
        SELECT g.*, u.username, u.fullname, u.phone
        FROM {$this->table} g
        JOIN users u ON g.user_id = u.id
        ORDER BY g.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy thông tin hướng dẫn viên theo id
    public function getGuideById($id)
    {
        $sql = "
        SELECT g.*, u.username, u.fullname, u.phone
        FROM {$this->table} g
        JOIN users u ON g.user_id = u.id
        WHERE g.id = ?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm hướng dẫn viên
    public function addGuide($data)
    {
        $sql = "INSERT INTO {$this->table} (user_id, experience_years, certificate, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'],
            $data['experience_years'] ?? 0,
            $data['certificate'] ?? '',
            $data['status'] ?? 1,
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    // Cập nhật thông tin hướng dẫn viên
    public function updateGuide($id, $data)
    {
        $sql = "UPDATE {$this->table} SET user_id=?, experience_years=?, certificate=?, status=?, updated_at=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'],
            $data['experience_years'] ?? 0,
            $data['certificate'] ?? '',
            $data['status'] ?? 1,
            $data['updated_at'],
            $id
        ]);
    }

    // Xóa hướng dẫn viên
    public function deleteGuide($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
