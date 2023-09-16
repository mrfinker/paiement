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

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "superadmin") {
    header('Location: ' . ERROR);
    exit;
}
?>
<?= include_once("./views/include/header.php") ?>
<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-aside-wrap">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head nk-block-head-lg">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Information personnel</h4>
                                            <div class="nk-block-des">
                                                <p>Vos informations personneles</p>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                            <a
                                                href="#"
                                                class="toggle btn btn-icon btn-trigger mt-n1"
                                                data-target="userAside">
                                                <em class="icon ni ni-menu-alt-r"></em>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="nk-data data-list">
                                        <div class="data-head">
                                            <h6 class="overline-title">Basiques</h6>
                                        </div>
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Nom complet</span>
                                                <span class="data-value"><?=$user['name']?></span>
                                            </div>
                                            <div
                                                class="data-col data-col-end"
                                                id="update_profile"
                                                data-nameprofile="<?= $user['name'] ?>"
                                                data-usernameprofile="<?= $user['username'] ?>"
                                                data-phoneprofile="<?= $user['phone'] ?>"
                                                data-birthdayprofile="<?= $user['birthday'] ?>"
                                                data-id="<?=$user['id']?>">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Nom d'utilisation</span>
                                                <span class="data-value"><?=$user['username']?></span>
                                            </div>
                                            <div class="data-col data-col-end"></div>
                                        </div>
                                        <!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Email</span>
                                                <span class="data-value"><?=$user['email']?></span>
                                            </div>
                                            <div class="data-col data-col-end"></div>
                                        </div>
                                        <!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Telephone</span>
                                                <span class="data-value text-soft"><?=$user['phone']?></span>
                                            </div>
                                            <div class="data-col data-col-end"></div>
                                        </div>
                                        <!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Date de naissance</span>
                                                <span class="data-value"><?=$user['birthday']?></span>
                                            </div>
                                            <div class="data-col data-col-end"></div>
                                        </div>
                                        <!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Adresse</span>
                                                <span class="data-value"><?=$user['address']?></span>
                                            </div>
                                            <div class="data-col data-col-end"></div>
                                        </div>
                                        <!-- data-item -->
                                        <div class="data-head">
                                            <h6 class="overline-title">Plus</h6>
                                        </div>
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Tpe d'utilisateur</span>
                                                <span class="data-value"><?= $userType['name'] ?></span>
                                            </div>
                                            <div class="data-col data-col-end"></div>
                                        </div>
                                        <!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Nom d'utilisation</span>
                                                <span class="data-value"><?= $user['username'] ?></span>
                                            </div>
                                            <div class="data-col data-col-end"></div>
                                        </div>
                                        <!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Nom complet</span>
                                                <span class="data-value"><?= $user['name'] ?></span>
                                            </div>
                                            <div class="data-col data-col-end"></div>
                                        </div>
                                        <!-- data-item -->
                                    </div>
                                    <!-- data-list -->
                                </div>
                                <!-- .nk-block -->
                            </div>
                            <div
                                class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg"
                                data-toggle-body="true"
                                data-content="userAside"
                                data-toggle-screen="lg"
                                data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar="data-simplebar">
                                    <div class="card-inner">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary">
                                                <span>AB</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?=$user['name']?></span>
                                                <span class="sub-text"><?=$user['email']?></span>
                                            </div>
                                            <div class="user-action">
                                                <div class="dropdown">
                                                    <a class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown" href="#">
                                                        <em class="icon ni ni-more-v"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="#">
                                                                    <em class="icon ni ni-camera-fill"></em>
                                                                    <span>Photo de profile</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- .user-card -->
                                    </div>
                                    <!-- .card-inner -->
                                    <div class="card-inner p-0">
                                        <ul class="link-list-menu">
                                            <li>
                                                <a class="active" href="html/user-profile-regular.html">
                                                    <em class="icon ni ni-user-fill-c"></em>
                                                    <span>Personal Infomation</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- .card-inner -->
                                </div>
                                <!-- .card-inner-group -->
                            </div>
                            <!-- card-aside -->
                        </div>
                        <!-- .card-aside-wrap -->
                    </div>
                    <!-- .card -->
                </div>
                <!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
</div>
<!-- wrap @e -->
</div>
<!-- app-root @e -->
<!-- @@ Profile Edit Modal @e -->
<div
class="modal fade"
id="profile_edit"
style="display: none;"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
<div class="modal-content">
    <a href="#" class="close" data-bs-dismiss="modal">
        <em class="icon ni ni-cross-sm"></em>
    </a>
    <div class="modal-body modal-body-lg">
        <h5 class="title">Update Profile</h5>
        <ul class="nk-nav nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#personal">Personal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#address">Address</a>
            </li>
        </ul>
        <!-- .nav-tabs -->
        <div class="tab-content">
            <div class="tab-pane active" id="personal">
                <form id="Updateinfo" method="post">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="newName">Nom</label>
                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    name="name"
                                    id="newName">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="newUsername">Nom d'utilisateur</label>
                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    name="username"
                                    id="newUsername">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="newPhone">Telephone</label>
                                <input type="text" class="form-control form-control-lg" name="phone" id="newPhone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="newBirthday">Date d'anniversaire</label>
                                <input
                                    type="text"
                                    class="form-control form-control-lg date-picker"
                                    name="birthday"
                                    id="newBirthday">
                            </div>
                        </div>
                        <input type="hidden" id="userId" name="userId" value="<?= $user['id'] ?>" class="id">
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button
                                        href="#"
                                        data-bs-dismiss="modal"
                                        id="update_info_btn"
                                        class="btn btn-lg btn-primary">Mettre a jour</button>
                                </li>
                                <li>
                                    <a href="#" data-bs-dismiss="modal" class="link link-light">Annuler</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <!-- .tab-pane -->
            <div class="tab-pane" id="address">
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="address-l1">Address Line 1</label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="address-l1"
                                value="2337 Kildeer Drive">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="address-l2">Address Line 2</label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="address-l2"
                                value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="address-st">State</label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="address-st"
                                value="Kentucky">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="address-county">Country</label>
                            <select class="form-select js-select2" id="address-county" data-ui="lg">
                                <option>Canada</option>
                                <option>United State</option>
                                <option>United Kindom</option>
                                <option>Australia</option>
                                <option>India</option>
                                <option>Bangladesh</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                            <li>
                                <a href="#" class="btn btn-lg btn-primary">Update Address</a>
                            </li>
                            <li>
                                <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- .tab-pane -->
        </div>
        <!-- .tab-content -->
    </div>
    <!-- .modal-body -->
</div>
<!-- .modal-content -->
</div>
<!-- .modal-dialog -->
</div>
<!-- .modal -->
<?= include_once("./views/include/footer.php") ?>