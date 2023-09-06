<?php

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location" . LOGIN);
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
                                    <li class="dropdown chats-dropdown">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="icon-status icon-status-na">
                                                <em class="icon ni ni-chat"></em>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Recent Chats</span>
                                                <a href="#">Setting</a>
                                            </div>
                                            <div class="dropdown-body">
                                                <ul class="chat-list">
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="html/apps-chats.html">
                                                            <div class="chat-media user-avatar">
                                                                <span>IH</span>
                                                                <span class="status dot dot-lg dot-gray"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Iliash Hossain</div>
                                                                    <span class="time">Now</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">You: Please confrim if you got my last messages.</div>
                                                                    <div class="status delivered">
                                                                        <em class="icon ni ni-check-circle-fill"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <!-- .chat-item -->
                                                    <li class="chat-item is-unread">
                                                        <a class="chat-link" href="html/apps-chats.html">
                                                            <div class="chat-media user-avatar bg-pink">
                                                                <span>AB</span>
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Abu Bin Ishtiyak</div>
                                                                    <span class="time">4:49 AM</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">Hi, I am Ishtiyak, can you help me with this problem ?</div>
                                                                    <div class="status unread">
                                                                        <em class="icon ni ni-bullet-fill"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <!-- .chat-item -->
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="html/apps-chats.html">
                                                            <div class="chat-media user-avatar">
                                                                <img src="./images/avatar/b-sm.jpg" alt="">
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">George Philips</div>
                                                                    <span class="time">6 Apr</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">Have you seens the claim from Rose?</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <!-- .chat-item -->
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="html/apps-chats.html">
                                                            <div class="chat-media user-avatar user-avatar-multiple">
                                                                <div class="user-avatar">
                                                                    <img src="./images/avatar/c-sm.jpg" alt="">
                                                                </div>
                                                                <div class="user-avatar">
                                                                    <span>AB</span>
                                                                </div>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Softnio Group</div>
                                                                    <span class="time">27 Mar</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">You: I just bought a new computer but i am having some problem</div>
                                                                    <div class="status sent">
                                                                        <em class="icon ni ni-check-circle"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <!-- .chat-item -->
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="html/apps-chats.html">
                                                            <div class="chat-media user-avatar">
                                                                <img src="./images/avatar/a-sm.jpg" alt="">
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Larry Hughes</div>
                                                                    <span class="time">3 Apr</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">Hi Frank! How is you doing?</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <!-- .chat-item -->
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="html/apps-chats.html">
                                                            <div class="chat-media user-avatar bg-purple">
                                                                <span>TW</span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Tammy Wilson</div>
                                                                    <span class="time">27 Mar</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">You: I just bought a new computer but i am having some problem</div>
                                                                    <div class="status sent">
                                                                        <em class="icon ni ni-check-circle"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <!-- .chat-item -->
                                                </ul>
                                                <!-- .chat-list -->
                                            </div>
                                            <!-- .nk-dropdown-body -->
                                            <div class="dropdown-foot center">
                                                <a href="html/apps-chats.html">View All</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown language-dropdown d-none d-sm-block me-n1">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="quick-icon border border-light">
                                                <img class="icon" src="./images/flags/english-sq.png" alt="">
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-s1">
                                            <ul class="language-list">
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="./images/flags/english.png" alt="" class="language-flag">
                                                        <span class="language-name">English</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="./images/flags/french.png" alt="" class="language-flag">
                                                        <span class="language-name">Français</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <!-- .dropdown -->
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
                                                        <a href="html/user-profile-regular.html">
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