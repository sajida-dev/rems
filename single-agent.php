<?php include_once("components/header.php");
require_once "backend/single_agent.php";
?>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Agent Details <i class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-3 bread"><?php echo htmlspecialchars($agent['name']); ?></h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-agent-details">
    <div class="container">
        <!-- <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="agent-left">
                    <h3>Agent Information</h3>
                    <div class="agent-info">
                        <div class="agent-image">
                            <img src="<?php echo 'uploads/avatars/' . htmlspecialchars($agent['profile_pic']); ?>" alt="Agent Image" class="img-fluid">
                        </div>
                        <div class="agent-details">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($agent['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($agent['email']); ?></p>
                            <p><strong>Agency:</strong> <?php echo htmlspecialchars($agent['agency']); ?></p>
                            <p><strong>Experience:</strong> <?php echo htmlspecialchars($agent['experience']); ?> years</p>
                            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($agent['contact']); ?></p>
                            <p><strong>Bio:</strong> <?php echo htmlspecialchars($agent['bio']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="agent-right">
                    <h3>Properties Managed by <?php echo htmlspecialchars($agent['name']); ?></h3>
                    <div class="agent-properties">
                        <?php if (count($properties) > 0): ?>
                            <div class="property-list">
                                <?php foreach ($properties as $property): ?>
                                    <div class="property-item">
                                        <div class="property-image" style="background-image: url('<?php echo 'dashboard/' . htmlspecialchars($property['image_url']); ?>');"></div>
                                        <div class="property-info">
                                            <h5><a href="property-details.php?property_id=<?php echo htmlspecialchars($property['property_id']); ?>"><?php echo htmlspecialchars($property['title']); ?></a></h5>
                                            <p><?php echo htmlspecialchars($property['location']); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>This agent doesn't manage any properties yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-md-12 pills">
                <div class="bd-example bd-example-tabs">
                    <div class="d-flex justify-content-center">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-personal-info-tab" data-toggle="pill" href="#pills-personal-info" role="tab" aria-controls="pills-personal-info" aria-expanded="true">Personal Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-Properties-tab" data-toggle="pill" href="#pills-Properties" role="tab" aria-controls="pills-Properties" aria-expanded="true">Properties</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-info-tab" data-toggle="pill" href="#pills-contact-info" role="tab" aria-controls="pills-contact-info" aria-expanded="true">Contact Info</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Features Tab -->
                        <div class="tab-pane fade show active" id="pills-personal-info" role="tabpanel" aria-labelledby="pills-personal-info-tab">
                            <div class="row">
                                <div class="col-md-2">
                                    <!-- for space -->
                                </div>
                                <div class="col-md-4">
                                    <!-- personal info {name,email,agency,experience,bio etch} -->
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($agent['name']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($agent['email']); ?></p>
                                    <p><strong>Agency:</strong> <?php echo htmlspecialchars($agent['agency']); ?></p>
                                    <p><strong>Experience:</strong> <?php echo htmlspecialchars($agent['experience']); ?> years</p>
                                    <p><strong>Bio:</strong> <?php echo htmlspecialchars($agent['bio']); ?></p>

                                </div>
                                <div class="col-md-4 m-0" style="height: 370px; overflow:hidden;">
                                    <!-- avator image for agent -->
                                    <img src="<?php echo 'dashboard/' . htmlspecialchars($agent['profile_pic']); ?>" style="object-fit: cover; width: 100%; height: 100%;" alt="<?php echo htmlspecialchars($agent['name']); ?>" class="img-fluid">
                                </div>
                                <div class="col-md-2">
                                    <!-- for space -->
                                </div>
                            </div>

                        </div>
                        <!-- Description Tab -->
                        <div class="tab-pane fade" id="pills-Properties" role="tabpanel" aria-labelledby="pills-Properties-tab">
                            <?php require_once("backend/select_properties.php");
                            include "properties-listing.php"; ?>
                        </div>
                        <div class="tab-pane fade text-center" id="pills-contact-info" role="tabpanel" aria-labelledby="pills-contact-info-tab">
                            <!-- contact information -->
                            <p>Contact information</p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($agent['email']); ?></p>
                            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($agent['contact']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include_once "components/footer.php" ?>

<script>
    $(document).ready(function() {
        $('#pills-tab a').on('click', function(e) {
            e.preventDefault();
            var hash = this.hash;
            $(this).tab('show');

            if (history.pushState) {
                history.pushState(null, null, hash);
            } else {
                window.location.hash = hash;
            }
        });
    });
</script>