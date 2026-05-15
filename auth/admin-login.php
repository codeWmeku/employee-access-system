<?php
session_start();
include '../config/db.php';

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM employees WHERE email='$email' AND role='admin'";
    $result = mysqli_query($conn, $query);

    if(!$result) {
        $error = "Database error: " . mysqli_error($conn);
    } else {
        $user = mysqli_fetch_assoc($result);
        
        if($user) {
            if(password_verify($password, $user['password'])) {
                // Login successful - admins don't need approval
                $_SESSION['employee_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];

                header("Location: ../admin/dashboard.php");
                exit;
            } else {
                $error = "Invalid Admin Credentials (password mismatch)";
            }
        } else {
            $error = "Invalid Admin Credentials (user not found)";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Employee Access Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-header text-center bg-danger text-white">
                    <h3>⚙️ Administrator Login</h3>
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

                        <button type="submit" name="login" class="btn btn-danger w-100">
                            Login
                        </button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="login.php" class="text-muted small">← Back to Role Selection</a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
