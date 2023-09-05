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

    function dashboard(){
        $this->view->render('dashboard/dashboard', true);
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
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            if (!empty($email) && !empty($password)) {
                $getUserByEmail = $this->model->getUserByEmail($email);
                if (!empty($getUserByEmail)) {
                    if ($getUserByEmail[0]["pwd"] == $password) {
                        Session::set("users", $getUserByEmail[0]);
                        echo "success";
                    } else {
                        echo "Identifiant incorrect";
                    }
                } else {
                    echo "Identifiant incorrect";
                }
            } else {
                echo "Tous les champs sont obligatoires";
            }
        } else {
            echo "Pas d'autorisation";
        }
    }

    function logout(){
        Session::destroy();
    }
}
