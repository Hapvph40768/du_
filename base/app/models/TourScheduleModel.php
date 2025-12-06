<?php
namespace App\Models;

class TourScheduleModel extends BaseModel
{
    protected $table = "tour_schedules";

    // ========== Lấy tất cả lịch trình theo tour ==========
    public function getByTour($tour_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tour_id = ? ORDER BY day_number ASC";
        $this->setQuery($sql);
        return $this->loadAllRows([$tour_id]);
    }

    // ========== Lấy 1 lịch trình theo ID ==========
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // ========== Thêm lịch trình ==========
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (tour_id, day_number, date, title, description, activities, meals, accommodation, transport, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['day_number'],
            $data['date'],
            $data['title'],
            $data['description'],
            $data['activities'],
            $data['meals'],
            $data['accommodation'],
            $data['transport'],
            $data['created_at'],
            $data['updated_at'],
        ]);
    }

    // ========== Cập nhật lịch trình ==========
    public function updateById($id, $data)
    {
        $sql = "UPDATE {$this->table} SET
            day_number=?, date=?, title=?, description=?, activities=?, meals=?, accommodation=?, transport=?, updated_at=?
            WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['day_number'],
            $data['date'],
            $data['title'],
            $data['description'],
            $data['activities'],
            $data['meals'],
            $data['accommodation'],
            $data['transport'],
            $data['updated_at'],
            $id
        ]);
    }

    // ========== Xóa lịch trình ==========
    public function deleteById($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
