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
    <div class="el-wallpaper"><span></span><span></span><span></span></div>
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

        <div class="el-slideshow">
            <div class="el-slide active">
                <span class="el-slide-icon"><i class="fa fa-building"></i></span>
                <div class="el-slide-body">
                    <div class="el-slide-city">Manila</div>
                    <div class="el-slide-tag">The capital gateway &mdash; every route starts or ends here.</div>
                </div>
                <div class="el-slide-dots">
                    <button class="active" type="button" aria-label="Manila"></button>
                    <button type="button" aria-label="Cebu"></button>
                    <button type="button" aria-label="Palawan"></button>
                    <button type="button" aria-label="Boracay"></button>
                    <button type="button" aria-label="Siargao"></button>
                </div>
            </div>
            <div class="el-slide">
                <span class="el-slide-icon"><i class="fa fa-ship"></i></span>
                <div class="el-slide-body">
                    <div class="el-slide-city">Cebu</div>
                    <div class="el-slide-tag">Island-hop the Visayas from the Queen City of the South.</div>
                </div>
            </div>
            <div class="el-slide">
                <span class="el-slide-icon"><i class="fa fa-tree"></i></span>
                <div class="el-slide-body">
                    <div class="el-slide-city">Palawan</div>
                    <div class="el-slide-tag">Lagoons, limestone cliffs, and the country's last frontier.</div>
                </div>
            </div>
            <div class="el-slide">
                <span class="el-slide-icon"><i class="fa fa-sun-o"></i></span>
                <div class="el-slide-body">
                    <div class="el-slide-city">Boracay</div>
                    <div class="el-slide-tag">White sand, sunset sails, and a fare that won't sink your budget.</div>
                </div>
            </div>
            <div class="el-slide">
                <span class="el-slide-icon"><i class="fa fa-life-ring"></i></span>
                <div class="el-slide-body">
                    <div class="el-slide-city">Siargao</div>
                    <div class="el-slide-tag">Chase the waves &mdash; the surfing capital of the Philippines.</div>
                </div>
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

<section class="el-explore">
    <div class="el-container">
        <div class="el-explore-head">
            <h2 style="font-size:28px;">Explore the Philippines</h2>
            <p>Eight islands, eight landmarks &mdash; swipe or click a city to jump straight there.</p>
        </div>

        <div class="el-dest-hero" id="destHero">
            <div class="el-dest-slide active" style="background-image:url('assets/images/rizal%20park.jpg');">
                <div class="el-dest-slide-scrim"></div>
                <div class="el-dest-slide-content">
                    <div class="el-dest-landmark">Rizal Park &amp; Intramuros</div>
                    <div class="el-dest-city">Manila</div>
                    <p>Walk the 16th-century walled city of Intramuros, then catch the sunset over Manila Bay at Rizal Park.</p>
                    <button type="button" class="el-dest-cta" data-city="Manila">Search flights &rarr;</button>
                </div>
            </div>
            <div class="el-dest-slide" style="background-image:url('assets/images/magellan%20cross.jpg');">
                <div class="el-dest-slide-scrim"></div>
                <div class="el-dest-slide-content">
                    <div class="el-dest-landmark">Magellan's Cross</div>
                    <div class="el-dest-city">Cebu City</div>
                    <p>Planted in 1521, marking where Spanish colonization began &mdash; steps from the Basilica del Santo Ni&ntilde;o.</p>
                    <button type="button" class="el-dest-cta" data-city="Cebu City">Search flights &rarr;</button>
                </div>
            </div>
            <div class="el-dest-slide" style="background-image:url('assets/images/underground%20river%20puerto%20princesa.jpg');">
                <div class="el-dest-slide-scrim"></div>
                <div class="el-dest-slide-content">
                    <div class="el-dest-landmark">Underground River</div>
                    <div class="el-dest-city">Puerto Princesa</div>
                    <p>Paddle a UNESCO World Heritage subterranean river carved through dramatic limestone cliffs.</p>
                    <button type="button" class="el-dest-cta" data-city="Puerto Princesa">Search flights &rarr;</button>
                </div>
            </div>
            <div class="el-dest-slide" style="background-image:url('assets/images/session%20road%20baguio.jpg');">
                <div class="el-dest-slide-scrim"></div>
                <div class="el-dest-slide-content">
                    <div class="el-dest-landmark">Session Road</div>
                    <div class="el-dest-city">Baguio City</div>
                    <p>The Summer Capital's pine-covered streets, cool mountain air, and Burnham Park lake.</p>
                    <button type="button" class="el-dest-cta" data-city="Baguio City">Search flights &rarr;</button>
                </div>
            </div>
            <div class="el-dest-slide" style="background-image:url('assets/images/philippine%20eagle%20center%20davao%20city.jpg');">
                <div class="el-dest-slide-scrim"></div>
                <div class="el-dest-slide-content">
                    <div class="el-dest-landmark">Philippine Eagle Center</div>
                    <div class="el-dest-city">Davao City</div>
                    <p>Come face to face with the critically endangered Philippine Eagle, the nation's proud bird.</p>
                    <button type="button" class="el-dest-cta" data-city="Davao City">Search flights &rarr;</button>
                </div>
            </div>
            <div class="el-dest-slide" style="background-image:url('assets/images/mayon%20volcano%20legazpi%20city.jpg');">
                <div class="el-dest-slide-scrim"></div>
                <div class="el-dest-slide-content">
                    <div class="el-dest-landmark">Mayon Volcano</div>
                    <div class="el-dest-city">Legazpi City</div>
                    <p>The world's most perfectly cone-shaped volcano, rising 2,462 meters over Albay province.</p>
                    <button type="button" class="el-dest-cta" data-city="Legazpi City">Search flights &rarr;</button>
                </div>
            </div>
            <div class="el-dest-slide" style="background-image:url('assets/images/white%20beach%20boracay%20caticlan.jpg');">
                <div class="el-dest-slide-scrim"></div>
                <div class="el-dest-slide-content">
                    <div class="el-dest-landmark">White Beach, Boracay</div>
                    <div class="el-dest-city">Caticlan</div>
                    <p>Gateway to the Philippines' most famous powder-white sand and unforgettable sunset sails.</p>
                    <button type="button" class="el-dest-cta" data-city="Caticlan">Search flights &rarr;</button>
                </div>
            </div>
            <div class="el-dest-slide" style="background-image:url('assets/images/rizal%20boulevard%20dumaguete%20city.jpg');">
                <div class="el-dest-slide-scrim"></div>
                <div class="el-dest-slide-content">
                    <div class="el-dest-landmark">Rizal Boulevard</div>
                    <div class="el-dest-city">Dumaguete City</div>
                    <p>The City of Gentle People's seaside promenade &mdash; minutes from Apo Island's sea turtles.</p>
                    <button type="button" class="el-dest-cta" data-city="Dumaguete City">Search flights &rarr;</button>
                </div>
            </div>

            <button type="button" class="el-dest-nav-arrow prev" aria-label="Previous destination"><i class="fa fa-chevron-left"></i></button>
            <button type="button" class="el-dest-nav-arrow next" aria-label="Next destination"><i class="fa fa-chevron-right"></i></button>
        </div>

        <div class="el-dest-strip">
            <button type="button" class="el-dest-nav-btn active">Manila</button>
            <button type="button" class="el-dest-nav-btn">Cebu City</button>
            <button type="button" class="el-dest-nav-btn">Puerto Princesa</button>
            <button type="button" class="el-dest-nav-btn">Baguio City</button>
            <button type="button" class="el-dest-nav-btn">Davao City</button>
            <button type="button" class="el-dest-nav-btn">Legazpi City</button>
            <button type="button" class="el-dest-nav-btn">Caticlan</button>
            <button type="button" class="el-dest-nav-btn">Dumaguete City</button>
        </div>
    </div>
</section>

<?php subview('footer.php'); ?>