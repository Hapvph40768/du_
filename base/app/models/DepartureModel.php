<?php

namespace App\Models;

class DepartureModel extends BaseModel
{
    protected $table = "departures";

    public function getAllDepartures()
    {
        $sql = "
        SELECT d.*, t.name AS tour_name, t.price AS tour_price
        FROM {$this->table} d
        JOIN tours t ON d.tour_id = t.id
        ORDER BY d.start_date DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getDepartureById($id)
    {
        $sql = "
        SELECT d.*, t.name AS tour_name, t.price AS tour_price
        FROM {$this->table} d
        JOIN tours t ON d.tour_id = t.id
        WHERE d.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addDeparture($data)
    {
        $total = $data['total_seats'];

        $sql = "INSERT INTO {$this->table} 
        (tour_id, start_date, end_date, price, total_seats, seats_booked, remaining_seats,
         status, guide_price, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['start_date'],
            $data['end_date'],
            $data['price'],
            $total,
            0,              // seats_booked = 0
            $total,         // remaining_seats = total
            $data['status'] ?? 'open',
            $data['guide_price'] ?: null,
            date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s")
        ]);
    }

    public function updateDeparture($id, $data)
    {
        $current = $this->getDepartureById($id);
        $bookedSeats = $current->seats_booked;

        $newTotal = $data['total_seats'] ?? $current->total_seats;

        if ($newTotal < $bookedSeats) {
            return false; // không được giảm tổng ghế nhỏ hơn ghế đã đặt
        }

        $newRemaining = $newTotal - $bookedSeats;

        $sql = "UPDATE {$this->table} SET 
        tour_id=?, start_date=?, end_date=?, price=?, total_seats=?, seats_booked=?, 
        remaining_seats=?, status=?, guide_price=?, updated_at=?
        WHERE id=?";

        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['start_date'],
            $data['end_date'],
            $data['price'],
            $newTotal,
            $bookedSeats,
            $newRemaining,
            $data['status'],
            $data['guide_price'] ?: null,
            date("Y-m-d H:i:s"),
            $id
        ]);
    }


    public function deleteDeparture($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
