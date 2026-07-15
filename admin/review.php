<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>

<?php if (isset($_SESSION['adminId'])) { ?>

<div class="page-title">Customer Reviews</div>
<p class="page-sub mb-4">What passengers are saying after booking with Earlines.</p>

<div class="review-grid mt-4">
    <?php
    $sql = 'SELECT * FROM feedback ORDER BY feed_id DESC';
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $has_rows = false;
    while ($row = mysqli_fetch_assoc($result)) {
        $has_rows = true;
        $rate = (int) $row['rate'];
        echo '
        <div class="review-card">
            <div class="review-email"><i class="fa fa-user"></i> ' . htmlspecialchars($row['email']) . '</div>
            <div class="review-stars">';
        for ($i = 1; $i <= 5; $i++) {
            $cls = $i <= $rate ? 'fa fa-star checked' : 'fa fa-star';
            echo '<span class="' . $cls . '"></span> ';
        }
        echo '</div>
            <p class="review-q">What was your first impression when you entered the website?</p>
            <p class="review-a">' . htmlspecialchars($row['q1']) . '</p>
            <p class="review-q">How did you first hear about us?</p>
            <p class="review-a">' . htmlspecialchars($row['q2']) . '</p>
            <p class="review-q">Is there anything missing on this page?</p>
            <p class="review-a">' . htmlspecialchars($row['q3']) . '</p>
        </div>
        ';
    }
    if (!$has_rows) {
        echo '<p class="board-empty">No reviews submitted yet.</p>';
    }
    ?>
</div>

<?php } ?>

<?php include_once 'footer.php'; ?>