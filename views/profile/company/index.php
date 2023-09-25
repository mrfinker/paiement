<?php
Session::init();
require_once './models/profile_model.php';

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location: " . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "company") {
    header('Location: ' . ERROR);
    exit;
}

$profileModel = new profile_model();
$currencies = $profileModel->getAllCurrencies();

?>

<?php include_once ("./views/include/header.php") ?>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-lg-5 col-xxl-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="card-title-group align-items mb-2">

                                    <div class="media user-about-block align-items-center">
                                        <div class="user-avatar sq xl mb-2 m-2">
                                            <?php if (isset($user['image']) && !empty($user['image'])): ?>
                                            <img src="" id="viewimage" alt="User Avatar">
                                        <?php else: ?>
                                            <em class="icon ni ni-user-alt"></em>
                                            <?php endif; ?>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-1">
                                                Caleb Kiangebeni
                                            </h6>
                                            <p class="mb-0 text-muted">@ mrfinker
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <ul class="list-group">
                                    <li class="list-group-item align-items-center d-flex">
                                        <em class="icon ni ni-mail-fill m-1"></em>
                                        <a href="mailto:caalebs@gmail.com" class="text-body">
                                            caalebs@gmail.com
                                        </a>
                                    </li>
                                    <li class="list-group-item align-items-center d-flex">
                                        <em class="icon ni ni-call-fill m-1"></em>
                                        <a href="#" class="float-right text-body">
                                            1234567890
                                        </a>
                                    </li>
                                </ul>

                                <ul class="nav link-list-menu border-light m-0" role="tablist">
                                    <li>
                                        <a
                                            class="active"
                                            data-bs-toggle="tab"
                                            href="#tabItem5"
                                            aria-selected="false"
                                            role="tab">
                                            <em class="icon ni ni-user"></em>
                                            <span>Compte</span></a>
                                    </li>
                                    <li>
                                        <a
                                            class=""
                                            data-bs-toggle="tab"
                                            href="#tabItem6"
                                            aria-selected="false"
                                            tabindex="-1"
                                            role="tab">
                                            <em class="icon ni ni-tile-thumb"></em>
                                            <span>Personnel</span></a>
                                    </li>
                                    <li>
                                        <a
                                            class=""
                                            data-bs-toggle="tab"
                                            href="#tabItem7"
                                            aria-selected="false"
                                            tabindex="-1"
                                            role="tab">
                                            <em class="icon ni ni-user-circle"></em>
                                            <span>Profil</span></a>
                                    </li>
                                    <li>
                                        <a
                                            class=""
                                            data-bs-toggle="tab"
                                            href="#tabItem8"
                                            aria-selected="false"
                                            tabindex="-1"
                                            role="tab">
                                            <em class="icon ni ni-building"></em>
                                            <span>Compagnie</span></a>
                                    </li>
                                    <li>
                                        <a
                                            class=""
                                            data-bs-toggle="tab"
                                            href="#tabItem9"
                                            aria-selected="false"
                                            tabindex="-1"
                                            role="tab">
                                            <em class="icon ni ni-lock-alt"></em>
                                            <span>Mot de passe</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xxl-8">
                        <div class="card card-preview">
                            <div class="card-inner">

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabItem5" role="tabpanel">
                                        <div class="row gy-4">
                                            <div class="col-sm-6" data-select2-id="14">

                                                <div class="form-group" data-select2-id="13">
                                                    <label class="form-label">Monnaie</label>
                                                    <div class="form-control-wrap" data-select2-id="12">
                                                        <select
                                                            class="form-select js-select2 select2-hidden-accessible"
                                                            data-search="on"
                                                            aria-hidden="true">
                                                            <option value="default_option" data-select2-id="0">Default Option</option>
                                                            <?php
                                                                foreach ($currencies as $currency) {
                                                                    $id = $currency['currency_id'];
                                                                    $code = $currency['currency_code'];
                                                                    $name = $currency['currency_name'];
                                                                    echo "<option value='$id'>$name - $code</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6" data-select2-id="12">

                                                <div class="form-group" data-select2-id="11">
                                                    <label class="form-label">Langues</label>
                                                    <div class="form-control-wrap" data-select2-id="10">
                                                        <select
                                                            class="form-select js-select2 select2-hidden-accessible"
                                                            data-search="on"
                                                            aria-hidden="true">
                                                            <option value="default_option" data-select2-id="0">Default Option</option>
                                                            <?php
                                                                foreach ($currencies as $currency) {
                                                                    $id = $currency['currency_id'];
                                                                    $code = $currency['currency_code'];
                                                                    $name = $currency['currency_name'];
                                                                    echo "<option value='$id'>$name - $code</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <li class="divider"></li>

                                            <div class="form-group mt-2">
                                                <button
                                                    type="submit"
                                                    id="update_company_one"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Enregistrer</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabItem6" role="tabpanel">
                                        <div class="row gy-4">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Prenom</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Nom</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Email</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Username</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Contact</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select
                                                            class="form-select js-select2 select2-hidden-accessible"
                                                            data-search="on"
                                                            data-ui="xl"
                                                            aria-hidden="true">
                                                            <option value="default_option" data-select2-id="0">Default genre</option>
                                                            <?php
                                                                foreach ($currencies as $currency) {
                                                                    $id = $currency['currency_id'];
                                                                    $code = $currency['currency_code'];
                                                                    $name = $currency['currency_name'];
                                                                    echo "<option value='$id'>$name - $code</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select
                                                            class="form-select js-select2 select2-hidden-accessible"
                                                            data-search="on"
                                                            data-ui="xl"
                                                            aria-hidden="true">
                                                            <option value="default_option" data-select2-id="0">Default pays</option>
                                                            <?php
                                                                foreach ($currencies as $currency) {
                                                                    $id = $currency['currency_id'];
                                                                    $code = $currency['currency_code'];
                                                                    $name = $currency['currency_name'];
                                                                    echo "<option value='$id'>$name - $code</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="default-textarea">Adresse</label>
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control no-resize" id="default-textarea"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Cité</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Povince</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Code Postalt</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <li class="divider"></li>

                                            <div class="form-group mt-2">
                                                <button
                                                    type="submit"
                                                    id="update_company_two"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Enregistrer</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabItem7" role="tabpanel">
                                        <div class="row gy-4">
                                            <div class="col-lg">
                                                <div class="form-group">
                                                    <label class="form-label">Compagnie logo</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-file">
                                                            <input type="file" class="form-file-input" id="customFile">
                                                            <label class="form-file-label" for="customFile">Choose file</label>
                                                        </div>
                                                        <p class="mt-2" style="font-size: 10px;">Telecharger l'image seulement en : png, jpg ou jpeg</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <li class="divider"></li>

                                            <div class="form-group mt-2">
                                                <button
                                                    type="submit"
                                                    id="update_company_three"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabItem8" role="tabpanel">
                                        <div class="row gy-4">
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group">

                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Nom compagnie</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select
                                                            class="form-select js-select2 select2-hidden-accessible"
                                                            data-search="on"
                                                            data-ui="xl"
                                                            aria-hidden="true">
                                                            <option value="default_option" data-select2-id="0">Default genre</option>
                                                            <?php
                                                                foreach ($currencies as $currency) {
                                                                    $id = $currency['currency_id'];
                                                                    $code = $currency['currency_code'];
                                                                    $name = $currency['currency_name'];
                                                                    echo "<option value='$id'>$name - $code</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Numero trading</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">Numero taxe</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            id="outlined-right-icon">
                                                        <label class="form-label-outlined" for="outlined-right-icon">RCCM</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <li class="divider"></li>

                                            <div class="form-group mt-2">
                                                <button
                                                    type="submit"
                                                    id="update_company_three"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabItem9" role="tabpanel">
                                        <div class="alert alert-warning alert-icon">
                                            <em class="icon ni ni-alert-circle"></em><b>Attention</b>, 
                                            Ne partager votre mot de passe à
                                            <strong>personne</strong>
                                        </div>
                                        <div class="row gy-4">
                                            <div class="col-6">
                                                <div class="form-control-wrap">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">
                                                                <em class="icon ni ni-eye"></em>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div><br>
                                            <div class="col-6">
                                                <div class="form-control-wrap">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">
                                                                <em class="icon ni ni-eye"></em>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-control-wrap">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">
                                                                <em class="icon ni ni-eye"></em>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <li class="divider"></li>

                                            <div class="form-group">
                                                <button
                                                    type="submit"
                                                    id="update_company_three"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Changer mot de passe</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once ("./views/include/footer.php") ?>