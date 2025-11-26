<?php
namespace App\Models;

class UserModel extends BaseModel
{
    protected $table = 'users';

    public function getAll()
    {
        $this->setQuery("SELECT * FROM {$this->table}");
        return $this->loadAllRows();
    }

    public function getById($id)
    {
        $this->setQuery("SELECT * FROM {$this->table} WHERE id = ?");
        return $this->loadRow([$id]);
    }

    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (`username`, `password`, `fullname`, `phone`, `status`, `created_at`, `updated_at`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['username'], 
            $data['password'], 
            $data['fullname'], 
            $data['phone'] ?? null, 
            $data['status'] ?? 1,
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET  `username`=?, `password`=?, `fullname`=?, `phone`=?, `status`=?, `updated_at`=? WHERE id=?";
        $this->setQuery($sql);
        return $this->execute([
            $data['username'], 
            $data['password'], 
            $data['fullname'], 
            $data['phone'] ?? null, 
            $data['status'] ?? 1,
            $data['updated_at'],
            $id
        ]);
    }

    public function delete($id)
    {
        $this->setQuery("DELETE FROM {$this->table} WHERE id=?");
        return $this->execute([$id]);
    }
}
?>
