<?php
session_start();
if(empty($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student'){
    header('Location: student_login.php');
    exit;
}
include('includes/dbconnect.php');
$student_id = (int)$_SESSION['user_id'];
$enquiry = mysqli_query($connection, "SELECT st_id, st_enquiry_id, st_name, st_email FROM student_enquiry WHERE student_user_id=$student_id AND st_enquiry_status!=1 ORDER BY st_id DESC LIMIT 1");
$row = $enquiry && mysqli_num_rows($enquiry) > 0 ? mysqli_fetch_assoc($enquiry) : null;
if($row){
    header('Location: student_enquiry.php?eq='.base64_encode($row['st_id']).'&student=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Enquiry | National College Australia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f8f9fa; min-height: 100vh; display: flex; flex-direction: column; }
        .reg-header { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: #fff; padding: 1rem 0; }
        .reg-header .logo { font-size: 1.25rem; font-weight: 700; }
        .reg-header a { color: #fff; text-decoration: none; }
        .card { border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .footer-small { background: #1a1a2e; color: rgba(255,255,255,0.8); padding: 1rem 0; margin-top: auto; }
    </style>
</head>
<body>
    <header class="reg-header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="student_portal.php" class="logo">National College Australia</a>
            <span>Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?> &nbsp; <a href="student_logout.php">Logout</a></span>
        </div>
    </header>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4 text-center">
                    <h4 class="mb-3">No Enquiry Linked</h4>
                    <p class="text-muted">You don't have an enquiry linked to your account yet. Submit an enquiry from the Enrol page first, then register with the same email to link it.</p>
                    <a href="Enrol.php" class="btn btn-primary">Go to Enrol Page</a>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer-small text-center">
        <div class="container">© <?php echo date('Y'); ?> National College Australia</div>
    </footer>
</body>
</html>
