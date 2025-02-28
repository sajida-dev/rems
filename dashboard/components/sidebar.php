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
                        href="#dashboard"
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

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Customer">
                        <i class="fas fa-layer-group"></i>
                        <p>Customers</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Customer">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="sidebar-style-2.php">
                                    <span class="sub-item">Add Customer</span>
                                </a>
                            </li>
                            <li>
                                <a href="all-customers.php">
                                    <span class="sub-item">All Customer</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Agents">
                        <i class="fas fa-th-list"></i>
                        <p>Property Agents</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Agents">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="sidebar-style-2.php">
                                    <span class="sub-item">Add Agents</span>
                                </a>
                            </li>
                            <li>
                                <a href="icon-menu.php">
                                    <span class="sub-item">All Agents</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Categories">
                        <i class="fas fa-th-list"></i>
                        <p>Categories</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Categories">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="new-category.php">
                                    <span class="sub-item">Add Categories</span>
                                </a>
                            </li>
                            <li>
                                <a href="all-categories.php">
                                    <span class="sub-item">All Categories</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Properties">
                        <i class="fas fa-th-list"></i>
                        <p>Properties</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Properties">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="sidebar-style-2.php">
                                    <span class="sub-item">Add Properties</span>
                                </a>
                            </li>
                            <li>
                                <a href="icon-menu.php">
                                    <span class="sub-item">All Properties</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a href="widgets.php">
                        <i class="fas fa-desktop"></i>
                        <p>Widgets</p>
                        <span class="badge badge-success">4</span>
                    </a>
                </li>
                <li class="nav-item">
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
                </li>
            </ul>
        </div>
    </div>
</div>