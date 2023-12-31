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
<button type="button" class="d-none btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" id="model_trigger" data-bs-target="#myModal"></button>
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

<!-- modal bootstrap -->
<button type="button" class="btn btn-primary btn-sm waves-effect waves-light d-none" data-bs-toggle="modal" id="model_trigger1" data-bs-target="#myModal2"></button>
<!-- sample modal content -->
<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body myModal1-body row">
                <div class="col-3">
            <label class="form-label" for="lookup_select">Search Type</label>
            <select name="lookup_select" class="form-select" id="lookup_select" onchange="studetnLookup()">
                <option value="1">Mobile</option>
                <option value="2">email</option>
            </select>
            </div>
            <div class="col-9">
            <label class="form-label" for="lookup_select">Details</label>
            <select name="lookup_select" class="form-control select2" id="lookup_select_data" style="position:relative !important;z-index:99999999999999999999">
            </select>
            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" id="close_lookup" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->