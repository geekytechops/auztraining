<?php
include('includes/dbconnect.php');
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '') {
    header('Location: index.php');
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$userRes = mysqli_query($connection, "SELECT * FROM users WHERE user_id = $user_id LIMIT 1");
$user = $userRes ? mysqli_fetch_assoc($userRes) : null;

$name = $user ? $user['user_name'] : '';
$email = $user ? $user['user_email'] : '';
$phone = $user && isset($user['user_phone']) ? $user['user_phone'] : '';
$address = $user && isset($user['user_address']) ? $user['user_address'] : '';
$roleLabel = 'User';
if ($user) {
    if ((int)$user['user_type'] === 1) $roleLabel = 'Admin';
    elseif ((int)$user['user_type'] === 2) $roleLabel = 'Staff';
}

// Load enquiry email templates data for admin users (for Settings → Enquiry Email Templates)
$is_admin = isset($user['user_type']) && (int)$user['user_type'] === 1;
$status_labels = array(
    1 => 'New',
    2 => 'Contacted',
    3 => 'Follow-up Required',
    4 => 'Interested',
    5 => 'Documents Collected',
    6 => 'Enrolled',
    7 => 'Not Interested',
    8 => 'Invalid / Duplicate'
);
$templates = array();
if ($is_admin) {
    $q = mysqli_query($connection, "SELECT id, status_code, subject, body, updated_at FROM enquiry_status_email_templates ORDER BY status_code");
    if ($q && mysqli_num_rows($q)) {
        while ($row = mysqli_fetch_assoc($q)) {
            $templates[$row['status_code']] = $row;
        }
    }
    for ($i = 1; $i <= 8; $i++) {
        if (!isset($templates[$i])) {
            $templates[$i] = array('id' => '', 'status_code' => $i, 'subject' => '', 'body' => '', 'updated_at' => null);
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Profile & Settings</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include('includes/app_includes.php'); ?>
    </head>
    <body>
        <div class="main-wrapper">
            <?php include('includes/header.php'); ?>
            <?php include('includes/sidebar.php'); ?>

            <div class="page-wrapper">
                <div class="content pb-0">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Settings</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                            <li class="breadcrumb-item active">Settings</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 mb-3">
                            <div class="card-body pb-0 pt-0 px-2">
                                <ul class="nav nav-tabs nav-bordered nav-bordered-primary">
                                    <li class="nav-item me-3">
                                        <a href="javascript:void(0);" class="nav-link p-2 active settings-main-tab" data-target="#settings_profile_section">
                                            <i class="ti ti-settings-cog me-2"></i>Profile
                                        </a>
                                    </li>
                                    <li class="nav-item me-3">
                                        <a href="javascript:void(0);" class="nav-link p-2 settings-main-tab" data-target="#settings_security_section">
                                            <i class="ti ti-lock me-2"></i>Security
                                        </a>
                                    </li>
                                    <li class="nav-item me-3">
                                        <a href="javascript:void(0);" class="nav-link p-2 settings-main-tab" data-target="#settings_email_section">
                                            <i class="ti ti-mail me-2"></i>Enquiry Email Templates
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-lg-12">
                                <div class="card mb-3 mb-xl-0">
                                    <div class="card-body">
                                        <div class="settings-sidebar">
                                            <h5 class="mb-3 fs-17">Profile Settings</h5>
                                            <div class="list-group list-group-flush settings-sidebar">
                                                <a href="javascript:void(0);" class="d-block p-2 fw-medium settings-side-link active" data-target="#settings_profile_section">Profile</a>
                                                <a href="javascript:void(0);" class="d-block p-2 fw-medium settings-side-link" data-target="#settings_security_section">Change Password</a>
                                                <a href="javascript:void(0);" class="d-block p-2 fw-medium settings-side-link" data-target="#settings_email_section">Enquiry Email Templates</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-9 col-lg-12">
                                <div class="card mb-0">
                                    <div class="card-body">

                                        <div id="settings_profile_section">
                                            <div class="border-bottom mb-3 pb-3 d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0 fs-17">Profile</h5>
                                                <span class="badge bg-info"><?php echo htmlspecialchars($roleLabel); ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="mb-1">Account Information</h6>
                                                <p class="mb-0 text-muted">Update your basic details below.</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="profile_name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
                                                        <div class="error-feedback">Please enter your name.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                                        <input type="email" id="profile_email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
                                                        <div class="error-feedback">Please enter a valid email.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Mobile</label>
                                                        <input type="text" id="profile_phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Address</label>
                                                        <textarea id="profile_address" class="form-control" rows="2"><?php echo htmlspecialchars($address); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-sm btn-primary" id="save_profile_btn">Save Changes</button>
                                            </div>
                                        </div>

                                        <div id="settings_security_section" class="d-none">
                                            <div class="border-bottom mb-3 pb-3">
                                                <h5 class="mb-0 fs-17">Security</h5>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="mb-1">Change Password</h6>
                                                <p class="mb-0 text-muted">Use a strong password that you do not use elsewhere.</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                                                        <input type="password" id="current_password" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                                                        <input type="password" id="new_password" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                                        <input type="password" id="confirm_password" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-sm btn-primary" id="change_password_btn">Update Password</button>
                                            </div>
                                        </div>

                                        <div id="settings_email_section" class="d-none">
                                            <div class="border-bottom mb-3 pb-3">
                                                <h5 class="mb-0 fs-17">Enquiry Email Templates</h5>
                                            </div>
                                            <?php if($is_admin){ ?>
                                            <p class="text-muted">
                                                Manage the default email templates used for each enquiry status (New, Contacted, Follow-up Required, etc.).
                                                These templates are used in the Follow-up section when sending status emails to students.
                                                You can use placeholders: <code>{{FirstName}}</code>, <code>{{CourseName}}</code>, <code>{{OfficerName}}</code> (and legacy <code>{{student_name}}</code>).
                                            </p>
                                            <div class="accordion" id="templatesAccordion">
                                                <?php for ($i = 1; $i <= 8; $i++) {
                                                    $t = $templates[$i];
                                                    $sid = (int)$t['status_code'];
                                                    $subj = htmlspecialchars($t['subject'] ?? '');
                                                    $body = htmlspecialchars($t['body'] ?? '');
                                                    $updated = !empty($t['updated_at']) ? date('d M Y H:i', strtotime($t['updated_at'])) : '—';
                                                ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="head<?php echo $sid; ?>">
                                                        <button class="accordion-button <?php echo $i > 1 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $sid; ?>" aria-expanded="<?php echo $i === 1 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $sid; ?>">
                                                            <?php echo $status_labels[$i]; ?> <span class="badge bg-secondary ms-2">Status <?php echo $i; ?></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse<?php echo $sid; ?>" class="accordion-collapse collapse <?php echo $i === 1 ? 'show' : ''; ?>" aria-labelledby="head<?php echo $sid; ?>" data-bs-parent="#templatesAccordion">
                                                        <div class="accordion-body">
                                                            <div class="mb-2 small text-muted">Last updated: <?php echo $updated; ?></div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Subject</label>
                                                                <input type="text" class="form-control template-subject" data-status="<?php echo $sid; ?>" value="<?php echo $subj; ?>" placeholder="Email subject">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Body</label>
                                                                <textarea class="form-control template-body" data-status="<?php echo $sid; ?>" rows="8" placeholder="Email body. Use {{FirstName}}, {{CourseName}}, {{OfficerName}} as needed."><?php echo $body; ?></textarea>
                                                            </div>
                                                            <button type="button" class="btn btn-primary btn-sm save-template-btn" data-status="<?php echo $sid; ?>">Save template</button>
                                                            <span class="ms-2 save-feedback" data-status="<?php echo $sid; ?>"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php } else { ?>
                                            <p class="text-muted">
                                                Only admin users can manage enquiry email templates.
                                                Please contact an administrator if you need a template updated.
                                            </p>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer_includes.php'); ?>
        <script>
        $(function(){
            function showSection(target){
                $('#settings_profile_section, #settings_security_section, #settings_email_section').addClass('d-none');
                $(target).removeClass('d-none');
                $('.settings-main-tab, .settings-side-link').removeClass('active');
                $('.settings-main-tab[data-target="'+target+'"]').addClass('active');
                $('.settings-side-link[data-target="'+target+'"]').addClass('active');
            }

            $(document).on('click','.settings-main-tab, .settings-side-link',function(e){
                e.preventDefault();
                var target = $(this).data('target');
                if(target){
                    showSection(target);
                }
            });

            $('#save_profile_btn').on('click', function(){
                var name = $('#profile_name').val().trim();
                var email = $('#profile_email').val().trim();
                var phone = $('#profile_phone').val().trim();
                var address = $('#profile_address').val().trim();
                $('.error-feedback').hide();
                if(!name){
                    $('#profile_name').closest('.mb-3').find('.error-feedback').show();
                    return;
                }
                if(!email){
                    $('#profile_email').closest('.mb-3').find('.error-feedback').show();
                    return;
                }
                $.post('includes/datacontrol.php', {
                    formName: 'update_profile',
                    user_name: name,
                    user_email: email,
                    user_phone: phone,
                    user_address: address
                }, function(resp){
                    if(resp === '1'){
                        $('#toast-text').html('Profile updated successfully');
                        $('#borderedToast1Btn').trigger('click');
                    }else{
                        $('.toast-text2').html('Unable to update profile. Please try again.');
                        $('#borderedToast2Btn').trigger('click');
                    }
                });
            });

            $('#change_password_btn').on('click', function(){
                var current = $('#current_password').val().trim();
                var nw = $('#new_password').val().trim();
                var confirm = $('#confirm_password').val().trim();
                if(!current || !nw || !confirm){
                    $('.toast-text2').html('Please fill all password fields.');
                    $('#borderedToast2Btn').trigger('click');
                    return;
                }
                if(nw !== confirm){
                    $('.toast-text2').html('New password and confirm password do not match.');
                    $('#borderedToast2Btn').trigger('click');
                    return;
                }
                $.post('includes/datacontrol.php', {
                    formName: 'change_password',
                    current_password: current,
                    new_password: nw
                }, function(resp){
                    if(resp === '1'){
                        $('#toast-text').html('Password updated successfully');
                        $('#borderedToast1Btn').trigger('click');
                        $('#current_password, #new_password, #confirm_password').val('');
                    }else if(resp === 'INVALID'){
                        $('.toast-text2').html('Current password is incorrect.');
                        $('#borderedToast2Btn').trigger('click');
                    }else{
                        $('.toast-text2').html('Unable to update password. Please try again.');
                        $('#borderedToast2Btn').trigger('click');
                    }
                });
            });

            // Save enquiry email templates (admin only)
            $(document).on('click', '.save-template-btn', function(){
                var status = $(this).data('status');
                var subject = $('.template-subject[data-status="'+status+'"]').val().trim();
                var body = $('.template-body[data-status="'+status+'"]').val().trim();
                var $btn = $(this).prop('disabled', true).text('Saving...');
                var $fb = $('.save-feedback[data-status="'+status+'"]').removeClass('text-success text-danger').text('');
                $.post('includes/datacontrol.php', { save_enquiry_status_template: 1, status_code: status, subject: subject, body: body }, function(data){
                    $btn.prop('disabled', false).text('Save template');
                    if (data == '1') {
                        $fb.addClass('text-success').text('Saved.');
                        setTimeout(function(){ $fb.text(''); }, 3000);
                    } else {
                        $fb.addClass('text-danger').text('Failed to save.');
                    }
                });
            });
        });
        </script>
    </body>
</html>

