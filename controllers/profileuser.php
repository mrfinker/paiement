<?php

class Profileuser extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("dashboard/js/profiles.js");
    }

    
    
}