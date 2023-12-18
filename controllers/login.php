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

    public function handleLogin()
    {
        if (isset($_POST["action"]) && $_POST['action'] == "jddiuanjkanciuSFDSFAEEEADS;sdiojd") {
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            if (!empty($email) && !empty($password)) {
                $getUserByEmail = $this->model->getUserByEmail($email);
                if (!empty($getUserByEmail)) {
                    if ($getUserByEmail[0]['is_logged_in'] == 1) {
                        echo json_encode(array("status" => 403, "msg" => "Ce compte est déjà connecté."));
                        return;
                    }

                    if ($getUserByEmail[0]['is_active'] == 0) {
                        echo json_encode(array("status" => 403, "msg" => "Ce compte est désactivé."));
                        return;
                    }

                    if (password_verify($password, $getUserByEmail[0]["password"])) {
                        $this->model->updateUserLoggedInStatus($email, 1);
                        $userIdentifier = $email;
                        $userType = $this->model->getUserByEmailOrUsernameWithRole($userIdentifier);

                        // Vérifiez si last_login est null ou vide
                        $isLastLoginEmpty = $this->model->isUserLastLoginEmpty($email);

                        // Mettre à jour last_login et last_login_ip
                        $ip_address = $_SERVER['REMOTE_ADDR']; // Ceci est un exemple; utilisez votre propre méthode pour récupérer l'IP.
                        $this->model->updateUserLastLogin($email, $ip_address);
                        $ValueRoles = $this->model->NumRole($getUserByEmail[0]["user_role_id"]);
                        // S'assurer que les données sont dans un format compatible avec JSON
                        // Extraction des permissions
                        $permissionsList = array_map(function ($item) {
                            return $item['permissions']; // Assurez-vous que 'permissions' est la clé correcte
                        }, $ValueRoles);

                        // Conversion du tableau des permissions en chaîne de caractères
                        $ValueRolesFormatted = !empty($permissionsList) ? implode(', ', $permissionsList) : '';

                        if (!empty($userType)) {
                            Session::set("users", $getUserByEmail[0]);
                            Session::set("userType", $userType[0]);
                            Session::set("CheckLogin", $isLastLoginEmpty);
                            Session::set("CheckEmployer", $isLastLoginEmpty);
                            Session::set("CheckRh", $isLastLoginEmpty);
                            Session::set("CheckFisc", $isLastLoginEmpty);
                            Session::set("CheckPaie", $isLastLoginEmpty);
                            Session::set("userPermissions", $ValueRolesFormatted);
                            echo json_encode(array("status" => 200, "msg" => "success", "userRole" => $userType[0]["user_type_id"], "TypeName" => $userType[0]["name"], "NumRole" => $getUserByEmail[0]["user_role_id"], "ValueRole" => $ValueRolesFormatted, "checkLogin" => $isLastLoginEmpty));
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

    // public function checkSession()
    // {
    //     if (!isset($_SESSION['LAST_ACTIVITY'])) {
    //         echo json_encode(['session_active' => false]);
    //         return;
    //     }

    //     $timeout = 60 * 60; // 1 minute
    //     if (time() - $_SESSION['LAST_ACTIVITY'] > $timeout) {
    //         echo json_encode(['session_active' => false]);
    //     } else {
    //         echo json_encode(['session_active' => true]);
    //     }
    // }

    // public function someMethodCalledOnEachRequest()
    // {
    //     if (session_status() === PHP_SESSION_ACTIVE) {
    //         $_SESSION['LAST_ACTIVITY'] = time();
    //     }
    // }

    public function logout()
    {
        $userSession = Session::get("users");

        if ($userSession && isset($userSession["email"])) {
            $email = $userSession["email"];
            $this->model->updateUserLoggedInStatus($email, 0);
            $this->model->updateUserLastLogout($email, date('Y-m-d H:i:s'));
        }
        Session::destroy();
    }

    // public function logoutClose()
    // {
    //     $userSession = Session::get("users");

    //     if ($userSession && isset($userSession["email"])) {
    //         $email = $userSession["email"];
    //         $this->model->updateUserLoggedInStatus($email, 0);
    //         $this->model->updateUserLastLogout($email, date('Y-m-d H:i:s'));

    //         Session::destroy();
    //     }

    //     // Marquez la session pour destruction dans 20 secondes
    //     $_SESSION['marked_for_destruction'] = time() + 10;
    // }


    // public function checkSessionStatus()
    // {

    //     // Si le temps actuel dépasse le temps marqué pour destruction
    //     if (isset($_SESSION['marked_for_destruction']) && time() > $_SESSION['marked_for_destruction']) {
    //         $this->logoutClose();
    //     } else {
    //         unset($_SESSION['marked_for_destruction']);
    //     }
    // }


    // Votre route

    // public function logoutsession()
    // {
    //     if (!isset($_SESSION['LAST_ACTIVITY'])) {
    //         return;
    //     }

    //     $timeout = 60 * 60; // 1 heure
    //     if (time() - $_SESSION['LAST_ACTIVITY'] > $timeout) {
    //         $_SESSION['session_expired'] = true;
    //         $email = Session::get("users")["email"];
    //         $this->model->updateUserLoggedInStatus($email, 0);
    //         $this->model->updateUserLastLogout($email, date('Y-m-d H:i:s'));
    //         Session::destroy();
    //         echo json_encode(['session_active' => false]);
    //     } else {
    //         echo json_encode(['session_active' => true]);
    //     }
    // }

}
