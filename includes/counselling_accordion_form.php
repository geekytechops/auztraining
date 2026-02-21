<?php
if(!isset($enquiryIdsCounselling)) $enquiryIdsCounselling = $enquiryIds ?? null;
if(!isset($counsilEqId)) $counsilEqId = 0;
if(!isset($counsil_Query)) $counsil_Query = array();
$counsil_Query = array_merge(array('st_enquiry_id'=>'','counsil_timing'=>'','counsil_end_time'=>'','counsil_type'=>'','counsil_mem_name'=>'','counsil_preferred_intake_date'=>'','counsil_mode_of_study'=>'','counsil_aus_stay_time'=>'','counsil_work_status'=>'','counsil_visa_condition'=>'','counsil_education'=>'','counsil_aus_study_status'=>'','counsil_course'=>'','counsil_university'=>'','counsil_qualification'=>'','counsil_eng_rate'=>'','counsil_migration_test'=>'','counsil_overall_result'=>'','counsil_module_result'=>'','counsil_job_nature'=>'','counsil_vaccine_status'=>'','counsil_pref_comments'=>'','counsil_remarks'=>''), $counsil_Query);
?>
<form class="followup_form" id="counselling_form">
<div class="row">
<div class="col-md-6">
<div class="mb-3">
<label class="form-label">Enquiry ID<span class="asterisk">*</span></label><br>
<?php if($counsilEqId==0){ ?>
<select class="selectpicker" title="--select--" data-live-search="true" name="enquiry_id" id="counselling_enquiry_id">
<?php
if($enquiryIdsCounselling && mysqli_num_rows($enquiryIdsCounselling)!=0){
while($enquiryIdsRes=mysqli_fetch_array($enquiryIdsCounselling)){
$checkQry=mysqli_query($connection,"SELECT * FROM `counseling_details` where st_enquiry_id='".$enquiryIdsRes['st_enquiry_id']."' AND counsil_enquiry_status=0");
if(mysqli_num_rows($checkQry)==0){
echo "<option value='".$enquiryIdsRes['st_enquiry_id']."' data-name='".$enquiryIdsRes['st_name']."' data-mobile='".$enquiryIdsRes['st_phno']."'>".$enquiryIdsRes['st_enquiry_id']."</option>";
}else{
echo "<option value='".$enquiryIdsRes['st_enquiry_id']."' data-name='".$enquiryIdsRes['st_name']."' data-mobile='".$enquiryIdsRes['st_phno']."' disabled>".$enquiryIdsRes['st_enquiry_id']."</option>";
}
}
}else{
echo "<option value='0'>No Enquiries Found</option>";
}
?>
</select>
<?php }else{ ?>
<input type="text" readonly class="form-control" style="width:20%" value="<?php echo $counsil_Query['st_enquiry_id']; ?>" name="enquiry_id" id="counselling_enquiry_id">
<?php }?>
<div class="error-feedback">Please Select the Enquiry ID</div>
</div>
</div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="counseling_timing">Start Date & Time<span class="asterisk">*</span></label>
<input type="datetime-local" class="form-control" id="counseling_timing" value="<?php echo $counsil_Query['counsil_timing']=='' ? '' : date('Y-m-d\TH:i',strtotime($counsil_Query['counsil_timing'])); ?>">
<div class="error-feedback">Please select the Date and Time</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="counseling_end_timing">End Date & Time</label>
<input type="datetime-local" class="form-control" id="counseling_end_timing" value="<?php echo $counsil_Query['counsil_end_time']=='' ? '' : date('Y-m-d\TH:i',strtotime($counsil_Query['counsil_end_time'])); ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label">Counseling Type<span class="asterisk">*</span></label><br>
<input type="radio" id="counseling_type1" name="counseling_type" class="form-check-input counseling_type" value="1" <?php echo $counsil_Query['counsil_type']==''||$counsil_Query['counsil_type']==1 ? 'checked' : ''; ?>><label for="counseling_type1">Face to Face</label>
<input type="radio" id="counseling_type2" name="counseling_type" class="form-check-input counseling_type" value="2" <?php echo $counsil_Query['counsil_type']==2 ? 'checked' : ''; ?>><label for="counseling_type2">Video</label></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="member_name">Counsellor's Name<span class="asterisk">*</span></label>
<input type="text" class="form-control" id="member_name" placeholder="Counsellor Name" value="<?php echo $counsil_Query['counsil_mem_name']; ?>">
<div class="error-feedback">Please enter the Counsellor Name</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="counselling_preferred_intake_date">Preferred Intake Date</label>
<input type="date" class="form-control" id="counselling_preferred_intake_date" value="<?php echo !empty($counsil_Query['counsil_preferred_intake_date']) ? date('Y-m-d', strtotime($counsil_Query['counsil_preferred_intake_date'])) : ''; ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="counselling_mode_of_study">Mode of Study</label>
<select class="form-select" id="counselling_mode_of_study">
<option value="">--select--</option>
<option value="1" <?php echo (isset($counsil_Query['counsil_mode_of_study']) && $counsil_Query['counsil_mode_of_study']==1) ? 'selected' : ''; ?>>Face to Face</option>
<option value="2" <?php echo (isset($counsil_Query['counsil_mode_of_study']) && $counsil_Query['counsil_mode_of_study']==2) ? 'selected' : ''; ?>>Online</option>
<option value="3" <?php echo (isset($counsil_Query['counsil_mode_of_study']) && $counsil_Query['counsil_mode_of_study']==3) ? 'selected' : ''; ?>>Blended</option>
</select></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="aus_duration">How long the student has been to Aus<span class="asterisk">*</span></label>
<input type="text" class="form-control" id="aus_duration" placeholder="Duration" value="<?php echo $counsil_Query['counsil_aus_stay_time']; ?>">
<div class="error-feedback">Please enter the Duration</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label">Currently Working<span class="asterisk">*</span></label><br>
<input type="radio" id="work_status1" name="work_status" class="form-check-input work_status" value="1" <?php echo $counsil_Query['counsil_work_status']==''||$counsil_Query['counsil_work_status']==1 ? 'checked' : ''; ?>><label>Yes</label>
<input type="radio" id="work_status2" name="work_status" class="form-check-input work_status" value="2" <?php echo $counsil_Query['counsil_work_status']==2 ? 'checked' : ''; ?>><label for="work_status2">No</label></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="visa_condition">Visa Condition<span class="asterisk">*</span></label>
<select name="visa_condition" class="form-select" id="visa_condition">
<?php if(isset($visaStatus) && $visaStatus){ mysqli_data_seek($visaStatus,0);
while($visaRes=mysqli_fetch_array($visaStatus)){
if($visaRes['visa_id']==1) echo "<option value='0'>--select--</option><optgroup label='Subclass 500 main applicant'>";
?><option value="<?php echo $visaRes['visa_id']; ?>" <?php echo $visaRes['visa_id']==$counsil_Query['counsil_visa_condition'] ? 'selected' : ''; ?>><?php echo $visaRes['visa_status_name']; ?></option><?php
if($visaRes['visa_id']==4) echo '</optgroup>';
} }?>
</select><div class="error-feedback">Please select a visa status</div></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="counselling_education">Education Background</label>
<input type="text" class="form-control" id="counselling_education" value="<?php echo $counsil_Query['counsil_education']; ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label">Is the Student Studying in Australia<span class="asterisk">*</span></label><br>
<input type="radio" id="aus_study1" name="aus_study" class="form-check-input aus_study" value="1" <?php echo $counsil_Query['counsil_aus_study_status']==''||$counsil_Query['counsil_aus_study_status']==1 ? 'checked' : ''; ?>><label for="aus_study1">Yes</label>
<input type="radio" id="aus_study2" name="aus_study" class="form-check-input aus_study" value="2" <?php echo $counsil_Query['counsil_aus_study_status']==2 ? 'checked' : ''; ?>><label for="aus_study2">No</label></div></div>
<div class="col-md-6 aus_study_child" style="display:<?php echo ($counsil_Query['counsil_aus_study_status']==1||$counsil_Query['counsil_aus_study_status']=='') ? 'block' : 'none'; ?>"><div class="mb-3"><label class="form-label" for="counselling_course">What Course</label><input type="text" class="form-control" id="counselling_course" value="<?php echo $counsil_Query['counsil_course']; ?>"></div></div>
<div class="col-md-6 aus_study_child" style="display:<?php echo ($counsil_Query['counsil_aus_study_status']==1||$counsil_Query['counsil_aus_study_status']=='') ? 'block' : 'none'; ?>"><div class="mb-3"><label class="form-label" for="counselling_university_name">University Name</label><input type="text" class="form-control" id="counselling_university_name" value="<?php echo $counsil_Query['counsil_university']; ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="counselling_qualification">Any Experience or Qualification related to Aged care/Health care</label><input type="text" class="form-control" id="counselling_qualification" value="<?php echo $counsil_Query['counsil_qualification']; ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="counselling_eng_rate">Rate your English ( 1 - 10 )</label><input type="tel" class="form-control rating-field" id="counselling_eng_rate" value="<?php echo $counsil_Query['counsil_eng_rate']; ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label">IELTS or PTE given <span class="asterisk">*</span></label><br>
<input type="radio" id="mig_test1" name="mig_test" class="form-check-input mig_test" value="1" <?php echo $counsil_Query['counsil_migration_test']==''||$counsil_Query['counsil_migration_test']==1 ? 'checked' : ''; ?>><label for="mig_test1">Yes</label>
<input type="radio" id="mig_test2" name="mig_test" class="form-check-input mig_test" value="2" <?php echo $counsil_Query['counsil_migration_test']==2 ? 'checked' : ''; ?>><label for="mig_test2">No</label></div></div>
<div class="col-md-6 mig_test_child" style="display:<?php echo ($counsil_Query['counsil_migration_test']==1||$counsil_Query['counsil_migration_test']=='') ? 'block' : 'none'; ?>"><div class="mb-3"><label class="form-label" for="counselling_overall_result">Overall Result</label><input type="text" class="form-control nummber-field" id="counselling_overall_result" value="<?php echo $counsil_Query['counsil_overall_result']; ?>"></div></div>
<div class="col-md-6 mig_test_child" style="display:<?php echo ($counsil_Query['counsil_migration_test']==1||$counsil_Query['counsil_migration_test']=='') ? 'block' : 'none'; ?>"><div class="mb-3"><label class="form-label" for="counselling_module_result">Each Module Result</label><input type="text" class="form-control" id="counselling_module_result" value="<?php echo $counsil_Query['counsil_module_result']; ?>"></div></div>
<div class="col-md-6 mig_test_child" style="display:<?php echo ($counsil_Query['counsil_migration_test']==1||$counsil_Query['counsil_migration_test']=='') ? 'block' : 'none'; ?>"><div class="mb-3"><label class="form-label" for="counselling_job_nature">Nature of the Job explained</label><input type="text" class="form-control" id="counselling_job_nature" value="<?php echo $counsil_Query['counsil_job_nature']; ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label">Vaccination Taken<span class="asterisk">*</span></label><br>
<input type="radio" id="vaccine_status1" name="vaccine_status" class="form-check-input vaccine_status" value="1" <?php echo $counsil_Query['counsil_vaccine_status']==''||$counsil_Query['counsil_vaccine_status']==1 ? 'checked' : ''; ?>><label>Yes</label>
<input type="radio" id="vaccine_status2" name="vaccine_status" class="form-check-input vaccine_status" value="2" <?php echo $counsil_Query['counsil_vaccine_status']==2 ? 'checked' : ''; ?>><label>No</label></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="counselling_pref_comment">Any preferences or requirements</label><input type="text" class="form-control" id="counselling_pref_comment" placeholder="Requirements" value="<?php echo $counsil_Query['counsil_pref_comments']; ?>"></div></div>
<div class="col-md-6"><div class="mb-3"><label class="form-label" for="remarks">Remarks</label>
<?php
$st_remarks=['Seems to be interested to do course and need to contact asap','contacted and followed','Good with communication skills','Sent enrollement form online/ hard copies','Want to do the course asap','not interested much','Looking for government funding','Have done counselling before but wants to get more info','Counseling is done but enrolment is due','Have done the counselling before','Seems like having attitude','Want to book an appointment for counselling','Will callus back again','Planning to relocate to other state','Wants to get COE for visa purpose'];
$remarksSel=($counsil_Query['counsil_remarks']!='') ? json_decode($counsil_Query['counsil_remarks']) : array();
for($i=1;$i<count($st_remarks);$i++){
$checked=in_array($i,$remarksSel) ? 'checked' : '';
echo '<div class="form-check"><input type="checkbox" class="remarks_check form-check-input counselling_remarks" id="counsel_remark_'.$i.'" '.$checked.' value="'.$i.'"><label for="counsel_remark_'.$i.'">'.$st_remarks[$i].'</label></div>';
}
?><div class="error-feedback">Please select atleast one option</div></div></div>
</div>
<button class="btn btn-primary" type="button" id="counseling_submit">Submit Counseling</button>
<input type="hidden" value="<?php echo $counsilEqId; ?>" id="counselling_check_update">
</form>
