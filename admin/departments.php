<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['employee_id'])) {
    header("Location: ../auth/login.php");
}

if(isset($_POST['add'])) {

    $department_name = $_POST['department_name'];

    mysqli_query($conn,
        "INSERT INTO departments(department_name)
         VALUES('$department_name')"
    );
    
    header("Location: departments.php");
}

if(isset($_GET['delete'])) {

    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM departments WHERE id='$id'");
    
    header("Location: departments.php");
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            <h4>Department Management</h4>
        </div>

        <div class="card-body">

            <form method="POST" class="row g-3 mb-4">

                <div class="col-md-10">
                    <input type="text" name="department_name" class="form-control" placeholder="Department Name" required>
                </div>

                <div class="col-md-2">
                    <button type="submit" name="add" class="btn btn-success w-100">Add Department</button>
                </div>

            </form>

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Department Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $departments = mysqli_query($conn, "SELECT * FROM departments");
                    while($row = mysqli_fetch_assoc($departments)) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['department_name']; ?></td>
                            <td>
                                <a href="departments.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
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
