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
                                                        <a href="<?=URL?>profileuser">
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
                                <p>Bonjour <?= $userType['name'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- JavaScript -->
                <!-- footer @s -->
                <div class="nk-footer bg-white">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright">
                                &copy; 2023
                                <a href="https://linked-solution" target="_blank">linked-solution</a>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>

</html>