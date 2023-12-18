<?php

Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location:" . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "company") {
    header('Location:' . ERROR);
    exit;
}
$companyModel = new company_model();
$accounts = $companyModel->getAllAccountsByCreatorAndCompany();
$depots = $companyModel->getAllDepotsByCreatorAndCompany();
$userscompany = $companyModel->getAllUsersByCreatorAndCompany();
$timesheets  = $companyModel->getAllTimesheetsByCreatorAndCompany();

// Récupérez le mois et l'année actuels
$currentMonth = date('m');
$currentYear = date('Y');

// Obtenez le nombre de jours dans le mois actuel
$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Créer une liste des jours du mois actuel
$daysInMonth = range(1, cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear));


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
                                <div class="dt-export-buttons d-flex align-center mb-3 d-flex justify-content-end">
                                    <h6 class="m-2">Telecharger</h6>
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button id="download-excel-presence" class="btn btn-secondary buttons-excel buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Excel" data-bs-original-title="Excel" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                            <span>Excel</span>
                                        </button>
                                        <button id="download-pdf-presence" class="btn btn-secondary buttons-pdf buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Pdf" data-bs-original-title="Pdf" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                            <span>PDF</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row gy-4 mb-4 d-flex align-conten">
                                <div class="col-lg-2 col-sm-4">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2 select2-hidden-accessible" data-search="on" data-ui="lg" id="year-select" onchange="changeYear()">
                                                <option>Choisir l'annee</option>
                                                <?php
                                                $currentYear = date("Y"); // Obtient l'année actuelle
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
                                                $currentMonth = date("m"); // Obtient le mois actuel au format "mm"
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
                                <div class="col-lg-2 col-sm-4">
                                    <button href="#" class="btn-lg btn btn-primary" onclick="filterData()">
                                        <span>Filtrer</span>
                                        <em class="icon ni ni-setting"></em>
                                    </button>
                                </div>

                            </div>

                            <div class="dt-export-buttons d-flex align-center d-flex justify-content-start">
                                <h6 class="m-2">Legende </h6>
                                <div class="dt-buttons btn-group flex-wrap">
                                    <span class="badge badge-dim bg-primary m-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Off" data-bs-original-title="Off">O</span>
                                    <span class="badge badge-dim bg-danger m-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Absent" data-bs-original-title="Absent">A</span>
                                    <span class="badge badge-dim bg-success m-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Present" data-bs-original-title="Present">P</span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-inner">
                                <div id="DataTables_Table_1_wrapper" style="overflow: auto; width: 100%;" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <table class=" nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
                                        <thead id="thead-main">
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col">Jours</th>
                                                <?php for ($i = 1; $i <= $daysInCurrentMonth; $i++) : ?>
                                                    <th class="nk-tb-col"><?= $i ?></th>
                                                <?php endfor; ?>
                                            </tr>

                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col">Employer</th>
                                                <?php foreach ($daysInMonth as $day) : ?>
                                                    <?php
                                                    // Convertir le numéro du jour en jour de la semaine (Mon, Tue, etc.)
                                                    $dayOfWeek = date('D', strtotime("$currentYear-$currentMonth-$day"));
                                                    ?>
                                                    <th class="nk-tb-col"><?= $dayOfWeek ?></th>
                                                <?php endforeach; ?>
                                                <!-- <th class="nk-tb-col"> jours/mois</th> -->
                                            </tr>

                                        </thead>
                                        <tbody id="presence_report">
                                            <?php foreach ($userscompany as $users) :
                                                $timesheetData = $companyModel->getCurrentMonthTimesheetsByCreatorAndCompany($users['id']);
                                                $timesheetDays = $timesheetData['days'];
                                                $officeShift = $timesheetData['officeShift'];
                                                $daysPerWeek = $officeShift['total_time'] / 8; // Combien de jours la total_time représente par semaine
                                                $daysPerMonth = $daysPerWeek * 4; // Multiplier par le nombre moyen de semaines dans un mois

                                            ?>
                                                <tr class="nk-tb-item odd">
                                                    <td class="nk-tb-col tb-col-mb">
                                                        <div class="col">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input user-checkbox" value="<?= $users['id']; ?>" id="user<?= $users['id']; ?>">
                                                                <label class="custom-control-label" for="user<?= $users['id']; ?>"></label>
                                                            </div>
                                                        </div>

                                </div>
                                <span class="tb-amount"><?= $users['name'] ?></span>
                                </td>
                                <?php for ($i = 1; $i <= $daysInCurrentMonth; $i++) : ?>
                                    <td class="nk-tb-col">
                                        <?php
                                                    $dayKeyIn = strtolower(date('l', strtotime(date('Y-m') . '-' . $i))) . '_in_time';
                                                    $dayKeyOut = strtolower(date('l', strtotime(date('Y-m') . '-' . $i))) . '_out_time';
                                        ?>
                                        <?php
                                                    if (isset($timesheetDays[$i]) && $timesheetDays[$i] == 'P') {
                                                        echo '<span class="badge badge-dim bg-success">P</span>';
                                                    } elseif (
                                                        isset($officeShift[$dayKeyIn]) && empty($officeShift[$dayKeyIn]) &&
                                                        isset($officeShift[$dayKeyOut]) && empty($officeShift[$dayKeyOut])
                                                    ) {
                                                        echo '<span class="badge badge-dim bg-primary">O</span>';
                                                    } else {
                                                        echo '<span class="badge badge-dim bg-danger">A</span>';
                                                    }
                                        ?>

                                        <!-- </td> -->
                                    <?php endfor; ?>
                                    <!-- Afficher le total_time pour chaque utilisateur -->
                                    <!-- <td class="nk-tb-col"> -->
                                    <?php #intval($daysPerMonth) 
                                    ?> <!-- rajouter un echo apres php -->
                                    <!-- </td> -->
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                                </table>

                            </div>
                            <div class="row align-items-center">
                                <div class="col-7 col-sm-12 col-md-9">
                                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button page-item previous disabled" id="DataTables_Table_1_previous"> <a aria-controls="DataTables_Table_1" aria-disabled="true" aria-role="link" data-dt-idx="previous" tabindex="0" class="page-link">Prev</a> </li>
                                            <li class="paginate_button page-item active">
                                                <a href="#" aria-controls="DataTables_Table_1" aria-role="link" aria-current="page" data-dt-idx="0" tabindex="0" class="page-link">1</a>
                                            </li>
                                            <li class="paginate_button page-item next" id="DataTables_Table_1_next"> <a href="#" aria-controls="DataTables_Table_1" aria-role="link" data-dt-idx="next" tabindex="0" class="page-link">Next</a> </li>
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

<script>
    document.getElementById('download-pdf-presence').addEventListener('click', function() {
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;
        var selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value).join(',');
        var url = '<?= URL; ?>company/generate_presence_pdf?year=' + year + '&month=' + month;
        if (selectedUsers.length > 0) {
            url += '&users=' + selectedUsers;
        }
        window.open(url, '_blank');
    });
</script>

<script>
    document.getElementById('download-excel-presence').addEventListener('click', function() {
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;
        var selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value).join(',');
        var url = '<?= URL; ?>company/generate_presence_excel?year=' + year + '&month=' + month;
        if (selectedUsers.length > 0) {
            url += '&users=' + selectedUsers;
        }
        window.open(url, '_blank');
    });
</script>

<script>
    function filterData() {
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;
        var selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value).join(',');

        // Masquer l'entête principal du tableau
        document.getElementById('thead-main').style.display = 'none';

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= URL; ?>company/report_paie_search', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('presence_report').innerHTML = this.responseText;
            }
        };
        xhr.send('year=' + year + '&month=' + month + '&users=' + selectedUsers);
    }
</script>

<?php include_once './views/include/footer.php' ?>