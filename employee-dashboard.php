<?php
session_start();
include 'config/db.php';

if(!isset($_SESSION['employee_id'])) {
    header("Location: auth/login.php");
    exit;
}

include 'includes/header.php';
include 'includes/navbar.php';
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
                                <h2 class="mb-2"><i class="fas fa-user-circle"></i> Welcome back, <?php echo $_SESSION['fullname']; ?>!</h2>
                                <p class="mb-0 opacity-75"><i class="fas fa-id-badge"></i> Employee ID: <strong><?php echo $_SESSION['employee_id']; ?></strong></p>
                            </div>
                            <div style="font-size: 3rem; opacity: 0.3;">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #667eea;">
                            <i class="fas fa-key"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $emp_id = $_SESSION['employee_id'];
                            $access = mysqli_query($conn, 
                                "SELECT COUNT(*) as count FROM permissions WHERE employee_id='$emp_id'"
                            );
                            $row = mysqli_fetch_assoc($access);
                            echo $row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0"><i class="fas fa-building"></i> Accessible Departments</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #28a745;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $approved = mysqli_query($conn, 
                                "SELECT COUNT(*) as count FROM access_logs WHERE employee_id='$emp_id' AND status='Approved'"
                            );
                            $approved_row = mysqli_fetch_assoc($approved);
                            echo $approved_row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0"><i class="fas fa-history"></i> Access Logs</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #17a2b8;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $last_access = mysqli_query($conn, 
                                "SELECT DATE_FORMAT(access_time, '%d %b %Y') as date FROM access_logs WHERE employee_id='$emp_id' ORDER BY access_time DESC LIMIT 1"
                            );
                            if(mysqli_num_rows($last_access) > 0) {
                                $last_row = mysqli_fetch_assoc($last_access);
                                echo $last_row['date'];
                            } else {
                                echo "Never";
                            }
                            ?>
                        </h3>
                        <p class="text-muted mb-0"><i class="fas fa-door-open"></i> Last Access</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #ffc107;">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $total_depts = mysqli_query($conn, "SELECT COUNT(*) as count FROM departments");
                            $total_row = mysqli_fetch_assoc($total_depts);
                            echo $total_row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0"><i class="fas fa-list"></i> Total Departments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Accessible Departments -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h4 class="mb-3" style="color: #333; font-weight: 700;"><i class="fas fa-door-open"></i> Departments You Can Access</h4>
                <div class="row">
                    <?php
                    $emp_id = $_SESSION['employee_id'];
                    $departments = mysqli_query($conn, 
                        "SELECT d.* FROM departments d 
                         INNER JOIN permissions p ON d.id = p.department_id 
                         WHERE p.employee_id='$emp_id'"
                    );
                    
                    if(mysqli_num_rows($departments) > 0) {
                        while($dept = mysqli_fetch_assoc($departments)) {
                            // Log the access
                            $access_log = "INSERT INTO access_logs(employee_id, department_id, status, access_time)
                                          VALUES('$emp_id', '{$dept['id']}', 'Approved', NOW())";
                            mysqli_query($conn, $access_log);
                            ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-top: 4px solid #28a745; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3" style="font-size: 2.5rem; color: #28a745;">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <h5 class="card-title"><?php echo $dept['department_name']; ?></h5>
                                        <p class="text-muted small mb-2"><?php echo $dept['description'] ?? 'Department'; ?></p>
                                        <span class="badge bg-success"><i class="fas fa-check"></i> Access Granted</span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-12">
                            <div class="alert alert-warning border-0 shadow-sm" style="border-radius: 15px; background-color: #fff3cd;">
                                <i class="fas fa-info-circle"></i> <strong>No Access Yet</strong><br>
                                You don't have access to any departments yet. Please contact your administrator to request access.
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- All Available Departments -->
        <div class="row">
            <div class="col-lg-12">
                <h4 class="mb-3" style="color: #333; font-weight: 700;"><i class="fas fa-list"></i> All Available Departments</h4>
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <tr>
                                    <th style="border: none;"><i class="fas fa-building"></i> Department Name</th>
                                    <th style="border: none;"><i class="fas fa-file-alt"></i> Description</th>
                                    <th style="border: none; text-align: center;"><i class="fas fa-lock"></i> Access Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $emp_id = $_SESSION['employee_id'];
                                $all_depts = mysqli_query($conn, "SELECT * FROM departments");
                                
                                while($dept = mysqli_fetch_assoc($all_depts)) {
                                    $check = mysqli_query($conn, 
                                        "SELECT * FROM permissions WHERE employee_id='$emp_id' AND department_id='{$dept['id']}'"
                                    );
                                    $has_access = mysqli_num_rows($check) > 0;
                                    ?>
                                    <tr>
                                        <td><strong><?php echo $dept['department_name']; ?></strong></td>
                                        <td><?php echo $dept['description'] ?? 'N/A'; ?></td>
                                        <td style="text-align: center;">
                                            <?php if($has_access) { ?>
                                                <span class="badge bg-success" style="font-size: 0.9rem;"><i class="fas fa-check"></i> Allowed</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger" style="font-size: 0.9rem;"><i class="fas fa-lock"></i> Denied</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    /* Card Hover Effects */
    .card {
        transition: all 0.3s ease !important;
    }

    .card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 10px;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    /* Table Styling */
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 1.2rem;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 1rem 1.2rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        h2 {
            font-size: 1.5rem !important;
        }

        h4 {
            font-size: 1.2rem !important;
        }
    }
</style>

<?php include 'includes/footer.php'; ?>
