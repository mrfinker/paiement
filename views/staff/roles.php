<?php
Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location" . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "staff") {
    header('Location: ' . ERROR);
    exit;
}

$companyModel = new staff_model();
$userRoles = $companyModel->getAllUserRoles();

?>

<?php include_once  "./views/include/header.php" ?>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-lg mx-auto">

                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">

                                <button href="#" class="btn btn-primary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#modalFormPrivilege">
                                    Ajouter<em class="icon ni ni-plus p-1"></em>
                                </button>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="overflow: auto; width: 100%;">

                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">

                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">#</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Nom</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">permissions</span>
                                                </th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                    : activate to sort column ascending">
                                                    <span>Action</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($userRoles as $userRole) {
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
                                                                    <?= $userRole['num'] ?>
                                                                    <span class=" d-md-none ms-1"></span></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="tb-amount"><?= $userRole['name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md col-9">
                                                        <?php
                                                        $permissions = explode(", ", $userRole['permissions']);
                                                        foreach ($permissions as $permission) { ?>
                                                            <span class="badge bg-light"><?= $permission ?></span>
                                                        <?php
                                                        }
                                                        ?>
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
                                                                                <a href="#" class="delete-button-role" data-id="<?= $userRole['id_role']; ?>" data-bs-toggle="modal" data-bs-target="#deleterRole">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>Supprimer</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="divider"></li>
                                                                            <li>
                                                                                <a href="#" class="update_button_role" data-userrole-name="<?= $userRole['name'] ?>" data-checked-role="<?= $userRole['permissions'] ?>" data-id="<?= $userRole['id_role']; ?>">
                                                                                    <em class="icon ni ni-pen2"></em>
                                                                                    <span>Modifier</span>
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

<!-- Ajouter role -->
<div class="modal fade" id="modalFormPrivilege" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <label class="form-label" for="name">Nom</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="name" name="name" required="">
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="form-label">Administration</label>
                        <ul class="custom-control-group g-3 align-center">
                            <li>
                                <div class="custom-control custom-checkbox custom-control-pro no-control">
                                    <input type="checkbox" class="custom-control-input" id="admin_employers" name="admin[]" value="admin employer">
                                    <label class="custom-control-label" for="admin_employers">Admin employer</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox custom-control-pro no-control">
                                    <input type="checkbox" class="custom-control-input" id="admin_rh" name="admin[]" value="admin rh">
                                    <label class="custom-control-label" for="admin_rh">Admin ressources humaines</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input type="checkbox" class="custom-control-input" id="admin_ficaslite" name="admin[]" value="admin fiscalite">
                                    <label class="custom-control-label" for="admin_ficaslite">Admin fiscalité</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input type="checkbox" class="custom-control-input" id="admin_paie" name="admin[]" value="admin paie">
                                    <label class="custom-control-label" for="admin_paie">Admin paie</label>
                                </div>
                            </li>
                        </ul>

                        <!-- <label class="form-label mt-1">Company</label>
                        <ul class="custom-control-group g-3 align-center">
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="company_create"
                                        name="company[]"
                                        value="company create">
                                    <label class="custom-control-label" for="company_create">Company create</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="company_edit"
                                        name="company[]"
                                        value="company edit">
                                    <label class="custom-control-label" for="company_edit">Company edit</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="company_delete"
                                        name="company[]"
                                        value="company delete">
                                    <label class="custom-control-label" for="company_delete">company delete</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="company_liste"
                                        name="company[]"
                                        value="company liste">
                                    <label class="custom-control-label" for="company_liste">company liste</label>
                                </div>
                            </li>
                        </ul>
                        
                        <label class="form-label mt-1">Privileges</label>
                        <ul class="custom-control-group g-3 align-center">
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="privilege_create"
                                        name="privilege[]"
                                        value="privilege create">
                                    <label class="custom-control-label" for="privilege_create">Privilege create</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="privilege_edit"
                                        name="privilege[]"
                                        value="privilege edit">
                                    <label class="custom-control-label" for="privilege_edit">Privilege edit</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="privilege_delete"
                                        name="privilege[]"
                                        value="privilege delete">
                                    <label class="custom-control-label" for="privilege_delete">Privilege delete</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio custom-control-pro no-control checked">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="privilege_liste"
                                        name="privilege[]"
                                        value="privilege liste">
                                    <label class="custom-control-label" for="privilege_liste">Privilege liste</label>
                                </div>
                            </li>
                        </ul> -->
                    </div>
                    <div class="form-group">
                        <button type="submit" id="btn_add_roles" class="btn btn-lg btn-primary mt-1">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- update role -->
<div class="modal fade" id="UpdateModalroles" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le role</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" id="UpdatePrivilegeForm" novalidate="novalidate">
                    <div class="form-group">
                        <label class="form-label" for="nomupdate">Nom</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nomupdate" name="nom" required="">
                        </div>
                        <div class="form-group">
                            <!-- <label class="form-label">Utilisateurs</label>
                            <ul class="custom-control-group g-3 align-center">
                                <li>
                                    <div class="custom-control custom-checkbox custom-control-pro no-control">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_user_create"
                                            name="user[]">
                                        <label class="custom-control-label" for="update_user_create">user create</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-checkbox custom-control-pro no-control">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_user_edit"
                                            name="user[]">
                                        <label class="custom-control-label" for="update_user_edit">user edit</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_user_delete"
                                            name="user[]">
                                        <label class="custom-control-label" for="update_user_delete">user delete</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_user_liste"
                                            name="user[]">
                                        <label class="custom-control-label" for="update_user_liste">user liste</label>
                                    </div>
                                </li>
                            </ul> -->

                            <label class="form-label">Administration</label>
                            <ul class="custom-control-group g-3 align-center">
                                <li>
                                    <div class="custom-control custom-checkbox custom-control-pro no-control">
                                        <input type="checkbox" class="custom-control-input" id="update_admin_employer" name="admin[]" value="admin employer">
                                        <label class="custom-control-label" for="update_admin_employer">Admin employer</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-checkbox custom-control-pro no-control">
                                        <input type="checkbox" class="custom-control-input" id="update_admin_rh" name="admin[]" value="admin rh">
                                        <label class="custom-control-label" for="update_admin_rh">Admin ressources humaines</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control">
                                        <input type="checkbox" class="custom-control-input" id="update_admin_fiscalite" name="admin[]" value="admin fiscalite">
                                        <label class="custom-control-label" for="update_admin_fiscalite">Admin fiscalité</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control">
                                        <input type="checkbox" class="custom-control-input" id="update_admin_paie" name="admin[]" value="admin paie">
                                        <label class="custom-control-label" for="update_admin_paie">Admin paie</label>
                                    </div>
                                </li>
                            </ul>
                            <!-- <label class="form-label mt-1">Company</label>
                            <ul class="custom-control-group g-3 align-center">
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control checked">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_company_create"
                                            name="company[]">
                                        <label class="custom-control-label" for="update_company_create">Company create</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control checked">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_company_edit"
                                            name="company[]">
                                        <label class="custom-control-label" for="update_company_edit">Company edit</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control checked">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_company_delete"
                                            name="company[]"
                                            value="company edit">
                                        <label class="custom-control-label" for="update_company_delete">company delete</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control checked">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_company_liste"
                                            name="company[]">
                                        <label class="custom-control-label" for="update_company_liste">company liste</label>
                                    </div>
                                </li>
                            </ul>
                            <label class="form-label mt-1">Privileges</label>
                            <ul class="custom-control-group g-3 align-center">
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control checked">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_privilege_create"
                                            name="privilege[]"
                                            value="privilege edit">
                                        <label class="custom-control-label" for="update_privilege_create">Privilege create</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control checked">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_privilege_edit"
                                            name="privilege[]"
                                            value="privilege edit">
                                        <label class="custom-control-label" for="update_privilege_edit">Privilege edit</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control checked">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_privilege_delete"
                                            name="privilege[]"
                                            value="privilege edit">
                                        <label class="custom-control-label" for="update_privilege_delete">Privilege delete</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio custom-control-pro no-control checked">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="update_privilege_liste"
                                            name="privilege[]"
                                            value="privilege edit">
                                        <label class="custom-control-label" for="update_privilege_liste">Privilege liste</label>
                                    </div>
                                </li>
                            </ul> -->
                        </div>
                        <input type="hidden" class="id_role">
                        <div class="form-group">
                            <button type="submit" id="btn_update_roles" class="btn btn-lg btn-primary mt-1">Mise a jour</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- popup -->
<div class="modal fade" id="deleterRole" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                        <h4 class="nk-modal-title">Confirmer la suppression !</h4>
                        <div class="nk-modal-text">
                            <p class="lead">Confirmez vous la suppression du role ?. <br>
                            L'action de suppression est non reversible et peut avoir des consequences majeurs sur les donnees, etes-vous sur de votre choix ?
                            </p>
                        </div>
                        <input type="hidden" class="id_users" name="id_users">
                        <div class="nk-modal-action d-flex align-items-center justify-content-center mt-2">
                            <a href="#" class="btn btn-lg btn-mw btn-light m-1" data-bs-dismiss="modal">Retourner</a>
                            <a href="#" data-id="value" class="btn btn-lg btn-mw btn-danger m-1 delete-button-deleteRole" data-bs-dismiss="modal">Supprimer</a>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div>
        </div>
    </div>

<?php include_once  "./views/include/footer.php" ?>