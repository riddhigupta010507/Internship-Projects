<?php
session_start();

include("db.php");

$roll = isset($_GET['roll']) ? $_GET['roll'] : '';
$student = null;
$marks = null;

if ($roll !== "") {
    $student_q = mysqli_query($conn, "SELECT * FROM students WHERE roll_number = '" . mysqli_real_escape_string($conn, $roll) . "'");
    if ($student_q && mysqli_num_rows($student_q) > 0) {
        $student = mysqli_fetch_assoc($student_q);
        $marks_q = mysqli_query($conn, "SELECT * FROM marks WHERE student_id = " . $student['id']);
        if ($marks_q && mysqli_num_rows($marks_q) > 0) {
            $marks = mysqli_fetch_assoc($marks_q);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #352f13, #917b53, #7b6638);">
<div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
        <i class="fa-solid fa-graduation-cap"></i> Student Result Viewer
    </a>
    <a href="student_dashboard.php" class="btn btn-light">
        <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
</div>
</nav>

<div class="container py-5">

<!-- Search -->
<div class="card shadow-lg p-4 mb-4">
    <h3 class="text-center mb-4"><i class="fa-solid fa-magnifying-glass"></i> Search Result</h3>
    <form method="GET" class="row align-items-center">
        <div class="col-md-9 mb-3">
            <input type="text" name="roll" class="form-control form-control-lg" placeholder="Enter Roll Number" value="<?php echo htmlspecialchars($roll); ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary btn-lg w-100">Search</button>
        </div>
    </form>
</div>

<?php if ($roll !== "" && $student): ?>

<!-- Student Details -->
<div class="card shadow-lg p-4 mb-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>Name :</strong> <?php echo htmlspecialchars($student['student_name']); ?></p>
            <p><strong>Roll Number :</strong> <?php echo htmlspecialchars($student['roll_number']); ?></p>
            <p><strong>Registration No :</strong> <?php echo htmlspecialchars($student['registration_number']); ?></p>
        </div>
        <div class="col-md-6">
            <p><strong>Branch :</strong> <?php echo htmlspecialchars($student['branch']); ?></p>
            <p><strong>Semester :</strong> <?php echo htmlspecialchars($student['semester']); ?></p>
            <p><strong>Section :</strong> <?php echo htmlspecialchars($student['section']); ?></p>
        </div>
    </div>
</div>

<?php if ($marks): ?>
<!-- Marks Table -->
<div class="card shadow-lg p-4 mb-4">
    <h4 class="mb-4">Subject Wise Marks</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-primary">
                <tr>
                    <th>Subject</th>
                    <th>Marks</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Mathematics</td><td><?php echo $marks['mathematics']; ?></td></tr>
                <tr><td>Physics</td><td><?php echo $marks['physics']; ?></td></tr>
                <tr><td>Programming in C</td><td><?php echo $marks['programming_c']; ?></td></tr>
                <tr><td>English</td><td><?php echo $marks['english']; ?></td></tr>
                <tr><td>Engineering Graphics</td><td><?php echo $marks['engineering_graphics']; ?></td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Summary -->
<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow text-center p-3">
            <h5>Total Marks</h5>
            <h3 class="text-primary"><?php echo $marks['total']; ?> / 500</h3>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow text-center p-3">
            <h5>Percentage</h5>
            <h3 class="text-success"><?php echo $marks['percentage']; ?>%</h3>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow text-center p-3">
            <h5>Grade</h5>
            <h3 class="text-warning"><?php echo $marks['grade']; ?></h3>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow text-center p-3">
            <h5>Result</h5>
            <h3 class="<?php echo $marks['status'] == 'Pass' ? 'text-success' : 'text-danger'; ?>"><?php echo $marks['status']; ?></h3>
        </div>
    </div>
</div>

<?php else: ?>
<div class="alert alert-warning text-center">No marks found for this student.</div>
<?php endif; ?>

<?php elseif ($roll !== ""): ?>
<div class="alert alert-danger text-center">No student found with roll number: <?php echo htmlspecialchars($roll); ?></div>
<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>