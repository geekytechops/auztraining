<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Light Sidebar | Upzet - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <?php include('includes/app_includes.php'); ?>
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
                                    <h4 class="mb-sm-0">Student's Enrolment Form</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Student's Enquiry</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="student_enquiry_form" id="student_enquiry_form">
                                        <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="qualifications">Qualification</label>
                                                            <select name="qualifications" class="form-control" id="qualifications">
                                                                <option value="0">--select--</option>
                                                                <option value="1">Masters Degree</option>
                                                                <option value="2">Bachelors Degree</option>
                                                                <option value="3">MCA</option>
                                                            </select>
                                                        <div class="error-feedback">
                                                            Please select qualification
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="venue">Venue</label>
                                                        <select name="qualifications" class="form-control" id="qualifications">
                                                                <option value="0">--select--</option>
                                                                <option value="1">Adeladie</option>
                                                                <option value="2">New Jersey</option>
                                                                <option value="3">Australia</option>
                                                            </select>
                                                        <div class="error-feedback">
                                                            Please Select a Venue
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="given_name">Given Name</label>
                                                        <input type="text" class="form-control" id="given_name" placeholder="Given Name" value="" >
                                                        <div class="error-feedback">
                                                            Please enter the Given name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_main">I am</label>
                                                        <input type="text" class="form-control" id="name_main" value="" >
                                                        <div class="error-feedback">
                                                            Please enter the Name
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="middle_name">Middle Name</label>
                                                        <input type="text" class="form-control" id="middle_name" placeholder="Middle Name" value="" >
                                                        <div class="error-feedback">
                                                            Please enter the Middle Name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="courses">How did you hear about Milton College</label>
                                                        <select name="courses" class="form-control" id="courses">
                                                            <option value="0">--select--</option>
                                                            <option value="1">Friends</option>
                                                            <option value="2">Google</option>
                                                            <option value="3">Website</option>
                                                        </select>
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Submit Form</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->                            
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <?php include('includes/footer_includes.php'); ?>
    </body>
</html>
