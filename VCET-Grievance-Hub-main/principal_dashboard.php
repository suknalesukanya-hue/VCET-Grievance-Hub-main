<?php
session_start();

$conn = new mysqli("localhost", "root", "", "vcet_grievance");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// -------------------------
// HANDLE APPROVE / REJECT
// -------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $id = $_POST['id'];
    $status = $_POST['action']; // Approved / Rejected

    $stmt = $conn->prepare("UPDATE complaints SET principal_status=?, updated_at=NOW() WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

// -------------------------
// FETCH ONLY CANTEEN COMPLAINTS
// -------------------------
$sql = "SELECT * FROM complaints 
        WHERE problem_type = 'Canteen'
        ORDER BY submitted_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Principal Dashboard</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    padding: 30px;
}

h2 { text-align: center; margin-bottom: 20px; }

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

table th {
    background: #2c3e50;
    color: white;
    padding: 12px;
}

table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.btn {
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    color: white;
}

.approve { background: green; }
.reject { background: red; }

tr:hover { background: #f1f1f1; }
</style>
</head>

<body>

<h2>Principal Dashboard – Canteen Complaints</h2>

<table>
<tr>
    <th>ID</th>
    <th>USN</th>
    <th>CR Name</th>
    <th>Department</th>
    <th>Complaint</th>
    <th>Status</th>
    <th>Submitted At</th>
    <th>Action</th>
</tr>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['usn']}</td>
                <td>{$row['crname']}</td>
                <td>{$row['department']}</td>
                <td>{$row['complaint_text']}</td>
                <td>{$row['principal_status']}</td>
                <td>{$row['submitted_at']}</td>

                <td>
                    <form method='POST'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        
                        <button class='btn approve' name='action' value='Approved'>
                            Approve
                        </button>

                        <button class='btn reject' name='action' value='Rejected'>
                            Reject
                        </button>
                    </form>
                </td>
              </tr>";
    }

} else {
    echo "<tr><td colspan='8' style='text-align:center;'>No canteen complaints found</td></tr>";
}
?>

</table>

</body>
</html>
