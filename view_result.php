<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include("db.php");

$sql = "SELECT * FROM students ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>View Students</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<nav class="navbar navbar-dark bg-primary">

    <div class="container">

        <a href="admin_dashboard.php"
           class="navbar-brand fw-bold">

            <i class="fa-solid fa-user-shield"></i>

            Admin Dashboard

        </a>

        <a href="admin_dashboard.php"
           class="btn btn-light">

            <i class="fa-solid fa-arrow-left"></i>

            Dashboard

        </a>

    </div>

</nav>


<div class="container-fluid py-5">

    <h2 class="text-center mb-4">

        <i class="fa-solid fa-users"></i>

        All Students

    </h2>


    <div class="table-responsive">

        <table class="table table-bordered table-striped table-hover text-center align-middle">

            <thead class="table-primary">

                <tr>

                    <th>ID</th>

                    <th>Student Name</th>

                    <th>Roll Number</th>

                    <th>Registration Number</th>

                    <th>Email</th>

                    <th>Branch</th>

                    <th>Semester</th>

                    <th>Section</th>

                    <th>Date of Birth</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

                <?php

                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                <tr>

                    <td>
                        <?php echo $row['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['student_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['roll_number']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['registration_number']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['branch']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['semester']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['section']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['dob']); ?>
                    </td>

                    <td>

                        <!-- Edit -->

                        <a href="edit_student.php?id=<?php echo $row['id']; ?>"
                           class="btn btn-warning btn-sm">

                            <i class="fa-solid fa-pen"></i>

                            Edit

                        </a>


                        <!-- Delete -->

                        <a href="delete_student.php?id=<?php echo $row['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this student?');">

                            <i class="fa-solid fa-trash"></i>

                            Delete

                        </a>

                    </td>

                </tr>

                <?php

                    }

                } else {

                ?>

                <tr>

                    <td colspan="10">

                        No Students Found

                    </td>

                </tr>

                <?php

                }

                ?>

            </tbody>

        </table>

    </div>


    <div class="text-center mt-4">

        <a href="add_student.php"
           class="btn btn-success">

            <i class="fa-solid fa-user-plus"></i>

            Add New Student

        </a>

    </div>

</div>

</body>

</html>