<?php

class Dashboard extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->js = array("dashboard/js/dashboard.js");
    }

}

?>