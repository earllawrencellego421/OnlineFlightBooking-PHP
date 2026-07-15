<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php
if (isset($_GET['err']) || isset($_GET['mail'])) {
    if (isset($_GET['err']) && $_GET['err'] === 'invalidemail') {
        echo '<script>alert("Invalid email");</script>';
    } else if (isset($_GET['err']) && $_GET['err'] === 'sqlerr') {
        echo '<script>alert("An error occured");</script>';
    } else if (isset($_GET['mail']) && $_GET['mail'] === 'success') {
        echo '<script>alert("Email has been succesfully sent to you");</script>';
    } else if (isset($_GET['err']) && $_GET['err'] === 'mailerr') {
        echo '<script>alert("An error occured");</script>';
    }
}
?>

<div class="el-page">
    <div class="el-container" style="max-width:480px;">
        <div class="el-card">
            <div class="el-page-title" style="font-size:26px;">Reset Password</div>
            <div class="el-status-pill el-status-scheduled mb-3" style="display:block;text-align:left;padding:12px 16px;font-weight:600;text-transform:none;letter-spacing:normal;font-size:13.5px;">
                <i class="fa fa-info-circle mr-1"></i>
                An email will be sent to you with instructions on how to reset your password.
            </div>

            <form method="POST" action="includes/reset-request.inc.php">
                <div class="el-field-group">
                    <label for="user_email">Registered Email</label>
                    <input type="text" name="user_email" id="user_email" placeholder="you@example.com" required>
                </div>
                <button name="reset-req-submit" type="submit" class="el-btn el-btn-primary el-btn-block">
                    Send reset link <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>