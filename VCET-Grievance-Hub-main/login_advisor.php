<?php
session_start();
include "db_connect.php";

$name  = $_POST['advisor_name'];
$dept  = $_POST['department'];
$email = $_POST['advisor_email'];
$pass  = $_POST['password'];

$sql = "SELECT * FROM advisors 
        WHERE advisor_name='$name' 
        AND department='$dept'
        AND email='$email' 
        AND password='$pass'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();

    $_SESSION['advisor_name'] = $row['advisor_name'];
    $_SESSION['advisor_email'] = $row['email'];
    $_SESSION['advisor_department'] = $row['department'];

    header("Location: advisor_dashboard.php");
    exit();

} else {
    echo "<h2 style='color:red; text-align:center;'>Invalid Login!</h2>";
}
?>
