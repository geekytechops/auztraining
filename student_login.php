<?php
session_start();
if(isset($_SESSION['user_type'])){
    if((int)$_SESSION['user_type'] === 0) { header('Location: index.php'); exit; } // staff use admin login
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
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .acc-vh {
            min-height: 100vh;
        }
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
            transition: all 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35) !important;
        }
        .btn-primary:disabled {
            opacity: 0.6;
            transform: none;
            box-shadow: none !important;
        }
        .form-control {
            border-radius: 10px !important;
            padding: 10px 14px !important;
            border: 1px solid #cbd5e1 !important;
            background-color: #fff !important;
            color: #0f172a !important;
            transition: all 0.2s !important;
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
            margin-bottom: 6px;
        }
        .input-group-text {
            border-radius: 0 10px 10px 0 !important;
            border: 1px solid #cbd5e1 !important;
            border-left: none !important;
            background-color: #fff !important;
            color: #64748b;
        }
        .input-group-flat input {
            border-radius: 10px 0 0 10px !important;
        }
        .qr-container {
            background: #fff;
            padding: 12px;
            border-radius: 12px;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            margin: 15px auto;
        }
        .copy-key-container {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .copy-key-text {
            font-family: monospace;
            font-size: 13px;
            color: #0f172a;
            font-weight: bold;
        }
        .copy-key-btn {
            background: transparent;
            border: none;
            color: #4f46e5;
            font-weight: 600;
            cursor: pointer;
            font-size: 12px;
        }
        .step-container {
            display: none;
        }
        .step-active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .badge-2fa {
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .back-link {
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #0f172a;
        }
        .account-bg-01 {
            background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%) !important;
            position: relative;
            overflow: hidden;
        }
        .account-bg-01::after {
            content: '';
            position: absolute;
            top: -20%;
            left: -20%;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            filter: blur(50px);
        }
        .otp-input-container {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .otp-input-field {
            width: 44px;
            height: 52px;
            font-size: 20px;
            font-weight: 700;
            border-radius: 10px !important;
            background: #fff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
            margin: 0 4px;
            text-align: center;
        }
        .otp-input-field:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15) !important;
        }
    </style>
</head>
<body class="account-page bg-white">
    <div class="main-wrapper">
        <div class="overflow-hidden p-3 acc-vh">
            <div class="row vh-100 w-100 g-0">
                <div class="col-lg-6 vh-100 overflow-y-auto overflow-x-hidden d-flex flex-column justify-content-between p-4">
                    
                    <!-- Logo Header -->
                    <div class="text-center mb-4 auth-logo">
                        <a href="student_login.php">
                            <img src="assets/img/logo.png" class="img-fluid" alt="Logo">
                        </a>
                    </div>

                    <!-- Main Auth Body Container -->
                    <div class="col-md-9 mx-auto">

                        <!-- STEP 1: CREDENTIALS -->
                        <div id="step_credentials" class="step-container step-active">
                            <div class="mb-4">
                                <h3 class="mb-1 font-weight-bold">Student Sign In</h3>
                                <p class="text-muted small">Log in to view and complete your enquiry.</p>
                            </div>
                            
                            <form id="credentials_form">
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group input-group-flat">
                                        <input type="email" class="form-control" id="email" placeholder="name@example.com" autocomplete="username">
                                        <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                    </div>
                                    <div class="invalid-feedback" id="email_error">Please enter your email.</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <div class="input-group input-group-flat pass-group">
                                        <input type="password" class="form-control pass-input" id="password" placeholder="Password" autocomplete="current-password">
                                        <span class="input-group-text toggle-password" style="cursor:pointer;"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                    <div class="invalid-feedback" id="password_error">Please enter your password.</div>
                                </div>

                                <div class="alert alert-danger py-2 mb-3" id="login_error" style="display:none;"></div>

                                <div class="mb-3">
                                    <button type="submit" id="btn_next" class="btn btn-primary w-100">Continue</button>
                                </div>
                                
                                <div class="mb-3 text-center">
                                    <p class="mb-0 small text-muted">New on our platform? <a href="student_register.php" class="link-indigo fw-bold link-hover" style="color: #4f46e5;">Create an account</a></p>
                                </div>
                            </form>
                        </div>

                        <!-- STEP 2A: GOOGLE AUTH LOGIN -->
                        <div id="step_google_auth" class="step-container">
                            <div class="text-center mb-4">
                                <span class="badge-2fa">2-Step Verification</span>
                                <h3 class="mb-1 font-weight-bold">Google Verification</h3>
                                <p class="text-muted small">Enter the 6-digit verification code generated by Google Authenticator.</p>
                            </div>
                            
                            <form id="google_auth_form">
                                <div class="mb-4">
                                    <label class="form-label d-block text-center">Verification Code</label>
                                    <div class="otp-input-container" data-target="google_auth_code">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                    </div>
                                    <input type="hidden" id="google_auth_code" value="">
                                    <div class="invalid-feedback text-center d-block" id="google_auth_code_error" style="display:none !important;">Invalid code.</div>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" id="btn_verify_google" class="btn btn-primary w-100">Verify</button>
                                </div>
                                
                                <div class="text-center">
                                    <a href="#" class="back-link btn-back-credentials"><i class="ti ti-arrow-left me-1"></i> Back to login</a>
                                </div>
                            </form>
                        </div>

                        <!-- STEP 2B: GOOGLE AUTH SETUP -->
                        <div id="step_google_setup" class="step-container">
                            <div class="text-center mb-3">
                                <span class="badge-2fa">Security Setup</span>
                                <h3 class="mb-1 font-weight-bold">Enable Two-Factor Auth</h3>
                                <p class="text-muted small">Scan this QR code using Google Authenticator, then enter the code below to complete setup.</p>
                                
                                <div id="qrcode_div" class="qr-container"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Setup Key (Manual Entry)</label>
                                <div class="copy-key-container">
                                    <span class="copy-key-text" id="setup_key_text"></span>
                                    <button type="button" class="copy-key-btn" id="btn_copy_key">Copy</button>
                                </div>
                            </div>

                            <form id="google_setup_form">
                                <div class="mb-4">
                                    <label class="form-label d-block text-center">Verification Code</label>
                                    <div class="otp-input-container" data-target="google_setup_code">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                    </div>
                                    <input type="hidden" id="google_setup_code" value="">
                                    <div class="invalid-feedback text-center d-block" id="google_setup_code_error" style="display:none !important;">Incorrect verification code.</div>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" id="btn_verify_setup" class="btn btn-primary w-100">Verify and Enable</button>
                                </div>
                                
                                <div class="text-center">
                                    <a href="#" class="back-link btn-back-credentials"><i class="ti ti-arrow-left me-1"></i> Cancel setup</a>
                                </div>
                            </form>
                        </div>

                        <!-- STEP 2C: EMAIL OTP -->
                        <div id="step_email_otp" class="step-container">
                            <div class="text-center mb-4">
                                <span class="badge-2fa">OTP Verification</span>
                                <h3 class="mb-1 font-weight-bold">Enter OTP Code</h3>
                                <p class="text-muted small" id="otp_sent_info">A one-time passcode has been sent to your email.</p>
                            </div>
                            
                            <form id="email_otp_form">
                                <div class="mb-4">
                                    <label class="form-label d-block text-center">OTP Code</label>
                                    <div class="otp-input-container" data-target="email_otp_code">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                        <input type="text" class="form-control otp-input-field" maxlength="1" pattern="\d" inputmode="numeric">
                                    </div>
                                    <input type="hidden" id="email_otp_code" value="">
                                    <div class="invalid-feedback text-center d-block" id="email_otp_code_error" style="display:none !important;">Invalid OTP.</div>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" id="btn_verify_otp" class="btn btn-primary w-100">Verify</button>
                                </div>
                                
                                <div id="login_sending_wrap" class="text-center text-muted small mb-3" style="display:none;">
                                    <span class="spinner-border spinner-border-sm align-middle me-2" role="status" aria-hidden="true"></span>Resending OTP…
                                </div>

                                <div class="text-center">
                                    <a href="#" class="back-link btn-back-credentials"><i class="ti ti-arrow-left me-1"></i> Back to login</a>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted small mb-0">Copyright &copy; <?php echo date('Y'); ?> - National College Australia</p>
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
    $(document).ready(function() {
        var loginOtpBypass = false;

        function showStep(stepId) {
            $('.step-container').removeClass('step-active');
            $('#' + stepId).addClass('step-active');
        }

        // Toggle Password visibility
        $(document).on('click', '.toggle-password', function() {
            var input = $('#password');
            var icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('ti-eye-off').addClass('ti-eye');
            } else {
                input.attr('type', 'password');
                icon.removeClass('ti-eye').addClass('ti-eye-off');
            }
        });

        // Copy Setup Key function
        $(document).on('click', '#btn_copy_key', function() {
            var keyText = $('#setup_key_text').text().replace(/\s+/g, '');
            navigator.clipboard.writeText(keyText).then(function() {
                $('#btn_copy_key').text('Copied!').css('color', '#10b981');
                setTimeout(function() {
                    $('#btn_copy_key').text('Copy').css('color', '#4f46e5');
                }, 2000);
            });
        });

        // Clear OTP containers helper
        function clearOtpContainer(containerTarget) {
            var $container = $('.otp-input-container[data-target="' + containerTarget + '"]');
            $container.find('.otp-input-field').val('');
            $('#' + containerTarget).val('');
        }

        // Back to credentials button
        $(document).on('click', '.btn-back-credentials', function(e) {
            e.preventDefault();
            $('#password').val('');
            clearOtpContainer('google_auth_code');
            clearOtpContainer('google_setup_code');
            clearOtpContainer('email_otp_code');
            $('#login_error').hide();
            $('.invalid-feedback').css('display', 'none', 'important');
            showStep('step_credentials');
        });

        // OTP inputs autofocus and pasting logic
        $('.otp-input-container').each(function() {
            var $container = $(this);
            var targetId = $container.data('target');
            var $inputs = $container.find('.otp-input-field');
            var $hidden = $('#' + targetId);

            $inputs.on('keyup input', function(e) {
                var $el = $(this);
                var val = $el.val();
                
                $el.val(val.replace(/\D/g, ''));
                
                if ($el.val().length === 1) {
                    $el.next('.otp-input-field').focus();
                }
                
                var code = '';
                $inputs.each(function() {
                    code += $(this).val();
                });
                $hidden.val(code);
            });

            $inputs.on('keydown', function(e) {
                var $el = $(this);
                if (e.key === 'Backspace') {
                    if ($el.val().length === 0) {
                        $el.prev('.otp-input-field').focus().val('');
                    } else {
                        $el.val('');
                    }
                    
                    setTimeout(function() {
                        var code = '';
                        $inputs.each(function() {
                            code += $(this).val();
                        });
                        $hidden.val(code);
                    }, 0);
                }
            });

            $inputs.on('paste', function(e) {
                e.preventDefault();
                var pasteData = (e.originalEvent || e).clipboardData.getData('text');
                var digits = pasteData.replace(/\D/g, '').substring(0, 6);
                
                for (var i = 0; i < digits.length; i++) {
                    $inputs.eq(i).val(digits[i]);
                }
                
                $hidden.val(digits);
                
                if (digits.length > 0) {
                    $inputs.eq(Math.min(digits.length - 1, 5)).focus();
                }
            });
        });

        // Form 1: Credentials submission
        $('#credentials_form').on('submit', function(e) {
            e.preventDefault();
            $('#login_error').hide();
            $('#email_error').css('display', 'none', 'important');
            $('#password_error').css('display', 'none', 'important');

            var email = $('#email').val().trim();
            var password = $('#password').val();
            var hasError = false;

            if (!email) {
                $('#email_error').css('display', 'block', 'important');
                hasError = true;
            }
            if (!password) {
                $('#password_error').css('display', 'block', 'important');
                hasError = true;
            }

            if (hasError) return;

            var btn = $('#btn_next');
            btn.prop('disabled', true).text('Processing…');

            var fd = new FormData();
            fd.append('formName', 'student_login_request_otp');
            fd.append('email', email);
            fd.append('password', password);

            fetch('includes/datacontrol', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data && data.success) {
                        loginOtpBypass = !!data.otp_bypass;

                        if (data.method === 'google_auth') {
                            if (data.setup) {
                                $('#qrcode_div').empty();
                                new QRCode(document.getElementById("qrcode_div"), {
                                    text: data.totp_uri,
                                    width: 160,
                                    height: 160,
                                    colorDark : "#0f172a",
                                    colorLight : "#ffffff",
                                    correctLevel : QRCode.CorrectLevel.H
                                });
                                $('#setup_key_text').text(data.secret.match(/.{1,4}/g).join(' '));
                                showStep('step_google_setup');
                            } else {
                                showStep('step_google_auth');
                                $('.otp-input-container[data-target="google_auth_code"] .otp-input-field').first().focus();
                            }
                        } else {
                            $('#otp_sent_info').text(data.message || 'OTP sent to your email.');
                            showStep('step_email_otp');
                            $('.otp-input-container[data-target="email_otp_code"] .otp-input-field').first().focus();
                        }
                    } else {
                        $('#login_error').text(data && data.message ? data.message : 'Invalid email or password.').show();
                    }
                })
                .catch(function() {
                    $('#login_error').text('Network error. Please try again.').show();
                })
                .finally(function() {
                    btn.prop('disabled', false).text('Continue');
                });
        });

        // Form 2A: Google Auth Verification
        $('#google_auth_form').on('submit', function(e) {
            e.preventDefault();
            $('#google_auth_code_error').css('display', 'none', 'important');

            var code = $('#google_auth_code').val().trim();
            if (!/^\d{6}$/.test(code)) {
                $('#google_auth_code_error').text('Please enter a valid 6-digit code.').css('display', 'block', 'important');
                return;
            }

            var btn = $('#btn_verify_google');
            btn.prop('disabled', true).text('Verifying…');

            var fd = new FormData();
            fd.append('formName', 'student_login_verify_google_auth');
            fd.append('code', code);

            fetch('includes/datacontrol', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data && data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        $('#google_auth_code_error').text(data && data.message ? data.message : 'Invalid code.').css('display', 'block', 'important');
                    }
                })
                .catch(function() {
                    $('#google_auth_code_error').text('Network error. Please try again.').css('display', 'block', 'important');
                })
                .finally(function() {
                    btn.prop('disabled', false).text('Verify');
                });
        });

        // Form 2B: Google Setup Verification
        $('#google_setup_form').on('submit', function(e) {
            e.preventDefault();
            $('#google_setup_code_error').css('display', 'none', 'important');

            var code = $('#google_setup_code').val().trim();
            if (!/^\d{6}$/.test(code)) {
                $('#google_setup_code_error').text('Please enter a valid 6-digit code.').css('display', 'block', 'important');
                return;
            }

            var btn = $('#btn_verify_setup');
            btn.prop('disabled', true).text('Activating…');

            var fd = new FormData();
            fd.append('formName', 'student_login_verify_google_auth');
            fd.append('code', code);

            fetch('includes/datacontrol', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data && data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        $('#google_setup_code_error').text(data && data.message ? data.message : 'Invalid code.').css('display', 'block', 'important');
                    }
                })
                .catch(function() {
                    $('#google_setup_code_error').text('Network error. Please try again.').css('display', 'block', 'important');
                })
                .finally(function() {
                    btn.prop('disabled', false).text('Verify and Enable');
                });
        });

        // Form 2C: Email OTP Verification
        $('#email_otp_form').on('submit', function(e) {
            e.preventDefault();
            $('#email_otp_code_error').css('display', 'none', 'important');

            var otp = $('#email_otp_code').val().trim();
            if (!loginOtpBypass && !/^\d{6}$/.test(otp)) {
                $('#email_otp_code_error').text('Please enter a valid 6-digit OTP.').css('display', 'block', 'important');
                return;
            }

            var btn = $('#btn_verify_otp');
            btn.prop('disabled', true).text('Verifying…');

            var fd = new FormData();
            fd.append('formName', 'student_login_verify_otp');
            fd.append('otp', otp);

            fetch('includes/datacontrol', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data && data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        $('#email_otp_code_error').text(data && data.message ? data.message : 'Invalid OTP.').css('display', 'block', 'important');
                    }
                })
                .catch(function() {
                    $('#email_otp_code_error').text('Network error. Please try again.').css('display', 'block', 'important');
                })
                .finally(function() {
                    btn.prop('disabled', false).text('Verify');
                });
        });
    });
    </script>
</body>
</html>
