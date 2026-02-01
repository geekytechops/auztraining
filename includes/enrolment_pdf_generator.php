<?php
/**
 * Generate Enrolment Form PDF matching National College Australia layout.
 * Uses TCPDF. $data = array of field names => values (same as DB/form).
 */
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

function enrolment_generate_pdf($data, $savePath) {
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('National College Australia');
    $pdf->SetAuthor('National College Australia');
    $pdf->SetTitle('Enrolment Form');
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('helvetica', '', 9);

    $cb = function($checked) use ($pdf) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Rect($x, $y, 3.5, 3.5);
        if ($checked) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->SetXY($x, $y - 0.5);
            $pdf->Cell(3.5, 4, 'X', 0, 0, 'C');
            $pdf->SetFont('helvetica', '', 9);
        }
        $pdf->SetXY($x + 4, $y);
    };

    $cbOnly = function($checked) use ($pdf) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Rect($x, $y, 3.5, 3.5);
        if ($checked) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->SetXY($x, $y - 0.5);
            $pdf->Cell(3.5, 4, 'X', 0, 0, 'C');
            $pdf->SetFont('helvetica', '', 9);
        }
        $pdf->SetXY($x + 4, $y);
    };

    $val = function($key, $default = '') use ($data) {
        return isset($data[$key]) && $data[$key] !== '' && $data[$key] !== null ? $data[$key] : $default;
    };

    // Page 1
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 6, 'ENROLMENT FORM', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, 'Qualification Code & Title: ' . $val('qualification_code_title'), 0, 1);
    $pdf->Cell(0, 4, 'National College Australia  RTO:91000  Enrolment Form  V1.0  August 2025  1 | Page', 0, 1);
    $pdf->Ln(2);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 5, 'STUDENT DETAILS:', 0, 1);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->MultiCell(0, 4, 'Unique Student Identifier (USI): * 10 Digit Unique identification. If you do not have a USI, please refer to the USI section. You must write your name exactly as on your identity document.', 0, 'L');
    $pdf->Ln(1);

    $pdf->Cell(40, 5, 'USI:', 0, 0);
    $pdf->Cell(0, 5, $val('usi_id'), 0, 1);
    $pdf->Cell(40, 5, 'First Name:', 0, 0);
    $pdf->Cell(0, 5, $val('given_name'), 0, 1);
    $pdf->Cell(40, 5, 'Last Name:', 0, 0);
    $pdf->Cell(0, 5, $val('surname'), 0, 1);
    $pdf->Cell(0, 4, 'Age Declaration:', 0, 1);
    $pdf->Cell(5, 5, '', 0, 0);
    $cbOnly((int)$val('age_declaration_18') === 1);
    $pdf->Cell(0, 5, 'I am at least 18 years of age', 0, 1);
    $pdf->Cell(40, 5, 'Date of Birth (DD/MM/YYYY):', 0, 0);
    $pdf->Cell(30, 5, $val('dob'), 0, 0);
    $pdf->Cell(20, 5, 'Gender:', 0, 0);
    $cb((int)$val('gender_check') === 1);
    $pdf->Cell(15, 5, 'Male', 0, 0);
    $cb((int)$val('gender_check') === 2);
    $pdf->Cell(15, 5, 'Female', 0, 0);
    $cb((int)$val('gender_check') === 3);
    $pdf->Cell(15, 5, 'Other', 0, 1);
    $pdf->Ln(2);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 5, 'Address Details', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(45, 5, 'House and Street Number:', 0, 0);
    $pdf->Cell(0, 5, $val('street_details'), 0, 1);
    $pdf->Cell(45, 5, 'Post Code:', 0, 0);
    $pdf->Cell(25, 5, $val('post_code'), 0, 0);
    $pdf->Cell(25, 5, 'Suburb:', 0, 0);
    $pdf->Cell(0, 5, $val('sub_urb'), 0, 1);
    $pdf->Cell(45, 5, 'State:', 0, 0);
    $pdf->Cell(0, 5, $val('stu_state'), 0, 1);
    $pdf->Cell(0, 4, 'Postal Address:', 0, 1);
    $cbOnly((int)$val('postal_same_as_above') === 1);
    $pdf->Cell(35, 5, 'Same as Above', 0, 0);
    $cbOnly((int)$val('postal_same_as_above') === 0);
    $pdf->Cell(0, 5, 'Enter postal address below', 0, 1);
    $pdf->MultiCell(0, 5, $val('postal_address'), 0, 'L');
    $pdf->Cell(0, 4, 'Are you able to read, write, and understand English?', 0, 1);
    $cb((int)$val('english_read_write') === 1);
    $pdf->Cell(15, 5, 'Yes', 0, 0);
    $cb((int)$val('english_read_write') === 2);
    $pdf->Cell(15, 5, 'No', 0, 1);
    $pdf->Ln(1);

    $pdf->Cell(35, 5, 'Mobile Number:', 0, 0);
    $pdf->Cell(40, 5, $val('mobile_num'), 0, 0);
    $pdf->Cell(25, 5, 'Work Phone:', 0, 0);
    $pdf->Cell(0, 5, $val('work_phone'), 0, 1);
    $pdf->Cell(35, 5, 'Home Phone:', 0, 0);
    $pdf->Cell(40, 5, $val('home_phone'), 0, 0);
    $pdf->Cell(25, 5, 'Email Address:', 0, 0);
    $pdf->Cell(0, 5, $val('emailAddress'), 0, 1);
    $pdf->Cell(50, 5, 'Emergency Contact (Name & Relation):', 0, 0);
    $pdf->Cell(0, 5, $val('em_full_name') . ' / ' . $val('em_relation'), 0, 1);
    $pdf->Cell(35, 5, 'Emergency Mobile:', 0, 0);
    $pdf->Cell(0, 5, $val('em_mobile_num'), 0, 1);
    $pdf->Ln(2);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 5, 'Language and Cultural Diversity', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(35, 5, 'Country of Birth:', 0, 0);
    $pdf->Cell(50, 5, $val('birth_country'), 0, 0);
    $pdf->Cell(25, 5, 'City of Birth:', 0, 0);
    $pdf->Cell(0, 5, $val('city_of_birth'), 0, 1);
    $pdf->Cell(0, 4, 'Do you speak a language other than English?', 0, 1);
    $cb((int)$val('lan_spoken') === 2);
    $pdf->Cell(15, 5, 'No', 0, 0);
    $cb((int)$val('lan_spoken') === 1);
    $pdf->Cell(50, 5, 'Yes  Language Spoken (at Home): ' . $val('lan_spoken_other'), 0, 1);
    $pdf->Cell(0, 4, 'Are you Aboriginal and/or Torres Strait Islander?', 0, 1);
    $cb((int)$val('origin') === 1);
    $pdf->Cell(15, 5, 'No', 0, 0);
    $cb((int)$val('origin') === 2);
    $pdf->Cell(35, 5, 'Yes, Aboriginal', 0, 0);
    $cb((int)$val('origin') === 3);
    $pdf->Cell(0, 5, 'Yes, Torres Strait Islander', 0, 1);
    $pdf->Ln(1);

    $pdf->Cell(0, 4, 'Disability (see Disability Supplement):', 0, 1);
    $cb((int)$val('disability') === 1);
    $pdf->Cell(50, 5, 'Yes (if yes, tick relevant)', 0, 0);
    $cb((int)$val('disability') === 2);
    $pdf->Cell(20, 5, 'No', 0, 1);
    $disTypes = array('Hearing/Deaf', 'Physical', 'Intellectual', 'Medical Condition', 'Mental Illness', 'Acquired brain impairment', 'Learning', 'Vision', 'Other');
    $dt = $val('st_disability_type');
    if (is_string($dt)) $dt = @json_decode($dt, true);
    if (!is_array($dt)) $dt = array();
    $pdf->Cell(5, 5, '', 0, 0);
    foreach ($disTypes as $i => $l) {
        $cb(in_array((string)$i, $dt));
        $pdf->Cell(32, 5, $l, 0, 0);
    }
    $pdf->Ln(5);
    $pdf->Cell(5, 5, '', 0, 0);
    $pdf->Cell(0, 5, 'Other: ' . $val('disability_type_other'), 0, 1);
    $pdf->Ln(2);

    $pdf->Cell(0, 4, 'What is your highest school level COMPLETED? (tick one only)', 0, 1);
    $hs = (int)$val('highest_school');
    for ($i = 1; $i <= 6; $i++) {
        $cb($hs === $i);
        $pdf->Cell(35, 5, array(1=>'Year 12 or equivalent', 2=>'Year 11 or equivalent', 3=>'Year 10 or equivalent', 4=>'Year 9 or equivalent', 5=>'Year 8 or below', 6=>'Never attended school')[$i], 0, 0);
    }
    $pdf->Ln(5);
    $pdf->Cell(0, 4, 'Are you still enrolled in secondary or senior secondary education?', 0, 1);
    $cb((int)$val('sec_school') === 1);
    $pdf->Cell(15, 5, 'Yes', 0, 0);
    $cb((int)$val('sec_school') === 2);
    $pdf->Cell(15, 5, 'No', 0, 1);
    $pdf->Cell(55, 5, 'In which YEAR did you complete the above school level?', 0, 0);
    $pdf->Cell(0, 5, $val('year_completed_school'), 0, 1);
    $pdf->Cell(0, 4, 'Mode of Delivery:', 0, 1);
    $md = $val('mode_delivery');
    $cb($md === 'Classroom');
    $pdf->Cell(28, 5, 'Classroom', 0, 0);
    $cb($md === 'Online');
    $pdf->Cell(28, 5, 'Online (Virtual)', 0, 0);
    $cb($md === 'Blended');
    $pdf->Cell(28, 5, 'Blended', 0, 0);
    $cb($md === 'Workplace');
    $pdf->Cell(0, 5, 'Workplace Based', 0, 1);
    $pdf->Cell(0, 5, 'Choose A Qualification: ' . $val('courses_display'), 0, 1);

    // Page 2
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(0, 4, 'Enrolment Form  National College Australia  RTO:91000  2 | Page', 0, 1);
    $pdf->Ln(2);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, 'Have you successfully completed any of the following qualifications? (Tick most relevant)', 0, 1);
    $qLabels = array('qual_cert1'=>'Certificate I', 'qual_cert2'=>'Certificate II', 'qual_cert3'=>'Certificate III (Trade Cert)', 'qual_cert4'=>'Certificate IV', 'qual_diploma'=>'Diploma', 'qual_adv_diploma'=>'Advanced Diploma', 'qual_bachelor'=>"Bachelor's or Higher", 'qual_other'=>'Other', 'qual_none'=>'None');
    foreach ($qLabels as $k => $l) {
        $cbOnly((int)$val($k) === 1);
        $pdf->Cell(0, 5, $l, 0, 1);
    }
    $pdf->Cell(0, 4, 'Attained:', 0, 1);
    $qa = $val('qualification_attained');
    $cb($qa === 'Australia');
    $pdf->Cell(45, 5, 'Attained in Australia', 0, 0);
    $cb($qa === 'Equivalent');
    $pdf->Cell(45, 5, 'Australian Equivalent', 0, 0);
    $cb($qa === 'International');
    $pdf->Cell(0, 5, 'International', 0, 1);
    $pdf->Ln(3);

    $pdf->Cell(0, 5, 'Employment Status:', 0, 1);
    $empLabels = array(1=>'Full-time employee', 2=>'Part-time employee', 3=>'Self-employed - not employing others', 4=>'Self-employed - employing others', 5=>'Employed - unpaid worker in family business', 6=>'Unemployed - seeking full-time work', 7=>'Unemployed - seeking part-time work', 8=>'Unemployed - not seeking employment');
    $emp = (int)$val('emp_status');
    foreach ($empLabels as $v => $l) {
        $cb($emp === $v);
        $pdf->Cell(0, 5, $l, 0, 1);
    }
    $pdf->Cell(45, 5, 'Industry of Work (ANZSCO):', 0, 0);
    $pdf->Cell(0, 5, $val('industry_of_work'), 0, 1);
    $pdf->Ln(2);
    $pdf->Cell(0, 5, 'Reason for Enrolling:', 0, 1);
    $studyLabels = array(1=>'To get a job', 2=>'To get a better job or promotion', 3=>'It was a requirement for my job', 4=>'I wanted extra skills for my job', 5=>'To start my own business', 6=>'To get into another course', 7=>'To try for a different career', 8=>'To develop my existing business', 9=>'For personal interest or self-development', 10=>'Community/voluntary work', 11=>'Other reasons');
    $sr = (int)$val('study_reason');
    foreach ($studyLabels as $v => $l) {
        $cb($sr === $v);
        $pdf->Cell(0, 5, $l, 0, 1);
    }
    $pdf->Cell(0, 5, 'Other: ' . $val('study_reason_other'), 0, 1);
    $pdf->Ln(2);
    $pdf->Cell(0, 5, 'Credit Transfer (CT) / Recognise Prior Learning (RPL):', 0, 1);
    $cb((int)$val('cred_tansf') === 1);
    $pdf->Cell(15, 5, 'Yes', 0, 0);
    $cb((int)$val('cred_tansf') === 2);
    $pdf->Cell(15, 5, 'No', 0, 1);
    $pdf->Ln(2);
    $pdf->Cell(0, 5, 'Do you have access to a computer and the internet?', 0, 1);
    $cb((int)$val('computer_access') === 1);
    $pdf->Cell(15, 5, 'Yes', 0, 0);
    $cb((int)$val('computer_access') === 2);
    $pdf->Cell(15, 5, 'No', 0, 1);
    $pdf->Cell(0, 5, 'Computer literacy: ' . $val('computer_literacy') . '   Numeracy skills: ' . $val('numeracy_skills'), 0, 1);
    $pdf->Cell(0, 5, 'Do you require additional support?', 0, 1);
    $cb((int)$val('additional_support') === 1);
    $pdf->Cell(15, 5, 'No', 0, 0);
    $cb((int)$val('additional_support') === 2);
    $pdf->Cell(0, 5, 'Yes (please specify): ' . $val('additional_support_specify'), 0, 1);

    // Page 3 - Declarations
    $pdf->AddPage();
    $pdf->Cell(0, 4, 'Enrolment Form  National College Australia  RTO:91000  3 | Page', 0, 1);
    $pdf->Ln(2);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 5, 'UNIQUE STUDENT IDENTIFIER / PRIVACY / REFUND', 0, 1);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->MultiCell(0, 4, 'I understand that my results will be uploaded into USI records as per company policy. If you have not yet obtained a USI you can apply at https://www.usi.gov.au/your-usi/create-usi', 0, 'L');
    $cbOnly((int)$val('usi_declaration') === 1);
    $pdf->Cell(0, 5, 'Yes, I understand and declare (USI)', 0, 1);
    $pdf->Ln(2);
    $pdf->MultiCell(0, 4, 'Privacy Notice: NCVER will collect, hold, use and disclose your personal information in accordance with the law. For more information see www.ncver.edu.au/privacy', 0, 'L');
    $cbOnly((int)$val('privacy_declaration') === 1);
    $pdf->Cell(0, 5, 'Yes, I understand and declare (Privacy)', 0, 1);
    $pdf->Ln(2);
    $pdf->MultiCell(0, 4, 'Refund Policy: Details of the RTO Fees and Charges / Refund Policy can be found on our website.', 0, 'L');
    $cbOnly((int)$val('refund_declaration') === 1);
    $pdf->Cell(0, 5, 'Yes, I understand and declare (Refund)', 0, 1);
    $pdf->Ln(3);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 5, 'Office Use Only:', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(30, 5, 'Student ID #:', 0, 0);
    $pdf->Cell(50, 5, $val('office_student_id'), 0, 0);
    $pdf->Cell(0, 5, 'Enrolment Coordinator/Admin: ' . $val('office_coordinator_name'), 0, 1);
    $cbOnly((int)$val('office_invoice_provided') === 1);
    $pdf->Cell(35, 5, 'Invoice Provided', 0, 0);
    $cbOnly((int)$val('office_receipt_collected') === 1);
    $pdf->Cell(35, 5, 'Receipt Collected', 0, 0);
    $cbOnly((int)$val('office_lms_access') === 1);
    $pdf->Cell(35, 5, 'LMS Access Granted', 0, 1);
    $cbOnly((int)$val('office_resources_access') === 1);
    $pdf->Cell(35, 5, 'Resources Access', 0, 0);
    $cbOnly((int)$val('office_uploaded_sms') === 1);
    $pdf->Cell(35, 5, 'Uploaded into SMS', 0, 0);
    $cbOnly((int)$val('office_welcome_pack_sent') === 1);
    $pdf->Cell(0, 5, 'Welcome Pack Sent', 0, 1);

    // Page 4 - Candidate Declaration
    $pdf->AddPage();
    $pdf->Cell(0, 4, 'Enrolment Form  National College Australia  RTO:91000  4 | Page', 0, 1);
    $pdf->Ln(2);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 5, 'Candidate Declaration:', 0, 1);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->MultiCell(0, 4, 'I understand and declare: I have read the Student Handbook including Privacy, Fee Administration and Refund Policy; I agree to allow collection of LLN and assessment information; I give consent to release my details to relevant government bodies; I agree to participate in mandatory course requirements; I confirm details provided are true.', 0, 'L');
    $cbOnly((int)$val('candidate_declaration') === 1);
    $pdf->Cell(0, 5, 'Yes, I understand and declare.', 0, 1);
    $pdf->Ln(3);
    $pdf->Cell(45, 5, 'Full Name of the Candidate:', 0, 0);
    $pdf->Cell(0, 5, $val('candidate_full_name'), 0, 1);
    $pdf->Cell(45, 5, 'Date:', 0, 0);
    $pdf->Cell(40, 5, $val('candidate_date'), 0, 0);
    $pdf->Cell(0, 5, 'Signature: ' . $val('candidate_signature'), 0, 1);

    $pdf->Output($savePath, 'F');
    return true;
}
