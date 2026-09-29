<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        .admin-nav {
            background: linear-gradient(135deg, #352f13, #917b53, #7b6638);
        }
        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 28px;
            color: #fff;
        }
        .stat-icon.gold { background: linear-gradient(135deg, #8B7D3C, #C4A94D); }
        .stat-icon.green { background: linear-gradient(135deg, #6B7D3C, #8FA94D); }
        .stat-icon.amber { background: linear-gradient(135deg, #9B6B3C, #C4894D); }
        .stat-icon.red { background: linear-gradient(135deg, #C4A94D, #D4B95D); }
        .stat-card h5 { color: #666; font-size: 14px; font-weight: 500; margin-bottom: 8px; }
        .stat-card h2 { color: #352f13; font-weight: 800; font-size: 36px; margin-bottom: 0; }

        .action-card {
            border: none;
            border-radius: 16px;
            padding: 35px 20px;
            text-align: center;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
        }
        .action-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }
        .action-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 32px;
            color: #fff;
            transition: transform 0.3s ease;
        }
        .action-card:hover .action-icon { transform: scale(1.1); }
        .action-icon.gold { background: linear-gradient(135deg, #8B7D3C, #C4A94D); box-shadow: 0 8px 20px rgba(139, 125, 60, 0.3); }
        .action-icon.green { background: linear-gradient(135deg, #6B7D3C, #8FA94D); box-shadow: 0 8px 20px rgba(107, 125, 60, 0.3); }
        .action-icon.amber { background: linear-gradient(135deg, #9B6B3C, #C4894D); box-shadow: 0 8px 20px rgba(155, 107, 60, 0.3); }
        .action-icon.dark { background: linear-gradient(135deg, #352f13, #5a4f28); box-shadow: 0 8px 20px rgba(53, 47, 19, 0.3); }
        .action-card h4 { color: #352f13; font-weight: 700; font-size: 18px; margin-bottom: 8px; }
        .action-card p { color: #888; font-size: 14px; margin-bottom: 18px; }
        .action-card .btn {
            border-radius: 50px;
            padding: 8px 28px;
            font-weight: 600;
            background: linear-gradient(135deg, #8B7D3C, #7b6638);
            border: none;
            color: #fff;
            transition: all 0.3s ease;
        }
        .action-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 125, 60, 0.35);
            color: #fff;
        }
        .welcome-section {
            background: linear-gradient(135deg, #f8f5ee, #f0ece2);
            border-radius: 16px;
            padding: 30px 35px;
            margin-bottom: 30px;
            border: 1px solid rgba(139, 125, 60, 0.15);
        }
        .welcome-section h2 { color: #352f13; font-weight: 800; margin-bottom: 5px; }
        .welcome-section p { color: #888; margin-bottom: 0; }
    </style>
</head>

<body style="background: #f8f9fa;">

<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark admin-nav">

<div class="container">

<a class="navbar-brand fw-bold" href="admin_dashboard.php">

<i class="fa-solid fa-user-shield"></i>

Admin Dashboard

</a>

<a href="index.php" class="btn btn-light">

<i class="fa-solid fa-right-from-bracket"></i>

Logout

</a>

</div>

</nav>

<div class="container py-5">

<!-- Welcome -->

<div class="welcome-section">

<h2><i class="fa-solid fa-hand-wave"></i> Welcome, Administrator</h2>

<p>Manage students, marks, and results from here.</p>

</div>

<!-- Statistics -->

<div class="row mb-4">

<div class="col-md-3 mb-3">

<div class="stat-card">

<div class="stat-icon gold"><i class="fa-solid fa-users"></i></div>

<h5>Total Students</h5>

<h2><?php
$r = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$rw = mysqli_fetch_assoc($r);
echo $rw['total'];
?></h2>

</div>

</div>

<div class="col-md-3 mb-3">

<div class="stat-card">

<div class="stat-icon green"><i class="fa-solid fa-file-circle-check"></i></div>

<h5>Results Published</h5>

<h2><?php
$r2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM marks");
$rw2 = mysqli_fetch_assoc($r2);
echo $rw2['total'];
?></h2>

</div>

</div>

<div class="col-md-3 mb-3">

<div class="stat-card">

<div class="stat-icon amber"><i class="fa-solid fa-chart-pie"></i></div>

<h5>Pass Percentage</h5>

<h2><?php
$r3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM marks WHERE status='Pass'");
$r4 = mysqli_query($conn, "SELECT COUNT(*) as total FROM marks");
$p = mysqli_fetch_assoc($r3);
$t = mysqli_fetch_assoc($r4);
echo $t['total'] > 0 ? round(($p['total'] / $t['total']) * 100) . "%" : "0%";
?></h2>

</div>

</div>

<div class="col-md-3 mb-3">

<div class="stat-card">

<div class="stat-icon red"><i class="fa-solid fa-building-columns"></i></div>

<h5>Departments</h5>

<h2>10</h2>

</div>

</div>

</div>

<!-- Admin Actions -->

<h4 class="mb-3" style="color:#352f13; font-weight:700;">Add</h4>

<div class="row mb-4">

<div class="col-md-6 mb-4">

<div class="action-card">

<div class="action-icon gold"><i class="fa-solid fa-user-plus"></i></div>

<h4>Add Student</h4>

<p>Create a new student record.</p>

<a href="add_student.php" class="btn">Open</a>

</div>

</div>

<div class="col-md-6 mb-4">

<div class="action-card">

<div class="action-icon amber"><i class="fa-solid fa-pen-to-square"></i></div>

<h4>Add Marks</h4>

<p>Enter semester marks.</p>

<a href="add_marks.php" class="btn">Open</a>

</div>

</div>

</div>

<h4 class="mb-3" style="color:#352f13; font-weight:700;">View</h4>

<div class="row">

<div class="col-md-6 mb-4">

<div class="action-card">

<div class="action-icon green"><i class="fa-solid fa-users"></i></div>

<h4>View Students</h4>

<p>View all student records.</p>

<a href="view_students.php" class="btn">Open</a>

</div>

</div>

<div class="col-md-6 mb-4">

<div class="action-card">

<div class="action-icon dark"><i class="fa-solid fa-table"></i></div>

<h4>View Results</h4>

<p>Check all published results.</p>

<a href="result.php" class="btn">Open</a>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>