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
        <link rel="shortcut icon" href="<?= URL ?>public/images/favicon.png">
        <!-- Page Title -->
        <title>Connexion | LinkedSolution</title>
        <!-- StyleSheets -->
        <link
            rel="stylesheet"
            href="<?= URL ?>public/assets/css/dashlite.css?ver=3.2.0">
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.css">
        <link
            id="skin-default"
            rel="stylesheet"
            href="<?= URL ?>public/assets/css/theme.css?ver=3.2.0">
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
                                        src="public/images/logo.png"
                                        alt="logo">
                                    <img
                                        class="logo-dark logo-img logo-img-lg"
                                        src="public/images/logo-dark.png"
                                        alt="logo-dark">
                                </a>
                            </div>
                            <div class="card card-bordered">
                                <div class="card-inner card-inner-lg">

                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Connexion</h4>
                                            <div class="nk-block-des">
                                                <p>Veuiller entrer vos coordonnées pour acceder a votre gestionnaire des données
                                                    .</p>
                                            </div>
                                        </div>
                                    </div>
                                    <form id="loginFormUser" method="POST">
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
                                                <a class="link link-primary link-sm" href="#">Mot de passe oublier ?</a>
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
                                        <a href="<?= URL ?>register">Enregistrer</a>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="nk-footer nk-auth-footer-full">
                            <div class="container wide-lg">
                                <div class="row g-3">
                                    <div class="col-lg-6 order-lg-last">
                                        <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= URL ?>pages/termes">Termes &amp; Condition</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= URL ?>pages/faq">F.A.Q</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="nk-block-content text-center text-lg-left">
                                            <p class="text-soft">© 2023 Linked-solution. Tout droit reservé.</p>
                                        </div>
                                    </div>
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
            <script src="<?= URL ?>public/assets/js/bundle.js?ver=3.2.0"></script>
            <script src="<?= URL ?>public/assets/js/scripts.js?ver=3.2.0"></script>
            <script src="<?= URL ?>public/assets/js/example-sweetalert.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <?php
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                echo '<script src="' . URL . 'views/' . $js . '"></script>';
            }
        }
        ?>

        </html>