<?php
//Config
require 'config.php';

require LIBS.'Bootstrap.php';
require LIBS.'controller.php';
require LIBS.'Database.php';
require LIBS.'session.php';
require LIBS.'hash.php';
require LIBS.'model.php';
require LIBS.'views.php';

$bootstrap = new Bootstrap();
$bootstrap->int();

?>

<h1>INDEX</h1>