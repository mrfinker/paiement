<?php

class Superadmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("superadmin/js/superadmin.js");
    }

    public function index()
    {
        $this->view->render('superadmin/dashboard/index', true);
    }
    public function admin()
    {
        $this->view->render('superadmin/category/index', true);
    }
    public function company()
    {
        $this->view->render('superadmin/settings/index', true);
    }
    public function staff()
    {
        $this->view->render('superadmin/staff/index', true);
    }
}
