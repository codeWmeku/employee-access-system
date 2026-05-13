<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['employee_id'])) {
    header("Location: ../auth/login.php");
}

if(isset($_POST['add'])) {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,
        "INSERT INTO employees(fullname,email,password)
         VALUES('$fullname','$email','$password')"
    );
    
    header("Location: employees.php");
}

if(isset($_GET['delete'])) {

    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM employees WHERE id='$id'");
    
    header("Location: employees.php");
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            <h4>Employee Management</h4>
        </div>

        <div class="card-body">

            <form method="POST" class="row g-3 mb-4">

                <div class="col-md-4">
                    <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                </div>

                <div class="col-md-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>

                <div class="col-md-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="col-md-2">
                    <button type="submit" name="add" class="btn btn-success w-100">Add Employee</button>
                </div>

            </form>

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $employees = mysqli_query($conn, "SELECT * FROM employees");
                    while($row = mysqli_fetch_assoc($employees)) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td>
                                <a href="employees.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>