<?php
require_once "app/model/Model.php";

class UserModel extends Model {

    public function getUserByEmail($email) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE email = ?');
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
