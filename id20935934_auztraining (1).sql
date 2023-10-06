-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 06, 2023 at 02:45 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id20935934_auztraining`
--

-- --------------------------------------------------------

--
-- Table structure for table `counseling_details`
--

DROP TABLE IF EXISTS `counseling_details`;
CREATE TABLE IF NOT EXISTS `counseling_details` (
  `counsil_id` int NOT NULL AUTO_INCREMENT,
  `st_enquiry_id` varchar(255) DEFAULT NULL,
  `counsil_mem_name` varchar(255) DEFAULT NULL,
  `counsil_vaccine_status` tinyint(1) DEFAULT NULL,
  `counsil_job_nature` varchar(255) DEFAULT NULL,
  `counsil_module_result` varchar(100) DEFAULT NULL,
  `counsil_timing` timestamp NULL DEFAULT NULL,
  `counsil_end_time` timestamp NULL DEFAULT NULL,
  `counsil_pref_comments` text,
  `counsil_eng_rate` varchar(10) DEFAULT NULL,
  `counsil_migration_test` tinyint(1) DEFAULT NULL,
  `counsil_overall_result` varchar(100) DEFAULT NULL,
  `counsil_course` varchar(255) DEFAULT NULL,
  `counsil_university` varchar(255) DEFAULT NULL,
  `counsil_qualification` varchar(255) DEFAULT NULL,
  `counsil_type` tinyint(1) DEFAULT NULL,
  `counsil_aus_stay_time` varchar(255) DEFAULT NULL,
  `counsil_visa_condition` tinyint(1) DEFAULT NULL,
  `counsil_education` varchar(255) DEFAULT NULL,
  `counsil_aus_study_status` tinyint(1) DEFAULT NULL,
  `counsil_work_status` tinyint(1) DEFAULT NULL,
  `counsil_remarks` text,
  `counsil_created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `counsil_createdby` int DEFAULT NULL,
  `counsil_modified_date` date DEFAULT NULL,
  `counsil_modified_by` int DEFAULT NULL,
  `counsil_delete_note` varchar(255) DEFAULT NULL,
  `counsil_enquiry_status` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`counsil_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `counseling_details`
--

INSERT INTO `counseling_details` (`counsil_id`, `st_enquiry_id`, `counsil_mem_name`, `counsil_vaccine_status`, `counsil_job_nature`, `counsil_module_result`, `counsil_timing`, `counsil_end_time`, `counsil_pref_comments`, `counsil_eng_rate`, `counsil_migration_test`, `counsil_overall_result`, `counsil_course`, `counsil_university`, `counsil_qualification`, `counsil_type`, `counsil_aus_stay_time`, `counsil_visa_condition`, `counsil_education`, `counsil_aus_study_status`, `counsil_work_status`, `counsil_remarks`, `counsil_created_date`, `counsil_createdby`, `counsil_modified_date`, `counsil_modified_by`, `counsil_delete_note`, `counsil_enquiry_status`) VALUES
(1, 'EQ00002', 'surya', 2, '', '', '2022-12-06 18:29:00', '2023-10-21 14:50:00', 'nothing', '2', 2, '', '', '', '2 years ', 1, '20', 1, 'test education', 2, 2, '[\"1\"]', '2023-10-05 20:20:59', 1, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) NOT NULL,
  `course_sname` varchar(255) NOT NULL,
  `course_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_sname`, `course_status`, `created_date`) VALUES
(1, 'A3', 'Certificate III in Individual Support (Ageing)', 0, '2023-09-07 22:40:15'),
(2, 'D3', 'Certificate III in Individual Support (Disability)', 0, '2023-09-07 22:40:16'),
(3, 'C3', 'Certificate III in Individual Support (Ageing & Disability)', 0, '2023-09-07 22:40:16'),
(4, 'A4', 'Certificate IV in Ageing Support', 0, '2023-09-07 22:40:16'),
(5, 'D4', 'Certificate IV in Disability', 0, '2023-09-07 22:40:16'),
(6, 'HAS', 'Certificate III in Health Services Assistance', 0, '2023-09-07 22:40:16'),
(7, 'FA', 'Provide First Aid', 0, '2023-09-07 22:40:16'),
(8, 'BLS', 'Provide Basic Emergency Life Support', 0, '2023-09-07 22:40:16'),
(9, 'CPR', 'Provide Cardiopulmonary Resuscitation (CPR)', 0, '2023-09-07 22:40:16'),
(10, 'MEDR', 'Medication Course: Refresher', 0, '2023-09-07 22:40:16'),
(11, 'MEDF', 'Medication Course: Full', 0, '2023-09-07 22:40:16'),
(12, 'MHR', 'Manual Handling: Refresher', 0, '2023-09-07 22:40:16'),
(13, 'MHF', 'Manual Handling: Full', 0, '2023-09-07 22:40:16'),
(14, 'MH4', 'cert 4 in Mental health', 0, '2023-09-07 22:40:16'),
(15, 'DMH', 'diploma in mental health', 0, '2023-09-07 22:40:16'),
(16, 'BSG', 'insulin training - BSG', 0, '2023-09-07 22:40:16'),
(17, 'DCS', 'Diploma in comm services', 0, '2023-09-07 22:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `document_id` int NOT NULL AUTO_INCREMENT,
  `document_name` varchar(255) NOT NULL,
  `document_shortcode` varchar(255) NOT NULL,
  `document_status` tinyint(1) NOT NULL DEFAULT '0',
  `document_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`document_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_forms`
--

DROP TABLE IF EXISTS `enquiry_forms`;
CREATE TABLE IF NOT EXISTS `enquiry_forms` (
  `enq_form_id` int NOT NULL AUTO_INCREMENT,
  `enq_admin_id` int DEFAULT NULL,
  `enq_status` tinyint(1) NOT NULL,
  `enq_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`enq_form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followup_calls`
--

DROP TABLE IF EXISTS `followup_calls`;
CREATE TABLE IF NOT EXISTS `followup_calls` (
  `flw_id` int NOT NULL AUTO_INCREMENT,
  `enquiry_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `flw_name` varchar(255) DEFAULT NULL,
  `flw_phone` varchar(100) DEFAULT NULL,
  `flw_contacted_person` varchar(255) DEFAULT NULL,
  `flw_contacted_time` datetime DEFAULT NULL,
  `flw_date` date DEFAULT NULL,
  `flw_progress_state` varchar(255) DEFAULT NULL,
  `flw_remarks` text NOT NULL,
  `flw_comments` text NOT NULL,
  `flw_mode_contact` varchar(100) DEFAULT NULL,
  `flw_created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flw_created_by` int DEFAULT NULL,
  `flw_modified_date` timestamp NULL DEFAULT NULL,
  `flw_modifiedby` int DEFAULT NULL,
  `flw_enquiry_status` tinyint NOT NULL DEFAULT '0',
  `flw_delete_note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`flw_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `followup_calls`
--

INSERT INTO `followup_calls` (`flw_id`, `enquiry_id`, `flw_name`, `flw_phone`, `flw_contacted_person`, `flw_contacted_time`, `flw_date`, `flw_progress_state`, `flw_remarks`, `flw_comments`, `flw_mode_contact`, `flw_created_date`, `flw_created_by`, `flw_modified_date`, `flw_modifiedby`, `flw_enquiry_status`, `flw_delete_note`) VALUES
(1, '', 'test student', '8309603265', 'surya', '2023-12-31 22:59:00', '2023-12-30', NULL, '[\"6\",\"14\"]', 'nothng for  now', 'phone call', '2023-10-02 22:22:06', 1, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `inv_id` int NOT NULL AUTO_INCREMENT,
  `inv_auto_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_unique_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `inv_std_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `inv_course` tinyint(1) NOT NULL,
  `inv_fee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `inv_paid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `inv_due` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `inv_payment_date` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inv_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

DROP TABLE IF EXISTS `qualifications`;
CREATE TABLE IF NOT EXISTS `qualifications` (
  `qualification_id` int NOT NULL AUTO_INCREMENT,
  `qualification_name` varchar(255) NOT NULL,
  `qualification_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`qualification_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`qualification_id`, `qualification_name`, `qualification_status`, `created_date`) VALUES
(1, 'Masters Degree', 0, '2023-08-23 00:37:08'),
(2, 'Bachelors Degree', 0, '2023-08-23 00:37:08'),
(3, 'MCA', 0, '2023-08-23 00:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `regular_group_form`
--

DROP TABLE IF EXISTS `regular_group_form`;
CREATE TABLE IF NOT EXISTS `regular_group_form` (
  `reg_grp_id` int NOT NULL AUTO_INCREMENT,
  `reg_grp_names` text,
  `enq_form_id` int DEFAULT NULL,
  `reg_grp_status` tinyint NOT NULL DEFAULT '0',
  `reg_grp_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reg_grp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rpl_enquries`
--

DROP TABLE IF EXISTS `rpl_enquries`;
CREATE TABLE IF NOT EXISTS `rpl_enquries` (
  `rpl_enq_id` int NOT NULL AUTO_INCREMENT,
  `enq_form_id` int DEFAULT NULL,
  `rpl_exp_in` varchar(255) DEFAULT NULL,
  `rpl_exp_role` varchar(255) DEFAULT NULL,
  `rpl_exp_years` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rpl_exp_docs` varchar(1) DEFAULT '0',
  `rpl_exp_prev_qual` varchar(1) DEFAULT '0',
  `rpl_exp_qual_name` varchar(255) NOT NULL,
  `rpl_exp` varchar(1) NOT NULL DEFAULT '0',
  `rpl_exp_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rpl_enq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rpl_enquries`
--

INSERT INTO `rpl_enquries` (`rpl_enq_id`, `enq_form_id`, `rpl_exp_in`, `rpl_exp_role`, `rpl_exp_years`, `rpl_exp_docs`, `rpl_exp_prev_qual`, `rpl_exp_qual_name`, `rpl_exp`, `rpl_exp_created_date`) VALUES
(1, 1, '', '', '', '', '', '', '2', '2023-10-02 16:49:58'),
(2, 2, '2', 'developer', '5', '2', '2', '', '1', '2023-10-02 16:51:27');

-- --------------------------------------------------------

--
-- Table structure for table `short_group_form`
--

DROP TABLE IF EXISTS `short_group_form`;
CREATE TABLE IF NOT EXISTS `short_group_form` (
  `sh_grp_id` int NOT NULL AUTO_INCREMENT,
  `enq_form_id` int DEFAULT NULL,
  `sh_org_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sh_grp_org_type` tinyint(1) DEFAULT NULL,
  `sh_grp_campus` tinyint(1) DEFAULT NULL,
  `sh_grp_date` date DEFAULT NULL,
  `sh_grp_num_stds` int DEFAULT NULL,
  `sh_grp_ind_exp` tinyint(1) DEFAULT NULL,
  `sh_grp_train_bef` tinyint(1) DEFAULT NULL,
  `sh_grp_con_us` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sh_grp_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sh_grp_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sh_grp_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sh_grp_status` tinyint(1) NOT NULL DEFAULT '0',
  `sh_grp_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sh_grp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slot_book`
--

DROP TABLE IF EXISTS `slot_book`;
CREATE TABLE IF NOT EXISTS `slot_book` (
  `slot_bk_id` int NOT NULL AUTO_INCREMENT,
  `enq_form_id` int NOT NULL,
  `slot_bk_datetime` timestamp NULL DEFAULT NULL,
  `slot_bk_purpose` varchar(255) NOT NULL,
  `slot_bk_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `slot_book_by` varchar(150) NOT NULL,
  `slot_bk_attend` tinyint NOT NULL DEFAULT '1',
  `slot_book_email_link` tinyint NOT NULL,
  PRIMARY KEY (`slot_bk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `slot_book`
--

INSERT INTO `slot_book` (`slot_bk_id`, `enq_form_id`, `slot_bk_datetime`, `slot_bk_purpose`, `slot_bk_on`, `slot_book_by`, `slot_bk_attend`, `slot_book_email_link`) VALUES
(1, 1, '2023-10-04 16:49:00', 'just visit', '2023-10-03 00:00:00', 'surya', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

DROP TABLE IF EXISTS `source`;
CREATE TABLE IF NOT EXISTS `source` (
  `source_id` int NOT NULL AUTO_INCREMENT,
  `source_name` varchar(255) NOT NULL,
  `source_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`source_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `source`
--

INSERT INTO `source` (`source_id`, `source_name`, `source_status`, `created_date`) VALUES
(1, 'Friends', 0, '2023-08-23 06:09:15'),
(2, 'Google', 0, '2023-08-23 06:09:15'),
(3, 'Website', 0, '2023-08-23 06:09:19');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
CREATE TABLE IF NOT EXISTS `student_attendance` (
  `st_at_id` int NOT NULL AUTO_INCREMENT,
  `st_unique_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `st_course_unit` varchar(255) NOT NULL,
  `st_unit_date` date NOT NULL,
  `st_unit_status` tinyint(1) NOT NULL DEFAULT '0',
  `st_unit_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`st_at_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_docs`
--

DROP TABLE IF EXISTS `student_docs`;
CREATE TABLE IF NOT EXISTS `student_docs` (
  `st_doc_id` int NOT NULL AUTO_INCREMENT,
  `st_unique_id` varchar(255) NOT NULL,
  `st_doc_names` text NOT NULL,
  `st_doc_status` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `st_modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`st_doc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_enquiry`
--

DROP TABLE IF EXISTS `student_enquiry`;
CREATE TABLE IF NOT EXISTS `student_enquiry` (
  `st_id` int NOT NULL AUTO_INCREMENT,
  `st_enquiry_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_member_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_phno` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_course` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `st_course_type` tinyint(1) NOT NULL DEFAULT '0',
  `st_street_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_suburb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_state` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0',
  `st_post_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_visited` tinyint(1) NOT NULL,
  `st_heared` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_hearedby` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `st_refered` tinyint(1) NOT NULL,
  `st_refer_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `st_refer_alumni` tinyint(1) NOT NULL,
  `st_fee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `st_shore` tinyint(1) NOT NULL,
  `st_ethnicity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_pref_comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `st_appoint_book` tinyint(1) NOT NULL,
  `st_enquiry_for` tinyint(1) NOT NULL DEFAULT '1',
  `st_visa_status` tinyint(1) DEFAULT '0',
  `st_visa_condition` tinyint DEFAULT '1',
  `st_visa_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `st_enquiry_status` tinyint(1) NOT NULL DEFAULT '0',
  `st_delete_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_startplan_date` datetime DEFAULT NULL,
  `st_enquiry_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `st_created_by` int NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `st_modified_by` int DEFAULT NULL,
  `st_modified_date` datetime DEFAULT NULL,
  `st_gen_enq_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enquiry`
--

INSERT INTO `student_enquiry` (`st_id`, `st_enquiry_id`, `st_name`, `st_member_name`, `st_surname`, `st_phno`, `st_email`, `st_course`, `st_course_type`, `st_street_details`, `st_suburb`, `st_state`, `st_post_code`, `st_visited`, `st_heared`, `st_hearedby`, `st_refered`, `st_refer_name`, `st_refer_alumni`, `st_fee`, `st_remarks`, `st_shore`, `st_ethnicity`, `st_comments`, `st_pref_comments`, `st_appoint_book`, `st_enquiry_for`, `st_visa_status`, `st_visa_condition`, `st_visa_note`, `st_enquiry_status`, `st_delete_note`, `st_startplan_date`, `st_enquiry_date`, `st_created_by`, `created_date`, `st_modified_by`, `st_modified_date`, `st_gen_enq_type`) VALUES
(1, 'EQ00001', 'satya', 'surya', 'mangs', '8309603262', 'saikiran.m.v.s.s@gmail.com', '[\"3\",\"10\"]', 1, 'street roads2', 'sub urbs names', '2', '535558', 1, '[\"9\"]', 'from friends', 2, '', 2, 'discussed 5000', '[\"1\",\"2\"]', 1, 'indian', 'no comments', '', 1, 2, 0, 1, '', 0, NULL, '2023-12-31 00:00:00', '2023-10-25 00:00:00', 1, '2023-10-03 15:05:38', 1, '2023-10-03 15:05:38', NULL),
(2, 'EQ00002', 'satya', 'satya', 'suryas ', '8309603263', 'saisaatya51@gmail.com', '[\"5\"]', 1, 'agraharam street', 'bobbili', '2', '535558', 1, '[\"4\"]', '', 2, '', 0, '999', '', 0, '', '', '', 0, 1, 0, 1, '', 0, NULL, '0000-00-00 00:00:00', '2023-12-31 00:00:00', 1, '2023-10-02 16:51:23', NULL, NULL, NULL),
(3, 'EQ00003', 'suryaas', 'satya', 'unaasd', '8309603262', 'saisatya51@gmail.com', '[\"14\"]', 0, 'agraharam street', 'bobbili', '0', '535558', 2, '[\"1\",\"9\"]', '', 1, 'asdfa', 1, '', NULL, 0, NULL, '', '', 0, 2, 0, 1, NULL, 0, NULL, '0000-00-00 00:00:00', '2023-10-02 22:27:14', 0, '2023-10-02 17:15:03', NULL, NULL, 1),
(4, 'EQ00004', 'satya', 'satya', 'asdfa', '8309603987', 'saisatya51@gmail.com', '[\"12\"]', 0, 'agraharam street', 'bobbili', '0', '535558', 1, '[\"1\",\"9\"]', 'nothing', 2, '', 0, '', NULL, 0, NULL, '', '', 0, 2, 0, 1, NULL, 0, NULL, '0000-00-00 00:00:00', '2023-10-02 22:31:29', 0, '2023-10-02 17:15:00', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_enrolment`
--

DROP TABLE IF EXISTS `student_enrolment`;
CREATE TABLE IF NOT EXISTS `student_enrolment` (
  `st_enrol_id` int NOT NULL AUTO_INCREMENT,
  `st_unique_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_enquiry_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_qualifications` tinyint(1) NOT NULL,
  `st_enrol_course` tinyint(1) DEFAULT NULL,
  `st_venue` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_source` tinyint(1) NOT NULL,
  `st_given_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_enrol_status` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`st_enrol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_log_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_log_id` (`user_log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_log_id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_status`, `created_date`, `modified_date`) VALUES
(1, 'ST56F54', 'test1', 'test123@gmail.com', 'test', 1, 0, '2023-08-19 23:06:13', NULL),
(2, '082623DSB0001', 'test2', 'test234@gmail.com', 'test2', 0, 0, '2023-08-19 23:06:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

DROP TABLE IF EXISTS `venue`;
CREATE TABLE IF NOT EXISTS `venue` (
  `venue_id` int NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(255) NOT NULL,
  `venue_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`venue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`venue_id`, `venue_name`, `venue_status`, `created_date`) VALUES
(1, 'Adeladie', 0, '2023-08-23 06:08:00'),
(2, 'New Jersey', 0, '2023-08-23 06:08:00'),
(3, 'Australia', 0, '2023-08-23 06:08:04');

-- --------------------------------------------------------

--
-- Table structure for table `visa_statuses`
--

DROP TABLE IF EXISTS `visa_statuses`;
CREATE TABLE IF NOT EXISTS `visa_statuses` (
  `visa_id` int NOT NULL AUTO_INCREMENT,
  `visa_status_name` varchar(255) NOT NULL,
  `visa_state_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL,
  PRIMARY KEY (`visa_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visa_statuses`
--

INSERT INTO `visa_statuses` (`visa_id`, `visa_status_name`, `visa_state_status`, `created_date`) VALUES
(1, 'Dependent on subclass 500', 0, '2023-08-23 05:17:23'),
(2, '489 visa', 0, '2023-08-23 05:17:23'),
(3, '491', 0, '2023-08-23 05:17:29'),
(4, 'Visitor’s visa', 0, '2023-09-16 00:22:01'),
(5, 'Permanent resident', 0, '2023-09-16 00:22:01'),
(6, 'Citizen', 0, '2023-09-16 00:22:18'),
(7, 'Other', 0, '2023-09-16 00:22:18');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
