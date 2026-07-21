<?php
session_start();
include "db_connect.php";

if (!isset($_POST['id']) || !isset($_POST['action'])) {
    die("Invalid request");
}

$id = $_POST['id'];
$status = $_POST['action'];

// Get the CR email from database
$sql = "SELECT cr_email FROM complaints WHERE id='$id'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$cr_email = $row['cr_email'];

/* ---------------------------------------------------------
   ✅ ADD TIMER LOGIC — ONLY THIS PART IS NEW
--------------------------------------------------------- */
if ($status == "Approved") {
    // Save approval time (starts 7-day timer)
    $update = "UPDATE complaints 
               SET status='Approved', approved_at=NOW() 
               WHERE id='$id'";
} else {
    // Other statuses → do NOT start timer
    $update = "UPDATE complaints 
               SET status='$status'
               WHERE id='$id'";
}
/* --------------------------------------------------------- */

$conn->query($update);

// Email content
$subject = "Complaint Status Update";
$message = "Hello CR,\n\nYour complaint (ID: $id) status has been updated to: $status.\n\nThank you!";
$headers = "From: grievancehub@college.com";

// send mail
mail($cr_email, $subject, $message, $headers);

// redirect
header("Location: hod_dashboard.php?branch=" . $_SESSION['hod_branch']);
exit();
?>
