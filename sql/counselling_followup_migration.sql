-- Counselling: Preferred Intake Date, Mode of Study (Face to Face / Online / Blended)
ALTER TABLE `counseling_details`
  ADD COLUMN `counsil_preferred_intake_date` DATE NULL DEFAULT NULL AFTER `counsil_type`,
  ADD COLUMN `counsil_mode_of_study` TINYINT(1) NULL DEFAULT NULL COMMENT '1=Face to Face, 2=Online, 3=Blended' AFTER `counsil_preferred_intake_date`;

-- Enquiry workflow status on main enquiry (default New when first enquiry)
ALTER TABLE `student_enquiry`
  ADD COLUMN `st_enquiry_flow_status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=New,2=Contacted,3=Follow-up Required,4=Interested,5=Documents Collected,6=Enrolled,7=Not Interested,8=Invalid/Duplicate' AFTER `st_enquiry_status`;

-- Follow-up: type (Call/Email), notes, next date, outcome
ALTER TABLE `followup_calls`
  ADD COLUMN `flw_followup_type` VARCHAR(20) NULL DEFAULT NULL COMMENT 'Call, Email' AFTER `flw_mode_contact`,
  ADD COLUMN `flw_follow_up_notes` TEXT NULL DEFAULT NULL AFTER `flw_followup_type`,
  ADD COLUMN `flw_next_followup_date` DATETIME NULL DEFAULT NULL AFTER `flw_follow_up_notes`,
  ADD COLUMN `flw_follow_up_outcome` VARCHAR(100) NULL DEFAULT NULL COMMENT 'No answer, Call back later, Sent info, Enrolment in progress' AFTER `flw_next_followup_date`;

-- Enquiry status email templates (one per status, editable by staff)
CREATE TABLE IF NOT EXISTS `enquiry_status_email_templates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status_code` TINYINT(1) NOT NULL COMMENT '1=New,2=Contacted,3=Follow-up Required,4=Interested,5=Documents Collected,6=Enrolled,7=Not Interested,8=Invalid/Duplicate',
  `subject` VARCHAR(255) NOT NULL DEFAULT '',
  `body` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_code` (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default templates for each of the 8 enquiry statuses
INSERT INTO `enquiry_status_email_templates` (`status_code`, `subject`, `body`) VALUES
(1, 'Thank you for your enquiry', 'Dear {{student_name}},\n\nThank you for your enquiry. We have received your details and will be in touch shortly.\n\nBest regards,\nNational College Australia'),
(2, 'Thank you for your time', 'Dear {{student_name}},\n\nThank you for your time speaking with us today. As discussed, we will follow up with further information.\n\nBest regards,\nNational College Australia'),
(3, 'Follow-up – National College Australia', 'Dear {{student_name}},\n\nWe would like to follow up on your enquiry. Please contact us at your convenience.\n\nBest regards,\nNational College Australia'),
(4, 'We are glad you are interested', 'Dear {{student_name}},\n\nWe are glad you are interested in our courses. Our team will send you the next steps shortly.\n\nBest regards,\nNational College Australia'),
(5, 'Documents received', 'Dear {{student_name}},\n\nWe have received your documents. We will review and get back to you soon.\n\nBest regards,\nNational College Australia'),
(6, 'Welcome – Enrolment confirmed', 'Dear {{student_name}},\n\nYour enrolment has been confirmed. Welcome to National College Australia.\n\nBest regards,\nNational College Australia'),
(7, 'Thank you for your interest', 'Dear {{student_name}},\n\nThank you for your interest. If you change your mind in the future, we are here to help.\n\nBest regards,\nNational College Australia'),
(8, 'Enquiry update', 'Dear {{student_name}},\n\nWe are writing in relation to your recent enquiry. Please contact us if you have any questions.\n\nBest regards,\nNational College Australia')
ON DUPLICATE KEY UPDATE `subject` = VALUES(`subject`), `body` = VALUES(`body`);
