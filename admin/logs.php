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

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Access Logs</h4>
            <a href="logs.php?clear=1" class="btn btn-warning btn-sm" onclick="return confirm('Clear all logs?')">Clear Logs</a>
        </div>

        <div class="card-body">

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Access Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $logs = mysqli_query($conn, 
                        "SELECT l.id, e.fullname, d.department_name, l.status, l.access_time 
                         FROM access_logs l 
                         LEFT JOIN employees e ON l.employee_id = e.id 
                         LEFT JOIN departments d ON l.department_id = d.id 
                         ORDER BY l.access_time DESC"
                    );
                    
                    if(mysqli_num_rows($logs) > 0) {
                        while($row = mysqli_fetch_assoc($logs)) {
                            $status_class = ($row['status'] == 'Approved') ? 'badge-success' : 'badge-danger';
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['fullname'] ?: 'N/A'; ?></td>
                                <td><?php echo $row['department_name'] ?: 'N/A'; ?></td>
                                <td>
                                    <span class="badge <?php echo $status_class; ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('Y-m-d H:i:s', strtotime($row['access_time'])); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">No access logs found</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <div class="card shadow mt-4">

        <div class="card-header bg-info text-white">
            <h4>How Access Logging Works</h4>
        </div>

        <div class="card-body">
            <p>Access logs are automatically recorded when employees attempt to access departments. The system tracks:</p>
            <ul>
                <li><strong>Employee:</strong> The employee attempting access</li>
                <li><strong>Department:</strong> The department being accessed</li>
                <li><strong>Status:</strong> Whether access was approved or denied</li>
                <li><strong>Access Time:</strong> When the access attempt occurred</li>
            </ul>
            <p>Administrators can review these logs to monitor employee access patterns and ensure security compliance.</p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>
