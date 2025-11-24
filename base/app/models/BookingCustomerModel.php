<?php
namespace App\Models;

class BookingCustomerModel extends BaseModel
{
    protected $table = 'booking_customers';
    public function getByBookingId(){
        $sql = "SELECT * FROM $this->table";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    public function getById($id){
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function addBooking($data){
        $sql = "INSERT INTO $this->table (`booking_id`,`fullname`, `gender`, `dob`) VALUE (?,?,?,?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['fullname'],
            $data['gender'],
            $data['dob']
        ]);
    }
    public function updateCustomer($id, $data)
    {
        $sql = "UPDATE $this->table 
                SET booking_id = ?, fullname = ?, gender = ?, dob = ?
                WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([
            $data['booking_id'],
            $data['fullname'],
            $data['gender'],
            $data['dob'],
            $id
        ]);
    }

    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}