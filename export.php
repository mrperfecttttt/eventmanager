<?php
// Query to fetch data from the table
$sql = "SELECT name, phone, email, attendance, pax FROM your_table_name";  // replace with your table name
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
        echo $row['name'] . "\t" . $row['phone'] . "\t" . $row['email'] . "\t" . $row['attendance'] . "\t" . $row['pax'] . "\n";
    }
} else {
    echo "No data found.\n";
}

// Close the connection
$conn->close();
?>
