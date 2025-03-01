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
    <title>Profile</title>
</head>

<body>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 ">
            <form id="msform">
                <ul id="progressbar">
                    <li class="active">Personal Details</li>
                    <li>Professional Profiles</li>
                    <li>Account Setup</li>
                </ul>
                <fieldset>
                    <h2 class="fs-title">Personal Details</h2>
                    <h3 class="fs-subtitle">Tell us about yourself</h3>
                    <div class="custom-row">
                        <div class="custom-col custom-col-left">
                            <div class="form-group">
                                <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="<?php echo htmlspecialchars($agent['email'] ?? ''); ?>" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" placeholder="+923001235678" class="form-control" maxlength="12" value="<?php echo htmlspecialchars($agent['phone'] ?? ''); ?>" required />
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

                <fieldset>
                    <h2 class="fs-title">Professional Details</h2>
                    <h3 class="fs-subtitle">Your work profile</h3>
                    <input type="text" name="agency" placeholder="Agency Name" value="<?php echo htmlspecialchars($agent['agency'] ?? ''); ?>" />
                    <input type="number" name="experience" placeholder="Years of Experience" min="0" value="<?php echo htmlspecialchars($agent['experience'] ?? ''); ?>" />
                    <div class="form-group " style="text-align: left;">
                        <label class="custom-form-label">Select Specializations</label>
                        <div class="custom-selectgroup">
                            <label class="custom-selectgroup-item">
                                <input type="checkbox" name="specializations[]" value="Residential">
                                <span>Residential</span>
                            </label>
                            <label class="custom-selectgroup-item">
                                <input type="checkbox" name="specializations[]" value="Commercial">
                                <span>Commercial</span>
                            </label>
                            <label class="custom-selectgroup-item">
                                <input type="checkbox" name="specializations[]" value="Industrial">
                                <span>Industrial</span>
                            </label>
                            <label class="custom-selectgroup-item">
                                <input type="checkbox" name="specializations[]" value="Land">
                                <span>Land</span>
                            </label>
                            <label class="custom-selectgroup-item">
                                <input type="checkbox" name="specializations[]" value="Luxury">
                                <span>Luxury</span>
                            </label>
                        </div>
                    </div>

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
    </div>

    <!-- /.MultiStep Form -->
</body>

</html>