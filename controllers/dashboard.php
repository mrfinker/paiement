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
        $this->view->render('dashboard/superadmin', true);
    }
    public function admin()
    {
        $this->view->render('dashboard/admin', true);
    }
    public function company()
    {
        $this->view->render('dashboard/company', true);
    }
    public function staff()
    {
        $this->view->render('dashboard/staff', true);
    }
}
