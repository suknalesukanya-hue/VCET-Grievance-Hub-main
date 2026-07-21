<?php
session_start();
include "db_connect.php";

$id = $_POST['id'];
$days = $_POST['days'];

$sql = "UPDATE complaints 
        SET extended_days = extended_days + $days
        WHERE id = $id";
$conn->query($sql);

// get CR email
$res = $conn->query("SELECT cr_email FROM complaints WHERE id=$id");
$row = $res->fetch_assoc();

// send mail
$to = $row['cr_email'];
$subject = "Complaint Deadline Extended";
$message = "HOD has extended your complaint deadline by $days days.";
$headers = "From: grievancehub@college.com";

mail($to, $subject, $message, $headers);

header("Location: hod_dashboard.php");
exit();
?>
