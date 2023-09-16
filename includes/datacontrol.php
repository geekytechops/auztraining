<?php 
require('dbconnect.php');
session_start();
if(@$_POST['formName']=='logout'){
    session_destroy();
    header('Location: ../index.php');
}
if(@$_POST['formName']=='create_qr'){
    $admin_id=$_POST['admin_id'];
    $query=mysqli_query($connection,"INSERT INTO `enquiry_forms` (`enq_admin_id`)VALUES($admin_id);");
    $last_inserted_id=mysqli_insert_id($connection);    
    echo base64_encode($last_inserted_id);

}

if(@$_POST['formName']=='student_enquiry_common'){


    $enquiryFor=$_POST['enquiryFor'];
    if($enquiryFor==1){
        $studentName=$_POST['studentName'];
        $memberName=$_POST['memberName'];
    }else{
        $studentName=$_POST['memberName'];
        $memberName=$_POST['studentName'];
    }

    $contactName=$_POST['contactName'];
    $emailAddress=$_POST['emailAddress'];
    $courses=$_POST['courses'];
    $checkId=$_POST['checkId'];

    $surname=$_POST['surname'];
    $suburb=$_POST['suburb'];
    $stuState=$_POST['stuState'];
    $postCode=$_POST['postCode'];
    $visit_before=$_POST['visit_before'];
    $hear_about=$_POST['hear_about'];
    $plan_to_start_date=$_POST['plan_to_start_date'];
    $refer_select=$_POST['refer_select'];
    $referer_name=$_POST['referer_name'];
    $refer_alumni=$_POST['refer_alumni'];
    $streetDetails=$_POST['streetDetails'];
    $created_by=$_POST['admin_id'];
    $form_type=$_POST['form_type'];

    $query=mysqli_query($connection,"INSERT INTO student_enquiry(st_name,st_member_name,st_phno,st_email,st_course,st_surname,st_suburb,st_state,st_post_code,st_visited,st_heared,st_startplan_date,st_refered,st_refer_name,st_refer_alumni,st_street_details,st_enquiry_for,st_created_by,st_gen_enq_type)VALUES('$studentName','$memberName','$contactName','$emailAddress',$courses,'$surname','$suburb','$stuState',$postCode,$visit_before,$hear_about,'$plan_to_start_date',$refer_select,'$referer_name',$refer_alumni,'$streetDetails',$enquiryFor,$created_by,$form_type)");

    $lastId=mysqli_insert_id($connection);
    $uniqueId=sprintf('EQ%05d', $lastId);
    $querys=mysqli_query($connection,"UPDATE student_enquiry SET st_enquiry_id='$uniqueId' WHERE st_id=$lastId");
    $error=mysqli_error($connection);
    if($error!=''){
        echo 0;
    }else{
        echo $uniqueId;

        $mail_to=$emailAddress;
        $mail_subject="Your Enquiry Successfully Created";
        $mail_body="Please keep your enquiry ID noted for future uses<br><b>Enquiry ID: </b>".$uniqueId;
        send_mail($mail_to,$mail_subject,$mail_body);


    }

}
if(@$_POST['formName']=='student_enquiry'){


    $enquiryFor=$_POST['enquiryFor'];
    if($enquiryFor==1){
        $studentName=$_POST['studentName'];
        $memberName=$_POST['memberName'];
    }else{
        $studentName=$_POST['memberName'];
        $memberName=$_POST['studentName'];
    }



$contactName=$_POST['contactName'];
$emailAddress=$_POST['emailAddress'];
$courses=$_POST['courses'];
$payment=$_POST['payment'];
$visaStatus=$_POST['visaStatus'];
$checkId=$_POST['checkId'];
$enquiryDate=$_POST['enquiryDate'];

$surname=$_POST['surname'];
$suburb=$_POST['suburb'];
$stuState=$_POST['stuState'];
$postCode=$_POST['postCode'];
$visit_before=$_POST['visit_before'];
$hear_about=$_POST['hear_about'];
$plan_to_start_date=$_POST['plan_to_start_date'];
$refer_select=$_POST['refer_select'];
$referer_name=$_POST['referer_name'];
$refer_alumni=$_POST['refer_alumni'];
$comments=$_POST['comments'];
$appointment_booked=$_POST['appointment_booked'];
$remarks=$_POST['remarks'];
$streetDetails=$_POST['streetDetails'];
$courseType=$_POST['courseType'];
$shore=$_POST['shore'];
$ethnicity=$_POST['ethnicity'];
$created_by=$_POST['admin_id'];
$formId=$_POST['formId'];
$slot_book_status=$_POST['slot_book_status'];
$short_grp_status=$_POST['short_grp_status'];
$rpl_status=$_POST['rpl_status'];
$now=date('Y-m-d H:i:s');

$rpl_arrays=json_decode($_POST['rpl_arrays']);
$short_grps=json_decode($_POST['short_grps']);
$slot_books=json_decode($_POST['slot_books']);

if($checkId==0){

    $query=mysqli_query($connection,"INSERT INTO student_enquiry(st_name,st_member_name,st_phno,st_email,st_course,st_fee,st_visa_status,st_surname,st_suburb,st_state,st_post_code,st_visited,st_heared,st_startplan_date,st_refered,st_refer_name,st_refer_alumni,st_comments,st_appoint_book,st_remarks,st_street_details,st_enquiry_for,st_enquiry_date,st_course_type,st_shore,st_ethnicity,st_created_by)VALUES('$studentName','$memberName','$contactName','$emailAddress',$courses,'$payment',$visaStatus,'$surname','$suburb','$stuState',$postCode,$visit_before,$hear_about,'$plan_to_start_date',$refer_select,'$referer_name',$refer_alumni,'$comments',$appointment_booked,'$remarks','$streetDetails',$enquiryFor,'$enquiryDate',$courseType,$shore,'$ethnicity',$created_by)");
    $lastId=mysqli_insert_id($connection);
    $uniqueId=sprintf('EQ%05d', $lastId);
    $querys=mysqli_query($connection,"UPDATE student_enquiry SET st_enquiry_id='$uniqueId' WHERE st_id=$lastId");
    $error=mysqli_error($connection);
    if($error!=''){
        echo 0;
    }else{
        echo $uniqueId;

        $mail_to=$emailAddress;
        $mail_subject="Your Enquiry Successfully Created";
        $mail_body="Please keep your enquiry ID noted for future uses<br><b>Enquiry ID: </b>".$uniqueId;
        send_mail($mail_to,$mail_subject,$mail_body);

        // insert course Type data
        if($courseType==1){

            $query=mysqli_query($connection,"INSERT INTO `rpl_enquries` (`enq_form_id`,`rpl_exp_in`,`rpl_exp_role`,`rpl_exp_years`,`rpl_exp_docs`,`rpl_exp_prev_qual`,`rpl_exp_qual_name`,`rpl_exp`) VALUES( $lastId,'".$rpl_arrays->exp_in."','".$rpl_arrays->exp_name."','".$rpl_arrays->exp_years."',".$rpl_arrays->exp_docs.",".$rpl_arrays->exp_prev.",'".$rpl_arrays->exp_prev_name."',".$rpl_arrays->rpl_exp." )");

        }else if($courseType==5){
         
            
            $query=mysqli_query($connection,"INSERT INTO `short_group_form` (`enq_form_id`,`sh_org_name`,`sh_grp_org_type`,`sh_grp_campus`,`sh_grp_date`,`sh_grp_num_stds`,`sh_grp_ind_exp`,`sh_grp_train_bef`,`sh_grp_con_us`,`sh_grp_phone`,`sh_grp_name`,`sh_grp_email`) VALUES( $lastId,'".$short_grps->short_grp_org_name."',".$short_grps->short_grp_org_type.",".$short_grps->short_grp_campus.",'".$short_grps->short_grp_date."',".$short_grps->short_grp_num_std.",".$short_grps->short_grp_ind_exp.",".$short_grps->short_grp_before.",'".$short_grps->short_grp_con_type."','".$short_grps->short_grp_con_num."','".$short_grps->short_grp_con_name."','".$short_grps->short_grp_con_email."' )");


        }


        if($appointment_booked==1){

            $appointment_booked_time=date('Y-m-d H:i:s',strtotime($slot_books->slot_book_time));

            $query=mysqli_query($connection,"INSERT INTO `slot_book` (`enq_form_id`,`slot_bk_datetime`,`slot_bk_purpose`,`slot_bk_on`,`slot_book_by`,`slot_book_email_link`) VALUES( $lastId,'".$appointment_booked_time."','".$slot_books->slot_book_purpose."','".$slot_books->slot_book_date."','".$slot_books->slot_book_by."',".$slot_books->slot_book_link." )");
        }        

    }

}else{
    
    if(mysqli_query($connection,"UPDATE student_enquiry SET `st_name`='$studentName',`st_member_name`='$memberName' ,`st_phno`='$contactName',`st_email`='$emailAddress',`st_course`=$courses,`st_fee`='$payment',`st_visa_status`=$visaStatus , `st_surname`='$surname' , `st_suburb`= '$suburb' , `st_state`='$stuState',`st_post_code`= $postCode,`st_visited`=$visit_before,`st_heared`=$hear_about,`st_startplan_date`='$plan_to_start_date',`st_refered`=$refer_select,`st_refer_name`='$referer_name',`st_refer_alumni`=$refer_alumni,`st_comments`='$comments',`st_appoint_book`= $appointment_booked,`st_remarks`='$remarks',`st_street_details`= '$streetDetails' , `st_enquiry_for`= $enquiryFor , `st_enquiry_date`='$enquiryDate' ,`st_course_type`=$courseType , `st_shore`=$shore,`st_ethnicity`='$ethnicity',`st_modified_by`= $created_by , `st_modified_date`='$now'  WHERE `st_id`=$checkId")){

        // insert course Type data
        if($courseType==1){

            if($rpl_status==1){

            $query=mysqli_query($connection,"UPDATE `rpl_enquries` set `rpl_exp_in` ='$rpl_arrays->exp_in' ,`rpl_exp_role` ='$rpl_arrays->exp_name' ,`rpl_exp_years` = '$rpl_arrays->exp_years',`rpl_exp_docs` =$rpl_arrays->exp_docs ,`rpl_exp_prev_qual` =$rpl_arrays->exp_prev ,`rpl_exp_qual_name` ='$rpl_arrays->exp_prev_name' ,`rpl_exp` =$rpl_arrays->rpl_exp WHERE `enq_form_id` = $formId");

        }else{

            $query=mysqli_query($connection,"INSERT INTO `rpl_enquries` (`enq_form_id`,`rpl_exp_in`,`rpl_exp_role`,`rpl_exp_years`,`rpl_exp_docs`,`rpl_exp_prev_qual`,`rpl_exp_qual_name`,`rpl_exp`) VALUES( $formId,'".$rpl_arrays->exp_in."','".$rpl_arrays->exp_name."','".$rpl_arrays->exp_years."',".$rpl_arrays->exp_docs.",".$rpl_arrays->exp_prev.",'".$rpl_arrays->exp_prev_name."',".$rpl_arrays->rpl_exp." )");


        }

        }else if($courseType==5){

            if($short_grp_status==1){
                     
            $query=mysqli_query($connection,"UPDATE `short_group_form` SET `sh_org_name`='$short_grps->short_grp_org_name',`sh_grp_org_type`=$short_grps->short_grp_org_type,`sh_grp_campus`=$short_grps->short_grp_campus,`sh_grp_date`='$short_grps->short_grp_date',`sh_grp_num_stds`=$short_grps->short_grp_num_std,`sh_grp_ind_exp`=$short_grps->short_grp_ind_exp,`sh_grp_train_bef`=$short_grps->short_grp_before,`sh_grp_con_us`='$short_grps->short_grp_con_type',`sh_grp_phone`='$short_grps->short_grp_con_num',`sh_grp_name`='$short_grps->short_grp_con_name',`sh_grp_email`='$short_grps->short_grp_con_email' WHERE `enq_form_id`=$formId");

            }else{

                $query=mysqli_query($connection,"INSERT INTO `short_group_form` (`enq_form_id`,`sh_org_name`,`sh_grp_org_type`,`sh_grp_campus`,`sh_grp_date`,`sh_grp_num_stds`,`sh_grp_ind_exp`,`sh_grp_train_bef`,`sh_grp_con_us`,`sh_grp_phone`,`sh_grp_name`,`sh_grp_email`) VALUES( $formId,'".$short_grps->short_grp_org_name."',".$short_grps->short_grp_org_type.",".$short_grps->short_grp_campus.",'".$short_grps->short_grp_date."',".$short_grps->short_grp_num_std.",".$short_grps->short_grp_ind_exp.",".$short_grps->short_grp_before.",'".$short_grps->short_grp_con_type."','".$short_grps->short_grp_con_num."','".$short_grps->short_grp_con_name."','".$short_grps->short_grp_con_email."' )");


            }

        }


        if($appointment_booked==1){

            $appointment_booked_time=date('Y-m-d H:i:s',strtotime($slot_books->slot_book_time));

            if($slot_book_status==1){


            $query=mysqli_query($connection,"UPDATE `slot_book` SET `slot_bk_datetime` = '$appointment_booked_time',`slot_bk_purpose` ='$slot_books->slot_book_purpose' ,`slot_bk_on` = '$slot_books->slot_book_date',`slot_book_by` = '$slot_books->slot_book_by',`slot_book_email_link` = $slot_books->slot_book_link WHERE `enq_form_id` = $formId");

            }else{


                $query=mysqli_query($connection,"INSERT INTO `slot_book` (`enq_form_id`,`slot_bk_datetime`,`slot_bk_purpose`,`slot_bk_on`,`slot_book_by`,`slot_book_email_link`) VALUES( $formId,'".$appointment_booked_time."','".$slot_books->slot_book_purpose."','".$slot_books->slot_book_date."','".$slot_books->slot_book_by."',".$slot_books->slot_book_link." )");


            }
            


        }


        echo 2;
    }else{
        echo 0;
    }

}

}

if(@$_POST['formName']=='delete_enq'){
    $enq_id=$_POST['eq_id'];
    $note=$_POST['note'];
    $query=mysqli_query($connection,"UPDATE `student_enquiry` SET `st_delete_note`='$note' , `st_enquiry_status`=1 WHERE `st_id`=$enq_id");
if($query){
    echo 1;
}else{
    echo 0;
}
}

if(@$_POST['formName']=='delete_enrol'){
    $enrol_id=$_POST['enrol_id'];
    $query=mysqli_query($connection,"UPDATE `student_enrolment` SET `st_enrol_status`=1 WHERE `st_enrol_id`=$enrol_id");
if($query){
    echo 1;
}else{
    echo 0;
}
}

if(@$_POST['formName']=='student_enrol'){
$qualifications=$_POST['qualifications'];
$venue=$_POST['venues'];
$middle_name=$_POST['middle_name'];
$st_enquiry_id=$_POST['enquiry_id'];
$courseName=strtoupper($_POST['courseName'][0]);
$courseId=$_POST['courses'];
$source=$_POST['source'];
$name_main=$_POST['name_main'];
$emailAddress=$_POST['emailAddress'];
$contactName=$_POST['contactName'];
$given_name=$_POST['given_name'];
$checkId=$_POST['checkId'];
$dateYear=date("Y");

if($checkId==0){

$query=mysqli_query($connection,"INSERT INTO student_enrolment(st_qualifications,st_email,st_mobile,st_enquiry_id,st_enrol_course,st_venue,st_middle_name,st_name,st_source,st_given_name)VALUES('$qualifications','$emailAddress','$contactName','$st_enquiry_id',$courseId,'$venue','$middle_name','$name_main',$source,'$given_name')");
$lastId=mysqli_insert_id($connection);

$courseID=mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM courses WHERE course_id=$courseId"));

$uniqueId=sprintf($dateYear.$courseID['course_sname'].'%04d', $lastId);

$querys=mysqli_query($connection,"UPDATE student_enrolment SET st_unique_id='$uniqueId' WHERE st_enrol_id=$lastId");
$error=mysqli_error($connection);
if($error!=''){
    echo 1;
}else{
    echo $uniqueId;
}

}else{

    if(mysqli_query($connection,"UPDATE student_enrolment SET `st_qualifications`='$qualifications',`st_email`='$emailAddress',`st_mobile`='$contactName',`st_enrol_course`=$courseId,`st_venue`='$venue',`st_middle_name`='$middle_name',`st_name`='$name_main',`st_source`=$source,`st_given_name`='$given_name' WHERE `st_enrol_id`=$checkId")){
        echo 2;
    }else{
        echo 0;
    }
    
}

}
if(@$_POST['formName']=='invoice_submit'){
$payment_date=$_POST['payment_date'];
$amount_due=$_POST['amount_due'];
$amount_paid=$_POST['amount_paid'];
$course_fee=$_POST['course_fee'];
$course_name=$_POST['course_name'];
$enrol_id=$_POST['enrol_id'];
$student_name=$_POST['student_name'];
$date=date('Y');

$query=mysqli_query($connection,"INSERT INTO invoices(inv_std_name,st_unique_id,inv_course,inv_fee,inv_paid,inv_due,inv_payment_date)VALUES('$student_name','$enrol_id','$course_name','$course_fee','$amount_paid',$amount_due,'$payment_date')");
$lastId=mysqli_insert_id($connection);
$uniqueId=sprintf('INV'.$date.'%05d', $lastId);

$querys=mysqli_query($connection,"UPDATE invoices SET inv_auto_id='$uniqueId' WHERE inv_id=$lastId");

$error=mysqli_error($connection);
if($error!=''){
    echo 1;
}else{
    echo $uniqueId;
}
}
if(@$_POST['formName']=='login'){
$email=$_POST['email'];
$password=$_POST['password'];
$query=mysqli_query($connection,"SELECT user_id,user_type,user_name,user_log_id FROM users WHERE user_email='$email' AND user_password='$password'");
$error=mysqli_error($connection);
$id=mysqli_fetch_array($query);
if($id['user_id']=='' || $id['user_id']=='undefined'){
    echo 1;
}else{
    $_SESSION['user_id']=$id['user_id'];
    $_SESSION['user_type']=$id['user_type'];
    $_SESSION['user_name']=$id['user_name'];
    $_SESSION['user_log_id']=$id['user_log_id'];
    echo 0;
}
}

if(@$_REQUEST['name']=='singleinvoice'){
    $studentId=$_REQUEST['id'];
    $invoices['data']=[];
    $query=mysqli_query($connection,"SELECT * FROM `invoices` WHERE `st_unique_id`='$studentId'");
    while($queryRes=mysqli_fetch_array($query)){

    array_push($invoices['data'],array('autoId'=>$queryRes['inv_auto_id'],'course'=>$queryRes['inv_course'], 'fee'=>$queryRes['inv_fee'],'paid'=>$queryRes['inv_paid'],'date'=>$queryRes['inv_payment_date']));

    }
    header("Content-Type: application/json");
    echo json_encode($invoices);
}

if(@$_REQUEST['name']=='studentEnquiry'){
    $enquiries['data']=[];
    $query=mysqli_query($connection,"SELECT * from student_enquiry where st_enquiry_status!=1");
    while($queryRes=mysqli_fetch_array($query)){
        $courses=mysqli_fetch_array(mysqli_query($connection,"SELECT * from courses where course_status!=1 AND course_id=".$queryRes['st_course']));

        if($queryRes['st_visa_status']==1){
            $visaStatus='<i class="mdi mdi-checkbox-blank-circle text-warning me-1"></i> Pending';
        }else if($queryRes['st_visa_status']==2){
            $visaStatus='<i class="mdi mdi-checkbox-blank-circle text-success me-1"></i> Approved';
        }else{
            $visaStatus='<i class="mdi mdi-checkbox-blank-circle text-danger me-1"></i> Declined';
        }

        $view='<a class="btn btn-outline-primary btn-sm edit_enq" style="margin-right:10px;" href="student_enquiry.php?eq='.base64_encode($queryRes['st_id']).'">Edit</a><button onclick="delete_enq('.$queryRes['st_id'].')" type="button" class="btn btn-outline-danger btn-sm">Delete</button>';

        array_push($enquiries['data'],array('st_enquiry_id'=>$queryRes['st_enquiry_id'],'std_name'=>$queryRes['st_name'], 'std_phno'=>$queryRes['st_phno'],'std_email'=>$queryRes['st_email'],'std_course'=>$courses['course_sname'].'-'.$courses['course_name'],'std_fee'=>$queryRes['st_fee'],'std_visa_status'=>$visaStatus,'action'=>$view));
        
    }
    header("Content-Type: application/json");
    echo json_encode($enquiries);
}
if(@$_REQUEST['name']=='student_invoices'){
    $invoices['data']=[];
    $query=mysqli_query($connection,"SELECT * from invoices");
    while($queryRes=mysqli_fetch_array($query)){

        $courses=mysqli_fetch_array(mysqli_query($connection,"SELECT * from courses where course_status!=1 AND course_id=".$queryRes['inv_course']));

        array_push($invoices['data'],array('inv_id'=>$queryRes['inv_auto_id'],'inv_std_name'=>$queryRes['inv_std_name'], 'inv_fee'=>$queryRes['inv_fee'],'inv_paid'=>$queryRes['inv_paid'],'inv_course'=>$courses['course_sname'].'-'.$courses['course_name'],'inv_due'=>$queryRes['inv_due'],'inv_payment_date'=>$queryRes['inv_payment_date']));
        
    }
    header("Content-Type: application/json");
    echo json_encode($invoices);
}

if(@$_REQUEST['name']=='student_enrol'){
    $enrol['data']=[];
    $query=mysqli_query($connection,"SELECT * from student_enrolment where st_enrol_status!=1");
    while($queryRes=mysqli_fetch_array($query)){

        if($queryRes['st_qualifications']==1){
            $qualifications='Masters Degree';
        }else if($queryRes['st_qualifications']==2){
            $qualifications='Bachelors Degree';
        }else{
            $qualifications='MCA';
        }

        if($queryRes['st_venue']==1){
            $venue='Adeladie';
        }else if($queryRes['st_venue']==2){
            $venue='New Jersey';
        }else{
            $venue='Australia';
        }

        if($queryRes['st_source']==1){
            $source='Friends';
        }else if($queryRes['st_source']==2){
            $source='Google';
        }else{
            $source='Website';
        }


        $view='<button type="button" data="'.$queryRes['st_enrol_id'].'" class="btn btn-outline-primary btn-sm edit_enrol" style="margin-right:10px;"><a href="enrolment.php?enrol='.base64_encode($queryRes['st_enrol_id']).'">Edit</a></button><button onclick="delete_enrol('.$queryRes['st_enrol_id'].')" type="button" class="btn btn-outline-danger btn-sm">Delete</button>';

        array_push($enrol['data'],array('st_enrol_name'=>$queryRes['st_name'],'st_enrol_id'=>$queryRes['st_unique_id'],'st_enq_id'=>$queryRes['st_enquiry_id'], 'st_enrol_givenname'=>$queryRes['st_given_name'],'st_enrol_middlename'=>$queryRes['st_middle_name'],'st_enrol_qual'=>$qualifications,'st_enrol_venue'=>$venue,'st_enrol_source'=>$source,'action'=>$view));
        
    }
    header("Content-Type: application/json");
    echo json_encode($enrol);
}


if(@$_REQUEST['name']=='all_students'){
    $enrol['data']=[];
    $query=mysqli_query($connection,"SELECT st_unique_id,st_name,st_mobile,st_email,st_enrol_course,created_date from student_enrolment where st_enrol_status!=1");
    while($queryRes=mysqli_fetch_array($query)){

        $enrolDate=date('d-M-Y',strtotime($queryRes['created_date']));

        // if($queryRes['st_enrol_course']==1){
        //     $course='Basic';
        // }else if($queryRes['st_enrol_course']==2){
        //     $course='Intermediate';
        // }else{
        //     $course='Expert';
        // }

        $courses=mysqli_fetch_array(mysqli_query($connection,"SELECT * from courses where course_status!=1 AND course_id=".$queryRes['st_enrol_course']));

        $uniq_id='<a href="studentData.php?check='.base64_encode($queryRes['st_unique_id']).'" style="color:var(--color)">'.$queryRes['st_unique_id'].'</a>';

        $view='<button type="button" data="'.$queryRes['st_unique_id'].'" class="btn btn-outline-primary btn-sm edit_enrol" style="margin-right:10px;"><a href="studentData.php?check='.base64_encode($queryRes['st_unique_id']).'">View</a></button>';

        array_push($enrol['data'],array('st_unique_id'=>$uniq_id,'st_enrol_name'=>$queryRes['st_name'], 'std_phno'=>$queryRes['st_mobile'],'std_email'=>$queryRes['st_email'],'course'=>$courses['course_sname'].'-'.$courses['course_name'],'std_date'=>$enrolDate,'action'=>$view));
        
    }
    header("Content-Type: application/json");
    echo json_encode($enrol);
}


if(@$_POST['formName']=='lookupLoad'){
    if($_POST['selected']=='1'){
        $query=mysqli_query($connection,"SELECT st_mobile as datas from student_enrolment WHERE st_enrol_status!=1");
    }else{
        $query=mysqli_query($connection,"SELECT st_email as datas from student_enrolment WHERE st_enrol_status!=1");
    }
    $body= "<option value='0'>--select--</option>";
    while($queryRes=mysqli_fetch_array($query)){
        $body.="<option value=".$queryRes['datas'].">".$queryRes['datas']."</option>";
    }
    echo $body;
}

if(@$_POST['formName']=='lookupdata'){
    if($_POST['selected']=='1'){
        $query=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enrolment WHERE st_enrol_status!=1 AND st_mobile='".$_POST['values']."'"));
    }else{
        $query=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enrolment WHERE st_enrol_status!=1 AND st_email='".$_POST['values']."'"));
    }
    
    echo json_encode($query);
}

if(@$_POST['formName']=='lookupLoad2'){
    if($_POST['selected']=='1'){
        $query=mysqli_query($connection,"SELECT st_phno as datas from student_enquiry WHERE st_enquiry_status!=1");
    }else{
        $query=mysqli_query($connection,"SELECT st_email as datas from student_enquiry WHERE st_enquiry_status!=1");
    }
    $body= "<option value='0'>--select--</option>";
    while($queryRes=mysqli_fetch_array($query)){
        $body.="<option value=".$queryRes['datas'].">".$queryRes['datas']."</option>";
    }
    echo $body;
}

if(@$_POST['formName']=='lookupdata2'){
    if($_POST['selected']=='1'){
        $query=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enquiry WHERE st_enquiry_status!=1 AND st_phno='".$_POST['values']."'"));
    }else{
        $query=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enquiry WHERE st_enquiry_status!=1 AND st_email='".$_POST['values']."'"));
    }
    
    echo json_encode($query);
}


if(@$_REQUEST['name']=='all_attendance'){
    $attendance['data']=[];

    $query=mysqli_fetch_all(mysqli_query($connection,"select DISTINCT(st_unique_id) from student_attendance"),MYSQLI_ASSOC); 
    $queryCrs=mysqli_fetch_all(mysqli_query($connection,"select DISTINCT(st_course_unit) from student_attendance"),MYSQLI_ASSOC); 

    $query=mysqli_query($connection,"select * from `student_attendance`");
    while($queryRes=mysqli_fetch_array($query)){

        $id=$queryRes['st_unique_id'];
        $selectName=mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM student_enrolment where st_unique_id='$id'"));
        if($selectName!=''){
        // echo "SELECT * FROM student_enrolment where st_unique_id='$id'";

        array_push($attendance['data'],array('student_id'=>$queryRes['st_unique_id'],'student_name'=>$selectName['st_given_name'].' '.$selectName['st_middle_name'],'course'=>$queryRes['st_course_unit'],'mobile'=>$selectName['st_mobile'],'email'=>$selectName['st_email'],'attenddate'=>$queryRes['st_unit_date']));
        }
        
    }
    // header("Content-Type: application/json");
    // echo json_encode($attendance);
}

if(@$_REQUEST['name']=='single_attendance'){
    $attendance['data']=[];
    $id=$_REQUEST['enrolid'];
    $query=mysqli_query($connection,"select st1.st_unique_id as student_id,st1.st_course_unit as course ,st1.st_unit_date as at_date from student_attendance st1 inner join student_enrolment st2 where st1.st_unique_id=$id");
    while($queryRes=mysqli_fetch_array($query)){

        array_push($attendance['data'],array('student_id'=>$queryRes['student_id'],'student_name'=>$queryRes['name'].' '.$queryRes['mname'],'course'=>$queryRes['course'],'mobile'=>$queryRes['mobile'],'email'=>$queryRes['email'],'attenddate'=>$queryRes['at_date']));
        
    }
    header("Content-Type: application/json");
    echo json_encode($attendance);
}

if(@$_POST['formName']=='studentDocs'){
 
    $arrayUploaded=array();
    $enrollId=$_POST['enrollId'];
    $count=count($_FILES['fileUpload']["name"]);
    $excelArr=array('xlsx','xlx','csv');
    $pdfArr=array('pdf');
    $docArr=array('doc','docx');
    $targetDir = "uploads/";
    $dbImgArray=array();

    for($i=0;$i<$count;$i++){
        $fileName=explode('.',$_FILES["fileUpload"]["name"][$i])[0];        
        $fileType = pathinfo('uploads/'.basename($_FILES["fileUpload"]["name"][$i]), PATHINFO_EXTENSION);
        $currentSeconds = round(microtime(true) * 1000);
        $targetFile = $targetDir . $fileName.'_'.$currentSeconds.'.'.$fileType;
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"][$i], $targetFile)) {

            if($_POST['docType']=='dob'){
                array_push($arrayUploaded,'includes/'.$targetFile."||dob");  
            }else{
                array_push($arrayUploaded,'includes/'.$targetFile."||address");  
            }

            // if (in_array($fileType, $excelArr)) {
            //     array_push($arrayUploaded,'includes/uploads/'.$targetFile."||xlsx.png");                
            // }elseif(in_array($fileType, $pdfArr)){
            //     array_push($arrayUploaded,'includes/uploads/'.$targetFile."||pdf.png");
            // }elseif(in_array($fileType, $docArr)){
            //     array_push($arrayUploaded,'includes/uploads/'.$targetFile."||docx.png");                
            // }
        }
    }

    $selectQry=mysqli_query($connection,"SELECT st_unique_id,st_doc_names FROM `student_docs` WHERE `st_unique_id`='$enrollId'");
    $rows=mysqli_num_rows($selectQry);
    if($rows==0){
        $qry=mysqli_query($connection,"INSERT INTO `student_docs` (`st_unique_id`,`st_doc_names`) VALUES('$enrollId','".json_encode($arrayUploaded)."')");
        $inserted=mysqli_insert_id($connection);
        if($inserted!=''){
            // echo json_encode($arrayUploaded);
            echo 1;
        }else{
            echo 0; 
        }
    }else{
        $selectQryRes=mysqli_fetch_array($selectQry);
        $fetchArray=array_merge(json_decode($selectQryRes['st_doc_names']),$arrayUploaded);

        // if(($key = array_search(4, $array1)) !== false) {
        //     unset($array1[$key]);
        // }

        $qry=mysqli_query($connection,"UPDATE `student_docs` SET `st_modified_date`='".date('Y-m-d')."',`st_doc_names`= '".json_encode($fetchArray)."' WHERE `st_unique_id`='$enrollId'");
        if($qry){
            echo 1;
            // echo json_encode($fetchArray);
        }else{
            echo 0; 
        }
    }
}

if(@$_POST['formName']=='deleteProof'){
    $enrolid=$_POST['enrolID'];
    $delType=$_POST['delType'];
    $arrayUploaded=array();
    if($delType=='dob_del'){
        $type="dob";
    }else{
        $type="address";
    }
    
    // echo "SELECT st_unique_id,st_doc_names FROM `student_docs` WHERE `st_unique_id`='$enrolid'"
    $selectQry=mysqli_query($connection,"SELECT st_unique_id,st_doc_names FROM `student_docs` WHERE `st_unique_id`='$enrolid'");
    $selectQryRes=mysqli_fetch_array($selectQry);
    $fetchArray=json_decode($selectQryRes['st_doc_names']); 

      
        // if(($key = array_search($type, $fetchArray)) !== false) {

        //     unset($fetchArray[$key]);
        // }
        $keyVal=0; 
        foreach ($fetchArray as $value) {
            if (strpos($value, $type) !== false) {
                unset($fetchArray[$keyVal]);      
                $arrayUploaded=array_values($fetchArray);
            }
            $keyVal++;
        }
        

        $qry=mysqli_query($connection,"UPDATE `student_docs` SET `st_modified_date`='".date('Y-m-d')."',`st_doc_names`= '".json_encode($arrayUploaded)."' WHERE `st_unique_id`='$enrolid'");
        if($qry){
            echo 1;
            // echo json_encode($fetchArray);
        }else{
            echo 0; 
        }


}

?>

<?php 

if(@$_POST['formName']=='uploadExcel'){
    
require 'vendor/autoload.php'; 


    $targetDir = "uploads/attendance/"; // Adjust the directory as needed
    $targetFile = $targetDir . basename($_FILES["fileUpload"]["name"]);
    $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
    $uploadOk = 1;

    // Check if the file is an Excel file
    if ($fileType != "xlsx" && $fileType != "xls") {
        echo "Only Excel files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $targetFile)) {
            // echo "The file " . basename($_FILES["fileUpload"]["name"]) . " has been uploaded.";

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetFile);
            $worksheet = $spreadsheet->getActiveSheet();

            $headers = [];
            $cellIterator = $worksheet->getRowIterator()->current()->getCellIterator();
            foreach ($cellIterator as $cell) {
                $headers[] = $cell->getValue();
            }
            $tbody='';
            foreach ($worksheet->getRowIterator(2) as $row) { 
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                $unixTimestamp = ($data[2] - 25569) * 86400; 
                if($data[0]!='' && $data[1]!='' ){
                    $tbody.='<tr>';
                    $tbody.='<td>'.$data[0].'</td>';
                    $tbody.='<td>'.$data[1].'</td>';
                    $tbody.='<td>'.date('m-d-Y',$unixTimestamp).'</td>';

                    // $sql = "INSERT INTO student_attendance (" . implode(", ", $headers) . ") VALUES ('" . implode("', '", $data) . "')";
                    $sql = "INSERT INTO student_attendance (`st_unique_id`,`st_course_unit`,`st_unit_date`) VALUES ('".$data[0]."','".$data[1]."','".date('Y-m-d',$unixTimestamp)."')";
                    if ($connection->query($sql) !== TRUE) {
                        echo "Error: " . $connection->error;
                    }
                    $tbody.='</tr>';
                }
            }
            echo $tbody;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

$connection->close();

}


?>
