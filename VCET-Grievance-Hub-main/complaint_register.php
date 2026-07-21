<?php
session_start();

// Redirect if user not logged in
if (!isset($_SESSION['crname']) || !isset($_SESSION['usn'])) {
    header("Location: login_student.html");
    exit();
}

$crname = $_SESSION['crname'];
$usn = $_SESSION['usn'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Complaint Registration</title>
    <link rel="stylesheet" href="style.css">
    <style>
        textarea {
            height: 120px;
            width: 100%;
            resize: none;
            border-radius: 10px;
        }

        button {
            padding: 12px 40px;
            margin: auto;
            display: block;
            background: #fff;
            color: #4f54ff;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Register Your Complaint</h2>

    <form action="complaint_submit.php" method="POST">

        <!-- Auto filled hidden fields -->
        <input type="hidden" name="crname" value="<?php echo $crname; ?>">
        <input type="hidden" name="usn" value="<?php echo $usn; ?>">

       

        <select name="department" required>
            <option value="">Select Department</option>
            <option value="CSE">CSE</option>
            <option value="ECE">ECE</option>
            <option value="AI">AI</option>
            <option value="MECH">MECH</option>
        </select>

        <select name="year" required>
            <option value="">Select Year</option>
            <option value="1st">1st Year</option>
            <option value="2nd">2nd Year</option>
            <option value="3rd">3rd Year</option>
            <option value="4th">4th Year</option>
        </select>

        <select name="problem_type" required>
            <option value="">Complaint Category</option>
            <option value="academic">Academic</option>
            <option value="placement">Placement</option>
            <option value="canteen">Canteen</option>
            <option value="infrastructure">Infrastructure</option>
        </select>

        <textarea name="complaint_text" placeholder="Describe your complaint..." required></textarea>

        <button type="submit">Submit Complaint</button>
    </form>
</div>

</body>
</html>
