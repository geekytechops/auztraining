<?php error_reporting(0);  ?>
        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        <link href="assets/css/panel.css" rel="stylesheet" type="text/css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div id="borderedToast1" class="toast-container position-fixed p-3 top-0 end-0 fade hide" role="alert" aria-live="assertive" aria-atomic="true">
<div class="align-items-center text-white btn-primary border-0">
    <div class="d-flex">
        <div class="toast-body" id="toast-text">
            
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
</div>
<button type="button" class="btn btn-primary d-none" id="borderedToast1Btn"></button>
<div id="borderedToast2" class="toast-container position-fixed p-3 top-0 end-0 fade hide" role="alert" aria-live="assertive" aria-atomic="true">
<div class="align-items-center text-white bg-danger border-0">
    <div class="d-flex">
        <div class="toast-body toast-text2" id="toast-text">
            
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
</div>
<button type="button" class="btn bg-danger d-none" id="borderedToast2Btn"></button>

<!-- modal bootstrap -->
<button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" id="model_trigger" data-bs-target="#myModal"></button>
<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->