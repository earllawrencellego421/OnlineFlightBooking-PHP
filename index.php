<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php');
require 'helpers/init_conn_db.php';
?>
<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'sameval') {
        echo '<script>alert("Select different value for departure city and arrival city")</script>';
    } else if ($_GET['error'] === 'seldep') {
        echo '<script>alert("Select Departure city")</script>';
    } else if ($_GET['error'] === 'selarr') {
        echo "<script>alert('Select Arrival city')</script>";
    }
}
?>

<section class="el-hero">
    <div class="el-container">
        <h1 class="el-hero-title">Fly every island, one booking at a time.</h1>
        <p class="el-hero-sub">Search domestic routes across the Philippines &mdash; real fares, real seats.</p>

        <div class="el-search-card">
            <div class="el-tab-row">
                <button type="button" class="el-tab-btn active" data-el-tab-target="panel-round">Round Trip</button>
                <button type="button" class="el-tab-btn" data-el-tab-target="panel-oneway">One Way</button>
            </div>

            <!-- ROUND TRIP -->
            <div class="el-search-panel active" id="panel-round">
                <form action="book_flight.php" method="post">
                    <input type="hidden" name="type" value="round">
                    <div class="el-field-grid cols-5">
                        <div class="el-field">
                            <label for="dep_city_r">From</label>
                            <select name="dep_city" id="dep_city_r" required>
                                <option value="0" selected disabled>Departure</option>
                                <?php
                                $sql = 'SELECT * FROM Cities';
                                $stmt = mysqli_stmt_init($conn);
                                mysqli_stmt_prepare($stmt, $sql);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . htmlspecialchars($row['city']) . '">' . htmlspecialchars($row['city']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="el-field">
                            <label for="arr_city_r">To</label>
                            <select name="arr_city" id="arr_city_r" required>
                                <option value="0" selected disabled>Arrival</option>
                                <?php
                                $sql = 'SELECT * FROM Cities';
                                $stmt = mysqli_stmt_init($conn);
                                mysqli_stmt_prepare($stmt, $sql);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . htmlspecialchars($row['city']) . '">' . htmlspecialchars($row['city']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="el-field">
                            <label for="dep_date_r">Depart</label>
                            <input type="date" name="dep_date" id="dep_date_r" required>
                        </div>
                        <div class="el-field">
                            <label for="ret_date_r">Return</label>
                            <input type="date" name="ret_date" id="ret_date_r" required>
                        </div>
                        <div class="el-field">
                            <label for="f_class_r">Class</label>
                            <select name="f_class" id="f_class_r">
                                <option value="E">Economy</option>
                                <option value="B">Business</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:16px;">
                        <div>
                            <label class="d-block mb-2" style="font-size:11.5px;text-transform:uppercase;letter-spacing:1px;font-weight:700;color:rgba(255,255,255,0.65);">Passengers</label>
                            <div class="el-stepper">
                                <button type="button" class="el-stepper-minus">&minus;</button>
                                <span class="el-stepper-value">1</span>
                                <button type="button" class="el-stepper-plus">&plus;</button>
                                <input type="hidden" name="passengers" value="1">
                            </div>
                        </div>
                        <button type="submit" name="search_but" class="el-search-submit">
                            Search Flights <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- ONE WAY -->
            <div class="el-search-panel" id="panel-oneway">
                <form action="book_flight.php" method="post">
                    <input type="hidden" name="type" value="one">
                    <input type="hidden" name="ret_date" value="">
                    <div class="el-field-grid">
                        <div class="el-field">
                            <label for="dep_city_o">From</label>
                            <select name="dep_city" id="dep_city_o" required>
                                <option selected disabled>Departure</option>
                                <?php
                                $sql = 'SELECT * FROM Cities';
                                $stmt = mysqli_stmt_init($conn);
                                mysqli_stmt_prepare($stmt, $sql);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . htmlspecialchars($row['city']) . '">' . htmlspecialchars($row['city']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="el-field">
                            <label for="arr_city_o">To</label>
                            <select name="arr_city" id="arr_city_o" required>
                                <option selected disabled>Arrival</option>
                                <?php
                                $sql = 'SELECT * FROM Cities';
                                $stmt = mysqli_stmt_init($conn);
                                mysqli_stmt_prepare($stmt, $sql);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . htmlspecialchars($row['city']) . '">' . htmlspecialchars($row['city']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="el-field">
                            <label for="dep_date_o">Depart</label>
                            <input type="date" name="dep_date" id="dep_date_o" required>
                        </div>
                        <div class="el-field">
                            <label for="f_class_o">Class</label>
                            <select name="f_class" id="f_class_o">
                                <option value="E">Economy</option>
                                <option value="B">Business</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:16px;">
                        <div>
                            <label class="d-block mb-2" style="font-size:11.5px;text-transform:uppercase;letter-spacing:1px;font-weight:700;color:rgba(255,255,255,0.65);">Passengers</label>
                            <div class="el-stepper">
                                <button type="button" class="el-stepper-minus">&minus;</button>
                                <span class="el-stepper-value">1</span>
                                <button type="button" class="el-stepper-plus">&plus;</button>
                                <input type="hidden" name="passengers" value="1">
                            </div>
                        </div>
                        <button type="submit" name="search_but" class="el-search-submit">
                            Search Flights <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="el-perks">
    <div class="el-container el-perk-grid">
        <div class="el-perk">
            <img src="assets/images/beach.svg" alt="">
            <div>
                <div class="el-perk-title">Top Destinations</div>
                <p>What's on your travel bucket list? From Palawan's lagoons to Siargao's waves.</p>
            </div>
        </div>
        <div class="el-perk">
            <img src="assets/images/wallet.svg" alt="">
            <div>
                <div class="el-perk-title">The Best Prices</div>
                <p>Visit your favorite islands at a fare that makes sense.</p>
            </div>
        </div>
        <div class="el-perk">
            <img src="assets/images/suitcase.svg" alt="">
            <div>
                <div class="el-perk-title">Amazing Service</div>
                <p>Great trips begin with knowing what our passengers need.</p>
            </div>
        </div>
    </div>
</section>

<?php subview('footer.php'); ?>