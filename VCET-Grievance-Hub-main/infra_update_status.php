<?php
include "db_connect.php";

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Invalid Request");
}

$id = $_GET['id'];
$status = $_GET['status'];

// Update ONLY the infra_status column
$sql = "UPDATE complaints SET infra_status = '$status' WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: infra_view_complaints.php");
} else {
    echo "Error updating status";
}
?>
