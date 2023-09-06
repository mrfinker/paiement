<?php

class Pages extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("pages/js/pages.js");
    }

    public function termes()
    {
        $this->view->render('pages/termes', true);
    }
    public function faq()
    {
        $this->view->render('pages/faq', true);
    }
}
