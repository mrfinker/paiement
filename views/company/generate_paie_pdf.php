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
$basicSalary = isset($_SESSION['pdfData']['basicSalary']) ? $_SESSION['pdfData']['basicSalary'] : 'Non spécifié';
// $created_at = isset($_SESSION['pdfData']['created_at']) ? $_SESSION['pdfData']['created_at'] : 'Non spécifié';

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

$cnss_company = isset($_SESSION['pdfData']['cnss_company']) ? $_SESSION['pdfData']['cnss_company'] : 'Non spécifié';
$cnss_employee = isset($_SESSION['pdfData']['cnss_employee']) ? $_SESSION['pdfData']['cnss_employee'] : 'Non spécifié';
$children = isset($_SESSION['pdfData']['children']) ? $_SESSION['pdfData']['children'] : 'Non spécifié';
$contract_start = isset($_SESSION['pdfData']['contract_start']) ? $_SESSION['pdfData']['contract_start'] : 'Non spécifié';
$contract_type = isset($_SESSION['pdfData']['contract_type']) ? $_SESSION['pdfData']['contract_type'] : 'Non spécifié';
$marital_status = isset($_SESSION['pdfData']['marital_status']) ? $_SESSION['pdfData']['marital_status'] : 'Non spécifié';
$poste_name = isset($_SESSION['pdfData']['poste_name']) ? $_SESSION['pdfData']['poste_name'] : 'Non spécifié';
$emplyee_id = isset($_SESSION['pdfData']['emplyee_id']) ? $_SESSION['pdfData']['emplyee_id'] : 'Non spécifié';
$bank_name = isset($_SESSION['pdfData']['bank_name']) ? $_SESSION['pdfData']['bank_name'] : 'Non spécifié';
$bank_number = isset($_SESSION['pdfData']['bank_number']) ? $_SESSION['pdfData']['bank_number'] : 'Non spécifié';
$presents_days = isset($_SESSION['pdfData']['presents_days']) ? $_SESSION['pdfData']['presents_days'] : 'Non spécifié';
$absents_days = isset($_SESSION['pdfData']['absents_days']) ? $_SESSION['pdfData']['absents_days'] : 'Non spécifié';
$ipr = isset($_SESSION['pdfData']['ipr']) ? $_SESSION['pdfData']['ipr'] : 'Non spécifié';
$inpp = isset($_SESSION['pdfData']['inpp']) ? $_SESSION['pdfData']['inpp'] : 'Non spécifié';
$onem = isset($_SESSION['pdfData']['onem']) ? $_SESSION['pdfData']['onem'] : 'Non spécifié';
$net_before_taxes = isset($_SESSION['pdfData']['net_before_taxes']) ? $_SESSION['pdfData']['net_before_taxes'] : 'Non spécifié';
$salary_imposable = isset($_SESSION['pdfData']['salary_imposable']) ? $_SESSION['pdfData']['salary_imposable'] : 'Non spécifié';
$none = "rien";

if ($advance_salary === "" || $advance_salary === "0" || $advance_salary === 0) {
    $advance_salary = floatval(0);
}
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
    <tr><td>Matricule</td><td>' . htmlspecialchars($emplyee_id) . '</td></tr>
    <tr><td>Date d' . "'" . 'embauche</td><td>' . htmlspecialchars($contract_start) . '</td></tr>
    <tr><td>Type de contrat</td><td>' . htmlspecialchars($contract_type) . '</td></tr>
    <tr><td>Fonction</td><td>' . htmlspecialchars($poste_name) . '</td></tr>
    <tr><td>N° CNSS</td><td>' . htmlspecialchars($none) . '</td></tr>
    <tr><td>Statut marital</td><td>' . htmlspecialchars($marital_status) . '</td></tr>
    <tr><td>Enfant a charge</td><td>' . htmlspecialchars($children) . '</td></tr>
    <tr><td>Nationalité</td><td>' . htmlspecialchars($country) . '</td></tr>
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
        <td>$</td> <!-- Cellule vide -->
    </tr>
    <tr>
        <td>Mode de paiement</td> <!-- Cellule vide de la deuxième ligne -->
        <td>Espece</td> <!-- Cellule vide de la deuxième ligne -->
        <td>Banque</td> <!-- Cellule vide -->
        <td>' . $bank_name . '</td> <!-- Cellule vide -->
        <td>N° de compte</td> <!-- Cellule vide -->
        <td>' . $bank_number . '</td> <!-- Cellule vide -->
    </tr>
</table>';

$pdf->SetY($pdf->GetY() + 50);
$pdf->writeHTML($table, true, false, true, false, '');

$table = '
<table border="0.5" cellspacing="0" cellpadding="4" width="100%">
    <tr>
        <td colspan="4" width="50%">ELEMENT DE PAIE</td>
        <td colspan="4" width="50%">CONTRIBUTIONS ET RETENUES</td>
    </tr>
    <tr>
        <td colspan="4" height="100%">
            <table border="0.5" cellspacing="0" cellpadding="4" width="100%" height="100%">
                <tr>
                    <td width="40%">Rubriques</td>
                    <td width="20%">Jours/Mois</td>
                    <td width="20%">Taux/%</td>
                    <td width="20%">Montant</td>
                </tr>
                <tr>
                    <td width="40%">Elements imposable</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                </tr>
                <tr>
                    <td width="40%">Salaire de base</td>
                    <td width="20%">' . $presents_days . '</td>
                    <td width="20%"></td>
                    <td width="20%">$ ' . $basicSalary . ' </td>
                </tr>
                <tr>
                    <td width="40%">heures supplementaire</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%">$ -</td>
                </tr>
                <tr>
                    <td width="40%">Congé annuel</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%">$ -</td>
                </tr>
                <tr>
                    <td width="40%">13ieme mois ' . date("Y") . '</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%">$ -</td>
                </tr>
                <tr>
                    <td width="40%">Regularisation</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%">$ -</td>
                </tr>
                <tr>
                    <td width="40%"></td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                </tr>
                <tr>
                    <td width="40%">S/Total</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%">$ ' . $basicSalary . '</td>
                </tr>
                <tr>
                    <td width="40%">Elements non imposable</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                </tr>
                <tr>
                    <td width="40%">Logement</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%">$ ' . $housing . '</td>
                </tr>
                <tr>
                    <td width="40%">Transport legal</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%">$ ' . $transport . '</td>
                </tr>
                <tr>
                    <td width="40%">S/Total</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%">$ ' . $housing + $transport . '</td>
                </tr>
                <tr>
                    <td width="40%">Total generale</td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                    <td width="20%"></td>
                </tr>
            </table>
        </td>
        <td colspan="4" height="100%">
            <table border="0.5" cellspacing="0" cellpadding="4" width="100%" height="100%">
                <tr>
                    <td width="40%">Rubriques 2</td>
                    <td width="20%">Taux/%</td>
                    <td width="40%">Montant</td>
                </tr>
                <tr>
                    <td width="40%">Contribution</td>
                    <td width="20%"></td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="40%">CNSS (employé)</td>
                    <td width="20%"></td>
                    <td width="40%">$ ' . $cnss_employee . '</td>
                </tr>
                <tr>
                    <td width="40%">CNSS (employeur)</td>
                    <td width="20%"></td>
                    <td width="40%">$ ' . $cnss_company . '</td>
                </tr>
                <tr>
                    <td width="40%">IPR (employé)</td>
                    <td width="20%"></td>
                    <td width="40%">$ ' . $ipr . '</td>
                </tr>
                <tr>
                    <td width="40%">INPP (employeur)</td>
                    <td width="20%"></td>
                    <td width="40%">$ ' . $inpp . '</td>
                </tr>
                <tr>
                    <td width="40%">ONEM (employeur)</td>
                    <td width="20%"></td>
                    <td width="40%">$ ' . $onem . '</td>
                </tr>
                <tr>
                    <td width="40%"></td>
                    <td width="20%"></td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="40%">S/Total</td>
                    <td width="20%"></td>
                    <td width="40%">$ ' . $cnss_employee + $cnss_company + $ipr + $inpp + $onem  . '</td>
                </tr>
                <tr>
                    <td width="40%">Retenues</td>
                    <td width="20%"></td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="40%">Quinzaine</td>
                    <td width="20%"></td>
                    <td width="40%">$ -</td>
                </tr>
                <tr>
                    <td width="40%">Autres paiements</td>
                    <td width="20%"></td>
                    <td width="40%">$ -</td>
                </tr>
                <tr>
                    <td width="40%"></td>
                    <td width="20%"></td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="40%"></td>
                    <td width="20%"></td>
                    <td width="40%"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

$pdf->writeHTML($table, true, false, true, false, '');

$table = '
<table border="0.5" cellspacing="0" cellpadding="4" width="100%">
    <tr>
        <td colspan="4" width="100%" height="100%">
               SOMMAIRE
        </td>    
    </tr>
    <tr colspan="4" height="100%" width="100%">
        <td colspan="4" width="13%">
               (*) Brut imposable
        </td>    
        <td colspan="4" width="14%">
        (*) CNSS (employé)
        </td>    
        <td colspan="4" width="14%">
        (*) Net imposable
        </td>    
        <td colspan="4" width="13%">
        (*) IPR (employé)
        </td>    
        <td colspan="4" width="15%">
        (*) Net non imposable
        </td>    
        <td colspan="4" width="11%">
        (*) Salaire net
        </td>    
        <td colspan="4" width="10%">
        (*) Retenues
        </td>    
        <td colspan="4" width="10%">
        (*) Net payé
        </td>    
    </tr>
    <tr colspan="4" height="100%" width="100%">
        <td colspan="4" width="13%">
        $ '. $salary_imposable .'
        </td>    
        <td colspan="4" width="14%">
        $ '. $cnss_employee .'
        </td>    
        <td colspan="4" width="14%">
        $ ' . $net_before_taxes . '
        </td>    
        <td colspan="4" width="13%">
        $ '. $ipr .'
        </td>    
        <td colspan="4" width="15%">
        $ '. $net_after_taxes . '
        </td>    
        <td colspan="4" width="11%">
        $ '. $net_salary . '
        </td>    
        <td colspan="4" width="10%">
        $ ' . $advance_salary. '
        </td>    
        <td colspan="4" width="10%">
        $ '. floatval($net_salary) - $advance_salary .'
        </td>    
    </tr>
</table>
';

$pdf->writeHTML($table, true, false, true, false, '');

$table = '
<table border="0.5" cellspacing="0" cellpadding="4" width="100%">
    <tr>
        <td colspan="4" width="100%" height="100%">
               <span>Message de l\'employeur</span> <br>
               Dans votre interet et pour vous permettre de faire valoir vos droits, veuillez conserver ce bulletin de paie sans limitation de durée.
        </td>    
    </tr>
</table>
';

$pdf->writeHTML($table, true, false, true, false, '');

$dateNow = date('d-m-Y H:i:s');
$pdf->Output('bulletin_de_paie_' . $dateNow . '.pdf', 'I');
