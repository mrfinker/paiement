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
$temps_horaire = $companyModel->getAllOfficeShiftsByCreatorAndCompanyListe();

function formatTimeRange($inTime, $outTime) {
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
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-xxl mx-auto">

                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <button href="#" class="btn btn-primary mt-2" type="button" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#newFormTime">
                                    Ajouter<em class="icon ni ni-plus p-1"></em>
                                </button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="overflow: auto; width: 100%;">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Nom</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Lundi</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Mardi</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Mercredi</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Jeudi</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Vendredi</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Samedi</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Dimanche</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Total</span>
                                                </th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                        : activate to sort column ascending">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($temps_horaire as $horaire) {
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
                                                        <span class="tb-amount"><?= !empty($horaire['shift_name']) ? $horaire['shift_name'] : '<span class="badge badge-dim-success">off</span>' ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= formatTimeRange($horaire['monday_in_time'], $horaire['monday_out_time']) ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= formatTimeRange($horaire['tuesday_in_time'], $horaire['tuesday_out_time']) ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= formatTimeRange($horaire['wednesday_in_time'], $horaire['wednesday_out_time']) ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= formatTimeRange($horaire['thursday_in_time'], $horaire['thursday_out_time']) ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= formatTimeRange($horaire['friday_in_time'], $horaire['friday_out_time']) ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= formatTimeRange($horaire['saturday_in_time'], $horaire['saturday_out_time']) ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= formatTimeRange($horaire['sunday_in_time'], $horaire['sunday_out_time']) ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="badge badge-dim bg-success"><?= $horaire['total_time'] . ' heures' ?></span>
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
                                                                                <a href="#" class="delete-button-horaire" data-id="<?= $horaire['office_shift_id']; ?>">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>Supprimer</span></a>
                                                                                <a href="#" class="update_button_horaire" data-id="<?= $horaire['office_shift_id']; ?>" data-horaire-name="<?= $horaire['shift_name']; ?>" data-horaire-time="<?= $horaire['total_time']; ?>" data-horaire-monday-in="<?= $horaire['monday_in_time']; ?>" data-horaire-monday-out="<?= $horaire['monday_out_time']; ?>" data-horaire-tuesday-in="<?= $horaire['tuesday_in_time']; ?>" data-horaire-tuesday-out="<?= $horaire['tuesday_out_time']; ?>" data-horaire-wednesday-in="<?= $horaire['wednesday_in_time']; ?>" data-horaire-wednesday-out="<?= $horaire['wednesday_out_time']; ?>" data-horaire-thursday-in="<?= $horaire['thursday_in_time']; ?>" data-horaire-thursday-out="<?= $horaire['thursday_out_time']; ?>" data-horaire-friday-in="<?= $horaire['friday_in_time']; ?>" data-horaire-friday-out="<?= $horaire['friday_out_time']; ?>" data-horaire-saturday-in="<?= $horaire['saturday_in_time']; ?>" data-horaire-saturday-out="<?= $horaire['saturday_out_time']; ?>" data-horaire-sunday-in="<?= $horaire['sunday_in_time']; ?>" data-horaire-sunday-out="<?= $horaire['sunday_out_time']; ?>">
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
                <h5 class="modal-title">Ajouter un temps de travail</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="registerFormTime" method="POST">
                    <div class="row gy-4">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="shift_name">Nom</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="shift_name" class="form-control form-control-lg" id="shift_name" placeholder="Entrer votre noms">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="lundi_in" class="form-control form-control-lg form-control-outlined time-picker" id="lundi_in">
                                    <label class="form-label-outlined" for="lundi_in">Temps d'arriver - Lundi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="lundi_out" class="form-control form-control-lg form-control-outlined time-picker" id="lundi_out">
                                    <label class="form-label-outlined" for="lundi_out">Temps de sortie - Lundi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="mardi_in" class="form-control form-control-lg form-control-outlined time-picker" id="mardi_in">
                                    <label class="form-label-outlined" for="mardi_in">Temps d'arriver - Mardi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="mardi_out" class="form-control form-control-lg form-control-outlined time-picker" id="mardi_out">
                                    <label class="form-label-outlined" for="mardi_out">Temps de sortie - Mardi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="mercredi_in" class="form-control form-control-lg form-control-outlined time-picker" id="mercredi_in">
                                    <label class="form-label-outlined" for="mercredi_in">Temps d'arriver - Mercredi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="mercredi_out" class="form-control form-control-lg form-control-outlined time-picker" id="mercredi_out">
                                    <label class="form-label-outlined" for="mercredi_out">Temps de sortie - Mercredi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="jeudi_in" class="form-control form-control-lg form-control-outlined time-picker" id="jeudi_in">
                                    <label class="form-label-outlined" for="jeudi_in">Temps d'arriver - Jeudi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="jeudi_out" class="form-control form-control-lg form-control-outlined time-picker" id="jeudi_out">
                                    <label class="form-label-outlined" for="jeudi_out">Temps de sortie - Jeudi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="vendredi_in" class="form-control form-control-lg form-control-outlined time-picker" id="vendredi_in">
                                    <label class="form-label-outlined" for="vendredi_in">Temps d'arriver - Vendredi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="vendredi_out" class="form-control form-control-lg form-control-outlined time-picker" id="vendredi_out">
                                    <label class="form-label-outlined" for="vendredi_out">Temps de sortie - Vendredi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="samedi_in" class="form-control form-control-lg form-control-outlined time-picker" id="samedi_in">
                                    <label class="form-label-outlined" for="samedi_in">Temps d'arriver - Samedi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="samedi_out" class="form-control form-control-lg form-control-outlined time-picker" id="samedi_out">
                                    <label class="form-label-outlined" for="samedi_out">Temps de sortie - Samedi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="dimanche_in" class="form-control form-control-lg form-control-outlined time-picker" id="dimanche_in">
                                    <label class="form-label-outlined" for="dimanche_in">Temps d'arriver - Dimanche</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="dimanche_out" class="form-control form-control-lg form-control-outlined time-picker" id="dimanche_out">
                                    <label class="form-label-outlined" for="dimanche_out">Temps de sortie - Dimanche</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="total_hours">Total Heures</label>
                                <input type="text" id="total_hours" name="total_hours" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="total_days">En jours</label>
                                <input type="text" id="total_days" name="total_days" class="form-control" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="form-group mt-2">
                        <button type="submit" id="register_btn" name="register_btn" class="btn btn-lg btn-primary btn-block">Cree un temps horaire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- update utilisateur -->
<div class="modal fade" id="updateModalTime" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-mb" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier temps de travail</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="updateFormTime" method="POST">
                    <div class="row gy-4">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="updateshift_name">Nom</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input required="required" type="text" name="shift_name" class="form-control form-control-lg" id="updateshift_name" placeholder="Entrer votre noms">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="lundi_in" class="form-control form-control-lg form-control-outlined time-picker" id="updatelundi_in">
                                    <label class="form-label-outlined" for="updatelundi_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="lundi_out" class="form-control form-control-lg form-control-outlined time-picker" id="updatelundi_out">
                                    <label class="form-label-outlined" for="updatelundi_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="mardi_in" class="form-control form-control-lg form-control-outlined time-picker" id="updatemardi_in">
                                    <label class="form-label-outlined" for="updatemardi_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="mardi_out" class="form-control form-control-lg form-control-outlined time-picker" id="updatemardi_out">
                                    <label class="form-label-outlined" for="updatemardi_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="mercredi_in" class="form-control form-control-lg form-control-outlined time-picker" id="updatemercredi_in">
                                    <label class="form-label-outlined" for="updatemercredi_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="mercredi_out" class="form-control form-control-lg form-control-outlined time-picker" id="updatemercredi_out">
                                    <label class="form-label-outlined" for="updatemercredi_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="jeudi_in" class="form-control form-control-lg form-control-outlined time-picker" id="updatejeudi_in">
                                    <label class="form-label-outlined" for="updatejeudi_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="jeudi_out" class="form-control form-control-lg form-control-outlined time-picker" id="updatejeudi_out">
                                    <label class="form-label-outlined" for="updatejeudi_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="vendredi_in" class="form-control form-control-lg form-control-outlined time-picker" id="updatevendredi_in">
                                    <label class="form-label-outlined" for="updatevendredi_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="vendredi_out" class="form-control form-control-lg form-control-outlined time-picker" id="updatevendredi_out">
                                    <label class="form-label-outlined" for="updatevendredi_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="samedi_in" class="form-control form-control-lg form-control-outlined time-picker" id="updatesamedi_in">
                                    <label class="form-label-outlined" for="updatesamedi_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="samedi_out" class="form-control form-control-lg form-control-outlined time-picker" id="updatesamedi_out">
                                    <label class="form-label-outlined" for="updatesamedi_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="dimanche_in" class="form-control form-control-xl form-control-outlined time-picker" id="updatedimanche_in">
                                    <label class="form-label-outlined" for="updatedimanche_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="dimanche_out" class="form-control form-control-xl form-control-outlined time-picker" id="updatedimanche_out">
                                    <label class="form-label-outlined" for="updatedimanche_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="total_hours">Total Heures</label>
                                <input type="text" id="updatetotal_hours" name="total_hours" class="form-control" readonly>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" class="id_horaire" name="horaire_id">
                    <div class="form-group mt-2">
                        <button type="submit" id="register_btn" name="register_btn" class="btn btn-lg btn-primary btn-block">Modifier horaire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- popup -->
<div class="modal fade" id="deleterOffice" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                    <h4 class="nk-modal-title">Confirmer la suppression !</h4>
                    <div class="nk-modal-text">
                        <p class="lead">Confirmez vous la suppression de l'horaire ?. <br>
                            L'action de suppression est non reversible et peut avoir des consequences majeurs sur les donnees, etes-vous sur de votre choix ?
                        </p>
                    </div>
                    <input type="hidden" class="id_users" name="id_users">
                    <div class="nk-modal-action d-flex align-items-center justify-content-center mt-2">
                        <a href="#" class="btn btn-lg btn-mw btn-light m-1" data-bs-dismiss="modal">Retourner</a>
                        <a href="#" data-id="value" class="btn btn-lg btn-mw btn-danger m-1 delete-button-deleteOffice" data-bs-dismiss="modal">Supprimer</a>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>



<?php include_once './views/include/footer.php' ?>