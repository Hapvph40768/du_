<?php

namespace App\Models;

class ServiceChangeRequestsModel extends BaseModel
{
    protected $table = "service_change_requests";

    // Lấy tất cả yêu cầu thay đổi dịch vụ
    public function getAllRequests()
    {
        $sql = "
            SELECT scr.*, 
                   bk.id AS booking_id, 
                   u1.username AS requester_name, 
                   u2.username AS decision_by_name,
                   -- bk.fullname AS customer_name,
                   t.name AS tour_name,
                   s.name AS service_name
            FROM {$this->table} scr
            JOIN bookings bk ON scr.booking_id = bk.id
            JOIN departures d ON bk.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            LEFT JOIN services s ON scr.service_id = s.id
            LEFT JOIN users u1 ON scr.requester_id = u1.id
            LEFT JOIN users u2 ON scr.decision_by = u2.id
            ORDER BY scr.created_at DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy yêu cầu theo ID
    public function getRequestById($id)
    {
        $sql = "
            SELECT scr.*, 
                   bk.id AS booking_id, 
                   u1.username AS requester_name, 
                   u2.username AS decision_by_name,
                   -- bk.fullname AS customer_name,
                   t.name AS tour_name,
                   s.name AS service_name
            FROM {$this->table} scr
            JOIN bookings bk ON scr.booking_id = bk.id
            JOIN departures d ON bk.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            LEFT JOIN services s ON scr.service_id = s.id
            LEFT JOIN users u1 ON scr.requester_id = u1.id
            LEFT JOIN users u2 ON scr.decision_by = u2.id
            WHERE scr.id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Thêm yêu cầu mới
    public function addRequest($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (booking_id, service_id, requester_id, request, status) 
                VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['service_id'] ?? null,
            $data['requester_id'] ?? null,
            $data['request'],
            $data['status'] ?? 'pending'
        ]);
    }

    // Cập nhật yêu cầu (bao gồm quyết định duyệt)
    public function updateRequest($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET booking_id = ?, service_id = ?, requester_id = ?, request = ?, status = ?, 
                    decision_by = ?, decided_at = ?, updated_at = NOW() 
                WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['service_id'] ?? null,
            $data['requester_id'] ?? null,
            $data['request'],
            $data['status'] ?? 'pending',
            $data['decision_by'] ?? null,
            $data['decided_at'] ?? null,
            $id
        ]);
    }

    // Xóa yêu cầu
    public function deleteRequest($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}