<?php

Session::init();

require_once 'vendor/autoload.php'; // ou le chemin vers tcpdf/tcpdf.php si installation manuelle

use setasign\Fpdi\Fpdi;

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = $_SESSION['users'];
    $copany_id = $user['company_id'];
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
$info_company = $companyModel->getUserById_Company($copany_id);
$idnat = $info_company[0]['idnat'];

function writeWithSpacing($pdf, $spacing, $text, $x, $y)
{
    $pdf->SetXY($x, $y);
    for ($i = 0; $i < strlen($text); $i++) {
        $letter = $text[$i];
        $pdf->Write(0, $letter);
        if ($i < strlen($text) - 1) {
            $x += $pdf->GetStringWidth($letter) + $spacing;
            $pdf->SetXY($x, $y);
        }
    }
}

$spacing = 3; // Espacement entre les lettres, ajustez selon vos besoins
$x = 158; // Position de départ en X
$y = 88; // Position de départ en Y

$pdf = new FPDI();

// Récupérer les données JSON
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData);

if (isset($_SESSION['pdfData'])) {
    $data = $_SESSION['pdfData'];
    $year = $data['year'];
    $month = $data['month'];
    $users = $data['users'];
    // Votre code pour manipuler le PDF...
} else {
    die('Données non trouvées dans la session.');
}

$months = [
    "01" => "Janvier", "02" => "Fevrier", "03" => "Mars",
    "04" => "Avril", "05" => "Mai", "06" => "Juin",
    "07" => "Juillet", "08" => "Aout", "09" => "Septembre",
    "10" => "Octobre", "11" => "Novembre", "12" => "Decembre"
];

// Supposons que vous ayez récupéré la valeur du mois de $data
$monthNumber = $data['month']; // Par exemple, '03'

// Convertir le numéro du mois en nom
$monthName = isset($months[$monthNumber]) ? $months[$monthNumber] : 'Mois Inconnu';


// Importer une page d'un PDF existant
$localPdf = $_SERVER['DOCUMENT_ROOT'] . '/views/company/dgi/dgi.pdf';
$pageCount = $pdf->setSourceFile($localPdf);

$pdf->setSourceFile($localPdf);
// Boucler sur toutes les pages
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    // Ajouter une nouvelle page dans le PDF de sortie
    $pdf->AddPage();

    // Importer la page courante
    $templateId = $pdf->importPage($pageNo);

    // Utiliser la page importée comme template
    $pdf->useTemplate($templateId);

    // Si vous souhaitez ajouter du texte ou des données spécifiques à chaque page,
    // vous pouvez le faire ici. Par exemple :
    if ($pageNo == 1) {
        // Ajouter le texte uniquement sur la première page
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetXY(60, 62);
        $pdf->Write(0, $monthName);
        $pdf->SetXY(155, 62);
        $pdf->Write(0, $year);
        $pdf->SetXY(135, 108);
        $pdf->Write(0, $user['email']);
        $pdf->SetXY(135, 102);
        $pdf->Write(0, $user['phone']);
        writeWithSpacing($pdf, $spacing, $idnat, $x, $y);
        $pdf->SetXY(55, 85);
        $pdf->Write(0, $user['name']);
    }
}

// Enregistrer le nouveau PDF
$pdf->Output('nouveau_fichier.pdf', 'I');
