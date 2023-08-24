<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
if(@$_SESSION['user_type']!=''){
    
            $qualifications=mysqli_query($connection,"SELECT * from qualifications where qualification_status!=1");
        $venue=mysqli_query($connection,"SELECT * from venue where venue_status!=1");
        $source=mysqli_query($connection,"SELECT * from source where source_status!=1");
        $courses=mysqli_query($connection,"SELECT * from courses where course_status!=1");

    if(isset($_GET['enrol'])){
        $Updatestatus=1;
        $enrolId=base64_decode($_GET['enrol']);
        $queryRes=mysqli_fetch_array(mysqli_query($connection,"SELECT * from student_enrolment where st_enrol_status!=1 and st_enrol_id=$enrolId"));

    }else{
        $Updatestatus=0;
        $enrolId=0;
    }

?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Enrolment</title>
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
                        <?php if($enrolId==0){ ?>
                        <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="enquiry_id">Enquiry ID</label>
                                                <input type="text" id="enquiry_id" class="form-control" name='enquiry_id'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <?php } ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="student_enrol_form" id="student_enrol_form">
                                        <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="qualifications">Qualification</label>
                                                            <select name="qualifications" class="form-control" id="qualifications">
                                                                <option value="0">--select--</option>
                                                            <?php 
                                                        while($qualificationsRes=mysqli_fetch_array($qualifications)){
                                                        ?>                                                            
                                                            <option value="<?php echo $qualificationsRes['qualification_id']; ?>" <?php echo $qualificationsRes['qualification_id']==$queryRes['st_qualifications'] ? 'selected' : ''; ?>><?php echo $qualificationsRes['qualification_name']; ?></option>
                                                            <?php } ?>
                                                            </select>
                                                        <div class="error-feedback">
                                                            Please select qualification
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="courses">Course Interested In</label>
                                                        <select name="courses" class="form-control" id="courses">
                                                        <option value="0">--select--</option>
                                                        <?php 
                                                        while($coursesRes=mysqli_fetch_array($courses)){
                                                        ?>                                                            
                                                            <option value="<?php echo $coursesRes['course_id']; ?>" <?php echo $coursesRes['course_id']==$queryRes['st_course'] ? 'selected' : ''; ?>><?php echo $coursesRes['course_name']; ?></option>
                                                            <?php } ?>
                                                        </select>    
                                                        <div class="error-feedback">
                                                            Please select the Courses
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="venue_name">Venue</label>
                                                        <select name="venue_name" class="form-control" id="venue_name">
                                                            <option value="0">--select--</option>
                                                        <?php 
                                                        while($venueRes=mysqli_fetch_array($venue)){
                                                        ?>                                                            
                                                            <option value="<?php echo $venueRes['venue_id']; ?>" <?php echo $venueRes['venue_id']==$queryRes['st_venue'] ? 'selected' : ''; ?>><?php echo $venueRes['venue_name']; ?></option>
                                                            <?php } ?>
                                                            </select>
                                                        <div class="error-feedback">
                                                            Please Select a Venue
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="given_name">Given Name</label>
                                                        <input type="text" class="form-control" id="given_name" placeholder="Given Name" value="<?php echo $queryRes['st_given_name'] ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Given name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_main">I am</label>
                                                        <input type="text" class="form-control" id="name_main" value="<?php echo $queryRes['st_name'] ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="middle_name">Middle Name</label>
                                                        <input type="text" class="form-control" id="middle_name" placeholder="Middle Name" value="<?php echo $queryRes['st_middle_name'] ?>" >
                                                        <div class="error-feedback">
                                                            Please enter the Middle Name
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="source">How did you hear about Milton College</label>
                                                        <select name="source" class="form-control" id="source">
                                                            <option value="0">--select--</option>
                                                        <?php 
                                                        while($sourceRes=mysqli_fetch_array($source)){
                                                        ?>                                                            
                                                            <option value="<?php echo $sourceRes['source_id']; ?>" <?php echo $sourceRes['source_id']==$queryRes['st_source'] ? 'selected' : ''; ?>><?php echo $sourceRes['source_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="error-feedback">
                                                            Please select atleast one option
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($enrolId==0){ ?>
                                                <button class="btn btn-primary" id="enrolment_check" type="button" >Submit Form</button>
                                            <?php }else{ ?>
                                                <button class="btn btn-primary" id="enrolment_check" type="button" >Update Details</button>
                                            <?php } ?>    
                                            <input type="hidden" value="<?php echo $enrolId; ?>" id="check_update">                                        
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
        <script>
            $(document).on('click','#enrolment_check',function(){
                var given_name=$('#given_name').val().trim();
                var name_main=$('#name_main').val().trim();
                var qualifications=$('#qualifications').val()==0 ? '' : $('#qualifications').val();
                var source=$('#source').val()==0 ? '' : $('#source').val();
                var middle_name=$('#middle_name').val().trim();
                var courses=$('#courses').val()==0 ? '' : $('#courses').val();
                var courseName=$('#courses').find(":selected").text();
                var venue=$('#venue_name').val()==0 ? '' : $('#venue_name').val();
                var enquiry_id=$('#enquiry_id').val();

                if(qualifications==''|| given_name=='' ||name_main=='' ||source==''||middle_name==''||venue==''){
                    if(qualifications==''){
                        $('#qualifications').addClass('invalid-div');
                        $('#qualifications').removeClass('valid-div');
                        $('#qualifications').closest('div').find('.error-feedback').show();
                    }else{
                        $('#qualifications').addClass('valid-div');
                        $('#qualifications').removeClass('invalid-div');                        
                        $('#qualifications').closest('div').find('.error-feedback').hide();
                    }
                    if(courses==''){
                        $('#courses').addClass('invalid-div');
                        $('#courses').removeClass('valid-div');
                        $('#courses').closest('div').find('.error-feedback').show();
                    }else{
                        $('#courses').addClass('valid-div');
                        $('#courses').removeClass('invalid-div');                        
                        $('#courses').closest('div').find('.error-feedback').hide();
                    }
                    if(qualifications==''){
                        $('#qualifications').addClass('invalid-div');
                        $('#qualifications').removeClass('valid-div');
                        $('#qualifications').closest('div').find('.error-feedback').show();
                    }else{
                        $('#qualifications').addClass('valid-div');
                        $('#qualifications').removeClass('invalid-div');                        
                        $('#qualifications').closest('div').find('.error-feedback').hide();
                    }
                    if(given_name==''){
                        $('#given_name').addClass('invalid-div');
                        $('#given_name').removeClass('valid-div');
                        $('#given_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#given_name').addClass('valid-div');
                        $('#given_name').removeClass('invalid-div');
                        $('#given_name').closest('div').find('.error-feedback').hide();
                    }
                    if(name_main==''){
                        $('#name_main').addClass('invalid-div');
                        $('#name_main').removeClass('valid-div');
                        $('#name_main').closest('div').find('.error-feedback').show();
                    }else{
                        $('#name_main').addClass('valid-div');
                        $('#name_main').removeClass('invalid-div');
                        $('#name_main').closest('div').find('.error-feedback').hide();
                    }
                    if(source==''){
                        $('#source').addClass('invalid-div');
                        $('#source').removeClass('valid-div');
                        $('#source').closest('div').find('.error-feedback').show();
                    }else{
                        $('#source').addClass('valid-div');
                        $('#source').removeClass('invalid-div');
                        $('#source').closest('div').find('.error-feedback').hide();
                    }
                    if(middle_name==''){
                        $('#middle_name').addClass('invalid-div');
                        $('#middle_name').removeClass('valid-div');
                        $('#middle_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#middle_name').addClass('valid-div');
                        $('#middle_name').removeClass('invalid-div');
                        $('#middle_name').closest('div').find('.error-feedback').hide();
                    }
                    if(venue==''){
                        $('#venue_name').addClass('invalid-div');
                        $('#venue_name').removeClass('valid-div');
                        $('#venue_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#venue_name').addClass('valid-div');
                        $('#venue_name').removeClass('invalid-div');
                        $('#venue_name').closest('div').find('.error-feedback').hide();
                    }
                }else{
                    var checkId=$("#check_update").val();
                    details={formName:'student_enrol',qualifications:qualifications,venues:venue,middle_name:middle_name,source:source,name_main:name_main,checkId:checkId,courseName:courseName,courses:courses,enquiry_id:enquiry_id,given_name:given_name};
                    $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data==1){
                                document.getElementById('student_enrol_form').reset();
                                $('#toast-text').html('New Record added Successfully');
                                $('#borderedToast1Btn').trigger('click');
                            }else if(data==2){
                                document.getElementById('student_enrol_form').reset();
                                $('#toast-text').html('Record Updated Successfully');
                                $('#borderedToast1Btn').trigger('click');
                                window.location.href="dashboard";
                            }else{
                                $('.toast-text2').html('Cannot add record. Please try again later');
                                $('#borderedToast2Btn').trigger('click');
                            }
                        }
                    })
                }

            })
        </script>
    </body>
</html>
<?php }else{ 
header("Location: index.php");
}
?>