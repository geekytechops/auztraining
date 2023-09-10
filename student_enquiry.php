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
                                        
                                        <ol class="breadcrumb m-0 align-items-baseline">
                                        <li class="breadcrumb-item">
                                            <button type="button" id="generate_qr" onclick="genQR()" class="btn btn-info waves-effect waves-light">Create QR Code <i class="mdi mdi-qrcode-edit"></i> 
                                            </button>
                                            <div class="d-none" id="qrcode"></div>
                                            <a id="downloadLink" download="enquiry_QR.png" class="d-none">Download QR Code</a>
                                            </li>
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
                                                        <label class="form-label" for="email_address">Email</label>
                                                        <input type="text" class="form-control" id="email_address" placeholder="Email Address" value="<?php echo $queryRes['st_email']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Email Address
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="enquiry_date">Date</label>
                                                        <input type="date" class="form-control" id="enquiry_date" >
                                                        <div class="error-feedback">
                                                            Please select the Date
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="surname">Surname</label>
                                                        <input type="text" class="form-control" id="surname" placeholder="Surname" value="" >
                                                        <div class="error-feedback">
                                                            Please enter the Surname
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="student_name">First Name</label>
                                                        <input type="text" class="form-control" id="student_name" placeholder="Student Name" value="<?php echo $queryRes['st_name']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the First name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="enquiry_for">Enquiring For</label>
                                                        <select name="enquiry_for" class="form-select" id="enquiry_for">
                                                        <option value="0">--select--</option>
                                                        <option value="1">Self</option>
                                                        <option value="2">Family member</option>
                                                        </select>  
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="course_type">Course Type</label>
                                                        <select name="course_type" class="form-select" id="course_type">
                                                        <option value="0">--select--</option>
                                                        <option value="1">Rpl</option>
                                                        <option value="2">Regular</option>
                                                        <option value="3">Regular - Group</option>                                                         
                                                        <option value="4">Regular - Group</option>                                                         
                                                        <option value="5">Short course - Group</option>
                                                        </select>  
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="contact_num">Mobile</label>
                                                        <input type="text" class="form-control number-field" maxlength="10" id="contact_num" placeholder="Contact Number" value="<?php echo $queryRes['st_phno']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Contact Number
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="street_no">Street No / Name</label>
                                                        <input type="text" class="form-control street_no" id="street_no" placeholder="Street No / Name" value="" >
                                                        <div class="error-feedback">
                                                            Please enter the Street Details
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="suburb">Suburb</label>
                                                        <input type="text" class="form-control suburb" id="suburb" placeholder="Sub Urb" value="" >
                                                        <div class="error-feedback">
                                                            Please enter the Suburb
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stu_state">State</label>
                                                        <input type="text" class="form-control stu_state" id="stu_state" placeholder="State" value="" >
                                                        <div class="error-feedback">
                                                            Please enter the State
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="post_code">Post Code</label>
                                                        <input type="tel" class="form-control number-field" maxlength="6" id="post_code" placeholder="Post Code" value="" >
                                                        <div class="error-feedback">
                                                            Please enter the Post Code
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visit_before">Have you visited us before?*</label>
                                                        <select name="visit_before" class="form-select" id="visit_before">
                                                        <option value="0">--select--</option>
                                                        <option value="1">Word of Mouth</option>
                                                        <option value="2">Family or Friends</option>
                                                        <option value="3">Website</option>
                                                        <option value="4">Gumtree</option>
                                                    <optgroup label="Social Media">
                                                        <option value="5">Facebook</option>
                                                        <option value="6">Instagram</option>
                                                        <option value="7">Linkedin</option>
                                                    </optgroup>   
                                                        <option value="8">Mail outs</option>
                                                        <option value="9">Migration Agency</option>
                                                        <option value="10">Other:</option>                                                     
                                                        </select>  
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="hear_about">How did you hear about us?</label>
                                                        <select name="hear_about" class="form-select" id="hear_about">
                                                        <option value="0">--select--</option>
                                                        <option value="1">Yes</option>
                                                        <option value="2">No</option>
                                                        </select>  
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="courses">Which Course are you interested in?*</label>
                                                        <select name="courses" class="form-select" id="courses">
                                                        <option value="0">--select--</option>
                                                        <?php 
                                                        while($coursesRes=mysqli_fetch_array($courses)){
                                                        ?>                                                            
                                                            <option value="<?php echo $coursesRes['course_id']; ?>" <?php echo $coursesRes['course_id']==$queryRes['st_course'] ? 'selected' : ''; ?>><?php echo $coursesRes['course_sname'].'-'.$coursesRes['course_name']; ?></option>
                                                            <?php } ?>
                                                        </select>    
                                                        <div class="error-feedback">
                                                            Please select the Courses
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="plan_to_start_date">When do you plan to start?</label>
                                                        <input type="date" class="form-control" id="plan_to_start_date" value="" >
                                                        <div class="error-feedback">
                                                            Please select the Plan to Start Date
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="refer_select">Have you been referred by someone?*</label>
                                                        <select name="refer_select" class="form-select refered" id="refer_select">
                                                        <option value="0">--select--</option>
                                                        <option value="1">Yes</option>
                                                        <option value="2">No</option>
                                                        </select>                                                          
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 refered_field" style="display:none">
                                                    <div class="mb-3">
                                                         <label class="form-label" for="referer_name">Please specify his / her name</label>
                                                        <input type="text" class="form-control" id="referer_name" value="" placeholder="Name">
                                                        <div class="error-feedback">
                                                            Please Enter his / her name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 refered_field" style="display:none">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="refer_alumni">Is he / she an alumni*</label>
                                                        <select name="refer_alumni" class="form-select" id="refer_alumni">
                                                        <option value="0">--select--</option>
                                                        <option value="1">Yes</option>
                                                        <option value="2">No</option>
                                                        </select>                                                          
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visa_status">Visa Condition</label>
                                                        <select name="visa_status" class="form-select" id="visa_status">
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
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="shore">Offshore or onshore</label>
                                                        <select name="shore" class="form-select" id="shore">
                                                        <option value="0">--select--</option>
                                                        <option value="1">OffShort</option>
                                                        <option value="2">OnShort</option>
                                                        </select>                                                          
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ethnicity">Ethnicity</label>
                                                        <input type="text" class="form-control" id="ethnicity" placeholder="Ethnicity">
                                                        <div class="error-feedback">
                                                            Please enter the Ethnicity
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="payment_fee">Fees mentioned</label>
                                                        <input type="text" class="form-control number-field" maxlength="7" id="payment_fee" placeholder="0.00" value="<?php echo $queryRes['st_fee']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Mentioned Fee
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="comments">Comments</label>
                                                        <input type="text" class="form-control" id="comments" placeholder="Comments">
                                                        <div class="error-feedback">
                                                            Please enter the Comments
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="appointment_booked">Appointment booked for counseling or not?</label>
                                                        <select name="appointment_booked" class="form-select" id="appointment_booked">
                                                        <option value="0">--select--</option>
                                                        <option value="1">Yes</option>
                                                        <option value="2">No</option>
                                                        </select>                                                          
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="remarks">Remarks</label>
                                                        <select name="remarks" class="form-select" id="remarks">
                                                        <option value="0">--select--</option>
                                                        <option value="1">Good</option>
                                                        <option value="2">Bad</option>
                                                        </select>                                                          
                                                        <div class="error-feedback">
                                                            Please select atleast one option
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

            $(document).ready(function(){
                $('.refered').on("change",function(){
                    var value=$(this).val();
                    if( value==0 || value==2 ){
                        $('.refered_field').hide();
                    }else{
                        $('.refered_field').show();
                    }                 
                })
                $('.rpl_parent').on("change",function(){
                    var value=$(this).val();
                    if( value==0 || value==2 ){
                        $('.rpl_child').hide();
                    }else{
                        $('.rpl_child').show();
                    }                 
                })
                $('#course_type').on("change",function(){
                    var value=$(this).val();
                    if( value==1 ){
                        $('#rpl_popup').trigger('click');
                    }else if(value==5){                                            
                        $('#short_group_popup').trigger('click');
                    }else{
                        // $('#rpl_close').trigger('click');
                    }
                })
                $('.rpl_prev_parent').on("change",function(){
                    var value=$(this).val();
                    if( value==2 || value==0){
                        $('.rpl_prev_child').hide();
                    }else{                                            
                        $('.rpl_prev_child').show();
                    }
                })

                $('.rpl_close').click(function(){
                    document.getElementById('rpl_form').reset();
                    document.getElementById('short_group_form').reset();
                    localStorage.setItem("rpl_array", '');
                    $('#course_type').val(0).change();
                 })
                $('.short_group_close').click(function(){
                    document.getElementById('rpl_form').reset();
                    document.getElementById('short_group_form').reset();
                    localStorage.setItem("rpl_array", '');
                    $('#course_type').val(0).change();
                })
            })

            $(document).on('click','#enquiry_form',function(){
                var studentName=$('#student_name').val().trim();
                var contactName=$('#contact_num').val().trim();
                var emailAddress=$('#email_address').val().trim();
                var enquiryDate=$('#enquiry_date').val();

                var surname=$('#surname').val();
                var suburb=$('#suburb').val();
                var stuState=$('#stu_state').val();
                var postCode=$('#post_code').val();
                var visit_before=$('#visit_before').val();
                var hear_about=$('#hear_about').val();
                var plan_to_start_date=$('#plan_to_start_date').val();
                var refer_select=$('#refer_select').val();
                var referer_name=$('#referer_name').val();
                var refer_alumni=$('#refer_alumni').val();
                var shore=$('#shore').val();
                var comments=$('#comments').val();
                var appointment_booked=$('#appointment_booked').val();
                var remarks=$('#remarks').val();
                var streetDetails=$('#street_no').val();
                var ethnicity=$('#ethnicity').val();                
                var enquiryFor=$('#enquiry_for').val()==0 ? '' : $('#enquiry_for').val();
                var courseType=$('#course_type').val()==0 ? '' : $('#course_type').val();

                var emailregexp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                var courses=$('#courses').val()==0 ? '' : $('#courses').val();
                var payment=$('#payment_fee').val().trim();
                var visaStatus=$('#visa_status').val()==0 ? '' : $('#visa_status').val();

                if(refer_select==0){
                    refer_select_error=0;
                }else if(refer_select==1){

                    if(refer_alumni==0){
                        refer_select_error=0;
                    }else{
                        refer_select_error=1;
                    }

                }else{
                    refer_select_error=1;
                }

                if(studentName==''|| ( contactName=='' || contactName.length!=10 ) ||emailAddress==''|| (emailAddress!='' && !emailAddress.match(emailregexp)==true ) ||courses==''||payment==''||visaStatus=='' || enquiryDate=='' || refer_select_error==0 || surname=='' || enquiryFor==''|| postCode=='' || visit_before=='' ){

                    if(refer_select_error==0){
                        if(refer_select==0){
                            $('#refer_select').addClass('invalid-div');
                            $('#refer_select').removeClass('valid-div');
                            $('#refer_select').closest('div').find('.error-feedback').show();
                        }else if(refer_select==1){

                            if(refer_alumni==0){
                                $('#refer_alumni').addClass('invalid-div');
                                $('#refer_alumni').removeClass('valid-div');
                                $('#refer_alumni').closest('div').find('.error-feedback').show();
                            }else{
                                $('#refer_alumni').addClass('valid-div');
                                $('#refer_alumni').removeClass('invalid-div');
                                $('#refer_alumni').closest('div').find('.error-feedback').hide();
                            }

                        }else{
                            $('#refer_select').addClass('valid-div');
                            $('#refer_select').removeClass('invalid-div');
                            $('#refer_select').closest('div').find('.error-feedback').hide();
                        }
                    }
                    if(studentName==''){
                        $('#student_name').addClass('invalid-div');
                        $('#student_name').removeClass('valid-div');
                        $('#student_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#student_name').addClass('valid-div');
                        $('#student_name').removeClass('invalid-div');
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

                    if(enquiryDate==''){
                        $('#enquiry_date').addClass('invalid-div');
                        $('#enquiry_date').removeClass('valid-div');
                        $('#enquiry_date').closest('div').find('.error-feedback').show();
                    }else{
                        $('#enquiry_date').addClass('valid-div');
                        $('#enquiry_date').removeClass('invalid-div');
                        $('#enquiry_date').closest('div').find('.error-feedback').hide();
                    }

                    if(surname==''){
                        $('#surname').addClass('invalid-div');
                        $('#surname').removeClass('valid-div');
                        $('#surname').closest('div').find('.error-feedback').show();
                    }else{
                        $('#surname').addClass('valid-div');
                        $('#surname').removeClass('invalid-div');
                        $('#surname').closest('div').find('.error-feedback').hide();
                    }

                    if(enquiryFor==''){
                        $('#enquiry_for').addClass('invalid-div');
                        $('#enquiry_for').removeClass('valid-div');
                        $('#enquiry_for').closest('div').find('.error-feedback').show();
                    }else{
                        $('#enquiry_for').addClass('valid-div');
                        $('#enquiry_for').removeClass('invalid-div');
                        $('#enquiry_for').closest('div').find('.error-feedback').hide();
                    }

                    if(postCode==''){
                        $('#post_code').addClass('invalid-div');
                        $('#post_code').removeClass('valid-div');
                        $('#post_code').closest('div').find('.error-feedback').show();
                    }else{
                        $('#post_code').addClass('valid-div');
                        $('#post_code').removeClass('invalid-div');
                        $('#post_code').closest('div').find('.error-feedback').hide();
                    }

                    if(visit_before==''){
                        $('#visit_before').addClass('invalid-div');
                        $('#visit_before').removeClass('valid-div');
                        $('#visit_before').closest('div').find('.error-feedback').show();
                    }else{
                        $('#visit_before').addClass('valid-div');
                        $('#visit_before').removeClass('invalid-div');
                        $('#visit_before').closest('div').find('.error-feedback').hide();
                    }

                }else{
                    var checkId=$("#check_update").val();

                    var rpl_arrays=localStorage.getItem("rpl_array");
                    var short_grps=localStorage.getItem("short_grp");
                    
                    details={formName:'student_enquiry',studentName:studentName,contactName:contactName,emailAddress:emailAddress,courses:courses,payment:payment,checkId:checkId,visaStatus:visaStatus,surname:surname,suburb:suburb,stuState:stuState,postCode:postCode,visit_before:visit_before,hear_about:hear_about,plan_to_start_date:plan_to_start_date,refer_select:refer_select,referer_name:referer_name,refer_alumni:refer_alumni,comments:comments,appointment_booked:appointment_booked,remarks:remarks,streetDetails:streetDetails,enquiryFor:enquiryFor,courseType:courseType,shore:shore,ethnicity:ethnicity,rpl_arrays:rpl_arrays,short_grps:short_grps,admin_id:"<?php echo $_SESSION['user_id']; ?>"};
                    $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data==0){
                                $('.toast-text2').html('Cannot add record. Please try again later');
                                $('#borderedToast2Btn').trigger('click');
                            }else if(data==2){
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('Record Updated Successfully');
                                $('#borderedToast1Btn').trigger('click');
                                window.location.href="dashboard.php";
                            }else{
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('New Enquiry Added');
                                $('#borderedToast1Btn').trigger('click');

                                $('#myModalLabel').html('Enquiry ID Created:');
                                $('.modal-body').html(data);
                                $('#model_trigger').trigger('click');
                            }
                        }
                    })
                }

            })


            function genQR(){                

                $.ajax({
                    url:'includes/datacontrol.php',
                    data:{admin_id:"<?php echo $_SESSION['user_id']; ?>",formName:'create_qr'},
                    type:'post',
                    success:function(data){
                        
                        var qrcodeContainer = document.getElementById('qrcode');
                        var updatedURL = removeLastSegmentFromURL(window.location.href)+'/common_enquiry.php?data='+data;
                        var qrcode = new QRCode(qrcodeContainer, {
                        text: updatedURL,
                        width: 128,
                        height: 128,
                        });

                        var downloadLink = document.getElementById('downloadLink');

                        var qrCodeDataURL = qrcodeContainer.querySelector('canvas').toDataURL('image/png');
                        
                        downloadLink.href = qrCodeDataURL;
                        downloadLink.click();
                    
                    }
                })

            }
            function removeLastSegmentFromURL(url) {
            // Split the URL by "/"
            var segments = url.split("/");

            // Remove the last segment
            segments.pop();

            // Join the segments back together
            var updatedURL = segments.join("/");

            return updatedURL;
            }

            function submitRpl(){
               var rpl_exp=$('#rpl_exp').val()==0 ? '' : $('#rpl_exp').val();
               var exp_in=$('#exp_in').val()==0 ? '' : $('#exp_in').val();
               var exp_docs=$('#exp_docs').val()==0 ? '' : $('#exp_docs').val();
               var exp_prev=$('#exp_prev').val()==0 ? '' : $('#exp_prev').val();
               var exp_name=$('#exp_name').val();
               var exp_years=$('#exp_years').val();
               var exp_prev_name=$('#exp_prev_name').val();

               if(rpl_exp=='' || rpl_exp!='' && ( exp_in=='' ||  exp_docs=='' || exp_prev=='' || exp_name=='' || exp_years=='' ) || ( exp_prev==1 && exp_prev_name=='' ) ) {



                    if(rpl_exp==''){
                            $('#rpl_exp').addClass('invalid-div');
                            $('#rpl_exp').removeClass('valid-div');
                    }else{
                            $('#rpl_exp').addClass('valid-div');
                            $('#rpl_exp').removeClass('invalid-div');
                    }

                    if(rpl_exp!='' && ( exp_in=='' ||  exp_docs=='' || exp_prev=='' || exp_name=='' || exp_years=='' )){


                        if(exp_in==''){
                            $('#exp_in').addClass('invalid-div');
                            $('#exp_in').removeClass('valid-div');
                        }else{
                                $('#exp_in').addClass('valid-div');
                                $('#exp_in').removeClass('invalid-div');
                        }

                        if(exp_docs==''){
                            $('#exp_docs').addClass('invalid-div');
                            $('#exp_docs').removeClass('valid-div');
                        }else{
                            $('#exp_docs').addClass('valid-div');
                            $('#exp_docs').removeClass('invalid-div');
                        }

                        if(exp_prev==''){
                            $('#exp_prev').addClass('invalid-div');
                            $('#exp_prev').removeClass('valid-div');
                        }else{
                            $('#exp_prev').addClass('valid-div');
                            $('#exp_prev').removeClass('invalid-div');
                        }

                        if(exp_name==''){
                            $('#exp_name').addClass('invalid-div');
                            $('#exp_name').removeClass('valid-div');
                        }else{
                            $('#exp_name').addClass('valid-div');
                            $('#exp_name').removeClass('invalid-div');
                        }

                        if(exp_years==''){
                            $('#exp_years').addClass('invalid-div');
                            $('#exp_years').removeClass('valid-div');
                        }else{
                            $('#exp_years').addClass('valid-div');
                            $('#exp_years').removeClass('invalid-div');
                        }

                    }

                    if( exp_prev==1 && exp_prev_name=='' ){

                        if(exp_prev_name==''){
                            $('#exp_prev_name').addClass('invalid-div');
                            $('#exp_prev_name').removeClass('valid-div');
                        }else{
                            $('#exp_prev_name').addClass('valid-div');
                            $('#exp_prev_name').removeClass('invalid-div');
                        }

                    }


                }else{

                    var rpl_array={"rpl_exp":rpl_exp,"exp_in":exp_in,"exp_docs":exp_docs,"exp_prev":exp_prev,"exp_name":exp_name,"exp_years":exp_years,"exp_prev_name":exp_prev_name};
                    localStorage.setItem("rpl_array", JSON.stringify(rpl_array));
                    $('#model_rpl_enq').modal('hide');
                    
                }

            }

            function submitShortGroup(){
                var short_grp_org_name=$('#short_grp_org_name').val();
                var short_grp_date=$('#short_grp_date').val();
                var short_grp_num_std=$('#short_grp_num_std').val();
                var short_grp_ind_exp=$('#short_grp_ind_exp').val()==0 ? '' : $('#short_grp_ind_exp').val();
                var short_grp_con_type=$('#short_grp_con_type').val();
                var short_grp_con_num=$('#short_grp_con_num').val();
                var short_grp_con_name=$('#short_grp_con_name').val();
                var short_grp_con_email=$('#short_grp_con_email').val();
                var short_grp_org_type=$('#short_grp_org_type').val()==0 ? '' : $('#short_grp_org_type').val();
                var short_grp_campus=$('#short_grp_campus').val()==0 ? '' : $('#short_grp_campus').val();
                var short_grp_before=$('#short_grp_before').val()==0 ? '' : $('#short_grp_before').val();

                if(short_grp_org_name=='' || short_grp_date=='' || short_grp_num_std=='' || short_grp_ind_exp=='' || short_grp_con_type=='' || short_grp_con_num=='' || short_grp_con_name=='' || short_grp_con_email=='' || short_grp_org_type=='' || short_grp_campus=='' || short_grp_before==''){
                    

                    if(short_grp_org_name==''){
                        $('#short_grp_org_name').addClass('invalid-div');
                        $('#short_grp_org_name').removeClass('valid-div');
                    }else{
                        $('#short_grp_org_name').addClass('valid-div');
                        $('#short_grp_org_name').removeClass('invalid-div');
                    }
                    if(short_grp_date==''){
                        $('#short_grp_date').addClass('invalid-div');
                        $('#short_grp_date').removeClass('valid-div');
                    }else{
                        $('#short_grp_date').addClass('valid-div');
                        $('#short_grp_date').removeClass('invalid-div');
                    }
                    if(short_grp_num_std==''){
                        $('#short_grp_num_std').addClass('invalid-div');
                        $('#short_grp_num_std').removeClass('valid-div');
                    }else{
                        $('#short_grp_num_std').addClass('valid-div');
                        $('#short_grp_num_std').removeClass('invalid-div');
                    }
                    if(short_grp_ind_exp==''){
                        $('#short_grp_ind_exp').addClass('invalid-div');
                        $('#short_grp_ind_exp').removeClass('valid-div');
                    }else{
                        $('#short_grp_ind_exp').addClass('valid-div');
                        $('#short_grp_ind_exp').removeClass('invalid-div');
                    }
                    if(short_grp_con_type==''){
                        $('#short_grp_con_type').addClass('invalid-div');
                        $('#short_grp_con_type').removeClass('valid-div');
                    }else{
                        $('#short_grp_con_type').addClass('valid-div');
                        $('#short_grp_con_type').removeClass('invalid-div');
                    }
                    if(short_grp_con_num==''){
                        $('#short_grp_con_num').addClass('invalid-div');
                        $('#short_grp_con_num').removeClass('valid-div');
                    }else{
                        $('#short_grp_con_num').addClass('valid-div');
                        $('#short_grp_con_num').removeClass('invalid-div');
                    }
                    if(short_grp_con_name==''){
                        $('#short_grp_con_name').addClass('invalid-div');
                        $('#short_grp_con_name').removeClass('valid-div');
                    }else{
                        $('#short_grp_con_name').addClass('valid-div');
                        $('#short_grp_con_name').removeClass('invalid-div');
                    }
                    if(short_grp_con_email==''){
                        $('#short_grp_con_email').addClass('invalid-div');
                        $('#short_grp_con_email').removeClass('valid-div');
                    }else{
                        $('#short_grp_con_email').addClass('valid-div');
                        $('#short_grp_con_email').removeClass('invalid-div');
                    }
                    if(short_grp_before==''){
                        $('#short_grp_before').addClass('invalid-div');
                        $('#short_grp_before').removeClass('valid-div');
                    }else{
                        $('#short_grp_before').addClass('valid-div');
                        $('#short_grp_before').removeClass('invalid-div');
                    }
                    if(short_grp_campus==''){
                        $('#short_grp_campus').addClass('invalid-div');
                        $('#short_grp_campus').removeClass('valid-div');
                    }else{
                        $('#short_grp_campus').addClass('valid-div');
                        $('#short_grp_campus').removeClass('invalid-div');
                    }
                    if(short_grp_org_type==''){
                        $('#short_grp_org_type').addClass('invalid-div');
                        $('#short_grp_org_type').removeClass('valid-div');
                    }else{
                        $('#short_grp_org_type').addClass('valid-div');
                        $('#short_grp_org_type').removeClass('invalid-div');
                    }


                }else{

                    
                    var short_grp={"short_grp_org_name":short_grp_org_name,"short_grp_org_type":short_grp_org_type,"short_grp_campus":short_grp_campus,"short_grp_date":short_grp_date,"short_grp_num_std":short_grp_num_std,"short_grp_ind_exp":short_grp_ind_exp,"short_grp_con_type":short_grp_con_type,"short_grp_con_num":short_grp_con_num,"short_grp_con_name":short_grp_con_name, "short_grp_con_email":short_grp_con_email,"short_grp_before":short_grp_before};
                    localStorage.setItem("short_grp", JSON.stringify(short_grp));
                    $('#model_short_group').modal('hide');

                }
            }

        </script>
    </body>
</html>
<?php }else{ 
header("Location: index.php");
}
?>
