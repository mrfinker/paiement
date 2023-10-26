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
$plan = $superadminModel->getAllplan();

?>

<?php include_once "./views/include/header.php"?>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-xxl mx-auto">

                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Liste des plans</h4>
                                <button
                                    href="#"
                                    class="btn btn-primary mt-2"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#newFormPlan">
                                    Ajouter<em class="icon ni ni-plus p-1"></em>
                                </button>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div
                                    id="DataTables_Table_1_wrapper"
                                    class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <table
                                        class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer"
                                        data-auto-responsive="false"
                                        id="DataTables_Table_1"
                                        aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">

                                                <th
                                                    class="nk-tb-col sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">#</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Nom</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Type</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Prix</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Durer</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Nombre employer</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col nk-tb-col-tools text-end sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="
                                                        : activate to sort column ascending">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach ($plan as $plans) {
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
                                                                <?=$plans['num']?>
                                                                <span class=" d-md-none ms-1"></span></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="tb-amount"><?=$plans['membership_plan_name']?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?=$plans['membership_type_plan']?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?=$plans['price']?> $</span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?=$plans['plan_duration']?> Jours</span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?=$plans['total_employee']?></span>
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
                                                                <a
                                                                    href="#"
                                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-more-h"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li>
                                                                            <a href="#" 
                                                                            class="delete-button-plan" 
                                                                            data-id="<?=$plans['membership_plan_id'];?>">
                                                                                <em class="icon ni ni-trash"></em>
                                                                                <span>Supprimer</span>
                                                                            </a>

                                                                            <a
                                                                                href="#"
                                                                                class="update_button_plan"
                                                                                data-id="<?=$plans['membership_plan_id'];?>"
                                                                                data-membership_plan_name="<?=$plans['membership_plan_name'];?>"
                                                                                data-membership_type_plan="<?=$plans['membership_type_plan'];?>"
                                                                                data-price="<?=$plans['price'];?>"
                                                                                data-plan_duration="<?=$plans['plan_duration'];?>"
                                                                                data-total_employee="<?=$plans['total_employee'];?>">
                                                                                <em class="icon ni ni-pen"></em>
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
                                        <div
                                            class="dataTables_paginate paging_simple_numbers"
                                            id="DataTables_Table_1_paginate">
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
<div
    class="modal fade"
    id="newFormPlan"
    style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-mb" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un plan</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="registerFormPlan" method="POST" enctype="multipart/form-data">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="membership_plan_name">Nom</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        type="text"
                                        name="membership_plan_name"
                                        class="form-control form-control-lg"
                                        id="membership_plan_name"
                                        placeholder="Entrer le nom">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="membership_type_plan">Type</label>
                                    <div class="form-control-wrap">
                                        <select
                                            id="membership_type_plan"
                                            name="membership_type_plan"
                                            class="form-select js-select2 select2-hidden-accessible"
                                            data-search="on"
                                            aria-hidden="true">
                                            <option selected>Selectionner les types</option>
                                            <option value="Mois">Mois</option>
                                            <option value="Annuel">Annuel</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="price">Prix</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        name="price"
                                        class="form-control form-control-lg"
                                        id="price"
                                        placeholder="Entrer le prix">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="plan_duration">Durer</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        name="plan_duration"
                                        class="form-control form-control-lg"
                                        id="plan_duration"
                                        placeholder="Entrer la durer">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="total_employee">Total employer</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        type="text"
                                        name="total_employee"
                                        class="form-control form-control-lg"
                                        id="total_employee"
                                        placeholder="Entrer le nombre d'employer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <button
                            type="submit"
                            id="register_btn"
                            name="register_btn"
                            class="btn btn-lg btn-primary btn-block">Cree</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- update users -->
<div
    class="modal fade"
    id="UpdateModalPlan"
    style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-mb" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier plan</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
            <form id="updateFormPlan" method="POST" enctype="multipart/form-data">
                    <div class="row gy-4">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updatemembership_plan_name">Nom</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        type="text"
                                        name="updatemembership_plan_name"
                                        class="form-control form-control-lg"
                                        id="updatemembership_plan_name"
                                        placeholder="Entrer le nom">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="updatemembership_type_plan">Type</label>
                                    <div class="form-control-wrap">
                                        <select
                                            id="updatemembership_type_plan"
                                            name="updatemembership_type_plan"
                                            class="form-select js-select2 select2-hidden-accessible"
                                            data-search="on"
                                            aria-hidden="true">
                                            <option selected>Selectionner les types</option>
                                            <option value="Mois">Mois</option>
                                            <option value="Annuel">Annuel</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateprice">Prix</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        name="updateprice"
                                        class="form-control form-control-lg"
                                        id="updateprice"
                                        placeholder="Entrer le prix">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateplan_duration">Durer</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        name="updateplan_duration"
                                        class="form-control form-control-lg"
                                        id="updateplan_duration"
                                        placeholder="Entrer la durer">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updatetotal_employee">Total employer</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input
                                        required="required"
                                        type="text"
                                        name="updatetotal_employee"
                                        class="form-control form-control-lg"
                                        id="updatetotal_employee"
                                        placeholder="Entrer le nombre d'employer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" class="membership_plan_id" name="membership_plan_id" value="<?=$plans['membership_plan_id'];?>">
                    <div class="form-group mt-2">
                        <button
                            type="submit"
                            id="update_btn"
                            name="update_btn"
                            class="btn btn-lg btn-primary btn-block">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include_once "./views/include/footer.php"?>