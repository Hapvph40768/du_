<?php 
namespace App\Models;

class TourModel extends BaseModel
{
    protected $table = "tours";
    public function getListTours()
    {
        $sql = "SELECT * FROM $this->table";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    public function getTourById($id){
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function addTour($id,$name,$description,$price,$days,$status)
    {
        $sql = "INSERT INTO $this->table VALUES 
        (?,?,?,?,?,?)";
        $this->setQuery($sql);
        return $this->execute([$id,$name,$description,$price,$days,$status]);
    }
        public function editTour($id,$name,$description,$price,$days,$status)
    {
        $sql = "UPDATE $this->table SET 
        `name`=?,`description`=?,`price`=?,`days`=?,`status`=? WHERE id =? ";
        $this->setQuery($sql);
        return $this->execute([$name,$description,$price,$days,$status,$id]);
    }
    public function deleteTour($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
    
}