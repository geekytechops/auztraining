<?php 
require('dbconnect.php');
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

// use TCPDF;

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

if(@$_POST['formName']=='phoneNumberCheck'){
    
    $number=$_POST['number'];
    $memberName=$_POST['memberName'];
    $enquiryFor=$_POST['enquiryFor'];    
    $check_update=$_POST['check_update'];    
    $oldenquiryFor=$_POST['oldenquiryFor'];    
    $oldNumber=$_POST['oldNumber'];   
    $updateCheck=0; 

    if($check_update!=0){

        if($oldenquiryFor!=$enquiryFor || $oldNumber!=$number){

            $checkPh=1;

            $updateCheck=1;

        }else{

            $checkPh=0;

        }

    }else{

        $checkPh=1;

    }


    if($checkPh==1){


        if($enquiryFor==1){


            if($updateCheck==0){


                $query2=mysqli_query($connection,"SELECT st_enquiry_id FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_phno` LIKE '%$number%' and `st_name` LIKE '$memberName'");

                // echo "SELECT * FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_phno` LIKE '%$number%' and st_enquiry_for=1";
                if(mysqli_num_rows($query2)==0){
                     echo 0;
                }else{
                    $query2Res=mysqli_fetch_array($query2);
                     echo '1||'.$query2Res['st_enquiry_id'];
                }

            }else{

                $query2=mysqli_query($connection,"SELECT st_enquiry_id FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_phno` LIKE '%$number%' and st_name='$memberName'");
                if(mysqli_num_rows($query2)==0){
                     echo 0;
                }else{
                    $query2Res=mysqli_fetch_array($query2);
                     echo '1||'.$query2Res['st_enquiry_id'];
                }

            }

        }else{
    
            if($updateCheck==0){


                $query2=mysqli_query($connection,"SELECT st_enquiry_id FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_phno` LIKE '%$number%' and `st_name` LIKE '$memberName'");

                // echo "SELECT * FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_phno` LIKE '%$number%' and st_enquiry_for=1";
                if(mysqli_num_rows($query2)==0){
                     echo 0;
                }else{
                    $query2Res=mysqli_fetch_array($query2);
                    echo '1||'.$query2Res['st_enquiry_id'];
                }

            }else{

                $query2=mysqli_query($connection,"SELECT st_enquiry_id FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_phno` LIKE '%$number%' and st_name='$memberName'");
                if(mysqli_num_rows($query2)==0){
                     echo 0;
                }else{
                    $query2Res=mysqli_fetch_array($query2);
                    echo '1||'.$query2Res['st_enquiry_id'];
                }

            }
    
        }

    }else{

        echo 0;

    }

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
    $courses=json_encode($_POST['courses']);
    $checkId=$_POST['checkId'];

    $surname=$_POST['surname'];
    $suburb=$_POST['suburb'];
    $prefComment=$_POST['prefComment'];
    $stuState=$_POST['stuState'];
    $postCode=$_POST['postCode'];
    $visit_before=$_POST['visit_before'];
    $hear_about=$_POST['hear_about'];
    $hearedby=$_POST['hearedby'];
    $plan_to_start_date=$_POST['plan_to_start_date'];
    $refer_select=$_POST['refer_select'];
    $referer_name=$_POST['referer_name'];
    $refer_alumni=$_POST['refer_alumni'];
    $streetDetails=$_POST['streetDetails'];
    $created_by=$_POST['admin_id'];
    $form_type=$_POST['form_type'];

    $query=mysqli_query($connection,"INSERT INTO student_enquiry(st_name,st_member_name,st_phno,st_email,st_course,st_surname,st_suburb,st_state,st_post_code,st_visited,st_heared,st_hearedby,st_startplan_date,st_refered,st_refer_name,st_refer_alumni,st_street_details,st_enquiry_for,st_pref_comments,st_created_by,st_gen_enq_type)VALUES('$studentName','$memberName','$contactName','$emailAddress','$courses','$surname','$suburb','$stuState',$postCode,$visit_before,'$hear_about','$hearedby','$plan_to_start_date',$refer_select,'$referer_name',$refer_alumni,'$streetDetails',$enquiryFor,'$prefComment',$created_by,$form_type)");

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
$courses=json_encode($_POST['courses']);
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
$hearedby=$_POST['hearedby'];
$plan_to_start_date=$_POST['plan_to_start_date'];
$refer_select=$_POST['refer_select'];
$referer_name=$_POST['referer_name'];
$refer_alumni=$_POST['refer_alumni'];
$visaCondition=$_POST['visaCondition'];
$comments=$_POST['comments'];
$prefComment=$_POST['prefComment'];
$appointment_booked=$_POST['appointment_booked'];
if(@$_POST['remarks'] && $_POST['remarks']!=''){
    $remarks=json_encode($_POST['remarks']);
    // echo $remarks;
}else{
    $remarks='';
}
$reg_grp_names=$_POST['reg_grp_names'];
$streetDetails=$_POST['streetDetails'];
$courseType=$_POST['courseType'];
$shore=$_POST['shore'];
$ethnicity=$_POST['ethnicity'];
$visaNote=$_POST['visaNote'];
$created_by=$_POST['admin_id'];
$formId=$_POST['formId'];
$slot_book_status=$_POST['slot_book_status'];
$short_grp_status=$_POST['short_grp_status'];
$rpl_status=$_POST['rpl_status'];
$reg_grp_status=$_POST['reg_grp_status'];
$now=date('Y-m-d H:i:s');

$rpl_arrays=json_decode($_POST['rpl_arrays']);
$short_grps=json_decode($_POST['short_grps']);
$slot_books=json_decode($_POST['slot_books']);

if($checkId==0){

    $query=mysqli_query($connection,"INSERT INTO student_enquiry(st_name,st_member_name,st_phno,st_email,st_course,st_fee,st_visa_status,st_visa_condition,st_visa_note,st_surname,st_suburb,st_state,st_post_code,st_visited,st_heared,st_hearedby,st_startplan_date,st_refered,st_refer_name,st_refer_alumni,st_comments,st_pref_comments,st_appoint_book,st_remarks,st_street_details,st_enquiry_for,st_enquiry_date,st_course_type,st_shore,st_ethnicity,st_created_by)VALUES('$studentName','$memberName','$contactName','$emailAddress','$courses','$payment',$visaStatus,$visaCondition,'$visaNote','$surname','$suburb','$stuState',$postCode,$visit_before,'$hear_about','$hearedby','$plan_to_start_date',$refer_select,'$referer_name',$refer_alumni,'$comments','$prefComment',$appointment_booked,'$remarks','$streetDetails',$enquiryFor,'$enquiryDate',$courseType,$shore,'$ethnicity',$created_by)");
    
    echo mysqli_error($connection);
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

            $query=mysqli_query($connection,"INSERT INTO `rpl_enquries` (`enq_form_id`,`rpl_exp_in`,`rpl_exp_role`,`rpl_exp_years`,`rpl_exp_docs`,`rpl_exp_prev_qual`,`rpl_exp_qual_name`,`rpl_exp`) VALUES( $lastId,'".$rpl_arrays->exp_in."','".$rpl_arrays->exp_name."','".$rpl_arrays->exp_years."','".$rpl_arrays->exp_docs."','".$rpl_arrays->exp_prev."','".$rpl_arrays->exp_prev_name."','".$rpl_arrays->rpl_exp."' )");

        }else if($courseType==5 || $courseType==4){
         
            
            $query=mysqli_query($connection,"INSERT INTO `short_group_form` (`enq_form_id`) VALUES( $lastId )");

            $query2=mysqli_query($connection,"UPDATE `short_group_form` SET `sh_org_name`='$short_grps->short_grp_org_name',`sh_grp_org_type`='$short_grps->short_grp_org_type',`sh_grp_campus`='$short_grps->short_grp_campus',`sh_grp_date`='$short_grps->short_grp_date',`sh_grp_num_stds`='$short_grps->short_grp_num_std',`sh_grp_ind_exp`='$short_grps->short_grp_ind_exp',`sh_grp_train_bef`='$short_grps->short_grp_before',`sh_grp_con_us`='$short_grps->short_grp_con_type',`sh_grp_phone`='$short_grps->short_grp_con_num',`sh_grp_name`='$short_grps->short_grp_con_name',`sh_grp_email`='$short_grps->short_grp_con_email' WHERE `enq_form_id`=$lastId");


        }else if($courseType==3){        

            $query=mysqli_query($connection,"INSERT INTO `regular_group_form` (`enq_form_id`,`reg_grp_names`) VALUES($lastId,'".$reg_grp_names."')");

        }


        if($appointment_booked==1){

            $appointment_booked_time=date('Y-m-d H:i:s',strtotime($slot_books->slot_book_time));

            $query=mysqli_query($connection,"INSERT INTO `slot_book` (`enq_form_id`,`slot_bk_datetime`,`slot_bk_purpose`,`slot_bk_on`,`slot_book_by`,`slot_book_email_link`) VALUES( $lastId,'".$appointment_booked_time."','".$slot_books->slot_book_purpose."','".$slot_books->slot_book_date."','".$slot_books->slot_book_by."',".$slot_books->slot_book_link." )");
        }        

    }

}else{
    
    if(mysqli_query($connection,"UPDATE student_enquiry SET `st_name`='$studentName',`st_member_name`='$memberName' ,`st_phno`='$contactName',`st_email`='$emailAddress',`st_course`='$courses',`st_fee`='$payment',`st_visa_status`=$visaStatus,`st_visa_condition`=$visaCondition ,`st_visa_note`='$visaNote', `st_surname`='$surname' , `st_suburb`= '$suburb' , `st_state`='$stuState',`st_post_code`= $postCode,`st_visited`=$visit_before,`st_heared`='$hear_about',`st_hearedby`='$hearedby',`st_startplan_date`='$plan_to_start_date',`st_refered`=$refer_select,`st_refer_name`='$referer_name',`st_refer_alumni`=$refer_alumni,`st_comments`='$comments',`st_pref_comments`='$prefComment',`st_appoint_book`= $appointment_booked,`st_remarks`='$remarks',`st_street_details`= '$streetDetails' , `st_enquiry_for`= $enquiryFor , `st_enquiry_date`='$enquiryDate' ,`st_course_type`=$courseType , `st_shore`=$shore,`st_ethnicity`='$ethnicity',`st_modified_by`= $created_by , `st_modified_date`='$now'  WHERE `st_id`=$checkId")){        

        // insert course Type data
        if($courseType==1){

            if($rpl_status==1){

            $query=mysqli_query($connection,"UPDATE `rpl_enquries` set `rpl_exp_in` ='$rpl_arrays->exp_in' ,`rpl_exp_role` ='$rpl_arrays->exp_name' ,`rpl_exp_years` = '$rpl_arrays->exp_years',`rpl_exp_docs` ='$rpl_arrays->exp_docs' ,`rpl_exp_prev_qual` ='$rpl_arrays->exp_prev' ,`rpl_exp_qual_name` ='$rpl_arrays->exp_prev_name' ,`rpl_exp` ='$rpl_arrays->rpl_exp' WHERE `enq_form_id` = $formId");

            // echo "UPDATE `rpl_enquries` set `rpl_exp_in` ='$rpl_arrays->exp_in' ,`rpl_exp_role` ='$rpl_arrays->exp_name' ,`rpl_exp_years` = '$rpl_arrays->exp_years',`rpl_exp_docs` ='$rpl_arrays->exp_docs' ,`rpl_exp_prev_qual` ='$rpl_arrays->exp_prev' ,`rpl_exp_qual_name` ='$rpl_arrays->exp_prev_name' ,`rpl_exp` ='$rpl_arrays->rpl_exp' WHERE `enq_form_id` = $formId";

        }else{

            $query=mysqli_query($connection,"INSERT INTO `rpl_enquries` (`enq_form_id`,`rpl_exp_in`,`rpl_exp_role`,`rpl_exp_years`,`rpl_exp_docs`,`rpl_exp_prev_qual`,`rpl_exp_qual_name`,`rpl_exp`) VALUES( $formId,'".$rpl_arrays->exp_in."','".$rpl_arrays->exp_name."','".$rpl_arrays->exp_years."','".$rpl_arrays->exp_docs."','".$rpl_arrays->exp_prev."','".$rpl_arrays->exp_prev_name."','".$rpl_arrays->rpl_exp."' )");


        }

        }else if($courseType==5 || $courseType==4){

            if($short_grp_status==1){
                     
                    $query=mysqli_query($connection,"UPDATE `short_group_form` SET `sh_org_name`='$short_grps->short_grp_org_name',`sh_grp_org_type`='$short_grps->short_grp_org_type',`sh_grp_campus`='$short_grps->short_grp_campus',`sh_grp_date`='$short_grps->short_grp_date',`sh_grp_num_stds`='$short_grps->short_grp_num_std',`sh_grp_ind_exp`='$short_grps->short_grp_ind_exp',`sh_grp_train_bef`='$short_grps->short_grp_before',`sh_grp_con_us`='$short_grps->short_grp_con_type',`sh_grp_phone`='$short_grps->short_grp_con_num',`sh_grp_name`='$short_grps->short_grp_con_name',`sh_grp_email`='$short_grps->short_grp_con_email' WHERE `enq_form_id`=$formId");

            }else{

                $query=mysqli_query($connection,"INSERT INTO `short_group_form` (`enq_form_id`) VALUES( $formId )");

                $query2=mysqli_query($connection,"UPDATE `short_group_form` SET `sh_org_name`='$short_grps->short_grp_org_name',`sh_grp_org_type`='$short_grps->short_grp_org_type',`sh_grp_campus`='$short_grps->short_grp_campus',`sh_grp_date`='$short_grps->short_grp_date',`sh_grp_num_stds`='$short_grps->short_grp_num_std',`sh_grp_ind_exp`='$short_grps->short_grp_ind_exp',`sh_grp_train_bef`='$short_grps->short_grp_before',`sh_grp_con_us`='$short_grps->short_grp_con_type',`sh_grp_phone`='$short_grps->short_grp_con_num',`sh_grp_name`='$short_grps->short_grp_con_name',`sh_grp_email`='$short_grps->short_grp_con_email' WHERE `enq_form_id`=$formId");

            }

        }

        else if($courseType==3){

            if($reg_grp_status==1){

                $query=mysqli_query($connection,"UPDATE `regular_group_form` SET `reg_grp_names`='".$reg_grp_names."' WHERE `enq_form_id`=$formId");

            }else{

                $query=mysqli_query($connection,"INSERT INTO `regular_group_form` (`enq_form_id`,`reg_grp_names`) VALUES($formId,'".$reg_grp_names."')");

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
    $tableName=$_POST['tableName'];
    $primId=$_POST['colPrefix'].'_id';
    $delColName=$_POST['colPrefix'].'_delete_note';
    $colPrefix=$_POST['colPrefix'].'_enquiry_status';

    $query=mysqli_query($connection,"UPDATE $tableName SET `$delColName`='$note' , `$colPrefix`=1 WHERE `$primId`=$enq_id");
    // echo "UPDATE $tableName SET `$delColName`='$note' , `$colPrefix`=1 WHERE `$primId`=$enq_id";
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

if(@$_POST['formName']=='student_filter'){

    $visa_status=$_POST['visa_status'];
    $appointment_status=$_POST['appointment_status'];
    $course_type_status=$_POST['course_type_status'];
    $state_status=$_POST['state_status'];
    $WHERE='';    

    if($visa_status!=0){
        $WHERE.=" AND st_visa_condition=$visa_status";
    }

    if($appointment_status!=0){
        $WHERE.=" AND st_appoint_book=$appointment_status";
    }
    
    if($course_type_status!=0){
        $WHERE.=" AND st_course_type=$course_type_status";
    }

    if($state_status!=0){
        $WHERE.=" AND st_state=$state_status";
    }



    $filterQuery="SELECT * FROM `student_enquiry` WHERE st_enquiry_status=0 $WHERE";

    $filterQueryget=mysqli_query($connection,$filterQuery);
    $tbody='';



if(mysqli_num_rows($filterQueryget)!=0){

    while($filterQueryRes=mysqli_fetch_array($filterQueryget)){

        $tbody.='<tr>';

        $coursesNames=json_decode($filterQueryRes['st_course']);
        $coursesName='<div class="td_scroll_height">';
        foreach($coursesNames as $value){
            $courses=mysqli_fetch_array(mysqli_query($connection,"SELECT * from courses where course_status!=1 AND course_id=".$value));
            $coursesName.= $courses['course_sname'].'-'.$courses['course_name']." , <br>"; 
        }

        $st_states=['--select--','NSW - New South Wales','VIC - Victoria','ACT - Australian Capital Territory','NT - Northern Territoy','WA - Western Australia','QLD - Queensland','SA - South Australia','TAS - Tasmania'];
        $state_name= $st_states[$filterQueryRes['st_state']];
        
        $st_course_type=['-','Rpl','Regular','Regular - Group','Short courses','Short course - Group'];
        $courseTypeId=$filterQueryRes['st_course_type'];
    
        $coursesNamePos = strrpos($coursesName, ',');
        $coursesName = substr($coursesName, 0, $coursesNamePos);
        $coursesName.='</div>';
    
        $visited=$filterQueryRes['st_visited']==1 ? 'Visited' : ( $filterQueryRes['st_visited']==2 ? 'Not Visited' : ' - ' ) ;
        
        $visastatus=$filterQueryRes['st_visa_condition']==1 ? 'Approved' : 'Not Approved' ;
    
        $refered_names = $filterQueryRes['st_refer_name'];
    
        $startPlanDate=date('d M Y',strtotime($filterQueryRes['st_startplan_date']));
    
        $staff_comments=$filterQueryRes['st_comments'];
        $preference=$filterQueryRes['st_pref_comments'];
    
        $st_remarks=['--select--','Seems to be interested to do course and need to contact asap','contacted and followed','Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose'];    
    
        if($filterQueryRes['st_remarks']!=''){
            $remarksNotes='<div class="td_scroll_height">';
    
        foreach(json_decode($filterQueryRes['st_remarks']) as $remark  ){                   
            
            $remarksNotes.=$st_remarks[$remark].' , <br>';
    
        }
        $remarksNotes.='</div>';
        }else{
            $remarksNotes=' - ';
            
        }
    
        $street=$filterQueryRes['st_street_details'];
        $suburb=$filterQueryRes['st_suburb'];
        $post_code=$filterQueryRes['st_post_code'];
        $appointment=$filterQueryRes['st_appoint_book']==1 ? 'Booked' : ( $filterQueryRes['st_appoint_book']==2 ? 'Not Booked' : ' - ' );
        
        $querys2=mysqli_query($connection,"select visa_status_name from `visa_statuses` WHERE visa_id=".$filterQueryRes['st_visa_status']);
        if(mysqli_num_rows($querys2)!=0){
        $visaCondition=mysqli_fetch_array($querys2);
    
        if(@$visaCondition['visa_status_name'] && $visaCondition['visa_status_name']!=''){
            $visacCond=$visaCondition['visa_status_name'];
        }else{
            $visacCond=' - ';
        }
        }else{
            $visacCond=' - ';
        }

        $appointment=$filterQueryRes['st_appoint_book']==1 ? 'Booked' : ( $filterQueryRes['st_appoint_book']==2 ? 'Not Booked' : ' - ' );

        $dateCreated=date('d M Y',strtotime($filterQueryRes['st_enquiry_date']));
        
    
            $view='<a class="btn btn-outline-primary btn-sm edit_enq" style="margin-right:10px;" href="student_enquiry.php?eq='.base64_encode($filterQueryRes['st_id']).'">Edit</a><button onclick="delete_enq(\'student_enquiry\',\'st\','.$filterQueryRes['st_id'].')" type="button" class="btn btn-outline-danger btn-sm">Delete</button>';


            $tbody.='<td>'.$filterQueryRes['st_enquiry_id'].'</td>
                    <td>'.$filterQueryRes['st_name'].'</td>
                    <td>'.$filterQueryRes['st_phno'].'</td>
                    <td>'.$filterQueryRes['st_email'].'</td>
                    <td>'.$street.'</td>
                    <td>'.$suburb.'</td>
                    <td>'.$state_name.'</td>
                    <td>'.$post_code.'</td>
                    <td>'.$coursesName.'</td>
                    <td>'.$startPlanDate.'</td>
                    <td>'.$st_course_type[$courseTypeId].'</td>
                    <td>'.$visited.'</td>
                    <td>'.$dateCreated.'</td>
                    <td>'.$refered_names.'</td>
                    <td>'.$filterQueryRes['st_fee'].'</td>
                    <td>'.$appointment.'</td>
                    <td>'.$visacCond.'</td>
                    <td>'.$visastatus.'</td></tr>';
    
            // array_push($enquiries['data'],array('st_enquiry_id'=>$filterQueryRes['st_enquiry_id'],'std_name'=>$filterQueryRes['st_name'], 'std_phno'=>$filterQueryRes['st_phno'],'std_email'=>$filterQueryRes['st_email'],'street'=>$street,'suburb'=>$suburb,'post_code'=>$post_code,'std_course'=>$coursesName,'startplan_date'=>$startPlanDate,'referedby'=>$refered_names,'visited'=>$visited,'st_coursetype'=>$st_course_type[$courseTypeId],'std_fee'=>$filterQueryRes['st_fee'],'appointment'=>$appointment,'Visa_condition'=>$visacCond,'std_visa_status'=>$visastatus));
            
        }

        echo $tbody;
    }else{
        echo "<tr><td>No Records</td></tr>";
    }


    
}
if(@$_POST['formName']=='followup_call'){
  
        $student_name=$_POST['student_name'];
        $date=$_POST['date'];
        $contacted_person=$_POST['contacted_person'];
        $contacted_time=date('Y-m-d H:i:s',strtotime($_POST['contacted_time']));
        $contactMode=$_POST['contactMode'];
        $progress_status=$_POST['progress_status'];
        $contact_num=$_POST['contact_num'];
        $enquiry_id=$_POST['enquiry_id'];
        $checkId=$_POST['checkId'];
        if(@$_POST['remarks'] && $_POST['remarks']!=''){
        $remarks=json_encode($_POST['remarks']);
        }else{
            $remarks='';
        }
        $comments=mysqli_real_escape_string($connection,$_POST['comments']);
        $admin_id=$_POST['admin_id'];


        if($checkId==0){

            $query=mysqli_query($connection,"INSERT INTO followup_calls(`enquiry_id`,`flw_name`,`flw_phone`,`flw_contacted_person`,`flw_contacted_time`,`flw_date`,`flw_remarks`,`flw_comments`,`flw_mode_contact`,`flw_created_by`)VALUES('$enquiry_id','$student_name','$contact_num','$contacted_person','$contacted_time','$date','$remarks','$comments','$contactMode',$admin_id)");
            $lastId=mysqli_insert_id($connection);
    
            if($lastId!=''){
                echo "1";
            }else{
                echo "0";
            }

        }else{

            $dates=date('Y-m-d H:i:s');

            $query=mysqli_query($connection,"UPDATE followup_calls SET `enquiry_id`='$enquiry_id',`flw_progress_state`='$progress_status',`flw_name`='$student_name',`flw_phone`='$contact_num',`flw_contacted_person`='$contacted_person',`flw_contacted_time`='$contacted_time',`flw_date`='$date',`flw_remarks`='$remarks',`flw_comments`='$comments',`flw_mode_contact`='$contactMode',`flw_modified_date`='$dates',`flw_modifiedby`=$admin_id WHERE `flw_id`=$checkId");

            if($query){
                echo "1";
            }else{
                echo "0";
            }

        }



}
if(@$_POST['formName']=='counseling_form'){
  
        $vaccine_status=$_POST['vaccine_status'];
        $job_nature=$_POST['job_nature'];
        $module_result=$_POST['module_result'];
        $counseling_timing=date('Y-m-d H:i:s',strtotime($_POST['counseling_timing']));
        $counseling_end_timing= $_POST['counseling_end_timing']!='' ? date('Y-m-d H:i:s',strtotime($_POST['counseling_end_timing'])) : '';
        $pref_comment=$_POST['pref_comment'];
        $eng_rate=$_POST['eng_rate'];
        $mig_test=$_POST['mig_test'];
        $overall_result=$_POST['overall_result'];
        $course=$_POST['course'];
        $university_name=$_POST['university_name'];
        $enquiry_id=$_POST['enquiry_id'];
        $qualification=$_POST['qualification'];
        $counseling_type=$_POST['counseling_type'];
        $member_name=$_POST['member_name'];
        $aus_duration=$_POST['aus_duration'];
        $visa_condition=$_POST['visa_condition'];
        $education=$_POST['education'];
        $aus_study=$_POST['aus_study'];
        $work_status=$_POST['work_status'];
        $checkId=$_POST['checkId'];       


        if(@$_POST['remarks'] && $_POST['remarks']!=''){
        $remarks=json_encode($_POST['remarks']);
        }else{
            $remarks='';
        }

        $admin_id=$_POST['admin_id'];


    if($checkId==0){

        $query=mysqli_query($connection,"INSERT INTO counseling_details(`st_enquiry_id`,`counsil_mem_name`,`counsil_vaccine_status`,`counsil_job_nature`,`counsil_module_result`,`counsil_timing`,`counsil_end_time`,`counsil_pref_comments`,`counsil_eng_rate`,`counsil_migration_test`,`counsil_overall_result`,`counsil_course`,`counsil_university`,`counsil_qualification`,`counsil_type`,`counsil_aus_stay_time`,`counsil_visa_condition`,`counsil_education`,`counsil_aus_study_status`,`counsil_work_status`,`counsil_remarks`,`counsil_createdby`)VALUES('$enquiry_id','$member_name',$vaccine_status,'$job_nature','$module_result','$counseling_timing','$counseling_end_timing','$pref_comment','$eng_rate',$mig_test,'$overall_result','$course','$university_name','$qualification',$counseling_type,'$aus_duration',$visa_condition,'$education',$aus_study,$work_status,'$remarks',$admin_id)");
        $lastId=mysqli_insert_id($connection);

        if($lastId!=''){
            echo "1";
        }else{
            echo "0";
        }


    }else{


        $mod_date=date('Y-m-d');

        $query=mysqli_query($connection,"UPDATE counseling_details SET `counsil_mem_name`='$member_name' , `counsil_vaccine_status` = $vaccine_status,`counsil_job_nature`= '$job_nature',`counsil_module_result`= '$module_result',`counsil_timing`='$counseling_timing',`counsil_end_time`='$counseling_end_timing',`counsil_pref_comments`='$pref_comment',`counsil_eng_rate`='$eng_rate',`counsil_migration_test`=$mig_test,`counsil_overall_result`='$overall_result',`counsil_course`='$course',`counsil_university`='$university_name',`counsil_qualification`='$qualification',`counsil_type`=$counseling_type,`counsil_aus_stay_time`='$aus_duration',`counsil_visa_condition`=$visa_condition,`counsil_education`='$education',`counsil_aus_study_status`=$aus_study,`counsil_work_status`=$work_status,`counsil_remarks`='$remarks',`counsil_modified_date`='$mod_date',`counsil_modified_by`=$admin_id WHERE `st_enquiry_id`='$enquiry_id'" );

        if($query){
            echo "1";
        }else{
            echo "0";
        }

    }




}


if(@$_POST['formName']=='date_filter'){

    if($_POST['from_date']>$_POST['to_date']){
        $from_date=$_POST['to_date'];
        $to_date=$_POST['from_date'];
    }else{
        $from_date=$_POST['from_date'];
        $to_date=$_POST['to_date'];
    }

    $WHERE='';        
    $WHERE.=" AND created_date between '$from_date' AND '$to_date'";
    
    $filterQuery="SELECT * FROM `student_enquiry` WHERE st_enquiry_status=0 $WHERE";

    // echo $filterQuery;

    $filterQueryget=mysqli_query($connection,$filterQuery);
    $tbody='';



if(mysqli_num_rows($filterQueryget)!=0){

    while($filterQueryRes=mysqli_fetch_array($filterQueryget)){

        $tbody.='<tr>';

        $coursesNames=json_decode($filterQueryRes['st_course']);
        $coursesName='<div class="td_scroll_height">';
        foreach($coursesNames as $value){
            $courses=mysqli_fetch_array(mysqli_query($connection,"SELECT * from courses where course_status!=1 AND course_id=".$value));
            $coursesName.= $courses['course_sname'].'-'.$courses['course_name']." , <br>"; 
        }

        $st_states=['--select--','NSW - New South Wales','VIC - Victoria','ACT - Australian Capital Territory','NT - Northern Territoy','WA - Western Australia','QLD - Queensland','SA - South Australia','TAS - Tasmania'];
        $state_name= $st_states[$filterQueryRes['st_state']];
        
        $st_course_type=['-','Rpl','Regular','Regular - Group','Short courses','Short course - Group'];
        $courseTypeId=$filterQueryRes['st_course_type'];
    
        $coursesNamePos = strrpos($coursesName, ',');
        $coursesName = substr($coursesName, 0, $coursesNamePos);
        $coursesName.='</div>';
    
        $visited=$filterQueryRes['st_visited']==1 ? 'Visited' : ( $filterQueryRes['st_visited']==2 ? 'Not Visited' : ' - ' ) ;
        
        $visastatus=$filterQueryRes['st_visa_condition']==1 ? 'Approved' : 'Not Approved' ;
    
        $refered_names = $filterQueryRes['st_refer_name'];
    
        $startPlanDate=date('d M Y',strtotime($filterQueryRes['st_startplan_date']));
    
        $staff_comments=$filterQueryRes['st_comments'];
        $preference=$filterQueryRes['st_pref_comments'];
    
        $st_remarks=['--select--','Seems to be interested to do course and need to contact asap','contacted and followed','Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose'];    
    
        if($filterQueryRes['st_remarks']!=''){
            $remarksNotes='<div class="td_scroll_height">';
    
        foreach(json_decode($filterQueryRes['st_remarks']) as $remark  ){                   
            
            $remarksNotes.=$st_remarks[$remark].' , <br>';
    
        }
        $remarksNotes.='</div>';
        }else{
            $remarksNotes=' - ';
            
        }
    
        $street=$filterQueryRes['st_street_details'];
        $suburb=$filterQueryRes['st_suburb'];
        $post_code=$filterQueryRes['st_post_code'];
        $appointment=$filterQueryRes['st_appoint_book']==1 ? 'Booked' : ( $filterQueryRes['st_appoint_book']==2 ? 'Not Booked' : ' - ' );
        
        $querys2=mysqli_query($connection,"select visa_status_name from `visa_statuses` WHERE visa_id=".$filterQueryRes['st_visa_status']);
        if(mysqli_num_rows($querys2)!=0){
        $visaCondition=mysqli_fetch_array($querys2);
    
        if(@$visaCondition['visa_status_name'] && $visaCondition['visa_status_name']!=''){
            $visacCond=$visaCondition['visa_status_name'];
        }else{
            $visacCond=' - ';
        }
        }else{
            $visacCond=' - ';
        }

        $appointment=$filterQueryRes['st_appoint_book']==1 ? 'Booked' : ( $filterQueryRes['st_appoint_book']==2 ? 'Not Booked' : ' - ' );

        $dateCreated=date('d M Y',strtotime($filterQueryRes['st_enquiry_date']));
        
    
            $view='<a class="btn btn-outline-primary btn-sm edit_enq" style="margin-right:10px;" href="student_enquiry.php?eq='.base64_encode($filterQueryRes['st_id']).'">Edit</a><button onclick="delete_enq(\'student_enquiry\',\'st\','.$filterQueryRes['st_id'].')" type="button" class="btn btn-outline-danger btn-sm">Delete</button>';


            $tbody.='<td>'.$filterQueryRes['st_enquiry_id'].'</td>
                    <td>'.$filterQueryRes['st_name'].'</td>
                    <td>'.$filterQueryRes['st_phno'].'</td>
                    <td>'.$filterQueryRes['st_email'].'</td>
                    <td>'.$street.'</td>
                    <td>'.$suburb.'</td>
                    <td>'.$state_name.'</td>
                    <td>'.$post_code.'</td>
                    <td>'.$coursesName.'</td>
                    <td>'.$startPlanDate.'</td>
                    <td>'.$st_course_type[$courseTypeId].'</td>
                    <td>'.$visited.'</td>
                    <td>'.$dateCreated.'</td>
                    <td>'.$refered_names.'</td>
                    <td>'.$filterQueryRes['st_fee'].'</td>
                    <td>'.$appointment.'</td>
                    <td>'.$visacCond.'</td>
                    <td>'.$visastatus.'</td></tr>';
            
        }

        echo $tbody;
    }else{
        echo "<tr><td>No Records</td></tr>";
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

if (@$_POST['formName'] == 'student_enrols') {
    $formData = json_decode($_POST['details']);
    $uploadDir = 'uploads/';
    $uploadedFiles = [];

    // Handle multiple file uploads
    if (!empty($_FILES['image']['name'][0])) {
        foreach ($_FILES['image']['name'] as $key => $fileName) {
            $tmpName = $_FILES['image']['tmp_name'][$key];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueName = rand(1000, 1000000) . '_' . time() . '.' . strtolower($fileExt);
            $targetPath = $uploadDir . $uniqueName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $uploadedFiles[] = $uniqueName;
            }
        }
    }

    // Store uploaded filenames as JSON
    $photo = json_encode($uploadedFiles);

    // --- Other field assignments ---
    $enquiry_id = $formData->enquiry_id;
    $rto_name = $formData->rto_name;
    $courses = json_encode($formData->courses);
    $branch_name = $formData->branch_name;
    $given_name = $formData->given_name;
    $surname = $formData->surname;
    $dob = $formData->dob;
    $birth_country = $formData->birth_country;
    $street_details = $formData->street_details;
    $sub_urb = $formData->sub_urb;
    $post_code = $formData->post_code;
    $tel_num = $formData->tel_num;
    $mobile_num = $formData->mobile_num;
    $emailAddress = $formData->emailAddress;
    $stu_state = $formData->stu_state;
    $em_full_name = $formData->em_full_name;
    $em_relation = $formData->em_relation;
    $em_mobile_num = $formData->em_mobile_num;
    $em_agree_check = $formData->em_agree_check;
    $usi_id = $formData->usi_id;
    $emp_status = $formData->emp_status;
    $self_status = $formData->self_status;
    $st_citizen = $formData->st_citizen;
    $highest_school = $formData->highest_school;
    $study_reason = $formData->study_reason;
    $study_reason_other = $formData->study_reason_other;
    $gender_check = $formData->gender_check;
    $cred_tansf = $formData->cred_tansf;
    $sec_school = $formData->sec_school;
    $born_country = $formData->born_country;
    $origin = $formData->origin;
    $lan_spoken = $formData->lan_spoken;
    $disability = $formData->disability;
    $qual_1 = $formData->qual_1;
    $qual_2 = $formData->qual_2;
    $qual_3 = $formData->qual_3;
    $qual_4 = $formData->qual_4;
    $qual_5 = $formData->qual_5;
    $qual_6 = $formData->qual_6;
    $qual_7 = $formData->qual_7;
    $qual_8 = $formData->qual_8;
    $qual_9 = $formData->qual_9;
    $qual_10 = $formData->qual_10;
    $st_born_country = $formData->st_born_country;
    $qual_name_8_other = $formData->qual_name_8_other;
    $qual_name_9_other = $formData->qual_name_9_other;
    $qual_name_10_other = $formData->qual_name_10_other;
    $lan_spoken_other = $formData->lan_spoken_other;
    $st_disability_type = json_encode($formData->st_disability_type);
    $disability_type_other = $formData->disability_type_other;
    $admin_id = $_SESSION['user_id'];

    // --- Insert query ---
    $query = "INSERT INTO `student_enrolments`
    (`st_unique_id`, `st_enquiry_id`, `st_rto_name`, `st_courses`, `st_branch`, `st_photo`,
     `st_given_name`, `st_surname`, `st_dob`, `st_country_birth`, `st_street`, `st_suburb`,
     `st_state`, `st_post_code`, `st_tel_num`, `st_email`, `st_mobile`, `st_emerg_name`,
     `st_emerg_relation`, `st_emerg_mobile`, `st_emerg_agree`, `st_usi`, `st_emp_status`,
     `st_self_status`, `st_citizenship`, `st_gender`, `st_credit_transfer`, `st_highest_school`,
     `st_secondary_school`, `st_born_country`, `st_born_country_other`, `st_origin`, `st_lan_spoken`,
     `st_lan_spoken_other`, `st_disability`, `st_disability_type`, `st_disability_type_other`,
     `st_study_reason`, `st_study_reason_other`, `st_qual_1`, `st_qual_2`, `st_qual_3`, `st_qual_4`,
     `st_qual_5`, `st_qual_6`, `st_qual_7`, `st_qual_8`, `st_qual_9`, `st_qual_10`, `st_qual_8_other`,
     `st_qual_9_other`, `st_qual_10_other`, `st_created_by`)
    VALUES
    ('1','$enquiry_id','$rto_name','$courses','$branch_name','$photo','$given_name','$surname',
     '$dob','$birth_country','$street_details','$sub_urb','$stu_state','$post_code','$tel_num',
     '$emailAddress','$mobile_num','$em_full_name','$em_relation','$em_mobile_num','$em_agree_check',
     '$usi_id','$emp_status','$self_status','$st_citizen','$gender_check','$cred_tansf','$highest_school',
     '$sec_school','$born_country','$st_born_country','$origin','$lan_spoken','$lan_spoken_other',
     '$disability','$st_disability_type','$disability_type_other','$study_reason','$study_reason_other',
     '$qual_1','$qual_2','$qual_3','$qual_4','$qual_5','$qual_6','$qual_7','$qual_8','$qual_9','$qual_10',
     '$qual_name_8_other','$qual_name_9_other','$qual_name_10_other',$admin_id)";

    $queryExec = mysqli_query($connection, $query);
    $lastId = mysqli_insert_id($connection);

    // Generate unique ID based on year + course name + ID
    $courseId = json_decode($courses)[0];
    $courseID = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM courses WHERE course_id=$courseId"));
    $dateYear = date('Y');
    $uniqueId = sprintf($dateYear . $courseID['course_name'] . '%04d', $lastId);

    $querys = mysqli_query($connection, "UPDATE student_enrolment SET st_unique_id='$uniqueId' WHERE st_enrol_id=$lastId");
    $error = mysqli_error($connection);

    echo ($error != '') ? 1 : $uniqueId;
}

// --- Enrolment Form Online (PDF form) ---
if (@$_POST['formName'] == 'student_enrols_online') {
    $raw = isset($_POST['details']) ? json_decode($_POST['details'], true) : array();
    if (!is_array($raw)) {
        echo json_encode(array('success' => false, 'message' => 'Invalid form data.'));
        exit;
    }
    $d = function($key, $def = '') use ($raw) {
        return isset($raw[$key]) && $raw[$key] !== '' ? $raw[$key] : $def;
    };
    $uploadDir = __DIR__ . '/../uploads/';
    $photo = '[]';
    if (!empty($_FILES['image']['name'][0])) {
        $uploadedFiles = array();
        foreach ($_FILES['image']['name'] as $key => $fileName) {
            $tmpName = $_FILES['image']['tmp_name'][$key];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueName = rand(1000, 999999) . '_' . time() . '.' . strtolower($fileExt);
            $targetPath = $uploadDir . $uniqueName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $uploadedFiles[] = $uniqueName;
            }
        }
        $photo = json_encode($uploadedFiles);
    }
    $enquiry_id = mysqli_real_escape_string($connection, $d('enquiry_id'));
    $rto_name = mysqli_real_escape_string($connection, $d('rto_name'));
    $branch_name = mysqli_real_escape_string($connection, $d('branch_name'));
    $courses = is_array($raw['courses']) ? $raw['courses'] : array();
    $coursesJson = json_encode($courses);
    $given_name = mysqli_real_escape_string($connection, $d('given_name'));
    $surname = mysqli_real_escape_string($connection, $d('surname'));
    $dob = mysqli_real_escape_string($connection, $d('dob'));
    $birth_country = mysqli_real_escape_string($connection, $d('birth_country'));
    $street_details = mysqli_real_escape_string($connection, $d('street_details'));
    $sub_urb = mysqli_real_escape_string($connection, $d('sub_urb'));
    $stu_state = mysqli_real_escape_string($connection, $d('stu_state'));
    $post_code = mysqli_real_escape_string($connection, $d('post_code'));
    $mobile_num = mysqli_real_escape_string($connection, $d('mobile_num'));
    $emailAddress = mysqli_real_escape_string($connection, $d('emailAddress'));
    $em_full_name = mysqli_real_escape_string($connection, $d('em_full_name'));
    $em_relation = mysqli_real_escape_string($connection, $d('em_relation'));
    $em_mobile_num = mysqli_real_escape_string($connection, $d('em_mobile_num'));
    $usi_id = mysqli_real_escape_string($connection, $d('usi_id'));
    $gender_check = mysqli_real_escape_string($connection, $d('gender_check'));
    $highest_school = mysqli_real_escape_string($connection, $d('highest_school'));
    $sec_school = mysqli_real_escape_string($connection, $d('sec_school'));
    $study_reason = mysqli_real_escape_string($connection, $d('study_reason'));
    $study_reason_other = mysqli_real_escape_string($connection, $d('study_reason_other'));
    $cred_tansf = mysqli_real_escape_string($connection, $d('cred_tansf'));
    $origin = mysqli_real_escape_string($connection, $d('origin'));
    $lan_spoken = mysqli_real_escape_string($connection, $d('lan_spoken'));
    $lan_spoken_other = mysqli_real_escape_string($connection, $d('lan_spoken_other'));
    $disability = mysqli_real_escape_string($connection, $d('disability'));
    $st_disability_type = isset($raw['st_disability_type']) && is_array($raw['st_disability_type']) ? json_encode($raw['st_disability_type']) : '[]';
    $disability_type_other = mysqli_real_escape_string($connection, $d('disability_type_other'));
    $emp_status = mysqli_real_escape_string($connection, $d('emp_status'));
    $admin_id = (int)($_SESSION['user_id'] ?? 0);

    $qualification_code_title = mysqli_real_escape_string($connection, $d('qualification_code_title'));
    $age_declaration_18 = (int)$d('age_declaration_18');
    $city_of_birth = mysqli_real_escape_string($connection, $d('city_of_birth'));
    $postal_same_as_above = $d('postal_same_as_above') !== '' ? (int)$d('postal_same_as_above') : 'NULL';
    $postal_address = mysqli_real_escape_string($connection, $d('postal_address'));
    $english_read_write = mysqli_real_escape_string($connection, $d('english_read_write'));
    $work_phone = mysqli_real_escape_string($connection, $d('work_phone'));
    $home_phone = mysqli_real_escape_string($connection, $d('home_phone'));
    $year_completed_school = mysqli_real_escape_string($connection, $d('year_completed_school'));
    $mode_delivery = mysqli_real_escape_string($connection, $d('mode_delivery'));
    $qualification_attained = mysqli_real_escape_string($connection, $d('qualification_attained'));
    $industry_of_work = mysqli_real_escape_string($connection, $d('industry_of_work'));
    $computer_access = mysqli_real_escape_string($connection, $d('computer_access'));
    $computer_literacy = mysqli_real_escape_string($connection, $d('computer_literacy'));
    $numeracy_skills = mysqli_real_escape_string($connection, $d('numeracy_skills'));
    $additional_support = mysqli_real_escape_string($connection, $d('additional_support'));
    $additional_support_specify = mysqli_real_escape_string($connection, $d('additional_support_specify'));
    $usi_declaration = (int)$d('usi_declaration');
    $privacy_declaration = (int)$d('privacy_declaration');
    $refund_declaration = (int)$d('refund_declaration');
    $office_coordinator_name = mysqli_real_escape_string($connection, $d('office_coordinator_name'));
    $office_invoice_provided = (int)$d('office_invoice_provided');
    $office_receipt_collected = (int)$d('office_receipt_collected');
    $office_lms_access = (int)$d('office_lms_access');
    $office_resources_access = (int)$d('office_resources_access');
    $office_uploaded_sms = (int)$d('office_uploaded_sms');
    $office_welcome_pack_sent = (int)$d('office_welcome_pack_sent');
    $candidate_declaration = (int)$d('candidate_declaration');
    $candidate_full_name = mysqli_real_escape_string($connection, $d('candidate_full_name'));
    $candidate_date = mysqli_real_escape_string($connection, $d('candidate_date'));
    $candidate_signature = mysqli_real_escape_string($connection, $d('candidate_signature'));

    $tel_num = $home_phone;
    $em_agree_check = '1';
    $self_status = '';
    $st_citizen = '';
    $born_country = '';
    $st_born_country = '';
    $qual_1 = $qual_2 = $qual_3 = $qual_4 = $qual_5 = $qual_6 = $qual_7 = $qual_8 = $qual_9 = $qual_10 = '';
    $qual_name_8_other = $qual_name_9_other = $qual_name_10_other = '';

    $cols = "st_unique_id, st_enquiry_id, st_rto_name, st_courses, st_branch, st_photo, st_given_name, st_surname, st_dob, st_country_birth, st_street, st_suburb, st_state, st_post_code, st_tel_num, st_email, st_mobile, st_emerg_name, st_emerg_relation, st_emerg_mobile, st_emerg_agree, st_usi, st_emp_status, st_self_status, st_citizenship, st_gender, st_credit_transfer, st_highest_school, st_secondary_school, st_born_country, st_born_country_other, st_origin, st_lan_spoken, st_lan_spoken_other, st_disability, st_disability_type, st_disability_type_other, st_study_reason, st_study_reason_other, st_qual_1, st_qual_2, st_qual_3, st_qual_4, st_qual_5, st_qual_6, st_qual_7, st_qual_8, st_qual_9, st_qual_10, st_qual_8_other, st_qual_9_other, st_qual_10_other, st_created_by";
    $vals = "'1','$enquiry_id','$rto_name','$coursesJson','$branch_name','$photo','$given_name','$surname','$dob','$birth_country','$street_details','$sub_urb','$stu_state','$post_code','$tel_num','$emailAddress','$mobile_num','$em_full_name','$em_relation','$em_mobile_num','$em_agree_check','$usi_id','$emp_status','$self_status','$st_citizen','$gender_check','$cred_tansf','$highest_school','$sec_school','$born_country','$st_born_country','$origin','$lan_spoken','$lan_spoken_other','$disability','$st_disability_type','$disability_type_other','$study_reason','$study_reason_other','$qual_1','$qual_2','$qual_3','$qual_4','$qual_5','$qual_6','$qual_7','$qual_8','$qual_9','$qual_10','$qual_name_8_other','$qual_name_9_other','$qual_name_10_other',$admin_id";

    $query = "INSERT INTO student_enrolments ($cols) VALUES ($vals)";
    $queryExec = mysqli_query($connection, $query);
    if (!$queryExec) {
        echo json_encode(array('success' => false, 'message' => 'Database error: ' . mysqli_error($connection)));
        exit;
    }
    $lastId = mysqli_insert_id($connection);
    $courseId = !empty($courses) ? (int)$courses[0] : 0;
    $courseID = $courseId ? mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM courses WHERE course_id=$courseId")) : null;
    $dateYear = date('Y');
    $uniqueId = $courseID ? sprintf($dateYear . $courseID['course_name'] . '%04d', $lastId) : ($dateYear . 'ENR' . sprintf('%04d', $lastId));
    $coursesDisplay = '';
    if (!empty($courses) && $courseID) {
        $names = array();
        foreach ($courses as $cid) {
            $r = mysqli_fetch_array(mysqli_query($connection, "SELECT course_sname, course_name FROM courses WHERE course_id=" . (int)$cid));
            if ($r) $names[] = $r['course_sname'] . '-' . $r['course_name'];
        }
        $coursesDisplay = implode(', ', $names);
    }

    $updateEnrol = "INSERT INTO student_enrolment (st_enquiry_id, st_unique_id, st_enrol_status, st_given_name, st_name, st_mobile, st_email, st_qualifications, st_enrol_course, st_venue, st_middle_name, st_source) VALUES ('$enquiry_id','$uniqueId',0,'$given_name','$surname','$mobile_num','$emailAddress','','$courseId','','','')";
    mysqli_query($connection, $updateEnrol);

    $updateStUnique = "UPDATE student_enrolments SET st_unique_id='$uniqueId' WHERE st_enrol_id=$lastId";
    mysqli_query($connection, $updateStUnique);

    $updNew = "UPDATE student_enrolments SET qualification_code_title='$qualification_code_title', age_declaration_18=" . ($age_declaration_18 ? 1 : 'NULL') . ", city_of_birth='$city_of_birth', postal_same_as_above=$postal_same_as_above, postal_address='$postal_address', english_read_write='$english_read_write', work_phone='$work_phone', home_phone='$home_phone', year_completed_school='$year_completed_school', mode_delivery='$mode_delivery', qualification_attained='$qualification_attained', industry_of_work='$industry_of_work', computer_access='$computer_access', computer_literacy='$computer_literacy', numeracy_skills='$numeracy_skills', additional_support='$additional_support', additional_support_specify='$additional_support_specify', usi_declaration=$usi_declaration, privacy_declaration=$privacy_declaration, refund_declaration=$refund_declaration, office_coordinator_name='$office_coordinator_name', office_invoice_provided=$office_invoice_provided, office_receipt_collected=$office_receipt_collected, office_lms_access=$office_lms_access, office_resources_access=$office_resources_access, office_uploaded_sms=$office_uploaded_sms, office_welcome_pack_sent=$office_welcome_pack_sent, candidate_declaration=$candidate_declaration, candidate_full_name='$candidate_full_name', candidate_date='" . ($candidate_date ? $candidate_date : '') . "', candidate_signature='$candidate_signature', form_source='online' WHERE st_enrol_id=$lastId";
    @mysqli_query($connection, $updNew);

    $pdfData = array_merge($raw, array(
        'office_student_id' => $uniqueId,
        'courses_display'   => $coursesDisplay,
        'emailAddress'     => $emailAddress,
    ));
    $pdfDir = __DIR__ . '/enrolments_pdf/';
    if (!is_dir($pdfDir)) {
        @mkdir($pdfDir, 0755, true);
    }
    $pdfPath = $pdfDir . 'Enrolment_' . $uniqueId . '.pdf';
    require_once __DIR__ . '/enrolment_pdf_generator.php';
    enrolment_generate_pdf($pdfData, $pdfPath);

    $pdfUrl = 'includes/enrolments_pdf/Enrolment_' . $uniqueId . '.pdf';
    echo json_encode(array('success' => true, 'unique_id' => $uniqueId, 'pdf_url' => $pdfUrl));
    exit;
}

if (@$_POST['formName'] == 'invoice_submit_company') {

     // Sanitize input
     
    $invoiceNumber = uniqid('INV_');
     $address = mysqli_real_escape_string($connection, $_POST['address']);
     $phone = mysqli_real_escape_string($connection, $_POST['phone']);
     
     $contact_number = mysqli_real_escape_string($connection, $_POST['contact_number']);
     $contact_name = mysqli_real_escape_string($connection, $_POST['contact_name']);
     $contact_email = mysqli_real_escape_string($connection, $_POST['contact_email']);
     $contact_role = mysqli_real_escape_string($connection, $_POST['contact_role']);
     
     $num_students = (int) $_POST['num_students'];
     $students_names = explode("\n", trim($_POST['students_names'])); // Convert to array
     $students_names_json = json_encode($students_names);
     
     $course_name = mysqli_real_escape_string($connection, $_POST['course_name']);
     $total_amount = (float) $_POST['total_amount'];
     $paid_amount = (float) $_POST['paid_amount'];
     $date_time = mysqli_real_escape_string($connection, $_POST['date_time']);
     $payment_mode = mysqli_real_escape_string($connection, $_POST['payment_mode']);
     $balance_amount = (float) $_POST['balance_amount'];
     
     $date = date('Y');
 
     // Contact Person Data as JSON
     $contact_person = json_encode([
         "name" => $contact_name,
         "email" => $contact_email,
         "role" => $contact_role,
         "phone" => $contact_number
     ]);
 
     // Insert data into database with invoice_type = 2
     $query = "INSERT INTO payment_records 
         (address, phone, contact_person, num_students, students_names, course, total_amount, paid_amount, dateTime, paymentMode, balance_amount, invoice_number, invoice_type)
         VALUES 
         ( '$address', '$phone', '$contact_person', '$num_students', '$students_names_json', '$course_name', '$total_amount', '$paid_amount', '$date_time', '$payment_mode', '$balance_amount', '$invoiceNumber', '2')";
 
     $insert = mysqli_query($connection, $query);
 
     if ($insert) {
         $lastId = mysqli_insert_id($connection);
         $uniqueId = sprintf('INV%s%05d', $date, $lastId);
 
         // Update with unique invoice ID
         mysqli_query($connection, "UPDATE payment_records SET invoice_number='$uniqueId' WHERE id=$lastId");
 
         // Generate PDF invoice
         $pdf = new TCPDF();
         $pdf->SetCreator(PDF_CREATOR);
         $pdf->SetAuthor('Auz Training College Pty Ltd');
         $pdf->SetTitle('Invoice');
 
         $pdf->AddPage();
 
         // Company Information
         $company_title = "Auz Training College Pty Ltd";
         $company_bsb = "BSB: 065 000";
         $company_account = "A/c Number: 1255 8010";
 
         // Add Logo
         $pdf->Image('../assets/images/logo-dark.webp', 15, 10, 40, 20, '', '', '', false, 300);
 
         // Set Title
         $pdf->SetFont('helvetica', 'B', 16);
         $pdf->Cell(0, 40, "Invoice", 0, 1, 'C');
 
         // Company Details
         $pdf->SetFont('helvetica', '', 10);
         $pdf->Cell(0, 5, $company_title, 0, 1, 'R');
         $pdf->Cell(0, 5, $company_bsb, 0, 1, 'R');
         $pdf->Cell(0, 5, $company_account, 0, 1, 'R');
         $pdf->Cell(0, 5, "Invoice Number: " . $uniqueId, 0, 1, 'R');
         $pdf->Ln(10); // Line break
 
         // Invoice Content
         $html = "
         <style>
             table { border-collapse: collapse; width: 100%; }
             th, td { border: 1px solid #000; padding: 8px; text-align: left; }
             th { background-color: #f2f2f2; }
         </style>
         <table>
             <tr><th>Field</th><th>Details</th></tr>
             <tr><td><strong>Company Name:</strong></td><td>test company</td></tr>
             <tr><td><strong>Address:</strong></td><td>$address</td></tr>
             <tr><td><strong>Phone No:</strong></td><td>$phone</td></tr>
             <tr><td><strong>Contact Person's Name:</strong></td><td>$contact_name</td></tr>
             <tr><td><strong>Contact Person's Email:</strong></td><td>$contact_email</td></tr>
             <tr><td><strong>Contact Person's Role:</strong></td><td>$contact_role</td></tr>
             <tr><td><strong>Contact Person's Phone:</strong></td><td>$contact_number</td></tr>
             <tr><td><strong>Number of Students:</strong></td><td>$num_students</td></tr>
             <tr><td><strong>Students Names:</strong></td><td>$students_names_json</td></tr>
             <tr><td><strong>Course Name:</strong></td><td>$course_name</td></tr>
             <tr><td><strong>Total Amount:</strong></td><td>$$total_amount</td></tr>
             <tr><td><strong>Paid Amount:</strong></td><td>$$paid_amount</td></tr>
             <tr><td><strong>Date & Time:</strong></td><td>$date_time</td></tr>
             <tr><td><strong>Payment Mode:</strong></td><td>$payment_mode</td></tr>
             <tr><td><strong>Balance Amount:</strong></td><td>$$balance_amount</td></tr>
         </table>
         <br><br>
         <strong>Terms & Conditions:</strong><br>
         Please do the payment using the below Bank account details.<br>
         <br>
         <strong>A/c Name:</strong> Auz Training College Pty Ltd<br>
         <strong>BSB:</strong> 065 000<br>
         <strong>A/c Number:</strong> 1255 8010<br>
         <br>
         Invoices we paid – Raise training, placement invoices.
         ";
 
         $pdf->writeHTML($html, true, false, true, false, '');

         $invoicePdfPath = __DIR__ . "/invoices/$uniqueId.pdf";
         $pdf->Output($invoicePdfPath, 'F'); // Save to file
 
         echo json_encode(["status" => "success", "invoice_number" => $uniqueId, "pdf_path" => $invoicePdfPath]);
     } else {
         echo json_encode(["status" => "error", "message" => mysqli_error($connection)]);
     }
}


if(@$_POST['formName']=='invoice_submit'){

    $invoice_number = uniqid('INV_');
    $given_name = $_POST['given_name'];
    $surname = $_POST['surname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $totalFees = $_POST['totalFees'];
    $paymentDone = $_POST['paymentDone'];
    $datePaid = $_POST['datePaid'];
    $remainingDue = $_POST['remainingDue'];
    $comments = $_POST['comments'];
    $instalmentPaid = $_POST['instalmentPaid'];
    $dateTime = $_POST['dateTime'];
    $whoTookPayment = $_POST['whoTookPayment'];
    $paymentMode = $_POST['paymentMode'];
    $fundsReceived = $_POST['fundsReceived'];
    $whoChecked = $_POST['whoChecked'];
    $receiptEmailed = $_POST['receiptEmailed'];


    $date = date('Y');

    // Insert data into database
    $query = mysqli_query($connection, "INSERT INTO payment_records 
        (given_name, surname, address, phone, email, course, totalFees, paymentDone, datePaid, remainingDue, comments, instalmentPaid, dateTime, whoTookPayment, paymentMode, fundsReceived, whoChecked, receiptEmailed , invoice_number)
        VALUES 
        ('$given_name', '$surname', '$address', '$phone', '$email', '$course', '$totalFees', '$paymentDone', '$datePaid', '$remainingDue', '$comments', '$instalmentPaid', '$dateTime', '$whoTookPayment', '$paymentMode', '$fundsReceived', '$whoChecked', '$receiptEmailed' , '$invoice_number')");

    $lastId = mysqli_insert_id($connection);
    $uniqueId = sprintf('INV%s%05d', $date, $lastId);
    $updateQuery = mysqli_query($connection, "UPDATE payment_records SET invoice_number='$uniqueId' WHERE id=$lastId");

    if ($updateQuery) {
        // Generate PDF invoice
       

    // Create PDF instance
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Auz Training');
    $pdf->SetTitle('Payment Invoice');
    $pdf->AddPage();
    
    // Company Information
    $company_name = "Auz Training";
    $company_abn = "ABN: 74 615 207 237";
    $company_address = "Level 1/118 King William Street, Adelaide 5000";
    $company_phone = "0468 449 468";
    $date_time = date('Y-M-d H:m:s');
    
    // Customer Information
    $customer_name = $surname . $given_name;
    $customer_email = $email;
    $customer_phone = $phone;
    $course_name = $course;
    
    // Payment Details
    $course_fees = $totalFees;
    $amount_paid = $paymentDone;
    $amount_due = $remainingDue;
    $payment_plan = "The remaining instalments need to be paid as follows:\n\n"
        . "$400 by 27th March 2025\n"
        . "$400 by 10th April 2025\n"
        . "$349 by 24th April 2025.";
    $orientation_details = "14th March 2025 (Friday) from 3 PM to 5 PM.";
    
    // Company Logo
    $pdf->Image('../assets/images/logo-dark.webp', 160, 10, 40, 20, '', '', '', false, 300);
    $pdf->Ln(30);
    
    // Title
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, "INVOICE", 0, 1, 'C');
    $pdf->Ln(5);
    
    // Company Details
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, $company_name, 0, 1, 'L');
    $pdf->Cell(0, 5, $company_abn, 0, 1, 'L');
    $pdf->Cell(0, 5, $company_address, 0, 1, 'L');
    $pdf->Cell(0, 5, "M: " . $company_phone, 0, 1, 'L');
    $pdf->Ln(5);
    
    // Customer Details
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 5, "To: " . $customer_name, 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, "Email: " . $customer_email, 0, 1, 'L');
    $pdf->Cell(0, 5, "M: " . $customer_phone, 0, 1, 'L');
    $pdf->Ln(5);

        
    // Invoice Details
    $pdf->Cell(0, 5, "Invoice No: " . $invoice_number, 0, 1, 'R');
    $pdf->Cell(0, 5, "Date: " . $date_time, 0, 1, 'R');
    $pdf->Ln(10); 
    
    // Course Details
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 5, "Course Name: " . $course_name, 0, 1, 'L');
    $pdf->Ln(5);
    
    // Payment Details Table
    $html = '<table border="1" cellspacing="0" cellpadding="5">
    <tr>
    <th><strong>Item Description</strong></th>
    <th><strong>Amount</strong></th>
    </tr>
    <tr>
    <td>Course Fees</td>
    <td>$' . $course_fees . '</td>
    </tr>
    <tr>
    <td>Pending Amount</td>
    <td>$' . $course_fees . '</td>
    </tr>
    <tr>
    <td>Amount Paid</td>
    <td>$' . $amount_paid . '</td>
    </tr>
    <tr>
    <td>Amount Due</td>
    <td>$' . $amount_due . '</td>
    </tr>
    </table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Ln(5);
    
    // Additional Notes
    $pdf->SetFont('helvetica', 'I', 10);
    $pdf->MultiCell(0, 5, "Additional Notes: \nThe down payment of $700 has been paid during enrolment on 13th March 2025.\n\n$payment_plan", 0, 'L');
    $pdf->Ln(5);
    
    // Orientation Details
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 5, "Total amount has to be paid within the duration of Theoretical part. 
If not paid by the due date, additional charges will be applicable. 
A mandatory online Orientation session has been booked for you. \n\n You can attend the Orientation session on the date mentioned 
below: \n\n\n\n\n\n\n\n The Zoom link for Online Orientation has been emailed to you and you are expected to come 
online on Friday by 3 PM and be there for 2 hours with the video on. \n\n $orientation_details", 0, 'L');
    $pdf->Ln(5);
    
    // Payment Instructions
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(0, 5, "In case Payment is not done, please find the below details to make payment:\nAccount Name: Auz Training College Pty Ltd\nBSB: 065000\nAcc. No. 1255 8010", 0, 'L');
    $pdf->Ln(10);
    
    // Save PDF
    $pdfFilePath = __DIR__ . "/invoices/$invoice_number.pdf";
    $pdf->Output($pdfFilePath, 'F');

        echo json_encode(["status" => "success", "invoice_number" => $invoice_number, "pdf_path" => $pdfFilePath]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($connection)]);
    }

}
// if(@$_POST['formName']=='invoice_submit'){
//     $payment_date=$_POST['payment_date'];
//     $amount_due=$_POST['amount_due'];
//     $amount_paid=$_POST['amount_paid'];
//     $course_fee=$_POST['course_fee'];
//     $course_name=$_POST['course_name'];
//     $enrol_id=$_POST['enrol_id'];
//     $student_name=$_POST['student_name'];
//     $date=date('Y');

//     $query=mysqli_query($connection,"INSERT INTO invoices(inv_std_name,st_unique_id,inv_course,inv_fee,inv_paid,inv_due,inv_payment_date)VALUES('$student_name','$enrol_id','$course_name','$course_fee','$amount_paid',$amount_due,'$payment_date')");
//     $lastId=mysqli_insert_id($connection);
//     $uniqueId=sprintf('INV'.$date.'%05d', $lastId);

//     $querys=mysqli_query($connection,"UPDATE invoices SET inv_auto_id='$uniqueId' WHERE inv_id=$lastId");

//     $error=mysqli_error($connection);
//     if($error!=''){
//         echo 1;
//     }else{
//         echo $uniqueId;
//     }
// }

if(@$_POST['formName']=='login'){
$email=$_POST['email'];
$password=$_POST['password'];
$query=mysqli_query($connection,"SELECT user_id,user_type,user_name,user_log_id FROM users WHERE user_email='$email' AND user_password='$password'");
$error=mysqli_error($connection);
$id=mysqli_fetch_array($query);
if($id['user_id']=='' || $id['user_id']=='undefined'){
    echo "1|invalid";
}else{
    $_SESSION['user_id']=$id['user_id'];
    $_SESSION['user_type']=$id['user_type'];
    $_SESSION['user_name']=$id['user_name'];
    $_SESSION['user_log_id']=$id['user_log_id'];
    echo "0|".$id['user_type'];
}
}

if(@$_POST['formName'] == 'get_user'){
    $id = $_POST['user_id'];
    $result = mysqli_query($connection, "SELECT * FROM users WHERE user_id='$id'");
    echo json_encode(mysqli_fetch_assoc($result));
}

// EDIT USER
if(@$_POST['formName'] == 'edit_user'){
    $id = $_POST['user_id'];
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    $type = $_POST['user_type'];
    $status = $_POST['user_status'];
    $modified = date('Y-m-d H:i:s');

    if($password != ''){
        $update = mysqli_query($connection, "UPDATE users SET user_name='$name', user_email='$email', user_password='$password', user_type='$type', user_status='$status', modified_date='$modified' WHERE user_id='$id'");
    } else {
        $update = mysqli_query($connection, "UPDATE users SET user_name='$name', user_email='$email', user_type='$type', user_status='$status', modified_date='$modified' WHERE user_id='$id'");
    }

    if($update){
        // Reload user list HTML
        $users = mysqli_query($connection, "SELECT * FROM users WHERE user_type=0 ORDER BY user_id DESC");
        include('../includes/user_list_partial.php');
    }else{
        echo 1;
    }
}

if(@$_POST['formName'] == 'create_user'){
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    $type = $_POST['user_type'];
    $status = $_POST['user_status'];

    $user_log_id = strtoupper(substr(md5(uniqid()), 0, 8));
    $created = date('Y-m-d H:i:s');

    $insert = mysqli_query($connection, "INSERT INTO users (user_log_id, user_name, user_email, user_password, user_type, user_status, created_date)
                                         VALUES ('$user_log_id', '$name', '$email', '$password', '$type', '$status', '$created')");
    if($insert){
        // Reload user list HTML
        $users = mysqli_query($connection, "SELECT * FROM users WHERE user_type=0 ORDER BY user_id DESC");
        include('../includes/user_list_partial.php');
    }else{
        echo 1;
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

    $coursesNames=json_decode($queryRes['st_course']);
    $coursesName='<div class="td_scroll_height">';
    foreach($coursesNames as $value){
        $courses=mysqli_fetch_array(mysqli_query($connection,"SELECT * from courses where course_status!=1 AND course_id=".$value));
        $coursesName.= $courses['course_sname'].'-'.$courses['course_name']." , <br>"; 
    }
    
    $st_course_type=['-','Rpl','Regular','Regular - Group','Short courses','Short course - Group'];
    $courseTypeId=$queryRes['st_course_type'];

    $coursesNamePos = strrpos($coursesName, ',');
    $coursesName = substr($coursesName, 0, $coursesNamePos);
    $coursesName.='</div>';

    $visited=$queryRes['st_visited']==1 ? 'Visited' : ( $queryRes['st_visited']==2 ? 'Not Visited' : ' - ' ) ;
    
    $visastatus=$queryRes['st_visa_condition']==1 ? 'Approved' : 'Not Approved' ;

    $refered_names = $queryRes['st_refer_name'];

    $startPlanDate=date('d M Y',strtotime($queryRes['st_startplan_date']));

    $staff_comments=$queryRes['st_comments'];
    $preference=$queryRes['st_pref_comments'];

    $st_remarks=['--select--','Seems to be interested to do course and need to contact asap','contacted and followed','Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose'];    

    if($queryRes['st_remarks']!=''){
        $remarksNotes='<div class="td_scroll_height">';

    foreach(json_decode($queryRes['st_remarks']) as $remark  ){                   
        
        $remarksNotes.=$st_remarks[$remark].' , <br>';

    }
    $remarksNotes.='</div>';
    }else{
        $remarksNotes=' - ';
        
    }

    $street=$queryRes['st_street_details'];
    $suburb=$queryRes['st_suburb'];
    $post_code=$queryRes['st_post_code'];
    $appointment=$queryRes['st_appoint_book']==1 ? 'Booked' : ( $queryRes['st_appoint_book']==2 ? 'Not Booked' : ' - ' );
    
    $querys2=mysqli_query($connection,"select visa_status_name from `visa_statuses` WHERE visa_id=".$queryRes['st_visa_status']);
    if(mysqli_num_rows($querys2)!=0){
    $visaCondition=mysqli_fetch_array($querys2);

    if(@$visaCondition['visa_status_name'] && $visaCondition['visa_status_name']!=''){
        $visacCond=$visaCondition['visa_status_name'];
    }else{
        $visacCond=' - ';
    }
    }else{
        $visacCond=' - ';
    }
    

        $view='<a class="btn btn-outline-primary btn-sm edit_enq" style="margin-right:10px;" href="student_enquiry.php?eq='.base64_encode($queryRes['st_id']).'">Edit</a><button onclick="delete_enq(\'student_enquiry\',\'st\','.$queryRes['st_id'].')" type="button" class="btn btn-outline-danger btn-sm">Delete</button>';

        array_push($enquiries['data'],array('st_enquiry_id'=>$queryRes['st_enquiry_id'],'std_name'=>$queryRes['st_name'], 'std_phno'=>$queryRes['st_phno'],'std_email'=>$queryRes['st_email'],'street'=>$street,'suburb'=>$suburb,'post_code'=>$post_code,'std_course'=>$coursesName,'startplan_date'=>$startPlanDate,'referedby'=>$refered_names,'visited'=>$visited,'st_coursetype'=>$st_course_type[$courseTypeId],'std_fee'=>$queryRes['st_fee'],'appointment'=>$appointment,'Visa_condition'=>$visacCond,'std_visa_status'=>$visastatus,'staffComments'=>$staff_comments,'preferences'=>$preference,'remarksNotes'=>$remarksNotes,'action'=>$view));
        
    }
    header("Content-Type: application/json");
    echo json_encode($enquiries);
}

if(@$_REQUEST['name']=='followup_calls'){

    $followups['data']=[];

    $checkQry=mysqli_query($connection,"SELECT * FROM `followup_calls` WHERE `flw_enquiry_status`=0");
    if(mysqli_num_rows($checkQry)!=0){

        while($checkQryRes=mysqli_fetch_array($checkQry)){

            $st_remarks=['--select--','Seems to be interested to do course and need to contact asap','contacted and followed','Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose'];    

            if($checkQryRes['flw_remarks']!=''){
                $remarksNotes='<div class="td_scroll_height">';
        
            foreach(json_decode($checkQryRes['flw_remarks']) as $remark  ){                   
                
                $remarksNotes.=$st_remarks[$remark].' , <br>';
        
            }
            $remarksNotes.='</div>';
            }else{
                $remarksNotes=' - ';
                
            }

            
        $view='<button type="button" data="'.$checkQryRes['flw_id'].'" class="btn btn-outline-primary btn-sm edit_enrol" style="margin-right:10px;"><a href="followup_call.php?flw_id='.base64_encode($checkQryRes['flw_id']).'">Edit</a></button><button onclick="delete_enq(\'followup_calls\',\'flw\','.$checkQryRes['flw_id'].')" type="button" class="btn btn-outline-danger btn-sm">Delete</button>';


            array_push($followups['data'],array('enquiry_id'=>$checkQryRes['enquiry_id'],'name'=>$checkQryRes['flw_name'],'phone'=>$checkQryRes['flw_phone'],'contacted_person'=>$checkQryRes['flw_contacted_person'],'contacted_time'=>date('d M y H:i',strtotime($checkQryRes['flw_contacted_time'])),'date'=>$checkQryRes['flw_date'],'mode_contact'=>$checkQryRes['flw_mode_contact'],'action'=>$view));

        }
                

    }

    header("Content-Type: application/json");
    echo json_encode($followups);



}

if(@$_REQUEST['formName']=='appointments_table'){


    $team_mems=$_POST['filter'];
    $where='';
    
    if($team_mems==''){
        $where.=" AND DATE(slot_bk_datetime) = CURDATE() AND TIME(slot_bk_datetime) <= CURTIME()";
    }else{
        $where.="AND `slot_book_by` LIKE '%$team_mems%' ";
    }

    $tbody='';

    $checkQry=mysqli_query($connection,"SELECT * FROM `slot_book` WHERE `slot_bk_id`!='' $where");

    // echo "SELECT * FROM `slot_book` WHERE `slot_bk_id`!='' $where";
    
    if(mysqli_num_rows($checkQry)!=0){

        while($checkQryRes=mysqli_fetch_array($checkQry)){

            $link=$checkQryRes['slot_book_email_link']==1 ? 'Yes' : 'No';
        
            $tbody.='<tr>';
            $tbody.='<td>'.$checkQryRes['slot_bk_id'].'</td>';
            $tbody.='<td>'.$checkQryRes['slot_bk_purpose'].'</td>';
            $tbody.='<td>'.$checkQryRes['slot_book_by'].'</td>';
            $tbody.='<td>'.$link.'</td>';
            $tbody.='<td>'.$checkQryRes['slot_bk_datetime'].'</td>';
            $tbody.='</tr>';

        }

    }

    echo $tbody;

}


if(@$_REQUEST['name']=='counselings'){

    $counselings['data']=[];

    $checkQry=mysqli_query($connection,"SELECT *, TIMESTAMPDIFF(DAY, counsil_timing, counsil_end_time) AS days, TIMESTAMPDIFF(HOUR, counsil_timing, counsil_end_time) % 24 AS hours, TIMESTAMPDIFF(MINUTE, counsil_timing, counsil_end_time) % 60 AS mins FROM `counseling_details` WHERE `counsil_enquiry_status` = 0;");
    if(mysqli_num_rows($checkQry)!=0){

        while($checkQryRes=mysqli_fetch_array($checkQry)){

            $st_remarks=['--select--','Seems to be interested to do course and need to contact asap','contacted and followed','Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose'];    

            if($checkQryRes['counsil_remarks']!=''){
                $remarksNotes='<div class="td_scroll_height">';
        
            foreach(json_decode($checkQryRes['counsil_remarks']) as $remark  ){                   
                
                $remarksNotes.=$st_remarks[$remark].' , <br>';
        
            }
            $remarksNotes.='</div>';
            }else{
                $remarksNotes=' - ';
                
            }

            if($checkQryRes['counsil_type']==1){
                $type="Face to Face";
            }else{
                $type="Video";
            }
            
            if($checkQryRes['counsil_work_status']==1){
                $work_status="Yes";
            }else{
                $work_status="No";
            }

            $querys2=mysqli_query($connection,"select visa_status_name from `visa_statuses` WHERE visa_id=".$checkQryRes['counsil_visa_condition']);
            if(mysqli_num_rows($querys2)!=0){
            $visaCondition=mysqli_fetch_array($querys2);
        
            if(@$visaCondition['visa_status_name'] && $visaCondition['visa_status_name']!=''){
                $visacCond=$visaCondition['visa_status_name'];
            }else{
                $visacCond=' - ';
            }
            }else{
                $visacCond=' - ';
            }



            $timeSpent=$checkQryRes['days']=='' && $checkQryRes['hours']==0 ? 'Not Available' : $checkQryRes['days'].' Days '.$checkQryRes['hours'].' Hours '.$checkQryRes['mins'].' Minutes';

            
        $view='<button type="button" data="'.$checkQryRes['counsil_id'].'" class="btn btn-outline-primary btn-sm edit_enrol" style="margin-right:10px;"><a href="counselling_form.php?eq='.base64_encode($checkQryRes['counsil_id']).'">Edit</a></button><button onclick="delete_enq(\'counseling_details\',\'counsil\','.$checkQryRes['counsil_id'].')" type="button" class="btn btn-outline-danger btn-sm">Delete</button>';


            array_push($counselings['data'],array('member_name'=>$checkQryRes['counsil_mem_name'],'counsil_type'=>$type,'work_status'=>$work_status,'visa'=>$visacCond,'education'=>$checkQryRes['counsil_education'],'counsil_timing'=>date('d M y H:i',strtotime($checkQryRes['counsil_timing'])),'time_spent'=>$timeSpent,'action'=>$view));

        }
                

    }

    header("Content-Type: application/json");
    echo json_encode($counselings);



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

if (@$_POST['formName'] == 'uploadEnrolmentExcel') {

    $targetDir = "uploads/attendance/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $targetFile = $targetDir . basename($_FILES["fileUpload"]["name"]);
    $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

    if ($fileType != "csv") {
        exit("Only CSV files (.csv) are allowed.");
    }

    if (!move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $targetFile)) {
        exit("Sorry, there was an error uploading your file.");
    }

    if (($handle = fopen($targetFile, "r")) === false) {
        exit("Unable to open uploaded CSV file.");
    }

    $tbody = '';
    $rowCount = 0;

    // Read header
    $headers = fgetcsv($handle, 10000, ",");

    // 🔹 Define mapping arrays for dropdowns
    $stateMap = [
        "NSW - New South Wales" => 1,
        "VIC - Victoria" => 2,
        "ACT - Australian Capital Territory" => 3,
        "NT - Northern Territoy" => 4,
        "WA - Western Australia" => 5,
        "QLD - Queensland" => 6,
        "SA - South Australia" => 7,
        "TAS - Tasmania" => 8,
    ];

    $empStatusMap = [
        "Full time employee (More than 35 hours)" => 1,
        "Part time employee (Less than 35 hours)" => 2,
        "Self employed - Not employing others Employer" => 3,
        "Employed - Unpaid family worker in a family business" => 4,
        "Unemployed - Seeking full time work" => 5,
        "Unemployed - Seeking part time work" => 6,
        "Not employed - Not seeking employment" => 7,
    ];

    $selfStatusMap = [
        "A sole supporting parent" => 1,
        "A person with a history of short term employment experience" => 2,
        "A person returning to the workforce after an absence of 12 month or more" => 3,
        "A person who requires assistance with reading and writing" => 4,
    ];

    $citizenMap = [
        "Australian Citizen" => 1,
        "New Zealand Citizen" => 2,
        "Australian Permanent Resident" => 3,
        "Humanitarian Visa" => 4,
        "Temporary Resident" => 5,
    ];

    $highestSchoolMap = [
        "Completed Year 12 Completed Year 11" => 1,
        "Completed Year 10 Completed Year 9" => 2,
        "Completed Year 8 Never Attended School" => 3,
    ];

    $studyReasonMap = [
        "To get a job" => 1,
        "To develop my existing business" => 2,
        "To start my own business" => 3,
        "To try for a dierent career" => 4,
        "To get a better job / promotion" => 5,
        "It was a requirement of my job" => 6,
        "I wanted extra skills for my job" => 7,
        "To get into another course or study" => 8,
        "For personal interest or self-development" => 9,
        "Other Reason" => 10,
    ];

    while (($data = fgetcsv($handle, 10000, ",")) !== false) {
        if (empty($data[0]) || empty($data[1])) continue;

        // Basic fields
        $enquiry_id         = $data[0];
        $rto_name           = $data[1];
        $courses_raw        = $data[2];
        $branch_name        = $data[3];
        $given_name         = $data[4];
        $surname            = $data[5];
        $dob                = date('Y-m-d', strtotime($data[6]));
        $birth_country      = $data[7];
        $street_details     = $data[8];
        $sub_urb            = $data[9];
        $post_code          = $data[10];
        $tel_num            = $data[11];
        $mobile_num         = $data[12];
        $emailAddress       = $data[13];
        $stu_state_raw      = trim($data[14]);
        $em_full_name       = $data[15];
        $em_relation        = $data[16];
        $em_mobile_num      = $data[17];
        $em_agree_check     = $data[18];
        $usi_id             = $data[19];
        $emp_status_raw     = trim($data[20]);
        $self_status_raw    = trim($data[21]);
        $st_citizen_raw     = trim($data[22]);
        $highest_school_raw = trim($data[23]);
        $study_reason_raw   = trim($data[24]); // Multi-select
        $study_reason_other = $data[25];
        $gender_check       = $data[26];
        $cred_tansf         = $data[27];
        $sec_school         = $data[28];
        $born_country       = $data[29];
        $origin             = $data[30];
        $lan_spoken         = $data[31];
        $disability         = $data[32];
        $qual_1             = $data[33];
        $qual_2             = $data[34];
        $qual_3             = $data[35];
        $qual_4             = $data[36];
        $qual_5             = $data[37];
        $qual_6             = $data[38];
        $qual_7             = $data[39];
        $qual_8             = $data[40];
        $qual_9             = $data[41];
        $qual_10            = $data[42];
        $st_born_country    = $data[43];
        $qual_name_8_other  = $data[44];
        $qual_name_9_other  = $data[45];
        $qual_name_10_other = $data[46];
        $lan_spoken_other   = $data[47];
        $disability_type_other = $data[48];
        $st_disability_type = json_encode([]);
        $photo              = json_encode([]);
        $admin_id           = $_SESSION['user_id'] ?? 1;

        // 🔹 Convert dropdown values by mapping name → ID
        $stu_state        = $stateMap[$stu_state_raw] ?? 0;
        $emp_status       = $empStatusMap[$emp_status_raw] ?? 0;
        $self_status      = $selfStatusMap[$self_status_raw] ?? 0;
        $st_citizen       = $citizenMap[$st_citizen_raw] ?? 0;
        $highest_school   = $highestSchoolMap[$highest_school_raw] ?? 0;

        // 🔹 Multi-select: study_reason
        $reasonNames = array_map('trim', explode(',', $study_reason_raw));
        $reasonIds = [];
        foreach ($reasonNames as $r) {
            if (isset($studyReasonMap[$r])) {
                $reasonIds[] = $studyReasonMap[$r];
            }
        }
        $study_reason = json_encode($reasonIds);

        // 🔹 Convert course names → IDs
        $courseNames = array_map('trim', explode(',', $courses_raw));
        $courseIds = [];
        foreach ($courseNames as $cname) {
            $cname = mysqli_real_escape_string($connection, $cname);
            $actualCourseName = explode('-', $cname)[0];
            $q = mysqli_query($connection, "SELECT course_id FROM courses WHERE course_sname='$actualCourseName' LIMIT 1");
            if ($q && mysqli_num_rows($q) > 0) {
                $row = mysqli_fetch_assoc($q);
                $courseIds[] = $row['course_id'];
            }
        }
        $courses = json_encode($courseIds);

        // 🔹 Insert
        $sql = "INSERT INTO student_enrolments
        (st_unique_id,st_enquiry_id, st_rto_name, st_courses, st_branch, st_photo, st_given_name, st_surname, st_dob, st_country_birth, st_street, st_suburb, st_post_code, st_tel_num, st_email, st_mobile, st_state, st_emerg_name, st_emerg_relation, st_emerg_mobile, st_emerg_agree, st_usi, st_emp_status, st_self_status, st_citizenship, st_highest_school, st_study_reason, st_study_reason_other, st_gender, st_credit_transfer, st_secondary_school, st_born_country, st_origin, st_lan_spoken, st_disability, st_qual_1, st_qual_2, st_qual_3, st_qual_4, st_qual_5, st_qual_6, st_qual_7, st_qual_8, st_qual_9, st_qual_10, st_born_country_other, st_qual_8_other, st_qual_9_other, st_qual_10_other, st_lan_spoken_other, st_disability_type, st_disability_type_other, st_created_by)
        VALUES
        ('1','$enquiry_id','$rto_name','$courses','$branch_name','$photo','$given_name','$surname','$dob','$birth_country','$street_details','$sub_urb','$post_code','$tel_num','$emailAddress','$mobile_num','$stu_state','$em_full_name','$em_relation','$em_mobile_num','$em_agree_check','$usi_id','$emp_status','$self_status','$st_citizen','$highest_school','$study_reason','$study_reason_other','$gender_check','$cred_tansf','$sec_school','$born_country','$origin','$lan_spoken','$disability','$qual_1','$qual_2','$qual_3','$qual_4','$qual_5','$qual_6','$qual_7','$qual_8','$qual_9','$qual_10','$st_born_country','$qual_name_8_other','$qual_name_9_other','$qual_name_10_other','$lan_spoken_other','$st_disability_type','$disability_type_other',$admin_id)";

        if (mysqli_query($connection, $sql)) {
            $rowCount++;
            $tbody .= "<tr>
                <td>$enquiry_id</td>
                <td>$rto_name</td>
                <td>$given_name $surname</td>
                <td>$emailAddress</td>
                <td>$mobile_num</td>
            </tr>";
        } else {
            $tbody .= "<tr><td colspan='5' style='color:red;'>DB Error: " . mysqli_error($connection) . "</td></tr>";
        }
    }

    fclose($handle);

    echo "<p><b>Uploaded successfully:</b> $rowCount rows inserted.</p>";
    echo "<table border='1' cellpadding='5'>
            <tr><th>Enquiry ID</th><th>RTO</th><th>Name</th><th>Email</th><th>Mobile</th></tr>
            $tbody
          </table>";

    mysqli_close($connection);
}




if(@$_POST['formName']=='fetchEnquiries'){    

    $where='';
    if(@$_POST['objFilter']){
        $objFilter=$_POST['objFilter'];        
        foreach($objFilter as $key=>$value){

        if($key=='created_date'){
            $from_date=date('Y-m-d',strtotime(explode(' - ',$value)[0])).' 00:00:00';
            $to_date=date('Y-m-d',strtotime(explode(' - ',$value)[1])).' 23:59:59';
            $where.=' AND '.$key.' BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
        }else{
            $where.=' AND '.$key.' LIKE "%'.$value.'%"';
        }

        }
    }else{
        $where='';
    }


    // echo "SELECT * FROM `student_enquiry` WHERE `st_enquiry_status`=0".$where;
    

    $tbody='';
    $selectData=mysqli_query($connection,"SELECT * FROM `student_enquiry` WHERE `st_enquiry_status`=0".$where);
    if(mysqli_num_rows($selectData)!=0){
        while($selectDataQry=mysqli_fetch_array($selectData)){


            $coursesNames=json_decode($selectDataQry['st_course']);
            $coursesName='<div class="td_scroll_height">';
            foreach($coursesNames as $value){
                $courses=mysqli_fetch_array(mysqli_query($connection,"SELECT * from courses where course_status!=1 AND course_id=".$value));
                $coursesName.= $courses['course_sname'].'-'.$courses['course_name']." , <br>"; 
            }
    
            $st_states=['-','NSW - New South Wales','VIC - Victoria','ACT - Australian Capital Territory','NT - Northern Territoy','WA - Western Australia','QLD - Queensland','SA - South Australia','TAS - Tasmania'];
            $stateIndex = isset($selectDataQry['st_state']) ? (int)$selectDataQry['st_state'] : 0;
            $state_name = $st_states[$stateIndex] ?? '-';
            
            $st_course_type=['-','Rpl','Regular','Regular - Group','Short courses','Short course - Group'];
            $courseTypeId=$selectDataQry['st_course_type'];
        
            $coursesNamePos = strrpos($coursesName, ',');
            $coursesName = substr($coursesName, 0, $coursesNamePos);
            $coursesName.='</div>';
        
            $visited=$selectDataQry['st_visited']==1 ? 'Visited' : ( $selectDataQry['st_visited']==2 ? 'Not Visited' : ' - ' ) ;
            
            $visastatus=$selectDataQry['st_visa_condition']==1 ? 'Approved' : 'Not Approved' ;
        
            $refered_names = $selectDataQry['st_refer_name'];
        
            $startPlanDate=date('d M Y',strtotime($selectDataQry['st_startplan_date']));
        
            $staff_comments=$selectDataQry['st_comments'];
            $preference=$selectDataQry['st_pref_comments'];
        
            $st_remarks=['--select--','Seems to be interested to do course and need to contact asap','contacted and followed','Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose'];    
        
            if($selectDataQry['st_remarks']!=''){
                $remarksNotes='<div class="td_scroll_height">';
        
            foreach(json_decode($selectDataQry['st_remarks']) as $remark  ){                   
                
                $remarksNotes.=$st_remarks[$remark].' , <br>';
        
            }
            $remarksNotes.='</div>';
            }else{
                $remarksNotes=' - ';
                
            }
        
            $street=$selectDataQry['st_street_details'];
            $suburb=$selectDataQry['st_suburb'];
            $post_code=$selectDataQry['st_post_code'];
            $appointment=$selectDataQry['st_appoint_book']==1 ? 'Booked' : ( $selectDataQry['st_appoint_book']==2 ? 'Not Booked' : ' - ' );
            
            $querys2=mysqli_query($connection,"select visa_status_name from `visa_statuses` WHERE visa_id=".$selectDataQry['st_visa_status']);
            if(mysqli_num_rows($querys2)!=0){
            $visaCondition=mysqli_fetch_array($querys2);
        
            if(@$visaCondition['visa_status_name'] && $visaCondition['visa_status_name']!=''){
                $visacCond=$visaCondition['visa_status_name'];
            }else{
                $visacCond=' - ';
            }
            }else{
                $visacCond=' - ';
            }
    
            $appointment=$selectDataQry['st_appoint_book']==1 ? 'Booked' : ( $selectDataQry['st_appoint_book']==2 ? 'Not Booked' : ' - ' );
    
            $dateCreated=date('d M Y',strtotime($selectDataQry['st_enquiry_date']));


            $tbody.='<tr>';
            $tbody.='<td>'.$selectDataQry['st_enquiry_id'].'</td>';
            $tbody.='<td>'.$selectDataQry['st_name'].'</td>';
            $tbody.='<td>'.$selectDataQry['st_phno'].'</td>';
            $tbody.='<td>'.$selectDataQry['st_email'].'</td>';
            $tbody.='<td>'.$st_course_type[$courseTypeId].'</td>';
            $tbody.='<td class="imp-none">'.$selectDataQry['created_date'].'</td>';
            $tbody.='<td class="imp-none">'.$state_name.'</td>';
            $tbody.='<td class="imp-none">'.$coursesName.'</td>';
            $tbody.='<td class="imp-none">'.$visacCond.'</td>';
            $tbody.='<td class="imp-none">'.$visastatus.'</td>';
            $tbody.='<td><a class="btn btn-outline-primary btn-sm" href="student_enquiry.php?eq='.base64_encode($selectDataQry['st_id']).'">Edit</a></td>';
            $tbody.='</tr>';
        }
    }

    echo $tbody;

}
if(@$_POST['formName']=='fetchAppoints'){    

    $where='';
    if(@$_POST['objFilter']){
        $objFilter=$_POST['objFilter'];        
        foreach($objFilter as $key=>$value){

        if($key=='slot_book_by'){
            $teamArray=explode(',',$value);
            array_walk($teamArray, function (&$item) {
                $item = '"%' . $item . '%"';
            });
            $team=implode(' OR slot_book_by LIKE ',$teamArray);
            $where.=' AND `slot_book_by` LIKE '.$team;
        }else if($key=='slot_bk_datetime'){
            $from_date=date('Y-m-d',strtotime(explode(' - ',$value)[0])).' 00:00:00';
            $to_date=date('Y-m-d',strtotime(explode(' - ',$value)[1])).' 23:59:59';
            $where.=' AND '.$key.' BETWEEN "'.$from_date.'" AND "'.$to_date.'"';            
        }else{
            $where.=' AND '.$key.' LIKE "%'.$value.'%"';
        }

        }
    }else{
        $where='';
    }    
    

    $tbody='';
    $selectData=mysqli_query($connection,"SELECT * FROM `slot_book` WHERE `slot_bk_id`!=''".$where);
    echo "SELECT * FROM `slot_book` WHERE `slot_bk_id`!=''".$where;
    if(mysqli_num_rows($selectData)!=0){
        while($selectDataQry=mysqli_fetch_array($selectData)){     
            // print_r($selectDataQry);       

            $queryName=mysqli_fetch_array(mysqli_query($connection,"SELECT `st_name`,`st_enquiry_id`,`st_phno`,`st_email` FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_id`=".$selectDataQry['enq_form_id']));

            if($selectDataQry['slot_book_email_link']==1){
                $link='Yes';
            }else{
                $link='No';
            }

            $tbody.='<tr>';
            $tbody.='<td>'.$queryName['st_name'].'</td>';
            $tbody.='<td>'.$queryName['st_enquiry_id'].'</td>';            
            $tbody.='<td>'.$queryName['st_phno'].'</td>';
            $tbody.='<td>'.$queryName['st_email'].'</td>';
            $tbody.='<td>'.$selectDataQry['slot_bk_purpose'].'</td>';
            $tbody.='<td>'.$selectDataQry['slot_book_by'].'</td>';
            $tbody.='<td>'.$link.'</td>';
            $tbody.='<td>'.date('Y-m-d H:i',strtotime($selectDataQry['slot_bk_datetime'])).'</td>';
            $tbody.='</tr>';
        }
    }

    echo $tbody;

}

if(@$_POST['formName']=='fetchCounsel'){    

    $where='';
    if(@$_POST['objFilter']){
        $objFilter=$_POST['objFilter'];        
        foreach($objFilter as $key=>$value){

        if($key=='counsil_mem_name'){
            $teamArray=explode(',',$value);
            array_walk($teamArray, function (&$item) {
                $item = '"%' . $item . '%"';
            });
            $team=implode(' OR counsil_mem_name LIKE ',$teamArray);
            $where.=' AND `counsil_mem_name` LIKE '.$team;
        }else if($key=='counsil_created_date'){
            $from_date=date('Y-m-d',strtotime(explode(' - ',$value)[0])).' 00:00:00';
            $to_date=date('Y-m-d',strtotime(explode(' - ',$value)[1])).' 23:59:59';
            $where.=' AND '.$key.' BETWEEN "'.$from_date.'" AND "'.$to_date.'"';    
        }else{
            $where.=' AND '.$key.' LIKE "%'.$value.'%"';
        }

        }
    }else{
        $where='';
    }    
    
// echo "SELECT * FROM `counseling_details` WHERE `counsil_enquiry_status`!=1".$where;
    $tbody='';
    $selectData=mysqli_query($connection,"SELECT * FROM `counseling_details` WHERE `counsil_enquiry_status`!=1".$where);
    // echo "SELECT * FROM `slot_book` WHERE `slot_bk_id`!=''".$where;
    if(mysqli_num_rows($selectData)!=0){
        while($selectDataQry=mysqli_fetch_array($selectData)){     
            // print_r($selectDataQry);       
            // echo "SELECT `st_name`,`st_enquiry_id`,`st_phno`,`st_email` FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_enquiry_id`=".$selectDataQry['st_enquiry_id'];
            $queryName=mysqli_fetch_array(mysqli_query($connection,"SELECT `st_name`,`st_enquiry_id`,`st_phno`,`st_email` FROM `student_enquiry` WHERE `st_enquiry_status`=0 AND `st_enquiry_id`='".$selectDataQry['st_enquiry_id']."'"));

            if($selectDataQry['counsil_type']==1){
                $type='Face to Face';
            }else{
                $type='Video';
            }

            if($selectDataQry['counsil_end_time']!=''){
                $endDate=date('Y-m-d H:i',strtotime($selectDataQry['counsil_end_time']));
            }else{
                $endDate='';
            }

            $tbody.='<tr>';
            $tbody.='<td>'.$queryName['st_name'].'</td>';
            $tbody.='<td>'.$queryName['st_enquiry_id'].'</td>';            
            $tbody.='<td>'.$queryName['st_phno'].'</td>';
            $tbody.='<td>'.$queryName['st_email'].'</td>';
            $tbody.='<td>'.$type.'</td>';
            $tbody.='<td>'.$selectDataQry['counsil_mem_name'].'</td>';
            $tbody.='<td>'.date('Y-m-d H:i',strtotime($selectDataQry['counsil_timing'])).'</td>';
            $tbody.='<td>'.$endDate.'</td>';
            $tbody.='<td><a class="btn btn-outline-primary btn-sm" href="counselling_form.php?eq='.base64_encode($selectDataQry['counsil_id']).'">Edit</a></td>';
            $tbody.='</tr>';
        }
    }

    echo $tbody;

}

if(@$_POST['formName']=='fetchFollowupList'){
    $where='';
    if(@$_POST['objFilter']){
        $objFilter=$_POST['objFilter'];
        foreach($objFilter as $key=>$value){
            if($key=='flw_contacted_time' || $key=='flw_date'){
                if(strpos($value,' - ')!==false){
                    $parts=explode(' - ',$value);
                    $from_date=date('Y-m-d',strtotime(trim($parts[0]))).' 00:00:00';
                    $to_date=date('Y-m-d',strtotime(trim($parts[1]))).' 23:59:59';
                    $where.=' AND `'.$key.'` BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
            }else{
                $where.=' AND `'.$key.'` LIKE "%'.mysqli_real_escape_string($connection,$value).'%"';
            }
        }
    }
    $tbody='';
    $selectData=mysqli_query($connection,"SELECT * FROM `followup_calls` WHERE `flw_enquiry_status`=0".$where);
    if(mysqli_num_rows($selectData)!=0){
        while($row=mysqli_fetch_array($selectData)){
            $contacted_time=$row['flw_contacted_time']!='' ? date('d M Y H:i',strtotime($row['flw_contacted_time'])) : '';
            $flw_date=$row['flw_date']!='' ? date('d M Y',strtotime($row['flw_date'])) : '';
            $tbody.='<tr>';
            $tbody.='<td>'.$row['enquiry_id'].'</td>';
            $tbody.='<td>'.$row['flw_name'].'</td>';
            $tbody.='<td>'.$row['flw_phone'].'</td>';
            $tbody.='<td>'.$row['flw_contacted_person'].'</td>';
            $tbody.='<td>'.$contacted_time.'</td>';
            $tbody.='<td>'.$flw_date.'</td>';
            $tbody.='<td>'.$row['flw_mode_contact'].'</td>';
            $tbody.='<td>'.($row['flw_comments']!='' ? $row['flw_comments'] : '-').'</td>';
            $tbody.='<td><a class="btn btn-outline-primary btn-sm" href="followup_call.php?flw_id='.base64_encode($row['flw_id']).'">Edit</a></td>';
            $tbody.='</tr>';
        }
    }
    echo $tbody;
}

// ==================== APPOINTMENT SYSTEM FUNCTIONS ====================

// Appointment Booking
if(@$_POST['formName']=='appointment_booking'){
    $appointment_id = $_POST['appointment_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_datetime = $appointment_date . ' ' . $appointment_time;
    $booked_by = $_POST['created_by'];
    $booked_by_name = $_POST['booked_by_name'];
    $booking_comments = $_POST['booking_comments'];
    $purpose_id = $_POST['purpose_id'];
    $appointment_to_see = $_POST['appointment_to_see'];
    $attendee_type_id = $_POST['attendee_type_id'];
    $student_name = isset($_POST['student_name']) ? $_POST['student_name'] : '';
    $student_phone = isset($_POST['student_phone']) ? $_POST['student_phone'] : '';
    $student_email = isset($_POST['student_email']) ? $_POST['student_email'] : '';
    $business_name = isset($_POST['business_name']) ? $_POST['business_name'] : '';
    $business_contact = isset($_POST['business_contact']) ? $_POST['business_contact'] : '';
    $send_email = isset($_POST['send_email']) ? 1 : 0;
    $staff_member_type = $_POST['staff_member_type'];
    $meeting_type = $_POST['meeting_type'];
    $location_id = isset($_POST['location_id']) && $_POST['location_id'] != '' ? $_POST['location_id'] : 'NULL';
    $platform_id = isset($_POST['platform_id']) && $_POST['platform_id'] != '' ? $_POST['platform_id'] : 'NULL';
    $online_meeting_link = isset($_POST['online_meeting_link']) ? $_POST['online_meeting_link'] : '';
    $timezone_state = $_POST['timezone_state'];
    $appointment_time_state = isset($_POST['appointment_time_state']) && $_POST['appointment_time_state'] != '' ? $_POST['appointment_time_state'] : $appointment_datetime;
    $appointment_time_adelaide = isset($_POST['appointment_time_adelaide']) && $_POST['appointment_time_adelaide'] != '' ? $_POST['appointment_time_adelaide'] : $appointment_datetime;
    $appointment_time_india = isset($_POST['appointment_time_india']) && $_POST['appointment_time_india'] != '' ? $_POST['appointment_time_india'] : $appointment_datetime;
    $appointment_time_philippines = isset($_POST['appointment_time_philippines']) && $_POST['appointment_time_philippines'] != '' ? $_POST['appointment_time_philippines'] : $appointment_datetime;
    $connected_enquiry_id = isset($_POST['connected_enquiry_id']) && $_POST['connected_enquiry_id'] != '' ? "'".$_POST['connected_enquiry_id']."'" : 'NULL';
    $connected_enrolment_id = isset($_POST['connected_enrolment_id']) && $_POST['connected_enrolment_id'] != '' ? "'".$_POST['connected_enrolment_id']."'" : 'NULL';
    $connected_counselling_id = isset($_POST['connected_counselling_id']) && $_POST['connected_counselling_id'] != '' ? $_POST['connected_counselling_id'] : 'NULL';
    $appointment_notes = isset($_POST['appointment_notes']) ? $_POST['appointment_notes'] : '';
    $created_by = $_POST['created_by'];
    
    if($appointment_id == '0'){
        // Insert new appointment
        $query = "INSERT INTO appointments (appointment_date, appointment_time, appointment_datetime, booked_by, booked_by_name, booking_comments, purpose_id, appointment_to_see, attendee_type_id, student_name, student_phone, student_email, business_name, business_contact, send_email, staff_member_type, meeting_type, location_id, platform_id, online_meeting_link, timezone_state, appointment_time_state, appointment_time_adelaide, appointment_time_india, appointment_time_philippines, connected_enquiry_id, connected_enrolment_id, connected_counselling_id, appointment_notes, created_by) VALUES ('$appointment_date', '$appointment_time', '$appointment_datetime', $booked_by, '$booked_by_name', '$booking_comments', $purpose_id, $appointment_to_see, $attendee_type_id, '$student_name', '$student_phone', '$student_email', '$business_name', '$business_contact', $send_email, '$staff_member_type', '$meeting_type', $location_id, $platform_id, '$online_meeting_link', '$timezone_state', '$appointment_time_state', '$appointment_time_adelaide', '$appointment_time_india', '$appointment_time_philippines', $connected_enquiry_id, $connected_enrolment_id, $connected_counselling_id, '$appointment_notes', $created_by)";
    } else {
        // Update existing appointment
        $query = "UPDATE appointments SET appointment_date='$appointment_date', appointment_time='$appointment_time', appointment_datetime='$appointment_datetime', booked_by_name='$booked_by_name', booking_comments='$booking_comments', purpose_id=$purpose_id, appointment_to_see=$appointment_to_see, attendee_type_id=$attendee_type_id, student_name='$student_name', student_phone='$student_phone', student_email='$student_email', business_name='$business_name', business_contact='$business_contact', send_email=$send_email, staff_member_type='$staff_member_type', meeting_type='$meeting_type', location_id=$location_id, platform_id=$platform_id, online_meeting_link='$online_meeting_link', timezone_state='$timezone_state', appointment_time_state='$appointment_time_state', appointment_time_adelaide='$appointment_time_adelaide', appointment_time_india='$appointment_time_india', appointment_time_philippines='$appointment_time_philippines', connected_enquiry_id=$connected_enquiry_id, connected_enrolment_id=$connected_enrolment_id, connected_counselling_id=$connected_counselling_id, appointment_notes='$appointment_notes', modified_date=NOW(), modified_by=$created_by WHERE appointment_id=$appointment_id";
    }
    
    $result = mysqli_query($connection, $query);
    $error = mysqli_error($connection);
    
    if($error != ''){
        echo 0;
    } else {
        $appt_id = $appointment_id == '0' ? mysqli_insert_id($connection) : $appointment_id;
        
        // Send email if enabled
        if($send_email == 1 && $student_email != ''){
            $mail_to = $student_email;
            $mail_subject = "Appointment Confirmation";
            $mail_body = "Your appointment has been booked for " . date('d M Y h:i A', strtotime($appointment_datetime)) . ".<br><br>Details:<br>Purpose: " . getPurposeName($connection, $purpose_id) . "<br>Meeting Type: " . $meeting_type;
            send_mail($mail_to, $mail_subject, $mail_body);
        }
        
        echo 1;
    }
}

// Get appointments for calendar
if(@$_POST['formName']=='get_appointments_calendar'){
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    $query = "SELECT a.*, p.purpose_name, p.purpose_color FROM appointments a 
              LEFT JOIN appointment_purposes p ON a.purpose_id = p.purpose_id 
              WHERE a.delete_status != 1 AND a.appointment_datetime >= '$start' AND a.appointment_datetime <= '$end'";
    
    $result = mysqli_query($connection, $query);
    $events = array();
    
    while($row = mysqli_fetch_array($result)){
        $title = $row['purpose_name'];
        if($row['student_name'] != ''){
            $title .= ' - ' . $row['student_name'];
        } else if($row['business_name'] != ''){
            $title .= ' - ' . $row['business_name'];
        }
        
        $events[] = array(
            'id' => $row['appointment_id'],
            'title' => $title,
            'start' => $row['appointment_datetime'],
            'color' => $row['purpose_color'],
            'extendedProps' => array(
                'status' => $row['appointment_status'],
                'purpose' => $row['purpose_name']
            )
        );
    }
    
    echo json_encode($events);
}

// Get appointment details
if(@$_POST['formName']=='get_appointment_details'){
    $appointment_id = $_POST['appointment_id'];
    
    $query = "SELECT a.*, p.purpose_name, p.purpose_color, at.type_name as attendee_type, l.location_name, pl.platform_name, u.user_name as staff_name 
              FROM appointments a 
              LEFT JOIN appointment_purposes p ON a.purpose_id = p.purpose_id 
              LEFT JOIN appointment_attendee_types at ON a.attendee_type_id = at.type_id 
              LEFT JOIN appointment_locations l ON a.location_id = l.location_id 
              LEFT JOIN appointment_platforms pl ON a.platform_id = pl.platform_id 
              LEFT JOIN users u ON a.appointment_to_see = u.user_id 
              WHERE a.appointment_id = $appointment_id";
    
    $result = mysqli_query($connection, $query);
    $appointment = mysqli_fetch_array($result);
    
    $html = '<input type="hidden" id="appointment_status_hidden" value="'.$appointment['appointment_status'].'">';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6"><strong>Date & Time:</strong></div><div class="col-md-6">' . date('d M Y h:i A', strtotime($appointment['appointment_datetime'])) . '</div>';
    $html .= '<div class="col-md-6"><strong>Purpose:</strong></div><div class="col-md-6"><span class="color-preview" style="background:'.$appointment['purpose_color'].'"></span>' . $appointment['purpose_name'] . '</div>';
    $html .= '<div class="col-md-6"><strong>Status:</strong></div><div class="col-md-6"><span class="status-badge status-'.$appointment['appointment_status'].'">' . ucfirst(str_replace('-', ' ', $appointment['appointment_status'])) . '</span></div>';
    $html .= '<div class="col-md-6"><strong>Booked By:</strong></div><div class="col-md-6">' . $appointment['booked_by_name'] . '</div>';
    $html .= '<div class="col-md-6"><strong>Staff Member:</strong></div><div class="col-md-6">' . $appointment['staff_name'] . ' (' . $appointment['staff_member_type'] . ')</div>';
    $html .= '<div class="col-md-6"><strong>Meeting Type:</strong></div><div class="col-md-6">' . $appointment['meeting_type'] . '</div>';
    
    if($appointment['location_name']){
        $html .= '<div class="col-md-6"><strong>Location:</strong></div><div class="col-md-6">' . $appointment['location_name'] . '</div>';
    }
    
    if($appointment['platform_name']){
        $html .= '<div class="col-md-6"><strong>Platform:</strong></div><div class="col-md-6">' . $appointment['platform_name'] . '</div>';
    }
    
    if($appointment['student_name']){
        $html .= '<div class="col-md-6"><strong>Student Name:</strong></div><div class="col-md-6">' . $appointment['student_name'] . '</div>';
        $html .= '<div class="col-md-6"><strong>Student Phone:</strong></div><div class="col-md-6">' . $appointment['student_phone'] . '</div>';
        $html .= '<div class="col-md-6"><strong>Student Email:</strong></div><div class="col-md-6">' . $appointment['student_email'] . '</div>';
    }
    
    if($appointment['business_name']){
        $html .= '<div class="col-md-6"><strong>Business Name:</strong></div><div class="col-md-6">' . $appointment['business_name'] . '</div>';
        $html .= '<div class="col-md-6"><strong>Business Contact:</strong></div><div class="col-md-6">' . $appointment['business_contact'] . '</div>';
    }
    
    if($appointment['time_in']){
        $html .= '<div class="col-md-6"><strong>Time In:</strong></div><div class="col-md-6">' . date('d M Y h:i A', strtotime($appointment['time_in'])) . '</div>';
    }
    
    if($appointment['time_out']){
        $html .= '<div class="col-md-6"><strong>Time Out:</strong></div><div class="col-md-6">' . date('d M Y h:i A', strtotime($appointment['time_out'])) . '</div>';
    }
    
    if($appointment['appointment_notes']){
        $html .= '<div class="col-md-12 mt-3"><strong>Notes:</strong><br>' . nl2br($appointment['appointment_notes']) . '</div>';
    }
    
    $html .= '</div>';
    
    echo $html;
}

// Update appointment status
if(@$_POST['formName']=='update_appointment_status'){
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];
    $meeting_happened = ($status == 'completed') ? 1 : 0;
    
    $query = "UPDATE appointments SET appointment_status='$status', meeting_happened=$meeting_happened, modified_date=NOW() WHERE appointment_id=$appointment_id";
    $result = mysqli_query($connection, $query);
    
    echo $result ? 1 : 0;
}

// Record time in/out
if(@$_POST['formName']=='record_time_in_out'){
    $appointment_id = $_POST['appointment_id'];
    $type = $_POST['type'];
    $now = date('Y-m-d H:i:s');
    
    if($type == 'in'){
        $query = "UPDATE appointments SET time_in='$now', modified_date=NOW() WHERE appointment_id=$appointment_id";
    } else {
        $query = "UPDATE appointments SET time_out='$now', modified_date=NOW() WHERE appointment_id=$appointment_id";
    }
    
    $result = mysqli_query($connection, $query);
    echo $result ? 1 : 0;
}

// Get appointment reports
if(@$_POST['formName']=='get_appointment_reports'){
    $date_range = $_POST['date_range'];
    $start_date = '';
    $end_date = '';
    
    if($date_range == 'today'){
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
    } else if($date_range == 'week'){
        $start_date = date('Y-m-d', strtotime('monday this week'));
        $end_date = date('Y-m-d', strtotime('sunday this week'));
    } else if($date_range == 'month'){
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
    } else {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
    }
    
    $query = "SELECT a.*, p.purpose_name, at.type_name as attendee_type, u.user_name as staff_name 
              FROM appointments a 
              LEFT JOIN appointment_purposes p ON a.purpose_id = p.purpose_id 
              LEFT JOIN appointment_attendee_types at ON a.attendee_type_id = at.type_id 
              LEFT JOIN users u ON a.appointment_to_see = u.user_id 
              WHERE a.delete_status != 1 AND DATE(a.appointment_date) >= '$start_date' AND DATE(a.appointment_date) <= '$end_date'";
    
    $result = mysqli_query($connection, $query);
    
    $summary = array('total' => 0, 'attended' => 0, 'missed' => 0, 'cancelled' => 0);
    $statusData = array('labels' => array(), 'values' => array());
    $purposeData = array('labels' => array(), 'values' => array());
    $staffData = array('labels' => array(), 'values' => array());
    $dailyData = array('labels' => array(), 'values' => array());
    $appointments = array();
    
    $statusCounts = array();
    $purposeCounts = array();
    $staffCounts = array();
    $dailyCounts = array();
    
    while($row = mysqli_fetch_array($result)){
        $summary['total']++;
        
        if($row['appointment_status'] == 'completed'){
            $summary['attended']++;
        } else if(in_array($row['appointment_status'], array('no-show', 'missed'))){
            $summary['missed']++;
        } else if($row['appointment_status'] == 'cancelled'){
            $summary['cancelled']++;
        }
        
        // Status counts
        $status = ucfirst(str_replace('-', ' ', $row['appointment_status']));
        if(!isset($statusCounts[$status])){
            $statusCounts[$status] = 0;
        }
        $statusCounts[$status]++;
        
        // Purpose counts
        $purpose = $row['purpose_name'];
        if(!isset($purposeCounts[$purpose])){
            $purposeCounts[$purpose] = 0;
        }
        $purposeCounts[$purpose]++;
        
        // Staff counts
        $staff = $row['staff_name'];
        if(!isset($staffCounts[$staff])){
            $staffCounts[$staff] = 0;
        }
        $staffCounts[$staff]++;
        
        // Daily counts
        $day = date('Y-m-d', strtotime($row['appointment_date']));
        if(!isset($dailyCounts[$day])){
            $dailyCounts[$day] = 0;
        }
        $dailyCounts[$day]++;
        
        // Appointment details
        $appointments[] = array(
            'id' => $row['appointment_id'],
            'datetime' => date('d M Y h:i A', strtotime($row['appointment_datetime'])),
            'purpose' => $row['purpose_name'],
            'attendee' => $row['student_name'] ? $row['student_name'] : ($row['business_name'] ? $row['business_name'] : '-'),
            'staff' => $row['staff_name'],
            'status' => $row['appointment_status'],
            'meeting_type' => $row['meeting_type']
        );
    }
    
    // Format chart data
    foreach($statusCounts as $label => $value){
        $statusData['labels'][] = $label;
        $statusData['values'][] = $value;
    }
    
    foreach($purposeCounts as $label => $value){
        $purposeData['labels'][] = $label;
        $purposeData['values'][] = $value;
    }
    
    foreach($staffCounts as $label => $value){
        $staffData['labels'][] = $label;
        $staffData['values'][] = $value;
    }
    
    ksort($dailyCounts);
    foreach($dailyCounts as $label => $value){
        $dailyData['labels'][] = date('d M', strtotime($label));
        $dailyData['values'][] = $value;
    }
    
    $response = array(
        'summary' => $summary,
        'charts' => array(
            'status' => $statusData,
            'purpose' => $purposeData,
            'staff' => $staffData,
            'daily' => $dailyData
        ),
        'appointments' => $appointments
    );
    
    echo json_encode($response);
}

// Manage purposes
if(@$_POST['formName']=='get_purposes'){
    $query = "SELECT * FROM appointment_purposes WHERE purpose_status != 1 ORDER BY purpose_name";
    $result = mysqli_query($connection, $query);
    
    $html = '<table class="table table-sm"><thead><tr><th>Purpose</th><th>Color</th><th>Actions</th></tr></thead><tbody>';
    while($row = mysqli_fetch_array($result)){
        $html .= '<tr>';
        $html .= '<td>'.$row['purpose_name'].'</td>';
        $html .= '<td><span class="color-preview" style="background:'.$row['purpose_color'].'"></span></td>';
        $html .= '<td><button class="btn btn-sm btn-danger" onclick="deletePurpose('.$row['purpose_id'].')">Delete</button></td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    
    echo $html;
}

if(@$_POST['formName']=='add_purpose'){
    $purpose_name = $_POST['purpose_name'];
    $purpose_color = $_POST['purpose_color'];
    
    $query = "INSERT INTO appointment_purposes (purpose_name, purpose_color) VALUES ('$purpose_name', '$purpose_color')";
    $result = mysqli_query($connection, $query);
    
    echo $result ? 1 : 0;
}

// Manage attendee types
if(@$_POST['formName']=='get_attendee_types'){
    $query = "SELECT * FROM appointment_attendee_types WHERE type_status != 1 ORDER BY type_name";
    $result = mysqli_query($connection, $query);
    
    $html = '<table class="table table-sm"><thead><tr><th>Type</th><th>Actions</th></tr></thead><tbody>';
    while($row = mysqli_fetch_array($result)){
        $html .= '<tr>';
        $html .= '<td>'.$row['type_name'].'</td>';
        $html .= '<td><button class="btn btn-sm btn-danger" onclick="deleteAttendeeType('.$row['type_id'].')">Delete</button></td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    
    echo $html;
}

if(@$_POST['formName']=='add_attendee_type'){
    $type_name = $_POST['type_name'];
    
    $query = "INSERT INTO appointment_attendee_types (type_name) VALUES ('$type_name')";
    $result = mysqli_query($connection, $query);
    
    echo $result ? 1 : 0;
}

// Manage locations
if(@$_POST['formName']=='get_locations'){
    $query = "SELECT * FROM appointment_locations WHERE location_status != 1 ORDER BY location_name";
    $result = mysqli_query($connection, $query);
    
    $html = '<table class="table table-sm"><thead><tr><th>Location</th><th>Actions</th></tr></thead><tbody>';
    while($row = mysqli_fetch_array($result)){
        $html .= '<tr>';
        $html .= '<td>'.$row['location_name'].'</td>';
        $html .= '<td><button class="btn btn-sm btn-danger" onclick="deleteLocation('.$row['location_id'].')">Delete</button></td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    
    echo $html;
}

if(@$_POST['formName']=='add_location'){
    $location_name = $_POST['location_name'];
    
    $query = "INSERT INTO appointment_locations (location_name) VALUES ('$location_name')";
    $result = mysqli_query($connection, $query);
    
    echo $result ? 1 : 0;
}

// Manage platforms
if(@$_POST['formName']=='get_platforms'){
    $query = "SELECT * FROM appointment_platforms WHERE platform_status != 1 ORDER BY platform_name";
    $result = mysqli_query($connection, $query);
    
    $html = '<table class="table table-sm"><thead><tr><th>Platform</th><th>Actions</th></tr></thead><tbody>';
    while($row = mysqli_fetch_array($result)){
        $html .= '<tr>';
        $html .= '<td>'.$row['platform_name'].'</td>';
        $html .= '<td><button class="btn btn-sm btn-danger" onclick="deletePlatform('.$row['platform_id'].')">Delete</button></td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    
    echo $html;
}

if(@$_POST['formName']=='add_platform'){
    $platform_name = $_POST['platform_name'];
    
    $query = "INSERT INTO appointment_platforms (platform_name) VALUES ('$platform_name')";
    $result = mysqli_query($connection, $query);
    
    echo $result ? 1 : 0;
}

// Appointment blocks
if(@$_POST['formName']=='add_appointment_block'){
    $block_date = $_POST['block_date'];
    $block_start_time = $_POST['block_start_time'];
    $block_end_time = $_POST['block_end_time'];
    $block_staff_member_id = isset($_POST['block_staff_member_id']) && $_POST['block_staff_member_id'] != '' ? $_POST['block_staff_member_id'] : 'NULL';
    $block_reason = isset($_POST['block_reason']) ? $_POST['block_reason'] : '';
    $created_by = $_SESSION['user_id'];
    
    $query = "INSERT INTO appointment_blocks (block_date, block_start_time, block_end_time, block_staff_member_id, block_reason, created_by) VALUES ('$block_date', '$block_start_time', '$block_end_time', $block_staff_member_id, '$block_reason', $created_by)";
    $result = mysqli_query($connection, $query);
    
    echo $result ? 1 : 0;
}

if(@$_POST['formName']=='get_appointment_blocks'){
    $query = "SELECT b.*, u.user_name FROM appointment_blocks b LEFT JOIN users u ON b.block_staff_member_id = u.user_id WHERE b.block_status != 1 ORDER BY b.block_date DESC, b.block_start_time";
    $result = mysqli_query($connection, $query);
    
    $blocks = array();
    while($row = mysqli_fetch_array($result)){
        $blocks[] = array(
            'id' => $row['block_id'],
            'date' => date('d M Y', strtotime($row['block_date'])),
            'start_time' => date('h:i A', strtotime($row['block_start_time'])),
            'end_time' => date('h:i A', strtotime($row['block_end_time'])),
            'staff' => $row['user_name'],
            'reason' => $row['block_reason']
        );
    }
    
    echo json_encode($blocks);
}

if(@$_POST['formName']=='delete_appointment_block'){
    $block_id = $_POST['block_id'];
    
    $query = "UPDATE appointment_blocks SET block_status=1 WHERE block_id=$block_id";
    $result = mysqli_query($connection, $query);
    
    echo $result ? 1 : 0;
}

// Helper function
function getPurposeName($connection, $purpose_id){
    $query = "SELECT purpose_name FROM appointment_purposes WHERE purpose_id = $purpose_id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    return $row['purpose_name'];
}

// Course Cancellation Form Processing
if(@$_POST['formName']=='course_cancellation'){
    if(!function_exists('send_mail')){
        require_once('mail_function.php');
    }
    
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $family_name = mysqli_real_escape_string($connection, $_POST['family_name']);
    $given_names = mysqli_real_escape_string($connection, $_POST['given_names']);
    $residential_address = mysqli_real_escape_string($connection, $_POST['residential_address']);
    $post_code = mysqli_real_escape_string($connection, $_POST['post_code']);
    $contact_number = mysqli_real_escape_string($connection, $_POST['contact_number']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $date_of_birth = !empty($_POST['date_of_birth']) ? mysqli_real_escape_string($connection, $_POST['date_of_birth']) : NULL;
    $gender = !empty($_POST['gender']) ? mysqli_real_escape_string($connection, $_POST['gender']) : NULL;
    $course_code = !empty($_POST['course_code']) ? mysqli_real_escape_string($connection, $_POST['course_code']) : NULL;
    $course_title = !empty($_POST['course_title']) ? mysqli_real_escape_string($connection, $_POST['course_title']) : NULL;
    $date_of_enrolment = !empty($_POST['date_of_enrolment']) ? mysqli_real_escape_string($connection, $_POST['date_of_enrolment']) : NULL;
    $reason_for_cancellation = mysqli_real_escape_string($connection, $_POST['reason_for_cancellation']);
    $reason_other_details = !empty($_POST['reason_other_details']) ? mysqli_real_escape_string($connection, $_POST['reason_other_details']) : NULL;
    $cancellation_effective_date = mysqli_real_escape_string($connection, $_POST['cancellation_effective_date']);
    $cooling_off_period = mysqli_real_escape_string($connection, $_POST['cooling_off_period']);
    $account_type = !empty($_POST['account_type']) ? mysqli_real_escape_string($connection, $_POST['account_type']) : NULL;
    $bank_name = !empty($_POST['bank_name']) ? mysqli_real_escape_string($connection, $_POST['bank_name']) : NULL;
    $bsb = !empty($_POST['bsb']) ? mysqli_real_escape_string($connection, $_POST['bsb']) : NULL;
    $account_number = !empty($_POST['account_number']) ? mysqli_real_escape_string($connection, $_POST['account_number']) : NULL;
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $signature = mysqli_real_escape_string($connection, $_POST['signature']);
    $submission_date = mysqli_real_escape_string($connection, $_POST['submission_date']);
    
    $query = "INSERT INTO course_cancellations (title, family_name, given_names, residential_address, post_code, contact_number, email, date_of_birth, gender, course_code, course_title, date_of_enrolment, reason_for_cancellation, reason_other_details, cancellation_effective_date, cooling_off_period, account_type, bank_name, bsb, account_number, full_name, signature, submission_date) 
              VALUES ('$title', '$family_name', '$given_names', '$residential_address', '$post_code', '$contact_number', '$email', " . ($date_of_birth ? "'$date_of_birth'" : "NULL") . ", " . ($gender ? "'$gender'" : "NULL") . ", " . ($course_code ? "'$course_code'" : "NULL") . ", " . ($course_title ? "'$course_title'" : "NULL") . ", " . ($date_of_enrolment ? "'$date_of_enrolment'" : "NULL") . ", '$reason_for_cancellation', " . ($reason_other_details ? "'$reason_other_details'" : "NULL") . ", '$cancellation_effective_date', '$cooling_off_period', " . ($account_type ? "'$account_type'" : "NULL") . ", " . ($bank_name ? "'$bank_name'" : "NULL") . ", " . ($bsb ? "'$bsb'" : "NULL") . ", " . ($account_number ? "'$account_number'" : "NULL") . ", '$full_name', '$signature', '$submission_date')";
    
    $result = mysqli_query($connection, $query);
    $error = mysqli_error($connection);
    
    if($error != '' || !$result){
        echo '0';
    } else {
        $lastId = mysqli_insert_id($connection);
        $uniqueId = sprintf('CC%05d', $lastId);
        $updateQuery = mysqli_query($connection, "UPDATE course_cancellations SET cancellation_unique_id='$uniqueId' WHERE cancellation_id=$lastId");
        
        if(mysqli_error($connection) == ''){
            echo $uniqueId;
            
            // Send email
            $mail_to = $email;
            $mail_subject = "Course Cancellation Form Submitted - National College Australia";
            $mail_body = "Dear $given_names $family_name,<br><br>";
            $mail_body .= "Thank you for submitting your Course Cancellation Form.<br><br>";
            $mail_body .= "<b>Reference ID:</b> $uniqueId<br>";
            $mail_body .= "<b>Submission Date:</b> $submission_date<br><br>";
            $mail_body .= "Your cancellation request is being processed. You will be contacted shortly regarding the status of your application.<br><br>";
            $mail_body .= "If you have any questions, please contact Client Services.<br><br>";
            $mail_body .= "Best regards,<br>National College Australia";
            
            send_mail($mail_to, $mail_subject, $mail_body);
        } else {
            echo '0';
        }
    }
}

// Course Extension Form Processing
if(@$_POST['formName']=='course_extension'){
    if(!function_exists('send_mail')){
        require_once('mail_function.php');
    }
    
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $family_name = mysqli_real_escape_string($connection, $_POST['family_name']);
    $given_names = mysqli_real_escape_string($connection, $_POST['given_names']);
    $residential_address = mysqli_real_escape_string($connection, $_POST['residential_address']);
    $post_code = mysqli_real_escape_string($connection, $_POST['post_code']);
    $contact_number = mysqli_real_escape_string($connection, $_POST['contact_number']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $course_code = !empty($_POST['course_code']) ? mysqli_real_escape_string($connection, $_POST['course_code']) : NULL;
    $course_title = !empty($_POST['course_title']) ? mysqli_real_escape_string($connection, $_POST['course_title']) : NULL;
    $enrolment_date = !empty($_POST['enrolment_date']) ? mysqli_real_escape_string($connection, $_POST['enrolment_date']) : NULL;
    $reason_for_extension = mysqli_real_escape_string($connection, $_POST['reason_for_extension']);
    $reason_other_details = !empty($_POST['reason_other_details']) ? mysqli_real_escape_string($connection, $_POST['reason_other_details']) : NULL;
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $signature = mysqli_real_escape_string($connection, $_POST['signature']);
    $submission_date = mysqli_real_escape_string($connection, $_POST['submission_date']);
    
    // Extract extension duration from reason_other_details if it contains duration info
    $extension_duration = NULL;
    if($reason_other_details && preg_match('/(\d+)\s*(month|months|week|weeks|day|days)/i', $reason_other_details, $matches)){
        $extension_duration = $matches[0];
    }
    
    $query = "INSERT INTO course_extensions (title, family_name, given_names, residential_address, post_code, contact_number, email, course_code, course_title, enrolment_date, reason_for_extension, reason_other_details, extension_duration, full_name, signature, submission_date) 
              VALUES ('$title', '$family_name', '$given_names', '$residential_address', '$post_code', '$contact_number', '$email', " . ($course_code ? "'$course_code'" : "NULL") . ", " . ($course_title ? "'$course_title'" : "NULL") . ", " . ($enrolment_date ? "'$enrolment_date'" : "NULL") . ", '$reason_for_extension', " . ($reason_other_details ? "'$reason_other_details'" : "NULL") . ", " . ($extension_duration ? "'$extension_duration'" : "NULL") . ", '$full_name', '$signature', '$submission_date')";
    
    $result = mysqli_query($connection, $query);
    $error = mysqli_error($connection);
    
    if($error != '' || !$result){
        echo '0';
    } else {
        $lastId = mysqli_insert_id($connection);
        $uniqueId = sprintf('CE%05d', $lastId);
        $updateQuery = mysqli_query($connection, "UPDATE course_extensions SET extension_unique_id='$uniqueId' WHERE extension_id=$lastId");
        
        if(mysqli_error($connection) == ''){
            echo $uniqueId;
            
            // Send email
            $mail_to = $email;
            $mail_subject = "Course Extension Application Submitted - National College Australia";
            $mail_body = "Dear $given_names $family_name,<br><br>";
            $mail_body .= "Thank you for submitting your Application for Course Extension Form.<br><br>";
            $mail_body .= "<b>Reference ID:</b> $uniqueId<br>";
            $mail_body .= "<b>Submission Date:</b> $submission_date<br>";
            $mail_body .= "<b>Reason:</b> $reason_for_extension<br><br>";
            $mail_body .= "Your extension request is being reviewed. You will be contacted shortly regarding the status of your application.<br><br>";
            $mail_body .= "<strong>Please note:</strong> Course extension rollover fees apply. Please refer to www.nationalcollege.edu.au for fee information.<br><br>";
            $mail_body .= "If you have any questions, please contact Client Services.<br><br>";
            $mail_body .= "Best regards,<br>National College Australia";
            
            send_mail($mail_to, $mail_subject, $mail_body);
        } else {
            echo '0';
        }
    }
}

// Course Cancellations DataTable API
if(@$_GET['name']=='courseCancellations'){
    ob_clean();
    header('Content-Type: application/json');
    
    $query = "SELECT * FROM course_cancellations WHERE status = 0 ORDER BY created_date DESC";
    $result = mysqli_query($connection, $query);
    
    $data = array();
    while($row = mysqli_fetch_array($result)){
        $refundStatus = isset($row['refund_to_be_issued']) ? trim($row['refund_to_be_issued']) : '';
        $status = 'Pending';
        $statusClass = 'warning';
        
        if($refundStatus == 'Yes'){
            $status = 'Approved';
            $statusClass = 'success';
        } elseif($refundStatus == 'No' && $refundStatus != ''){
            $status = 'Processed';
            $statusClass = 'info';
        }
        
        // Show Process button only if not yet processed (refund_to_be_issued is empty or NULL)
        if($refundStatus == '' || $refundStatus == NULL){
            $action = '<button class="btn btn-sm btn-success btn-accept" data-id="'.$row['cancellation_id'].'"><i class="ti ti-check"></i> Process</button>';
        } else {
            $action = '<span class="badge bg-'.$statusClass.'">'.$status.'</span>';
        }
        
        $data[] = array(
            'reference_id' => $row['cancellation_unique_id'] ? $row['cancellation_unique_id'] : 'N/A',
            'name' => $row['given_names'] . ' ' . $row['family_name'],
            'email' => $row['email'],
            'contact_number' => $row['contact_number'],
            'course_code' => $row['course_code'] ? $row['course_code'] : '-',
            'course_title' => $row['course_title'] ? $row['course_title'] : '-',
            'reason' => $row['reason_for_cancellation'],
            'effective_date' => $row['cancellation_effective_date'] ? date('d M Y', strtotime($row['cancellation_effective_date'])) : '-',
            'cooling_off' => $row['cooling_off_period'],
            'status' => '<span class="badge bg-'.$statusClass.'">'.$status.'</span>',
            'submitted_date' => $row['submission_date'] ? date('d M Y', strtotime($row['submission_date'])) : '-',
            'action' => $action
        );
    }
    
    echo json_encode(array('data' => $data));
    exit;
}

// Course Extensions DataTable API
if(@$_GET['name']=='courseExtensions'){
    // Clear any previous output
    ob_clean();
    header('Content-Type: application/json');
    
    $query = "SELECT * FROM course_extensions WHERE status = 0 ORDER BY created_date DESC";
    $result = mysqli_query($connection, $query);
    
    $data = array();
    while($row = mysqli_fetch_array($result)){
        $extensionStatus = isset($row['extension_approved']) ? trim($row['extension_approved']) : '';
        $status = 'Pending';
        $statusClass = 'warning';
        
        if($extensionStatus == 'Yes'){
            $status = 'Approved';
            $statusClass = 'success';
        } elseif($extensionStatus == 'No' && $extensionStatus != ''){
            $status = 'Rejected';
            $statusClass = 'danger';
        }
        
        // Show Process button only if not yet processed (extension_approved is empty or NULL)
        if($extensionStatus == '' || $extensionStatus == NULL){
            $action = '<button class="btn btn-sm btn-success btn-accept" data-id="'.$row['extension_id'].'"><i class="ti ti-check"></i> Process</button>';
        } else {
            $action = '<span class="badge bg-'.$statusClass.'">'.$status.'</span>';
        }
        
        $data[] = array(
            'reference_id' => $row['extension_unique_id'] ? $row['extension_unique_id'] : 'N/A',
            'name' => $row['given_names'] . ' ' . $row['family_name'],
            'email' => $row['email'],
            'contact_number' => $row['contact_number'],
            'course_code' => $row['course_code'] ? $row['course_code'] : '-',
            'course_title' => $row['course_title'] ? $row['course_title'] : '-',
            'reason' => $row['reason_for_extension'],
            'enrolment_date' => $row['enrolment_date'] ? date('d M Y', strtotime($row['enrolment_date'])) : '-',
            'status' => '<span class="badge bg-'.$statusClass.'">'.$status.'</span>',
            'submitted_date' => $row['submission_date'] ? date('d M Y', strtotime($row['submission_date'])) : '-',
            'action' => $action
        );
    }
    
    echo json_encode(array('data' => $data));
    exit;
}

// Process Course Cancellation (Office Use Only)
if(@$_POST['formName']=='process_cancellation'){
    // Clear any previous output
    ob_clean();
    
    if(!function_exists('send_mail')){
        require_once('mail_function.php');
    }
    
    $cancellation_id = intval($_POST['cancellation_id']);
    $refund_to_be_issued = mysqli_real_escape_string($connection, $_POST['refund_to_be_issued']);
    $refund_approved_by = !empty($_POST['refund_approved_by']) ? mysqli_real_escape_string($connection, $_POST['refund_approved_by']) : NULL;
    $refund_approved_date = !empty($_POST['refund_approved_date']) ? mysqli_real_escape_string($connection, $_POST['refund_approved_date']) : NULL;
    $refund_amount = !empty($_POST['refund_amount']) ? floatval($_POST['refund_amount']) : NULL;
    $date_forwarded_to_finance = !empty($_POST['date_forwarded_to_finance']) ? mysqli_real_escape_string($connection, $_POST['date_forwarded_to_finance']) : NULL;
    $finance_initial = !empty($_POST['finance_initial']) ? mysqli_real_escape_string($connection, $_POST['finance_initial']) : NULL;
    $office_comments = !empty($_POST['office_comments']) ? mysqli_real_escape_string($connection, $_POST['office_comments']) : NULL;
    $processed_by = $_SESSION['user_id'];
    
    $updateQuery = "UPDATE course_cancellations SET 
        refund_to_be_issued = '$refund_to_be_issued',
        refund_approved_by = " . ($refund_approved_by ? "'$refund_approved_by'" : "NULL") . ",
        refund_approved_date = " . ($refund_approved_date ? "'$refund_approved_date'" : "NULL") . ",
        refund_amount = " . ($refund_amount ? $refund_amount : "NULL") . ",
        date_forwarded_to_finance = " . ($date_forwarded_to_finance ? "'$date_forwarded_to_finance'" : "NULL") . ",
        finance_initial = " . ($finance_initial ? "'$finance_initial'" : "NULL") . ",
        office_comments = " . ($office_comments ? "'$office_comments'" : "NULL") . ",
        modified_by = $processed_by,
        modified_date = CURDATE()
        WHERE cancellation_id = $cancellation_id";
    
    $result = mysqli_query($connection, $updateQuery);
    $error = mysqli_error($connection);
    
    if($error){
        echo '0';
        exit;
    }
    
    if($result && mysqli_affected_rows($connection) > 0){
        // Get student details for email
        $studentQuery = mysqli_query($connection, "SELECT * FROM course_cancellations WHERE cancellation_id = $cancellation_id");
        $student = mysqli_fetch_array($studentQuery);
        
        // Send email to student
        $mail_to = $student['email'];
        $mail_subject = "Course Cancellation Request - Update";
        $mail_body = "Dear " . $student['given_names'] . " " . $student['family_name'] . ",<br><br>";
        
        if($refund_to_be_issued == 'Yes'){
            $mail_body .= "Your Course Cancellation Request (Reference ID: " . $student['cancellation_unique_id'] . ") has been <strong>approved</strong>.<br><br>";
            if($refund_amount){
                $mail_body .= "<b>Refund Amount:</b> $" . number_format($refund_amount, 2) . "<br>";
            }
            $mail_body .= "Your refund will be processed according to our refund policy. You will be notified once the refund has been processed.<br><br>";
        } else {
            $mail_body .= "Your Course Cancellation Request (Reference ID: " . $student['cancellation_unique_id'] . ") has been <strong>processed</strong>.<br><br>";
            $mail_body .= "Please note that no refund will be issued as per our cancellation policy.<br><br>";
        }
        
        if($office_comments){
            $mail_body .= "<b>Comments:</b> " . $office_comments . "<br><br>";
        }
        
        $mail_body .= "If you have any questions, please contact Client Services.<br><br>";
        $mail_body .= "Best regards,<br>National College Australia";
        
        send_mail($mail_to, $mail_subject, $mail_body);
        
        echo '1';
    } else {
        echo '0';
    }
    exit;
}

// Process Course Extension (Office Use Only)
if(@$_POST['formName']=='process_extension'){
    // Clear any previous output
    ob_clean();
    
    if(!function_exists('send_mail')){
        require_once('mail_function.php');
    }
    
    $extension_id = intval($_POST['extension_id']);
    $extension_approved = mysqli_real_escape_string($connection, $_POST['extension_approved']);
    $application_approved_by = !empty($_POST['application_approved_by']) ? mysqli_real_escape_string($connection, $_POST['application_approved_by']) : NULL;
    $approval_initial = !empty($_POST['approval_initial']) ? mysqli_real_escape_string($connection, $_POST['approval_initial']) : NULL;
    $approval_date = !empty($_POST['approval_date']) ? mysqli_real_escape_string($connection, $_POST['approval_date']) : NULL;
    $rollover_fee = !empty($_POST['rollover_fee']) ? floatval($_POST['rollover_fee']) : NULL;
    $office_comments = !empty($_POST['office_comments']) ? mysqli_real_escape_string($connection, $_POST['office_comments']) : NULL;
    $processed_by = $_SESSION['user_id'];
    
    $updateQuery = "UPDATE course_extensions SET 
        extension_approved = '$extension_approved',
        application_approved_by = " . ($application_approved_by ? "'$application_approved_by'" : "NULL") . ",
        approval_initial = " . ($approval_initial ? "'$approval_initial'" : "NULL") . ",
        approval_date = " . ($approval_date ? "'$approval_date'" : "NULL") . ",
        rollover_fee = " . ($rollover_fee ? $rollover_fee : "NULL") . ",
        office_comments = " . ($office_comments ? "'$office_comments'" : "NULL") . ",
        modified_by = $processed_by,
        modified_date = CURDATE()
        WHERE extension_id = $extension_id";
    
    $result = mysqli_query($connection, $updateQuery);
    $error = mysqli_error($connection);
    
    if($error){
        echo '0';
        exit;
    }
    
    if($result && mysqli_affected_rows($connection) > 0){
        // Get student details for email
        $studentQuery = mysqli_query($connection, "SELECT * FROM course_extensions WHERE extension_id = $extension_id");
        $student = mysqli_fetch_array($studentQuery);
        
        // Send email to student
        $mail_to = $student['email'];
        $mail_subject = "Course Extension Application - Update";
        $mail_body = "Dear " . $student['given_names'] . " " . $student['family_name'] . ",<br><br>";
        
        if($extension_approved == 'Yes'){
            $mail_body .= "Your Application for Course Extension (Reference ID: " . $student['extension_unique_id'] . ") has been <strong>approved</strong>.<br><br>";
            if($rollover_fee){
                $mail_body .= "<b>Rollover Fee:</b> $" . number_format($rollover_fee, 2) . "<br>";
                $mail_body .= "Please arrange payment of the rollover fee. For payment details, please refer to www.nationalcollege.edu.au<br><br>";
            }
        } else {
            $mail_body .= "Your Application for Course Extension (Reference ID: " . $student['extension_unique_id'] . ") has been <strong>reviewed</strong>.<br><br>";
            $mail_body .= "Unfortunately, we are unable to offer an extension at this time.<br><br>";
        }
        
        if($office_comments){
            $mail_body .= "<b>Comments:</b> " . $office_comments . "<br><br>";
        }
        
        $mail_body .= "If you have any questions, please contact Client Services.<br><br>";
        $mail_body .= "Best regards,<br>National College Australia";
        
        send_mail($mail_to, $mail_subject, $mail_body);
        
        echo '1';
    } else {
        echo '0';
    }
    exit;
}

?>
