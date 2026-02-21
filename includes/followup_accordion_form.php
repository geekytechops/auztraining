<?php
if(!isset($enquiryIdsFollowup)) $enquiryIdsFollowup = $enquiryIds ?? null;
if(!isset($followupEqId)) $followupEqId = 0;
if(!isset($followup_Query)) $followup_Query = array();
$followup_Query = array_merge(array('flw_name'=>'','flw_phone'=>'','flw_contacted_person'=>'','flw_contacted_time'=>'','flw_date'=>'','flw_mode_contact'=>'','flw_followup_type'=>'','flw_follow_up_notes'=>'','flw_next_followup_date'=>'','flw_follow_up_outcome'=>'','flw_comments'=>'','flw_progress_state'=>'','flw_remarks'=>''), $followup_Query);
$enquiry_flow_statuses = array(1=>'New',2=>'Contacted',3=>'Follow-up Required',4=>'Interested',5=>'Documents Collected',6=>'Enrolled',7=>'Not Interested',8=>'Invalid / Duplicate');
$follow_up_outcomes = array(''=>'--select--','No answer'=>'No answer','Call back later'=>'Call back later','Sent info'=>'Sent info','Enrolment in progress'=>'Enrolment in progress');
?>
<form class="followup_form" id="followup_form_embed">
<div class="row">
<div class="col-md-6"><div class="mb-3"><label class="form-label">Enquiry ID</label><br>
<select class="selectpicker" title="--select--" data-live-search="true" name="enquiry_id" id="followup_enquiry_id">
<?php
if($enquiryIdsFollowup && mysqli_num_rows($enquiryIdsFollowup)!=0){
while($enquiryIdsRes=mysqli_fetch_array($enquiryIdsFollowup)){
echo "<option value='".$enquiryIdsRes['st_enquiry_id']."' data-name='".$enquiryIdsRes['st_name']."' data-mobile='".$enquiryIdsRes['st_phno']."'>".$enquiryIdsRes['st_enquiry_id']."</option>";
}
}else{
echo "<option value='0'>No Enquiries Found</option>";
}
?>
</select><div class="error-feedback">Please Select the Enquiry ID</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_student_name">Student Name<span class="asterisk">*</span></label>
<input type="text" class="form-control" placeholder="Student Name" id="followup_student_name" value="<?php echo $followup_Query['flw_name']; ?>"><div class="error-feedback">Please enter the Student Name</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_mobile_num">Contact Number<span class="asterisk">*</span></label>
<input type="text" class="form-control number-field" id="followup_mobile_num" placeholder="Contact Number" value="<?php echo $followup_Query['flw_phone']; ?>" maxlength="10"><div class="error-feedback">Please enter the Contact Number</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_contacted_person">Contacted Person<span class="asterisk">*</span></label>
<input type="text" class="form-control" id="followup_contacted_person" placeholder="Contacted Person Name" value="<?php echo $followup_Query['flw_contacted_person']; ?>"><div class="error-feedback">Please enter the Contacted Person Name</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_contacted_time">Follow-up Date &amp; Time<span class="asterisk">*</span></label>
<input type="datetime-local" class="form-control" id="followup_contacted_time" value="<?php echo $followup_Query['flw_contacted_time']=='' ? '' : date('Y-m-d\TH:i',strtotime($followup_Query['flw_contacted_time'])); ?>"><div class="error-feedback">Please select the follow-up date and time</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_followup_type">Follow-up Type<span class="asterisk">*</span></label>
<select class="form-select" id="followup_followup_type">
<option value="">--select--</option>
<option value="Call" <?php echo (isset($followup_Query['flw_followup_type']) && $followup_Query['flw_followup_type']=='Call') ? 'selected' : ''; ?>>Call</option>
<option value="Email" <?php echo (isset($followup_Query['flw_followup_type']) && $followup_Query['flw_followup_type']=='Email') ? 'selected' : ''; ?>>Email</option>
</select><div class="error-feedback">Please select Follow-up Type</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_enquiry_flow_status">Enquiry Status</label>
<select class="form-select" id="followup_enquiry_flow_status">
<?php foreach($enquiry_flow_statuses as $k=>$v) echo '<option value="'.$k.'" '.((isset($followup_Query['enquiry_flow_status']) && $followup_Query['enquiry_flow_status']==$k) ? 'selected' : '').'>'.$v.'</option>'; ?>
</select><small class="text-muted">Default: New for first-time enquiries</small></div></div>
<div class="col-12"><div class="mb-3"><label class="form-label" for="followup_follow_up_notes">Follow-Up Notes</label>
<textarea class="form-control" id="followup_follow_up_notes" rows="3" placeholder="Free text notes"><?php echo htmlspecialchars(isset($followup_Query['flw_follow_up_notes']) ? $followup_Query['flw_follow_up_notes'] : ''); ?></textarea></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_next_followup_date">Next Follow-Up Date</label>
<input type="datetime-local" class="form-control" id="followup_next_followup_date" value="<?php echo !empty($followup_Query['flw_next_followup_date']) ? date('Y-m-d\TH:i',strtotime($followup_Query['flw_next_followup_date'])) : ''; ?>" placeholder="Calendar reminder"><small class="text-muted">Reminder / notification</small></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_follow_up_outcome">Follow-Up Outcome</label>
<select class="form-select" id="followup_follow_up_outcome">
<?php foreach($follow_up_outcomes as $k=>$v) echo '<option value="'.htmlspecialchars($k).'" '.((isset($followup_Query['flw_follow_up_outcome']) && $followup_Query['flw_follow_up_outcome']==$k) ? 'selected' : '').'>'.htmlspecialchars($v).'</option>'; ?>
</select></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_date">Date</label>
<input type="date" class="form-control" id="followup_date" value="<?php echo $followup_Query['flw_date']=='' ? '' : date('Y-m-d',strtotime($followup_Query['flw_date'])); ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_mode_contacted">Mode of Contact</label>
<input type="text" class="form-control" id="followup_mode_contacted" value="<?php echo $followup_Query['flw_mode_contact']; ?>" placeholder="e.g. Phone, 3cx"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_comments">Staff Notes</label><input type="text" class="form-control" id="followup_comments" value="<?php echo $followup_Query['flw_comments']; ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="followup_progress_status">Status or Progress</label><input type="text" class="form-control" id="followup_progress_status" value="<?php echo $followup_Query['flw_progress_state']; ?>" maxlength="255"></div></div>
<div class="col-12 mb-3" id="followup_email_template_section" style="display:none;">
<div class="card border-primary"><div class="card-header bg-light">Send status email to student</div><div class="card-body">
<p class="text-muted small">When you change Enquiry Status, the matching email template is loaded. Review, edit if needed, and send.</p>
<label class="form-label">Subject</label><input type="text" class="form-control mb-2" id="followup_email_subject" placeholder="Email subject">
<label class="form-label">Message</label><textarea class="form-control mb-2" id="followup_email_body" rows="4" placeholder="Email body"></textarea>
<div class="form-check mb-2"><input type="checkbox" class="form-check-input" id="followup_save_template_default" value="1"><label class="form-check-label" for="followup_save_template_default">Save as default template for this status</label></div>
<button type="button" class="btn btn-success btn-sm" id="followup_send_status_email">Send email</button>
</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="remarks">Remarks</label>
<?php
$st_remarks=['Seems to be interested to do course and need to contact asap','contacted and followed','Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose'];
$remarksSel=($followup_Query['flw_remarks']!='') ? json_decode($followup_Query['flw_remarks']) : array();
for($i=1;$i<count($st_remarks);$i++){
$checked=in_array($i,$remarksSel) ? 'checked' : '';
echo '<div class="form-check"><input type="checkbox" class="remarks_check form-check-input followup_remarks" id="flw_remark_'.$i.'" value="'.$i.'" '.$checked.'><label for="flw_remark_'.$i.'">'.$st_remarks[$i].'</label></div>';
}
?><div class="error-feedback">Please select atleast one option</div></div></div>
</div>
<button class="btn btn-primary" type="button" id="followup_check">Submit Follow Up</button>
<input type="hidden" value="<?php echo $followupEqId; ?>" id="followup_check_update">
</form>
