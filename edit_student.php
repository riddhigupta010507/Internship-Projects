<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include("db.php");

if (!isset($_GET['id'])) {
    header("Location: view_students.php");
    exit();
}

$id = intval($_GET['id']);


// Fetch student

$sql = "SELECT * FROM students WHERE id = $id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("Student not found.");
}

$student = mysqli_fetch_assoc($result);


// Update student

if (isset($_POST['update_student'])) {

    $student_name = $_POST['student_name'];
    $roll_number = $_POST['roll_number'];
    $registration_number = $_POST['registration_number'];
    $email = $_POST['email'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $dob = $_POST['dob'];


    $update_sql = "UPDATE students SET

        student_name = '$student_name',
        roll_number = '$roll_number',
        registration_number = '$registration_number',
        email = '$email',
        branch = '$branch',
        semester = '$semester',
        section = '$section',
        dob = '$dob'

        WHERE id = $id";


    if (mysqli_query($conn, $update_sql)) {

        header("Location: view_students.php?status=updated");
        exit();

    } else {

        echo "Error: " . mysqli_error($conn);

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<nav class="navbar navbar-dark" style="background: linear-gradient(135deg, #352f13, #917b53, #7b6638);">

    <div class="container">

        <a href="admin_dashboard.php"
           class="navbar-brand">

            Admin Dashboard

        </a>

        <a href="view_students.php"
           class="btn btn-light">

            Back

        </a>

    </div>

</nav>


<div class="container py-5">

    <div class="card shadow mx-auto"
         style="max-width:700px;">

        <div class="card-body">

            <h2 class="text-center mb-4" style="color:#352f13;">

                <i class="fa-solid fa-user-pen"></i>

                Edit Student

            </h2>


            <form method="POST">


                <div class="mb-3">

                    <label>Student Name</label>

                    <input type="text"
                           name="student_name"
                           class="form-control"
                           value="<?php echo htmlspecialchars($student['student_name']); ?>"
                           required>

                </div>


                <div class="mb-3">

                    <label>Roll Number</label>

                    <input type="text"
                           name="roll_number"
                           class="form-control"
                           value="<?php echo htmlspecialchars($student['roll_number']); ?>"
                           required>

                </div>


                <div class="mb-3">

                    <label>Registration Number</label>

                    <input type="text"
                           name="registration_number"
                           class="form-control"
                           value="<?php echo htmlspecialchars($student['registration_number']); ?>"
                           required>

                </div>


                <div class="mb-3">

                    <label>Email</label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?php echo htmlspecialchars($student['email']); ?>"
                           required>

                </div>


                <div class="mb-3">

                    <label>Branch</label>

                    <input type="text"
                           name="branch"
                           class="form-control"
                           value="<?php echo htmlspecialchars($student['branch']); ?>"
                           required>

                </div>


                <div class="mb-3">

                    <label>Semester</label>

                    <input type="number"
                           name="semester"
                           class="form-control"
                           value="<?php echo htmlspecialchars($student['semester']); ?>"
                           required>

                </div>


                <div class="mb-3">

                    <label>Section</label>

                    <input type="text"
                           name="section"
                           class="form-control"
                           value="<?php echo htmlspecialchars($student['section']); ?>"
                           required>

                </div>


                <div class="mb-3">

                    <label>Date of Birth</label>

                    <input type="date"
                           name="dob"
                           class="form-control"
                           value="<?php echo htmlspecialchars($student['dob']); ?>"
                           required>

                </div>


                <button type="submit"
                        name="update_student"
                        class="btn btn-lg w-100"
                        style="background:linear-gradient(135deg,#8B7D3C,#7b6638); color:#fff; border:none; border-radius:50px; padding:12px; font-weight:600;">

                    <i class="fa-solid fa-pen-to-square"></i>

                    Update Student

                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>