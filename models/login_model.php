<?php

class Login_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserbyEmail(string $email)
    {
        return $this->db->select("SELECT * FROM users WHERE email = :email LIMIT 1", array("email" => $email));
    }

    public function getUserbyUsername(string $username)
    {
        return $this->db->select("SELECT * FROM users WHERE username = :username LIMIT 1", array("username" => $username));
    }

    public function getUserByEmailOrUsernameWithRole(string $identifier)
    {
        return $this->db->select("SELECT u.user_type_id, ut.name
        FROM users u
        INNER JOIN user_type ut ON u.user_type_id = ut.id_type
        WHERE u.email = :identifier OR u.username = :identifier
        LIMIT 1", array("identifier" => $identifier));

    }

}
