<?php
class Register extends Controller {

    public function __construct() {

    }

    public function registration($name, $username, $email, $phone, $address, $password) {
   
        if ($this->isUserExists($email)) {
            return false; 
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            return false;
        }
        
        // Hash du mot de passe
        $password = str_replace(["'", "`"], '', $password);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $name = str_replace(["'", "`"], '', $name);
        $email = str_replace(["'", "`"], '', $email);
        $username = str_replace(["'", "`"], '', $username);
        $phone = str_replace(["'", "`"], '', $phone);
        $address = str_replace(["'", "`"], '', $address);
        $data = array('name' => $name,
        'email' => $email,
        'username' => $username,
        'password' => $hashedPassword,
        'phone' => $phone,
        'address' => $address);
        // Préparez la requête SQL pour l'insertio
        $stmt = $this->model->saveUser($data);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isUserExists($email) {
        $checkUser = "SELECT email FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($checkUser);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function confirm_password($password, $c_password) {
        return $password === $c_password;
    }
}
?>
