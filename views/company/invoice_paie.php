<?php

Session::init();

require LIBS . 'tcpdf/tcpdf.php'; // ou le chemin vers tcpdf/tcpdf.php si installation manuelle

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



<div class="nk-content nk-content-fluid">
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
    <div class="">
        <div class="invoice">
            <div class="invoice-action">
                <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" onclick="printInvoice()"><em class="icon ni ni-printer-fill"></em></a>
                <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="<?= URL ?>/public/html/invoice-print.html" target="_blank"><em class="icon ni ni-save-fill"></em></a>
            </div><!-- .invoice-actions -->
            <div class="invoice-wrap">
                <div class="invoice-brand text-center">
                    <div href="html/index.html" class="logo-link">
                        <img class="logo-light logo-img" src="<?= URL ?>/public/images/logo.png" srcset="<?= URL ?>/public/images/logo2x.png 2x" alt="logo">
                        <img class="logo-dark logo-img" src="<?= URL ?>/public/images/logo-dark.png" srcset="<?= URL ?>/public/images/logo-dark2x.png 2x" alt="logo-dark">
                    </div>
                </div>
                <div class="invoice-head">
                    <div class="invoice-desc">
                        <span class="overline-title">Facture à</span>
                        <div class="invoice-contact-info" style="width:300px;">
                            <h4 class="title" id="name"></h4>
                            <ul class="list-plain">
                                <li class="invoice-id"><span>Adresse</span>:<span id="address"></span></li>
                                <li class="invoice-date"><span>Telephone</span>:<span id="phone"></span></li>
                                <li class="invoice-date"><span>Departement</span>:<span id="department"></span></li>
                                <li class="invoice-date" style="width:300px;"><span>Branche</span>:<span id="designation"></span></li>
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
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="w-60">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span>
                                            Salaire apres taxe
                                        </span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="net_after_taxes"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>
                                            Maison
                                        </span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="housing"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>
                                            Transport
                                        </span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="transport"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>
                                            Avance sur salaire
                                        </span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="advance_salary"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">Salaire net</td>
                                    <td id="net_salary"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2"></td>
                                    <td></td>
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