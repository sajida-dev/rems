<?php
session_start();
require_once "components/db_connection.php";
require_once "backend/save-profile.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard/assets/css/profile.css">
    <link rel="stylesheet" href="dashboard/assets/css/personalProfile.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="dashboard/assets/js/profile.js"></script>
    <script src="dashboard/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
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

                <fieldset>
                    <h2 class="fs-title">Personal Details</h2>
                    <h3 class="fs-subtitle">Tell us about yourself</h3>
                    <div class="custom-row">
                        <div class="custom-col custom-col-left">
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" placeholder="923001235678" class="form-control" maxlength="12" value="<?php echo htmlspecialchars($user['contact'] ?? ''); ?>" required />
                            </div>
                        </div>
                        <div class="custom-col custom-col-right">
                            <?php if (!empty($user['profile_pic'])): ?>
                                <img src="<?php echo "dashboard/" . htmlspecialchars($user['profile_pic']); ?>" alt="Profile Avatar" class="avatar custom-avatar img-fluid" id="avatarPreview" />
                            <?php else: ?>
                                <img src="dashboard/assets/img/profile.jpg" alt="Default Avatar" class="custom-avatar img-fluid" id="avatarPreview" />
                            <?php endif; ?>
                            <input type="file" name="profile_pic" id="profile_pic" accept="image/*" style="display: none;" />
                        </div>
                    </div>
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