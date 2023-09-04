<?php
require_once('./models/authentication_code.php');
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="zxx" class="js">

    <head>
        <base href="../../../">
        <meta charset="utf-8">
        <meta name="author" content="Softnio">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta
            name="description"
            content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
        <!-- Fav Icon -->
        <link rel="shortcut icon" href="./public/images/favicon.png">
        <!-- Page Title -->
        <title>Connexion</title>
        <!-- StyleSheets -->
        <link rel="stylesheet" href="./public/assets/css/dashlite.css?ver=3.2.0">
        <link
            id="skin-default"
            rel="stylesheet"
            href="./public/assets/css/theme.css?ver=3.2.0">
    </head>

    <body class="nk-body bg-white npc-general pg-auth">

        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- wrap @s -->
                <div class="nk-wrap nk-wrap-nosidebar">
                    <!-- content @s -->
                    <div class="nk-content ">
                        <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                            <div class="brand-logo pb-4 text-center">
                                <a href="html/index.html" class="logo-link">
                                    <img
                                        class="logo-light logo-img logo-img-lg"
                                        src="./public/images/logo.png"
                                        srcset="./public/images/logo2x.png 2x"
                                        alt="logo">
                                    <img
                                        class="logo-dark logo-img logo-img-lg"
                                        src="./public/images/logo-dark.png"
                                        srcset="./public/images/logo-dark2x.png 2x"
                                        alt="logo-dark">
                                </a>
                            </div>
                            <div class="card card-bordered">
                                <div class="card-inner card-inner-lg">
                                    <?php include('./message.php') ?>
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Connexion</h4>
                                            <div class="nk-block-des">
                                                <p>Veuiller entrer vos coordonnées pour acceder a votre gestionnaire des données
                                                    le plus complet.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="dashboard.php" method="POST">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="email">Votre email</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input
                                                    required="required"
                                                    type="email"
                                                    name="email"
                                                    class="form-control form-control-lg"
                                                    id="email"
                                                    placeholder="Entrer votre email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="password">Mot de passe</label>
                                                <a class="link link-primary link-sm" href="/app/views/auth-reset.php">Mot de passe oublier ?</a>
                                            </div>
                                            <div class="form-control-wrap">
                                                <a
                                                    href="#"
                                                    class="form-icon form-icon-right passcode-switch lg"
                                                    data-target="password">
                                                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                </a>
                                                <input
                                                    required="required"
                                                    type="password"
                                                    name="password"
                                                    class="form-control form-control-lg"
                                                    id="password"
                                                    placeholder="Entrer votre mot de passe">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="login_btn" class="btn btn-lg btn-primary btn-block">Connexion</button>
                                        </div>
                                        <a href="<?php echo base_url('register.php'); ?>">Enregistrer</a>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content @e -->
                </div>
                <!-- main @e -->
            </div>
            <!-- app-root @e -->
            <!-- JavaScript -->
            <script src="./public/assets/js/bundle.js?ver=3.2.0"></script>
            <script src="./public/assets/js/scripts.js?ver=3.2.0"></script>
            <script src="./public/assets/js/example-sweetalert.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        </html>