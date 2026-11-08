<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
$session_id = session_id();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard | SessionAuthSystem</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background: #b674a5;
    font-family:Arial, Helvetica, sans-serif;
    color:#263244;
}

.navbar{
    background:solid #e0b2d5;
}

.navbar-brand{
    color:#fff !important;
    font-weight:bold;
}

.user-label{
    color: #d69bc7;
}

.logout-btn{
    text-decoration:none;
    color:#ff6b6b;
    border:1px solid #fd5fd6;
    padding:7px 14px;
    border-radius:6px;
    transition:.3s;
}

.logout-btn:hover{
    background: #e455c2;
    color:#fff;
}

.page-container{
    max-width:1200px;
    margin:30px auto;
    padding:20px;
}

.welcome-card{
    background: #f5a6e1;
    border-radius:15px;
    padding:50px;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
}

.welcome-title{
    color: #ce0f9e;
    font-size:42px;
    font-weight:bold;
}

.welcome-subtitle{
    color: #c249a4;
    font-size:18px;
}

.explore-btn{
    background: #d86bbd;
    color:#e2b1d6;
    border:none;
    padding:12px 20px;
    border-radius:8px;
}

.explore-btn:hover{
    background:#ce65b4;
}

.info-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
    margin-top:30px;
}

.info-card{
    background:#e958c5;
    padding:25px;
    border-radius:12px;
    box-shadow:0 3px 12px rgba(0,0,0,.06);
    transition:.3s;
}

.info-card:hover{
    transform:translateY(-5px);
}

.info-title{
    font-size:18px;
    font-weight:600;
    margin-bottom:12px;
}

.info-card p{
    color:#f189d7;
    line-height:1.7;
}

.session-code{
    display:block;
    font-size:12px;
    color:#ca4aaa;
    font-weight:bold;
    word-break:break-all;
    margin-top:10px;
}


.demo-message{
    width:100%;
    overflow:hidden;
    white-space:nowrap;
    margin-top:35px;
}

.demo-message-content{
    display:inline-block;
    padding-left:100%;
    animation:marquee 20s linear infinite;
    color:#000;
    font-weight:600;
    font-size:15px;
}

.demo-message-content i{
    color:#000;
}

@keyframes marquee{
    0%{
        transform:translateX(0);
    }

    100%{
        transform:translateX(-100%);
    }
}

@media(max-width:768px){

    .welcome-title{
        font-size:30px;
    }

    .welcome-card{
        padding:30px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a class="navbar-brand" href="#">
            <i class="bi bi-shield-lock-fill"></i>
                SessionAuthSystem
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">

            <span class="user-label">
                <i class="bi bi-person-circle"></i>
                <?= htmlspecialchars($username) ?>
            </span>

            <a href="logout.php" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>

        </div>

    </div>

</nav>

<div class="page-container">

    <div class="welcome-card">

        <h1 class="welcome-title">
            Welcome, <?= htmlspecialchars($username) ?>!
        </h1>

        <p class="welcome-subtitle">
            This page is protected and only visible to logged_in users.
        </p>

        <button
            class="explore-btn"
            onclick="document.getElementById('account-info').scrollIntoView({behavior:'smooth'})">

            <i class="bi bi-compass"></i>
            Explore Dashboard

        </button>

    </div>

    <div class="info-grid" id="account-info">

        <div class="info-card">

            <div class="info-title text-success">
                <i class="bi bi-shield-check"></i>
                Account Status
            </div>

            <p>
                Your session is active and protected against Session Fixation using 
                <code>session_regenerate_id(true)</code>.
            </p>

        </div>

        <div class="info-card">

            <div class="info-title text-primary">
                <i class="bi bi-person-badge"></i>
                User Details
            </div>

            <p>
                <strong>User ID:</strong>
                <?= htmlspecialchars($user_id) ?>

                <br><br>

                <strong>Username:</strong>
                <?= htmlspecialchars($username) ?>
            </p>

        </div>

        <div class="info-card">

            <div class="info-title text-warning">
                <i class="bi bi-key"></i>
                Active Session ID
            </div>

            <p>

                <strong>Current Session ID:</strong>

                <span class="session-code">
                    <?= htmlspecialchars($session_id) ?>
                </span>

                <br>

                Generated after login call to
                <code>session_regenerate_id(true)</code>.

            </p>

        </div>

    </div>

    <div class="demo-message">
        <div class="demo-message-content">
        </div>
    </div>

</div>

</body>
</html>