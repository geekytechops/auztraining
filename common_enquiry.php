<?php include('includes/dbconnect.php'); ?>
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
        <style>
            .main-content{
                margin:0;
            }
            .page-content{
                padding:20px 0px 0px 0px;
            }
        </style>
    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">        
            
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                    <?php 
                    session_start();
                        
                        if(isset($_GET['data'])){

                            $courses=mysqli_query($connection,"SELECT * from courses where course_status!=1");
                            $visaStatus=mysqli_query($connection,"SELECT * from visa_statuses where visa_state_status!=1");


                            $Updatestatus=1;
                            $eqId=base64_decode($_GET['data']);
                            $query=mysqli_query($connection,"SELECT * FROM `enquiry_forms` where enq_status!=1 and enq_form_id=$eqId");
                            $query2=mysqli_query($connection,"SELECT * FROM `student_enquiry` where st_enquiry_status=0 and st_gen_enq_id=$eqId");
                            if($query && mysqli_num_rows($query)!=0 && mysqli_num_rows($query2)==0){
                                $queryRes=mysqli_fetch_array($query);
                                
                    ?>

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Enquiry Form</h4>
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
                                                        <input type="text" class="form-control" id="email_address" placeholder="Email Address" >
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
                                                        <input type="text" class="form-control" id="student_name" placeholder="Student Name">
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
                                                        <label class="form-label" for="contact_num">Mobile</label>
                                                        <input type="text" class="form-control number-field" maxlength="10" id="contact_num" placeholder="Contact Number" >
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

                        <?php }else{ ?>
                            <div class="row vh-100">
                            <div class="col-xl-12 d-flex align-items-center justify-content-center">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center text-center" style="flex-direction:column">                                        
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <i class="fas fa-exclamation-triangle" style="font-size:50px;color:#ffa808"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <h4>The page you have followed is Expired</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php 
                        }else{ 
                        ?>                        
                        <div class="row vh-100">
                            <div class="col-xl-12 d-flex align-items-center justify-content-center">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center text-center" style="flex-direction:column">                                        
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <i class="fas fa-exclamation-triangle" style="font-size:50px;color:#ffa808"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <h4>The page you have followed is Expired</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        }
                        ?>

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
                var streetDetails=$('#street_no').val();
                var enquiryFor=$('#enquiry_for').val()==0 ? '' : $('#enquiry_for').val();

                var emailregexp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                var courses=$('#courses').val()==0 ? '' : $('#courses').val();

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

                if(studentName==''|| ( contactName=='' || contactName.length!=10 ) ||emailAddress==''|| (emailAddress!='' && !emailAddress.match(emailregexp)==true ) ||courses==''|| enquiryDate=='' || refer_select_error==0 || surname=='' || enquiryFor==''|| postCode=='' || visit_before=='' ){

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
                    
                    details={formName:'student_enquiry_common',studentName:studentName,contactName:contactName,emailAddress:emailAddress,courses:courses,checkId:checkId,surname:surname,suburb:suburb,stuState:stuState,postCode:postCode,visit_before:visit_before,hear_about:hear_about,plan_to_start_date:plan_to_start_date,refer_select:refer_select,referer_name:referer_name,refer_alumni:refer_alumni,streetDetails:streetDetails,enquiryFor:enquiryFor,admin_id:0,form_id:'<?php echo $eqId; ?>'};
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
                        var updatedURL = removeLastSegmentFromURL(window.location.href);        
                    
                        var qrcode = new QRCode(qrcodeContainer, {
                        text: updatedURL+'/common_enquiry.php?data='+data, 
                        width: 128,
                        height: 128,
                        });
                        var qrcodeContainer = document.getElementById('qrcode');

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

        </script>
    </body>
</html>
