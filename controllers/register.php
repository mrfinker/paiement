<?php
class Register extends Controller {

    public function __construct() {
        parent::__construct();
        // if (!isset($this->user["privilege"]) || $this->user["privilege"] !== "admin" ) {
        //     header("location:".LOGIN);
        // }
        $this->view->js = array("register/js/register.js");
    }

    function index()
    {
        $this->view->render('register/index', true);
    }

    public function handleRegister() {
   
        print_r($_POST);
        die;
        if ($this->isUserExists($email)) {
            return false; 
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            return false;
        }
        
        // Hash du mot de passe
        $password = htmlspecialchars($password);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $phone = htmlspecialchars($phone);
        $address = htmlspecialchars($address);
        $data = array('name' => $name,
        'email' => $email,
        'username' => $username,
        'password' => $hashedPassword,
        'phone' => $phone,
        'address' => $address);
        // Préparez la requête SQL pour l'insertio
        $stmt = $this->model->saveUser($data);
        if ($stmt) {
            echo json_encode(array("status" => 200, "msg" => "success"));
        } else {
            return false;
        }
    }

    public function isUserExists($email) {
        $stmt = $this->model->getUserbyEmail($email);
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
