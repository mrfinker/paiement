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
$depots = $companyModel->getAllDepotsByCreatorAndCompany();
$userscompany = $companyModel->getAllUsersByCreatorAndCompany();
$transactions = $companyModel->getAllTransactionsDepotsByCreatorAndCompany();




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
                                <h5 class="nk-block-title">Liste des depots</h5>
                                <button href="#" class="btn btn-primary mt-2" type="button" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#newFormDepots">
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
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Date</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Categorie</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Reference</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">Compte</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Payer</span>
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
                                            foreach ($transactions as $transaction) {
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
                                                        <span><?= $transaction['num'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?php
                                                                try {
                                                                    $date = DateTime::createFromFormat('Y-m-d', $transaction['transaction_date']);
                                                                    echo $date->format('d-m-Y');
                                                                } catch (Exception $e) {
                                                                    // Si une exception est levée, cela signifie que la date n'a pas pu être analysée.
                                                                    // Afficher la date telle quelle ou afficher un message d'erreur selon vos préférences.
                                                                    echo $transaction['transaction_date'];
                                                                }
                                                                ?>
                                                        </span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span class="badge badge-dim bg-success"><?= $transaction['category_name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span class="badge badge-dim bg-primary"><?= $transaction['reference'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $transaction['account_name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $transaction['staff_name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $transaction['amount'] ?> $</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $transaction['payement_method'] ?></span>
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
                                                                                <a href="#" class="delete-button-transaction-depexp" data-id="<?= $transaction['transactions_id']; ?>">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>Supprimer</span>
                                                                                </a>
                                                                                <a href="#" class="update_button_transaction-depexp" data-id="<?= $transaction['transactions_id']; ?>" data-transactions-amount="<?= $transaction['amount']; ?>" data-transactions-date="<?= $transaction['transaction_date']; ?>" data-transactions-method="<?= $transaction['payement_method']; ?>" data-transactions-entity="<?= $transaction['entity_category_id']; ?>">
                                                                                    <em class="icon ni ni-pen"></em>
                                                                                    <span>Modifier</span>
                                                                                </a>
                                                                                <a href="#" class="voir_button_transaction-depexp" data-id="<?= $transaction['transactions_id']; ?>" data-created_at="<?= $transaction['created_at']; ?>" data-transactions_value="<?= $transaction['transactions_value']; ?>" data-transactions_code="<?= $transaction['transactions_code']; ?>" data-reference="<?= $transaction['reference']; ?>" data-transactions_amount="<?= $transaction['amount']; ?>" data-transactions_date="<?= $transaction['transaction_date']; ?>" data-transactions_method="<?= $transaction['payement_method']; ?>" data-staff_name="<?= $transaction['staff_name']; ?>" data-category_name="<?= $transaction['category_name']; ?>" data-account_name="<?= $transaction['account_name']; ?>" data-account_number="<?= $transaction['account_number']; ?>" data-transactions_entity="<?= $transaction['entity_category_id']; ?>">
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

<!-- Ajouter depenses -->
<div class="modal fade" id="newFormDepots" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une transaction</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="registerFormDepots" method="POST">
                    <div class="row gy-4">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="account_name">Nom du compte</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="account_name" required="required" data-ui="lg">
                                        <option disabled="disabled" selected="selected">Choisissez le compte</option>
                                        <?php foreach ($accounts as $account) { ?>
                                            <option value="<?= $account['account_id']; ?>"><?= $account['account_name']; ?></option>
                                        <?php } ?>

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="amount">Montant</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="amount" class="form-control form-control-lg" id="amount" placeholder="Entrer le numero de compte">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="transaction_date">Date</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="transaction_date" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="transaction_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="entity_category_id">Categorie</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="entity_category_id" id="entity_category_id" required="required" data-ui="lg">
                                        <option disabled="disabled" selected="selected">Choisissez la cotegorie</option>
                                        <?php foreach ($depots as $depot) { ?>
                                            <option value="<?= $depot['constants_id']; ?>"><?= $depot['category_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="staff_id">Payer par</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="staff_id" id="staff_id" required="required" data-ui="lg">
                                        <option disabled="disabled" selected="selected">Choisissez une personne</option>
                                        <?php foreach ($userscompany as $userc) { ?>
                                            <option value="<?= $userc['id']; ?>"><?= $userc['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="payement_method">Methode de paiement</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="payement_method" id="payement_method" required="required" data-ui="lg">
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
                                    <label class="form-label" for="reference">Reference</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="reference" class="form-control form-control-lg" id="reference" <?php $randomId = rand(100000000, 999999999); ?> value="<?= $randomId; ?>" readonly="readonly">
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

<!-- update transactions -->
<div class="modal fade" id="UpdateModalTransactions" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-mb" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la transaction</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="updateFormTransactions" method="POST" enctype="multipart/form-data">
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="transactionDate">Date</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="transactionDate" class="form-control form-control-lg form-control-outlined date-picker" id="transactionDate">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="TransactionAmount">Montant</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="TransactionAmount" class="form-control form-control-lg" id="TransactionAmount" placeholder="Entrer votre noms">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="transactions_id" name="transactions_id">
                    <div class="form-group mt-2">
                        <button type="submit" id="update_btn" name="update_btn" class="btn btn-lg btn-primary btn-block">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include_once './views/include/footer.php' ?>