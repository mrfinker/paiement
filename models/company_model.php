<?php

class company_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Roles
    public function getAllUserRoles()
{
    // Démarrer une session si elle n'est pas déjà démarrée
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            // Si $_SESSION['users'] n'est pas défini, retourner un tableau vide
            return [];
        }

        $userRoles = $this->db->select(
            'SELECT ur.*, u.name as creator_name
             FROM users_role ur
             LEFT JOIN users u ON ur.added_by = u.id
             WHERE ur.added_by = :userId OR ur.company_id = :companyId',
            ['userId' => $userId, 'companyId' => $companyId]
        );

        // Vérifiez si $userRoles est un tableau avant de continuer
        if (!is_array($userRoles)) {
            return [];
        }

        // Ajoutez un compteur si nécessaire
        $count = 1;
        foreach ($userRoles as &$userRole) {
            $userRole['num'] = $count;
            $count++;
        }

        // Retournez les rôles d'utilisateur récupérés
        return $userRoles;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
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

    public function getAllUsersByCreatorAndCompany()
    {
        // Démarrer une session si elle n'est pas déjà démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $userId = $user['id'];
                $companyId = $user['company_id'];
            } else {
                // Si $_SESSION['users'] n'est pas défini, retourner un tableau vide
                return [];
            }

            $userscompany = $this->db->select(
                // Modification de la requête SQL pour inclure le nom du pays via une jointure avec la table country
                'SELECT u.*, c.name as country, ur.name as role_name
             FROM users u
             LEFT JOIN country c ON u.country_id = c.id
             LEFT JOIN users_role ur ON u.user_role_id = ur.id_role AND ur.company_id = :companyId
             WHERE (u.id = :userId OR u.company_id = :companyId) AND u.id != :userId',
                ['userId' => $userId, 'companyId' => $companyId]
            );

            // Vérifiez si $userscompany est un tableau avant de continuer
            if (!is_array($userscompany)) {
                return [];
            }

            // Ajoutez un compteur si nécessaire
            $count = 1;
            foreach ($userscompany as &$userc) {
                $userc['num'] = $count;
                $count++;
            }

            // Retournez les utilisateurs récupérés
            return $userscompany;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function addDepartment($data) {
        return $this->db->insert("departments", $data);
    }

    public function getAllDepartmentsByCreatorAndCompany()
{
    // Démarrer une session si elle n'est pas déjà démarrée
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            // Si $_SESSION['users'] n'est pas défini, retourner un tableau vide
            return [];
        }

        $departments = $this->db->select(
            'SELECT d.*, u.name as creator_name
             FROM departments d
             LEFT JOIN users u ON d.added_by = u.id
             WHERE d.added_by = :userId OR d.company_id = :companyId',
            ['userId' => $userId, 'companyId' => $companyId]
        );

        // Vérifiez si $departments est un tableau avant de continuer
        if (!is_array($departments)) {
            return [];
        }

        // Ajoutez un compteur si nécessaire
        $count = 1;
        foreach ($departments as &$department) {
            $department['num'] = $count;
            $count++;
        }

        // Retournez les départements récupérés
        return $departments;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

public function departmentExists($departmentName, $companyId) {
    try {
        $result = $this->db->select(
            'SELECT * FROM departments WHERE department_name = :departmentName AND company_id = :companyId',
            ['departmentName' => $departmentName, 'companyId' => $companyId]
        );

        error_log('departmentExists Result: ' . json_encode($result));
        
        return !empty($result); // Cela renvoie true si le tableau n'est pas vide
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}


public function deleteDepartement($id) {
    
    return $this->db->delete('departments', "department_id = $id");
     
}

public function updateDepartment($id, $departmentNameUpdate)
{
    $data = array(
        'department_name' => $departmentNameUpdate
    );
    
    return $this->db->update("departments", $data, "department_id = $id");
}



    

}
