<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['employee_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
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

<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: calc(100vh - 80px);">
    
    <div class="container">

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; color: white;">
                    <div class="card-body p-4">
                        <h2 class="mb-0"><i class="fas fa-building"></i> Department Management</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Department Form -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Add New Department</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" class="row g-3">
                            <div class="col-md-10">
                                <label class="form-label"><i class="fas fa-briefcase"></i> Department Name</label>
                                <input type="text" name="department_name" class="form-control" style="border-radius: 8px; border: 2px solid #e0e0e0;" placeholder="e.g. Sales, Engineering, Marketing..." required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" name="add" class="btn w-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; font-weight: 600;">
                                    <i class="fas fa-plus"></i> Add Department
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0"><i class="fas fa-list"></i> All Departments</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                <tr>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-hashtag"></i> ID</th>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-building"></i> Department Name</th>
                                    <th style="padding: 1.2rem; font-weight: 600;"><i class="fas fa-users"></i> Employees</th>
                                    <th style="padding: 1.2rem; font-weight: 600; text-align: center;"><i class="fas fa-cog"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $departments = mysqli_query($conn, "SELECT * FROM departments ORDER BY id DESC");
                                $count = 0;
                                while($row = mysqli_fetch_assoc($departments)) {
                                    $count++;
                                    // Count employees in this department
                                    $emp_count_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM permissions WHERE department_id='{$row['id']}'");
                                    $emp_count_row = mysqli_fetch_assoc($emp_count_query);
                                    $emp_count = $emp_count_row['count'];
                                    ?>
                                    <tr style="border-bottom: 1px solid #f0f0f0;">
                                        <td style="padding: 1rem 1.2rem; vertical-align: middle;"><strong>#<?php echo $row['id']; ?></strong></td>
                                        <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                            <i class="fas fa-briefcase" style="color: #28a745; margin-right: 8px;"></i>
                                            <?php echo $row['department_name']; ?>
                                        </td>
                                        <td style="padding: 1rem 1.2rem; vertical-align: middle;">
                                            <span class="badge bg-info" style="font-size: 0.85rem;">
                                                <i class="fas fa-users"></i> <?php echo $emp_count; ?> employee<?php echo ($emp_count != 1) ? 's' : ''; ?>
                                            </span>
                                        </td>
                                        <td style="padding: 1rem 1.2rem; vertical-align: middle; text-align: center;">
                                            <a href="departments.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" style="border-radius: 6px; padding: 0.4rem 0.8rem; font-size: 0.85rem;" onclick="return confirm('Are you sure you want to delete this department? This will also remove all associated permissions.')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if($count == 0) {
                                    echo '<tr><td colspan="4" class="text-center p-4"><i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i><p class="text-muted mt-2">No departments found</p></td></tr>';
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
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.7rem;
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
