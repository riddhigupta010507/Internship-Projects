<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result Viewer</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- ================= NAVBAR ================= -->


<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../project/favicon.ico" class="logo" alt="SKIT Logo">
            <div class="ms-3">
                <h4 class="mb-0">SKIT Jaipur</h4>
                <small>Student Result Portal</small>
            </div>
        </a>

        <!-- Mobile Button -->
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item ms-3">
                    <button class="btn btn-light" id="theme-toggle">🌙</button>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- ================= HERO SECTION ================= -->

<section id="home" class="hero">

    <div class="container">

        <div class="row align-items-center">

            <!-- Left Side -->

            <div class="col-lg-6">

                <h1 class="hero-title">

                    Student Result Viewer

                </h1>

                <p class="hero-text">

                    Welcome to the official Student Result Portal of
                    <strong>Swami Keshvanand Institute of Technology,
                    Jaipur.</strong>

                    Check semester results, monitor academic
                    performance and access your records securely.

                </p>

                <div class="mt-4">

                    <a href="student_login.php"
                    class="btn btn-primary btn-lg me-3">

                        <i class="fa-solid fa-user-graduate"></i>

                        Student Login

                    </a>

                    <a href="admin_login.php"
                    class="btn btn-success btn-lg">

                        <i class="fa-solid fa-user-shield"></i>

                        Admin Login

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- ================= FEATURES ================= -->

<section class="features-section">

    <div class="text-center">

        <h2 class="section-title">Features</h2>

        <p class="section-subtitle">Everything you need to manage your academic results</p>

    </div>

    <div class="row g-4">

        <div class="col-md-6 col-lg-3">

            <div class="feature-card">

                <div class="feature-icon blue">

                    <i class="fa-solid fa-user-graduate"></i>

                </div>

                <h4>Student Login</h4>

                <p>Secure login to access personal academic records.</p>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="feature-card">

                <div class="feature-icon green">

                    <i class="fa-solid fa-chart-column"></i>

                </div>

                <h4>Performance</h4>

                <p>View detailed marks and overall percentage.</p>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="feature-card">

                <div class="feature-icon red">

                    <i class="fa-solid fa-download"></i>

                </div>

                <h4>Download</h4>

                <p>Save your result as a PDF for future reference.</p>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="feature-card">

                <div class="feature-icon orange">

                    <i class="fa-solid fa-lock"></i>

                </div>

                <h4>Secure</h4>

                <p>Protected student information with secure access.</p>

            </div>

        </div>

    </div>

</section>

<section class="stats-section">

    <div class="container">

        <div class="text-center">

            <h2 class="section-title">Statistics</h2>

            <p class="section-subtitle">Our achievements at a glance</p>

        </div>

        <div class="row g-4">

            <div class="col-md-6 col-lg-3">

                <div class="stat-card">

                    <h1>250+</h1>

                    <p>Total Students</p>

                </div>

            </div>

            <div class="col-md-6 col-lg-3">

                <div class="stat-card">

                    <h1>95%</h1>

                    <p>Pass Rate</p>

                </div>

            </div>

            <div class="col-md-6 col-lg-3">

                <div class="stat-card">

                    <h1>10</h1>

                    <p>Departments</p>

                </div>

            </div>

            <div class="col-md-6 col-lg-3">

                <div class="stat-card">

                    <h1>24x7</h1>

                    <p>Availability</p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= FOOTER ================= -->

<footer class="text-white text-center p-4">

    <h5>

        <i class="fa-solid fa-graduation-cap me-2"></i>Student Result Viewer

    </h5>

    <p>

        &copy; 2026 Swami Keshvanand Institute of Technology, Jaipur. All Rights Reserved.

    </p>

</footer>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript -->

    <script src="script.js"></script>

</body>
</html>