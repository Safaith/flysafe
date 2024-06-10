<?php
require 'config.php';
if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = mysqli_query($connect, "SELECT * FROM fly_user WHERE username = '$username' AND password = '$password' ");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){
        if($password == $row["password"]){
           $_SESSION["login"] = true;
           $_SESSION["id"] = $row["id"];
           $_SESSION["email"] = $row["email"];
           header("Location: flight search.php");
        }
        else{
            echo "<script> alert('Wrong password');</script>";
            echo "window.location.href ='index.php';</script>";
            exit;

        }
    }
    else{
        echo "<script> alert('User not Registered');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'login.html';}, 1000);</script>";
        exit;
    }
}
?>