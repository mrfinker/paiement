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

    function getUserByEmailOrUsernameWithRole(string $identifier) {
        $sql = "SELECT u.*, r.role_type 
                FROM users u
                LEFT JOIN user_roles ur ON u.user_id = ur.user_id
                LEFT JOIN roles r ON ur.role_id = r.role_id
                WHERE u.email = :identifier OR u.username = :identifier
                LIMIT 1";
        return $this->db->select($sql, array("identifier" => $identifier));
    }
    
}