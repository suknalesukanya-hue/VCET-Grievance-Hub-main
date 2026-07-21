<?php
$conn = mysqli_connect("localhost", "root", "", "VCET_grievance");

$id     = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE complaints 
        SET principal_status='$status', updated_at=NOW()
        WHERE id=$id";

mysqli_query($conn, $sql);

header("Location: principal_view_complaints.php");
exit();
?>
