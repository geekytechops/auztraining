-- PEFU / PCFU: last time enquiry flow status was set from a follow-up outcome (Post Enquiry vs Post Counselling).
-- Applied automatically on save via includes/datacontrol.php when needed.

ALTER TABLE `student_enquiry`
  ADD COLUMN `st_enquiry_flow_change_stage` VARCHAR(8) NULL DEFAULT NULL
  COMMENT 'PEFU or PCFU when enquiry status last set from follow-up outcome';
