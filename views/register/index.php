<?php
Session::init();

// if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
//     $user = $_SESSION['users'];
//     $userType = $_SESSION['userType'];
// } else {
//     header("Location" . LOGIN);
//     exit;
// }

// if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "superadmin") {
//     header('Location: ' . ERROR);
//     exit;
// }
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
        <link rel="shortcut icon" href="<?= URL ?>public/images/favicon.png">
        <!-- Page Title -->
        <title>Enregistrement | LinkedSolution</title>
        <!-- StyleSheets -->
        <link
            rel="stylesheet"
            href="<?= URL ?>public/assets/css/dashlite.css?ver=3.2.0">
        <link
            id="skin-default"
            rel="stylesheet"
            href="<?= URL ?>public/assets/css/theme.css?ver=3.2.0">
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.css">
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
                                <a href="<?= URL ?>login" class="logo-link">
                                    <img
                                        class="logo-light logo-img logo-img-lg"
                                        src="<?= URL ?>public/images/logo.png"
                                        srcset="<?= URL ?>public/images/logo2x.png 2x"
                                        alt="logo">
                                    <img
                                        class="logo-dark logo-img logo-img-lg"
                                        src="<?= URL ?>public/images/logo-dark.png"
                                        srcset="<?= URL ?>public/images/logo-dark2x.png 2x"
                                        alt="logo-dark">
                                </a>
                            </div>
                            <div class="card card-bordered">
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Incription</h4>
                                            <div class="nk-block-des">
                                                <p>Veuiller entrer vos coordonnées pour etre enregistrer dans notre base de
                                                    donnees.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <form id="registerFormUser" method="POST">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="name">Votre noms</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input
                                                    required="required"
                                                    type="text"
                                                    name="name"
                                                    class="form-control form-control-lg"
                                                    id="name"
                                                    placeholder="Entrer votre noms">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="username">Votre nom utilisateur</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input
                                                    required="required"
                                                    type="text"
                                                    name="username"
                                                    class="form-control form-control-lg"
                                                    id="username"
                                                    placeholder="Entrer votre username">
                                            </div>
                                        </div>
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
                                                <label class="form-label" for="phone">Votre telephone</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input
                                                    required="required"
                                                    type="number"
                                                    name="phone"
                                                    class="form-control form-control-lg"
                                                    id="phone"
                                                    placeholder="Entrer votre numero de telephone">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="address">Votre adresse</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input
                                                    required="required"
                                                    type="text"
                                                    name="address"
                                                    class="form-control form-control-lg"
                                                    id="address"
                                                    placeholder="Entrer votre adresse">
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
                                            <div class="form-label-group">
                                                <label class="form-label" for="confirm_password">Confirmer votre mot de passe</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <a
                                                    href="#"
                                                    class="form-icon form-icon-right passcode-switch lg"
                                                    data-target="confirm_password">
                                                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                </a>
                                                <input
                                                    required="required"
                                                    type="password"
                                                    name="confirm_password"
                                                    class="form-control form-control-lg"
                                                    id="confirm_password"
                                                    placeholder="Confirmer votre mot de passe">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button
                                                type="submit"
                                                name="register_btn"
                                                class="btn btn-lg btn-primary btn-block">S'incrire</button>
                                        </div>
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
            <script src="<?= URL ?>public/assets/js/bundle.js?ver=3.2.0"></script>
            <script src="<?= URL ?>public/assets/js/scripts.js?ver=3.2.0"></script>
            <script src="<?= URL ?>public/assets/js/example-sweetalert.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- Ajoutez ces liens dans la section <head> de votre HTML -->
            <script
                src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.js"></script>

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