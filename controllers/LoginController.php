<?php

class LoginController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function userlogin($email, $password) {
    
        $checkLogin = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($checkLogin);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Vérifier si l'utilisateur existe dans la base de données
        if (!empty($result)) {
            // Vérifier le mot de passe haché
            if (password_verify($password, $result['password'])) {
                $this->userAuthentication($result);
                return true;
            }
        }
    
        return false;
    }    

    private function userAuthentication($data) {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['authenticated'] = true;
            $_SESSION['auth_user'] = [
                'id' => $data['id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone']
            ];
        }
    }
    
}

?>