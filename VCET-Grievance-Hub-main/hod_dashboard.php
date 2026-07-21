<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['hod_branch'])) {
    header("Location: hod_login.html");
    exit();
}

$hod_dept = $_SESSION['hod_branch'];

$sql = "SELECT id, usn, crname, year, problem_type, complaint_text, status, created_at, approved_at, extended_days
        FROM complaints
        WHERE department = '$hod_dept'
        AND problem_type != 'Canteen'
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>HOD Dashboard</title>
    <style>
        body { background: #eef1f7; font-family: Arial; }
        table {
            width: 95%; margin: auto; margin-top: 25px;
            border-collapse: collapse; background: #fff;
            border-radius: 10px; overflow: hidden;
        }
        th { background: #243b55; color: #fff; padding: 12px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f5f5f5; }

        .btn { padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; color: white; }
        .approve { background: green; }
        .reject { background: red; }
        .processing { background: orange; }
        .delay { background: blue; }

        .expired {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h2 style="text-align:center; margin-top:20px;">
    <?= $hod_dept ?> Department - Complaints Dashboard
</h2>

<table>
<tr>
    <th>USN</th>
    <th>CR Name</th>
    <th>Year</th>
    <th>Problem Type</th>
    <th>Complaint</th>
    <th>Status</th>
    <th>Time Left</th>
    <th>Action</th>
</tr>

<?php
while ($row = $result->fetch_assoc()) {

    $approved = $row['approved_at'];
    $extended = $row['extended_days'];

    echo "<tr>
            <td>{$row['usn']}</td>
            <td>{$row['crname']}</td>
            <td>{$row['year']}</td>
            <td>{$row['problem_type']}</td>
            <td>{$row['complaint_text']}</td>
            <td><b>{$row['status']}</b></td>

            <td class='timer'
                data-approved='{$approved}'
                data-extended='{$extended}'></td>

            <td>";

    // APPROVE/PROCESS/REJECT buttons
    echo "<form action='update_complaint_status.php' method='POST'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <button name='action' value='Approved' class='btn approve'>Approve</button>
            <button name='action' value='Processing' class='btn processing'>Processing</button>
            <button name='action' value='Rejected' class='btn reject'>Reject</button>
          </form>";

    // SHOW DELAY OPTION ONLY WHEN EXPIRED AND STATUS ≠ RESOLVED
    echo "<br>";

    echo "<form action='extend_deadline.php' method='POST'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <select name='days'>
                <option value='' disabled selected>Select Delay</option>
                <option value='2'>Delay 2 Days</option>
                <option value='3'>Delay 3 Days</option>
                <option value='4'>Delay 4 Days</option>
                <option value='5'>Delay 5 Days</option>
            </select>
            <button type='submit' class='btn delay'>Apply Delay</button>
          </form>";

    echo "</td>
          </tr>";
}
?>
</table>

<script>
function startTimers() {
    document.querySelectorAll(".timer").forEach(timer => {

        const approved = timer.dataset.approved;
        const extended = parseInt(timer.dataset.extended || 0);

        // If not approved yet → show blank
        if (!approved) {
            timer.textContent = "—";
            return;
        }

        const approvedAt = new Date(approved);
        const daysToAdd = 7 + extended;
        const expiry = new Date(approvedAt.getTime() + daysToAdd * 24 * 60 * 60 * 1000);

        function update() {
            const now = new Date();
            const diff = expiry - now;

            if (diff <= 0) {
                timer.innerHTML = "<span class='expired'>Expired</span>";
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / (1000 * 60)) % 60);
            const seconds = Math.floor((diff / 1000) % 60);

            timer.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        update();
        setInterval(update, 1000);
    });
}

window.onload = startTimers;
</script>

</body>
</html>
