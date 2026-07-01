<?php 
if(@$_GET['name']=='logout'){
    session_start();
    session_destroy();
}
session_start();
if(@$_SESSION['user_id']!=''){
    header('Location: dashboard.php');
}else{
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Login | Auztraining</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Auztraining Premium Portal Login" name="description" />
        <meta content="Auztraining" name="author" />
        <link rel="shortcut icon" href="assets/img/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <?php include('includes/app_includes.php'); ?>

        <style>
            body.bg-pattern {
                background: #05070f !important;
                font-family: 'Plus Jakarta Sans', sans-serif;
                color: #f8fafc;
                overflow-x: hidden;
                position: relative;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .bg-overlay {
                background: radial-gradient(circle at 50% 50%, rgba(5, 7, 15, 0.4) 0%, #03050a 100%) !important;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            }
            .glow-orb {
                position: absolute;
                width: 500px;
                height: 500px;
                border-radius: 50%;
                filter: blur(150px);
                z-index: -2;
                opacity: 0.18;
                pointer-events: none;
            }
            @keyframes drift-glow-1 {
                0% { transform: translate(0, 0) scale(1); }
                33% { transform: translate(60px, 40px) scale(1.15); }
                66% { transform: translate(-40px, 80px) scale(0.85); }
                100% { transform: translate(0, 0) scale(1); }
            }
            @keyframes drift-glow-2 {
                0% { transform: translate(0, 0) scale(1); }
                33% { transform: translate(-70px, -50px) scale(0.9); }
                66% { transform: translate(50px, -30px) scale(1.1); }
                100% { transform: translate(0, 0) scale(1); }
            }
            .glow-1 {
                background: #6366f1;
                top: 5%;
                left: 8%;
                animation: drift-glow-1 15s infinite ease-in-out;
            }
            .glow-2 {
                background: #0ea5e9;
                bottom: 5%;
                right: 8%;
                animation: drift-glow-2 18s infinite ease-in-out;
            }
            .account-pages {
                width: 100%;
                max-width: 440px;
                padding: 20px;
                z-index: 10;
            }
            .glass-card {
                background: rgba(10, 15, 30, 0.7) !important;
                backdrop-filter: blur(25px) saturate(200%);
                -webkit-backdrop-filter: blur(25px) saturate(200%);
                border: 1px solid rgba(255, 255, 255, 0.08) !important;
                border-radius: 28px !important;
                box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.8) !important;
                position: relative;
                overflow: hidden;
                color: #e2e8f0;
            }
            .glass-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, #6366f1, #0ea5e9);
            }
            .auth-logo-img {
                filter: drop-shadow(0 4px 12px rgba(0,0,0,0.5));
                transition: transform 0.3s ease;
            }
            .auth-logo-img:hover {
                transform: scale(1.03);
            }
            .form-label {
                color: #94a3b8 !important;
                font-weight: 500;
                font-size: 13px;
                margin-bottom: 8px;
                letter-spacing: 0.5px;
            }
            .form-control {
                background: rgba(15, 23, 42, 0.6) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                color: #fff !important;
                border-radius: 14px !important;
                padding: 12px 16px !important;
                transition: all 0.3s ease !important;
                font-size: 14px;
            }
            .form-control:focus {
                border-color: #0ea5e9 !important;
                box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.2) !important;
                background: rgba(15, 23, 42, 0.8) !important;
            }
            .form-control::placeholder {
                color: #475569 !important;
            }
            .btn-primary {
                background: linear-gradient(135deg, #6366f1 0%, #0ea5e9 100%) !important;
                border: none !important;
                border-radius: 14px !important;
                padding: 13px !important;
                font-weight: 600 !important;
                font-size: 15px;
                letter-spacing: 0.5px;
                box-shadow: 0 4px 18px 0 rgba(99, 102, 241, 0.35) !important;
                transition: all 0.3s ease !important;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 24px 0 rgba(14, 165, 233, 0.5) !important;
            }
            .btn-primary:active {
                transform: translateY(0);
            }
            .btn-primary:disabled {
                opacity: 0.6;
                transform: none;
                box-shadow: none !important;
            }
            .error-feedback {
                color: #f87171 !important;
                font-size: 12px;
                margin-top: 6px;
                display: none;
                font-weight: 500;
            }
            .qr-container {
                background: #fff;
                padding: 18px;
                border-radius: 20px;
                display: inline-block;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
                margin: 20px auto;
            }
            .copy-key-container {
                background: rgba(15, 23, 42, 0.8);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 14px;
                padding: 11px 15px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 20px;
                width: 100%;
            }
            .copy-key-text {
                font-family: 'Courier New', Courier, monospace;
                font-size: 14px;
                color: #38bdf8;
                font-weight: 600;
                letter-spacing: 1px;
            }
            .copy-key-btn {
                background: transparent;
                border: none;
                color: #0ea5e9;
                cursor: pointer;
                padding: 4px 10px;
                border-radius: 8px;
                transition: all 0.2s;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
            }
            .copy-key-btn:hover {
                color: #fff;
                background: rgba(14, 165, 233, 0.15);
            }
            .step-container {
                display: none;
            }
            .step-active {
                display: block;
                animation: fadeIn 0.4s ease-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(12px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .badge-2fa {
                background: rgba(14, 165, 233, 0.12);
                color: #38bdf8;
                border: 1px solid rgba(14, 165, 233, 0.25);
                border-radius: 20px;
                padding: 5px 14px;
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1.2px;
                display: inline-block;
                margin-bottom: 14px;
            }
            .back-link {
                color: #64748b;
                text-decoration: none;
                font-size: 13px;
                transition: color 0.2s;
                display: inline-flex;
                align-items: center;
                margin-top: 15px;
            }
            .back-link:hover {
                color: #fff;
            }
            .otp-input-container {
                display: flex;
                justify-content: space-between;
                margin: 20px 0;
            }
            .otp-input-field {
                width: 48px;
                height: 56px;
                font-size: 22px;
                font-weight: 700;
                border-radius: 12px !important;
                background: rgba(15, 23, 42, 0.6) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                color: #fff !important;
                margin: 0 4px;
            }
            .otp-input-field:focus {
                border-color: #0ea5e9 !important;
                box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.25) !important;
            }
        </style>

    </head>

    <body class="bg-pattern">
        <div class="glow-orb glow-1"></div>
        <div class="glow-orb glow-2"></div>
        <div class="bg-overlay"></div>
        
        <div class="account-pages">
            <div class="card glass-card">
                <div class="card-body p-4">
                    
                    <!-- Logo Header -->
                    <div class="text-center mb-4">
                        <a href="index.php">
                            <img src="assets/img/logo.png" alt="Logo" height="50" class="auth-logo-img logo-light mx-auto">
                        </a>
                    </div>

                    <!-- STEP 1: CREDENTIALS -->
                    <div id="step_credentials" class="step-container step-active">
                        <h4 class="font-size-18 text-white mt-2 text-center font-weight-bold">Welcome Back</h4>
                        <p class="text-muted text-center small mb-4">Please log in to your account.</p>
                        
                        <form id="credentials_form">
                            <div class="mb-3">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" placeholder="name@example.com" autocomplete="username">
                                <div class="error-feedback" id="email_error">Please enter a valid email address.</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="••••••••" autocomplete="current-password">
                                <div class="error-feedback" id="password_error">Please enter your password.</div>
                            </div>

                            <div class="text-end mb-3">
                                <a href="forgot_password.php?portal=admin" class="back-link" style="margin-top:0;">Forgot password?</a>
                            </div>

                            <div class="error-feedback text-center mb-3" id="login_error" style="font-size: 14px;">Invalid credentials.</div>

                            <div class="d-grid">
                                <button class="btn btn-primary w-100" id="btn_next" type="submit">Continue</button>
                            </div>
                        </form>
                    </div>

                    <!-- STEP 2A: GOOGLE AUTH LOGIN -->
                    <div id="step_google_auth" class="step-container">
                        <div class="text-center">
                            <span class="badge-2fa">2-Step Verification</span>
                            <h4 class="font-size-18 text-white font-weight-bold">Google Authenticator</h4>
                            <p class="text-muted small">Enter the 6-digit verification code generated by Google Authenticator.</p>
                        </div>
                        
                        <form id="google_auth_form">
                            <div class="mb-4">
                                <label class="form-label d-block text-center">Verification Code</label>
                                <div class="otp-input-container" data-target="google_auth_code">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                </div>
                                <input type="hidden" id="google_auth_code" value="">
                                <div class="error-feedback text-center" id="google_auth_code_error">Invalid verification code.</div>
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-primary w-100" id="btn_verify_google" type="submit">Verify</button>
                            </div>
                            
                            <div class="text-center">
                                <a href="#" class="back-link btn-back-credentials"><i class="ti ti-arrow-left me-1"></i> Back to login</a>
                            </div>
                        </form>
                    </div>

                    <!-- STEP 2B: GOOGLE AUTH SETUP -->
                    <div id="step_google_setup" class="step-container">
                        <div class="text-center">
                            <span class="badge-2fa">Security Setup</span>
                            <h4 class="font-size-18 text-white font-weight-bold">Enable Two-Factor Auth</h4>
                            <p class="text-muted small">Scan this QR code using Google Authenticator and enter the verification code to finish setup.</p>
                            
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
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                </div>
                                <input type="hidden" id="google_setup_code" value="">
                                <div class="error-feedback text-center" id="google_setup_code_error">Incorrect verification code.</div>
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-primary w-100" id="btn_verify_setup" type="submit">Verify and Enable</button>
                            </div>
                            
                            <div class="text-center">
                                <a href="#" class="back-link btn-back-credentials"><i class="ti ti-arrow-left me-1"></i> Cancel setup</a>
                            </div>
                        </form>
                    </div>

                    <!-- STEP 2C: EMAIL OTP -->
                    <div id="step_email_otp" class="step-container">
                        <div class="text-center">
                            <span class="badge-2fa">OTP Verification</span>
                            <h4 class="font-size-18 text-white font-weight-bold">Enter OTP Code</h4>
                            <p class="text-muted small" id="otp_sent_info">A one-time passcode has been sent to your email.</p>
                        </div>
                        
                        <form id="email_otp_form">
                            <div class="mb-4">
                                <label class="form-label d-block text-center">OTP Code</label>
                                <div class="otp-input-container" data-target="email_otp_code">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                    <input type="text" class="form-control otp-input-field text-center" maxlength="1" pattern="\d" inputmode="numeric">
                                </div>
                                <input type="hidden" id="email_otp_code" value="">
                                <div class="error-feedback text-center" id="email_otp_code_error">Invalid OTP.</div>
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-primary w-100" id="btn_verify_otp" type="submit">Verify</button>
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
            </div>
        </div>

        <?php include('includes/footer_includes.php'); ?>

        <script>
            $(document).ready(function() {
                var loginOtpBypass = false;

                function showStep(stepId) {
                    $('.step-container').removeClass('step-active');
                    $('#' + stepId).addClass('step-active');
                }

                // Copy Setup Key function
                $(document).on('click', '#btn_copy_key', function() {
                    var keyText = $('#setup_key_text').text().replace(/\s+/g, '');
                    navigator.clipboard.writeText(keyText).then(function() {
                        $('#btn_copy_key').text('Copied!').addClass('text-success');
                        setTimeout(function() {
                            $('#btn_copy_key').text('Copy').removeClass('text-success');
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
                    // Reset fields
                    $('#password').val('');
                    clearOtpContainer('google_auth_code');
                    clearOtpContainer('google_setup_code');
                    clearOtpContainer('email_otp_code');
                    $('.error-feedback').hide();
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
                    $('.error-feedback').hide();

                    var email = $('#email').val().trim();
                    var password = $('#password').val().trim();
                    var hasError = false;

                    if (email === '') {
                        $('#email_error').show();
                        hasError = true;
                    }
                    if (password === '') {
                        $('#password_error').show();
                        hasError = true;
                    }

                    if (hasError) return;

                    var btn = $('#btn_next');
                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm align-middle me-2"></span>Processing…');

                    $.ajax({
                        type: 'POST',
                        url: 'includes/datacontrol',
                        data: {
                            formName: 'login_request_otp',
                            email: email,
                            password: password
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data && data.success) {
                                if (data.auto_login) {
                                    window.location.href = data.redirect || "dashboard.php";
                                    return;
                                }
                                
                                loginOtpBypass = !!data.otp_bypass;

                                if (data.method === 'google_auth') {
                                    if (data.setup) {
                                        $('#qrcode_div').empty();
                                        new QRCode(document.getElementById("qrcode_div"), {
                                            text: data.totp_uri,
                                            width: 180,
                                            height: 180,
                                            colorDark : "#05070f",
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
                                    $('#otp_sent_info').text(data.message || 'A one-time passcode has been sent to your email.');
                                    showStep('step_email_otp');
                                    $('.otp-input-container[data-target="email_otp_code"] .otp-input-field').first().focus();
                                }
                            } else {
                                $('#login_error').text(data && data.message ? data.message : 'Invalid email or password.').show();
                            }
                        },
                        error: function() {
                            $('#login_error').text('Unable to connect to login server. Please try again.').show();
                        },
                        complete: function() {
                            btn.prop('disabled', false).text('Continue');
                        }
                    });
                });

                // Form 2A: Google Auth Code verification
                $('#google_auth_form').on('submit', function(e) {
                    e.preventDefault();
                    $('#google_auth_code_error').hide();

                    var code = $('#google_auth_code').val().trim();
                    if (!/^\d{6}$/.test(code)) {
                        $('#google_auth_code_error').text('Please enter a valid 6-digit code.').show();
                        return;
                    }

                    var btn = $('#btn_verify_google');
                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm align-middle me-2"></span>Verifying…');

                    $.ajax({
                        type: 'POST',
                        url: 'includes/datacontrol',
                        data: {
                            formName: 'login_verify_google_auth',
                            code: code
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data && data.success) {
                                var ut = parseInt(data.user_type, 10);
                                if (ut === 1 || ut === 2) {
                                    window.location.href = "dashboard.php";
                                } else {
                                    window.location.href = "student_docs.php";
                                }
                            } else {
                                $('#google_auth_code_error').text(data && data.message ? data.message : 'Invalid code.').show();
                            }
                        },
                        error: function() {
                            $('#google_auth_code_error').text('Error connecting to authentication service.').show();
                        },
                        complete: function() {
                            btn.prop('disabled', false).text('Verify');
                        }
                    });
                });

                // Form 2B: Google Setup Code verification
                $('#google_setup_form').on('submit', function(e) {
                    e.preventDefault();
                    $('#google_setup_code_error').hide();

                    var code = $('#google_setup_code').val().trim();
                    if (!/^\d{6}$/.test(code)) {
                        $('#google_setup_code_error').text('Please enter a valid 6-digit code.').show();
                        return;
                    }

                    var btn = $('#btn_verify_setup');
                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm align-middle me-2"></span>Activating…');

                    $.ajax({
                        type: 'POST',
                        url: 'includes/datacontrol',
                        data: {
                            formName: 'login_verify_google_auth',
                            code: code
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data && data.success) {
                                var ut = parseInt(data.user_type, 10);
                                if (ut === 1 || ut === 2) {
                                    window.location.href = "dashboard.php";
                                } else {
                                    window.location.href = "student_docs.php";
                                }
                            } else {
                                $('#google_setup_code_error').text(data && data.message ? data.message : 'Invalid code.').show();
                            }
                        },
                        error: function() {
                            $('#google_setup_code_error').text('Error activating Google Authenticator.').show();
                        },
                        complete: function() {
                            btn.prop('disabled', false).text('Verify and Enable');
                        }
                    });
                });

                // Form 2C: Email OTP verification
                $('#email_otp_form').on('submit', function(e) {
                    e.preventDefault();
                    $('#email_otp_code_error').hide();

                    var otp = $('#email_otp_code').val().trim();
                    if (!loginOtpBypass && !/^\d{6}$/.test(otp)) {
                        $('#email_otp_code_error').text('Please enter a valid 6-digit OTP.').show();
                        return;
                    }

                    var btn = $('#btn_verify_otp');
                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm align-middle me-2"></span>Verifying…');

                    $.ajax({
                        type: 'POST',
                        url: 'includes/datacontrol',
                        data: {
                            formName: 'login_verify_otp',
                            otp: otp
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data && data.success) {
                                var ut = parseInt(data.user_type, 10);
                                if (ut === 1 || ut === 2) {
                                    window.location.href = "dashboard.php";
                                } else {
                                    window.location.href = "student_docs.php";
                                }
                            } else {
                                $('#email_otp_code_error').text(data && data.message ? data.message : 'Invalid OTP.').show();
                            }
                        },
                        error: function() {
                            $('#email_otp_code_error').text('Error verifying OTP. Please try again.').show();
                        },
                        complete: function() {
                            btn.prop('disabled', false).text('Verify');
                        }
                    });
                });
            });
        </script>
    </body>
</html>
<?php } ?>