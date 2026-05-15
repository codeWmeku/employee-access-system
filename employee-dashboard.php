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

<div class="container mt-4">

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4>My Dashboard</h4>
                </div>

                <div class="card-body">
                    <h5>Welcome, <?php echo $_SESSION['fullname']; ?>!</h5>
                    <p>Your Employee ID: <?php echo $_SESSION['employee_id']; ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4>Your Departments</h4>
                </div>

                <div class="card-body">
                    <?php
                    $emp_id = $_SESSION['employee_id'];
                    $access = mysqli_query($conn, 
                        "SELECT COUNT(*) as count FROM permissions WHERE employee_id='$emp_id'"
                    );
                    $row = mysqli_fetch_assoc($access);
                    ?>
                    <h3><?php echo $row['count']; ?></h3>
                    <p>Accessible Departments</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header bg-dark text-white">
            <h4>Departments You Can Access</h4>
        </div>

        <div class="card-body">
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
                        <div class="col-md-6 mb-3">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $dept['department_name']; ?></h5>
                                    <span class="badge badge-success">Access Granted</span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="col-12">
                        <div class="alert alert-warning">
                            You don't have access to any departments yet. Contact your administrator.
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header bg-dark text-white">
            <h4>All Available Departments</h4>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Department Name</th>
                        <th>Access Status</th>
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
                            <td><?php echo $dept['department_name']; ?></td>
                            <td>
                                <?php if($has_access) { ?>
                                    <span class="badge badge-success">✓ Allowed</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">✗ Denied</span>
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

<?php include 'includes/footer.php'; ?>

</body>
</html>
