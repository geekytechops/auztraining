<?php 
include('includes/dbconnect.php'); 
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] === ''){
    header('Location: index.php');
    exit;
}
if((int)@$_SESSION['user_type'] !== 1){
    header('Location: dashboard.php');
    exit;
}
$users=mysqli_query($connection,"SELECT * FROM users WHERE user_type IN (1,2) ORDER BY user_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Staff Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/logo-dark.png">
    <?php include('includes/app_includes.php'); ?>
</head>

<body>
    <div class="main-wrapper">

        <?php include('includes/header.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="page-wrapper">
            <div class="content pb-0">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Staff Management</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Staff Management</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Form + List -->
                    <form id="create_user_form" class="row">
                        <!-- LEFT SIDE: CREATE / EDIT FORM -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center" id="form_title">Create Staff</h4>
                                    <p class="text-muted small text-center mb-0">Create admin or staff accounts only. Students register via the student portal.</p>
                                    <input type="hidden" id="edit_user_id" value="">

                                    <div class="mb-3">
                                        <label class="form-label">Staff Name</label>
                                        <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Enter staff name" required>
                                        <div class="error-feedback">Please enter the staff name</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Staff Email</label>
                                        <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Enter email" required>
                                        <div class="error-feedback">Please enter a valid email</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Enter password" required>
                                        <div class="error-feedback">Please enter a password</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select id="user_type" name="user_type" class="form-select" required>
                                            <option value="">-- Select --</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Staff</option>
                                        </select>
                                        <div class="error-feedback">Please select a role</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select id="user_status" name="user_status" class="form-select">
                                            <option value="0">Active</option>
                                            <option value="1">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" id="create_user_submit" class="btn btn-primary w-50">Create Staff</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT SIDE: USER LIST -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Existing Staff</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
                                                    <th>MFA</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="user_list">
                                                <?php
                                                mysqli_data_seek($users, 0);
                                                include('includes/user_list_partial.php');
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form><!-- End Row -->

                </div>
            </div>
        </div>

    </div>
    <?php include('includes/footer_includes.php'); ?>

    <script>
        function staffMgmtToastError(msg) {
            $('.toast-text2').html(msg || 'Operation failed. Please try again later.');
            $('#borderedToast2Btn').trigger('click');
        }
        function staffMgmtToastOk(msg) {
            $('#toast-text').html(msg);
            $('#borderedToast1Btn').trigger('click');
        }
        function staffMgmtHandleListResponse(data, okMsg) {
            if (data === '1' || data === 1 || data === '0' || data === 0) {
                staffMgmtToastError();
                return;
            }
            if (data === 'EMAIL_EXISTS') {
                staffMgmtToastError('This email is already used by another staff account.');
                return;
            }
            if (data === 'SELF') {
                staffMgmtToastError('You cannot delete your own account.');
                return;
            }
            if (data === 'NO_MFA_COL') {
                staffMgmtToastError('Authenticator column is not available on this database.');
                return;
            }
            document.getElementById('create_user_form').reset();
            $('#edit_user_id').val('');
            $('#form_title').html('Create Staff');
            $('#create_user_submit').text('Create Staff');
            staffMgmtToastOk(okMsg);
            $('#user_list').html(data);
        }

        // CREATE / UPDATE USER
        $(document).on('click', '#create_user_submit', function(){
            var id = $('#edit_user_id').val();
            var name = $('#user_name').val().trim();
            var email = $('#user_email').val().trim();
            var password = $('#user_password').val().trim();
            var type = $('#user_type').val();
            var status = $('#user_status').val();

            if(name=='' || email=='' || (id=='' && password=='') || type==''){
                $('.error-feedback').hide();
                if(name=='') $('#user_name').closest('div').find('.error-feedback').show();
                if(email=='') $('#user_email').closest('div').find('.error-feedback').show();
                if(id=='' && password=='') $('#user_password').closest('div').find('.error-feedback').show();
                if(type=='') $('#user_type').closest('div').find('.error-feedback').show();
            }else{
                var details = {
                    formName: id ? 'edit_user' : 'create_user',
                    user_id: id,
                    user_name: name,
                    user_email: email,
                    user_password: password,
                    user_type: type,
                    user_status: status
                };

                $.ajax({
                    type: 'POST',
                    url: 'includes/datacontrol',
                    data: details,
                    success: function(data){
                        staffMgmtHandleListResponse(data, id ? 'User updated successfully!' : 'User created successfully!');
                    },
                    error: function(){ staffMgmtToastError(); }
                });
            }
        });

        // EDIT BUTTON CLICK
        $(document).on('click', '.edit_user', function(){
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'includes/datacontrol',
                data: {formName: 'get_user', user_id: id},
                dataType: 'json',
                success: function(user){
                    $('#form_title').html('Edit Staff');
                    $('#create_user_submit').text('Update Staff');
                    $('#edit_user_id').val(user.user_id);
                    $('#user_name').val(user.user_name);
                    $('#user_email').val(user.user_email);
                    $('#user_password').val('');
                    $('#user_type').val(user.user_type);
                    $('#user_status').val(user.user_status);
                }
            });
        });

        // RESET MFA
        $(document).on('click', '.reset_mfa_user', function(){
            var id = $(this).data('id');
            var name = $(this).data('name') || 'this user';
            if (!confirm('Reset authenticator for "' + name + '"?\n\nThey will need to set up Google Authenticator again on next login.')) {
                return;
            }
            $.ajax({
                type: 'POST',
                url: 'includes/datacontrol',
                data: { formName: 'reset_user_mfa', user_id: id },
                success: function(data){
                    staffMgmtHandleListResponse(data, 'Authenticator reset. They will set it up again on next login.');
                },
                error: function(){ staffMgmtToastError(); }
            });
        });

        // HARD DELETE USER
        $(document).on('click', '.delete_user', function(){
            var id = $(this).data('id');
            var name = $(this).data('name') || 'this user';
            if (!confirm('Permanently delete "' + name + '"?\n\nThis cannot be undone.\nYou can create a new account with the same email afterwards (fresh MFA setup).')) {
                return;
            }
            if (!confirm('Confirm permanent delete for "' + name + '"?')) {
                return;
            }
            $.ajax({
                type: 'POST',
                url: 'includes/datacontrol',
                data: { formName: 'delete_user', user_id: id },
                success: function(data){
                    staffMgmtHandleListResponse(data, 'User deleted permanently.');
                },
                error: function(){ staffMgmtToastError(); }
            });
        });
    </script>

</body>
</html>
