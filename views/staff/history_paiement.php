<?php

Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location:" . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "staff") {
    header('Location:' . ERROR);
    exit;
}
$companyModel = new staff_model();
$accounts = $companyModel->getAllAccountsByCreatorAndCompany();
$depenses = $companyModel->getAllDepensesByCreatorAndCompany();
$userscompany = $companyModel->getAllUsersByCreatorAndCompany();
$paiement = $companyModel->getAllPayementByCreatorAndCompany();




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
                                <h5 class="nk-block-title">Liste de tout les paiements</h5>
                                <div class="dt-export-buttons d-flex align-center mb-3 d-flex justify-content-end">
                                    <span class="m-2">Telecharger</span>
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button class="btn btn-secondary buttons-excel buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Telecharger en excel" data-bs-original-title="Telecharger en excel" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                            <span>Excel</span>
                                        </button>
                                        <button class="btn btn-secondary buttons-pdf buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Telecharger en pdf" data-bs-original-title="Telecharger en pdf" tabindex="0" aria-controls="DataTables_Table_2" type="button">
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
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">Date</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">Nom</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">Salaire</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">Montant payer</span>
                                                </th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($paiement as $paiements) {
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
                                                        <span><?= $paiements['num'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?php
                                                                try {
                                                                    $date = DateTime::createFromFormat('Y-m', $paiements['salary_month']);
                                                                    echo $date->format('m-Y');
                                                                } catch (Exception $e) {
                                                                    // Si une exception est levée, cela signifie que la date n'a pas pu être analysée.
                                                                    // Afficher la date telle quelle ou afficher un message d'erreur selon vos préférences.
                                                                    echo $paiements['salary_month'];
                                                                }
                                                                ?>
                                                        </span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="badge badge-dim bg-primary"><?= $paiements['staff_name'] ?></span>
                                                    </td>

                                                    <td class="nk-tb-col">
                                                        <span><?= $paiements['basic_salary'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= $paiements['net_salary'] ?></span>
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

<?php include_once './views/include/footer.php' ?>