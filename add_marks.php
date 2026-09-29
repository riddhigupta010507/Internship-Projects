<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include("db.php");

$errors = [];
$message = "";

if (isset($_POST['save_marks'])) {

    $student_id = $_POST['student_id'];
    $math_internal = $_POST['mathematics_internal'];
    $math_external = $_POST['mathematics_external'];
    $phy_internal = $_POST['physics_internal'];
    $phy_external = $_POST['physics_external'];
    $prog_internal = $_POST['programming_c_internal'];
    $prog_external = $_POST['programming_c_external'];
    $eng_internal = $_POST['english_internal'];
    $eng_external = $_POST['english_external'];
    $egraphics_internal = $_POST['engineering_graphics_internal'];
    $egraphics_external = $_POST['engineering_graphics_external'];

    // Validation
    if(empty($student_id)){
        $errors[] = "Please select a student.";
    }

    $subjects = [
        'Mathematics' => ['internal' => $math_internal, 'external' => $math_external, 'max_i' => 30, 'max_e' => 70],
        'Physics' => ['internal' => $phy_internal, 'external' => $phy_external, 'max_i' => 30, 'max_e' => 70],
        'Programming in C' => ['internal' => $prog_internal, 'external' => $prog_external, 'max_i' => 30, 'max_e' => 70],
        'English' => ['internal' => $eng_internal, 'external' => $eng_external, 'max_i' => 30, 'max_e' => 70],
        'Engineering Graphics' => ['internal' => $egraphics_internal, 'external' => $egraphics_external, 'max_i' => 30, 'max_e' => 70],
    ];

    foreach($subjects as $subj => $data){
        if($data['internal'] === '' || $data['external'] === ''){
            $errors[] = "Please fill all marks for $subj.";
        } elseif(!is_numeric($data['internal']) || !is_numeric($data['external'])){
            $errors[] = "Marks for $subj must be numbers.";
        } elseif($data['internal'] < 0 || $data['internal'] > $data['max_i']){
            $errors[] = "$subj internal marks must be between 0 and {$data['max_i']}.";
        } elseif($data['external'] < 0 || $data['external'] > $data['max_e']){
            $errors[] = "$subj external marks must be between 0 and {$data['max_e']}.";
        }
    }

    if(empty($errors)){
        $mathematics = $math_internal + $math_external;
        $physics = $phy_internal + $phy_external;
        $programming_c = $prog_internal + $prog_external;
        $english = $eng_internal + $eng_external;
        $engineering_graphics = $egraphics_internal + $egraphics_external;

        $total = $mathematics + $physics + $programming_c + $english + $engineering_graphics;
        $percentage = $total / 5;

        if ($percentage >= 90) { $grade = "A+"; }
        elseif ($percentage >= 80) { $grade = "A"; }
        elseif ($percentage >= 70) { $grade = "B"; }
        elseif ($percentage >= 60) { $grade = "C"; }
        else { $grade = "D"; }

        $status = ($percentage >= 40) ? "Pass" : "Fail";

        $sql = "INSERT INTO marks
        (student_id, mathematics, physics, programming_c, english, engineering_graphics, total, percentage, grade, status)
        VALUES
        ('$student_id', '$mathematics', '$physics', '$programming_c', '$english', '$engineering_graphics', '$total', '$percentage', '$grade', '$status')";

        if (mysqli_query($conn, $sql)) {
            $message = "success";
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
    <title>Add Student Marks</title>

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

<?php if($message === "success"): ?>
<div class="alert alert-success text-center mb-0">Marks saved successfully!</div>
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
    <i class="fa-solid fa-pen-to-square"></i> Add Student Marks
</h2>

<form action="" method="POST" id="marksForm" novalidate>

<label class="form-label fw-semibold">Select Student <span class="text-danger">*</span></label>
<select name="student_id" class="form-select" id="studentSelect">
    <option value="">Select Student</option>
    <?php
    $students = mysqli_query($conn, "SELECT id, student_name, roll_number FROM students");
    while ($row = mysqli_fetch_assoc($students)) {
    ?>
        <option value="<?php echo $row['id']; ?>" <?php echo (isset($_POST['student_id']) && $_POST['student_id']==$row['id']) ? 'selected' : ''; ?>>
            <?php echo $row['student_name'] . " - " . $row['roll_number']; ?>
        </option>
    <?php } ?>
</select>
<div class="error-text" id="err_student"></div>

<hr>

<h4 class="mb-4" style="color:#352f13;">Subject Wise Marks</h4>

<div class="table-responsive">
<table class="table table-bordered text-center align-middle">
<thead style="background: linear-gradient(135deg, #8B7D3C, #C4A94D); color:#fff;">
<tr>
    <th>Subject</th>
    <th>Internal (30)</th>
    <th>External (70)</th>
</tr>
</thead>
<tbody>
<tr>
    <td>Mathematics</td>
    <td><input type="number" name="mathematics_internal" class="form-control internal" min="0" max="30" value="<?php echo isset($_POST['mathematics_internal']) ? $_POST['mathematics_internal'] : ''; ?>"></td>
    <td><input type="number" name="mathematics_external" class="form-control external" min="0" max="70" value="<?php echo isset($_POST['mathematics_external']) ? $_POST['mathematics_external'] : ''; ?>"></td>
</tr>
<tr>
    <td>Physics</td>
    <td><input type="number" name="physics_internal" class="form-control internal" min="0" max="30" value="<?php echo isset($_POST['physics_internal']) ? $_POST['physics_internal'] : ''; ?>"></td>
    <td><input type="number" name="physics_external" class="form-control external" min="0" max="70" value="<?php echo isset($_POST['physics_external']) ? $_POST['physics_external'] : ''; ?>"></td>
</tr>
<tr>
    <td>Programming in C</td>
    <td><input type="number" name="programming_c_internal" class="form-control internal" min="0" max="30" value="<?php echo isset($_POST['programming_c_internal']) ? $_POST['programming_c_internal'] : ''; ?>"></td>
    <td><input type="number" name="programming_c_external" class="form-control external" min="0" max="70" value="<?php echo isset($_POST['programming_c_external']) ? $_POST['programming_c_external'] : ''; ?>"></td>
</tr>
<tr>
    <td>English</td>
    <td><input type="number" name="english_internal" class="form-control internal" min="0" max="30" value="<?php echo isset($_POST['english_internal']) ? $_POST['english_internal'] : ''; ?>"></td>
    <td><input type="number" name="english_external" class="form-control external" min="0" max="70" value="<?php echo isset($_POST['english_external']) ? $_POST['english_external'] : ''; ?>"></td>
</tr>
<tr>
    <td>Engineering Graphics</td>
    <td><input type="number" name="engineering_graphics_internal" class="form-control internal" min="0" max="30" value="<?php echo isset($_POST['engineering_graphics_internal']) ? $_POST['engineering_graphics_internal'] : ''; ?>"></td>
    <td><input type="number" name="engineering_graphics_external" class="form-control external" min="0" max="70" value="<?php echo isset($_POST['engineering_graphics_external']) ? $_POST['engineering_graphics_external'] : ''; ?>"></td>
</tr>
</tbody>
</table>
</div>

<div class="row mt-4">
<div class="col-md-3 mb-3">
    <label class="form-label">Total Marks</label>
    <input type="text" id="totalMarks" class="form-control" readonly>
</div>
<div class="col-md-3 mb-3">
    <label class="form-label">Percentage</label>
    <input type="text" id="percentage" class="form-control" readonly>
</div>
<div class="col-md-3 mb-3">
    <label class="form-label">Grade</label>
    <input type="text" id="grade" class="form-control" readonly>
</div>
<div class="col-md-3 mb-3">
    <label class="form-label">Status</label>
    <input type="text" id="status" class="form-control" readonly>
</div>
</div>

<div class="text-center mt-4">
<button type="button" class="btn btn-lg me-3" onclick="calculateResult()"
style="background:linear-gradient(135deg,#8B7D3C,#7b6638); color:#fff; border:none; border-radius:50px; padding:10px 30px; font-weight:600;">
    <i class="fa-solid fa-calculator"></i> Calculate
</button>
<button type="submit" name="save_marks" class="btn btn-lg me-3"
style="background:linear-gradient(135deg,#8B7D3C,#C4A94D); color:#fff; border:none; border-radius:50px; padding:10px 30px; font-weight:600;">
    <i class="fa-solid fa-floppy-disk"></i> Save Marks
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
function calculateResult(){
    let total = 0;
    let internals = document.querySelectorAll(".internal");
    let externals = document.querySelectorAll(".external");

    for(let i = 0; i < internals.length; i++){
        total += Number(internals[i].value) || 0;
        total += Number(externals[i].value) || 0;
    }

    let percentage = (total / 500) * 100;
    document.getElementById("totalMarks").value = total;
    document.getElementById("percentage").value = percentage.toFixed(2) + " %";

    if(percentage >= 90){
        document.getElementById("grade").value = "A+";
        document.getElementById("status").value = "PASS";
    } else if(percentage >= 80){
        document.getElementById("grade").value = "A";
        document.getElementById("status").value = "PASS";
    } else if(percentage >= 70){
        document.getElementById("grade").value = "B";
        document.getElementById("status").value = "PASS";
    } else if(percentage >= 60){
        document.getElementById("grade").value = "C";
        document.getElementById("status").value = "PASS";
    } else {
        document.getElementById("grade").value = "F";
        document.getElementById("status").value = "FAIL";
    }
}

document.getElementById("marksForm").addEventListener("submit", function(e){
    let valid = true;
    document.querySelectorAll(".error-text").forEach(el => el.style.display = "none");
    document.querySelectorAll("select, input[type='number']").forEach(el => el.classList.remove("is-invalid"));

    let student = document.getElementById("studentSelect");
    if(!student.value){
        showErr(student, "err_student", "Please select a student."); valid = false;
    }

    let inputs = document.querySelectorAll(".internal, .external");
    let names = ["Mathematics Internal", "Mathematics External", "Physics Internal", "Physics External",
                 "Programming C Internal", "Programming C External", "English Internal", "English External",
                 "Engineering Graphics Internal", "Engineering Graphics External"];
    let maxVals = [30, 70, 30, 70, 30, 70, 30, 70, 30, 70];

    for(let i = 0; i < inputs.length; i++){
        let val = inputs[i].value;
        if(val === ""){
            inputs[i].classList.add("is-invalid");
            inputs[i].insertAdjacentHTML("afterend", '<div class="error-text" style="display:block;">Required.</div>');
            valid = false;
        } else if(isNaN(val) || Number(val) < 0 || Number(val) > maxVals[i]){
            inputs[i].classList.add("is-invalid");
            inputs[i].insertAdjacentHTML("afterend", '<div class="error-text" style="display:block;">Must be 0-' + maxVals[i] + '.</div>');
            valid = false;
        }
    }

    if(!valid) e.preventDefault();
});

function showErr(input, errId, msg){
    input.classList.add("is-invalid");
    let el = document.getElementById(errId);
    el.textContent = msg;
    el.style.display = "block";
}
</script>

</body>
</html>