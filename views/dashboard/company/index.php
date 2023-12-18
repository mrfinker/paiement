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
// $totalDepense = $dashboardModel->getTotalDepenseAmount();
// $totalDepots = $dashboardModel->getTotalDepotsAmount();
$userc = $dashboardModel->getAllUsersByCreatorAndCompany();
$usersComp = $dashboardModel->getTotalUsersByCompanyId();
$NetSalary = $dashboardModel->getSumNetSalaryByCompanyId();
$totalDepense = $dashboardModel->getTotalDGIAmount();
$totalDepots = $dashboardModel->getTotalCnssCompanyAmount();
$totalIere = $dashboardModel->getTotalIereAmount();
$totalInpp = $dashboardModel->getTotalInppAmount();
$TotalOnem = $dashboardModel->getTotalOnemAmount();
$totalBruteCompany = $dashboardModel->getTotalBruteCompanyAmount();
// $monthlyDepenses = $dashboardModel->getMonthlyDepenseAmount();
$monthlyDepenses = $dashboardModel->getMonthlyDGIAmount();
// print_r($monthlyDepenses);
$monthlyDepots = $dashboardModel->getMonthlyCnssCompanyAmount();
// print_r($monthlyDepots);
$monthlyIere = $dashboardModel->getMonthlyIereAmount();
$monthlyInpp = $dashboardModel->getMonthlyInppAmount();
$monthlyOnem = $dashboardModel->getMonthlyOnemAmount();
$monthlySalaryBrutCompany = $dashboardModel->getMonthlyBruteCompanyAmount();
$monthlySalaryNetCompany = $dashboardModel->getMonthlyNetSalaryAmount();

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


function generateColorFromName($name)
{
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

$colorsDep = array_map(function ($name) {
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

$colorsDes = array_map(function ($name) {
    return generateColorFromName($name);
}, $designationNames);

$colorsJsonDep = json_encode($colorsDep);
$colorsJsonDes = json_encode($colorsDes);



$depenseData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros
foreach ($monthlyDepenses as $depense) {
    $monthIndex = $depense['monthyaer'] - 1;
    $depenseData[$monthIndex] = (float)$depense['total_amount'];
}
$depotsData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros
foreach ($monthlyDepots as $depots) {
    $monthIndex = $depots['monthyaer'] - 1;
    $depotsData[$monthIndex] = (float)$depots['total_amount'];
}
$iereData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros
foreach ($monthlyIere as $depots) {
    $monthIndex = $depots['monthyaer'] - 1;
    $iereData[$monthIndex] = (float)$depots['total_amount'];
}
$inppData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros
foreach ($monthlyInpp as $depots) {
    $monthIndex = $depots['monthyaer'] - 1;
    $inppData[$monthIndex] = (float)$depots['total_amount'];
}
$onemData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros
foreach ($monthlyOnem as $depots) {
    $monthIndex = $depots['monthyaer'] - 1;
    $onemData[$monthIndex] = (float)$depots['total_amount'];
}
$salaryBrutCompanyData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros
foreach ($monthlySalaryBrutCompany as $depots) {
    $monthIndex = $depots['monthyaer'] - 1;
    $salaryBrutCompanyData[$monthIndex] = (float)$depots['total_amount'];
}
$salaryNetData = array_fill(0, 12, 0); // Crée un tableau avec 12 zéros
foreach ($monthlySalaryNetCompany as $depots) {
    $monthIndex = $depots['monthyaer'] - 1;
    $salaryNetData[$monthIndex] = (float)$depots['total_amount'];
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
<div class="nk-content step1">
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

                    <div class="col-lg-3 col-sm-6 step4">
                        <div class="card card-bordered">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total employer</h6>
                                        <h5 class="sub-title"><?= $usersComp ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 step5">
                        <div class="card card-bordered">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total payers</h6>
                                        <h5 class="sub-title">
                                            <?= $NetSalary ?>
                                            <span>$</span>
                                        </h5>
                                        <p style="font-size: small; font-weight: 600; position:absolute">
                                            <?= $NetSalary * 2600 ?>
                                            <span>FC</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 step20">
                        <div class="card card-bordered ">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total CNSS Company</h6>
                                        <h5 class="sub-title"><?= $totalDepots; ?>
                                            <span>$</span>
                                        </h5>
                                        <p style="font-size: small; font-weight: 600; position:absolute">
                                            <?= $totalDepots * 2600 ?>
                                            <span>FC</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 step21">
                        <div class="card card-bordered">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total DGI</h6>
                                        <h5 class="sub-title"><?= $totalDepense; ?>
                                            <span>$</span>
                                        </h5>
                                        <p style="font-size: small; font-weight: 600; position:absolute">
                                            <?= $totalDepense * 2600 ?>
                                            <span>FC</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 step22">
                        <div class="card card-bordered ">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total IERE</h6>
                                        <h5 class="sub-title"><?= $totalIere; ?>
                                            <span>$</span>
                                        </h5>
                                        <p style="font-size: small; font-weight: 600; position:absolute">
                                            <?= $totalIere * 2600 ?>
                                            <span>FC</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 step23">
                        <div class="card card-bordered">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total INPP</h6>
                                        <h5 class="sub-title"><?= $totalInpp; ?>
                                            <span>$</span>
                                        </h5>
                                        <p style="font-size: small; font-weight: 600; position:absolute">
                                            <?= $totalInpp * 2600 ?>
                                            <span>FC</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 step24">
                        <div class="card card-bordered">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total ONEM</h6>
                                        <h5 class="sub-title">
                                            <?= $TotalOnem ?>
                                            <span>$</span>
                                        </h5>
                                        <p style="font-size: small; font-weight: 600; position:absolute">
                                            <?= $TotalOnem * 2600 ?>
                                            <span>FC</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 step25">
                        <div class="card card-bordered ">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Total Salaire brute Company</h6>
                                        <h5 class="sub-title"><?= $totalBruteCompany; ?>
                                            <span>$</span>
                                        </h5>
                                        <p style="font-size: small; font-weight: 600; position:absolute">
                                            <?= $totalBruteCompany * 2600 ?>
                                            <span>FC</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 step26">
                        <div class="card card-bordered">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Statistique DGI, IERE, INPP, ONEM et CNSS</h6>
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

                    <div class="col-lg-12 col-sm-12 step27">
                        <div class="card card-bordered">
                            <div class="card-body m-2">
                                <div class="row align-items-center mb-0">
                                    <div class="col">
                                        <h6 class="title">Statistique Salaire brut company et Paiements</h6>
                                        <div class="nk-ck">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas class="line-chart chartjs-render-monitor" id="line-chart2"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-12 step6">
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
                    <div class="col-lg-3 col-sm-12 step7">
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
                    <div class="col-lg-3 col-sm-12 step8">
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
                    <div class="col-lg-3 col-sm-12 step9">
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

<script type="text/javascript">
    // Récupérer la valeur de la session PHP
    var isFirstLogin = <?php echo json_encode(Session::get("CheckLogin")); ?>;
    var isRhLogin = <?php echo json_encode(Session::get("CheckRh")); ?>;
    console.log(isFirstLogin);
    console.log(isRhLogin);
    // Exécuter le script de visite guidée seulement si c'est le premier login
    if (isFirstLogin) {
        const driver = window.driver.js.driver;

        const driverObj = driver({
            showProgress: true,
            steps: [{
                    element: '.sidebar',
                    popover: {
                        title: 'Bienvenue dans e-paie',
                        description: 'Nous allons vous montrer les procedures d\'utilisations de l\'application, veuillez suivre etape par etape'
                    }
                },
                {
                    element: '.step2',
                    popover: {
                        title: 'Barre de menu',
                        description: 'Ceci est votre menu de navigation vous permettant de passer d\'un menu a un autre'
                    }
                },
                {
                    element: '.step3',
                    popover: {
                        title: 'Tableau de bord',
                        description: 'Ici c\'est la page princopale ou vous verrez tout les details de votre entreprise'
                    }
                },
                {
                    element: '.step4',
                    popover: {
                        title: 'Total employer',
                        description: 'Vous verrez ici les nombres totals de vos employers enregistrers dans l\'application'
                    }
                },
                {
                    element: '.step5',
                    popover: {
                        title: 'Total payer',
                        description: 'Vous verrez ici les nombres totals de vos paiement de salaire sur vos employers'
                    }
                },
                {
                    element: '.step20',
                    popover: {
                        title: 'Total payer CNSS',
                        description: 'Vous verrez ici les nombres totals de vos paiement de salaire sur vos employers en rapport avec la CNSS'
                    }
                },
                {
                    element: '.step21',
                    popover: {
                        title: 'Total payer DGI',
                        description: 'Vous verrez ici les nombres totals de vos paiement de salaire sur vos employers en rapports avec la DGI'
                    }
                },
                {
                    element: '.step22',
                    popover: {
                        title: 'Total payer IERE',
                        description: 'Vous verrez ici les nombres totals de vos paiement de salaire sur vos employers, en rapports avec IERE'
                    }
                },
                {
                    element: '.step23',
                    popover: {
                        title: 'Total payer INPP',
                        description: 'Vous verrez ici les nombres totals de vos paiement de salaire sur vos employers, en rapports avec INPP'
                    }
                },
                {
                    element: '.step24',
                    popover: {
                        title: 'Total payer ONEM',
                        description: 'Vous verrez ici les nombres totals de vos paiement de salaire sur vos employers, en rapports avec ONEM'
                    }
                },
                {
                    element: '.step25',
                    popover: {
                        title: 'Total salaire brut payer',
                        description: 'Vous verrez ici les nombres totals de vos paiement de salaire brut payer sur vos employers'
                    }
                },
                {
                    element: '.step26',
                    popover: {
                        title: 'Total fiscalité payer',
                        description: 'Vous verrez ici le statistique totals de vos paiement en rapports avec la fiscalité comme la DGI, IERE, INPP, ONEM et CNSS'
                    }
                },
                {
                    element: '.step27',
                    popover: {
                        title: 'Total salaire brut et paiement',
                        description: 'Vous verrez ici les statistiques totals de vos paiement de salaire brut et des salaires net sur vos employers'
                    }
                },
                {
                    element: '.step6',
                    popover: {
                        title: 'Total presence',
                        description: 'Vous verrez ici les nombres totals de presence de vos employers durant la semaine'
                    }
                },
                {
                    element: '.step7',
                    popover: {
                        title: 'Total par genre',
                        description: 'Vous verrez ici les nombres totals des personnes dans la compagnie par genre'
                    }
                },
                {
                    element: '.step8',
                    popover: {
                        title: 'Total par departement',
                        description: 'Vous verrez ici les nombres totals des personnes dans chaque departements'
                    }
                },
                {
                    element: '.step9',
                    popover: {
                        title: 'Total par branche',
                        description: 'Vous verrez ici les nombres totals des personnes dans chaque branche d\'un departements'
                    }
                },
                {
                    element: '.step10',
                    popover: {
                        title: 'Menu employer',
                        description: 'C\'est ici que vous allez avoir la possibilité de cree un utilisateur et aussi le temps de travail, veuillez cliquez ce bouton, puis Next !!!'
                    }
                },
                {
                    element: '.step15',
                    popover: {
                        title: 'Sous-menu employer',
                        description: 'Voici les sous-menu lier a ce menu qui vous permettrons de cree un utilisateur et le temps de travail'
                    }
                },
                {
                    element: '.step11',
                    popover: {
                        title: 'Menu Ressources humaines',
                        description: 'C\'est ici que vous allez avoir la possibilité de cree un departement, sa branche, mettre les presences et faire les rapports de presence du mois, veuillez cliquez ce bouton, puis Next !!!'
                    }
                },
                {
                    element: '.step16',
                    popover: {
                        title: 'Sous-menu Ressources humaines',
                        description: 'Voici les sous-menu lier a ce menu qui vous permettrons de cree un departement, sa branche, mettre les presences et faire les rapports de presence du mois'
                    }
                },
                {
                    element: '.step12',
                    popover: {
                        title: 'Menu Fiscalité',
                        description: 'C\'est ici que vous allez avoir la possibilité de cree des fichiers lier au fisc, comme la DGI, CNPP, ONEM, CNSS, veuillez cliquez ce bouton, puis Next !!!'
                    }
                },
                {
                    element: '.step17',
                    popover: {
                        title: 'sous-menu Fiscalité',
                        description: 'Voici les sous-menu lier a ce menu qui vous permettrons de cree des fichiers lier au fisc, comme la DGI, CNPP, ONEM, CNSS'
                    }
                },
                {
                    element: '.step13',
                    popover: {
                        title: 'Menu Paie',
                        description: 'C\'est ici que vous allez avoir la possibilité de cree des fichiers lier au paiement pour chaque utilisateur, l\'historique de paie, l\'historique annuel et les avances sur salaires, veuillez cliquez ce bouton, puis Next !!!'
                    }
                },
                {
                    element: '.step18',
                    popover: {
                        title: 'Sous-menu Paie',
                        description: 'Voici les sous-menu lier a ce menu qui vous permettrons de cree des fichiers lier au paiement pour chaque utilisateur, l\'historique de paie, l\'historique annuel et les avances sur salaires'
                    }
                },
                {
                    element: '.step14',
                    popover: {
                        title: 'Profile',
                        description: 'Grace a cette partie vous aurez la possibilité d\'entrer dans votre profil et de faire de mise a jour, veuillez cliquez ce bouton, puis Next !!!'
                    }
                },
                {
                    element: '.step19',
                    popover: {
                        title: 'Menu profile',
                        description: 'Grace a cette partie vous aurez la possibilité de voir votre profile, administrer le role et les privileges des utilisateurs ou de se deconnecter'
                    }
                },
                {
                    element: '.sidebar',
                    popover: {
                        title: 'Bonne suite',
                        description: 'Merci pour votre attention, Linked-solution vous souhaite la bienvenue, dans votre nouvelle application !'
                    }
                },
            ],

            onDestroyStarted: () => {
                if (!driverObj.hasNextStep() || confirm("Etes-vous sure de vouloir quitter ?")) {
                    driverObj.destroy();
                }
            },
        });

        driverObj.drive();

        // Mettre à jour la valeur de la session en AJAX
        fetch('<?= URL; ?>dashboard/updateSession', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'updateSession=true'
            }).then(response => response.json())
            .then(data => console.log(data.message));

    }
</script>