<?php
namespace App\Models;

class PaymentModel extends BaseModel
{
    protected $table = "payments";

    public function getAllPayments()
    {
        $sql = "
        SELECT p.*, b.customer_name
        FROM {$this->table} p
        JOIN bookings b ON p.booking_id = b.id
        ORDER BY p.pay_date DESC
        ";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getPaymentById($id)
    {
        $sql = "
        SELECT p.*, b.customer_name
        FROM {$this->table} p
        JOIN bookings b ON p.booking_id = b.id
        WHERE p.id=?
        ";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    public function addPayment($data)
    {
        $sql = "INSERT INTO {$this->table} (`booking_id`, `amount`, `pay_date`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['amount'],
            $data['pay_date'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function updatePayment($id, $data)
    {
        $sql = "UPDATE {$this->table} SET `booking_id`=?, `amount`=?, `pay_date`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['amount'],
            $data['pay_date'],
            $data['updated_at'],
            $id
        ]);
    }

    public function deletePayment($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}
?>
