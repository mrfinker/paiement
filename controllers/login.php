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
    

    function handleRegister()
    {
        if (isset($_POST["action"]) && $_POST['action'] == "jddiuanjkanciuwenfas,mcn;sdiojd") {
            $nom = htmlspecialchars($_POST["nom"]);
            $username = htmlspecialchars($_POST["username"]);
            $email = htmlspecialchars($_POST["email"]);
            $phone = htmlspecialchars($_POST["phone"]);
            $address = htmlspecialchars($_POST["address"]);
            $password = htmlspecialchars($_POST["password"]);
            $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);
            if (
                !empty($nom) &&
                !empty($username) &&
                !empty($email) &&
                !empty($phone) &&
                !empty($address) &&
                !empty($password) &&
                !empty($confirmPassword)
            ) {
                if ($password === $confirmPassword) {
                    $getUserByEmail = $this->model->getUserByEmail($email);
                    if (empty($getUserByEmail)) {
                        $save = $this->model->saveUser(array(
                            "nom" => $nom,
                            "username" => $username,
                            "email" => $email,
                            "phone" => $phone,
                            "address" => $address,
                            "pwd" => $password
                        ));
                        if ($save) {
                            $getUserByEmail = $this->model->getUserByEmail($email);
                            Session::set("users", $getUserByEmail[0]);
                            echo "success";
                        } else {
                            echo "Une erreur de traitement";
                        }
                    } else {
                        echo "L'adresse email existe déjà";
                    }
                } else {
                    echo "Les deux mots de passe doivent être identiques";
                }
            } else {
                echo "Tous les champs sont obligatoires";
            }
        } else {
            echo "Pas d'autorisation";
        }
    }

    function handleLogin()
{
    if (isset($_POST["action"]) && $_POST['action'] == "jddiuanjkanciuSFDSFAEEEADS;sdiojd") {
        $identifier = htmlspecialchars($_POST["identifier"]); // Peut être soit l'email soit le nom d'utilisateur
        $password = htmlspecialchars($_POST["password"]);
        if (!empty($identifier) && !empty($password)) {
            $userWithRole = $this->model->getUserByEmailOrUsernameWithRole($identifier);
            if (!empty($userWithRole)) {
                if (password_verify($password, $userWithRole[0]["password"])) {
                    $userRoleName = $userWithRole[0]["role_type"];
                    Session::set("users", $userWithRole[0]);
                    Session::set("userRoleName", $userRoleName);

                    echo json_encode(array("status" => 200, "msg" => "success"));
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

