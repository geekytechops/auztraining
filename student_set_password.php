<?php
/**
 * First-time / invite password set via email token (no registration).
 * Token is issued when NCA enquiry creates a student account.
 */
session_start();
require_once __DIR__ . '/includes/dbconnect.php';

$asset_base = 'crm/html/template/assets';
$token = trim((string) ($_GET['token'] ?? ''));
$error = '';
$ready = false;
$email_display = '';

function crm_student_setup_ensure_columns($connection) {
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;
    $c1 = @mysqli_fetch_assoc(mysqli_query($connection, "SHOW COLUMNS FROM student_users LIKE 'password_setup_token'"));
    if (!$c1) {
        @mysqli_query($connection, "ALTER TABLE student_users ADD COLUMN `password_setup_token` VARCHAR(64) NULL DEFAULT NULL");
    }
    $c2 = @mysqli_fetch_assoc(mysqli_query($connection, "SHOW COLUMNS FROM student_users LIKE 'password_setup_expires'"));
    if (!$c2) {
        @mysqli_query($connection, "ALTER TABLE student_users ADD COLUMN `password_setup_expires` DATETIME NULL DEFAULT NULL");
    }
}

crm_student_setup_ensure_columns($connection);

if ($token === '' || !preg_match('/^[a-f0-9]{32,64}$/i', $token)) {
    $error = 'This password link is invalid. Please use the link from your enquiry email.';
} else {
    $tok_esc = mysqli_real_escape_string($connection, $token);
    $q = mysqli_query(
        $connection,
        "SELECT id, email, full_name, password_setup_expires, status FROM student_users WHERE password_setup_token='$tok_esc' LIMIT 1"
    );
    $row = ($q && mysqli_num_rows($q)) ? mysqli_fetch_assoc($q) : null;
    if (!$row) {
        $error = 'This password link is invalid or has already been used.';
    } elseif ((int) $row['status'] !== 1) {
        $error = 'This account is not active. Please contact the college.';
    } elseif (empty($row['password_setup_expires']) || strtotime($row['password_setup_expires']) < time()) {
        $error = 'This password link has expired. Please use Forgot password on the login page.';
    } else {
        $ready = true;
        $email_display = (string) $row['email'];
        $_SESSION['password_setup_uid'] = (int) $row['id'];
        $_SESSION['password_setup_token'] = $token;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $ready) {
    $p1 = (string) ($_POST['password'] ?? '');
    $p2 = (string) ($_POST['password_confirm'] ?? '');
    $uid = (int) ($_SESSION['password_setup_uid'] ?? 0);
    $sessTok = (string) ($_SESSION['password_setup_token'] ?? '');
    if ($uid <= 0 || $sessTok === '' || !hash_equals($sessTok, $token)) {
        $error = 'Session expired. Please open the link from your email again.';
        $ready = false;
    } elseif (strlen($p1) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($p1 !== $p2) {
        $error = 'Passwords do not match.';
    } else {
        $hash = password_hash($p1, PASSWORD_DEFAULT);
        $hash_esc = mysqli_real_escape_string($connection, $hash);
        $tok_esc = mysqli_real_escape_string($connection, $token);
        $ok = mysqli_query(
            $connection,
            "UPDATE student_users SET password_hash='$hash_esc', password_setup_token=NULL, password_setup_expires=NULL WHERE id=$uid AND password_setup_token='$tok_esc' AND status=1 LIMIT 1"
        );
        if ($ok && mysqli_affected_rows($connection) > 0) {
            unset($_SESSION['password_setup_uid'], $_SESSION['password_setup_token']);
            header('Location: student_login.php?password_set=1');
            exit;
        }
        $error = 'Could not update password. The link may have already been used.';
        $ready = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Set Password | National College Australia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/style.css" id="app-style">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif !important; background-color: #f8fafc; color: #1e293b; }
        .acc-vh { min-height: 100vh; }
        .auth-logo img { height: 60px; }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important;
            border: none !important; border-radius: 10px !important; padding: 11px !important; font-weight: 600 !important;
        }
        .form-control { border-radius: 10px !important; padding: 10px 14px !important; border: 1px solid #cbd5e1 !important; }
        .form-control:focus { border-color: #4f46e5 !important; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15) !important; }
        .form-label { font-weight: 500; font-size: 13px; color: #475569; }
        .account-bg-01 { background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%) !important; }
    </style>
</head>
<body class="account-page bg-white">
<div class="main-wrapper">
    <div class="overflow-hidden p-3 acc-vh">
        <div class="row vh-100 w-100 g-0">
            <div class="col-lg-6 vh-100 overflow-y-auto overflow-x-hidden d-flex flex-column justify-content-between p-4">
                <div class="text-center mb-4 auth-logo">
                    <a href="student_login.php"><img src="assets/img/logo.png" class="img-fluid" alt="Logo"></a>
                </div>
                <div class="col-md-9 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="mb-1">Set your password</h4>
                            <p class="text-muted small mb-4">Use this page only to set a password for your student portal account. After that, log in with your email and new password.</p>
                            <?php if ($error !== '') { ?>
                                <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($error); ?></div>
                                <div class="text-center mt-3">
                                    <a href="student_login.php" class="small">Back to login</a>
                                    &nbsp;·&nbsp;
                                    <a href="forgot_password.php?portal=student" class="small">Forgot password</a>
                                </div>
                            <?php } elseif ($ready) { ?>
                                <p class="small text-muted mb-3">Account: <strong><?php echo htmlspecialchars($email_display); ?></strong></p>
                                <form method="post" autocomplete="off">
                                    <div class="mb-3">
                                        <label class="form-label" for="password">New password</label>
                                        <input type="password" class="form-control" name="password" id="password" minlength="6" required placeholder="At least 6 characters" autocomplete="new-password">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password_confirm">Confirm password</label>
                                        <input type="password" class="form-control" name="password_confirm" id="password_confirm" minlength="6" required autocomplete="new-password">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Save password</button>
                                </form>
                                <div class="text-center mt-3">
                                    <a href="student_login.php" class="small">Back to login</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="text-center pb-2">
                    <p class="text-dark mb-0 small">Copyright &copy; <?php echo date('Y'); ?> - National College Australia</p>
                </div>
            </div>
            <div class="col-lg-6 account-bg-01"></div>
        </div>
    </div>
</div>
</body>
</html>
