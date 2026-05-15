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

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card-login {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            max-width: 450px;
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

        .card-header-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
            border: none;
        }

        .card-header-login h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .card-header-login i {
            font-size: 2rem;
        }

        .card-body-login {
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

        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e0e0;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .back-link a:hover {
            color: #764ba2;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 2px solid #f5c6cb;
            color: #721c24;
            border-radius: 10px;
            padding: 1rem;
            animation: slideDown 0.5s ease;
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
            .card-login {
                max-width: 100%;
            }

            .header-top a {
                font-size: 1.5rem;
            }

            .card-header-login h3 {
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

<!-- Login Container -->
<div class="login-container">
    <div class="card-login">
        <div class="card-header-login">
            <h3><i class="fas fa-user-shield"></i> Administrator Login</h3>
        </div>

        <div class="card-body-login">

            <?php if(isset($error)) { ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@twingambit.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your secure password" required>
                </div>

                <button type="submit" name="login" class="btn btn-login w-100">
                    <i class="fas fa-sign-in-alt"></i> Login to Admin Panel
                </button>
            </form>

            <div class="back-link">
                <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Role Selection</a>
            </div>

        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer-custom">
    <p><strong>© 2026 TwinsGambit Company Limited</strong></p>
    <p>Secure Administration Panel</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
