<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php');
require 'helpers/init_conn_db.php';
?>

<div class="el-page">
    <div class="el-container">
        <?php if (isset($_POST['search_but'])) {
            $dep_date = $_POST['dep_date'];
            $ret_date = $_POST['ret_date'];
            $dep_city = $_POST['dep_city'];
            $arr_city = $_POST['arr_city'];
            $type = $_POST['type'];
            $f_class = $_POST['f_class'];
            $passengers = $_POST['passengers'];
            if ($dep_city === $arr_city) {
                header('Location: index.php?error=sameval');
                exit();
            }
            if ($dep_city === '0') {
                header('Location: index.php?error=seldep');
                exit();
            }
            if ($arr_city === '0') {
                header('Location: index.php?error=selarr');
                exit();
            }
            ?>
            <div class="el-page-title">Flights &mdash; <?php echo htmlspecialchars($dep_city); ?> to <?php echo htmlspecialchars($arr_city); ?></div>
            <p class="el-page-sub">Showing upcoming flights on or after <?php echo htmlspecialchars($dep_date); ?> &middot; <?php echo (int) $passengers; ?> passenger(s) &middot; <?php echo $f_class === 'B' ? 'Business' : 'Economy'; ?></p>

            <?php
            // CHANGED: DATE(departure) >= ? instead of DATE(departure) = ?
            // This shows flights on the selected date OR ANY future date for this route.
            $sql = 'SELECT * FROM Flight WHERE source=? AND Destination =? AND
                DATE(departure) >= ? ORDER BY departure ASC, Price ASC';
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, 'sss', $dep_city, $arr_city, $dep_date);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $has_rows = false;
            
            while ($row = mysqli_fetch_assoc($result)) {
                $has_rows = true;
                $price = (int) $row['Price'] * (int) $passengers;
                if ($type === 'round') {
                    $price = $price * 2;
                }
                if ($f_class == 'B') {
                    $price += 0.5 * $price;
                }
                if ($row['status'] === '') {
                    $status = 'Not yet Departed';
                    $pill = 'el-status-scheduled';
                } else if ($row['status'] === 'dep') {
                    $status = 'Departed';
                    $pill = 'el-status-dep';
                } else if ($row['status'] === 'issue') {
                    $status = 'Delayed';
                    $pill = 'el-status-issue';
                } else if ($row['status'] === 'arr') {
                    $status = 'Arrived';
                    $pill = 'el-status-arr';
                }
                echo '
                <div class="el-flight-card">
                    <div>
                        <div class="el-flight-label">Airline</div>
                        <div class="el-flight-airline">' . htmlspecialchars($row['airline']) . '</div>
                    </div>
                    <div>
                        <div class="el-flight-label">Departure</div>
                        <div class="el-flight-time">' . $row['departure'] . '</div>
                    </div>
                    <div>
                        <div class="el-flight-label">Arrival</div>
                        <div class="el-flight-time">' . $row['arrivale'] . '</div>
                    </div>
                    <div>
                        <div class="el-flight-label">Status</div>
                        <span class="el-status-pill ' . $pill . '">' . $status . '</span>
                    </div>
                    <div class="text-right">
                        <div class="el-flight-label">Fare</div>
                        <div class="el-flight-price">&#8369;' . $price . '</div>
                ';
                
                if (isset($_SESSION['userId'])) {
                    // User IS logged in
                    if ($row['status'] === '') {
                        // Flight is open for booking
                        echo '
                            <form action="pass_form.php" method="post" class="mt-2">
                                <input name="flight_id" type="hidden" value="' . $row['flight_id'] . '">
                                <input name="type" type="hidden" value="' . htmlspecialchars($type) . '">
                                <input name="passengers" type="hidden" value="' . htmlspecialchars($passengers) . '">
                                <input name="price" type="hidden" value="' . $price . '">
                                <input name="ret_date" type="hidden" value="' . htmlspecialchars($ret_date) . '">
                                <input name="class" type="hidden" value="' . htmlspecialchars($f_class) . '">
                                <button name="book_but" type="submit" class="el-btn el-btn-primary el-btn-block">
                                    <i class="fa fa-check"></i> Book
                                </button>
                            </form>
                        ';
                    } else {
                        // Flight is departed, arrived, or has an issue
                        echo '<p class="mt-2 mb-0 text-muted small">Not available</p>';
                    }
                } else {
                    // User is NOT logged in
                    echo '<a href="login.php" class="el-link">Login to continue</a>';
                }
                
                echo '
                    </div>
                </div>
                ';
            }
            if (!$has_rows) {
                echo '<div class="el-card text-center"><p class="mb-0" style="color:var(--slate);">No upcoming flights found for this route. Please try a different destination.</p></div>';
            }
            ?>
        <?php } ?>
    </div>
</div>

<?php subview('footer.php'); ?>