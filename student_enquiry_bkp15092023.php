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
        $form_id=$queryRes['st_id'];


        $rpl_exp=$exp_in=$exp_docs=$exp_prev=$exp_name=$exp_years=$exp_prev_name='';
        $short_grp_org_name=$short_grp_org_type=$short_grp_campus=$short_grp_date=$short_grp_num_std=$short_grp_ind_exp=$short_grp_con_type=$short_grp_con_num=$short_grp_con_name=$short_grp_con_email=$short_grp_before='';
        $slot_book_time=$slot_book_purpose=$slot_book_date=$slot_book_by=$slot_book_link='';


        // RPL Enquiries
        $queryRes_rpl=mysqli_query($connection,"SELECT * from rpl_enquries where enq_form_id=$form_id");
        if(mysqli_num_rows($queryRes_rpl)!=0){
            $queryRes_rpls=mysqli_fetch_array($queryRes_rpl);
            $rpl_status=1;
            $rpl_array=["rpl_exp" => $queryRes_rpls['rpl_exp'] , "exp_in"=>$queryRes_rpls['rpl_exp_in'] , "exp_docs"=>$queryRes_rpls['rpl_exp_docs'] , "exp_prev"=>$queryRes_rpls['rpl_exp_prev_qual'] , "exp_name"=>$queryRes_rpls['rpl_exp_role']  , "exp_years"=>$queryRes_rpls['rpl_exp_years']  , "exp_prev_name"=>$queryRes_rpls['rpl_exp_qual_name']];        
        }else{
            $rpl_status=0;
            $rpl_array=["rpl_exp" => '' , "exp_in"=>'' , "exp_docs"=>'' , "exp_prev"=>'' , "exp_name"=>''  , "exp_years"=>''  , "exp_prev_name"=>'']; 
        }

        // Short Groups 
        $queryRes_shortGrp=mysqli_query($connection,"SELECT * from short_group_form where enq_form_id=$form_id");
        if(mysqli_num_rows($queryRes_shortGrp)!=0){
            $queryRes_shortGrps=mysqli_fetch_array($queryRes_shortGrp);
            $short_grp_status=1;
            $short_grp=["short_grp_org_name" => $queryRes_shortGrps['sh_org_name'] , "short_grp_org_type"=>$queryRes_shortGrps['sh_grp_org_type'] , "short_grp_campus"=>$queryRes_shortGrps['sh_grp_campus'],"short_grp_date"=>$queryRes_shortGrps['sh_grp_date'] , "short_grp_num_std"=> $queryRes_shortGrps['sh_grp_num_stds'],"short_grp_ind_exp"=>$queryRes_shortGrps['sh_grp_ind_exp'],"short_grp_con_type"=>$queryRes_shortGrps['sh_grp_con_us'] , "short_grp_con_num"=>$queryRes_shortGrps['sh_grp_phone'],"short_grp_con_name"=>$queryRes_shortGrps['sh_grp_name'],"short_grp_con_email"=>$queryRes_shortGrps['sh_grp_email'],"short_grp_before"=>$queryRes_shortGrps['sh_grp_train_bef']];        
        }else{
            $short_grp_status=0;
            $short_grp=["short_grp_org_name" => '' , "short_grp_org_type"=>'' , "short_grp_campus"=>'',"short_grp_date"=>'', "short_grp_num_std"=> '',"short_grp_ind_exp"=>'',"short_grp_con_type"=>'' , "short_grp_con_num"=>'',"short_grp_con_name"=>'',"short_grp_con_email"=>'',"short_grp_before"=>'' ];    
        }

        // booked appointement
        $queryRes_slotBook=mysqli_query($connection,"SELECT * from slot_book where enq_form_id=$form_id");
        if(mysqli_num_rows($queryRes_slotBook)!=0){
            $slot_book_status=1;
            $queryRes_slotBooks=mysqli_fetch_array($queryRes_slotBook);
            $slot_book=["slot_book_time"=>$queryRes_slotBooks['slot_bk_datetime'],"slot_book_purpose"=>$queryRes_slotBooks['slot_bk_purpose'],"slot_book_date"=>$queryRes_slotBooks['slot_bk_on'],"slot_book_by"=>$queryRes_slotBooks['slot_book_by'],"slot_book_link"=>$queryRes_slotBooks['slot_book_email_link']];                  
        }else{
            $slot_book_status=0;
            $slot_book=["slot_book_time"=>'',"slot_book_purpose"=>'',"slot_book_date"=>'',"slot_book_by"=>'',"slot_book_link"=>''];  
        }

        $rpl_arrays=json_encode($rpl_array);
        $short_grps=json_encode($short_grp);
        $slot_books=json_encode($slot_book);


    }else{
        $Updatestatus=0;
        $eqId=0;
        $rpl_array=["rpl_exp" => '' , "exp_in"=>'' , "exp_docs"=>'' , "exp_prev"=>'' , "exp_name"=>''  , "exp_years"=>''  , "exp_prev_name"=>'']; 
        $slot_book=["slot_book_time"=>'',"slot_book_purpose"=>'',"slot_book_date"=>'',"slot_book_by"=>'',"slot_book_link"=>''];  
        $short_grp=["short_grp_org_name" => '' , "short_grp_org_type"=>'' , "short_grp_campus"=>'',"short_grp_date"=>'', "short_grp_num_std"=> '',"short_grp_ind_exp"=>'',"short_grp_con_type"=>'' , "short_grp_con_num"=>'',"short_grp_con_name"=>'',"short_grp_con_email"=>'',"short_grp_before"=>'' ];  
        $rpl_arrays=json_encode($rpl_array);
        $short_grps=json_encode($short_grp);
        $slot_books=json_encode($slot_book);
        $form_id=0;
        $rpl_status=0;
        $short_grp_status=0;
        $slot_book_status=0;
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
                                    <div class="card-body" id="student_enquiry_form_parent">
                                    <div class="jelly" id="jelly_loader"></div>
                                        <form class="student_enquiry_form" id="student_enquiry_form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="email_address">Email*</label>
                                                        <input type="text" class="form-control" id="email_address" placeholder="Email Address" value="<?php echo $queryRes['st_email']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Email Address
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="enquiry_date">Date*</label>
                                                        <input type="date" class="form-control" id="enquiry_date" value="<?php echo  $queryRes['st_enquiry_date']!='' ? date('Y-m-d',strtotime($queryRes['st_enquiry_date'])) : ''; ?>">
                                                        <div class="error-feedback">
                                                            Please select the Date
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="surname">Surname*</label>
                                                        <input type="text" class="form-control" id="surname" placeholder="Surname" value="<?php echo  $queryRes['st_surname']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Surname
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="student_name">First Name*</label>
                                                        <input type="text" class="form-control" id="student_name" placeholder="Student Name" value="<?php echo $queryRes['st_name']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the First name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="enquiry_for">Enquiring For*</label>
                                                        <select name="enquiry_for" class="form-select" id="enquiry_for">
                                                        <?php  
                                                        $st_enquiry=['--select--','Self','Family Member'];
                                                        for($i=0;$i<count($st_enquiry);$i++){
                                                            $checked= $i==$queryRes['st_enquiry_for'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" '.$checked.'>'.$st_enquiry[$i].'</option>';
                                                        }
                                                        ?>
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
                                                        <?php  
                                                        $st_course_type=['--select--','Rpl','Regular','Regular - Group','Short course','Short course - Group'];
                                                        $selectedCourseType=$queryRes['st_course_type']!='' ? $queryRes['st_course_type'] : 0;
                                                        for($i=0;$i<count($st_course_type);$i++){
                                                            $checked= $i==$queryRes['st_course_type'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" data="'.$st_course_type[$i].'" '.$checked.'>'.$st_course_type[$i].'</option>';
                                                        }
                                                        ?>
                                                        </select>  
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="contact_num">Mobile*</label>
                                                        <input type="text" class="form-control number-field" maxlength="10" id="contact_num" placeholder="Contact Number" value="<?php echo $queryRes['st_phno']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Contact Number
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="street_no">Street No / Name</label>
                                                        <input type="text" class="form-control street_no" id="street_no" placeholder="Street No / Name" value="<?php echo $queryRes['st_street_details']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Street Details
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="suburb">Suburb</label>
                                                        <input type="text" class="form-control suburb" id="suburb" placeholder="Sub Urb" value="<?php echo $queryRes['st_suburb']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Suburb
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stu_state">State</label>
                                                        <input type="text" class="form-control stu_state" id="stu_state" placeholder="State" value="<?php echo $queryRes['st_state']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the State
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="post_code">Post Code*</label>
                                                        <input type="tel" class="form-control number-field" maxlength="6" id="post_code" placeholder="Post Code" value="<?php echo $queryRes['st_post_code']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Post Code
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="hear_about">Have you visited us before?*</label>
                                                        <select name="hear_about" class="form-select" id="hear_about">
                                                        <?php  
                                                        $st_visited=['--select--','Yes','No'];
                                                        for($i=0;$i<count($st_visited);$i++){
                                                            $checked= $i==$queryRes['st_visited'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" '.$checked.'>'.$st_visited[$i].'</option>';
                                                        }
                                                        ?>
                                                        </select>  
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visit_before">How did you hear about us?*</label>
                                                        <select name="visit_before" class="form-select" id="visit_before">
                                                        <?php  
                                                        $st_heared=['--select--','Word of Mouth','Family or Friends','Website','Gumtree','Facebook','Instagram','Linkedin','Mail outs','Migration Agency','Other:'];
                                                        for($i=0;$i<count($st_heared);$i++){
                                                            $checked= $i==$queryRes['st_heared'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" '.$checked.'>'.$st_heared[$i].'</option>';
                                                            if($i==4){
                                                                echo '<optgroup label="Social Media">';
                                                            }else if($i==7){
                                                                echo '</optgroup>';
                                                            }
                                                        }
                                                        ?>                                              
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
                                                        <input type="date" class="form-control" id="plan_to_start_date" value="<?php echo $queryRes['st_startplan_date']!='' ? date('Y-m-d',strtotime($queryRes['st_startplan_date'])) : '' ?>" >
                                                        <div class="error-feedback">
                                                            Please select the Plan to Start Date
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="refer_select">Have you been referred by someone?*</label>
                                                        <select name="refer_select" class="form-select refered" id="refer_select">
                                                        <?php  
                                                        $st_refered=['--select--','Yes','No'];
                                                        for($i=0;$i<count($st_refered);$i++){
                                                            $checked= $i==$queryRes['st_refered'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" '.$checked.'>'.$st_refered[$i].'</option>';
                                                        }
                                                        ?>
                                                        </select>                                                          
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 refered_field" style="display:<?php echo $queryRes['st_refered']==1 ? '' : 'none'; ?>">
                                                    <div class="mb-3">
                                                         <label class="form-label" for="referer_name">Please specify his / her name</label>
                                                        <input type="text" class="form-control" id="referer_name" value="<?php echo $queryRes['st_refer_name']; ?>" placeholder="Name">
                                                        <div class="error-feedback">
                                                            Please Enter his / her name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 refered_field" style="display:<?php echo $queryRes['st_refered']==1 ? '' : 'none'; ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="refer_alumni">Is he / she an alumni*</label>
                                                        <select name="refer_alumni" class="form-select" id="refer_alumni">
                                                        <?php  
                                                        $st_refer_alumni=['--select--','Yes','No'];
                                                        for($i=0;$i<count($st_refer_alumni);$i++){
                                                            $checked= $i==$queryRes['st_refered'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" '.$checked.'>'.$st_refer_alumni[$i].'</option>';
                                                        }
                                                        ?>
                                                        </select>                                                          
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visa_status">Visa Condition*</label>
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
                                                        <?php  
                                                        $st_shore=['--select--','OffShore','OnShore'];
                                                        for($i=0;$i<count($st_shore);$i++){
                                                            $checked= $i==$queryRes['st_refered'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" '.$checked.'>'.$st_shore[$i].'</option>';
                                                        }
                                                        ?>
                                                        </select>                                                          
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ethnicity">Ethnicity</label>
                                                        <input type="text" class="form-control" id="ethnicity" placeholder="Ethnicity" value="<?php echo $queryRes['st_ethnicity']; ?>">
                                                        <div class="error-feedback">
                                                            Please enter the Ethnicity
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="payment_fee">Fees mentioned*</label>
                                                        <input type="text" class="form-control number-field" maxlength="7" id="payment_fee" placeholder="0.00" value="<?php echo $queryRes['st_fee']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Mentioned Fee
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="comments">Comments</label>
                                                        <input type="text" class="form-control" id="comments" placeholder="Comments" <?php echo $queryRes['st_comments']; ?>>
                                                        <div class="error-feedback">
                                                            Please enter the Comments
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="appointment_booked">Appointment booked for counseling or not?</label>
                                                        <select name="appointment_booked" class="form-select" id="appointment_booked">
                                                        <?php  
                                                        $st_appoint_book=['--select--','Yes','No'];
                                                        $selectedAppoint=$queryRes['st_appoint_book']=='' ? 0 : $queryRes['st_appoint_book'];
                                                        for($i=0;$i<count($st_appoint_book);$i++){
                                                            $checked= $i==$queryRes['st_appoint_book'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" '.$checked.'>'.$st_appoint_book[$i].'</option>';
                                                        }
                                                        ?>
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
                                                        <?php  
                                                        $st_remarks=['--select--','Good','Bad'];
                                                        for($i=0;$i<count($st_appoint_book);$i++){
                                                            $checked= $i==$queryRes['st_remarks'] ? 'selected' : '';
                                                            echo '<option value="'.$i.'" '.$checked.'>'.$st_remarks[$i].'</option>';
                                                        }
                                                        ?>
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

                localStorage.setItem("rpl_array", '<?php echo $rpl_arrays; ?>');
                localStorage.setItem("short_grp", '<?php echo $short_grps; ?>');
                localStorage.setItem("slot_book", '<?php echo $slot_books; ?>');

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
                $('#appointment_booked').on("change",function(){
                    var value=$(this).val();
                    if( value==1){
                        $('#model_slot_popup').trigger('click');
                    }
                })

                $('.rpl_close').click(function(){
                    document.getElementById('rpl_form').reset();
                    document.getElementById('short_group_form').reset();
                    // document.getElementById('model_slot_popup').reset();
                    // localStorage.getItem("rpl_array");
                    $('#course_type').val(<?php echo $selectedCourseType; ?>).change();
                 })
                $('.short_group_close').click(function(){
                    document.getElementById('rpl_form').reset();
                    document.getElementById('short_group_form').reset();
                    // document.getElementById('model_slot_popup').reset();
                    // localStorage.getItem("short_grp");
                    $('#course_type').val(<?php echo $selectedCourseType; ?>).change();
                })
                $('.model_slot_close').click(function(){
                    document.getElementById('rpl_form').reset();
                    document.getElementById('short_group_form').reset();
                    document.getElementById('slot_book_form').reset();
                    // localStorage.getItem("slot_book");
                    $('#appointment_booked').val(<?php echo $selectedAppoint; ?>).change();
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
                var visit_before=$('#visit_before').val()==0 ? '' :$('#visit_before').val();
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
                    var slot_books=localStorage.getItem("slot_book");
                    var short_grps=localStorage.getItem("short_grp");
                    $('#jelly_loader').show();
                    $('#student_enquiry_form').css('opacity','0.1');
                    
                    details={formName:'student_enquiry',studentName:studentName,contactName:contactName,emailAddress:emailAddress,courses:courses,payment:payment,checkId:checkId,visaStatus:visaStatus,surname:surname,enquiryDate:enquiryDate,suburb:suburb,stuState:stuState,postCode:postCode,visit_before:visit_before,hear_about:hear_about,plan_to_start_date:plan_to_start_date,refer_select:refer_select,referer_name:referer_name,refer_alumni:refer_alumni,comments:comments,appointment_booked:appointment_booked,remarks:remarks,streetDetails:streetDetails,enquiryFor:enquiryFor,courseType:courseType,shore:shore,ethnicity:ethnicity,rpl_arrays:rpl_arrays,short_grps:short_grps,slot_books:slot_books,admin_id:"<?php echo $_SESSION['user_id']; ?>",formId:<?php echo $form_id; ?>,rpl_status:'<?php echo $rpl_status; ?>',short_grp_status:'<?php echo $short_grp_status; ?>',slot_book_status:'<?php echo $slot_book_status; ?>'};
                    $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data==0){
                                $('.toast-text2').html('Cannot add record. Please try again later');
                                $('#borderedToast2Btn').trigger('click');
                            }else if(data==2){
                                $( "#student_enquiry_form_parent" ).load(window.location.href + " #student_enquiry_form" );
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('Record Updated Successfully');
                                $('#borderedToast1Btn').trigger('click');
                                $('#jelly_loader').hide();
                                $('#student_enquiry_form').css('opacity','');
                                // window.location.href="dashboard.php";
                            }else{
                                $( "#student_enquiry_form_parent" ).load(window.location.href + " #student_enquiry_form" );
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('New Enquiry Added');
                                $('#borderedToast1Btn').trigger('click');

                                $('#myModalLabel').html('Enquiry ID Created:');
                                $('.modal-body').html(data);
                                $('#model_trigger').trigger('click');
                                $('#jelly_loader').hide();
                                $('#student_enquiry_form').css('opacity','');
                            }
                        }
                    })
                }

            })


            function genQR(){                

                // $.ajax({
                //     url:'includes/datacontrol.php',
                //     data:{admin_id:"<?php echo $_SESSION['user_id']; ?>",formName:'create_qr'},
                //     type:'post',
                //     success:function(data){
                        
                        var qrcodeContainer = document.getElementById('qrcode');
                        var updatedURL = removeLastSegmentFromURL(window.location.href)+'/common_enquiry.php';
                        var qrcode = new QRCode(qrcodeContainer, {
                        text: updatedURL,
                        width: 128,
                        height: 128,
                        });

                        var downloadLink = document.getElementById('downloadLink');

                        var qrCodeDataURL = qrcodeContainer.querySelector('canvas').toDataURL('image/png');
                        
                        downloadLink.href = qrCodeDataURL;
                        downloadLink.click();
                    
                    // }
                // })

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


               if(rpl_exp=='' || ( rpl_exp!='' && rpl_exp==1 ) && ( exp_in=='' ||  exp_docs=='' || exp_prev=='' || exp_name=='' || exp_years=='' ) || ( rpl_exp!='' && rpl_exp==1 ) && ( exp_prev==1 && exp_prev_name=='' ) ) {



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
                var emailregexp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                var short_grp_org_type=$('#short_grp_org_type').val()==0 ? '' : $('#short_grp_org_type').val();
                var short_grp_campus=$('#short_grp_campus').val()==0 ? '' : $('#short_grp_campus').val();
                var short_grp_before=$('#short_grp_before').val()==0 ? '' : $('#short_grp_before').val();

                if(short_grp_org_name=='' || short_grp_date=='' || short_grp_num_std=='' || short_grp_ind_exp=='' || short_grp_con_type=='' || short_grp_con_num=='' || short_grp_con_name=='' || (short_grp_con_email!='' && !short_grp_con_email.match(emailregexp)==true ) || short_grp_org_type=='' || short_grp_campus=='' || short_grp_before==''){
                    

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
                    if((short_grp_con_email!='' && !short_grp_con_email.match(emailregexp)==true )){
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

            function submitSlot(){
                var slot_book_time=$('#slot_book_time').val(); 
                var slot_book_purpose=$('#slot_book_purpose').val(); 
                var slot_book_date=$('#slot_book_date').val(); 
                var slot_book_by=$('#slot_book_by').val(); 
                var slot_book_link=$('#slot_book_link').val()==0 ? '' : $('#slot_book_link').val(); 

                if(slot_book_time=='' || slot_book_purpose=='' || slot_book_date=='' || slot_book_by=='' || slot_book_link==''){

                    if(slot_book_time==''){

                        $('#slot_book_time').addClass('invalid-div');
                        $('#slot_book_time').removeClass('valid-div');
                    }else{
                        $('#slot_book_time').addClass('valid-div');
                        $('#slot_book_time').removeClass('invalid-div');

                    }
                    if(slot_book_purpose==''){

                        $('#slot_book_purpose').addClass('invalid-div');
                        $('#slot_book_purpose').removeClass('valid-div');
                    }else{
                        $('#slot_book_purpose').addClass('valid-div');
                        $('#slot_book_purpose').removeClass('invalid-div');

                    }
                    if(slot_book_date==''){

                        $('#slot_book_date').addClass('invalid-div');
                        $('#slot_book_date').removeClass('valid-div');
                    }else{
                        $('#slot_book_date').addClass('valid-div');
                        $('#slot_book_date').removeClass('invalid-div');

                    }
                    if(slot_book_by==''){

                        $('#slot_book_by').addClass('invalid-div');
                        $('#slot_book_by').removeClass('valid-div');
                    }else{
                        $('#slot_book_by').addClass('valid-div');
                        $('#slot_book_by').removeClass('invalid-div');

                    }
                    if(slot_book_link==''){

                        $('#slot_book_link').addClass('invalid-div');
                        $('#slot_book_link').removeClass('valid-div');
                    }else{
                        $('#slot_book_link').addClass('valid-div');
                        $('#slot_book_link').removeClass('invalid-div');

                    }

                }else{

                    var slot_book={"slot_book_time":slot_book_time,"slot_book_purpose":slot_book_purpose,"slot_book_date":slot_book_date,"slot_book_by":slot_book_by,"slot_book_link":slot_book_link};
                    localStorage.setItem("slot_book", JSON.stringify(slot_book));
                    $('#model_slot').modal('hide');

                }

            }

        </script>
        <!-- RPL Enquiring Popup-->
<!-- modal bootstrap -->
<button type="button" class="btn btn-primary btn-sm waves-effect waves-light d-none" data-bs-toggle="modal" id="rpl_popup" data-bs-target="#model_rpl_enq"></button>
<!-- sample modal content -->
<div id="model_rpl_enq" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rpl_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rpl_modal"></h5>
                <button type="button" class="btn-close rpl_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rpl_form">
            <div class="modal-body myModal1-body row">

                <div class="col-12">
                    <label class="form-label" for="rpl_exp">Do they have Experience ?</label>
                    <select name="rpl_exp" class="form-control rpl_parent" id="rpl_exp">
                        <?php 
                        $rpl_exps=['--select--','Yes','No'];
                        for($i=0;$i<count($rpl_exps);$i++){
                            $selected=$i==$rpl_array['rpl_exp'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$rpl_exps[$i]."</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="col-12 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
                    <label class="form-label" for="exp_in">Experienced In</label>
                    <select name="exp_in" class="form-control" id="exp_in">
                    <?php 
                        $rpl_exps_in=['--select--','Aged Care','Disability Care','Mental Health'];
                        for($i=0;$i<count($rpl_exps_in);$i++){
                            $selected=$i==$rpl_array['exp_in'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$rpl_exps_in[$i]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
                    <label class="form-label" for="exp_name">Role/Designation</label>
                    <input type="text" name="exp_name" class="form-control" id="exp_name" placeholder="Role" value="<?php echo $rpl_array['exp_name']; ?>">
                </div>
                <div class="col-12 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
                    <label class="form-label" for="exp_years">How Many Years & Months</label>
                    <input type="text" name="exp_years" class="form-control number-field" id="exp_years" placeholder="Years" value="<?php echo $rpl_array['exp_years']; ?>">
                </div>
                <div class="col-12 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
                    <label class="form-label" for="exp_docs">Do they have any Documents(payslips and job description / Contract Letter)</label>
                    <select name="exp_docs" class="form-control" id="exp_docs">
                    <?php 
                        $rpl_exps_doc=['--select--','Yes','No'];
                        for($i=0;$i<count($rpl_exps_doc);$i++){
                            $selected=$i==$rpl_array['exp_docs'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$rpl_exps_doc[$i]."</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="col-12 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
                    <label class="form-label" for="exp_prev">Any previous Qualification done ?</label>
                    <select name="exp_prev" class="form-control rpl_prev_parent" id="exp_prev">
                    <?php 
                        $rpl_exps_prev=['--select--','Yes','No'];
                        for($i=0;$i<count($rpl_exps_prev);$i++){
                            $selected=$i==$rpl_array['exp_prev'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$rpl_exps_prev[$i]."</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="col-12 rpl_prev_child" style="display:<?php echo $rpl_array['exp_prev']==1 ? 'block' : 'none' ?>">
                    <label class="form-label" for="exp_prev_name">Previous Qualification Name</label>
                    <input type="text" name="exp_prev_name" class="form-control" id="exp_prev_name" placeholder="Name" value="<?php echo $rpl_array['exp_prev_name']; ?>">
                </div>

            </div>
        </form> 

            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" id="rpl_submit" onclick="submitRpl()" >Submit</button>
                <button type="button" class="btn btn-secondary waves-effect rpl_close" id="rpl_close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Short course Group booking Popup-->
<!-- modal bootstrap -->
<button type="button" class="btn btn-primary btn-sm waves-effect waves-light d-none" data-bs-toggle="modal" id="short_group_popup" data-bs-target="#model_short_group"></button>
<!-- sample modal content -->
<div id="model_short_group" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="short_group" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="short_group"></h5>
                <button type="button" class="btn-close short_group_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="short_group_form">
            <div class="modal-body myModal1-body row">

                <div class="col-12">
                    <label class="form-label" for="short_grp_org_name">Organisation Name</label>
                    <input type="text" name="short_grp_org_name" class="form-control" id="short_grp_org_name" placeholder="Organisation Name"  value="<?php echo $short_grp['short_grp_org_name']; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_org_type">Type of Organisation</label>
                    <select name="short_grp_org_type" class="form-control" id="short_grp_org_type">
                    <?php 
                        $short_grp_org_type=['--select--','Job Agency','Employer','College'];
                        for($i=0;$i<count($short_grp_org_type);$i++){
                            $selected=$i==$short_grp['short_grp_org_type'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$short_grp_org_type[$i]."</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_campus">Campus</label>
                    <select name="short_grp_campus" class="form-control" id="short_grp_campus">
                    <?php 
                        $short_grp_campus=['--select--','Off Campus','On Campus'];
                        for($i=0;$i<count($short_grp_campus);$i++){
                            $selected=$i==$short_grp['short_grp_campus'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$short_grp_campus[$i]."</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_date">Date Required</label>
                    <input type="date" name="short_grp_date" class="form-control" id="short_grp_date" value="<?php echo $short_grp['short_grp_date']!='' ? date('Y-m-d',strtotime($short_grp['short_grp_date'])) : ''; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_num_std">Number of Students</label>
                    <input type="tel" name="short_grp_num_std" class="form-control number-field" id="short_grp_num_std" value="<?php echo $short_grp['short_grp_num_std']; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_ind_exp">Have they got Industry Experience ?</label>
                    <select name="short_grp_ind_exp" class="form-control" id="short_grp_ind_exp">
                    <?php 
                        $short_grps_ind_exp=['--select--','Yes','No'];
                        for($i=0;$i<count($short_grps_ind_exp);$i++){
                            $selected=$i==$short_grp['short_grp_ind_exp'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$short_grps_ind_exp[$i]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_before">Have they done this Training Before ?</label>
                    <select name="short_grp_before" class="form-control" id="short_grp_before">
                    <?php 
                        $short_grp_train_bef=['--select--','Yes','No'];
                        for($i=0;$i<count($short_grp_train_bef);$i++){
                            $selected=$i==$short_grp['short_grp_before'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$short_grp_train_bef[$i]."</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_con_type">How did they Contact us</label>
                    <input type="text" name="short_grp_con_type" class="form-control" id="short_grp_con_type" value="<?php echo $short_grp['short_grp_con_type']; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_con_num">Contact Number</label>
                    <input type="tel" name="short_grp_con_num" class="form-control number-field" id="short_grp_con_num" placeholder="Contact Number" value="<?php echo $short_grp['short_grp_con_num']; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_con_name">Contact Person Name</label>
                    <input type="text" name="short_grp_con_name" class="form-control" id="short_grp_con_name" placeholder="Name" value="<?php echo $short_grp['short_grp_con_name']; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_con_email">Contact Person Email</label>
                    <input type="email" name="short_grp_con_email" class="form-control" id="short_grp_con_email" placeholder="Email" value="<?php echo $short_grp['short_grp_con_email']; ?>">
                </div>

            </div>
        </form> 

            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" id="short_group_submit" onclick="submitShortGroup()" >Submit</button>
                <button type="button" class="btn btn-secondary waves-effect short_group_close" id="short_group_close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- sLOT Booked Modal-->
<!-- modal bootstrap -->
<button type="button" class="btn btn-primary btn-sm waves-effect waves-light d-none" data-bs-toggle="modal" id="model_slot_popup" data-bs-target="#model_slot"></button>
<!-- sample modal content -->
<div id="model_slot" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="model_slot" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="model_slot"></h5>
                <button type="button" class="btn-close model_slot_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="slot_book_form">
            <div class="modal-body myModal1-body row">
                <div class="col-12">
                    <label class="form-label" for="slot_book_time">Appointment Time</label>
                    <input type="datetime-local" name="slot_book_time" class="form-control" id="slot_book_time" value="<?php echo $slot_book['slot_book_time']!='' ? date('Y-m-d H:i',strtotime($slot_book['slot_book_time'])) : '' ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="slot_book_purpose">Purpose of Appointment</label>
                    <input type="text" name="slot_book_purpose" class="form-control" id="slot_book_purpose" placeholder="Purpose" value="<?php echo $slot_book['slot_book_purpose']; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="slot_book_date">Booked On</label>
                    <input type="date" name="slot_book_date" class="form-control" id="slot_book_date" value="<?php echo $slot_book['slot_book_date']!='' ? date('Y-m-d',strtotime($slot_book['slot_book_date'])) : '' ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="slot_book_by">Booking Made By</label>
                    <input type="text" name="slot_book_by" class="form-control" id="slot_book_by" placeholder="Booked By" value="<?php echo $slot_book['slot_book_by']; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label" for="slot_book_link">Sent the Email for the Link ?</label>
                    <select name="slot_book_link" class="form-control" id="slot_book_link">
                    <?php 
                        $slot_booking_link=['--select--','Yes','No'];
                        for($i=0;$i<count($slot_booking_link);$i++){
                            $selected=$i==$slot_book['slot_book_link'] ? 'selected' : '';
                            echo "<option value='".$i."' ".$selected.">".$slot_booking_link[$i]."</option>";
                        }

                        ?>
                    </select>
                </div>

            </div>
        </form> 

            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" id="model_slot_submit" onclick="submitSlot()" >Submit</button>
                <button type="button" class="btn btn-secondary waves-effect model_slot_close" id="model_slot_close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    </body>
</html>
<?php }else{ 
header("Location: index.php");
}
?>
