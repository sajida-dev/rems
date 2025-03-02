<?php
$title = "Property";
$page = "View";
$mainPage = "Property";
require_once "components/header.php";
require_once "backend/detail-property.php";
?>
<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Include Bootstrap CSS (optional) -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .property-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 20px auto;
        background: #fff;
    }

    .property-image {
        width: 100%;
        height: 300px;
        background-size: cover;
        background-position: center;
        overflow: hidden;
    }

    .property-details {
        padding: 20px;
    }

    .property-details h2 {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .property-location,
    .property-price {
        font-size: 16px;
        margin: 5px 0;
        color: #555;
    }

    .property-description {
        margin: 15px 0;
    }

    .property-features span {
        display: inline-block;
        margin-right: 15px;
        font-size: 14px;
        color: #666;
    }

    .property-features span i {
        margin-right: 5px;
        color: #007bff;
    }

    .property-amenities h5 {
        margin-top: 20px;
        font-size: 18px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }

    .property-amenities ul {
        list-style: none;
        padding-left: 0;
        margin: 10px 0;
    }

    .property-amenities ul li {
        display: inline-block;
        margin-right: 10px;
        background: #f0f0f0;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
    }

    .property-gallery h5 {
        margin-top: 20px;
        font-size: 18px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }

    .gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .gallery-item {
        width: calc(33.333% - 10px);
        height: 150px;
        overflow: hidden;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="fw-mediumbold"><?php echo htmlspecialchars($property['title']); ?></h5>
        </div>
        <div class="card-body">
            <div>
                <div class="property-details">
                    <h2><?php echo htmlspecialchars($property['title']); ?></h2>
                    <p class="property-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($property['location']); ?></p>
                    <p class="property-price">$<?php echo number_format($property['rent_price'], 2); ?> / mo</p>
                    <div class="property-features">
                        <span><i class="fas fa-bed"></i> <?php echo htmlspecialchars($property['bedrooms']); ?> Bedrooms</span>
                        <span><i class="fas fa-bath"></i> <?php echo htmlspecialchars($property['bathrooms']); ?> Bathrooms</span>
                        <span><i class="fas fa-ruler-combined"></i> <?php echo htmlspecialchars($property['area']); ?> sqft</span>
                    </div>
                    <div class="property-description">
                        <p><?php echo htmlspecialchars($property['description']); ?></p>
                    </div>
                    <?php if (!empty($amenityList)): ?>
                        <div class="property-amenities">
                            <h5>Amenities</h5>
                            <ul>
                                <?php foreach ($amenityList as $amenity): ?>
                                    <li><?php echo htmlspecialchars($amenity); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($galleryImages)): ?>
                        <div class="property-gallery">
                            <h5>Gallery</h5>
                            <div class="gallery">
                                <?php foreach ($galleryImages as $img): ?>
                                    <div class="gallery-item">
                                        <img src="<?php echo htmlspecialchars($img['image_url']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "components/footer.php"; ?>
<!-- Optional: include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>