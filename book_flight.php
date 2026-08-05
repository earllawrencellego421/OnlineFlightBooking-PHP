<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php');
require 'helpers/init_conn_db.php';
?>

<div class="el-page">
    <div class="el-container">
        <?php if (isset($_POST['search_but'])) {
            // FIXED: We now check if the values actually exist before assigning them.
            // This prevents the "Undefined array key" error if the user submits without selecting a city.
            $dep_date = isset($_POST['dep_date']) ? $_POST['dep_date'] : '';
            $ret_date = isset($_POST['ret_date']) ? $_POST['ret_date'] : '';
            $dep_city = isset($_POST['dep_city']) ? $_POST['dep_city'] : '0';
            $arr_city = isset($_POST['arr_city']) ? $_POST['arr_city'] : '0';
            $type = isset($_POST['type']) ? $_POST['type'] : 'round';
            $f_class = isset($_POST['f_class']) ? $_POST['f_class'] : 'E';
            $passengers = isset($_POST['passengers']) ? $_POST['passengers'] : 1;
            
            // Redirect back with an error alert if the data is missing
            if ($dep_city === '0') {
                header('Location: index.php?error=seldep');
                exit();
            }
            if ($arr_city === '0') {
                header('Location: index.php?error=selarr');
                exit();
            }
            if ($dep_city === $arr_city) {
                header('Location: index.php?error=sameval');
                exit();
            }
            ?>
            <div class="el-page-title">Flights &mdash; <?php echo htmlspecialchars($dep_city); ?> to <?php echo htmlspecialchars($arr_city); ?></div>
            <p class="el-page-sub">Showing flights for <?php echo htmlspecialchars($dep_date); ?> &middot; <?php echo (int) $passengers; ?> passenger(s) &middot; <?php echo $f_class === 'B' ? 'Business' : 'Economy'; ?></p>

            <?php
            function displayFlightCard($row, $passengers, $type, $f_class, $ret_date) {
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
                    if ($row['status'] === '') {
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
                        echo '<p class="mt-2 mb-0 text-muted small">Not available</p>';
                    }
                } else {
                    echo '<a href="login.php" class="el-link">Login to continue</a>';
                }
                
                echo '
                    </div>
                </div>
                ';
            }

            // Step 1: Search for existing flights on or after the requested date
            $sql = 'SELECT * FROM Flight WHERE source=? AND Destination =? AND DATE(departure) >= ? ORDER BY departure ASC, Price ASC';
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, 'sss', $dep_city, $arr_city, $dep_date);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                // Display normal scheduled flights
                while ($row = mysqli_fetch_assoc($result)) {
                    displayFlightCard($row, $passengers, $type, $f_class, $ret_date);
                }
            } else {
                // Step 2: Auto-Generate Mode - Create a dynamic realistic flight
                $default_admin = 1; 
                
                // Fetch a random airline from the database
                $air_sql = "SELECT * FROM Airline ORDER BY RAND() LIMIT 1";
                $air_stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($air_stmt, $air_sql);
                mysqli_stmt_execute($air_stmt);
                $air_result = mysqli_stmt_get_result($air_stmt);
                
                if ($air_row = mysqli_fetch_assoc($air_result)) {
                    $default_airline = $air_row['name'];
                    $default_seats = $air_row['seats'];
                } else {
                    $default_airline = 'Earlines'; 
                    $default_seats = '150';
                }
                
                // Generate a random departure time (between 05:00 and 20:00)
                $rand_hour = str_pad(rand(5, 20), 2, "0", STR_PAD_LEFT);
                $mins = ['00', '15', '30', '45'];
                $rand_min = $mins[array_rand($mins)];
                $dep_datetime = $dep_date . ' ' . $rand_hour . ':' . $rand_min . ':00';
                
                // Generate a realistic domestic duration (1 to 2 hours, plus random minutes)
                $duration_hours = rand(1, 2);
                $duration_mins = rand(0, 45);
                $default_duration = (string) $duration_hours;
                
                $arr_time_obj = new DateTime($dep_datetime);
                $arr_time_obj->add(new DateInterval('PT' . $duration_hours . 'H' . $duration_mins . 'M'));
                $arr_datetime = $arr_time_obj->format('Y-m-d H:i:s');
                
                // Randomize a realistic base price
                $default_price = rand(1899, 4599); 
                
                $insert_sql = "INSERT INTO Flight(admin_id, arrivale, departure, Destination, source, airline, Seats, duration, Price, status, issue) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '', '')";
                $insert_stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($insert_stmt, $insert_sql);
                mysqli_stmt_bind_param($insert_stmt, 'isssssssi', $default_admin, $arr_datetime, $dep_datetime, $arr_city, $dep_city, $default_airline, $default_seats, $default_duration, $default_price);
                mysqli_stmt_execute($insert_stmt);
                
                $new_flight_id = mysqli_insert_id($conn);
                
                $fetch_sql = "SELECT * FROM Flight WHERE flight_id = ?";
                $fetch_stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($fetch_stmt, $fetch_sql);
                mysqli_stmt_bind_param($fetch_stmt, 'i', $new_flight_id);
                mysqli_stmt_execute($fetch_stmt);
                $new_result = mysqli_stmt_get_result($fetch_stmt);
                
                if ($new_row = mysqli_fetch_assoc($new_result)) {
                    echo '<div class="el-card text-center mb-4" style="background-color: var(--teal-tint); border: 1px solid var(--teal); padding: 12px;"><p class="mb-0" style="color:var(--teal-dark); font-weight:700;">A new direct route has been found for your travel dates!</p></div>';
                    displayFlightCard($new_row, $passengers, $type, $f_class, $ret_date);
                }
            }
            ?>
        <?php } ?>
    </div>
</div>

<?php subview('footer.php'); ?>