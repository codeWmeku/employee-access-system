<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? 'dashboard.php' : 'employee-dashboard.php'; ?>">EAMS</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="ms-auto">
                <?php if(strpos($_SERVER['PHP_SELF'], '/admin/') !== false) { ?>
                    <!-- Admin Navigation -->
                    <a href="dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
                    <a href="employees.php" class="btn btn-outline-light btn-sm">Employees</a>
                    <a href="departments.php" class="btn btn-outline-light btn-sm">Departments</a>
                    <a href="permissions.php" class="btn btn-outline-light btn-sm">Permissions</a>
                    <a href="logs.php" class="btn btn-outline-light btn-sm">Logs</a>
                <?php } else { ?>
                    <!-- Employee Navigation -->
                    <a href="employee-dashboard.php" class="btn btn-outline-light btn-sm">My Dashboard</a>
                <?php } ?>
                <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../auth/logout.php' : 'auth/logout.php'; ?>" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </div>
</nav>