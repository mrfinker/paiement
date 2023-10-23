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
    public function invoice_paie()
    {
        $this->view->render('company/invoice_paie', true);
    }
    public function invoice_account()
    {
        $this->view->render('company/invoice_account', true);
    }
    public function invoice_transaction()
    {
        $this->view->render('company/invoice_transaction', true);
    }
    public function invoiceprint()
    {
        $this->view->render('company/invoiceprint', true);
    }
    public function comptes()
    {
        $this->view->render('company/comptes', true);
    }
    public function depenses()
    {
        $this->view->render('company/depenses', true);
    }
    public function depots()
    {
        $this->view->render('company/depots', true);
    }
    public function transactions()
    {
        $this->view->render('company/transactions', true);
    }
    public function depense_depot()
    {
        $this->view->render('company/depense_depot', true);
    }
    public function timesheet()
    {
        $this->view->render('company/timesheet', true);
    }
    public function report_monthly()
    {
        $this->view->render('company/report_monthly', true);
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

            // Remplacez les caractères "_" par des espaces dans les noms des permissions
            $permissionsAdmin = array_map(function($permission) {
                return str_replace('_', ' ', $permission);
            }, $permissionsAdmin);
            $permissionsCompany = array_map(function($permission) {
                return str_replace('_', ' ', $permission);
            }, $permissionsCompany);
            $permissionsPrivilege = array_map(function($permission) {
                return str_replace('_', ' ', $permission);
            }, $permissionsPrivilege);

            // Supprimez les valeurs "on" du tableau des permissions
            $permissionsAdmin = array_filter($permissionsAdmin, function($permission) {
                return $permission !== 'on';
            });
            $permissionsCompany = array_filter($permissionsCompany, function($permission) {
                return $permission !== 'on';
            });
            $permissionsPrivilege = array_filter($permissionsPrivilege, function($permission) {
                return $permission !== 'on';
            });

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
    public function handleAddDepartment()
    {
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

    public function handleDeleteDepartement()
    {
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
    public function handleAddDesignation()
    {
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

    public function handleDeleteDesignation()
    {
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

    public function updateDesignation()
    {
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

    public function handleAjaxRequest()
    {
        if (isset($_POST['departmentId'])) {
            $departmentId = intval($_POST['departmentId']);
            $designations = $this->model->getDesignationsByDepartmentId($departmentId);

            header('Content-Type: application/json');
            echo json_encode($designations);
            exit;
        }
    }

// depots et depenses
    public function handleAddDepExp()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $userId = $user['id'];
                $companyId = $user['company_id'];
            } else {
                echo json_encode(array("status" => 400, "msg" => "Session utilisateur non trouvée."));
                return;
            }

            $categoryName = $_POST['category_name'];
            $type = $_POST['type'];

            // TODO: Ajoutez des vérifications pour s'assurer que categoryName et type sont valides.

            // Par exemple, pour vérifier si cette catégorie et ce type existent déjà, 
            // vous pourriez avoir une méthode `categoryExists($categoryName, $type, $companyId)`.
            // Pour l'instant, je vais continuer sans cette vérification.

            $data = [
                'category_name' => $categoryName,
                'type' => $type,
                'company_id' => $companyId,
                'added_by' => $userId,
            ];

            $result = $this->model->addDepExp($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "La catégorie a été ajoutée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout de la catégorie."));
            }
        }
    }

    public function updateDepExp()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['constants_id']);
            $depexpNameUpdate = $_POST['depexpNameUpdate'];
            $constantsId = $_POST['constants_id'];

            if (empty($depexpNameUpdate)) {
                $response = ['status' => 400, 'msg' => 'Le nom de la category est vide, veuillez le remplir'];
            } else {
                $result = $this->model->updateDepExp($id, $depexpNameUpdate, $constantsId);

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

    public function handleDeleteCategoryDepExp()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
            // ...

            $result = $this->model->deleteCategoryDepExp($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "L'element a été supprimée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'element."));
            }
        } else {
            echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
        }
    }

    public function handleAddDepenses()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $userId = $user['id'];
                $companyId = $user['company_id'];
            } else {
                echo json_encode(array("status" => 400, "msg" => "Session utilisateur non trouvée."));
                return;
            }

            $accountName = $_POST['account_name'];
            $amount = $_POST['amount'];
            try {
                $date = DateTime::createFromFormat('Y-m-d', $_POST['transaction_date']);
                if (!$date) {
                    throw new Exception("Format de date invalide.");
                }
                $transaction_date = $date->format('Y-m-d'); // Pas nécessaire de reformater si on utilise le même format
            } catch (Exception $e) {
                // Traiter l'exception ou indiquer une date incorrecte
                echo $e->getMessage();
            }    
                        
            $entity_category_id = $_POST['entity_category_id'];
            $staff_id = $_POST['staff_id'];
            $payement_method = $_POST['payement_method'];
            $reference = $_POST['reference'];
            $description = $_POST['description'];
            $transaction_type = "depense";

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $transactionsValue = '';
            for ($i = 0; $i < 15; $i++) {
                $transactionsValue .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Les lettres en majuscules et les chiffres
            $transactionsCode = '#'; // Commence par #

            for ($i = 0; $i < 6; $i++) {
                $transactionsCode .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            // TODO: Ajoutez des vérifications pour s'assurer que accountName et type sont valides.

            // Par exemple, pour vérifier si cette catégorie et ce type existent déjà, 
            // vous pourriez avoir une méthode `categoryExists($accountName, $type, $companyId)`.
            // Pour l'instant, je vais continuer sans cette vérification.

            $data = [
                'account_id' => $accountName,
                'amount' => $amount,
                'transaction_date' => $transaction_date,
                'entity_category_id' => $entity_category_id,
                'staff_id' => $staff_id,
                'payement_method' => $payement_method,
                'reference' => $reference,
                'description' => $description,
                'transaction_type' => $transaction_type,
                'transactions_value' => $transactionsValue,
                'transactions_code' => $transactionsCode,
                'company_id' => $companyId,
                'added_by' => $userId,
            ];

            $result = $this->model->addDepenses($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "La depense a été ajoutée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout de la depense."));
            }
        }
    }
    public function handleDeleteTransactionDepExp()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
            // ...

            $result = $this->model->deleteTransactionDepExp($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "L'element a été supprimée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'element."));
            }
        } else {
            echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
        }
    }

    public function handleAddDepots()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $userId = $user['id'];
                $companyId = $user['company_id'];
            } else {
                echo json_encode(array("status" => 400, "msg" => "Session utilisateur non trouvée."));
                return;
            }

            $accountName = $_POST['account_name'];
            $amount = $_POST['amount'];
            try {
                $date = DateTime::createFromFormat('Y-m-d', $_POST['transaction_date']);
                if (!$date) {
                    throw new Exception("Format de date invalide.");
                }
                $transaction_date = $date->format('Y-m-d'); // Pas nécessaire de reformater si on utilise le même format
            } catch (Exception $e) {
                // Traiter l'exception ou indiquer une date incorrecte
                echo $e->getMessage();
            }    
            $entity_category_id = $_POST['entity_category_id'];
            $staff_id = $_POST['staff_id'];
            $payement_method = $_POST['payement_method'];
            $reference = $_POST['reference'];
            $description = $_POST['description'];
            $transaction_type = "depot";

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $transactionsValue = '';
            for ($i = 0; $i < 15; $i++) {
                $transactionsValue .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Les lettres en majuscules et les chiffres
            $transactionsCode = '#'; // Commence par #

            for ($i = 0; $i < 6; $i++) {
                $transactionsCode .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            // TODO: Ajoutez des vérifications pour s'assurer que accountName et type sont valides.

            // Par exemple, pour vérifier si cette catégorie et ce type existent déjà, 
            // vous pourriez avoir une méthode `categoryExists($accountName, $type, $companyId)`.
            // Pour l'instant, je vais continuer sans cette vérification.

            $data = [
                'account_id' => $accountName,
                'amount' => $amount,
                'transaction_date' => $transaction_date,
                'entity_category_id' => $entity_category_id,
                'staff_id' => $staff_id,
                'payement_method' => $payement_method,
                'reference' => $reference,
                'description' => $description,
                'transaction_type' => $transaction_type,
                'transactions_value' => $transactionsValue,
                'transactions_code' => $transactionsCode,
                'company_id' => $companyId,
                'added_by' => $userId,
            ];

            $result = $this->model->addDepots($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le depot a été ajoutée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du depot."));
            }
        }
    }

    public function updateTransactions()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['transactions_id']);
        $date = $_POST['transactionDate'];
        $amount = $_POST['TransactionAmount'];

        // Formatage et validation de la date
        $parts = explode('/', $date);
        if (count($parts) === 3) {
            $date = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
        } else {
            $parts = explode('-', $date);
            if (count($parts) === 3) {
                $year = $parts[0];
                $month = $parts[1];
                $day = $parts[2];
                $date = $year . '-' . $month . '-' . $day;
            }
        }

        try {
            $dateObject = DateTime::createFromFormat('Y-m-d', $date);
            if (!$dateObject) {
                throw new Exception("Format de date invalide.");
            }
            $transaction_date = $dateObject->format('Y-m-d');
        } catch (Exception $e) {
            // Traiter l'exception ou indiquer une date incorrecte
            $response = ['status' => 400, 'msg' => $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        // Vérification de la date
        if (empty($transaction_date)) {
            $response = ['status' => 400, 'msg' => 'La date est vide, veuillez le remplir'];
        } else {
            $result = $this->model->updateTransaction($id, $transaction_date, $amount);

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



// Horaire
    public function handleAddHoraire()
    {
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

    public function handleDeleteHoraire()
    {
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

    public function updateHoraire()
    {
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
        $children = $_POST['children'];
        $spouse = $_POST['spouse'];
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
            "children" => $children,
            "spouse" => $spouse,
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
            "user_type_id" => 4,
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

            $id = intval($_POST['id_users']);
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
            $updatecountry = $_POST['updatecountry'];

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
                    $updatestatus_marital,
                    $updateemployeid,
                    $phoneupdate,
                    $updategender,
                    $updatecountry,
                    $usernameupdate,
                    $emailupdate,
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

    // payements
    public function handleAddPayments()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $userId = $user['id'];
                $companyId = $user['company_id'];
                $staffId = $_POST['id'];
            } else {
                return [];
            }

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $payslipValue = '';
            for ($i = 0; $i < 15; $i++) {
                $payslipValue .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Les lettres en majuscules et les chiffres
            $payslipCode = '#'; // Commence par #

            for ($i = 0; $i < 6; $i++) {
                $payslipCode .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $year_to_date = date('d-m-Y');
            $salary_month = date('Y-m');

            $data = [
                'payslip_value' => $payslipValue,
                'payslip_code' => $payslipCode,
                'company_id' => $companyId,
                'added_by' => $userId,
                'staff_id' => $staffId,
                'basic_salary' => $_POST['basic_salary'],
                'year_to_date' => $year_to_date,
                'salary_month' => $salary_month,
                'net_salary' => $_POST['salary_net'],

                'salary_imposable' => $_POST['salary_imposable'],
                'net_before_taxes' => $_POST['net_before_taxes'],
                'ipr' => $_POST['ipr'],
                'net_after_taxes' => $_POST['net_after_taxes'],
                'housing' => $_POST['housing'],
                'transport' => $_POST['transport'],
                'cnss' => $_POST['cnss'],
                'cnss_company' => $_POST['cnss_company'],
                'iere' => $_POST['iere'],
                'inpp' => $_POST['inpp'],
                'onem' => $_POST['onem'],
                'salary_brut_company' => $_POST['salary_brut_company'],

                'pay_comments' => $_POST['commentaire'],
                'is_payment' => 1,
            ];

            // Ici, vous feriez normalement appel à une méthode de votre modèle pour insérer les données dans la base de données.
            $result = $this->model->insertPayement($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le paiement a été ajouté avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du paiement."));
            }
        }
    }

    public function updateStatus()
    {
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

// Comptes
    public function handleAddComptes()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $userId = $user['id'];
                $companyId = $user['company_id'];
            } else {
                return [];
            }

            $accountName = $_POST['account_name'];
            $accountNumber = $_POST['account_number'];
            $accountBalance = $_POST['account_balance'];
            $bankName = strtoupper($_POST['bank_name']);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $accountValue = '';
            for ($i = 0; $i < 20; $i++) {
                $accountValue .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Les lettres en majuscules et les chiffres
            $accountCode = '#'; // Commence par #

            for ($i = 0; $i < 10; $i++) {
                $accountCode .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            // TODO: Ajoutez une validation pour chacun des champs pour s'assurer qu'ils sont correctement remplis.

            $data = [
                'account_value' => $accountValue,
                'account_code' => $accountCode,
                'account_name' => $accountName,
                'account_number' => $accountNumber,
                'account_balance' => $accountBalance,
                'account_opening_balance' => $accountBalance, // la meme valeur que account_balance
                'bank_name' => $bankName,
                'company_id' => $companyId,
                'added_by' => $userId,
            ];

            $result = $this->model->addComptes($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le compte a été ajouté avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du compte."));
            }
        }
    }

    public function handleDeleteComptes()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
            // ...

            $result = $this->model->deleteComptes($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le compte a été supprimée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression du compte"));
            }
        } else {
            echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
        }
    }

    public function updateComptes()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['account_id']);
            $compteNameUpdate = $_POST['compteNameUpdate'];
            $compteNumberUpdate = $_POST['compteNumberUpdate'];
            $compteBalanceUpdate = $_POST['compteBalanceUpdate'];
            $compteBankNameUpdate = $_POST['compteBankNameUpdate'];

            // Vérifiez si les données obligatoires ne sont pas vides
            if (empty($compteNameUpdate)) {
                $response = [
                    'status' => 400,
                    'msg' => 'Le nom du comptes est vide, veuillez le remplir',
                ];
            } else {
                // Appelez la méthode de mise à jour du département dans votre modèle ici
                $result = $this->model->updateComptes($id, $compteNameUpdate, $compteNumberUpdate, $compteBalanceUpdate, $compteBankNameUpdate);

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

// Timesheet
public function handleAddTimesheet()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_SESSION['users'])) {
            $user = $_SESSION['users'];
            $userId = $user['id'];
            $companyId = $user['company_id'];
        } else {
            return [];
        }

        $staff_id = $_POST['staff_id'];
        $timesheet_date = $_POST['timesheet_date'];
        $clock_in = $_POST['clock_in'];
        $clock_out = $_POST['clock_out'];
        $timesheet_status = "Present";

        // Formatage et validation de la date
        $parts = explode('/', $timesheet_date);
        if (count($parts) === 3) {
            $timesheet_date = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
        } else {
            $parts = explode('-', $timesheet_date);
            if (count($parts) === 3) {
                $year = $parts[0];
                $month = $parts[1];
                $day = $parts[2];
                $timesheet_date = $year . '-' . $month . '-' . $day;
            }
        }

        try {
            $dateObject = DateTime::createFromFormat('Y-m-d', $timesheet_date);
            if (!$dateObject) {
                throw new Exception("Format de date invalide.");
            }
            $timesheet_date = $dateObject->format('Y-m-d');
        } catch (Exception $e) {
            // Traiter l'exception ou indiquer une date incorrecte
            $response = ['status' => 400, 'msg' => $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

                // Convertir clock_in et clock_out en heures
        $clockInParts = explode(':', $clock_in);
        $clockOutParts = explode(':', $clock_out);

        $clockInHour = intval($clockInParts[0]);
        $clockOutHour = intval($clockOutParts[0]);

        if (strpos($clock_in, 'PM') !== false && $clockInHour != 12) {
            $clockInHour += 12;
        } elseif (strpos($clock_in, 'AM') !== false && $clockInHour == 12) {
            $clockInHour = 0;
        }

        if (strpos($clock_out, 'PM') !== false && $clockOutHour != 12) {
            $clockOutHour += 12;
        } elseif (strpos($clock_out, 'AM') !== false && $clockOutHour == 12) {
            $clockOutHour = 0;
        }

        $clockInHours = $clockInHour + intval($clockInParts[1]) / 60;
        $clockOutHours = $clockOutHour + intval($clockOutParts[1]) / 60;

        // Calculer total_work
        $total_work = $clockOutHours - $clockInHours;

        // Calculer total_rest ou total_sup
        $total_rest = 0;
        $total_sup = 0;
        $workDifference = 8 - $total_work;
        if ($workDifference > 0) {
            $total_rest = abs($workDifference);
        } else {
            $total_sup = abs($workDifference);
        }
        
        $data = [
            'staff_id' => $staff_id,
            'timesheet_date' => $timesheet_date,
            'clock_in' => $clock_in,
            'clock_out' => $clock_out,
            'timesheet_status' => $timesheet_status,
            'total_work' => intval($total_work), // converti en entier
            'total_rest' => intval($total_rest), // converti en entier
            'total_sup' => intval($total_sup),   // converti en entier
            'company_id' => $companyId,
            'added_by' => $userId,
        ];

        $result = $this->model->addTimesheet($data);

        if ($result) {
            echo json_encode(array("status" => 200, "msg" => "La presence a été ajouté avec succès."));
        } else {
            echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout."));
        }
    }
}

public function handleDeleteTimesheet()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
            // ...

            $result = $this->model->deleteTimesheet($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le compte a été supprimée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression du compte"));
            }
        } else {
            echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
        }
    }

    public function updateTimesheet()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['timesheet_id']);
        $timesheet_date = $_POST['timesheet_date_update'];
        $clock_in = $_POST['clock_in_update'];
        $clock_out = $_POST['clock_out_update'];
        $staff_id = $_POST['staff_id_update'];

        // Formatage et validation de la date
        $parts = explode('/', $timesheet_date);
        if (count($parts) === 3) {
            $timesheet_date = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
        } else {
            $parts = explode('-', $timesheet_date);
            if (count($parts) === 3) {
                $year = $parts[0];
                $month = $parts[1];
                $day = $parts[2];
                $timesheet_date = $year . '-' . $month . '-' . $day;
            }
        }

        try {
            $dateObject = DateTime::createFromFormat('Y-m-d', $timesheet_date);
            if (!$dateObject) {
                throw new Exception("Format de date invalide.");
            }
            $transaction_date = $dateObject->format('Y-m-d');
        } catch (Exception $e) {
            // Traiter l'exception ou indiquer une date incorrecte
            $response = ['status' => 400, 'msg' => $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        // Formatage et validation de la date
        $parts = explode('/', $timesheet_date);
        if (count($parts) === 3) {
            $timesheet_date = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
        } else {
            $parts = explode('-', $timesheet_date);
            if (count($parts) === 3) {
                $year = $parts[0];
                $month = $parts[1];
                $day = $parts[2];
                $timesheet_date = $year . '-' . $month . '-' . $day;
            }
        }

        try {
            $dateObject = DateTime::createFromFormat('Y-m-d', $timesheet_date);
            if (!$dateObject) {
                throw new Exception("Format de date invalide.");
            }
            $timesheet_date = $dateObject->format('Y-m-d');
        } catch (Exception $e) {
            // Traiter l'exception ou indiquer une date incorrecte
            $response = ['status' => 400, 'msg' => $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

                // Convertir clock_in et clock_out en heures
        $clockInParts = explode(':', $clock_in);
        $clockOutParts = explode(':', $clock_out);

        $clockInHour = intval($clockInParts[0]);
        $clockOutHour = intval($clockOutParts[0]);

        if (strpos($clock_in, 'PM') !== false && $clockInHour != 12) {
            $clockInHour += 12;
        } elseif (strpos($clock_in, 'AM') !== false && $clockInHour == 12) {
            $clockInHour = 0;
        }

        if (strpos($clock_out, 'PM') !== false && $clockOutHour != 12) {
            $clockOutHour += 12;
        } elseif (strpos($clock_out, 'AM') !== false && $clockOutHour == 12) {
            $clockOutHour = 0;
        }

        $clockInHours = $clockInHour + intval($clockInParts[1]) / 60;
        $clockOutHours = $clockOutHour + intval($clockOutParts[1]) / 60;

        // Calculer total_work
        $total_work = $clockOutHours - $clockInHours;

        // Calculer total_rest ou total_sup
        $total_rest = 0;
        $total_sup = 0;
        $workDifference = 8 - $total_work;
        if ($workDifference > 0) {
            $total_rest = abs($workDifference);
        } else {
            $total_sup = abs($workDifference);
        }

        $total_work = intval($total_work); // converti en entier
        $total_rest = intval($total_rest); // converti en entier
        $total_sup = intval($total_sup);

        // Vérification de la date
        if (empty($transaction_date)) {
            $response = ['status' => 400, 'msg' => 'La date est vide, veuillez le remplir'];
        } else {
            $result = $this->model->updateTimesheet($id, $staff_id, $clock_in, $clock_out, $timesheet_date, $total_work, $total_rest, $total_sup);

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
