<?php require_once "backend/add-property.php"; ?>

<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">


            <form action="backend/add_property.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Property Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter property title" required>
                </div>
                <div class="form-group">
                    <label for="description">Property Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter property description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Property Category</label>
                    <select name="category_id" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['id']); ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" placeholder="Enter location" required>
                </div>
                <div class="form-group">
                    <label for="rent_price">Rent Price ($)</label>
                    <input type="number" name="rent_price" id="rent_price" class="form-control" placeholder="Enter rent price" required step="0.01">
                </div>
                <div class="form-group">
                    <label for="old_price">Old Price ($) <small>(optional)</small></label>
                    <input type="number" name="old_price" id="old_price" class="form-control" placeholder="Enter old price" step="0.01">
                </div>
                <div class="form-group">
                    <label for="bedrooms">Bedrooms</label>
                    <input type="number" name="bedrooms" id="bedrooms" class="form-control" placeholder="Number of bedrooms" required>
                </div>
                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input type="number" name="bathrooms" id="bathrooms" class="form-control" placeholder="Number of bathrooms" required>
                </div>
                <div class="form-group">
                    <label for="area">Area (sqft)</label>
                    <input type="number" name="area" id="area" class="form-control" placeholder="Property area in square feet" required>
                </div>
                <div class="form-group">
                    <label for="images">Property Images</label>
                    <!-- Allow multiple image uploads -->
                    <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple required>
                </div>
                <!-- Hidden field for agent_id -->
                <input type="hidden" name="agent_id" value="<?php echo $_SESSION['id']; ?>">
                <button type="submit" class="btn btn-primary">Add Property</button>
            </form>
        </div>
    </div>
</div>