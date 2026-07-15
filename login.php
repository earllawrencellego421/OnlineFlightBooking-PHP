<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php
if (isset($_GET['pwd'])) {
    if ($_GET['pwd'] == 'updated') {
        echo "<script>alert('Your password has been reset!!');</script>";
    }
}
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'invalidcred') {
        echo '<script>alert("Invalid Credentials")</script>';
    } else if ($_GET['error'] === 'wrongpwd') {
        echo '<script>alert("Wrong Password")</script>';
    } else if ($_GET['error'] === 'sqlerror') {
        echo "<script>alert('Database error')</script>";
    }
}
// Legacy "remember me" cookie check — kept as-is from the original build.
// Uname/Upwd cookies are never actually set anywhere in this codebase,
// so this block is a no-op safeguard rather than active behavior.
if (isset($_COOKIE['Uname']) && isset($_COOKIE['Upwd'])) {
    require 'helpers/init_conn_db.php';
    $email_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $password = isset($_POST['user_pass']) ? $_POST['user_pass'] : '';
    $sql = 'SELECT * FROM Users WHERE username=? OR email=?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: login.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'ss', $_COOKIE['Uname'], $_COOKIE['Uname']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $pwd_check = password_verify($_COOKIE['Upwd'], $row['password']);
            if ($pwd_check == false) {
                setcookie('Uname', '', time() - 3600);
                setcookie('Upwd', '', time() - 3600);
                header('Location: login.php?error=wrongpwd');
                exit();
            } else if ($pwd_check == true) {
                session_start();
                $_SESSION['userId'] = $row['user_id'];
                $_SESSION['userUid'] = $row['username'];
                $_SESSION['userMail'] = $row['email'];
                header('Location: index.php?login=success');
                exit();
            } else {
                header('Location: login.php?error=invalidcred');
                exit();
            }
        }
        header('Location: login.php?error=invalidcred');
        exit();
    }
    header('Location: login.php?error=invalidcred');
    exit();
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<div class="el-page">
    <div class="el-container" style="max-width:480px;">
        <div class="el-card">
            <div class="el-page-title" style="font-size:26px;">Passenger Sign In</div>
            <p class="el-page-sub">Log in to book flights and manage your tickets.</p>

            <form method="POST" action="includes/login.inc.php">
                <div class="el-field-group">
                    <label for="user_id">Username / Email</label>
                    <input type="text" name="user_id" id="user_id" required>
                </div>
                <div class="el-field-group">
                    <label for="user_pass">Password</label>
                    <input type="password" name="user_pass" id="user_pass" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="register.php" class="el-link">Create an account</a>
                    <a href="reset-pwd.php" class="el-link">Forgot password?</a>
                </div>

                <button name="login_but" type="submit" class="el-btn el-btn-primary el-btn-block">
                    Sign in <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>