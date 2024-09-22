<?php 
include 'db_connect.php';

// Query to retrieve all data from the rsvp table
$sql = "SELECT * FROM rsvp"; // Change 'rsvp' to your table name
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["nama"]. " - Phone: " . $row["phone"]. " - RSVP: " . $row["attendance"]. " - Pax: " . $row["pax"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();

?>