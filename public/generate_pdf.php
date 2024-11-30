<?php

session_start();

require('../src/account.php');
require('../src/inc/utilities.inc.php');

$logger = new Logger();

$account = unserialize($_SESSION['account']);

require('./pdf/fpdf186/fpdf.php'); // Inkluder FPDF

// Opprett PDF-objekt
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Overskrift
$pdf->Cell(190, 10, 'Kommende Innleveringer', 0, 1, 'C');

try {
    $upcomingTasks = $account->getUpcomingTasks();
    if (sizeof($upcomingTasks) > 0) {

        // Legg til oppgaver i PDF
        foreach ($upcomingTasks as $task) {
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, "Tittel: {$task['title']}", 0, 1);
            $pdf->Cell(0, 10, "Emne: {$task['course_code']}", 0, 1);
            $pdf->Cell(0, 10, "Forfall: " . formatNorwegianDateTime($task['due_date']), 0, 1);
            $pdf->Cell(0, 10, "Status: {$task['status']}", 0, 1);
            $pdf->Ln(); // Linjeskift
        }

        // Output PDF
        $pdf->Output('I', 'innleveringer.pdf'); // 'I' for å vise i nettleser, 'D' for nedlasting
    }
} catch (Exception $e) {
    $logger->logError($e->getMessage());
}
