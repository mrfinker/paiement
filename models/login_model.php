<?php

class Login_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function NumRole($role)
    {
        $userPermissions = $this->db->select(
            'SELECT permissions
             FROM users_role
             WHERE id_role = :roleId',
            ['roleId' => $role]
        );
        return $userPermissions;
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

    public function updateUserLoggedInStatus(string $email, int $status)
    {
        return $this->db->update("users", array("is_logged_in" => $status, "email" => $email), "email = :email");
    }

    public function updateUserLastLogin(string $email, string $ip_address)
    {
        $dateTimeNow = date('Y-m-d H:i:s');
        return $this->db->update(
            "users",
            array("last_login" => $dateTimeNow, "last_login_ip" => $ip_address, "email" => $email),
            "email = :email"
        );
    }

    public function isUserLastLoginEmpty(string $email)
    {
        // Préparez une requête pour sélectionner la colonne last_login
        $query = $this->db->prepare("SELECT last_login FROM users WHERE email = :email");
        $query->execute(array(':email' => $email));

        // Récupérez le résultat
        $result = $query->fetch();

        // Vérifiez si last_login est null ou vide
        return empty($result['last_login']);
    }

    public function updateUserLastLogout(string $email)
    {
        $dateTimeNow = date('Y-m-d H:i:s');
        return $this->db->update(
            "users",
            array("last_logout" => $dateTimeNow, "email" => $email),
            "email = :email"
        );
    }
}
