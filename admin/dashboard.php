<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['employee_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: calc(100vh - 80px);">
    
    <div class="container">

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; color: white;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="mb-2"><i class="fas fa-tachometer-alt"></i> Administration Dashboard</h2>
                                <p class="mb-0 opacity-75"><i class="fas fa-user-cog"></i> Welcome, <?php echo $_SESSION['fullname']; ?> - Manage your system here</p>
                            </div>
                            <div style="font-size: 3rem; opacity: 0.3;">
                                <i class="fas fa-cogs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Stats Section -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-top: 4px solid #667eea; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #667eea;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $employees = mysqli_query($conn, "SELECT * FROM employees");
                            echo mysqli_num_rows($employees);
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Total Employees</p>
                        <a href="employees.php" class="btn btn-sm btn-outline-primary mt-3" style="border-radius: 8px;">
                            <i class="fas fa-arrow-right"></i> Manage
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-top: 4px solid #28a745; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #28a745;">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $departments = mysqli_query($conn, "SELECT * FROM departments");
                            echo mysqli_num_rows($departments);
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Total Departments</p>
                        <a href="departments.php" class="btn btn-sm btn-outline-success mt-3" style="border-radius: 8px;">
                            <i class="fas fa-arrow-right"></i> Manage
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-top: 4px solid #ffc107; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #ffc107;">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $logs = mysqli_query($conn, "SELECT * FROM access_logs");
                            echo mysqli_num_rows($logs);
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Access Logs</p>
                        <a href="logs.php" class="btn btn-sm btn-outline-warning mt-3" style="border-radius: 8px;">
                            <i class="fas fa-arrow-right"></i> View
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h4 class="mb-3" style="color: #333; font-weight: 700;"><i class="fas fa-bolt"></i> Quick Actions</h4>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="approvals.php" class="text-decoration-none">
                            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; height: 100%; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(245, 87, 108, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-clipboard-check" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                                    <h5 class="mb-2">Approve Users</h5>
                                    <p class="mb-0 small">Review pending registrations</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="permissions.php" class="text-decoration-none">
                            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; height: 100%; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(79, 172, 254, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-lock" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                                    <h5 class="mb-2">Assign Permissions</h5>
                                    <p class="mb-0 small">Manage department access</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="employees.php" class="text-decoration-none">
                            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; height: 100%; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(67, 233, 123, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-user-plus" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                                    <h5 class="mb-2">Add Employees</h5>
                                    <p class="mb-0 small">Create new employee accounts</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="departments.php" class="text-decoration-none">
                            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; height: 100%; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(250, 112, 154, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-building" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                                    <h5 class="mb-2">Departments</h5>
                                    <p class="mb-0 small">Manage departments</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Stats -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-clock"></i> Pending Approvals</h5>
                    </div>
                    <div class="card-body p-4">
                        <h2 class="text-warning" style="font-weight: 700;">
                            <?php
                            $pending = mysqli_query($conn, "SELECT COUNT(*) as count FROM employees WHERE status='pending' AND role='employee'");
                            $pending_row = mysqli_fetch_assoc($pending);
                            echo $pending_row['count'];
                            ?>
                        </h2>
                        <p class="text-muted mb-3">Employees waiting for approval</p>
                        <a href="approvals.php" class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px;">
                            <i class="fas fa-check"></i> Review Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-approved"></i> Approved Employees</h5>
                    </div>
                    <div class="card-body p-4">
                        <h2 class="text-success" style="font-weight: 700;">
                            <?php
                            $approved = mysqli_query($conn, "SELECT COUNT(*) as count FROM employees WHERE status='approved' AND role='employee'");
                            $approved_row = mysqli_fetch_assoc($approved);
                            echo $approved_row['count'];
                            ?>
                        </h2>
                        <p class="text-muted mb-3">Active employees in system</p>
                        <a href="employees.php" class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px;">
                            <i class="fas fa-users"></i> View All
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    /* Smooth transitions */
    .card {
        transition: all 0.3s ease !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        h2 {
            font-size: 1.5rem !important;
        }

        h4 {
            font-size: 1.2rem !important;
        }

        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>

<?php include '../includes/footer.php'; ?>