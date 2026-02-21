<?php
session_start();
if(isset($_SESSION['user_type'])){
    if((int)$_SESSION['user_type'] === 0) { header('Location: student_docs.php'); exit; }
    if($_SESSION['user_type'] === 'student') { header('Location: student_portal.php'); exit; }
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
    <link rel="shortcut icon" href="<?php echo $asset_base; ?>/img/favicon.png">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/style.css" id="app-style">
</head>
<body class="account-page bg-white">
    <div class="main-wrapper">
        <div class="overflow-hidden p-3 acc-vh">
            <div class="row vh-100 w-100 g-0">
                <div class="col-lg-6 vh-100 overflow-y-auto overflow-x-hidden">
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <form id="login_form" class="vh-100 d-flex justify-content-between flex-column p-4 pb-0">
                                <div class="text-center mb-4 auth-logo">
                                    <a href="student_login.php"><img src="<?php echo $asset_base; ?>/img/logo.svg" class="img-fluid" alt="Logo" onerror="this.style.display='none';this.nextElementSibling.style.display='block';"><span class="h4 mb-0" style="display:none;">NCA</span></a>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <h3 class="mb-2">Student Sign In</h3>
                                        <p class="mb-0">Log in to view and complete your enquiry.</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <div class="input-group input-group-flat">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                        </div>
                                        <div class="invalid-feedback d-block" id="email_err" style="display:none !important;">Please enter your email.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group input-group-flat pass-group">
                                            <input type="password" class="form-control pass-input" id="password" name="password" placeholder="Password" required>
                                            <span class="input-group-text toggle-password"><i class="ti ti-eye-off"></i></span>
                                        </div>
                                        <div class="invalid-feedback d-block" id="pass_err" style="display:none !important;">Please enter your password.</div>
                                    </div>
                                    <div class="alert alert-danger py-2 mb-3" id="form_error" style="display:none;"></div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0">New on our platform? <a href="student_register.php" class="link-indigo fw-bold link-hover">Create an account</a></p>
                                    </div>
                                </div>
                                <div class="text-center pb-4">
                                    <p class="text-dark mb-0">Copyright &copy; <?php echo date('Y'); ?> - National College Australia</p>
                                </div>
                            </form>
                        </div>
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
    document.getElementById('login_form').addEventListener('submit', function(e){
        e.preventDefault();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value;
        var errEl = document.getElementById('form_error');
        errEl.style.display = 'none';
        document.getElementById('email_err').style.setProperty('display','none','important');
        document.getElementById('pass_err').style.setProperty('display','none','important');
        if(!email){ document.getElementById('email_err').style.setProperty('display','block','important'); return; }
        if(!password){ document.getElementById('pass_err').style.setProperty('display','block','important'); return; }
        var fd = new FormData();
        fd.append('formName', 'student_login');
        fd.append('email', email);
        fd.append('password', password);
        fetch('includes/datacontrol.php', { method: 'POST', body: fd })
            .then(function(r){ return r.json(); })
            .then(function(data){
                if(data.success && data.redirect){ window.location.href = data.redirect; }
                else { errEl.textContent = data.message || 'Invalid email or password.'; errEl.style.display = 'block'; }
            })
            .catch(function(){ errEl.textContent = 'Network error. Please try again.'; errEl.style.display = 'block'; });
    });
    </script>
</body>
</html>
