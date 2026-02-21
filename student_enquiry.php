<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
$is_student_portal = (@$_SESSION['user_type'] === 'student');
if(@$_SESSION['user_type']!=''){

    if($is_student_portal && (!isset($_GET['eq']) || $_GET['eq']==='')){
        header('Location: student_portal.php');
        exit;
    }
    if($is_student_portal && isset($_GET['view']) && $_GET['view']=='list'){
        header('Location: student_portal.php');
        exit;
    }
    if(isset($_GET['view']) && $_GET['view']=='list'){
        ?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>View Enquiry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('includes/app_includes.php'); ?>
    <style>
        #viewEnquiryAccordion .accordion-button { font-weight: 600; }
        #viewEnquiryAccordion .table-responsive { overflow-x: auto; overflow-y: visible; min-height: 0; }
        #viewEnquiryAccordion .dataTables_wrapper .dataTables_filter input { margin-left: 0.5em; border-radius: 4px; padding: 4px 8px; }
        #viewEnquiryAccordion .dataTables_wrapper .dataTables_length select { padding: 4px 8px; margin: 0 4px; border-radius: 4px; }
        #viewEnquiryAccordion .dataTables_wrapper .dataTables_paginate .pagination { margin: 0; }
        #viewEnquiryAccordion .dataTables_wrapper .dataTables_paginate .page-link { display: inline-flex; align-items: center; justify-content: center; min-width: 2em; }
        #viewEnquiryAccordion .dataTables_wrapper .dataTables_paginate .page-link i.ti { font-size: 1.1em; }
        /* Ensure all enquiry table columns show - strip imp-none so Edit stays in Action column */
        #datatable_enquiries tbody td.imp-none { display: table-cell !important; }
        #datatable_enquiries { min-width: 1200px; }
        #viewEnquiryAccordion .dataTables_scrollBody { overflow-x: auto !important; }
        .course-cell-first { display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px; vertical-align: middle; }
        .course-view-more { color: #0d6efd; cursor: pointer; white-space: nowrap; font-size: 0.9em; vertical-align: middle; }
        .course-view-more:hover { color: #0a58ca; text-decoration: underline; }
        .course-view-more .mdi { font-size: 1.1em; vertical-align: middle; }
        .course-view-more-text { margin-left: 1px; }
        .popover-body { max-height: 280px; overflow-y: auto; }
        #viewEnquiryAccordion .dataTables_scrollBody { cursor: grab; user-select: none; }
        #viewEnquiryAccordion .dataTables_scrollBody.drag-scrolling { cursor: grabbing; }
    </style>
</head>
<body>
<div class="main-wrapper">
<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>
            <div class="page-wrapper">
                <div class="content pb-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">View Enquiry</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="student_enquiry.php">Create Enquiry</a></li>
                                            <li class="breadcrumb-item active">View Enquiry</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion" id="viewEnquiryAccordion">
                            <!-- Accordion 1: Student Enquiries -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headEnquiries">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnquiries" aria-expanded="true" aria-controls="collapseEnquiries">Student Enquiries</button>
                                </h2>
                                <div id="collapseEnquiries" class="accordion-collapse collapse show" aria-labelledby="headEnquiries" data-bs-parent="#viewEnquiryAccordion">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="datatable_enquiries" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Enquiry ID</th><th>Student Name</th><th>Contact Number</th><th>Email</th><th>Course Type</th><th>Date</th><th>States</th><th>Course</th><th>Visa Condition</th><th>Visa Status</th><th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="student_filter_body"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion 2: Counseling -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headCounseling">
                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCounseling" aria-expanded="false" aria-controls="collapseCounseling">Counseling</button>
                                </h2>
                                <div id="collapseCounseling" class="accordion-collapse collapse" aria-labelledby="headCounseling" data-bs-parent="#viewEnquiryAccordion">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="datatable_counseling" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Student Name</th><th>Enquiry ID</th><th>Phone</th><th>Email</th><th>Type</th><th>Team Member</th><th>Start Date</th><th>End Date</th><th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="counsel_filter_body"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion 3: Follow Up Call -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headFollowup">
                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFollowupList" aria-expanded="false" aria-controls="collapseFollowupList">Follow Up Call</button>
                                </h2>
                                <div id="collapseFollowupList" class="accordion-collapse collapse" aria-labelledby="headFollowup" data-bs-parent="#viewEnquiryAccordion">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="datatable_followup" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Enquiry ID</th><th>Name</th><th>Phone</th><th>Contacted Person</th><th>Contacted Time</th><th>Date</th><th>Mode of Contact</th><th>Staff Notes</th><th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="followup_filter_body"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer_includes.php'); ?>
        <script>
        function initCoursePopovers(){
            $('.course-view-more').each(function(){
                var el = $(this);
                if (el.data('bs.popover')) el.popover('dispose');
                var raw = el.attr('data-courses');
                if (!raw) return;
                try {
                    var courses = JSON.parse(raw);
                    if (courses && courses.length) {
                        var content = courses.map(function(c){ return $('<div/>').text(c).html(); }).join('<br>');
                        el.popover({ html: true, content: content, trigger: 'hover focus', title: 'All courses', container: 'body', sanitize: false });
                    }
                } catch(e) {}
            });
        }
        function initDataTableEnquiries(){
            if($.fn.DataTable.isDataTable('#datatable_enquiries')) return;
            $('#datatable_enquiries').DataTable({
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                pageLength: 10,
                language: { paginate: { previous: "<i class=\"ti ti-chevron-left\"></i>", next: "<i class=\"ti ti-chevron-right\"></i>" } },
                drawCallback: function(){
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    initCoursePopovers();
                },
                scrollX: true,
                autoWidth: false,
                columnDefs: [ { width: '90px', targets: 0 }, { width: '120px', targets: 1 }, { width: '110px', targets: 2 }, { width: '160px', targets: 3 }, { width: '90px', targets: 10 } ],
                order: [[0, 'desc']]
            });
        }
        function initDataTableCounseling(){
            if($.fn.DataTable.isDataTable('#datatable_counseling')) return;
            $('#datatable_counseling').DataTable({
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                pageLength: 10,
                language: { paginate: { previous: "<i class=\"ti ti-chevron-left\"></i>", next: "<i class=\"ti ti-chevron-right\"></i>" } },
                drawCallback: function(){ $(".dataTables_paginate > .pagination").addClass("pagination-rounded"); },
                scrollX: true,
                order: [[6, 'desc']]
            });
        }
        function initDataTableFollowup(){
            if($.fn.DataTable.isDataTable('#datatable_followup')) return;
            $('#datatable_followup').DataTable({
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                pageLength: 10,
                language: { paginate: { previous: "<i class=\"ti ti-chevron-left\"></i>", next: "<i class=\"ti ti-chevron-right\"></i>" } },
                drawCallback: function(){ $(".dataTables_paginate > .pagination").addClass("pagination-rounded"); },
                scrollX: true,
                order: [[5, 'desc']]
            });
        }
        var dragScroll = null;
        $(document).on('mousedown', '#viewEnquiryAccordion .dataTables_scrollBody', function(e){
            var el = $(this);
            dragScroll = { el: this, startX: e.pageX, startScroll: this.scrollLeft };
            el.addClass('drag-scrolling');
        });
        $(document).on('mousemove', function(e){
            if (!dragScroll) return;
            e.preventDefault();
            dragScroll.el.scrollLeft = dragScroll.startScroll + (dragScroll.startX - e.pageX);
        });
        $(document).on('mouseup mouseleave', function(e){
            if (dragScroll) {
                $(dragScroll.el).removeClass('drag-scrolling');
                dragScroll = null;
            }
        });
        $(document).on('touchstart', '#viewEnquiryAccordion .dataTables_scrollBody', function(e){
            if (e.originalEvent.touches.length !== 1) return;
            var el = $(this);
            dragScroll = { el: this, startX: e.originalEvent.touches[0].pageX, startScroll: this.scrollLeft };
            el.addClass('drag-scrolling');
        });
        $(document).on('touchmove', function(e){
            if (!dragScroll || e.originalEvent.touches.length !== 1) return;
            e.preventDefault();
            var x = e.originalEvent.touches[0].pageX;
            dragScroll.el.scrollLeft += (dragScroll.startX - x);
            dragScroll.startX = x;
            dragScroll.startScroll = dragScroll.el.scrollLeft;
        });
        $(document).on('touchend touchcancel', function(){
            if (dragScroll) {
                $(dragScroll.el).removeClass('drag-scrolling');
                dragScroll = null;
            }
        });
        $(function(){
            $.ajax({ type:'post', url:'includes/datacontrol.php', data:{ formName:'fetchEnquiries' }, success:function(data){
                var html = (data && data.trim()) ? data : '<tr><td colspan="11">No records</td></tr>';
                $('#student_filter_body').html(html);
                $('#student_filter_body td.imp-none').removeClass('imp-none');
                initDataTableEnquiries();
                initCoursePopovers();
            }});
            $.ajax({ type:'post', url:'includes/datacontrol.php', data:{ formName:'fetchCounsel' }, success:function(data){
                $('#counsel_filter_body').html(data && data.trim() ? data : '<tr><td colspan="9">No records</td></tr>');
                initDataTableCounseling();
            }});
            $.ajax({ type:'post', url:'includes/datacontrol.php', data:{ formName:'fetchFollowupList' }, success:function(data){
                $('#followup_filter_body').html(data && data.trim() ? data : '<tr><td colspan="9">No records</td></tr>');
                initDataTableFollowup();
            }});
        });
        </script>
        </body></html>
        <?php
        exit;
    }
    
            $courses=mysqli_query($connection,"SELECT * from courses where course_status!=1");
        $visaStatus=mysqli_query($connection,"SELECT * from visa_statuses where visa_state_status!=1");

    if(isset($_GET['eq'])){
        $Updatestatus=1;
        $eqId=base64_decode($_GET['eq']);
        $eqId=(int)$eqId;
        $queryRes=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enquiry where st_enquiry_status!=1 and st_id=$eqId"));
        if(!$queryRes){
            if($is_student_portal){ header('Location: student_portal.php'); exit; }
            $queryRes=array();
        }
        if($is_student_portal && !empty($queryRes) && (int)($queryRes['student_user_id']??0) !== (int)$_SESSION['user_id']){
            header('Location: student_portal.php');
            exit;
        }
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
        $queryRes_regGrp=mysqli_query($connection,"SELECT * from regular_group_form where enq_form_id=$form_id");
        if(mysqli_num_rows($queryRes_regGrp)!=0){
            $queryRes_regGrps=mysqli_fetch_array($queryRes_regGrp);
            $reg_grp_status=1;
            $reg_grp=$queryRes_regGrps['reg_grp_names'];
        }else{
            $reg_grp_status=0;
            $reg_grp='';    
        }

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
        $queryRes=array();
        $rpl_array=["rpl_exp" => '' , "exp_in"=>'' , "exp_docs"=>'' , "exp_prev"=>'' , "exp_name"=>''  , "exp_years"=>''  , "exp_prev_name"=>'']; 
        $slot_book=["slot_book_time"=>'',"slot_book_purpose"=>'',"slot_book_date"=>'',"slot_book_by"=>'',"slot_book_link"=>''];  
        $short_grp=["short_grp_org_name" => '' , "short_grp_org_type"=>'' , "short_grp_campus"=>'',"short_grp_date"=>'', "short_grp_num_std"=> '',"short_grp_ind_exp"=>'',"short_grp_con_type"=>'' , "short_grp_con_num"=>'',"short_grp_con_name"=>'',"short_grp_con_email"=>'',"short_grp_before"=>'' ];  
        $rpl_arrays=json_encode($rpl_array);
        $short_grps=json_encode($short_grp);
        $slot_books=json_encode($slot_book);
        $form_id=0;
        $reg_grp='';
        $rpl_status=0;
        $short_grp_status=0;
        $slot_book_status=0;
    }

    $enquiryIds=mysqli_query($connection,"SELECT st_enquiry_id,st_name,st_phno from student_enquiry where st_enquiry_status!=1");
    $enquiryIdsCounselling=mysqli_query($connection,"SELECT st_enquiry_id,st_name,st_phno from student_enquiry where st_enquiry_status!=1");
    $enquiryIdsFollowup=mysqli_query($connection,"SELECT st_enquiry_id,st_name,st_phno from student_enquiry where st_enquiry_status!=1");
    $counsilEqId=0;
    $followupEqId=0;
    $counsil_Query=array('st_enquiry_id'=>'','counsil_timing'=>'','counsil_end_time'=>'','counsil_type'=>'','counsil_mem_name'=>'','counsil_aus_stay_time'=>'','counsil_work_status'=>'','counsil_visa_condition'=>'','counsil_education'=>'','counsil_aus_study_status'=>'','counsil_course'=>'','counsil_university'=>'','counsil_qualification'=>'','counsil_eng_rate'=>'','counsil_migration_test'=>'','counsil_overall_result'=>'','counsil_module_result'=>'','counsil_job_nature'=>'','counsil_vaccine_status'=>'','counsil_pref_comments'=>'','counsil_remarks'=>'');
    $followup_Query=array('flw_name'=>'','flw_phone'=>'','flw_contacted_person'=>'','flw_contacted_time'=>'','flw_date'=>'','flw_mode_contact'=>'','flw_comments'=>'','flw_progress_state'=>'','flw_remarks'=>'');

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
        <?php 
        include('includes/app_includes.php'); 
        ?>
    </head>

    <body>

    <div id="loader-container">
        <div class="loader"></div>
    </div>

        <!-- Begin page -->
        <div class="main-wrapper">

            
            <?php if($is_student_portal): ?>
            <div class="border-bottom bg-light py-2">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">National College Australia – My Enquiry</span>
                    <span><a href="student_portal.php">My Portal</a> &nbsp;|&nbsp; <a href="student_logout.php">Logout</a></span>
                </div>
            </div>
            <div class="container-fluid py-4">
            <?php else: ?>
            <?php include('includes/header.php'); ?>
            <?php include('includes/sidebar.php'); ?>
            <div class="page-wrapper">
                <div class="content pb-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Student's Enquiry</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0 align-items-baseline">
                                        <li class="breadcrumb-item">
                                            <button type="button" id="generate_qr" onclick="genQR()" class="btn btn-info waves-effect waves-light">Create QR Code <i class="mdi mdi-qrcode-edit"></i> </button>
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
            <?php endif; ?>
        <div class="accordion mb-3" id="enquiryMainAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingStudentEnquiry">
                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStudentEnquiry" aria-expanded="true" aria-controls="collapseStudentEnquiry">
                        Student Enquiry
                    </button>
                </h2>
                <div id="collapseStudentEnquiry" class="accordion-collapse collapse show" aria-labelledby="headingStudentEnquiry" data-bs-parent="#enquiryMainAccordion">
                    <div class="accordion-body p-0">
        <form class="student_enquiry_form" id="student_enquiry_form">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body" id="student_enquiry_form_parent">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Personal Details
                                        </button>
                                    </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="email_address">Email<span class="asterisk">*</span></label>
                                                        <input type="text" class="form-control" id="email_address" placeholder="Email Address" value="<?php echo $queryRes['st_email']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Email Address
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="enquiry_date">Date<span class="asterisk">*</span></label>
                                                        <input type="date" class="form-control" id="enquiry_date" value="<?php echo  $queryRes['st_enquiry_date']!='' ? date('Y-m-d',strtotime($queryRes['st_enquiry_date'])) : ''; ?>">
                                                        <div class="error-feedback">
                                                            Please select the Date
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="surname">Surname<span class="asterisk">*</span></label>
                                                        <input type="text" class="form-control" id="surname" placeholder="Surname" value="<?php echo  $queryRes['st_surname']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Surname
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="student_name">First Name<span class="asterisk">*</span></label>
                                                        <input type="text" class="form-control" id="student_name" placeholder="Student Name" value="<?php echo $queryRes['st_enquiry_for']==1 ? $queryRes['st_name']: $queryRes['st_member_name'] ; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the First name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="enquiry_for">Enquiring For<span class="asterisk">*</span></label>
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
                                                        <label class="form-label" for="member_name">Name<span class="asterisk">*</span></label>
                                                        <input type="text" class="form-control" id="member_name" placeholder="Name" value="<?php echo $queryRes['st_enquiry_for']==1 ? $queryRes['st_member_name'] : $queryRes['st_name']; ?>" <?php echo $queryRes['st_enquiry_for']==1 ? 'readonly' : ''  ?> >
                                                        <div class="error-feedback">
                                                            Please enter the Name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="course_type">Course Type</label>
                                                        <select name="course_type" class="form-select" id="course_type">
                                                        <?php  
                                                        $st_course_type=['--select--','Rpl','Regular','Regular - Group','Short courses','Short course - Group'];
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
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>                        

                          <!-- Short Course - group Form -->

                <div class="row" id="short_grp_form" style="display:<?php echo $queryRes['st_course_type']==5 || $queryRes['st_course_type']==4 ? 'block' : 'none' ?>">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <b><p class="card-title">Short Course Group Form</p></b>
                                <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="short_grp_org_name">Organisation Name</label>
                                    <input type="text" name="short_grp_org_name" class="form-control" id="short_grp_org_name" placeholder="Organisation Name"  value="<?php echo $short_grp['short_grp_org_name']; ?>">
                                </div>
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <label class="form-label" for="short_grp_campus">Training to be given</label>
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
                                <div class="col-md-6">
                                    <label class="form-label" for="short_grp_date">Date Required</label>
                                    <input type="date" name="short_grp_date" class="form-control" id="short_grp_date" value="<?php echo $short_grp['short_grp_date']!='' ? date('Y-m-d',strtotime($short_grp['short_grp_date'])) : ''; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="short_grp_num_std">Number of Students</label>
                                    <input type="tel" name="short_grp_num_std" class="form-control number-field" id="short_grp_num_std" value="<?php echo $short_grp['short_grp_num_std']; ?>">
                                </div>
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <label class="form-label" for="short_grp_con_type">How did they Contact us</label>
                                    <input type="text" name="short_grp_con_type" class="form-control" id="short_grp_con_type" value="<?php echo $short_grp['short_grp_con_type']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="short_grp_con_num">Contact Number</label>
                                    <input type="tel" name="short_grp_con_num" class="form-control number-field" id="short_grp_con_num" placeholder="Contact Number" value="<?php echo $short_grp['short_grp_con_num']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="short_grp_con_name">Contact Person Name</label>
                                    <input type="text" name="short_grp_con_name" class="form-control" id="short_grp_con_name" placeholder="Name" value="<?php echo $short_grp['short_grp_con_name']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="short_grp_con_email">Contact Person Email</label>
                                    <input type="email" name="short_grp_con_email" class="form-control" id="short_grp_con_email" placeholder="Email" value="<?php echo $short_grp['short_grp_con_email']; ?>">
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                                <div class="row" id="rpl_form" style="display:<?php echo (isset($queryRes['st_course_type']) && $queryRes['st_course_type']==1) ? 'block' : 'none' ?>">
                                   <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <b><p class="card-title">RPL Form</p></b>
                                                <div class="row">

                                                <div class="col-md-6">
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
                                                <div class="col-md-6 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
                                                    <label class="form-label" for="exp_in">Experienced In</label>
                                                    <select name="exp_in" class="form-control" id="exp_in">
                                                    <?php 
                                                        $rpl_exps_in=['--select--','Aged Care','Disability Care','Mental Health','Home Care and Hospitals'];
                                                        for($i=0;$i<count($rpl_exps_in);$i++){
                                                            $selected=$i==$rpl_array['exp_in'] ? 'selected' : '';
                                                            echo "<option value='".$i."' ".$selected.">".$rpl_exps_in[$i]."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
                                                    <label class="form-label" for="exp_name">Role/Designation</label>
                                                    <input type="text" name="exp_name" class="form-control" id="exp_name" placeholder="Role" value="<?php echo $rpl_array['exp_name']; ?>">
                                                </div>
                                                <div class="col-md-6 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
                                                    <label class="form-label" for="exp_years">How Many Years & Months</label>
                                                    <input type="text" name="exp_years" class="form-control" id="exp_years" placeholder="Years" value="<?php echo $rpl_array['exp_years']; ?>">
                                                </div>
                                                <div class="col-md-6 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
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
                                                <div class="col-md-6 rpl_child" style="display:<?php echo $rpl_array['rpl_exp']==1 ? 'block' : 'none' ?>">
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
                                                <div class="col-md-6 rpl_prev_child">
                                                    <label class="form-label" for="exp_prev_name">Previous Qualification Name</label>
                                                    <input type="text" name="exp_prev_name" class="form-control" id="exp_prev_name" placeholder="Name" value="<?php echo $rpl_array['exp_prev_name']; ?>">
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="regular_grp_form" style="display:<?php echo $queryRes['st_course_type']==3 ? '' : 'none' ?>">
                                   <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <b><p class="card-title">Regular Group Form</p></b>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="reg_grp_names">Enter the People Names</label>
                                                        <input type="text" id="reg_grp_names" class="form-control" name="reg_grp_names" value="<?php echo $reg_grp; ?>">
                                                        <div class="alert alert-primary d-flex align-items-center mt-2" role="alert">
                                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                                        <div>
                                                        Multiple Names can be written with a Comma(,) in Between
                                                        </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body" id="student_enquiry_form_parent">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingTwo">
                                                                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                                Address Details
                                                                </button>
                                                            </h2>                                                                
                                                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="contact_num">Mobile<span class="asterisk">*</span></label>
                                                                            <input type="text" class="form-control number-field" maxlength="10" id="contact_num" placeholder="Contact Number" value="<?php echo $queryRes['st_phno']; ?>" >
                                                                            <div class="error-feedback">
                                                                                Please enter the Contact Number
                                                                            </div>
                                                                            <div class="phone_error">
                                                                                Entered Number Already exist with Enquiry ID: <span id="phone_err_id"></span>
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
                                                                            <select name="stu_state" id="stu_state" class="form-control">
                                                                            <?php  
                                                                            $st_states=['--select--','NSW - New South Wales','VIC - Victoria','ACT - Australian Capital Territory','NT - Northern Territoy','WA - Western Australia','QLD - Queensland','SA - South Australia','TAS - Tasmania'];
                                                                            for($i=0;$i<count($st_states);$i++){
                                                                                $checked= $i==$queryRes['st_state'] ? 'selected' : '';
                                                                                echo '<option value="'.$i.'" '.$checked.'>'.$st_states[$i].'</option>';
                                                                            }
                                                                            ?>
                                                                            </select>
                                                                            <div class="error-feedback">
                                                                                Please enter the State
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="post_code">Post Code<span class="asterisk">*</span></label>
                                                                            <input type="tel" class="form-control number-field" maxlength="6" id="post_code" placeholder="Post Code" value="<?php echo $queryRes['st_post_code']; ?>" >
                                                                            <div class="error-feedback">
                                                                                Please enter the Post Code
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="visit_before">Have you visited us before?<span class="asterisk">*</span></label>
                                                                            <select name="visit_before" class="form-select" id="visit_before">
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body" id="student_enquiry_form_parent">      
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingThree">
                                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_counsel" aria-expanded="true" aria-controls="collapse_counsel">
                                                                    Training Dependencies
                                                                    </button>
                                                                </h2>
                                                                <div id="collapse_counsel" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                    <div class="row">
                                                            <div class="col-sm">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="hear_about">How did you hear about us?<span class="asterisk">*</span></label><br>
                                                                        <input type="text" name="hear_about" id="hear_about" class="form-control" value="<?= $heared_about=$queryRes['st_heared']=='' ? '' : $queryRes['st_heared'];?>">
                                                                        <!-- <select name="hear_about" class="selectpicker hear_about" data-selected-text-format="count" multiple id="hear_about" title="Heared From"> -->
                                                                        <?php  
                                                                            // $st_heared=['Word of Mouth','Family or Friends','Website','Gumtree','Facebook','Instagram','Linkedin','Mail outs','Migration Agency','Other:'];
                                                                            // $hear_select_opt='';                                                            
                                                                            // echo $heared_about=$queryRes['st_heared']=='' ? '' : $queryRes['st_heared'];
                                                                            // $heared_about=$queryRes['st_heared']=='' ? array() : json_decode($queryRes['st_heared']);
                                                                            // for($i=0;$i<count($st_heared);$i++){

                                                                            //     if(in_array($i,$heared_about) && count($heared_about)!=0){
                                                                            //         $checked="selected";
                                                                            //     }else{
                                                                            //         $checked= "";
                                                                            //     }                                                            

                                                                            //     $hear_select_opt.= '<option value="'.$i.'" '.$checked.'>'.$st_heared[$i].'</option>';
                                                                            //     if($i==4){
                                                                            //         $hear_select_opt.='<optgroup Label="Social Media">';
                                                                            //     }else if($i==7){
                                                                            //         $hear_select_opt.='</optgroup>';
                                                                            //     }
                                                                            // }
                                                                            // echo $hear_select_opt;
                                                                        ?>
                                                                        <!-- <optgroup label="Social Media"> -->
                                                                            <!-- <option value="2">test</option> -->
                                                                        <!-- </optgroup> -->
                                                                            <!-- </select> -->
                                                                        <div class="error-feedback">
                                                                            Please select atleast one option
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-md-12 hear_about_child" style="display:">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="hearedby">Specify How you heared about us</label>
                                                                        <input type="text" class="form-control" id="hearedby" value="" >
                                                                        <div class="error-feedback">
                                                                            Please enter the source heared
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="plan_to_start_date">When do you plan to start?</label>
                                                                        <input type="date" class="form-control" id="plan_to_start_date" value="<?php echo $queryRes['st_startplan_date']!='' ? date('Y-m-d',strtotime($queryRes['st_startplan_date'])) : '' ?>" >
                                                                        <div class="error-feedback">
                                                                            Please select the Plan to Start Date
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="refer_select">Have you been referred by someone?<span class="asterisk">*</span></label>
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
                                                                <div class="col-md-12 refered_field" style="display:<?php echo $queryRes['st_refered']==1 ? '' : 'none'; ?>">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="referer_name">Please specify his / her name</label>
                                                                        <input type="text" class="form-control" id="referer_name" value="<?php echo $queryRes['st_refer_name']; ?>" placeholder="name1,name2,name3">
                                                                        <div class="alert alert-primary d-flex align-items-center mt-2" role="alert">
                                                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                                                        <div>
                                                                        Multiple Names can be written with a Comma(,) in Between
                                                                        </div>
                                                                        </div>
                                                                        <div class="error-feedback">
                                                                            Please Enter his / her name
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 refered_field" style="display:<?php echo $queryRes['st_refered']==1 ? '' : 'none'; ?>">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="refer_alumni">Is he / she an alumni<span class="asterisk">*</span></label>
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
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="visa_condition">Visa Condition</label>
                                                                        <select name="visa_condition" class="form-select" id="visa_condition">
                                                                        <?php 
                                                                        while($visaRes=mysqli_fetch_array($visaStatus)){
                                                                            if($visaRes['visa_id']==1){
                                                                                echo "<option value='0'>--select--</option><optgroup label='Subclass 500 main applicant'>";
                                                                            }
                                                                        ?>                                                                                                      
                                                                            <option value="<?php echo $visaRes['visa_id']; ?>" <?php echo $visaRes['visa_id']==$queryRes['st_visa_status'] ? 'selected' : ''; ?>><?php echo $visaRes['visa_status_name']; ?></option>
                                                                            <?php
                                                                        if($visaRes['visa_id']==4){
                                                                            echo '</optgroup>';
                                                                        }

                                                                        } ?>
                                                                        </select> 
                                                                        <div class="error-feedback">
                                                                            Please select a visa status
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 visa_note" style="display:<?php echo $visaRes['visa_status_name']==7 ? '' : 'none'; ?>">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="visa_note">Specify Visa Status</label>
                                                                        <input type="text" class="form-control" id="visa_note" value="<?php echo $queryRes['st_visa_note']; ?>" placeholder="Visa Note">
                                                                        <div class="error-feedback">
                                                                            Please Specify the Visa Condition
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                    <div><label for="visa_status_label">Visa Status</label></div>
                                                                    <div>
                                                                        <input class="form-check-input visa_status" type="radio" value="1" name="visa_status" id="visa_status1" <?php echo $queryRes['st_visa_condition']=='' ? 'checked' :  ( $queryRes['st_visa_condition']==1 ? 'checked' : '' ) ; ?>>
                                                                        <label class="form-check-label" for="visa_status1">
                                                                            Approved
                                                                        </label>
                                                                        <input class="form-check-input visa_status" type="radio" value="2" name="visa_status" id="visa_status2" <?php echo $queryRes['st_visa_condition']==2 ? 'checked' : ''; ?>>
                                                                        <label class="form-check-label" for="visa_status2" >
                                                                            Not Approved
                                                                        </label>
                                                                        <div class="error-feedback">
                                                                            Please select a visa status
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="shore">Are you Offshore or Onshore</label>
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
                                                            </div> <!-- col-sm-close div -->

                                                                <div class="col-sm">

                                                                    <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label" for="courses">Which Course are you interested in?<span class="asterisk">*</span></label>
                                                                                <?php 
                                                                                $counts=1;
                                                                                while($coursesRes=mysqli_fetch_array($courses)){

                                                                                    if($queryRes['st_course']!=''){
                                                                                        $coursesSel=json_decode($queryRes['st_course']);
                                                                                    }else{
                                                                                        $coursesSel=[];   
                                                                                    }
                                                                                                                                        
                                                                                    if(in_array($counts,$coursesSel)){
                                                                                        $checked='checked';
                                                                                    }else{
                                                                                        $checked='';
                                                                                    }                                                            

                                                                                    echo '<div class="form-check"><input type="checkbox" class="courses_check form-check-input" id="course_check_'.$counts.'" '.$checked.' value="'.$counts.'">';
                                                                                    echo '<label for="course_check_'.$counts.'">'.$coursesRes["course_sname"].'-'.$coursesRes["course_name"].'</label></div>';
                                                                                    $counts++;
                                                                                }

                                                                                ?>
                                                                                <div class="courses_error">
                                                                                    Please select the Courses
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="student_enquiry_form_parent">
                                            <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingfour">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                                                    Additional Information
                                                    </button>
                                                </h2>
                                                <div id="collapsefour" class="accordion-collapse collapse show" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                    <div class="row">
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
                                                        <label class="form-label" for="payment_fee">Fees mentioned<span class="asterisk">*</span></label>
                                                        <input type="text" class="form-control" maxlength="255" id="payment_fee" placeholder="0.00" value="<?php echo $queryRes['st_fee']; ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Mentioned Fee
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="comments">Comments</label>
                                                        <input type="text" class="form-control" id="comments" placeholder="Comments" value="<?php echo $queryRes['st_comments']; ?>">
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
                                                        <?php  
                                                        $st_remarks=['Seems to be interested to do course and need to contact asap','contacted and followed','Selected - Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose','Rejected - "Reasons mentioned in comments" or " ReCounseliing needed"'];

                                                        if($queryRes['st_remarks']!=''){
                                                            $remarksSel=json_decode($queryRes['st_remarks']);
                                                        }else{
                                                            $remarksSel=[];   
                                                        }

                                                        for($i=1;$i<count($st_remarks);$i++){                                            

                                                            if(in_array($i,$remarksSel)){
                                                                $checked='checked';
                                                            }else{
                                                                $checked='';
                                                            }                                                            

                                                            echo '<div class="form-check"><input type="checkbox" class="remarks_check form-check-input" id="remark_check_"'.$i.' '.$checked.' value="'.$i.'">';
                                                            echo '<label for="remark_check_"'.$i.'>'.$st_remarks[$i].'</label></div>';
                                                        }
                                                            ?>
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                         <label class="form-label" for="pref_comment">Any preferences or requirements or expectations regarding this course</label>
                                                        <input type="text" class="form-control" id="pref_comment" placeholder="Requirements" value="<?php echo $queryRes['st_pref_comments']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                                <!-- appointment form  -->

                                <div class="row" id="appointment_form" style="display:<?php echo $queryRes['st_appoint_book']==1 ? 'block' : 'none' ?>"> 
                                   <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <b><p class="card-title">Appointment Form</p></b>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="slot_book_time">Appointment Time</label>
                                                        <input type="datetime-local" name="slot_book_time" class="form-control" id="slot_book_time" value="<?php echo $slot_book['slot_book_time']!='' ? date('Y-m-d H:i',strtotime($slot_book['slot_book_time'])) : '' ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="slot_book_purpose">Purpose of Appointment</label>
                                                        <input type="text" name="slot_book_purpose" class="form-control" id="slot_book_purpose" placeholder="Purpose" value="<?php echo $slot_book['slot_book_purpose']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="slot_book_date">Booked On</label>
                                                        <input type="date" name="slot_book_date" class="form-control" id="slot_book_date" value="<?php echo $slot_book['slot_book_date']!='' ? date('Y-m-d',strtotime($slot_book['slot_book_date'])) : '' ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="slot_book_by">Booking Made By</label>
                                                        <input type="text" name="slot_book_by" class="form-control" id="slot_book_by" placeholder="Booked By" value="<?php echo $slot_book['slot_book_by']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                   <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body" id="student_enquiry_form_parent">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <?php if($eqId==0){ ?>
                                                        <button class="btn btn-primary" type="button" id="enquiry_form">Submit Enquiry</button>
                                                        <?php }else{ ?>
                                                        <button class="btn btn-primary" type="button" id="enquiry_form">Update Enquiry</button>
                                                        <?php } ?>
                                                        <input type="hidden" value="<?php echo $eqId; ?>" id="check_update">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </div></div></div>
            <!-- Accordion 2: Counseling -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCounseling">
                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCounseling" aria-expanded="false" aria-controls="collapseCounseling">Counseling</button>
                </h2>
                <div id="collapseCounseling" class="accordion-collapse collapse" aria-labelledby="headingCounseling" data-bs-parent="#enquiryMainAccordion">
                    <div class="accordion-body">
                        <?php include('includes/counselling_accordion_form.php'); ?>
                    </div>
                </div>
            </div>
            <!-- Accordion 3: Follow Up Call -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFollowup">
                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFollowup" aria-expanded="false" aria-controls="collapseFollowup">Follow Up Call</button>
                </h2>
                <div id="collapseFollowup" class="accordion-collapse collapse" aria-labelledby="headingFollowup" data-bs-parent="#enquiryMainAccordion">
                    <div class="accordion-body">
                        <?php include('includes/followup_accordion_form.php'); ?>
                    </div>
                </div>
            </div>
        </div>
                    </div> <!-- container-fluid -->
            <?php if(!$is_student_portal): ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if($is_student_portal): ?>
            </div><!-- student container-fluid -->
            <?php endif; ?>
        </div>
        <?php include('includes/footer_includes.php'); ?>
        <script>

            var checkPhone=0;
            function PhoneCheck(number){

                return new Promise(function (resolve, reject) {

                    var check_update=$('#check_update').val();
                    var oldenquiryFor='<?php echo $queryRes['st_enquiry_for']; ?>';
                    var oldNumber='<?php echo $queryRes['st_phno']; ?>';

                    var memberName=$('#member_name').val();     
                    var enquiryFor=$('#enquiry_for').val();                

                $.ajax({
                    type:'post',
                    data:{number:number,formName:'phoneNumberCheck',oldNumber:oldNumber,memberName:memberName,enquiryFor:enquiryFor,check_update:check_update,oldenquiryFor:oldenquiryFor},
                    url:'includes/datacontrol.php',
                    success:function(datas){
                        resolve(datas);
                    },
                    error: function (xhr, status, error) {
                        reject(new Error(status + ': ' + error));
                    }

                })

            });

            }

                        // Usage with async/await
            async function getData(number) {
            try {
                const data = await PhoneCheck(number);
                return data;

                // You can perform further operations with 'data' here
            } catch (error) {
                console.error(error);
            }
            }

            $(document).ready(function(){            

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
                $('#visa_condition').on("change",function(){
                    var value=$(this).val();
                    if( value==7 ){
                        $('.visa_note').show();
                    }else{
                        $('.visa_note').hide();
                    }                 
                })
              /*  $('#hear_about').on("change",function(){
                    var value=$(this).val();                    
                    if( value.includes('9') ){
                        $('.hear_about_child').show();
                    }else{
                        $('.hear_about_child').hide();
                    }                 
                }) */

                $('#course_type').on("change",function(){
                    var value=$(this).val();
                    if( value==1 ){
                        $('#rpl_form').show();
                        $('#short_grp_form').hide();
                        $('#regular_grp_form').hide();
                    }else if(value==5 || value==4){       
                        $('#rpl_form').hide();
                        $('#short_grp_form').show(); 
                        $('#regular_grp_form').hide();
                    }else if(value==3){                        
                        $('#rpl_form').hide();
                        $('#short_grp_form').hide();
                        $('#regular_grp_form').show();
                    }else{
                        $('#rpl_form').hide();
                        $('#short_grp_form').hide();
                        $('#regular_grp_form').hide();
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
                        $('#appointment_form').show();
                    }else{
                        $('#appointment_form').hide();
                    }
                })

                $('#enquiry_for').on('change',function(){
                    var value=$(this).val();
                    if( value==1){
                        $('#member_name').val($('#student_name').val());
                        $('#member_name').prop('readonly',true);
                    }else{
                        $('#member_name').prop('readonly',false);
                        $('#member_name').val('');
                    }
                })

                $('#student_name').keyup(function(){
                    if($('#enquiry_for').val()==1){
                        $('#member_name').val($('#student_name').val());
                    }
                })
            })

            $(document).on('click','#enquiry_form',async() =>{
                var studentName=$('#student_name').val().trim();
                var contactName=$('#contact_num').val().trim();
                var emailAddress=$('#email_address').val().trim();
                var enquiryDate=$('#enquiry_date').val();

                var surname=$('#surname').val();
                var suburb=$('#suburb').val();
                var stuState=$('#stu_state').val() == 0 ? '' : $('#stu_state').val();
                var postCode=$('#post_code').val();
                var visit_before=$('#visit_before').val()==0 ? '' :$('#visit_before').val();
                var hear_about=$('#hear_about').val();
                // var hearedby=$('#hearedby').val();
                var hearedby=0;
                var plan_to_start_date=$('#plan_to_start_date').val();
                var refer_select=$('#refer_select').val();
                var referer_name=$('#referer_name').val();
                var refer_alumni=$('#refer_alumni').val();
                var shore=$('#shore').val();
                var comments=$('#comments').val();
                var remarks=[];
                var appointment_booked=$('#appointment_booked').val();

                $('.remarks_check:checkbox:checked').each(function() {
                    remarks.push(this.value);
                });           
                     
                var streetDetails=$('#street_no').val();
                var ethnicity=$('#ethnicity').val();                
                var prefComment=$('#pref_comment').val();                
                var enquiryFor=$('#enquiry_for').val()==0 ? '' : $('#enquiry_for').val();
                var courseType=$('#course_type').val();

                var emailregexp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                // var courses=$('#courses').val()==0 ? '' : $('#courses').val();
                var courses=[];

                $('.courses_check:checkbox:checked').each(function() {
                    courses.push(this.value);
                });

                var payment=$('#payment_fee').val().trim();
                var memberName=$('#member_name').val().trim();
                var visaStatus=$('#visa_condition').val();
                var visaNote=$('#visa_note').val();
                var visaCondition=$('.visa_status').val();

                var reg_grp_names=$('#reg_grp_names').val();

                if(visaStatus==7 && visaNote=='' ){
                    visaNoteStatus=1;
                }else{
                    visaNoteStatus=0;
                }

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

                // if(hear_about.length==0){
                //     hear_about_error=0;
                // }else if(hear_about.includes('9')){

                //     if(hearedby==''){
                //         hear_about_error=0;
                //     }else{
                //         hear_about_error=1;
                //     }

                // }else{
                //     hear_about_error=1;
                // }

                if(hear_about==''){
                    hear_about_error=0;
                }else{
                    hear_about_error=1;
                }
                
                // checkPhone=0;            
                // var error_ph=await getData(contactName).split('||')[0];
                var enquiryIdRec=await getData(contactName);                
                if(enquiryIdRec.split('||')[0]==1 || ( contactName=='' || contactName.length!=10 ) ){
                    var phoneChecks=1;
                }else{
                    var phoneChecks=0;
                }

                if(studentName==''|| phoneChecks==1 ||emailAddress==''|| (emailAddress!='' && !emailAddress.match(emailregexp)==true ) ||courses.length==0||payment=='' || enquiryDate=='' || refer_select_error==0 || hear_about_error==0 || surname=='' || enquiryFor==''|| postCode=='' || visit_before=='' || memberName=='' || visaNoteStatus==1 ){

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

                    if(hear_about_error==0){
                        if(hear_about.length==0){
                            $('#hear_about').addClass('invalid-div');
                            $('#hear_about').removeClass('valid-div');
                            $('#hear_about').closest('div').find('.error-feedback').show();
                        }else if(hear_about.includes('9')){

                            if(hearedby==''){
                                $('#hearedby').addClass('invalid-div');
                                $('#hearedby').removeClass('valid-div');
                                $('#hearedby').closest('div').find('.error-feedback').show();
                            }else{
                                $('#hearedby').addClass('valid-div');
                                $('#hearedby').removeClass('invalid-div');
                                $('#hearedby').closest('div').find('.error-feedback').hide();
                            }

                        }else{
                            $('#hear_about').addClass('valid-div');
                            $('#hear_about').removeClass('invalid-div');
                            $('#hear_about').closest('div').find('.error-feedback').hide();
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
                    }else if(enquiryIdRec.split('||')[0]==1){
                        $('#contact_num').addClass('invalid-div');
                        $('#contact_num').removeClass('valid-div');                        
                        $('#contact_num').closest('div').find('.error-feedback').hide();     
                        $('#contact_num').closest('div').find('.phone_error').show();
                        $('#contact_num').closest('div').find('#phone_err_id').html(enquiryIdRec.split('||')[1]);
                    }else{
                        $('#contact_num').addClass('valid-div');
                        $('#contact_num').removeClass('invalid-div');
                        $('#contact_num').closest('div').find('.error-feedback').hide();
                        $('#contact_num').closest('div').find('.phone_error').hide();
                    }
                    if(memberName=='' ){
                        $('#member_name').addClass('invalid-div');
                        $('#member_name').removeClass('valid-div');
                        $('#member_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#member_name').addClass('valid-div');
                        $('#member_name').removeClass('invalid-div');
                        $('#member_name').closest('div').find('.error-feedback').hide();
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
                    if(courses.length==0){
                        // $('#courses').addClass('invalid-div');
                        // $('#courses').removeClass('valid-div');
                        $('.courses_error').show();
                    }else{
                        // $('#courses').addClass('valid-div');
                        // $('#courses').removeClass('invalid-div');
                        $('.courses_error').hide();
                    }
                    if(visaNoteStatus==1){
                        $('#visa_note').addClass('invalid-div');
                        $('#visa_note').removeClass('valid-div');
                        $('#visa_note').closest('div').find('.error-feedback').show();
                    }else{
                        $('#visa_note').addClass('valid-div');
                        $('#visa_note').removeClass('invalid-div');
                        $('#visa_note').closest('div').find('.error-feedback').hide();
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

                    // console.log($('.error-feedback:visible'));
                    // $('.collapse').collapse();

                    $('.error-feedback:visible').parent('.accordion-button').trigger('click');
                    // if($('.error-feedback:visible').css('display')!='none'){

                    // }

                }else{
                    var checkId=$("#check_update").val();
                    var forms=true;
                    var appointForm=true;

                    if(courseType==1){
                        forms= submitRpl();
                    }else if(courseType==5 || courseType==4){
                        forms= submitShortGroup();
                    }else if(courseType==3){
                        if(reg_grp_names==''){
                            $('#reg_grp_names').addClass('invalid-div');
                             $('#reg_grp_names').removeClass('valid-div');
                            return false;
                        }else{
                            $('#reg_grp_names').addClass('valid-div');
                             $('#reg_grp_names').removeClass('invalid-div');
                        }
                    }

                    if(appointment_booked==1){
                        appointForm= submitSlot();
                    }

                    if(forms && appointForm ){

                    $('#loader-container').css('display','flex');
                    $('#student_enquiry_form').css('opacity','0.1');

                    courses=courses.filter(item => item !== '0');
                    remarks=remarks.filter(item => item !== '0');
                    
                    details={formName:'student_enquiry',studentName:studentName,contactName:contactName,emailAddress:emailAddress,courses:courses,payment:payment,checkId:checkId,visaStatus:visaStatus,surname:surname,enquiryDate:enquiryDate,suburb:suburb,stuState:stuState,postCode:postCode,visit_before:visit_before,hear_about:hear_about,hearedby:hearedby,memberName:memberName,plan_to_start_date:plan_to_start_date,refer_select:refer_select,referer_name:referer_name,refer_alumni:refer_alumni,visaNote:visaNote,prefComment:prefComment,comments:comments,appointment_booked:appointment_booked,visaCondition:visaCondition,remarks:remarks,reg_grp_names:reg_grp_names,streetDetails:streetDetails,enquiryFor:enquiryFor,courseType:courseType,shore:shore,ethnicity:ethnicity,rpl_arrays:JSON.stringify(rpl_array),short_grps:JSON.stringify(short_grp),slot_books:JSON.stringify(slot_book),admin_id:"<?php echo $_SESSION['user_id']; ?>",formId:<?php echo $form_id; ?>,rpl_status:'<?php echo $rpl_status; ?>',short_grp_status:'<?php echo $short_grp_status; ?>',reg_grp_status:'<?php echo $reg_grp_status; ?>',slot_book_status:'<?php echo $slot_book_status; ?>'};
                    $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data==0){
                                $('.toast-text2').html('Cannot add record. Please try again later');
                                $('#borderedToast2Btn').trigger('click');
                            }else if(data==2){
                                // $( "#student_enquiry_form_parent" ).load(window.location.href + " #student_enquiry_form" );
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('Record Updated Successfully');
                                $('#borderedToast1Btn').trigger('click');
                                // $('#jelly_loader').hide();
                                $('#loader-container').hide();
                                $('#student_enquiry_form').css('opacity','');
                                setTimeout(() => {location.reload();}, 500); 
                                // window.location.href="dashboard.php";
                            }else{
                                // $( "#student_enquiry_form_parent" ).load(window.location.href + " #student_enquiry_form" );
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('New Enquiry Added');
                                $('#borderedToast1Btn').trigger('click');

                                $('#myModalLabel').html('Enquiry ID Created:');
                                $('.modal-body').html(data);
                                $('#model_trigger').trigger('click');
                                $('#loader-container').hide();
                                // $('#jelly_loader').hide();
                                $('#student_enquiry_form').css('opacity','');
                                setTimeout(() => {location.reload();}, 500); 
                            }
                        }
                    })
                    }
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

            var rpl_array=<?php echo $rpl_arrays; ?>;
            var short_grp=<?php echo $short_grps ?>;
            var slot_book=<?php echo $slot_books ?>;
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

                    return false;

                }else{

                    rpl_array={"rpl_exp":rpl_exp,"exp_in":exp_in,"exp_docs":exp_docs,"exp_prev":exp_prev,"exp_name":exp_name,"exp_years":exp_years,"exp_prev_name":exp_prev_name};
                    return true;
                    
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

                // if(short_grp_org_name=='' || short_grp_date=='' || short_grp_num_std=='' || short_grp_ind_exp=='' || short_grp_con_type=='' || short_grp_con_num=='' || short_grp_con_name=='' || (short_grp_con_email!='' && !short_grp_con_email.match(emailregexp)==true ) || short_grp_org_type=='' || short_grp_campus=='' || short_grp_before==''){
                    

                //     if(short_grp_org_name==''){
                //         $('#short_grp_org_name').addClass('invalid-div');
                //         $('#short_grp_org_name').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_org_name').addClass('valid-div');
                //         $('#short_grp_org_name').removeClass('invalid-div');
                //     }
                //     if(short_grp_date==''){
                //         $('#short_grp_date').addClass('invalid-div');
                //         $('#short_grp_date').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_date').addClass('valid-div');
                //         $('#short_grp_date').removeClass('invalid-div');
                //     }
                //     if(short_grp_num_std==''){
                //         $('#short_grp_num_std').addClass('invalid-div');
                //         $('#short_grp_num_std').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_num_std').addClass('valid-div');
                //         $('#short_grp_num_std').removeClass('invalid-div');
                //     }
                //     if(short_grp_ind_exp==''){
                //         $('#short_grp_ind_exp').addClass('invalid-div');
                //         $('#short_grp_ind_exp').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_ind_exp').addClass('valid-div');
                //         $('#short_grp_ind_exp').removeClass('invalid-div');
                //     }
                //     if(short_grp_con_type==''){
                //         $('#short_grp_con_type').addClass('invalid-div');
                //         $('#short_grp_con_type').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_con_type').addClass('valid-div');
                //         $('#short_grp_con_type').removeClass('invalid-div');
                //     }
                //     if(short_grp_con_num==''){
                //         $('#short_grp_con_num').addClass('invalid-div');
                //         $('#short_grp_con_num').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_con_num').addClass('valid-div');
                //         $('#short_grp_con_num').removeClass('invalid-div');
                //     }
                //     if(short_grp_con_name==''){
                //         $('#short_grp_con_name').addClass('invalid-div');
                //         $('#short_grp_con_name').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_con_name').addClass('valid-div');
                //         $('#short_grp_con_name').removeClass('invalid-div');
                //     }
                //     if((short_grp_con_email!='' && !short_grp_con_email.match(emailregexp)==true )){
                //         $('#short_grp_con_email').addClass('invalid-div');
                //         $('#short_grp_con_email').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_con_email').addClass('valid-div');
                //         $('#short_grp_con_email').removeClass('invalid-div');
                //     }
                //     if(short_grp_before==''){
                //         $('#short_grp_before').addClass('invalid-div');
                //         $('#short_grp_before').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_before').addClass('valid-div');
                //         $('#short_grp_before').removeClass('invalid-div');
                //     }
                //     if(short_grp_campus==''){
                //         $('#short_grp_campus').addClass('invalid-div');
                //         $('#short_grp_campus').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_campus').addClass('valid-div');
                //         $('#short_grp_campus').removeClass('invalid-div');
                //     }
                //     if(short_grp_org_type==''){
                //         $('#short_grp_org_type').addClass('invalid-div');
                //         $('#short_grp_org_type').removeClass('valid-div');
                //     }else{
                //         $('#short_grp_org_type').addClass('valid-div');
                //         $('#short_grp_org_type').removeClass('invalid-div');
                //     }
                //     return false;


                // }else{

                    
                    short_grp={"short_grp_org_name":short_grp_org_name,"short_grp_org_type":short_grp_org_type,"short_grp_campus":short_grp_campus,"short_grp_date":short_grp_date,"short_grp_num_std":short_grp_num_std,"short_grp_ind_exp":short_grp_ind_exp,"short_grp_con_type":short_grp_con_type,"short_grp_con_num":short_grp_con_num,"short_grp_con_name":short_grp_con_name, "short_grp_con_email":short_grp_con_email,"short_grp_before":short_grp_before};
                    return true;

                }
            // }

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

                    return false;

                }else{

                    slot_book={"slot_book_time":slot_book_time,"slot_book_purpose":slot_book_purpose,"slot_book_date":slot_book_date,"slot_book_by":slot_book_by,"slot_book_link":slot_book_link};
                    return true;

                }

            }

            $(document).on('change','#counselling_form .mig_test',function(){
                var mig_test=$('#counselling_form .mig_test:checked').val();
                $('#counselling_form .mig_test_child').toggle(mig_test==1);
            });
            $(document).on('change','#counselling_form .aus_study',function(){
                var aus_study=$('#counselling_form .aus_study:checked').val();
                $('#counselling_form .aus_study_child').toggle(aus_study==1);
            });
            $(document).on('change','#followup_enquiry_id',function(){
                var opt=$('#followup_enquiry_id option:selected');
                $('#followup_mobile_num').val(opt.data('mobile')||'');
                $('#followup_student_name').val(opt.data('name')||'');
            });
            $(document).on('click','#counseling_submit',function(){
                var $f=$('#counselling_form');
                var enquiry_id=($('#counselling_enquiry_id').length ? $('#counselling_enquiry_id').val() : '').toString().trim();
                var counseling_timing=$('#counseling_timing').val().trim();
                var counseling_type=$f.find('.counseling_type:checked').val();
                var member_name=$('#counselling_member_name').val().trim();
                var aus_duration=$('#aus_duration').val().trim();
                var work_status=$f.find('.work_status:checked').val();
                var visa_condition=$('#counselling_visa_condition').val();
                if(visa_condition=='0')visa_condition='';
                var education=$('#counselling_education').val();
                var aus_study=$f.find('.aus_study:checked').val();
                var qualification=$('#counselling_qualification').val();
                var eng_rate=$('#counselling_eng_rate').val();
                var mig_test=$f.find('.mig_test:checked').val();
                var vaccine_status=$f.find('.vaccine_status:checked').val();
                var remarks=[];$f.find('.counselling_remarks:checked').each(function(){remarks.push(this.value);});
                var checkId=$('#counselling_check_update').val();
                var aus_study_error=1;
                if(aus_study==1){if($('#counselling_course').val()==''||$('#counselling_university_name').val()=='')aus_study_error=0;}
                var mig_test_error=1;
                if(mig_test==1){if($('#counselling_overall_result').val()==''||$('#counselling_module_result').val()==''||$('#counselling_job_nature').val()=='')mig_test_error=0;}
                if(!enquiry_id||!counseling_timing||!counseling_type||!member_name||!aus_duration||!work_status||!visa_condition||!education||eng_rate==''||!vaccine_status||!qualification||aus_study_error==0||mig_test_error==0){
                    if(!enquiry_id)$('#counselling_enquiry_id').addClass('invalid-div').closest('.mb-3').find('.error-feedback').show();
                    return;
                }
                var details={formName:'counseling_form',vaccine_status:vaccine_status,job_nature:$('#counselling_job_nature').val(),module_result:$('#counselling_module_result').val(),pref_comment:$('#counselling_pref_comment').val(),eng_rate:eng_rate,mig_test:mig_test,overall_result:$('#counselling_overall_result').val(),course:$('#counselling_course').val(),university_name:$('#counselling_university_name').val(),qualification:qualification,counseling_timing:counseling_timing,counseling_end_timing:$('#counseling_end_timing').val(),enquiry_id:enquiry_id,counseling_type:counseling_type,member_name:member_name,aus_duration:aus_duration,work_status:work_status,visa_condition:visa_condition,education:education,remarks:remarks,aus_study:aus_study,checkId:checkId,admin_id:"<?php echo $_SESSION['user_id']; ?>"};
                $.ajax({type:'post',url:'includes/datacontrol.php',data:details,success:function(data){
                    if(data==1){$('#toast-text').html('Record Added Successfully');$('#borderedToast1Btn').trigger('click');setTimeout(function(){location.reload();},400);}
                    else{$('.toast-text2').html('Cannot add record. Please try again later');$('#borderedToast2Btn').trigger('click');}
                }});
            });
            $(document).on('click','#followup_check',function(){
                var student_name=$('#followup_student_name').val().trim();
                var contact_num=$('#followup_mobile_num').val().trim();
                var contacted_person=$('#followup_contacted_person').val().trim();
                var contacted_time=$('#followup_contacted_time').val().trim();
                var date=$('#followup_date').val().trim();
                var contactMode=$('#followup_mode_contacted').val();
                var comments=$('#followup_comments').val().trim();
                var progress_status=$('#followup_progress_status').val();
                var enquiry_id=$('#followup_enquiry_id').val();
                var remarks=[];$('#followup_form_embed .followup_remarks:checked').each(function(){remarks.push(this.value);});
                var checkId=$('#followup_check_update').val();
                if(!date||!contactMode||!contacted_person||!student_name||!contacted_time||!contact_num||contact_num.length!=10){
                    if(!contact_num||contact_num.length!=10)$('#followup_mobile_num').addClass('invalid-div').closest('.mb-3').find('.error-feedback').show();
                    if(!contactMode)$('#followup_mode_contacted').addClass('invalid-div').closest('.mb-3').find('.error-feedback').show();
                    if(!contacted_time)$('#followup_contacted_time').addClass('invalid-div').closest('.mb-3').find('.error-feedback').show();
                    if(!date)$('#followup_date').addClass('invalid-div').closest('.mb-3').find('.error-feedback').show();
                    if(!student_name)$('#followup_student_name').addClass('invalid-div').closest('.mb-3').find('.error-feedback').show();
                    return;
                }
                var details={formName:'followup_call',student_name:student_name,date:date,contacted_person:contacted_person,contacted_time:contacted_time,contactMode:contactMode,progress_status:progress_status,contact_num:contact_num,enquiry_id:enquiry_id,remarks:remarks,comments:comments,checkId:checkId,admin_id:"<?php echo $_SESSION['user_id']; ?>"};
                $.ajax({type:'post',url:'includes/datacontrol.php',data:details,success:function(data){
                    if(data==1){$('#toast-text').html('Record Added Successfully');$('#borderedToast1Btn').trigger('click');setTimeout(function(){location.reload();},400);}
                    else{$('.toast-text2').html('Cannot add record. Please try again later');$('#borderedToast2Btn').trigger('click');}
                }});
            });

        </script>
    </body>
</html>
<?php }else{ 
header("Location: index.php");
}
?>
