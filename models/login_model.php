<?php

class Login_model extends Model{

    function __construct() {
        parent:: __construct();
    }

    function getUserbyEmail(string $email){
        return $this->db->select("SELECT * FROM users WHERE email = :email LIMIT 1", array("email" => $email));
    }

    function saveUser(array $data) {
        return $this->db->insert("users", $data);
    }
}