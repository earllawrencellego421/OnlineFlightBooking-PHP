<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php if (isset($_SESSION['userId'])) { ?>

<div class="el-page">
    <div class="el-container" style="max-width:460px;">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] === 'sqlerror') {
                echo "<script>alert('Database error')</script>";
            } else if ($_GET['error'] === 'noret') {
                echo "<script>alert('No return flight available')</script>";
            } else if ($_GET['error'] === 'mailerr') {
                echo "<script>alert('Mail error')</script>";
            }
        }
        ?>
        <div class="el-page-title" style="font-size:26px;">Pay Invoice</div>
        <p class="el-page-sub">Secure checkout for your Earlines booking.</p>

        <div class="el-card">
            <label class="d-block mb-2" style="font-size:12px;text-transform:uppercase;letter-spacing:1px;font-weight:700;color:var(--slate);">Accepted Cards</label>
            <div class="mb-3">
                <i class="fa fa-cc-visa fa-2x mr-2" style="color:navy;"></i>
                <i class="fa fa-cc-amex fa-2x mr-2" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard fa-2x mr-2" style="color:red;"></i>
                <i class="fa fa-cc-discover fa-2x mr-2" style="color:orange;"></i>
                <i class="fa fa-cc-stripe fa-2x" style="color:blue;"></i>
            </div>
            <hr>
            <form id="el-payment-form" action="includes/payment.inc.php" method="post" novalidate>
                <div class="el-field-group">
                    <label for="cc-number">Card number</label>
                    <input id="cc-number" name="cc-number" type="tel" required autocomplete="off">
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="el-field-group">
                            <label for="cc-exp">Expiration</label>
                            <input id="cc-exp" name="cc-exp" type="tel" placeholder="MM / YY" required autocomplete="cc-exp">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="el-field-group">
                            <label for="x_card_code">CVV</label>
                            <input id="x_card_code" name="x_card_code" type="password" required autocomplete="off">
                        </div>
                    </div>
                </div>

                <button id="payment-button" type="submit" name="pay_but" class="el-btn el-btn-primary el-btn-block mt-2">
                    <i class="fa fa-lock"></i> <span id="payment-button-amount">Pay</span>
                    <span id="payment-button-sending" style="display:none;">Sending&hellip;</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('el-payment-form');
    form.addEventListener('submit', function (e) {
        var cvv = document.getElementById('x_card_code').value;
        var cardNo = document.getElementById('cc-number').value;
        var exp = document.getElementById('cc-exp').value.split('/');
        var regCVV = /^[0-9]{3,4}$/;
        var regCardNo = /^[0-9]{12,16}$/;
        var regMonth = /^(0[1-9]|1[0-2])$/;
        var regYear = /^\d{2}$/;

        if (!regCardNo.test(cardNo.replace(/\s/g, ''))) {
            e.preventDefault();
            document.getElementById('cc-number').focus();
            alert('Enter a valid 12 to 16 digit card number');
            return;
        }
        if (!regCVV.test(cvv)) {
            e.preventDefault();
            document.getElementById('x_card_code').focus();
            alert('Enter a valid CVV');
            return;
        }
        var month = exp[0] ? exp[0].trim() : '';
        var year = exp[1] ? exp[1].trim() : '';
        if (!regMonth.test(month) || !regYear.test(year)) {
            e.preventDefault();
            document.getElementById('cc-exp').focus();
            alert('Enter a valid expiration date (MM / YY)');
            return;
        }
    });
});
</script>

<?php subview('footer.php'); ?>
<?php } ?>