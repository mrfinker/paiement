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

?>
<?php include_once './views/include/header.php'; ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Facture avance <strong class="text-primary small" id="avance_code"></strong></h3>
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
                        <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" onclick="printInvoice()"><em class="icon ni ni-printer-fill"></em></a>
                        <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="<?= URL ?>/public/html/invoice-print.html" target="_blank"><em class="icon ni ni-save-fill"></em></a>
                    </div><!-- .invoice-actions -->
                    <div class="card invoice-wrap">
                        <div class="invoice-brand text-center">
                            <div href="html/index.html" class="logo-link">
                                <img class="logo-light logo-img" src="<?= URL ?>/public/images/logo.png" srcset="<?= URL ?>/public/images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img" src="<?= URL ?>/public/images/logo-dark.png" srcset="<?= URL ?>/public/images/logo-dark2x.png 2x" alt="logo-dark">
                            </div>
                        </div>
                        <div class="invoice-head">
                            <div class="invoice-desc">
                                <span class="overline-title">Facture de</span>
                                <div class="invoice-contact-info">
                                    <h4 class="title" id="account_name_2" style="width: 250px;"></h4>
                                    <ul class="list-plain">
                                        <li class="invoice-date" style="width:300px;"><span>Compagnie</span> : <span id="company_name"></span></li>
                                        <li class="invoice-date" style="width:300px;"><span>Numero de reference</span> : <span id="avance_reference"></span></li>
                                        <li class="invoice-date" style="width:300px;"><span>Date de paiement</span> : <span id="month_year"></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-desc">
                                <h3 class="title" style="font-size:large">Infos</h3>
                                <ul class="list-plain">
                                    <li class="invoice-id"><span>Date </span> : <span id="today_date"></span></li>
                                    <li class="invoice-id"><span>Chargé </span> : <span id="staff_name"></span></li>
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
                                            <th>Type</th>
                                            <th class="w-10">Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span id="description">
                                                </span>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td id="paiement_type"></td>
                                            <td id="advance_amount"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">Montant</td>
                                            <td id="transactions_amount_2"></td>
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
    </div>
</div>
<script>
    function printInvoice() {
        // Cacher la partie nk-main
        const nkSidebar = document.querySelector('.nk-sidebar');
        nkSidebar.style.display = 'none';

        const nkHeader = document.querySelector('.nk-header');
        nkHeader.style.display = 'none';

        // Cacher les autres éléments de la page
        const buttonsToHide = document.querySelectorAll('.invoice-action');
        buttonsToHide.forEach(button => {
            button.style.display = 'none';
        });

        // Imprimer la partie désignée
        window.print();

        // Afficher à nouveau la partie nk-main
        nkSidebar.style.display = 'block';

        // Afficher à nouveau la partie nk-main
        nkHeader.style.display = 'block';

        // Afficher à nouveau les éléments cachés après l'impression
        buttonsToHide.forEach(button => {
            button.style.display = 'block';
        });
    }
</script>
<?php include_once './views/include/footer.php' ?>