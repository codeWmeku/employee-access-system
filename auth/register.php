<?php
include '../config/db.php';

if(isset($_POST['register'])) {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = mysqli_query($conn, "SELECT * FROM employees WHERE email='$email'");
    
    if(mysqli_num_rows($checkEmail) > 0) {
        $error = "Email already registered!";
    } else {
        // Register as pending employee (status: pending, role: employee)
        $query = "INSERT INTO employees(fullname, email, password, role, status)
                  VALUES('$fullname', '$email', '$password', 'employee', 'pending')";

        if(mysqli_query($conn, $query)) {
            $success = "Account created! Awaiting admin approval before you can login.";
            // Don't redirect, show message
        } else {
            $error = "Error creating account. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Employee Access Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-primary text-white text-center">
                    <h3>Register as Employee</h3>
                </div>

                <div class="card-body">

                    <?php if(isset($success)) { ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong><br>
                            <?php echo $success; ?><br><br>
                            <small class="text-muted">An administrator will review your request and approve your account soon. You will be able to login once approved.</small>
                        </div>
                        <a href="employee-login.php" class="btn btn-primary w-100 mt-3">Go to Employee Login</a>
                    <?php } else { ?>
                        <?php if(isset($error)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>

                        <form method="POST">

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-control" placeholder="Enter your full name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter a strong password" required>
                            </div>

                            <div class="alert alert-info">
                                <small>After registration, an administrator will review your request. You'll receive access once approved.</small>
                            </div>

                            <button type="submit" name="register" class="btn btn-primary w-100">
                                Register
                            </button>

                        </form>

                        <div class="mt-3 text-center">
                            <p>Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
                        </div>
                    <?php } ?>

                </div>
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>