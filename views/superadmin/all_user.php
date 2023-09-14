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
$user = $superadminModel->getAllUsers();

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
                                            <h4 class="nk-block-title">Liste des utiliateurs</h4>
                                            <button href="#" class="btn btn-primary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#modalFormUser">
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
                                                        <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                            <span class="sub-text">email</span>
                                                        </th>
                                                        <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                            <span class="sub-text">username</span>
                                                        </th>
                                                        <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                            <span class="sub-text">birthday</span>
                                                        </th>
                                                        <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                            <span class="sub-text">phone</span>
                                                        </th>
                                                        <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                            <span class="sub-text">adresse</span>
                                                        </th>
                                                        <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                            <span class="sub-text">date de creation</span>
                                                        </th>
                                                        
                                                        
                                                       <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                        : activate to sort column ascending">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($user as $users) {
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
                                                                    <span class="tb-lead"> <?= $users['id'] ?> <span class=" d-md-none ms-1"></span></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span class="tb-amount"><?= $users['name'] ?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?= $users['email'] ?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?= $users['username'] ?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?= $users['birthday'] ?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?= $users['phone'] ?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?= $users['address'] ?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?= $users['created_at'] ?></span>
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
                                                                                <li>
                                                                                    <a href="#" class="delete-button" data-id="<?= $users['id']; ?>">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>Supprimer</span></a>
                                                                                </li>
                                                                                <li class="divider"></li>
                                                                                <li>
                                                                                    <a href="#" class="update-button" data-id="<?= $users['id']; ?>" data-bs-toggle="modal" data-bs-target="#UpdateModal">
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

                <div class="modal fade" id="modalFormUser" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un utilisateurs</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                <form id="registerFormUser" method="POST">
                                        <div class="row gy-4">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label class="form-label" for="name">Votre noms</label>
                                                    </div>
                                                    <div class="form-control-wrap">
                                                        <input
                                                            required="required"
                                                            type="text"
                                                            name="name"
                                                            class="form-control form-control-lg"
                                                            id="name"
                                                            placeholder="Entrer votre noms">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label class="form-label" for="username">Votre nom utilisateur</label>
                                                    </div>
                                                    <div class="form-control-wrap">
                                                        <input
                                                            required="required"
                                                            type="text"
                                                            name="username"
                                                            class="form-control form-control-lg"
                                                            id="username"
                                                            placeholder="Entrer votre username">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="email">Votre email</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input
                                                    required="required"
                                                    type="email"
                                                    name="email"
                                                    class="form-control form-control-lg"
                                                    id="email"
                                                    placeholder="Entrer votre email">
                                            </div>
                                        </div>
                                            </div>
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="phone">Votre telephone</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input
                                                    required="required"
                                                    type="number"
                                                    name="phone"
                                                    class="form-control form-control-lg"
                                                    id="phone"
                                                    placeholder="Entrer votre numero de telephone">
                                            </div>
                                        </div>
                                            </div>
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="address">Votre adresse</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input
                                                    required="required"
                                                    type="text"
                                                    name="address"
                                                    class="form-control form-control-lg"
                                                    id="address"
                                                    placeholder="Entrer votre adresse">
                                            </div>
                                        </div>
                                            </div>
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="password">Mot de passe</label>
                                                <a class="link link-primary link-sm" href="/app/views/auth-reset.php">Mot de passe oublier ?</a>
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
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <div class="form-label-group">
                                                <label class="form-label">Veuillez inserer une image</label>
                                            </div>
                                                    <div class="form-control-wrap">
                                                                        <div class="form-file">
                                                                            <input type="file" class="form-file-input" id="imageFile">
                                                                            <label class="form-file-label" for="imageFile">Choisir fichier</label>
                                                                        </div>
                                                                    </div>
                                                    </div>
                                                </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        <div class="form-group mt-2">
                                            <button
                                                type="submit"
                                                name="register_btn"
                                                class="btn btn-lg btn-primary btn-block">Cree utilisateur</button>
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