<?php
namespace App\Models;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    public function getUserByUsername($username)
    {
        $this->setQuery("SELECT * FROM users WHERE username = ?");
        return $this->loadRow([$username]);
    }

    public function createUser($data)
    {
        $this->setQuery("INSERT INTO users (username, email, password, role, avatar, is_active, last_login) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $this->execute($data);
    }
}