<?php
// Database Configuration
$host = "localhost";
$user = "root";
$password = "1234"; 
$database = "employee_access_system";

// Attempt connection
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    // If connection fails, display helpful error message
    $error = mysqli_connect_error();
    
    if (strpos($error, "Access denied") !== false) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Database Connection Error</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body class='bg-light'>
            <div class='container mt-5'>
                <div class='row justify-content-center'>
                    <div class='col-md-6'>
                        <div class='card shadow'>
                            <div class='card-header bg-danger text-white'>
                                <h4>Database Connection Error</h4>
                            </div>
                            <div class='card-body'>
                                <h5>Error: Access Denied</h5>
                                <p class='text-muted'>The database connection failed. Please follow the steps below:</p>
                                
                                <div class='alert alert-info'>
                                    <strong>Solution 1: If you have a MySQL root password</strong>
                                    <ol>
                                        <li>Open <code>config/db.php</code></li>
                                        <li>Update line: <code>\$password = \"yourpassword\";</code></li>
                                        <li>Replace 'yourpassword' with your actual MySQL password</li>
                                        <li>Save and refresh this page</li>
                                    </ol>
                                </div>
                                
                                <div class='alert alert-warning'>
                                    <strong>Solution 2: Reset MySQL Root Password</strong>
                                    <ol>
                                        <li>Open Command Prompt as Administrator</li>
                                        <li>Stop MySQL: <code>net stop MySQL80</code></li>
                                        <li>Start with skip-grant-tables: 
                                            <code>\"C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqld.exe\" --skip-grant-tables</code>
                                        </li>
                                        <li>In another Command Prompt: <code>mysql -u root</code></li>
                                        <li>Execute: <code>FLUSH PRIVILEGES;</code></li>
                                        <li>Execute: <code>ALTER USER 'root'@'localhost' IDENTIFIED BY '';</code></li>
                                        <li>Restart MySQL normally</li>
                                    </ol>
                                </div>
                                
                                <div class='alert alert-success'>
                                    <strong>Solution 3: Import Database Schema</strong>
                                    <ol>
                                        <li>Once connected, import the database: <br>
                                            <code>mysql -u root < database/employee_access_system.sql</code>
                                        </li>
                                    </ol>
                                </div>
                                
                                <div class='mt-3'>
                                    <a href='/' class='btn btn-primary'>Retry Connection</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>";
        exit;
    } else {
        die("Connection Failed: " . $error);
    }
}
?>