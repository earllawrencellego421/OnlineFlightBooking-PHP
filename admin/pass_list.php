<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>

<?php if (isset($_SESSION['adminId'])) { ?>

<div class="light-card">
    <div class="light-card-head">
        <div>
            <div class="page-title">Passenger List</div>
            <p class="page-sub">Flight #<?php echo htmlspecialchars($_GET['flight_id']); ?> &mdash; booked passengers and payment.</p>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Contact</th>
                <th>D.O.B</th>
                <th>Paid By</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cnt = 1;
            $has_rows = false;
            $flight_id = $_GET['flight_id'];
            $sql_t = 'SELECT * FROM Ticket WHERE flight_id=?';
            $stmt_t = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt_t, $sql_t)) {
                header('Location: ticket.php?error=sqlerror');
                exit();
            } else {
                mysqli_stmt_bind_param($stmt_t, 'i', $flight_id);
                mysqli_stmt_execute($stmt_t);
                $result_t = mysqli_stmt_get_result($stmt_t);
                while ($row_t = mysqli_fetch_assoc($result_t)) {
                    $sql = 'SELECT * FROM Passenger_profile WHERE passenger_id=?';
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_bind_param($stmt, 'i', $row_t['passenger_id']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        $sql_p = 'SELECT * FROM PAYMENT WHERE flight_id=? AND user_id=?';
                        $stmt_p = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt_p, $sql_p);
                        mysqli_stmt_bind_param($stmt_p, 'ii', $flight_id, $row['user_id']);
                        mysqli_stmt_execute($stmt_p);
                        $result_p = mysqli_stmt_get_result($stmt_p);
                        if ($row_p = mysqli_fetch_assoc($result_p)) {
                            $sql_u = 'SELECT * FROM Users WHERE user_id=?';
                            $stmt_u = mysqli_stmt_init($conn);
                            mysqli_stmt_prepare($stmt_u, $sql_u);
                            mysqli_stmt_bind_param($stmt_u, 'i', $row['user_id']);
                            mysqli_stmt_execute($stmt_u);
                            $result_u = mysqli_stmt_get_result($stmt_u);
                            if ($row_u = mysqli_fetch_assoc($result_u)) {
                                $has_rows = true;
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . htmlspecialchars($row['f_name']) . '</td>
                                    <td>' . htmlspecialchars($row['m_name']) . '</td>
                                    <td>' . htmlspecialchars($row['l_name']) . '</td>
                                    <td>' . htmlspecialchars($row['mobile']) . '</td>
                                    <td>' . $row['dob'] . '</td>
                                    <td><span class="row-id">' . htmlspecialchars($row_u['username']) . '</span></td>
                                    <td>&#8369; ' . $row_p['amount'] . '</td>
                                </tr>
                                ';
                            }
                        }
                    }
                    $cnt++;
                }
            }
            if (!$has_rows) {
                echo '<tr><td colspan="8" class="board-empty">No passengers booked on this flight yet.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php } ?>

<?php include_once 'footer.php'; ?>