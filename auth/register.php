<?php
include '../config/db.php';

if(isset($_POST['register'])) {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO employees(fullname,email,password)
              VALUES('$fullname','$email','$password')";

    if(mysqli_query($conn, $query)) {
        $success = "Account created successfully! Redirecting to login...";
        header("Refresh: 2; url=login.php");
    } else {
        $error = "Error creating account. Email may already exist.";
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
                    <h3>Create Employee Account</h3>
                </div>

                <div class="card-body">

                    <?php if(isset($success)) { ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                        </div>
                    <?php } ?>

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

                        <button type="submit" name="register" class="btn btn-primary w-100">
                            Register
                        </button>

                    </form>

                    <div class="mt-3 text-center">
                        <p>Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>