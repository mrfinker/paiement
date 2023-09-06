<?php

class Register_model extends Model{

    function __construct() {
        parent:: __construct();
    }

    function getUserbyEmail(string $email){
        return $this->db->select("SELECT * FROM users WHERE email = :email LIMIT 1", array("email" => $email));
    }
    
    function getUserbyUsername(string $username){
        return $this->db->select("SELECT * FROM users WHERE username = :username LIMIT 1", array("userame" => $userame));
    }

    function saveUser(array $data) {
        return $this->db->insert("users", $data);
    }
}