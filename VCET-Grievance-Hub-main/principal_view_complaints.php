<?php
$conn = mysqli_connect("localhost", "root", "", "VCET_grievance");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch only CANEEN complaints
$sql = "SELECT * FROM complaints 
        WHERE problem_type='Canteen'
        ORDER BY submitted_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Principal – Canteen Complaints</title>

<style>
table {width:100%;border-collapse: collapse;background:white;margin-top:20px;}
td,th {border:1px solid #ccc;padding:10px;text-align:center;}
button {padding:6px 12px;margin:2px;border:none;border-radius:5px;cursor:pointer;}
.approve {background:green;color:white;}
.reject {background:red;color:white;}
.pending {background:orange;color:white;}
</style>

</head>
<body>

<h2 style="text-align:center;">Principal Panel – Canteen Complaints</h2>

<table>
<tr>
    <th>ID</th>
    <th>USN</th>
    <th>CR Name</th>
    <th>Department</th>
    <th>Complaint</th>
    <th>Submitted At</th>
    <th>Principal Status</th>
    <th>Action</th>
</tr>

<?php while ($r = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $r['id'] ?></td>
    <td><?= $r['usn'] ?></td>
    <td><?= $r['crname'] ?></td>
    <td><?= $r['department'] ?></td>
    <td><?= $r['complaint_text'] ?></td>
    <td><?= $r['submitted_at'] ?></td>
    <td><?= $r['principal_status'] ?></td>

    <td>
        <a href="principal_update_status.php?id=<?= $r['id'] ?>&status=Approved">
            <button class="approve">Approve</button>
        </a>

        <a href="principal_update_status.php?id=<?= $r['id'] ?>&status=Rejected">
            <button class="reject">Reject</button>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>
