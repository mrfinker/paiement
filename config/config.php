<?php
include_once('./classes/Database.php');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'jenesaispas');
define('DB_DATABASE', 'paiment');

define('LIBS', 'libs/');
define('SITE_URL','http://paiement.mr:81/');

// Utilisez la classe Database pour créer une connexion PDO
$db = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

function base_url($slug){
    echo SITE_URL.$slug;
}

?>