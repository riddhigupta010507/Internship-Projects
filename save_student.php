<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if(isset($_POST['save_student']))
{
    $student_name = $_POST['student_name'];
    $roll_number = $_POST['roll_number'];
    $registration_number = $_POST['registration_number'];
    $email = $_POST['email'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];

    $sql = "INSERT INTO students
    (student_name, roll_number, registration_number, email, branch, semester, section, dob, password)
    VALUES
    ('$student_name', '$roll_number', '$registration_number', '$email', '$branch', '$semester', '$section', '$dob', '$password')";

    if(mysqli_query($conn, $sql)){
        header("Location: add_student.php?status=success");
        exit();
    }
    else{
        echo "SQL Error: " . mysqli_error($conn);
    }
}
else{
    echo "No data received. Check form action.";
}

?>