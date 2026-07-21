<?php
session_start();
include "db_connect.php";

// Check if form submitted
if (!isset($_POST['name']) || !isset($_POST['branch']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    die("Required fields missing!");
}

$name     = $_POST['name'];
$branch   = $_POST['branch'];
$email    = $_POST['email'];
$password = $_POST['password'];

// Login using email + password ONLY (correct method)
$sql = "SELECT * FROM hod_login WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    // Store values from DATABASE into session
    $_SESSION['hod_name']   = $row['name'];
    $_SESSION['hod_branch'] = $row['branch'];
    $_SESSION['hod_email']  = $row['email'];

    header("Location: hod_dashboard.php");
    exit();

} else {
    echo "<h3 style='color:red; text-align:center;'>Invalid Login!</h3>";
}
?>
