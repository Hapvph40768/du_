<?php
namespace App\Models;

class RolesModel extends BaseModel
{
    protected $table = 'roles';

    public function getAllRoles()
    {
        $sql = "SELECT * FROM $this->table";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    public function getRolesById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function addRoles($id,$name)
    {
        $sql = "INSERT INTO $this->table VALUE (?,?)";
        $this->setQuery($sql);
        return $this->execute([$id,$name]);
    }
    public function updateRoles($id,$name)
    {
        $sql = "UPDATE $this->table SET `name`=? WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$name,$id]);
    }
    public function deleteRoles($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}