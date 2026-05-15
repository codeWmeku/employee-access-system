<nav class="navbar navbar-expand-lg navbar-modern">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? 'dashboard.php' : 'employee-dashboard.php'; ?>">
            <i class="fas fa-crown"></i>TwinsGambit
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                    <!-- Admin Navigation -->
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="approvals.php" class="nav-link">
                            <i class="fas fa-clipboard-check"></i> Approvals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employees.php" class="nav-link">
                            <i class="fas fa-users"></i> Employees
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departments.php" class="nav-link">
                            <i class="fas fa-building"></i> Departments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="permissions.php" class="nav-link">
                            <i class="fas fa-lock"></i> Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logs.php" class="nav-link">
                            <i class="fas fa-history"></i> Logs
                        </a>
                    </li>
                <?php } else { ?>
                    <!-- Employee Navigation -->
                    <li class="nav-item">
                        <a href="employee-dashboard.php" class="nav-link">
                            <i class="fas fa-home"></i> My Dashboard
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../auth/logout.php' : 'auth/logout.php'; ?>" class="nav-link logout-btn ms-2">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>