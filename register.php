<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'invalidemail') {
        echo '<script>alert("Invalid email")</script>';
    } else if ($_GET['error'] === 'pwdnotmatch') {
        echo '<script>alert("Passwords do not match")</script>';
    } else if ($_GET['error'] === 'sqlerror') {
        echo "<script>alert('Database error')</script>";
    } else if ($_GET['error'] === 'usernameexists') {
        echo "<script>alert('Username already exists')</script>";
    } else if ($_GET['error'] === 'emailexists') {
        echo "<script>alert('Email already exists')</script>";
    }
}
?>

<div class="el-page">
    <div class="el-container" style="max-width:640px;">
        <div class="el-card">
            <div class="el-page-title" style="font-size:26px;">Create Your Account</div>
            <p class="el-page-sub">Join Earlines to book and manage flights across the islands.</p>

            <form method="POST" action="includes/register.inc.php">
                <div class="row">
                    <div class="col-md-6">
                        <div class="el-field-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="el-field-group">
                            <label for="email_id">Email</label>
                            <input type="text" name="email_id" id="email_id" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="el-field-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" required
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="el-field-group">
                            <label for="password_repeat">Confirm Password</label>
                            <input type="password" name="password_repeat" id="password_repeat" required>
                        </div>
                    </div>
                </div>

                <button name="signup_submit" type="submit" class="el-btn el-btn-primary el-btn-block mt-2">
                    Complete registration <i class="fa fa-arrow-right"></i>
                </button>

                <p class="text-center mt-3 mb-0" style="color:var(--slate);font-size:13.5px;">
                    Already have an account? <a href="login.php" class="el-link">Sign in</a>
                </p>
            </form>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>