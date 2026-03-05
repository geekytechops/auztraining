<?php
include('includes/dbconnect.php');
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] === ''){
    header('Location: index.php');
    exit;
}
$ut = (int)@$_SESSION['user_type'];
if($ut !== 1 && $ut !== 2){
    header('Location: dashboard.php');
    exit;
}
$courses_q = mysqli_query($connection, "SELECT course_id, course_sname, course_name FROM courses WHERE course_status!=1 ORDER BY course_sname");
$sources = array('','Website form','Phone call','Walk-in','Email','WhatsApp','Facebook / Instagram ads','Agent / referral');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>View Enquiries | Enquiry List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <?php include('includes/app_includes.php'); ?>
    <style>
        .enquiry-card{ transition: transform .15s ease; }
        .enquiry-card:hover{ transform: translateY(-2px); }
        .table-next-fup{ min-width: 120px; }
        .table-enquiry-list thead th{ white-space: nowrap; }
        #enquiry_list_body tr td:first-child{ font-weight: 500; }
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
                            <h4 class="mb-sm-0">View Enquiries</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="student_enquiry.php">Create Enquiry</a></li>
                                    <li class="breadcrumb-item active">Enquiry List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard cards -->
                <div class="row mb-4">
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="card enquiry-card border-primary">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 small">Today</p>
                                        <h5 class="mb-0" id="card_today">0</h5>
                                    </div>
                                    <div class="avatar-sm bg-primary bg-opacity-10 rounded"><i class="ti ti-calendar text-primary fs-4"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="card enquiry-card border-info">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 small">This Week</p>
                                        <h5 class="mb-0" id="card_week">0</h5>
                                    </div>
                                    <div class="avatar-sm bg-info bg-opacity-10 rounded"><i class="ti ti-calendar-week text-info fs-4"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="card enquiry-card border-secondary">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 small">This Month</p>
                                        <h5 class="mb-0" id="card_month">0</h5>
                                    </div>
                                    <div class="avatar-sm bg-secondary bg-opacity-10 rounded"><i class="ti ti-calendar-month text-secondary fs-4"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="card enquiry-card border-warning">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 small">Follow-ups Due Today</p>
                                        <h5 class="mb-0" id="card_followups">0</h5>
                                    </div>
                                    <div class="avatar-sm bg-warning bg-opacity-10 rounded"><i class="ti ti-phone-call text-warning fs-4"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="card enquiry-card border-success">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 small">Converted</p>
                                        <h5 class="mb-0" id="card_converted">0</h5>
                                    </div>
                                    <div class="avatar-sm bg-success bg-opacity-10 rounded"><i class="ti ti-school text-success fs-4"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="card enquiry-card border-danger">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 small">Lost</p>
                                        <h5 class="mb-0" id="card_lost">0</h5>
                                    </div>
                                    <div class="avatar-sm bg-danger bg-opacity-10 rounded"><i class="ti ti-user-off text-danger fs-4"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters & List -->
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label small">Search (name, phone, email)</label>
                                <input type="text" id="filter_search" class="form-control form-control-sm" placeholder="Search...">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Course</label>
                                <select id="filter_course" class="form-select form-select-sm">
                                    <option value="0">All</option>
                                    <?php while($c = mysqli_fetch_assoc($courses_q)){ echo '<option value="'.(int)$c['course_id'].'">'.htmlspecialchars($c['course_sname'].' - '.$c['course_name']).'</option>'; } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Status</label>
                                <select id="filter_status" class="form-select form-select-sm">
                                    <option value="-1">All</option>
                                    <option value="1">New</option>
                                    <option value="2">Contacted</option>
                                    <option value="3">Follow-up Required</option>
                                    <option value="4">Interested</option>
                                    <option value="5">Documents Collected</option>
                                    <option value="6">Enrolled</option>
                                    <option value="7">Not Interested</option>
                                    <option value="8">Invalid/Duplicate</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Source</label>
                                <select id="filter_source" class="form-select form-select-sm">
                                    <option value="-1">All</option>
                                    <?php for($i=1;$i<count($sources);$i++){ echo '<option value="'.$i.'">'.htmlspecialchars($sources[$i]).'</option>'; } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Counsellor</label>
                                <input type="text" id="filter_counsellor" class="form-control form-control-sm" placeholder="Name">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Date From</label>
                                <input type="date" id="filter_date_from" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Date To</label>
                                <input type="date" id="filter_date_to" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Sort by</label>
                                <select id="sort_by" class="form-select form-select-sm">
                                    <option value="latest">Latest</option>
                                    <option value="followup_date">Follow-up Date</option>
                                    <option value="status">Status</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" id="btn_apply" class="btn btn-primary btn-sm me-1">Apply</button>
                                <button type="button" id="btn_reset" class="btn btn-outline-secondary btn-sm">Reset</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-enquiry-list mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="table-next-fup">Next Follow-up</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                        <th style="width:120px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="enquiry_list_body">
                                    <tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer_includes.php'); ?>
<script>
$(function(){
    function loadDashboard(){
        $.post('includes/datacontrol.php', { formName: 'fetchEnquiryDashboard' }, function(data){
            try {
                var j = typeof data === 'string' ? JSON.parse(data) : data;
                $('#card_today').text(j.total_today || 0);
                $('#card_week').text(j.total_week || 0);
                $('#card_month').text(j.total_month || 0);
                $('#card_followups').text(j.followups_due_today || 0);
                $('#card_converted').text(j.converted || 0);
                $('#card_lost').text(j.lost || 0);
            } catch(e) {}
        });
    }
    function loadList(){
        var d = {
            formName: 'fetchEnquiryList',
            search: $('#filter_search').val(),
            filter_course: $('#filter_course').val(),
            filter_status: $('#filter_status').val(),
            filter_date_from: $('#filter_date_from').val(),
            filter_date_to: $('#filter_date_to').val(),
            filter_counsellor: $('#filter_counsellor').val(),
            filter_source: $('#filter_source').val(),
            sort_by: $('#sort_by').val()
        };
        $('#enquiry_list_body').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
        $.post('includes/datacontrol.php', d, function(html){
            $('#enquiry_list_body').html(html && html.trim() ? html : '<tr><td colspan="6" class="text-center text-muted">No records</td></tr>');
        });
    }
    loadDashboard();
    loadList();
    $('#btn_apply').on('click', function(){ loadList(); });
    $('#btn_reset').on('click', function(){
        $('#filter_search,#filter_counsellor').val('');
        $('#filter_course').val('0');
        $('#filter_status,#filter_source').val('-1');
        $('#filter_date_from,#filter_date_to').val('');
        $('#sort_by').val('latest');
        loadList();
    });
    $('#filter_search').on('keypress', function(e){ if(e.which===13) loadList(); });
});
</script>
</body>
</html>
