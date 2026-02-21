<?php
include('includes/dbconnect.php');
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/includes/google_calendar_helper.php';

$message = '';
$error = '';

// OAuth callback: exchange code for tokens (single shared account)
if (isset($_GET['action']) && $_GET['action'] === 'callback' && !empty($_GET['code'])) {
    $result = google_calendar_exchange_code($connection, $_GET['code']);
    if (!empty($result['success'])) {
        header('Location: google_calendar_settings.php?connected=1');
        exit;
    }
    $error = isset($result['error']) ? $result['error'] : 'Could not connect. Check your Client ID and Secret, and that the redirect URI matches exactly.';
}

// Disconnect shared account
if (isset($_GET['action']) && $_GET['action'] === 'disconnect') {
    $tableCheck = mysqli_fetch_row(mysqli_query($connection, "SHOW TABLES LIKE 'google_calendar_tokens'"));
    if ($tableCheck) mysqli_query($connection, "DELETE FROM google_calendar_tokens WHERE id=1");
    header('Location: google_calendar_settings.php?disconnected=1');
    exit;
}

// Save API credentials (admin)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_google_config'])) {
    $cid = isset($_POST['google_client_id']) ? trim($_POST['google_client_id']) : '';
    $csec = isset($_POST['google_client_secret']) ? trim($_POST['google_client_secret']) : '';
    $redirect_uri = isset($_POST['google_redirect_uri']) ? trim($_POST['google_redirect_uri']) : '';
    $cid_esc = mysqli_real_escape_string($connection, $cid);
    $csec_esc = mysqli_real_escape_string($connection, $csec);
    $redirect_esc = mysqli_real_escape_string($connection, $redirect_uri);
    $tableExists = mysqli_fetch_row(mysqli_query($connection, "SHOW TABLES LIKE 'site_settings'"));
    if ($tableExists) {
        mysqli_query($connection, "INSERT INTO site_settings (setting_key, setting_value) VALUES ('google_calendar_client_id','$cid_esc'), ('google_calendar_client_secret','$csec_esc'), ('google_calendar_redirect_uri','$redirect_esc') ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)");
        $message = 'Credentials saved. Copy the Redirect URI below into Google Console if you haven’t already, then connect your Google account.';
    } else {
        $error = 'Run the database migration first: sql/google_calendar_migration.sql (creates site_settings and google_calendar_tokens tables).';
    }
}

$config = google_calendar_get_config($connection);
$auth_url = google_calendar_get_auth_url($connection);
$redirect_uri_used = !empty(trim($config['redirect_uri'])) ? trim($config['redirect_uri']) : google_calendar_build_redirect_uri();
$tbl = @mysqli_query($connection, "SHOW TABLES LIKE 'google_calendar_tokens'");
$connected = $tbl && mysqli_num_rows($tbl) && mysqli_fetch_row(mysqli_query($connection, "SELECT 1 FROM google_calendar_tokens WHERE id=1 AND refresh_token IS NOT NULL AND refresh_token != ''"));
if (isset($_GET['connected'])) $message = 'Google Calendar connected. When any staff sets a Next Follow-Up Date, an event is created and all dashboard staff are added as attendees so everyone gets it on their calendar.';
if (isset($_GET['disconnected'])) $message = 'Google Calendar disconnected.';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Google Calendar – Follow-up reminders</title>
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
                        <h4 class="mb-sm-0">Google Calendar – Follow-up reminders</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="student_enquiry.php">Create Enquiry</a></li>
                                <li class="breadcrumb-item"><a href="student_enquiry.php?view=list">View Enquiry</a></li>
                                <li class="breadcrumb-item active">Google Calendar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Prerequisites / API credentials -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">1. Prerequisites (one-time setup)</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">One admin connects a single Google account here. When <strong>any</strong> staff sets a <strong>Next Follow-Up Date</strong>, an event is created and <strong>all dashboard staff</strong> are added as attendees so everyone gets the event (and reminders) on their own calendar. Create OAuth credentials in Google Cloud and save them below.</p>
                            <ol class="small mb-3">
                                <li>Go to <a href="https://console.cloud.google.com/" target="_blank" rel="noopener">Google Cloud Console</a> and create/select a project.</li>
                                <li>Enable <strong>Google Calendar API</strong>: APIs &amp; Services → Library → search “Calendar API” → Enable.</li>
                                <li>Create <strong>OAuth 2.0 Client ID</strong>: APIs &amp; Services → Credentials → Create Credentials → OAuth client ID. Application type: <strong>Web application</strong>. Under <strong>Authorized redirect URIs</strong>, add the <strong>exact</strong> URL shown in the “Redirect URI” field below (copy it—it must match character for character).</li>
                                <li>Copy the <strong>Client ID</strong> and <strong>Client Secret</strong> from Google and paste below.</li>
                            </ol>
                            <form method="post" class="mb-0">
                                <div class="mb-2">
                                    <label class="form-label">Redirect URI <span class="text-muted">(copy this into Google Console → Authorized redirect URIs)</span></label>
                                    <input type="text" name="google_redirect_uri" class="form-control font-monospace small" placeholder="Leave blank to use auto-detected URL" value="<?php echo htmlspecialchars($config['redirect_uri']); ?>" title="Must match exactly what you add in Google Cloud Console">
                                    <small class="text-muted">If blank we use: <code><?php echo htmlspecialchars($redirect_uri_used); ?></code></small>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Client ID</label>
                                    <input type="text" name="google_client_id" class="form-control" placeholder="xxxxx.apps.googleusercontent.com" value="<?php echo htmlspecialchars($config['client_id']); ?>">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Client Secret</label>
                                    <input type="password" name="google_client_secret" class="form-control" placeholder="GOCSPX-..." value="<?php echo htmlspecialchars($config['client_secret']); ?>">
                                </div>
                                <button type="submit" name="save_google_config" class="btn btn-outline-primary btn-sm">Save credentials</button>
                            </form>
                        </div>
                    </div>

                    <!-- Connect / Disconnect (single shared account) -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">2. Connect one Google account (admin)</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($connected): ?>
                                <p class="text-success mb-2">A Google account is connected. When <strong>any staff</strong> sets a <strong>Next Follow-Up Date</strong> in the Follow-up section, an event is created and <strong>all dashboard users</strong> (from the Users list) are added as attendees, so everyone gets the event and reminders.</p>
                                <a href="google_calendar_settings.php?action=disconnect" class="btn btn-outline-danger btn-sm">Disconnect Google Calendar</a>
                            <?php else: ?>
                                <?php if (empty($config['client_id']) || empty($config['client_secret'])): ?>
                                    <p class="text-warning mb-0">Save your Client ID and Client Secret above first, then click the button below.</p>
                                <?php else: ?>
                                    <p class="mb-2">As admin, connect <strong>one</strong> Google account. Events will be created from this account and all staff will be added as attendees so everyone receives the follow-up reminder.</p>
                                    <a href="<?php echo htmlspecialchars($auth_url); ?>" class="btn btn-primary"><i class="ti ti-calendar"></i> Connect Google Calendar</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include('includes/footer_includes.php'); ?>
</body>
</html>
