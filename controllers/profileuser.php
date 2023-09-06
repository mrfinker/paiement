<?php

class Profileuser extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("dashboard/js/profiles.js");
    }

    public function profileuser()
    {
        $this->view->render('dashboard/profileuser', true);
    }
    
}