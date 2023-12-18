<?php

Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $userType = $_SESSION['userType'];
} else {
    header("Location:" . LOGIN);
    exit;
}

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "staff") {
    header('Location:' . ERROR);
    exit;
}
$companyModel = new staff_model();

?>
<?php include_once './views/include/header.php'; ?>

<div class="nk-content nk-content-fluid" id="invoice-content">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Facture comptes <strong class="text-primary small" id="account_name"></strong></h3>
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
                        <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" onclick="generatePDF()"><em class="icon ni ni-save-fill"></em></a>
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
                                        <li class="invoice-id" style="width:300px;"><span>Nom du compte</span>:<span id="creator_name"></span></li>
                                        <li class="invoice-date" style="width:300px;"><span>Numero de compte</span>:<span id="account_number"></span></li>
                                        <li class="invoice-date" style="width:300px;"><span>Numero banque</span>:<span id="bank_name"></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-desc">
                                <h3 class="title" style="font-size: large;">Date</h3>
                                <ul class="list-plain">
                                    <li class="invoice-id"><span id="today_date"></span><span></span></li>
                                </ul>
                            </div>
                        </div><!-- .invoice-head -->
                        <div class="invoice-bills">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="w-20">Refernce</th>
                                            <th class="w-20">Date</th>
                                            <th class="w-20">Nom</th>
                                            <th>Type</th>
                                            <th class="w-10">Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">Solde initial</td>
                                            <td id="solde_initial"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">Depenses</td>
                                            <td id="depenses"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">Depots</td>
                                            <td id="depots"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">Reste</td>
                                            <td id="Reste"></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function generatePDF() {
        const content = document.querySelector(".nk-content");

        // Configuration pour html2pdf
        const pdfOptions = {
            margin: 10,
            filename: 'facture.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        // Utilisez html2pdf pour convertir le contenu en PDF
        html2pdf().from(content).set(pdfOptions).outputPdf(function(pdf) {
            const blob = new Blob([pdf], {
                type: 'application/pdf'
            });
            const url = URL.createObjectURL(blob);

            // Créez un lien temporaire pour le téléchargement du PDF
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'facture.pdf';

            // Ajoutez le lien au corps du document et déclenchez un clic pour le télécharger
            document.body.appendChild(a);
            a.click();

            // Supprimez le lien après le téléchargement
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
    }
</script>

<script>
    function printInvoice() {
        // Cacher la partie nk-main
        const nkSidebar = document.querySelector('.nk-sidebar');
        nkSidebar.style.display = 'none';

        const nkHeader = document.querySelector('.nk-header');
        nkHeader.style.display = 'none';

        const nkCard = document.querySelector('.card');
        nkCard.classList.remove('card');

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