<?php
/**
 *
 */
class Controller
{
    public $view;
    public $user;
    public $model;

    public function __construct()
    {
        Session::init();
        $this->view = new Views();
        $this->user = Session::get("users");
    }

    public function loadModel($name, $modelpath)
    {

        $path = $modelpath . $name . '_model.php';

        if (file_exists($path)) {
            require $modelpath . $name . '_model.php';
            $modelName = $name . '_model';
            $this->model = new $modelName();
        }
    }

    public function str_random($length)
    {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, 120)), 0, $length);
    }

    public function date_time()
    {
        return date('Y-m-d H:i:s');
    }

}
