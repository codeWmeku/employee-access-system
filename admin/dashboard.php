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

<div class="container mt-4">

    <div class="row">

        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h3>
                        <?php
                        $employees = mysqli_query($conn, "SELECT * FROM employees");
                        echo mysqli_num_rows($employees);
                        ?>
                    </h3>
                    <p>Total Employees</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h3>
                        <?php
                        $departments = mysqli_query($conn, "SELECT * FROM departments");
                        echo mysqli_num_rows($departments);
                        ?>
                    </h3>
                    <p>Total Departments</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h3>
                        <?php
                        $logs = mysqli_query($conn, "SELECT * FROM access_logs");
                        echo mysqli_num_rows($logs);
                        ?>
                    </h3>
                    <p>Access Logs</p>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>