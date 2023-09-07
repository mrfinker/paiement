<?php

class Superadmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("dashboard/js/dashboard.js");
    }

    
    public function profile()
    {
        $this->view->render('dashboard/superadmin/profile', true);
    }

    public function affichage(){
        
    }
}
