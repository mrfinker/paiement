<?php

require LIBS . 'tcpdf/tcpdf.php'; // ou le chemin vers tcpdf/tcpdf.php si installation manuelle

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

$pdf = new TCPDF();
$pdf->AddPage();

$selectedUserIds = isset($_GET['users']) ? explode(',', $_GET['users']) : null;
$userc = $selectedUserIds ? $companyModel->getAllUsersIdByCreatorAndCompany($selectedUserIds) : $companyModel->getAllUsersByCreatorAndCompany();
$usersRoles = $companyModel->getAllUserRoles();
$usersDepartements = $companyModel->getAllDepartmentsByCreatorAndCompany();
$countries = $companyModel->getAllCountry();
$office_shifts = $companyModel->getAllOfficeShiftsByCreatorAndCompany();
$branches = $companyModel->getAllDesignationsByCreatorAndCompany();

// Entêtes de colonnes
$entetes = ["Nom", "Poste", "Début du contrat", "Fin du contrat", "Type de contrat", "Genre", "Téléphone", "Pays", "Rôle"];

$pdf->SetFont('helvetica', 'B', 14); // Police en gras ('B') et taille 14

// Ajouter le titre
$title = 'Liste des utilisateurs';
$pdf->Write(0, $title, '', 0, 'C', true, 0, false, false, 0);

// Ajouter un soulignement
$pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

$pdf->Ln(5); // Ajouter un peu d'espace après le titre

// Définir la police
$pdf->SetFont('helvetica', '', 8);

// Calculer la largeur de chaque cellule
$nombreDeColonnes = 9; // Nombre total de colonnes
$largeurPage = 210; // Largeur d'une page A4 en mm
$largeurMarge = 20; // Total des marges gauche et droite
$largeurCellule = ($largeurPage - $largeurMarge) / $nombreDeColonnes;

// Dessiner les entêtes
foreach ($entetes as $entete) {
    $pdf->Cell($largeurCellule, 5, $entete, 1, 0, 'C');
}
$pdf->Ln(); // Nouvelle ligne après l'en-tête

foreach ($userc as $usercomp) {

    $pdf->MultiCell($largeurCellule, 15, htmlspecialchars($usercomp['name'] ?? ''), 1, 'L', false, 0);
    $pdf->MultiCell($largeurCellule, 15, htmlspecialchars($usercomp['poste_name'] ?? ''), 1, 'L', false, 0);
    $pdf->MultiCell($largeurCellule, 15, htmlspecialchars($usercomp['contract_start'] ?? ''), 1, 'L', false, 0);

    $contract_end = $usercomp['contract_type'] === 'CDD' ? htmlspecialchars($usercomp['contract_end'] ?? '') : 'indéterminées';
    $pdf->MultiCell($largeurCellule, 15, $contract_end, 1, 'L', false, 0);

    $pdf->MultiCell($largeurCellule, 15, htmlspecialchars($usercomp['contract_type'] ?? ''), 1, 'L', false, 0);
    $pdf->MultiCell($largeurCellule, 15, htmlspecialchars($usercomp['gender'] ?? ''), 1, 'L', false, 0);
    $pdf->MultiCell($largeurCellule, 15, htmlspecialchars($usercomp['phone'] ?? ''), 1, 'L', false, 0);
    $pdf->MultiCell($largeurCellule, 15, htmlspecialchars($usercomp['country'] ?? ''), 1, 'L', false, 0);
    $pdf->MultiCell($largeurCellule, 15, htmlspecialchars($usercomp['role_name'] ?? ''), 1, 'L', false, 0);

    // Fin de la ligne du tableau
    $pdf->Ln();
}
// Format de la date
$dateNow = date("Y-m-d_H-i-s"); // Date au format AAAA-MM-JJ

// Nom du fichier avec la date
$fileName = 'liste_utilisateurs_' . $dateNow . '.pdf';

// Générer le PDF et indiquer au navigateur de le télécharger ou de l'afficher
$pdf->Output($fileName, 'I');
