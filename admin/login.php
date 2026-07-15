<?php include_once 'header.php'; ?>
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
?>
<main class="auth-wrap">
    <section class="auth-visual">
        <svg class="plane-path" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 150 C 120 60, 260 60, 380 20" stroke="rgba(255,255,255,0.35)" stroke-width="2" stroke-dasharray="2 10" stroke-linecap="round"/>
            <g transform="translate(360,10) rotate(-18)">
                <path d="M0 8 L28 0 L34 3 L14 12 L20 22 L14 24 L4 15 L-8 18 L-10 13 L0 8 Z" fill="#E8A33D"/>
            </g>
        </svg>
        <h2>Every island, one board.<br>Run your fleet from a single view.</h2>
        <p>Earlines Admin gives your ops team a clear read on today's departures, arrivals, and flagged issues &mdash; built for the pace of the Philippine skies.</p>
    </section>

    <section class="auth-form-side">
        <div class="auth-card">
            <div class="brand-row">
                <span class="brand-mark"><i class="fa fa-paper-plane"></i></span>
                <span class="word">Earlines</span>
            </div>
            <h1>Admin sign in</h1>
            <p class="auth-sub">Enter your operations credentials to continue.</p>

            <form method="POST" action="../includes/admin/login.inc.php">
                <div class="auth-field">
                    <label for="user_id">Username / Email</label>
                    <input type="text" name="user_id" id="user_id" required>
                </div>
                <div class="auth-field">
                    <label for="user_pass">Password</label>
                    <input type="password" name="user_pass" id="user_pass" required>
                </div>
                <button name="login_but" type="submit" class="auth-submit">
                    Sign in <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </section>
</main>

<?php include_once 'footer.php'; ?>