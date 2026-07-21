<?php
session_start();
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);  // "infra"

    // Check if user exists in staff table with role=infra
    $sql = "SELECT * FROM staff WHERE email='$email' AND role='infra' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        // Check password (plain text)
        if ($row['password'] === $password) {

            // Set session values
            $_SESSION['infra_id'] = $row['id'];
            $_SESSION['infra_name'] = $row['name'];
            $_SESSION['infra_email'] = $row['email'];
            $_SESSION['role'] = "infra";

            header("Location: infra_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect Password'); window.location='infra_login.html';</script>";
            exit();
        }

    } else {
        echo "<script>alert('Invalid Email or Not an Infra User'); window.location='infra_login.html';</script>";
        exit();
    }
}
?>
