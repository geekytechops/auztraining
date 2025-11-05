<?php 
include('includes/dbconnect.php'); 
session_start();

if(@$_SESSION['user_type']==1){
    $users=mysqli_query($connection,"SELECT * FROM users WHERE user_type=0 ORDER BY user_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Create / Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <?php include('includes/app_includes.php'); ?>
</head>

<body data-topbar="colored">
    <div id="layout-wrapper">

        <?php include('includes/header.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Create / Edit User</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">User Management</li>
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
                                    <h4 class="card-title text-center" id="form_title">Create User</h4>

                                    <input type="hidden" id="edit_user_id" value="">

                                    <div class="mb-3">
                                        <label class="form-label">User Name</label>
                                        <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Enter User Name" required>
                                        <div class="error-feedback">Please enter the user name</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">User Email</label>
                                        <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Enter Email" required>
                                        <div class="error-feedback">Please enter a valid email</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Enter Password" required>
                                        <div class="error-feedback">Please enter a password</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">User Type</label>
                                        <select id="user_type" name="user_type" class="form-select" required>
                                            <option value="">-- Select --</option>
                                            <option value="1">Admin</option>
                                            <option value="0">User</option>
                                        </select>
                                        <div class="error-feedback">Please select a user type</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">User Status</label>
                                        <select id="user_status" name="user_status" class="form-select">
                                            <option value="0">Active</option>
                                            <option value="1">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" id="create_user_submit" class="btn btn-primary w-50">Create User</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT SIDE: USER LIST -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Existing Users</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="user_list">
                                                <?php 
                                                while($user=mysqli_fetch_array($users)){ 
                                                ?>
                                                <tr>
                                                    <td><?php echo $user['user_id']; ?></td>
                                                    <td><?php echo $user['user_name']; ?></td>
                                                    <td><?php echo $user['user_email']; ?></td>
                                                    <td><?php echo $user['user_status']==0 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning edit_user" data-id="<?php echo $user['user_id']; ?>">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php } ?>
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

    <div class="rightbar-overlay"></div>
    <?php include('includes/footer_includes.php'); ?>

    <script>
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
                    url: 'includes/datacontrol.php',
                    data: details,
                    success: function(data){
                        if(data==1){
                            $('.toast-text2').html('Operation failed. Please try again later.');
                            $('#borderedToast2Btn').trigger('click');
                        }else{
                            document.getElementById('create_user_form').reset();
                            $('#edit_user_id').val('');
                            $('#form_title').html('Create User');
                            $('#create_user_submit').text('Create User');
                            $('#toast-text').html(id ? 'User updated successfully!' : 'User created successfully!');
                            $('#borderedToast1Btn').trigger('click');
                            $('#user_list').html(data); // reload user list
                        }
                    }
                });
            }
        });

        // EDIT BUTTON CLICK
        $(document).on('click', '.edit_user', function(){
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'includes/datacontrol.php',
                data: {formName: 'get_user', user_id: id},
                dataType: 'json',
                success: function(user){
                    $('#form_title').html('Edit User');
                    $('#create_user_submit').text('Update User');
                    $('#edit_user_id').val(user.user_id);
                    $('#user_name').val(user.user_name);
                    $('#user_email').val(user.user_email);
                    $('#user_password').val('');
                    $('#user_type').val(user.user_type);
                    $('#user_status').val(user.user_status);
                }
            });
        });
    </script>

</body>
</html>

<?php 
}else{ 
    header("Location: index.php");
}
?>
