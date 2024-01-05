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
$timesheets  = $companyModel->getAllTimesheetsByCreatorAndCompany();




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
                                <h5 class="nk-block-title">Liste des presences</h5>
                                <button href="#" class="btn btn-md btn-primary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#newFormTimesheet">
                                    Ajouter<em class="icon ni ni-plus"></em>
                                </button>
                            </div>
                        </div>
                        <div class="row gy-4 mb-4 d-flex align-conten">
                            <div class="col-lg-2 col-sm-4">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2 select2-hidden-accessible" data-search="on" data-ui="lg" id="year-select" onchange="changeYear()">
                                            <option>Choisir l'annee</option>
                                            <?php
                                            for ($year = 2029; $year >= 2000; $year--) {
                                                $selected = ($year == $currentYear) ? "selected" : "";
                                                echo "<option value='$year' $selected>$year</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2 select2-hidden-accessible" data-search="on" data-ui="lg" id="month-select" onchange="changeMonth()">
                                            <option>Choisir le mois</option>
                                            <?php
                                            $months = [
                                                "01" => "Janvier", "02" => "Fevrier", "03" => "Mars",
                                                "04" => "Avril", "05" => "Mai", "06" => "Juin",
                                                "07" => "Juillet", "08" => "Aout", "09" => "Septembre",
                                                "10" => "Octobre", "11" => "Novembre", "12" => "Decembre"
                                            ];

                                            foreach ($months as $num => $name) {
                                                $selected = ($num == $currentMonth) ? "selected" : "";
                                                echo "<option value='$num' $selected>$name</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <!-- New Day Selector -->
                            <div class="col-lg-2 col-sm-4">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2 select2-hidden-accessible" data-search="on" data-ui="lg" id="day-select" onchange="changeDay()">
                                            <option>Choisir le jour</option>
                                            <?php
                                            for ($day = 1; $day <= 31; $day++) {
                                                $formattedDay = str_pad($day, 2, '0', STR_PAD_LEFT);
                                                $selected = ($day == $currentDay) ? "selected" : "";
                                                echo "<option value='$formattedDay' $selected>$formattedDay</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                                <button href="#" id="dgiData" class="btn-lg btn btn-primary" onclick="filterData()">
                                    <span>Filtrer</span>
                                    <em class="icon ni ni-filter"></em>
                                </button>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="overflow: auto; width: 100%;">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">

                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">#</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Image</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Noms</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Date</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Arrivé</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">Depart</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Status presence</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Status entrer</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Status sortie</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Temps de travail</span>
                                                </th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                        : activate to sort column ascending">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="presence_users">
                                            <?php
                                            foreach ($timesheets as $timesheet) {
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

                                                    <td class="nk-tb-col tb-col">
                                                        <span><?= $timesheet['num'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <div class="user-toggle">
                                                            <div class="user-avatar sm">
                                                                <?php if (isset($timesheet['staff_image']) && !empty($timesheet['staff_image'])) : ?>
                                                                    <img src="<?= $timesheet['staff_image'] ?>" alt="User Avatar">
                                                                <?php else : ?>
                                                                    <em class="icon ni ni-user-alt"></em>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <span class="tb-amount"><?= $timesheet['staff_name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <span><?php
                                                                try {
                                                                    $date = DateTime::createFromFormat('Y-m-d', $timesheet['timesheet_date']);
                                                                    // Créer un formateur de date avec la locale française
                                                                    $formatter = new IntlDateFormatter(
                                                                        'fr_FR',
                                                                        IntlDateFormatter::FULL,
                                                                        IntlDateFormatter::NONE,
                                                                        'Europe/Paris',
                                                                        IntlDateFormatter::GREGORIAN
                                                                    );

                                                                    // Définir le format de la date
                                                                    $formatter->setPattern('EEEE dd MMMM yyyy');

                                                                    // Afficher la date formatée
                                                                    echo $formatter->format($date);
                                                                } catch (Exception $e) {
                                                                    echo $timesheet['timesheet_date'];
                                                                }
                                                                ?>
                                                        </span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <span>
                                                            <?php
                                                            // Conversion de clock_in en format 24 heures
                                                            $clockIn = DateTime::createFromFormat('h:i A', $timesheet['clock_in']);
                                                            echo $clockIn ? $clockIn->format('H:i') : $timesheet['clock_in'];
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <span>
                                                            <?php
                                                            // Conversion de clock_out en format 24 heures
                                                            $clockOut = DateTime::createFromFormat('h:i A', $timesheet['clock_out']);
                                                            echo $clockOut ? $clockOut->format('H:i') : $timesheet['clock_out'];
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <span class="badge badge-dim bg-success"><?= $timesheet['timesheet_status'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <span class="badge badge-dim <?php
                                                                                        echo ($timesheet['status_enter'] === 'en avance') ? 'bg-warning' : (($timesheet['status_enter'] === 'en retard') ? 'bg-danger' : 'bg-success');
                                                                                        ?>"><?= $timesheet['status_enter'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <span class="badge badge-dim <?php
                                                                                        echo ($timesheet['status_out'] === 'en avance') ? 'bg-danger' : (($timesheet['status_out'] === 'apres l\'heure') ? 'bg-warning' : 'bg-success');
                                                                                        ?>"><?= $timesheet['status_out'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col">
                                                        <span><?= $timesheet['total_work'] ?> Heures</span>
                                                    </td>

                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                                        <em class="icon ni ni-more-h"></em>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <ul class="link-list-opt no-bdr">
                                                                            <li>
                                                                                <a href="#" class="delete-button-timesheet" data-id="<?= $timesheet['timesheet_id']; ?>">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>Supprimer</span>
                                                                                </a>
                                                                                <a href="#" class="update_button_timesheet" data-id="<?= $timesheet['timesheet_id']; ?>" data-timesheet_date="<?= $timesheet['timesheet_date']; ?>" data-timesheet_clockin="<?= $timesheet['clock_in']; ?>" data-timesheet_clockout="<?= $timesheet['clock_out']; ?>" data-timesheet_staffid="<?= $timesheet['staff_id']; ?>">
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

<!-- Ajouter depenses -->
<div class="modal fade" id="newFormTimesheet" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une presence</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="registerFormTimesheet" method="POST">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="staff_id">Employer</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="staff_id" id="staff_id" required="required" data-ui="lg">
                                        <option disabled="disabled" selected="selected">Choisissez l'utilisateur</option>
                                        <?php foreach ($userscompany as $employer) { ?>
                                            <option value="<?= $employer['id']; ?>"><?= $employer['name']; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="timesheet_date">Date</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="timesheet_date" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="timesheet_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="clock_in" class="form-control form-control-xl form-control-outlined time-picker" id="clock_in">
                                    <label class="form-label-outlined" for="clock_in">Heure d'arrivée</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="clock_out" class="form-control form-control-xl form-control-outlined time-picker" id="clock_out">
                                    <label class="form-label-outlined" for="clock_out">Heure de depart</label>
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
<div class="modal fade" id="UpdateModalTimesheet" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-mb" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la presence</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="updateFormTimesheet" method="POST" enctype="multipart/form-data">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="staff_id_update">Employer</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2 select2-hidden-accessible" aria-hidden="true" name="staff_id_update" id="staff_id_update" required="required" data-ui="lg">
                                        <option disabled="disabled" <?php if (!isset($timesheet_staffid)) echo 'selected="selected"'; ?>>Choisissez l'utilisateur</option>
                                        <?php foreach ($userscompany as $employer) { ?>
                                            <option value="<?= $employer['id']; ?>" <?php if (isset($timesheet_staffid) && $timesheet_staffid == $employer['id']) echo 'selected'; ?>>
                                                <?= $employer['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="timesheet_date_update">Date</label>
                                </div>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" name="timesheet_date_update" placeholder="2023-10-23" class="form-control form-control-lg form-control-outlined date-picker" id="timesheet_date_update">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="clock_in_update" class="form-control form-control-xl form-control-outlined time-picker" id="clock_in_update">
                                    <label class="form-label-outlined" for="clock_in_update"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control-wrap has-timepicker">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" name="clock_out_update" class="form-control form-control-xl form-control-outlined time-picker" id="clock_out_update">
                                    <label class="form-label-outlined" for="clock_out_update"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="timesheet_id" name="timesheet_id">
                    <div class="form-group mt-2">
                        <button type="submit" id="update_btn" name="update_btn" class="btn btn-lg btn-primary btn-block">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- popup -->
<div class="modal fade" id="deleterPresence" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                    <h4 class="nk-modal-title">Confirmer la suppression !</h4>
                    <div class="nk-modal-text">
                        <p class="lead">Confirmez vous la suppression de cette presence ?. <br>
                            L'action de suppression est non reversible et peut avoir des consequences majeurs sur les donnees, etes-vous sur de votre choix ?
                        </p>
                    </div>
                    <input type="hidden" class="id_users" name="id_users">
                    <div class="nk-modal-action d-flex align-items-center justify-content-center mt-2">
                        <a href="#" class="btn btn-lg btn-mw btn-light m-1" data-bs-dismiss="modal">Retourner</a>
                        <a href="#" data-id="value" class="btn btn-lg btn-mw btn-danger m-1 delete-button-deleterPresence" data-bs-dismiss="modal">Supprimer</a>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<script>
    var filteredUserData = []; // Variable globale pour stocker les données filtrées
    document.getElementById('dgiData').addEventListener('click', function() {
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;
        var day = document.getElementById('day-select').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= URL; ?>company/presence_searchData', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                var response = JSON.parse(this.responseText);
                filteredUserData = response;
                console.log("filteredUserData:", filteredUserData);

                isDataFiltered = true;
            }
        };
        xhr.send('year=' + year + '&month=' + month + '&day=' + day);
    });
</script>


<script>
    function filterData() {
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;
        var day = document.getElementById('day-select').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= URL; ?>company/presence_search', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('presence_users').innerHTML = this.responseText;
            }
        };
        xhr.send('year=' + year + '&month=' + month + '&day=' + day);
    }
</script>

<?php include_once './views/include/footer.php' ?>