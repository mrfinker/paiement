<?php

class Dashbord extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->js = array("dashboard/js/dashboard.js");
    }

    function index(){
        $this->view->render("dashboard/index", true);
    }
}

?>