<?php
session_start();
include "db_connect.php";

// Check if form submitted
if (!isset($_POST['principalname']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    die("Required fields missing!");
}

$principalname = $_POST['principalname'];
$email = $_POST['email'];
$password = $_POST['password'];

// Change table name to your actual table name (e.g., principal)
$sql = "SELECT * FROM principal WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    $_SESSION['principalname'] = $row['principalname'];
    $_SESSION['principal_email'] = $row['email'];

    header("Location: principal_dashboard.php");
    exit();

} else {
    echo "<h3 style='color:red; text-align:center;'>Invalid Login</h3>";
}
?>
