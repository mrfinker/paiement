<?php

class Views
{
    public $title;
    public $js;
    public $css;
    public $msg;
    public $user;
    public $active;
    public $login;
    public $notification;
    public $userc;
    public function __construct()
    {
    }

    public function render_head()
    {
        require 'views/include/header.php';
    }

    public function render_foot()
    {
        require 'views/include/footer.php';
    }

    public function render_main_content($name)
    {
        require 'views/' . $name . '.php';
    }
    /**
     *
     * @param type $name
     * @param type $noInclude
     * @param type $option
     */
    public function render($name, $noInclude = false)
    {
        if ($noInclude == true) {
            $this->render_main_content($name);
        } else {
            $this->render_head();
            $this->render_main_content($name);
            $this->render_foot();
        }
    }

}
