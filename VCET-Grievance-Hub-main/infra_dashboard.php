<?php
session_start();

if (!isset($_SESSION['infra_email'])) {
    header("Location: login_infra.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Infrastructure Dashboard</title>

<style>
/* Same CSS reused */
body {
    margin: 0; padding: 0; height: 100vh;
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #141e30, #243b55);
    display: flex; justify-content: center; align-items: center;
    overflow: hidden; animation: fadeIn 1.5s ease-in-out;
}

@keyframes fadeIn { from {opacity:0; transform:scale(1.05);} to {opacity:1; transform:scale(1);} }

.shape { position:absolute; background:rgba(255,255,255,0.12); border-radius:50%;
    animation: float 6s infinite ease alternate; }
.shape:nth-child(1){width:120px;height:120px;top:10%;left:15%;}
.shape:nth-child(2){width:170px;height:170px;bottom:8%;left:10%;}
.shape:nth-child(3){width:150px;height:150px;top:18%;right:12%;}
.shape:nth-child(4){width:90px;height:90px;bottom:22%;right:18%;}

@keyframes float { from{transform:translateY(0);} to{transform:translateY(25px);} }

.container {
    background: rgba(255,255,255,0.15);
    padding: 40px; width: 420px; border-radius: 18px;
    backdrop-filter: blur(13px); color: white;
    box-shadow: 0 4px 25px rgba(255,255,255,0.3);
    animation: slideUp 1.2s ease; text-align:center;
}

@keyframes slideUp { from{opacity:0;transform:translateY(35px);} to{opacity:1;transform:translateY(0);} }

.btn {
    display: block;
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    background: linear-gradient(135deg,#fff,#dfe9f3);
    border-radius: 12px;
    color:#243b55;
    font-size: 17px;
    font-weight: 700;
    text-decoration: none;
    transition: .3s;
}
.btn:hover { transform:translateY(-3px) scale(1.05); }
</style>

</head>
<body>

<div class="shape"></div> <div class="shape"></div> <div class="shape"></div> <div class="shape"></div>

<div class="container">
    <h2>Infrastructure Dashboard</h2>

    <a href="infra_view_complaints.php" class="btn">View Complaints</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

</body>
</html>
