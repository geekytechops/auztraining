<?php
require_once __DIR__ . '/timezone_config.php';

$connection=mysqli_connect('localhost','root','','auztraining');
// $connection= mysqli_connect("localhost","u593282393_enq_dash_new","U593282393_enq_dash_new","u593282393_enq_dash_new");
if ($connection) {
    crm_app_mysql_set_timezone($connection);
}
include('mail_function.php');
