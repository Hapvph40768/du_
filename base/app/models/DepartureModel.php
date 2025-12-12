<?php

namespace App\Models;

class DepartureModel extends BaseModel
{
    protected $table = "departures";

    public function getAllDepartures()
    {
        $sql = "
        SELECT d.*, t.name AS tour_name, t.price AS tour_price, t.start_location, t.destination,
               (SELECT COALESCE(SUM(b.num_people), 0) FROM bookings b WHERE b.departure_id = d.id AND b.status IN ('confirmed', 'pending_payment', 'completed', 'pending')) as booked_guests,
               (d.total_seats - (SELECT COALESCE(SUM(b.num_people), 0) FROM bookings b WHERE b.departure_id = d.id AND b.status IN ('confirmed', 'pending_payment', 'completed', 'pending'))) as real_remaining_seats,

               (SELECT GROUP_CONCAT(DISTINCT b.pickup_location SEPARATOR ', ') FROM bookings b WHERE b.departure_id = d.id AND b.pickup_location IS NOT NULL AND b.pickup_location != '') as pickup_locations_list,
               (SELECT MIN(b.start_date) FROM bookings b WHERE b.departure_id = d.id) as booking_start_date,
               (SELECT MAX(b.end_date) FROM bookings b WHERE b.departure_id = d.id) as booking_end_date
        FROM {$this->table} d
        JOIN tours t ON d.tour_id = t.id
        ORDER BY d.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getDepartureById($id)
    {
        $sql = "
        SELECT d.*, 
               t.name AS tour_name, t.price AS tour_price, 
               t.start_location, t.destination,
               (SELECT COALESCE(SUM(b.num_people), 0) FROM bookings b WHERE b.departure_id = d.id AND b.status IN ('confirmed', 'pending_payment', 'completed', 'pending')) as booked_guests,
               (d.total_seats - (SELECT COALESCE(SUM(b.num_people), 0) FROM bookings b WHERE b.departure_id = d.id AND b.status IN ('confirmed', 'pending_payment', 'completed', 'pending'))) as real_remaining_seats,
               (SELECT GROUP_CONCAT(DISTINCT b.pickup_location SEPARATOR ', ') FROM bookings b WHERE b.departure_id = d.id AND b.pickup_location IS NOT NULL AND b.pickup_location != '') as pickup_locations_list,
               (SELECT MIN(b.start_date) FROM bookings b WHERE b.departure_id = d.id) as booking_start_date,
               (SELECT MAX(b.end_date) FROM bookings b WHERE b.departure_id = d.id) as booking_end_date
        FROM {$this->table} d
        JOIN tours t ON d.tour_id = t.id
        WHERE d.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addDeparture($data)
    {
        $total = $data['total_seats']; // can be null

        $sql = "INSERT INTO {$this->table} 
        (tour_id, start_date, end_date, start_time, total_seats, seats_booked, remaining_seats,
         status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['start_time'] ?? null,
            $total,
            0,              // seats_booked = 0
            $total,         // remaining_seats = total (null if total is null)
            $data['status'] ?? 'open',
            date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s")
        ]);
    }

    public function updateDeparture($id, $data)
    {
        $current = $this->getDepartureById($id);
        $bookedSeats = $current->seats_booked;

        // If 'total_seats' key exists in data, use it (can be null). Else use current.
        // Careful: if $data does not contain 'total_seats', we assume we keep current.
        // But Controller passes it.
        $newTotal = array_key_exists('total_seats', $data) ? $data['total_seats'] : $current->total_seats;

        if ($newTotal !== null && $newTotal < $bookedSeats) {
            return false; // không được giảm tổng ghế nhỏ hơn ghế đã đặt (chỉ check khi có giới hạn)
        }

        if ($newTotal === null) {
            $newRemaining = null; // Unlimited
        } else {
            $newRemaining = $newTotal - $bookedSeats;
        }

        $sql = "UPDATE {$this->table} SET 
        tour_id=?, start_date=?, end_date=?, start_time=?, total_seats=?, seats_booked=?, 
        remaining_seats=?, status=?, updated_at=?
        WHERE id=?";

        $this->setQuery($sql);
        return $this->execute([
            $data['tour_id'],
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['start_time'] ?? null,
            $newTotal,
            $bookedSeats,
            $newRemaining,
            $data['status'],
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

    public function getBookingsByDepartureId($departureId)
    {
        $sql = "
            SELECT b.fullname, b.phone, b.total_price, b.num_people, b.status
            FROM bookings b
            JOIN departures d ON b.departure_id = d.id
            WHERE b.departure_id = ?
            ORDER BY b.created_at DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows([$departureId]);
    }
}
