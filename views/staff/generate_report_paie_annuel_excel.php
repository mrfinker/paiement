<?php

require 'vendor/autoload.php'; // ou le chemin vers tcpdf/tcpdf.php si installation manuelle

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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$companyModel = new staff_model();
$accounts = $companyModel->getAllAccountsByCreatorAndCompany();
$depots = $companyModel->getAllDepotsByCreatorAndCompany();
$userscompany = $companyModel->getAllUsersByCreatorAndCompany();
$timesheets  = $companyModel->getAllTimesheetsByCreatorAndCompany();

$currentMonth = date('m');
$currentYear = date('Y');
$getYear = $_GET['year'];

// Obtenez le nombre de jours dans le mois actuel
$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Créer une liste des jours du mois actuel
$daysInMonth = range(1, cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear));

// Création d'un nouvel objet Spreadsheet (le document Excel)
$spreadsheet = new Spreadsheet();
$nomUtilisateur = $user['name'] ?? 'Nom non disponible';
// Définition des propriétés du document
$spreadsheet->getProperties()
    ->setCreator($nomUtilisateur)
    ->setTitle("Rapport de paie annuel - $getYear")
    ->setDescription("$currentMonth - $currentYear");

// Sélectionnez la feuille de calcul active dans le document
$sheet = $spreadsheet->getActiveSheet();

// En-têtes des colonnes
$columnHeaders = ['Noms'];
for ($i = 1; $i <= 12; $i++) {
    $date = new DateTime("$getYear-$i-1");
    $columnHeaders[] = $date->format('F'); // Nom du mois
}

// Ajouter les en-têtes des colonnes à la première ligne
$sheet->fromArray($columnHeaders, null, 'A1');

// Style d'alignement
$styleArray = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

// Parcourir chaque utilisateur et ajouter leurs données
$row = 2; // Commence à la deuxième ligne
foreach ($userscompany as $user) {
    $paymentData = $companyModel->getAllPayementCurrentYearByCreatorAndCompanyFiltered($user['id'], $getYear);
    $rowData = [htmlspecialchars($user['name'])];

    for ($month = 1; $month <= 12; $month++) {
        $netSalary = array_key_exists($month, $paymentData) ? $paymentData[$month] : '-';
        $rowData[] = htmlspecialchars($netSalary) . " $";
    }

    // Ajouter la ligne au tableau
    $sheet->fromArray($rowData, null, 'A' . $row);
    $row++;
}

// Récupérer la colonne la plus haute
$highestColumn = $sheet->getHighestColumn();
$highestRow = $sheet->getHighestRow();

// Appliquer le style d'alignement à toutes les cellules
$sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray($styleArray);

// Ajuster la largeur de chaque colonne
for ($col = 'A'; $col !== $highestColumn; ++$col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Appliquer l'ajustement de la taille
$sheet->calculateColumnWidths();

// Écrire le fichier Excel
$writer = new Xlsx($spreadsheet);
$dateNow = date("Y-m-d_H-i-s"); // Date au format AAAA-MM-JJ
$fileName = 'liste_report_paie_annuel_' . $dateNow . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
