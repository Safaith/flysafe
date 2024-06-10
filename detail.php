<?php

require 'config.php';

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$booking = null; // Initialize $booking to null

if (isset($_GET['flightid'])) {
    $flightid = intval($_GET['flightid']); // Ensure flightid is an integer
    $email = $_SESSION["email"]; // Ensure email is a string

    // Prepare the statement using the database connection object ($conn)
    $stmt = $connect->prepare("SELECT * FROM flightbook WHERE flightid = ? AND email = ?");
    $stmt->bind_param("is", $flightid, $email); // "is" denotes integer and string types respectively
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the result
        $booking = $result->fetch_assoc();
    } else {
        echo "No booking found for this flight and email.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <link rel="stylesheet" href="detail.css" />
</head>
<body>
    <div class="container">
    
        <div class="email">
            <p>Email: <?php echo htmlspecialchars($booking['email']); ?></p>
        </div>
        <div class="from">
            <p>From: <?php echo htmlspecialchars($booking['fromcity']); ?></p>
        </div>
        <div class="to">
            <p>To: <?php echo htmlspecialchars($booking['tocity']); ?></p>
        </div>
        <div class="depart">
            <p>Departure date:<?php echo htmlspecialchars($booking['departuredate']); ?></p>
        </div>
        <div class="return">
            <p>Return date: <?php echo htmlspecialchars($booking['returndate']); ?></p>
        </div>
        <div class="adult">
            <p>Adults: <?php echo htmlspecialchars($booking['adult']); ?></p>
        </div>
        <div class="child">
            <p>Childs: <?php echo htmlspecialchars($booking['child']); ?></p>
        </div>
        <div class="infant">
            <p>Infants: <?php echo htmlspecialchars($booking['infant']); ?></p>
        </div>
        <div class="cabin">
            <p>Cabin: <?php echo htmlspecialchars($booking['cabin']); ?></p>
        </div>
        <a href="index.php">Confirm</a>
        <a href="update.php?flightid=<?php echo $flightid; ?>">Update booking</a>
        <a href="delete.php?flightid=<?php echo $flightid; ?>">Delete</a>
    </div>    
</body>
</html>