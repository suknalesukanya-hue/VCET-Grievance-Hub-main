<?php
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();  // MUST be FIRST

include "db_connect.php";
require "mail.php";      
require "send_email.php"; 

// ------------------------------------------------------
// 1. CHECK LOGIN
// ------------------------------------------------------
if (!isset($_SESSION['usn'])) {
    die("You are not logged in.");
}

// ------------------------------------------------------
// 2. CHECK POST FIELDS
// ------------------------------------------------------
if (
    empty($_POST['department']) ||
    empty($_POST['year']) ||
    empty($_POST['problem_type']) ||
    empty($_POST['complaint_text'])
) {
    die("Missing required form fields.");
}

// ------------------------------------------------------
// 3. CLEAN & PREPARE DATA
// ------------------------------------------------------
$usn            = $_SESSION['usn'];
$crname         = $_SESSION['crname'];
$department     = strtoupper(trim($_POST['department']));
$year           = $_POST['year'];
$problem_type   = $_POST['problem_type'];
$complaint_text = trim($_POST['complaint_text']);
$date_time      = date("Y-m-d H:i:s");

// ------------------------------------------------------
// 4. INSERT COMPLAINT INTO DATABASE
// ------------------------------------------------------
$sql = "INSERT INTO complaints 
(usn, crname, department, year, problem_type, complaint_text, status, submitted_at)
VALUES 
('$usn', '$crname', '$department', '$year', '$problem_type', '$complaint_text', 'Pending', '$date_time')";

if ($conn->query($sql) !== TRUE) {
    die("Database Insert Error: " . $conn->error);
}

// ------------------------------------------------------
// 5. FIND EMAIL RECIPIENTS
// ------------------------------------------------------
$recipientList = [];

$hod_email     = $hodEmails[$department] ?? null;
$advisor_email = $advisorEmails[$department] ?? null;

if ($problem_type == "academic" || $problem_type == "department") {
    if ($hod_email)     $recipientList[] = $hod_email;
    if ($advisor_email) $recipientList[] = $advisor_email;
}

if ($problem_type == "placement") {
    if ($advisor_email) $recipientList[] = $advisor_email;
    if ($hod_email)     $recipientList[] = $hod_email;
}

if ($problem_type == "canteen") {
    $recipientList[] = $principalEmail;
}

if ($problem_type == "infrastructure") {
    $recipientList[] = $infraEmail;
    if ($advisor_email) $recipientList[] = $advisor_email;
    if ($hod_email)     $recipientList[] = $hod_email;
}

// ------------------------------------------------------
// 6. EMAIL CONTENT — HTML FORMAT
// ------------------------------------------------------
$subject = "New Complaint Submitted by $crname ($usn)";

$htmlBody = "
<h2 style='color:#d9534f;'>New Complaint Received</h2>

<p><strong>Student Name:</strong> $crname</p>
<p><strong>USN:</strong> $usn</p>
<p><strong>Department:</strong> $department</p>
<p><strong>Year:</strong> $year</p>
<p><strong>Category:</strong> $problem_type</p>

<h3 style='color:green;'>Complaint Details</h3>
<p>$complaint_text</p>

<p><strong>Submitted At:</strong> $date_time</p>
";


// ------------------------------------------------------
// 7. SEND EMAILS
// ------------------------------------------------------
foreach ($recipientList as $recipient) {
    sendMailNow($recipient, $subject, $htmlBody);
}

// ------------------------------------------------------
// 8. SUCCESS PAGE (HTML INSIDE THIS FILE)
// ------------------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>
    <title>Complaint Submitted</title>
    <style>
        body {
            font-family: Arial;
            background: #f7f7f7;
            text-align: center;
            padding-top: 80px;
        }
        .box {
            background: white;
            width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            color: green;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Complaint Submitted Successfully ✔</h2>
    <p>Your complaint has been recorded and forwarded to the respective department.</p>

    <a class="btn" href="student_dashboard.php">Go Back</a>
    
</div>

</body>
</html>
