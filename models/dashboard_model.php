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

    public function checkLastLoginDate($userId) {
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

    public function getAllUsersByCreatorAndCompany() {
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
    
            return ['users' => $userscompany, 'maleCount' => $maleCount, 'femaleCount' => $femaleCount];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['users' => [], 'maleCount' => 0, 'femaleCount' => 0];
        }
    }

    public function getTotalUsersByCompanyId() {
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

    
    


}
