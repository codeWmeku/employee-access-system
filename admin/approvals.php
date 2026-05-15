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

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            <h4>🔐 Employee Registration Approvals</h4>
        </div>

        <div class="card-body">

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h3>
                                <?php
                                $pending = mysqli_query($conn, "SELECT COUNT(*) as count FROM employees WHERE status='pending'");
                                $row = mysqli_fetch_assoc($pending);
                                echo $row['count'];
                                ?>
                            </h3>
                            <p>Pending Approvals</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3>
                                <?php
                                $approved = mysqli_query($conn, "SELECT COUNT(*) as count FROM employees WHERE status='approved' AND role='employee'");
                                $row = mysqli_fetch_assoc($approved);
                                echo $row['count'];
                                ?>
                            </h3>
                            <p>Approved Employees</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <h3>
                                <?php
                                $total = mysqli_query($conn, "SELECT COUNT(*) as count FROM employees");
                                $row = mysqli_fetch_assoc($total);
                                echo $row['count'];
                                ?>
                            </h3>
                            <p>Total Users</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h5>Pending Registrations</h5>

            <?php
            $pending = mysqli_query($conn, "SELECT * FROM employees WHERE status='pending' ORDER BY created_at DESC");
            
            if(mysqli_num_rows($pending) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($pending)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <a href="approvals.php?approve=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Approve this employee?')">Approve</a>
                                        <a href="approvals.php?reject=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Reject this employee?')">Reject</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-info">
                    No pending employee registrations
                </div>
                <?php
            }
            ?>

            <hr class="my-4">

            <h5>Approved Employees</h5>

            <?php
            $approved = mysqli_query($conn, "SELECT * FROM employees WHERE status='approved' AND role='employee' ORDER BY fullname");
            
            if(mysqli_num_rows($approved) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Approved Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($approved)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-info">
                    No approved employees yet
                </div>
                <?php
            }
            ?>

        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>
