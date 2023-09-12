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


<?= include_once("./views/include/header.php") ?>

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
            </div>
            <!-- app-root @e -->

            </div>
            <!-- wrap @e -->
        </div>
        <!-- app-root @e -->

<?= include_once("./views/include/footer.php") ?>