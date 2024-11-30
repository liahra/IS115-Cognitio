<?php
require('./pdf/fpdf186/fpdf.php'); // Inkluder FPDF

// Opprett PDF-objekt
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Overskrift
$pdf->Cell(190, 10, 'Kommende Innleveringer', 0, 1, 'C');

// Simuler oppgave-data (hent dine faktiske data fra databasen)
$upcomingTasks = [
    ['title' => 'Oppgave 1', 'course_code' => 'INF101', 'due_date' => '2024-12-01', 'status' => 'Ikke levert'],
    ['title' => 'Oppgave 2', 'course_code' => 'MAT102', 'due_date' => '2024-12-05', 'status' => 'Levert']
];

// Legg til oppgaver i PDF
foreach ($upcomingTasks as $task) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Tittel: {$task['title']}", 0, 1);
    $pdf->Cell(0, 10, "Emne: {$task['course_code']}", 0, 1);
    $pdf->Cell(0, 10, "Forfall: {$task['due_date']}", 0, 1);
    $pdf->Cell(0, 10, "Status: {$task['status']}", 0, 1);
    $pdf->Ln(); // Linjeskift
}

// Output PDF
$pdf->Output('I', 'innleveringer.pdf'); // 'I' for å vise i nettleser, 'D' for nedlasting
?>