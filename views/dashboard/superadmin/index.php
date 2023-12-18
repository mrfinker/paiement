<?php
Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location" . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "superadmin") {
    header('Location: ' . ERROR);
    exit;
}

$dashboardModel = new Dashboard_model();
$users = $dashboardModel->threeLast($_SESSION[('users')]['id']);

?>

<?php include_once("./views/include/header.php") ?>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Dashboard</h3>
                            <div class="nk-block-des text-soft">
                                <p>Bonjour
                                    <?= $user['name'] ?></p>
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                                    <em class="icon ni ni-more-v"></em>
                                </a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <em class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span class="d-none d-md-inline">Derniers</span>
                                                        30 Jours</span>
                                                    <em class="dd-indc icon ni ni-chevron-right"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li>
                                                            <a href="#">
                                                                <span> 30 jours</span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <span> 6 Mois</span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <span> 1 Année</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                    </div>
                    <!-- .nk-block-between -->
                </div>
                <!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-xxl-6">
                            <div class="row g-gs">
                                <div class="col-lg-4 col-xxl-4">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-2">
                                                <div class="card-title">
                                                    <h6 class="title">Les abonnements</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Revenue des abonnements" data-bs-original-title="Revenue des abonnements"></em>
                                                </div>
                                            </div>
                                            <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                                <div class="nk-sale-data-group flex-md-nowrap g-4">
                                                    <div class="nk-sale-data">
                                                        <span class="amount">59</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- .col -->
                                <div class="col-lg-6 col-xxl-12">
                                    <div class="row g-gs">
                                        <div class="col-sm-6 col-lg-8 col-xxl-4">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start mb-2">
                                                        <div class="card-title">
                                                            <h6 class="title">Nombre total d'abonnements</h6>
                                                        </div>
                                                        <div class="card-tools">
                                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Total abonnements" data-bs-original-title="Total abonnements"></em>
                                                        </div>
                                                    </div>
                                                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                        <div class="nk-sale-data">
                                                            <span class="amount">945</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- .card -->
                                        </div>
                                        <!-- .col -->
                                        <div class="col-sm-6 col-lg-8 col-xxl-4">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start mb-2">
                                                        <div class="card-title">
                                                            <h6 class="title">Moyenne d'abonnements</h6>
                                                        </div>
                                                        <div class="card-tools">
                                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Abonnements moyenn par semaine" data-bs-original-title="Abonnements moyenne par semaine"></em>
                                                        </div>
                                                    </div>
                                                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                        <div class="nk-sale-data">
                                                            <span class="amount">346</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- .card -->
                                        </div>
                                        <!-- .col -->
                                    </div>
                                    <!-- .row -->
                                </div>
                                <!-- .col -->
                            </div>
                            <!-- .row -->
                        </div>
                        <!-- .col -->
                        <div class="col-sm-6 col-lg-8 col-xxl-4">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-2">
                                        <div class="card-title">
                                            <h6 class="title">Moyenne d'abonnements</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Abonnements moyenn par semaine" data-bs-original-title="Abonnements moyenne par semaine"></em>
                                        </div>
                                    </div>
                                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                        <div class="nk-sale-data">
                                            <span class="amount">346</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- .card -->
                        </div>
                        <!-- .col -->
                        <div class="col-xxl-8">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">
                                                <span class="me-2">Paiment</span>
                                            </h6>
                                        </div>
                                        <div class="card-tools">
                                            <ul class="card-tools-nav">
                                                <li class="active">
                                                    <a href="#">
                                                        <span>Tout</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-inner p-0 border-top">
                                    <div class="nk-tb-list nk-tb-orders">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col">
                                                <span>No.</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm">
                                                <span>Compagnie</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                                <span>Date</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-lg">
                                                <span>Reference</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>Montant</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span class="d-none d-sm-inline">Status</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>&nbsp;</span>
                                            </div>
                                        </div>
                                        <?php foreach ($users as $user) : ?>
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead">
                                                        <a href="#">#<?= $user['id'] ?></a>
                                                    </span>
                                                </div>
                                                <div class="nk-tb-col tb-col-sm">
                                                    <div class="user-card">
                                                        <div class="user-avatar user-avatar-sm bg-azure">
                                                            <span>DE</span>
                                                        </div>
                                                        <div class="user-name">
                                                            <span class="tb-lead"><?= $user['username'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub"><?= $user['created_at'] ?></span>
                                                </div>
                                                <div class="nk-tb-col tb-col-lg">
                                                    <span class="tb-sub text-primary">SUB-2309154</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="tb-sub tb-amount">596.75
                                                        <span>USD</span>
                                                    </span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dot badge-dot-xs bg-danger">Annuler</span>
                                                </div>
                                                <div class="nk-tb-col nk-tb-col-action">
                                                    <div class="dropdown">
                                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                            <em class="icon ni ni-more-h"></em>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                            <ul class="link-list-plain">
                                                                <li>
                                                                    <a href="#">Voir</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Supprimer</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                            <!-- .card -->
                        </div>
                        <!-- .col -->
                        <!-- .col -->
                        <div class="col-md-6 col-xxl-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Nouvelles utiliseurs</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>EB</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">ECOBANK</span>
                                                <span class="sub-text">info@ecobank.com</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="#">
                                                                    <em class="icon ni ni-setting"></em>
                                                                    <span>voir le profile</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-pink-dim">
                                                <span>FB</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">FBNBANK</span>
                                                <span class="sub-text">info@fbnbank.com</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="#">
                                                                    <em class="icon ni ni-setting"></em>
                                                                    <span>Voir le profile</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-warning-dim">
                                                <span>LS</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">LINKED-SOLUTION</span>
                                                <span class="sub-text">info@linked-solution.com</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="#">
                                                                    <em class="icon ni ni-setting"></em>
                                                                    <span>Voir le profil</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- .card -->
                        </div>
                    </div>
                    <!-- .row -->
                </div>
                <!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- JavaScript -->
</div>
<!-- wrap @e -->
</div>
<!-- app-root @e -->

<?php include_once("./views/include/footer.php") ?>