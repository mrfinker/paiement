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
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div
                                    id="DataTables_Table_1_wrapper"
                                    style="overflow: auto; width: 100%;"
                                    class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <table
                                        class=" nk-tb-list nk-tb-ulist dataTable no-footer"
                                        data-auto-responsive="false"
                                        id="DataTables_Table_1"
                                        aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col tb-col-mb">Jours</th>
                                                <?php for ($i = 1; $i <= $daysInCurrentMonth; $i++): ?>
                                                    <th class="nk-tb-col tb-col-md"><?= $i ?></th>
                                                <?php endfor; ?>
                                            </tr>

                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col tb-col-mb">Employer</th>
                                                <?php foreach ($daysInMonth as $day): ?>
                                                    <?php 
                                                    // Convertir le numéro du jour en jour de la semaine (Mon, Tue, etc.)
                                                    $dayOfWeek = date('D', strtotime("$currentYear-$currentMonth-$day"));
                                                    ?>
                                                    <th class="nk-tb-col tb-col-md"><?= $dayOfWeek ?></th>
                                                <?php endforeach; ?>
                                                    <th class="nk-tb-col tb-col-md"> jours/mois</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                        <?php foreach ($userscompany as $users): 
                                            $timesheetData = $companyModel->getCurrentMonthTimesheetsByCreatorAndCompany($users['id']);
                                            $timesheetDays = $timesheetData['days'];
                                            $officeShift = $timesheetData['officeShift'];
                                            $daysPerWeek = $officeShift['total_time'] / 8; // Combien de jours la total_time représente par semaine
$daysPerMonth = $daysPerWeek * 4; // Multiplier par le nombre moyen de semaines dans un mois

                                        ?>
                                            <tr class="nk-tb-item odd">
    <td class="nk-tb-col tb-col-mb">
        <span class="tb-amount"><?=$users['name']?></span>
    </td>
    <?php for ($i = 1; $i <= 31; $i++): ?>
        <td class="nk-tb-col tb-col-md">
        <?php 
        $dayKeyIn = strtolower(date('l', strtotime(date('Y-m') . '-' . $i))) . '_in_time';
        $dayKeyOut = strtolower(date('l', strtotime(date('Y-m') . '-' . $i))) . '_out_time';
        ?>
        <?php 
    if (isset($timesheetDays[$i]) && $timesheetDays[$i] == 'P') {
        echo '<span class="badge badge-dim bg-success">P</span>';
    } elseif (isset($officeShift[$dayKeyIn]) && empty($officeShift[$dayKeyIn]) && 
              isset($officeShift[$dayKeyOut]) && empty($officeShift[$dayKeyOut])) {
        echo '<span class="badge badge-dim bg-primary">D</span>';
    } else {
        echo '<span class="badge badge-dim bg-danger">A</span>';
    }
?>

        </td>
    <?php endfor; ?>
    <!-- Afficher le total_time pour chaque utilisateur -->
    <td class="nk-tb-col tb-col-md">
    <?= intval($daysPerMonth) ?>
    
</td>

</tr>

                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-7 col-sm-12 col-md-9">
                                        <div
                                            class="dataTables_paginate paging_simple_numbers"
                                            id="DataTables_Table_1_paginate">
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

<?php include_once './views/include/footer.php' ?>