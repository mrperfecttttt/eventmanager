<?php
// Updated sample data for guests
$guests = [
    ['name' => 'John Doe', 'phone' => '123-456-7890', 'rsvp' => 'Yes', 'pax' => 2],
    ['name' => 'Jane Smith', 'phone' => '098-765-4321', 'rsvp' => 'No', 'pax' => 1],
    ['name' => 'Alice Johnson', 'phone' => '555-123-4567', 'rsvp' => 'No', 'pax' => 0],
    ['name' => 'Bob Brown', 'phone' => '444-789-1234', 'rsvp' => 'Yes', 'pax' => 3],
    ['name' => 'Charlie White', 'phone' => '333-222-1111', 'rsvp' => 'Yes', 'pax' => 4],
    ['name' => 'Diana Green', 'phone' => '222-333-4444', 'rsvp' => 'No', 'pax' => 1],
    ['name' => 'Ethan Black', 'phone' => '666-777-8888', 'rsvp' => 'Yes', 'pax' => 5],
    ['name' => 'Fiona Red', 'phone' => '999-888-7777', 'rsvp' => 'No', 'pax' => 2],
];

// Pagination settings
$limit = 5; // Number of guests per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$totalGuests = count($guests); // Total number of guests
$totalPages = ceil($totalGuests / $limit); // Total number of pages
$offset = ($page - 1) * $limit; // Calculate the offset for SQL-like pagination

// Slice the guests array for the current page
$currentGuests = array_slice($guests, $offset, $limit);

// Count RSVP statuses and total pax
$rsvpYes = count(array_filter($currentGuests, fn($g) => $g['rsvp'] == 'Yes'));
$rsvpNo = count(array_filter($currentGuests, fn($g) => $g['rsvp'] == 'No'));
$totalPax = array_sum(array_column($currentGuests, 'pax'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Management</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Event Name and Date -->
        <h1>Jadi Majlis Pernikahan Fikri dan Syahirah</h1>
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
                                <span class="<?php echo strtolower($guest['rsvp']); ?>" style="display:inline-block; width:10px; height:10px; border-radius:50%; margin-right: 5px; background-color: <?php echo $guest['rsvp'] == 'Yes' ? 'green' : 'red'; ?>;"></span>
                                <?php echo htmlspecialchars($guest['name']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($guest['phone']); ?></td>
                            <td><?php echo htmlspecialchars($guest['pax']); ?></td>
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

        <a href="export.php" class="export-btn">Export to Excel</a>
    </div>
</body>
</html>
