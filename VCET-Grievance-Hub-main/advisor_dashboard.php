<?php
session_start();
include "db_connect.php";

// BLOCK ACCESS IF NOT LOGGED IN
if (!isset($_SESSION['advisor_email'])) {
    header("Location: login_advisor.html");
    exit();
}

$advisor_name = $_SESSION['advisor_name'];
$advisor_department = $_SESSION['advisor_department'];

// 🔥 MOST IMPORTANT – FILTER COMPLAINTS BY DEPARTMENT
$sql = "SELECT * FROM complaints 
        WHERE department = '$advisor_department'
        AND problem_type != 'Canteen'
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Advisor Dashboard</title>
    <style>
        body {
            background: #eef2f7;
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .top-bar {
            background: #fff;
            padding: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #007bff;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        tr:hover {
            background: #f2f6ff;
        }

        .logout-btn {
            float: right;
            background: red;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="top-bar">
        <strong>Advisor:</strong> <?= $advisor_name ?>  
        &nbsp;&nbsp; | &nbsp;&nbsp;  
        <strong>Department:</strong> <?= $advisor_department ?>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <h2>Department Complaints</h2>

    <table>
        <tr>
            <th>USN</th>
            <th>Name</th>
            <th>Year</th>
            <th>Problem Type</th>
            <th>Complaint</th>
            <th>Status</th>
            <th>Date</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['usn']}</td>
                        <td>{$row['crname']}</td>
                        <td>{$row['year']}</td>
                        <td>{$row['problem_type']}</td>
                        <td>{$row['complaint_text']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['created_at']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align:center;color:red;'>No complaints found</td></tr>";
        }
        ?>
    </table>

</body>
</html>
