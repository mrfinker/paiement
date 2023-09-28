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
$userc = $dashboardModel->getAllUsersByCreatorAndCompany();
$usersComp = $dashboardModel->getTotalUsersByCompanyId();
$userscompany = $userc['users'];
$maleCount = $userc['maleCount'];
$femaleCount = $userc['femaleCount'];


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
                                            <h4 class="sub-title">100000
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
                                            <h4 class="sub-title">100000
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
                                            <h4 class="sub-title">100000
                                                <span>$</span></h4>
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
                                            <h6 class="title">Statistique depenses/payer/deposer</h6>
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