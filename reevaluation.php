<?php
session_start();
include("db.php");

if(!isset($_SESSION['roll_number'])){
    header("Location: student_login.php");
    exit();
}

$roll_number = $_SESSION['roll_number'];
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, student_name, roll_number FROM students WHERE roll_number='$roll_number'"));
$student_id = $student['id'];

$subjects_list = ['mathematics', 'physics', 'programming_c', 'english', 'engineering_graphics'];
$subject_labels = [
    'mathematics' => 'Mathematics',
    'physics' => 'Physics',
    'programming_c' => 'Programming in C',
    'english' => 'English',
    'engineering_graphics' => 'Engineering Graphics'
];

$message = "";

if(isset($_POST['confirm_payment'])){
    $selected = $_POST['subjects'] ?? [];
    $method = $_POST['payment_method'];
    $card_number = $_POST['card_number'] ?? '';
    $upi_id = $_POST['upi_id'] ?? '';

    if(empty($selected)){
        $message = '<div class="alert alert-danger">Please select at least one subject.</div>';
    } else {
        $amount = count($selected) * 500;
        $subjects_str = implode(', ', $selected);

        $reeval_sql = "INSERT INTO reevaluation (student_id, subjects) VALUES ('$student_id', '$subjects_str')";
        if(mysqli_query($conn, $reeval_sql)){
            $reeval_id = mysqli_insert_id($conn);
            $pay_sql = "INSERT INTO payments (student_id, reeval_id, amount, method) VALUES ('$student_id', '$reeval_id', '$amount', '$method')";
            if(mysqli_query($conn, $pay_sql)){
                $message = '<div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> Payment of ₹' . $amount . ' successful! Your re-evaluation request has been submitted.</div>';
            } else {
                $message = '<div class="alert alert-danger">Payment failed. Please try again.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Error submitting request.</div>';
        }
    }
}

$history = mysqli_query($conn, "SELECT * FROM reevaluation WHERE student_id='$student_id' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Re-evaluation Request</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        .reeval-nav { background: linear-gradient(135deg, #352f13, #917b53, #7b6638); }
        .reeval-card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            margin-bottom: 25px;
        }
        .reeval-card h3 { color: #352f13; font-weight: 700; }
        .reeval-card h4 { color: #352f13; font-weight: 600; }
        .subject-check {
            border: 2px solid #e0ddd5;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .subject-check:hover { border-color: #8B7D3C; background: #fdfcf8; }
        .subject-check input:checked + span { font-weight: 600; color: #8B7D3C; }
        .subject-check:has(input:checked) { border-color: #8B7D3C; background: #fdfcf8; }
        .payment-option {
            border: 2px solid #e0ddd5;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-option:hover { border-color: #8B7D3C; }
        .payment-option.active { border-color: #8B7D3C; background: #fdfcf8; }
        .pay-btn {
            background: linear-gradient(135deg, #8B7D3C, #C4A94D);
            border: none;
            border-radius: 50px;
            padding: 12px 40px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
        }
        .pay-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139,125,60,0.4);
            color: #fff;
        }
        .step-num {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #8B7D3C, #C4A94D);
            color: #fff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 10px;
        }
        .back-link { color: #8B7D3C; text-decoration: none; font-weight: 500; }
        .back-link:hover { color: #352f13; }
    </style>
</head>

<body style="background: #f8f9fa;">

<nav class="navbar navbar-expand-lg navbar-dark reeval-nav">
<div class="container">
    <a class="navbar-brand fw-bold" href="student_dashboard.php">
        <i class="fa-solid fa-graduation-cap"></i> Student Result Viewer
    </a>
    <a href="student_dashboard.php" class="btn btn-light">
        <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
</div>
</nav>

<div class="container py-5">

<?php echo $message; ?>

<!-- Step 1: Select Subjects -->
<div class="reeval-card">
    <h3><span class="step-num">1</span> Select Subjects for Re-evaluation</h3>
    <p class="text-muted mt-2">Select the subject(s) you want to request re-evaluation for. ₹500 per subject.</p>

    <form method="POST" id="reevalForm">
    <div class="row mt-3">
        <?php foreach($subjects_list as $sub): ?>
        <div class="col-md-6 mb-2">
            <label class="subject-check d-flex align-items-center">
                <input type="checkbox" name="subjects[]" value="<?php echo $sub; ?>" class="form-check-input me-3 subject-cb" onchange="updateTotal()">
                <span><?php echo $subject_labels[$sub]; ?></span>
            </label>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-3 p-3" style="background:#f8f5ee; border-radius:12px;">
        <strong>Selected: <span id="selCount">0</span> subject(s)</strong> &nbsp;|&nbsp;
        <strong>Total Amount: ₹<span id="totalAmount">0</span></strong>
    </div>
</div>

<!-- Step 2: Payment -->
<div class="reeval-card">
    <h3><span class="step-num">2</span> Payment Details</h3>
    <p class="text-muted mt-2">Choose a payment method and enter details.</p>

    <div class="row mt-3">
        <div class="col-md-6 mb-3">
            <div class="payment-option active" onclick="selectMethod('card', this)">
                <i class="fa-solid fa-credit-card fa-2x mb-2" style="color:#8B7D3C;"></i>
                <h5>Debit / Credit Card</h5>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="payment-option" onclick="selectMethod('upi', this)">
                <i class="fa-solid fa-mobile-screen fa-2x mb-2" style="color:#8B7D3C;"></i>
                <h5>UPI</h5>
            </div>
        </div>
    </div>

    <!-- Card Form -->
    <div id="cardForm" class="mt-3">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Card Number</label>
                <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Expiry</label>
                <input type="text" name="card_expiry" class="form-control" placeholder="MM/YY" maxlength="5">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">CVV</label>
                <input type="password" name="card_cvv" class="form-control" placeholder="***" maxlength="3">
            </div>
        </div>
    </div>

    <!-- UPI Form -->
    <div id="upiForm" class="mt-3" style="display:none;">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">UPI ID</label>
                <input type="text" name="upi_id" class="form-control" placeholder="yourname@upi">
            </div>
        </div>
    </div>

    <input type="hidden" name="payment_method" id="paymentMethod" value="card">

    <div class="text-center mt-4">
        <button type="submit" name="confirm_payment" class="btn pay-btn btn-lg">
            <i class="fa-solid fa-lock"></i> Confirm & Pay ₹<span id="payAmount">0</span>
        </button>
    </div>

    </form>
</div>

<!-- History -->
<?php if(mysqli_num_rows($history) > 0): ?>
<div class="reeval-card">
    <h3><i class="fa-solid fa-clock-rotate-left"></i> Re-evaluation History</h3>
    <div class="table-responsive mt-3">
        <table class="table table-bordered align-middle">
            <thead style="background: linear-gradient(135deg, #8B7D3C, #C4A94D); color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Subjects</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while($row = mysqli_fetch_assoc($history)): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($row['subjects']); ?></td>
                    <td>
                        <?php
                        $statusClass = match($row['status']){
                            'Approved' => 'success',
                            'Rejected' => 'danger',
                            default => 'warning'
                        };
                        ?>
                        <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $row['status']; ?></span>
                    </td>
                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
function updateTotal(){
    let checked = document.querySelectorAll('.subject-cb:checked');
    document.getElementById('selCount').textContent = checked.length;
    let amt = checked.length * 500;
    document.getElementById('totalAmount').textContent = amt;
    document.getElementById('payAmount').textContent = amt;
}

function selectMethod(method, el){
    document.querySelectorAll('.payment-option').forEach(e => e.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('paymentMethod').value = method;
    document.getElementById('cardForm').style.display = method === 'card' ? 'block' : 'none';
    document.getElementById('upiForm').style.display = method === 'upi' ? 'block' : 'none';
}

document.getElementById('reevalForm').addEventListener('submit', function(e){
    let checked = document.querySelectorAll('.subject-cb:checked');
    if(checked.length === 0){
        e.preventDefault();
        alert('Please select at least one subject.');
        return;
    }
    let method = document.getElementById('paymentMethod').value;
    if(method === 'card'){
        let num = document.querySelector('[name="card_number"]').value;
        let exp = document.querySelector('[name="card_expiry"]').value;
        let cvv = document.querySelector('[name="card_cvv"]').value;
        if(!num || !exp || !cvv){
            e.preventDefault();
            alert('Please fill all card details.');
            return;
        }
    } else {
        let upi = document.querySelector('[name="upi_id"]').value;
        if(!upi){
            e.preventDefault();
            alert('Please enter your UPI ID.');
            return;
        }
    }
});
</script>

</body>
</html>