<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include("db.php");

$errors = [];
$msg = "";

if(isset($_POST['save_student']))
{
    $student_name = trim($_POST['student_name']);
    $roll_number = trim($_POST['roll_number']);
    $registration_number = trim($_POST['registration_number']);
    $email = trim($_POST['email']);
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $section = trim($_POST['section']);
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if(empty($student_name)){
        $errors[] = "Student Name is required.";
    } elseif(!preg_match("/^[a-zA-Z ]+$/", $student_name)){
        $errors[] = "Student Name can only contain letters and spaces.";
    }

    if(empty($roll_number)){
        $errors[] = "Roll Number is required.";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM students WHERE roll_number='$roll_number'");
        if(mysqli_num_rows($check) > 0){
            $errors[] = "Roll Number already exists.";
        }
    }

    if(empty($registration_number)){
        $errors[] = "Registration Number is required.";
    }

    if(empty($email)){
        $errors[] = "Email is required.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid email format.";
    }

    if(empty($branch)){
        $errors[] = "Please select a Branch.";
    }

    if(empty($semester)){
        $errors[] = "Please select a Semester.";
    }

    if(empty($section)){
        $errors[] = "Section is required.";
    } elseif(!preg_match("/^[a-zA-Z0-9 ]+$/", $section)){
        $errors[] = "Section can only contain letters and numbers.";
    }

    if(empty($dob)){
        $errors[] = "Date of Birth is required.";
    }

    if(empty($password)){
        $errors[] = "Password is required.";
    } elseif(strlen($password) < 6){
        $errors[] = "Password must be at least 6 characters.";
    }

    if($password !== $confirm_password){
        $errors[] = "Passwords do not match.";
    }

    // If no errors, insert
    if(empty($errors)){
        $sql = "INSERT INTO students
        (student_name, roll_number, registration_number, email, branch, semester, section, dob, password)
        VALUES
        ('$student_name', '$roll_number', '$registration_number', '$email', '$branch', '$semester', '$section', '$dob', '$password')";

        if(mysqli_query($conn, $sql)){
            $msg = "success";
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        .error-text { color: #dc3545; font-size: 12px; margin-top: 4px; display: none; }
        .is-invalid ~ .error-text { display: block; }
    </style>
</head>

<body style="background:#f8f9fa;">

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

<?php if($msg === "success"): ?>
<div class="alert alert-success text-center mb-0">Student Added Successfully!</div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger mb-0">
    <ul class="mb-0">
        <?php foreach($errors as $e): ?>
            <li><?php echo $e; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="container py-5">
<div class="card shadow-lg p-4">

<h2 class="text-center mb-4" style="color:#352f13;">
    <i class="fa-solid fa-user-plus"></i> Add Student
</h2>

<form action="" method="POST" id="studentForm" novalidate>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Student Name <span class="text-danger">*</span></label>
<input type="text" name="student_name" class="form-control" placeholder="Enter Student Name" value="<?php echo isset($_POST['student_name']) ? htmlspecialchars($_POST['student_name']) : ''; ?>">
<div class="error-text" id="err_name"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Roll Number <span class="text-danger">*</span></label>
<input type="text" name="roll_number" class="form-control" placeholder="Enter Roll Number" value="<?php echo isset($_POST['roll_number']) ? htmlspecialchars($_POST['roll_number']) : ''; ?>">
<div class="error-text" id="err_roll"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Registration Number <span class="text-danger">*</span></label>
<input type="text" name="registration_number" class="form-control" placeholder="Enter Registration Number" value="<?php echo isset($_POST['registration_number']) ? htmlspecialchars($_POST['registration_number']) : ''; ?>">
<div class="error-text" id="err_reg"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Email <span class="text-danger">*</span></label>
<input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
<div class="error-text" id="err_email"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Branch <span class="text-danger">*</span></label>
<select name="branch" class="form-select">
    <option value="">Select Branch</option>
    <option <?php echo (isset($_POST['branch']) && $_POST['branch']=='CSE') ? 'selected' : ''; ?>>CSE</option>
    <option <?php echo (isset($_POST['branch']) && $_POST['branch']=='IT') ? 'selected' : ''; ?>>IT</option>
    <option <?php echo (isset($_POST['branch']) && $_POST['branch']=='ECE') ? 'selected' : ''; ?>>ECE</option>
    <option <?php echo (isset($_POST['branch']) && $_POST['branch']=='EE') ? 'selected' : ''; ?>>EE</option>
    <option <?php echo (isset($_POST['branch']) && $_POST['branch']=='ME') ? 'selected' : ''; ?>>ME</option>
    <option <?php echo (isset($_POST['branch']) && $_POST['branch']=='CE') ? 'selected' : ''; ?>>CE</option>
</select>
<div class="error-text" id="err_branch"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Semester <span class="text-danger">*</span></label>
<select name="semester" class="form-select">
    <option value="">Select Semester</option>
    <?php for($i=1; $i<=8; $i++): ?>
    <option value="<?php echo $i; ?>" <?php echo (isset($_POST['semester']) && $_POST['semester']==$i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
    <?php endfor; ?>
</select>
<div class="error-text" id="err_sem"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Section <span class="text-danger">*</span></label>
<input type="text" name="section" class="form-control" placeholder="e.g. A, B, C" value="<?php echo isset($_POST['section']) ? htmlspecialchars($_POST['section']) : ''; ?>">
<div class="error-text" id="err_section"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Date of Birth <span class="text-danger">*</span></label>
<input type="date" name="dob" class="form-control" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>">
<div class="error-text" id="err_dob"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Password <span class="text-danger">*</span></label>
<input type="password" name="password" class="form-control" placeholder="Min 6 characters">
<div class="error-text" id="err_pass"></div>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Confirm Password <span class="text-danger">*</span></label>
<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
<div class="error-text" id="err_cpass"></div>
</div>

</div>

<div class="text-center mt-4">
<button type="submit" name="save_student" class="btn btn-lg"
style="background:linear-gradient(135deg,#8B7D3C,#7b6638); color:#fff; border:none; border-radius:50px; padding:10px 30px; font-weight:600;">
    <i class="fa-solid fa-floppy-disk"></i> Save Student
</button>
<button type="reset" class="btn btn-lg"
style="background:linear-gradient(135deg,#c0392b,#e74c3c); color:#fff; border:none; border-radius:50px; padding:10px 30px; font-weight:600;">
    <i class="fa-solid fa-rotate-left"></i> Reset
</button>
</div>

</form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("studentForm").addEventListener("submit", function(e){
    let valid = true;

    document.querySelectorAll(".error-text").forEach(el => el.style.display = "none");
    document.querySelectorAll(".form-control, .form-select").forEach(el => el.classList.remove("is-invalid"));

    let name = document.querySelector("[name='student_name']");
    if(!name.value.trim()){
        showError(name, "err_name", "Student Name is required."); valid = false;
    } else if(!/^[a-zA-Z ]+$/.test(name.value.trim())){
        showError(name, "err_name", "Only letters and spaces allowed."); valid = false;
    }

    let roll = document.querySelector("[name='roll_number']");
    if(!roll.value.trim()){
        showError(roll, "err_roll", "Roll Number is required."); valid = false;
    }

    let reg = document.querySelector("[name='registration_number']");
    if(!reg.value.trim()){
        showError(reg, "err_reg", "Registration Number is required."); valid = false;
    }

    let email = document.querySelector("[name='email']");
    if(!email.value.trim()){
        showError(email, "err_email", "Email is required."); valid = false;
    } else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())){
        showError(email, "err_email", "Invalid email format."); valid = false;
    }

    let branch = document.querySelector("[name='branch']");
    if(!branch.value){
        showError(branch, "err_branch", "Please select a Branch."); valid = false;
    }

    let sem = document.querySelector("[name='semester']");
    if(!sem.value){
        showError(sem, "err_sem", "Please select a Semester."); valid = false;
    }

    let section = document.querySelector("[name='section']");
    if(!section.value.trim()){
        showError(section, "err_section", "Section is required."); valid = false;
    }

    let dob = document.querySelector("[name='dob']");
    if(!dob.value){
        showError(dob, "err_dob", "Date of Birth is required."); valid = false;
    }

    let pass = document.querySelector("[name='password']");
    if(!pass.value){
        showError(pass, "err_pass", "Password is required."); valid = false;
    } else if(pass.value.length < 6){
        showError(pass, "err_pass", "Password must be at least 6 characters."); valid = false;
    }

    let cpass = document.querySelector("[name='confirm_password']");
    if(!cpass.value){
        showError(cpass, "err_cpass", "Confirm Password is required."); valid = false;
    } else if(pass.value !== cpass.value){
        showError(cpass, "err_cpass", "Passwords do not match."); valid = false;
    }

    if(!valid) e.preventDefault();
});

function showError(input, errId, msg){
    input.classList.add("is-invalid");
    let errEl = document.getElementById(errId);
    errEl.textContent = msg;
    errEl.style.display = "block";
}
</script>

</body>
</html>