<?php
session_start();

// If already logged in, redirect
if(isset($_SESSION['employee_id'])) {
    if($_SESSION['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../employee-dashboard.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TwinsGambit Company Limited - Employee Access System</title>
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

        /* Navigation */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-custom .brand-logo {
            font-weight: 800;
            font-size: 1.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-custom .brand-logo i {
            margin-right: 8px;
        }

        /* Hero Section */
        .hero-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px 60px 20px;
            text-align: center;
        }

        .hero-content {
            max-width: 900px;
            color: white;
            animation: fadeInDown 0.8s ease;
            margin: 0;
            padding: 0;
        }

        .company-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin: 0 !important;
            padding: 0 !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .company-tagline {
            font-size: 1.5rem;
            margin: 30px 0 0 0 !important;
            padding: 0 !important;
            opacity: 0.95;
            font-weight: 300;
        }

        .tagline-icon {
            margin: 0 !important;
            padding: 0 !important;
            display: block;
            text-align: center;
            line-height: 0;
            height: auto;
            overflow: visible;
        }

        .tagline-icon img {
            max-width: 900px;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.2));
            display: block;
            margin: 0 auto !important;
            padding: 0 !important;
            vertical-align: top;
        }

        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 25px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            color: white;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: block;
        }

        .feature-card h5 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Role Selection */
        .role-selection {
            margin: 50px 0 60px 0;
        }

        .role-selection h3 {
            color: white;
            font-weight: 700;
            margin-bottom: 40px;
            font-size: 2rem;
        }

        .role-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .role-btn {
            background: white;
            color: #667eea;
            border: none;
            border-radius: 15px;
            padding: 40px 30px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .role-btn:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            color: #764ba2;
        }

        .role-btn .role-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .role-btn h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .role-btn p {
            font-size: 0.95rem;
            opacity: 0.8;
            margin: 0;
        }

        /* Register Link */
        .register-section {
            color: white;
            font-size: 1.1rem;
            margin: 30px 0;
        }

        .register-section a {
            color: white;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 2px solid white;
            transition: all 0.3s ease;
        }

        .register-section a:hover {
            opacity: 0.8;
        }

        /* Footer */
        .footer-custom {
            background: rgba(0, 0, 0, 0.3);
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-custom p {
            margin: 5px 0;
            opacity: 0.9;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .role-btn {
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .company-title {
                font-size: 2.5rem;
            }

            .company-tagline {
                font-size: 1.1rem;
            }

            .tagline-icon img {
                max-width: 600px;
            }

            .features-grid {
                gap: 15px;
                margin: 30px 0;
            }

            .role-selection h3 {
                font-size: 1.5rem;
            }

            .role-btn {
                padding: 30px 20px;
            }

            .role-btn .role-icon {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar-custom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <i class="fas fa-crown"></i>TwinsGambit
            </div>
            <small style="color: #667eea; font-weight: 500;">Employee Access System</small>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <div class="tagline-icon">
            <img src="../assets/logo.png" alt="TwinsGambit Logo" />
        </div>

        <h1 class="company-title">TwinsGambit Company Limited</h1>
        <p class="company-tagline">Secure. Professional. Efficient.</p>

        <!-- Features -->
        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon"><i class="fas fa-shield-alt"></i></span>
                <h5>Secure Access</h5>
                <p>Enterprise-grade security for your employee data</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon"><i class="fas fa-users-cog"></i></span>
                <h5>Easy Management</h5>
                <p>Streamlined employee and department management</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon"><i class="fas fa-chart-line"></i></span>
                <h5>Complete Control</h5>
                <p>Full oversight with comprehensive access logs</p>
            </div>
        </div>

        <!-- Role Selection -->
        <div class="role-selection">
            <h3>Get Started</h3>
            <div class="role-buttons">
                <a href="employee-login.php" class="role-btn">
                    <span class="role-icon"><i class="fas fa-user-tie"></i></span>
                    <h4>Employee</h4>
                    <p>Access your workspace</p>
                </a>
                <a href="admin-login.php" class="role-btn">
                    <span class="role-icon"><i class="fas fa-user-secret"></i></span>
                    <h4>Administrator</h4>
                    <p>Manage the system</p>
                </a>
            </div>
        </div>

        <!-- Register Link -->
        <div class="register-section">
            <p>New employee? <a href="register.php">Request Access</a></p>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer-custom">
    <p><strong>© 2026 TwinsGambit Company Limited</strong></p>
    <p>Employee Access Management System v1.0</p>
    <p>Building excellence through secure collaboration</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>