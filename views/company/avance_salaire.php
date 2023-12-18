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
$accounts = $companyModel->getAllAccountsByCreatorAndCompany();
$depots = $companyModel->getAllDepotsByCreatorAndCompany();
$userscompany = $companyModel->getAllUsersByCreatorAndCompany();
$advance = $companyModel->getAllAdvanceSalaireByCreatorAndCompany();




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
                                <h5 class="nk-block-title">Liste des avances sur salaire</h5>
                                <button href="#" class="btn btn-primary mt-2" type="button" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#newFormAvanceSalaire">
                                    Ajouter<em class="icon ni ni-plus"></em>
                                </button>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="dt-export-buttons d-flex align-center mb-3 d-flex justify-content-end">
                                        <h6 class="m-2">Telecharger</h6>
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <button class="btn btn-secondary buttons-excel buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Telecharger en excel" data-bs-original-title="Telecharger en excel" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                                <span>Excel</span>
                                            </button>
                                            <button class="btn btn-secondary buttons-pdf buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Telecharger en pdf" data-bs-original-title="Telecharger en pdf" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                                <span>PDF</span>
                                            </button>
                                        </div>
                                    </div>
                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">

                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">#</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">Employer</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Date</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Reference</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Montant</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Methode</span>
                                                </th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                        : activate to sort column ascending">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($advance as $advanced) {
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
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $advanced['num'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $advanced['staff_name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?php
                                                                try {
                                                                    $date = DateTime::createFromFormat('Y-m', $advanced['month_year']);
                                                                    echo $date->format('m-Y'); // Affiche le mois et l'année (par exemple : "10-2023")
                                                                } catch (Exception $e) {
                                                                    // Si une exception est levée, cela signifie que la date n'a pas pu être analysée.
                                                                    // Afficher la date telle quelle ou afficher un message d'erreur selon vos préférences.
                                                                    echo $advanced['month_year'];
                                                                }
                                                                ?></span>

                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span class="badge badge-dim bg-primary"><?= $advanced['avance_reference'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $advanced['advance_amount'] ?> $</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span class="badge badge-dim bg-success"><?= $advanced['paiement_type'] ?></span>
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
                                                                                <a href="#" class="delete_button_advanced" data-id="<?= $advanced['advanced_salary_id']; ?>" data-bs-toggle="modal" data-bs-target="#deleterAvance">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>Supprimer</span>
                                                                                </a>
                                                                                <a href="#" class="update_button_advanced" data-id="<?= $advanced['advanced_salary_id']; ?>" data-advance_amount="<?= $advanced['advance_amount']; ?>" data-month_year="<?= $advanced['month_year']; ?>" data-paiement_type="<?= $advanced['paiement_type']; ?>" data-description="<?= $advanced['description']; ?>" data-avance_reference="<?= $advanced['avance_reference']; ?>" data-staff_name="<?= $advanced['staff_name']; ?>">
                                                                                    <em class="icon ni ni-pen"></em>
                                                                                    <span>Modifier</span>
                                                                                </a>
                                                                                <a href="#" class="voir_button_advanced" data-id="<?= $advanced['advanced_salary_id']; ?>" data-advance_amount="<?= $advanced['advance_amount']; ?>" data-month_year="<?= $advanced['month_year']; ?>" data-paiement_type="<?= $advanced['paiement_type']; ?>" data-description="<?= $advanced['description']; ?>" data-avance_reference="<?= $advanced['avance_reference']; ?>" data-avance_value="<?= $advanced['avance_value']; ?>" data-avance_code="<?= $advanced['avance_code']; ?>" data-salary_type="<?= $advanced['salary_type']; ?>" data-adresse_company="<?= $advanced['adresse_company']; ?>" data-company_name="<?= $advanced['company_name']; ?>" data-created_at="<?= $advanced['created_at']; ?>" data-staff_name="<?= $advanced['staff_name']; ?>">
                                                                                    <em class="icon ni ni-eye"></em>
                                                                                    <span>voir</span>
                                                                                </a>
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

<!-- Ajouter avance -->
<div class="modal fade" id="newFormAvanceSalaire" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une avance sur salaire</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="registerFormAvanceSalaire" method="POST">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="staff_id">Employer</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="staff_id" id="staff_id" required="required" data-ui="lg">
                                        <option disabled selected>Choisissez une personne</option>
                                        <?php foreach ($userscompany as $userc) { ?>
                                            <option value="<?= $userc['id']; ?>"><?= $userc['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="advance_amount">Montant</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="advance_amount" class="form-control form-control-lg" id="advance_amount" placeholder="Entrer le montant">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="month_year">Date</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="month_year" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="month_year">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="paiement_methode">Methode de paiement</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" name="paiement_type" id="paiement_methode" required="required" data-ui="lg">
                                        <option disabled="disabled" selected="selected">Le type de paiement</option>
                                        <option value="cash">Cash</option>
                                        <option value="carte bancaire">Carte bancaire</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="banque">Bank</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="avance_reference">Reference</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="avance_reference" class="form-control form-control-lg" id="avance_reference" <?php $randomId = rand(100000000, 999999999); ?> value="<?= $randomId; ?>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="description">Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control no-resize" id="description" name="description" required="required" placeholder="Veuiller remplir cette zone..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" name="register_btn" class="btn btn-lg btn-primary btn-block">Cree
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- update avance -->
<div class="modal fade" id="UpdateModalAvanceSalaire" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la transaction</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="updateFormAdvanceSalaire" method="POST" enctype="multipart/form-data">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="updatestaff_id">Employer</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="updatestaff_id" id="updatestaff_id" required="required" data-ui="lg">
                                        <option selected>Choisissez une personne</option>
                                        <?php foreach ($userscompany as $userc) { ?>
                                            <option value="<?= $userc['id']; ?>"><?= $userc['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateadvance_amount">Montant</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="updateadvance_amount" class="form-control form-control-lg" id="updateadvance_amount" placeholder="Entrer le montant">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updatemonth_year">Date</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="updatemonth_year" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="updatemonth_year">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="updatepaiement_type">Methode de paiement</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="updatepaiement_type" id="updatepaiement_type" required="required" data-ui="lg">
                                        <option disabled="disabled" selected="selected">Le type de paiement</option>
                                        <option value="cash">Cash</option>
                                        <option value="carte bancaire">Carte bancaire</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="banque">Bank</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateavance_reference">Reference</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="updateavance_reference" class="form-control form-control-lg" id="updateavance_reference">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="updatedescription">Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control no-resize" id="updatedescription" name="updatedescription" required="required" placeholder="Veuiller remplir cette zone..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="advanced_salary_id" name="advanced_salary_id">
                    <div class="form-group mt-2">
                        <button type="submit" id="update_btn" name="update_btn" class="btn btn-lg btn-primary btn-block">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- popup -->
<div class="modal fade" id="deleterAvance" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                        <h4 class="nk-modal-title">Confirmer la suppression !</h4>
                        <div class="nk-modal-text">
                            <p class="lead">Confirmez vous la suppression de l'avanace sur salaire ?. <br>
                            L'action de suppression est non reversible, etes-vous sur de votre choix ?
                            </p>
                        </div>
                        <input type="hidden" class="id_users" name="id_users">
                        <div class="nk-modal-action d-flex align-items-center justify-content-center mt-2">
                            <a href="#" class="btn btn-lg btn-mw btn-light m-1" data-bs-dismiss="modal">Retourner</a>
                            <a href="#" data-id="value" class="btn btn-lg btn-mw btn-danger m-1 delete-button-avanceSalaire" data-bs-dismiss="modal">Supprimer</a>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div>
        </div>
    </div>

<?php include_once './views/include/footer.php' ?>