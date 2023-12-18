<?php

Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location:" . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "company") {
    header('Location:' . ERROR);
    exit;
}
// Récupérez le mois et l'année actuels
$currentMonth = date('m');
$currentYear = date('Y');
$companyModel = new company_model();
$userc = $companyModel->getAllUsersByCreatorAndCompanyFiltered($currentYear, $currentMonth);
$usersRoles = $companyModel->getAllUserRoles();
$usersDepartements = $companyModel->getAllDepartmentsByCreatorAndCompany();
$countries = $companyModel->getAllCountry();
$office_shifts = $companyModel->getAllOfficeShiftsByCreatorAndCompany();



?>
<?php include_once './views/include/header.php'; ?>
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-xxl mx-auto">
                    <div class="nk-block nk-block-lg">

                        <div class="row gy-4 mb-4 d-flex align-conten">
                            <div class="col-lg-2 col-sm-4">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2 select2-hidden-accessible" data-search="on" data-ui="lg" id="year-select" onchange="changeYear()">
                                            <option>Choisir l'annee</option>
                                            <?php
                                            for ($year = 2029; $year >= 2000; $year--) {
                                                $selected = ($year == $currentYear) ? "selected" : "";
                                                echo "<option value='$year' $selected>$year</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2 select2-hidden-accessible" data-search="on" data-ui="lg" id="month-select" onchange="changeMonth()">
                                            <option>Choisir le mois</option>
                                            <?php
                                            $months = [
                                                "01" => "Janvier", "02" => "Fevrier", "03" => "Mars",
                                                "04" => "Avril", "05" => "Mai", "06" => "Juin",
                                                "07" => "Juillet", "08" => "Aout", "09" => "Septembre",
                                                "10" => "Octobre", "11" => "Novembre", "12" => "Decembre"
                                            ];

                                            foreach ($months as $num => $name) {
                                                $selected = ($num == $currentMonth) ? "selected" : "";
                                                echo "<option value='$num' $selected>$name</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                                <button href="#" class="btn-lg btn btn-primary" onclick="filterData()">
                                    <span>Filtrer</span>
                                    <em class="icon ni ni-setting"></em>
                                </button>
                            </div>

                        </div>

                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">
                                                    <span class="sub-text">#</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Image</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Noms</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                                                    <span class="sub-text">Employee ID</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Salaire de base</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    <span class="sub-text">Status</span>
                                                </th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                        : activate to sort column ascending">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="paiement_users">
                                            <?php
                                            foreach ($userc as $usercomp) {
                                            ?>

                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <!-- .nk-tb-item -->
                                                <tr class="nk-tb-item odd">
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="tb-lead">
                                                                    <?= $usercomp['num'] ?>
                                                                    <span class=" d-md-none ms-1"></span></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <div class="user-toggle">
                                                            <div class="user-avatar sm">
                                                                <?php if (isset($usercomp['image']) && !empty($usercomp['image'])) : ?>
                                                                    <img src="<?= $usercomp['image'] ?>" alt="User Avatar">
                                                                    <?php if ($usercomp['is_logged_in'] == 1) : ?>
                                                                        <div class="status dot dot-lg dot-success"></div>
                                                                    <?php else : ?>
                                                                        <div class="status dot dot-lg dot-danger"></div>
                                                                    <?php endif; ?>
                                                                <?php else : ?>
                                                                    <em class="icon ni ni-user-alt"></em>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-mb">
                                                        <span class="tb-amount"><?= $usercomp['name'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['emplyee_id'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span><?= $usercomp['basic_salary'] ?></span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <?php
                                                        if (isset($usercomp['payed']) && $usercomp['payed'] == 1 && $usercomp['salary_month'] == $currentYear . "-" . $currentMonth) :
                                                        ?>
                                                            <span class="badge badge-dim bg-success">Payé</span>
                                                        <?php else : ?>
                                                            <span class="badge badge-dim bg-danger">Non Payé</span>
                                                        <?php endif; ?>
                                                    </td>


                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <!-- <li class="nk-tb-action-hidden"> <a href="#" class="btn btn-trigger
                                                        btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wallet"
                                                        data-bs-original-title="Wallet"> <em class="icon ni ni-wallet-fill"></em> </a>
                                                        </li> <li class="nk-tb-action-hidden"> <a href="#" class="btn btn-trigger
                                                        btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Send
                                                        Email" data-bs-original-title="Send Email"> <em class="icon ni
                                                        ni-mail-fill"></em> </a> </li> <li class="nk-tb-action-hidden"> <a href="#"
                                                        class="btn btn-trigger btn-icon" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" aria-label="Suspend" data-bs-original-title="Suspend">
                                                        <em class="icon ni ni-user-cross-fill"></em> </a> </li> -->
                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                                        <em class="icon ni ni-more-h"></em>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <ul class="link-list-opt no-bdr">
                                                                            <li>
                                                                                <?php if (isset($usercomp['payed']) && $usercomp['payed'] == 1 && $usercomp['salary_month'] == $currentYear . "-" . $currentMonth) : ?>
                                                                                    <a href="#" class="facture_button_usercomp" data-id="<?= $usercomp['id']; ?>" data-name="<?= $usercomp['name']; ?>" data-address="<?= $usercomp['address']; ?>" data-phone="<?= $usercomp['phone']; ?>" data-created_at="<?= $usercomp['created_at']; ?>" data-basic_salary="<?= $usercomp['basic_salary']; ?>" data-total_time="<?= $usercomp['total_time']; ?>" data-country="<?= $usercomp['country']; ?>" data-payslip_value="<?= $usercomp['payslip_value']; ?>" data-payslip_code="<?= $usercomp['payslip_code']; ?>" data-salary_month="<?= $usercomp['salary_month']; ?>" data-year_to_date="<?= $usercomp['year_to_date']; ?>" data-net_salary="<?= $usercomp['net_salary']; ?>" data-housing="<?= $usercomp['housing']; ?>" data-transport="<?= $usercomp['transport']; ?>" data-net_after_taxes="<?= $usercomp['net_after_taxes']; ?>" data-advance_salary="<?= $usercomp['advanced_salary']; ?>" data-department="<?= $usercomp['department']; ?>" data-designation="<?= $usercomp['designation']; ?>">
                                                                                        <em class="icon ni ni-file-text"></em>
                                                                                        <span>Facture</span>
                                                                                    </a>
                                                                                <?php else : ?>
                                                                                    <a href="#" class="paye_button_usercomp" data-id="<?= $usercomp['id']; ?>" data-basic_salary="<?= $usercomp['basic_salary']; ?>" data-total_time="<?= $usercomp['total_time']; ?>" data-children="<?= $usercomp['children']; ?>" data-spouse="<?= $usercomp['spouse']; ?>" data-advanced_salary="<?= $usercomp['advanced_salary']; ?>" data-timesheet_count="<?= $usercomp['timesheet_count']; ?>" data-country="<?= $usercomp['country']; ?>">
                                                                                        <em class="icon ni ni-money"></em>
                                                                                        <span>Payer</span>
                                                                                    </a>
                                                                                <?php endif; ?>

                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-7 col-sm-12 col-md-9">
                                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">
                                            <ul class="pagination">
                                                <!-- <li class="paginate_button page-item previous disabled"
                                                id="DataTables_Table_1_previous"> <a aria-controls="DataTables_Table_1"
                                                aria-disabled="true" aria-role="link" data-dt-idx="previous" tabindex="0"
                                                class="page-link">Prev</a> </li> <li class="paginate_button page-item active">
                                                <a href="#" aria-controls="DataTables_Table_1" aria-role="link"
                                                aria-current="page" data-dt-idx="0" tabindex="0" class="page-link">1</a> </li>
                                                <li class="paginate_button page-item next" id="DataTables_Table_1_next"> <a
                                                href="#" aria-controls="DataTables_Table_1" aria-role="link" data-dt-idx="next"
                                                tabindex="0" class="page-link">Next</a> </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .card-preview -->
                </div>
                <!-- nk-block -->
            </div>
            <!-- .components-preview wide-lg mx-auto -->
        </div>
    </div>
</div>

<!-- payer users -->
<div class="modal fade" id="payeModalUsercomp" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Information de paiement</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="payeFormUsercomp" method="POST">
                    <div class="row gy-4">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="basic_salary">Salaire de base</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" id="basic_salary" name="basic_salary" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="absent_days">Jours absent</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" id="absent_days" name="absent_days" placeholder="Jours d'absence" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="timesheet_count">Jours presents</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" id="timesheet_count" name="timesheet_count" placeholder="Jours d'absence" readonly>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div>
                                <span class="badge badge-dim bg-success" id="hours_time_badge" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="jours" name="jours" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="regularization" name="regularization" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="other" name="other" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="leave" name="leave" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="monthlastone" name="monthlastone" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="advanced_salary" name="advanced_salary" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="children" name="children" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="spouse" name="spouse" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="telephone" name="telephone" style="font-size: 12px;"></span>
                                <span class="badge badge-dim bg-success" id="country" name="country" style="font-size: 12px;"></span>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">Salaire brut imposable</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="salary_imposable_display"></h3>
                                        <input type="hidden" id="salary_imposable" name="salary_imposable">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">Salaire net imposable</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="net_before_taxes_display"></h3>
                                        <input type="hidden" id="net_before_taxes" name="net_before_taxes">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">Salaire apres deduction</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="net_after_taxes_display"></h3>
                                        <input type="hidden" id="net_after_taxes" name="net_after_taxes">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">Maison</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="housing_display"></h3>
                                        <input type="hidden" id="housing" name="housing">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">Transport</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="transport_display"></h3>
                                        <input type="hidden" id="transport" name="transport">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">CNSS</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="cnss_display"></h3>
                                        <input type="hidden" id="cnss" name="cnss">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">Salaire net</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="salary_net_display"></h3>
                                        <input type="hidden" id="salary_net" name="salary_net">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">Salaire</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="final_salary_display"></h3>
                                        <input type="hidden" id="final_salary" name="final_salary">
                                    </div>
                                </div>
                            </div>

                            <label class="divider"></label>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">CNSS company</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="cnss_company_display"></h3>
                                        <input type="hidden" id="cnss_company" name="cnss_company">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">IERE</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="iere_display"></h3>
                                        <input type="hidden" id="iere" name="iere">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">INPP</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="inpp_display"></h3>
                                        <input type="hidden" id="inpp" name="inpp">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">ONEM</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="onem_display"></h3>
                                        <input type="hidden" id="onem" name="onem">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">Salaire brute company</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="salary_brut_company_display"></h3>
                                        <input type="hidden" id="salary_brut_company" name="salary_brut_company">
                                    </div>
                                    <div class="row-xxl d-flex justify-content-between">
                                        <span class="nk-col tb-col-sm primary">IPR</span>
                                        <h3 class="nk-col tb-col-sm" style="font-size: large;" id="ipr_display"></h3>
                                        <input type="hidden" id="ipr" name="ipr">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-textarea">Commentaire</label>
                                <div class="form-control-wrap">
                                    <textarea required="required" class="form-control no-resize" id="commentaire" name="commentaire" placeholder="Les raisons du paiement"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="id_users" name="id">
                        <div class="form-group mt-2">
                            <button type="submit" id="payement_btn" name="payement_btn" class="btn btn-lg btn-primary btn-block">Enregistrer les informations</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function filterData() {
        var year = document.getElementById('year-select').value;
        var month = document.getElementById('month-select').value;

        console.log("Année : " + year); // Affiche l'année dans la console
        console.log("Mois : " + month); // Affiche le mois dans la console

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= URL; ?>company/paiement_search', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('paiement_users').innerHTML = this.responseText;
            }
        };
        xhr.send('year=' + year + '&month=' + month);
    }
</script>

<script>
</script>

<?php include_once './views/include/footer.php' ?>