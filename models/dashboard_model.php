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
                'SELECT u.*, c.name as country, ur.name as role_name
                FROM users u
                LEFT JOIN country c ON u.country_id = c.id
                LEFT JOIN users_role ur ON u.user_role_id = ur.id_role AND ur.company_id = :companyId
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
                    $departmentGenderCount[$departmentId] = ['homme' => 0, 'femme' => 0];
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
    

}
