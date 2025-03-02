<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Add</span>
                        <span class="fw-light"> Customer</span>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none"></div>
                    <div class="form-group">
                        <label for="name">Agent Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter agent name" required value="<?php echo htmlspecialchars($agent['name'] ?? ""); ?>" value="<?php echo htmlspecialchars($agent['name'] ?? ""); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Agent Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required value="<?php echo htmlspecialchars($agent['email'] ?? ""); ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Agent Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required value="<?php echo htmlspecialchars($agent['password'] ?? ""); ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter contact number" value="<?php echo htmlspecialchars($agent['contact'] ?? ""); ?>">
                    </div>
                    <div class="form-group">
                        <label for="agency">Agency Name</label>
                        <input type="text" class="form-control" id="agency" name="agency" placeholder="Enter agency name" required value="<?php echo htmlspecialchars($agent['agency'] ?? ""); ?>">
                    </div>
                    <div class="form-group">
                        <label for="experience">Years of Experience</label>
                        <input type="number" class="form-control" id="experience" name="experience" placeholder="Enter years of experience" required value="<?php echo htmlspecialchars($agent['experience'] ?? ""); ?>" min="0">
                    </div>
                    <div class="form-group">
                        <label for="bio">Agent Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Write a brief bio" required value="<?php echo htmlspecialchars($agent['bio'] ?? ""); ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="profile_pic">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="register_agent" id="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>