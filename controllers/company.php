<?php

class Company extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->js = array("company/js/company.js");
    }

    public function all_employee()
    {
        $this->view->render('company/all_employee', true);
    }

    public function departements()
    {
        $this->view->render('company/departements', true);
    }
    public function designation()
    {
        $this->view->render('company/designation', true);
    }
    public function roles()
    {
        $this->view->render('company/roles', true);
    }
    public function office_shifts()
    {
        $this->view->render('company/office_shifts', true);
    }
    public function paie()
    {
        $this->view->render('company/paie', true);
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
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $userId = $user['id'];
                $companyId = $user['company_id'];
            } else {
                return [];
            }
            $name = $_POST['name'];
            $permissionsAdmin = isset($_POST['admin']) ? $_POST['admin'] : [];
            $permissionsCompany = isset($_POST['company']) ? $_POST['company'] : [];
            $permissionsPrivilege = isset($_POST['privilege']) ? $_POST['privilege'] : [];

            $permissions = array_merge($permissionsAdmin, $permissionsCompany, $permissionsPrivilege);

            $permissionsString = implode(', ', $permissions);

            $data = [
                'name' => $name,
                'permissions' => $permissionsString,
                'company_id' => $companyId, // Ou une autre manière d'obtenir le company_id
                'added_by' => $userId, // 
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

// departements
public function handleAddDepartment() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            return [];
        }
        $departmentName = $_POST['departement_name'];

        // Vérifiez si le département existe déjà
        if ($this->model->departmentExists($departmentName, $companyId)) {
            echo json_encode(array("status" => 400, "msg" => "Un département avec ce nom existe déjà."));
            return;
        }
        
        $data = [
            'department_name' => $departmentName,
            'company_id' => $companyId, // Ou une autre manière d'obtenir le company_id
            'added_by' => $userId, // Ou une autre manière d'obtenir le user_id
        ];
        
        $result = $this->model->addDepartment($data);
        
        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "Le département a été ajouté avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du département."));
        }
    }
}

public function handleDeleteDepartement() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        
        // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
        // ...

        $result = $this->model->deleteDepartement($id);

        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "L'entreprise a été supprimée avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'entreprise."));
        }
    } else {
        echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
    }
}

public function updateDepartment()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['department_id']);
        $departmentNameUpdate = $_POST['departmentNameUpdate'];
        
        // Vérifiez si les données obligatoires ne sont pas vides
        if (empty($departmentNameUpdate)) {
            $response = [
                'status' => 400,
                'msg' => 'Le nom du département est vide, veuillez le remplir',
            ];
        } else {
            // Appelez la méthode de mise à jour du département dans votre modèle ici
            $result = $this->model->updateDepartment($id, $departmentNameUpdate);

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

// Designation
public function handleAddDesignation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            echo json_encode(array("status" => 400, "msg" => "L'utilisateur n'est pas connecté."));
            return;
        }
        
        $designationName = $_POST['designation_name'];
        $departmentId = $_POST['department_id'];
        
        // Vérifiez si la designation existe déjà
        if ($this->model->designationExists($designationName, $departmentId, $companyId)) {
            echo json_encode(array("status" => 400, "msg" => "Une designation avec ce nom existe déjà dans ce département."));
            return;
        }
        
        $data = [
            'designation_name' => $designationName,
            'department_id' => $departmentId,
            'company_id' => $companyId,
            'added_by' => $userId,
        ];
        
        $result = $this->model->addDesignation($data);
        
        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "La designation a été ajoutée avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout de la designation."));
        }
    }
}

public function handleDeleteDesignation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        
        // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
        // ...

        $result = $this->model->deleteDesignation($id);

        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "L'entreprise a été supprimée avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'entreprise."));
        }
    } else {
        echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
    }
}

public function updateDesignation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['designation_id']);
        $designationNameUpdate = $_POST['designationNameUpdate'];
        $departmentId = $_POST['department_id'];
        
        if (empty($designationNameUpdate)) {
            $response = ['status' => 400, 'msg' => 'Le nom de la désignation est vide, veuillez le remplir'];
        } else {
            $result = $this->model->updateDesignation($id, $designationNameUpdate, $departmentId);

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

public function handleAjaxRequest() {
    if(isset($_POST['departmentId'])) {
        $departmentId = intval($_POST['departmentId']);
        $designations = $this->model->getDesignationsByDepartmentId($departmentId);
        
        header('Content-Type: application/json');
        echo json_encode($designations);
        exit;
    }
}


// Horaire
public function handleAddHoraire() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            echo json_encode(array("status" => 400, "msg" => "L'utilisateur n'est pas connecté."));
            return;
        }

        $shiftName = $_POST['shift_name'];
        $lundi_in = $_POST['lundi_in'];
        $lundi_out = $_POST['lundi_out'];
        $mardi_in = $_POST['mardi_in'];
        $mardi_out = $_POST['mardi_out'];
        $mercredi_in = $_POST['mercredi_in'];
        $mercredi_out = $_POST['mercredi_out'];
        $jeudi_in = $_POST['jeudi_in'];
        $jeudi_out = $_POST['jeudi_out'];
        $vendredi_in = $_POST['vendredi_in'];
        $vendredi_out = $_POST['vendredi_out'];
        $samedi_in = $_POST['samedi_in'];
        $samedi_out = $_POST['samedi_out'];
        $dimanche_in = $_POST['dimanche_in'];
        $dimanche_out = $_POST['dimanche_out'];
        $total_hours = $_POST['total_hours'];

        $data = [
            'shift_name' => $shiftName,
            'total_time' => $total_hours,
            'monday_in_time' => $lundi_in,
            'monday_out_time' => $lundi_out,
            'tuesday_in_time' => $mardi_in,
            'tuesday_out_time' => $mardi_out,
            'wednesday_in_time' => $mercredi_in,
            'wednesday_out_time' => $mercredi_out,
            'thursday_in_time' => $jeudi_in,
            'thursday_out_time' => $jeudi_out,
            'friday_in_time' => $vendredi_in,
            'friday_out_time' => $vendredi_out,
            'saturday_in_time' => $samedi_in,
            'saturday_out_time' => $samedi_out,
            'sunday_in_time' => $dimanche_in,
            'sunday_out_time' => $dimanche_out,
            'company_id' => $companyId,
            'added_by' => $userId,
        ];
        
        $result = $this->model->addHoraire($data);
        
        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "L'horaire a été ajouté avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout de l'horaire."));
        }
    }
}

public function handleDeleteHoraire() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        
        // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
        // ...

        $result = $this->model->deleteHoraire($id);

        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "L'entreprise a été supprimée avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'entreprise."));
        }
    } else {
        echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
    }
}

public function updateHoraire() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['horaire_id']); // Obtention de l'ID de l'horaire
        
        $shiftName = $_POST['shift_name'];
        $totalHours = $_POST['total_hours'];
        $mondayIn = $_POST['lundi_in'];
        $mondayOut = $_POST['lundi_out'];
        $tuesdayIn = $_POST['mardi_in'];
        $tuesdayOut = $_POST['mardi_out'];
        $wednesdayIn = $_POST['mercredi_in'];
        $wednesdayOut = $_POST['mercredi_out'];
        $thursdayIn = $_POST['jeudi_in'];
        $thursdayOut = $_POST['jeudi_out'];
        $fridayIn = $_POST['vendredi_in'];
        $fridayOut = $_POST['vendredi_out'];
        $saturdayIn = $_POST['samedi_in'];
        $saturdayOut = $_POST['samedi_out'];
        $sundayIn = $_POST['dimanche_in'];
        $sundayOut = $_POST['dimanche_out'];

        // Validation
        if (empty($shiftName)) {
            $response = ['status' => 400, 'msg' => 'Veuillez remplir tous les champs obligatoires'];
        } else {
            $data = [
                'shift_name' => $shiftName,
                'total_time' => $totalHours,
                'monday_in_time' => $mondayIn,
                'monday_out_time' => $mondayOut,
                'tuesday_in_time' => $tuesdayIn,
                'tuesday_out_time' => $tuesdayOut,
                'wednesday_in_time' => $wednesdayIn,
                'wednesday_out_time' => $wednesdayOut,
                'thursday_in_time' => $thursdayIn,
                'thursday_out_time' => $thursdayOut,
                'friday_in_time' => $fridayIn,
                'friday_out_time' => $fridayOut,
                'saturday_in_time' => $saturdayIn,
                'saturday_out_time' => $saturdayOut,
                'sunday_in_time' => $sundayIn,
                'sunday_out_time' => $sundayOut,
            ];
            
            $result = $this->model->updateHoraire($id, $data);
            
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

// utilisateurs
public function handleRegisterUsers()
{
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $response = ["status" => 500, "msg" => "Méthode non autorisée"];
        echo json_encode($response);
        return;
    }

    // Récupération des informations de session de l'utilisateur et de la compagnie.
    if (isset($_SESSION['users'])) {
        $user = $_SESSION['users'];
        $userId = $user['id'];
        $companyId = $user['company_id'];
    } else {
        echo json_encode(array("status" => 400, "msg" => "L'utilisateur n'est pas connecté."));
        return;
    }

    $name = $_POST["name"] . " " . $_POST['prename'];
    $paiement_type = $_POST['paiement_type'];
    $employeid = $_POST['employeid'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $user_role = $_POST['user_role'];
    $department_id = $_POST['department_id'];
    $designation_id = $_POST['designation_id'];
    $working_time = $_POST['working_time'];
    $salaire_base = $_POST['salaire_base'];
    $paiement_type = $_POST['paiement_type'];
    $contract_type = $_POST['contract_type'];
    $status_marital = $_POST['status_marital'];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
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
        "salary_type" => $paiement_type,
        "emplyee_id" => $employeid,
        "gender" => $gender,
        "country_id" => $country,
        "user_role_id" => $user_role,
        "departement_id" => $department_id,
        "designation_id" => $designation_id,
        "office_shift_id" => $working_time,
        "basic_salary" => $salaire_base,
        "contract_type" => $contract_type,
        "marital_status" => $status_marital,
        "username" => $username,
        "email" => $email,
        "phone" => $phone,
        "password" => $hashedPassword,
        "image" => $imageFileName,
        "added_by" => $userId, // ajouté par l'utilisateur en session
        "company_id" => $companyId,
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
        echo '<pre>';
print_r($_POST);
echo '</pre>';
        $id = intval($_POST['id']);
        $nameupdate = $_POST['updatename'];
        $usernameupdate = $_POST['updateusername'];
        $emailupdate = $_POST['updateemail'];
        $phoneupdate = $_POST['updatephone'];
        $updatestatus_marital = $_POST['updatestatus_marital'];
        $updateemployeid = $_POST['updateemployeid'];
        $updategender = $_POST['updategender'];
        $updateuser_role = $_POST['updateuser_role'];
        $updatedepartment_id = $_POST['updatedepartment_id'];
        $updatedesignation_id = $_POST['updatedesignation_id'];
        $updateworking_time = $_POST['updateworking_time'];
        $updatesalaire_base = $_POST['updatesalaire_base'];
        $updatepaiement_type = $_POST['updatepaiement_type'];
        $updatecontract_type = $_POST['updatecontract_type'];

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

        if (empty($nameupdate) || empty($usernameupdate) || empty($emailupdate) || empty($phoneupdate)) {
            $response = [
                'status' => 400,
                'msg' => 'Données vides, veuillez les remplir',
            ];
        } else {
            $result = $this->model->updateUser(
                $id, 
                $nameupdate, 
                $usernameupdate, 
                $emailupdate, 
                $phoneupdate, 
                $updatestatus_marital,
                $updateemployeid,
                $updategender,
                $updateuser_role,
                $updatedepartment_id,
                $updatedesignation_id,
                $updateworking_time,
                $updatesalaire_base,
                $updatepaiement_type,
                $updatecontract_type, 
                $imageFileName
            );

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
                    $_SESSION['users']['image'] = $imageFileName;
                    $_SESSION['users']['emplyee_id'] = $updateemployeid;
                    $_SESSION['users']['gender'] = $updategender;
                    $_SESSION['users']['user_role_id'] = $updateuser_role;
                    $_SESSION['users']['departement_id'] = $updatedepartment_id;
                    $_SESSION['users']['designation_id'] = $updatedesignation_id;
                    $_SESSION['users']['office_shift_id'] = $updateworking_time;
                    $_SESSION['users']['basic_salary'] = $updatesalaire_base;
                    $_SESSION['users']['contract_type'] = $updatepaiement_type;
                    $_SESSION['users']['marital_status'] = $updatestatus_marital;
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

    public function handleDeleteUserscomp()
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



}
