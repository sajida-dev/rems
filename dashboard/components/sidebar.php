<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <?php require_once "components/logo-header.php"; ?>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a
                        data-bs-toggle="collapse"
                        href="index.php"
                        class="collapsed"
                        aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>

                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == '3'): ?>
                    <li class="nav-item">
                        <a href="all-categories.php">
                            <i class="fas fa-layer-group"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="all-amenities.php">
                            <i class="fas fa-concierge-bell"></i>
                            <p>Amenities</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="all-customers.php">
                            <i class="fas fa-users"></i>
                            <p>Customers</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="all-properties.php">
                        <i class="fas fa-home"></i>
                        <p>Properties</p>
                    </a>
                </li>

                <?php
                try {
                    // Query to count agents that are not approved
                    $sql = "SELECT COUNT(*) FROM agent WHERE status = 0";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                    $count = 0; // Default to 0 if there's an error
                }
                $role = ['3', 'admin'];
                if (in_array($_SESSION['role'], $role)): ?>
                    <li class="nav-item">
                        <a href="all-agents.php">
                            <i class="fas fa-user-tie"></i>
                            <p>Agents</p>
                            <span class="badge badge-success"><?php echo $count; ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <!-- <li class="nav-item">
                    <a href="widgets.php">
                        <i class="fas fa-desktop"></i>
                        <p>Widgets</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#submenu">
                        <i class="fas fa-bars"></i>
                        <p>Menu Levels</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="submenu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-bs-toggle="collapse" href="#subnav1">
                                    <span class="sub-item">Level 1</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav1">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-bs-toggle="collapse" href="#subnav2">
                                    <span class="sub-item">Level 1</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav2">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Level 1</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>
</div>