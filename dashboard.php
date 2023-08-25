<?php 
session_start();
// print_r($_SESSION);
if(@$_SESSION['user_type']==1){
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />

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
                                    <h4 class="mb-sm-0">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li> -->
                                            <!-- <li class="breadcrumb-item active">Light Sidebar</li> -->
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Student Records</h4>

                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    Student Enquiries
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table id="datatable" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col-3">Enquiry ID</th>
                                                                    <th scope="col-2">Student Name</th>
                                                                    <th scope="col-2">Contact Number</th>
                                                                    <th scope="col-2">Email</th>
                                                                    <th scope="col-2">Course</th>
                                                                    <th scope="col-1">Fee</th>
                                                                    <th scope="col-1">Visa Status</th>
                                                                    <th scope="col-1">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Students Enrolled
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                            <table id="datatable_enrol" class="table table-striped table-bordered  nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Given Name</th>
                                                                <th scope="col">Middle Name</th>
                                                                <th scope="col">Qualification</th>
                                                                <th scope="col">Venue</th>
                                                                <th scope="col">Source</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Invoices
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                                <table id="datatable_invoices" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100% !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Student Name</th>
                                                                    <th scope="col">Course</th>
                                                                    <th scope="col">Course Fee</th>
                                                                    <th scope="col">Paid Amount</th>
                                                                    <th scope="col">Due Amount</th>
                                                                    <th scope="col">Payment Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accordion -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">All Students</h4>  
                                            <table id="datatable-all" class="table nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Student ID</th>
                                                        <th scope="col">Student Name</th>
                                                        <th scope="col">Contact Number</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Course</th>
                                                        <th scope="col">Enroled Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Student Enquiries</h4>  
                                            <table id="datatable" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Enquiry ID</th>
                                                        <th scope="col">Student Name</th>
                                                        <th scope="col">Contact Number</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Course</th>
                                                        <th scope="col">Fee</th>
                                                        <th scope="col">Visa Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Students Enrolled</h4>  
                                            <table id="datatable_enrol" class="table table-striped table-bordered  nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Given Name</th>
                                                        <th scope="col">Middle Name</th>
                                                        <th scope="col">Qualification</th>
                                                        <th scope="col">Venue</th>
                                                        <th scope="col">Source</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Invoices</h4>  
                                            <table id="datatable_invoices" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Student Name</th>
                                                        <th scope="col">Course</th>
                                                        <th scope="col">Course Fee</th>
                                                        <th scope="col">Paid Amount</th>
                                                        <th scope="col">Due Amount</th>
                                                        <th scope="col">Payment Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div> -->
                    

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
        <script>

            function delete_enq(eq_id){
                $.ajax({
                    type:'post',
                    data:{eq_id:eq_id,formName:'delete_enq'},
                    url:'includes/datacontrol.php',
                    success:function(data){
                        if(data==1){
                            console.log(data);
                        var table = $('#datatable').DataTable();
                            table.ajax.reload();
                        }else{
                            alert('Something went wrong. Please try again');
                        }
                    }
                })
            }

            function delete_enq(enrol_id){
                $.ajax({
                    type:'post',
                    data:{enrol_id:enrol_id,formName:'delete_enrol'},
                    url:'includes/datacontrol.php',
                    success:function(data){
                        if(data==1){
                            console.log(data);
                        var table = $('#datatable_enrol').DataTable();
                            table.ajax.reload();
                        }else{
                            alert('Something went wrong. Please try again');
                        }
                    }
                })
            }

            $(document).ready(function () {
                $('#datatable').DataTable({lengthMenu: [5, 10, 20],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                scrollX: true,
                    ajax: 'includes/datacontrol.php?name=studentEnquiry',
                        columns: [
                        { data: 'st_enquiry_id' },                                    
                        { data: 'std_name' },                                    
                        { data: 'std_phno' },
                        { data: 'std_email' },
                        { data: 'std_course' },
                        { data: 'std_fee' },
                        { data: 'std_visa_status' },
                        { data: 'action' },
                    ],
                });
                $('#datatable-all').DataTable({lengthMenu: [5, 10, 20],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                scrollX: true,
                    ajax: 'includes/datacontrol.php?name=all_students',
                        columns: [
                        { data: 'st_unique_id' },                                    
                        { data: 'st_enrol_name' },                                    
                        { data: 'std_phno' },
                        { data: 'std_email' },
                        { data: 'course' },
                        { data: 'std_date' },
                    ],
                });

                $('#datatable_enrol').DataTable({lengthMenu: [5, 10, 20],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                scrollX: true,
                    ajax: 'includes/datacontrol.php?name=student_enrol',
                        columns: [
                        { data: 'st_enrol_name' },                                    
                        { data: 'st_enrol_givenname' },
                        { data: 'st_enrol_middlename' },
                        { data: 'st_enrol_qual' },
                        { data: 'st_enrol_venue' },
                        { data: 'st_enrol_source' },
                        { data: 'action' },
                    ],
                });
                
                $('#datatable_invoices').DataTable({lengthMenu: [5, 10, 20],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                scrollX: true,
                    ajax: 'includes/datacontrol.php?name=student_invoices',
                        columns: [
                        { data: 'inv_std_name' },                                    
                        { data: 'inv_course' },
                        { data: 'inv_fee' },
                        { data: 'inv_paid' },
                        { data: 'inv_due' },
                        { data: 'inv_payment_date' },
                    ],
                });
            })
        </script>
    </body>
</html>
<?php } else{
    header('Location: student_enquiry.php');
    // echo "testss";
} ?>