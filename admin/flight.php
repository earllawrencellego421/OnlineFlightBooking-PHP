<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>

<?php if (isset($_SESSION['adminId'])) { ?>

<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'destless') {
        echo "<script>alert('Dest. date/time is less than src.');</script>";
    } else if ($_GET['error'] === 'sqlerr') {
        echo "<script>alert('Database error');</script>";
    } else if ($_GET['error'] === 'same') {
        echo "<script>alert('Same city specified in source and destination');</script>";
    }
}
?>

<div class="page-title">Add Flight</div>
<p class="page-sub">Schedule a new route for the fleet.</p>

<div class="form-shell mt-4">
    <form method="POST" action="../includes/admin/flight.inc.php">

        <p class="section-label"><i class="fa fa-plane"></i> Departure</p>
        <div class="field-row">
            <div class="field-group">
                <label for="source_date">Date</label>
                <input type="date" name="source_date" id="source_date" required>
            </div>
            <div class="field-group">
                <label for="source_time">Time</label>
                <input type="time" name="source_time" id="source_time" required>
            </div>
        </div>

        <p class="section-label"><i class="fa fa-flag-checkered"></i> Arrival</p>
        <div class="field-row">
            <div class="field-group">
                <label for="dest_date">Date</label>
                <input type="date" name="dest_date" id="dest_date" required>
            </div>
            <div class="field-group">
                <label for="dest_time">Time</label>
                <input type="time" name="dest_time" id="dest_time" required>
            </div>
        </div>

        <p class="section-label"><i class="fa fa-map-marker"></i> Route</p>
        <div class="field-row">
            <div class="field-group">
                <label for="dep_city">From</label>
                <select name="dep_city" id="dep_city" required>
                    <option value="" selected disabled>Select a city</option>
                    <?php
                    $sql = 'SELECT * FROM Cities';
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . htmlspecialchars($row['city']) . '">' . htmlspecialchars($row['city']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="field-group">
                <label for="arr_city">To</label>
                <select name="arr_city" id="arr_city" required>
                    <option value="" selected disabled>Select a city</option>
                    <?php
                    $sql = 'SELECT * FROM Cities';
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . htmlspecialchars($row['city']) . '">' . htmlspecialchars($row['city']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <p class="section-label"><i class="fa fa-tags"></i> Fare &amp; Carrier</p>
        <div class="field-row triple">
            <div class="field-group">
                <label for="dura">Duration (hrs)</label>
                <input type="text" name="dura" id="dura" required>
            </div>
            <div class="field-group">
                <label for="price">Price (&#8369;)</label>
                <input type="number" name="price" id="price" required>
            </div>
            <div class="field-group">
                <label for="airline_name">Airline</label>
                <select name="airline_name" id="airline_name" required>
                    <option value="" selected disabled>Select airline</option>
                    <?php
                    $sql = 'SELECT * FROM Airline';
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['airline_id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <button name="flight_but" type="submit" class="btn-primary mt-3">
            Add flight <i class="fa fa-arrow-right"></i>
        </button>
    </form>
</div>

<?php } ?>

<?php include_once 'footer.php'; ?>