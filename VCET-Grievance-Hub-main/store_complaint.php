<?php
session_start();
include 'db_connect.php';

// Check login
if (!isset($_SESSION['usn']) || !isset($_SESSION['crname'])) {
    header("Location: login_student.html");
    exit();
}

$usn        = $_SESSION['usn'];
$crname     = $_SESSION['crname'];

$cr_email       = $_POST['cr_email'];
$department     = $_POST['department'];
$year           = $_POST['year'];
$problem_type   = $_POST['problem_type'];
$complaint_text = $_POST['complaint'];
$submitted_at   = date("Y-m-d H:i:s");

/*
------------------------------------------------------------------
   CANEEN COMPLAINT → DIRECTLY TO PRINCIPAL (advisor + HOD skip)
------------------------------------------------------------------
*/

if ($problem_type === "Canteen") {

    $query = "INSERT INTO complaints 
        (usn, crname, cr_email, department, year, problem_type, complaint_text,
         status, hod_status, principal_status, forwarded_to_principal, submitted_at)
        
        VALUES 
        ('$usn', '$crname', '$cr_email', '$department', '$year', '$problem_type', '$complaint_text',
         'Sent to Principal', 'Skipped', 'Pending', 1, '$submitted_at')";
}

/*
------------------------------------------------------------------
   ALL OTHER COMPLAINTS → ADVISOR → HOD → PRINCIPAL
------------------------------------------------------------------
*/

else {

    $query = "INSERT INTO complaints 
        (usn, crname, cr_email, department, year, problem_type, complaint_text,
         status, hod_status, principal_status, forwarded_to_principal, submitted_at)
         
        VALUES 
        ('$usn', '$crname', '$cr_email', '$department', '$year', '$problem_type', '$complaint_text',
         'Pending', 'Pending', 'Not Received', 0, '$submitted_at')";
}

/*
------------------------------------------------------------------
   EXECUTE QUERY
------------------------------------------------------------------
*/

if ($conn->query($query) === TRUE) {
    $success = true;
} else {
    $success = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Complaint Submitted</title>
    <style>
        body {
            background: linear-gradient(to right, #4e4376, #2b5876);
            font-family: Arial, sans-serif;
            color: #fff;
            text-align: center;
            padding-top: 120px;
        }
        .box {
            width: 380px;
            margin: auto;
            padding: 25px;
            border-radius: 12px;
            background: rgba(255,255,255,0.15);
        }
        .btn {
            margin-top: 18px;
            display: inline-block;
            padding: 12px 24px;
            background: rgba(100,150,200,0.8);
            border-radius: 8px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        .btn:hover {
            background: rgba(100,150,200,1);
        }
    </style>
</head>
<body>

<div class="box">
    <?php if ($success) { ?>
        <h2>Complaint Submitted Successfully</h2>
        <p>Your complaint has been recorded.</p>
    <?php } else { ?>
        <h2>Error Submitting Complaint</h2>
        <p>Please try again later.</p>
        <p>Error: <?php echo $conn->error; ?></p>
    <?php } ?>

    <a class="btn" href="student_dashboard.php">Go Back</a>
</div>

</body>
</html>
