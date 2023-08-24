<?php 
require('dbconnect.php');
session_start();
if(@$_POST['formName']=='logout'){
    session_destroy();
    header('Location: ../index.php');
}
if(@$_POST['formName']=='student_enquiry'){
$studentName=$_POST['studentName'];
$contactName=$_POST['contactName'];
$emailAddress=$_POST['emailAddress'];
$courses=$_POST['courses'];
$payment=$_POST['payment'];
$visaStatus=$_POST['visaStatus'];
$checkId=$_POST['checkId'];

if($checkId==0){

    $query=mysqli_query($connection,"INSERT INTO student_enquiry(st_name,st_phno,st_email,st_course,st_fee,st_visa_status)VALUES('$studentName','$contactName','$emailAddress',$courses,'$payment',$visaStatus)");
    $lastId=mysqli_insert_id($connection);
    $uniqueId=sprintf('EQ%05d', $lastId);
    $querys=mysqli_query($connection,"UPDATE student_enquiry SET st_enquiry_id='$uniqueId' WHERE st_id=$lastId");
    $error=mysqli_error($connection);
    if($error!=''){
        echo 0;
    }else{
        echo 1;
    }

}else{
    
    if(mysqli_query($connection,"UPDATE student_enquiry SET `st_name`='$studentName',`st_phno`='$contactName',`st_email`='$emailAddress',`st_course`=$courses,`st_fee`='$payment',`st_visa_status`=$visaStatus WHERE `st_id`=$checkId")){
        echo 2;
    }else{
        echo 0;
    }

}

}

if(@$_POST['formName']=='delete_enq'){
    $enq_id=$_POST['eq_id'];
    $query=mysqli_query($connection,"UPDATE `student_enquiry` SET `st_enquiry_status`=1 WHERE `st_id`=$enq_id");
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
$given_name=$_POST['given_name'];
$checkId=$_POST['checkId'];
$dateYear=date("Y");

if($checkId==0){

$query=mysqli_query($connection,"INSERT INTO student_enrolment(st_qualifications,st_enquiry_id,st_enrol_course,st_venue,st_middle_name,st_name,st_source,st_given_name)VALUES('$qualifications','$st_enquiry_id',$courseId,'$venue','$middle_name','$name_main',$source,'$given_name')");
$lastId=mysqli_insert_id($connection);
$uniqueId=sprintf($dateYear.$courseName.$courseId.'%04d', $lastId);
$querys=mysqli_query($connection,"UPDATE student_enrolment SET st_unique_id='$uniqueId' WHERE st_enrol_id=$lastId");
$error=mysqli_error($connection);
if($error!=''){
    echo 1;
}else{
    echo 0;
}

}else{

    if(mysqli_query($connection,"UPDATE student_enrolment SET `st_qualifications`='$qualifications',`st_enrol_course`=$courseId,`st_venue`='$venue',`st_middle_name`='$middle_name',`st_name`='$name_main',`st_source`=$source,`st_given_name`='$given_name' WHERE `st_enrol_id`=$checkId")){
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

$query=mysqli_query($connection,"INSERT INTO invoices(inv_std_name,st_unique_id,inv_course,inv_fee,inv_paid,inv_due,inv_payment_date)VALUES('$student_name','$enrol_id','$course_name','$course_fee','$amount_paid',$amount_due,'$payment_date')");
$lastId=mysqli_insert_id($connection);
$uniqueId=sprintf('INV%05d', $lastId);

$querys=mysqli_query($connection,"UPDATE invoices SET inv_auto_id='$uniqueId' WHERE inv_id=$lastId");

$error=mysqli_error($connection);
if($error!=''){
    echo 1;
}else{
    echo 0;
}
}
if(@$_POST['formName']=='login'){
$email=$_POST['email'];
$password=$_POST['password'];
$query=mysqli_query($connection,"SELECT user_id,user_type,user_name FROM users WHERE user_email='$email' AND user_password='$password'");
$error=mysqli_error($connection);
$id=mysqli_fetch_array($query);
if($id['user_id']=='' || $id['user_id']=='undefined'){
    echo 1;
}else{
    $_SESSION['user_id']=$id['user_id'];
    $_SESSION['user_type']=$id['user_type'];
    $_SESSION['user_name']=$id['user_name'];
    echo 0;
}
}
if(@$_REQUEST['name']=='studentEnquiry'){
    $enquiries['data']=[];
    $query=mysqli_query($connection,"SELECT * from student_enquiry where st_enquiry_status!=1");
    while($queryRes=mysqli_fetch_array($query)){

        if($queryRes['st_course']==1){
            $course='Basic';
        }else if($queryRes['st_course']==2){
            $course='Intermediate';
        }else{
            $course='Expert';
        }

        if($queryRes['st_visa_status']==1){
            $visaStatus='<i class="mdi mdi-checkbox-blank-circle text-warning me-1"></i> Pending';
        }else if($queryRes['st_visa_status']==2){
            $visaStatus='<i class="mdi mdi-checkbox-blank-circle text-success me-1"></i> Approved';
        }else{
            $visaStatus='<i class="mdi mdi-checkbox-blank-circle text-danger me-1"></i> Declined';
        }

        $view='<button type="button" data="'.$queryRes['st_id'].'" class="btn btn-outline-primary btn-sm edit_enq" style="margin-right:10px;"><a href="student_enquiry.php?eq='.base64_encode($queryRes['st_id']).'">Edit</a></button><button onclick="delete_enq('.$queryRes['st_id'].')" type="button" class="btn btn-outline-danger btn-sm">Delete</button>';

        array_push($enquiries['data'],array('st_enquiry_id'=>$queryRes['st_enquiry_id'],'std_name'=>$queryRes['st_name'], 'std_phno'=>$queryRes['st_phno'],'std_email'=>$queryRes['st_email'],'std_course'=>$course,'std_fee'=>$queryRes['st_fee'],'std_visa_status'=>$visaStatus,'action'=>$view));
        
    }
    header("Content-Type: application/json");
    echo json_encode($enquiries);
}
if(@$_REQUEST['name']=='student_invoices'){
    $invoices['data']=[];
    $query=mysqli_query($connection,"SELECT * from invoices");
    while($queryRes=mysqli_fetch_array($query)){

        if($queryRes['inv_course']==1){
            $course='Basic';
        }else if($queryRes['inv_course']==2){
            $course='Intermediate';
        }else{
            $course='Expert';
        }

        array_push($invoices['data'],array('inv_std_name'=>$queryRes['inv_std_name'], 'inv_fee'=>$queryRes['inv_fee'],'inv_paid'=>$queryRes['inv_paid'],'inv_course'=>$course,'inv_due'=>$queryRes['inv_due'],'inv_payment_date'=>$queryRes['inv_payment_date']));
        
    }
    header("Content-Type: application/json");
    echo json_encode($invoices);
}


if(@$_POST['name']=='uploadExcel'){

print_r($_FILES);

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

        array_push($enrol['data'],array('st_enrol_name'=>$queryRes['st_name'], 'st_enrol_givenname'=>$queryRes['st_given_name'],'st_enrol_middlename'=>$queryRes['st_middle_name'],'st_enrol_qual'=>$qualifications,'st_enrol_venue'=>$venue,'st_enrol_source'=>$source,'action'=>$view));
        
    }
    header("Content-Type: application/json");
    echo json_encode($enrol);
}

?>