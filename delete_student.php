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


// First delete marks of this student

$delete_marks = "DELETE FROM marks WHERE student_id = $id";

if (!mysqli_query($conn, $delete_marks)) {

    die("Error deleting student marks: " . mysqli_error($conn));

}


// Then delete student

$delete_student = "DELETE FROM students WHERE id = $id";

if (mysqli_query($conn, $delete_student)) {

    header("Location: view_students.php?status=deleted");
    exit();

} else {

    echo "Error deleting student: " . mysqli_error($conn);

}

?>