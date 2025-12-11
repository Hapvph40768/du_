<?php
namespace App\Models;

class TourModel extends BaseModel
{
    protected $table = "tours";

    // Lấy tất cả tour
    public function getAllTours()
    {
        $sql = "SELECT t.*, 
                       COALESCE(SUM(d.total_seats), 0) as total_seats, 
                       COALESCE(SUM(d.seats_booked), 0) as booked_seats
                FROM {$this->table} t
                LEFT JOIN departures d ON t.id = d.tour_id AND d.status = 'open'
                GROUP BY t.id
                ORDER BY t.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy tour theo trạng thái
    public function getToursByStatus($status)
    {
        $sql = "SELECT t.*, 
                       COALESCE(SUM(d.total_seats), 0) as total_seats, 
                       COALESCE(SUM(d.seats_booked), 0) as booked_seats
                FROM {$this->table} t
                LEFT JOIN departures d ON t.id = d.tour_id AND d.status = 'open'
                WHERE t.status = ?
                GROUP BY t.id
                ORDER BY t.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows([$status]);
    }

    // Lấy tour theo ID
    public function getTourById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm tour mới
    public function addTour($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (`name`, `slug`, `description`, `price`, `start_location`, `destination`, `thumbnail`, `status`, `category`, `created_at`, `updated_at`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['name'],
            $data['slug'] ?? null,
            $data['description'] ?? null,
            $data['price'] ?? 0.00,
            $data['start_location'] ?? null,
            $data['destination'] ?? null,
            $data['thumbnail'] ?? null,
            $data['status'] ?? 'active',
            $data['category'] ?? null,
            $data['created_at'] ?? date("Y-m-d H:i:s"),
            $data['updated_at'] ?? null
        ]);
    }

    // Cập nhật tour
    public function updateTour($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        `name`=?, `slug`=?, `description`=?, `price`=?, `start_location`=?, `destination`=?, `thumbnail`=?, `status`=?, `category`=?, `updated_at`=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['name'],
            $data['slug'] ?? null,
            $data['description'] ?? null,
            $data['price'] ?? 0.00,
            $data['start_location'] ?? null,
            $data['destination'] ?? null,
            $data['thumbnail'] ?? null,
            $data['status'] ?? 'active',
            $data['category'] ?? null,
            $data['updated_at'] ?? date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa tour
    public function deleteTour($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }

    // Trả về danh sách category có sẵn (key => label)
    public static function getCategories()
    {
        return [
            'domestic' => 'Tour trong nước',
            'international' => 'Tour quốc tế',
            'on_demand' => 'Tour theo yêu cầu',
        ];
    }

    // Lấy tours và gom theo category
    public function getToursGroupedByCategory()
    {
        $tours = $this->getAllTours();
        $groups = [];
        foreach ($tours as $tour) {
            $cat = $tour->category ?? 'other';
            if ($cat === '') {
                $cat = 'other';
            }
            if (!isset($groups[$cat])) {
                $groups[$cat] = [];
            }
            $groups[$cat][] = $tour;
        }
        return $groups;
    }
}
?>