<?php
require_once("components/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $_SESSION['search'] = trim($_POST['search']);
}

// Retrieve search term from session (if any)
$search = isset($_SESSION['search']) ? $_SESSION['search'] : '';
?>
<?php require_once("components/header.php"); ?>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Properties <i class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-3 bread">Choose <br>Your Desired Home</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-md-3">
                <h4>Filter Properties</h4>
                <form id="filter-form">
                    <div class="form-group mb-3">
                        <label for="search" class="small">Search</label>
                        <input type="text" name="search" id="search" class="form-control form-control-sm" value="<?php echo htmlspecialchars($search); ?>" placeholder="Location, Price, Area">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="min_price" class="small">Min Price</label>
                                <input type="number" name="min_price" id="min_price" class="form-control form-control-sm" placeholder="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="max_price" class="small">Max Price</label>
                                <input type="number" name="max_price" id="max_price" class="form-control form-control-sm" placeholder="500000">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3 text-d">
                                <label for="bedrooms" class="small">Bedrooms</label>
                                <select name="bedrooms" id="bedrooms" class="form-control form-control-sm">
                                    <option value="">Any</option>
                                    <option value="1">1+</option>
                                    <option value="2">2+</option>
                                    <option value="3">3+</option>
                                    <option value="4">4+</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <!-- side filter  -->

            <!-- Properties Listing -->
            <div class="col-md-9">
                <div id="properties-listing">
                    <?php
                    require_once("backend/filter_properties.php");
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once("components/footer.php"); ?>

<script src="js/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filter-form input[type="text"]').on('keyup', function() {
            updateProperties();
        });
        $('#filter-form input[type="number"], #filter-form select').on('change', function() {
            updateProperties();
        });

        function updateProperties() {
            var formData = $('#filter-form').serialize();
            $.ajax({
                url: 'backend/filter_properties.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log("AJAX Response:", response);
                    document.getElementById("properties-listing").innerHTML = response;
                    // $('#properties-listing').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
        }
    });
</script>