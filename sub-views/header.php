<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/earlines-site.css?v=5">
    <title>Earlines &mdash; Fly the Philippines</title>
    <link rel="icon" href="assets/images/brand.png" type="image/x-icon">
</head>
<body>
<nav class="el-navbar navbar navbar-expand-lg navbar-dark">
    <div class="el-container d-flex align-items-center justify-content-between w-100">
        <a class="navbar-brand" href="index.php">
            <span class="el-brand-mark"><i class="fa fa-paper-plane"></i></span>
            <span class="el-brand-word">Earlines</span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto ml-4">
                <?php if (isset($_SESSION['userId'])) { ?>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="my_flights.php"><h5>My Flights</h5></a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="ticket.php"><h5>Tickets</h5></a>
                </li>
                <?php } ?>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="feedback.php"><h5>Feedback</h5></a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="about.php"><h5>About</h5></a>
                </li>
            </ul>

            <?php if (isset($_SESSION['userId'])) { ?>
            <ul class="nav navbar-nav navbar-right align-items-lg-center">
                <li class="nav-item mr-3">
                    <h5><i class="ml-1 fa fa-user mr-1"></i><?php echo htmlspecialchars($_SESSION['userUid']); ?></h5>
                </li>
                <li class="nav-item">
                    <form action="includes/logout.inc.php" class="logout_form m-0 p-0" method="POST">
                        <button class="astext" type="submit"><h5>Logout</h5></button>
                    </form>
                </li>
            </ul>
            <?php } else { ?>
            <div class="dropdown">
                <button class="btn-login dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Login
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="login.php"><i class="fa fa-user mr-2"></i>Passenger</a>
                    <a class="dropdown-item" href="admin/login.php"><i class="fa fa-lock mr-2"></i>Administrator</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</nav>