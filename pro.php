<?php
require_once("components/db_connection.php");
require_once "backend/filter.php";
require_once "backend/get_amenities.php";
require_once "backend/get_categories.php";
require_once("components/header.php"); ?>
<style>
    .form-control-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
        height: calc(1.5em + 0.5rem + 2px) !important;
    }
</style>
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

            <div class="col-md-3">
                <h4>Filter Properties</h4>
                <form id="filter-form" action="" method="POST">
                    <div class="form-group mb-3">
                        <label for="search" class="small">Keyword</label>
                        <input type="text" name="search" id="search" class="form-control form-control-sm" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="e.g., Downtown, 3BHK">
                    </div>

                    <!-- Category Dropdown -->
                    <div class="form-group mb-3">
                        <label for="category" class="small">Category</label>
                        <select name="category_id" id="category" class="form-control form-control-sm">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['id']); ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Location Input -->
                    <div class="form-group mb-3">
                        <label for="location" class="small">Location</label>
                        <input type="text" name="location" id="location" class="form-control form-control-sm" placeholder="Enter location">
                    </div>

                    <!-- Price Range -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="min_price" class="small">Min Price($)</label>
                                <input type="number" name="min_price" id="min_price" class="form-control form-control-sm" placeholder="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="max_price" class="small">Max Price($)</label>
                                <input type="number" name="max_price" id="max_price" class="form-control form-control-sm" placeholder="500000">
                            </div>
                        </div>
                    </div>

                    <!-- Bedrooms -->
                    <div class="form-group mb-3">
                        <label for="bedrooms" class="small">Bedrooms</label>
                        <select name="bedrooms" id="bedrooms" class="form-control form-control-sm">
                            <option value="">Any</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                        </select>
                    </div>

                    <!-- Amenities (Checkbox Group) -->
                    <div class="form-group mb-3">
                        <label class="small">Amenities</label>
                        <div class="d-flex flex-wrap">
                            <?php foreach ($amenities as $amenity): ?>
                                <div class="form-check mr-2">
                                    <input class="form-check-input form-check-input-sm" type="checkbox" name="amenities[]" value="<?php echo htmlspecialchars($amenity['id']); ?>" id="amenity-<?php echo htmlspecialchars($amenity['id']); ?>">
                                    <label class="form-check-label small" for="amenity-<?php echo htmlspecialchars($amenity['id']); ?>">
                                        <?php echo htmlspecialchars($amenity['name']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                    <!-- Submit Button -->
                    <button type="submit" name="filter" class="btn btn-primary btn-sm">Apply Filters</button>
                </form>
            </div>


            <!-- side filter  -->

            <!-- Properties Listing -->
            <div class="col-md-9">
                <div id="properties-listing">
                    <?php
                    $col = 6;
                    $message = true;
                    // require_once("backend/filter_properties.php");
                    require_once "properties-listing.php";
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once("components/footer.php"); ?>

<script src="js/jquery.min.js"></script>
<script>
    // $(document).ready(function() {
    //     $('#filter-form input[type="text"]').on('keyup', function() {
    //         updateProperties();
    //     });
    //     $('#filter-form input[type="number"], #filter-form select, #filter-form input[type="checkbox"]').on('change', function() {
    //         updateProperties();
    //     });

    //     function updateProperties() {
    //         var formData = $('#filter-form').serialize();
    //         $.ajax({
    //             url: '',
    //             type: 'POST',
    //             data: formData,
    //             dataType: 'html',
    //             success: function(response) {
    //                 console.log("AJAX Response:", response);
    //                 // document.getElementById("properties-listing").innerHTML = response;
    //                 // $('#properties-listing').html("<p>testing response filter properties</p>" + response);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("Error: " + error);
    //             }
    //         });
    //     }
    // });
</script>