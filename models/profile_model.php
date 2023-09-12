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

    public function getUserProfile()
{
    $userId = $_SESSION['users']['id'];

    $query = "SELECT * FROM users WHERE id = :userId";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        return $profile;
    } else {
        return null;
    }
}

public function saveUser(array $data)
    {
        return $this->db->insert("users", $data);
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