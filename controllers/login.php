<?php

class Login extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $this->view->js = array("login/js/login.js");
    }

    function index()
    {
        $this->view->render('login/index', true);
    }

    function register()
    {
        $this->view->render('register/index', true);
    }

    function dashboard()
    {
        if (Session::get("users")) {
            $userRole = Session::get("users")['role_type'];
    
            switch ($userRole) {
                case 'superadmin':
                    $this->view->render('dashboard/superadmin', true);
                    break;
                case 'admin':
                    $this->view->render('dashboard/admin', true);
                    break;
                case 'company':
                    $this->view->render('dashboard/company', true);
                    break;
                case 'staff':
                    $this->view->render('dashboard/staff', true);
                    break;
                default:
                    // Si le rôle n'est pas défini ou inconnu, redirigez l'utilisateur vers une page d'erreur ou le tableau de bord par défaut.
                    $this->view->render('error/index', true);
                    break;
            }
        } else {
            // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion.
            $this->view->render('login/index', true);
        }
    }

    function handleLogin()
{
    if (isset($_POST["action"]) && $_POST['action'] == "jddiuanjkanciuSFDSFAEEEADS;sdiojd") {
        $emailOrUsername = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);
        
        if (!empty($emailOrUsername) && !empty($password)) {
            $getUser = $this->model->getUserByEmailOrUsernameWithRole($emailOrUsername);
            
            if (!empty($getUser)) {
                if (password_verify($password, $getUser[0]["password"])) {
                    Session::set("users", $getUser[0]);
                    
                    switch ($getUser[0]["role_type"]) {
                        case 'superadmin':
                            echo json_encode(array("status" => 200, "msg" => "success", "redirect" => "dashboard/superadmin"));
                            break;
                        case 'admin':
                            echo json_encode(array("status" => 200, "msg" => "success", "redirect" => "dashboard/admin"));
                            break;
                        case 'company':
                            echo json_encode(array("status" => 200, "msg" => "success", "redirect" => "dashboard/company"));
                            break;
                        case 'staff':
                            echo json_encode(array("status" => 200, "msg" => "success", "redirect" => "dashboard/staff"));
                            break;
                        default:
                            echo json_encode(array("status" => 200, "msg" => "success", "redirect" => "dashboard/default"));
                            break;
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




    function logout(){
        Session::destroy();
    }
}