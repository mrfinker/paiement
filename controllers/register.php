<?php
class Register extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->js = array("register/js/register.js");
    }

    public function index() {
        $this->view->render('register/index', true);
    }

    public function handleRegister() {
        // Utilisez filter_input pour valider et nettoyer les données POST
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password");

        // Vérifiez si toutes les données sont présentes
        if (!$name || !$email || !$username || !$phone || !$address || !$password) {
            $this->sendResponse(400, "Toutes les données sont requises.");
            return;
        }

        // Vérifiez la longueur du mot de passe
        if (strlen($password) < 8) {
            $this->sendResponse(400, "Le mot de passe doit avoir au moins 8 caractères.");
            return;
        }

        // Vérifiez si l'utilisateur existe déjà
        if ($this->isUserExists($email)) {
            $this->sendResponse(409, "L'email existe déjà.");
            return;
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Créez un tableau de données
        $data = array(
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword,
            'phone' => $phone,
            'address' => $address
        );

        // Enregistrez l'utilisateur
        $saveUser = $this->model->saveUser($data);

        if ($saveUser) {
            $this->sendResponse(200, "Enregistrement réussi.");
        } else {
            $this->sendResponse(500, "Une erreur s'est produite lors de l'enregistrement de l'utilisateur.");
        }
    }

    public function isUserExists($email) {
        $stmt = $this->model->getUserByEmail($email);
        return !empty($stmt);
    }

    private function sendResponse($status, $message) {
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "msg" => $message));
        exit;
    }
}
?>
