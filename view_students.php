<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include("db.php");

$students = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #352f13, #917b53, #7b6638);">
<div class="container">
    <a class="navbar-brand fw-bold" href="admin_dashboard.php">
        <i class="fa-solid fa-user-shield"></i> Admin Panel
    </a>
    <a href="admin_dashboard.php" class="btn btn-light">
        <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
</div>
</nav>

<div class="container py-5">

<?php if(isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
<div class="alert alert-success">Student updated successfully!</div>
<?php endif; ?>
<?php if(isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
<div class="alert alert-success">Student deleted successfully!</div>
<?php endif; ?>

<h2 class="mb-4" style="color:#352f13;"><i class="fa-solid fa-users"></i> All Students</h2>

<div class="card shadow-lg p-4">
<div class="table-responsive">
<table class="table table-bordered table-hover text-center align-middle">
<thead class="table-primary">
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Roll No</th>
    <th>Reg No</th>
    <th>Email</th>
    <th>Branch</th>
    <th>Sem</th>
    <th>Section</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
while ($row = mysqli_fetch_assoc($students)) {
?>
<tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
    <td><?php echo htmlspecialchars($row['roll_number']); ?></td>
    <td><?php echo htmlspecialchars($row['registration_number']); ?></td>
    <td><?php echo htmlspecialchars($row['email']); ?></td>
    <td><?php echo htmlspecialchars($row['branch']); ?></td>
    <td><?php echo htmlspecialchars($row['semester']); ?></td>
    <td><?php echo htmlspecialchars($row['section']); ?></td>
    <td>
        <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
            <i class="fa-solid fa-pen"></i> Edit
        </a>
        <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
           onclick="return confirm('Are you sure you want to delete this student?');">
            <i class="fa-solid fa-trash"></i> Delete
        </a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>