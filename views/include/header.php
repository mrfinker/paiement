<?php

$PermissionsRoles = Session::get("userPermissions");
// $foundPermissions = [];

// Vérifier si les permissions spécifiques sont présentes
// if (strpos($PermissionsRoles, 'admin_fiscalité') !== false || strpos($PermissionsRoles, 'admin fiscalité') !== false) {
//     $foundPermissions[] = 'admin_fiscalité';
// }
// if (strpos($PermissionsRoles, 'admin_paie') !== false || strpos($PermissionsRoles, 'admin paie') !== false) {
//     $foundPermissions[] = 'admin_paie';
// }

// $foundPermissions = strpos($permissions, 'admin_fiscalité') !== false || 
//                     strpos($permissions, 'admin fiscalité') !== false ||
//                     strpos($permissions, 'admin_paie') !== false || 
//                     strpos($permissions, 'admin paie') !== false;
// Vérifier si les permissions spécifiques sont présentes et retourner true ou false
$hasRequiredPermissionsEmployer = (strpos($PermissionsRoles, 'admin_employer') !== false || strpos($PermissionsRoles, 'admin employer') !== false);
$hasRequiredPermissionsRH = (strpos($PermissionsRoles, 'admin_rh') !== false || strpos($PermissionsRoles, 'admin rh') !== false);
$hasRequiredPermissionsFisc = (strpos($PermissionsRoles, 'admin_fiscalite') !== false || strpos($PermissionsRoles, 'admin fiscalite') !== false);
$hasRequiredPermissionsPaie = (strpos($PermissionsRoles, 'admin_paie') !== false || strpos($PermissionsRoles, 'admin paie') !== false);

?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Linked-solution">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Une application de gestion de paiement complete.">
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="<?= URL ?>public/images/favicon.png">
    <!-- Page Title -->
    <title><?= $userType['name'] ?>
        | dashboard</title>
    <!-- StyleSheets -->
    <link rel="stylesheet" href="<?= URL ?>public/assets/css/dashlite.css?ver=3.2.0">
    <link rel="stylesheet" href="<?= URL ?>public/assets/css/skins/theme-blue.css">
    <link id="skin-default" rel="stylesheet" href="<?= URL ?>public/assets/css/theme.css?ver=3.2.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Par défaut theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
</head>


<body class="nk-body ui-rounder has-sidebar">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar is-light nk-sidebar-fixed is-light step2" data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="html/index.html" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="<?= URL ?>public/images/logo.png" srcset="<?= URL ?>public/images/logo2x.png 2x" alt="logo">
                            <img class="logo-dark logo-img" src="<?= URL ?>public/images/logo-dark.png" srcset="<?= URL ?>public/images/logo-dark2x.png 2x" alt="logo-dark">
                            <img class="logo-small logo-img logo-img-small" src="<?= URL ?>public/images/logo-small.png" srcset="<?= URL ?>public/images/logo-small2x.png 2x" alt="logo-small">
                        </a>
                    </div>
                    <div class="nk-menu-trigger me-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu">
                            <em class="icon ni ni-arrow-left"></em>
                        </a>
                    </div>
                </div>
                <!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar="data-simplebar">
                            <ul class="nk-menu">
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Tableau de bord</h6>
                                </li>
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-item step3">
                                    <a href="<?= URL ?>dashboard/<?= $userType['name'] ?>" class="nk-menu-link">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-bag"></em>
                                        </span>
                                        <span class="nk-menu-text">Tableau de bord</span>
                                    </a>
                                </li>
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Gestions</h6>
                                </li>
                                <!-- .nk-menu-item -->
                                <!-- .nk-menu-item -->
                                <?php if ($_SESSION['userType']['name'] === 'superadmin') : ?>
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon">
                                                <em class="icon ni ni-users"></em>
                                            </span>
                                            <span class="nk-menu-text">utilisateurs</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="<?= URL ?><?= $userType['name'] ?>/all_user" class="nk-menu-link">
                                                    <span class="nk-menu-text">Tout les utilisateurs</span>
                                                </a>
                                            </li>
                                            <!-- .nk-menu-item -->
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                    </li>
                                <?php endif; ?>
                                <!-- .nk-menu-item -->
                                <?php if ($_SESSION['userType']['name'] === 'superadmin') : ?>
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon">
                                                <em class="icon ni ni-building"></em>
                                            </span>
                                            <span class="nk-menu-text">compagnies</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <!-- .nk-menu-item -->
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="<?= URL ?><?= $userType['name'] ?>/all_company" class="nk-menu-link">
                                            <span class="nk-menu-text">Toutes les compagnies</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="<?= URL ?><?= $userType['name'] ?>/membership_plan" class="nk-menu-link">
                                            <span class="nk-menu-text">Plans</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                            </ul>
                        <?php endif; ?>

                        <?php if ($_SESSION['userType']['name'] === 'company') : ?>
                            <li class="nk-menu-item has-sub step15">
                                <a href="#" class="nk-menu-link nk-menu-toggle step10">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-users-fill"></em>
                                    </span>
                                    <span class="nk-menu-text">Employers</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <!-- .nk-menu-item -->
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/all_employee" class="nk-menu-link">
                                    <span class="nk-menu-text">Employer</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/office_shifts" class="nk-menu-link">
                                    <span class="nk-menu-text">Temps de travail</span>
                                </a>
                            </li>
                            <!-- .nk-menu-item -->
                            </ul>
                        <?php
                        elseif ($_SESSION['userType']['name'] === 'staff' && $hasRequiredPermissionsEmployer) :
                            // var_dump($hasRequiredPermissions);
                            // var_dump($PermissionsRoles);
                        ?>

                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-users-fill"></em>
                                    </span>
                                    <span class="nk-menu-text">Employers</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <!-- .nk-menu-item -->
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/all_employee" class="nk-menu-link">
                                    <span class="nk-menu-text">Employer</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/office_shifts" class="nk-menu-link">
                                    <span class="nk-menu-text">Temps de travail</span>
                                </a>
                            </li>
                            <!-- .nk-menu-item -->
                            </ul>
                        <?php endif; ?>
                        <?php if ($_SESSION['userType']['name'] === 'superadmin') : ?>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/roles" class="nk-menu-link">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-users-fill"></em>
                                    </span>
                                    <span class="nk-menu-text">Roles et privileges</span>
                                </a>
                                </ul>
                            <?php endif; ?>
                            <?php if ($_SESSION['userType']['name'] === 'company') : ?>
                            <li class="nk-menu-item has-sub step16">
                                <a href="#" class="nk-menu-link nk-menu-toggle step11">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-network"></em>
                                    </span>
                                    <span class="nk-menu-text">Ressources humaines</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <!-- .nk-menu-item -->
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/departements" class="nk-menu-link">
                                    <span class="nk-menu-text">Departements</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/designation" class="nk-menu-link">
                                    <span class="nk-menu-text">Branches</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/timesheet" class="nk-menu-link">
                                    <span class="nk-menu-text">Presences</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/report_monthly" class="nk-menu-link">
                                    <span class="nk-menu-text">Rapport du mois</span>
                                </a>
                            </li>
                            <!-- Une de partie finance -->
                            <!-- <li class="nk-menu-item">
                                            <a href="<*?=URL?><*?= $userType['name'] ?>/depense_depot" class="nk-menu-link">
                                                <span class="nk-menu-text">Type depense/depot</span>
                                            </a>
                                        </li> -->
                            </ul>
                        <?php elseif ($_SESSION['userType']['name'] === 'staff' && $hasRequiredPermissionsRH) : ?>
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-network"></em>
                                    </span>
                                    <span class="nk-menu-text">Ressources humaines</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <!-- .nk-menu-item -->
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/departements" class="nk-menu-link">
                                    <span class="nk-menu-text">Departements</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/designation" class="nk-menu-link">
                                    <span class="nk-menu-text">Branches</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/timesheet" class="nk-menu-link">
                                    <span class="nk-menu-text">Presences</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/report_monthly" class="nk-menu-link">
                                    <span class="nk-menu-text">Rapport du mois</span>
                                </a>
                            </li>
                            </ul>
                        <?php endif; ?>
                        <!-- Partie Finance mit de coté -->
                        <!-- <*?php if ($_SESSION['userType']['name'] === 'company'): ?>
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon">
                                            <em class="icon ni ni-sign-dollar"></em>
                                            </span>
                                            <span class="nk-menu-text">Finance</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="<*?=URL?><*?= $userType['name'] ?>/comptes" class="nk-menu-link">
                                                <span class="nk-menu-text">Comptes</span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="<*?=URL?><*?= $userType['name'] ?>/depots" class="nk-menu-link">
                                                <span class="nk-menu-text">Depots</span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="<*?=URL?><*?= $userType['name'] ?>/depenses" class="nk-menu-link">
                                                <span class="nk-menu-text">Depenses</span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="<*?=URL?><*?= $userType['name'] ?>/transactions" class="nk-menu-link">
                                                <span class="nk-menu-text">Transactions</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <*?php endif; ?> -->
                        <?php if ($_SESSION['userType']['name'] === 'company') : ?>
                            <li class="nk-menu-item has-sub step17">
                                <a href="#" class="nk-menu-link nk-menu-toggle step12">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-money"></em>
                                    </span>
                                    <span class="nk-menu-text">Fiscalité</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <!-- .nk-menu-item -->
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/dgi" class="nk-menu-link">
                                    <span class="nk-menu-text">DGI</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/cnss" class="nk-menu-link">
                                    <span class="nk-menu-text">CNSS</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/inpp" class="nk-menu-link">
                                    <span class="nk-menu-text">INPP</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/onem" class="nk-menu-link">
                                    <span class="nk-menu-text">ONEM</span>
                                </a>
                            </li>
                            </ul>
                        <?php elseif ($_SESSION['userType']['name'] === 'staff' && $hasRequiredPermissionsFisc) : ?>
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-money"></em>
                                    </span>
                                    <span class="nk-menu-text">Fiscalité</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <!-- .nk-menu-item -->
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/dgi" class="nk-menu-link">
                                    <span class="nk-menu-text">DGI</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/cnss" class="nk-menu-link">
                                    <span class="nk-menu-text">CNSS</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/inpp" class="nk-menu-link">
                                    <span class="nk-menu-text">INPP</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/onem" class="nk-menu-link">
                                    <span class="nk-menu-text">ONEM</span>
                                </a>
                            </li>
                            </ul>
                        <?php endif; ?>
                        <?php if ($_SESSION['userType']['name'] === 'company') : ?>
                            <li class="nk-menu-item has-sub step18">
                                <a href="#" class="nk-menu-link nk-menu-toggle step13">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-amazon-pay"></em>
                                    </span>
                                    <span class="nk-menu-text">Paie</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <!-- .nk-menu-item -->
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/paie" class="nk-menu-link">
                                    <span class="nk-menu-text">Paie</span>
                                </a>
                            </li>
                            <!-- <li class="nk-menu-item">
                                <a href="<*?= URL ?><*?= $userType['name'] ?>/history_paiement" class="nk-menu-link">
                                    <span class="nk-menu-text">Historique de paie</span>
                                </a>
                            </li> -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/report_paie_annuel" class="nk-menu-link">
                                    <span class="nk-menu-text">Historique annuel</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/avance_salaire" class="nk-menu-link">
                                    <span class="nk-menu-text">Avance sur salaire</span>
                                </a>
                            </li>
                            <!-- .nk-menu-item -->
                            </ul>
                        <?php elseif ($_SESSION['userType']['name'] === 'staff' && $hasRequiredPermissionsFisc) : ?>
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-amazon-pay"></em>
                                    </span>
                                    <span class="nk-menu-text">Paie</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <!-- .nk-menu-item -->
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/paie" class="nk-menu-link">
                                    <span class="nk-menu-text">Paie</span>
                                </a>
                            </li>
                            <!-- <li class="nk-menu-item">
                                <a href="<*?= URL ?><*?= $userType['name'] ?>/history_paiement" class="nk-menu-link">
                                    <span class="nk-menu-text">Historique de paie</span>
                                </a>
                            </li> -->
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/report_paie_annuel" class="nk-menu-link">
                                    <span class="nk-menu-text">Historique annuel</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= URL ?><?= $userType['name'] ?>/avance_salaire" class="nk-menu-link">
                                    <span class="nk-menu-text">Avance sur salaire</span>
                                </a>
                            </li>
                            <!-- .nk-menu-item -->
                            </ul>
                        <?php endif; ?>

                        </ul>
                        <!-- .nk-menu -->
                        </div>
                        <!-- .nk-sidebar-menu -->
                    </div>
                    <!-- .nk-sidebar-content -->
                </div>
                <!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header is-light nk-header-fixed is-light">
                    <div class="container-xl wide-xl">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1 me-3">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu">
                                    <em class="icon ni ni-menu"></em>
                                </a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="<?= URL ?>public/images/logo.png" srcset="<?= URL ?>public/images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="<?= URL ?>public/images/logo-dark.png" srcset="<?= URL ?>public/images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div>

                            <?php if ($_SESSION['userType']['name'] === 'company') : ?>
                                <div class="nk-header-menu is-light">
                                    <div class="nk-header-menu-inner">
                                        <!-- Menu -->
                                        <ul class="nk-menu nk-menu-main">
                                            <!-- <li class="nk-menu-item has-sub">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">Applications</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="html/index.html" class="nk-menu-link">
                                                            <span class="nk-menu-text">Backup base de donnees</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li> -->
                                            <!-- .nk-menu-item -->
                                            <li class="nk-menu-item has-sub">
                                                <!-- <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">Configuration systeme</span>
                                                </a> -->
                                                <!-- <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<? #=URL
                                                                    ?><? #=$userType['name'] 
                                                                            ?>/settings" class="nk-menu-link">
                                                            <span class="nk-menu-text">Parametre</span>
                                                        </a>
                                                    </li> -->
                                                <!-- <li class="nk-menu-item">
                                                        <a href="html/index.html" class="nk-menu-link">
                                                            <span class="nk-menu-text">Email template</span>
                                                        </a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="html/index.html" class="nk-menu-link">
                                                            <span class="nk-menu-text">SMS template</span>
                                                        </a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="html/index.html" class="nk-menu-link">
                                                            <span class="nk-menu-text">Langues</span>
                                                        </a>
                                                    </li> -->
                                                <!-- .nk-menu-item -->
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                        </li>

                                        </ul>
                                        <!-- Menu -->
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown step14">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <?php if (isset($user['image']) && !empty($user['image'])) : ?>
                                                        <img src="<?= $user['image'] ?>" alt="User Avatar">
                                                    <?php else : ?>
                                                        <em class="icon ni ni-user-alt"></em>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light step19">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <?php if (isset($user['image']) && !empty($user['image'])) : ?>
                                                            <img src="<?= $user['image'] ?>" alt="User Avatar">
                                                        <?php else : ?>
                                                            <em class="icon ni ni-user-alt"></em>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="user-info">
                                                        <span class="lead-text"><?= isset($user['username']) ? $user['username'] : '' ?></span>
                                                        <span class="sub-text"><?= isset($user['email']) ? $user['email'] : '' ?></span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a href="<?= URL ?>profile/<?= $userType['name'] ?>">
                                                            <em class="icon ni ni-user-alt"></em>
                                                            <span>Voir Profile</span></a>
                                                    </li>
                                                    <?php if ($_SESSION['userType']['name'] === 'company') : ?>
                                                        <li>
                                                            <a href="<?= URL ?><?= $userType['name'] ?>/roles">
                                                                <em class="icon ni ni-users-fill"></em>
                                                                <span class="nk-menu-text">Administration de comptes</span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a id="logout_btn" href="<?= URL ?>login/logout">
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