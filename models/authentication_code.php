<?php
session_start();
include_once('config.php');
include_once('./controllers/RegisterController.php');
include_once('./controllers/LoginController.php');

$dbConnection = $db->getConnection(); // Obtenez la connexion PDO à partir de $db
$auth = new LoginController($dbConnection);
$register = new RegisterController($dbConnection);

function validateinput($dbcon, $input){
    return $dbcon->quote($input); // Utilisez la méthode quote pour échapper les entrées
}

function redirect($message, $page){
    $redirectTo = URL.$page;
    $_SESSION['message'] = $message; // Notez la correction ici (suppression des guillemets autour de $message)
    header("Location: $redirectTo");
    exit(0);
}

if (isset($_POST['login_btn'])) {
    // Validation des entrées
    $email = validateinput($dbConnection, $_POST["email"]); // Utilisez $dbConnection au lieu de $db->conn
    $password = validateinput($dbConnection, $_POST["password"]); // Utilisez $dbConnection au lieu de $db->conn

    // Authentification de l'utilisateur 
    $isLoggedIn = $auth->userlogin($email, $password);

    // Redirection en fonction du résultat de l'authentification
    if ($isLoggedIn) {
        $_SESSION['email'] = $email;
            redirect("Connexion réussie", "dashboard.php");
    } else {
        redirect("Connexion échouée", "index.php");
    }
}

if(isset($_POST['register_btn'])){
    // Validation des entrées
    $name = validateinput($dbConnection, $_POST["name"]); // Utilisez $dbConnection au lieu de $db->conn
    $username = validateinput($dbConnection, $_POST["username"]); // Utilisez $dbConnection au lieu de $db->conn
    $email = validateinput($dbConnection, $_POST["email"]); // Utilisez $dbConnection au lieu de $db->conn
    $phone = validateinput($dbConnection, $_POST["phone"]); // Utilisez $dbConnection au lieu de $db->conn
    $address = validateinput($dbConnection, $_POST["address"]); // Utilisez $dbConnection au lieu de $db->conn
    $password = validateinput($dbConnection, $_POST["password"]); // Utilisez $dbConnection au lieu de $db->conn
    $confirm_password = validateinput($dbConnection, $_POST["confirm_password"]); // Utilisez $dbConnection au lieu de $db->conn

    // Vérification de la correspondance des mots de passe
    $result_password = $register->confirm_password($password, $confirm_password);

    if($result_password){
        // Vérification si l'utilisateur existe déjà
        $result_user = $register->isUserExists($email, $username);

        if($result_user){
            redirect("Email déjà existant", "register.php");
        }else{
            // Enregistrement de l'utilisateur
            $register_query = $register->registration($name,$username,$email,$phone,$address,$password);

            if($register_query){
                redirect("L'enregistrement a réussi", "index.php");
            }else{
                redirect("L'enregistrement a échoué", "register.php");
            }
        }
    }else{
        redirect("Vos mots de passe ne correspondent pas", "register.php");
    }
}

if(isset($_POST['logout_btn'])){
    
    // Supprimer toutes les variables de session
    $_SESSION = array();

    // Supprimer le cookie de session s'il existe
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion ou une autre page appropriée
    header("Location: index.php");
    exit();

}

?>
