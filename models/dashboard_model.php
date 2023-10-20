<?php

class Dashboard_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function threeLast(int $id)
    {
        return $this->db->select("SELECT * FROM users ORDER BY id DESC LIMIT 3");
    }

    public function checkLastLoginDate($userId)
    {
        $query = $this->db->prepare("SELECT last_login FROM users WHERE id = :userId");
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $lastLoginDate = date('Y-m-d', strtotime($user['last_login']));
            $today = date('Y-m-d');

            if ($lastLoginDate == $today) {
                return "Vous revoilà";
            } else {
                return "Bonjour";
            }
        } else {
            return "Utilisateur introuvable";
        }
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
                return ['users' => [], 'maleCount' => 0, 'femaleCount' => 0];
            }

            $userscompany = $this->db->select(
                'SELECT u.*, c.name as country, ur.name as role_name, d.department_name
                FROM users u
                LEFT JOIN country c ON u.country_id = c.id
                LEFT JOIN users_role ur ON u.user_role_id = ur.id_role AND ur.company_id = :companyId
                LEFT JOIN departments d ON u.departement_id = d.department_id
                WHERE (u.id = :userId OR u.company_id = :companyId) AND u.id != :userId',
                ['userId' => $userId, 'companyId' => $companyId]
            );
            

            if (!is_array($userscompany)) {
                return ['users' => [], 'maleCount' => 0, 'femaleCount' => 0];
            }

            $maleCount = 0;
            $femaleCount = 0;
            foreach ($userscompany as $userc) {
                if (strtolower($userc['gender']) === 'homme') {
                    $maleCount++;
                } elseif (strtolower($userc['gender']) === 'femme') {
                    $femaleCount++;
                }
            }

            $departmentGenderCount = [];
foreach ($userscompany as $userc) {
    $departmentId = $userc['departement_id'];
    $gender = strtolower($userc['gender']);

    if (!isset($departmentGenderCount[$departmentId])) {
        $departmentGenderCount[$departmentId] = ['name' => $userc['department_name'], 'homme' => 0, 'femme' => 0];
    }

    if ($gender === 'homme') {
        $departmentGenderCount[$departmentId]['homme']++;
    } elseif ($gender === 'femme') {
        $departmentGenderCount[$departmentId]['femme']++;
    }
}


            return [
                'users' => $userscompany,
                'maleCount' => $maleCount,
                'femaleCount' => $femaleCount,
                'departmentGenderCount' => $departmentGenderCount,
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [
                'users' => [],
                'maleCount' => 0,
                'femaleCount' => 0,
                'departmentGenderCount' => [],
            ];
        }
    }

    public function getTotalUsersByCompanyId()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if (isset($_SESSION['users'])) {
                $companyId = $_SESSION['users']['company_id'];
                $userId = $_SESSION['users']['id'];
            } else {
                // Si $_SESSION['users'] n'est pas défini, retourner zéro
                return 0;
            }

            $count = $this->db->select(
                'SELECT COUNT(*) as total_users
                 FROM users
                 WHERE company_id = :companyId AND id != :userId',
                ['companyId' => $companyId, 'userId' => $userId]
            );

            if (is_array($count) && isset($count[0]['total_users'])) {
                return $count[0]['total_users'];
            }

            return 0;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function getTotalUsersByDepartementsId()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if (isset($_SESSION['users'])) {
                $companyId = $_SESSION['users']['company_id'];
                $userId = $_SESSION['users']['id'];
            } else {
                // Si $_SESSION['users'] n'est pas défini, retourner zéro
                return 0;
            }

            $departmentUserCount = $this->db->select(
                'SELECT d.department_name, COUNT(u.id) as user_count
                FROM departments d
                LEFT JOIN users u ON u.departement_id = d.department_id
                WHERE (u.id = :userId OR u.company_id = :companyId) AND u.id != :userId
                GROUP BY d.department_id',
                ['userId' => $userId, 'companyId' => $companyId]
            );

            return $departmentUserCount;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
    }

    public function getTotalUsersByDesignation()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (isset($_SESSION['users'])) {
            $companyId = $_SESSION['users']['company_id'];
            $userId = $_SESSION['users']['id'];
        } else {
            return [];
        }

        $designationUserCount = $this->db->select(
            'SELECT d.designation_name, COUNT(u.id) as user_count
            FROM designations d
            LEFT JOIN users u ON u.designation_id = d.designation_id
            WHERE (u.id = :userId OR u.company_id = :companyId) AND u.id != :userId
            GROUP BY d.designation_id',
            ['userId' => $userId, 'companyId' => $companyId]
        );

        return $designationUserCount;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}


    public function getSumNetSalaryByCompanyId()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if (isset($_SESSION['users'])) {
                $companyId = $_SESSION['users']['company_id'];
                $userId = $_SESSION['users']['id'];
            } else {
                return 0;
            }

            $sum = $this->db->select(
                'SELECT SUM(net_salary) as total_net_salary
                 FROM payslips
                 WHERE company_id = :companyId AND added_by = :userId',
                ['companyId' => $companyId, 'userId' => $userId]
            );

            if (is_array($sum) && isset($sum[0]['total_net_salary'])) {
                return $sum[0]['total_net_salary'] ?? 0;
            }

            return 0;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function getTotalDepenseAmount()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if (isset($_SESSION['users'])) {
                $companyId = $_SESSION['users']['company_id'];
                $userId = $_SESSION['users']['id'];
            } else {
                return 0;
            }

            $sum = $this->db->select(
                'SELECT SUM(amount) as total_amount
                 FROM finance_transactions
                 WHERE transaction_type = "depense" AND company_id = :companyId AND added_by = :userId',
                ['companyId' => $companyId, 'userId' => $userId]
            );

            if (is_array($sum) && isset($sum[0]['total_amount'])) {
                return $sum[0]['total_amount'] ?? 0;
            }

            return 0;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function getMonthlyDepenseAmount() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['users'])) {
            return [];
        }
    
        $companyId = $_SESSION['users']['company_id'];
        $userId = $_SESSION['users']['id'];
        $currentYear = date("Y");
    
        try {
            $sums = $this->db->select(
                "SELECT MONTH(transaction_date) as month, SUM(amount) as total_amount
                 FROM finance_transactions
                 WHERE transaction_type = 'depense' AND YEAR(transaction_date) = :currentYear AND company_id = :companyId AND added_by = :userId
                 GROUP BY MONTH(transaction_date)",
                 ['currentYear' => $currentYear, 'companyId' => $companyId, 'userId' => $userId]
            );
    
            return $sums ?? [];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getTotalDepotsAmount()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if (isset($_SESSION['users'])) {
                $companyId = $_SESSION['users']['company_id'];
                $userId = $_SESSION['users']['id'];
            } else {
                return 0;
            }

            $sum = $this->db->select(
                'SELECT SUM(amount) as total_amount
                 FROM finance_transactions
                 WHERE transaction_type = "depot" AND company_id = :companyId AND added_by = :userId',
                ['companyId' => $companyId, 'userId' => $userId]
            );

            if (is_array($sum) && isset($sum[0]['total_amount'])) {
                return $sum[0]['total_amount'] ?? 0;
            }

            return 0;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function getMonthlyDepotsAmount() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['users'])) {
            return [];
        }
    
        $companyId = $_SESSION['users']['company_id'];
        $userId = $_SESSION['users']['id'];
        $currentYear = date("Y");
    
        try {
            $sums = $this->db->select(
                "SELECT MONTH(transaction_date) as month, SUM(amount) as total_amount
                 FROM finance_transactions
                 WHERE transaction_type = 'depot' AND YEAR(transaction_date) = :currentYear AND company_id = :companyId AND added_by = :userId
                 GROUP BY MONTH(transaction_date)",
                 ['currentYear' => $currentYear, 'companyId' => $companyId, 'userId' => $userId]
            );
    
            return $sums ?? [];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getWeeklyAttendance() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if (isset($_SESSION['users'])) {
            $companyId = $_SESSION['users']['company_id'];
            $userId = $_SESSION['users']['id'];
        } else {
            // Si $_SESSION['users'] n'est pas défini, retourner zéro
            return 0;
        }

        $companyId = $_SESSION['users']['company_id'];
        $userId = $_SESSION['users']['id'];
        $currentYear = intval(date("Y"));
        $currentWeekNumber = intval(date("W")); // Récupère le numéro de la semaine actuelle.
        


        try {
            // Récupérer le nombre total des utilisateurs dans la company
            $totalUsers = $this->db->select(
                'SELECT COUNT(*) as total_users
                 FROM users
                 WHERE company_id = :companyId AND id != :userId',
                ['companyId' => $companyId, 'userId' => $userId]
            );
    
            $totalUsersCount = intval($totalUsers[0]['total_users']);

            $presentCounts = $this->db->select(
                "SELECT DATE(timesheet_date) as day, COUNT(*) as present_count
                 FROM timesheet
                 WHERE timesheet_status = 'Present' 
                 AND YEAR(timesheet_date) = :currentYear 
                 AND WEEK(timesheet_date, 1) = :currentWeekNumber 
                 AND company_id = :companyId
                 GROUP BY DATE(timesheet_date)",
                [
                    'currentYear' => $currentYear,
                    'currentWeekNumber' => $currentWeekNumber,
                    'companyId' => $companyId
                ]
            );

            // Construire le résultat basé sur le total des utilisateurs
            $result = [];
            $totalPresent = 0; // Variable pour garder une trace du total

            foreach ($presentCounts as $row) {
                $day = $row['day'];
                $present = intval($row['present_count']); // Convertir en entier
                $absent = $totalUsersCount - $present;
                $totalPresent += $present; // Incrémenter le total
                
                $result[$day] = [
                    'present' => $present,
                    'absent' => $absent
                ];
            }

            
            return $result;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }

    }
    
    

}
