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
        $userRoles = $this->db->select("SELECT * FROM users_role");
    
    if ($userRoles) {
        $count = 1;

        foreach ($userRoles as &$userRole) {
            $userRole['num'] = $count;
            $count++;
        }
    }

    return $userRoles;
    }

    public function deleteUserRole($id)
    {
        return $this->db->delete("users_role", "id_role =$id");
    }

    public function addUserRole($data)
    {
        return $this->db->insert("users_role", $data);
    }

    public function updateRoleName($id, $newName, $permissions)
    {
        return $this->db->update("users_role", array('name' => $newName, 'permissions' => $permissions), "id_role = $id");
    }




    // utilisateurs
    public function getAllUsers()
    {
        $Alluser = $this->db->select("SELECT * FROM users");

        if($Alluser){
            $count = 1;
            foreach($Alluser as &$user){
                $user['num'] = $count;
                $count++;
            }
        }
        return $Alluser;
    }

    public function updateUser($id, $nameupdate, $usernameupdate, $emailupdate, $phoneupdate, $addressupdate, $birthdayupdate, $imageFileName = null)
    {
        $data = array(
            'name' => $nameupdate,
            'username' => $usernameupdate,
            'email' => $emailupdate,
            'phone' => $phoneupdate,
            'address' => $addressupdate,
            'birthday' => $birthdayupdate
        );
    
        if ($imageFileName !== null) {
            $data['image'] = $imageFileName;
        }
    
        return $this->db->update("users", $data, "id = $id");
    }

    public function UserActiveStatus($id) {
        $currentUser = $this->db->select("SELECT * FROM users WHERE id = :id LIMIT 1", array("id" => $id));
        if(!$currentUser) return false; // ou vous pouvez également retourner un message d'erreur détaillé
        
        $newStatus = $currentUser[0]['is_active'] == 1 ? 0 : 1;
        
        return $this->db->update("users", array('is_active' => $newStatus), "id = $id");
    }
    
    // public function updateUserActiveStatus($id, $newIsActive) {
    //     return $this->db->update("users", array('is_active' => $newIsActive), "id = $id");
    // }

    public function getUserById($id) {
        return $this->db->select("SELECT * FROM users WHERE id = :id LIMIT 1", array("id" => $id));
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

    public function insertUser(array $data)
    {
        return $this->db->insert("users", $data);
    }


    // Company
    public function getAllcompany()
    {
        return $this->db->select("SELECT * FROM company");
    }

    public function insertCompany($data) {
        // Insérer dans la table company
        $company_id = $this->db->insert("company", $data);
    
        // Vérifiez si l'insertion a réussi
        if ($company_id) {
            // Préparez les données pour la table 'users'
            $user_data = [
                "company_id" => $company_id,
                "name" => $data["name"],
                "username" => $data["username"],
                "email" => $data["email"],
                "country_id" => $data["country_id"],
                "phone" => $data["phone"],
                "address" => $data["address"],
                "password" => $data["password"],
                "user_type_id" => 3 // Remplacez par le type d'utilisateur approprié
                // ajoutez d'autres champs nécessaires
            ];
    
            // Insérer dans la table users
            $user_result = $this->db->insert("users", $user_data);
    
            return $user_result ? true : false;
        } else {
            return false;
        }
    }
    
    public function deleteCompany($id)
    {
        return $this->db->delete("company", "id =$id");
    }

    public function getCompanyByCompanyId(int $companyId)
    {
        return $this->db->select("SELECT name FROM company WHERE id = :companyId LIMIT 1", array("companyId" => $companyId));
    }

    public function getCountryByCountryId(int $countryId)
    {
        return $this->db->select("SELECT name FROM country WHERE id = :countryId LIMIT 1", array("countryId" => $countryId));
    }

    public function updateCompany($id, $nameupdate, $emailupdate, $phoneupdate, $addressupdate, $usernameupdate, $cityupdate, $provinceupdate, $code_postaleupdate, $tax_numberupdate, $rccmupdate, $bank_nameupdate, $bank_numberupdate) {
        try {
            $this->db->beginTransaction();
    
            // Mise à jour de la table company
            $updateCompany = $this->db->update(
                "company", 
                array(
                    'name' => $nameupdate, 
                    'email' => $emailupdate, 
                    'phone' => $phoneupdate, 
                    'address' => $addressupdate,
                    'city' => $cityupdate,
                    'province' => $provinceupdate,
                    'code_postale' => $code_postaleupdate,
                    'tax_number' => $tax_numberupdate,
                    'rccm' => $rccmupdate,
                    'bank_name' => $bank_nameupdate,
                    'bank_number' => $bank_numberupdate,
                    'username' => $usernameupdate
                ), 
                "id = $id"
            );
            
            if (!$updateCompany) {
                throw new Exception('La mise à jour de la table company a échoué');
            }
    
            // Mise à jour de la table users
            $updateUsers = $this->db->update(
                "users", 
                array(
                    'name' => $nameupdate, 
                    'email' => $emailupdate, 
                    'phone' => $phoneupdate, 
                    'address' => $addressupdate,
                    'username' => $usernameupdate
                ), 
                "company_id = $id AND username = '$usernameupdate'"
            );
            
            if (!$updateUsers) {
                throw new Exception('La mise à jour de la table users a échoué');
            }
    
            $this->db->commit();
    
            return true; // Les deux mises à jour ont réussi
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false; // Une ou les deux mises à jour ont échoué
        }
    }
    
    

    // Admin

    // Country
    public function getAllCountry()
    {
        $Allcountry = $this->db->select("SELECT * FROM country");

        if($Allcountry){
            $count = 1;
            foreach($Allcountry as &$country){
                $country['num'] = $count;
                $count++;
            }
        }
        return $Allcountry;
    }

    // Category
    public function getAllCategory()
    {
        $allcategory = $this->db->select("SELECT * FROM category");

        if($allcategory){
            $count = 1;
            foreach($allcategory as &$category){
                $category['num'] = $count;
                $count++;
            }
        }
        return $allcategory;
    }

    public function updateStatus($id, $status) {
        $data = ['is_active' => $status];
        return $this->db->update("users", $data, "id = $id");
    }

    // Company
    public function getAllplan()
    {
        $allplan = $this->db->select("SELECT * FROM membership_plan");

        if($allplan){
            $count = 1;
            foreach($allplan as &$allplans){
                $allplans['num'] = $count;
                $count++;
            }
        }
        return $allplan;
    }

    // Plan
    public function addPlan($data) {
        return $this->db->insert("membership_plan", $data);
    }

    public function deletePlan($id) {
    
        return $this->db->delete('membership_plan', "membership_plan_id = $id");
         
    }

    public function updatePlan($id, $data) {
        return $this->db->update("membership_plan", $data, "membership_plan_id = $id");
    }

}
