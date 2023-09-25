-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 25, 2023 at 02:34 AM
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
  `counsil_mem_name` varchar(255) DEFAULT NULL,
  `counsil_vaccine_status` tinyint(1) DEFAULT NULL,
  `counsil_job_nature` varchar(255) DEFAULT NULL,
  `counsil_module_result` varchar(100) DEFAULT NULL,
  `counsil_timing` timestamp NULL DEFAULT NULL,
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

INSERT INTO `counseling_details` (`counsil_id`, `counsil_mem_name`, `counsil_vaccine_status`, `counsil_job_nature`, `counsil_module_result`, `counsil_timing`, `counsil_pref_comments`, `counsil_eng_rate`, `counsil_migration_test`, `counsil_overall_result`, `counsil_course`, `counsil_university`, `counsil_qualification`, `counsil_type`, `counsil_aus_stay_time`, `counsil_visa_condition`, `counsil_education`, `counsil_aus_study_status`, `counsil_work_status`, `counsil_remarks`, `counsil_created_date`, `counsil_createdby`, `counsil_modified_date`, `counsil_modified_by`, `counsil_delete_note`, `counsil_enquiry_status`) VALUES
(1, 'testing', 2, '', '', '2023-12-31 18:29:00', 'tasets', '8', 2, '', '', '', 'aetest', 1, '20 years', 1, 'test name', 2, 2, '[\"1\",\"2\"]', '2023-09-23 21:14:25', 1, '2023-09-24', 1, 'test', 0);

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
(1, 'A3', 'Certificate III in Individual Support (Ageing)', 0, '2023-09-08 04:10:15'),
(2, 'D3', 'Certificate III in Individual Support (Disability)', 0, '2023-09-08 04:10:16'),
(3, 'C3', 'Certificate III in Individual Support (Ageing & Disability)', 0, '2023-09-08 04:10:16'),
(4, 'A4', 'Certificate IV in Ageing Support', 0, '2023-09-08 04:10:16'),
(5, 'D4', 'Certificate IV in Disability', 0, '2023-09-08 04:10:16'),
(6, 'HAS', 'Certificate III in Health Services Assistance', 0, '2023-09-08 04:10:16'),
(7, 'FA', 'Provide First Aid', 0, '2023-09-08 04:10:16'),
(8, 'BLS', 'Provide Basic Emergency Life Support', 0, '2023-09-08 04:10:16'),
(9, 'CPR', 'Provide Cardiopulmonary Resuscitation (CPR)', 0, '2023-09-08 04:10:16'),
(10, 'MEDR', 'Medication Course: Refresher', 0, '2023-09-08 04:10:16'),
(11, 'MEDF', 'Medication Course: Full', 0, '2023-09-08 04:10:16'),
(12, 'MHR', 'Manual Handling: Refresher', 0, '2023-09-08 04:10:16'),
(13, 'MHF', 'Manual Handling: Full', 0, '2023-09-08 04:10:16'),
(14, 'MH4', 'cert 4 in Mental health', 0, '2023-09-08 04:10:16'),
(15, 'DMH', 'diploma in mental health', 0, '2023-09-08 04:10:16'),
(16, 'BSG', 'insulin training - BSG', 0, '2023-09-08 04:10:16'),
(17, 'DCS', 'Diploma in comm services', 0, '2023-09-08 04:10:16');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `document_name`, `document_shortcode`, `document_status`, `document_created_date`) VALUES
(1, 'Date of  Birth', 'dob', 0, '2023-08-27 11:50:16'),
(2, 'Address', 'address', 0, '2023-08-27 11:50:16');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `followup_calls`
--

INSERT INTO `followup_calls` (`flw_id`, `enquiry_id`, `flw_name`, `flw_phone`, `flw_contacted_person`, `flw_contacted_time`, `flw_date`, `flw_remarks`, `flw_comments`, `flw_mode_contact`, `flw_created_date`, `flw_created_by`, `flw_modified_date`, `flw_modifiedby`, `flw_enquiry_status`, `flw_delete_note`) VALUES
(1, 'EQ00002', 'John Kotln', '8309603267', 'asdfsdf', '2023-12-31 23:58:00', '2023-12-31', '[\"1\"]', 'testest', 'asdfas', '2023-09-24 09:39:39', 1, NULL, NULL, 1, 'setetsste'),
(2, 'EQ00003', 'John Kotln', '8309603264', 'test', '2023-12-31 23:59:00', '2023-12-30', '[\"2\",\"3\"]', 'test', 'asdasdf', '2023-09-24 09:40:18', 1, '2023-09-23 22:41:00', 1, 0, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`inv_id`, `inv_auto_id`, `st_unique_id`, `inv_std_name`, `inv_course`, `inv_fee`, `inv_paid`, `inv_due`, `inv_payment_date`, `created_date`, `inv_status`) VALUES
(1, 'INV00001', '082623DSB0001', 'Mike', 1, '5000', '2000', '300', '2023-08-11', '2023-08-26 15:55:39', 0),
(2, 'INV00002', '98798sdf', 'Kiran', 1, '500', '3030', '200', '2023-08-16', '2023-08-27 10:33:31', 0),
(3, 'INV202300003', '2023B10002', 'John Kotln', 1, '5000', '2000', '3000', '2023-08-18', '2023-08-28 02:23:45', 0);

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
(1, 'Masters Degree', 0, '2023-08-23 06:07:08'),
(2, 'Bachelors Degree', 0, '2023-08-23 06:07:08'),
(3, 'MCA', 0, '2023-08-23 06:07:16');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `regular_group_form`
--

INSERT INTO `regular_group_form` (`reg_grp_id`, `reg_grp_names`, `enq_form_id`, `reg_grp_status`, `reg_grp_created_date`) VALUES
(1, 'name1,aesraser', 1, 0, '2023-09-17 02:05:21');

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
  `rpl_exp_docs` tinyint(1) DEFAULT NULL,
  `rpl_exp_prev_qual` tinyint(1) DEFAULT NULL,
  `rpl_exp_qual_name` varchar(255) NOT NULL,
  `rpl_exp` tinyint(1) NOT NULL,
  `rpl_exp_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rpl_enq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rpl_enquries`
--

INSERT INTO `rpl_enquries` (`rpl_enq_id`, `enq_form_id`, `rpl_exp_in`, `rpl_exp_role`, `rpl_exp_years`, `rpl_exp_docs`, `rpl_exp_prev_qual`, `rpl_exp_qual_name`, `rpl_exp`, `rpl_exp_created_date`) VALUES
(1, 6, '4', 'pop', '5 years 12 mnths', 2, 1, 'namess', 1, '2023-09-19 15:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `short_group_form`
--

DROP TABLE IF EXISTS `short_group_form`;
CREATE TABLE IF NOT EXISTS `short_group_form` (
  `sh_grp_id` int NOT NULL AUTO_INCREMENT,
  `enq_form_id` int NOT NULL,
  `sh_org_name` varchar(255) NOT NULL,
  `sh_grp_org_type` tinyint(1) NOT NULL,
  `sh_grp_campus` tinyint(1) NOT NULL,
  `sh_grp_date` date NOT NULL,
  `sh_grp_num_stds` int NOT NULL,
  `sh_grp_ind_exp` tinyint(1) NOT NULL,
  `sh_grp_train_bef` tinyint(1) NOT NULL,
  `sh_grp_con_us` varchar(255) NOT NULL,
  `sh_grp_phone` varchar(255) NOT NULL,
  `sh_grp_name` varchar(255) NOT NULL,
  `sh_grp_email` varchar(255) NOT NULL,
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
  `slot_book_email_link` tinyint NOT NULL,
  PRIMARY KEY (`slot_bk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `slot_book`
--

INSERT INTO `slot_book` (`slot_bk_id`, `enq_form_id`, `slot_bk_datetime`, `slot_bk_purpose`, `slot_bk_on`, `slot_book_by`, `slot_book_email_link`) VALUES
(1, 1, '2023-12-31 17:29:00', 'testset', '2023-12-31 00:00:00', 'testse', 1),
(2, 6, '2023-12-30 18:29:00', 'testset', '2023-12-31 00:00:00', 'testse', 1),
(3, 7, '2023-12-31 18:29:00', 'testset', '2023-12-31 00:00:00', 'testse', 1);

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
(1, 'Friends', 0, '2023-08-23 11:39:15'),
(2, 'Google', 0, '2023-08-23 11:39:15'),
(3, 'Website', 0, '2023-08-23 11:39:19');

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
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`st_at_id`, `st_unique_id`, `st_course_unit`, `st_unit_date`, `st_unit_status`, `st_unit_created_date`) VALUES
(1, '082623DSB0001', 'units9', '2023-09-09', 0, '2023-08-26 15:57:14'),
(2, '082623DSB0001', 'units9', '2023-09-07', 0, '2023-08-26 15:57:14'),
(3, '082623DSB0001', 'units9', '2023-09-07', 0, '2023-08-26 15:57:14'),
(4, '082623DSB0001', 'units7', '2023-08-25', 0, '2023-08-27 04:07:52'),
(5, '082623DSB0001', 'units8', '2023-09-08', 0, '2023-08-27 04:07:52'),
(6, '2023B10003', 'units7', '2023-08-25', 0, '2023-08-27 04:07:52'),
(7, '2023B10002', 'units7', '2023-08-25', 0, '2023-08-27 04:07:52'),
(8, '2023B10002', 'units9', '2023-08-25', 0, '2023-08-27 04:10:27'),
(12, '2023B10002', 'units9', '2023-08-25', 0, '2023-08-27 04:12:11'),
(17, '2023B10002', 'units9', '2023-08-25', 0, '2023-08-27 04:16:10'),
(16, '2023B10002', 'units9', '2023-08-25', 0, '2023-08-27 04:12:44'),
(18, '270823AG0001', 'units9', '2023-08-25', 0, '2023-09-11 08:26:48'),
(19, '270823AG0001', 'units7', '2023-08-25', 0, '2023-09-11 08:26:48'),
(20, '270823AG0001', 'units8', '2023-08-25', 0, '2023-09-11 08:26:48'),
(21, '270823AG0001', 'units2', '2023-08-25', 0, '2023-09-11 08:26:48'),
(22, '270823AG0001', 'units9', '2023-08-22', 0, '2023-09-11 08:26:48'),
(23, '270823DSB0002', 'units9', '2023-08-22', 0, '2023-09-11 08:26:48'),
(24, '270823DSB0002', 'units2', '2023-08-25', 0, '2023-09-11 08:26:48'),
(25, '270823AG0001', 'units9', '2023-08-25', 0, '2023-09-11 08:36:37'),
(26, '270823AG0001', 'units7', '2023-08-25', 0, '2023-09-11 08:36:37'),
(27, '270823AG0001', 'units8', '2023-08-25', 0, '2023-09-11 08:36:37'),
(28, '270823AG0001', 'units2', '2023-08-25', 0, '2023-09-11 08:36:37'),
(29, '270823AG0001', 'units9', '2023-08-22', 0, '2023-09-11 08:36:37'),
(30, '270823DSB0002', 'units9', '2023-08-22', 0, '2023-09-11 08:36:37'),
(31, '270823DSB0002', 'units2', '2023-08-25', 0, '2023-09-11 08:36:37');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_docs`
--

INSERT INTO `student_docs` (`st_doc_id`, `st_unique_id`, `st_doc_names`, `st_doc_status`, `created_date`, `st_modified_date`) VALUES
(1, '082623DSB0001', '[\"includes/uploads/ADHAAR_1693107526480.pdf||dob\"]', 0, '2023-08-27 03:08:04', '2023-08-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student_enquiry`
--

DROP TABLE IF EXISTS `student_enquiry`;
CREATE TABLE IF NOT EXISTS `student_enquiry` (
  `st_id` int NOT NULL AUTO_INCREMENT,
  `st_enquiry_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_member_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_phno` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_course` text COLLATE utf8mb4_general_ci,
  `st_course_type` tinyint(1) NOT NULL DEFAULT '0',
  `st_street_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_suburb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_state` tinyint(1) DEFAULT NULL,
  `st_post_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_visited` tinyint(1) NOT NULL,
  `st_heared` text COLLATE utf8mb4_general_ci NOT NULL,
  `st_hearedby` text COLLATE utf8mb4_general_ci,
  `st_refered` tinyint(1) NOT NULL,
  `st_refer_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `st_refer_alumni` tinyint(1) NOT NULL,
  `st_fee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_remarks` text COLLATE utf8mb4_general_ci,
  `st_shore` tinyint(1) NOT NULL,
  `st_ethnicity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_pref_comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `st_appoint_book` tinyint(1) NOT NULL,
  `st_enquiry_for` tinyint(1) NOT NULL DEFAULT '1',
  `st_visa_status` tinyint(1) NOT NULL,
  `st_visa_condition` tinyint DEFAULT NULL,
  `st_visa_note` text COLLATE utf8mb4_general_ci,
  `st_enquiry_status` tinyint(1) NOT NULL DEFAULT '0',
  `st_delete_note` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_startplan_date` datetime DEFAULT NULL,
  `st_enquiry_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `st_created_by` int NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `st_modified_by` int DEFAULT NULL,
  `st_modified_date` datetime DEFAULT NULL,
  `st_gen_enq_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enquiry`
--

INSERT INTO `student_enquiry` (`st_id`, `st_enquiry_id`, `st_name`, `st_member_name`, `st_surname`, `st_phno`, `st_email`, `st_course`, `st_course_type`, `st_street_details`, `st_suburb`, `st_state`, `st_post_code`, `st_visited`, `st_heared`, `st_hearedby`, `st_refered`, `st_refer_name`, `st_refer_alumni`, `st_fee`, `st_remarks`, `st_shore`, `st_ethnicity`, `st_comments`, `st_pref_comments`, `st_appoint_book`, `st_enquiry_for`, `st_visa_status`, `st_visa_condition`, `st_visa_note`, `st_enquiry_status`, `st_delete_note`, `st_startplan_date`, `st_enquiry_date`, `st_created_by`, `created_date`, `st_modified_by`, `st_modified_date`, `st_gen_enq_type`) VALUES
(1, 'EQ00001', 'names', 'John Kotln', 'test12', '8309603267', 'saikiran.m.v.s.s@gmail.com', '[\"1\",\"2\",\"3\",\"4\",\"17\"]', 3, 'agraharam street', 'bobbili', 4, '535558', 1, '3', NULL, 1, 'asd,artsdf,sgdfgs', 1, '897', '[\"1\",\"2\",\"3\",\"4\",\"12\",\"13\",\"14\"]', 1, 'bobbili', 'asdfasdf', 'asdfsd', 1, 2, 1, 1, '', 0, NULL, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 1, '2023-09-24 05:23:19', 1, '2023-09-24 05:23:19', NULL),
(2, 'EQ00002', 'John Kotln', 'John Kotln', 'surname rest', '8309603267', 'saikiran.m.v.s.s@gmail.com', '[\"2\",\"3\",\"4\"]', 2, 'agraharam street', 'bobbili', 2, '535558', 1, '2', NULL, 2, '', 1, '987', '', 1, 'bobbili', '', '', 2, 1, 1, 1, '', 0, NULL, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 1, '2023-09-24 05:15:02', NULL, NULL, NULL),
(3, 'EQ00003', 'John Kotln', 'John Kotln', 'asdfa', '8309603264', 'saikiran.m.v.s.s@gmail.com', '[\"1\",\"2\",\"3\",\"6\",\"8\"]', 2, 'agraharam street', 'bobbili', 1, '535558', 2, '2', NULL, 2, '', 0, '987987', '[\"2\",\"3\",\"4\",\"5\",\"6\"]', 2, 'bobbili', 'asdf', 'asdf', 2, 1, 1, 1, '', 0, NULL, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 1, '2023-09-24 05:15:12', NULL, NULL, NULL),
(4, 'EQ00004', 'asdasdgsdf', 'John Kotln', 'name test', '8309603987', 'saikiran.m.v.s.s@gmail.com', '[\"3\",\"4\",\"5\",\"6\",\"7\",\"9\"]', 0, 'agraharam street', 'bobbili', 1, '535558', 1, '3', NULL, 2, '', 0, '', NULL, 0, NULL, '', 'asdfsdf', 0, 2, 0, 2, NULL, 0, NULL, '2023-12-31 00:00:00', '2023-09-17 18:39:20', 0, '2023-09-24 05:15:05', NULL, NULL, 1),
(5, 'EQ00005', 'John Kotl', 'John Kotl', 'shane', '8309603298', 'saikiran.m.v.s.s@gmail.com', '[\"2\"]', 0, 'agraharam street', 'bobbili', 4, '535558', 1, '5', NULL, 2, '', 0, '', NULL, 0, NULL, '', 'zvzdv', 0, 1, 0, 2, NULL, 0, NULL, '2023-12-31 00:00:00', '2023-09-17 20:10:57', 0, '2023-09-24 05:15:09', NULL, NULL, 1),
(6, 'EQ00006', 'Jacob Shane', 'Jacob Shane', 'test surya', '8309609879', 'saikiran.m.v.s.s@gmail.com', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"10\"]', 1, 'agraharam street', 'bobbili', 3, '535558', 2, '4', NULL, 2, '', 0, '999', '[\"1\",\"3\",\"4\",\"5\"]', 2, 'test', 'test', 'test ', 1, 1, 1, 1, '', 0, NULL, '2023-12-31 00:00:00', '2023-11-28 00:00:00', 1, '2023-09-24 05:15:08', NULL, NULL, NULL),
(7, 'EQ00007', 'John Kotln', 'John Kotln', 'test sai', '9879879879', 'testsai@gmail.com', '[\"4\"]', 2, 'agraharam street', 'bobbili', 2, '535558', 2, '10', 'teststese', 1, '', 2, '987', '[\"2\"]', 1, 'bobbili', 'atesddfds', '', 1, 1, 1, 1, '', 0, NULL, '2022-11-30 00:00:00', '2023-12-31 00:00:00', 1, '2023-09-24 05:48:09', NULL, NULL, NULL),
(8, 'EQ00008', 'John Kotln', 'John Kotln', 'aets', '8997987987', 'testmike@gmail.com', '[\"1\"]', 0, 'agraharam street', 'bobbili', 2, '535558', 2, 'test', NULL, 1, '', 1, '', NULL, 0, NULL, '', '', 0, 1, 0, NULL, NULL, 0, NULL, '2023-12-31 00:00:00', '2023-09-24 12:02:40', 0, '2023-09-24 06:32:40', NULL, NULL, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enrolment`
--

INSERT INTO `student_enrolment` (`st_enrol_id`, `st_unique_id`, `st_enquiry_id`, `st_qualifications`, `st_enrol_course`, `st_venue`, `st_middle_name`, `st_name`, `st_mobile`, `st_email`, `st_source`, `st_given_name`, `st_enrol_status`, `created_date`) VALUES
(1, '082623DSB0001', '', 2, 2, '2', 'Sheifen', 'Surya', '9876543214', 'test@gmail.com', 2, 'Mike', 0, '2023-08-26 15:47:37'),
(2, '2023B10002', '', 2, 1, '1', 'Kotln', 'Shearry', '8796543215', 'test65@gmail.com', 2, 'John', 0, '2023-08-27 13:33:27');

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
(1, 'ST56F54', 'test1', 'test123@gmail.com', 'test', 1, 0, '2023-08-20 04:36:13', NULL),
(2, '082623DSB0001', 'test2', 'test234@gmail.com', 'test2', 0, 0, '2023-08-20 04:36:13', NULL);

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
(1, 'Adeladie', 0, '2023-08-23 11:38:00'),
(2, 'New Jersey', 0, '2023-08-23 11:38:00'),
(3, 'Australia', 0, '2023-08-23 11:38:04');

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
(1, 'Dependent on subclass 500', 0, '2023-08-23 10:47:23'),
(2, '489 visa', 0, '2023-08-23 10:47:23'),
(3, '491', 0, '2023-08-23 10:47:29'),
(4, 'Visitor’s visa', 0, '2023-09-16 05:52:01'),
(5, 'Permanent resident', 0, '2023-09-16 05:52:01'),
(6, 'Citizen', 0, '2023-09-16 05:52:18'),
(7, 'Other', 0, '2023-09-16 05:52:18');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
