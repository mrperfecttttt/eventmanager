<?php
// Include the database connection file
include 'db_connect.php';  // This will establish the connection

// Pagination settings
$limit = 5; // Number of guests per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Calculate the offset for pagination

// Query to fetch total guest count
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM rsvp"); // replace 'rsvp' with your table name
$totalGuests = $totalResult->fetch_assoc()['total']; // Total number of guests
$totalPages = ceil($totalGuests / $limit); // Total number of pages

// Query to fetch the guests for the current page
$sql = "SELECT nama, phone, attendance, pax FROM rsvp LIMIT $offset, $limit";  // replace 'rsvp' with your table name
$result = $conn->query($sql);
$currentGuests = $result->fetch_all(MYSQLI_ASSOC);

// Query to get the overall count of RSVPs for 'yes' and 'no'
$rsvpYesResult = $conn->query("SELECT COUNT(*) AS rsvpYes FROM rsvp WHERE attendance = 'yes'");
$rsvpYes = $rsvpYesResult->fetch_assoc()['rsvpYes'];

$rsvpNoResult = $conn->query("SELECT COUNT(*) AS rsvpNo FROM rsvp WHERE attendance = 'no'");
$rsvpNo = $rsvpNoResult->fetch_assoc()['rsvpNo'];

// Query to calculate the total pax for all guests
$totalPaxResult = $conn->query("SELECT SUM(pax) AS totalPax FROM rsvp");
$totalPax = $totalPaxResult->fetch_assoc()['totalPax'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>RSVP Management</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script>
    function exportPDF() {
    // Check if in full screen and exit
    if (document.fullscreenElement) {
        document.exitFullscreen().then(() => {
            window.open('export.php', '_blank'); // Open PDF in a new tab
        });
    } else {
        window.open('export.php', '_blank'); // Open PDF in a new tab
    }
}
    </script>
</head>

<body>
    <div class="container">
        <!-- Logout Section -->
        <div class="logout-container">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <!-- Event Name and Date -->
        <h1>Majlis Pernikahan Fikri dan Syahirah</h1>
        <p class="event-date">3 December 2024</p>

        <div class="summary">
            <h2>Event Summary</h2>
            <p>Total Guests: <?php echo $totalGuests; ?></p>
            <p>RSVP Yes: <?php echo $rsvpYes; ?></p>
            <p>RSVP No: <?php echo $rsvpNo; ?></p>
            <p>Total Pax: <?php echo $totalPax; ?></p>
        </div>

        <div class="rsvp-management">
            <h2>RSVP Management</h2>
            <!-- Status Legend -->
            <div class="status-legend" style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;">
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span> Attending
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: red; margin-left: 20px; margin-right: 5px;"></span> Not Attending
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Pax</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($currentGuests as $guest): ?>
                        <tr>
                            <td>
                                <span class="<?php echo strtolower($guest['attendance']); ?>" style="display:inline-block; width:10px; height:10px; border-radius:50%; margin-right: 5px; background-color: <?php echo $guest['attendance'] == 'yes' ? 'green' : 'red'; ?>;"></span>
                                <?php echo htmlspecialchars($guest['nama']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($guest['phone']); ?></td>
                            <td><?php echo htmlspecialchars($guest['pax']); ?> Person</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>

        <!-- Link to export the data to Pdf using your existing export.php -->
        <!-- <a href="export.php" class="export-btn" target="_blank">Export to PDF</a> -->
        <a href="export.php" download class="export-btn">Export to PDF</a>
    </div>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>