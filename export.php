<?php
// Include the FPDF library and database connection
require('fpdf/fpdf.php');
include 'db_connect.php';  // This will establish the connection

// Create instance of FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Add table headers
$pdf->Cell(40, 10, 'Name', 1);
$pdf->Cell(40, 10, 'Phone', 1);
$pdf->Cell(60, 10, 'Email', 1);
$pdf->Cell(30, 10, 'Attendance', 1);
$pdf->Cell(20, 10, 'Pax', 1);
$pdf->Ln();  // Line break

// Query to fetch data from the table
$sql2 = "SELECT nama, phone, email, attendance, pax FROM rsvp";  // replace with your table name
$result2 = $conn->query($sql);

// Output data rows
if ($result2->num_rows > 0) {
    while ($row2 = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row2['nama'], 1);
        $pdf->Cell(40, 10, $row2['phone'], 1);
        $pdf->Cell(60, 10, $row2['email'], 1);
        $pdf->Cell(30, 10, $row2['attendance'], 1);
        $pdf->Cell(20, 10, $row2['pax'], 1);
        $pdf->Ln();  // Line break
    }
} else {
    $pdf->Cell(190, 10, 'No data found', 1);
}

// Output the generated PDF to the browser
$pdf->Output('D', 'guest_list.pdf');  // 'D' forces the download of the PDF

// Close the connection
$conn->close();
?>
