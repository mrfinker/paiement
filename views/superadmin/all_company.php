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
$category = $superadminModel->getAllCategory();
$Allcountry = $superadminModel->getAllCountry();

?>

<?php include_once "./views/include/header.php"?>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-xxl mx-auto">
                    <div class="nk-block nk-block-xl">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <button
                                    href="#"
                                    id="addCompany"
                                    class="btn btn-primary mt-2"
                                    type="button">
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
                                                                                data-company-name="<?=$compagni['name'];?>"
                                                                                data-company-uniqueid="<?=$compagni['unique_id'];?>"
                                                                                data-company-username="<?=$compagni['username'];?>"
                                                                                data-company-email="<?=$compagni['email'];?>"
                                                                                data-company-phone="<?=$compagni['phone'];?>"
                                                                                data-company-city="<?=$compagni['city'];?>"
                                                                                data-company-province="<?=$compagni['province'];?>"
                                                                                data-company-address="<?=$compagni['address'];?>">
                                                                                <em class="icon ni ni-pen"></em>
                                                                                <span>Modifier</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="divider"></li>
                                                                        <li>
                                                                            <a
                                                                                href="#"
                                                                                class="view_button_company"
                                                                                data-id="<?=$compagni['id'];?>"
                                                                                data-view-name="<?=$compagni['name'];?>"
                                                                                data-view-uniqueid="<?=$compagni['unique_id'];?>"
                                                                                data-view-username="<?=$compagni['username'];?>"
                                                                                data-view-email="<?=$compagni['email'];?>"
                                                                                data-view-phone="<?=$compagni['phone'];?>"
                                                                                data-view-address="<?=$compagni['address'];?>"
                                                                                data-view-companycharge="<?=$compagni['company_charge'];?>">
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


<!-- Create company -->
<div
    class="modal fade"
    id="addModalCompany"
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
                    id="registerFormCompany"
                    <div class="form-group">
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <label class="form-label" for="name">Nom</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="name" id="name" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="username">Username</label>
                                <div class="form-control-wrap">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="username"
                                        id="username"
                                        required="">
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
                                <label class="form-label" for="city">Ville</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="city" id="city" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="province">Province</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="province" id="province" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="code_postale">Code postale</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="code_postale" id="code_postale" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="tax_number">Numero taxe</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="tax_number" id="tax_number" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="rccm">RCCM</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="rccm" id="rccm" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="bank_name">Nom banque</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="bank_name" id="bank_name" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="bank_number">Compte bancaire</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="bank_number" id="bank_number" required="">
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
                                            data-search="on"
                                            aria-hidden="true">
                                            <option value="default_option">Selectionner votre pays</option>
                                            <?php
foreach ($Allcountry as $countri) {
    echo '<option value="' . $countri['id'] . '">' . $countri['name'] . '</option>';
}
?>
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
                                            data-search="on"
                                            aria-hidden="true">
                                            <option value="default_option">Selectionner la category</option>
                                            <?php
foreach ($category as $categori) {
    echo '<option value="' . $categori['id'] . '">' . $categori['name'] . '</option>';
}
?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Les compagnies</label>
                                    <div class="form-control-wrap">
                                        <select
                                            id="company"
                                            name="company_charge"
                                            class="form-select js-select2 select2-hidden-accessible"
                                            data-search="on"
                                            aria-hidden="true"
                                            disabled="disabled">
                                            <option value="default_option">Selectionner les compagnies</option>
                                            <?php
$sessionCompanyId = isset($_SESSION['company_id']) ? $_SESSION['company_id'] : null;

foreach ($company as $compagni) {
    if ($compagni['id'] != $sessionCompanyId) {
        echo '<option value="' . $compagni['id'] . '">' . $compagni['name'] . '</option>';
    }
}
?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">Mot de passe</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <a
                                            href="#"
                                            class="form-icon form-icon-right passcode-switch lg"
                                            data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input
                                            required="required"
                                            type="password"
                                            name="password"
                                            class="form-control form-control-lg"
                                            id="password"
                                            placeholder="Entrer votre mot de passe">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="confirm_password">Confirmer votre mot de passe</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <a
                                            href="#"
                                            class="form-icon form-icon-right passcode-switch lg"
                                            data-target="confirm_password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input
                                            required="required"
                                            type="password"
                                            name="confirm_password"
                                            class="form-control form-control-lg"
                                            id="confirm_password"
                                            placeholder="Confirmer votre mot de passe">
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

<!-- update company -->
<div
    class="modal fade"
    id="UpdateModalCompany"
    style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier company</h5>
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
                                        <input type="text" class="form-control" name="nameupdate" id="nameupdate" required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="updateuniqueid">identifiant unique</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="unique_id"
                                            id="uniqueidupdate"
                                            disabled
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="addressupdate">adresse</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="addressupdate"
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
                                            name="emailupdate"
                                            id="emailupdate"
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="emailupdate">Username</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="usernameupdate"
                                            id="usernameupdate"
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
                                <div class="col-sm-6">
                                <label class="form-label" for="updatecity">Ville</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="updatecity" id="updatecity" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="updateprovince">Province</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="updateprovince" id="updateprovince" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="updatecode_postale">Code postale</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="updatecode_postale" id="updatecode_postale" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="updatetax_number">Numero taxe</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="updatetax_number" id="updatetax_number" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="updaterccm">RCCM</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="updaterccm" id="updaterccm" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="updatebank_name">Nom banque</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="updatebank_name" id="updatebank_name" required="">
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="updatebank_number">Compte bancaire</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="updatebank_number" id="updatebank_number" required="">
                                </div>
                                </div>
                            </div>
                            <input type="hidden" class="id_company" name="id">
                            <div class="form-group">
                                <button
                                    type="submit"
                                    id="modifier_company_btn"
                                    name="modifier_btn"
                                    class="btn btn-lg btn-primary mt-1">Modifier la company</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>

</div>
<!-- voir company -->
<div
    class="modal fade"
    id="viewModalCompany"
    style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier company</h5>
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
                                    <label class="form-label" for="nameview">Nom</label>
                                    <div class="form-control-wrap">
                                        <input type="text" disabled class="form-control" name="nameview" id="nameview" required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="uniqueiview">identifiant unique</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="unique_id"
                                            id="uniqueidview"
                                            disabled
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="addressview">adresse</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="addressview"
                                            id="addressview"
                                            disabled
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="emailview">Email</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="emailview"
                                            id="emailview"
                                            disabled
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="usernameview">Username</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="usernameview"
                                            id="usernameview"
                                            disabled
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="phoneview">Phone</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="phoneview"
                                            disabled
                                            id="phoneview"
                                            required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="phoneview">Company en charge</label>
                                    <div class="form-control-wrap">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="companychargeview"
                                            disabled
                                            id="companycharge"
                                            required="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="id_company" name="id">
                            
                        </div>
                    </form>
            </div>
        </div>
    </div>

</div>


    <?php include_once "./views/include/footer.php"?>