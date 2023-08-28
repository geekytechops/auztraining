<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
// print_r($_SESSION);
if(@$_SESSION['user_type']==0){
    $enrolId=$_SESSION['user_log_id'];
    
    $enrolId=$_SESSION['user_log_id'];
    $selectQry=mysqli_query($connection,"SELECT st_unique_id,st_doc_names FROM `student_docs` WHERE `st_unique_id`='$enrolId'");
    
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
                                    <h4 class="mb-sm-0">Documents Upload</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Documents Upload</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <?php 
                            $dob=0;
                            $address=0;
                        $selectQryRowss=mysqli_num_rows($selectQry);
                        if($selectQryRowss!=0){
                            $selectQryRess=mysqli_fetch_array($selectQry);
                            // print_r($selectQryRess);
                            if($selectQryRess['st_doc_names']!='[]'){
                                $imageArray=json_decode($selectQryRess['st_doc_names']);
                                for($i=0;$i<count($imageArray);$i++){
                                
                                    $imageFull=explode('||',$imageArray[$i])[0];
                                    $thumb=explode('||',$imageArray[$i])[1];
                                    

                                    if($thumb=='dob'){
                                        $dob=1;
                                    }else{
                                        $address=1;
                                    }

                                }
                            }else{
                                $dob=0;
                                $address=0;
                            }

                        }else{
                            $dob=0;
                            $address=0;
                        }
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" id="add_docs_div_parents">
                                        <div class="row" id="add_docs_div">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="courses">Date of Birth</label>
                                                    <input type="file" id="dob" name="dob" class="form-control" accept=".pdf" onchange="uploadDocs(this)" <?php echo $dob==1 ? 'disabled' : '' ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="courses">Address Proof</label>
                                                    <input type="file" id="address" name="address" class="form-control" accept=".pdf" onchange="uploadDocs(this)" <?php echo $address==1 ? 'disabled' : '' ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" id="docs_div_parent">
                                        <div class="row" id="docs_div">
                                        <?php 
                                    $columnStart='';
                                    $imageDiv='';
                                    $selectQry=mysqli_query($connection,"SELECT st_unique_id,st_doc_names FROM `student_docs` WHERE `st_unique_id`='$enrolId'");
                                    $selectQryRows=mysqli_num_rows($selectQry);
                                    if($selectQryRows!=0){
                                    $selectQryRes=mysqli_fetch_array($selectQry);
                                    if($selectQryRes['st_doc_names']!='[]'){
                                    $imageArray=json_decode($selectQryRes['st_doc_names']);
                                        for($i=0;$i<count($imageArray);$i++){
                                            $columnStart='<div class="col-md-2 text-center" style="box-shadow: 0px 0px 33px -20px #78c7e5;padding: 1rem;"><div><label class="form-label" for="courses">';
                                            $columnEnd='</div></div>';

                                            $imageFull=explode('||',$imageArray[$i])[0];
                                            $thumb=explode('||',$imageArray[$i])[1];

                                            if($thumb=='dob'){
                                                $imageDiv.=$columnStart.'Date of Birth Proof:</label>                                                    
                                                </div>
                                                <div class=" dob-image">
                                                <a href="'.$imageFull.'"><img src="assets/images/thumbnails/pdf.png" alt="" style="width:90%"></a>
                                                </div>
                                                <div class="dob-button">
                                                <button type="buttton" id="dob_del" name="dob_del" onclick="deleted(this)" class="btn btn-danger" style="width:90%">DELETE</button>'.$columnEnd;
                                            }else{
                                                $imageDiv.=$columnStart.'Address Proof:</label>
                                                </div>
                                                <div class="address-image"> 
                                                <a href="'.$imageFull.'"><img src="assets/images/thumbnails/pdf.png" alt="" style="width:90%"></a>
                                                </div>
                                                <div class="address-button">
                                                    <button type="buttton" id="address_del" name="address_del" onclick="deleted(this)" class="btn btn-danger" style="width:90%">DELETE</button>'.$columnEnd;
                                            }
                                
                                        }
                                        echo $imageDiv;
                                    }else{

                                    }   
                                    }
                                    ?>
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
            
            function deleted(element){
                var delType=$(element).attr('id');
                var enrolId='<?php echo $enrolId; ?>';
                $.ajax({
                    type:'post',
                    url:'includes/datacontrol.php',
                    data:{delType:delType,enrolID:enrolId,formName:"deleteProof"},
                    success:function(data){
                        if(data==1){
                            $( "#docs_div_parent" ).load(window.location.href + " #docs_div" );
                            $( "#add_docs_div_parents" ).load(window.location.href + " #add_docs_div" );
                        }else{
                            alert("Something went wrong. Please try later");
                        }
                    }
                })
            }

            function uploadDocs(element){
                var docType=$(element).attr('id');          
                var files=$(element).prop('files');
                var formDatas=new FormData();
                var allowedFormats=['pdf'];                
                var formatError=0;
                for (const file of files) {
                    if(!allowedFormats.includes(file.name.split('.')[1])){
                        formatError=1;
                    }
                    formDatas.append('fileUpload[]',file);
                }
                formDatas.append('formName','studentDocs');
                formDatas.append('docType',docType);
                formDatas.append('enrollId','<?php echo $enrolId; ?>');
                if(formatError==0){
                $.ajax({
                    type:'post',
                    url:'includes/datacontrol.php',
                    data:formDatas,
                    contentType: false,
                    processData:false,
                    success:function(data){
                        // var Images=JSON.parse(data);
                        // var columnStart='<div class="col-md-2 text-center"><div class="mb-3">';
                        // var columnEnd=' </div></div></div>';
                        // $('#docs_div').html('');
                        // for(i=0;i<Images.length;i++){
                            // var pathImage=Images[i].split('||')[0];
                            // var thumb=Images[i].split('||')[1];
                            // var nameOnly=Images[i].split('||')[0].split('.')[0];
                            // var Type=Images[i].split('||')[0].split('.')[1];                            
                                                        
                            // var subs=(nameOnly.substring(nameOnly.lastIndexOf('/') + 1));
                            // var imageName=(nameOnly.substring(nameOnly.lastIndexOf('/') + 1)).substring(0,subs.lastIndexOf('_'))+'.'+Type;
                            $( "#docs_div_parent" ).load(window.location.href + " #docs_div" );
                            $( "#add_docs_div_parents" ).load(window.location.href + " #add_docs_div" );

                            // if(docType=='dob'){
                            //     $('.dob-image').show();
                            //     $('.dob-button').show();
                            // }else{
                            //     $('.address-image').show();
                            //     $('.address-button').show();
                            // }                           

                            // $('#docs_div').append(columnStart+'<label class="form-label" style="width:90%" for="validationCustom02">'+imageName+'</label><div class="shop-city"><a href="includes/uploads/'+subs+'"><img src="assets/images/thumbnails/'+thumb+'" style="width:70%">'+columnEnd);
                        // }
                        $('#toast-text').html('Files Uploaded Successfully');
                        $('#borderedToast1Btn').trigger('click');
                    }
                })
            }else{
                    alert("Attachments with 'docx','doc','xlsx','xlx','pdf' formats are only allowed")
                }
            }
        </script>
    </body>
</html>
<?php }else{ 

header("Location: index.php");

}
?>