<?php

class Profile extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("profile/js/profile.js");
    }

    public function superadmin()
    {
        $this->view->render('profile/superadmin/index', true);
    }
    public function admin()
    {
        $this->view->render('profile/admin/index', true);
    }
    public function company()
    {
        $this->view->render('profile/company/index', true);
    }
    public function staff()
    {
        $this->view->render('profile/staff/index', true);
    }

    public function handleUpdateProfile()
{
    // Vérifiez d'abord si des données POST ont été soumises
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérez les données POST
        $fullName = htmlspecialchars($_POST["name"]);
        $userName = htmlspecialchars($_POST["username"]);
        $phoneNumber = htmlspecialchars($_POST["phone"]);
        $birthday = htmlspecialchars($_POST["birthday"]);

        $userId = $_SESSION['users']['id'];
        
        // Instanciez le modèle de profil
        $profileModel = new Profile_model();
        $result = $profileModel->updateUserProfile($userId, $fullName, $userName, $phoneNumber, $birthday);
        
        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "Mise à jour du profil réussie."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la mise à jour du profil."));
        }
    } else {
        // Si aucune donnée POST n'a été soumise, renvoyez un message d'erreur JSON
        echo json_encode(array("status" => 400, "msg" => "Aucune donnée de mise à jour du profil n'a été soumise."));
    }
}


}