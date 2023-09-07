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
        if($role === 'superadmin'){
            $this->view->render('dashboard/profile', true);
        }elseif($role === 'admin'){
            $this->view->render('dashboard/profile', true);
        }elseif($role === 'staff'){
            $this->view->render('dashboard/profile', true);
        }elseif($role === 'company'){
            $this->view->render('dashboard/profile', true);
        }else{
            $this->view->render('error/index', true);
        }
    }
    
}