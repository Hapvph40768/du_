<?php
namespace App\Models;

class GuidesModel extends BaseModel
{
    protected $table = "guides";
    public function getAllGuides()
    {
        $sql = "SELECT g.*, u.username, u.fullname as user_fullname
                FROM guides g
                LEFT JOIN users u ON g.user_id = u.id
                ORDER BY g.created_at DESC";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function getGuidesId($id)
    {
        $sql = "
        SELECT g.*, u.name AS username
        FROM $this->table g
        JOIN users u ON g.user_id = u.id
        WHERE g.id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }
    public function addGuides($data){
        $sql = "INSERT INTO $this->table (user_id, dob, avatar, certificates, languages,experience_years,
        tour_history,skill_rating,health_status,created_at,updated_at) VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?)"; 
        $this->setQuery($sql);
        return $this->execute([
            $data['user_id'],
            $data['dob'],
            $data['avatar'],
            $data['certificates'],
            $data['languages'],
            $data['experience_years'],
            $data['tour_history'],
            $data['skill_rating'],
            $data['health_status'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }
    public function updateGuides($id, $data){
        $sql = "UPDATE $this->table SET user_id = ?, dob = ?, avatar = ?, certificates = ?, languages = ?
        , experience_years = ? ,tour_history = ?, skill_rating = ?, health_status = ?, created_at = ?, updated_at = ?
         WHERE id = ?"; 
        $this->setQuery($sql);
        return $this->execute([
           $data['user_id'],
            $data['dob'],
            $data['avatar'],
            $data['certificates'],
            $data['languages'],
            $data['experience_years'],
            $data['tour_history'],
            $data['skill_rating'],
            $data['health_status'],
            $data['created_at'],
            $data['updated_at'],
            $id
        ]);
    }
    public function deleteGuides($id){
        $sql = "DELETE FROM $this->table WHERE id = ?"; 
        $this->setQuery($sql);
        return $this->execute([$id]);
    }


}