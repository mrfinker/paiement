<?php

class Superadmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("superadmin/js/superadmin.js");
    }

    public function roles()
    {
        $this->view->render('superadmin/roles', true);
    }

    public function user_affectation()
    {
        $this->view->render('superadmin/user_affectation', true);
    }

    public function all_user()
    {
        $this->view->render('superadmin/all_user', true);
    }
    public function all_company()
    {
        $this->view->render('superadmin/all_company', true);
    }

    public function all_admin()
    {
        $this->view->render('superadmin/all_admin', true);
    }

    // utilisateurs
    public function handleRegisterUsers()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];
            if ($password !== $confirm_password) {
                $response = ["status" => 400, "msg" => "Les mots de passe ne correspondent pas"];
                echo json_encode($response);
                return;
            }

            $existingEmailUser = $this->model->getUserbyEmail($email);
            if (!empty($existingEmailUser)) {
                $response = ["status" => 400, "msg" => "L'e-mail existe déjà"];
                echo json_encode($response);
                return;
            }

            $existingUsernameUser = $this->model->getUserbyUsername($username);
            if (!empty($existingUsernameUser)) {
                $response = ["status" => 400, "msg" => "Le nom d'utilisateur existe déjà"];
                echo json_encode($response);
                return;
            }

            if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] === UPLOAD_ERR_OK) {
                $image = $_FILES["imageFile"]["name"];
                $target_directory = "upload/";
                if (!file_exists($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }
                $target_file = $target_directory . basename($image);

                if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
                } else {
                    $response = ["status" => 400, "msg" => "Erreur lors de l'enregistrement de l'image"];
                    echo json_encode($response);
                    return;
                }
            } else {
                $image = "";
            }

            $data = [
                "name" => $name,
                "username" => $username,
                "email" => $email,
                "phone" => $phone,
                "address" => $address,
                "password" => password_hash($password, PASSWORD_DEFAULT),
                "image" => $image,
            ];
            $result = $this->model->insertUser($data);

            if ($result) {
                $response = ["status" => 200, "msg" => "Enregistrement réussi"];
                echo json_encode($response);
            } else {
                $response = ["status" => 500, "msg" => "Erreur lors de l'enregistrement"];
                echo json_encode($response);
            }
        } else {
            $response = ["status" => 500, "msg" => "Méthode non autorisée"];
            echo json_encode($response);
        }
    }

    public function updateUsers()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $nameupdate = $_POST['nameupdate'];
            $usernameupdate = $_POST['usernameupdate'];
            $emailupdate = $_POST['emailupdate'];
            $phoneupdate = $_POST['phoneupdate'];
            $addressupdate = $_POST['addressupdate'];
            $birthdayupdate = $_POST['birthdayupdate'];

            if (empty($nameupdate) || empty($usernameupdate) || empty($emailupdate) || empty($phoneupdate) || empty($addressupdate) || empty($birthdayupdate)) {
                $response = [
                    'status' => 400,
                    'msg' => 'Données vides, veuillez les remplir',
                ];
            } else {
                $result = $this->model->updateUser($id, $nameupdate, $usernameupdate, $emailupdate, $phoneupdate, $addressupdate, $birthdayupdate);

                if ($result) {
                    $response = [
                        'status' => 200,
                        'msg' => 'Mise à jour réussie',

                    ];
                    $userIDInSession = $_SESSION['users']['id'];
                    $idToUpdate = intval($_POST['id']);

                    if ($userIDInSession === $idToUpdate) {
                        $_SESSION['users']['name'] = $nameupdate;
                        $_SESSION['users']['username'] = $usernameupdate;
                        $_SESSION['users']['email'] = $emailupdate;
                        $_SESSION['users']['phone'] = $phoneupdate;
                        $_SESSION['users']['address'] = $addressupdate;
                        $_SESSION['users']['birthday'] = $birthdayupdate;
                    }
                } else {
                    $response = [
                        'status' => 409,
                        'msg' => 'Erreur lors de la mise à jour',
                    ];
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    public function handleDeleteUsers()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $result = $this->model->deleteUser($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "L'élément a été supprimé avec succès."));
            } else {
                echo json_encode(array("status" => 409, "msg" => "Une erreur s'est produite lors de la suppression de l'élément."));
            }
        }
    }

    public function isUserEmailExists($email)
    {
        $stmt = $this->model->getUserbyEmail($email);
        if (!empty($stmt)) {
            return true;
        } else {
            return false;
        }
    }

    public function isUsernameExists($username)
    {
        $stmt = $this->model->getUserbyUsername($username);
        if (!empty($stmt)) {
            return true;
        } else {
            return false;
        }
    }

    public function confirm_password($password, $c_password)
    {
        return $password === $c_password;
    }

    // Role
    public function handleDeleteRole()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_role'];
            $result = $this->model->deleteUserRole($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "L'élément a été supprimé avec succès."));
            } else {
                echo json_encode(array("status" => 409, "msg" => "Une erreur s'est produite lors de la suppression de l'élément."));
            }
        }
    }

    public function handleAddRole()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['nom'];
            $permissionsAdmin = isset($_POST['admin']) ? $_POST['admin'] : [];
            $permissionsCompany = isset($_POST['company']) ? $_POST['company'] : [];
            $permissionsPrivilege = isset($_POST['privilege']) ? $_POST['privilege'] : [];

            $permissions = array_merge($permissionsAdmin, $permissionsCompany, $permissionsPrivilege);

            $permissionsString = implode(', ', $permissions);

            $data = [
                'nom' => $name,
                'permissions' => $permissionsString,
            ];

            $result = $this->model->addUserRole($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le privilège a été ajouté avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du privilège."));
            }
        }
    }

    public function updateRole()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id_role']);
            $newName = $_POST['newName'];
            $permissionsAdmin = isset($_POST['admin']) ? $_POST['admin'] : [];
        $permissionsCompany = isset($_POST['company']) ? $_POST['company'] : [];
        $permissionsPrivilege = isset($_POST['privilege']) ? $_POST['privilege'] : [];

        $permissions = array_merge($permissionsAdmin, $permissionsCompany, $permissionsPrivilege);
        $permissionsString = implode(', ', $permissions);

            $result = $this->model->updateRoleName($id, $newName, $permissionsString);

            if (empty($newName)) {
                $response = [
                    'status' => 400,
                    'msg' => 'Données invalides',
                ];
            } elseif ($result) {
                $response = [
                    'status' => 200,
                    'msg' => 'Mise à jour réussie',
                ];
            } else {
                $response = [
                    'status' => 409,
                    'msg' => 'Erreur lors de la mise à jour',
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    // Company
    public function handleDeleteCompany()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $result = $this->model->deleteCompany($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "L'élément a été supprimé avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'élément."));
            }
        }
    }

    public function handleInsertCompany()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"];
            $address = $_POST["address"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $country_id = $_POST["country_id"];
            $category_id = $_POST["category_id"];

            $uniqueid = "LKD" . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            // Créez un tableau de données pour la compagnie
            $data = [
                "unique_id" => $uniqueid,
                "name" => $name,
                "country_id" => $country_id,
                "address" => $address,
                "email" => $email,
                "category_id" => $category_id,
                "phone" => $phone,
            ];

            $result = $this->model->insertCompany($data);

            if ($result) {
                $response = ["status" => 200, "msg" => "Enregistrement de la compagnie réussi"];
                echo json_encode($response);
            } else {
                $response = ["status" => 400, "msg" => "Erreur lors de l'enregistrement de la compagnie"];
                echo json_encode($response);
            }
        } else {
            $response = ["status" => 400, "msg" => "Méthode non autorisée"];
            echo json_encode($response);
        }
    }

    public function updateCompany()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $nameupdate = $_POST['nameupdate'];
            $emailupdate = $_POST['emailupdate'];
            $phoneupdate = $_POST['phoneupdate'];
            $addressupdate = $_POST['addressupdate'];

            // Vérifiez si les données obligatoires ne sont pas vides
            if (empty($nameupdate) || empty($emailupdate) || empty($phoneupdate) || empty($addressupdate)) {
                $response = [
                    'status' => 400,
                    'msg' => 'Données vides, veuillez les remplir',
                ];
            } else {
                // Appelez la méthode de mise à jour de l'utilisateur dans votre modèle ici
                // Assurez-vous que cette méthode effectue la mise à jour dans la base de données
                $result = $this->model->updateCompany($id, $nameupdate, $emailupdate, $phoneupdate, $addressupdate);

                if ($result) {
                    $response = [
                        'status' => 200,
                        'msg' => 'Mise à jour réussie',

                    ];
                    $userIDInSession = $_SESSION['users']['id'];
                    $idToUpdate = intval($_POST['id']);

                    if ($userIDInSession === $idToUpdate) {
                        $_SESSION['company']['name'] = $nameupdate;
                        $_SESSION['company']['email'] = $emailupdate;
                        $_SESSION['company']['phone'] = $phoneupdate;
                        $_SESSION['company']['address'] = $addressupdate;
                    }
                } else {
                    $response = [
                        'status' => 409,
                        'msg' => 'Erreur lors de la mise à jour',
                    ];
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    //

}
