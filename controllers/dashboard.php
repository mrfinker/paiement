<?php

class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("dashboard/js/dashboard.js");
    }

    public function superadmin()
    {
        $this->view->render('dashboard/superadmin/index', true);
    }
    public function admin()
    {
        $this->view->render('dashboard/admin/index', true);
    }
    public function company()
    {
        $this->view->render('dashboard/company/index', true);
    }
    public function staff()
    {
        $this->view->render('dashboard/staff/index', true);
    }

    public function updateSession()
    {
        if (isset($_POST['updateSession']) && $_POST['updateSession'] == 'true') {
            // Met à jour la session
            Session::set("CheckLogin", false);
            echo json_encode(["message" => "La session a ete mise a jour"]);
        } else {
            echo json_encode(["message" => "La requete est invalide"]);
        }
    }
}
