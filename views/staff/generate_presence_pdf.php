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

$pdf = new TCPDF();
$pdf->AddPage();

// Récupérez le mois et l'année actuels
$currentMonth = $_GET['month'];
$currentYear = $_GET['year'];

// Configuration de la police pour le titre
$pdf->SetFont('helvetica', 'B', 14); // Police en gras et taille 14

// Ajouter le titre
$title = 'Liste des presences';
$pdf->Write(0, $title, '', 0, 'C', true, 0, false, false, 0);

// Ajouter un soulignement sous le titre
$pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

$pdf->Ln(3); // Ajouter un peu d'espace après le titre

// Récupérez le mois et l'année actuels
$currentMonthYear = $currentMonth . '-' . $currentYear;
$pdf->Write(0, $currentMonthYear, '', 0, 'C', true, 0, false, false, 0);

$pdf->Ln(3); // Ajouter un peu d'espace après le titre

// Configuration de la police pour le reste du contenu
$pdf->SetFont('helvetica', '', 10);

// Calculer la largeur de chaque cellule
$nombreDeColonnes = 32; // Nombre total de colonnes (1 pour le nom + 31 pour les jours)
$largeurPage = 210; // Largeur d'une page A4 en mm
$largeurMarge = 20; // Total des marges gauche et droite
$largeurCellule = ($largeurPage - $largeurMarge) / $nombreDeColonnes;

$selectedUserIds = isset($_GET['users']) ? explode(',', $_GET['users']) : null;

$companyModel = new staff_model();
$userscompany = $selectedUserIds ? $companyModel->getAllUsersIdByCreatorAndCompany($selectedUserIds) : $companyModel->getAllUsersByCreatorAndCompany();
$timesheets  = $companyModel->getAllTimesheetsByCreatorAndCompany();

// Obtenez le nombre de jours dans le mois actuel
$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Créer une liste des jours du mois actuel
$daysInMonth = range(1, cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear));

// Cellules pour chaque jour du mois
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell($largeurCellule + 20, 5, "Jours", 1, 'L', 0, 0, '', '', true);
for ($day = 1; $day <= $daysInCurrentMonth; $day++) {
    $dayOfWeek = date('D', strtotime("$currentYear-$currentMonth-$day"));
    $pdf->MultiCell($largeurCellule - 0.5, 5, $day, 1, 'C', 0, 0, '', '', true);
}
$pdf->Ln();

foreach ($userscompany as $users) {
    $timesheetData = $companyModel->getCurrentMonthTimesheetsByCreatorAndCompanyFiltered($users['id'], $currentMonth, $currentYear);
    $timesheetDays = $timesheetData['days'];
    $officeShift = $timesheetData['officeShift'];

    $pdf->SetFont('helvetica', '', 8);

    // Calculez la hauteur nécessaire pour le nom de l'utilisateur
    $name = $users['name'];
    $nameWidth = $largeurCellule + 20; // La largeur de la cellule du nom
    $nameHeight = $pdf->getStringHeight($nameWidth, $name);

    // Assurez-vous que la hauteur de la cellule est suffisante pour au moins une ligne
    $cellHeight = max($nameHeight, 5);

    // Écrivez le nom de l'utilisateur avec la hauteur calculée
    $pdf->MultiCell($nameWidth, $cellHeight, $name, 1, 'L', 0, 0, '', '', true);

    for ($i = 1; $i <= $daysInCurrentMonth; $i++) {
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

        // Add a MultiCell for each day
        $pdf->MultiCell($largeurCellule - 0.5, $cellHeight, $cellContent, 1, 'C', 0, 0, '', '', true);
    }

    $pdf->Ln($cellHeight);
}
$dateNow = date("Y-m-d_H-i-s"); // Date au format AAAA-MM-JJ

// Nom du fichier avec la date
$fileName = 'liste_presence_' . $dateNow . '.pdf';

// Générer le PDF et indiquer au navigateur de le télécharger ou de l'afficher
$pdf->Output($fileName, 'I');
