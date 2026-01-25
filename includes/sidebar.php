<?php session_start(); ?>
<?php $CRM_ASSET_BASE = 'crm/html/template/assets'; ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div>
                    <a href="dashboard.php" class="logo logo-normal text-center">
                        <img src="<?php echo $CRM_ASSET_BASE; ?>/img/logo.png" alt="Logo" height="50">
                    </a>
                    <a href="dashboard.php" class="logo-small">
                        <img src="<?php echo $CRM_ASSET_BASE; ?>/img/logo-small.png" alt="Logo" width="50">
                    </a>
                    <a href="dashboard.php" class="dark-logo text-center">
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
                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li>
                                    <a href="dashboard.php"><i class="ti ti-dashboard"></i><span>Dashboard</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li>
                                    <a href="student_enquiry.php"><i class="ti ti-file-text"></i><span>Student's Enquiry</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li>
                                    <a href="enrolment.php"><i class="ti ti-user-plus"></i><span>Enrolment</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li>
                                    <a href="create_user.php"><i class="ti ti-users"></i><span>Create User</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li>
                                    <a href="followup_call.php"><i class="ti ti-phone"></i><span>Follow Up Call</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li>
                                    <a href="counselling_form.php"><i class="ti ti-book"></i><span>Counseling</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li class="submenu">
                                    <a href="javascript:void(0);"><i class="ti ti-calendar"></i><span>Appointments</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="appointment_calendar.php">Calendar View</a></li>
                                        <li><a href="appointment_booking.php">Book Appointment</a></li>
                                        <li><a href="appointment_reports.php">Reports</a></li>
                                        <li><a href="appointment_blocks.php">Block Slots</a></li>
                                    </ul>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==0){ ?>
                                <li>
                                    <a href="student_docs.php"><i class="ti ti-file-upload"></i><span>Documents</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li class="d-none">
                                    <a href="attendance_record.php"><i class="ti ti-file-spreadsheet"></i><span>Attendance Records</span></a>
                                </li>
                                <li class="d-none">
                                    <a href="attendance.php"><i class="ti ti-file-spreadsheet"></i><span>Add Attendance</span></a>
                                </li>
                                <?php } ?>

                                <?php if(@$_SESSION['user_type']==1){ ?>
                                <li>
                                    <a href="invoices1.php"><i class="ti ti-file-invoice"></i><span>Invoices</span></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>