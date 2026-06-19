<?php
session_start();
if(isset($_SESSION['user_type'])){
    if((int)$_SESSION['user_type'] === 0) { header('Location: index.php'); exit; }
    if($_SESSION['user_type'] === 'student') { header('Location: student_enquiry_form.php'); exit; }
}
$asset_base = 'crm/html/template/assets';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student Login | National College Australia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link rel="shortcut icon" href="assets/img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/style.css" id="app-style">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .acc-vh { min-height: 100vh; }
        .auth-logo img {
            height: 60px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.05));
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 11px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25) !important;
        }
        .form-control {
            border-radius: 10px !important;
            padding: 10px 14px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15) !important;
        }
        .form-label {
            font-weight: 500;
            font-size: 13px;
            color: #475569;
        }
        .input-group-text {
            border-radius: 0 10px 10px 0 !important;
            border: 1px solid #cbd5e1 !important;
            border-left: none !important;
            background-color: #fff !important;
            color: #64748b;
        }
        .input-group-flat input { border-radius: 10px 0 0 10px !important; }
        .account-bg-01 {
            background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%) !important;
        }
    </style>
</head>
<body class="account-page bg-white">
    <div class="main-wrapper">
        <div class="overflow-hidden p-3 acc-vh">
            <div class="row vh-100 w-100 g-0">
                <div class="col-lg-6 vh-100 overflow-y-auto overflow-x-hidden d-flex flex-column justify-content-between p-4">
                    <div class="text-center mb-4 auth-logo">
                        <a href="student_login.php">
                            <img src="assets/img/logo.png" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="col-md-9 mx-auto">
                        <div class="mb-4">
                            <h3 class="mb-1 font-weight-bold">Student Sign In</h3>
                            <p class="text-muted small">Log in to view and complete your enquiry.</p>
                        </div>
                        <form id="login_form">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <div class="input-group input-group-flat">
                                    <input type="email" class="form-control" id="email" placeholder="name@example.com" autocomplete="username" required>
                                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                </div>
                                <div class="invalid-feedback d-block" id="email_error" style="display:none !important;">Please enter your email.</div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group input-group-flat pass-group">
                                    <input type="password" class="form-control pass-input" id="password" placeholder="Password" autocomplete="current-password" required>
                                    <span class="input-group-text toggle-password" style="cursor:pointer;"><i class="ti ti-eye-off"></i></span>
                                </div>
                                <div class="invalid-feedback d-block" id="password_error" style="display:none !important;">Please enter your password.</div>
                            </div>
                            <div class="alert alert-danger py-2 mb-3" id="login_error" style="display:none;"></div>
                            <div class="mb-3">
                                <button type="submit" id="login_btn" class="btn btn-primary w-100">Sign In</button>
                            </div>
                            <div class="mb-3 text-center">
                                <p class="mb-0 small text-muted">New on our platform? <a href="student_register.php" class="fw-bold" style="color: #4f46e5;">Create an account</a></p>
                            </div>
                        </form>
                    </div>
                    <div class="text-center pb-2">
                        <p class="text-dark mb-0 small">Copyright &copy; <?php echo date('Y'); ?> - National College Australia</p>
                    </div>
                </div>
                <div class="col-lg-6 account-bg-01"></div>
            </div>
        </div>
    </div>
    <script src="<?php echo $asset_base; ?>/js/jquery-3.7.1.min.js"></script>
    <script src="<?php echo $asset_base; ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $asset_base; ?>/js/script.js"></script>
    <script>
    document.getElementById('login_form').addEventListener('submit', function(e) {
        e.preventDefault();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value;
        var errEl = document.getElementById('login_error');
        var btn = document.getElementById('login_btn');

        errEl.style.display = 'none';
        document.getElementById('email_error').style.setProperty('display', 'none', 'important');
        document.getElementById('password_error').style.setProperty('display', 'none', 'important');

        if (!email) {
            document.getElementById('email_error').style.setProperty('display', 'block', 'important');
            return;
        }
        if (!password) {
            document.getElementById('password_error').style.setProperty('display', 'block', 'important');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Signing in…';

        var fd = new FormData();
        fd.append('formName', 'student_login_request_otp');
        fd.append('email', email);
        fd.append('password', password);

        fetch('includes/datacontrol', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data && data.success && data.auto_login && data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }
                errEl.textContent = (data && data.message) ? data.message : 'Invalid email or password.';
                errEl.style.display = 'block';
            })
            .catch(function() {
                errEl.textContent = 'Network error. Please try again.';
                errEl.style.display = 'block';
            })
            .finally(function() {
                btn.disabled = false;
                btn.textContent = 'Sign In';
            });
    });
    </script>
</body>
</html>
