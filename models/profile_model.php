<?php

class Profile_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCompanyByCompanyId(int $companyId)
    {
        return $this->db->select("SELECT name FROM company WHERE id = :companyId LIMIT 1", array("companyId" => $companyId));
    }

    public function getCountryByCountryId(int $countryId)
    {
        return $this->db->select("SELECT name FROM country WHERE id = :countryId LIMIT 1", array("countryId" => $countryId));
    }

    public function updateUserProfile(int $id, string $name, string $username, string $phone, string $birthday)
{
    $query = "UPDATE users SET name = :name, username = :username, phone = :phone, birthday = :birthday WHERE id = :id";
    $values = array(
        "id" => $id,
        "name" => $name,
        "username" => $username,
        "phone" => $phone,
        "birthday" => $birthday
    );

    $options = array();

    return $this->db->insert($query, $values, $options);
}



    

}