<?php session_start(); ?>
<?php 
$CRM_ASSET_BASE = 'crm/html/template/assets';
$is_student_sidebar = (isset($_SESSION['user_type']) && ($_SESSION['user_type'] === 0 || $_SESSION['user_type'] === 'student'));
$sidebar_home_url = $is_student_sidebar ? 'student_docs.php' : 'dashboard.php';

// Determine current page for active highlighting
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$current_query = $_GET ?? array();

$enquiries_pages    = array('student_enquiry.php','view_enquiries.php','enquiry_reports.php');
$enrolment_pages    = array('enrolment.php','enrolment_online.php');
$appointments_pages = array('appointment_booking.php','appointment_blocks.php','appointment_calendar.php','appointment_reports.php');
$course_forms_pages = array('course_cancellations_list.php','course_extensions_list.php');

$is_enquiries_active    = in_array($current_page, $enquiries_pages, true);
$is_enrolment_active    = in_array($current_page, $enrolment_pages, true);
$is_appointments_active = in_array($current_page, $appointments_pages, true);
$is_course_forms_active = in_array($current_page, $course_forms_pages, true);
?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div>
                    <a href="<?php echo $sidebar_home_url; ?>" class="logo logo-normal text-center">
                        <img src="<?php echo $CRM_ASSET_BASE; ?>/img/logo.png" alt="Logo" height="50">
                    </a>
                    <a href="<?php echo $sidebar_home_url; ?>" class="logo-small">
                        <img src="<?php echo $CRM_ASSET_BASE; ?>/img/logo-small.png" alt="Logo" width="50">
                    </a>
                    <a href="<?php echo $sidebar_home_url; ?>" class="dark-logo text-center">
                        <img src="<?php echo $CRM_ASSET_BASE; ?>/img/logo-white.png" alt="Logo" height="50">
                    </a>
                </div>
                <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn">
                    <i class="ti ti-arrow-bar-to-left"></i>
                </button>
                <button class="sidebar-close">
                    <i class="ti ti-x align-middle"></i>
                </button>
            </div>

            <div class="sidebar-inner" data-simplebar>
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title"><span>Main Menu</span></li>
                        <li>
                            <ul>
                                <?php if(@$_SESSION['user_type']==1 || @$_SESSION['user_type']==2){ ?>
                                <li>
                                    <a href="dashboard.php" class="<?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>"><i class="ti ti-dashboard"></i><span>Dashboard</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1 || @$_SESSION['user_type']==2){ ?>
                                <li class="submenu">
                                    <a href="javascript:void(0);" class="<?php echo $is_enquiries_active ? 'active' : ''; ?>"><i class="ti ti-file-text"></i><span>Enquiries</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="student_enquiry.php" class="<?php echo ($current_page === 'student_enquiry.php' && (!isset($current_query['view']) || $current_query['view'] !== 'list')) ? 'active' : ''; ?>">Create Enquiry</a></li>
                                        <li><a href="view_enquiries.php" class="<?php echo $current_page === 'view_enquiries.php' ? 'active' : ''; ?>">View Enquiries</a></li>
                                        <li><a href="enquiry_reports.php" class="<?php echo $current_page === 'enquiry_reports.php' ? 'active' : ''; ?>">Enquiry Reports</a></li>
                                    </ul>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1 || @$_SESSION['user_type']==2){ ?>
                                <li class="submenu">
                                    <a href="javascript:void(0);" class="<?php echo $is_enrolment_active ? 'active' : ''; ?>"><i class="ti ti-user-plus"></i><span>Enrolment</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="enrolment.php" class="<?php echo $current_page === 'enrolment.php' ? 'active' : ''; ?>">Enrolment (Legacy)</a></li>
                                        <li><a href="enrolment_online.php" class="<?php echo $current_page === 'enrolment_online.php' ? 'active' : ''; ?>">Enrolment Form (Online)</a></li>
                                    </ul>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1 || @$_SESSION['user_type']==2){ ?>
                                <li class="submenu">
                                    <a href="javascript:void(0);" class="<?php echo $is_appointments_active ? 'active' : ''; ?>"><i class="ti ti-calendar"></i><span>Appointments</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="appointment_booking.php" class="<?php echo $current_page === 'appointment_booking.php' ? 'active' : ''; ?>">Book Appointment</a></li>
                                        <li><a href="appointment_blocks.php" class="<?php echo $current_page === 'appointment_blocks.php' ? 'active' : ''; ?>">Block Slots</a></li>
                                        <li><a href="appointment_calendar.php" class="<?php echo $current_page === 'appointment_calendar.php' ? 'active' : ''; ?>">Calendar View</a></li>
                                        <li><a href="appointment_reports.php" class="<?php echo $current_page === 'appointment_reports.php' ? 'active' : ''; ?>">List View</a></li>
                                    </ul>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==0 || @$_SESSION['user_type']==='student'){ ?>
                                <li>
                                    <a href="student_docs.php" class="<?php echo $current_page === 'student_docs.php' ? 'active' : ''; ?>"><i class="ti ti-file-upload"></i><span>Documents</span></a>
                                </li>
                                <li>
                                    <a href="student_enquiry_form.php" class="<?php echo $current_page === 'student_enquiry_form.php' ? 'active' : ''; ?>"><i class="ti ti-file-text"></i><span>My Enquiry</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1 || @$_SESSION['user_type']==2){ ?>
                                <li class="d-none">
                                    <a href="attendance_record.php"><i class="ti ti-file-spreadsheet"></i><span>Attendance Records</span></a>
                                </li>
                                <li class="d-none">
                                    <a href="attendance.php"><i class="ti ti-file-spreadsheet"></i><span>Add Attendance</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1 || @$_SESSION['user_type']==2){ ?>
                                <li>
                                    <a href="email_logs.php" class="<?php echo $current_page === 'email_logs.php' ? 'active' : ''; ?>"><i class="ti ti-mail-forward"></i><span>Email Logs</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1 || @$_SESSION['user_type']==2){ ?>
                                <li>
                                    <a href="invoices1.php" class="<?php echo $current_page === 'invoices1.php' ? 'active' : ''; ?>"><i class="ti ti-file-invoice"></i><span>Invoices</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1 || @$_SESSION['user_type']==2){ ?>
                                <li class="submenu">
                                    <a href="javascript:void(0);" class="<?php echo $is_course_forms_active ? 'active' : ''; ?>"><i class="ti ti-file-off"></i><span>Course Forms</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="course_cancellations_list.php" class="<?php echo $current_page === 'course_cancellations_list.php' ? 'active' : ''; ?>">Course Cancellations</a></li>
                                        <li><a href="course_extensions_list.php" class="<?php echo $current_page === 'course_extensions_list.php' ? 'active' : ''; ?>">Course Extensions</a></li>
                                    </ul>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li>
                                    <a href="create_user.php" class="<?php echo $current_page === 'create_user.php' ? 'active' : ''; ?>"><i class="ti ti-users"></i><span>Staff Management</span></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>