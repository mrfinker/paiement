<?php

class staff_model extends Model
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

    public function roleExists($name, $companyId)
    {
        try {
            $result = $this->db->select(
                'SELECT * FROM users_role WHERE name = :name AND company_id = :companyId',
                ['name' => $name, 'companyId' => $companyId]
            );

            error_log('nameExists Result: ' . json_encode($result));

            return !empty($result); // Cela renvoie true si le tableau n'est pas vide
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }


    // Departements
    public function addDepartment($data)
    {
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

    public function departmentExists($departmentName, $companyId)
    {
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


    public function deleteDepartement($id)
    {

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
                'SELECT d.*, u.name as creator_name, de.department_name, de.department_id
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

    public function getDesignationNameById($designationId)
    {
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

    public function designationExists($designationName, $departmentId, $companyId)
    {
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

    public function addDesignation($data)
    {
        return $this->db->insert("designations", $data);
    }

    public function deleteDesignation($id)
    {

        return $this->db->delete('designations', "designation_id = $id");
    }

    public function updateDesignation($id, $designationNameUpdate, $departmentId)
    {
        $data = [
            'designation_name' => $designationNameUpdate,
            'department_id' => $departmentId // Ajoutez cette ligne pour mettre à jour le department_id
        ];

        return $this->db->update("designations", $data, "designation_id = $id");
    }

    // Depot et depenses
    public function addDepExp($data)
    {
        return $this->db->insert("constants_dep_exp", $data);
    }

    public function deleteCategoryDepExp($id)
    {

        return $this->db->delete('constants_dep_exp', "constants_id = $id");
    }

    public function updateDepExp($id, $depexpNameUpdate, $constantsId)
    {
        $data = [
            'category_name' => $depexpNameUpdate,
            'constants_id' => $constantsId // Ajoutez cette ligne pour mettre à jour le department_id
        ];

        return $this->db->update("constants_dep_exp", $data, "constants_id = $id");
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
    public function addDepenses($data)
    {
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
                'SELECT t.*, fa.account_name, u.name as staff_name, cde.category_name, fa.account_number 
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

    public function deleteTransactionDepExp($id)
    {

        return $this->db->delete('finance_transactions', "transactions_id = $id");
    }

    // depots
    public function addDepots($data)
    {
        return $this->db->insert("finance_transactions", $data);
    }

    public function getAllTransactionsDepotsByCreatorAndCompany()
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
                'SELECT t.*, fa.account_name, u.name as staff_name, cde.category_name, fa.account_number  
             FROM finance_transactions t
             LEFT JOIN finance_accounts fa ON t.account_id = fa.account_id
             LEFT JOIN users u ON t.staff_id = u.id
             LEFT JOIN constants_dep_exp cde ON t.entity_category_id = cde.constants_id
             WHERE (t.added_by = :userId OR t.company_id = :companyId) AND t.transaction_type = "depot"',
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

    public function getAllTransactionsByCreatorAndCompany()
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
                'SELECT t.*, fa.account_name, u.name as staff_name, cde.category_name, fa.account_number
             FROM finance_transactions t
             LEFT JOIN finance_accounts fa ON t.account_id = fa.account_id
             LEFT JOIN users u ON t.staff_id = u.id
             LEFT JOIN constants_dep_exp cde ON t.entity_category_id = cde.constants_id
             WHERE (t.added_by = :userId AND t.company_id = :companyId)',
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

    public function updateTransaction($id, $transaction_date, $amount)
    {
        $data = [
            'transaction_date' => $transaction_date,
            'amount' => $amount // Ajoutez cette ligne pour mettre à jour le department_id
        ];

        return $this->db->update("finance_transactions", $data, "transactions_id = $id");
    }


    public function getAllCountry()
    {
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
             WHERE (os.added_by = :userId OR os.company_id = :companyId OR os.office_shift_id IN (20, 21, 22, 23))',
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

    public function getOfficeShiftIdByStaffId($staffId)
    {
        try {
            $officeShifts = $this->db->select(
                'SELECT office_shift_id FROM users WHERE id = :staffId',
                ['staffId' => $staffId]
            );

            // Si la requête retourne un tableau vide, renvoyez null
            if (empty($officeShifts)) {
                return null;
            }

            // Si la requête retourne un tableau d'enregistrements, accédez au premier élément
            $officeShift = $officeShifts[0];

            return isset($officeShift['office_shift_id']) ? $officeShift['office_shift_id'] : null;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    public function getOfficeShiftDetailsById($officeShiftId)
    {
        try {
            $officeShiftDetails = $this->db->select(
                'SELECT * FROM office_shifts WHERE office_shift_id = :officeShiftId',
                ['officeShiftId' => $officeShiftId]
            );

            return $officeShiftDetails ? $officeShiftDetails : null;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    public function getAllOfficeShiftsByCreatorAndCompanyListe()
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
             WHERE (os.added_by = :userId OR os.company_id = :companyId)
               AND os.office_shift_id NOT IN (20, 21, 22, 23)',
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

    public function addHoraire($data)
    {
        return $this->db->insert("office_shifts", $data);
    }

    public function deleteHoraire($id)
    {

        return $this->db->delete('office_shifts', "office_shift_id = $id");
    }

    public function updateHoraire($id, $data)
    {
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
                "SELECT 
                u.*, 
                MAX(c.name) as country, 
                MAX(ur.name) as role_name,
                MAX(d.designation_name) as designation, 
                MAX(dep.department_name) as department, 
                MAX(avc.advance_amount) as advanced_salary, 
                MAX(p.is_payment) as payed, 
                MAX(p.payslip_value) as payslip_value, 
                MAX(p.year_to_date) as year_to_date, 
                MAX(p.created_at) as created_at, 
                MAX(p.payslip_code) as payslip_code, 
                MAX(p.salary_month) as salary_month, 
                MAX(p.net_salary) as net_salary, 
                MAX(p.housing) as housing, 
                MAX(p.transport) as transport, 
                MAX(p.net_after_taxes) as net_after_taxes, 
                MAX(os.total_time) as total_time,
                MAX(ts.timesheet_status) as timesheet_count
                FROM users u
                LEFT JOIN country c ON u.country_id = c.id
                LEFT JOIN users_role ur ON u.user_role_id = ur.id_role
                LEFT JOIN designations d ON u.designation_id = d.designation_id
                LEFT JOIN departments dep ON u.departement_id = dep.department_id
                LEFT JOIN advanced_salary avc ON u.id = avc.staff_id  AND avc.month_year = DATE_FORMAT(NOW(), '%Y-%m')
                LEFT JOIN payslips p ON u.id = p.staff_id AND u.company_id = p.company_id
                LEFT JOIN office_shifts os ON u.company_id = os.company_id AND u.office_shift_id = os.office_shift_id
                LEFT JOIN (
                    SELECT staff_id, COUNT(*) as timesheet_status
                    FROM timesheet
                    WHERE DATE_FORMAT(timesheet_date, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
                    GROUP BY staff_id
                ) ts ON u.id = ts.staff_id
                WHERE (u.id = :userId OR u.company_id = :companyId) AND u.emplyee_id IS NOT NULL
                GROUP BY u.id", // Assurez-vous de grouper par la clé primaire de la table utilisateur pour éviter les doublons
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

    public function getAllUsersIdByCreatorAndCompany($userIds = null)
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

            $userIdsCondition = '';
            if (!empty($userIds)) {
                // Convertir les IDs en chaîne pour la requête SQL
                $idsFormatted = implode(',', array_map('intval', $userIds));
                $userIdsCondition = " AND u.id IN ($idsFormatted)";
            }

            $userscompany = $this->db->select(
                "SELECT 
                u.*, 
                MAX(c.name) as country, 
                MAX(ur.name) as role_name,
                MAX(d.designation_name) as designation, 
                MAX(dep.department_name) as department, 
                MAX(avc.advance_amount) as advanced_salary, 
                MAX(p.is_payment) as payed, 
                MAX(p.payslip_value) as payslip_value, 
                MAX(p.year_to_date) as year_to_date, 
                MAX(p.created_at) as created_at, 
                MAX(p.payslip_code) as payslip_code, 
                MAX(p.salary_month) as salary_month, 
                MAX(p.net_salary) as net_salary, 
                MAX(p.housing) as housing, 
                MAX(p.transport) as transport, 
                MAX(p.net_after_taxes) as net_after_taxes, 
                MAX(os.total_time) as total_time,
                MAX(ts.timesheet_status) as timesheet_count
                FROM users u
                LEFT JOIN country c ON u.country_id = c.id
                LEFT JOIN users_role ur ON u.user_role_id = ur.id_role
                LEFT JOIN designations d ON u.designation_id = d.designation_id
                LEFT JOIN departments dep ON u.departement_id = dep.department_id
                LEFT JOIN advanced_salary avc ON u.id = avc.staff_id  AND avc.month_year = DATE_FORMAT(NOW(), '%Y-%m')
                LEFT JOIN payslips p ON u.id = p.staff_id AND u.company_id = p.company_id
                LEFT JOIN office_shifts os ON u.company_id = os.company_id AND u.office_shift_id = os.office_shift_id
                LEFT JOIN (
                    SELECT staff_id, COUNT(*) as timesheet_status
                    FROM timesheet
                    WHERE DATE_FORMAT(timesheet_date, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
                    GROUP BY staff_id
                ) ts ON u.id = ts.staff_id
                WHERE (u.id = :userId OR u.company_id = :companyId) $userIdsCondition AND u.emplyee_id IS NOT NULL
        GROUP BY u.id",
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



    public function getAllUsersByCreatorAndCompanyFiltered($year, $month)
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

            $formattedMonthYear = sprintf('%04d-%02d', $year, $month);

            $userscompany = $this->db->select(
                "SELECT 
                u.*, 
                MAX(c.name) as country, 
                MAX(ur.name) as role_name,
                MAX(d.designation_name) as designation, 
                MAX(dep.department_name) as department, 
                MAX(avc.advance_amount) as advanced_salary, 
                MAX(p.is_payment) as payed, 
                MAX(p.payslip_value) as payslip_value, 
                MAX(p.payslip_code) as payslip_code, 
                MAX(p.year_to_date) as year_to_date, 
                MAX(p.created_at) as created_at, 
                MAX(p.salary_month) as salary_month, 
                MAX(p.net_salary) as net_salary, 
                MAX(p.housing) as housing, 
                MAX(p.ipr) as ipr, 
                MAX(p.cnss) as cnss_employee, 
                MAX(p.cnss_company) as cnss_company, 
                MAX(p.inpp) as inpp, 
                MAX(p.onem) as onem, 
                MAX(p.transport) as transport, 
                MAX(p.net_after_taxes) as net_after_taxes, 
                MAX(p.net_before_taxes) as net_before_taxes, 
                MAX(p.salary_imposable) as salary_imposable, 
                MAX(p.presents_days) as presents_days, 
                MAX(p.absents_days) as absents_days, 
                MAX(os.total_time) as total_time,
                MAX(ts.timesheet_status) as timesheet_count
                FROM users u
                LEFT JOIN country c ON u.country_id = c.id
                LEFT JOIN users_role ur ON u.user_role_id = ur.id_role
                LEFT JOIN designations d ON u.designation_id = d.designation_id
                LEFT JOIN departments dep ON u.departement_id = dep.department_id
                LEFT JOIN advanced_salary avc ON u.id = avc.staff_id  AND avc.month_year = :formattedMonthYear
                LEFT JOIN payslips p ON u.id = p.staff_id AND u.company_id = p.company_id AND p.salary_month = :formattedMonthYear
                LEFT JOIN office_shifts os ON u.company_id = os.company_id AND u.office_shift_id = os.office_shift_id
                LEFT JOIN (
                    SELECT staff_id, COUNT(*) as timesheet_status
                    FROM timesheet
                    WHERE DATE_FORMAT(timesheet_date, '%Y-%m') = :formattedMonthYear
                    GROUP BY staff_id
                ) ts ON u.id = ts.staff_id
                WHERE (u.id = :userId OR u.company_id = :companyId) AND u.emplyee_id IS NOT NULL
                GROUP BY u.id", // Assurez-vous de grouper par la clé primaire de la table utilisateur pour éviter les doublons
                ['userId' => $userId, 'companyId' => $companyId, 'formattedMonthYear' => $formattedMonthYear]
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

    public function getUsersByName($searchUsername)
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

            // Modifier la requête pour inclure un filtre sur le nom de l'utilisateur
            $userscompany = $this->db->select(
                "SELECT 
                u.*, 
                MAX(c.name) as country, 
                MAX(ur.name) as role_name,
                MAX(d.designation_name) as designation, 
                MAX(dep.department_name) as department, 
                MAX(avc.advance_amount) as advanced_salary, 
                MAX(p.is_payment) as payed, 
                MAX(p.payslip_value) as payslip_value, 
                MAX(p.year_to_date) as year_to_date, 
                MAX(p.created_at) as created_at, 
                MAX(p.payslip_code) as payslip_code, 
                MAX(p.salary_month) as salary_month, 
                MAX(p.net_salary) as net_salary, 
                MAX(p.housing) as housing, 
                MAX(p.transport) as transport, 
                MAX(p.net_after_taxes) as net_after_taxes, 
                MAX(os.total_time) as total_time,
                MAX(ts.timesheet_status) as timesheet_count
                FROM users u
                LEFT JOIN country c ON u.country_id = c.id
                LEFT JOIN users_role ur ON u.user_role_id = ur.id_role
                LEFT JOIN designations d ON u.designation_id = d.designation_id
                LEFT JOIN departments dep ON u.departement_id = dep.department_id
                LEFT JOIN advanced_salary avc ON u.id = avc.staff_id
                LEFT JOIN payslips p ON u.id = p.staff_id AND u.company_id = p.company_id
                LEFT JOIN office_shifts os ON u.company_id = os.company_id AND u.office_shift_id = os.office_shift_id
                LEFT JOIN (
                    SELECT staff_id, COUNT(*) as timesheet_status
                    FROM timesheet
                    WHERE DATE_FORMAT(timesheet_date, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
                    GROUP BY staff_id
                ) ts ON u.id = ts.staff_id
                WHERE (u.name LIKE :searchName AND (u.id = :userId OR u.company_id = :companyId)) AND u.emplyee_id IS NOT NULL
                GROUP BY u.id",
                ['searchName' => '%' . $searchUsername . '%', 'userId' => $userId, 'companyId' => $companyId]
            );

            // Vérifiez si $userscompany est un tableau avant de continuer
            if (!is_array($userscompany)) {
                return [];
            }

            return $userscompany;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }


    public function updateUser($id, $nameupdate, $updatestatus_marital, $updateposte_name, $updateemployeid, $phoneupdate, $updategender, $updatecountry, $usernameupdate, $emailupdate, $updateuser_role,  $updatedepartment_id,  $updatedesignation_id,  $updateworking_time,  $updatesalaire_base,  $updatepaiement_type,  $updatecontract_type,  $imageFileName = null)
    {
        $data = array(
            'name' => $nameupdate,
            'username' => $usernameupdate,
            'email' => $emailupdate,
            'phone' => $phoneupdate,
            'marital_status' => $updatestatus_marital,
            'poste_name' => $updateposte_name,
            'gender' => $updategender,
            'emplyee_id' => $updateemployeid,
            'user_role_id' => $updateuser_role,
            'country_id' => $updatecountry,
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

    public function getUserById($id)
    {
        return $this->db->select("SELECT * FROM users WHERE id = :id LIMIT 1", array("id" => $id));
    }

    public function getUserById_Company($id)
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

            $info_company = $this->db->select(
                'SELECT c.* 
                FROM company c
                LEFT JOIN users u ON c.id = u.company_id
                WHERE c.id = :id
                LIMIT 1',
                ['id' => $companyId]
            );

            if (!is_array($info_company)) {
                return [];
            }

            return $info_company;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
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

    public function updateStatus($id, $status)
    {
        $data = ['is_active' => $status];
        return $this->db->update("users", $data, "id = $id");
    }

    public function getAllPayementByCreatorAndCompany()
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

            $payement = $this->db->select(
                'SELECT p.*, u.name as staff_name
            FROM payslips p
            LEFT JOIN users u ON p.staff_id = u.id
            WHERE p.added_by = :userId OR p.company_id = :companyId',
                ['userId' => $userId, 'companyId' => $companyId]
            );

            if (!is_array($payement)) {
                return [];
            }

            $count = 1;
            foreach ($payement as &$payements) {
                $payements['num'] = $count;
                $count++;
            }

            return $payement;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getAllPayementCurrentYearByCreatorAndCompany($staffId)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $currentYear = date("Y");  // Obtenez l'année en cours

            // Récupérer les paiements pour l'employé pour l'année en cours
            $payements = $this->db->select(
                'SELECT p.*, u.name as staff_name
            FROM payslips p
            LEFT JOIN users u ON p.staff_id = u.id
            WHERE p.staff_id = :staffId AND LEFT(p.salary_month, 4) = :currentYear',
                ['staffId' => $staffId, 'currentYear' => $currentYear]
            );
            error_log(print_r($payements, true));

            if (!is_array($payements)) {
                return [];
            }

            // Initialisation d'un tableau pour les salaires nets de chaque mois
            $monthlySalaries = array_fill(1, 12, 0);
            foreach ($payements as $payement) {
                // Assurez-vous que 'salary_month' est bien formaté avant de l'utiliser
                if (preg_match('/^\d{4}-\d{2}$/', $payement['salary_month'])) {
                    $month = intval(date('n', strtotime($payement['salary_month'])));
                    $monthlySalaries[$month] = $payement['net_salary'];
                }
            }

            return $monthlySalaries;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getAllPayementCurrentYearByCreatorAndCompanyFiltered($staffId, $year)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $currentYear = $year;

            // Récupérer les paiements pour l'employé pour l'année en cours
            $payements = $this->db->select(
                'SELECT p.*, u.name as staff_name
            FROM payslips p
            LEFT JOIN users u ON p.staff_id = u.id
            WHERE p.staff_id = :staffId AND LEFT(p.salary_month, 4) = :currentYear',
                ['staffId' => $staffId, 'currentYear' => $currentYear]
            );
            error_log(print_r($payements, true));

            if (!is_array($payements)) {
                return [];
            }

            // Initialisation d'un tableau pour les salaires nets de chaque mois
            $monthlySalaries = array_fill(1, 12, 0);
            foreach ($payements as $payement) {
                // Assurez-vous que 'salary_month' est bien formaté avant de l'utiliser
                if (preg_match('/^\d{4}-\d{2}$/', $payement['salary_month'])) {
                    $month = intval(date('n', strtotime($payement['salary_month'])));
                    $monthlySalaries[$month] = $payement['net_salary'];
                }
            }

            return $monthlySalaries;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Comptes
    public function addComptes($data)
    {
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

    public function getAllAccountsByCreatorAndCompany_hack($id)
    {
        return $this->db->select(
            "SELECT 
        ft.transaction_date, 
        ft.transaction_type, 
        ft.reference, 
        ft.amount, 
        ft.payement_method,
        fa.account_opening_balance,
        u.name
        FROM finance_accounts fa
        JOIN finance_transactions ft ON fa.account_id = ft.account_id
        LEFT JOIN users u ON ft.staff_id = u.id
        WHERE ft.account_id = :id
        ",
            array("id" => $id)
        );
    }


    public function deleteComptes($id)
    {

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

    // timesheet
    public function addTimesheet($data)
    {
        return $this->db->insert("timesheet", $data);
    }

    public function getAllTimesheetsByCreatorAndCompany()
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

            $timesheets = $this->db->select(
                'SELECT t.*, u.name as staff_name, u.image as staff_image
                FROM timesheet t
                LEFT JOIN users u ON t.staff_id = u.id
                WHERE t.added_by = :userId OR t.company_id = :companyId
                ORDER BY t.timesheet_date DESC',
                ['userId' => $userId, 'companyId' => $companyId]
            );

            if (!is_array($timesheets)) {
                return [];
            }

            $count = 1;
            foreach ($timesheets as &$timesheet) {
                $timesheet['num'] = $count;
                $count++;
            }

            return $timesheets;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getAllTimesheetsByCreatorAndCompanyYearMonthDay($year, $month, $day)
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

            $formattedDayMonthYear = sprintf('%04d-%02d-%02d', $year, $month, $day);

            $timesheets = $this->db->select(
                'SELECT t.*, u.name as staff_name, u.image as staff_image
                FROM timesheet t
                LEFT JOIN users u ON t.staff_id = u.id
                WHERE (t.added_by = :userId OR t.company_id = :companyId) AND t.timesheet_date = :formattedDayMonthYear
                ORDER BY t.timesheet_date DESC',
                ['userId' => $userId, 'companyId' => $companyId, 'formattedDayMonthYear' => $formattedDayMonthYear]
            );

            if (!is_array($timesheets)) {
                return [];
            }

            $count = 1;
            foreach ($timesheets as &$timesheet) {
                $timesheet['num'] = $count;
                $count++;
            }

            return $timesheets;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getTimesheetByStaffAndDate($staff_id, $timesheet_date)
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
                return null;
            }

            // Exécutez une requête pour rechercher un enregistrement avec le staff_id et timesheet_date spécifiés
            $timesheet = $this->db->select(
                'SELECT t.* 
                 FROM timesheet t 
                 WHERE (t.added_by = :userId OR t.company_id = :companyId) 
                 AND t.staff_id = :staffId 
                 AND DATE(t.timesheet_date) = :timesheetDate',
                ['userId' => $userId, 'companyId' => $companyId, 'staffId' => $staff_id, 'timesheetDate' => $timesheet_date]
            );

            return $timesheet;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getTimesheetByStaffAndDateAndClockInOut($staff_id, $timesheet_date, $clock_in, $clock_out)
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
                return null;
            }

            // Exécutez une requête pour rechercher un enregistrement avec le staff_id, timesheet_date spécifiés, clock_in et clock_out specifiques
            $timesheet = $this->db->select(
                'SELECT t.* 
                 FROM timesheet t 
                 WHERE (t.added_by = :userId OR t.company_id = :companyId) 
                 AND t.staff_id = :staffId 
                 AND DATE(t.timesheet_date) = :timesheetDate
                 AND t.clock_in = :clockIn
                 AND t.clock_out = :clockOut',
                [
                    'userId' => $userId, 
                    'companyId' => $companyId, 
                    'staffId' => $staff_id, 
                    'timesheetDate' => $timesheet_date,
                    'clockIn' => $clock_in,
                    'clockOut' => $clock_out
                ]
            );

            return $timesheet;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    public function getYearlyTimesheetsByStaffAndYear($staffId, $year)
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

            // Modifier la requête pour filtrer par staffId et year
            $timesheets = $this->db->select(
                'SELECT t.*, u.name as staff_name, u.image as staff_image
             FROM timesheet t
             LEFT JOIN users u ON t.staff_id = u.id
             WHERE (t.added_by = :userId OR t.company_id = :companyId) 
             AND t.staff_id = :staffId 
             AND YEAR(t.timesheet_date) = :year',
                ['userId' => $userId, 'companyId' => $companyId, 'staffId' => $staffId, 'year' => $year]
            );

            if (!is_array($timesheets)) {
                return [];
            }

            $count = 1;
            foreach ($timesheets as &$timesheet) {
                $timesheet['num'] = $count;
                $count++;
            }

            return $timesheets;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }


    public function getCurrentMonthTimesheetsByCreatorAndCompany($staffId)
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

            // Récupère les fiches du mois en cours
            $firstDayOfMonth = date("Y-m-01");
            $lastDayOfMonth = date("Y-m-t");

            $timesheets = $this->db->select(
                'SELECT t.*, DAY(t.timesheet_date) as day, u.name as staff_name, u.image as staff_image
             FROM timesheet t
             LEFT JOIN users u ON t.staff_id = u.id
             WHERE (t.added_by = :userId OR t.company_id = :companyId) AND t.staff_id = :staffId
                   AND t.timesheet_date BETWEEN :firstDay AND :lastDay',
                ['userId' => $userId, 'companyId' => $companyId, 'staffId' => $staffId, 'firstDay' => $firstDayOfMonth, 'lastDay' => $lastDayOfMonth]
            );

            // Après avoir récupéré les fiches de temps, récupérez également les informations de l'office_shift pour cet utilisateur.
            $officeShift = $this->db->select(
                'SELECT os.* 
         FROM users u
         JOIN office_shifts os ON u.office_shift_id = os.office_shift_id
         WHERE u.id = :staffId',
                ['staffId' => $staffId]
            );

            if (!is_array($timesheets)) {
                return [];
            }

            if (!is_array($officeShift) || count($officeShift) == 0) {
                $officeShift = null;
            } else {
                $officeShift = $officeShift[0];
            }

            // Initialisation d'un tableau pour tous les jours du mois avec la valeur par défaut 'A'.
            $days = array_fill(1, 31, 'A');
            foreach ($timesheets as $timesheet) {
                $day = intval($timesheet['day']);
                $days[$day] = $timesheet['timesheet_status'] == 'Present' ? 'P' : 'A';
            }

            return [
                'days' => $days,
                'officeShift' => $officeShift
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getCurrentMonthTimesheetsByCreatorAndCompanyFiltered($staffId, $month, $year)
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

            // Récupère les fiches de temps pour le mois et l'année spécifiés
            $firstDayOfMonth = "$year-$month-01";
            $lastDayOfMonth = date("Y-m-t", strtotime($firstDayOfMonth));

            $timesheets = $this->db->select(
                'SELECT t.*, DAY(t.timesheet_date) as day, u.name as staff_name, u.image as staff_image
             FROM timesheet t
             LEFT JOIN users u ON t.staff_id = u.id
             WHERE (t.added_by = :userId OR t.company_id = :companyId) AND t.staff_id = :staffId
                   AND t.timesheet_date BETWEEN :firstDay AND :lastDay',
                ['userId' => $userId, 'companyId' => $companyId, 'staffId' => $staffId, 'firstDay' => $firstDayOfMonth, 'lastDay' => $lastDayOfMonth]
            );

            // Récupération des informations de l'office_shift pour cet utilisateur.
            $officeShift = $this->db->select(
                'SELECT os.* 
             FROM users u
             JOIN office_shifts os ON u.office_shift_id = os.office_shift_id
             WHERE u.id = :staffId',
                ['staffId' => $staffId]
            );

            if (!is_array($timesheets)) {
                return [];
            }

            if (!is_array($officeShift) || count($officeShift) == 0) {
                $officeShift = null;
            } else {
                $officeShift = $officeShift[0];
            }

            // Initialisation d'un tableau pour tous les jours du mois spécifié avec la valeur par défaut 'A'.
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $days = array_fill(1, $daysInMonth, 'A');
            foreach ($timesheets as $timesheet) {
                $day = intval($timesheet['day']);
                $days[$day] = $timesheet['timesheet_status'] == 'Present' ? 'P' : 'A';
            }

            return [
                'days' => $days,
                'officeShift' => $officeShift
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }


    public function deleteTimesheet($id)
    {

        return $this->db->delete('timesheet', "timesheet_id = $id");
    }

    public function updateTimesheet($id, $staff_id, $clock_in, $clock_out, $timesheet_date, $total_work, $total_rest, $total_sup, $status_enter, $status_out)
    {
        $data = [
            'staff_id' => $staff_id,
            'clock_in' => $clock_in,
            'clock_out' => $clock_out,
            'timesheet_date' => $timesheet_date,
            'total_work' => $total_work,
            'total_rest' => $total_rest,
            'total_sup' => $total_sup,
            'status_enter' => $status_enter,
            'status_out' => $status_out,
        ];
        return $this->db->update("timesheet", $data, "timesheet_id = $id");
    }

    // Avance sur salaire
    public function addAvanceSalaire($data)
    {
        return $this->db->insert("advanced_salary", $data);
    }

    public function getBasicSalary($userId) {
        $result = $this->db->select(
            'SELECT basic_salary FROM users WHERE id = :userId',
            ['userId' => $userId]
        );
        return $result ? $result[0]['basic_salary'] : null;
    } 
    
    public function isPaymentDoneForMonth($staffId, $monthYear) {
        $result = $this->db->select(
            'SELECT COUNT(*) as count FROM payslips WHERE staff_id = :staffId AND salary_month = :monthYear',
            ['staffId' => $staffId, 'monthYear' => $monthYear]
        );
        return $result[0]['count'] > 0;
    }
    

    public function getAllAdvanceSalaireByCreatorAndCompany()
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

            $advance = $this->db->select(
                'SELECT avc.*, u.name as staff_name, u.id as staff_id, c.name as company_name, c.address as adresse_company, u.basic_salary as salaire_utilisateur
             FROM advanced_salary avc
             LEFT JOIN users u ON avc.staff_id = u.id
             LEFT JOIN company c ON avc.company_id = c.id
             WHERE (avc.added_by = :userId OR avc.company_id = :companyId) AND avc.salary_type = "avance"',
                ['userId' => $userId, 'companyId' => $companyId]
            );

            if (!is_array($advance)) {
                return [];
            }

            $count = 1;
            foreach ($advance as &$advanced) {
                $advanced['num'] = $count;
                $count++;
            }

            return $advance;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function deleteAvanceSalaire($id)
    {

        return $this->db->delete('advanced_salary', "advanced_salary_id = $id");
    }

    public function updateAvanceSalaire($id, $updatemonth_year, $updateadvance_amount, $updatestaff_id, $updatepaiement_type, $updateavance_reference, $updatedescription)
    {
        $data = [
            'month_year' => $updatemonth_year,
            'advance_amount' => $updateadvance_amount,
            'staff_id' => $updatestaff_id,
            'paiement_type' => $updatepaiement_type,
            'avance_reference' => $updateavance_reference,
            'description' => $updatedescription,
        ];
        return $this->db->update("advanced_salary", $data, "advanced_salary_id = $id");
    }

    // Dayoffnation
    public function getAllDayOffNationByCreatorAndCompanyListe()
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

            // Sélectionner les enregistrements de dayoffnation
            $dayOffNations = $this->db->select(
                'SELECT dn.*, u.name as creator_name
             FROM dayoffnation dn
             LEFT JOIN users u ON dn.added_by = u.id
             WHERE (dn.company_id = 1 AND dn.added_by = 1) 
                OR (dn.added_by = :userId AND dn.company_id = :companyId)',
                ['userId' => $userId, 'companyId' => $companyId]
            );

            if (!is_array($dayOffNations)) {
                return [];
            }

            $count = 1;
            foreach ($dayOffNations as &$dayOffNation) {
                $dayOffNation['num'] = $count;
                $count++;
            }

            return $dayOffNations;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function addDayOff($data)
    {
        return $this->db->insert("dayoffnation", $data);
    }

    public function deleteDayOff($id)
    {
        return $this->db->delete('dayoffnation', "id = $id");
    }
    public function updateDayOff($id, $date_offupdate, $date_off, $description)
    {
        $data = [
            'dayoff_date' => $date_offupdate,
            'day_date' => $date_off,
            'description' => $description,
        ];
        return $this->db->update("dayoffnation", $data, "id = $id");
    }
}
