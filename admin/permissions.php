<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['employee_id'])) {
    header("Location: ../auth/login.php");
}

// Add permission
if(isset($_POST['add_permission'])) {

    $employee_id = $_POST['employee_id'];
    $department_id = $_POST['department_id'];

    // Check if permission already exists
    $check = mysqli_query($conn, "SELECT * FROM permissions WHERE employee_id='$employee_id' AND department_id='$department_id'");
    
    if(mysqli_num_rows($check) == 0) {
        mysqli_query($conn,
            "INSERT INTO permissions(employee_id, department_id)
             VALUES('$employee_id','$department_id')"
        );
        $success = "Permission added successfully!";
    } else {
        $error = "This permission already exists!";
    }
}

// Delete permission
if(isset($_GET['delete'])) {

    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM permissions WHERE id='$id'");
    
    header("Location: permissions.php");
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">

                <div class="card-header bg-dark text-white">
                    <h4>Assign Permissions</h4>
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
                            <label class="form-label">Select Employee</label>
                            <select name="employee_id" class="form-control" required>
                                <option value="">-- Choose Employee --</option>
                                <?php
                                $employees = mysqli_query($conn, "SELECT * FROM employees");
                                while($row = mysqli_fetch_assoc($employees)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['fullname']; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Department</label>
                            <select name="department_id" class="form-control" required>
                                <option value="">-- Choose Department --</option>
                                <?php
                                $departments = mysqli_query($conn, "SELECT * FROM departments");
                                while($row = mysqli_fetch_assoc($departments)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['department_name']; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" name="add_permission" class="btn btn-success w-100">Add Permission</button>

                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">

                <div class="card-header bg-dark text-white">
                    <h4>View Employee Access</h4>
                </div>

                <div class="card-body">

                    <form method="GET" class="mb-3">

                        <label class="form-label">Filter by Employee</label>
                        <select name="filter_employee" class="form-control mb-2">
                            <option value="">-- All Employees --</option>
                            <?php
                            $employees = mysqli_query($conn, "SELECT * FROM employees");
                            while($row = mysqli_fetch_assoc($employees)) {
                                $selected = (isset($_GET['filter_employee']) && $_GET['filter_employee'] == $row['id']) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                    <?php echo $row['fullname']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>

                        <button type="submit" class="btn btn-primary w-100">Filter</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mt-4">

        <div class="card-header bg-dark text-white">
            <h4>Current Permissions</h4>
        </div>

        <div class="card-body">

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT p.id, e.fullname, d.department_name 
                              FROM permissions p 
                              JOIN employees e ON p.employee_id = e.id 
                              JOIN departments d ON p.department_id = d.id";
                    
                    if(isset($_GET['filter_employee']) && $_GET['filter_employee'] != '') {
                        $filter_id = $_GET['filter_employee'];
                        $query .= " WHERE e.id = '$filter_id'";
                    }
                    
                    $permissions = mysqli_query($conn, $query);
                    
                    if(mysqli_num_rows($permissions) > 0) {
                        while($row = mysqli_fetch_assoc($permissions)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['department_name']; ?></td>
                                <td>
                                    <a href="permissions.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Revoke</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="4" class="text-center">No permissions found</td>
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
