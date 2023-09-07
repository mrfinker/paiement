<?php

class Profile extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("dashboard/js/dashboard.js");
    }

    public function profile($role)
    {
        if($role === 'superadmin')
        $this->view->render('dashboard/profileuser', true);
    }
    
}