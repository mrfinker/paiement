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

$pdf = new TCPDF();
// Ajouter une page
$pdf->AddPage();

$companyModel = new company_model();
$userc = $companyModel->getAllUsersByCreatorAndCompany();
$usersRoles = $companyModel->getAllUserRoles();
$usersDepartements = $companyModel->getAllDepartmentsByCreatorAndCompany();
$countries = $companyModel->getAllCountry();
$office_shifts = $companyModel->getAllOfficeShiftsByCreatorAndCompany();

$name = isset($_SESSION['pdfData']['name']) ? $_SESSION['pdfData']['name'] : 'Non spécifié';
$address = isset($_SESSION['pdfData']['address']) ? $_SESSION['pdfData']['address'] : 'Non spécifié';
$phone = isset($_SESSION['pdfData']['phone']) ? $_SESSION['pdfData']['phone'] : 'Non spécifié';

$department = isset($_SESSION['pdfData']['department']) ? $_SESSION['pdfData']['department'] : 'Non spécifié';
$designation = isset($_SESSION['pdfData']['designation']) ? $_SESSION['pdfData']['designation'] : 'Non spécifié';
$created_at = isset($_SESSION['pdfData']['created_at']) ? $_SESSION['pdfData']['created_at'] : 'Non spécifié';

$basicSalary = isset($_SESSION['pdfData']['basicSalary']) ? $_SESSION['pdfData']['basicSalary'] : 'Non spécifié';
$totalTime = isset($_SESSION['pdfData']['totalTime']) ? $_SESSION['pdfData']['totalTime'] : 'Non spécifié';
$country = isset($_SESSION['pdfData']['country']) ? $_SESSION['pdfData']['country'] : 'Non spécifié';

$payslip_value = isset($_SESSION['pdfData']['payslip_value']) ? $_SESSION['pdfData']['payslip_value'] : 'Non spécifié';
$payslip_code = isset($_SESSION['pdfData']['payslip_code']) ? $_SESSION['pdfData']['payslip_code'] : 'Non spécifié';
$salary_month = isset($_SESSION['pdfData']['salary_month']) ? $_SESSION['pdfData']['salary_month'] : 'Non spécifié';

$year_to_date = isset($_SESSION['pdfData']['year_to_date']) ? $_SESSION['pdfData']['year_to_date'] : 'Non spécifié';
$department = isset($_SESSION['pdfData']['department']) ? $_SESSION['pdfData']['department'] : 'Non spécifié';
$net_salary = isset($_SESSION['pdfData']['net_salary']) ? $_SESSION['pdfData']['net_salary'] : 'Non spécifié';

$housing = isset($_SESSION['pdfData']['housing']) ? $_SESSION['pdfData']['housing'] : 'Non spécifié';
$transport = isset($_SESSION['pdfData']['transport']) ? $_SESSION['pdfData']['transport'] : 'Non spécifié';
$advance_salary = isset($_SESSION['pdfData']['advance_salary']) ? $_SESSION['pdfData']['advance_salary'] : 'Non spécifié';
$net_after_taxes = isset($_SESSION['pdfData']['net_after_taxes']) ? $_SESSION['pdfData']['net_after_taxes'] : 'Non spécifié';

// Définir l'en-tête et le pied de page
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Définir la police
$pdf->SetFont('helvetica', '', 7);

// Titre et mois de salaire
$title = "BULLETIN DE PAIE";
$Month = $salary_month; // Remplacez par la variable appropriée
$pdf->Cell(0, 0, "", 0, 1, 'L');
$pdf->Cell(0, 0, $title, 0, 1, 'C');
$pdf->Cell(0, 0, $Month, 0, 1, 'R');
$pdf->SetY($pdf->GetY() + 10);

// Tableau de gauche
$leftTable = '
<table border="0.5" cellspacing="0" cellpadding="2">
    <tr><th colspan="2">' . htmlspecialchars($name) . '</th></tr>
    <tr><td>Matricule</td><td>' . htmlspecialchars($name) . '</td></tr>
    <tr><td>Date d' . "'" . 'embauche</td><td>' . htmlspecialchars($name) . '</td></tr>
    <tr><td>Type de contrat</td><td>' . htmlspecialchars($address) . '</td></tr>
    <tr><td>Fonction</td><td>' . htmlspecialchars($address) . '</td></tr>
    <tr><td>N° CNSS</td><td>' . htmlspecialchars($address) . '</td></tr>
    <tr><td>Statut marital</td><td>' . htmlspecialchars($address) . '</td></tr>
    <tr><td>Enfant a charge</td><td>' . htmlspecialchars($address) . '</td></tr>
    <tr><td>Nationalité</td><td>' . htmlspecialchars($address) . '</td></tr>
</table>';

// Tableau de droite
$rightTable = '
<table border="0.5" cellspacing="0" cellpadding="2">
    <tr><td>Adresse</td><td>' . htmlspecialchars($address) . '</td></tr>
    <tr><td>Téléphone</td><td>' . htmlspecialchars($phone) . '</td></tr>
    <tr><td>Département</td><td>' . htmlspecialchars($department) . '</td></tr>
    <tr><td>Branche</td><td>' . htmlspecialchars($designation) . '</td></tr>
</table>';

// Écrire les tableaux dans des cellules séparées
$pdf->writeHTMLCell(70, '', '', '', $leftTable, 0, 0, 0, true, 'L', true);

$rightCellXPosition = 130; // Ajustez cette valeur selon vos besoins
$pdf->writeHTMLCell(70, '', $rightCellXPosition, '', $rightTable, 0, 0, 0, true, 'L', true);

$table = '
<table border="0.5" cellspacing="0" cellpadding="4">
    <tr>
        <td>Date de clôture du mois</td>
        <td></td>
        <td>Date de paiement</td> <!-- Cellule vide -->
        <td></td> <!-- Cellule vide -->
        <td>Devise</td> <!-- Cellule vide -->
        <td></td> <!-- Cellule vide -->
    </tr>
    <tr>
        <td>Mode de paiement</td> <!-- Cellule vide de la deuxième ligne -->
        <td>Espece</td> <!-- Cellule vide de la deuxième ligne -->
        <td>Banque</td> <!-- Cellule vide -->
        <td></td> <!-- Cellule vide -->
        <td>N° de compte</td> <!-- Cellule vide -->
        <td></td> <!-- Cellule vide -->
    </tr>
</table>';

$pdf->SetY($pdf->GetY() + 45);
$pdf->writeHTML($table, true, false, true, false, '');

// Définir le contenu
$htmlContent = '
<div class="invoice-wrap">
    <div class="invoice-bills">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>Montant :</td>
                    <td>' . htmlspecialchars($basicSalary) . '</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Salaire après taxe</td>
                    <td>' . htmlspecialchars($net_after_taxes) . '</td>
                </tr>
                <tr>
                    <td>Maison :</td>
                    <td>' . htmlspecialchars($housing) . '</td>
                </tr>
                <tr>
                    <td>Transport :</td>
                    <td>' . htmlspecialchars($transport) . '</td>
                </tr>
                <tr>
                    <td>Avance sur salaire</td>
                    <td>' . htmlspecialchars($advance_salary) . '</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>';

// Écrire le contenu HTML
$pdf->writeHTML($htmlContent, true, false, true, false, '');
$pdf->Output('bulletin_de_paie.pdf', 'I');
