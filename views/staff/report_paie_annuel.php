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
                                <h5 class="nk-block-title">Liste des paiement annuel</h5>
                                <div class="dt-export-buttons d-flex align-center mb-3 d-flex justify-content-end">
                                    <h6 class="m-2">Telecharger</h6>
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button id="download-excel" class="btn btn-secondary buttons-excel buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Excel" data-bs-original-title="Excel" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                            <span>Excel</span>
                                        </button>
                                        <button id="download-pdf" class="btn btn-secondary buttons-pdf buttons-html5" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Pdf" data-bs-original-title="Pdf" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                            <span>PDF</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row gy-4 mb-4 d-flex align-conten">
                                <!-- <div class="col-lg-2 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right">
                                                                    <em class="icon ni ni-user"></em>
                                                                </div>
                                                                <input 
                                                                    type="text" 
                                                                    class="form-control form-control-lg form-control-outlined" 
                                                                    id="search-user" 
                                                                    onkeyup="updateTable()">
                                                                <label class="form-label-outlined" for="outlined-right-icon">Nom de l'utilisateur</label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                <!-- <div class="col-lg-2 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <select class="form-select js-select2 select2-hidden-accessible" data-search="on" data-ui="lg">
                                                                    <option >Choisir le mois</option>
                                                                    <option value="01">Janvier</option>
                                                                    <option value="02">Fevrier</option>
                                                                    <option value="03">Mars</option>
                                                                    <option value="04">Avril</option>
                                                                    <option value="05">Mai</option>
                                                                    <option value="06">Juin</option>
                                                                    <option value="07">Juillet</option>
                                                                    <option value="08">Aout</option>
                                                                    <option value="09">Septembre</option>
                                                                    <option value="10">Octobre</option>
                                                                    <option value="11">Novembre</option>
                                                                    <option value="12">Decembre</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> -->
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

                                <!-- <div class="col-lg-2 col-sm-4">
                                                        <a href="#" class="btn-lg btn btn-primary">
                                                            <span>Filtrer</span>
                                                            <em class="icon ni ni-setting"></em>
                                                        </a>
                                                    </div> -->
                            </div>

                            <div class="card">
                                <div class="card-inner">
                                    <div id="DataTables_Table_1_wrapper" style="overflow: auto; width: 100%;" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <table class=" nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
                                            <thead>
                                                <tr class="nk-tb-item nk-tb-head">
                                                    <th class="nk-tb-col">Noms</th>
                                                    <?php
                                                    $selectedYear = $_POST['year'] ?? '2023';;
                                                    for ($i = 1; $i <= 12; $i++) :
                                                        $formatter = new IntlDateFormatter(
                                                            'fr_FR',
                                                            IntlDateFormatter::FULL,
                                                            IntlDateFormatter::FULL,
                                                            'Europe/Paris',
                                                            IntlDateFormatter::GREGORIAN,
                                                            'MMMM'
                                                        );
                                                        $date = new DateTime("$selectedYear-$i-1");
                                                        $nomDuMois = $formatter->format($date);
                                                    ?>
                                                        <th class="nk-tb-col"><?= $nomDuMois ?></th>
                                                    <?php endfor; ?>
                                                </tr>

                                            </thead>
                                            <tbody id="table-container">
                                                <?php foreach ($userscompany as $user) :
                                                    // Récupération des données de paiement pour l'employé courant
                                                    $paymentData = $companyModel->getAllPayementCurrentYearByCreatorAndCompany($user['id']);

                                                ?>
                                                    <tr class="nk-tb-item odd">
                                                        <td class="nk-tb-col">
                                                            <div class="col">
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input user-checkbox" value="<?= $user['id']; ?>" id="user<?= $user['id']; ?>">
                                                                    <label class="custom-control-label" for="user<?= $user['id']; ?>"></label>
                                                                </div>
                                                            </div>
                                                            <span class="tb-amount"><?= htmlspecialchars($user['name']) ?></span>
                                                        </td>
                                                        <?php
                                                        // Parcourir chaque mois de l'année
                                                        for ($month = 1; $month <= 12; $month++) :
                                                            $netSalary = array_key_exists($month, $paymentData) ? $paymentData[$month] : '-';
                                                        ?>
                                                            <td class="nk-tb-col"><?= htmlspecialchars($netSalary) . " $" ?></td>
                                                        <?php endfor; ?>

                                                    </tr>
                                                <?php endforeach; ?>

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

    <script>
        document.getElementById('download-pdf').addEventListener('click', function() {
            var year = document.getElementById('year-select').value;
            var selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value).join(',');
            var url = '<?= URL; ?>company/generate_report_paie_annuel_pdf?year=' + year;
            if (selectedUsers.length > 0) {
                url += '&users=' + selectedUsers;
            }
            window.open(url, '_blank');
        });
    </script>

    <script>
        document.getElementById('download-excel').addEventListener('click', function() {
            var year = document.getElementById('year-select').value;
            var selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value).join(',');
            var url = '<?= URL; ?>company/generate_report_paie_annuel_excel?year=' + year;
            if (selectedUsers.length > 0) {
                url += '&users=' + selectedUsers;
            }
            window.open(url, '_blank');
        });
    </script>

    <script>
        function changeYear() {
            var year = document.getElementById('year-select').value;
            var selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value).join(',');

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= URL; ?>company/report_search', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('table-container').innerHTML = this.responseText;
                }
            };
            xhr.send('year=' + year + '&users=' + selectedUsers);
        }
    </script>


    <?php include_once './views/include/footer.php' ?>