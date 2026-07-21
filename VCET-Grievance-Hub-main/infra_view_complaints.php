<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['infra_email'])) {
    header("Location: login_infra.html");
    exit();
}

$sql = "SELECT * FROM complaints 
        WHERE problem_type = 'Infrastructure'
        ORDER BY submitted_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Infrastructure Complaints</title>

<style>
/* Same CSS reused */
body {
    margin: 0; padding: 0; min-height: 100vh;
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #141e30, #243b55);
    padding: 40px;
    color: white;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    overflow: hidden;
    margin-top: 25px;
}

th {
    background: rgba(0,0,0,0.4);
    padding: 12px;
    color: #fff;
}

td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

button {
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    color: white;
}

.processing { background: orange; }
.approved { background: green; }
.reject { background: red; }
</style>

</head>
<body>

<h1 style="text-align:center;">Infrastructure Related Complaints</h1>

<table>
<tr>
    <th>ID</th>
    <th>USN</th>
    <th>Department</th>
    <th>Complaint</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($r = mysqli_fetch_assoc($result)) { ?>
    
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['usn'] ?></td>
            <td><?= $r['department'] ?></td>
            <td><?= $r['complaint_text'] ?></td>
            <td><?= $r['infra_status'] ?></td>

            <td>
                <a href="infra_update_status.php?id=<?= $r['id'] ?>&status=Processing">
                    <button class="processing">Processing</button>
                </a>
                <a href="infra_update_status.php?id=<?= $r['id'] ?>&status=Approved">
                    <button class="approved">Approved</button>
                </a>
                <a href="infra_update_status.php?id=<?= $r['id'] ?>&status=Rejected">
                    <button class="reject">Reject</button>
                </a>
            </td>
        </tr>

<?php }
} else {
    echo "<tr><td colspan='6'>No Infrastructure Complaints Found</td></tr>";
}
?>

</table>

</body>
</html>
