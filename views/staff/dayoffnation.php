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
$dayNation = $companyModel->getAllDayOffNationByCreatorAndCompanyListe();

function formatTimeRange($inTime, $outTime)
{
    if (!empty($inTime) && !empty($outTime)) {
        $formattedInTime = DateTime::createFromFormat('h:i A', $inTime)->format('H:i');
        $formattedOutTime = DateTime::createFromFormat('h:i A', $outTime)->format('H:i');

        return $formattedInTime . ' - ' . $formattedOutTime;
    } else {
        return '<span class="badge badge-dim bg-success">off</span>';
    }
}


?>
<?php include_once './views/include/header.php'; ?>

<div class="nk-content ">
    <div class="container-md">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-xxl mx-auto">

                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <button href="#" class="btn btn-primary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#newFormTime">
                                    Ajouter<em class="icon ni ni-plus p-1"></em>
                                </button>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="card-inner">
                                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="overflow: auto; width: 100%;">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Date</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Description</span>
                                                </th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                        : activate to sort column ascending">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($dayNation as $days) {
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

                                                    <td class="nk-tb-col tb-col-mb">
                                                        <?php
                                                        if (!empty($days['day_date'])) {
                                                            $dateParts = explode('-', $days['day_date']); // Sépare la chaîne de caractères en mois et jour
                                                            $month = intval($dateParts[0]); // Convertit le mois en nombre entier
                                                            $day = intval($dateParts[1]); // Convertit le jour en nombre entier

                                                            $months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
                                                            $formattedDate = $day . ' ' . $months[$month - 1]; // Formate la date en français
                                                            echo $formattedDate;
                                                        }
                                                        ?>
                                                    </td>

                                                    <td class="nk-tb-col">
                                                        <span class="tb-amount"><?= !empty($days['description']) ? $days['description'] : '' ?></span>
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
                                                                <?php if ($days['company_id'] != 1 || $days['added_by'] != 1) : ?>
                                                                    <div class="drodown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                                            <em class="icon ni ni-more-h"></em>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li>
                                                                                    <a href="#" class="delete-button-dayoff" data-id="<?= $days['id']; ?>">
                                                                                        <em class="icon ni ni-trash"></em>
                                                                                        <span>Supprimer</span></a>
                                                                                    <a 
                                                                                        href="#" 
                                                                                        class="update_button_dayoff" 
                                                                                        data-id="<?= $days['id']; ?>"
                                                                                        data-dateoff="<?= $days['dayoff_date']; ?>"
                                                                                        data-description="<?= $days['description']; ?>"
                                                                                        >
                                                                                        <em class="icon ni ni-pen"></em>
                                                                                        <span>Modifier</span>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
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
<div class="modal fade" id="newFormTime" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-mb" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un jour</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="registerFormDayoff" method="POST">
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="date_off">Date</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="date_off" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="date_off">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-textarea">Description</label>
                                <div class="form-control-wrap">
                                    <textarea required="required" class="form-control no-resize" id="description" name="description" placeholder="Description de la date"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <button type="submit" id="register_btn" name="register_btn" class="btn btn-lg btn-primary btn-block">Cree</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- update utilisateur -->
<div class="modal fade" id="updateModaldayoff" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-mb" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="updateFormdayoff" method="POST">
                    <div class="row gy-4">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="date_offupdate">Date</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="date_offupdate" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="date_offupdate">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-textarea">Description</label>
                                <div class="form-control-wrap">
                                    <textarea required="required" class="form-control no-resize" id="descriptionupdate" name="descriptionupdate" placeholder="Description de la date"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" class="id_horaire" name="id_horaire">
                    <div class="form-group mt-2">
                        <button type="submit" id="register_btn" name="register_btn" class="btn btn-lg btn-primary btn-block">Modifier horaire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- popup -->
<div class="modal fade" id="deleterDayoff" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                    <h4 class="nk-modal-title">Confirmer la suppression !</h4>
                    <div class="nk-modal-text">
                        <p class="lead">Confirmez vous la suppression de cette journée ?. <br>
                            L'action de suppression est non reversible et peut avoir des consequences majeurs sur les donnees, etes-vous sur de votre choix ?
                        </p>
                    </div>
                    <input type="hidden" class="id_users" name="id_users">
                    <div class="nk-modal-action d-flex align-items-center justify-content-center mt-2">
                        <a href="#" class="btn btn-lg btn-mw btn-light m-1" data-bs-dismiss="modal">Retourner</a>
                        <a href="#" data-id="value" class="btn btn-lg btn-mw btn-danger m-1 delete-button-deleteDayoff" data-bs-dismiss="modal">Supprimer</a>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>



<?php include_once './views/include/footer.php' ?>