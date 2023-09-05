<?php

class Dashboard extends Controller{
    function __construct(){
        parent::__construct();
        Session::init();
        $this->view->js = array("dashboard/js/dashboard.js");
    }

    function index(){
        $this->view->render("dashboard/index", true);
    }

}

?>