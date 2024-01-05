<?php

class Company extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Session::init();
        $this->view->js = array("company/js/company.js");
    }

    public function all_employee()
    {
        $this->view->userc = $this->model->getAllUsersByCreatorAndCompany();
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
    public function dayoffnation()
    {
        $this->view->render('company/dayoffnation', true);
    }
    public function office_shifts()
    {
        $this->view->render('company/office_shifts', true);
    }
    public function paie()
    {
        $this->view->render('company/paie', true);
    }
    // public function history_paiement()
    // {
    //     $this->view->render('company/history_paiement', true);
    // }
    public function generate_paie_pdf()
    {
        $this->view->render('company/generate_paie_pdf', true);
    }
    public function generate_pdf()
    {
        $this->view->render('company/generate_pdf', true);
    }
    public function generate_excel()
    {
        $this->view->render('company/generate_excel', true);
    }
    public function generate_presence_pdf()
    {
        $this->view->render('company/generate_presence_pdf', true);
    }
    public function generate_presence_excel()
    {
        $this->view->render('company/generate_presence_excel', true);
    }
    public function generate_report_paie_annuel_pdf()
    {
        $this->view->render('company/generate_report_paie_annuel_pdf', true);
    }
    public function generate_report_paie_annuel_excel()
    {
        $this->view->render('company/generate_report_paie_annuel_excel', true);
    }
    public function generate_dgi_pdf()
    {
        $this->view->render('company/generate_dgi_pdf', true);
    }
    public function generate_cnss_pdf()
    {
        $this->view->render('company/generate_cnss_pdf', true);
    }
    public function invoice_paie()
    {
        $this->view->render('company/invoice_paie', true);
    }
    // public function invoice_account()
    // {
    //     // Récupérez la valeur de account_value depuis la requête GET
    //     $accountValue = isset($_GET['account_value']) ? $_GET['account_value'] : '';
    //     $this->view->render('company/invoice_account', true);
    // }

    // public function getAllAccountsByCreatorAndCompany_hack()
    // {
    //     if (isset($_POST["account_id"]) && !empty($_POST["account_id"])) {
    //         $get = $this->model->getAllAccountsByCreatorAndCompany_hack($_POST["account_id"]);
    //         if (!empty($get)) {
    //             echo json_encode(array("status" => 200, "data" => $get));
    //         } else {
    //             echo json_encode(array("status" => 500, "msg" => "error"));
    //         }
    //     }
    // }
    public function invoice_avance()
    {
        $this->view->render('company/invoice_avance', true);
    }
    // public function invoice_transaction()
    // {
    //     $this->view->render('company/invoice_transaction', true);
    // }
    // public function comptes()
    // {
    //     $this->view->render('company/comptes', true);
    // }
    // public function depenses()
    // {
    //     $this->view->render('company/depenses', true);
    // }
    // public function depots()
    // {
    //     $this->view->render('company/depots', true);
    // }
    // public function transactions()
    // {
    //     $this->view->render('company/transactions', true);
    // }
    // public function depense_depot()
    // {
    //     $this->view->render('company/depense_depot', true);
    // }
    public function timesheet()
    {
        $this->view->render('company/timesheet', true);
    }
    public function report_monthly()
    {
        $this->view->render('company/report_monthly', true);
    }
    public function avance_salaire()
    {
        $this->view->render('company/avance_salaire', true);
    }
    public function report_paie_annuel()
    {
        $this->view->render('company/report_paie_annuel', true);
    }
    public function dgi()
    {
        $this->view->render('company/dgi', true);
    }
    public function cnss()
    {
        $this->view->render('company/cnss', true);
    }
    public function onem()
    {
        $this->view->render('company/onem', true);
    }
    public function inpp()
    {
        $this->view->render('company/inpp', true);
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
            // $permissionsCompany = isset($_POST['company']) ? $_POST['company'] : [];
            // $permissionsPrivilege = isset($_POST['privilege']) ? $_POST['privilege'] : [];

            // Remplacez les caractères "_" par des espaces dans les noms des permissions
            $permissionsAdmin = array_map(function ($permission) {
                return str_replace('_', ' ', $permission);
            }, $permissionsAdmin);

            // $permissionsCompany = array_map(function($permission) {
            //     return str_replace('_', ' ', $permission);
            // }, $permissionsCompany);

            // $permissionsPrivilege = array_map(function($permission) {
            //     return str_replace('_', ' ', $permission);
            // }, $permissionsPrivilege);

            // Supprimez les valeurs "on" du tableau des permissions
            $permissionsAdmin = array_filter($permissionsAdmin, function ($permission) {
                return $permission !== 'on';
            });
            // $permissionsCompany = array_filter($permissionsCompany, function($permission) {
            //     return $permission !== 'on';
            // });
            // $permissionsPrivilege = array_filter($permissionsPrivilege, function($permission) {
            //     return $permission !== 'on';
            // });

            $permissions = array_merge($permissionsAdmin);

            $permissionsString = implode(', ', $permissions);

            // Vérifiez si le département existe déjà pour l'id de la company
            if ($this->model->roleExists($name, $companyId)) {
                echo json_encode(array("status" => 400, "msg" => "Un role avec ce nom existe déjà dans votre company."));
                return;
            }

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
                $_POST['admin'] ?? []
                // $_POST['company'] ?? [],
                // $_POST['privilege'] ?? []
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

            // Vérifiez si le département existe déjà pour l'id de la company
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
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $companyId = $user['company_id'];
            } else {
                return [];
            }
            $id = intval($_POST['department_id']);
            $departmentNameUpdate = $_POST['departmentNameUpdate'];

            // Vérifiez si le département existe déjà pour l'id de la company
            if ($this->model->departmentExists($departmentNameUpdate, $companyId)) {
                echo json_encode(array("status" => 400, "msg" => "Un département avec ce nom existe déjà."));
                return;
            }

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
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $companyId = $user['company_id'];
            } else {
                echo json_encode(array("status" => 400, "msg" => "L'utilisateur n'est pas connecté."));
                return;
            }

            $id = intval($_POST['designation_id']);
            $designationNameUpdate = $_POST['designationNameUpdate'];
            $departmentId = $_POST['department_id'];

            // Vérifiez si la designation existe déjà
            if ($this->model->designationExists($designationNameUpdate, $departmentId, $companyId)) {
                echo json_encode(array("status" => 400, "msg" => "Une designation avec ce nom existe déjà dans ce département."));
                return;
            }

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
    // public function handleAddDepExp()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         if (isset($_SESSION['users'])) {
    //             $user = $_SESSION['users'];
    //             $userId = $user['id'];
    //             $companyId = $user['company_id'];
    //         } else {
    //             echo json_encode(array("status" => 400, "msg" => "Session utilisateur non trouvée."));
    //             return;
    //         }

    //         $categoryName = $_POST['category_name'];
    //         $type = $_POST['type'];

    //         // TODO: Ajoutez des vérifications pour s'assurer que categoryName et type sont valides.

    //         // Par exemple, pour vérifier si cette catégorie et ce type existent déjà, 
    //         // vous pourriez avoir une méthode `categoryExists($categoryName, $type, $companyId)`.
    //         // Pour l'instant, je vais continuer sans cette vérification.

    //         $data = [
    //             'category_name' => $categoryName,
    //             'type' => $type,
    //             'company_id' => $companyId,
    //             'added_by' => $userId,
    //         ];

    //         $result = $this->model->addDepExp($data);

    //         if ($result) {
    //             echo json_encode(array("status" => 200, "msg" => "La catégorie a été ajoutée avec succès."));
    //         } else {
    //             echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout de la catégorie."));
    //         }
    //     }
    // }

    // public function updateDepExp()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = intval($_POST['constants_id']);
    //         $depexpNameUpdate = $_POST['depexpNameUpdate'];
    //         $constantsId = $_POST['constants_id'];

    //         if (empty($depexpNameUpdate)) {
    //             $response = ['status' => 400, 'msg' => 'Le nom de la category est vide, veuillez le remplir'];
    //         } else {
    //             $result = $this->model->updateDepExp($id, $depexpNameUpdate, $constantsId);

    //             if ($result) {
    //                 $response = ['status' => 200, 'msg' => 'Mise à jour réussie'];
    //             } else {
    //                 $response = ['status' => 409, 'msg' => 'Erreur lors de la mise à jour'];
    //             }
    //         }

    //         header('Content-Type: application/json');
    //         echo json_encode($response);
    //         exit;
    //     }
    // }

    // public function handleDeleteCategoryDepExp()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = $_POST['id'];

    //         // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
    //         // ...

    //         $result = $this->model->deleteCategoryDepExp($id);

    //         if ($result) {
    //             echo json_encode(array("status" => 200, "msg" => "L'element a été supprimée avec succès."));
    //         } else {
    //             echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'element."));
    //         }
    //     } else {
    //         echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
    //     }
    // }

    // public function handleAddDepenses()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         if (isset($_SESSION['users'])) {
    //             $user = $_SESSION['users'];
    //             $userId = $user['id'];
    //             $companyId = $user['company_id'];
    //         } else {
    //             echo json_encode(array("status" => 400, "msg" => "Session utilisateur non trouvée."));
    //             return;
    //         }

    //         $accountName = $_POST['account_name'];
    //         $amount = $_POST['amount'];
    //         try {
    //             $date = DateTime::createFromFormat('Y-m-d', $_POST['transaction_date']);
    //             if (!$date) {
    //                 throw new Exception("Format de date invalide.");
    //             }
    //             $transaction_date = $date->format('Y-m-d'); // Pas nécessaire de reformater si on utilise le même format
    //         } catch (Exception $e) {
    //             // Traiter l'exception ou indiquer une date incorrecte
    //             echo $e->getMessage();
    //         }

    //         $entity_category_id = $_POST['entity_category_id'];
    //         $staff_id = $_POST['staff_id'];
    //         $payement_method = $_POST['payement_method'];
    //         $reference = $_POST['reference'];
    //         $description = $_POST['description'];
    //         $transaction_type = "depense";

    //         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //         $transactionsValue = '';
    //         for ($i = 0; $i < 30; $i++) {
    //             $transactionsValue .= $characters[mt_rand(0, strlen($characters) - 1)];
    //         }

    //         $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Les lettres en majuscules et les chiffres
    //         $transactionsCode = '#'; // Commence par #

    //         for ($i = 0; $i < 10; $i++) {
    //             $transactionsCode .= $characters[mt_rand(0, strlen($characters) - 1)];
    //         }

    //         // TODO: Ajoutez des vérifications pour s'assurer que accountName et type sont valides.

    //         // Par exemple, pour vérifier si cette catégorie et ce type existent déjà, 
    //         // vous pourriez avoir une méthode `categoryExists($accountName, $type, $companyId)`.
    //         // Pour l'instant, je vais continuer sans cette vérification.

    //         $data = [
    //             'account_id' => $accountName,
    //             'amount' => $amount,
    //             'transaction_date' => $transaction_date,
    //             'entity_category_id' => $entity_category_id,
    //             'staff_id' => $staff_id,
    //             'payement_method' => $payement_method,
    //             'reference' => $reference,
    //             'description' => $description,
    //             'transaction_type' => $transaction_type,
    //             'transactions_value' => $transactionsValue,
    //             'transactions_code' => $transactionsCode,
    //             'company_id' => $companyId,
    //             'added_by' => $userId,
    //         ];

    //         $result = $this->model->addDepenses($data);

    //         if ($result) {
    //             echo json_encode(array("status" => 200, "msg" => "La depense a été ajoutée avec succès."));
    //         } else {
    //             echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout de la depense."));
    //         }
    //     }
    // }
    // public function handleDeleteTransactionDepExp()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = $_POST['id'];

    //         // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
    //         // ...

    //         $result = $this->model->deleteTransactionDepExp($id);

    //         if ($result) {
    //             echo json_encode(array("status" => 200, "msg" => "L'element a été supprimée avec succès."));
    //         } else {
    //             echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression de l'element."));
    //         }
    //     } else {
    //         echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
    //     }
    // }

    // public function handleAddDepots()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         if (isset($_SESSION['users'])) {
    //             $user = $_SESSION['users'];
    //             $userId = $user['id'];
    //             $companyId = $user['company_id'];
    //         } else {
    //             echo json_encode(array("status" => 400, "msg" => "Session utilisateur non trouvée."));
    //             return;
    //         }

    //         $accountName = $_POST['account_name'];
    //         $amount = $_POST['amount'];
    //         try {
    //             $date = DateTime::createFromFormat('Y-m-d', $_POST['transaction_date']);
    //             if (!$date) {
    //                 throw new Exception("Format de date invalide.");
    //             }
    //             $transaction_date = $date->format('Y-m-d'); // Pas nécessaire de reformater si on utilise le même format
    //         } catch (Exception $e) {
    //             // Traiter l'exception ou indiquer une date incorrecte
    //             echo $e->getMessage();
    //         }
    //         $entity_category_id = $_POST['entity_category_id'];
    //         $staff_id = $_POST['staff_id'];
    //         $payement_method = $_POST['payement_method'];
    //         $reference = $_POST['reference'];
    //         $description = $_POST['description'];
    //         $transaction_type = "depot";

    //         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //         $transactionsValue = '';
    //         for ($i = 0; $i < 30; $i++) {
    //             $transactionsValue .= $characters[mt_rand(0, strlen($characters) - 1)];
    //         }

    //         $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Les lettres en majuscules et les chiffres
    //         $transactionsCode = '#'; // Commence par #

    //         for ($i = 0; $i < 10; $i++) {
    //             $transactionsCode .= $characters[mt_rand(0, strlen($characters) - 1)];
    //         }

    //         // TODO: Ajoutez des vérifications pour s'assurer que accountName et type sont valides.

    //         // Par exemple, pour vérifier si cette catégorie et ce type existent déjà, 
    //         // vous pourriez avoir une méthode `categoryExists($accountName, $type, $companyId)`.
    //         // Pour l'instant, je vais continuer sans cette vérification.

    //         $data = [
    //             'account_id' => $accountName,
    //             'amount' => $amount,
    //             'transaction_date' => $transaction_date,
    //             'entity_category_id' => $entity_category_id,
    //             'staff_id' => $staff_id,
    //             'payement_method' => $payement_method,
    //             'reference' => $reference,
    //             'description' => $description,
    //             'transaction_type' => $transaction_type,
    //             'transactions_value' => $transactionsValue,
    //             'transactions_code' => $transactionsCode,
    //             'company_id' => $companyId,
    //             'added_by' => $userId,
    //         ];

    //         $result = $this->model->addDepots($data);

    //         if ($result) {
    //             echo json_encode(array("status" => 200, "msg" => "Le depot a été ajoutée avec succès."));
    //         } else {
    //             echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du depot."));
    //         }
    //     }
    // }

    // public function updateTransactions()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = intval($_POST['transactions_id']);
    //         $date = $_POST['transactionDate'];
    //         $amount = $_POST['TransactionAmount'];

    //         // Formatage et validation de la date
    //         $parts = explode('/', $date);
    //         if (count($parts) === 3) {
    //             $date = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
    //         } else {
    //             $parts = explode('-', $date);
    //             if (count($parts) === 3) {
    //                 $year = $parts[0];
    //                 $month = $parts[1];
    //                 $day = $parts[2];
    //                 $date = $year . '-' . $month . '-' . $day;
    //             }
    //         }

    //         try {
    //             $dateObject = DateTime::createFromFormat('Y-m-d', $date);
    //             if (!$dateObject) {
    //                 throw new Exception("Format de date invalide.");
    //             }
    //             $transaction_date = $dateObject->format('Y-m-d');
    //         } catch (Exception $e) {
    //             // Traiter l'exception ou indiquer une date incorrecte
    //             $response = ['status' => 400, 'msg' => $e->getMessage()];
    //             header('Content-Type: application/json');
    //             echo json_encode($response);
    //             exit;
    //         }

    //         // Vérification de la date
    //         if (empty($transaction_date)) {
    //             $response = ['status' => 400, 'msg' => 'La date est vide, veuillez le remplir'];
    //         } else {
    //             $result = $this->model->updateTransaction($id, $transaction_date, $amount);

    //             if ($result) {
    //                 $response = ['status' => 200, 'msg' => 'Mise à jour réussie'];
    //             } else {
    //                 $response = ['status' => 409, 'msg' => 'Erreur lors de la mise à jour'];
    //             }
    //         }

    //         header('Content-Type: application/json');
    //         echo json_encode($response);
    //         exit;
    //     }
    // }



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
        $poste_name = $_POST['poste'];
        $contract_start = $_POST['contract_start'];
        $contract_end = $_POST['contract_end'];
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

        // Formatage et validation de la date start
        $parts = explode('/', $contract_start);
        if (count($parts) === 3) {
            $contract_start = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
        } else {
            $parts = explode('-', $contract_start);
            if (count($parts) === 3) {
                $year = $parts[0];
                $month = $parts[1];
                $day = $parts[2];
                $contract_start = $year . '-' . $month . '-' . $day;
            }
        }

        try {
            $dateObject = DateTime::createFromFormat('Y-m-d', $contract_start);
            if (!$dateObject) {
                throw new Exception("Format de date invalide.");
            }
            $contract_start = $dateObject->format('Y-m-d');
        } catch (Exception $e) {
            // Traiter l'exception ou indiquer une date incorrecte
            $response = ['status' => 400, 'msg' => $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        // Formatage et validation de la date end
        $parts = explode('/', $contract_end);
        if (count($parts) === 3) {
            $contract_end = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
        } else {
            $parts = explode('-', $contract_end);
            if (count($parts) === 3) {
                $year = $parts[0];
                $month = $parts[1];
                $day = $parts[2];
                $contract_end = $year . '-' . $month . '-' . $day;
            }
        }

        try {
            $dateObject = DateTime::createFromFormat('Y-m-d', $contract_end);
            if (!$dateObject) {
                throw new Exception("Format de date invalide.");
            }
            $contract_end = $dateObject->format('Y-m-d');
        } catch (Exception $e) {
            // Traiter l'exception ou indiquer une date incorrecte
            $response = ['status' => 400, 'msg' => $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
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
            "poste_name" => $poste_name,
            "contract_start" => $contract_start,
            "contract_end" => $contract_end,
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
            $updateposte_name = $_POST['updateposte'];
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
                    $updateposte_name,
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
                    $idToUpdate = intval($_POST['id_users']);

                    if ($userIDInSession === $idToUpdate) {
                        $_SESSION['users']['name'] = $nameupdate;
                        $_SESSION['users']['username'] = $usernameupdate;
                        $_SESSION['users']['email'] = $emailupdate;
                        $_SESSION['users']['phone'] = $phoneupdate;
                        $_SESSION['users']['image'] = $imageFileName;
                        $_SESSION['users']['emplyee_id'] = $updateemployeid;
                        $_SESSION['users']['gender'] = $updategender;
                        $_SESSION['users']['poste_name'] = $updateposte_name;
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

            $currentYear = $_POST['year']; // Récupération de l'année de POST
            $currentMonth = $_POST['month']; // Récupération du mois de POST
            $currentDay = date('d'); // Récupération du jour

            $year_to_date = date('d-m-Y');
            $salary_month = $currentYear . '-' . $currentMonth;
            $salary_month_day = $currentYear . '-' . $currentMonth . '-' . $currentDay;

            $data = [
                'payslip_value' => $payslipValue,
                'payslip_code' => $payslipCode,
                'company_id' => $companyId,
                'added_by' => $userId,
                'staff_id' => $staffId,
                'basic_salary' => $_POST['basic_salary'],
                'year_to_date' => $year_to_date,
                'salary_month' => $salary_month,
                'salary_month_day' => $salary_month_day,
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
                
                'presents_days' => $_POST['timesheet_count'],
                'absents_days' => $_POST['absent_days'],

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
    // public function handleAddComptes()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         if (isset($_SESSION['users'])) {
    //             $user = $_SESSION['users'];
    //             $userId = $user['id'];
    //             $companyId = $user['company_id'];
    //         } else {
    //             return [];
    //         }

    //         $accountName = $_POST['account_name'];
    //         $accountNumber = $_POST['account_number'];
    //         $accountBalance = $_POST['account_balance'];
    //         $bankName = strtoupper($_POST['bank_name']);

    //         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //         $accountValue = '';
    //         for ($i = 0; $i < 20; $i++) {
    //             $accountValue .= $characters[mt_rand(0, strlen($characters) - 1)];
    //         }

    //         $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Les lettres en majuscules et les chiffres
    //         $accountCode = '#'; // Commence par #

    //         for ($i = 0; $i < 10; $i++) {
    //             $accountCode .= $characters[mt_rand(0, strlen($characters) - 1)];
    //         }

    //         // TODO: Ajoutez une validation pour chacun des champs pour s'assurer qu'ils sont correctement remplis.

    //         $data = [
    //             'account_value' => $accountValue,
    //             'account_code' => $accountCode,
    //             'account_name' => $accountName,
    //             'account_number' => $accountNumber,
    //             'account_balance' => $accountBalance,
    //             'account_opening_balance' => $accountBalance, // la meme valeur que account_balance
    //             'bank_name' => $bankName,
    //             'company_id' => $companyId,
    //             'added_by' => $userId,
    //         ];

    //         $result = $this->model->addComptes($data);

    //         if ($result) {
    //             echo json_encode(array("status" => 200, "msg" => "Le compte a été ajouté avec succès."));
    //         } else {
    //             echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du compte."));
    //         }
    //     }
    // }

    // public function handleDeleteComptes()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = $_POST['id'];

    //         // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
    //         // ...

    //         $result = $this->model->deleteComptes($id);

    //         if ($result) {
    //             echo json_encode(array("status" => 200, "msg" => "Le compte a été supprimée avec succès."));
    //         } else {
    //             echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression du compte"));
    //         }
    //     } else {
    //         echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
    //     }
    // }

    // public function updateComptes()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = intval($_POST['account_id']);
    //         $compteNameUpdate = $_POST['compteNameUpdate'];
    //         $compteNumberUpdate = $_POST['compteNumberUpdate'];
    //         $compteBalanceUpdate = $_POST['compteBalanceUpdate'];
    //         $compteBankNameUpdate = $_POST['compteBankNameUpdate'];

    //         // Vérifiez si les données obligatoires ne sont pas vides
    //         if (empty($compteNameUpdate)) {
    //             $response = [
    //                 'status' => 400,
    //                 'msg' => 'Le nom du comptes est vide, veuillez le remplir',
    //             ];
    //         } else {
    //             // Appelez la méthode de mise à jour du département dans votre modèle ici
    //             $result = $this->model->updateComptes($id, $compteNameUpdate, $compteNumberUpdate, $compteBalanceUpdate, $compteBankNameUpdate);

    //             if ($result) {
    //                 $response = [
    //                     'status' => 200,
    //                     'msg' => 'Mise à jour réussie',
    //                 ];
    //             } else {
    //                 $response = [
    //                     'status' => 409,
    //                     'msg' => 'Erreur lors de la mise à jour',
    //                 ];
    //             }
    //         }

    //         header('Content-Type: application/json');
    //         echo json_encode($response);
    //         exit;
    //     }
    // }

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

            // Obtenez l'office_shift_id de l'employé
            $officeShiftId = $this->model->getOfficeShiftIdByStaffId($staff_id);

            // Obtenez les détails de l'office_shift
            $officeShiftDetailsArray = $this->model->getOfficeShiftDetailsById($officeShiftId);

            $officeShiftDetails = $officeShiftDetailsArray[0];

            // Déterminez le jour de la semaine de la timesheet_date
            $dayOfWeek = strtolower(date('l', strtotime($timesheet_date))); // 'monday', 'tuesday', etc.
            // Obtenez les heures d'arrivée et de départ prévues pour ce jour
            function convertTo24HourFormat($time)
            {
                return date("H:i", strtotime($time));
            }

            $expectedInTime = convertTo24HourFormat($officeShiftDetails[$dayOfWeek . '_in_time']);
            $expectedOutTime = convertTo24HourFormat($officeShiftDetails[$dayOfWeek . '_out_time']);

            $clock_in_24hour = convertTo24HourFormat($clock_in);
            $clock_out_24hour = convertTo24HourFormat($clock_out);

            // Comparaison pour l'entrée
            $status_enter = '';
            if ($clock_in_24hour < $expectedInTime) {
                $status_enter = 'en avance';
            } elseif ($clock_in_24hour > $expectedInTime) {
                $status_enter = 'en retard';
            } else {
                $status_enter = 'a l\'heure';
            }

            // Comparaison pour la sortie
            $status_out = '';
            if ($clock_out_24hour < $expectedOutTime) {
                $status_out = 'en avance';
            } elseif ($clock_out_24hour > $expectedOutTime) {
                $status_out = 'apres l\'heure';
            } else {
                $status_out = 'a l\'heure';
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

            $data = [
                'staff_id' => $staff_id,
                'timesheet_date' => $timesheet_date,
                'clock_in' => $clock_in,
                'clock_out' => $clock_out,
                'timesheet_status' => $timesheet_status,
                'status_enter' => $status_enter,
                'status_out' => $status_out,
                'total_work' => intval($total_work),
                'total_rest' => intval($total_rest),
                'total_sup' => intval($total_sup),
                'company_id' => $companyId,
                'added_by' => $userId,
            ];

            $existingTimesheet = $this->model->getTimesheetByStaffAndDate($staff_id, $timesheet_date);
            if ($existingTimesheet) {
                echo json_encode(array("status" => 400, "msg" => "Un enregistrement existe déjà pour cet employé à cette date."));
                exit;
            }

            $result = $this->model->addTimesheet($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "La presence a été ajouté avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout."));
            }
        }
    }

    public function getOfficeShiftDetailsPresence()
    {
        if (isset($_GET['staffId'])) {
            $staffId = $_GET['staffId'];
            $officeShiftId = $this->model->getOfficeShiftIdByStaffId($staffId);
            $officeShiftDetails = $this->model->getOfficeShiftDetailsById($officeShiftId);
            echo json_encode($officeShiftDetails);
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

            // Obtenez l'office_shift_id de l'employé
            $officeShiftId = $this->model->getOfficeShiftIdByStaffId($staff_id);

            // Obtenez les détails de l'office_shift
            $officeShiftDetailsArray = $this->model->getOfficeShiftDetailsById($officeShiftId);

            $officeShiftDetails = $officeShiftDetailsArray[0];

            // Déterminez le jour de la semaine de la timesheet_date
            $dayOfWeek = strtolower(date('l', strtotime($timesheet_date))); // 'monday', 'tuesday', etc.
            // Obtenez les heures d'arrivée et de départ prévues pour ce jour
            function convertTo24HourFormat($time)
            {
                return date("H:i", strtotime($time));
            }

            $expectedInTime = convertTo24HourFormat($officeShiftDetails[$dayOfWeek . '_in_time']);
            $expectedOutTime = convertTo24HourFormat($officeShiftDetails[$dayOfWeek . '_out_time']);

            $clock_in_24hour = convertTo24HourFormat($clock_in);
            $clock_out_24hour = convertTo24HourFormat($clock_out);

            // Comparaison pour l'entrée
            $status_enter = '';
            if ($clock_in_24hour < $expectedInTime) {
                $status_enter = 'en avance';
            } elseif ($clock_in_24hour > $expectedInTime) {
                $status_enter = 'en retard';
            } else {
                $status_enter = 'a l\'heure';
            }

            // Comparaison pour la sortie
            $status_out = '';
            if ($clock_out_24hour < $expectedOutTime) {
                $status_out = 'en avance';
            } elseif ($clock_out_24hour > $expectedOutTime) {
                $status_out = 'apres l\'heure';
            } else {
                $status_out = 'a l\'heure';
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

            $total_work = intval($total_work);
            $total_rest = intval($total_rest);
            $total_sup = intval($total_sup);

            $existingTimesheet = $this->model->getTimesheetByStaffAndDateAndClockInOut($staff_id, $timesheet_date, $clock_in, $clock_out);
            if ($existingTimesheet) {
                echo json_encode(array("status" => 400, "msg" => "Un enregistrement existe déjà pour cet employé à cette date au memes heures."));
                exit;
            }

            // Vérification de la date
            if (empty($transaction_date)) {
                $response = ['status' => 400, 'msg' => 'La date est vide, veuillez le remplir'];
            } else {
                $result = $this->model->updateTimesheet($id, $staff_id, $clock_in, $clock_out, $timesheet_date, $total_work, $total_rest, $total_sup, $status_enter, $status_out);

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

    // Avance sur salaire
    public function handleAddavanceSalaire()
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

            $advance_amount = $_POST['advance_amount'];
            try {
                $date = DateTime::createFromFormat('Y-m-d', $_POST['month_year']);
                if (!$date) {
                    throw new Exception("Format de date invalide.");
                }
                $month_year = $date->format('Y-m'); // Pas nécessaire de reformater si on utilise le même format
            } catch (Exception $e) {
                // Traiter l'exception ou indiquer une date incorrecte
                echo $e->getMessage();
            }
            $staff_id = $_POST['staff_id'];
            $paiement_type = $_POST['paiement_type'];
            $avance_reference = $_POST['avance_reference'];
            $description = $_POST['description'];

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $AvanceValue = '';
            for ($i = 0; $i < 30; $i++) {
                $AvanceValue .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Les lettres en majuscules et les chiffres
            $AvanceCode = '#'; // Commence par #

            for ($i = 0; $i < 10; $i++) {
                $AvanceCode .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            // TODO: Ajoutez des vérifications pour s'assurer que accountName et type sont valides.

            // Par exemple, pour vérifier si cette catégorie et ce type existent déjà, 
            // vous pourriez avoir une méthode `categoryExists($accountName, $type, $companyId)`.
            // Pour l'instant, je vais continuer sans cette vérification.

            $data = [
                'advance_amount' => $advance_amount,
                'month_year' => $month_year,
                'staff_id' => $staff_id,
                'paiement_type' => $paiement_type,
                'avance_reference' => $avance_reference,
                'description' => $description,
                'avance_value' => $AvanceValue,
                'avance_code' => $AvanceCode,
                'company_id' => $companyId,
                'added_by' => $userId,
            ];

            $basicSalary = $this->model->getBasicSalary($staff_id);
            if ($advance_amount > $basicSalary * 0.6) { // Exemple : Limite à 50% du salaire de base
                echo json_encode(array("status" => 400, "msg" => "Demande d'avance sur salaire trop élevée par rapport au 60% du salaire de base."));
                return;
            }

            $result = $this->model->addAvanceSalaire($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le depot a été ajoutée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout du depot."));
            }
        }
    }

    public function handleDeleteAvanceSalaire()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            // Sécurité supplémentaire : vérifier que l'utilisateur a les droits pour supprimer une entreprise
            // ...

            $result = $this->model->deleteAvanceSalaire($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le compte a été supprimée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression du compte"));
            }
        } else {
            echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
        }
    }

    public function updateAvanceSalaire()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['advanced_salary_id']);
            $updatemonth_year = $_POST['updatemonth_year'];
            $updatestaff_id = $_POST['updatestaff_id'];
            $updateadvance_amount = $_POST['updateadvance_amount'];
            $updatepaiement_type = $_POST['updatepaiement_type'];
            $updateavance_reference = $_POST['updateavance_reference'];
            $updatedescription = $_POST['updatedescription'];

            // Formatage et validation de la updatemonth_year
            $parts = explode('/', $updatemonth_year);
            if (count($parts) === 3) {
                $updatemonth_year = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
            } else {
                $parts = explode('-', $updatemonth_year);
                if (count($parts) === 3) {
                    $year = $parts[0];
                    $month = $parts[1];
                    $day = $parts[2];
                    $updatemonth_year = $year . '-' . $month . '-' . $day;
                }
            }

            // Formatage et validation de la updatemonth_year
            try {
                if (preg_match('/^\d{4}-\d{2}$/', $updatemonth_year)) {
                    // Si le format est YYYY-MM, ajoutez le premier jour du mois
                    $updatemonth_year = $updatemonth_year . '-01';
                }

                $date = DateTime::createFromFormat('Y-m-d', $updatemonth_year);
                if (!$date) {
                    throw new Exception("Format de date invalide.");
                }
                $updatemonth_year = $date->format('Y-m'); // Pas nécessaire de reformater si on utilise le même format
            } catch (Exception $e) {
                // Traiter l'exception ou indiquer une date incorrecte
                echo json_encode(array("status" => 400, "msg" => $e->getMessage()));
                return;
            }

            if ($this->model->isPaymentDoneForMonth($updatestaff_id, $updatemonth_year)) {
                echo json_encode(array("status" => 400, "msg" => "Un paiement a déjà été effectué pour ce mois. La mise à jour de l'avance n'est pas autorisée."));
                return;
            }

            // $basicSalary = $this->model->getBasicSalary($updatestaff_id);
            // if ($updateadvance_amount > $basicSalary * 0.6) { // Exemple : Limite à 50% du salaire de base
            //     echo json_encode(array("status" => 400, "msg" => "Demande d'avance sur salaire trop élevée par rapport au 60% du salaire de base."));
            //     return;
            // }

            // Vérification de la date
            if (empty($updatemonth_year)) {
                $response = ['status' => 400, 'msg' => 'La date est vide, veuillez le remplir'];
            } else {
                $result = $this->model->updateAvanceSalaire($id, $updatemonth_year, $updateadvance_amount, $updatestaff_id, $updatepaiement_type, $updateavance_reference, $updatedescription);

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

    public function report_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];

            $selectedUserIds = isset($_GET['users']) ? explode(',', $_GET['users']) : null;

            $companyModel = new company_model();
            $userscompany = $selectedUserIds ? $companyModel->getAllUsersIdByCreatorAndCompany($selectedUserIds) : $companyModel->getAllUsersByCreatorAndCompany();

            // Générez le HTML du tableau avec les nouvelles données
            foreach ($userscompany as $user) {
                foreach ($userscompany as $user) {
                    // Récupération des données de paiement pour l'employé courant pour l'année sélectionnée
                    $paymentData = $companyModel->getAllPayementCurrentYearByCreatorAndCompanyFiltered($user['id'], $currentYear);

                    echo '<tr class="nk-tb-item odd">';
                    echo '<td class="nk-tb-col tb-col-mb">';
                    echo '<div class="col">';
                    echo '<div class="custom-control custom-control-sm custom-checkbox notext">';
                    echo '<input type="checkbox" class="custom-control-input user-checkbox" value="' . htmlspecialchars($user['id']) . '" id="user' . htmlspecialchars($user['id']) . '">';
                    echo '<label class="custom-control-label" for="user' . htmlspecialchars($user['id']) . '"></label>';
                    echo '</div>';
                    echo '</div>';
                    echo '<span class="tb-amount">' . htmlspecialchars($user['name']) . '</span>';
                    echo '</td>';


                    // Parcourir chaque mois de l'année
                    for ($month = 1; $month <= 12; $month++) {
                        $netSalary = array_key_exists($month, $paymentData) ? $paymentData[$month] : '-';
                        echo '<td class="nk-tb-col">' . htmlspecialchars($netSalary) . " $" . '</td>';
                    }
                    echo '</tr>';
                }
                exit;
            }
            exit;
        }
    }

    public function report_paie_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentMonth = $_POST['month']; // Mois sélectionné par l'utilisateur
            $currentYear = $_POST['year']; // Année sélectionnée par l'utilisateur

            $selectedUserIds = isset($_GET['users']) ? explode(',', $_GET['users']) : null;

            $companyModel = new company_model();
            $userscompany = $selectedUserIds ? $companyModel->getAllUsersIdByCreatorAndCompany($selectedUserIds) : $companyModel->getAllUsersByCreatorAndCompany();
            $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

            // Générer le HTML pour l'entête du tableau
            $thead = '<thead>
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col">Jours</th>';
            for ($i = 1; $i <= $daysInCurrentMonth; $i++) {
                $thead .= '<th class="nk-tb-col">' . $i . '</th>';
            }
            $thead .= '</tr><tr class="nk-tb-item nk-tb-head">
                <th class="nk-tb-col">Employeur</th>';

            foreach (range(1, $daysInCurrentMonth) as $day) {
                $date = new DateTime("$currentYear-$currentMonth-$day");
                $formatter = new IntlDateFormatter(
                    'fr_FR',
                    IntlDateFormatter::FULL,
                    IntlDateFormatter::NONE,
                    'Europe/Paris',
                    IntlDateFormatter::GREGORIAN,
                    'E' // Format pour le jour de la semaine abrégé
                );
                $dayOfWeek = $formatter->format($date);
                $thead .= '<th class="nk-tb-col">' . $dayOfWeek . '</th>';
            }
            $thead .= '</tr></thead>';

            // Commencer le HTML pour le corps du tableau
            $tbody = '<tbody>';

            foreach ($userscompany as $user) {
                // Récupération des données pour l'employé pour le mois en cours et pour l'année sélectionnée
                $timesheetData = $companyModel->getCurrentMonthTimesheetsByCreatorAndCompanyFiltered($user['id'], $currentMonth, $currentYear);
                $timesheetDays = $timesheetData['days'];
                $officeShift = $timesheetData['officeShift'];
                $tbody .= '<tr class="nk-tb-item odd">';
                $tbody .= '<td class="nk-tb-col tb-col-mb">';
                $tbody .= '<div class="col">';
                $tbody .= '<div class="custom-control custom-control-sm custom-checkbox notext">';
                $tbody .= '<input type="checkbox" class="custom-control-input user-checkbox" value="' . htmlspecialchars($user['id']) . '" id="user' . htmlspecialchars($user['id']) . '">';
                $tbody .= '<label class="custom-control-label" for="user' . htmlspecialchars($user['id']) . '"></label>';
                $tbody .= '</div>';
                $tbody .= '</div>';
                $tbody .= '<span class="tb-amount">' . htmlspecialchars($user['name']) . '</span>';
                $tbody .= '</td>';


                for ($i = 1; $i <= $daysInCurrentMonth; $i++) {
                    $dayKeyIn = strtolower(date('l', strtotime("$currentYear-$currentMonth-$i"))) . '_in_time';
                    $dayKeyOut = strtolower(date('l', strtotime("$currentYear-$currentMonth-$i"))) . '_out_time';

                    $presence = '<span class="badge badge-dim bg-danger">A</span>'; // Par défaut Absent
                    if (isset($timesheetDays[$i]) && $timesheetDays[$i] == 'P') {
                        $presence = '<span class="badge badge-dim bg-success">P</span>'; // Présent
                    } elseif (isset($officeShift[$dayKeyIn]) && empty($officeShift[$dayKeyIn]) && isset($officeShift[$dayKeyOut]) && empty($officeShift[$dayKeyOut])) {
                        $presence = '<span class="badge badge-dim bg-primary">O</span>'; // Office
                    }
                    $tbody .= '<td class="nk-tb-col">' . $presence . '</td>';
                }
                $tbody .= '</tr>';
            }
            $tbody .= '</tbody>';

            // Envoyer l'ensemble du HTML (entête + corps) comme réponse
            echo $thead . $tbody;
            exit;
        }
    }

    public function updateTable()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $searchUsername = $_POST['username'] ?? '';

            $companyModel = new company_model();

            // Si un nom d'utilisateur est fourni, filtrez par ce nom
            if (!empty($searchUsername)) {
                // Assurez-vous que cette méthode renvoie les utilisateurs dont le nom correspond à $searchUsername
                $userscompany = $companyModel->getUsersByName($searchUsername, $currentYear);
            } else {
                $userscompany = $companyModel->getAllUsersByCreatorAndCompany();
            }

            // Vérifier si $userscompany est vide
            if (empty($userscompany)) {
                echo '<tr class="nk-tb-item odd"><td colspan="13" class="nk-tb-col">Aucun utilisateur trouvé.</td></tr>'; // Assurez-vous que le colspan correspond au nombre de colonnes de votre tableau
                exit;
            }

            // Générez le HTML du tableau avec les nouvelles données
            foreach ($userscompany as $user) {
                // Récupération des données de paiement pour l'employé courant pour l'année sélectionnée
                $paymentData = $companyModel->getAllPayementCurrentYearByCreatorAndCompany($user['id'], $currentYear);

                echo '<tr class="nk-tb-item odd">';
                echo '<td class="nk-tb-col tb-col-mb">' . htmlspecialchars($user['name']) . '</td>';

                for ($month = 1; $month <= 12; $month++) {
                    $netSalary = array_key_exists($month, $paymentData) ? $paymentData[$month] : '-';
                    echo '<td class="nk-tb-col">' . htmlspecialchars($netSalary) . " $" . '</td>';
                }
                echo '</tr>';
            }
            exit;
        }
    }

    public function paiement_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            // Commencer le HTML pour le corps du tableau
            $tbody = '<tbody>';

            foreach ($userc as $usercomp) {
                // Générer chaque ligne du tableau pour les utilisateurs
                $tbody .= '<tr class="nk-tb-item odd">';
                $tbody .= '<td class="nk-tb-col"><div class="user-card"><div class="user-info"><span class="tb-lead">' . $usercomp['num'] . '<span class="d-md-none ms-1"></span></span></div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><div class="user-toggle"><div class="user-avatar sm">';
                if (isset($usercomp['image']) && !empty($usercomp['image'])) {
                    $tbody .= '<img src="' . $usercomp['image'] . '" alt="User Avatar">';
                    if ($usercomp['is_logged_in'] == 1) {
                        $tbody .= '<div class="status dot dot-lg dot-success"></div>';
                    } else {
                        $tbody .= '<div class="status dot dot-lg dot-danger"></div>';
                    }
                } else {
                    $tbody .= '<em class="icon ni ni-user-alt"></em>';
                }
                $tbody .= '</div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-mb"><span class="tb-amount">' . $usercomp['name'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['emplyee_id'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['basic_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md">';
                if (isset($usercomp['payed']) && $usercomp['payed'] == 1 && $usercomp['salary_month'] == $currentYear . "-" . $currentMonth) {
                    $tbody .= '<span class="badge badge-dim bg-success">Payé</span>';
                } else {
                    $tbody .= '<span class="badge badge-dim bg-danger">Non Payé</span>';
                }
                $tbody .= '</td>';

                // Ajout de la colonne pour les actions
                $tbody .= '<td class="nk-tb-col nk-tb-col-tools"><ul class="nk-tb-actions gx-1">';
                $tbody .= '<li><div class="drodown"><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>';
                $tbody .= '<div class="dropdown-menu dropdown-menu-end"><ul class="link-list-opt no-bdr">';
                if (isset($usercomp['payed']) && $usercomp['payed'] == 1 && $usercomp['salary_month'] == $currentYear . "-" . $currentMonth) {
                    $tbody .= '<a href="#" class="facture_button_usercomp" 
                    data-id="' . $usercomp['id'] . '" 
                    data-name="' . $usercomp['name'] . '" 
                    data-address="' . $usercomp['address'] . '" 
                    data-phone="' . $usercomp['phone'] . '" 
                    data-created_at="' . $usercomp['created_at'] . '" 
                    data-basic_salary="' . $usercomp['basic_salary'] . '" 
                    data-total_time="' . $usercomp['total_time'] . '" 
                    data-country="' . $usercomp['country'] . '" 
                    data-payslip_value="' . $usercomp['payslip_value'] . '" 
                    data-payslip_code="' . $usercomp['payslip_code'] . '" 
                    data-salary_month="' . $usercomp['salary_month'] . '" 
                    data-year_to_date="' . $usercomp['year_to_date'] . '" 
                    data-net_salary="' . $usercomp['net_salary'] . '" 
                    data-housing="' . $usercomp['housing'] . '" 
                    data-transport="' . $usercomp['transport'] . '" 
                    data-net_after_taxes="' . $usercomp['net_after_taxes'] . '" 
                    data-advance_salary="' . $usercomp['advanced_salary'] . '" 
                    data-department="' . $usercomp['department'] . '" 
                    data-designation="' . $usercomp['designation'] . '" 
                    data-contract_start="' . $usercomp['contract_start'] . '" 
                    data-contract_type="' . $usercomp['contract_type'] . '" 
                    data-marital_status="' . $usercomp['marital_status'] . '" 
                    data-poste_name="' . $usercomp['poste_name'] . '" 
                    data-children="' . $usercomp['children'] . '" 
                    data-cnss_employee="' . $usercomp['cnss_employee'] . '" 
                    data-cnss_company="' . $usercomp['cnss_company'] . '" 
                    data-emplyee_id="' . $usercomp['emplyee_id'] . '" 
                    data-bank_name="' . $usercomp['bank_name'] . '" 
                    data-bank_number="' . $usercomp['bank_number'] . '" 
                    data-presents_days="' . $usercomp['presents_days'] . '" 
                    data-ipr="' . $usercomp['ipr'] . '" 
                    data-inpp="' . $usercomp['inpp'] . '" 
                    data-onem="' . $usercomp['onem'] . '" 
                    data-net_before_taxes="' . $usercomp['net_before_taxes'] . '" 
                    data-salary_imposable="' . $usercomp['salary_imposable'] . '" 
                    data-absents_days="' . $usercomp['absents_days'] . '"><em class="icon ni ni-file-text"></em><span>Voir Facture</span></a>';
                } else {
                    $tbody .= '<a href="#" class="paye_button_usercomp" data-id="' . $usercomp['id'] . '" data-basic_salary="' . $usercomp['basic_salary'] . '" data-total_time="' . $usercomp['total_time'] . '" data-children="' . $usercomp['children'] . '" data-spouse="' . $usercomp['spouse'] . '" data-advanced_salary="' . $usercomp['advanced_salary'] . '" data-timesheet_count="' . $usercomp['timesheet_count'] . '" data-country="' . $usercomp['country'] . '"><em class="icon ni ni-money"></em><span>Payer</span></a>';
                }
                $tbody .= '</ul></div></div></li></ul></td>';

                $tbody .= '</tr>';
            }

            $tbody .= '</tbody>';

            // Envoyer le HTML généré comme réponse
            echo $tbody;
            exit;
        }
    }

    public function dgi_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            // Commencer le HTML pour le corps du tableau
            $tbody = '<tbody>';

            foreach ($userc as $usercomp) {
                // Générer chaque ligne du tableau pour les utilisateurs
                $tbody .= '<tr class="nk-tb-item odd">';
                $tbody .= '<td class="nk-tb-col"><div class="user-card"><div class="user-info"><span class="tb-lead">' . $usercomp['num'] . '<span class="d-md-none ms-1"></span></span></div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><div class="user-toggle"><div class="user-avatar sm">';
                if (isset($usercomp['image']) && !empty($usercomp['image'])) {
                    $tbody .= '<img src="' . $usercomp['image'] . '" alt="User Avatar">';
                    if ($usercomp['is_logged_in'] == 1) {
                        $tbody .= '<div class="status dot dot-lg dot-success"></div>';
                    } else {
                        $tbody .= '<div class="status dot dot-lg dot-danger"></div>';
                    }
                } else {
                    $tbody .= '<em class="icon ni ni-user-alt"></em>';
                }
                $tbody .= '</div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-mb"><span class="tb-amount">' . $usercomp['name'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['emplyee_id'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['basic_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['net_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['ipr'] . '</span></td>';

                $tbody .= '</tr>';
            }

            $tbody .= '</tbody>';

            // Envoyer le HTML généré comme réponse
            echo $tbody;
            exit;
        }
    }
    public function cnss_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            // Commencer le HTML pour le corps du tableau
            $tbody = '<tbody>';

            foreach ($userc as $usercomp) {
                // Générer chaque ligne du tableau pour les utilisateurs
                $tbody .= '<tr class="nk-tb-item odd">';
                $tbody .= '<td class="nk-tb-col"><div class="user-card"><div class="user-info"><span class="tb-lead">' . $usercomp['num'] . '<span class="d-md-none ms-1"></span></span></div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><div class="user-toggle"><div class="user-avatar sm">';
                if (isset($usercomp['image']) && !empty($usercomp['image'])) {
                    $tbody .= '<img src="' . $usercomp['image'] . '" alt="User Avatar">';
                    if ($usercomp['is_logged_in'] == 1) {
                        $tbody .= '<div class="status dot dot-lg dot-success"></div>';
                    } else {
                        $tbody .= '<div class="status dot dot-lg dot-danger"></div>';
                    }
                } else {
                    $tbody .= '<em class="icon ni ni-user-alt"></em>';
                }
                $tbody .= '</div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-mb"><span class="tb-amount">' . $usercomp['name'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['emplyee_id'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['basic_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['net_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['cnss'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['cnss_company'] . '</span></td>';

                $tbody .= '</tr>';
            }

            $tbody .= '</tbody>';

            // Envoyer le HTML généré comme réponse
            echo $tbody;
            exit;
        }
    }
    public function inpp_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            // Commencer le HTML pour le corps du tableau
            $tbody = '<tbody>';

            foreach ($userc as $usercomp) {
                // Générer chaque ligne du tableau pour les utilisateurs
                $tbody .= '<tr class="nk-tb-item odd">';
                $tbody .= '<td class="nk-tb-col"><div class="user-card"><div class="user-info"><span class="tb-lead">' . $usercomp['num'] . '<span class="d-md-none ms-1"></span></span></div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><div class="user-toggle"><div class="user-avatar sm">';
                if (isset($usercomp['image']) && !empty($usercomp['image'])) {
                    $tbody .= '<img src="' . $usercomp['image'] . '" alt="User Avatar">';
                    if ($usercomp['is_logged_in'] == 1) {
                        $tbody .= '<div class="status dot dot-lg dot-success"></div>';
                    } else {
                        $tbody .= '<div class="status dot dot-lg dot-danger"></div>';
                    }
                } else {
                    $tbody .= '<em class="icon ni ni-user-alt"></em>';
                }
                $tbody .= '</div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-mb"><span class="tb-amount">' . $usercomp['name'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['emplyee_id'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['basic_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['net_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['inpp'] . '</span></td>';

                $tbody .= '</tr>';
            }

            $tbody .= '</tbody>';

            // Envoyer le HTML généré comme réponse
            echo $tbody;
            exit;
        }
    }
    public function onem_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            // Commencer le HTML pour le corps du tableau
            $tbody = '<tbody>';

            foreach ($userc as $usercomp) {
                // Générer chaque ligne du tableau pour les utilisateurs
                $tbody .= '<tr class="nk-tb-item odd">';
                $tbody .= '<td class="nk-tb-col"><div class="user-card"><div class="user-info"><span class="tb-lead">' . $usercomp['num'] . '<span class="d-md-none ms-1"></span></span></div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><div class="user-toggle"><div class="user-avatar sm">';
                if (isset($usercomp['image']) && !empty($usercomp['image'])) {
                    $tbody .= '<img src="' . $usercomp['image'] . '" alt="User Avatar">';
                    if ($usercomp['is_logged_in'] == 1) {
                        $tbody .= '<div class="status dot dot-lg dot-success"></div>';
                    } else {
                        $tbody .= '<div class="status dot dot-lg dot-danger"></div>';
                    }
                } else {
                    $tbody .= '<em class="icon ni ni-user-alt"></em>';
                }
                $tbody .= '</div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-mb"><span class="tb-amount">' . $usercomp['name'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['emplyee_id'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['basic_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['net_salary'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['onem'] . '</span></td>';

                $tbody .= '</tr>';
            }

            $tbody .= '</tbody>';

            // Envoyer le HTML généré comme réponse
            echo $tbody;
            exit;
        }
    }
    public function presence_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];
            $currentDay = $_POST['day'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllTimesheetsByCreatorAndCompanyYearMonthDay($currentYear, $currentMonth, $currentDay);

            // Commencer le HTML pour le corps du tableau
            $tbody = '<tbody>';

            foreach ($userc as $usercomp) {

                $formattedDate = '';

                try {
                    $date = DateTime::createFromFormat('Y-m-d', $usercomp['timesheet_date']);
                    $formatter = new IntlDateFormatter(
                        'fr_FR',
                        IntlDateFormatter::FULL,
                        IntlDateFormatter::NONE,
                        'Europe/Paris',
                        IntlDateFormatter::GREGORIAN
                    );
                    $formatter->setPattern('EEEE dd MMMM yyyy');
                    $formattedDate = $formatter->format($date);
                } catch (Exception $e) {
                    // En cas d'erreur, utiliser la date non formatée
                    $formattedDate = $usercomp['timesheet_date'];
                }

                $clockIn = DateTime::createFromFormat('h:i A', $usercomp['clock_in']);
                $formattedClockIn = $clockIn ? $clockIn->format('H:i') : $usercomp['clock_in'];

                $clockOut = DateTime::createFromFormat('h:i A', $usercomp['clock_out']);
                $formattedclockOut = $clockOut ? $clockOut->format('H:i') : $usercomp['clock_out'];

                $statusenterClass = '';
    if ($usercomp['status_enter'] === 'en avance') {
        $statusenterClass = 'bg-warning';
    } elseif ($usercomp['status_enter'] === 'en retard') {
        $statusenterClass = 'bg-danger';
    } else {
        $statusenterClass = 'bg-success';
    }
                $statusoutClass = '';
    if ($usercomp['status_out'] === 'en avance') {
        $statusoutClass = 'bg-danger';
    } elseif ($usercomp['status_out'] === 'apres l\'heure') {
        $statusoutClass = 'bg-warning';
    } else {
        $statusoutClass = 'bg-success';
    }

                // Générer chaque ligne du tableau pour les utilisateurs
                $tbody .= '<tr class="nk-tb-item odd">';
                $tbody .= '<td class="nk-tb-col">
                <div class="user-card">
                <div class="user-info">
                <span class="tb-lead">' . $usercomp['num'] . '<span class="d-md-none ms-1"></span></span></div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md">
                <div class="user-toggle">
                <div class="user-avatar sm">';
                if (isset($usercomp['staff_image']) && !empty($usercomp['staff_image'])) {
                    $tbody .= '<img src="' . $usercomp['staff_image'] . '" alt="User Avatar">';
                }
                $tbody .= '</div></div></td>';
                $tbody .= '<td class="nk-tb-col tb-col-mb"><span class="tb-amount">' . $usercomp['staff_name'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $formattedDate . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $formattedClockIn . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $formattedclockOut . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span class="badge badge-dim bg-success">' . $usercomp['timesheet_status'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span class="badge badge-dim '. $statusenterClass .'">' . $usercomp['status_enter'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span class="badge badge-dim '. $statusoutClass .'">' . $usercomp['status_out'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col tb-col-md"><span>' . $usercomp['total_work'] . '</span></td>';
                $tbody .= '<td class="nk-tb-col nk-tb-col-tools">
        <ul class="nk-tb-actions gx-1">
            <li>
                <div class="drodown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                        <em class="icon ni ni-more-h"></em>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <ul class="link-list-opt no-bdr">
                            <li>
                                <a href="#" class="delete-button-timesheet" data-id="' . $usercomp['timesheet_id'] . '">
                                    <em class="icon ni ni-trash"></em>
                                    <span>Supprimer</span>
                                </a>
                                <a href="#" class="update_button_timesheet" data-id="' . $usercomp['timesheet_id'] . '" data-timesheet_date="' . $usercomp['timesheet_date'] . '" data-timesheet_clockin="' . $usercomp['clock_in'] . '" data-timesheet_clockout="' . $usercomp['clock_out'] . '" data-timesheet_staffid="' . $usercomp['staff_id'] . '">
                                    <em class="icon ni ni-pen"></em>
                                    <span>Modifier</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </td>';

                $tbody .= '</tr>';
            }

            $tbody .= '</tbody>';

            // Envoyer le HTML généré comme réponse
            echo $tbody;
            exit;
        }
    }

    public function dgi_searchData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            $data = [];
            foreach ($userc as $usercomp) {
                $data[] = [
                    'name' => $usercomp['name'],
                    'employee_id' => $usercomp['emplyee_id'],
                    'basic_salary' => $usercomp['basic_salary'],
                    'net_salary' => $usercomp['net_salary'] ?? '0',
                    'ipr' => $usercomp['ipr'] ?? '0'
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
    }
    public function presence_searchData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];
            $currentDay = $_POST['day'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllTimesheetsByCreatorAndCompanyYearMonthDay($currentYear, $currentMonth, $currentDay);

            $data = [];
            foreach ($userc as $usercomp) {
                $data[] = [
                    'num' => $usercomp['num'],
                    'staff_image' => $usercomp['staff_image'],
                    'staff_name' => $usercomp['staff_name'],
                    'timesheet_date' => $usercomp['timesheet_date'],
                    'clock_in' => $usercomp['clock_in'],
                    'clock_out' => $usercomp['clock_out'],
                    'timesheet_status' => $usercomp['timesheet_status'],
                    'status_enter' => $usercomp['status_enter'],
                    'status_out' => $usercomp['status_out'],
                    'is_logged_in' => $usercomp['is_logged_in'],
                    'total_work' => $usercomp['total_work']
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
    }
    public function cnss_searchData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            $data = [];
            foreach ($userc as $usercomp) {
                $data[] = [
                    'name' => $usercomp['name'],
                    'employee_id' => $usercomp['emplyee_id'],
                    'basic_salary' => $usercomp['basic_salary'],
                    'net_salary' => $usercomp['net_salary'] ?? '0',
                    'ipr' => $usercomp['cnss'] ?? '0'
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
    }
    public function inpp_searchData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            $data = [];
            foreach ($userc as $usercomp) {
                $data[] = [
                    'name' => $usercomp['name'],
                    'employee_id' => $usercomp['emplyee_id'],
                    'basic_salary' => $usercomp['basic_salary'],
                    'net_salary' => $usercomp['net_salary'] ?? '0',
                    'ipr' => $usercomp['inpp'] ?? '0'
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
    }
    public function onem_searchData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentYear = $_POST['year'];
            $currentMonth = $_POST['month'];


            $companyModel = new company_model();
            $userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);

            $data = [];
            foreach ($userc as $usercomp) {
                $data[] = [
                    'name' => $usercomp['name'],
                    'employee_id' => $usercomp['emplyee_id'],
                    'basic_salary' => $usercomp['basic_salary'],
                    'net_salary' => $usercomp['net_salary'] ?? '0',
                    'ipr' => $usercomp['onem'] ?? '0'
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
    }

    public function generatePaiePdfAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Définir l'en-tête pour le type de contenu JSON

            $postData = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $_SESSION['pdfData'] = $postData;

            // Supposons que vous avez généré une URL pour rediriger l'utilisateur
            $redirectUrl = URL . "company/generate_paie_pdf";

            // Créez un tableau avec l'URL de redirection
            $responseArray = ['redirectUrl' => $redirectUrl];

            // Encodez ce tableau en JSON et renvoyez-le
            header('Content-Type: application/json');
            echo json_encode($responseArray);
        }
    }

    public function generateAvancePdfAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Définir l'en-tête pour le type de contenu JSON

            $postData = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $_SESSION['pdfAvance'] = $postData;

            // Supposons que vous avez généré une URL pour rediriger l'utilisateur
            $redirectUrl = URL . "company/invoice_avance";

            // Créez un tableau avec l'URL de redirection
            $responseArray = ['redirectUrl' => $redirectUrl];

            // Encodez ce tableau en JSON et renvoyez-le
            header('Content-Type: application/json');
            echo json_encode($responseArray);
        }
    }

    public function generatedgiPdfAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les données JSON de la requête POST
            $json = file_get_contents('php://input');
            $postData = json_decode($json, true);

            // Vérifier si les données JSON ont été décodées correctement
            if ($postData === null) {
                // Gérer l'erreur de décodage JSON
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid JSON data']);
                exit;
            }

            $_SESSION['pdfData'] = $postData;

            // Supposons que vous avez généré une URL pour rediriger l'utilisateur
            $redirectUrl = URL . "company/generate_dgi_pdf";

            // Créez un tableau avec l'URL de redirection
            $responseArray = ['redirectUrl' => $redirectUrl];

            // Encodez ce tableau en JSON et renvoyez-le
            header('Content-Type: application/json');
            echo json_encode($responseArray);
        }
    }
    public function generatecnssPdfAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les données JSON de la requête POST
            $json = file_get_contents('php://input');
            $postData = json_decode($json, true);

            // Vérifier si les données JSON ont été décodées correctement
            if ($postData === null) {
                // Gérer l'erreur de décodage JSON
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid JSON data']);
                exit;
            }

            $_SESSION['pdfData'] = $postData;

            // Supposons que vous avez généré une URL pour rediriger l'utilisateur
            $redirectUrl = URL . "company/generate_cnss_pdf";

            // Créez un tableau avec l'URL de redirection
            $responseArray = ['redirectUrl' => $redirectUrl];

            // Encodez ce tableau en JSON et renvoyez-le
            header('Content-Type: application/json');
            echo json_encode($responseArray);
        }
    }
    public function generateinppPdfAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les données JSON de la requête POST
            $json = file_get_contents('php://input');
            $postData = json_decode($json, true);

            // Vérifier si les données JSON ont été décodées correctement
            if ($postData === null) {
                // Gérer l'erreur de décodage JSON
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid JSON data']);
                exit;
            }

            $_SESSION['pdfData'] = $postData;

            // Supposons que vous avez généré une URL pour rediriger l'utilisateur
            $redirectUrl = URL . "company/generate_inpp_pdf";

            // Créez un tableau avec l'URL de redirection
            $responseArray = ['redirectUrl' => $redirectUrl];

            // Encodez ce tableau en JSON et renvoyez-le
            header('Content-Type: application/json');
            echo json_encode($responseArray);
        }
    }
    public function generateonemPdfAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les données JSON de la requête POST
            $json = file_get_contents('php://input');
            $postData = json_decode($json, true);

            // Vérifier si les données JSON ont été décodées correctement
            if ($postData === null) {
                // Gérer l'erreur de décodage JSON
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid JSON data']);
                exit;
            }

            $_SESSION['pdfData'] = $postData;

            // Supposons que vous avez généré une URL pour rediriger l'utilisateur
            $redirectUrl = URL . "company/generate_onem_pdf";

            // Créez un tableau avec l'URL de redirection
            $responseArray = ['redirectUrl' => $redirectUrl];

            // Encodez ce tableau en JSON et renvoyez-le
            header('Content-Type: application/json');
            echo json_encode($responseArray);
        }
    }

    public function handleAddDayoff()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['users'])) {
                $user = $_SESSION['users'];
                $userId = $user['id'];
                $companyId = $user['company_id'];
            } else {
                return [];
            }

            $date_off = $_POST['date_off'];
            $description = $_POST['description'];
            $is_universal = 0;

            // Formatage et validation de la date
            $parts = explode('/', $date_off);
            if (count($parts) === 3) {
                $date_off = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
            } else {
                $parts = explode('-', $date_off);
                if (count($parts) === 3) {
                    $year = $parts[0];
                    $month = $parts[1];
                    $day = $parts[2];
                    $date_off = $year . '-' . $month . '-' . $day;
                }
            }

            try {
                $dateObject = DateTime::createFromFormat('Y-m-d', $date_off);
                if (!$dateObject) {
                    throw new Exception("Format de date invalide.");
                }
                $date_off = $dateObject->format('Y-m-d');
                $day_date = $dateObject->format('m-d');
            } catch (Exception $e) {
                // Traiter l'exception ou indiquer une date incorrecte
                $response = ['status' => 400, 'msg' => $e->getMessage()];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

            $data = [
                'dayoff_date' => $date_off,
                'day_date' => $day_date,
                'is_universal' => $is_universal,
                'description' => $description,
                'company_id' => $companyId,
                'added_by' => $userId,
            ];

            // $existingTimesheet = $this->model->getTimesheetByStaffAndDate($staff_id, $timesheet_date);
            // if ($existingTimesheet) {
            //     echo json_encode(array("status" => 400, "msg" => "Un enregistrement existe déjà pour cet employé à cette date."));
            //     exit;
            // }

            $result = $this->model->addDayOff($data);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le jour a été ajouté avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de l'ajout."));
            }
        }
    }

    public function handleDeleteDayoff()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $result = $this->model->deleteDayOff($id);

            if ($result) {
                echo json_encode(array("status" => 200, "msg" => "Le jour a été supprimée avec succès."));
            } else {
                echo json_encode(array("status" => 500, "msg" => "Une erreur s'est produite lors de la suppression du jour"));
            }
        } else {
            echo json_encode(array("status" => 400, "msg" => "Méthode non autorisée."));
        }
    }

    public function updatedayoff()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id_horaire']);
            $date_offupdate = $_POST['date_offupdate'];
            $description = $_POST['descriptionupdate'];

            // Formatage et validation de la date
            $parts = explode('/', $date_offupdate);
            if (count($parts) === 3) {
                $date_offupdate = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
            } else {
                $parts = explode('-', $date_offupdate);
                if (count($parts) === 3) {
                    $year = $parts[0];
                    $month = $parts[1];
                    $day = $parts[2];
                    $date_offupdate = $year . '-' . $month . '-' . $day;
                }
            }

            // Formatage et validation de la date
            $parts = explode('/', $date_offupdate);
            if (count($parts) === 3) {
                $date_offupdate = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
            } else {
                $parts = explode('-', $date_offupdate);
                if (count($parts) === 3) {
                    $year = $parts[0];
                    $month = $parts[1];
                    $day = $parts[2];
                    $date_offupdate = $year . '-' . $month . '-' . $day;
                }
            }

            try {
                $dateObject = DateTime::createFromFormat('Y-m-d', $date_offupdate);
                if (!$dateObject) {
                    throw new Exception("Format de date invalide.");
                }
                $date_offupdate = $dateObject->format('Y-m-d');
                $date_off = $dateObject->format('m-d');
            } catch (Exception $e) {
                // Traiter l'exception ou indiquer une date incorrecte
                $response = ['status' => 400, 'msg' => $e->getMessage()];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

            // $existingTimesheet = $this->model->getTimesheetByStaffAndDate($staff_id, $timesheet_date);
            // if ($existingTimesheet) {
            //     echo json_encode(array("status" => 400, "msg" => "Un enregistrement existe déjà pour cet employé à cette date."));
            //     exit;
            // }

            // Vérification de la date
            if (empty($date_offupdate)) {
                $response = ['status' => 400, 'msg' => 'La date est vide, veuillez le remplir'];
            } else {
                $result = $this->model->updatedayoff($id, $date_offupdate, $date_off, $description);

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
