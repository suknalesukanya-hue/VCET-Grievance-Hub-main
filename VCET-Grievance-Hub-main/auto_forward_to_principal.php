<?php
include "db_connection.php";

$sql = "
    UPDATE complaints
    SET principal_status = 'Pending',
        forward_to_principal_at = NOW()
    WHERE hod_status = 'Pending'
      AND principal_status = 'Not Received'
      AND created_at <= DATE_SUB(NOW(), INTERVAL 7 DAY)
";

$conn->query($sql);
?>
