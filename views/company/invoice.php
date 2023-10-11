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
    $companyModel = new company_model();
    $userc = $companyModel->getAllUsersByCreatorAndCompany();
    $usersRoles = $companyModel->getAllUserRoles();
    $usersDepartements = $companyModel->getAllDepartmentsByCreatorAndCompany();
    $countries = $companyModel->getAllCountry();
    $office_shifts = $companyModel->getAllOfficeShiftsByCreatorAndCompany();
    

?>
<?php include_once './views/include/header.php'; ?>

<div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-xl">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Bulletin de paie <strong class="text-primary small" id="payslip_code"></strong></h3>
                                        <div class="nk-block-des text-soft">
                                            <ul class="list-inline">
                                                <li>Créé à: <span class="text-base" id="created_at"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="invoice">
                                    <div class="invoice-action">
                                        <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary"><em class="icon ni ni-printer-fill"></em></a>
                                        <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="<?=URL?>/public/html/invoice-print.html" target="_blank"><em class="icon ni ni-save-fill"></em></a>
                                    </div><!-- .invoice-actions -->
                                    <div class="card invoice-wrap">
                                        <div class="invoice-brand text-center">
                                            <div href="html/index.html" class="logo-link">
                                                <img class="logo-light logo-img" src="<?=URL?>/public/images/logo.png" srcset="<?=URL?>/public/images/logo2x.png 2x" alt="logo">
                                                <img class="logo-dark logo-img" src="<?=URL?>/public/images/logo-dark.png" srcset="<?=URL?>/public/images/logo-dark2x.png 2x" alt="logo-dark">
                                            </div>
                                        </div>
                                        <div class="invoice-head">
                                            <div class="invoice-contact">
                                                <span class="overline-title">Facture à</span>
                                                <div class="invoice-contact-info">
                                                    <h4 class="title" id="name"></h4>
                                                    <ul class="list-plain">
                                                        <li><em class="icon ni ni-map-pin-fill"></em><span id="address"><br></span></li>
                                                        <li><em class="icon ni ni-call-fill"></em><span id="phone"></span></li>
                                                        <li><em class="icon ni ni-home-fill"></em><span id="designation"></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="invoice-desc">
                                                <h3 class="title">Facture</h3>
                                                <ul class="list-plain">
                                                    <li class="invoice-id"><span>Facture</span>:<span id="payslip_code_"></span></li>
                                                    <li class="invoice-date"><span>Date</span>:<span id="invoice_date_value"></span></li>
                                                    <li class="invoice-date"><span>Date paiement</span>:<span id="salary_month"></span></li>
                                                </ul>
                                            </div>
                                        </div><!-- .invoice-head -->
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-60">Description</th>
                                                            <th class="w-60"></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Montant</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Maison</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td id="housing">$40.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Transport</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td id="transport">$25.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>CNSS</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td id="cnss">$131.25</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">TAX</td>
                                                            <td>$43.50</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">Salaire net</td>
                                                            <td id="net_salary"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="nk-notes ff-italic fs-12px text-soft"> La facture a été créée sur ordinateur et n'est pas valable sans la signature et le sceau.</div>
                                            </div>
                                        </div><!-- .invoice-bills -->
                                    </div><!-- .invoice-wrap -->
                                </div><!-- .invoice -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
                <script>
    function printPromot() {
        window.print();
    }
</script>
<?php include_once './views/include/footer.php' ?>