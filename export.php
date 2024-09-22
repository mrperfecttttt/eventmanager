<?php
// Sample data for export
$guests = [
    ['name' => 'John Doe', 'rsvp' => 'Yes', 'email' => 'john@example.com'],
    ['name' => 'Jane Smith', 'rsvp' => 'Maybe', 'email' => 'jane@example.com'],
    ['name' => 'Alice Johnson', 'rsvp' => 'No', 'email' => 'alice@example.com'],
    ['name' => 'Bob Brown', 'rsvp' => 'Yes', 'email' => 'bob@example.com'],
];

// Set headers to force download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=\"guest_list.xls\"");
header("Cache-Control: max-age=0");

// Output Excel table headers
echo "Name\tRSVP Status\tEmail\n";

// Output data rows
foreach ($guests as $guest) {
    echo $guest['name'] . "\t" . $guest['rsvp'] . "\t" . $guest['email'] . "\n";
}
?>
