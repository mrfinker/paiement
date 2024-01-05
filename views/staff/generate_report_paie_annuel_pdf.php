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

$nomUtilisateur = $user['name'] ?? 'Nom non disponible';

require LIBS . 'tcpdf/tcpdf.php'; // ou le chemin vers tcpdf/tcpdf.php si installation manuelle

$selectedUserIds = isset($_GET['users']) ? explode(',', $_GET['users']) : null;


$currentMonth = date('m');
$currentYear = date('Y');
$getYear = isset($_GET['year']) ? filter_var($_GET['year'], FILTER_SANITIZE_NUMBER_INT) : date('Y');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator("Créé par " . $nomUtilisateur);
$pdf->SetHeaderData('', 0, "Rapport de paie annuel - $getYear", "$currentMonth - $currentYear\nCréé par " . $nomUtilisateur);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

$companyModel = new staff_model();
$accounts = $companyModel->getAllAccountsByCreatorAndCompany();
$depots = $companyModel->getAllDepotsByCreatorAndCompany();
$userscompany = $selectedUserIds ? $companyModel->getAllUsersIdByCreatorAndCompany($selectedUserIds) : $companyModel->getAllUsersByCreatorAndCompany();
$timesheets  = $companyModel->getAllTimesheetsByCreatorAndCompany();

// Obtenez le nombre de jours dans le mois actuel
$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Créer une liste des jours du mois actuel
$daysInMonth = range(1, cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear));

$style = 'style="font-size: 6pt; border: 0.5px solid #000;"'; // Définissez le style ici

$html = '<table border="0.5" cellpadding="2" cellspacing="1">'; // Réduire la taille de la bordure
$html .= '<thead>
            <tr>
                <th ' . $style . '>Noms</th>'; // Appliquez le style à chaque cellule
// Récupérer l'année depuis POST ou utiliser l'année actuelle


// En-têtes des mois
for ($i = 1; $i <= 12; $i++) {
    $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Paris', IntlDateFormatter::GREGORIAN, 'MMMM');
    $date = new DateTime("$getYear-$i-1");
    $nomDuMois = $formatter->format($date);
    $html .= '<th ' . $style . '>' . $nomDuMois . '</th>'; // Appliquez le style à chaque cellule
}

$html .= '</tr></thead>';

// Corps du tableau
$html .= '<tbody>';
foreach ($userscompany as $user) {
    $paymentData = $companyModel->getAllPayementCurrentYearByCreatorAndCompanyFiltered($user['id'], $getYear);

    $html .= '<tr><td ' . $style . '>' . htmlspecialchars($user['name']) . '</td>'; // Appliquez le style à chaque cellule

    for ($month = 1; $month <= 12; $month++) {
        $netSalary = array_key_exists($month, $paymentData) ? $paymentData[$month] : '-';
        $html .= '<td ' . $style . '>' . htmlspecialchars($netSalary) . " $" . '</td>'; // Appliquez le style à chaque cellule
    }

    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>'; // Fin du tableau


$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$dateNow = date("Y-m-d_H-i-s"); // Date au format AAAA-MM-JJ

// Nom du fichier avec la date
$fileName = 'liste_report_paie_annuel_' . $dateNow . '.pdf';

// Générer le PDF et indiquer au navigateur de le télécharger ou de l'afficher
$pdf->Output($fileName, 'I');
