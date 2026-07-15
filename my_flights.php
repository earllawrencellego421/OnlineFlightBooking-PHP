<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php if (isset($_SESSION['userId'])) {
    require 'helpers/init_conn_db.php';
    ?>

<div class="el-page">
    <div class="el-container" style="max-width:820px;">
        <div class="el-page-title">Flight Status</div>
        <p class="el-page-sub">Live status for every flight you've booked.</p>

        <?php
        $has_rows = false;
        $stmt_t = mysqli_stmt_init($conn);
        $sql_t = 'SELECT * FROM Ticket WHERE user_id=?';
        $stmt_t = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_t, $sql_t)) {
            header('Location: my_flights.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt_t, 'i', $_SESSION['userId']);
            mysqli_stmt_execute($stmt_t);
            $result_t = mysqli_stmt_get_result($stmt_t);
            while ($row_t = mysqli_fetch_assoc($result_t)) {
                $stmt = mysqli_stmt_init($conn);
                $sql = 'SELECT * FROM Passenger_profile WHERE passenger_id=?';
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header('Location: my_flights.php?error=sqlerror');
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, 'i', $row_t['passenger_id']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        $sql_f = 'SELECT * FROM Flight WHERE flight_id=? ';
                        $stmt_f = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt_f, $sql_f)) {
                            header('Location: my_flights.php?error=sqlerror');
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt_f, 'i', $row_t['flight_id']);
                            mysqli_stmt_execute($stmt_f);
                            $result_f = mysqli_stmt_get_result($stmt_f);
                            if ($row_f = mysqli_fetch_assoc($result_f)) {
                                $has_rows = true;
                                $date_time_dep = $row_f['departure'];
                                $date_dep = substr($date_time_dep, 0, 10);
                                $time_dep = substr($date_time_dep, 10, 6);
                                $date_time_arr = $row_f['arrivale'];
                                $date_arr = substr($date_time_arr, 0, 10);
                                $time_arr = substr($date_time_arr, 10, 6);
                                if ($row_f['status'] === '') {
                                    $status = 'Not yet Departed';
                                    $pill = 'el-status-scheduled';
                                } else if ($row_f['status'] === 'dep') {
                                    $status = 'Departed';
                                    $pill = 'el-status-dep';
                                } else if ($row_f['status'] === 'issue') {
                                    $status = 'Delayed';
                                    $pill = 'el-status-issue';
                                } else if ($row_f['status'] === 'arr') {
                                    $status = 'Arrived';
                                    $pill = 'el-status-arr';
                                }
                                $dot_on = $row_f['status'] === 'arr' ? 'on' : '';
                                echo '
                                <div class="el-tracker">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3" style="gap:14px;">
                                        <div>
                                            <div class="el-track-city">' . htmlspecialchars($row_f['source']) . ' <i class="fa fa-long-arrow-right mx-2 el-track-plane"></i> ' . htmlspecialchars($row_f['Destination']) . '</div>
                                        </div>
                                        <span class="el-status-pill ' . $pill . '">' . $status . '</span>
                                    </div>
                                    <div class="el-track-line">
                                        <div class="el-track-dot on"></div>
                                        <div class="el-track-rule ' . $dot_on . '"></div>
                                        <i class="fa fa-plane el-track-plane"></i>
                                        <div class="el-track-rule ' . $dot_on . '"></div>
                                        <div class="el-track-dot ' . $dot_on . '"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="el-track-meta">Scheduled Departure</div>
                                            <div class="el-track-date">' . $date_dep . '</div>
                                            <div class="el-track-clock">' . $time_dep . '</div>
                                        </div>
                                        <div class="col-6 text-right">
                                            <div class="el-track-meta">Scheduled Arrival</div>
                                            <div class="el-track-date">' . $date_arr . '</div>
                                            <div class="el-track-clock">' . $time_arr . '</div>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                        }
                    }
                }
            }
        }
        if (!$has_rows) {
            echo '<div class="el-card text-center"><p class="mb-2" style="color:var(--slate);">You haven\'t booked any flights yet.</p><a href="index.php" class="el-link">Search flights</a></div>';
        }
        ?>
    </div>
</div>

<?php } ?>
<?php subview('footer.php'); ?>