<?php
$title = "Property";
$page = "Update";
$mainPage = "Property";
require_once "components/header.php";
require_once "backend/edit-property.php";
?>
<style>
    .imagecheck-figure {
        width: 200px;
        height: 200px;
        overflow: hidden;
        margin: 0;
        border: 1px solid grey;
    }
</style>
<div class="col-md-12">
    <div class="card">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="card-header">
                <div class="card-title">Update Property Details</div>
            </div>
            <div class="card-body">
                <div id="formErrors" class="alert alert-danger d-none"></div>
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <!-- Property Title -->
                        <div class="form-group">
                            <label for="title">Property Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter property title" required
                                value="<?php echo htmlspecialchars($property['title'] ?? ''); ?>">
                        </div>
                        <!-- Bedrooms -->
                        <div class="form-group">
                            <label for="bedrooms">Bedrooms</label>
                            <input type="number" name="bedrooms" id="bedrooms" class="form-control" placeholder="Number of bedrooms" required
                                value="<?php echo htmlspecialchars($property['bedrooms'] ?? ''); ?>">
                        </div>
                        <!-- Location -->
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="Enter location" required
                                value="<?php echo htmlspecialchars($property['location'] ?? ''); ?>">
                        </div>
                        <!-- Rent Price -->
                        <div class="form-group">
                            <label for="rent_price">Rent Price ($)</label>
                            <input type="number" name="rent_price" id="rent_price" class="form-control" placeholder="Enter rent price" required step="0.01"
                                value="<?php echo htmlspecialchars($property['rent_price'] ?? ''); ?>">
                        </div>

                        <!-- Property Description -->
                        <div class="form-group">
                            <label for="description">Property Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter property description" required><?php echo htmlspecialchars($property['description'] ?? ''); ?></textarea>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <!-- Property Category -->
                        <div class="form-group">
                            <label for="category">Property Category</label>
                            <select name="category_id" id="category" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat):
                                    $select = ($property['category_id'] == $cat['id']) ? "selected" : "";
                                ?>
                                    <option <?php echo $select; ?> value="<?php echo htmlspecialchars($cat['id']); ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Bathrooms -->
                        <div class="form-group">
                            <label for="bathrooms">Bathrooms</label>
                            <input type="number" name="bathrooms" id="bathrooms" class="form-control" placeholder="Number of bathrooms" required
                                value="<?php echo htmlspecialchars($property['bathrooms'] ?? ''); ?>">
                        </div>

                        <!-- Area -->
                        <div class="form-group">
                            <label for="area">Area (sqft)</label>
                            <input type="number" name="area" id="area" class="form-control" placeholder="Property area in square feet" required
                                value="<?php echo htmlspecialchars($property['area'] ?? ''); ?>">
                        </div>
                        <!-- Old Price -->
                        <div class="form-group">
                            <label for="old_price">Old Price ($) <small>(optional)</small></label>
                            <input type="number" name="old_price" id="old_price" class="form-control" placeholder="Enter old price" step="0.01"
                                value="<?php echo htmlspecialchars($property['old_price'] ?? ''); ?>">
                        </div>
                        <!-- Property Images -->
                        <div class="form-group">
                            <label for="images">Property Images <small>(select new images to update)</small></label>
                            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
                        </div>
                        <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($property['id'] ?? ''); ?>">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-label d-block">Select Amenities</label>
                                <div class="selectgroup selectgroup-secondary selectgroup-pills">
                                    <?php foreach ($amenities as $amenity): ?>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="amenities[]" value="<?php echo htmlspecialchars($amenity['id']); ?>" class="selectgroup-input" <?php echo (in_array($amenity['id'], $selectedAmenitiesIds)) ? 'checked' : ''; ?>>
                                            <span class="selectgroup-button">
                                                <?php echo htmlspecialchars($amenity['name']); ?>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Property Images</label>
                        <div class="row">
                            <?php if (!empty($images)): ?>
                                <?php foreach ($images as $img): ?>
                                    <div class="col-6 col-sm-4 col-lg-3 border-2">
                                        <label class="imagecheck mb-4">
                                            <input name="delete_images[]" type="checkbox" value="<?php echo htmlspecialchars($img['id']); ?>" class="imagecheck-input">
                                            <figure class="imagecheck-figure">
                                                <img src="<?php echo htmlspecialchars($img['image_url']); ?>" alt="Property Image" class="imagecheck-image">
                                            </figure>
                                        </label>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No images available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-action">
                <button type="submit" id="deleteSelected" class="btn btn-danger" style="display: none;">Delete Selected Images</button>
                <button type="submit" class="btn btn-success">Update Property</button>
                <button type="button" class="btn btn-danger" onclick="window.location.href='all-properties.php';">Cancel</button>
            </div>
        </form>
    </div>
</div>
<?php require_once "components/footer.php"; ?>


<script>
    $(document).ready(function() {
        $('input.imagecheck-input').on('change', function() {
            if ($('input.imagecheck-input:checked').length > 0) {
                $('#deleteSelected').show();
            } else {
                $('#deleteSelected').hide();
            }
        });
    });
</script>