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

    public function updateCompany_personnel()
    {
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

            // Vérifiez si les valeurs sont vides
            if (empty($name) || empty($username) || empty($email) || empty($phone) || empty($address) || empty($ville) || empty($city)) {
                $response = [
                    'status' => 409,
                    'msg' => 'Tous les champs sont obligatoires.',
                ];
                echo json_encode($response);
                exit;
            }

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

    public function updateCompany_image()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = intval($_POST['user_id']);
            $companyId = intval($_POST['company_id']);

            $imageFileName = null;
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
                $target_directory = "uploads/";
                $target_file = $target_directory . time() . rand() . rand() . basename($_FILES["image"]["name"]);

                $maxFileSize = 20 * 1024 * 1024;
                if ($_FILES["image"]["size"] <= $maxFileSize) {
                    $imageFileNamed = pathinfo($_FILES["image"]["name"]);
                    $extensionImage = $imageFileNamed['extension'];
                    $allowedImageTypes = ["jpeg", "jpg", "png"];

                    if (in_array($extensionImage, $allowedImageTypes)) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                        $imageFileName = $target_file;
                    } else {
                        $response = ["status" => 409, "msg" => "Format de fichier non pris en charge. Veuillez utiliser une image au format JPEG, PNG ou JPG."];
                        echo json_encode($response);
                        return;
                    }
                } else {
                    $response = ["status" => 409, "msg" => "La taille de l'image dépasse la limite autorisée (20 Mo)."];
                    echo json_encode($response);
                    return;
                }
            }

            // Utilisez la fonction pour mettre à jour à la fois "users" et "company"
            $this->model->updateCompanyAndImage($companyId, $userId, $imageFileName);

            $response = [
                'status' => 200,
                'msg' => 'Mise à jour réussie',
            ];

            // Mettez à jour la session si nécessaire (par exemple, si l'utilisateur met à jour son propre profil)
            $userIDInSession = $_SESSION['users']['id'];
            if ($userIDInSession === $userId) {
                $_SESSION['users']['image'] = $imageFileName;
            }

            echo json_encode($response);
            exit;
        }
    }

    public function updateCompany_compagny()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = intval($_POST['user_id']);
            $companyId = intval($_POST['company_id']);
            $bank_name = $_POST['bank_name'];
            $bank_number = $_POST['bank_number'];
            $code_postale = $_POST['code_postale']; // Ajoutez l'code_postale
            $tax_number = $_POST['tax_number'];
            $rccm = $_POST['rccm'];

            // Vérifiez si les valeurs sont vides
            if (empty($bank_name) || empty($bank_number) || empty($code_postale) || empty($tax_number) || empty($rccm)) {
                $response = [
                    'status' => 409,
                    'msg' => 'Tous les champs sont obligatoires.',
                ];
                echo json_encode($response);
                exit;
            }

            // Utilisez la fonction pour mettre à jour à la fois "users" et "company"
            $this->model->updateCompanyAndCompagny($companyId, $userId, $bank_name, $bank_number, $code_postale, $tax_number, $rccm);

            $response = [
                'status' => 200,
                'msg' => 'Mise à jour réussie',
            ];

            // Mettez à jour la session si nécessaire (par exemple, si l'utilisateur met à jour son propre profil)
            $userIDInSession = $_SESSION['users']['id'];
            if ($userIDInSession === $userId) {
                $_SESSION['users']['bank_name'] = $bank_name;
                $_SESSION['users']['bank_number'] = $bank_number;
                $_SESSION['users']['code_postale'] = $code_postale; // Mettez à jour l'email
                $_SESSION['users']['tax_number'] = $tax_number;
                $_SESSION['users']['rccm'] = $rccm;
            }
            echo json_encode($response);
            exit;
        }
    }

    public function updateCompany_password()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = intval($_POST['user_id']);
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];

            if ($password !== $confirm_password) {
                $response = ["status" => 400, "msg" => "Les mots de passe ne correspondent pas"];
                echo json_encode($response);
                return;
            }

            // Vérifiez si les valeurs sont vides
            if (empty($password) || empty($confirm_password)) {
                $response = [
                    'status' => 409,
                    'msg' => 'Tous les champs sont obligatoires.',
                ];
                echo json_encode($response);
                exit;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);

            // Utilisez la fonction pour mettre à jour à la fois "users" et "company"
            $this->model->updateCompanyAndPassword($userId, $password);

            $response = [
                'status' => 200,
                'msg' => 'Mise à jour réussie',
            ];

            // Mettez à jour la session si nécessaire (par exemple, si l'utilisateur met à jour son propre profil)
            $userIDInSession = $_SESSION['users']['id'];
            if ($userIDInSession === $userId) {
                $_SESSION['users']['password'] = $password;
            }
            echo json_encode($response);
            exit;
        }
    }
}
