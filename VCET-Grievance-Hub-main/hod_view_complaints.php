<?php
$conn = mysqli_connect("localhost", "root", "", "VCET_grievance");

$sql = "SELECT * FROM complaints ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>HOD Panel</title>
<style>
table {width:100%;border-collapse: collapse;background:white;margin-top:20px;}
td,th {border:1px solid #ccc;padding:10px;text-align:center;}
button {padding:6px 12px;margin:2px;border:none;border-radius:5px;cursor:pointer;}
.approve {background:green;color:white;}
.reject {background:red;color:white;}
.process {background:orange;color:white;}
.ignore {background:gray;color:white;}
</style>
</head>
<body>

<h2>HOD Complaint Management</h2>

<table>
<tr>
    <th>USN</th>
    <th>Complaint</th>
    <th>Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($r = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $r['usn'] ?></td>
    <td><?= $r['complaint'] ?></td>
    <td><?= $r['created_at'] ?></td>
    <td><?= $r['status'] ?></td>
    <td>
        <a href="update_status.php?id=<?= $r['id'] ?>&status=Approved"><button class="approve">Approve</button></a>
        <a href="update_status.php?id=<?= $r['id'] ?>&status=Rejected"><button class="reject">Reject</button></a>
        <a href="update_status.php?id=<?= $r['id'] ?>&status=Processing"><button class="process">Processing</button></a>
        <a href="update_status.php?id=<?= $r['id'] ?>&status=Ignored"><button class="ignore">Ignore</button></a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>
