<?php
$title = "Properties";
$page = "Add";
$mainPage = "Properties";
require_once "components/header.php";
require_once "backend/add-property.php"; ?>

<div class="col-md-12">
    <div class="card">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-header">
                <div class="card-title">Add Property Details</div>
            </div>
            <div class="card-body">
                <div id="formErrors" class="alert alert-danger d-none"></div>
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <!-- Property Title -->
                        <div class="form-group">
                            <label for="title">Property Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter property title" required>
                        </div>

                        <!-- Bedrooms -->
                        <div class="form-group">
                            <label for="bedrooms">Bedrooms</label>
                            <input type="number" name="bedrooms" id="bedrooms" class="form-control" placeholder="Number of bedrooms" required>
                        </div>

                        <!-- Location -->
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="Enter location" required>
                        </div>

                        <!-- Rent Price -->
                        <div class="form-group">
                            <label for="rent_price">Rent Price ($)</label>
                            <input type="number" name="rent_price" id="rent_price" class="form-control" placeholder="Enter rent price" required step="0.01">
                        </div>

                        <!-- Property Description -->
                        <div class="form-group">
                            <label for="description">Property Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter property description" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <!-- Property Category -->
                        <div class="form-group">
                            <label for="category">Property Category</label>
                            <select name="category_id" id="category" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo htmlspecialchars($cat['id']); ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Bathrooms -->
                        <div class="form-group">
                            <label for="bathrooms">Bathrooms</label>
                            <input type="number" name="bathrooms" id="bathrooms" class="form-control" placeholder="Number of bathrooms" required>
                        </div>

                        <!-- Area -->
                        <div class="form-group">
                            <label for="area">Area (sqft)</label>
                            <input type="number" name="area" id="area" class="form-control" placeholder="Property area in square feet" required>
                        </div>

                        <!-- Old Price -->
                        <div class="form-group">
                            <label for="old_price">Old Price ($) <small>(optional)</small></label>
                            <input type="number" name="old_price" id="old_price" class="form-control" placeholder="Enter old price" step="0.01">
                        </div>
                        <!-- Property Main Image -->
                        <!-- <div class="form-group">
                            <label for="image">Property Main Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" <?php echo (isset($property['image_url']) ? '' : 'required'); ?>>
                        </div> -->

                        <!-- Property Images -->
                        <!-- <div class="form-group">
                            <label for="images">Property Images</label>
                            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple required>
                        </div> -->

                        <!-- Main Image -->
                        <div class="form-group">
                            <label for="image">Property Main Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                        </div>
                        <!-- Gallery Images -->
                        <div class="form-group">
                            <label for="gallery">Property Gallery Images <small>(optional)</small></label>
                            <input type="file" name="gallery[]" id="gallery" class="form-control" accept="image/*" multiple>
                        </div>
                    </div>

                    <!-- Amenities Section (Optional) -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label d-block">Select Amenities</label>
                            <div class="selectgroup selectgroup-secondary selectgroup-pills">
                                <?php foreach ($amenities as $amenity): ?>
                                    <label class="selectgroup-item">
                                        <input type="checkbox" name="amenities[]" value="<?php echo htmlspecialchars($amenity['id']); ?>" class="selectgroup-input" />
                                        <span class="selectgroup-button">
                                            <?php echo htmlspecialchars($amenity['name']); ?>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Add Property</button>
                <button type="button" class="btn btn-danger" onclick="window.location.href='all-properties.php';">Cancel</button>
            </div>
        </form>
    </div>
</div>



<?php require_once "components/footer.php"; ?>