<?php

class Login_model extends Model{

    function __construct() {
        parent:: __construct();
    }

    function getUserbyEmail(string $email){
        return $this->db->select("SELECT * FROM users WHERE email = :email LIMIT 1", array("email" => $email));
    }
    
    function getUserbyUsername(string $username){
        return $this->db->select("SELECT * FROM users WHERE username = :username LIMIT 1", array("username" => $username));
    }

    function saveUser(array $data) {
        return $this->db->insert("users", $data);
    }

    function getUserByEmailOrUsernameWithRole(string $identifier)
{
    // Utilisez une requête préparée pour éviter les injections SQL.
    $query = "SELECT u.*, ut.user_type AS role_type 
              FROM users u
              LEFT JOIN user_types ut ON u.user_type_id = ut.id_type
              WHERE u.email = :identifier OR u.username = :identifier
              LIMIT 1";
    
    // Utilisez une requête préparée pour sécuriser la requête SQL.
    $params = array(':identifier' => $identifier);
    
    // Utilisez la méthode de requête préparée de votre base de données pour exécuter la requête.
    $result = $this->db->select($query, $params);
    
    // Retournez le résultat de la requête.
    return $result;
}

    
}