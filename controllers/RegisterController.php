<?php
class RegisterController {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registration($name, $username, $email, $phone, $address, $password) {
        // Vérifiez d'abord si l'utilisateur existe déjà
        if ($this->isUserExists($email)) {
            return false; // L'utilisateur existe déjà, renvoyez false
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            return false; // Le mot de passe ne respecte pas les critères de longueur
        }
        
        // Hash du mot de passe
        $password = str_replace(["'", "`"], '', $password);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $name = str_replace(["'", "`"], '', $name);
        $email = str_replace(["'", "`"], '', $email);
        $username = str_replace(["'", "`"], '', $username);
        $phone = str_replace(["'", "`"], '', $phone);
        $address = str_replace(["'", "`"], '', $address);
        
        // Préparez la requête SQL pour l'insertion
        $register_query = "INSERT INTO users (name, email, username, password, phone, address) VALUES (:name, :email, :username, :password, :phone, :address)";
        $stmt = $this->conn->prepare($register_query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);

        // Exécutez la requête
        if ($stmt->execute()) {
            return true; // L'inscription a réussi
        } else {
            return false; // L'inscription a échoué
        }
    }

    public function isUserExists($email) {
        $checkUser = "SELECT email FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($checkUser);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true; // L'utilisateur existe déjà
        } else {
            return false; // L'utilisateur n'existe pas
        }
    }

    public function confirm_password($password, $c_password) {
        return $password === $c_password;
    }
}
?>
