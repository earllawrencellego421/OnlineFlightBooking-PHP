<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'invalidemail') {
        echo '<script>alert("Invalid email")</script>';
    } else if ($_GET['error'] === 'sqlerror') {
        echo "<script>alert('Database error')</script>";
    } else if ($_GET['error'] === 'success') {
        echo "<script>alert('Thank you for your Feedback')</script>";
    }
}
?>

<div class="el-page">
    <div class="el-container" style="max-width:640px;">
        <div class="el-page-title"><i class="far fa-comment-alt mr-2"></i>Feedback</div>
        <p class="el-page-sub">Tell us about your experience booking with Earlines.</p>

        <div class="el-card">
            <form action="includes/feedback.inc.php" method="POST">
                <div class="el-field-group">
                    <label for="user_id">Email</label>
                    <input type="text" name="email" id="user_id" required>
                </div>

                <div class="el-field-group">
                    <label for="q1">What was your first impression when you entered the website?</label>
                    <textarea id="q1" name="1" rows="3" required></textarea>
                </div>

                <div class="el-field-group">
                    <label for="q2">How did you first hear about us?</label>
                    <select id="q2" name="2" required>
                        <option selected disabled>How did you first hear about us?</option>
                        <option>Search Engine</option>
                        <option>Social Media</option>
                        <option>Friend/Relative</option>
                        <option>Word of Mouth</option>
                        <option>Television</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="el-field-group">
                    <label for="q3">Is there anything missing on this page?</label>
                    <textarea id="q3" name="3" rows="3" required></textarea>
                </div>

                <div class="el-field-group text-center">
                    <label class="d-block mb-2">Rate your experience</label>
                    <div class="el-rating">
                        <input type="radio" id="star5" name="stars" value="5" required><label for="star5" title="5 stars">&#9733;</label>
                        <input type="radio" id="star4" name="stars" value="4" required><label for="star4" title="4 stars">&#9733;</label>
                        <input type="radio" id="star3" name="stars" value="3" required><label for="star3" title="3 stars">&#9733;</label>
                        <input type="radio" id="star2" name="stars" value="2" required><label for="star2" title="2 stars">&#9733;</label>
                        <input type="radio" id="star1" name="stars" value="1" required><label for="star1" title="1 star">&#9733;</label>
                    </div>
                </div>

                <button name="feed_but" type="submit" class="el-btn el-btn-primary el-btn-block mt-2">
                    Submit feedback <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>