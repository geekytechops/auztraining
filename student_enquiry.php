<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
if(@$_SESSION['user_type']!=''){
    
            $courses=mysqli_query($connection,"SELECT * from courses where course_status!=1");
        $visaStatus=mysqli_query($connection,"SELECT * from visa_statuses where visa_state_status!=1");

    if(isset($_GET['eq'])){
        $Updatestatus=1;
        $eqId=base64_decode($_GET['eq']);
        $queryRes=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enquiry where st_enquiry_status!=1 and st_id=$eqId"));

    }else{
        $Updatestatus=0;
        $eqId=0;
    }

?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Student Enquiry</title>
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
                                    <h4 class="mb-sm-0">Student's Enquiry</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Student's Enquiry</li>
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
                                        <form class="student_enquiry_form" id="student_enquiry_form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="student_name">Student's Name</label>
                                                        <input type="text" class="form-control" id="student_name" placeholder="Student Name" value="<?php echo $queryRes['st_name']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the student's name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="contact_num">Contact No</label>
                                                        <input type="text" class="form-control number-field" maxlength="10" id="contact_num" placeholder="Contact Number" value="<?php echo $queryRes['st_phno']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Contact Number
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="email_address">Email</label>
                                                        <input type="text" class="form-control" id="email_address" placeholder="Email Address" value="<?php echo $queryRes['st_email']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Email Address
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="courses">Course Interested In</label>
                                                        <select name="courses" class="form-control" id="courses">
                                                        <option value="0">--select--</option>
                                                        <?php 
                                                        while($coursesRes=mysqli_fetch_array($courses)){
                                                        ?>                                                            
                                                            <option value="<?php echo $coursesRes['course_id']; ?>" <?php echo $coursesRes['course_id']==$queryRes['st_course'] ? 'selected' : ''; ?>><?php echo $coursesRes['course_name']; ?></option>
                                                            <?php } ?>
                                                        </select>    
                                                        <div class="error-feedback">
                                                            Please select the Courses
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="payment_fee">Fee Promised</label>
                                                        <input type="text" class="form-control number-field" maxlength="7" id="payment_fee" placeholder="0.00" value="<?php echo $queryRes['st_fee']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Promised Fee
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visa_status">Visa Condition</label>
                                                        <select name="visa_status" class="form-control" id="visa_status">
                                                        <option value="0">--select--</option>
                                                        <?php 
                                                        while($visaRes=mysqli_fetch_array($visaStatus)){
                                                        ?>                                                            
                                                            <option value="<?php echo $visaRes['visa_id']; ?>" <?php echo $visaRes['visa_id']==$queryRes['st_visa_status'] ? 'selected' : ''; ?>><?php echo $visaRes['visa_status_name']; ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                        <div class="error-feedback">
                                                            Please select a visa status
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($eqId==0){ ?>
                                            <button class="btn btn-primary" type="button" id="enquiry_form">Submit Enquiry</button>
                                            <?php }else{ ?>
                                            <button class="btn btn-primary" type="button" id="enquiry_form">Update Enquiry</button>
                                            <?php } ?>
                                            <input type="hidden" value="<?php echo $eqId; ?>" id="check_update">
                                        </form>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

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
            $(document).on('click','#enquiry_form',function(){
                var studentName=$('#student_name').val().trim();
                var contactName=$('#contact_num').val().trim();
                var emailAddress=$('#email_address').val().trim();
                var emailregexp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                var courses=$('#courses').val()==0 ? '' : $('#courses').val();
                var payment=$('#payment_fee').val().trim();
                var visaStatus=$('#visa_status').val()==0 ? '' : $('#visa_status').val();

                if(studentName==''|| ( contactName=='' || contactName.length!=10 ) ||emailAddress==''|| (emailAddress!='' && !emailAddress.match(emailregexp)==true ) ||courses==''||payment==''||visaStatus==''){
                    if(studentName==''){
                        $('#student_name').addClass('invalid-div');
                        $('#student_name').removeClass('valid-div');
                        $('#student_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#student_name').addClass('valid-div');
                        $('#student_name').removeClass('invalid-div');
                        console.log($('#student_name').parents('div').find('.error-feedback').attr('class'));
                        $('#student_name').closest('div').find('.error-feedback').hide();
                    }
                    if(contactName=='' || contactName.length!=10 ){
                        $('#contact_num').addClass('invalid-div');
                        $('#contact_num').removeClass('valid-div');
                        $('#contact_num').closest('div').find('.error-feedback').show();
                    }else{
                        $('#contact_num').addClass('valid-div');
                        $('#contact_num').removeClass('invalid-div');
                        $('#contact_num').closest('div').find('.error-feedback').hide();
                    }
                    if(emailAddress=='' || (emailAddress!='' && (!emailAddress.match(emailregexp)==true))){
                        $('#email_address').addClass('invalid-div');
                        $('#email_address').removeClass('valid-div');
                        $('#email_address').closest('div').find('.error-feedback').show();
                    }else{
                        $('#email_address').addClass('valid-div');
                        $('#email_address').removeClass('invalid-div');
                        $('#email_address').closest('div').find('.error-feedback').hide();
                    }
                    if(courses==''){
                        $('#courses').addClass('invalid-div');
                        $('#courses').removeClass('valid-div');
                        $('#courses').closest('div').find('.error-feedback').show();
                    }else{
                        $('#courses').addClass('valid-div');
                        $('#courses').removeClass('invalid-div');
                        $('#courses').closest('div').find('.error-feedback').hide();
                    }
                    if(payment==''){
                        $('#payment_fee').addClass('invalid-div');
                        $('#payment_fee').removeClass('valid-div');
                        $('#payment_fee').closest('div').find('.error-feedback').show();
                    }else{
                        $('#payment_fee').addClass('valid-div');
                        $('#payment_fee').removeClass('invalid-div');
                        $('#payment_fee').closest('div').find('.error-feedback').hide();
                    }
                    if(visaStatus==''){
                        $('#visa_status').addClass('invalid-div');
                        $('#visa_status').removeClass('valid-div');
                        $('#visa_status').closest('div').find('.error-feedback').show();
                    }else{
                        $('#visa_status').addClass('valid-div');
                        $('#visa_status').removeClass('invalid-div');
                        $('#visa_status').closest('div').find('.error-feedback').hide();
                    }
                }else{
                    var checkId=$("#check_update").val();
                    
                    details={formName:'student_enquiry',studentName:studentName,contactName:contactName,emailAddress:emailAddress,courses:courses,payment:payment,checkId:checkId,visaStatus:visaStatus};
                    $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data==1){
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('New Enquiry Added');
                                $('#borderedToast1Btn').trigger('click');
                            }else if(data==2){
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('Record Updated Successfully');
                                $('#borderedToast1Btn').trigger('click');
                                window.location.href="dashboard";
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
