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

if (isset($user['id'])) {
    $userId = $user['id'];
    $dashboardModel = new dashboard_model();
    $message = $dashboardModel->checkLastLoginDate($userId);
} else {
    $message = "Utilisateur introuvable";
}

$dashboardModel = new dashboard_model();
$monthlyDepenses = $dashboardModel->getMonthlyDepenseAmount();
$userc = $dashboardModel->getAllUsersByCreatorAndCompany();
$usersComp = $dashboardModel->getTotalUsersByCompanyId();
$NetSalary = $dashboardModel->getSumNetSalaryByCompanyId();
$totalDepense = $dashboardModel->getTotalDepenseAmount();
$totalDepots = $dashboardModel->getTotalDepotsAmount();
$monthlyDepots = $dashboardModel->getMonthlyDepotsAmount();

$userscompany = $userc['users'];
$maleCount = $userc['maleCount'];
$femaleCount = $userc['femaleCount'];

$departmentUserCount = $dashboardModel->getTotalUsersByDepartementsId();
$departmentNames = [];
$DepartmentUsersCount = [];

foreach ($departmentUserCount as $department) {
    $departmentNames[] = $department['department_name'];
    $DepartmentUsersCount[] = $department['user_count'];
}
$departmentNamesJson = json_encode($departmentNames);
$DepartmentUsersCountJson = json_encode($DepartmentUsersCount);


function generateColorFromName($name) {
    $hash = md5($name);  // Convertir le nom en un hash md5
    
    // Prendre les 6 premiers caractères du hash pour les convertir en valeurs RGB
    $r = hexdec(substr($hash, 0, 2));
    $g = hexdec(substr($hash, 2, 2));
    $b = hexdec(substr($hash, 4, 2));
    
    // Augmenter la luminosité pour rendre la couleur plus pâle
    $factor = 1.5; // Vous pouvez ajuster cette valeur
    $r = min(125, $r * $factor);
    $g = min(125, $g * $factor);
    $b = min(255, $b * $factor);
    
    // Convertir les valeurs RGB en couleur hexadécimale
    $color = sprintf("#%02x%02x%02x", $r, $g, $b);
    
    return $color;
}

$colorsDep = array_map(function($name) {
    return generateColorFromName($name);
}, $departmentNames);

$designationUserCount = $dashboardModel->getTotalUsersByDesignation();

$designationNames = [];
$designationUsersCount = [];

foreach ($designationUserCount as $designation) {
    $designationNames[] = $designation['designation_name'];
    $designationUsersCount[] = $designation['user_count'];
}

$designationNamesJson = json_encode($designationNames);
$designationUsersCountJson = json_encode($designationUsersCount);

$colorsDes = array_map(function($name) {
    return generateColorFromName($name);
}, $designationNames);

$colorsJsonDep = json_encode($colorsDep);
$colorsJsonDes = json_encode($colorsDes);



$depenseData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros

foreach ($monthlyDepenses as $depense) {
    $monthIndex = $depense['month'] - 1;
    $depenseData[$monthIndex] = (float)$depense['total_amount'];
}
$depotsData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros

foreach ($monthlyDepots as $depots) {
    $monthIndex = $depots['month'] - 1;
    $depotsData[$monthIndex] = (float)$depots['total_amount'];
}

$attendanceData = $dashboardModel->getWeeklyAttendance();

$today = date('N');  // Le numéro du jour actuel (1 = lundi, 7 = dimanche)

foreach (["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"] as $key => $day) {
    // Calculez le décalage pour chaque jour
    $offset = $key + 1 - $today;
    $date = date('Y-m-d', strtotime("$offset days"));
    
    if (isset($attendanceData[$date])) {
        $presents[] = $attendanceData[$date]['present'];
        $absents[] = $attendanceData[$date]['absent'];
    } else {
        $presents[] = 0;
        $absents[] = 0;
    }
}




?>
<?php include_once './views/include/header.php'; ?>

<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="alert alert-info alert-icon alert-dismissible">
                    <em class="icon ni ni-alert-circle"></em>
                    <strong><?= $message ?></strong>
                    <?= $user['name'] ?>
                    Faites un update de votre compagnie pour avoir plus d'avantage !
                    <button class="close" data-bs-dismiss="alert"></button>
                </div>

                <div class="row gy-4">

                    <div class="col-lg-3 col-sm-6">
                        <div class="card card- bg-warning-dim">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total employer</h6>
                                        <h4 class="sub-title"><?= $usersComp ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-bordered bg-info-dim">
                                <div class="card-body m-2">
                                    <div class="row align-items-center mb-0">
                                        <div class="col">
                                            <h6 class="title">Total deposer</h6>
                                            <h4 class="sub-title"><?= $totalDepots; ?>
                                                <span>$</span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-bordered bg-danger-dim">
                                <div class="card-body m-2">
                                    <div class="row align-items-center mb-0">
                                        <div class="col">
                                            <h6 class="title">Total depenser</h6>
                                            <h4 class="sub-title"><?= $totalDepense; ?>
                                                <span>$</span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-bordered bg-success-dim">
                                <div class="card-body m-2">
                                    <div class="row align-items-center mb-0">
                                    <div class="col">
    <h6 class="title">Total payers</h6>
    <h4 class="sub-title">
        <?= $NetSalary ?>
        <span>$</span>
    </h4>
</div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-sm-12">
                            <div class="card card-bordered">
                                <div class="card-body m-2">
                                    <div class="row align-items-center mb-0">
                                        <div class="col">
                                            <h6 class="title">Statistique des depenses et depots</h6>
                                            <div class="nk-ck">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <canvas class="line-chart chartjs-render-monitor" id="line-chart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-12">
                            <div class="card card-bordered">
                                <div class="card-body m-2">
                                    <div class="row align-items-center mb-0">
                                        <div class="col">
                                            <h6 class="title">Presence</h6>
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="presence" width="800" height="450"></canvas>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card card-bordered">
                                <div class="card-body m-2">
                                    <div class="row align-items-center mb-0">
                                        <div class="col">
                                            <h6 class="title">Sexe</h6>
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="sexe" width="800" height="450"></canvas>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card card-bordered">
                                <div class="card-body m-2">
                                    <div class="row align-items-center mb-0">
                                        <div class="col">
                                            <h6 class="title">Departements</h6>
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="doughnut-chart" width="800" height="450"></canvas>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card card-bordered">
                                <div class="card-body m-2">
                                    <div class="row align-items-center mb-0">
                                        <div class="col">
                                            <h6 class="title">Branches</h6>
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="pie-chart" width="800" height="450"></canvas>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include_once './views/include/footer.php' ?>