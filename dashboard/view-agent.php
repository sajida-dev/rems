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
    .agent-details {
        margin: 20px auto;
        max-width: 1200px;
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .contact-details {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        background: #f8f8f8;
    }

    .transaction-group {
        margin-bottom: 30px;
    }

    .transaction-group h5 {
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .profile-img {
        max-width: 150px;
        border-radius: 50%;
        margin-bottom: 15px;
    }
</style>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="fw-mediumbold"><?php echo htmlspecialchars($agent['name']); ?></h5>
        </div>
        <div class="card-body">
            <div class="container agent-details">
                <div class="row">
                    <!-- Left Column: Agent's Managed Properties -->
                    <div class="col-md-8">
                        <h3>Properties Managed by <?php echo htmlspecialchars($agent['name']); ?></h3>
                        <?php if (!empty($properties)): ?>
                            <?php foreach ($properties as $property): ?>
                                <div class="transaction-group">
                                    <h5><?php echo htmlspecialchars($property['title']); ?></h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <!-- <th>Property Type</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo htmlspecialchars($property['location']); ?></td>
                                                <td>$<?php echo number_format($property['rent_price'], 2); ?></td>
                                                <td><?php echo htmlspecialchars($property['status']); ?></td>
                                                <!-- <td><?php echo htmlspecialchars($property['type']); ?></td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="mt-4 d-flex justify-content-center">No properties found for this agent.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Right Column: Contact Details -->
                    <div class="col-md-4">
                        <div class="contact-details">
                            <h4>Contact Details</h4>
                            <?php if (!empty($agent['profile_pic'])): ?>
                                <img src="<?php echo htmlspecialchars($agent['profile_pic']); ?>" alt="Profile Picture" class="profile-img img-fluid">
                            <?php else: ?>
                                <img src="assets/img/avatar.png" alt="Default Avatar" class="profile-img img-fluid">
                            <?php endif; ?>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($agent['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($agent['email']); ?></p>
                            <p><strong>Contact:</strong> <?php echo htmlspecialchars($agent['contact']); ?></p>
                        </div>
                    </div>
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