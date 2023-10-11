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

    

    
    // Departements
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

// Designations
public function getAllDesignationsByCreatorAndCompany()
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

        $designations = $this->db->select(
            'SELECT d.*, u.name as creator_name, de.department_name 
             FROM designations d
             LEFT JOIN users u ON d.added_by = u.id
             LEFT JOIN departments de ON d.department_id = de.department_id
             WHERE d.added_by = :userId OR d.company_id = :companyId',
            ['userId' => $userId, 'companyId' => $companyId]
        );

        // Vérifiez si $designations est un tableau avant de continuer
        if (!is_array($designations)) {
            return [];
        }
        
        // Ajoutez un compteur si nécessaire
        $count = 1;
        foreach ($designations as &$designation) {
            $designation['num'] = $count;
            $count++;
        }

        // Retournez les désignations récupérées
        return $designations;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

public function getDesignationNameById($designationId) {
    try {
        $designation = $this->db->select(
            'SELECT designation_name FROM designations WHERE designation_id = :designationId',
            ['designationId' => $designationId]
        );
        return $designation['designation_name'] ?? ''; // retourner le nom ou une chaîne vide si rien n'est trouvé
    } catch (Exception $e) {
        error_log($e->getMessage());
        return '';
    }
}

public function getDesignationsByDepartmentId($departmentId)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $companyId = $user['company_id'];
        } else {
            return [];
        }

        $designations = $this->db->select(
            'SELECT d.*, u.name as creator_name, de.department_name 
             FROM designations d
             LEFT JOIN users u ON d.added_by = u.id
             LEFT JOIN departments de ON d.department_id = de.department_id
             WHERE (d.company_id = :companyId) AND (d.department_id = :departmentId)',
            ['companyId' => $companyId, 'departmentId' => $departmentId]
        );

        return is_array($designations) ? $designations : [];

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

public function designationExists($designationName, $departmentId, $companyId) {
    try {
        $result = $this->db->select(
            'SELECT * FROM designations WHERE designation_name = :designationName AND department_id = :departmentId AND company_id = :companyId',
            ['designationName' => $designationName, 'departmentId' => $departmentId, 'companyId' => $companyId]
        );

        error_log('designationExists Result: ' . json_encode($result));
        
        return !empty($result); // Cela renvoie true si le tableau n'est pas vide
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

public function addDesignation($data) {
    return $this->db->insert("designations", $data);
}

public function deleteDesignation($id) {
    
    return $this->db->delete('designations', "designation_id = $id");
     
}

public function updateDesignation($id, $designationNameUpdate, $departmentId) {
    $data = [
        'designation_name' => $designationNameUpdate,
        'department_id' => $departmentId // Ajoutez cette ligne pour mettre à jour le department_id
    ];
    
    return $this->db->update("designations", $data, "designation_id = $id");
}

// Depot et depenses
public function addDepExp($data) {
    return $this->db->insert("constants_dep_exp", $data);
}

public function getAllDepensesByCreatorAndCompany()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            return [];
        }

        $depenses = $this->db->select(
            'SELECT d.*, u.name as creator_name
             FROM constants_dep_exp d
             LEFT JOIN users u ON d.added_by = u.id
             WHERE (d.added_by = :userId OR d.company_id = :companyId) AND d.type = "depense"',
            ['userId' => $userId, 'companyId' => $companyId]
        );

        if (!is_array($depenses)) {
            return [];
        }

        $count = 1;
        foreach ($depenses as &$depense) {
            $depense['num'] = $count;
            $count++;
        }

        return $depenses;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

public function getAllDepotsByCreatorAndCompany()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            return [];
        }

        $depots = $this->db->select(
            'SELECT d.*, u.name as creator_name
             FROM constants_dep_exp d
             LEFT JOIN users u ON d.added_by = u.id
             WHERE (d.added_by = :userId OR d.company_id = :companyId) AND d.type = "depot"',
            ['userId' => $userId, 'companyId' => $companyId]
        );

        if (!is_array($depots)) {
            return [];
        }

        $count = 1;
        foreach ($depots as &$depot) {
            $depot['num'] = $count;
            $count++;
        }

        return $depots;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

// depenses
public function addDepenses($data) {
    return $this->db->insert("finance_transactions", $data);
}

public function getAllTransactionsDepensesByCreatorAndCompany()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            return [];
        }

        $transactions = $this->db->select(
            'SELECT t.*, fa.account_name, u.name as staff_name, cde.category_name 
             FROM finance_transactions t
             LEFT JOIN finance_accounts fa ON t.account_id = fa.account_id
             LEFT JOIN users u ON t.staff_id = u.id
             LEFT JOIN constants_dep_exp cde ON t.entity_category_id = cde.constants_id
             WHERE (t.added_by = :userId OR t.company_id = :companyId) AND t.transaction_type = "depense"',
            ['userId' => $userId, 'companyId' => $companyId]
        );        

        if (!is_array($transactions)) {
            return [];
        }

        $count = 1;
        foreach ($transactions as &$transaction) {
            $transaction['num'] = $count;
            $count++;
        }

        return $transactions;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}



public function getAllCountry(){
    return  $this->db->select('SELECT * FROM country');
}

// Horaire
public function getAllOfficeShiftsByCreatorAndCompany()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            return [];
        }

        $officeShifts = $this->db->select(
            'SELECT os.*, u.name as creator_name
             FROM office_shifts os
             LEFT JOIN users u ON os.added_by = u.id
             WHERE os.added_by = :userId OR os.company_id = :companyId',
            ['userId' => $userId, 'companyId' => $companyId]
        );

        if (!is_array($officeShifts)) {
            return [];
        }

        $count = 1;
        foreach ($officeShifts as &$officeShift) {
            $officeShift['num'] = $count;
            $count++;
        }

        return $officeShifts;
        
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

public function addHoraire($data) {
    return $this->db->insert("office_shifts", $data);
}

public function deleteHoraire($id) {
    
    return $this->db->delete('office_shifts', "office_shift_id = $id");
     
}

public function updateHoraire($id, $data) {
    return $this->db->update("office_shifts", $data, "office_shift_id = $id");
}

// users

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
                'SELECT 
                u.*, 
                c.name as country, 
                ur.name as role_name, 
                d.designation_name as designation, 
                p.is_payment as payed, 
                p.payslip_value as payslip_value, 
                p.year_to_date as year_to_date, 
                p.created_at as created_at, 
                p.payslip_code as payslip_code, 
                p.salary_month as salary_month, 
                p.net_salary as net_salary, 
                os.total_time as total_time
                FROM users u
                LEFT JOIN country c ON u.country_id = c.id
                LEFT JOIN users_role ur ON u.user_role_id = ur.id_role
                LEFT JOIN designations d ON u.designation_id = d.designation_id
                LEFT JOIN payslips p ON u.id = p.staff_id AND u.company_id = p.company_id
                LEFT JOIN office_shifts os ON u.company_id = os.company_id AND u.office_shift_id = os.office_shift_id
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

    public function updateUser(
        $id, 
        $nameupdate, 
        $usernameupdate, 
        $emailupdate, 
        $phoneupdate, 
        $updatestatus_marital,
        $updateemployeid,
        $updategender,
        $updateuser_role,
        $updatedepartment_id,
        $updatedesignation_id,
        $updateworking_time,
        $updatesalaire_base,
        $updatepaiement_type,
        $updatecontract_type,  
        $imageFileName = null)
    {
        $data = array(
            'name' => $nameupdate,
            'username' => $usernameupdate,
            'email' => $emailupdate,
            'phone' => $phoneupdate,
            'marital_status' => $updatestatus_marital,
            'gender' => $updategender,
            'emplyee_id' => $updateemployeid,
            'user_role_id' => $updateuser_role,
            'departement_id' => $updatedepartment_id,
            'designation_id' => $updatedesignation_id,
            'office_shift_id' => $updateworking_time,
            'basic_salary' => $updatesalaire_base,
            'salary_type' => $updatepaiement_type,
            'contract_type' => $updatecontract_type,
        );
    
        if ($imageFileName !== null) {
            $data['image'] = $imageFileName;
        }
    
        return $this->db->update("users", $data, "id = $id");
    }

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
    
    // Payements
    public function insertPayement(array $data)
    {
        return $this->db->insert("payslips", $data);
    }
    
    public function updateStatus($id, $status) {
        $data = ['is_active' => $status];
        return $this->db->update("users", $data, "id = $id");
    }
    
    
    // Comptes
    public function addComptes($data) {
        return $this->db->insert("finance_accounts", $data);
    }

public function getAllAccountsByCreatorAndCompany()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            return [];
        }

        $accounts = $this->db->select(
            'SELECT a.*, u.name as creator_name
             FROM finance_accounts a
             LEFT JOIN users u ON a.added_by = u.id
             WHERE a.added_by = :userId OR a.company_id = :companyId',
            ['userId' => $userId, 'companyId' => $companyId]
        );

        if (!is_array($accounts)) {
            return [];
        }

        $count = 1;
        foreach ($accounts as &$account) {
            $account['num'] = $count;
            $count++;
        }

        return $accounts;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

public function deleteComptes($id) {
    
    return $this->db->delete('finance_accounts', "account_id = $id");
     
}

public function updateComptes($id, $compteNameUpdate, $compteNumberUpdate, $compteBalanceUpdate, $compteBankNameUpdate)
{
    $data = array(
        'account_name' => $compteNameUpdate,
        'account_number' => $compteNumberUpdate,
        'account_balance' => $compteBalanceUpdate,
        'bank_name' => $compteBankNameUpdate
    );
    
    return $this->db->update("finance_accounts", $data, "account_id = $id");
}

}
