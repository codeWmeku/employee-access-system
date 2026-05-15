<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['employee_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
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

<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: calc(100vh - 80px);">
    
    <div class="container">

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; color: white;">
                    <div class="card-body p-4">
                        <h2 class="mb-0"><i class="fas fa-lock"></i> Permission Management</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Assign New Permission -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Assign New Permission</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($success)) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php } ?>

                        <?php if(isset($error)) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php } ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user-tie"></i> Select Employee</label>
                                <select name="employee_id" class="form-control" style="border-radius: 8px; border: 2px solid #e0e0e0;" required>
                                    <option value="">-- Choose an Employee --</option>
                                    <?php
                                    $employees = mysqli_query($conn, "SELECT * FROM employees WHERE role='employee' ORDER BY fullname");
                                    while($row = mysqli_fetch_assoc($employees)) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['fullname']; ?> (<?php echo $row['email']; ?>)
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-building"></i> Select Department</label>
                                <select name="department_id" class="form-control" style="border-radius: 8px; border: 2px solid #e0e0e0;" required>
                                    <option value="">-- Choose a Department --</option>
                                    <?php
                                    $departments = mysqli_query($conn, "SELECT * FROM departments ORDER BY department_name");
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

                            <button type="submit" name="add_permission" class="btn w-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; font-weight: 600; padding: 0.75rem;">
                                <i class="fas fa-check"></i> Assign Permission
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Filter Permissions -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Permissions</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="GET">
                            <label class="form-label"><i class="fas fa-search"></i> Filter by Employee</label>
                            <select name="filter_employee" class="form-control mb-3" style="border-radius: 8px; border: 2px solid #e0e0e0;">
                                <option value="">-- All Employees --</option>
                                <?php
                                $employees = mysqli_query($conn, "SELECT * FROM employees WHERE role='employee' ORDER BY fullname");
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
                            <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 8px; font-weight: 600; padding: 0.75rem;">
                                <i class="fas fa-search"></i> Apply Filter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Permissions Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-list"></i> Current Permissions</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                <tr>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-hashtag"></i> ID</th>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-user-tie"></i> Employee</th>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-building"></i> Department</th>
                                    <th style="padding: 1.2rem; font-weight: 600; text-align: center;"><i class="fas fa-cog"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT p.id, e.fullname, e.email, d.department_name 
                                          FROM permissions p 
                                          JOIN employees e ON p.employee_id = e.id 
                                          JOIN departments d ON p.department_id = d.id";
                                
                                if(isset($_GET['filter_employee']) && $_GET['filter_employee'] != '') {
                                    $filter_id = $_GET['filter_employee'];
                                    $query .= " WHERE e.id = '$filter_id'";
                                }
                                
                                $query .= " ORDER BY e.fullname ASC, d.department_name ASC";
                                $permissions = mysqli_query($conn, $query);
                                
                                if(mysqli_num_rows($permissions) > 0) {
                                    while($row = mysqli_fetch_assoc($permissions)) {
                                        ?>
                                        <tr style="border-bottom: 1px solid #f0f0f0;">
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;"><strong>#<?php echo $row['id']; ?></strong></td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <i class="fas fa-user-circle" style="color: #667eea; margin-right: 8px;"></i>
                                                <?php echo $row['fullname']; ?><br>
                                                <small class="text-muted"><?php echo $row['email']; ?></small>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                                <i class="fas fa-building" style="color: #28a745; margin-right: 8px;"></i>
                                                <?php echo $row['department_name']; ?>
                                            </td>
                                            <td style="padding: 1rem 1.2rem; vertical-align: middle; text-align: center;">
                                                <a href="permissions.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" style="border-radius: 6px; padding: 0.4rem 0.8rem; font-size: 0.85rem;" onclick="return confirm('Are you sure you want to revoke this permission?')">
                                                    <i class="fas fa-ban"></i> Revoke
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="4" class="text-center p-4"><i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i><p class="text-muted mt-2">No permissions found</p></td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.7rem;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }

        .btn {
            padding: 0.4rem 0.6rem !important;
            font-size: 0.8rem !important;
        }
    }
</style>

<?php include '../includes/footer.php'; ?>
