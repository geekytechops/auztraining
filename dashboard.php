<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
// print_r($_SESSION);
if(isset($_SESSION['user_type'])){

    $courses=mysqli_query($connection,"SELECT * from courses where course_status!=1");
    $filterCols=mysqli_fetch_array(mysqli_query($connection,"SELECT GROUP_CONCAT(column_name SEPARATOR ',') as column_names FROM information_schema.COLUMNS WHERE table_name LIKE 'student_enquiry'"));
    $filterColsArray=explode(',',$filterCols['column_names']);

    $filterDropDown=['Student ID','Student Name','Contact Number','Email','Course Type','Date','States','Course','Visa Condition','Visa Status'];
    
    $filterCols2=mysqli_fetch_array(mysqli_query($connection,"SELECT GROUP_CONCAT(column_name SEPARATOR ',') as column_names FROM information_schema.COLUMNS WHERE table_name LIKE 'slot_book'"));
    $filterCols2Array=explode(',',$filterCols2['column_names']);

    $filterDropDown2=['Student Name','Enquiry ID','Phone','Email','Purpose','Booked by','Sent Link','Appointment Time'];
    
    $filterCols3=mysqli_fetch_array(mysqli_query($connection,"SELECT GROUP_CONCAT(column_name SEPARATOR ',') as column_names FROM information_schema.COLUMNS WHERE table_name LIKE 'counseling_details'"));
    $filterCols3Array=explode(',',$filterCols3['column_names']);

    $filterDropDown3=['Student Name','Enquiry ID','Phone','Email','Type','Team Member','Start Date','End Date'];

    $enquriesConvQry=mysqli_query($connection,"SELECT (SELECT COUNT(*) FROM student_enquiry WHERE st_enquiry_id NOT IN (SELECT st_enquiry_id FROM student_enrolment WHERE st_enquiry_id != '')) AS not_converted, (SELECT COUNT(*) FROM student_enquiry WHERE st_enquiry_id IN (SELECT st_enquiry_id FROM student_enrolment WHERE st_enquiry_id != '')) AS converted");

    $enquriesConv=mysqli_fetch_array($enquriesConvQry);

    if($enquriesConv['converted']!=0 && $enquriesConv['not_converted']!=0){

        $converted=round((intval($enquriesConv['converted']) / intval($enquriesConv['not_converted'])+intval($enquriesConv['converted'])))* 100;    
        $notconverted=round((intval($enquriesConv['not_converted']) / intval($enquriesConv['not_converted']+$enquriesConv['converted']))) * 100;
        $totalEnq=intval($enquriesConv['not_converted'])+intval($enquriesConv['converted']);
        $per_conv= round((intval($enquriesConv['converted'])/$totalEnq)*100);        
        $per_notconv= round((intval($enquriesConv['not_converted'])/$totalEnq)*100);        

    }else{

                
        $converted=0;    
        $notconverted=0;
        $totalEnq=0;
        $per_conv= 0;        
        $per_notconv= 0;        


    }

    $totalTimeCounsil=mysqli_query($connection,"SELECT SUM(TIMESTAMPDIFF(DAY, counsil_timing, counsil_end_time)) AS days, SUM(TIMESTAMPDIFF(HOUR, counsil_timing, counsil_end_time)) % 24 AS hours, SUM(TIMESTAMPDIFF(MINUTE, counsil_timing, counsil_end_time)) % 60 AS mins FROM `counseling_details` WHERE `counsil_enquiry_status` = 0;");
    $timeSpent=mysqli_fetch_array($totalTimeCounsil);
    if($timeSpent['days']!=0 || $timeSpent['days']!=''){        
        $timeSpentRes=$timeSpent['days'];
        $timeSpentHrsRes=$timeSpent['hours'];
        $timeSpentMnsRes=$timeSpent['mins'];
    }else{
        $timeSpentRes=0;
        $timeSpentHrsRes=0;
        $timeSpentMnsRes=0;
    }

?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" /> 

        <?php 
        include('includes/app_includes.php');
         ?>
        <style>
            #filter-dropdowns td{
                margin:0;
                padding:0;
                padding-top:1rem;
            }
            #filter-dropdowns .dropdown-toggle{
                padding: 3px 10px 3px 10px;;
            }
            tbody tr td:nth-child(5) {
                white-space: break-spaces;
                width:20%;
            }
            #datatable tbody tr td:nth-child(7) {
                white-space: break-spaces;
                width:10%;
            }
            #datatable tbody tr td:nth-child(3) {
                white-space: break-spaces;
                width:10%;
            }


.container {
  overflow: scroll;
  height: 80vh;
  margin-top:2rem;
  /* width: 300px; */
}

#appointments_table , #counsel_table,#table-filter {
  border-collapse: collapse;
}

#table-filter th,
#table-filter td, #appointments_table th , #appointments_table td, #counsel_table th , #counsel_table td {
  max-width: 300px;
  padding: 8px 16px;
  border: 1px solid #ddd;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

#table-filter thead ,#appointments_table thead ,#counsel_table thead {
  position: sticky;
  inset-block-start: 0;
  background-color: #ddd;
}

            #table-filter::-webkit-scrollbar-track
            {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                background-color: #F2F2F2;
                border-radius:5px;
            }

            #table-filter::-webkit-scrollbar
            {
                width: 10px;
                height:5px;
                background-color: #F2F2F2;
            }

            #table-filter::-webkit-scrollbar-thumb
            {
                background-color: var(--color);
                border: 2px solid var(--color);
                border-radius:5px;
            }
       </style>

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
                                    <h4 class="mb-sm-0">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li> -->
                                            <!-- <li class="breadcrumb-item active">Light Sidebar</li> -->
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <?php 
                        if($_SESSION['user_type']==1){
                        ?>

                        <div class="row">
                            <div class="col-xl-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Enquiry Records</h5>
                                            <div>
                                                <ul class="list-unstyled">
                                                    <li class="py-3">
                                                        <div class="d-flex">
                                                            <div class="avatar-xs align-self-center me-3">
                                                                <div class="avatar-title rounded-circle bg-light text-primary font-size-18">
                                                                    <i class="ri-checkbox-circle-line"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex justify-content-between"><p class="text-muted mb-2">Converted</p><p><?php echo $enquriesConv['converted']; ?></p></div>
                                                                <div class="progress progress-sm animated-progess">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $per_conv; ?>%" aria-valuenow="<?php echo $per_conv; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalEnq; ?>"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="py-3">
                                                        <div class="d-flex">
                                                            <div class="avatar-xs align-self-center me-3">
                                                                <div class="avatar-title rounded-circle bg-light text-primary font-size-18">
                                                                    <i class="ri-calendar-2-line"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between"><p class="text-muted mb-2">Not Converted</p><p><?php echo $enquriesConv['not_converted']; ?></p></div>
                                                                <div class="progress progress-sm animated-progess">
                                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $per_notconv; ?>%" aria-valuenow="<?php echo $per_notconv; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalEnq; ?>"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- end card-body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                        <i class="ri-group-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Total Counselings Time</p>
                                                <h5 class="mb-3"><?php echo $timeSpentRes.' Days '. $timeSpentHrsRes.' Hours '.$timeSpentMnsRes.' Minutes';  ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <h4 class="card-title">Student Records</h4> -->

                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    Student Enquiries
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table id="datatable" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Enquiry ID</th>
                                                                    <th>Student Name</th>
                                                                    <th>Contact Number</th>
                                                                    <th>Email</th>
                                                                    <th>Street</th>
                                                                    <th>Sub Urb</th>
                                                                    <th>Post Code</th>
                                                                    <th>Course</th>
                                                                    <th>Plan to Start</th>
                                                                    <th>Course Type</th>
                                                                    <th>Visited Before</th>
                                                                    <th>Refered By</th>
                                                                    <th>Fee</th>
                                                                    <th>Appointment</th>
                                                                    <th>Visa Status</th>
                                                                    <th>Visa Condiition</th>
                                                                    <th>Staff Comments</th>
                                                                    <th>Preferences Or Requirements</th>
                                                                    <th>Remarks</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Follow Up Calls
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                            <table id="datatable_followup" class="table table-striped table-bordered  nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Enquiry ID</th>
                                                                <th scope="col">Student Name</th>
                                                                <th scope="col">Contact Number</th>
                                                                <th scope="col">Contacted Person</th>
                                                                <th scope="col">Contacted Time</th>
                                                                <th scope="col">Date</th>
                                                                <th scope="col">Mode of Contact</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_counsel" aria-expanded="false" aria-controls="collapse_counsel">
                                                    Counselings
                                                    </button>
                                                </h2>
                                                <div id="collapse_counsel" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                            <table id="datatable_counseling" class="table table-striped table-bordered  nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Team Member Name</th>
                                                                <th scope="col">Counseling Type</th>
                                                                <th scope="col">Currently Working</th>
                                                                <th scope="col">Visa Condition</th>
                                                                <th scope="col">Education</th>
                                                                <th scope="col">Counseling Date</th>
                                                                <th scope="col">Time Spent</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accordion -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Counseling</h4>

                                        <div class="row mb-3 d-flex">
                                        <div class="col-lg-10 d-flex">

                                            <div class="columns-report" style="margin-right:1rem">
                                               <select class="selectpicker boot-select" title="Columns" data-live-search="true" id="counsel_select" >
                                                <option value="<?php echo $filterCols3Array['2']; ?>" id="option_2" data-value="2" data-name="Team Member">Team Member</option>
                                                <option value="<?php echo $filterCols3Array['15']; ?>" id="option_15" data-value="15" data-name="Counseling Type">Counseling Type</option>
                                                <option value="<?php echo $filterCols3Array['22']; ?>" id="option_22" data-value="22" data-name="Date">Date</option>
                                               </select> 
                                            </div>
                                            <div class="columns-report counsel_input" style="margin-right:1rem">
                                                <input type="text" id="counsel_column_2" placeholder="value" class="counsel_column_value form-control">
                                                <input type="text" id="counsel_column_22" placeholder="value" class="counsel_column_value form-control">
                                                <select name="counsel_column_15" class="counsel_column_value form-select" title="Counsel Type" id="counsel_column_15" style="width:auto;">
                                                <option value="1" data="1">Face to Face</option>
                                                <option value="2" data="2">Video</option>
                                                </select> 
                                                <!-- <input type="text" id="counsel_column_15" placeholder="value" class="counsel_column_value form-control"> -->
                                            </div>
                                            <div class="columns-report" style="margin-right:1rem">
                                            <button type="button" class="btn btn-success" id="submit_column3_filter">Submit</button>
                                            </div>
                                            </div>
                                            <div class="col-lg-2"><button type="button" class="btn btn-secondary" id="counsel_export">Export <i class="fas fa-file-export export-filter"></i></button></div>

                                        </div>
                                        <div class="row counsel-badges-div mb-3 align-items-start">
                                        </div>  
                                    <div class="container" style="height:30vh">
                                        <table id="counsel_table" >
                                            <thead>
                                                <tr>
                                                <?php
                                                
                                                foreach($filterDropDown3 as $key=>$value){
                                                    if($key>=5){
                                                        $class="";
                                                    }else{
                                                        $class="";
                                                    }
                                                    echo "<th class='$class'>$value</th>";
                                                }

                                                ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Appointments</h4>

                                        <div class="row mb-3 d-flex">
                                        <div class="col-lg-10 d-flex">
                                            <div class="columns-report" style="margin-right:1rem">
                                               <select class="selectpicker boot-select" title="Columns" data-live-search="true" id="appoint_select" >
                                                <option value="<?php echo $filterCols2Array['5']; ?>" id="option_5" data-value="5" data-name="Team Member">Team Member</option>
                                                <option value="<?php echo $filterCols2Array['2']; ?>" id="option_2" data-value="2" data-name="Booking Date">Booking Date</option>
                                               </select> 
                                            </div>
                                            <div class="columns-report appoint_input" style="margin-right:1rem">
                                                <input type="text" id="appoint_column_5" placeholder="value" class="appoint_column_value form-control">
                                                <input type="text" id="appoint_column_2" placeholder="value" class="appoint_column_value form-control">
                                            </div>
                                            <div class="columns-report" style="margin-right:1rem">
                                            <button type="button" class="btn btn-success" id="submit_column2_filter">Submit</button>
                                            </div>
                                            </div>
                                            <div class="col-lg-2"><button type="button"  class="btn btn-secondary" id="appoint_export">Export <i class="fas fa-file-export export-filter"></i></button></div>
                                        </div>
                                        <div class="row appoint-badges-div mb-3 align-items-start">
                                        </div>  
                                        <div class="container" style="height:30vh">
                                        <table id="appointments_table">
                                            <thead>
                                                <tr>
                                                <?php
                                                
                                                foreach($filterDropDown2 as $key=>$value){
                                                    if($key>=5){
                                                        $class="";
                                                        // $class="imp-none";
                                                    }else{
                                                        $class="";
                                                    }
                                                    echo "<th class='$class'>$value</th>";
                                                }

                                                ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>             

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Student Details Export</h4>                                          
                                        <div class="row mb-3">
                                            <div class="columns-report">
                                               <select class="selectpicker boot-select" title="Columns" data-live-search="true" id="column_select" >
                                                <?php 
                                                $count=0;                                                                            
                                                ?>
                                                <option value="<?php echo $filterColsArray['1']; ?>" id="option_1" data-value="1" data-name="Enquiry ID">Enquiry ID</option>
                                                <option value="<?php echo $filterColsArray['5']; ?>" id="option_5" data-value="5" data-name="Phone">Phone</option>
                                                <option value="<?php echo $filterColsArray['8']; ?>" id="option_8" data-value="8" data-name="Course Type">Course Type</option>
                                                <option value="<?php echo $filterColsArray['7']; ?>" id="option_7" data-value="7" data-name="Course">Course</option>
                                                <option value="<?php echo $filterColsArray['11']; ?>" id="option_11" data-value="11" data-name="States">States</option>
                                                <option value="<?php echo $filterColsArray['14']; ?>" id="option_14" data-value="14" data-name="Heared From">Heared From</option>
                                                <option value="<?php echo $filterColsArray['22']; ?>" id="option_22" data-value="22" data-name="Ethinicity">Ethinicity</option>
                                                <option value="<?php echo $filterColsArray['35']; ?>" id="option_35" data-value="35" data-name="Date">Date</option>
                                                <?php  ?>
                                               </select> 
                                            </div>
                                            <div class="columns-report input-div">
                                                <input type="text" id="column_1" placeholder="value" class="column_value form-control">
                                                <input type="text" id="column_5" placeholder="value" class="column_value form-control">
                                                <input type="text" id="column_22" placeholder="value" class="column_value form-control">
                                                <input type="text" id="column_35" placeholder="value" class="column_value form-control">
                                                <select name="column_8" class="column_value form-select" title="Course Type" id="column_8" style="width:auto;">
                                                        <?php  
                                                        $st_course_type=['-- select --','Rpl','Regular','Regular - Group','Short courses','Short course - Group'];
                                                        for($i=0;$i<count($st_course_type);$i++){     
                                                            $count=$i;                                                       
                                                            echo '<option value="'.$count.'" data="'.$st_course_type[$i].'">'.$st_course_type[$i].'</option>';
                                                        }
                                                        ?>
                                                </select> 
                                                <select name="column_7" class="column_value form-select" title="States" id="column_7" style="width:auto;">
                                                <?php 
                                                    $counts=1;
                                                    while($coursesRes=mysqli_fetch_array($courses)){                                                        

                                                        $course_name=$coursesRes['course_name'].' - '.$coursesRes['course_sname'];
                                                        echo '<option value="'.$count.'" data="'.$course_name.'">'.$course_name.'</option>';
                                                        $counts++;
                                                    }

                                                    ?>
                                                </select> 
                                                <select name="column_11" class="column_value form-select" title="States" id="column_11" style="width:auto;">
                                                        <?php  
                                                        $st_states=['--select--','NSW - New South Wales','VIC - Victoria','ACT - Australian Capital Territory','NT - Northern Territoy','WA - Western Australia','QLD - Queensland','SA - South Australia','TAS - Tasmania'];
                                                        for($i=0;$i<count($st_states);$i++){     
                                                            $count=$i;                                                       
                                                            echo '<option value="'.$count.'" data="'.$st_states[$i].'">'.$st_states[$i].'</option>';
                                                        }
                                                        ?>
                                                </select> 
                                                <select name="column_14" class="column_value form-select" title="Heared From" id="column_14" style="width:auto;">
                                                        <?php  
                                                        $st_heared=['Word of Mouth','Family or Friends','Website','Gumtree','Facebook','Instagram','Linkedin','Mail outs','Migration Agency','Other:'];
                                                        for($i=0;$i<count($st_heared);$i++){     
                                                            $count=$i;                                                       
                                                            echo '<option value="'.$count.'" data="'.$st_heared[$i].'">'.$st_heared[$i].'</option>';
                                                        }
                                                        ?>
                                                </select> 
                                            </div>
                                            <div class="columns-report">
                                            <button type="button" class="btn btn-success" id="submit_column_filter">Submit</button>
                                            </div>
                                        </div>
                                        <div class="row badges-div align-items-start">
                                        </div>        
                                        <hr class="bg-dark border-2 border-top border-dark">
                                        <div class="row align-items-end">
                                            <div class="col-md-12">
                                                <div class="filter-options text-end">
                                                    <div style="margin-right: 1rem;margin-top: 0.5rem;">
                                                        <strong>Total Records: </strong><span id="total_filter_records"></span>
                                                    </div>
                                                    <div class="btn-group">
                                                        <i class="fas fa-filter dropdown-toggle" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                                        <div class="dropdown-menu">
                                                            <select name="filter-select" class="selectpicker boot-select" data-selected-text-format="count" multiple id="filter-select" title="Filter Columns">
                                                                <?php
                                                                
                                                                foreach($filterDropDown as $key=>$value){
                                                                    if($key<=4){
                                                                        $select='selected';
                                                                    }else{
                                                                        $select='';
                                                                    }
                                                                    $key=$key+1;
                                                                    echo "<option value='$key' class='filter-opt' $select>$value</option>";
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-file-export export-filter"></i>
                                                    </div>
                                                </div>    
                                        <div class="container">                                                
                                            <table id="table-filter" class="table nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <?php
                                                                
                                                    foreach($filterDropDown as $key=>$value){
                                                        if($key>=5){
                                                            $class="imp-none";
                                                        }else{
                                                            $class="";
                                                        }
                                                        echo "<th class='$class'>$value</th>";
                                                    }

                                                    ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="student_filter_body">
                                                </tbody>
                                            </table>
                                            </div>
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-none">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Student Filter</h4>  
                                        <div class="row align-items-end">
                                            <div class="col-md-8">
                                                <div class="row mt-2 mb-2 align-items-end">
                                                    <div class="col-md-4">
                                                        <label for="from_date">From:</label>
                                                    <input type="date" class=" form-control" id="from_date">
                                                    </div>                                            
                                                    <div class="col-md-4">
                                                    <label for="to_date">To:</label>
                                                    <input type="date" class="form-control" id="to_date">
                                                    </div>                                            
                                                    <div class="col-md-4">
                                                    <button id="date_filter" class="btn btn-dark ms-2" >Filter </button>
                                                    </div>
                                                </div>
                                                <span class="error-feedback" id="date_error" style="margin-left: 4px;font-size: 12px;">select the dates to filter</span>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                <div class="col-md-4">                                            
                                                <button id="student_filter" class="btn btn-dark ms-2">Export <i class="align-middle ms-2 mdi mdi-printer" ></i></button>
                                                </div>   
                                                <div class="col-md-8">
                                                <input type="search" class="form-control" id="filter_input" placeholder="Search table">
                                                </div>
                                                </div>
                                            </div>
                                        </div>                                     
                                        <div class="print_header"></div>                                           
                                    </div>
                                </div>
                            </div>
                        </div>                
            <?php }else{ 
                            
                $enrolId=$_SESSION['user_log_id'];
                $queryRess=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enrolment where st_enrol_status!=1 and st_unique_id='$enrolId'"));
                $selectQry=mysqli_query($connection,"SELECT st_unique_id,st_doc_names FROM `student_docs` WHERE `st_unique_id`='$enrolId'");
                $course_id=$queryRess['st_enrol_course'];
                $courses=mysqli_fetch_array(mysqli_query($connection,"SELECT * from courses where course_status!=1 AND course_id=$course_id"));                                
            ?>

                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="validationCustom01">Student ID</label>
                                                    <div class="">
                                                        <?php echo $_SESSION['user_log_id'];  ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                <label class="form-label" for="validationCustom01">Name</label>
                                                    <div class="">
                                                        <?php echo $queryRess['st_given_name'].' '.$queryRess['st_middle_name'];  ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                <label class="form-label" for="validationCustom01">Phone Number</label>
                                                    <div class="">
                                                        <?php echo $queryRess['st_mobile'];  ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                <label class="form-label" for="validationCustom01">Email</label>
                                                    <div class="">
                                                        <?php echo $queryRess['st_email'];  ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="validationCustom01">Enquiry ID</label>
                                                    <div class="">
                                                        <?php echo $queryRess['st_enquiry_id'];  ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                <label class="form-label" for="validationCustom01">Enroled Date</label>
                                                    <div class="">
                                                        <?php echo $queryRess['created_date'];  ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                <label class="form-label" for="validationCustom01">Course</label>
                                                    <div class="">
                                                        <?php echo $courses['course_name'];  ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                            <?php } ?>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <script></script>

        <?php include('includes/footer_includes.php'); ?>

<script>
$(function() {
    var options = {};
    options.ranges = {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            };
    $('#column_35 , #appoint_column_2, #counsel_column_22').daterangepicker(options);
});
    </script>

        <?php 
        if($_SESSION['user_type']==1){
        ?>
        <script>

            // $(document).on('click','#date_filter',function(){
            //     var from_date=$('#from_date').val();
            //     var to_date=$('#to_date').val();

            //     if(from_date=='' && to_date==''){
            //         $('#date_error').show();
            //         return false;
            //     }else{
            //         $('#date_error').hide();                    
            //     }

            //     if(from_date==''){

            //         from_date='1900-01-01';                    

            //     }

            //     if(to_date==''){

            //         var currentDate = new Date();

            //         to_date = currentDate.getFullYear() + '-' + 
            //         ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + 
            //         ('0' + currentDate.getDate()).slice(-2);           

            //     }


            //     $.ajax({
            //         type:'post',
            //         url:"includes/datacontrol.php",
            //         data:{formName:"date_filter",from_date:from_date,to_date:to_date},
            //         success:function(data){
            //             $('#student_filter_body').html(data);                                                
            //         }
            //     })
            // })

            // $(document).on('change','.change_select',function(){
            //     var visa_status= $('#visa_status_select').val()=='' ? 0 : $('#visa_status_select').val();
            //     var appointment_status= $('#appointment_select').val()=='' ? 0 : $('#appointment_select').val();
            //     var course_type_status= $('#course_type_select').val()=='' ? 0 : $('#course_type_select').val();
            //     var state_status= $('#state_select').val()=='' ? 0 : $('#state_select').val();
            //     $.ajax({
            //         type:'post',
            //         url:'includes/datacontrol.php',
            //         data:{visa_status:visa_status,state_status:state_status,course_type_status:course_type_status,appointment_status:appointment_status,formName:'student_filter'},
            //         success:function(data){
            //             $('#student_filter_body').html(data);
            //         }
            //     })
            // })

            async function delete_enq(tableName,colPrefix,eq_id){

                Swal.fire({
                    icon: 'warning',
                    title: 'Are you Sure ?',
                    input: 'text',
                    showCancelButton:!0,
                    inputPlaceholder: 'Reason to Delete',
                    confirmButtonText:"Delete!",
                    confirmButtonColor:"#1cbb8c",
                    cancelButtonColor:"#ff3d60",
                    inputValidator: (value) => {
                        if (!value) {
                        return 'You need to write something!'
                        }
                    }
                    }).then(function(t){
                        if(t.isConfirmed){
                            deleteFun(tableName,colPrefix,eq_id,t.value);
                        }
                    })
                }

                function deleteFun(tableName,colPrefix,eq_id,note){

                $.ajax({
                    type:'post',
                    data:{eq_id:eq_id,tableName:tableName,colPrefix:colPrefix,note:note,formName:'delete_enq'},
                    url:'includes/datacontrol.php',
                    success:function(data){
                        if(data==1){
                        var table = $('#datatable').DataTable();
                            table.ajax.reload();
                        var table = $('#datatable_followup').DataTable();
                            table.ajax.reload();
                        var table = $('#datatable_counseling').DataTable();
                            table.ajax.reload();
                        }else{
                            alert('Something went wrong. Please try again');
                        }
                    }
                })
            }


            function delete_enrol(enrol_id){
                $.ajax({
                    type:'post',
                    data:{enrol_id:enrol_id,formName:'delete_enrol'},
                    url:'includes/datacontrol.php',
                    success:function(data){
                        if(data==1){
                            console.log(data);
                        var table = $('#datatable_enrol').DataTable();
                            table.ajax.reload();
                        }else{
                            alert('Something went wrong. Please try again');
                        }
                    }
                })
            }

            $(document).ready(function () {
                $('#datatable').DataTable({
                    lengthMenu: [5, 10, 20],
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"}},
                            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                    sScrollX: true,
                    responsive:false,
                    ajax: 'includes/datacontrol.php?name=studentEnquiry',
                        columns: [
                        { data: 'st_enquiry_id' },                                    
                        { data: 'std_name' },                                    
                        { data: 'std_phno' },
                        { data: 'std_email' },
                        { data: 'street' },
                        { data: 'suburb' },
                        { data: 'post_code' },
                        { data: 'std_course' },
                        { data: 'startplan_date' },
                        { data: 'st_coursetype' },
                        { data: 'visited' },
                        { data: 'referedby' },
                        { data: 'std_fee' },
                        { data: 'appointment' },
                        { data: 'Visa_condition' },
                        { data: 'std_visa_status' },
                        { data: 'staffComments' },
                        { data: 'preferences' },
                        { data: 'remarksNotes' },
                        { data: 'action' },
                    ],
                    // "dom": 'Blfrtip',
                    // "buttons": ['pdf']
    //                 dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
    //   "<'row'<'col-sm-12'tr>>" +
    //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    // buttons: [
    //   {
    //     extend: 'pdf',
    //     className: "btn-sm",
    //     text: 'EXPORT',
    //     filename: function() {
    //     return "Enquiries"
    //     },
    //     title: function() {
    //     return "<div><div>Logo</div><div>Auztraining</div></div>"
    //     },
    //     exportOptions: {
    //       columns: [ 1, 2, 3, 4, 5, 6]
    //     }
    //   }
    // ]
                });

                $('#datatable_followup').DataTable({
                    scrollX: true,
                    lengthMenu: [5, 10, 20],
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"}},
                            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},                    
                    responsive:false,
                    ajax: 'includes/datacontrol.php?name=followup_calls',
                        columns: [
                        { data: 'enquiry_id' },                                    
                        { data: 'name' },                                    
                        { data: 'phone' },
                        { data: 'contacted_person' },
                        { data: 'contacted_time' },
                        { data: 'date' },
                        { data: 'mode_contact' },
                        // { data: 'remarks' },
                        // { data: 'comments' },
                        { data: 'action' }
                    ]
                });
                $('#datatable_counseling').DataTable({
                    scrollX: true,
                    lengthMenu: [5, 10, 20],
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"}},
                            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},                    
                    responsive:false,
                    ajax: 'includes/datacontrol.php?name=counselings',
                        columns: [
                        { data: 'member_name' },                                    
                        { data: 'counsil_type' },                                    
                        { data: 'work_status' },
                        { data: 'visa' },
                        { data: 'education' },
                        { data: 'counsil_timing' },
                        { data: 'time_spent' },
                        { data: 'action' }
                    ]
                });

                $('#accordionExample').on('show.bs.collapse', function(e){
                setTimeout(function () {
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                }, 10);
                });
            })

            $("#filter_input").on("input", function() {
                mark(this);
                var value = $(this).val().toLowerCase();
                $("#student_filter_table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            function mark(element) {
                var keyword = $(element).val();

                var options = {};
                $("#student_filter_table tbody").unmark({
                    done: function() {
                    $("#student_filter_table tbody").mark(keyword, options);
                    }
                });
                };

            $('.export-filter').click(function(){

                var divToPrint=$("#table-filter");
                $(divToPrint).find('.imp-none').remove();
                newWin=  window.open('', '_top', '','');       
                newWin.document.write('<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'><html xmlns=\'http://www.w3.org/1999/xhtml\'><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv=\'Content-Type\' content=\'text/html; charset=iso-8859-1\' /><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"><title>Patient Feed</title><style>#student_filter_body th , #student_filter_body td { white-space: pre; }  .td_scroll_height { width:max-content; }@page { size:Legal landscape; } table, th, td { border: 1px solid;border-collapse: collapse;text-align: left;padding: 5px 10px;}  body { background: #FFF;color: #000;font-size: 12pt;padding: 0;} .print_div{ display:flex;justify-content:center; } .print_logo{ height: 85px;width: 10%;margin: 0;padding: 0;}  </style></head><body><div class="print_div"><img class="print_logo" src="assets/images/logo-dark.png"></div><table>'+$(divToPrint).html()+'</table></body></html>');
                newWin.print();
                newWin.close();



            })

            $('#appoint_export').click(function(){

                var divToPrint=$("#appointments_table");
                // $(divToPrint).find('.imp-none').remove();
                newWin=  window.open('', '_top', '','');       
                newWin.document.write('<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'><html xmlns=\'http://www.w3.org/1999/xhtml\'><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv=\'Content-Type\' content=\'text/html; charset=iso-8859-1\' /><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"><title>Patient Feed</title><style>#student_filter_body th , #student_filter_body td { white-space: pre; }  .td_scroll_height { width:max-content; }@page { size:Legal landscape; } table, th, td { border: 1px solid;border-collapse: collapse;text-align: left;padding: 5px 10px;}  body { background: #FFF;color: #000;font-size: 12pt;padding: 0;} .print_div{ display:flex;justify-content:center; } .print_logo{ height: 85px;width: 10%;margin: 0;padding: 0;}  </style></head><body><div class="print_div"><img class="print_logo" src="assets/images/logo-dark.png"></div><table>'+$(divToPrint).html()+'</table></body></html>');
                newWin.print();
                newWin.close();



            })

            $('#counsel_export').click(function(){

                var divToPrint=$("#counsel_table");
                // $(divToPrint).find('.imp-none').remove();
                newWin=  window.open('', '_top', '','');       
                newWin.document.write('<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'><html xmlns=\'http://www.w3.org/1999/xhtml\'><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv=\'Content-Type\' content=\'text/html; charset=iso-8859-1\' /><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"><title>Patient Feed</title><style>#student_filter_body th , #student_filter_body td { white-space: pre; }  .td_scroll_height { width:max-content; }@page { size:Legal landscape; } table, th, td { border: 1px solid;border-collapse: collapse;text-align: left;padding: 5px 10px;}  body { background: #FFF;color: #000;font-size: 12pt;padding: 0;} .print_div{ display:flex;justify-content:center; } .print_logo{ height: 85px;width: 10%;margin: 0;padding: 0;}  </style></head><body><div class="print_div"><img class="print_logo" src="assets/images/logo-dark.png"></div><table>'+$(divToPrint).html()+'</table></body></html>');
                newWin.print();
                newWin.close();



            })

            // $('#student_filter').click(function(){

            //     var divToPrint=$("#student_filter_table");
            //     if(tableArray.length!=tablethCount){
            //     var thfinder='';
            //     var tdfinder='';
            //     for(var i=0;i<tableArray.length;i++){
            //         // var number=0;
            //     var number=tableArray[i];

            //      thfinder+='thead tr th:eq("'+number+'"),';
            //      tdfinder+='td:eq("'+number+'"),';

            //     }

            //     thfinder=thfinder.slice(0, -1);
            //     tdfinder=tdfinder.slice(0, -1);

            //     $(divToPrint).find(thfinder).remove();

            //     $(divToPrint).find("tbody tr").each(function() {
            //     $(this).find(tdfinder).remove();
            //     });
            //     $(divToPrint).find('#filter-dropdowns').remove();
            //     }else{
            //     $(divToPrint).find('#filter-dropdowns').remove();
            //     }


            //     newWin=  window.open('', '_top', '','');       
            //     newWin.document.write('<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'><html xmlns=\'http://www.w3.org/1999/xhtml\'><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv=\'Content-Type\' content=\'text/html; charset=iso-8859-1\' /><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"><title>Patient Feed</title><style>#student_filter_body th , #student_filter_body td { white-space: pre; }  .td_scroll_height { width:max-content; }@page { size:Legal landscape; } table, th, td { border: 1px solid;border-collapse: collapse;text-align: left;padding: 5px 10px;}  body { background: #FFF;color: #000;font-size: 12pt;padding: 0;} .print_div{ display:flex;justify-content:center; } .print_logo{ height: 85px;width: 10%;margin: 0;padding: 0;}  </style></head><body><div class="print_div"><img class="print_logo" src="assets/images/logo-dark.png"></div><table>'+$(divToPrint).html()+'</table></body></html>');
            //     newWin.print();
            //     newWin.close();

            // })

            // var tableColorIndex=[];
            // var tablethCount=$('#student_filter_table').find('thead tr th').length;
            // var tableArray = Array(tablethCount).fill(0).map((n, i) => n + i);               
            // $(document).on('click','#student_filter_table th',function(){
            //     var index=$(this)[0].cellIndex+1;
            //     $('#student_filter_table tbody tr td:nth-child('+index+')').toggleClass('table-bg');
            //     $(this).toggleClass('table-bg');
            //     console.log(index);
            //     console.log(tableArray);
            //     if(tableArray.includes(index)){
            //         // console.log(index);console.log(tableArray);
            //         tableArray = tableArray.filter(item => item !== index-1);
            //     }else{
            //         tableArray.push(index);
            //     }
            // })

            // $(document).on('click',"#student_filter_body td",function(){
            //     var index=$(this)[0].cellIndex+1;
            //     $('#student_filter_table thead tr th:nth-child('+index+')').trigger('click');
            // })

                $(document).on('click','#submit_column_filter',function(){
                    var columnName=$('#column_select option:selected').attr('data-name');                    
                    var mainColName=$('#column_select').val();
                    var columnId=$('#column_select option:selected').attr('data-value');
                    var badgeId=$('#badge_'+columnId).val();   
                    var colValue=$('#column_'+columnId).val();                                              
                if(colValue!='' && columnId!=undefined && columnName!=0 && ( badgeId==undefined || badgeId=='' )){
                    $('.badges-div').append('<button type="button" data-col-name="'+mainColName+'" id="badge_'+columnId+'" data-id="'+columnId+'" main-value="'+colValue+'" class="btn btn-secondary btn-rounded badge-button close-badge"><i class="mdi mdi-close-circle"></i> <span>'+columnName+'</span></button>');
                    filterMain();
                }
            })
            
            $(document).on('click','.close-badge',function(){
                $(this).remove();
                var idCol=$(this).attr('data-id');
                var nameCol=$(this).children("span").text();
                var mainCol=$(this).attr('data-col-name');
                $('#column_select').append('<option value="'+mainCol+'" id="option_'+idCol+'" data-value="'+idCol+'" data-name="'+nameCol+'">'+nameCol+'</option>');
                $('#column_select').val(0).change();
                $('#column_select').selectpicker('refresh');  
                filterMain();
            })


            function filterMain(){
                var columnData={};
                $('.badge-button').each(function(){
                    var option=$(this).attr('data-id');
                    $('#option_'+option).remove();
                    $('.column_value').val('');
                    $('.column_value').hide();
                    $('#column_select').selectpicker('refresh');     
                    $('#column_select').val(0).change();
                    
                    var columnName=$(this).attr('data-col-name');
                    var columnValue=$(this).attr('main-value');
                    columnData[columnName]=columnValue;
                    
                })    
                
                fetchFilter(columnData);

            }

            function fetchFilter(objFilter){
                $.ajax({
                    type:'post',
                    url:'includes/datacontrol.php',
                    data:{objFilter,formName:'fetchEnquiries'},
                    success:function(data){
                        $('#student_filter_body').html(data);
                        $('#total_filter_records').html($('#student_filter_body tr').length);                        
                    }
                })
            }

            $(document).on('change','#column_select',function(){                                                
                var inputType=$('#column_select option:selected').attr('data-value');
                    $('.column_value').hide();
                    $('#column_'+inputType).show();
            })

            fetchFilter('');

            $(document).on('change','#filter-select',function(){
                $('#table-filter thead tr th').addClass('imp-none');  
                $('#table-filter tbody tr td').addClass('imp-none');  
                $('#filter-select option:selected').map(function(){
                    var index=this.value;

                    $('#table-filter thead tr th:nth-child('+index+')').removeClass('imp-none');
                    $('#table-filter thead tr th:nth-child('+index+')').addClass('imp-block');
                    
                    $('#table-filter tbody tr td:nth-child('+index+')').removeClass('imp-none');
                    $('#table-filter tbody tr td:nth-child('+index+')').addClass('imp-block');
                });
            })   



            $(document).on('click','#submit_column2_filter',function(){
                    var columnName=$('#appoint_select option:selected').attr('data-name');                    
                    var mainColName=$('#appoint_select').val();
                    var columnId=$('#appoint_select option:selected').attr('data-value');
                    var badgeId=$('#appoint_badge_'+columnId).val();   
                    var colValue=$('#appoint_column_'+columnId).val();                                              
                if(colValue!='' && columnId!=undefined && columnName!=0 && ( badgeId==undefined || badgeId=='' )){
                    $('.appoint-badges-div').append('<button type="button" data-col-name="'+mainColName+'" id="appoint_badge_'+columnId+'" data-id="'+columnId+'" main-value="'+colValue+'" class="btn btn-secondary btn-rounded appoint-badge-button appoint_close-badge"><i class="mdi mdi-close-circle"></i> <span>'+columnName+'</span></button>');
                    appoint_filterMain();
                }
            })
            
            $(document).on('click','.appoint_close-badge',function(){
                $(this).remove();
                var idCol=$(this).attr('data-id');
                var nameCol=$(this).children("span").text();
                var mainCol=$(this).attr('data-col-name');
                $('#appoint_select').append('<option value="'+mainCol+'" id="option_'+idCol+'" data-value="'+idCol+'" data-name="'+nameCol+'">'+nameCol+'</option>');
                $('#appoint_select').val(0).change();
                $('#appoint_select').selectpicker('refresh');  
                appoint_filterMain();
            })


            function appoint_filterMain(){
                var columnData={};
                $('.appoint-badge-button').each(function(){
                    var option=$(this).attr('data-id');
                    $('#option_'+option).remove();
                    $('.appoint_column_value').val('');
                    $('.appoint_column_value').hide();
                    $('#appoint_select').selectpicker('refresh');     
                    $('#appoint_select').val(0).change();
                    
                    var columnName=$(this).attr('data-col-name');
                    var columnValue=$(this).attr('main-value');
                    columnData[columnName]=columnValue;
                    
                })    
                
                appoint_fetch(columnData);

            }

            function appoint_fetch(objFilter){
                $.ajax({
                    type:'post',
                    url:'includes/datacontrol.php',
                    data:{objFilter,formName:'fetchAppoints'},
                    success:function(data){
                        $('#appointments_table tbody').html(data);
                        // $('#total_filter_records').html($('#student_filter_body tr').length);                        
                    }
                })
            }

            $(document).on('change','#appoint_select',function(){                                                
                var inputType=$('#appoint_select option:selected').attr('data-value');
                    $('.appoint_column_value').hide();
                    console.log(inputType);
                    $('#appoint_column_'+inputType).show();
            })

            appoint_fetch('');


            $(document).on('click','#submit_column3_filter',function(){
                    var columnName=$('#counsel_select option:selected').attr('data-name');                    
                    var mainColName=$('#counsel_select').val();
                    var columnId=$('#counsel_select option:selected').attr('data-value');
                    var badgeId=$('#counsel_badge_'+columnId).val();   
                    var colValue=$('#counsel_column_'+columnId).val();                                              
                if(colValue!='' && columnId!=undefined && columnName!=0 && ( badgeId==undefined || badgeId=='' )){
                    $('.counsel-badges-div').append('<button type="button" data-col-name="'+mainColName+'" id="counsel_badge_'+columnId+'" data-id="'+columnId+'" main-value="'+colValue+'" class="btn btn-secondary btn-rounded counsel-badge-button counsel_close-badge"><i class="mdi mdi-close-circle"></i> <span>'+columnName+'</span></button>');
                    counsel_filterMain();
                }
            })
            
            $(document).on('click','.counsel_close-badge',function(){
                $(this).remove();
                var idCol=$(this).attr('data-id');
                var nameCol=$(this).children("span").text();
                var mainCol=$(this).attr('data-col-name');
                $('#counsel_select').append('<option value="'+mainCol+'" id="option_'+idCol+'" data-value="'+idCol+'" data-name="'+nameCol+'">'+nameCol+'</option>');
                $('#counsel_select').val(0).change();
                $('#counsel_select').selectpicker('refresh');  
                counsel_filterMain();
            })


            function counsel_filterMain(){
                var columnData={};
                $('.counsel-badge-button').each(function(){
                    var option=$(this).attr('data-id');
                    $('#option_'+option).remove();
                    $('.counsel_column_value').val('');
                    $('.counsel_column_value').hide();
                    $('#counsel_select').selectpicker('refresh');     
                    $('#counsel_select').val(0).change();
                    
                    var columnName=$(this).attr('data-col-name');
                    var columnValue=$(this).attr('main-value');
                    columnData[columnName]=columnValue;
                    
                })    
                
                counsel_fetch(columnData);

            }

            function counsel_fetch(objFilter){
                $.ajax({
                    type:'post',
                    url:'includes/datacontrol.php',
                    data:{objFilter,formName:'fetchCounsel'},
                    success:function(data){
                        $('#counsel_table tbody').html(data);
                        // $('#total_filter_records').html($('#student_filter_body tr').length);                        
                    }
                })
            }

            $(document).on('change','#counsel_select',function(){                                                
                var inputType=$('#counsel_select option:selected').attr('data-value');
                    $('.counsel_column_value').hide();
                    console.log(inputType);
                    $('#counsel_column_'+inputType).show();
            })

            counsel_fetch('');
        </script>
        <?php }else{ ?>
            <script>

            </script>
        <?php } ?>
    </body>
</html>
 <?php
  } else{ 
    header('Location: student_enquiry.php');
} 
?>