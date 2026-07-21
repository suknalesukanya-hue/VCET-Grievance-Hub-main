<?php
session_start();
// Destroy CR session and redirect to login
session_unset();
session_destroy();
header('Location: login_student.html');
exit();
?>