<?php
session_start();
include "db_connect.php";

// Get form data
$crname = $_POST['crname'];
$usn    = $_POST['usn'];
$email  = $_POST['email'];
$pass   = $_POST['password'];

// Query the database
$sql = "SELECT * FROM student_login 
        WHERE crname='$crname' 
        AND usn='$usn'
        AND email='$email' 
        AND password='$pass'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();

    // Store session variables
    $_SESSION['crname'] = $row['crname'];
    $_SESSION['usn']    = $row['usn'];
    $_SESSION['email']  = $row['email'];

    // Redirect to student dashboard
    header("Location: student_dashboard.php");
    exit();

} else {
    echo "<h2 style='color:red; text-align:center;'>Invalid Login!</h2>";
}
?>
