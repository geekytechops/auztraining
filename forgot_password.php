<?php
session_start();
$portal = isset($_GET['portal']) && $_GET['portal'] === 'student' ? 'student' : 'admin';
if ($portal === 'student' && isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'student') {
    header('Location: student_enquiry_form.php');
    exit;
}
if ($portal === 'admin' && !empty($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'student') {
    header('Location: dashboard.php');
    exit;
}
$asset_base = $portal === 'student' ? 'crm/html/template/assets' : 'assets';
$login_url = $portal === 'student' ? 'student_login.php' : 'index.php';
$title = $portal === 'student' ? 'Student Password Reset' : 'Password Reset';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($title); ?> | National College Australia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link rel="shortcut icon" href="assets/img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php if ($portal === 'student') { ?>
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/style.css" id="app-style">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif !important; background-color: #f8fafc; color: #1e293b; }
        .acc-vh { min-height: 100vh; }
        .auth-logo img { height: 60px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.05)); }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important;
            border: none !important; border-radius: 10px !important; padding: 11px !important;
            font-weight: 600 !important; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25) !important;
        }
        .form-control {
            border-radius: 10px !important; padding: 10px 14px !important;
            border: 1px solid #cbd5e1 !important; font-size: 14px;
        }
        .form-control:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15) !important;
        }
        .form-label { font-weight: 500; font-size: 13px; color: #475569; }
        .account-bg-01 { background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%) !important; }
    </style>
    <?php } else { include 'includes/app_includes.php'; ?>
    <style>
        body.bg-pattern {
            background: #05070f !important; font-family: 'Plus Jakarta Sans', sans-serif;
            color: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .bg-overlay {
            background: radial-gradient(circle at 50% 50%, rgba(5, 7, 15, 0.4) 0%, #03050a 100%) !important;
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
        }
        .glow-orb {
            position: absolute; width: 500px; height: 500px; border-radius: 50%;
            filter: blur(150px); z-index: -2; opacity: 0.18; pointer-events: none;
        }
        .glow-1 { background: #6366f1; top: 5%; left: 8%; }
        .glow-2 { background: #0ea5e9; bottom: 5%; right: 8%; }
        .account-pages { width: 100%; max-width: 440px; padding: 20px; z-index: 10; }
        .glass-card {
            background: rgba(10, 15, 30, 0.7) !important;
            backdrop-filter: blur(25px) saturate(200%);
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 28px !important;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.8) !important;
            color: #e2e8f0;
        }
        .glass-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, #6366f1, #0ea5e9);
        }
        .form-label { color: #94a3b8 !important; font-weight: 500; font-size: 13px; }
        .form-control {
            background: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important; border-radius: 14px !important; padding: 12px 16px !important;
        }
        .form-control:focus {
            border-color: #0ea5e9 !important;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.2) !important;
        }
        .form-control::placeholder { color: #475569 !important; }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #0ea5e9 100%) !important;
            border: none !important; border-radius: 14px !important; padding: 13px !important;
            font-weight: 600 !important;
        }
        .back-link { color: #64748b; text-decoration: none; font-size: 13px; }
        .back-link:hover { color: #fff; }
    </style>
    <?php } ?>
</head>
<body class="<?php echo $portal === 'student' ? 'account-page bg-white' : 'bg-pattern'; ?>">
<?php if ($portal === 'admin') { ?>
    <div class="glow-orb glow-1"></div>
    <div class="glow-orb glow-2"></div>
    <div class="bg-overlay"></div>
<?php } ?>
<div class="<?php echo $portal === 'student' ? 'main-wrapper' : 'account-pages'; ?>">
    <div class="<?php echo $portal === 'student' ? 'overflow-hidden p-3 acc-vh' : ''; ?>">
        <div class="<?php echo $portal === 'student' ? 'row vh-100 w-100 g-0' : ''; ?>">
            <div class="<?php echo $portal === 'student' ? 'col-lg-6 vh-100 overflow-y-auto overflow-x-hidden d-flex flex-column justify-content-between p-4' : ''; ?>">
                <?php if ($portal === 'student') { ?>
                <div class="text-center mb-4 auth-logo">
                    <a href="student_login.php"><img src="assets/img/logo.png" class="img-fluid" alt="Logo"></a>
                </div>
                <div class="col-md-9 mx-auto">
                <?php } ?>
                <div class="card <?php echo $portal === 'admin' ? 'glass-card position-relative border-0' : 'shadow-sm border-0'; ?>">
                    <div class="card-body p-4">
                        <?php if ($portal === 'admin') { ?>
                        <div class="text-center mb-4">
                            <a href="index.php"><img src="assets/img/logo.png" alt="Logo" height="50" class="mx-auto d-block"></a>
                        </div>
                        <?php } ?>
                        <h4 class="mb-1 <?php echo $portal === 'admin' ? 'text-white text-center' : ''; ?>"><?php echo htmlspecialchars($title); ?></h4>
                        <p class="<?php echo $portal === 'admin' ? 'text-muted text-center' : 'text-muted'; ?> small mb-4">Enter your email, verify the OTP we send, then set a new password.</p>
                        <form id="reset_form">
                            <input type="hidden" id="reset_portal" value="<?php echo htmlspecialchars($portal); ?>">
                            <div class="mb-3" id="step_email">
                                <label class="form-label" for="reset_email">Email</label>
                                <input type="email" class="form-control" id="reset_email" required placeholder="Your account email" autocomplete="username">
                            </div>
                            <div class="mb-3" id="step_otp" style="display:none;">
                                <label class="form-label" for="reset_otp">OTP</label>
                                <input type="text" class="form-control" id="reset_otp" maxlength="6" inputmode="numeric" placeholder="6-digit code" autocomplete="one-time-code">
                            </div>
                            <div id="step_password" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label" for="reset_password">New password</label>
                                    <input type="password" class="form-control" id="reset_password" minlength="6" placeholder="At least 6 characters" autocomplete="new-password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="reset_password2">Confirm password</label>
                                    <input type="password" class="form-control" id="reset_password2" minlength="6" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="alert alert-danger py-2 small" id="reset_error" style="display:none;"></div>
                            <div class="alert alert-success py-2 small" id="reset_success" style="display:none;"></div>
                            <button type="submit" class="btn btn-primary w-100" id="reset_btn">Send OTP</button>
                            <div class="text-center mt-3">
                                <a href="<?php echo htmlspecialchars($login_url); ?>" class="<?php echo $portal === 'admin' ? 'back-link' : 'small'; ?>">Back to login</a>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if ($portal === 'student') { ?>
                </div>
                <div class="text-center pb-2">
                    <p class="text-dark mb-0 small">Copyright &copy; <?php echo date('Y'); ?> - National College Australia</p>
                </div>
                <?php } ?>
            </div>
            <?php if ($portal === 'student') { ?>
            <div class="col-lg-6 account-bg-01"></div>
            <?php } ?>
        </div>
    </div>
</div>
<script src="<?php echo $portal === 'student' ? $asset_base . '/js/jquery-3.7.1.min.js' : 'crm/html/template/assets/js/jquery-3.7.1.min.js'; ?>"></script>
<?php if ($portal === 'student') { ?>
<script src="<?php echo $asset_base; ?>/js/bootstrap.bundle.min.js"></script>
<?php } ?>
<script>
(function () {
    var step = 1;
    var portal = document.getElementById('reset_portal').value;
    function showErr(msg) {
        var el = document.getElementById('reset_error');
        el.textContent = msg || '';
        el.style.display = msg ? 'block' : 'none';
        document.getElementById('reset_success').style.display = 'none';
    }
    function showOk(msg) {
        var el = document.getElementById('reset_success');
        el.textContent = msg || '';
        el.style.display = msg ? 'block' : 'none';
        document.getElementById('reset_error').style.display = 'none';
    }
    document.getElementById('reset_form').addEventListener('submit', function (e) {
        e.preventDefault();
        showErr('');
        var email = document.getElementById('reset_email').value.trim();
        var otp = document.getElementById('reset_otp').value.trim();
        var p1 = document.getElementById('reset_password').value;
        var p2 = document.getElementById('reset_password2').value;
        var fd = new FormData();
        var btn = document.getElementById('reset_btn');
        if (step === 1) {
            if (!email) { showErr('Email is required.'); return; }
            fd.append('formName', 'password_reset_request_otp');
            fd.append('portal', portal);
            fd.append('email', email);
            btn.disabled = true;
            btn.textContent = 'Sending…';
            fetch('includes/datacontrol', { method: 'POST', body: fd })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    btn.disabled = false;
                    if (data && data.success) {
                        step = 2;
                        document.getElementById('step_otp').style.display = 'block';
                        document.getElementById('step_password').style.display = 'block';
                        document.getElementById('reset_email').readOnly = true;
                        btn.textContent = 'Reset password';
                        showOk(data.message || 'OTP sent to your email.');
                    } else {
                        btn.textContent = 'Send OTP';
                        showErr((data && data.message) ? data.message : 'Unable to send OTP.');
                    }
                })
                .catch(function () {
                    btn.disabled = false;
                    btn.textContent = 'Send OTP';
                    showErr('Request failed.');
                });
            return;
        }
        if (!/^\d{6}$/.test(otp)) { showErr('Enter a valid 6-digit OTP.'); return; }
        if (p1.length < 6) { showErr('Password must be at least 6 characters.'); return; }
        if (p1 !== p2) { showErr('Passwords do not match.'); return; }
        fd.append('formName', 'password_reset_verify');
        fd.append('portal', portal);
        fd.append('otp', otp);
        fd.append('password', p1);
        fd.append('password_confirm', p2);
        btn.disabled = true;
        btn.textContent = 'Updating…';
        fetch('includes/datacontrol', { method: 'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                btn.disabled = false;
                btn.textContent = 'Reset password';
                if (data && data.success) {
                    showOk(data.message || 'Password updated. Redirecting to login…');
                    setTimeout(function () { window.location.href = data.redirect || '<?php echo $login_url; ?>'; }, 1800);
                } else {
                    showErr((data && data.message) ? data.message : 'Reset failed.');
                }
            })
            .catch(function () {
                btn.disabled = false;
                btn.textContent = 'Reset password';
                showErr('Request failed.');
            });
    });
})();
</script>
</body>
</html>
