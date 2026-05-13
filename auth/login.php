<?php
session_start();
include '../config/db.php';

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM employees WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])) {
        
        // Check if account is approved
        if($user['status'] != 'approved') {
            $error = "Your account is pending admin approval. Please wait for approval before logging in.";
        } else {
            // Login successful
            $_SESSION['employee_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if($user['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../employee-dashboard.php");
            }
        }
    } else {
        $error = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Employee Access Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-header text-center bg-dark text-white">
                    <h3>Employee Login</h3>
                </div>

                <div class="card-body">

                    <?php if(isset($error)) { ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>

                        <button type="submit" name="login" class="btn btn-dark w-100">
                            Login
                        </button>
                    </form>

                    <div class="mt-3 text-center">
                        <p>Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a></p>
                    </div>

                    <div class="alert alert-info mt-3">
                        <small><strong>Admin Test Credentials:</strong><br>
                        Email: admin@system.local<br>
                        Password: admin12345</small>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>