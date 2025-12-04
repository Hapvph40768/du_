<?php
namespace App\Models;

class GuidesModel extends BaseModel
{
    protected $table = "guides";

    // Lấy tất cả hướng dẫn viên
    public function getAllGuides()
    {
        $sql = "SELECT g.*, u.username AS account_name 
                FROM {$this->table} g 
                JOIN users u ON g.user_id = u.id
                ORDER BY g.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy hướng dẫn viên theo ID
    public function getGuideById($id)
    {
        $sql = "SELECT g.*, u.username AS account_name 
                FROM {$this->table} g 
                JOIN users u ON g.user_id = u.id
                WHERE g.id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm hướng dẫn viên
    public function addGuide($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (user_id, fullname, phone, email, gender, languages, experience_years, experience, certificate_url, avatar, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'],
            $data['fullname'] ?? null,
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['gender'] ?? null,
            $data['languages'] ?? null, // JSON string
            $data['experience_years'] ?? 0,
            $data['experience'] ?? null,
            $data['certificate_url'] ?? null,
            $data['avatar'] ?? null,
            $data['status'] ?? 'active',
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật hướng dẫn viên
    public function updateGuide($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        user_id=?, fullname=?, phone=?, email=?, gender=?, languages=?, experience_years=?, experience=?, certificate_url=?, avatar=?, status=?, updated_at=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'],
            $data['fullname'] ?? null,
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['gender'] ?? null,
            $data['languages'] ?? null,
            $data['experience_years'] ?? 0,
            $data['experience'] ?? null,
            $data['certificate_url'] ?? null,
            $data['avatar'] ?? null,
            $data['status'] ?? 'active',
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
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