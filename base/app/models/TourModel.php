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
    public function addTour($tour_id,$tour_name,$category,$price,$duration,$description,$thumbnail)
    {
        $sql = "INSERT INTO $this->table VALUES 
        (?,?,?,?,?,?,?)";
        $this->setQuery($sql);
        return $this->execute([$tour_id,$tour_name,$category,$price,$duration,$description,$thumbnail]);
    }
        public function editTour($tour_id,$tour_name,$category,$price,$duration,$description,$thumbnail)
    {
        $sql = "UPDATE $this->table SET 
        `tour_id`=?,`tour_name`=?,`category`=?,`price`=?,`duration`=?,`description`=?,`thumbnail`=? WHERE id =? ";
        $this->setQuery($sql);
        return $this->execute([$tour_name,$category,$price,$duration,$description,$thumbnail,,$tour_id]);
    }
    public function deleteTour($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
    
}