<?php

class Register_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function threeLast(string $email)
    {
        return $this->db->select("SELECT * FROM users ORDER BY id DESC LIMIT 3 WHERE email = :email LIMIT 1", array("email" => $email));
    }

}
