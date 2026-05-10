<?php
/**
 * Maps Follow-up outcome (student_enquiry follow-up accordion) to st_enquiry_flow_status codes.
 * Labels shown in UI are defined in followup_accordion_form.php / view_enquiries.php.
 *
 * Note: Follow-up outcome "Booked Counselling" maps to status 2 (Contacted), not 9 — status 9 is
 * still used as an email-template code ("Booked Counselling") in follow-up email dropdowns only.
 */
if (!function_exists('enquiry_flow_status_for_followup_outcome')) {
    function enquiry_flow_status_for_followup_outcome($outcome_raw) {
        $o = trim((string) $outcome_raw);
        if ($o === '') {
            return null;
        }
        static $map = array(
            'No Answer' => 3,
            'Call Back Later' => 3,
            'Booked Counselling' => 2,
            'Requested More Information' => 2,
            'Application Started' => 4,
            /** Post Counselling Follow Up only (see followup_accordion_form.php) */
            'Delayed' => 4,
            'Enrolled' => 6,
            'Not Interested' => 7,
            'Do not Call' => 7,
            'Wrong No' => 7,
            'Enrolled Elsewhere' => 7,
            'Course not Offered' => 7,
            'Funding Enquiry' => 7,
        );
        return isset($map[$o]) ? $map[$o] : null;
    }
}

/**
 * Student Enquiry accordion: internal "appointment booked for counselling" slot → Contacted (2).
 */
if (!function_exists('student_enquiry_set_contacted_when_counselling_slot_booked')) {
    function student_enquiry_set_contacted_when_counselling_slot_booked($connection, $st_id, $appointment_booked) {
        if ((int) $appointment_booked !== 1 || (int) $st_id <= 0) {
            return;
        }
        if (!mysqli_fetch_assoc(@mysqli_query($connection, "SHOW COLUMNS FROM student_enquiry LIKE 'st_enquiry_flow_status'"))) {
            return;
        }
        $sid = (int) $st_id;
        mysqli_query($connection, "UPDATE student_enquiry SET st_enquiry_flow_status=2, st_enquiry_flow_change_stage=NULL WHERE st_id=$sid AND st_enquiry_status!=1 LIMIT 1");
    }
}

/**
 * Maps Counselling outcome to st_enquiry_flow_status codes.
 */
if (!function_exists('enquiry_flow_status_for_counselling_outcome')) {
    function enquiry_flow_status_for_counselling_outcome($outcome_raw) {
        $o = trim((string) $outcome_raw);
        if ($o === '') {
            return null;
        }
        static $map = array(
            'Counselling Done' => 5,
            'Rejected' => 7,
            'Rescheduled' => 11,
        );
        return isset($map[$o]) ? $map[$o] : null;
    }
}
