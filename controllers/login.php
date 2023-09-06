<?php

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Session::init();
        $this->view->js = array("login/js/login.js");
    }

    public function index()
    {
        $this->view->render('login/index', true);
    }

    public function register()
    {
        $this->view->render('register/index', true);
    }

    public function superadmin()
    {
        $this->view->render('dashboard/superadmin', true);
    }
    public function admin()
    {
        $this->view->render('dashboard/admin', true);
    }
    public function company()
    {
        $this->view->render('dashboard/company', true);
    }
    public function staff()
    {
        $this->view->render('dashboard/staff', true);
    }

    public function handleLogin()
    {
        if (isset($_POST["action"]) && $_POST['action'] == "jddiuanjkanciuSFDSFAEEEADS;sdiojd") {
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            if (!empty($email) && !empty($password)) {
                $getUserByEmail = $this->model->getUserByEmail($email);
                if (!empty($getUserByEmail)) {
                    if (password_verify($password, $getUserByEmail[0]["password"])) {
                        $userIdentifier = $email;
                        $userType = $this->model->getUserByEmailOrUsernameWithRole($userIdentifier);

                        if (!empty($userType)) {
                            Session::set("users", $getUserByEmail[0]);
                            Session::set("userType", $userType[0]);
                            echo json_encode(array("status" => 200, "msg" => "success", "userRole" => $userType[0]["user_type_id"], "TypeName" => $userType[0]["name"]));
                        } else {
                            echo json_encode(array("status" => 403, "msg" => "Erreur lors de la récupération du rôle"));
                        }
                    } else {
                        echo json_encode(array("status" => 403, "msg" => "Identifiant incorrect"));
                    }
                } else {
                    echo json_encode(array("status" => 403, "msg" => "Identifiant incorrect"));
                }
            } else {
                echo json_encode(array("status" => 400, "msg" => "Tous les champs sont obligatoires"));
            }
        } else {
            echo json_encode(array("status" => 401, "msg" => "Pas d'autorisation"));
        }
    }

    public function logout()
    {
        Session::destroy();
    }
}
