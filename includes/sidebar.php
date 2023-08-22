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
                            <li>
                                <a href="dashboard.php" class="waves-effect">
                                    <i class="mdi mdi-home-variant-outline"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <?php } ?>
                            <li>
                                <a href="student_enquiry.php" class="waves-effect">
                                    <i class="fab fa-wpforms"></i>
                                    <span>Student's Enquiry</span>
                                </a>
                            </li>
                            <li>
                                <a href="enrolment.php" class="waves-effect">
                                    <i class="fab fa-wpforms"></i>
                                    <span>Enrolment</span>
                                </a>
                            </li>
                            <li>
                                <a href="invoices.php" class="waves-effect">
                                    <i class="fab fa-wpforms"></i>
                                    <span>Invoices</span>
                                </a>    
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->