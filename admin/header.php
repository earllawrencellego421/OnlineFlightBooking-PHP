<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
function earlines_nav_active($page, $current) {
    return $page === $current ? 'active' : '';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/earlines-admin.css?v=3">
    <title>Earlines &mdash; Admin</title>
    <link rel="icon" href="../assets/images/brand.png" type="image/x-icon">
</head>
<body class="<?php echo isset($_SESSION['adminId']) ? '' : 'auth-page'; ?>">
<?php if (isset($_SESSION['adminId'])) { ?>
<div class="shell">
    <aside class="sidebar">
        <a class="brand" href="index.php">
            <span class="brand-mark"><i class="fa fa-paper-plane"></i></span>
            <span class="brand-word">Earlines</span>
        </a>

        <nav class="nav">
            <a class="nav-link <?php echo earlines_nav_active('index.php', $current_page); ?>" href="index.php">
                <i class="fa fa-th-large"></i><span>Dashboard</span>
            </a>
            <a class="nav-link <?php echo earlines_nav_active('flight.php', $current_page); ?>" href="flight.php">
                <i class="fa fa-plus-circle"></i><span>Add Flight</span>
            </a>
            <a class="nav-link <?php echo earlines_nav_active('all_flights.php', $current_page); ?>" href="all_flights.php">
                <i class="fa fa-list"></i><span>Flights</span>
            </a>
            <a class="nav-link <?php echo earlines_nav_active('list_airlines.php', $current_page); ?>" href="list_airlines.php">
                <i class="fa fa-plane"></i><span>Airlines</span>
            </a>
            <a class="nav-link <?php echo earlines_nav_active('review.php', $current_page); ?>" href="review.php">
                <i class="fa fa-star"></i><span>Reviews</span>
            </a>
        </nav>

        <div class="nav-add-airline">
            <button class="pill-btn" id="addAirlineToggle" type="button">
                <i class="fa fa-plus"></i> New Airline
            </button>
            <form class="add-airline-form" id="addAirlineForm" action="../includes/admin/airline.inc.php" method="post">
                <input type="text" name="airline" placeholder="Airline name" required>
                <input type="number" name="seats" placeholder="Total seats" required>
                <button type="submit" name="air_but" class="pill-btn solid">Save Airline</button>
            </form>
        </div>
    </aside>

    <div class="content-area">
        <header class="topbar">
            <div>
                <p class="eyebrow">Mabuhay,</p>
                <h1 class="topbar-name"><?php echo htmlspecialchars($_SESSION['adminUname']); ?></h1>
            </div>
            <div class="topbar-right">
                <span class="topbar-date"><?php echo date('l, F j, Y'); ?></span>
                <form action="../includes/logout.inc.php" method="POST">
                    <button class="logout-btn" type="submit"><i class="fa fa-sign-out"></i> Logout</button>
                </form>
            </div>
        </header>
        <main class="main-content">
<?php } ?>