<?php

require 'config.php';

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$flightid = intval($_GET['flightid']); // Ensure flightid is an integer
$email = $_SESSION["email"]; // Ensure email is a string

// Retrieve the existing booking details
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

// Handle form submission to update booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fromcity = $_POST['origin'];
    $tocity = $_POST['depart'];
    $departuredate = $_POST['departure-date'];
    $returndate = $_POST['return-date'];
    $adult = $_POST['adult'];
    $child = $_POST['child'];
    $infant = $_POST['infant'];
    $cabin = $_POST['cabin'];

    $stmt = $connect->prepare("UPDATE flightbook SET fromcity = ?, tocity = ?, departuredate = ?, returndate = ?, adult = ?, child = ?, infant = ?, cabin = ? WHERE flightid = ? AND email = ?");
    $stmt->bind_param("ssssiiisis", $fromcity, $tocity, $departuredate, $returndate, $adult, $child, $infant, $cabin, $flightid, $email);
    
    if ($stmt->execute()) {
        echo "<script> alert('Booking updated Successfully'); </script>";
        echo "<script>setTimeout(function(){ window.location.href = 'detail.php?flightid=$flightid';}, 1000);</script>";
    } else {
        echo "Error updating booking.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking</title>
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
                    <a href="logout.php" class="logout-link">logout</a>    
                </form>    
            <?php endif; ?>            
        </nav>
        <div class="card custom-bg w-75 p-4 d-flex">
            <div class="row">
                <div class="pb-3 h3 text-left">Update Flight Booking &#128747;</div>
            </div>
            <form id="flight-form" method="post" action="">
                <div class="row">
                    <div class="form-group col-md align-items-start flex-column">
                        <label for="origin" class="d-inline-flex">From</label>
                        <input type="text" placeholder="City or Airport" class="form-control" id="origin" name="origin"
                            value="<?php echo htmlspecialchars($booking['fromcity']); ?>" required>
                    </div>
                    <div class="form-group col-md align-items-start flex-column">
                        <label for="depart" class="d-inline-flex">To</label>
                        <input type="text" placeholder="City or Airport" class="form-control" id="depart" name="depart"
                            value="<?php echo htmlspecialchars($booking['tocity']); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md align-items-start flex-column">
                        <label for="departure-date" class=" d-inline-flex">Depart</label>
                        <input type="date" class="form-control" id="departure-date" name="departure-date"
                            value="<?php echo htmlspecialchars($booking['departuredate']); ?>" onkeydown="return false" required>
                    </div>
                    <div class="form-group col-md align-items-start flex-column">
                        <label for="return-date" class="d-inline-flex">Return</label>
                        <input type="date" placeholder="One way" value="<?php echo htmlspecialchars($booking['returndate']); ?>"
                            onChange="this.setAttribute('value', this.value)" class="form-control" id="return-date"
                            name="return-date">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 align-items-start flex-column">
                        <label for="adults" class="d-inline-flex col-auto">Adults <span class="sublabel"> 12+
                            </span></label>
                        <select class="form-select" id="adults" name="adult"
                            onchange="javascript: dynamicDropDown(this.options[this.selectedIndex].value);">
                            <option value="1" <?php if ($booking['adult'] == 1) echo 'selected'; ?>>1</option>
                            <option value="2" <?php if ($booking['adult'] == 2) echo 'selected'; ?>>2</option>
                            <option value="3" <?php if ($booking['adult'] == 3) echo 'selected'; ?>>3</option>
                            <option value="4" <?php if ($booking['adult'] == 4) echo 'selected'; ?>>4</option>
                            <option value="5" <?php if ($booking['adult'] == 5) echo 'selected'; ?>>5</option>
                            <option value="6" <?php if ($booking['adult'] == 6) echo 'selected'; ?>>6</option>
                            <option value="7" <?php if ($booking['adult'] == 7) echo 'selected'; ?>>7</option>
                            <option value="8" <?php if ($booking['adult'] == 8) echo 'selected'; ?>>8</option>
                            <option value="9" <?php if ($booking['adult'] == 9) echo 'selected'; ?>>9</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3 align-items-start flex-column">
                        <label for="children" class="d-inline-flex col-auto">Children <span class="sublabel"> 2-11
                            </span></label>
                        <select class="form-select" id="children" name="child">
                            <option value="0" <?php if ($booking['child'] == 0) echo 'selected'; ?>>0</option>
                            <option value="1" <?php if ($booking['child'] == 1) echo 'selected'; ?>>1</option>
                            <option value="2" <?php if ($booking['child'] == 2) echo 'selected'; ?>>2</option>
                            <option value="3" <?php if ($booking['child'] == 3) echo 'selected'; ?>>3</option>
                            <option value="4" <?php if ($booking['child'] == 4) echo 'selected'; ?>>4</option>
                            <option value="5" <?php if ($booking['child'] == 5) echo 'selected'; ?>>5</option>
                            <option value="6" <?php if ($booking['child'] == 6) echo 'selected'; ?>>6</option>
                            <option value="7" <?php if ($booking['child'] == 7) echo 'selected'; ?>>7</option>
                            <option value="8" <?php if ($booking['child'] == 8) echo 'selected'; ?>>8</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3 align-items-start flex-column">
                        <label for="infants" class="d-inline-flex col-auto">Infants <span class="sublabel"> less than
                                2</span></label>
                        <select class="form-select" id="infants" name="infant">
                            <option value="0" <?php if ($booking['infant'] == 0) echo 'selected'; ?>>0</option>
                            <option value="1" <?php if ($booking['infant'] == 1) echo 'selected'; ?>>1</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 align-items-start flex-column">
                        <label for="cabin" class="d-inline-flex">Cabin</label>
                        <select class="form-select" id="cabin" name="cabin">
                            <option value="ECONOMY" <?php if ($booking['cabin'] == 'ECONOMY') echo 'selected'; ?>>Economy</option>
                            <option value="BUSINESS" <?php if ($booking['cabin'] == 'BUSINESS') echo 'selected'; ?>>Business</option>
                            <option value="FIRST" <?php if ($booking['cabin'] == 'FIRST') echo 'selected'; ?>>First</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="text-left col-auto">
                        <button type="submit" class="btn btn-primary">Confirm flights</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="./fly.js"></script>
</html>
