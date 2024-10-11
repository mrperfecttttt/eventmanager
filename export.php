<?php
// Include the DOMPDF library
require 'dompdf/autoload.inc.php'; // Adjust the path if necessary

use Dompdf\Dompdf;

// Include the database connection
include 'db_connect.php';

// Create new DOMPDF instance
$dompdf = new Dompdf();

// Fetch data from database
$sql = "SELECT nama, phone, email, attendance, pax FROM rsvp"; // Replace 'rsvp' with your table name
$result = $conn->query($sql);

// Start building HTML content for the PDF
$html = '<h1 style="text-align: center;">RSVP Guest List</h1>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
$html .= '<thead><tr><th>Name</th><th>Phone</th><th>Email</th><th>Attendance</th><th>Pax</th></tr></thead><tbody>';

// Populate table with data
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['nama']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
    $html .= '<td>' . ucfirst(htmlspecialchars($row['attendance'])) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['pax']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Load HTML into DOMPDF
$dompdf->loadHtml($html);

// (Optional) Set the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to the browser
$dompdf->stream('RSVP_Guest_List.pdf', ['Attachment' => 1]);

// Close the connection
$conn->close();
?>
