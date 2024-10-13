<?php
// Include the FPDF library
require('fpdf/fpdf.php');
include 'db_connect.php';  // Database connection

// Create a new instance of the FPDF class
$pdf = new FPDF();
$pdf->AddPage();

// Set title and meta for the first page (All guests)
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Majlis Pernikahan Fikri dan Syahirah - RSVP List (All Guests)', 0, 1, 'C');
$pdf->Ln(5);  // Line break

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Event Date: 3 December 2024', 0, 1, 'C');
$pdf->Ln(10);

// Table properties
$columnWidths = [60, 60, 30, 30];  // Define the width of each column
$tableWidth = array_sum($columnWidths);  // Total width of the table
$marginLeft = (210 - $tableWidth) / 2;  // Center the table on an A4 page (210mm width)

// Fetch all RSVP data
$sqlAll = "SELECT nama, phone, attendance, pax FROM rsvp";
$resultAll = $conn->query($sqlAll);

if ($resultAll->num_rows > 0) {
    // Set table headers and center the table
    $pdf->SetX($marginLeft);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell($columnWidths[0], 10, 'Name', 1);
    $pdf->Cell($columnWidths[1], 10, 'Phone', 1);
    $pdf->Cell($columnWidths[2], 10, 'Attendance', 1);
    $pdf->Cell($columnWidths[3], 10, 'Pax', 1);
    $pdf->Ln();

    // Output the data row by row and center the rows
    while ($row = $resultAll->fetch_assoc()) {
        $pdf->SetX($marginLeft);  // Reset X position to marginLeft to keep the table centered
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($columnWidths[0], 10, $row['nama'], 1);
        $pdf->Cell($columnWidths[1], 10, $row['phone'], 1);
        $pdf->Cell($columnWidths[2], 10, ucfirst($row['attendance']), 1);  // Capitalize 'yes' or 'no'
        $pdf->Cell($columnWidths[3], 10, $row['pax'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190, 10, 'No RSVP data found.', 1, 1, 'C');
}

// Page 2: Guests who will attend (attendance = 'yes')
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'RSVP - Guests Who Will Attend', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'These guests have RSVP-ed with "Yes".', 0, 1, 'C');
$pdf->Ln(10);

// Fetch RSVP data where attendance = 'yes'
$sqlYes = "SELECT nama, phone, pax FROM rsvp WHERE attendance = 'yes'";
$resultYes = $conn->query($sqlYes);

if ($resultYes->num_rows > 0) {
    // Set table headers and center the table
    $pdf->SetX($marginLeft);  // Center table on page
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell($columnWidths[0], 10, 'Name', 1);
    $pdf->Cell($columnWidths[1], 10, 'Phone', 1);
    $pdf->Cell($columnWidths[2], 10, 'Pax', 1);
    $pdf->Ln();

    // Output the data row by row and keep table centered
    while ($row = $resultYes->fetch_assoc()) {
        $pdf->SetX($marginLeft);  // Reset X position for each row
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($columnWidths[0], 10, $row['nama'], 1);
        $pdf->Cell($columnWidths[1], 10, $row['phone'], 1);
        $pdf->Cell($columnWidths[2], 10, $row['pax'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190, 10, 'No guests will attend.', 1, 1, 'C');
}

// Page 3: Guests who will NOT attend (attendance = 'no')
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'RSVP - Guests Who Will Not Attend', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'These guests have RSVP-ed with "No".', 0, 1, 'C');
$pdf->Ln(10);

// Fetch RSVP data where attendance = 'no'
$sqlNo = "SELECT nama, phone, pax FROM rsvp WHERE attendance = 'no'";
$resultNo = $conn->query($sqlNo);

if ($resultNo->num_rows > 0) {
    // Set table headers and center the table
    $pdf->SetX($marginLeft);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell($columnWidths[0], 10, 'Name', 1);
    $pdf->Cell($columnWidths[1], 10, 'Phone', 1);
    $pdf->Cell($columnWidths[2], 10, 'Pax', 1);
    $pdf->Ln();

    // Output the data row by row
    while ($row = $resultNo->fetch_assoc()) {
        $pdf->SetX($marginLeft);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($columnWidths[0], 10, $row['nama'], 1);
        $pdf->Cell($columnWidths[1], 10, $row['phone'], 1);
        $pdf->Cell($columnWidths[2], 10, $row['pax'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190, 10, 'No guests will missed your event.', 1, 1, 'C');
}

// Close the database connection
$conn->close();

// Output the PDF to the browser
$pdf->Output('D', 'RSVP_List.pdf');
?>
