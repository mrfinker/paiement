<?php

class Superadmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("superadmin/js/superadmin.js");
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
    public function roles()
    {
        $this->view->render('superadmin/roles', true);
    }
    public function membership_plan()
    {
        $this->view->render('superadmin/membership_plan', true);
    }

    // utilisateurs
    public function handleRegisterUsers()
{
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $response = ["status" => 500, "msg" => "Méthode non autorisée"];
        echo json_encode($response);
        return;
    }

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

    $imageFileName = "";
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
                $response = ["status" => 400, "msg" => "Format de fichier non pris en charge. Veuillez utiliser une image au format JPEG, PNG ou JPG."];
                echo json_encode($response);
                return;
            }
            
        } else {
            $response = ["status" => 400, "msg" => "La taille de l'image dépasse la limite autorisée (20 Mo)."];
            echo json_encode($response);
            return;
        }
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $data = [
        "name" => $name,
        "username" => $username,
        "email" => $email,
        "phone" => $phone,
        "address" => $address,
        "password" => $hashedPassword,
        "image" => $imageFileName,
    ];

    $result = $this->model->insertUser($data);

    if ($result) {
        $response = ["status" => 200, "msg" => "Enregistrement réussi"];
    } else {
        $response = ["status" => 500, "msg" => "Erreur lors de l'enregistrement"];
    }

    echo json_encode($response);
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

        $userdate = $_SESSION['users']['birthday'];

        $dateTime = DateTime::createFromFormat('Y-m-d', $userdate);
if (!$dateTime) {
    $response = ['status' => 400, 'msg' => 'Format de date invalide dans la base de données: ' . $userdate];
    echo json_encode($response);
    return;
}

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
                    $response = ["status" => 400, "msg" => "Format de fichier non pris en charge. Veuillez utiliser une image au format JPEG, PNG ou JPG."];
                    echo json_encode($response);
                    return;
                }
            } else {
                $response = ["status" => 400, "msg" => "La taille de l'image dépasse la limite autorisée (20 Mo)."];
                echo json_encode($response);
                return;
            }
        }

        if (empty($nameupdate) || empty($usernameupdate) || empty($emailupdate) || empty($phoneupdate) || empty($addressupdate) || empty($birthdayupdate)) {
            $response = [
                'status' => 400,
                'msg' => 'Données vides, veuillez les remplir',
            ];
        } else {
            $result = $this->model->updateUser($id, $nameupdate, $usernameupdate, $emailupdate, $phoneupdate, $addressupdate, $birthdayupdate, $imageFileName);

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
                    if ($imageFileName != "") {
                        $_SESSION['users']['image'] = $imageFileName;
                    }
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
            $username = $_POST["username"];
            $address = $_POST["address"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $city = $_POST["city"];
            $province = $_POST["province"];
            $code_postale = $_POST["code_postale"];
            $tax_number = $_POST["tax_number"];
            $rccm = $_POST["rccm"];
            $bank_name = $_POST["bank_name"];
            $bank_number = $_POST["bank_number"];
            $country_id = $_POST["country_id"];
            $category_id = $_POST["category_id"];
            $company_charge = $_POST["company_charge"];
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];

            if ($name === null || $username === null) {
                $response = ["status" => 400, "msg" => "Des champs obligatoires sont manquants"];
                echo json_encode($response);
                return;
            }

            if ($password !== $confirm_password) {
                $response = ["status" => 400, "msg" => "Les mots de passe ne correspondent pas"];
                echo json_encode($response);
                return;
            }

            $uniqueid = "LKD" . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Créez un tableau de données pour la compagnie
            $data = [
                "unique_id" => $uniqueid,
                "name" => $name,
                "username" => $username,
                "country_id" => $country_id,
                "address" => $address,
                "email" => $email,
                "category_id" => $category_id,
                "company_charge" => $company_charge,
                "password" => $hashedPassword,
                "phone" => $phone,
                "city" => $city,
                "province" => $province,
                "code_postale" => $code_postale,
                "tax_number" => $tax_number,
                "rccm" => $rccm,
                "bank_name" => $bank_name,
                "bank_number" => $bank_number
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
            $usernameupdate = $_POST['usernameupdate'];
            $phoneupdate = $_POST['phoneupdate'];
            $addressupdate = $_POST['addressupdate'];
            $cityupdate = $_POST["updatecity"];
            $provinceupdate = $_POST["updateprovince"];
            

            // Vérifiez si les données obligatoires ne sont pas vides
            if (empty($nameupdate) || empty($emailupdate) || empty($phoneupdate) || empty($addressupdate)) {
                $response = [
                    'status' => 400,
                    'msg' => 'Données vides, veuillez les remplir',
                ];
            } else {
                $result = $this->model->updateCompany(
                    $id, 
                    $nameupdate, 
                    $emailupdate, 
                    $phoneupdate, 
                    $addressupdate, 
                    $usernameupdate, 
                    $cityupdate,
                    $provinceupdate
                );

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
                        $_SESSION['company']['username'] = $usernameupdate;
                        $_SESSION['company']['phone'] = $phoneupdate;
                        $_SESSION['company']['address'] = $addressupdate;
                        $_SESSION['company']['city'] = $cityupdate;
                        $_SESSION['company']['province'] = $provinceupdate;
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
            $name = $_POST['name'];
            $permissionsAdmin = isset($_POST['admin']) ? $_POST['admin'] : [];
            $permissionsCompany = isset($_POST['company']) ? $_POST['company'] : [];
            $permissionsPrivilege = isset($_POST['privilege']) ? $_POST['privilege'] : [];

            $permissions = array_merge($permissionsAdmin, $permissionsCompany, $permissionsPrivilege);

            $permissionsString = implode(', ', $permissions);

            $data = [
                'name' => $name,
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
        
        // Combine permissions arrays
        $permissions = array_merge(
            $_POST['admin'] ?? [],
            $_POST['company'] ?? [],
            $_POST['privilege'] ?? []
        );

        $permissionsString = implode(', ', $permissions);

        if (empty($newName)) {
            $response = [
                'status' => 400,
                'msg' => 'Données invalides',
            ];
        } else {
            $result = $this->model->updateRoleName($id, $newName, $permissionsString);

            if ($result) {
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
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

public function toggleUserActiveStatus() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        
        if (is_null($id)) {
            echo json_encode(['success' => false, 'message' => 'ID is missing']);
            return;
        }
        
        $userModel = new superadmin_model();
        $success = $userModel->UserActiveStatus($id);
        
        if($success) {
            $currentUser = $userModel->getUserById($id);
            echo json_encode(['success' => true, 'newIsActive' => $currentUser[0]['is_active']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update user status']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Not a POST request']);
    }
}




// Dans le modèle, ajoutez une nouvelle méthode pour récupérer l'utilisateur par id
public function isUserIdExists($id) {
    $stmt = $this->model->getUserById($id);
        if (!empty($stmt)) {
            return true;
        } else {
            return false;
        }
}

public function updateStatus() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['id']);
        $status = intval($_POST['status']);
        
        $result = $this->model->updateStatus($id, $status);
        
        if ($result) {
            $response = ['status' => 200, 'msg' => 'Mise à jour réussie'];
        } else {
            $response = ['status' => 409, 'msg' => 'Erreur lors de la mise à jour du statut'];
        }
        
        echo json_encode($response);
    }
}

public function AddPlan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $membership_plan_name = $_POST['membership_plan_name'];
            $membership_type_plan = $_POST['membership_type_plan'];
            $price = $_POST['price'];
            $plan_duration = $_POST['plan_duration'];
            $total_employee = $_POST['total_employee'];

            $data = [
                'membership_plan_name' => $membership_plan_name,
                'membership_type_plan' => $membership_type_plan,
                'price' => $price,
                'plan_duration' => $plan_duration,
                'total_employee' => $total_employee,
            ];

            $result = $this->model->addPlan($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le privilège a été ajouté avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du privilège."));
            }
        }
    }

public function DeletePlan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $result = $this->model->deletePlan($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "L'élément a été supprimé avec succès."));
            } else {
                echo json_encode(array("status" => 409, "msg" => "Une erreur s'est produite lors de la suppression de l'élément."));
            }
        }
    }

    public function UpdatePlan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['membership_plan_id']); // Obtention de l'ID de l'horaire

            $membership_plan_name = $_POST['updatemembership_plan_name'];
            $membership_type_plan = $_POST['updatemembership_type_plan'];
            $price = $_POST['updateprice'];
            $plan_duration = $_POST['updateplan_duration'];
            $total_employee = $_POST['updatetotal_employee'];

            // Validation
            if (empty($membership_plan_name)) {
                $response = ['status' => 400, 'msg' => 'Veuillez remplir tous les champs obligatoires'];
            } else {
                $data = [
                    'membership_plan_name' => $membership_plan_name,
                    'membership_type_plan' => $membership_type_plan,
                    'price' => $price,
                    'plan_duration' => $plan_duration,
                    'total_employee' => $total_employee,
                ];

                $result = $this->model->updatePlan($id, $data);

                if ($result) {
                    $response = ['status' => 200, 'msg' => 'Mise à jour réussie'];
                } else {
                    $response = ['status' => 409, 'msg' => 'Erreur lors de la mise à jour'];
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

}
