<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'invdate') {
        echo '<script>alert("Invalid date of birth")</script>';
    } else if ($_GET['error'] === 'moblen') {
        echo '<script>alert("Invalid contact info")</script>';
    } else if ($_GET['error'] === 'sqlerror') {
        echo "<script>alert('Database error')</script>";
    }
}
?>
<?php if (isset($_SESSION['userId']) && isset($_POST['book_but'])) {
    $flight_id = $_POST['flight_id'];
    $passengers = $_POST['passengers'];
    $price = $_POST['price'];
    $class = $_POST['class'];
    $type = $_POST['type'];
    $ret_date = $_POST['ret_date'];
    ?>

<div class="el-page">
    <div class="el-container" style="max-width:760px;">
        <div class="el-page-title">Passenger Details</div>
        <p class="el-page-sub">Fill in details for each traveler on this booking.</p>

        <form action="includes/pass_detail.inc.php" method="POST">
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
            <input type="hidden" name="ret_date" value="<?php echo htmlspecialchars($ret_date); ?>">
            <input type="hidden" name="class" value="<?php echo htmlspecialchars($class); ?>">
            <input type="hidden" name="passengers" value="<?php echo htmlspecialchars($passengers); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
            <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($flight_id); ?>">

            <?php for ($i = 1; $i <= $passengers; $i++) { ?>
            <div class="el-card mb-3">
                <p class="el-page-sub" style="margin-bottom:16px;text-align:left;">Passenger <?php echo $i; ?></p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="el-field-group">
                            <label for="firstname<?php echo $i; ?>">Firstname</label>
                            <input type="text" name="firstname[]" id="firstname<?php echo $i; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="el-field-group">
                            <label for="midname<?php echo $i; ?>">Middlename</label>
                            <input type="text" name="midname[]" id="midname<?php echo $i; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="el-field-group">
                            <label for="lastname<?php echo $i; ?>">Lastname</label>
                            <input type="text" name="lastname[]" id="lastname<?php echo $i; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="el-field-group">
                            <label for="mobile<?php echo $i; ?>">Contact No.</label>
                            <input type="tel" name="mobile[]" id="mobile<?php echo $i; ?>"
                                inputmode="numeric" pattern="[0-9]{11}" maxlength="11"
                                placeholder="09XXXXXXXXX" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="el-field-group">
                            <label for="date<?php echo $i; ?>">Date of Birth</label>
                            <input type="date" name="date[]" id="date<?php echo $i; ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <button name="pass_but" type="submit" class="el-btn el-btn-primary el-btn-block">
                Proceed to payment <i class="fa fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<?php subview('footer.php'); ?>
<?php } ?>