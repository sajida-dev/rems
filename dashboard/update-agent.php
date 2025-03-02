<?php
$title = "New Agent";
$page = "New";
$mainPage = "Agent";
require_once "components/header.php";
require_once "backend/add-agent.php"; ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="fw-mediumbold">Add Agent</h5>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="agent_id" value="<?php echo htmlspecialchars($agent_id); ?>">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="form-group">
                            <label for="name">Agent Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter agent name" required value="<?php echo htmlspecialchars($agent['name'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Agent Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required value="<?php echo htmlspecialchars($agent['email'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="agency">Agency Name</label>
                            <input type="text" class="form-control" id="agency" name="agency" placeholder="Enter agency name" required value="<?php echo htmlspecialchars($agent['agency'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="form-group">
                            <label for="password">Agent Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                            <?php if (isset($agent['id'])): ?>
                                <small class="text-muted">Leave blank to keep the current password.</small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact Number</label>
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter contact number" value="<?php echo htmlspecialchars($agent['contact'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="experience">Years of Experience</label>
                            <input type="number" class="form-control" id="experience" name="experience" placeholder="Enter years of experience" required value="<?php echo htmlspecialchars($agent['experience'] ?? ''); ?>" min="0">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label d-block">Select Specializations </label>
                        <div class="selectgroup selectgroup-secondary selectgroup-pills">
                            <?php foreach ($categories as $category): ?>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="categories[]" value="<?php echo htmlspecialchars($category['id']); ?>" class="selectgroup-input" />
                                    <span class="selectgroup-button">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="bio">Agent Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Write a brief bio" required><?php echo htmlspecialchars($agent['bio'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="profile_pic">Profile Picture</label>
                    <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
                    <?php if (isset($agent['profile_pic']) && $agent['profile_pic']): ?>
                        <img src="<?php echo $agent['profile_pic']; ?>" alt="Agent Picture" class="mt-3" style="max-width: 100px;">
                    <?php endif; ?>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update Agent</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='all-agents.php';">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>


<?php require_once "components/footer.php"; ?>