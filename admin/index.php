<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>
<?php
// Pull today's flights once, reuse for every board below.
// IMPROVEMENT: Used 'Y' to get the full 4-digit year cleanly.
$curr_date = date('Y-m-d');
$sql = "SELECT * FROM Flight WHERE DATE(departure)=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, 's', $curr_date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$today_flights = array();
while ($row = mysqli_fetch_assoc($result)) {
    $today_flights[] = $row;
}

function earlines_status_badge($status)
{
    switch ($status) {
        case 'issue':
            return '<span class="badge-pill badge-issue">Issue</span>';
        case 'dep':
            return '<span class="badge-pill badge-dep">Departed</span>';
        case 'arr':
            return '<span class="badge-pill badge-arr">Arrived</span>';
        default:
            return '<span class="badge-pill badge-scheduled">Scheduled</span>';
    }
}
?>

<?php if (isset($_SESSION['adminId'])) { ?>

<div class="stat-grid">
    <div class="stat-card">
        <i class="fa fa-users"></i>
        <div class="stat-label">Total Passengers</div>
        <div class="stat-value"><?php include 'psngrcnt.php'; ?></div>
    </div>
    <div class="stat-card gold">
        <i class="fa fa-money"></i>
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value">&#8369;<?php include 'amtcnt.php'; ?></div>
    </div>
    <div class="stat-card coral">
        <i class="fa fa-plane"></i>
        <div class="stat-label">Flights</div>
        <div class="stat-value"><?php include 'flightscnt.php'; ?></div>
    </div>
    <div class="stat-card ink">
        <i class="fa fa-plane fa-rotate-180"></i>
        <div class="stat-label">Available Airlines</div>
        <div class="stat-value"><?php include 'airlcnt.php'; ?></div>
    </div>
</div>

<div class="tab-row">
    <button class="tab-btn active" data-tab-target="tab-flight" type="button">Today's Flights</button>
    <button class="tab-btn" data-tab-target="tab-issue" type="button">Issues</button>
    <button class="tab-btn" data-tab-target="tab-dep" type="button">Departed</button>
    <button class="tab-btn" data-tab-target="tab-arr" type="button">Arrived</button>
</div>

<!-- TODAY'S FLIGHTS -->
<div class="tab-panel active" id="tab-flight">
    <div class="board-card">
        <p class="board-title"><i class="fa fa-clock-o"></i> Today's Flights <span class="live-dot">Live</span></p>
        <table class="board">
            <thead>
                <tr>
                    <th>ID</th><th>Arrival</th><th>Departure</th><th>Destination</th>
                    <th>Source</th><th>Airline</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $has_rows = false; ?>
                <?php foreach ($today_flights as $row): if ($row['status'] == ''): $has_rows = true; ?>
                <tr>
                    <td><a href="pass_list.php?flight_id=<?php echo $row['flight_id']; ?>"><?php echo $row['flight_id']; ?></a></td>
                    <td><?php echo $row['arrivale']; ?></td>
                    <td><?php echo $row['departure']; ?></td>
                    <td><?php echo htmlspecialchars($row['Destination']); ?></td>
                    <td><?php echo htmlspecialchars($row['source']); ?></td>
                    <td><?php echo htmlspecialchars($row['airline']); ?></td>
                    <td><?php echo earlines_status_badge($row['status']); ?></td>
                    <td>
                        <div class="row-actions" style="position: relative;">
                            <button class="row-actions-toggle" type="button" style="background:none; border:none; cursor:pointer;">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="row-actions-panel" style="display:none; position:absolute; right:0; background:#fff; border:1px solid #ddd; padding:10px; z-index:100; box-shadow:0 4px 6px rgba(0,0,0,0.1); border-radius:4px; min-width: 150px;">
                                <form action="../includes/admin/admin.inc.php" method="post">
                                    <input type="hidden" name="flight_id" value="<?php echo $row['flight_id']; ?>">
                                    <label for="issue_<?php echo $row['flight_id']; ?>" style="display:block; font-size:12px; margin-bottom:5px;">Delay, in minutes</label>
                                    <input type="number" id="issue_<?php echo $row['flight_id']; ?>" name="issue" placeholder="Eg. 120" style="width:100%; margin-bottom:10px; padding:4px;">
                                    <button type="submit" name="issue_but" class="row-action-btn danger" style="width:100%; margin-bottom:5px;">Flag issue</button>
                                    <hr class="row-actions-divider" style="margin:5px 0;">
                                    <button type="submit" name="dep_but" class="row-action-btn primary" style="width:100%;">Mark departed</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endif; endforeach; ?>
                <?php if (!$has_rows): ?>
                <tr><td colspan="8" class="board-empty" style="text-align:center; padding: 20px;">No open flights left to manage today.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ISSUES -->
<div class="tab-panel" id="tab-issue" style="display:none;">
    <div class="board-card">
        <p class="board-title"><i class="fa fa-exclamation-triangle"></i> Today's Flight Issues</p>
        <table class="board">
            <thead>
                <tr>
                    <th>ID</th><th>Arrival</th><th>Departure</th><th>Destination</th>
                    <th>Source</th><th>Airline</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $has_rows = false; ?>
                <?php foreach ($today_flights as $row): if ($row['status'] == 'issue'): $has_rows = true; ?>
                <tr>
                    <td><a href="pass_list.php?flight_id=<?php echo $row['flight_id']; ?>"><?php echo $row['flight_id']; ?></a></td>
                    <td><?php echo $row['arrivale']; ?></td>
                    <td><?php echo $row['departure']; ?></td>
                    <td><?php echo htmlspecialchars($row['Destination']); ?></td>
                    <td><?php echo htmlspecialchars($row['source']); ?></td>
                    <td><?php echo htmlspecialchars($row['airline']); ?></td>
                    <td>
                        <form action="../includes/admin/admin.inc.php" method="post" style="display:inline;">
                            <input type="hidden" name="flight_id" value="<?php echo $row['flight_id']; ?>">
                            <button type="submit" name="issue_soved_but" class="btn btn-danger btn-sm">Issue solved</button>
                        </form>
                    </td>
                </tr>
                <?php endif; endforeach; ?>
                <?php if (!$has_rows): ?>
                <tr><td colspan="7" class="board-empty" style="text-align:center; padding: 20px;">No open issues &mdash; smooth skies today.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- DEPARTED -->
<div class="tab-panel" id="tab-dep" style="display:none;">
    <div class="board-card">
        <p class="board-title"><i class="fa fa-plane"></i> Flights Departed Today</p>
        <table class="board">
            <thead>
                <tr>
                    <th>ID</th><th>Arrival</th><th>Departure</th><th>Destination</th>
                    <th>Source</th><th>Airline</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $has_rows = false; ?>
                <?php foreach ($today_flights as $row): if ($row['status'] == 'dep'): $has_rows = true; ?>
                <tr>
                    <td><a href="pass_list.php?flight_id=<?php echo $row['flight_id']; ?>"><?php echo $row['flight_id']; ?></a></td>
                    <td><?php echo $row['arrivale']; ?></td>
                    <td><?php echo $row['departure']; ?></td>
                    <td><?php echo htmlspecialchars($row['Destination']); ?></td>
                    <td><?php echo htmlspecialchars($row['source']); ?></td>
                    <td><?php echo htmlspecialchars($row['airline']); ?></td>
                    <td>
                        <form action="../includes/admin/admin.inc.php" method="post" style="display:inline;">
                            <input type="hidden" name="flight_id" value="<?php echo $row['flight_id']; ?>">
                            <button type="submit" name="arr_but" class="btn btn-danger btn-sm">Mark arrived</button>
                        </form>
                    </td>
                </tr>
                <?php endif; endforeach; ?>
                <?php if (!$has_rows): ?>
                <tr><td colspan="7" class="board-empty" style="text-align:center; padding: 20px;">Nothing has departed yet today.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ARRIVED -->
<div class="tab-panel" id="tab-arr" style="display:none;">
    <div class="board-card">
        <p class="board-title"><i class="fa fa-flag-checkered"></i> Flights Arrived Today</p>
        <table class="board">
            <thead>
                <tr>
                    <th>ID</th><th>Arrival</th><th>Departure</th><th>Destination</th>
                    <th>Source</th><th>Airline</th>
                </tr>
            </thead>
            <tbody>
                <?php $has_rows = false; ?>
                <?php foreach ($today_flights as $row): if ($row['status'] == 'arr'): $has_rows = true; ?>
                <tr>
                    <td><a href="pass_list.php?flight_id=<?php echo $row['flight_id']; ?>"><?php echo $row['flight_id']; ?></a></td>
                    <td><?php echo $row['arrivale']; ?></td>
                    <td><?php echo $row['departure']; ?></td>
                    <td><?php echo htmlspecialchars($row['Destination']); ?></td>
                    <td><?php echo htmlspecialchars($row['source']); ?></td>
                    <td><?php echo htmlspecialchars($row['airline']); ?></td>
                </tr>
                <?php endif; endforeach; ?>
                <?php if (!$has_rows): ?>
                <tr><td colspan="6" class="board-empty" style="text-align:center; padding: 20px;">No arrivals logged yet today.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php } ?>

<!-- ADDED: JavaScript to make the Tabs and Action Menus function properly -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching logic
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active state from all buttons and hide all panels
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.style.display = 'none');
            
            // Add active state to clicked button and show its target panel
            btn.classList.add('active');
            const targetId = btn.getAttribute('data-tab-target');
            document.getElementById(targetId).style.display = 'block';
        });
    });

    // Action Menu Toggle Logic (The 3 dots)
    const toggles = document.querySelectorAll('.row-actions-toggle');
    const panels = document.querySelectorAll('.row-actions-panel');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation(); // Stop click from immediately closing the panel
            const panel = toggle.nextElementSibling;
            
            // Close all other open menus first
            panels.forEach(p => {
                if (p !== panel) p.style.display = 'none';
            });
            
            // Toggle the clicked one
            panel.style.display = (panel.style.display === 'none' || panel.style.display === '') ? 'block' : 'none';
        });
    });

    // Close the action menu if the user clicks anywhere else on the page
    document.addEventListener('click', () => {
        panels.forEach(p => p.style.display = 'none');
    });
});
</script>

<?php include_once 'footer.php'; ?>