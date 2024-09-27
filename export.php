<?php
// Include the database connection file
include 'db_connect.php';  // This will establish the connection

// Query to fetch data from the table
$sql = "SELECT nama, phone, email, attendance, pax FROM rsvp";  // replace with your table name
$result = $conn->query($sql);

// Set headers to force download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=\"guest_list.xls\""); 
header("Cache-Control: max-age=0");

// Output Excel table headers
echo "Name\tPhone\tEmail\tAttendance\tPax\n";

// Output data rows
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Use tab-delimited format and ensure phone numbers are treated as text
        echo $row['nama'] . "\t" . '"' . $row['phone'] . '"' . "\t" . $row['email'] . "\t" . $row['attendance'] . "\t" . $row['pax'] . "\n";
    }
} else {
    echo "No data found.\n";
}

// Close the connection
$conn->close();
?>
