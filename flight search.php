<?php

require 'config.php';
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

if(isset($_POST["submit"])){
    $from = $_POST["origin"];
    $to = $_POST["depart"];
    $departure_date = $_POST["departure-date"];
    $return_date = $_POST["return-date"];
    $adult = $_POST["adult"];
    $child = $_POST["child"];
    $infant = $_POST["infant"];
    $cabin = $_POST["cabin"];
    $email = $_SESSION["email"];
    $duplicate = mysqli_query($connect, "SELECT * FROM flightbook WHERE email='$email' AND fromcity='$from' AND tocity='$to' AND departuredate='$departure_date' AND returndate='$return_date' AND cabin='$cabin' ");
    if(mysqli_num_rows($duplicate) > 0){
        echo
        "<script> alert('Already Booked'); </script>";
    } else {
        $query = "INSERT INTO flightbook VALUES('','$email','$from','$to','$departure_date','$return_date','$adult','$child','$infant','$cabin')";
        if(mysqli_query($connect,$query)){
            $flightid = mysqli_insert_id($connect);
            echo
            "<script> alert('Flight booking Successfull'); </script>";
            echo "<script>setTimeout(function(){ window.location.href = 'detail.php?flightid=$flightid';}, 1000);</script>";
        } else{
            echo "<script> alert('Error in booking'); </script>";
        }
        
    }
}
?>
<!DOCTYPE html>
<html>
<title>Flight Search</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="script.js"></script>
<link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet"
      />

<link rel="stylesheet" href="flight search.css">

<body>
    <div class="container">
        <nav>
            <a href="index.php" class="nav__logo">Fly-Safe</a>
            <?php if(isset($_SESSION["login"]) && $_SESSION["login"]): ?>
                <form action="logout.php" method="post">
                    <a href="logout.php" class="logout-link">logout</a>    
                </form>    
            <?php endif; ?>                
        </nav>
        <div class="card custom-bg w-75 p-4 d-flex">
            <div class="row">
                <div class="pb-3 h3 text-left">Flight Booking &#128747;</div>
            </div>
            <form id="flight-form" action="" method="post">
                <div class="row">
                    <div class="form-group col-md align-items-start flex-column">
                        <label for="origin" class="d-inline-flex">From</label>
                        <input type="text" placeholder="City or Airport" class="form-control" id="origin" name="origin"
                            required>
                    </div>
                    <div class="form-group col-md align-items-start flex-column">
                        <label for="depart" class="d-inline-flex">To</label>
                        <input type="text" placeholder="City or Airport" class="form-control" id="depart" name="depart"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md align-items-start flex-column">
                        <label for="departure-date" class=" d-inline-flex">Depart</label>
                        <input type="date" class="form-control" id="departure-date" name="departure-date" required>
                    </div>
                    <div class="form-group col-md align-items-start flex-column">
                        <label for="return-date" class="d-inline-flex">Return</label>
                        <input type="date" placeholder="One way" value=""
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
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3 align-items-start flex-column">
                        <label for="children" class="d-inline-flex col-auto">Children <span class="sublabel"> 2-11
                            </span></label>
                        <select class="form-select" id="children" name="child">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3 align-items-start flex-column">
                        <label for="infants" class="d-inline-flex col-auto">Infants <span class="sublabel"> less than
                                2</span></label>
                        <select class="form-select" id="infants" name="infant">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 align-items-start flex-column">
                        <label for="cabin" class="d-inline-flex">Cabin</label>
                        <select class="form-select" id="cabin" name="cabin">
                            <option value="ECONOMY">Economy</option>
                            <option value="BUSINESS">Business</option>
                            <option value="FIRST">First</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="text-left col-auto">
                        <button type="submit" name="submit" class="btn btn-primary" value="confirm">Confirm flights</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="./fly.js"></script>

</html>