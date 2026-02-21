<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] === ''){
    header('Location: student_login.php');
    exit;
}
if(empty($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student'){
    header('Location: student_login.php');
    exit;
}
// Send students to the dedicated student enquiry page (empty form or their enquiry).
header('Location: student_enquiry_form.php');
exit;
