<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php
if (isset($_GET['err']) || isset($_GET['pwd'])) {
    if (isset($_GET['err']) && $_GET['err'] === 'pwdnotmatch') {
        echo '<script>alert("Passwords do not match");</script>';
    } else if (isset($_GET['err']) && $_GET['err'] === 'sqlerr') {
        echo '<script>alert("An error occured");</script>';
    } else if (isset($_GET['pwd']) && $_GET['pwd'] === 'updated') {
        echo '<script>alert("Your password has been updated");</script>';
    }
    exit();
}
?>

<div class="el-page">
    <div class="el-container" style="max-width:480px;">
        <div class="el-card">
            <div class="el-page-title" style="font-size:26px;">Set a New Password</div>
            <p class="el-page-sub">Choose a strong password for your account.</p>
            <?php
            $selector = isset($_GET['selector']) ? $_GET['selector'] : '';
            $validator = isset($_GET['validator']) ? $_GET['validator'] : '';
            if (empty($selector) || empty($validator)) {
                echo '<p class="text-center" style="color:var(--coral);">Could not validate your request.</p>';
            } else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>
                    <form method="POST" action="includes/reset-password.inc.php">
                        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                        <div class="el-field-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password"
                                placeholder="Enter password"
                                required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                        </div>
                        <div class="el-field-group">
                            <label for="password_repeat">Confirm Password</label>
                            <input type="password" name="password_repeat" id="password_repeat"
                                placeholder="Confirm password" required>
                        </div>
                        <button name="new-pwd-submit" type="submit" class="el-btn el-btn-primary el-btn-block">
                            Update password
                        </button>
                    </form>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>