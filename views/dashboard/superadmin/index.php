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



?>
<!DOCTYPE html>
<html lang="zxx" class="js">

    <head>
        <base href="../">
        <meta charset="utf-8">
        <meta name="author" content="Softnio">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta
            name="description"
            content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
        <!-- Fav Icon -->
        <link rel="shortcut icon" href="<?=URL?>public/images/favicon.png">
        <!-- Page Title -->
        <title>superadmin | dashboard</title>
        <!-- StyleSheets -->
        <link rel="stylesheet" href="<?=URL?>public/assets/css/dashlite.css?ver=3.2.0">
        <link
            id="skin-default"
            rel="stylesheet"
            href="<?=URL?>public/assets/css/theme.css?ver=3.2.0">
    </head>

    <body class="nk-body bg-lighter ">
        <div class="nk-app-root">
            <?php
// include('./message.php')
?>
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger me-sm-2 d-lg-none">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav">
                                    <em class="icon ni ni-menu"></em>
                                </a>
                            </div>
                            <div class="nk-header-brand">
                                <a href="html/index.html" class="logo-link">
                                    <img
                                        class="logo-light logo-img"
                                        src="<?=URL?>public/images/logo.png"
                                        srcset="<?=URL?>images/logo2x.png 2x"
                                        alt="logo">
                                    <img
                                        class="logo-dark logo-img"
                                        src="<?=URL?>public/images/logo-dark.png"
                                        srcset="<?=URL?>public/images/logo-dark2x.png 2x"
                                        alt="logo-dark">
                                </a>
                            </div>
                            <!-- .nk-header-brand -->
                            <div class="nk-header-menu ms-auto" data-content="headerNav">
                                <div class="nk-header-mobile">
                                    <div class="nk-header-brand">
                                        <a href="html/index.html" class="logo-link">
                                            <img
                                                class="logo-light logo-img"
                                                src="<?=URL?>public/images/logo.png"
                                                srcset="<?=URL?>public/images/logo2x.png 2x"
                                                alt="logo">
                                            <img
                                                class="logo-dark logo-img"
                                                src="<?=URL?>images/logo-dark.png"
                                                srcset="<?=URL?>images/logo-dark2x.png 2x"
                                                alt="logo-dark">
                                        </a>
                                    </div>
                                    <div class="nk-menu-trigger me-n2">
                                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav">
                                            <em class="icon ni ni-arrow-left"></em>
                                        </a>
                                    </div>
                                </div>
                                <ul class="nk-menu nk-menu-main ui-s2">
                                    <li class="nk-menu-item has-sub">
                                        <a href="<?=URL?>dashboard/superadmin" class="nk-menu-link">
                                            <span class="nk-menu-text">Dashboards</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-text">Utilisateurs</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="html/index.html" class="nk-menu-link">
                                                    <span class="nk-menu-text">Affectations des privileges</span>
                                                </a>
                                            </li><!-- .nk-menu-item -->
                                            <li class="nk-menu-item">
                                                <a href="html/index-sales.html" class="nk-menu-link">
                                                    <span class="nk-menu-text">Administrations</span>
                                                </a>
                                            </li>
                                            <!-- .nk-menu-item -->
                                            </li><!-- .nk-menu-item -->
                                            <li class="nk-menu-item">
                                                <a href="html/index-sales.html" class="nk-menu-link">
                                                    <span class="nk-menu-text">Compagnies</span>
                                                </a>
                                            </li>
                                            <!-- .nk-menu-item -->
                                        </ul><!-- .nk-menu-sub -->
                                    </li><!-- .nk-menu-item -->
                                </ul>
                                <!-- .nk-menu -->
                            </div>
                            <!-- .nk-header-menu -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                            </div>
                                        </a>
                                        <div
                                            class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <span>AB</span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?=$user['username']?></span>
                                                        <span class="sub-text"><?=$user['email']?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a href="<?=URL?>profile/superadmin">
                                                            <em class="icon ni ni-user-alt"></em>
                                                            <span>View Profile</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a id="logout_btn" href="<?=URL?>login/logout">
                                                            <em class="icon ni ni-signout"></em>
                                                            <span>Deconnexion</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- .dropdown -->
                                </ul>
                                <!-- .nk-quick-nav -->
                            </div>
                            <!-- .nk-header-tools -->
                        </div>
                        <!-- .nk-header-wrap -->
                    </div>
                    <!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->

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
                                                    <?=$user['name']?></p>
                                            </div>
                                        </div>
                                        <!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a
                                                    href="#"
                                                    class="btn btn-icon btn-trigger toggle-expand me-n1"
                                                    data-target="pageMenu">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li>
                                                            <div class="drodown">
                                                                <a
                                                                    href="#"
                                                                    class="dropdown-toggle btn btn-white btn-dim btn-outline-light"
                                                                    data-bs-toggle="dropdown"
                                                                    aria-expanded="false">
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
                                                <div class="col-lg-6 col-xxl-12">
                                                    <div class="card card-bordered">
                                                        <div class="card-inner">
                                                            <div class="card-title-group align-start mb-2">
                                                                <div class="card-title">
                                                                    <h6 class="title">Les abonnements</h6>
                                                                    <p>Revenue de 30 derniers jours.</p>
                                                                </div>
                                                                <div class="card-tools">
                                                                    <em
                                                                        class="card-hint icon ni ni-help-fill"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="left"
                                                                        aria-label="Revenue des abonnements"
                                                                        data-bs-original-title="Revenue des abonnements"></em>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                                                <div class="nk-sale-data-group flex-md-nowrap g-4">
                                                                    <div class="nk-sale-data">
                                                                        <span class="amount">59
                                                                            <span class="change down text-danger">
                                                                                <em class="icon ni ni-arrow-long-down"></em>16.93%</span></span>
                                                                        <span class="sub-title">Ce mois</span>
                                                                    </div>
                                                                    <div class="nk-sale-data">
                                                                        <span class="amount">29
                                                                            <span class="change up text-success">
                                                                                <em class="icon ni ni-arrow-long-up"></em>4.26%</span></span>
                                                                        <span class="sub-title">Cette semaine</span>
                                                                    </div>
                                                                </div>
                                                                <div class="nk-sales-ck sales-revenue">
                                                                    <div class="chartjs-size-monitor">
                                                                        <div class="chartjs-size-monitor-expand">
                                                                            <div class=""></div>
                                                                        </div>
                                                                        <div class="chartjs-size-monitor-shrink">
                                                                            <div class=""></div>
                                                                        </div>
                                                                    </div>
                                                                    <canvas
                                                                        class="sales-bar-chart chartjs-render-monitor"
                                                                        id="salesRevenue"
                                                                        style="display: block; width: 603px; height: 148px;"
                                                                        width="603"
                                                                        height="148"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- .col -->
                                                <div class="col-lg-6 col-xxl-12">
                                                    <div class="row g-gs">
                                                        <div class="col-sm-6 col-lg-12 col-xxl-6">
                                                            <div class="card card-bordered">
                                                                <div class="card-inner">
                                                                    <div class="card-title-group align-start mb-2">
                                                                        <div class="card-title">
                                                                            <h6 class="title">Nombre total d'abonnements</h6>
                                                                        </div>
                                                                        <div class="card-tools">
                                                                            <em
                                                                                class="card-hint icon ni ni-help-fill"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="left"
                                                                                aria-label="Total abonnements"
                                                                                data-bs-original-title="Total abonnements"></em>
                                                                        </div>
                                                                    </div>
                                                                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                                        <div class="nk-sale-data">
                                                                            <span class="amount">945</span>
                                                                            <span class="sub-title">
                                                                                <span class="change down text-danger">
                                                                                    <em class="icon ni ni-arrow-long-down"></em>1.93%</span>par raport au mois passés</span>
                                                                        </div>
                                                                        <div class="nk-sales-ck">
                                                                            <div class="chartjs-size-monitor">
                                                                                <div class="chartjs-size-monitor-expand">
                                                                                    <div class=""></div>
                                                                                </div>
                                                                                <div class="chartjs-size-monitor-shrink">
                                                                                    <div class=""></div>
                                                                                </div>
                                                                            </div>
                                                                            <canvas
                                                                                class="sales-bar-chart chartjs-render-monitor"
                                                                                id="activeSubscription"
                                                                                style="display: block; width: 438px; height: 56px;"
                                                                                width="438"
                                                                                height="56"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- .card -->
                                                        </div>
                                                        <!-- .col -->
                                                        <div class="col-sm-6 col-lg-12 col-xxl-6">
                                                            <div class="card card-bordered">
                                                                <div class="card-inner">
                                                                    <div class="card-title-group align-start mb-2">
                                                                        <div class="card-title">
                                                                            <h6 class="title">Moyenne d'abonnements</h6>
                                                                        </div>
                                                                        <div class="card-tools">
                                                                            <em
                                                                                class="card-hint icon ni ni-help-fill"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="left"
                                                                                aria-label="Abonnements moyenn par semaine"
                                                                                data-bs-original-title="Abonnements moyenne par semaine"></em>
                                                                        </div>
                                                                    </div>
                                                                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                                        <div class="nk-sale-data">
                                                                            <span class="amount">346</span>
                                                                            <span class="sub-title">
                                                                                <span class="change up text-success">
                                                                                    <em class="icon ni ni-arrow-long-up"></em>2.45%</span>debut de cette semaine</span>
                                                                        </div>
                                                                        <div class="nk-sales-ck">
                                                                            <div class="chartjs-size-monitor">
                                                                                <div class="chartjs-size-monitor-expand">
                                                                                    <div class=""></div>
                                                                                </div>
                                                                                <div class="chartjs-size-monitor-shrink">
                                                                                    <div class=""></div>
                                                                                </div>
                                                                            </div>
                                                                            <canvas
                                                                                class="sales-bar-chart chartjs-render-monitor"
                                                                                id="totalSubscription"
                                                                                style="display: block; width: 445px; height: 56px;"
                                                                                width="445"
                                                                                height="56"></canvas>
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
                                        <div class="col-xxl-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Vue d'ensemble</h6>
                                                            <p>Abonnements des 30 derniers jours
                                                            </p>
                                                        </div>
                                                        <div class="card-tools">
                                                            <div class="dropdown">
                                                                <a
                                                                    href="#"
                                                                    class="btn btn-primary btn-dim d-none d-sm-inline-flex"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-download-cloud"></em><span><span class="d-none d-md-inline">Telecharger</span>
                                                                        le rapport</span></a>
                                                                <a
                                                                    href="#"
                                                                    class="btn btn-icon btn-primary btn-dim d-sm-none"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-download-cloud"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li>
                                                                            <a href="#">
                                                                                <span>Version PDF</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <span>Version EXCEL</span></a>
                                                                        </li>
                                                                        <li class="divider"></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                                        <div class="nk-sale-data">
                                                            <span class="amount">$82,944.60</span>
                                                        </div>
                                                        <div class="nk-sale-data">
                                                            <span class="amount sm">9852
                                                                <small>personnes dans la platforme</small>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="nk-sales-ck large pt-4">
                                                        <div class="chartjs-size-monitor">
                                                            <div class="chartjs-size-monitor-expand">
                                                                <div class=""></div>
                                                            </div>
                                                            <div class="chartjs-size-monitor-shrink">
                                                                <div class=""></div>
                                                            </div>
                                                        </div>
                                                        <canvas
                                                            class="sales-overview-chart chartjs-render-monitor"
                                                            id="salesOverview"
                                                            style="display: block; width: 1283px; height: 176px;"
                                                            width="1283"
                                                            height="176"></canvas>
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
                                                                <span>No.</span></div>
                                                            <div class="nk-tb-col tb-col-sm">
                                                                <span>Compagnie</span></div>
                                                            <div class="nk-tb-col tb-col-md">
                                                                <span>Date</span></div>
                                                            <div class="nk-tb-col tb-col-lg">
                                                                <span>Reference</span></div>
                                                            <div class="nk-tb-col">
                                                                <span>Montant</span></div>
                                                            <div class="nk-tb-col">
                                                                <span class="d-none d-sm-inline">Status</span></div>
                                                            <div class="nk-tb-col">
                                                                <span>&nbsp;</span></div>
                                                        </div>
                                                        <?php foreach ($users as $user): ?>
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
<?php endforeach;?>

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
                                                                    <a
                                                                        href="#"
                                                                        class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
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
                                                                    <a
                                                                        href="#"
                                                                        class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
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
                                                                    <a
                                                                        href="#"
                                                                        class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
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

        <script src="<?=URL?>public/assets/js/bundle.js?ver=3.2.0"></script>
        <script src="<?=URL?>public/assets/js/scripts.js?ver=3.2.0"></script>
        <script src="<?=URL?>public/assets/js/charts/gd-default.js?ver=3.2.0"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>

    <?php
if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script src="' . URL . 'views/' . $js . '"></script>';
    }
}
?>

</html>