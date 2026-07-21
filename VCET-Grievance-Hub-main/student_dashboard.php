<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['crname']) || !isset($_SESSION['usn'])) {
    header('Location: login_student.html');
    exit();
}

$crname = htmlspecialchars($_SESSION['crname']);
$usn = htmlspecialchars($_SESSION['usn']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CR Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dash-box { max-width: 420px; margin: 80px auto; padding: 28px; border-radius:12px; background: rgba(255,255,255,0.12); color: #fff; text-align:center; }
        .dash-box h2 { margin-bottom: 18px; }
        .dash-actions { display: grid; gap: 12px; }
        .dash-actions a { text-decoration:none; }
        .dash-actions .btn { display:block; padding:12px; border-radius:8px; background:#fff; color:#4e4376; font-weight:600; }
        .small { font-size:14px; color:#ddd; margin-top:8px; }
        .logout { margin-top:14px; display:inline-block; padding:8px 14px; background:transparent; color:#fff; border:1px solid rgba(255,255,255,0.15); border-radius:8px; text-decoration:none; }
    </style>
</head>
<body>

<div class="dash-box">
    <h2>Welcome, <?php echo $crname; ?></h2>
    <div class="small">USN: <?php echo $usn; ?></div>

    <div class="dash-actions">
        <a class="btn" href="complaint_register.php">Submit Complaint</a>
        <a class="btn" href="student_status.php?usn=<?php echo urlencode($_SESSION['usn']); ?>">Check Status</a>
    </div>

    <a class="logout" href="logout_student.php">Logout</a>
</div>

</body>
</html>