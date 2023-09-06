<?php

class Dashboard extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->js = array("dashboard/js/dashboard.js");
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

}

?>