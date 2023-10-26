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
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['users'])) {
        $user = $_SESSION['users'];
        $userId = $user['id'];
        $companyId = $user['company_id'];
    } else {
        // Si $_SESSION['users'] n'est pas défini, retourner zéro
        return 0;
    }

    try {
        $userProfile = $this->db->select(
            "SELECT 
            u.*,
            c.city,
            c.code_postale,
            c.tax_number,
            c.rccm,
            c.bank_name,
            c.bank_number
            FROM users u
            LEFT JOIN company c ON u.company_id = c.id
            WHERE u.id = :userId AND u.company_id = :companyId",
            ['userId' => $userId, 'companyId' => $companyId]
        );
    
        if (!is_array($userProfile)) {
            return [];
        }
    
        return ($userProfile && count($userProfile) > 0) ? $userProfile[0] : null;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
    
}

public function saveUser(array $data)
    {
        return $this->db->insert("users", $data);
    }


    public function updateUserProfile($id, $name, $username, $phone, $birthday) {
        $data = [
            'id' => $id,
            'name' => $name,
            'username' => $username,
            'phone' => $phone,
            'birthday' => $birthday,
        ];
        $where = "id = $id";
        return $this->db->update('users', $data, $where);
    }

    public function getAllCurrencies()
{
    $sql = "SELECT * FROM currencies";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateCompanyAndPersonnel($companyId, $userId, $name, $username, $email, $phone, $address, $ville, $city)
{
    // Mettre à jour la table "users"
    $userData = [
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'ville' => $ville,
    ];

    $this->db->update("users", $userData, "id = $userId");

    // Mettre à jour la table "company"
    $companyData = [
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'city' => $city,
        'province' => $ville,
    ];

    if (!empty($companyId)) {
        $this->db->update("company", $companyData, "id = $companyId");
    }
}

public function updateCompanyAndImage($companyId, $userId, $imageFileName = null)
{
    $userData = array();
    if ($imageFileName !== null) {
        $userData['image'] = $imageFileName;
    }

    $this->db->update("users", $userData, "id = $userId");

    if (!empty($companyId)) {
        $this->db->update("company", $userData, "id = $companyId");
    }
}

public function updateCompanyAndCompagny($companyId, $userId, $bank_name, $bank_number, $code_postale, $tax_number, $rccm)
{
    // Mettre à jour la table "users"
    $userData = [
        'bank_name' => $bank_name,
        'bank_number' => $bank_number,
    ];

    $this->db->update("users", $userData, "id = $userId");

    // Mettre à jour la table "company"
    $companyData = [
        'code_postale' => $code_postale,
        'tax_number' => $tax_number,
        'rccm' => $rccm,
        'bank_name' => $bank_name,
        'bank_number' => $bank_number,
    ];

    if (!empty($companyId)) {
        $this->db->update("company", $companyData, "id = $companyId");
    }
}


public function updateCompanyAndPassword($userId, $password)
{
    // Mettre à jour la table "users"
    $userData = [
        'password' => $password,
    ];

    $this->db->update("users", $userData, "id = $userId");
}



    

}