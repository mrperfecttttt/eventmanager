<?php
// Include the FPDF library
require('fpdf/fpdf.php');
include 'db_connect.php';  // This is your database connection

// Create a new instance of the FPDF class
$pdf = new FPDF();
$pdf->AddPage();

// Set title and meta
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Majlis Pernikahan Fikri dan Syahirah - RSVP List', 0, 1, 'C');
$pdf->Ln(5);  // Line break

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Event Date: 3 December 2024', 0, 1, 'C');
$pdf->Ln(10);

// Fetch RSVP data from the database
$sql = "SELECT nama, phone, attendance, pax FROM rsvp";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Set table headers
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Name', 1);
    $pdf->Cell(60, 10, 'Phone', 1);
    $pdf->Cell(30, 10, 'Attendance', 1);
    $pdf->Cell(30, 10, 'Pax', 1);
    $pdf->Ln();

    // Output the data row by row
    while ($row = $result->fetch_assoc()) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 10, $row['nama'], 1);
        $pdf->Cell(60, 10, $row['phone'], 1);
        $pdf->Cell(30, 10, ucfirst($row['attendance']), 1);  // Capitalize 'yes' or 'no'
        $pdf->Cell(30, 10, $row['pax'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190, 10, 'No RSVP data found.', 1, 1, 'C');
}

// Close the database connection
$conn->close();

// Output the PDF to the browser
$pdf->Output('D', 'RSVP_List.pdf');
