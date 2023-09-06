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
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);
        $username = htmlspecialchars($_POST["username"]);
        $phone = htmlspecialchars($_POST["phone"]);
        $address = htmlspecialchars($_POST["address"]);
        $password = htmlspecialchars($_POST["password"]);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if (!$this->isUserEmailExists($email) && !$this->isUsernameExists($username)) {
            if (strlen($password) >= 8) {
                $data = array('name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => $hashedPassword,
                'phone' => $phone,
                'address' => $address);
                $saveUser = $this->model->saveUser($data);
                if ($saveUser) {
                    echo json_encode(array("status" => 200, "msg" => "success"));
                } else {
                    echo json_encode(array("status" => 500, "msg" => "Une erreur se produite lors de l'enregistrement de l'utlisateur."));
                }
            }else {
                echo json_encode(array("status" => 400, "msg" => "Le mot de passe doit avoir au moins 8 caractere"));
            }
        }else {
            echo json_encode(array("status" => 409, "msg" => "L'email existe déjà."));
        }
    }

    public function isUserEmailExists($email) {
        $stmt = $this->model->getUserbyEmail($email);
        if (!empty($stmt)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function isUsernameExists($username) {
        $stmt = $this->model->getUserbyUsername($username);
        if (!empty($stmt)) {
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
