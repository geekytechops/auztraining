<?php session_start(); ?>
<!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Forms</li>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li class="">
                                <a href="dashboard.php" class="waves-effect">
                                    <i class="mdi mdi-home-variant-outline"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li>
                                <a href="student_enquiry.php" class="waves-effect">
                                    <i class="fab fa-wpforms"></i>
                                    <span>Student's Enquiry</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li>
                                <a href="enrolment.php" class="waves-effect">
                                    <i class="mdi mdi-account-plus"></i>
                                    <span>Enrolment</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li>
                                <a href="create_user.php" class="waves-effect">
                                    <i class="mdi mdi-account-plus"></i>
                                    <span>Create User</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li>
                                <a href="followup_call.php" class="waves-effect">
                                    <i class="ri-user-follow-fill"></i>
                                    <span>Follow Up Call</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li>
                                <a href="counselling_form.php" class="waves-effect">
                                    <i class="fas fa-book-reader"></i>
                                    <span>Counseling</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-calendar-clock"></i>
                                    <span>Appointments</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="appointment_calendar.php">Calendar View</a></li>
                                    <li><a href="appointment_booking.php">Book Appointment</a></li>
                                    <li><a href="appointment_reports.php">Reports</a></li>
                                    <li><a href="appointment_blocks.php">Block Slots</a></li>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php 
                            if(@$_SESSION['user_type']==0){
                            ?>
                            <li class="">
                                <a href="student_docs.php" class="waves-effect">
                                    <i class="mdi mdi-file-upload"></i>
                                    <span>Documents</span>
                                </a>
                            </li>
                            <?php 
                            }
                            ?>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li class="d-none">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-file-excel"></i>
                                    <span>Attendance</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="attendance_record.php">Attendance Records</a></li>
                                    <li><a href="attendance.php">Add Attendance</a></li>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php 
                            if(@$_SESSION['user_type']==1){
                            ?>
                            <li class="">
                                <a href="invoices1.php" class="waves-effect">
                                    <i class="fas fa-file-invoice"></i>
                                    <span>Invoices</span>
                                </a>    
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->