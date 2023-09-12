<?php
Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location" . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "superadmin") {
    header('Location: ' . ERROR);
    exit;
}

$superadminModel = new superadmin_model();
$userRoles = $superadminModel->getAllUserRoles();

?>


<?=include_once "./views/include/header.php"?>

<div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="components-preview wide-lg mx-auto">
                                <div class="nk-block-head nk-block-head-lg wide-sm">
                                    <div class="nk-block-head-content">
                                        <div class="nk-block-head-sub"><a class="back-to" href="<?=URL?>dashboard/superadmin"><em class="icon ni ni-arrow-left"></em><span>Retour</span></a></div>
                                    </div>
                                </div><!-- .nk-block-head -->

                                <div class="nk-block nk-block-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Liste des roles</h4>
                                            
                                            <button href="#" class="btn btn-primary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#modalFormPrivilege">
                                                Ajouter<em class="icon ni ni-plus p-1"></em>
                                            </button>
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
                                                        <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                            <span class="sub-text">Nom</span>
                                                        </th>
                                                        <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                            <span class="sub-text">Date d'ajout</span>
                                                        </th>
                                                        
                                                        
                                                       <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                        : activate to sort column ascending">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($userRoles as $userRole) {
                                                    ?>
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                    <!-- .nk-tb-item  -->
                                                <tr class="nk-tb-item odd">
                                                        
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">
                                                                <div class="user-info">
                                                                    <span class="tb-lead"> <?= $userRole['id_role'] ?> <span class=" d-md-none ms-1"></span></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span class="tb-amount"><?= $userRole['nom'] ?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?= $userRole['created_at'] ?></span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <!-- <li class="nk-tb-action-hidden">
                                                                    <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wallet" data-bs-original-title="Wallet">
                                                                        <em class="icon ni ni-wallet-fill"></em>
                                                                    </a>
                                                                </li>
                                                                <li class="nk-tb-action-hidden">
                                                                    <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Send Email" data-bs-original-title="Send Email">
                                                                        <em class="icon ni ni-mail-fill"></em>
                                                                    </a>
                                                                </li>
                                                                <li class="nk-tb-action-hidden">
                                                                    <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Suspend" data-bs-original-title="Suspend">
                                                                        <em class="icon ni ni-user-cross-fill"></em>
                                                                    </a>
                                                                </li> -->
                                                                <li>
                                                                    <div class="drodown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li><a href="#" class="delete-button" data-id="<?= $userRole['id_role']; ?>"><em class="icon ni ni-trash"></em><span>Supprimer</span></a></li>
                                                                                <li class="divider"></li>
                                                                                <li>
                                                                                    <a href="#" class="update-button" data-id="<?= $userRole['id_role']; ?>" data-bs-toggle="modal" data-bs-target="#UpdateModal">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>Modifier</span></a>
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
                                                    ></tbody>
                                            </table>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-7 col-sm-12 col-md-9">
                                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">
                                                    <ul class="pagination">
                                                        <!-- <li class="paginate_button page-item previous disabled" id="DataTables_Table_1_previous">
                                                            <a aria-controls="DataTables_Table_1" aria-disabled="true" aria-role="link" data-dt-idx="previous" tabindex="0" class="page-link">Prev</a>
                                                        </li>
                                                        <li class="paginate_button page-item active">
                                                            <a href="#" aria-controls="DataTables_Table_1" aria-role="link" aria-current="page" data-dt-idx="0" tabindex="0" class="page-link">1</a>
                                                        </li>
                                                        <li class="paginate_button page-item next" id="DataTables_Table_1_next">
                                                            <a href="#" aria-controls="DataTables_Table_1" aria-role="link" data-dt-idx="next" tabindex="0" class="page-link">Next</a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        </div>
                                    </div><!-- .card-preview -->
                                </div> <!-- nk-block -->
                            </div><!-- .components-preview wide-lg mx-auto -->
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalFormPrivilege" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un privilege</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-validate is-alter" id="PrivilegeForm" novalidate="novalidate">
                        <div class="form-group">
                            <label class="form-label" for="full-name">Nom</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="full-name" required="">
                            </div>
                        <!-- </div>
                        <div class="form-group">
                            <label class="form-label" for="email-address"></label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="email-address" required="">
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label class="form-label">Communication</label>
                            <ul class="custom-control-group g-3 align-center">
                                <li>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="com-email">
                                        <label class="custom-control-label" for="com-email">Email</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="com-sms">
                                        <label class="custom-control-label" for="com-sms">SMS</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="com-phone">
                                        <label class="custom-control-label" for="com-phone">Phone</label>
                                    </div>
                                </li>
                            </ul>
                        </div> -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary mt-1">Enregistrer</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

            </div>

            <div class="modal fade" id="UpdateModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le privilege</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-validate is-alter" id="UpdatePrivilegeForm" novalidate="novalidate">
                        <div class="form-group">
                            <label class="form-label" for="full-name">Nom</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="full-name" required="" value="<?= $userRole['nom']; ?>">
                            </div>
                        <!-- </div>
                        <div class="form-group">
                            <label class="form-label" for="email-address"></label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="email-address" required="">
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label class="form-label">Communication</label>
                            <ul class="custom-control-group g-3 align-center">
                                <li>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="com-email">
                                        <label class="custom-control-label" for="com-email">Email</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="com-sms">
                                        <label class="custom-control-label" for="com-sms">SMS</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="com-phone">
                                        <label class="custom-control-label" for="com-phone">Phone</label>
                                    </div>
                                </li>
                            </ul>
                        </div> -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary mt-1">Mise a jour</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

            </div>

            </div>
            <!-- wrap @e -->
        </div>
        <!-- app-root @e -->

<?=include_once "./views/include/footer.php"?>