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

    public function handleUpdateProfile() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = intval($_POST['userId']);;
            $name = $_POST['name']; 
            $username = $_POST['username']; 
            $phone = $_POST['phone']; 
            $birthday = $_POST['birthday'];
        
            $result = $this->model->updateUserProfile($id, $name, $username, $phone, $birthday);
    
                    if ($result) {
                        $response = [
                            'status' => 200,
                            'msg' => 'Mise à jour réussie',
                            
                        ];
                        $userIDInSession = $_SESSION['users']['id'];
                        $idToUpdate = intval($_POST['userId']);
                        
                        if ($userIDInSession === $idToUpdate) {
                            $_SESSION['users']['name'] = $name;
                            $_SESSION['users']['username'] = $username;
                            $_SESSION['users']['phone'] = $phone;
                            $_SESSION['users']['birthday'] = $birthday;
                        }
                    } else {
                        $response = [
                            'status' => 409,
                            'msg' => 'Erreur lors de la mise à jour',
                        ];
                    }
            echo json_encode($response);
            exit;
        }

        }

        
    


}