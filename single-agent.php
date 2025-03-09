<?php
include "components/db_connection.php";

require_once "backend/single_agent.php";
$title = htmlspecialchars($agent['name']);
include_once("components/header.php");
?>
<style>
    /* Common button styling */
    .btn-custom {
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        font-size: 16px;
        border-radius: 4px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        font-weight: 600;
    }

    /* Hire Now Button Styles */
    .btn-hire {
        background-color: rgb(255, 97, 221);
        color: #fff;
        border: none;
    }

    .btn-hire:hover {
        transform: scale(1.03);
        border: 1px solid rgb(255, 97, 221);
        background: none;
    }


    .btn-custom i {
        margin-right: 8px;
    }
</style>

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
                                <div class="col-md-4 mt-5">
                                    <!-- personal info {name,email,agency,experience,bio etch} -->
                                    <p class="mt-5"><strong>Name:</strong> <?php echo htmlspecialchars($agent['name']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($agent['email']); ?></p>
                                    <p><strong>Agency:</strong> <?php echo htmlspecialchars($agent['agency']); ?></p>
                                    <p><strong>Experience:</strong> <?php echo htmlspecialchars($agent['experience']); ?> years</p>
                                    <p><strong>Bio:</strong> <?php echo htmlspecialchars($agent['bio']); ?></p>
                                    <?php (isset($_SESSION['id']) ? $page = 'request-services.php?agent_id=' . $_GET['agent_id'] . '' : $page = 'register.php?agent_id=' . $_GET['agent_id'] . '&page=request-services') ?>
                                    <a href="<?php echo $page; ?>" class="btn-custom btn-hire">
                                        <i class="fas fa-phone"></i> Hire Now
                                    </a>
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
                            <?php $message = true;
                            $col = 4;
                            require_once("backend/filter.php");
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