<?php

Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location:" . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "company") {
    header('Location:' . ERROR);
    exit;
}
$companyModel = new company_model();
$userc = $companyModel->getAllUsersByCreatorAndCompany();
$usersRoles = $companyModel->getAllUserRoles();
$usersDepartements = $companyModel->getAllDepartmentsByCreatorAndCompany();
$countries = $companyModel->getAllCountry();
$office_shifts = $companyModel->getAllOfficeShiftsByCreatorAndCompany();
$branches = $companyModel->getAllDesignationsByCreatorAndCompany();


?>
<?php include_once './views/include/header.php'; ?>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-xxl mx-auto">

                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Liste des utiliateurs</h5>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <button href="#" class="btn btn-primary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#newFormUserCompany">
                                            Ajouter<em class="icon ni ni-plus p-1"></em>
                                        </button>
                                    </div>
                                </div>
                                <div class="dt-export-buttons d-flex align-center mb-3 d-flex justify-content-end">
                                    <h6 class="m-2">Telecharger</h6>
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button id="download-excel" class="btn btn-secondary buttons-excel buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Telecharger en excel" data-bs-original-title="Excel" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                            <span>Excel</span>
                                        </button>
                                        <button id="download-pdf" class="btn btn-secondary buttons-pdf buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Telecharger en pdf" data-bs-original-title="Pdf" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                            <span>PDF</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">

                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">#</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Image</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Noms</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Branche</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Poste</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Debut contrat</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Fin contrat</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Type de contrat</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Genre</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Telephone</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Pays</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Role</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Status</span>
                                                </th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                        : activate to sort column ascending"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($userc as $usercomp) {
                                            ?>

                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <tr class="nk-tb-item odd">

                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="tb-lead">
                                                                    <?= $usercomp['num'] ?>
                                                                    <span class=" d-md-none ms-1"></span></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input user-checkbox" value="<?= $usercomp['id']; ?>" id="user<?= $usercomp['id']; ?>">
                                                                    <label class="custom-control-label" for="user<?= $usercomp['id']; ?>"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <div class="user-toggle">
                                                            <div class="user-avatar sm">
                                                                <?php if (isset($usercomp['image']) && !empty($usercomp['image'])) : ?>
                                                                    <img src="<?= $usercomp['image'] ?>" alt="User Avatar">
                                                                    <?php if ($usercomp['is_logged_in'] == 1) : ?>
                                                                        <div class="status dot dot-lg dot-success"></div>
                                                                    <?php else : ?>
                                                                        <div class="status dot dot-lg dot-danger"></div>
                                                                    <?php endif; ?>
                                                                <?php else : ?>
                                                                    <em class="icon ni ni-user-alt"></em>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-mb">
                                                        <span class="tb-amount"><?= $usercomp['name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['designation'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['poste_name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['contract_start'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span>
                                                            <?php
                                                            if ($usercomp['contract_type'] === 'CDD') {
                                                                echo ($usercomp['contract_end']);
                                                            } else {
                                                                echo 'indéterminées';
                                                            }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['contract_type'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['gender'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['phone'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['country'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['role_name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <?php if ($usercomp['is_active'] == 1) : ?>
                                                            <span class="badge badge-dim bg-success">Actif</span>
                                                        <?php else : ?>
                                                            <span class="badge badge-dim bg-danger">Désactivé</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <!-- <li class="nk-tb-action-hidden"> <a href="#" class="btn btn-trigger
                                                        btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wallet"
                                                        data-bs-original-title="Wallet"> <em class="icon ni ni-wallet-fill"></em> </a>
                                                        </li> <li class="nk-tb-action-hidden"> <a href="#" class="btn btn-trigger
                                                        btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Send
                                                        Email" data-bs-original-title="Send Email"> <em class="icon ni
                                                        ni-mail-fill"></em> </a> </li> <li class="nk-tb-action-hidden"> <a href="#"
                                                        class="btn btn-trigger btn-icon" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" aria-label="Suspend" data-bs-original-title="Suspend">
                                                        <em class="icon ni ni-user-cross-fill"></em> </a> </li> -->
                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                                        <em class="icon ni ni-more-h"></em>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <ul class="link-list-opt no-bdr">
                                                                            <li>
                                                                                <a href="#" class="delete-button-usercomp" data-bs-toggle="modal" data-bs-target="#deleterUser" data-id="<?= $usercomp['id']; ?>">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>Supprimer</span>
                                                                                </a>

                                                                                <a href="#" class="update_button_usercomp" 
                                                                                data-id="<?= $usercomp['id']; ?>" 
                                                                                data-userprofile-name="<?= $usercomp['name']; ?>" 
                                                                                data-userprofile-designation="<?= $usercomp['designation_id']; ?>" 
                                                                                data-userprofile-username="<?= $usercomp['username']; ?>" 
                                                                                data-userprofile-email="<?= $usercomp['email']; ?>" 
                                                                                data-userprofile-phone="<?= $usercomp['phone']; ?>" 
                                                                                data-userprofile-address="<?= $usercomp['address']; ?>" 
                                                                                data-userprofile-birthday="<?= $usercomp['birthday']; ?>" 
                                                                                data-userprofile-departement="<?= $usercomp['departement_id']; ?>" 
                                                                                data-userprofile-marital_status="<?= $usercomp['marital_status']; ?>" 
                                                                                data-userprofile-poste_name="<?= $usercomp['poste_name']; ?>" 
                                                                                data-userprofile-employeeid="<?= $usercomp['emplyee_id']; ?>" data-userprofile-working_time="<?= $usercomp['office_shift_id']; ?>" data-userprofile-salaire_base="<?= $usercomp['basic_salary']; ?>" data-userprofile-salary_type="<?= $usercomp['salary_type']; ?>" data-userprofile-country="<?= $usercomp['country_id']; ?>" data-userprofile-contract_type="<?= $usercomp['contract_type']; ?>" data-userprofile-gender="<?= $usercomp['gender']; ?>" data-userprofile-role="<?= $usercomp['user_role_id']; ?>" data-userprofile-image="<?= $usercomp['image']; ?>">
                                                                                    <em class="icon ni ni-pen"></em>
                                                                                    <span>Modifier</span>
                                                                                </a>
                                                                                <a href="#" class="voir_button_usercomp" data-id="<?= $usercomp['id']; ?>" data-userview_name="<?= $usercomp['name']; ?>" data-userview_designation="<?= $usercomp['designation_id']; ?>" data-userview_username="<?= $usercomp['username']; ?>" data-userview_email="<?= $usercomp['email']; ?>" data-userview_phone="<?= $usercomp['phone']; ?>" data-userview_address="<?= $usercomp['address']; ?>" data-userview_birthday="<?= $usercomp['birthday']; ?>" data-userview_departement="<?= $usercomp['departement_id']; ?>" data-userview_marital_status="<?= $usercomp['marital_status']; ?>" data-userview_employeeid="<?= $usercomp['emplyee_id']; ?>" data-userview_working_time="<?= $usercomp['office_shift_id']; ?>" data-userview_salaire_base="<?= $usercomp['basic_salary']; ?>" data-userview_salary_type="<?= $usercomp['salary_type']; ?>" data-userview_country="<?= $usercomp['country_id']; ?>" data-userview_contract_type="<?= $usercomp['contract_type']; ?>" data-userview_gender="<?= $usercomp['gender']; ?>" data-userview_role="<?= $usercomp['user_role_id']; ?>" data-userview_image="<?= $usercomp['image']; ?>">
                                                                                    <em class="icon ni ni-eye"></em>
                                                                                    <span>Voir</span>
                                                                                </a>
                                                                            <li></li>
                                                                            <li>
                                                                                <?php if (isset($usercomp['is_active']) && $usercomp['is_active'] == 1) : ?>
                                                                                    <a href="#" class="deactivate_button_usercomp" data-id="<?= $usercomp['id']; ?>" data-status="0">
                                                                                        <em class="icon ni ni-lock"></em>
                                                                                        <span>Désactiver</span>
                                                                                    </a>
                                                                                <?php else : ?>
                                                                                    <a href="#" class="activate_button_usercomp" data-id="<?= $usercomp['id']; ?>" data-status="1">
                                                                                        <em class="icon ni ni-unlock"></em>
                                                                                        <span>Activer</span>
                                                                                    </a>
                                                                                <?php endif; ?>

                                                                            </li>
                                                            </li>
                                                        </ul>
                                </div>
                            </div>
                            </li>
                            </ul>
                            </td>
                            </tr>
                        <?php
                                            }
                        ?>
                        </tbody>
                        </table>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-7 col-sm-12 col-md-9">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">
                                    <ul class="pagination">
                                        <!-- <li class="paginate_button page-item previous disabled"
                                            id="DataTables_Table_1_previous"> <a aria-controls="DataTables_Table_1"
                                            aria-disabled="true" aria-role="link" data-dt-idx="previous" tabindex="0"
                                            class="page-link">Prev</a> </li> <li class="paginate_button page-item active">
                                            <a href="#" aria-controls="DataTables_Table_1" aria-role="link"
                                            aria-current="page" data-dt-idx="0" tabindex="0" class="page-link">1</a> </li>
                                            <li class="paginate_button page-item next" id="DataTables_Table_1_next"> <a
                                            href="#" aria-controls="DataTables_Table_1" aria-role="link" data-dt-idx="next"
                                            tabindex="0" class="page-link">Next</a> </li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .card-preview -->
        </div>
        <!-- nk-block -->
    </div>
    <!-- .components-preview wide-lg mx-auto -->
</div>
</div>
</div>

<!-- Ajouter utilisateur -->
<div class="modal fade" id="newFormUserCompany" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un utilisateurs</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="registerFormUserCompany" method="POST" enctype="multipart/form-data">
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="file" required="required" class="form-file-input" name="image" id="image">
                                    <label class="form-file-label" for="image">Choisir un image</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="name">Noms</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="name" class="form-control form-control-lg" id="name" placeholder="Entrer le nom">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="prename">Prenom</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="prename" class="form-control form-control-lg" id="prename" placeholder="Entrer le prenom">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="status_marital">Etat-civil</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="status_marital" id="status_marital" data-ui="lg">
                                        <option disabled="disabled" selected="selected"></option>
                                        <option value="Celibataire">Celibataire</option>
                                        <option value="Veuve/veuf">Veuve/veuf</option>
                                        <option value="Marier">Marier</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="children">Enfants</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="children" class="form-control form-control-lg" id="children">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="spouse">Epouse</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="spouse" class="form-control form-control-lg" id="spouse">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="poste">poste</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        type="text"
                                        name="poste"
                                        class="form-control form-control-lg"
                                        id="poste">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="contract_start">Debut de contrat</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="contract_start" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="contract_start">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="contract_end">Fin de contrat</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="contract_end" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="contract_end">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="employeid">Employee ID</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="employeid" class="form-control form-control-lg" id="employeid" <?php $randomId = rand(100000000, 999999999); ?> value="<?= $randomId; ?>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="phone">Votre telephone</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="number" name="phone" class="form-control form-control-lg" id="phone" placeholder="Entrer votre numero de telephone">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="gender">Gender</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" data-search="on" aria-hidden="true" id="gender" name="gender" data-ui="lg">
                                        <option disabled="disabled" selected="selected"></option>
                                        <option value="Homme">Homme</option>
                                        <option value="Femme">Femme</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="country">Pays</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" data-search="on" id="country" name="country" aria-hidden="true" data-ui="lg">
                                        <option disabled="disabled" selected="selected"></option>
                                        <?php foreach ($countries as $country) : ?>
                                            <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="username">Votre nom utilisateur</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="username" class="form-control form-control-lg" id="username" placeholder="Entrer votre username">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="email">Votre email</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Entrer votre email">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password">Mot de passe</label>
                                </div>
                                <div class="form-control-wrap">
                                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input required="required" type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Entrer votre mot de passe">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="confirm_password">Confirmer votre mot de passe</label>
                                </div>
                                <div class="form-control-wrap">
                                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="confirm_password">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input required="required" type="password" name="confirm_password" class="form-control form-control-lg" id="confirm_password" placeholder="Confirmer votre mot de passe">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="user_role">Role</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" data-search="on" aria-hidden="true" id="user_role" name="user_role" data-ui="lg">
                                        <option value="Role" disabled="disabled" selected="selected">Role</option>
                                        <?php
                                        foreach ($usersRoles as $role) {
                                            echo '<option value="' . $role['id_role'] . '">' . $role['name'] . '</option>';
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="department_id">Departements</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible department-select" aria-hidden="true" name="department_id" id="department_id" data-ui="lg">
                                        <option value="" disabled="disabled" selected="selected">Departements</option>
                                        <?php
                                        foreach ($usersDepartements as $dep) {
                                            echo '<option value="' . $dep['department_id'] . '">' . $dep['department_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="designation_id">Branches</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible designation-select" aria-hidden="true" id="designation_id" name="designation_id" disabled="disabled" data-ui="lg">
                                        <option value="" disabled="disabled" selected="selected">Branches</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="working_time">Temps de travail</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="working_time" id="working_time" data-ui="lg">
                                        <option value="default_option">Default Option</option>
                                        <?php
                                        foreach ($office_shifts as $office) {
                                            echo '<option value="' . $office['office_shift_id'] . '">' . $office['shift_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="salaire_base">Salaire de base</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="salaire_base" class="form-control form-control-lg" id="salaire_base" placeholder="entrer le salaire">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="paiement_type">Type de paiement</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="paiement_type" id="paiement_type" data-ui="lg">
                                        <option disabled="disabled" selected="selected"></option>
                                        <option value="1">Par mois</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="contract_type">Type de contart</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" id="contract_type" name="contract_type" data-ui="lg">
                                        <option disabled="disabled" selected="selected"></option>
                                        <option value="CDD">CDD</option>
                                        <option value="CDI">CDI</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <button type="submit" id="register_btn" name="register_btn" class="btn btn-lg btn-primary btn-block">Cree staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- update users -->
<div class="modal fade" id="UpdateModalUsercomp" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'utilisateur</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="updateFormUsercomp" method="POST" enctype="multipart/form-data">

                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="imageupdate">Veuillez inserer une image</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" name="image" id="imageupdate">
                                        <label class="form-file-label" for="imageupdate">Choisir fichier</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updatename">Noms</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="updatename" class="form-control form-control-lg" id="updatename" placeholder="Entrer le nom">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="updatestatus_marital">Status marital</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="updatestatus_marital" id="updatestatus_marital" data-ui="lg">
                                        <option selected="selected"><?= $usercomp['marital_status'] ?></option>
                                        <option value="Celibataire">Celibataire</option>
                                        <option value="Veuve/veuf">Veuve/veuf</option>
                                        <option value="Marier">Marier</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateposte">poste</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        type="text"
                                        name="updateposte"
                                        class="form-control form-control-lg"
                                        id="updateposte">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateemployeid">Employee ID</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="updateemployeid" class="form-control form-control-lg" id="updateemployeid">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updatephone">Votre telephone</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="number" name="updatephone" class="form-control form-control-lg" id="updatephone" placeholder="Entrer votre numero de telephone">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="updategender">Gender</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" data-search="on" aria-hidden="true" id="updategender" name="updategender" data-ui="lg">
                                        <option selected="selected"><?= $usercomp['gender'] ?></option>
                                        <option value="Homme">Homme</option>
                                        <option value="Femme">Femme</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="updatecountry">Pays</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" data-search="on" id="updatecountry" name="updatecountry" aria-hidden="true" data-ui="lg">
                                        <option selected="selected"><?= $usercomp['country'] ?></option>
                                        <?php foreach ($countries as $country) : ?>
                                            <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateusername">Votre nom utilisateur</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="updateusername" class="form-control form-control-lg" id="updateusername" placeholder="Entrer votre username">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateemail">Votre email</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="email" name="updateemail" class="form-control form-control-lg" id="updateemail" placeholder="Entrer votre email">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="updateuser_role">Role</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" data-search="on" aria-hidden="true" id="updateuser_role" name="updateuser_role" data-ui="lg">
                                        <option selected="selected"><?= $role['name']; ?></option>
                                        <?php
                                        foreach ($usersRoles as $role) {
                                            echo '<option value="' . $role['id_role'] . '">' . $role['name'] . '</option>';
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="updatedepartment_id">Departements</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible department-select" aria-hidden="true" name="updatedepartment_id" id="updatedepartment_id" data-ui="lg">
                                        <option selected="selected"><?= $dep['department_name']; ?></option>
                                        <?php
                                        foreach ($usersDepartements as $dep) {
                                            echo '<option value="' . $dep['department_id'] . '">' . $dep['department_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="updatedesignation_id">Branches</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible designation-select" aria-hidden="true" id="updatedesignation_id" name="updatedesignation_id" data-ui="lg">
                                        <option selected="selected"><?= $usercomp['designation'] ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="updateworking_time">Temps de travail</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="updateworking_time" id="updateworking_time" data-ui="lg">
                                        <option selected="selected"><?= $office['shift_name'] ?></option>
                                        <?php
                                        foreach ($office_shifts as $office) {
                                            echo '<option value="' . $office['office_shift_id'] . '">' . $office['shift_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updatesalaire_base">Salaire de base</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="updatesalaire_base" class="form-control form-control-lg" id="updatesalaire_base" placeholder="entrer le salaire">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="updatepaiement_type">Type de paiement</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="updatepaiement_type" id="updatepaiement_type" data-ui="lg">
                                        <option selected="selected"><?php echo $usercomp['salary_type'] == 1 ? 'Par mois' : $usercomp['salary_type']; ?></option>
                                        <option value="1">Par mois</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="updatecontract_type">Type de contart</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" id="updatecontract_type" name="updatecontract_type" data-ui="lg">
                                        <option selected="selected"><?= $usercomp['contract_type']; ?></option>
                                        <option value="CDD">CDD</option>
                                        <option value="CDI">CDI</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="id_users" name="id_users">
                    <div class="form-group mt-2">
                        <button type="submit" id="update_btn" name="update_btn" class="btn btn-lg btn-primary btn-block">Modifier utilisateur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- voir users -->
<div class="modal fade" id="viewModalProfile" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">voir l'utilisateur</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>

            <div class="modal-body">
                <form id="viewFormUser" method="POST" enctype="multipart/form-data">
                    <div class="user-avatar sq xl mb-2">
                        <?php if (isset($usercomp['image']) && !empty($usercomp['image'])) : ?>
                            <img src="" id="viewimage" alt="User Avatar">
                        <?php else : ?>
                            <em class="icon ni ni-user-alt"></em>
                        <?php endif; ?>
                    </div>
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="viewname">Votre noms</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="name" class="form-control form-control-lg" id="viewname" disabled="disabled" placeholder="Entrer votre noms">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="viewusername">Votre nom utilisateur</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="username" class="form-control form-control-lg" id="viewusername" disabled="disabled" placeholder="Entrer votre username">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="viewemail">Votre email</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="email" name="email" class="form-control form-control-lg" id="viewemail" disabled="disabled" placeholder="Entrer votre email">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="viewphone">Votre telephone</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="number" name="phone" class="form-control form-control-lg" id="viewphone" disabled="disabled" placeholder="Entrer votre numero de telephone">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="viewaddress">Votre adresse</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="address" class="form-control form-control-lg" id="viewaddress" disabled="disabled" placeholder="Entrer votre adresse">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="viewbirthday">Date d'anniversaire</label>
                                <input type="text" class="form-control form-control-lg date-picker" name="birthday" disabled="disabled" id="viewbirthday">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="id_users">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- popup -->
<div class="modal fade" id="deleterUser" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                        <h4 class="nk-modal-title">Confirmer la suppression !</h4>
                        <div class="nk-modal-text">
                            <p class="lead">Confirmez vous la suppression de l'utilisateur ?. <br>
                            L'action de suppression est non reversible, etes-vous sur de votre choix ?
                            </p>
                        </div>
                        <input type="hidden" class="id_users" name="id_users">
                        <div class="nk-modal-action d-flex align-items-center justify-content-center mt-2">
                            <a href="#" class="btn btn-lg btn-mw btn-light m-1" data-bs-dismiss="modal">Retourner</a>
                            <a href="#" data-id="value" class="btn btn-lg btn-mw btn-danger m-1 delete-button-usercompp" data-bs-dismiss="modal">Supprimer</a>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div>
        </div>
    </div>

<script>
    document.getElementById('download-pdf').addEventListener('click', function() {
        var selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value).join(',');
        var url = '<?= URL; ?>company/generate_pdf';
        if (selectedUsers.length > 0) {
            url += '?users=' + selectedUsers;
        }
        window.open(url, '_blank');
    });
</script>


<script>
    document.getElementById('download-excel').addEventListener('click', function() {
        var selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value).join(',');
        var url = '<?= URL; ?>company/generate_excel';
        if (selectedUsers.length > 0) {
            url += '?users=' + selectedUsers;
        }
        window.open(url, '_blank');
    });
</script>

<script>
    document.getElementById('download-pdf-presence').addEventListener('click', function() {


        if (selectedUsers.length > 0) {
            url += '&users=' + selectedUsers;
        }
        window.open(url, '_blank');
    });
</script>

<?php include_once './views/include/footer.php' ?>