<?php 
session_start();
// print_r($_SESSION);
if(@$_SESSION['user_type']==1){
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Attendance</title>
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
                                    <h4 class="mb-sm-0">Attendance</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Attendance</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Dropzone</h4>
                                        <p class="card-title-desc">Please Drop the Attendance Spreadsheet.
                                        </p>
        
                                        <div>
                                        <input name="file" type="file" accept=".XLSX,.XLX,.CSV" id="upload_file" class="form-control d-none" onchange="uploadFile()">
                                            <form action="#" id="dropzone" class="dropzone">
                                                <div class="fallback">
                                                    <img src="assets/images/thumbnails/xlsx.png" alt="">
                                                </div>
                                                <div class="dz-message needsclick text-center mt-5">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted mdi mdi-cloud-upload-outline"></i>
                                                    </div>                                                    
                                                    <h4>Drop files here to upload</h4>
                                                </div>
                                            </form>
                                        </div>
        
                                        <div class="text-center mt-4">
                                            <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </form>
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

function uploadFile(){
    var filesUp=$('#upload_file').prop('files')[0];   
    sendFile(filesUp);
}

function sendFile(Files){
    console.log(Files);
}



$('#dropzone').on(
    'dragover',
    function(e) {
        e.preventDefault();
        e.stopPropagation();
    }
)
$('#dropzone').on(
    'dragenter',
    function(e) {
        e.preventDefault();
        e.stopPropagation();
    }
)

// $(document).on('click','#dropzone',function(){
//     tiggerFile();
// })

$('#dropzone').on({

    drop:function(e){
            e.preventDefault();
           e.stopPropagation();  
           sendFile(e.originalEvent.dataTransfer.files[0]);
        //    uploadFile();  
    },
    click:function(e){
            e.preventDefault();
           e.stopPropagation();  
        $('#upload_file').trigger('click');
    }
}
    
    // function(e){
    //     console.log(e.originalEvent);
    //     // if(e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length) {
    //     //     e.preventDefault();
    //     //     e.stopPropagation();
    //     //     // /*UPLOAD FILES HERE*/
    //     //     // upload(e.originalEvent.dataTransfer.files);
    //     //     // uploadFile();
    //     //     sendFile(e.originalEvent.dataTransfer.files);
    //     // }
    // }
);

            $(document).on('click','#invoice_submit',function(){
                $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data==0){
                            document.getElementById('invoice_form').reset();
                            $('#toast-text').html('New Invoice added Successfully');
                                $('#borderedToast1Btn').trigger('click');
                            }else{
                                $('.toast-text2').html('Cannot add record. Please try again later');
                                $('#borderedToast2Btn').trigger('click');
                            }
                        }
                    })

            })
        </script>
    </body>
</html>
<?php }else{ 

header("Location: index.php");

}
?>