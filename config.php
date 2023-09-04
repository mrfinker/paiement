<?php
include_once('./libs/Database.php');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PORT', '');
define('DB_PASSWORD', 'jenesaispas');
define('DB_DATABASE', 'paiment');

define('LIBS', 'libs/');
define('URL','http://paiement.mr:81/');
define('LOGIN', 'http://paiement.mr:81/views/login');


define ('HASH_PASSWORD_KEY', 'rouuge');
// Utilisez la classe Database pour créer une connexion PDO
$db = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

function base_url($slug){
    echo URL.$slug;
}

?>