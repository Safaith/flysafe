<?php
require 'config.php';

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$flightid = intval($_GET['flightid']);
$email = $_SESSION["email"]; 

// Retrieve the existing booking details to ensure it exists
$stmt = $connect->prepare("SELECT * FROM flightbook WHERE flightid = ? AND email = ?");
$stmt->bind_param("is", $flightid, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script> alert('No booking found for this flight and email.'); </script>";
    echo "<script>setTimeout(function(){ window.location.href = 'flight search.php';}, 1000);</script>";
    exit();
}

$booking = $result->fetch_assoc();
$stmt->close();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $stmt = $connect->prepare("DELETE FROM flightbook WHERE flightid = ? AND email = ?");
    $stmt->bind_param("is", $flightid, $email);
    
    if ($stmt->execute()) {
        echo "<script> alert('Booking deleted Successfully'); </script>";
        echo "<script>setTimeout(function(){ window.location.href = 'index.php';}, 1000);</script>";
        exit();
    } else {
        echo "Error deleting booking.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <nav>
            <div class="nav__logo">Fly-Safe</div>
            <?php if(isset($_SESSION["login"]) && $_SESSION["login"]): ?>
                <form action="logout.php" method="post">
                    <a href="logout.php" class="logout-link">Logout</a>    
                </form>    
            <?php endif; ?>            
        </nav>
        <div class="card custom-bg w-75 p-4 d-flex">
            <div class="row">
                <div class="pb-3 h3 text-left">Confirm Delete Booking &#128747;</div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p>Are you sure you want to delete this booking?</p>
                    <form method="post" action="">
                        <button type="submit" name="confirm_delete" class="btn btn-danger">Confirm Delete</button>
                        <a href="detail.php?flightid=<?php echo $flightid; ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
