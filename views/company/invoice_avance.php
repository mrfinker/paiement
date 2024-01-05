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

require LIBS . 'tcpdf/tcpdf.php'; // ou le chemin vers tcpdf/tcpdf.php si installation manuelle

if (isset($_SESSION['pdfAvance'])) {
    $pdfAvance = $_SESSION['pdfAvance'];
}

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Ajouter une page
$pdf->AddPage();

// Récupérer le contenu HTML
$html = '
<div>
    <h3>Facture avance sur salaire</h3>
    <div>
        <h4>Créé à: ' . $pdfAvance['created_at'] . '</h4> <!-- Exemple de données de session -->
    </div>
    <div>
        <table cellpadding="4" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%;">
            <tr>
                <td style="width: 30%;"><strong>Facture de :</strong></td>
                <td style="width: 70%;">' . $pdfAvance['staff_name'] . '</td>
            </tr>
            <tr>
                <td><strong>Compagnie :</strong></td>
                <td>' . $pdfAvance['company_name'] . '</td>
            </tr>
            <tr>
                <td><strong>Numero de reference :</strong></td>
                <td>' . $pdfAvance['avance_reference'] . '</td>
            </tr>
            <tr>
                <td><strong>Code de reference :</strong></td>
                <td>' . $pdfAvance['avance_code'] . '</td>
            </tr>
            <tr>
                <td><strong>Date de paiement :</strong></td>
                <td>' . $pdfAvance['month_year'] . '</td>
            </tr>
            <tr>
                <td><strong>Date d\'aujourd\'hui :</strong></td>
                <td>' . date("d/m/Y") . '</td>
            </tr>
        </table>
    </div>
    <h3>Informations</h3>
    <div>
        <table cellpadding="4" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th><strong>Description</strong></th>
                    <th><strong>Type</strong></th>
                    <th><strong>Montant</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>' . $pdfAvance['description'] . '</td>
                    <td>' . $pdfAvance['paiement_type'] . '</td>
                    <td>' . $pdfAvance['advance_amount'] . '</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        La facture a été créée sur ordinateur et n\'est pas valable sans la signature et le sceau.
    </div>
</div>
';

// Écrire le contenu HTML dans le PDF
$pdf->writeHTML($html, true, false, true, false, '');

$dateNow = date("Y-m-d_H-i-s"); // Date au format AAAA-MM-JJ

// Fermer et sortir le document PDF
$pdf->Output('bulletin_avance_sur_salaire_'. $dateNow .'.pdf', 'I');