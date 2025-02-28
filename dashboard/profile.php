<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/profile.css">
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/profile.js"></script> v v vc cb bn
    <title>Profile</title>
</head>

<body>
    <!-- MultiStep Form -->
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 col-md-offset-3">
            <form id="msform">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active">Personal Details</li>
                    <li>Social Profiles</li>
                    <li>Account Setup</li>
                </ul>
                <!-- fieldsets -->
                <fieldset>
                    <h2 class="fs-title">Personal Details</h2>
                    <h3 class="fs-subtitle">Tell us something more about you</h3>
                    <input type="text" name="fname" placeholder="First Name" />
                    <input type="text" name="lname" placeholder="Last Name" />
                    <input type="text" name="phone" placeholder="Phone" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Social Profiles</h2>
                    <h3 class="fs-subtitle">Your presence on the social network</h3>
                    <input type="text" name="twitter" placeholder="Twitter" />
                    <input type="text" name="facebook" placeholder="Facebook" />
                    <input type="text" name="gplus" placeholder="Google Plus" />
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Create your account</h2>
                    <h3 class="fs-subtitle">Fill in your credentials</h3>
                    <input type="text" name="email" placeholder="Email" />
                    <input type="password" name="pass" placeholder="Password" />
                    <input type="password" name="cpass" placeholder="Confirm Password" />
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    <input type="submit" name="submit" class="submit action-button" value="Submit" />
                </fieldset>
            </form>

        </div>
        <div class="col-md-3"></div>
    </div>
    <!-- /.MultiStep Form -->
</body>

</html>