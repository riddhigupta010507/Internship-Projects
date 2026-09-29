<?php
session_start();
include("db.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){

        $_SESSION['admin'] = $username;

        header("Location: admin_dashboard.php");
        exit();

    }else{

        echo "<script>alert('Invalid Username or Password');</script>";

    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        .login-heading { color: #352f13; }
        .login-btn {
            background: linear-gradient(135deg, #8B7D3C, #7b6638);
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .login-btn:hover {
            background: linear-gradient(135deg, #7b6638, #352f13);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 125, 60, 0.4);
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }
        .back-link {
            color: #8B7D3C;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .back-link:hover { color: #352f13; }
    </style>

</head>

<body style="background: #f8f9fa;">

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #352f13, #917b53, #7b6638);">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">

            <i class="fa-solid fa-graduation-cap"></i>

            Student Result Viewer

        </a>

    </div>

</nav>

<section class="container py-5">

<div class="row align-items-center justify-content-center">

<div class="col-lg-5">

<div class="card login-card p-4">

<h2 class="text-center login-heading mb-4">

<i class="fa-solid fa-user-shield"></i>

Admin Login

</h2>

<form action="" method="POST">

    <div class="mb-3">
        <label class="form-label fw-semibold">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
    </div>

    <div class="d-grid">
        <button type="submit" name="login" class="btn btn-lg login-btn">
            <i class="fa-solid fa-right-to-bracket"></i> Login
        </button>
    </div>

</form>

<div class="text-center mt-3">
    <a href="index.php" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Home
    </a>
</div>

</div>

</div>

</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>