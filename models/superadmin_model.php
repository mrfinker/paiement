<?php

class superadmin_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Roles
    public function getAllUserRoles()
    {
        return $this->db->select("SELECT * FROM users_role");
    }

    public function deleteUserRole($id)
    {
        return $this->db->delete("users_role", "id_role =$id");
    }

    public function addUserRole($data)
    {
        return $this->db->insert("users_role", $data);
    }

    public function updateRoleName($id, $newName)
    {
        return $this->db->update("users_role", array('nom' => $newName), "id_role = $id");
    }

    // utilisateurs
    public function getAllUsers()
    {
        return $this->db->select("SELECT * FROM users");
    }

    public function deleteUser($id)
    {
        return $this->db->delete("users", "id =$id");
    }

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

    // Company
    public function getAllcompany()
    {
        return $this->db->select("SELECT * FROM company");
    }

    public function deleteCompany($id)
    {
        return $this->db->delete("company", "id =$id");
    }

}
