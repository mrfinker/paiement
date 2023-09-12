<?php

class Superadmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("superadmin/js/superadmin.js");
    }

    public function create_company()
    {
        $this->view->render('superadmin/create_company', true);
    }
    public function privilege()
    {
        $this->view->render('superadmin/privilege', true);
    }
    public function user_affectation()
    {
        $this->view->render('superadmin/user_affectation', true);
    }
    public function user_creation()
    {
        $this->view->render('superadmin/user_creation', true);
    }

    // enregistrements utilisateurs

    public function handleRegister()
    {
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
            } else {
                echo json_encode(array("status" => 400, "msg" => "Le mot de passe doit avoir au moins 8 caractere"));
            }
        } else {
            echo json_encode(array("status" => 409, "msg" => "L'email ou le username existe déjà."));
        }
    }

    public function isUserEmailExists($email)
    {
        $stmt = $this->model->getUserbyEmail($email);
        if (!empty($stmt)) {
            return true;
        } else {
            return false;
        }
    }

    public function isUsernameExists($username)
    {
        $stmt = $this->model->getUserbyUsername($username);
        if (!empty($stmt)) {
            return true;
        } else {
            return false;
        }
    }

    public function confirm_password($password, $c_password)
    {
        return $password === $c_password;
    }



    public function handleDeleteRole()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id_role'];
        $result = $this->model->deleteUserRole($id);

        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "L'élément a été supprimé avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'élément."));
        }
    }
}

public function handleAddRole()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $result = $this->model->addUserRole($name);
        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "Le rôle a été ajouté avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du rôle."));
        }
    }
}




}
