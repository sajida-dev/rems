<?php
$title = "Request Services | Hire Now";
include_once("components/header.php");
require_once "backend/get_categories.php";
require_once "backend/save-hiring-request.php";
?>

<style>
    .request-form {
        max-width: 600px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: 600;
    }
</style>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Request Services <i class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-3 bread"> Hire Agent</h1>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="request-form">
        <h3 class="mb-4 text-center">Request Agent Services</h3>
        <form action="" method="POST">
            <!-- Request Type -->
            <div class="form-group">
                <label for="transaction_type" class="form-label">I Want To</label>
                <select name="transaction_type" id="transaction_type" class="form-control" required>
                    <option value="">Select Transaction</option>
                    <option value="rent">Rent a Property</option>
                    <option value="buy">Buy a Property</option>
                    <option value="sell">Sell a Property</option>
                </select>
            </div>

            <!-- Property Details -->
            <div class="form-group">
                <label for="property_category" class="form-label">Property Category</label>
                <select name="property_category" id="property_category" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id'] ?>"><?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="location" class="form-label">Preferred Location</label>
                <input type="text" name="location" id="location" class="form-control" placeholder="e.g., Downtown">
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="min_budget" class="form-label">Min Budget ($)</label>
                        <input type="number" name="min_budget" id="min_budget" class="form-control" placeholder="0">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="max_budget" class="form-label">Max Budget ($)</label>
                        <input type="number" name="max_budget" id="max_budget" class="form-control" placeholder="500000">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="bedrooms" class="form-label">Bedrooms</label>
                <select name="bedrooms" id="bedrooms" class="form-control">
                    <option value="">Any</option>
                    <option value="1">1+</option>
                    <option value="2">2+</option>
                    <option value="3">3+</option>
                    <option value="4">4+</option>
                </select>
            </div>

            <!-- Additional Requirements -->
            <div class="form-group">
                <label for="requirements" class="form-label">Additional Requirements</label>
                <textarea name="requirements" id="requirements" class="form-control" rows="4" placeholder="Describe your requirements (e.g., property features, preferred neighborhood, etc.)" required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
        </form>
    </div>
</div>


<?php include_once "components/footer.php" ?>