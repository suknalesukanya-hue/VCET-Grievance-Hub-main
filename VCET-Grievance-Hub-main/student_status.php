<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['usn'])) {
    header("Location: login_student.html");
    exit();
}

$usn = $_SESSION['usn'];

$sql = "SELECT problem_type, complaint_text, status, infra_status, created_at,
        approved_at, extended_days
        FROM complaints 
        WHERE usn = '$usn'
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Complaint Status</title>

<style>
/* ---------- PAGE BACKGROUND ---------- */
body {
    margin: 0;
    padding: 0;
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #1b2735, #090a0f);
    color: #fff;
}

/* ---------- PAGE HEADING ---------- */
h2 {
    text-align: center;
    margin-top: 30px;
    font-size: 28px;
    letter-spacing: 1px;
}

/* ---------- COMPLAINT CARD ---------- */
.status-card {
    width: 70%;
    margin: 20px auto;
    padding: 20px;
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    animation: fadeIn 0.7s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.status-card strong {
    color: #ffeead;
}

/* ---------- TIMER ---------- */
.timer-box {
    margin-top: 10px;
    font-size: 16px;
    font-weight: bold;
    color: #00eaff;
}

.expired {
    color: red;
    font-weight: bold;
}

/* ---------- NO COMPLAINT MESSAGE ---------- */
.no-data {
    text-align: center;
    margin-top: 50px;
    font-size: 20px;
    opacity: 0.8;
}

/* ---------- GO BACK BUTTON ---------- */
.back-btn {
    display: block;
    width: 200px;
    margin: 30px auto;
    padding: 12px;
    text-align: center;
    background: #00aaff;
    color: #fff;
    border-radius: 8px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
}

.back-btn:hover {
    background: #0088cc;
    transform: translateY(-2px);
}
</style>

</head>
<body>

<h2>Your Complaint Status</h2>

<?php
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) { ?>

        <div class="status-card">
            <p><strong>Problem Type:</strong> <?= $row['problem_type'] ?></p>
            <p><strong>Complaint:</strong> <?= $row['complaint_text'] ?></p>

            <?php if ($row['problem_type'] != "Canteen") { ?>
                <p><strong>Status (Advisor / HOD):</strong> <?= $row['status'] ?></p>
            <?php } ?>

            <?php if ($row['problem_type'] == "Infrastructure") { ?>
                <p><strong>Infrastructure Status:</strong> <?= $row['infra_status'] ?></p>
            <?php } ?>

            <p><strong>Submitted On:</strong> <?= date("d-m-Y h:i A", strtotime($row['created_at'])) ?></p>

            <!-- ✅ Delay Message -->
            <?php if ($row['extended_days'] > 0) { ?>
                <p><strong style="color:#00ff99;">Deadline Extended By:</strong>
                    <?= $row['extended_days'] ?> Days</p>
            <?php } ?>

            <!-- ✅ TIMER (Only after approved) -->
            <?php if ($row['status'] == "Approved" || $row['extended_days'] > 0) {

                $start_time = $row['approved_at'] ? $row['approved_at'] : $row['created_at'];

                $total_days = 7 + $row['extended_days'];

                $expiry = date("Y-m-d H:i:s", strtotime("$start_time + $total_days days"));
            ?>

                <p class="timer-box" data-expiry="<?= $expiry ?>">
                    Loading timer...
                </p>

            <?php } ?>

        </div>

    <?php }

} else {
    echo "<p class='no-data'>No complaints found.</p>";
}
?>

<a href="student_dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

<!-- ✅ TIMER SCRIPT -->
<script>
document.querySelectorAll(".timer-box").forEach(box => {

    const expiry = new Date(box.dataset.expiry);

    function updateTimer() {
        const now = new Date();
        const diff = expiry - now;

        if (diff <= 0) {
            box.innerHTML = "<span class='expired'>Expired</span>";
            return;
        }

        const d = Math.floor(diff / (1000*60*60*24));
        const h = Math.floor((diff / (1000*60*60)) % 24);
        const m = Math.floor((diff / (1000*60)) % 60);
        const s = Math.floor((diff / 1000) % 60);

        box.textContent = `Time Left: ${d}d ${h}h ${m}m ${s}s`;
    }

    updateTimer();
    setInterval(updateTimer, 1000);
});
</script>

</body>
</html>
