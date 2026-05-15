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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Employee Access Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header-top {
            background: rgba(255, 255, 255, 0.95);
            padding: 1.2rem;
            text-align: center;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .header-top a {
            font-weight: 800;
            font-size: 1.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .header-top a i {
            font-size: 2rem;
        }

        .register-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card-register {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            max-width: 480px;
            width: 100%;
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease;
            overflow: hidden;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
            border: none;
        }

        .card-header-register h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .card-header-register i {
            font-size: 2rem;
        }

        .card-body-register {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.7rem;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .mb-3 {
            margin-bottom: 1.2rem;
        }

        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.85rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e0e0;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
        }

        .alert {
            border: none;
            border-radius: 10px;
            animation: slideDown 0.5s ease;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 1.2rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1.2rem;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 1rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-custom {
            background: rgba(0, 0, 0, 0.2);
            color: white;
            padding: 20px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .card-register {
                max-width: 100%;
            }

            .header-top a {
                font-size: 1.5rem;
            }

            .card-header-register h3 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header-top">
    <a href="login.php">
        <i class="fas fa-crown"></i>
        TwinsGambit
    </a>
</div>

<!-- Register Container -->
<div class="register-container">
    <div class="card-register">
        <div class="card-header-register">
            <h3><i class="fas fa-user-plus"></i> Create Employee Account</h3>
        </div>

        <div class="card-body-register">

            <?php if(isset($success)) { ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <strong>Account Created Successfully!</strong><br><br>
                    <?php echo $success; ?><br><br>
                    <small>An administrator will review your request soon. You'll receive confirmation once approved.</small>
                </div>
                <a href="employee-login.php" class="btn btn-register w-100 mt-3">
                    <i class="fas fa-sign-in-alt"></i> Go to Employee Login
                </a>
            <?php } else { ?>
                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i> Full Name</label>
                        <input type="text" name="fullname" class="form-control" placeholder="John Doe" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="john@twingambit.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Next Step:</strong> After registration, an administrator will review your request. You'll be able to login once your account is approved.
                    </div>

                    <button type="submit" name="register" class="btn btn-register w-100">
                        <i class="fas fa-user-check"></i> Create My Account
                    </button>

                </form>

                <div class="login-link">
                    <p>Already have an account? <a href="employee-login.php"><i class="fas fa-sign-in-alt"></i> Login here</a></p>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer-custom">
    <p><strong>© 2026 TwinsGambit Company Limited</strong></p>
    <p>Employee Access Management System v1.0</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>