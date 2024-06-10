<?php
require 'config.php';
if (!empty($_SESSION["id"])) {
    header("Location: index.php");
}
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $duplicate = mysqli_query($connect, "SELECT * FROM fly_user WHERE username = '$username' AND email = '$email' ");
    if(mysqli_num_rows($duplicate) > 0){
        echo
        "<script> alert('Username or Email Has Already Taken'); </script>";
        echo "<script>setTimeout(function(){ window.location.href = 'login.html';}, 1000);</script>";
    }
    else{
        if($password == $cpassword){
            $query = "INSERT INTO fly_user VALUES('','$name','$email','$username','$password')";
            mysqli_query($connect,$query);
            echo
            "<script> alert('Registration Successful'); </script>";
            echo "<script>setTimeout(function(){ window.location.href = 'index.php';}, 1000);</script>";
        }
        else{
            echo
            "<script> alert('Password Does not match'); </script>";
            echo "<script>setTimeout(function(){ window.location.href = 'login.html';}, 1000);</script>";  
        }
    }
}
?>
