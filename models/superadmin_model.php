<?php

class superadmin_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllUserRoles()
{
    return $this->db->select("SELECT * FROM users_role");
}

public function deleteUserRole($id)
{
    $query = "DELETE FROM users_role WHERE id_role = :id";
    $bindings = array(':id' => $id);
    return $this->db->delete($query, $bindings);
}

public function addUserRole($name)
{
    $query = "INSERT INTO users_role (nom) VALUES (:name)";
    $bindings = array(':name' => $name);
    return $this->db->insert($query, $bindings);
}

public function updateRoleName($id, $newName)
{
    $table = "users_role";
    $data = array('nom' => $newName);
    $where = "id_role = :id";
    $bindings = array(':id' => $id);

    return $this->db->update($table, $data, $where, $bindings);
}

// Enregistrements utilisateurs

public function getUserbyEmail(string $email)
    {
        return $this->db->select("SELECT * FROM users WHERE email = :email LIMIT 1", array("email" => $email));
    }

    public function getUserbyUsername(string $username)
    {
        return $this->db->select("SELECT * FROM users WHERE username = :username LIMIT 1", array("username" => $username));
    }

    public function saveUser(array $data)
    {
        return $this->db->insert("users", $data);
    }

    public function getCompanyByCompanyId(int $companyId)
    {
        return $this->db->select("SELECT name FROM company WHERE id = :companyId LIMIT 1", array("companyId" => $companyId));
    }

    public function getCountryByCountryId(int $countryId)
    {
        return $this->db->select("SELECT name FROM country WHERE id = :countryId LIMIT 1", array("countryId" => $countryId));
    }


}
