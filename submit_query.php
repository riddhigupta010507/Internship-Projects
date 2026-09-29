<?php
session_start();
include("db.php");

if(!isset($_SESSION['roll_number'])){
    header("Location: student_login.php");
    exit();
}

$roll_number = $_SESSION['roll_number'];
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM students WHERE roll_number='$roll_number'"));
$student_id = $student['id'];

if(isset($_POST['submit_query'])){
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $subject = mysqli_real_escape_string($conn, $subject);
    $message = mysqli_real_escape_string($conn, $message);

    $sql = "INSERT INTO queries (student_id, subject, message) VALUES ('$student_id', '$subject', '$message')";

    if(mysqli_query($conn, $sql)){
        header("Location: student_dashboard.php?query=success");
        exit();
    } else {
        header("Location: student_dashboard.php?query=error");
        exit();
    }
}
?>