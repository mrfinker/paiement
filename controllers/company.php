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

public function handleDeleteCompany() {
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



}
