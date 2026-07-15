<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<style>
.el-navbar, .el-footer { display: none !important; }
body { background: var(--paper); }
</style>

<div class="el-page">
  <div class="el-container" style="max-width:760px;">
  <?php if (isset($_SESSION['userId'])) {
    require 'helpers/init_conn_db.php';
    ?>
    <?php
    if (isset($_POST['print_but'])) {
        $ticket_id = $_POST['ticket_id'];
        $stmt = mysqli_stmt_init($conn);
        $sql = 'SELECT * FROM Ticket WHERE ticket_id=?';
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ticket.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'i', $ticket_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $sql_p = 'SELECT * FROM Passenger_profile WHERE passenger_id=?';
                $stmt_p = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt_p, $sql_p)) {
                    header('Location: ticket.php?error=sqlerror');
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt_p, 'i', $row['passenger_id']);
                    mysqli_stmt_execute($stmt_p);
                    $result_p = mysqli_stmt_get_result($stmt_p);
                    if ($row_p = mysqli_fetch_assoc($result_p)) {
                        $sql_f = 'SELECT * FROM Flight WHERE flight_id=?';
                        $stmt_f = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt_f, $sql_f)) {
                            header('Location: ticket.php?error=sqlerror');
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt_f, 'i', $row['flight_id']);
                            mysqli_stmt_execute($stmt_f);
                            $result_f = mysqli_stmt_get_result($stmt_f);
                            if ($row_f = mysqli_fetch_assoc($result_f)) {
                                $date_time_dep = $row_f['departure'];
                                $date_dep = substr($date_time_dep, 0, 10);
                                $time_dep = substr($date_time_dep, 10, 6);
                                $board_time = date('H:i', strtotime($date_time_dep . ' -30 minutes'));
                                $date_time_arr = $row_f['arrivale'];
                                $date_arr = substr($date_time_arr, 0, 10);
                                $time_arr = substr($date_time_arr, 10, 6);
                                $class_txt = $row['class'] === 'E' ? 'ECONOMY' : 'BUSINESS';
                                echo '
                                <div class="el-boardingpass">
                                    <div class="el-bp-main">
                                        <div class="el-bp-head">
                                            <span class="el-bp-brand"><i class="fa fa-paper-plane mr-1"></i> Earlines</span>
                                            <span class="el-bp-class">' . $class_txt . ' CLASS</span>
                                        </div>
                                        <hr class="el-bp-divider">
                                        <div class="el-bp-row">
                                            <div class="el-bp-col">
                                                <div class="el-bp-label">Airline</div>
                                                <div class="el-bp-value">' . htmlspecialchars($row_f['airline']) . '</div>
                                            </div>
                                            <div class="el-bp-col">
                                                <div class="el-bp-label">From</div>
                                                <div class="el-bp-value">' . htmlspecialchars($row_f['source']) . '</div>
                                            </div>
                                            <div class="el-bp-col">
                                                <div class="el-bp-label">To</div>
                                                <div class="el-bp-value">' . htmlspecialchars($row_f['Destination']) . '</div>
                                            </div>
                                        </div>
                                        <div class="el-bp-row">
                                            <div class="el-bp-col" style="flex:2;">
                                                <div class="el-bp-label">Passenger</div>
                                                <div class="el-bp-value" style="text-transform:uppercase;">' . htmlspecialchars($row_p['f_name'] . ' ' . $row_p['m_name'] . ' ' . $row_p['l_name']) . '</div>
                                            </div>
                                            <div class="el-bp-col">
                                                <div class="el-bp-label">Board Time</div>
                                                <div class="el-bp-value">' . $board_time . '</div>
                                            </div>
                                        </div>
                                        <div class="el-bp-row mb-0">
                                            <div class="el-bp-col">
                                                <div class="el-bp-label">Departure</div>
                                                <div class="el-bp-value">' . $date_dep . '</div>
                                                <div class="el-bp-value-lg">' . $time_dep . '</div>
                                            </div>
                                            <div class="el-bp-col">
                                                <div class="el-bp-label">Arrival</div>
                                                <div class="el-bp-value">' . $date_arr . '</div>
                                                <div class="el-bp-value-lg">' . $time_arr . '</div>
                                            </div>
                                            <div class="el-bp-col">
                                                <div class="el-bp-label">Gate</div>
                                                <div class="el-bp-value-lg">A22</div>
                                            </div>
                                            <div class="el-bp-col">
                                                <div class="el-bp-label">Seat</div>
                                                <div class="el-bp-value-lg">' . htmlspecialchars($row['seat_no']) . '</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="el-bp-stub">
                                        <i class="fa fa-paper-plane fa-2x mb-2"></i>
                                        <p class="mb-0" style="font-size:13px;color:rgba(255,255,255,0.75);">Thank you for choosing Earlines.<br>Please be at the gate at boarding time.</p>
                                    </div>
                                </div>
                                ';
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
  <?php } ?>
  </div>
</div>

<?php subview('footer.php'); ?>
<script>window.print();</script>