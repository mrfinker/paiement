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
        $this->view->render('dashboard/index', true);
    }
    public function category()
    {
        $this->view->render('category/index', true);
    }
    public function settings()
    {
        $this->view->render('settings/index', true);
    }
}
