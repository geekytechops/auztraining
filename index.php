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
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <?php include('includes/app_includes.php'); ?>

    </head>

    <body class="bg-pattern">
        <div class="bg-overlay"></div>
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6 col-md-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="">
                                    <div class="text-center">
                                        <a href="index.html" class="">
                                            <img src="assets/images/logo-dark.webp" alt="" height="80" class="auth-logo logo-dark mx-auto">
                                            <img src="assets/images/logo-dark.png" alt="" height="80" class="auth-logo logo-light mx-auto">
                                        </a>
                                    </div>
                                    <!-- end row -->
                                    <h4 class="font-size-18 text-muted mt-2 text-center">Welcome Back !</h4>
                                    <form class="form-horizontal" id="login_form">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-4">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input type="text" class="form-control" id="email" placeholder="Enter email">
                                                    <div class="error-feedback">
                                                            Please enter the Email Address
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="password">Password</label>
                                                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                                                    <div class="error-feedback">
                                                            Please enter the Password
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- <div class="col">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="customControlInline">
                                                            <label class="form-label" class="form-check-label" for="customControlInline">Remember me</label>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-7 d-none">
                                                        <div class="text-md-end mt-3 mt-md-0">
                                                            <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-grid">
                                                <div class="error-feedback" style="font-size:14px;text-align:center;" id="login_error">
                                                            Please enter proper Credentials
                                                </div>
                                                    <button class="btn btn-primary waves-effect waves-light" id="login" type="button">Log In</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center d-none">
                            <p class="text-white-50">Don't have an account ? <a href="auth-register.html" class="fw-medium text-primary"> Register </a> </p>
                            <p class="text-white-50">© <script>document.write(new Date().getFullYear())</script> Upzet. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end Account pages -->

        <?php include('includes/footer_includes.php'); ?>

        <script>
            $(document).on("click","#login",function(){
                var email=$('#email').val().trim();
                var password=$('#password').val().trim();
                if(email==''||password==''){
                    if(email==''){
                        $('#email').addClass('invalid-div');
                        $('#email').removeClass('valid-div');
                        $('#email').closest('div').find('.error-feedback').show();
                    }else{
                        $('#email').addClass('valid-div');
                        $('#email').removeClass('invalid-div');
                        $('#email').closest('div').find('.error-feedback').hide();
                    }
                    if(password==''){
                        $('#password').addClass('invalid-div');
                        $('#password').removeClass('valid-div');
                        $('#password').closest('div').find('.error-feedback').show();
                    }else{
                        $('#password').addClass('valid-div');
                        $('#password').removeClass('invalid-div');
                        $('#password').closest('div').find('.error-feedback').hide();
                    }
                }
            else{
                details={formName:'login',email:email,password:password};
                $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data.split('|')[0]==0){
                                var ut = data.split('|')[1];
                                if(ut==1 || ut==2){
                                    window.location.href="dashboard.php";
                                }else{
                                    window.location.href="student_docs.php";
                                }
                                document.getElementById('login_form').reset();
                                $('#login_error').hide();
                            }else{
                                $('#login_error').show();
                            }
                        }
                    })

            }
            })
        </script>
    </body>
</html>
<?php } ?>