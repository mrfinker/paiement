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
$company = $superadminModel->getAllcompany();

?>

<?=include_once "./views/include/header.php"?>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-xl mx-auto">
                    <div class="nk-block-head nk-block-head-lg wide-sm">
                        <div class="nk-block-head-content">
                            <div class="nk-block-head-sub">
                                <a class="back-to" href="<?=URL?>dashboard/superadmin">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Retour</span></a>
                            </div>
                        </div>
                    </div>
                    <!-- .nk-block-head -->

                    <div class="nk-block nk-block-xl">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Liste de toutes les company</h4>
                                <button
                                    href="#"
                                    class="btn btn-primary mt-2"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#ModalCompany">
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
                                                    class="nk-tb-col tb-col-mb sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">id_unique</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col tb-col-mb sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">name</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col tb-col-md sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">adresse</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col tb-col-md sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">email</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col tb-col-md sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">phone</span>
                                                </th>
                                                <th
                                                    class="nk-tb-col tb-col-md sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">date de creation</span>
                                                </th>

                                                <th
                                                    class="nk-tb-col nk-tb-col-tools text-end sorting"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_1"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="
                                                        : activate to sort column ascending"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach ($company as $compagni) {
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
                                                                <?=$compagni['id']?>
                                                                <span class=" d-md-none ms-1"></span></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span class="tb-amount"><?=$compagni['unique_id']?></span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span><?=$compagni['name']?></span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span><?=$compagni['address']?></span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span><?=$compagni['email']?></span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span><?=$compagni['phone']?></span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span><?=$compagni['created_at']?></span>
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
                                                                            <a href="#" class="delete-button-company" data-id="<?=$compagni['id'];?>">
                                                                                <em class="icon ni ni-trash"></em>
                                                                                <span>Supprimer</span></a>
                                                                        </li>
                                                                        <li class="divider"></li>
                                                                        <li>
                                                                            <a
                                                                                href="#"
                                                                                class="update_button_company"
                                                                                data-id="<?=$compagni['id'];?>"
                                                                                data-companyname="<?=$compagni['name'];?>"
                                                                                data-companyemail="<?=$compagni['email'];?>"
                                                                                data-companyphone="<?=$compagni['phone'];?>"
                                                                                data-companyaddress="<?=$compagni['address'];?>">
                                                                                <em class="icon ni ni-pen"></em>
                                                                                <span>Modifier</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="divider"></li>
                                                                        <li>
                                                                            <a
                                                                                href="#"
                                                                                class="update_button_company"
                                                                                data-id="<?=$compagni['id'];?>"
                                                                                data-companyname="<?=$compagni['name'];?>"
                                                                                data-companyemail="<?=$compagni['email'];?>"
                                                                                data-companyphone="<?=$compagni['phone'];?>"
                                                                                data-companyaddress="<?=$compagni['address'];?>">
                                                                                <em class="icon ni ni-eye"></em>
                                                                                <span>Voir</span>
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
                                            <ul class="pagination"></ul>
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

<!-- Ajouter company -->
<div
    class="modal fade"
    id="ModalCompany"
    style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une compagnie</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form
                    action="#"
                    class="form-validate is-alter"
                    id="registerFormCompany"
                    novalidate="novalidate">
                    <div class="form-group">
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <label class="form-label" for="name">Nom</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="name" id="name" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="uniqueid">identifiant unique</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" disabled="" id="uniqueid" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="address">adresse</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="address" id="address" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="email">Email</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="email" id="email" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="phone">Phone</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="phone" id="phone" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label class="form-label">Choisir le pays</label>
                                <div class="form-control-wrap">
                                    <select
                                        id="country"
                                        name="country_id"
                                        class="form-select js-select2 select2-hidden-accessible"
                                        data-select2-id="3"
                                        tabindex="-1"
                                        aria-hidden="true">
                                        <option value="default_option" data-select2-id="5">Selectionner votre pays</option>
                                        <option value="1" data-select2-id="28">Republique democratique du congo</option>
                                        <option value="2" data-select2-id="29">Republique du congo</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label class="form-label">Choisir la category</label>
                                <div class="form-control-wrap">
                                    <select
                                        id="category"
                                        name="category_id"
                                        class="form-select js-select2 select2-hidden-accessible"
                                        data-select2-id="3"
                                        tabindex="-1"
                                        aria-hidden="true">
                                        <option value="default_option" data-select2-id="5">Selectionner ici</option>
                                        <option value="5" data-select2-id="28">Fudiciaire</option>
                                        <option value="6" data-select2-id="29">ong locale</option>
                                        <option value="7" data-select2-id="30">ong internationale</option>
                                        <option value="8" data-select2-id="31">sous-traitance</option>
                                    </select>
                                </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <button type="submit" id="insert_company" class="btn btn-lg btn-primary mt-1">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

<!-- Update company -->
    <div
        class="modal fade"
        id="updateModalCompany"
        style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier une compagnie</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form
                        action="#"
                        class="form-validate is-alter"
                        id="updateFormCompany"
                        novalidate="novalidate">
                        <div class="form-group">
                            <div class="row gy-4">
                                <div class="col-sm-6">
                                    <label class="form-label" for="nameupdate">Nom</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="name" id="nameupdate" required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="uniqueid">identifiant unique</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="unique_id"
                                            id="uniqueid"
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="addressupdate">adresse</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="address"
                                            id="addressupdate"
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="emailupdate">Email</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="email"
                                            id="emailupdate"
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="phoneupdate">Phone</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="phoneupdate"
                                            id="phoneupdate"
                                            required="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="id_company">
                            <div class="form-group">
                                <button
                                    type="submit"
                                    id="modifier_btn"
                                    name="modifier_btn"
                                    class="btn btn-lg btn-primary mt-1">Modifier la company</button>
                            </div>
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