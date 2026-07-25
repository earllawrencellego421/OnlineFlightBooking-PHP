<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>
<?php
if (isset($_POST['del_flight']) and isset($_SESSION['adminId'])) {
    $flight_id = $_POST['flight_id'];
    $sql = 'DELETE FROM Flight WHERE flight_id=?';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: ../index.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $flight_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo("<script>location.href = 'all_flights.php';</script>");
        exit();
    }
}
?>

<?php if (isset($_SESSION['adminId'])) { ?>

<div class="light-card">
    <div class="light-card-head">
        <div>
            <div class="page-title">Flight List</div>
            <p class="page-sub">Every route currently in the schedule. Click an ID to see its passengers.</p>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Airline</th>
                <th>Seats</th>
                <th>Price</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = 'SELECT * FROM Flight ORDER BY flight_id DESC';
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $has_rows = false;
            while ($row = mysqli_fetch_assoc($result)) {
                $has_rows = true;
                echo '
                <tr>
                    <td><a class="row-id" href="pass_list.php?flight_id=' . $row['flight_id'] . '">#' . $row['flight_id'] . '</a></td>
                    <td>' . $row['arrivale'] . '</td>
                    <td>' . $row['departure'] . '</td>
                    <td>' . htmlspecialchars($row['source']) . '</td>
                    <td>' . htmlspecialchars($row['Destination']) . '</td>
                    <td>' . htmlspecialchars($row['airline']) . '</td>
                    <td>' . htmlspecialchars($row['Seats']) . '</td>
                    <td>&#8369; ' . $row['Price'] . '</td>
                    <td>
                        <form action="../includes/admin/update_status.php" method="POST" style="display:flex; gap:8px; align-items:center;">
                            <input type="hidden" name="flight_id" value="' . $row['flight_id'] . '">
                            <select name="status" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc;">
                                <option value="" ' . ($row['status'] == '' ? 'selected' : '') . '>Scheduled</option>
                                <option value="dep" ' . ($row['status'] == 'dep' ? 'selected' : '') . '>Departed</option>
                                <option value="arr" ' . ($row['status'] == 'arr' ? 'selected' : '') . '>Arrived</option>
                                <option value="issue" ' . ($row['status'] == 'issue' ? 'selected' : '') . '>Delayed</option>
                            </select>
                            <button type="submit" name="update_status" class="icon-btn" title="Save Status" style="color:#0E7C86; background:none; border:none; cursor:pointer;">
                                <i class="fa fa-save"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <form action="all_flights.php" method="post" class="confirm-delete" data-confirm="Delete flight #' . $row['flight_id'] . '? This cannot be undone.">
                            <input name="flight_id" type="hidden" value="' . $row['flight_id'] . '">
                            <button class="icon-btn" type="submit" name="del_flight" title="Delete flight" style="background:none; border:none; color:#E8583F; cursor:pointer;">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                ';
            }
            if (!$has_rows) {
                echo '<tr><td colspan="10" class="board-empty">No flights scheduled yet. <a href="flight.php">Add your first flight</a>.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php } ?>

<?php include_once 'footer.php'; ?>