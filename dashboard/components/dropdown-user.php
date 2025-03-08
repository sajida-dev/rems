<ul class="dropdown-menu dropdown-user animated fadeIn">
    <div class="dropdown-user-scroll scrollbar-outer">
        <li>
            <div class="user-box">
                <div class="avatar-lg">
                    <img
                        src="assets/img/profile.jpg"
                        alt="image profile"
                        class="avatar-img rounded" />
                </div>
                <div class="u-text">
                    <h4><?php echo $_SESSION['name'] ?? "" ?></h4>
                    <p class="text-muted"><?php echo $_SESSION['email'];
                                            ?></p>
                    <a
                        href="profile.php"
                        class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                </div>
            </div>
        </li>
        <li>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <!-- <a class="dropdown-item" href="#">My Balance</a> -->
            <!-- <a class="dropdown-item" href="#">Inbox</a> -->
            <!-- <div class="dropdown-divider"></div> -->
            <!-- <a class="dropdown-item" href="#">Account Setting</a> -->
            <!-- <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="../logout.php">Logout</a>
        </li>
    </div>
</ul>