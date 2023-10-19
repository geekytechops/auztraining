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
if(@$_POST['formName']=='student_enrols'){
    $formData=json_decode($_POST['details']);

    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $final_image = rand(1000, 1000000) . $img;
    $path = 'uploads/';
    $path = $path . strtolower($final_image);
    move_uploaded_file($tmp, $path);

    $enquiry_id=$formData->enquiry_id;
    $rto_name=$formData->rto_name;
    $courses=json_encode($formData->courses);
    $branch_name=$formData->branch_name;
    $photo=$final_image;
    $given_name=$formData->given_name;
    $surname=$formData->surname;
    $dob=$formData->dob;
    $birth_country=$formData->birth_country;
    $street_details=$formData->street_details;
    $sub_urb=$formData->sub_urb;
    $post_code=$formData->post_code;
    $tel_num=$formData->tel_num;
    $mobile_num=$formData->mobile_num;
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
    $qual_name_10_other = $formData->qual_name_10_other;
    $qual_name_9_other = $formData->qual_name_9_other;
    $lan_spoken_other = $formData->lan_spoken_other;
    $st_disability_type = json_encode($formData->st_disability_type);
    $disability_type_other = $formData->disability_type_other;
    $admin_id=$_SESSION['user_id'];


    $query="INSERT INTO `student_enrolments`(`st_unique_id`, `st_enquiry_id`, `st_rto_name`, `st_courses`, `st_branch`, `st_photo`, `st_given_name`, `st_surname`, `st_dob`, `st_country_birth`, `st_street`, `st_suburb`, `st_state`, `st_post_code`, `st_tel_num`, `st_email`, `st_mobile`, `st_emerg_name`, `st_emerg_relation`, `st_emerg_mobile`, `st_emerg_agree`, `st_usi`, `st_emp_status`, `st_self_status`, `st_citizenship`, `st_gender`, `st_credit_transfer`, `st_highest_school`, `st_secondary_school`, `st_born_country`, `st_born_country_other`, `st_origin`, `st_lan_spoken`, `st_lan_spoken_other`, `st_disability`, `st_disability_type`, `st_disability_type_other`, `st_study_reason`, `st_study_reason_other`, `st_qual_1`, `st_qual_2`, `st_qual_3`, `st_qual_4`, `st_qual_5`, `st_qual_6`, `st_qual_7`, `st_qual_8`, `st_qual_9`, `st_qual_10`, `st_qual_8_other`, `st_qual_9_other`, `st_qual_10_other`, `st_created_by`) VALUES ('1','$enquiry_id','$rto_name','$courses','$branch_name','$photo','$given_name','$surname','$dob','$birth_country','$street_details','$sub_urb','$stu_state','$post_code','$tel_num','$emailAddress','$mobile_num','$em_full_name','$em_relation','$em_mobile_num','$em_agree_check','$usi_id','$emp_status','$self_status','$st_citizen','$gender_check','$cred_tansf','$highest_school','$sec_school','$born_country','$st_born_country','$origin','$lan_spoken','$lan_spoken_other','$disability','$st_disability_type','$disability_type_other','$study_reason','$study_reason_other','$qual_1','$qual_2','$qual_3','$qual_4','$qual_5','$qual_6','$qual_7','$qual_8','$qual_9','$qual_10','$qual_name_8_other','$qual_name_9_other','$qual_name_10_other',$admin_id);";

    echo $query;
    $queryExec=mysqli_query($connection,$query);
    $lastId=mysqli_insert_id($connection);

    echo $lastId;

    // $courseID=mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM courses WHERE course_id=$courseId"));

    // $uniqueId=sprintf($dateYear.$courseID['course_sname'].'%04d', $lastId);

    // $querys=mysqli_query($connection,"UPDATE student_enrolment SET st_unique_id='$uniqueId' WHERE st_enrol_id=$lastId");
    // $error=mysqli_error($connection);
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
            $state_name= $st_states[$selectDataQry['st_state']];
            
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
            $tbody.='</tr>';
        }
    }

    echo $tbody;

}


?>
