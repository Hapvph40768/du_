<?php
namespace App\Models;

class BookingServiceModel extends BaseModel
{
    protected $table = "booking_services";

    // Lấy tất cả dịch vụ kèm theo booking
    public function getAllBookingServices()
    {
        $sql = "
        SELECT bs.*, b.id AS booking_id, s.name AS service_name
        FROM {$this->table} bs
        JOIN bookings b ON bs.booking_id = b.id
        JOIN services s ON bs.service_id = s.id
        ORDER BY bs.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    // Lấy dịch vụ theo ID
    public function getBookingServiceById($id)
    {
        $sql = "
        SELECT bs.*, b.id AS booking_id, s.name AS service_name
        FROM {$this->table} bs
        JOIN bookings b ON bs.booking_id = b.id
        JOIN services s ON bs.service_id = s.id
        WHERE bs.id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    // Lấy tất cả dịch vụ theo booking_id
    public function getServicesByBooking($booking_id)
    {
        $sql = "SELECT 
                    bs.id, 
                    bs.service_id, 
                    bs.quantity, 
                    bs.price, 
                    bs.created_at, 
                    bs.updated_at, 
                    s.name AS service_name
                FROM {$this->table} bs
                JOIN services s ON bs.service_id = s.id
                WHERE bs.booking_id = ?";
        $this->setQuery($sql);
        return $this->loadAllRows([$booking_id]);
    }

    // Thêm dịch vụ vào booking
    public function addBookingService($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (booking_id, service_id, quantity, price, created_at) 
                VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['service_id'],
            $data['quantity'] ?? 1,
            $data['price'] ?? 0.00,
            $data['created_at'] ?? date("Y-m-d H:i:s")
        ]);
    }

    // Cập nhật dịch vụ trong booking
    public function updateBookingService($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                    booking_id = ?, 
                    service_id = ?, 
                    quantity = ?, 
                    price = ?, 
                    updated_at = ?
                WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['service_id'],
            $data['quantity'] ?? 1,
            $data['price'] ?? 0.00,
            date("Y-m-d H:i:s"),
            $id
        ]);
    }

    // Xóa dịch vụ khỏi booking
    public function deleteBookingService($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>