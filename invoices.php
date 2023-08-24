<?php 
session_start();
// print_r($_SESSION);
if(@$_SESSION['user_type']==1){
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Invoices</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <?php include('includes/app_includes.php'); ?>
    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <?php include('includes/header.php'); ?>
            <?php include('includes/sidebar.php'); ?>
            
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Invoice</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Invoice</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="enrol_id">Student Enrolment ID</label>
                                                <input type="text" id="enrol_id" class="form-control" name='enrol_id'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <form class="invoice_form" id="invoice_form">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-center">Student's Details</h4>
                                            <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="payment_date">Payment Date</label>
                                                        <input type="date" id="payment_date" class="form-control">
                                                        <div class="error-feedback">
                                                            Please select the Date
                                                        </div>
                                                    </div>
                                            </div>                                        
                                            <div class="">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="student_name">Student Name</label>
                                                        <input type="text" id="student_name" class="form-control" placeholder="Student Name">
                                                        <div class="error-feedback">
                                                            Please Enter the student Name
                                                        </div>
                                                    </div>
                                            </div>                                        
                                            <div class="">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="course_name">Course Name</label>
                                                        <select name="course_name" class="form-control" id="course_name">
                                                            <option value="0">--select--</option>
                                                            <option value="1">Basic</option>
                                                            <option value="2">Intermediate</option>
                                                            <option value="3">Expert</option>
                                                        </select>  
                                                        <div class="error-feedback">
                                                            Please Enter the Course Name
                                                        </div>
                                                    </div>
                                            </div>                                        
                                    </div>
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                            <div class="col-xl-6">
                                <div class="card">
                                <div class="card-body">
                                        <h4 class="card-title text-center">Payment Details</h4>
                                            <div class="">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="course_fee">Course Fee</label>
                                                        <input type="text" id="course_fee" class="form-control number-field" placeholder="0.00">
                                                        <div class="error-feedback">
                                                            Please Enter the Course Fee
                                                        </div>
                                                    </div>
                                            </div>                                        
                                            <div class="">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="amount_paid">Amount Paid</label>
                                                        <input type="text" id="amount_paid" class="form-control number-field" placeholder="0.00">
                                                        <div class="error-feedback">
                                                            Please Enter the Paid Amount
                                                        </div>
                                                    </div>
                                            </div>                                        
                                            <div class="">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="amount_due">Amount Due</label>
                                                        <input type="text" id="amount_due" class="form-control number-field" placeholder="0.00">
                                                        <div class="error-feedback">
                                                            Please Enter the Due Amount
                                                        </div>
                                                    </div>
                                            </div>                                        
                                    </div>
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="col-md-12 text-center">
                                        <button class="form-control btn btn-primary" type="button" style="width:30%;" id="invoice_submit">Submit</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </form>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->                            
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <?php include('includes/footer_includes.php'); ?>
        <script>
            $(document).on('click','#invoice_submit',function(){
                var payment_date=$('#payment_date').val().trim();
                var student_name=$('#student_name').val().trim();
                var course_name=$('#course_name').val()==0 ? '' : $('#course_name').val();
                var course_fee=$('#course_fee').val().trim();
                var amount_paid=$('#amount_paid').val().trim();
                var enrol_id=$('#enrol_id').val().trim();
                var amount_due=$('#amount_due').val().trim();

                if(payment_date==''|| student_name=='' ||course_name=='' ||course_fee==''||amount_paid==''||amount_due=='' || enrol_id==''){
                    if(payment_date==''){
                        $('#payment_date').addClass('invalid-div');
                        $('#payment_date').removeClass('valid-div');
                        $('#payment_date').closest('div').find('.error-feedback').show();
                    }else{
                        $('#payment_date').addClass('valid-div');
                        $('#payment_date').removeClass('invalid-div');                        
                        $('#payment_date').closest('div').find('.error-feedback').hide();
                    }
                    if(student_name==''){
                        $('#student_name').addClass('invalid-div');
                        $('#student_name').removeClass('valid-div');
                        $('#student_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#student_name').addClass('valid-div');
                        $('#student_name').removeClass('invalid-div');
                        $('#student_name').closest('div').find('.error-feedback').hide();
                    }
                    if(course_name==''){
                        $('#course_name').addClass('invalid-div');
                        $('#course_name').removeClass('valid-div');
                        $('#course_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#course_name').addClass('valid-div');
                        $('#course_name').removeClass('invalid-div');
                        $('#course_name').closest('div').find('.error-feedback').hide();
                    }
                    if(course_fee==''){
                        $('#course_fee').addClass('invalid-div');
                        $('#course_fee').removeClass('valid-div');
                        $('#course_fee').closest('div').find('.error-feedback').show();
                    }else{
                        $('#course_fee').addClass('valid-div');
                        $('#course_fee').removeClass('invalid-div');
                        $('#course_fee').closest('div').find('.error-feedback').hide();
                    }
                    if(amount_paid==''){
                        $('#amount_paid').addClass('invalid-div');
                        $('#amount_paid').removeClass('valid-div');
                        $('#amount_paid').closest('div').find('.error-feedback').show();
                    }else{
                        $('#amount_paid').addClass('valid-div');
                        $('#amount_paid').removeClass('invalid-div');
                        $('#amount_paid').closest('div').find('.error-feedback').hide();
                    }
                    if(amount_due==''){
                        $('#amount_due').addClass('invalid-div');
                        $('#amount_due').removeClass('valid-div');
                        $('#amount_due').closest('div').find('.error-feedback').show();
                    }else{
                        $('#amount_due').addClass('valid-div');
                        $('#amount_due').removeClass('invalid-div');
                        $('#amount_due').closest('div').find('.error-feedback').hide();
                    }
                }else{
                    details={formName:'invoice_submit',payment_date:payment_date,amount_due:amount_due,amount_paid:amount_paid,course_fee:course_fee,enrol_id:enrol_id,course_name:course_name,student_name:student_name};
                    $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data==0){
                            document.getElementById('invoice_form').reset();
                            $('#toast-text').html('New Invoice added Successfully');
                                $('#borderedToast1Btn').trigger('click');
                            }else{
                                $('.toast-text2').html('Cannot add record. Please try again later');
                                $('#borderedToast2Btn').trigger('click');
                            }
                        }
                    })
                }

            })
        </script>
    </body>
</html>
<?php }else{ 

header("Location: index.php");

}
?>