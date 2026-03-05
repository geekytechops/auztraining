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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Enquiry Reports &amp; Analytics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <?php include('includes/app_includes.php'); ?>
    <style>
        .report-card{ margin-bottom: 1.25rem; }
        .report-card .card-body{ padding: 1rem 1.25rem; }
        .report-table{ font-size: 0.9rem; }
        .report-table th{ white-space: nowrap; }
        .stat-big{ font-size: 1.5rem; font-weight: 600; }
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
                            <h4 class="mb-sm-0">Enquiry Reports &amp; Analytics</h4>
                            <div class="page-title-right">
                                <form method="post" action="includes/datacontrol.php" target="_blank" class="d-inline">
                                    <input type="hidden" name="formName" value="exportEnquiryReportsExcel">
                                    <button type="submit" class="btn btn-success btn-sm me-1"><i class="ti ti-file-spreadsheet me-1"></i>Export Excel</button>
                                </form>
                                <form method="post" action="includes/datacontrol.php" target="_blank" class="d-inline">
                                    <input type="hidden" name="formName" value="exportEnquiryReportsPdf">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="ti ti-file-type-pdf me-1"></i>Export PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="reports_loading" class="text-center py-4 text-muted">Loading reports...</div>
                <div id="reports_content" class="d-none">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card report-card border-primary">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-2">Conversion Rate</h6>
                                    <div class="stat-big text-primary" id="stat_conversion">0%</div>
                                    <p class="mb-0 small text-muted"><span id="stat_converted">0</span> converted / <span id="stat_total">0</span> total enquiries</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card report-card border-danger">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-2">Lost Enquiries</h6>
                                    <div class="stat-big text-danger" id="stat_lost">0</div>
                                    <p class="mb-0 small text-muted">Not Interested</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card report-card border-info">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-2">Follow-up Effectiveness</h6>
                                    <div class="stat-big text-info" id="stat_followup">0</div>
                                    <p class="mb-0 small text-muted">Converted among those with follow-up</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card report-card">
                                <div class="card-header"><h5 class="card-title mb-0">Enquiries by Course</h5></div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table report-table table-hover mb-0">
                                            <thead class="table-light"><tr><th>Course</th><th class="text-end">Count</th></tr></thead>
                                            <tbody id="report_by_course"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card report-card">
                                <div class="card-header"><h5 class="card-title mb-0">Enquiries by Source</h5></div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table report-table table-hover mb-0">
                                            <thead class="table-light"><tr><th>Source</th><th class="text-end">Count</th></tr></thead>
                                            <tbody id="report_by_source"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card report-card">
                                <div class="card-header"><h5 class="card-title mb-0">Counsellor Performance</h5></div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table report-table table-hover mb-0">
                                            <thead class="table-light"><tr><th>Counsellor</th><th class="text-end">Enquiries</th><th class="text-end">Converted</th><th class="text-end">Conversion %</th></tr></thead>
                                            <tbody id="report_counsellor"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card report-card">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-2">Follow-up Effectiveness</h6>
                                    <p class="mb-1">Enquiries with at least one follow-up: <strong id="followup_with">0</strong></p>
                                    <p class="mb-0">Converted among those with follow-up: <strong id="followup_converted">0</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card report-card">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-2">Lost Enquiries</h6>
                                    <p class="mb-0">Total enquiries marked as <strong>Not Interested</strong>: <strong id="lost_total">0</strong>. Track reasons (e.g. fee, visa, timing) in remarks for future reporting.</p>
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
$(function(){
    $.post('includes/datacontrol.php', { formName: 'fetchEnquiryReports' }, function(data){
        $('#reports_loading').addClass('d-none');
        $('#reports_content').removeClass('d-none');
        try {
            var d = typeof data === 'string' ? JSON.parse(data) : data;
            $('#stat_conversion').text((d.conversion_rate || 0) + '%');
            $('#stat_converted').text(d.converted_count || 0);
            $('#stat_total').text(d.total_enquiries || 0);
            $('#stat_lost').text(d.lost_count || 0);
            $('#lost_total').text(d.lost_count || 0);
            $('#stat_followup').text(d.followup_effectiveness ? d.followup_effectiveness.converted_with_followup : 0);
            $('#followup_with').text(d.followup_effectiveness ? d.followup_effectiveness.with_followup : 0);
            $('#followup_converted').text(d.followup_effectiveness ? d.followup_effectiveness.converted_with_followup : 0);
            var byCourse = d.by_course || [];
            var t = '';
            byCourse.forEach(function(r){ t += '<tr><td>'+escapeHtml(r.course)+'</td><td class="text-end">'+r.count+'</td></tr>'; });
            $('#report_by_course').html(t || '<tr><td colspan="2" class="text-muted">No data</td></tr>');
            var bySource = d.by_source || [];
            t = '';
            bySource.forEach(function(r){ t += '<tr><td>'+escapeHtml(r.source)+'</td><td class="text-end">'+r.count+'</td></tr>'; });
            $('#report_by_source').html(t || '<tr><td colspan="2" class="text-muted">No data</td></tr>');
            var cp = d.counsellor_performance || [];
            t = '';
            cp.forEach(function(r){ t += '<tr><td>'+escapeHtml(r.counsellor)+'</td><td class="text-end">'+r.enquiries+'</td><td class="text-end">'+r.converted+'</td><td class="text-end">'+r.rate+'%</td></tr>'; });
            $('#report_counsellor').html(t || '<tr><td colspan="4" class="text-muted">No data</td></tr>');
        } catch(e) {
            $('#reports_content').html('<div class="alert alert-danger">Failed to load report data.</div>');
        }
    }).fail(function(){ $('#reports_loading').addClass('d-none'); $('#reports_content').removeClass('d-none').html('<div class="alert alert-danger">Failed to load reports.</div>'); });
    function escapeHtml(s){ var d=document.createElement('div'); d.textContent=s; return d.innerHTML; }
});
</script>
</body>
</html>
