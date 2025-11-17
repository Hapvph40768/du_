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
}