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

// Legacy "remember me" cookie check
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

<style>
    /* Passenger Login Specific Styles */
    .user-auth-wrap {
        display: flex;
        min-height: calc(100vh - 70px); /* Adjusts for navbar if present */
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        background: #F5F7FB;
        margin: -20px; /* Counteracts default padding in some header files */
    }
    .user-auth-visual {
        flex: 1;
        background: url('assets/images/white beach boracay caticlan.jpg') center center / cover no-repeat;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 60px;
    }
    .user-visual-scrim {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(8, 43, 102, 0.95) 0%, rgba(11, 61, 145, 0.4) 50%, transparent 100%);
        z-index: 1;
    }
    .user-visual-content {
        position: relative;
        z-index: 2;
        color: #ffffff;
        max-width: 500px;
    }
    .user-visual-content h2 {
        font-size: clamp(32px, 4vw, 48px);
        font-weight: 700;
        margin: 0 0 15px 0;
        line-height: 1.1;
        font-family: 'Product Sans', 'Segoe UI', sans-serif;
    }
    .user-visual-content h2 em {
        color: #FFD100;
        font-style: normal;
    }
    .user-visual-content p {
        font-size: 17px;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
        margin: 0;
    }
    .user-auth-form-side {
        width: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        padding: 40px;
        box-shadow: -10px 0 30px rgba(8, 43, 102, 0.05);
        z-index: 3;
    }
    .user-auth-card {
        width: 100%;
        max-width: 360px;
    }
    .user-auth-card h1 {
        font-size: 28px;
        color: #122446;
        margin: 0 0 8px 0;
        font-weight: 700;
        font-family: 'Product Sans', 'Segoe UI', sans-serif;
    }
    .user-auth-sub {
        color: #6B7690;
        font-size: 15px;
        margin-bottom: 30px;
    }
    .user-auth-field {
        margin-bottom: 20px;
    }
    .user-auth-field label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #6B7690;
        margin-bottom: 8px;
    }
    .user-auth-field input {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid #E4E8F0;
        border-radius: 12px;
        font-size: 15px;
        color: #122446;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .user-auth-field input:focus {
        outline: none;
        border-color: #0B3D91;
        box-shadow: 0 0 0 3px rgba(11, 61, 145, 0.12);
    }
    .user-auth-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 600;
    }
    .user-auth-links a {
        color: #0B3D91;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .user-auth-links a:hover {
        color: #F0B90B;
        text-decoration: underline;
    }
    .user-auth-submit {
        width: 100%;
        background: #FFD100;
        color: #082B66;
        border: none;
        padding: 15px;
        font-size: 16px;
        font-weight: 700;
        border-radius: 999px; /* Pill shape matching homepage */
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 20px rgba(240, 185, 11, 0.4);
    }
    .user-auth-submit:hover {
        background: #F0B90B;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(240, 185, 11, 0.5);
    }
    
    /* Responsive layout for smaller screens */
    @media (max-width: 900px) {
        .user-auth-wrap { flex-direction: column; }
        .user-auth-visual { padding: 40px 20px; flex: none; height: 300px; justify-content: center; text-align: center; }
        .user-visual-content { margin: 0 auto; }
        .user-auth-form-side { width: 100%; padding: 40px 20px; }
    }
</style>

<main class="user-auth-wrap">
    <section class="user-auth-visual">
        <div class="user-visual-scrim"></div>
        <div class="user-visual-content">
            <h2>Your next island adventure <em>awaits</em>.</h2>
            <p>Log in to securely book flights, manage your itineraries, and easily access your e-tickets across the Philippines.</p>
        </div>
    </section>

    <section class="user-auth-form-side">
        <div class="user-auth-card">
            <h1>Welcome back</h1>
            <p class="user-auth-sub">Sign in to your passenger account.</p>

            <form method="POST" action="includes/login.inc.php">
                <div class="user-auth-field">
                    <label for="user_id">Username / Email</label>
                    <input type="text" name="user_id" id="user_id" placeholder="Enter your username or email" required>
                </div>
                <div class="user-auth-field">
                    <label for="user_pass">Password</label>
                    <input type="password" name="user_pass" id="user_pass" placeholder="••••••••" required>
                </div>

                <div class="user-auth-links">
                    <a href="register.php">Create an account</a>
                    <a href="reset-pwd.php">Forgot password?</a>
                </div>

                <button name="login_but" type="submit" class="user-auth-submit">
                    Sign in <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </section>
</main>

<?php subview('footer.php'); ?>