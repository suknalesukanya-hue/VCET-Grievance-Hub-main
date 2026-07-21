<?php
$loc = "localhost";
$user = "root";
$pass = "";  
$dbname = "VCET_grievance";

$conn = new mysqli($loc, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>