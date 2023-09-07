<?php

class Superadmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("superadmin/js/superadmin.js");
    }

    public function superadmin()
    {
        $this->view->render('superadmin/superadmin/index', true);
    }
    public function admin()
    {
        $this->view->render('superadmin/admin/index', true);
    }
    public function company()
    {
        $this->view->render('superadmin/company/index', true);
    }
    public function staff()
    {
        $this->view->render('superadmin/staff/index', true);
    }
}
