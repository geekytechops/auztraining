<?php
include('includes/dbconnect.php');
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 1) {
    header('Location: index.php');
    exit;
}

$status_labels = array(
    1 => 'New',
    2 => 'Contacted',
    3 => 'Follow-up Required',
    4 => 'Interested',
    5 => 'Documents Collected',
    6 => 'Enrolled',
    7 => 'Not Interested',
    8 => 'Invalid / Duplicate'
);

$templates = array();
$q = mysqli_query($connection, "SELECT id, status_code, subject, body, updated_at FROM enquiry_status_email_templates ORDER BY status_code");
if ($q && mysqli_num_rows($q)) {
    while ($row = mysqli_fetch_assoc($q)) {
        $templates[$row['status_code']] = $row;
    }
}
// Ensure we have a row for each status (use defaults if table empty)
for ($i = 1; $i <= 8; $i++) {
    if (!isset($templates[$i])) {
        $templates[$i] = array('id' => '', 'status_code' => $i, 'subject' => '', 'body' => '', 'updated_at' => null);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Enquiry Status Email Templates</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('includes/app_includes.php'); ?>
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
                        <h4 class="mb-sm-0">Enquiry Status Email Templates</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="student_enquiry.php">Create Enquiry</a></li>
                                <li class="breadcrumb-item"><a href="student_enquiry.php?view=list">View Enquiry</a></li>
                                <li class="breadcrumb-item active">Email Templates</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-muted">Edit the default email templates used when staff send emails from the Follow-up section. Each template is linked to an enquiry status. Use <code>{{student_name}}</code> in the body to insert the student's name.</p>
                    <div class="accordion" id="templatesAccordion">
                        <?php for ($i = 1; $i <= 8; $i++) {
                            $t = $templates[$i];
                            $sid = (int)$t['status_code'];
                            $subj = htmlspecialchars($t['subject'] ?? '');
                            $body = htmlspecialchars($t['body'] ?? '');
                            $updated = !empty($t['updated_at']) ? date('d M Y H:i', strtotime($t['updated_at'])) : '—';
                        ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="head<?php echo $sid; ?>">
                                <button class="accordion-button <?php echo $i > 1 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $sid; ?>" aria-expanded="<?php echo $i === 1 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $sid; ?>">
                                    <?php echo $status_labels[$i]; ?> <span class="badge bg-secondary ms-2">Status <?php echo $i; ?></span>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $sid; ?>" class="accordion-collapse collapse <?php echo $i === 1 ? 'show' : ''; ?>" aria-labelledby="head<?php echo $sid; ?>" data-bs-parent="#templatesAccordion">
                                <div class="accordion-body">
                                    <div class="mb-2 small text-muted">Last updated: <?php echo $updated; ?></div>
                                    <div class="mb-3">
                                        <label class="form-label">Subject</label>
                                        <input type="text" class="form-control template-subject" data-status="<?php echo $sid; ?>" value="<?php echo $subj; ?>" placeholder="Email subject">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Body</label>
                                        <textarea class="form-control template-body" data-status="<?php echo $sid; ?>" rows="5" placeholder="Email body. Use {{student_name}} for the student's name."><?php echo $body; ?></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm save-template-btn" data-status="<?php echo $sid; ?>">Save template</button>
                                    <span class="ms-2 save-feedback" data-status="<?php echo $sid; ?>"></span>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
$(function(){
    $(document).on('click', '.save-template-btn', function(){
        var status = $(this).data('status');
        var subject = $('.template-subject[data-status="'+status+'"]').val().trim();
        var body = $('.template-body[data-status="'+status+'"]').val().trim();
        var $btn = $(this).prop('disabled', true).text('Saving...');
        var $fb = $('.save-feedback[data-status="'+status+'"]').removeClass('text-success text-danger').text('');
        $.post('includes/datacontrol.php', { save_enquiry_status_template: 1, status_code: status, subject: subject, body: body }, function(data){
            $btn.prop('disabled', false).text('Save template');
            if (data == '1') {
                $fb.addClass('text-success').text('Saved.');
                setTimeout(function(){ $fb.text(''); }, 3000);
            } else {
                $fb.addClass('text-danger').text('Failed to save.');
            }
        });
    });
});
</script>
<?php include('includes/footer_includes.php'); ?>
</body>
</html>
