<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['employee_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Approve employee
if(isset($_GET['approve'])) {
    $id = $_GET['approve'];
    mysqli_query($conn, "UPDATE employees SET status='approved' WHERE id='$id' AND role='employee'");
    header("Location: approvals.php");
    exit;
}

// Reject employee
if(isset($_GET['reject'])) {
    $id = $_GET['reject'];
    mysqli_query($conn, "DELETE FROM employees WHERE id='$id' AND role='employee' AND status='pending'");
    header("Location: approvals.php");
    exit;
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: calc(100vh - 80px);">
    
    <div class="container">

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; color: white;">
                    <div class="card-body p-4">
                        <h2 class="mb-0"><i class="fas fa-clipboard-check"></i> Employee Registration Approvals</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; border-top: 4px solid #ffc107;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #ffc107;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $pending = mysqli_query($conn, "SELECT COUNT(*) as count FROM employees WHERE status='pending'");
                            $pending_row = mysqli_fetch_assoc($pending);
                            echo $pending_row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Pending Approvals</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; border-top: 4px solid #28a745;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #28a745;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $approved = mysqli_query($conn, "SELECT COUNT(*) as count FROM employees WHERE status='approved' AND role='employee'");
                            $approved_row = mysqli_fetch_assoc($approved);
                            echo $approved_row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Approved Employees</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; border-top: 4px solid #17a2b8;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #17a2b8;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $total = mysqli_query($conn, "SELECT COUNT(*) as count FROM employees");
                            $total_row = mysqli_fetch_assoc($total);
                            echo $total_row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Registrations -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h4 class="mb-3" style="color: #333; font-weight: 700;"><i class="fas fa-clock"></i> Pending Registrations</h4>
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-list"></i> Awaiting Your Approval</h5>
                    </div>
                    <div class="table-responsive">
                        <?php
                        $pending = mysqli_query($conn, "SELECT * FROM employees WHERE status='pending' ORDER BY created_at DESC");
                        
                        if(mysqli_num_rows($pending) > 0) {
                            ?>
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                    <tr>
                                        <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-user"></i> Full Name</th>
                                        <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-envelope"></i> Email Address</th>
                                        <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-calendar"></i> Registration Date</th>
                                        <th style="padding: 1.2rem; font-weight: 600; text-align: center;"><i class="fas fa-cog"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while($row = mysqli_fetch_assoc($pending)) {
                                        ?>
                                        <tr style="border-bottom: 1px solid #f0f0f0;">
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <i class="fas fa-user-circle" style="color: #667eea; margin-right: 8px;"></i>
                                                <strong><?php echo $row['fullname']; ?></strong>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;"><?php echo $row['email']; ?></td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <i class="fas fa-clock" style="color: #ffc107; margin-right: 5px;"></i>
                                                <?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle; text-align: center;">
                                                <a href="approvals.php?approve=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" style="border-radius: 6px; padding: 0.4rem 0.8rem; font-size: 0.85rem;" onclick="return confirm('Approve this employee?')">
                                                    <i class="fas fa-check"></i> Approve
                                                </a>
                                                <a href="approvals.php?reject=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" style="border-radius: 6px; padding: 0.4rem 0.8rem; font-size: 0.85rem;" onclick="return confirm('Reject this employee?')">
                                                    <i class="fas fa-times"></i> Reject
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="p-4 text-center">
                                <i class="fas fa-inbox" style="font-size: 2.5rem; color: #ccc; margin-bottom: 10px; display: block;"></i>
                                <p class="text-muted"><strong>No pending employee registrations</strong></p>
                                <small class="text-muted">All registration requests have been processed.</small>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Employees -->
        <div class="row">
            <div class="col-lg-12">
                <h4 class="mb-3" style="color: #333; font-weight: 700;"><i class="fas fa-check-circle"></i> Approved Employees</h4>
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-list"></i> Active Employees in System</h5>
                    </div>
                    <div class="table-responsive">
                        <?php
                        $approved = mysqli_query($conn, "SELECT * FROM employees WHERE status='approved' AND role='employee' ORDER BY fullname");
                        
                        if(mysqli_num_rows($approved) > 0) {
                            ?>
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                    <tr>
                                        <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-hashtag"></i> ID</th>
                                        <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-user"></i> Full Name</th>
                                        <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-envelope"></i> Email Address</th>
                                        <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-calendar"></i> Approved Date</th>
                                        <th style="padding: 1.2rem; font-weight: 600; text-align: center;"><i class="fas fa-check"></i> Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while($row = mysqli_fetch_assoc($approved)) {
                                        ?>
                                        <tr style="border-bottom: 1px solid #f0f0f0;">
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;"><strong>#<?php echo $row['id']; ?></strong></td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <i class="fas fa-user-circle" style="color: #28a745; margin-right: 8px;"></i>
                                                <?php echo $row['fullname']; ?>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;"><?php echo $row['email']; ?></td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle; text-align: center;">
                                                <span class="badge bg-success" style="font-size: 0.85rem;"><i class="fas fa-check"></i> Approved</span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="p-4 text-center">
                                <i class="fas fa-inbox" style="font-size: 2.5rem; color: #ccc; margin-bottom: 10px; display: block;"></i>
                                <p class="text-muted"><strong>No approved employees yet</strong></p>
                                <small class="text-muted">Approved employees will appear here.</small>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .badge {
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
        border-radius: 6px;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }

        .btn {
            padding: 0.4rem 0.6rem !important;
            font-size: 0.8rem !important;
        }
    }
</style>

<?php include '../includes/footer.php'; ?>
