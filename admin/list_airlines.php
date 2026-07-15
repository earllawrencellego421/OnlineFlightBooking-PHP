<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>
<?php
if (isset($_POST['del_airlines']) and isset($_SESSION['adminId'])) {
    $airline_id = $_POST['airline_id'];
    $sql = 'DELETE FROM airline WHERE airline_id=?';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: ../index.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $airline_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo("<script>location.href = 'list_airlines.php';</script>");
        exit();
    }
}
?>

<?php if (isset($_SESSION['adminId'])) { ?>

<div class="light-card">
    <div class="light-card-head">
        <div>
            <div class="page-title">Airlines</div>
            <p class="page-sub">Carriers available to assign when scheduling a flight.</p>
        </div>
        <button class="btn-primary" type="button" onclick="document.getElementById('addAirlineToggle').click(); window.scrollTo(0,0);">
            <i class="fa fa-plus"></i> New Airline
        </button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Seats</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cnt = 1;
            $sql = 'SELECT * FROM airline ORDER BY airline_id ASC';
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $has_rows = false;
            while ($row = mysqli_fetch_assoc($result)) {
                $has_rows = true;
                echo '
                <tr>
                    <td>' . $cnt . '</td>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['seats']) . '</td>
                    <td>
                        <form action="list_airlines.php" method="post" class="confirm-delete" data-confirm="Remove ' . htmlspecialchars($row['name'], ENT_QUOTES) . '? Existing flights will keep referencing it.">
                            <input name="airline_id" type="hidden" value="' . $row['airline_id'] . '">
                            <button class="icon-btn" type="submit" name="del_airlines" title="Delete airline">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                ';
                $cnt++;
            }
            if (!$has_rows) {
                echo '<tr><td colspan="4" class="board-empty">No airlines yet. Use "New Airline" to add your first carrier.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php } ?>

<?php include_once 'footer.php'; ?>