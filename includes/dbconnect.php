<?php
require_once __DIR__ . '/timezone_config.php';

$connection=mysqli_connect('localhost','root','','auz_dash');
// $connection= mysqli_connect("localhost","u593282393_enq_dash_new","U593282393_enq_dash_new","u593282393_enq_dash_new");
if ($connection) {
    crm_app_mysql_set_timezone($connection);
    
    // Check and add google_auth_secret column for users
    $chk_users = mysqli_query($connection, "SHOW COLUMNS FROM `users` LIKE 'google_auth_secret'");
    if ($chk_users && mysqli_num_rows($chk_users) == 0) {
        mysqli_query($connection, "ALTER TABLE `users` ADD COLUMN `google_auth_secret` VARCHAR(255) DEFAULT NULL");
    }
    
    // Check and add google_auth_secret column for student_users
    $chk_students = mysqli_query($connection, "SHOW COLUMNS FROM `student_users` LIKE 'google_auth_secret'");
    if ($chk_students && mysqli_num_rows($chk_students) == 0) {
        mysqli_query($connection, "ALTER TABLE `student_users` ADD COLUMN `google_auth_secret` VARCHAR(255) DEFAULT NULL");
    }
}
include_once __DIR__ . '/mail_function.php';
