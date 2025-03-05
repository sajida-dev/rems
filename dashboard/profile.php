<?php
require_once "components/db_connection.php";
$stmtCat = $conn->query("SELECT id, name FROM property_categories ORDER BY name ASC");
$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
require_once "backend/save-profile.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/personalProfile.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/profile.js"></script>
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <title>Profile</title>
    <style>
        .msform-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .msform-container {
                max-width: 90%;
                padding: 10px;
            }
        }
    </style>
</head>

<body>


    <div class="row">
        <div class="col-md-6 col-lg-3 col-6 col-md-offset-3 msform-container">
            <?php
            if (isset($_SESSION['msg'])) {
                echo '<div class="alert alert-success">' . $_SESSION['msg'] . '</div>';
                unset($_SESSION['msg']);
            }
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <form id="msform" action="" method="POST" enctype="multipart/form-data">
                <!-- Progressbar -->
                <ul id="progressbar">
                    <li class="active">Personal Details</li>
                    <li>Professional Details</li>
                    <li>Account Setup</li>
                </ul>
                <!-- Fieldset 1: Personal Details -->
                <fieldset>
                    <h2 class="fs-title">Personal Details</h2>
                    <h3 class="fs-subtitle">Tell us about yourself</h3>
                    <div class="custom-row">
                        <div class="custom-col custom-col-left">
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" placeholder="923001235678" class="form-control" maxlength="12" value="<?php echo htmlspecialchars($user['contact'] ?? ''); ?>" required />
                            </div>
                            <div class="form-group">
                                <textarea name="bio" id="bio" placeholder="Write something about yourself..." rows="4" class="form-control"><?php echo htmlspecialchars($agent['bio'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        <div class="custom-col custom-col-right">
                            <?php if (!empty($agent['profile_pic'])): ?>
                                <img src="<?php echo htmlspecialchars($agent['profile_pic']); ?>" alt="Profile Avatar" class="avatar img-fluid" id="avatarPreview" />
                            <?php else: ?>
                                <img src="assets/img/profile.jpg" alt="Default Avatar" class="custom-avatar img-fluid" id="avatarPreview" />
                            <?php endif; ?>
                            <input type="file" name="profile_pic" id="profile_pic" accept="image/*" style="display: none;" />
                        </div>
                    </div>
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <!-- Fieldset 2: Professional Details -->
                <fieldset>
                    <h2 class="fs-title">Professional Details</h2>
                    <h3 class="fs-subtitle">Your work profile</h3>
                    <div class="form-group">
                        <input type="text" name="agency" placeholder="Agency Name" class="form-control" required value="<?php echo htmlspecialchars($agent['agency'] ?? ''); ?>" />
                    </div>
                    <div class="form-group">
                        <input type="number" name="experience" placeholder="Years of Experience" class="form-control" min="0" required value="<?php echo htmlspecialchars($agent['experience'] ?? ''); ?>" />
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <!-- Fieldset 3:  Setup Specializations -->
                <fieldset>
                    <h2 class="fs-title">Specializations Setup</h2>
                    <h3 class="fs-subtitle"> select specializations</h3>
                    <div class="form-group" style="margin:50px 5px;">
                        <div class="custom-selectgroup">
                            <?php foreach ($categories as $spec):
                                $select = "";
                                $select =  (in_array($spec['id'], $specializations)) ?  "checked" : "";


                            ?>
                                <label class="custom-selectgroup-item ">
                                    <input type="checkbox" name="specializations[]" value="<?php echo htmlspecialchars($spec['id']); ?>" <?php echo $select; ?>>
                                    <span><?php echo htmlspecialchars($spec['name']); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- <input type="hidden" name="current_profile_pic" value="<?php echo htmlspecialchars($agent['profile_pic'] ?? ''); ?>" /> -->
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    <input type="submit" name="submit" class="submit action-button" value="Submit" />
                </fieldset>
            </form>
        </div>
    </div>

    <script>
        $('#avatarPreview').on('click', function() {
            $('#profile_pic').click();
        });
    </script>

</body>

</html>