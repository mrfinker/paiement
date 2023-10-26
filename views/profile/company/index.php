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
$profile = $profileModel->getUserProfile();

?>

<?php include_once ("./views/include/header.php") ?>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-lg-4 col-xxl-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="card-title-group align-items mb-2">

                                    <div class="media user-about-block align-items-center">
                                    <div class="user-avatar sq xl mb-2 m-2">
                                        <?php if (isset($profile['image']) && !empty($profile['image'])): ?>
                                            <img src="<?php echo $profile['image']; ?>" id="viewimage" alt="User Avatar">
                                        <?php else: ?>
                                            <em class="icon ni ni-user-alt"></em>
                                        <?php endif; ?>
                                    </div>

                                        <div class="media-body ml-3">
                                            <h6 class="mb-1">
                                            <?=$profile['name'] ?>
                                            </h6>
                                            <p class="mb-0 text-muted"><?=$profile['username'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <ul class="list-group">
                                    <li class="list-group-item align-items-center d-flex">
                                        <em class="icon ni ni-mail-fill m-1"></em>
                                        <a href="mailto:<?=$profile['email'] ?>" class="text-body">
                                        <?=$profile['email'] ?>
                                        </a>
                                    </li>
                                    <li class="list-group-item align-items-center d-flex">
                                        <em class="icon ni ni-call-fill m-1"></em>
                                        <span href="#" class="float-right text-body">
                                        <?=$profile['phone'] ?>
                                        </span>
                                    </li>
                                </ul>

                                <ul class="nav link-list-menu border-light m-0" role="tablist">
                                    
                                    <li>
                                        <a
                                            class="active"
                                            data-bs-toggle="tab"
                                            href="#tabItem6"
                                            aria-selected="false"
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
                                            <span>Profile</span></a>
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
                    <div class="col-lg-8 col-xxl-8">
                        <div class="card card-preview">
                            <div class="card-inner">

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabItem6" role="tabpanel">
                                        <form id="updateFormCompany_personnel" method="POST" enctype="multipart/form-data">
                                        <div class="row gy-4">
                                            <div class="col-lg-6 col-sm-6 col-mb-6 col-xxl-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="name"
                                                            id="name">
                                                        <label class="form-label-outlined" for="name"><?=$profile['name'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-mb-6 col-xxl-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-mail"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="email"
                                                            id="email">
                                                        <label class="form-label-outlined" for="email"><?=$profile['email'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-mb-6 col-xxl-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                        <em class="icon ni ni-bulb-fill"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="username"
                                                            id="username">
                                                        <label class="form-label-outlined" for="username"><?=$profile['username'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-mb-6 col-xxl-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-call"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="phone"
                                                            id="phone">
                                                        <label class="form-label-outlined" for="phone"><?=$profile['phone'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-mb-6 col-xxl-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-b-si"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="ville"
                                                            id="ville">
                                                        <label class="form-label-outlined" for="ville"><?=$profile['ville'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-xxl-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                        <em class="icon ni ni-link-group"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="city"
                                                            id="city">
                                                        <label class="form-label-outlined" for="city"><?=$profile['city'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="address">Adresse</label>
                                                    <div class="form-control-wrap">
                                                        <textarea 
                                                        class="form-control no-resize"
                                                        name="address" 
                                                        id="address"><?=$profile['address'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <li class="divider"></li>

                                            <input type="hidden" class="user_id" name="user_id" value="<?=$profile['id'] ?>">
                                            <input type="hidden" class="company_id" name="company_id" value="<?=$profile['company_id'] ?>">
                                            <div class="form-group mt-2">
                                                <button
                                                    type="submit"
                                                    id="update_btn"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Modifier</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>

                                    <div class="tab-pane" id="tabItem7" role="tabpanel">
                                    <form id="updateFormCompany_image" method="POST" enctype="multipart/form-data">
                                        <div class="row gy-4">
                                            <div class="col-lg">
                                                <div class="form-group">
                                                    <label class="form-label">Compagnie logo</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-file">
                                                            <input 
                                                            type="file" 
                                                            class="form-file-input"
                                                            name="image" 
                                                            id="image">
                                                            <label class="form-file-label" for="image">Choose file</label>
                                                        </div>
                                                        <p class="mt-2" style="font-size: 10px;">Telecharger l'image seulement en : png, jpg ou jpeg</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <li class="divider"></li>

                                            <input type="hidden" class="user_id" name="user_id" value="<?=$profile['id'] ?>">
                                            <input type="hidden" class="company_id" name="company_id" value="<?=$profile['company_id'] ?>">
                                            <div class="form-group mt-2">
                                                <button
                                                    type="submit"
                                                    id="update_btn"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Modifier</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>

                                    <div class="tab-pane" id="tabItem8" role="tabpanel">
                                    <form id="updateFormCompany_compagny" method="POST" enctype="multipart/form-data">
                                        <div class="row gy-4">
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">code postale</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                        <em class="icon ni ni-activity-round-fill"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="code_postale"
                                                            id="code_postale">
                                                        <label class="form-label-outlined" for="code_postale"><?=$profile['code_postale'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Numero de taxe</label><br>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="tax_number"
                                                            id="tax_number">
                                                        <label class="form-label-outlined" for="tax_number"><?=$profile['tax_number'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">RCCM</label><br>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="rccm"
                                                            id="rccm">
                                                        <label class="form-label-outlined" for="rccm"><?=$profile['rccm'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Nom banque</label><br>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="bank_name"
                                                            id="bank_name">
                                                        <label class="form-label-outlined" for="bank_name"><?=$profile['bank_name'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Numero de compte</label><br>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-xl form-control-outlined"
                                                            name="bank_number"
                                                            id="bank_number">
                                                        <label class="form-label-outlined" for="bank_number"><?=$profile['bank_number'] ?></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <li class="divider"></li>

                                            <input type="hidden" class="user_id" name="user_id" value="<?=$profile['id'] ?>">
                                            <input type="hidden" class="company_id" name="company_id" value="<?=$profile['company_id'] ?>">
                                            <div class="form-group mt-2">
                                                <button
                                                    type="submit"
                                                    id="update_btn"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Modifier</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                    
                                    <div class="tab-pane" id="tabItem9" role="tabpanel">
                                    <form id="updateFormCompany_password" method="POST" enctype="multipart/form-data">
                                        <div class="alert alert-warning alert-icon">
                                            <em class="icon ni ni-alert-circle"></em><b>Attention</b>, 
                                            Ne partager votre mot de passe à
                                            <strong>personne</strong>
                                        </div>
                                        <div class="row gy-4">
                                            <div class="col-6">
                                            <label class="form-label">Nouveau mot de passe</label><br>
                                                <div class="form-control-wrap">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">
                                                                <em class="icon ni ni-eye"></em>
                                                            </span>
                                                        </div>
                                                        <input 
                                                        type="password"
                                                        name="password"
                                                        id="password" 
                                                        class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Confirmer mot de passe</label><br>
                                                <div class="form-control-wrap">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">
                                                                <em class="icon ni ni-eye"></em>
                                                            </span>
                                                        </div>
                                                        <input 
                                                        type="password"
                                                        name="confirm_password"
                                                        id="confirm_password" 
                                                        class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <li class="divider"></li>

                                            <input type="hidden" class="user_id" name="user_id" value="<?=$profile['id'] ?>">
                                            <div class="form-group mt-2">
                                                <button
                                                    type="submit"
                                                    id="update_btn"
                                                    name="update_btn"
                                                    class="btn btn-lg btn-primary btn-block">Modifier</button>
                                            </div>
                                        </div>
                                    </form>
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