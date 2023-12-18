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

if (isset($_SESSION['userType']) && $_SESSION['userType']['name'] !== "company") {
    header('Location:' . ERROR);
    exit;
}

$selectedUserIds = isset($_GET['users']) ? explode(',', $_GET['users']) : null;

$companyModel = new company_model();
$userc = $selectedUserIds ? $companyModel->getAllUsersIdByCreatorAndCompany($selectedUserIds) : $companyModel->getAllUsersByCreatorAndCompany();
$usersRoles = $companyModel->getAllUserRoles();
$usersDepartements = $companyModel->getAllDepartmentsByCreatorAndCompany();
$countries = $companyModel->getAllCountry();
$office_shifts = $companyModel->getAllOfficeShiftsByCreatorAndCompany();
$branches = $companyModel->getAllDesignationsByCreatorAndCompany();

// Créer un nouveau document Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Ajouter des en-têtes de colonne
$sheet->setCellValue('A1', 'Nom');
$sheet->setCellValue('B1', 'Poste');
$sheet->setCellValue('C1', 'Début du contrat');
$sheet->setCellValue('D1', 'Fin du contrat');
$sheet->setCellValue('E1', 'Type de contrat');
$sheet->setCellValue('F1', 'Genre');
$sheet->setCellValue('G1', 'Téléphone');
$sheet->setCellValue('H1', 'Pays');
$sheet->setCellValue('I1', 'Rôle');

// Remplir les données
$row = 2;
foreach ($userc as $usercomp) {
    $sheet->setCellValue('A' . $row, $usercomp['name']);
    $sheet->setCellValue('B' . $row, $usercomp['poste_name']);
    $sheet->setCellValue('C' . $row, $usercomp['contract_start']);
    $contract_end = $usercomp['contract_type'] === 'CDD' ? ($usercomp['contract_end'] ?? '') : 'indéterminées';
    $sheet->setCellValue('D' . $row, $contract_end);
    $sheet->setCellValue('E' . $row, $usercomp['contract_type']);
    $sheet->setCellValue('F' . $row, $usercomp['gender']);
    $phoneNumber = (string)$usercomp['phone'];
    $sheet->setCellValueExplicit('G' . $row, $phoneNumber, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValue('H' . $row, $usercomp['country']);
    $sheet->setCellValue('I' . $row, $usercomp['role_name']);
    $row++;
}

// Ajustement automatique de la largeur des colonnes
foreach (range('A', 'I') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Activer l'ajustement du texte dans les cellules
$styleArray = [
    'alignment' => [
        'wrapText' => true,
    ],
];

$sheet->getStyle('A1:I' . $row)->applyFromArray($styleArray);

// Écrire dans un fichier Excel
$writer = new Xlsx($spreadsheet);
$dateTimeNow = date("Y-m-d_H-i-s");
$fileName = 'liste_utilisateurs_' . $dateTimeNow . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
$writer->save('php://output');
exit;
