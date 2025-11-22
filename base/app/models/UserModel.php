<?php
namespace App\Models;

class UserModel extends BaseModel
{
    protected $table = "users";

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM $this->table WHERE username = ?";
        $this->setQuery($sql);
        return $this->loadRow([$username]);
    }

    public function getAll()
    {
        $sql = "
        SELECT u.*, r.name AS role_name
        FROM $this->table u
        JOIN roles r ON u.role_id = r.id
        ORDER BY u.id DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    public function getByID($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function getPhone($phone)
    {
        $sql = "SELECT * FROM $this->table WHERE phone = ?";
        $this->setQuery($sql);
        return $this->loadRow([$phone]);
    }
    public function addUser($data)
    {
        $sql = "INSERT INTO $this->table (`role_id`, `username`, `password`, `fullname`, `phone`, `status`) 
        VALUE (?,?,?,?,?,?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['role_id'],
            $data['username'],
            $data['password'],
            $data['fullname'],
            $data['phone'],
            $data['status']
        ]);
    }
    public function updateUser($id,$data)
    {
        $sql = "UPDATE $this->table SET `role_id` = ?, `username` = ?, `password` = ?, `fullname` = ?, `phone` = ?, `status` = ? WHERE id =?";
        $this->setQuery($sql);
        return $this->execute([
            $data['role_id'],
            $data['username'],
            $data['password'],
            $data['fullname'],
            $data['phone'],
            $data['status'],
            $id
        ]);
    }
    public function deleteUser($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }

}
