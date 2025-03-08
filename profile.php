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
        <div class="col-md-6 col-lg-3 col-6 col-md-offset-3 msform-container " style="text-align: center;">
            <?php require_once "components/notification.php";  ?>
            <form id="msform" action="" method="POST" enctype="multipart/form-data">

                <fieldset>
                    <h2 class="fs-title">Personal Details</h2>
                    <h3 class="fs-subtitle">Tell us about yourself</h3>
                    <div class="custom-row">
                        <div class="custom-col custom-col-left">
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="Enter Full Name" class="form-control" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" placeholder="+1 (988) 471-92" class="form-control" maxlength="12" value="<?php echo htmlspecialchars($user['contact'] ?? ''); ?>" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" id="username" placeholder="Enter Username" class="form-control" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required />
                                <span id="username-availability"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" />
                            </div>
                        </div>
                        <div class="custom-col custom-col-right">
                            <?php if (!empty($user['profile_pic'])): ?>
                                <img src="<?php echo  htmlspecialchars($user['profile_pic']); ?>" alt="<?php echo  htmlspecialchars($user['name']); ?>" class="avatar custom-avatar img-fluid" id="avatarPreview" />
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

        $(document).ready(function() {
            $('#username').on('input', function() {
                var username = $(this).val();

                // Check if username is not empty
                if (username.length > 0) {
                    $.ajax({
                        url: 'backend/check-username-availability.php',
                        method: 'POST',
                        data: {
                            username: username
                        },
                        success: function(response) {
                            if (response === 'available') {
                                $('#username-availability').text('Username is available').css('color', 'green');
                            } else if (response === 'taken') {
                                $('#username-availability').text('Username is already taken').css('color', 'red');
                            } else {
                                $('#username-availability').text('Error checking username').css('color', 'orange');
                            }
                        }
                    });
                } else {
                    $('#username-availability').text('Username is required').css('color', 'red');
                }
            });
        });
    </script>

</body>

</html>