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

    public function updateCompany_personnel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = intval($_POST['user_id']);
            $companyId = intval($_POST['company_id']);
            $name = $_POST['name'];
            $username = $_POST['username'];
            $email = $_POST['email']; // Ajoutez l'email
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $ville = $_POST['ville'];
            $city = $_POST['city']; // Ajoutez la ville
    
            // Utilisez la fonction pour mettre à jour à la fois "users" et "company"
            $this->model->updateCompanyAndPersonnel($companyId, $userId, $name, $username, $email, $phone, $address, $ville, $city);
    
            $response = [
                'status' => 200,
                'msg' => 'Mise à jour réussie',
            ];
    
            // Mettez à jour la session si nécessaire (par exemple, si l'utilisateur met à jour son propre profil)
            $userIDInSession = $_SESSION['users']['id'];
            if ($userIDInSession === $userId) {
                $_SESSION['users']['name'] = $name;
                $_SESSION['users']['username'] = $username;
                $_SESSION['users']['email'] = $email; // Mettez à jour l'email
                $_SESSION['users']['phone'] = $phone;
                $_SESSION['users']['address'] = $address;
                $_SESSION['users']['ville'] = $ville;
            } 
            echo json_encode($response);
            exit;
        }
    }
    



}