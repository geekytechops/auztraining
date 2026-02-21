<?php
session_start();
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'student'){
    unset($_SESSION['user_id'], $_SESSION['user_type'], $_SESSION['user_name']);
}
header('Location: student_login.php');
exit;
