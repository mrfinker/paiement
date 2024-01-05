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
// Récupérez le mois et l'année actuels
$currentMonth = date('m');
$currentYear = date('Y');
$companyModel = new company_model();
$userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);
$usersRoles = $companyModel->getAllUserRoles();
$usersDepartements = $companyModel->getAllDepartmentsByCreatorAndCompany();
$countries = $companyModel->getAllCountry();
$office_shifts = $companyModel->getAllOfficeShiftsByCreatorAndCompany();



?>
<?php include_once './views/include/header.php'; ?>
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-xxl mx-auto">
                    <div class="nk-block nk-block-lg">
                        <div class="dt-export-buttons d-flex align-center mb-3 d-flex justify-content-end">
                            <h6 class="m-2">Telecharger</h6>
                            <div class="dt-buttons btn-group flex-wrap">
                                <button id="download-pdf-dgi" class="btn btn-secondary buttons-pdf buttons-html5 dgi_info" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Pdf" data-bs-original-title="Pdf" tabindex="0" aria-controls="DataTables_Table_2" type="button">
                                    <span>PDF</span>
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
                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">#</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Image</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Noms</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Employee ID</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Salaire de base</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Salaire net</span>
                                                </th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">DGI</span>
                                                </th>

                                        </thead>

                                        <script>
                                            var allUsersData = [];
                                        </script>

                                        <tbody id="paiement_users">
                                            <?php
                                            foreach ($userc as $usercomp) {
                                            ?>
                                                <script>
                                                    allUsersData.push({
                                                        name: "<?= $usercomp['name']; ?>",
                                                        employee_id: "<?= $usercomp['emplyee_id']; ?>",
                                                        basic_salary: "<?= $usercomp['basic_salary']; ?>",
                                                        net_salary: "<?= $usercomp['net_salary']; ?>",
                                                        ipr: "<?= $usercomp['ipr']; ?>"
                                                    });
                                                </script>

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
                                                                    <?= $usercomp['num'] ?>
                                                                    <span class=" d-md-none ms-1"></span></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-toggle">
                                                            <div class="user-avatar sm">
                                                                <?php if (isset($usercomp['image']) && !empty($usercomp['image'])) : ?>
                                                                    <img src="<?= $usercomp['image'] ?>" alt="User Avatar">
                                                                    <?php if ($usercomp['is_logged_in'] == 1) : ?>
                                                                        <div class="status dot dot-lg dot-success"></div>
                                                                    <?php else : ?>
                                                                        <div class="status dot dot-lg dot-danger"></div>
                                                                    <?php endif; ?>
                                                                <?php else : ?>
                                                                    <em class="icon ni ni-user-alt"></em>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-mb">
                                                        <span class="tb-amount"><?= $usercomp['name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= $usercomp['emplyee_id'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= $usercomp['basic_salary'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= $usercomp['net_salary'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?= $usercomp['ipr'] ?></span>
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
    var isDataFiltered = false;

    document.getElementById('download-pdf-dgi').addEventListener('click', async function(event) {
        var button = event.currentTarget;
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;
        // Création de l'objet userData avec l'année et le mois
        // Choisir entre allUsersData et filteredUserData
        var userData = {
            year: year,
            month: month,
            users: isDataFiltered ? filteredUserData : allUsersData
        };

        console.log("isDataFiltered:", isDataFiltered);
        // Stocker les données dans sessionStorage
        sessionStorage.setItem('userData', JSON.stringify(userData));


        try {
            let response = await fetch('<?= URL; ?>company/generatedgiPdfAjax', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            let result = await response.json();

            // Ouvrir l'URL de redirection reçue du serveur
            if (result.redirectUrl) {
                window.open(result.redirectUrl, '_blank');
            } else {
                alert('Pas d\'URL de redirection reçue');
            }
        } catch (error) {
            alert('Erreur lors de l\'envoi des données:', error);
        }
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
    var filteredUserData = []; // Variable globale pour stocker les données filtrées
    document.getElementById('dgiData').addEventListener('click', function() {
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= URL; ?>company/dgi_searchData', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                var response = JSON.parse(this.responseText);
                filteredUserData = response;
                console.log("filteredUserData:", filteredUserData);

                isDataFiltered = true;
            }
        };
        xhr.send('year=' + year + '&month=' + month);
    });
</script>


<script>
    function filterData() {
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;

        console.log("Année : " + year); // Affiche l'année dans la console
        console.log("Mois : " + month); // Affiche le mois dans la console

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= URL; ?>company/dgi_search', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('paiement_users').innerHTML = this.responseText;
            }
        };
        xhr.send('year=' + year + '&month=' + month);
    }
</script>

<?php include_once './views/include/footer.php' ?>