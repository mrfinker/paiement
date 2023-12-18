<?php

require 'vendor/autoload.php'; // ou le chemin vers tcpdf/tcpdf.php si installation manuelle

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

// Créer un nouveau document Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$selectedUserIds = isset($_GET['users']) ? explode(',', $_GET['users']) : null;
$userscompany = $selectedUserIds ? $companyModel->getAllUsersIdByCreatorAndCompany($selectedUserIds) : $companyModel->getAllUsersByCreatorAndCompany();
$timesheets  = $companyModel->getAllTimesheetsByCreatorAndCompany();

// Récupérez le mois et l'année actuels
$currentMonth = $_GET['month'];
$currentYear = $_GET['year'];
$currentMonthYear = $currentMonth . '-' . $currentYear;

// Obtenez le nombre de jours dans le mois actuel
$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Créer une liste des jours du mois actuel
$daysInMonth = range(1, cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear));

// Ajouter le titre et le mois/année actuels
$sheet->setCellValue('A1', 'Liste des presences');
$sheet->setCellValue('A2', $currentMonthYear);

// Définir la largeur des colonnes (adapté de votre code TCPDF)
$nombreDeColonnes = 34;
$sheet->getColumnDimension('A')->setWidth(20); // Largeur adaptée pour le nom

// Cellules pour chaque jour du mois
for ($day = 1, $col = 'B'; $day <= $daysInCurrentMonth; $day++, $col++) {
    $dayOfWeek = date('D', strtotime("$currentYear-$currentMonth-$day"));
    $sheet->setCellValue($col . '3', $dayOfWeek . "\n" . $day);
}

// Ajouter les données des utilisateurs
$row = 4;
foreach ($userscompany as $users) {
    $timesheetData = $companyModel->getCurrentMonthTimesheetsByCreatorAndCompanyFiltered($users['id'], $currentMonth, $currentYear);
    $timesheetDays = $timesheetData['days'];
    $officeShift = $timesheetData['officeShift'];
    $sheet->setCellValue('A' . $row, $users['name']);

    for ($i = 1, $col = 'B'; $i <= $daysInCurrentMonth; $i++, $col++) {
        $dayKeyIn = strtolower(date('l', strtotime(date($currentYear . '-' . $currentMonth . '-' . $i)))) . '_in_time';
        $dayKeyOut = strtolower(date('l', strtotime(date($currentYear . '-' . $currentMonth . '-' . $i)))) . '_out_time';

        $cellContent = '';
        if (isset($timesheetDays[$i]) && $timesheetDays[$i] == 'P') {
            $cellContent = 'P';
        } elseif (
            isset($officeShift[$dayKeyIn]) && empty($officeShift[$dayKeyIn]) &&
            isset($officeShift[$dayKeyOut]) && empty($officeShift[$dayKeyOut])
        ) {
            $cellContent = 'O';
        } else {
            $cellContent = 'A';
        }

        $sheet->setCellValue($col . $row, $cellContent);
    }

    $row++;
}

// Ajustement automatique de la largeur des colonnes
foreach (range('A', $col) as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Activer l'ajustement du texte dans les cellules
$styleArray = [
    'alignment' => [
        'wrapText' => true,
    ],
];

$sheet->getStyle('A1:' . $col . $row)->applyFromArray($styleArray);

// Préparer pour l'écriture dans un fichier Excel et le téléchargement
$writer = new Xlsx($spreadsheet);
$dateTimeNow = date("Y-m-d_H-i-s");
$fileName = 'liste_presence_' . $dateTimeNow . '.xlsx';

// En-têtes pour le téléchargement
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
$writer->save('php://output');
exit;
