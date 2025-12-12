<?php

namespace App\Models;

use App\Models\BaseModel;

class PasswordResetModel extends BaseModel
{
    protected $table = 'password_resets';

    public function createToken($email, $token)
    {
        // Delete any existing token for this email first
        $this->deleteToken($email);

        $sql = "INSERT INTO {$this->table} (email, token, created_at) VALUES (?, ?, NOW())";
        $this->setQuery($sql);
        return $this->execute([$email, $token]);
    }

    public function getToken($email, $token)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? AND token = ?";
        $this->setQuery($sql);
        return $this->loadRow([$email, $token]);
    }

    public function deleteToken($email)
    {
        $sql = "DELETE FROM {$this->table} WHERE email = ?";
        $this->setQuery($sql);
        return $this->execute([$email]);
    }
}
