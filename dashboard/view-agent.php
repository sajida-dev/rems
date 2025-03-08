<?php
$title = "Agent Profile";
$page = "View";
$mainPage = "Agent";
require_once "components/header.php";
require_once "../backend/single_agent.php";
?>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    body {
        background: #f5f5f5;
    }

    .container {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    /* Agent Card */
    .agent-card {
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .agent-card .card-body {
        display: flex;
        align-items: center;
    }

    .agent-card img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 20px;
    }

    /* Property Cards */
    .property-card {
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .property-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .property-card .card-body {
        padding: 15px;
    }

    .property-card .card-title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .property-card .card-text {
        font-size: 14px;
        color: #555;
    }

    .property-card .amenities {
        margin-top: 10px;
        font-size: 13px;
        color: #777;
    }

    .property-heading {
        border-bottom: 1px solid gray;
        padding-bottom: 5px;
    }
</style>

<div class="container">
    <!-- Agent Information Card -->
    <div class="card agent-card">
        <div class="card-body">
            <div>
                <?php if (!empty($agent['profile_pic'])): ?>
                    <img src="<?php echo htmlspecialchars($agent['profile_pic']); ?>" style="border:1px solid gray" alt="Agent Picture">
                <?php else: ?>
                    <img src="assets/img/default-avatar.png" alt="Default Avatar">
                <?php endif; ?>
            </div>
            <div>
                <h3><?php echo htmlspecialchars($agent['name']); ?></h3>
                <p><strong>Agency:</strong> <?php echo htmlspecialchars($agent['agency']); ?></p>
                <p><strong>Experience:</strong> <?php echo htmlspecialchars($agent['experience']); ?> years</p>
                <p><strong>Contact:</strong> <?php echo htmlspecialchars($agent['contact']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($agent['email']); ?></p>
                <p><strong>Bio:</strong> <?php echo htmlspecialchars($agent['bio']); ?></p>
            </div>

        </div>
    </div>

    <!-- Agent Properties Listing -->
    <div class="card">
        <div class="card-body">
            <h4 class="property-heading">Properties by <?php echo htmlspecialchars($agent['name']); ?></h4>

            <div class="row">
                <?php if (!empty($properties)): ?>

                    <?php foreach ($properties as $property): ?>
                        <div class="col-md-4">
                            <div class="card property-card">
                                <?php if (!empty($property['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($property['image_url']); ?>" class="card-img-top" alt="Property Cover">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                                    <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
                                    <p class="card-text"><strong>Price:</strong> $<?php echo number_format($property['rent_price'], 2); ?> / mo</p>
                                    <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($property['category_name']); ?></p>
                                    <?php if (!empty($property['amenities'])): ?>
                                        <p class="amenities"><strong>Amenities:</strong> <?php echo htmlspecialchars($property['amenities']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No properties found for this agent.</p>
                    </div>
                <?php endif; ?>
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