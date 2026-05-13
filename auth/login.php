<?php
session_start();

// If already logged in, redirect
if(isset($_SESSION['employee_id'])) {
    if($_SESSION['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../employee-dashboard.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Access Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center bg-dark text-white">
                    <h3>🔐 Employee Access Management System</h3>
                </div>

                <div class="card-body text-center">

                    <h5 class="mb-4">Select Your Role</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="employee-login.php" class="btn btn-primary btn-lg w-100 py-4">
                                <h4>👤 Employee</h4>
                                <small>Log in as an employee</small>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="admin-login.php" class="btn btn-danger btn-lg w-100 py-4">
                                <h4>⚙️ Administrator</h4>
                                <small>Admin login</small>
                            </a>
                        </div>
                    </div>

                    <hr class="my-4">

                    <p class="text-muted small">
                        New employee? <a href="register.php" class="text-decoration-none">Register here</a>
                    </p>

                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>