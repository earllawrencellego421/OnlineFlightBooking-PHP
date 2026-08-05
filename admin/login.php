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

<style>
    /* Admin Login Specific Styles to guarantee a perfect layout */
    .auth-wrap {
        display: flex;
        min-height: 100vh;
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        background: #F5F7FB;
        margin: -20px; /* Offsets default body margins if any exist in header.php */
    }
    .auth-visual {
        flex: 1;
        background: linear-gradient(135deg, #082B66 0%, #0B3D91 100%);
        color: white;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .auth-visual h2 {
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 700;
        margin-bottom: 20px;
        z-index: 2;
        line-height: 1.2;
    }
    .auth-visual p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.85);
        max-width: 440px;
        line-height: 1.6;
        z-index: 2;
    }
    .plane-path {
        position: absolute;
        top: 15%;
        left: -10%;
        width: 120%;
        height: auto;
        opacity: 0.6;
        z-index: 1;
        pointer-events: none;
    }
    .auth-form-side {
        width: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        padding: 40px;
        box-shadow: -10px 0 30px rgba(8, 43, 102, 0.08);
        z-index: 3;
    }
    .auth-card {
        width: 100%;
        max-width: 360px;
    }
    .brand-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 40px;
        color: #0B3D91;
        font-size: 24px;
        font-weight: bold;
    }
    .brand-mark {
        background: #FFD100;
        color: #082B66;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 20px;
    }
    .auth-card h1 {
        font-size: 28px;
        color: #122446;
        margin: 0 0 8px 0;
        font-weight: 700;
    }
    .auth-sub {
        color: #6B7690;
        font-size: 14.5px;
        margin-bottom: 30px;
    }
    .auth-field {
        margin-bottom: 20px;
    }
    .auth-field label {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #6B7690;
        margin-bottom: 8px;
    }
    .auth-field input {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid #E4E8F0;
        border-radius: 10px;
        font-size: 15px;
        color: #122446;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .auth-field input:focus {
        outline: none;
        border-color: #0B3D91;
        box-shadow: 0 0 0 3px rgba(11, 61, 145, 0.12);
    }
    .auth-submit {
        width: 100%;
        background: #FFD100;
        color: #082B66;
        border: none;
        padding: 15px;
        font-size: 16px;
        font-weight: 700;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        box-shadow: 0 4px 14px rgba(255, 209, 0, 0.3);
    }
    .auth-submit:hover {
        background: #F0B90B;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(240, 185, 11, 0.4);
    }
    .auth-back {
        display: inline-block;
        margin-top: 28px;
        color: #0B3D91;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: color 0.2s ease;
    }
    .auth-back:hover {
        color: #FFD100;
        text-decoration: underline;
    }
    
    /* Responsive layout for smaller screens */
    @media (max-width: 900px) {
        .auth-wrap { flex-direction: column; }
        .auth-visual { padding: 40px 20px; flex: none; height: auto; min-height: 280px; text-align: center; align-items: center; }
        .plane-path { display: none; }
        .auth-form-side { width: 100%; padding: 40px 20px; }
    }
</style>

<main class="auth-wrap">
    <section class="auth-visual">
        <svg class="plane-path" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 150 C 120 60, 260 60, 380 20" stroke="rgba(255,255,255,0.25)" stroke-width="2" stroke-dasharray="4 8" stroke-linecap="round"/>
            <g transform="translate(360,10) rotate(-18)">
                <path d="M0 8 L28 0 L34 3 L14 12 L20 22 L14 24 L4 15 L-8 18 L-10 13 L0 8 Z" fill="#FFD100"/>
            </g>
        </svg>
        <h2>Every island, one board.<br>Run your fleet from a single view.</h2>
        <p>Earlines Admin gives your ops team a clear read on today's departures, arrivals, and flagged issues &mdash; built for the pace of the Philippine skies.</p>
    </section>

    <section class="auth-form-side">
        <div class="auth-card">
            <div class="brand-row">
                <span class="brand-mark"><i class="fa fa-paper-plane"></i></span>
                <span class="word">Earlines Ops</span>
            </div>
            <h1>Admin Sign in</h1>
            <p class="auth-sub">Enter your operations credentials to continue.</p>

            <form method="POST" action="../includes/admin/login.inc.php">
                <div class="auth-field">
                    <label for="user_id">Username / Email</label>
                    <input type="text" name="user_id" id="user_id" placeholder="admin@earlines.com" required>
                </div>
                <div class="auth-field">
                    <label for="user_pass">Password</label>
                    <input type="password" name="user_pass" id="user_pass" placeholder="••••••••" required>
                </div>
                <button name="login_but" type="submit" class="auth-submit">
                    Sign in to Dashboard <i class="fa fa-sign-in"></i>
                </button>
            </form>
            
            <a href="../index.php" class="auth-back"><i class="fa fa-arrow-left"></i> Return to Passenger Portal</a>
        </div>
    </section>
</main>

<?php include_once 'footer.php'; ?>