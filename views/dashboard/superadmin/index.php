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
        <link
            rel="stylesheet"
            href="<?=URL?>public/assets/css/dashlite.css?ver=3.2.0">
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
                                        srcset="<?=URL?>images/logo-dark2x.png 2x"
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
                                                src="<?=URL?>images/logo.png"
                                                srcset="<?=URL?>images/logo2x.png 2x"
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
                                        <a href="#" class="nk-menu-link">
                                            <span class="nk-menu-text">Dashboards</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link">
                                            <span class="nk-menu-text">Applications</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link">
                                            <span class="nk-menu-text">Pages</span>
                                        </a>
                                    </li>
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
                                                        <a href="<?=URL?>dashboard/superadmin/profile">
                                                            <em class="icon ni ni-user-alt"></em>
                                                            <span>View Profile</span></a>
                                                    </li>
                                                    <li>
                                                        <a href="html/user-profile-setting.html">
                                                            <em class="icon ni ni-setting-alt"></em>
                                                            <span>Account Setting</span></a>
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
                                            <p>Bonjour <?= $userType['name'] ?></p>
                                            <p>Analyse de votre systeme</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li>
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span class="d-none d-md-inline">Last</span> 30 Days</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-end" style="">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><span>Last 30 Days</span></a></li>
                                                                    <li><a href="#"><span>Last 6 Months</span></a></li>
                                                                    <li><a href="#"><span>Last 1 Years</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-reports"></em><span>Reports</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <div class="col-xxl-6">
                                        <div class="row g-gs">
                                            <div class="col-lg-6 col-xxl-12">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Sales Revenue</h6>
                                                                <p>In last 30 days revenue from subscription.</p>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Revenue from subscription" data-bs-original-title="Revenue from subscription"></em>
                                                            </div>
                                                        </div>
                                                        <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                                            <div class="nk-sale-data-group flex-md-nowrap g-4">
                                                                <div class="nk-sale-data">
                                                                    <span class="amount">59 <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>16.93%</span></span>
                                                                    <span class="sub-title">This Month</span>
                                                                </div>
                                                                <div class="nk-sale-data">
                                                                    <span class="amount">29 <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>4.26%</span></span>
                                                                    <span class="sub-title">This Week</span>
                                                                </div>
                                                            </div>
                                                            <div class="nk-sales-ck sales-revenue"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                                <canvas class="sales-bar-chart chartjs-render-monitor" id="salesRevenue" style="display: block; width: 603px; height: 148px;" width="603" height="148"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .col -->
                                            <div class="col-lg-6 col-xxl-12">
                                                <div class="row g-gs">
                                                    <div class="col-sm-6 col-lg-12 col-xxl-6">
                                                        <div class="card card-bordered">
                                                            <div class="card-inner">
                                                                <div class="card-title-group align-start mb-2">
                                                                    <div class="card-title">
                                                                        <h6 class="title">Active Subscriptions</h6>
                                                                    </div>
                                                                    <div class="card-tools">
                                                                        <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Total active subscription" data-bs-original-title="Total active subscription"></em>
                                                                    </div>
                                                                </div>
                                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                                    <div class="nk-sale-data">
                                                                        <span class="amount">9.69K</span>
                                                                        <span class="sub-title"><span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>1.93%</span>since last month</span>
                                                                    </div>
                                                                    <div class="nk-sales-ck"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                                        <canvas class="sales-bar-chart chartjs-render-monitor" id="activeSubscription" style="display: block; width: 438px; height: 56px;" width="438" height="56"></canvas>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- .card -->
                                                    </div><!-- .col -->
                                                    <div class="col-sm-6 col-lg-12 col-xxl-6">
                                                        <div class="card card-bordered">
                                                            <div class="card-inner">
                                                                <div class="card-title-group align-start mb-2">
                                                                    <div class="card-title">
                                                                        <h6 class="title">Avg Subscriptions</h6>
                                                                    </div>
                                                                    <div class="card-tools">
                                                                        <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Daily Avg. subscription" data-bs-original-title="Daily Avg. subscription"></em>
                                                                    </div>
                                                                </div>
                                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                                    <div class="nk-sale-data">
                                                                        <span class="amount">346.2</span>
                                                                        <span class="sub-title"><span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>2.45%</span>since last week</span>
                                                                    </div>
                                                                    <div class="nk-sales-ck"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                                        <canvas class="sales-bar-chart chartjs-render-monitor" id="totalSubscription" style="display: block; width: 445px; height: 56px;" width="445" height="56"></canvas>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- .card -->
                                                    </div><!-- .col -->
                                                </div><!-- .row -->
                                            </div><!-- .col -->
                                        </div><!-- .row -->
                                    </div><!-- .col -->
                                    <div class="col-xxl-6">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start gx-3 mb-3">
                                                    <div class="card-title">
                                                        <h6 class="title">Sales Overview</h6>
                                                        <p>In 30 days sales of product subscription. <a href="#">See Details</a></p>
                                                    </div>
                                                    <div class="card-tools">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-download-cloud"></em><span><span class="d-none d-md-inline">Download</span> Report</span></a>
                                                            <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-download-cloud"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><span>Download Mini Version</span></a></li>
                                                                    <li><a href="#"><span>Download Full Version</span></a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#"><em class="icon ni ni-opt-alt"></em><span>More Options</span></a></li>
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
                                                        <span class="amount sm">1,937 <small>Subscribers</small></span>
                                                    </div>
                                                </div>
                                                <div class="nk-sales-ck large pt-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                    <canvas class="sales-overview-chart chartjs-render-monitor" id="salesOverview" style="display: block; width: 1283px; height: 176px;" width="1283" height="176"></canvas>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-xxl-8">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title"><span class="me-2">Transaction</span> <a href="#" class="link d-none d-sm-inline">See History</a></h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <ul class="card-tools-nav">
                                                            <li><a href="#"><span>Paid</span></a></li>
                                                            <li><a href="#"><span>Pending</span></a></li>
                                                            <li class="active"><a href="#"><span>All</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner p-0 border-top">
                                                <div class="nk-tb-list nk-tb-orders">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col"><span>Order No.</span></div>
                                                        <div class="nk-tb-col tb-col-sm"><span>Customer</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                                        <div class="nk-tb-col tb-col-lg"><span>Ref</span></div>
                                                        <div class="nk-tb-col"><span>Amount</span></div>
                                                        <div class="nk-tb-col"><span class="d-none d-sm-inline">Status</span></div>
                                                        <div class="nk-tb-col"><span>&nbsp;</span></div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95954</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-purple">
                                                                    <span>AB</span>
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Abu Bin Ishtiyak</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">02/11/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2309232</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">4,596.75 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-success">Paid</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Invoice</a></li>
                                                                        <li><a href="#">Print</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95850</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-azure">
                                                                    <span>DE</span>
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Desiree Edwards</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">02/02/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2309154</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">596.75 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-danger">Canceled</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Remove</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95812</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-warning">
                                                                    <img src="./images/avatar/b-sm.jpg" alt="">
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Blanca Schultz</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">02/01/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2309143</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">199.99 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-success">Paid</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Invoice</a></li>
                                                                        <li><a href="#">Print</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95256</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-purple">
                                                                    <span>NL</span>
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Naomi Lawrence</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">01/29/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2305684</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">1099.99 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-success">Paid</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Invoice</a></li>
                                                                        <li><a href="#">Print</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95135</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-success">
                                                                    <span>CH</span>
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Cassandra Hogan</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">01/29/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2305564</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">1099.99 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-warning">Due</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Invoice</a></li>
                                                                        <li><a href="#">Notify</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner-sm border-top text-center d-sm-none">
                                                <a href="#" class="btn btn-link btn-block">See History</a>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-xxl-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Recent Activities</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <ul class="card-tools-nav">
                                                            <li><a href="#"><span>Cancel</span></a></li>
                                                            <li class="active"><a href="#"><span>All</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nk-activity">
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-success"><img src="./images/avatar/c-sm.jpg" alt=""></div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Keith Jensen requested to Widthdrawl.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-warning">HS</div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Harry Simpson placed a Order.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-azure">SM</div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Stephanie Marshall got a huge bonus.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-purple"><img src="./images/avatar/d-sm.jpg" alt=""></div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Nicholas Carr deposited funds.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-pink">TM</div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Timothy Moreno placed a Order.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-xxl-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner-group">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">New Users</h6>
                                                        </div>
                                                        <div class="card-tools">
                                                            <a href="html/user-list-regular.html" class="link">View All</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-inner card-inner-md">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-primary-dim">
                                                            <span>AB</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="lead-text">Abu Bin Ishtiyak</span>
                                                            <span class="sub-text">info@softnio.com</span>
                                                        </div>
                                                        <div class="user-action">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><em class="icon ni ni-setting"></em><span>Action Settings</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-inner card-inner-md">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-pink-dim">
                                                            <span>SW</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="lead-text">Sharon Walker</span>
                                                            <span class="sub-text">sharon-90@example.com</span>
                                                        </div>
                                                        <div class="user-action">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><em class="icon ni ni-setting"></em><span>Action Settings</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-inner card-inner-md">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-warning-dim">
                                                            <span>GO</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="lead-text">Gloria Oliver</span>
                                                            <span class="sub-text">gloria_72@example.com</span>
                                                        </div>
                                                        <div class="user-action">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><em class="icon ni ni-setting"></em><span>Action Settings</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-inner card-inner-md">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-success-dim">
                                                            <span>PS</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="lead-text">Phillip Sullivan</span>
                                                            <span class="sub-text">phillip-85@example.com</span>
                                                        </div>
                                                        <div class="user-action">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><em class="icon ni ni-setting"></em><span>Action Settings</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-lg-6 col-xxl-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Support Requests</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <a href="#" class="link">All Tickets</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nk-support">
                                                <li class="nk-support-item">
                                                    <div class="user-avatar">
                                                        <img src="./images/avatar/a-sm.jpg" alt="">
                                                    </div>
                                                    <div class="nk-support-content">
                                                        <div class="title">
                                                            <span>Vincent Lopez</span><span class="badge badge-dot badge-dot-xs bg-warning ms-1">Pending</span>
                                                        </div>
                                                        <p>Thanks for contact us with your issues...</p>
                                                        <span class="time">6 min ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-support-item">
                                                    <div class="user-avatar bg-purple-dim">
                                                        <span>DM</span>
                                                    </div>
                                                    <div class="nk-support-content">
                                                        <div class="title">
                                                            <span>Daniel Moore</span><span class="badge badge-dot badge-dot-xs bg-info ms-1">Open</span>
                                                        </div>
                                                        <p>Thanks for contact us with your issues...</p>
                                                        <span class="time">2 Hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-support-item">
                                                    <div class="user-avatar">
                                                        <img src="./images/avatar/b-sm.jpg" alt="">
                                                    </div>
                                                    <div class="nk-support-content">
                                                        <div class="title">
                                                            <span>Larry Henry</span><span class="badge badge-dot badge-dot-xs bg-success ms-1">Solved</span>
                                                        </div>
                                                        <p>Thanks for contact us with your issues...</p>
                                                        <span class="time">3 Hours ago</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-lg-6 col-xxl-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Notifications</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <a href="#" class="link">View All</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner">
                                                <div class="timeline">
                                                    <h6 class="timeline-head">November, 2019</h6>
                                                    <ul class="timeline-list">
                                                        <li class="timeline-item">
                                                            <div class="timeline-status bg-primary is-outline"></div>
                                                            <div class="timeline-date">13 Nov <em class="icon ni ni-alarm-alt"></em></div>
                                                            <div class="timeline-data">
                                                                <h6 class="timeline-title">Submited KYC Application</h6>
                                                                <div class="timeline-des">
                                                                    <p>Re-submitted KYC form.</p>
                                                                    <span class="time">09:30am</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item">
                                                            <div class="timeline-status bg-primary"></div>
                                                            <div class="timeline-date">13 Nov <em class="icon ni ni-alarm-alt"></em></div>
                                                            <div class="timeline-data">
                                                                <h6 class="timeline-title">Submited KYC Application</h6>
                                                                <div class="timeline-des">
                                                                    <p>Re-submitted KYC form.</p>
                                                                    <span class="time">09:30am</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item">
                                                            <div class="timeline-status bg-pink"></div>
                                                            <div class="timeline-date">13 Nov <em class="icon ni ni-alarm-alt"></em></div>
                                                            <div class="timeline-data">
                                                                <h6 class="timeline-title">Submited KYC Application</h6>
                                                                <div class="timeline-des">
                                                                    <p>Re-submitted KYC form.</p>
                                                                    <span class="time">09:30am</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                </div><!-- .row -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
                <!-- JavaScript -->
                <!-- footer @s -->
                <div class="nk-footer bg-white">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright">
                                &copy; 2023
                                <a href="" target="_blank">linked-solution</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- app-root @e -->

        <script src="<?=URL?>public/assets/js/bundle.js?ver=3.2.0"></script>
        <script src="<?=URL?>public/assets/js/scripts.js?ver=3.2.0"></script>
        <script src="<?=URL?>public/assets/js/charts/gd-default.js?ver=3.2.0"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>

</html>