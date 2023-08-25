<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
if(@$_SESSION['user_type']==1){

    $qualifications=mysqli_query($connection,"SELECT * from qualifications where qualification_status!=1");
    $venue=mysqli_query($connection,"SELECT * from venue where venue_status!=1");
    $source=mysqli_query($connection,"SELECT * from source where source_status!=1");
    $courses=mysqli_query($connection,"SELECT * from courses where course_status!=1");

if(isset($_GET['check'])){
    $Updatestatus=1;
    $enrolId=base64_decode($_GET['check']);
    $queryRes=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enrolment where st_enrol_status!=1 and st_unique_id='$enrolId'"));
    if($queryRes['st_unique_id']=="" ){
        header('Location:dashboard');
    }
}else{
    $Updatestatus=0;
    $enrolId=0;
    header('Location:dashboard');
}

?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Student Data</title>
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
                                    <h4 class="mb-sm-0">Student Data</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item">Student Data</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="needs-validation" id="formid" novalidate>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="validationCustom01">Student ID</label>
                                                        <div class="shop-name">
                                                        <?php echo $queryRes['st_unique_id'];  ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="validationCustom02">Student Name</label>
                                                        <div class="shop-location">
                                                        <?php echo $queryRes['st_name'];  ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="validationCustom02">City</label>
                                                        <div class="shop-city">
                                                        <a href="mailto:<?php echo $queryRes['st_email'];  ?>"><?php echo $queryRes['st_email'];  ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="validationCustom02">Email</label>
                                                        <div class="shop-email">
                                                        <a href="tel:<?php echo $queryRes['st_mobile'];  ?>" ><?php echo $queryRes['st_mobile'];  ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                        </div>   
                        <!-- end row -->

                        <div class="row align-items-baseline mb-2">
                            <div class="col-md-6">
                                <h5 class="mb-sm-0">Document</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" value="Upload" class="btn btn-primary" onclick="$('#files').trigger('click');">Upload</button>
                                <input type="file" id="files" class="files d-none" multiple onchange="uplaodFiles(this)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="docs_div">
                                    </div>
                                </div>
                            </div>
                        </div>

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

            function uplaodFiles(element){
                var files=$(element).prop('files');
                var formDatas=new FormData();

                for (const file of files) {
                    formDatas.append('fileUpload[]',file);
                }                
                formDatas.append('formName','studentDocs');
                $.ajax({
                    type:'post',
                    url:'includes/datacontrol.php',
                    data:formDatas,
                    contentType: false,
                    processData:false,
                    success:function(data){
                        var objectImages=JSON.parse(data);
                        var columnStart='<div class="col-md-3"><div class="mb-3">';
                        var columnEnd=' </div></div></div>';
                        for(i=0;i<Object.keys(objectImages).length;i++){
                            $('#docs_div').append(columnStart+'<label class="form-label" for="validationCustom02">'+Object.values(objectImages)[i]+'</label><div class="shop-city"><img src="assets/images/thumbnails/'+Object.keys(objectImages)[i]+'" style="width:15%">'+columnEnd);
                        }
                    }
                })
            }

        </script>
    </body>
</html>
<?php } else{
    header('Location: student_enquiry.php');
    // echo "testss";
} ?>
