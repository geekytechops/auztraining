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

<!-- RPL Enquiring Popup-->
<!-- modal bootstrap -->
<button type="button" class="btn btn-primary btn-sm waves-effect waves-light d-none" data-bs-toggle="modal" id="rpl_popup" data-bs-target="#model_rpl_enq"></button>
<!-- sample modal content -->
<div id="model_rpl_enq" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rpl_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rpl_modal"></h5>
                <button type="button" class="btn-close rpl_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rpl_form">
            <div class="modal-body myModal1-body row">

                <div class="col-12">
                    <label class="form-label" for="rpl_exp">Do they have Experience ?</label>
                    <select name="rpl_exp" class="form-control rpl_parent" id="rpl_exp">
                        <option value="0">--Select--</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="col-12 rpl_child">
                    <label class="form-label" for="exp_in">Experienced In</label>
                    <select name="exp_in" class="form-control" id="exp_in">
                        <option value="0">--Select--</option>
                        <option value="1">Aged Care</option>
                        <option value="2">Disability Care</option>
                        <option value="3">Mental Health</option>
                    </select>
                </div>
                <div class="col-12 rpl_child">
                    <label class="form-label" for="exp_name">Role/Designation</label>
                    <input type="text" name="exp_name" class="form-control" id="exp_name" placeholder="Role">
                </div>
                <div class="col-12 rpl_child">
                    <label class="form-label" for="exp_years">How Many Years</label>
                    <input type="text" name="exp_years" class="form-control number-field" id="exp_years" placeholder="Years">
                </div>
                <div class="col-12 rpl_child">
                    <label class="form-label" for="exp_docs">Do they have any Documents(payslips or job description)</label>
                    <select name="exp_docs" class="form-control" id="exp_docs">
                        <option value="0">--Select--</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="col-12 rpl_child">
                    <label class="form-label" for="exp_prev">Any previous Qualification done ?</label>
                    <select name="exp_prev" class="form-control rpl_prev_parent" id="exp_prev">
                        <option value="0">--Select--</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="col-12 rpl_prev_child">
                    <label class="form-label" for="exp_prev_name">Previous Qualification Name</label>
                    <input type="text" name="exp_prev_name" class="form-control" id="exp_prev_name" placeholder="Name">
                </div>

            </div>
        </form> 

            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" id="rpl_submit" onclick="submitRpl()" >Submit</button>
                <button type="button" class="btn btn-secondary waves-effect rpl_close" id="rpl_close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Short course Group booking Popup-->
<!-- modal bootstrap -->
<button type="button" class="btn btn-primary btn-sm waves-effect waves-light d-none" data-bs-toggle="modal" id="short_group_popup" data-bs-target="#model_short_group"></button>
<!-- sample modal content -->
<div id="model_short_group" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="short_group" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="short_group"></h5>
                <button type="button" class="btn-close short_group_close" aria-label="Close"></button>
            </div>
            <form id="short_group_form">
            <div class="modal-body myModal1-body row">

                <div class="col-12">
                    <label class="form-label" for="short_grp_org_name">Organisation Name</label>
                    <input type="text" name="short_grp_org_name" class="form-control" id="short_grp_org_name" placeholder="Organisation Name">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_org_type">Type of Organisation</label>
                    <select name="short_grp_org_type" class="form-control" id="short_grp_org_type">
                        <option value="0">--Select--</option>
                        <option value="1">Job Agency</option>
                        <option value="2">Employer</option>
                        <option value="3">College</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_campus">Campus</label>
                    <select name="short_grp_campus" class="form-control" id="short_grp_campus">
                        <option value="0">--Select--</option>
                        <option value="1">Off Campus</option>
                        <option value="2">On Campus</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_date">Date Required</label>
                    <input type="date" name="short_grp_date" class="form-control" id="short_grp_date" >
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_num_std">Number of Students</label>
                    <input type="tel" name="short_grp_num_std" class="form-control number-field" id="short_grp_num_std" >
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_ind_exp">Have they got Industry Experience ?</label>
                    <select name="short_grp_ind_exp" class="form-control" id="short_grp_ind_exp">
                        <option value="0">--Select--</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_before">Have they done this Training Before ?</label>
                    <select name="short_grp_before" class="form-control" id="short_grp_before">
                        <option value="0">--Select--</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_con_type">How did they Contact us</label>
                    <input type="text" name="short_grp_con_type" class="form-control" id="short_grp_con_type">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_con_num">Contact Number</label>
                    <input type="tel" name="short_grp_con_num" class="form-control number-field" id="short_grp_con_num" placeholder="Contact Number">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_con_name">Contact Person Name</label>
                    <input type="text" name="short_grp_con_name" class="form-control" id="short_grp_con_name" placeholder="Name">
                </div>
                <div class="col-12">
                    <label class="form-label" for="short_grp_con_email">Contact Person Email</label>
                    <input type="email" name="short_grp_con_email" class="form-control" id="short_grp_con_email" placeholder="Email">
                </div>

            </div>
        </form> 

            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" id="short_group_submit" onclick="submitShortGroup()" >Submit</button>
                <button type="button" class="btn btn-secondary waves-effect short_group_close" id="short_group_close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->