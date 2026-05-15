<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['employee_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Clear logs if requested
if(isset($_GET['clear'])) {
    mysqli_query($conn, "DELETE FROM access_logs");
    header("Location: logs.php");
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
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><i class="fas fa-history"></i> Access Logs</h2>
                        <a href="logs.php?clear=1" class="btn btn-light" style="border-radius: 8px; font-weight: 600;" onclick="return confirm('Clear all logs? This action cannot be undone.')">
                            <i class="fas fa-trash"></i> Clear All Logs
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; border-top: 4px solid #667eea;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #667eea;">
                            <i class="fas fa-list"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $total_logs = mysqli_query($conn, "SELECT COUNT(*) as count FROM access_logs");
                            $total_row = mysqli_fetch_assoc($total_logs);
                            echo $total_row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Total Access Attempts</p>
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
                            $approved_logs = mysqli_query($conn, "SELECT COUNT(*) as count FROM access_logs WHERE status='Approved'");
                            $approved_row = mysqli_fetch_assoc($approved_logs);
                            echo $approved_row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Approved Access</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; border-top: 4px solid #dc3545;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size: 2.5rem; color: #dc3545;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h3 class="mb-2">
                            <?php
                            $denied_logs = mysqli_query($conn, "SELECT COUNT(*) as count FROM access_logs WHERE status='Denied'");
                            $denied_row = mysqli_fetch_assoc($denied_logs);
                            echo $denied_row['count'];
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Denied Access</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Logs Table -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-list"></i> Recent Activity</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                <tr>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-hashtag"></i> ID</th>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-user-tie"></i> Employee</th>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-building"></i> Department</th>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-lock"></i> Status</th>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-clock"></i> Access Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $logs = mysqli_query($conn, 
                                    "SELECT l.id, e.fullname, d.department_name, l.status, l.access_time 
                                     FROM access_logs l 
                                     LEFT JOIN employees e ON l.employee_id = e.id 
                                     LEFT JOIN departments d ON l.department_id = d.id 
                                     ORDER BY l.access_time DESC 
                                     LIMIT 100"
                                );
                                
                                $count = 0;
                                if(mysqli_num_rows($logs) > 0) {
                                    while($row = mysqli_fetch_assoc($logs)) {
                                        $count++;
                                        $status_badge = ($row['status'] == 'Approved') ? 
                                            '<span class="badge bg-success" style="font-size: 0.85rem;"><i class="fas fa-check"></i> Approved</span>' : 
                                            '<span class="badge bg-danger" style="font-size: 0.85rem;"><i class="fas fa-times"></i> Denied</span>';
                                        ?>
                                        <tr style="border-bottom: 1px solid #f0f0f0;">
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;"><strong>#<?php echo $row['id']; ?></strong></td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <i class="fas fa-user-circle" style="color: #667eea; margin-right: 8px;"></i>
                                                <?php echo $row['fullname'] ?: 'Unknown'; ?>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <i class="fas fa-building" style="color: #28a745; margin-right: 8px;"></i>
                                                <?php echo $row['department_name'] ?: 'Unknown'; ?>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <?php echo $status_badge; ?>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <small>
                                                    <i class="fas fa-calendar-alt" style="margin-right: 5px;"></i>
                                                    <?php echo date('M d, Y H:i:s', strtotime($row['access_time'])); ?>
                                                </small>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center p-4"><i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i><p class="text-muted mt-2">No access logs found</p></td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #e0e7ff 0%, #f0e7ff 100%);">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> About Access Logs</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="mb-3"><strong>Access logs automatically track employee access attempts to departments.</strong></p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 style="color: #667eea; font-weight: 600;"><i class="fas fa-user-tie"></i> Employee</h6>
                                <p class="text-muted small">The employee attempting to access the system or department</p>
                            </div>
                            <div class="col-md-6">
                                <h6 style="color: #667eea; font-weight: 600;"><i class="fas fa-building"></i> Department</h6>
                                <p class="text-muted small">The department or resource being accessed</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 style="color: #667eea; font-weight: 600;"><i class="fas fa-lock"></i> Status</h6>
                                <p class="text-muted small">Whether the access was approved or denied based on permissions</p>
                            </div>
                            <div class="col-md-6">
                                <h6 style="color: #667eea; font-weight: 600;"><i class="fas fa-clock"></i> Access Time</h6>
                                <p class="text-muted small">The exact date and time of the access attempt</p>
                            </div>
                        </div>
                        <hr>
                        <p class="text-muted mb-0"><strong>💡 Tip:</strong> Review logs regularly to monitor employee access patterns and ensure security compliance. Use the Clear Logs button to delete all historical records if needed.</p>
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
            padding: 0.4rem 0.8rem !important;
            font-size: 0.9rem !important;
        }
    }
</style>

<?php include '../includes/footer.php'; ?>
