<?php
session_start();
include("db.php");

if(!isset($_SESSION['roll_number'])){
    header("Location: student_login.php");
    exit();
}

$roll_number = $_SESSION['roll_number'];

$sql = "SELECT * FROM students WHERE roll_number='$roll_number'";
$result = mysqli_query($conn,$sql);
$student = mysqli_fetch_assoc($result);
$student_id = $student['id'];

$sql2 = "SELECT * FROM marks WHERE student_id='$student_id'";
$result2 = mysqli_query($conn,$sql2);
$marks = mysqli_fetch_assoc($result2);

$query_history = mysqli_query($conn, "SELECT * FROM queries WHERE student_id='$student_id' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        .dash-nav { background: linear-gradient(135deg, #352f13, #917b53, #7b6638); }
        .dash-welcome {
            background: linear-gradient(135deg, #f8f5ee, #f0ece2);
            border-radius: 16px;
            padding: 30px 35px;
            border: 1px solid rgba(139, 125, 60, 0.15);
        }
        .dash-welcome h2 { color: #352f13; font-weight: 800; }
        .dash-welcome p { color: #888; }
        .dash-info {
            background: #fff;
            border-radius: 16px;
            padding: 25px 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
        }
        .dash-info p { margin-bottom: 8px; color: #555; }
        .dash-info strong { color: #352f13; }
        .dash-btn {
            background: linear-gradient(135deg, #8B7D3C, #7b6638);
            border: none;
            border-radius: 50px;
            padding: 10px 28px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
        }
        .dash-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 125, 60, 0.4);
            color: #fff;
        }
        .back-link {
            color: #8B7D3C;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover { color: #352f13; }
        .section-card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            margin-bottom: 25px;
        }
        .section-card h3 { color: #352f13; font-weight: 700; }
        .query-btn {
            background: linear-gradient(135deg, #8B7D3C, #7b6638);
            border: none;
            border-radius: 50px;
            padding: 10px 28px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
        }
        .query-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139,125,60,0.4);
            color: #fff;
        }
        .reeval-btn {
            background: linear-gradient(135deg, #C4A94D, #8B7D3C);
            border: none;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
        }
        .reeval-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(196,169,77,0.4);
            color: #fff;
        }
    </style>
</head>

<body style="background: #f8f9fa;">

<nav class="navbar navbar-expand-lg navbar-dark dash-nav">

<div class="container">

<a class="navbar-brand fw-bold" href="index.php">

<i class="fa-solid fa-graduation-cap"></i>

Student Result Viewer

</a>

<a href="index.php" class="btn btn-light">

<i class="fa-solid fa-right-from-bracket"></i>

Logout

</a>

</div>

</nav>

<div class="container py-5">

<div class="dash-welcome mb-4">

<h2>Welcome, <?php echo htmlspecialchars($student['student_name']); ?> 👋</h2>

<p>Here's your academic overview.</p>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<div class="dash-info">

<p><strong>Roll Number :</strong> <?php echo htmlspecialchars($student['roll_number']); ?></p>

<p><strong>Branch :</strong> <?php echo htmlspecialchars($student['branch']); ?></p>

<p><strong>Semester :</strong> <?php echo htmlspecialchars($student['semester']); ?></p>

</div>

</div>

<div class="col-md-6 mb-3">

<div class="dash-info">

<p><strong>Registration No :</strong> <?php echo htmlspecialchars($student['registration_number']); ?></p>

<p><strong>Email :</strong> <?php echo htmlspecialchars($student['email']); ?></p>

<p><strong>Section :</strong> <?php echo htmlspecialchars($student['section']); ?></p>

</div>

</div>

</div>

<?php if($marks): ?>

<div class="row mt-3">

<div class="col-md-3 mb-3">

<div class="dash-info text-center">

<h5 style="color:#888;">Total</h5>

<h3 style="color:#352f13; font-weight:800;"><?php echo $marks['total']; ?> / 500</h3>

</div>

</div>

<div class="col-md-3 mb-3">

<div class="dash-info text-center">

<h5 style="color:#888;">Percentage</h5>

<h3 style="color:#352f13; font-weight:800;"><?php echo $marks['percentage']; ?>%</h3>

</div>

</div>

<div class="col-md-3 mb-3">

<div class="dash-info text-center">

<h5 style="color:#888;">Grade</h5>

<h3 style="color:#8B7D3C; font-weight:800;"><?php echo $marks['grade']; ?></h3>

</div>

</div>

<div class="col-md-3 mb-3">

<div class="dash-info text-center">

<h5 style="color:#888;">Status</h5>

<h3 style="color:<?php echo $marks['status'] == 'Pass' ? '#198754' : '#dc3545'; ?>; font-weight:800;"><?php echo $marks['status']; ?></h3>

</div>

</div>

</div>

<?php endif; ?>

<!-- ================= QUERY PORTAL ================= -->
<div class="section-card mt-4">
    <h3><i class="fa-solid fa-circle-question" style="color:#8B7D3C;"></i> Query Portal</h3>
    <p class="text-muted">Have a question or issue? Submit your query here.</p>

    <form action="submit_query.php" method="POST" class="mt-3">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Subject</label>
                <select name="subject" class="form-select" required>
                    <option value="">Select Subject</option>
                    <option value="Result Issue">Result Issue</option>
                    <option value="Marks Discrepancy">Marks Discrepancy</option>
                    <option value="Re-evaluation Query">Re-evaluation Query</option>
                    <option value="Account Issue">Account Issue</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label fw-semibold">Message</label>
                <textarea name="message" class="form-control" rows="3" placeholder="Describe your query..." required></textarea>
            </div>
        </div>
        <button type="submit" name="submit_query" class="query-btn">
            <i class="fa-solid fa-paper-plane"></i> Submit Query
        </button>
    </form>

    <?php if(mysqli_num_rows($query_history) > 0): ?>
    <hr>
    <h5 class="mt-3" style="color:#352f13;"><i class="fa-solid fa-clock-rotate-left"></i> Query History</h5>
    <div class="table-responsive mt-3">
        <table class="table table-bordered align-middle">
            <thead style="background: linear-gradient(135deg, #8B7D3C, #C4A94D); color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Admin Reply</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while($row = mysqli_fetch_assoc($query_history)): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td>
                        <?php
                        $statusClass = ($row['status'] == 'Resolved') ? 'success' : 'warning';
                        ?>
                        <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $row['status']; ?></span>
                    </td>
                    <td><?php echo $row['admin_reply'] ? htmlspecialchars($row['admin_reply']) : '<em class="text-muted">Awaiting reply</em>'; ?></td>
                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<!-- ================= RE-EVALUATION ================= -->
<div class="section-card">
    <h3><i class="fa-solid fa-pen-to-square" style="color:#8B7D3C;"></i> Re-evaluation</h3>
    <p class="text-muted">Not satisfied with your marks? Request a re-evaluation for specific subjects.</p>
    <a href="reevaluation.php" class="reeval-btn mt-2">
        <i class="fa-solid fa-arrow-right"></i> Request Re-evaluation
    </a>
</div>

<div class="text-center mt-4">

<a href="result.php?roll=<?php echo urlencode($student['roll_number']); ?>" class="btn dash-btn btn-lg me-3">

<i class="fa-solid fa-file-lines"></i> View Result

</a>

<a href="index.php" class="back-link">

<i class="fa-solid fa-arrow-left"></i> Back to Home

</a>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>