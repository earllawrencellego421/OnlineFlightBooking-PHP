<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

<div class="el-page d-flex align-items-center justify-content-center" style="min-height:75vh;">
    <div class="el-container" style="max-width:520px;">
        <div class="el-card text-center">
            <div style="width:64px;height:64px;border-radius:50%;background:var(--teal-tint);display:flex;align-items:center;justify-content:center;margin:0 auto 18px auto;">
                <i class="fa fa-check fa-2x" style="color:var(--teal-dark);"></i>
            </div>
            <h2 class="mb-2">Payment Successful!</h2>
            <p style="color:var(--slate);">Thank you for choosing Earlines. An automated payment receipt will be sent to your registered email.</p>
            <a href="my_flights.php" class="el-btn el-btn-primary mt-2">View my flights</a>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>