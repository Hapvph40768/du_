<?php
namespace App\Models;

class TourGuideModel extends BaseModel
{
    protected $table = "tour_guides";

    public function getAllGuides()
    {
        $sql = "
        SELECT tg.*, g.fullname AS guide_name, t.name AS tour_name, d.start_date, d.end_date,
               (SELECT MIN(b.start_date) FROM bookings b WHERE b.departure_id = d.id) as booking_start_date,
               (SELECT MAX(b.end_date) FROM bookings b WHERE b.departure_id = d.id) as booking_end_date
        FROM {$this->table} tg
        JOIN guides g ON tg.guide_id = g.id
        JOIN departures d ON tg.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        ORDER BY tg.id DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getAssignedTours($guide_id)
    {
        $sql = "
        SELECT tg.*, t.name AS tour_name, g.fullname as guide_name, d.id as id, d.tour_id, d.start_date, d.end_date, d.status AS departure_status, t.thumbnail,
               (SELECT COALESCE(SUM(b.num_people), 0) FROM bookings b WHERE b.departure_id = d.id AND b.status IN ('confirmed', 'pending_payment', 'completed', 'pending')) as booked_guests,
               (SELECT MIN(b.start_date) FROM bookings b WHERE b.departure_id = d.id) as booking_start_date,
               (SELECT MAX(b.end_date) FROM bookings b WHERE b.departure_id = d.id) as booking_end_date
        FROM {$this->table} tg
        JOIN departures d ON tg.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        JOIN guides g ON tg.guide_id = g.id
        WHERE tg.guide_id = ?
        ORDER BY d.start_date DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows([$guide_id]);
    }

    public function getNextTour($guide_id)
    {
        $sql = "
        SELECT tg.*, t.name AS tour_name, d.id as departure_id, d.start_date, d.end_date,
               (SELECT COALESCE(SUM(b.num_people), 0) FROM bookings b WHERE b.departure_id = d.id AND b.status IN ('confirmed', 'pending_payment', 'completed', 'pending')) as booked_guests
        FROM {$this->table} tg
        JOIN departures d ON tg.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        WHERE tg.guide_id = ? AND d.end_date >= CURRENT_DATE()
        ORDER BY d.start_date ASC
        LIMIT 1
        ";
        $this->setQuery($sql);
        return $this->loadRow([$guide_id]);
    }

    public function getGuideById($id)
    {
        $sql = "
        SELECT tg.*, g.fullname AS guide_name, t.name AS tour_name, d.start_date, d.end_date
        FROM {$this->table} tg
        JOIN guides g ON tg.guide_id = g.id
        JOIN departures d ON tg.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        WHERE tg.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addGuide($data)
    {
        $sql = "INSERT INTO {$this->table} 
        (`departure_id`, `guide_id`, `role`, `assigned_at`, `created_at`, `updated_at`) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['guide_id'],
            $data['role'] ?? 'assistant',
            $data['assigned_at'] ?? date('Y-m-d H:i:s'),
            $data['created_at'] ?? date('Y-m-d H:i:s'),
            $data['updated_at'] ?? null
        ]);
    }

    public function updateGuide($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
        `departure_id`=?, `guide_id`=?, `role`=?, `assigned_at`=?, `updated_at`=? 
        WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['departure_id'],
            $data['guide_id'],
            $data['role'] ?? 'assistant',
            $data['assigned_at'] ?? date('Y-m-d H:i:s'),
            $data['updated_at'] ?? date('Y-m-d H:i:s'),
            $id
        ]);
    }

    public function deleteGuide($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
    public function checkOverlappingAssignment($guideId, $departureId, $ignoreAssignmentId = null)
    {
        // 1. Get effective dates for the target departure
        $sqlTarget = "
            SELECT 
                COALESCE(d.start_date, (SELECT MIN(b.start_date) FROM bookings b WHERE b.departure_id = d.id)) as effective_start,
                COALESCE(d.end_date, (SELECT MAX(b.end_date) FROM bookings b WHERE b.departure_id = d.id)) as effective_end
            FROM departures d
            WHERE d.id = ?
        ";
        $this->setQuery($sqlTarget);
        $target = $this->loadRow([$departureId]);

        if (!$target || !$target->effective_start || !$target->effective_end) {
            return false;
        }

        $targetStart = strtotime($target->effective_start);
        $targetEnd = strtotime($target->effective_end);

        // 2. Get all other assignments for this guide
        $sqlOthers = "
            SELECT tg.id, 
                COALESCE(d.start_date, (SELECT MIN(b.start_date) FROM bookings b WHERE b.departure_id = d.id)) as effective_start,
                COALESCE(d.end_date, (SELECT MAX(b.end_date) FROM bookings b WHERE b.departure_id = d.id)) as effective_end,
                t.name as tour_name
            FROM tour_guides tg
            JOIN departures d ON tg.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            WHERE tg.guide_id = ?
        ";

        if ($ignoreAssignmentId) {
            $sqlOthers .= " AND tg.id != $ignoreAssignmentId";
        }

        $this->setQuery($sqlOthers);
        $assignments = $this->loadAllRows([$guideId]);

        // 3. Check for overlap
        foreach ($assignments as $a) {
            if ($a->effective_start && $a->effective_end) {
                $otherStart = strtotime($a->effective_start);
                $otherEnd = strtotime($a->effective_end);

                // Overlap condition:
                // Target:       [TS......TE]
                // Other:   [OS......OE]
                // Overlap exists if (TS <= OE) and (TE >= OS)
                
                if ($targetStart <= $otherEnd && $targetEnd >= $otherStart) {
                    return $a->tour_name;
                }
            }
        }

        return false;
    }

    public function getGuidesByDeparture($departureId)
    {
        $sql = "
        SELECT g.id, g.fullname, g.username, g.phone, tg.role
        FROM guides g
        JOIN tour_guides tg ON g.id = tg.guide_id
        WHERE tg.departure_id = ?
        ";
        $this->setQuery($sql);
        return $this->loadAllRows([$departureId]);
    }
}
?>
