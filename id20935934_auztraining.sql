-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 10, 2023 at 01:23 PM
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
(3, 'AD', 'Certificate III in Individual Support (Ageing & Disability)', 0, '2023-09-08 04:10:16'),
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enquiry_forms`
--

INSERT INTO `enquiry_forms` (`enq_form_id`, `enq_admin_id`, `enq_status`, `enq_created_on`) VALUES
(1, 1, 0, '2023-09-08 10:06:36'),
(2, 1, 0, '2023-09-08 10:07:03'),
(3, 1, 0, '2023-09-08 16:20:23'),
(4, 1, 0, '2023-09-08 16:46:27'),
(5, 1, 0, '2023-09-10 10:44:43');

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
-- Table structure for table `rpl_enquries`
--

DROP TABLE IF EXISTS `rpl_enquries`;
CREATE TABLE IF NOT EXISTS `rpl_enquries` (
  `rpl_enq_id` int NOT NULL AUTO_INCREMENT,
  `enq_form_id` int DEFAULT NULL,
  `rpl_exp_in` varchar(255) DEFAULT NULL,
  `rpl_exp_role` varchar(255) DEFAULT NULL,
  `rpl_exp_years` varchar(10) DEFAULT NULL,
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
(1, 18, '1', 'testset', '20', 1, 1, 'testset', 1, '2023-09-10 13:03:22');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `short_group_form`
--

INSERT INTO `short_group_form` (`sh_grp_id`, `enq_form_id`, `sh_org_name`, `sh_grp_org_type`, `sh_grp_campus`, `sh_grp_date`, `sh_grp_num_stds`, `sh_grp_ind_exp`, `sh_grp_train_bef`, `sh_grp_con_us`, `sh_grp_phone`, `sh_grp_name`, `sh_grp_email`, `sh_grp_status`, `sh_grp_created_date`) VALUES
(1, 21, 'test Org', 1, 1, '0000-00-00', 20, 1, 1, 'test', '6546546544', 'testes', 'teste@gmail.com', 0, '2023-09-10 13:10:54');

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(16, '2023B10002', 'units9', '2023-08-25', 0, '2023-08-27 04:12:44');

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
  `st_surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_phno` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_course` tinyint(1) NOT NULL,
  `st_course_type` tinyint(1) NOT NULL DEFAULT '0',
  `st_street_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_suburb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_post_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_visited` tinyint(1) NOT NULL,
  `st_heared` tinyint(1) NOT NULL,
  `st_refered` tinyint(1) NOT NULL,
  `st_refer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_refer_alumni` tinyint(1) NOT NULL,
  `st_fee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_remarks` tinyint(1) NOT NULL,
  `st_shore` tinyint(1) NOT NULL,
  `st_ethnicity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_appoint_book` tinyint(1) NOT NULL,
  `st_enquiry_for` tinyint(1) NOT NULL DEFAULT '1',
  `st_visa_status` tinyint(1) NOT NULL,
  `st_enquiry_status` tinyint(1) NOT NULL DEFAULT '0',
  `st_startplan_date` datetime DEFAULT NULL,
  `st_enquiry_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `st_created_by` int NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `st_modified_by` int DEFAULT NULL,
  `st_modified_date` datetime DEFAULT NULL,
  `st_gen_enq_id` int DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enquiry`
--

INSERT INTO `student_enquiry` (`st_id`, `st_enquiry_id`, `st_name`, `st_surname`, `st_phno`, `st_email`, `st_course`, `st_course_type`, `st_street_details`, `st_suburb`, `st_state`, `st_post_code`, `st_visited`, `st_heared`, `st_refered`, `st_refer_name`, `st_refer_alumni`, `st_fee`, `st_remarks`, `st_shore`, `st_ethnicity`, `st_comments`, `st_appoint_book`, `st_enquiry_for`, `st_visa_status`, `st_enquiry_status`, `st_startplan_date`, `st_enquiry_date`, `st_created_by`, `created_date`, `st_modified_by`, `st_modified_date`, `st_gen_enq_id`) VALUES
(1, 'EQ00001', 'TEst First', 'Test Surname', '9876549877', 'Test@gmail.com', 1, 1, 'TESTS Street', 'Test Suburb', 'TEST State', '987654', 1, 1, 1, 'TEst His', 1, '654', 1, 1, '', 'TESt Comment', 1, 1, 1, 0, '2023-09-09 00:00:00', '2023-09-08 09:22:50', 0, '2023-09-08 03:52:50', 0, '2023-09-08 09:22:50', NULL),
(2, 'EQ00002', 'first name Test', 'Surname TEst', '9876544987', 'TESt@gmail.com', 1, 1, 'TEst Street', 'Test sub', 'Test test state', '987654', 1, 1, 1, 'TEst his name', 2, '9674', 1, 2, '', 'test comment', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-08 09:24:39', 0, '2023-09-08 03:54:39', 0, '2023-09-08 09:24:39', NULL),
(3, 'EQ00003', 'Test name', 'Test Surname', '9876549877', 'test@gmail.com', 3, 1, 'Test Street', 'Test Surb', 'Test State', '654987', 2, 2, 1, 'test', 1, '654654', 0, 1, 'test', '', 1, 1, 2, 0, '0000-00-00 00:00:00', '2023-09-08 11:27:07', 1, '2023-09-08 05:57:07', NULL, NULL, NULL),
(4, 'EQ00004', 'Test First', 'Test Surname', '9876549877', 'saisatya51@gmail.com', 2, 1, 'Trest Street', 'Test Sub', 'Test State', '987654', 1, 1, 1, 'test', 1, '654', 1, 1, 'TEst ethin', 'Test Comment', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-08 13:58:27', 1, '2023-09-08 08:28:27', NULL, NULL, NULL),
(5, 'EQ00005', 'Test First', 'Test Surname', '9876549877', 'saisatya51@gmail.com', 1, 1, 'Test Street', 'Test Suburb', 'Test State', '987654', 1, 1, 1, 'Test Her Name', 1, '654654', 1, 1, 'Test Ethinincvity', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-08 14:02:47', 1, '2023-09-08 08:32:47', NULL, NULL, NULL),
(6, 'EQ00006', 'Test First', 'Test Surname', '9876549877', 'saisatya51@gmail.com', 1, 1, 'Test Street', 'Test Sub', 'Test State', '987654', 1, 1, 1, 'Test Her test', 1, '684', 1, 1, 'Test Ethinicility', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-08 14:37:09', 1, '2023-09-08 09:07:09', NULL, NULL, NULL),
(7, 'EQ00007', 'first', 'surname', '8309603262', 'saisatya51@gmail.com', 1, 0, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 1, 1, 1, 'his name', 1, '', 0, 0, NULL, '', 0, 1, 0, 0, '2023-12-31 00:00:00', '2023-09-08 22:29:20', 0, '2023-09-08 16:59:42', NULL, NULL, NULL),
(8, 'EQ00008', 'first1', 'surnaeme1', '8309603262', 'saisatya51@gmail.com', 1, 0, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 4, 1, 1, 'his name', 1, '', 0, 0, NULL, '', 0, 1, 0, 0, '2023-12-31 00:00:00', '2023-09-08 22:30:39', 0, '2023-09-08 17:00:39', NULL, NULL, NULL),
(9, 'EQ00009', 'first2', 'surname2', '8309603262', 'saisatya51@gmail.com', 1, 0, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 1, 1, 1, 'his name', 1, '', 0, 0, NULL, '', 0, 1, 0, 0, '2023-12-31 00:00:00', '2023-09-08 22:33:00', 0, '2023-09-08 17:03:00', NULL, NULL, NULL),
(10, 'EQ00010', 'test', 'test', '6546546456', 'saiprakash359@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 2, 1, 1, 'test', 1, '20', 1, 1, 'test', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 16:28:59', 1, '2023-09-10 10:59:00', NULL, NULL, NULL),
(11, 'EQ00011', 'test', 'test', '5465465465', 'saiprakash359@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 2, 1, 2, '', 0, '2000', 1, 1, 'bobbili', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 16:56:34', 1, '2023-09-10 11:26:35', NULL, NULL, NULL),
(12, 'EQ00012', 'tes', 'test', '8309603262', 'test@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 1, 1, 2, '', 0, '20', 1, 1, 'bobbili', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 17:03:04', 1, '2023-09-10 11:33:04', NULL, NULL, NULL),
(13, 'EQ00013', 'test', 'test', '8309603262', 'test@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 1, 1, 2, '', 0, '20', 1, 1, 'bobbili', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 17:05:16', 1, '2023-09-10 11:35:16', NULL, NULL, NULL),
(14, 'EQ00014', 'John Kotln', 'tests', '8309603262', 'testse@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 2, 1, 1, 'restset', 1, '20', 1, 1, 'testes', '', 1, 1, 1, 0, '2023-12-30 00:00:00', '2023-09-10 18:20:20', 1, '2023-09-10 12:50:20', NULL, NULL, NULL),
(15, 'EQ00015', 'John Kotln', 'test', '8309603262', 'test@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 2, 1, 1, 'test', 1, '32', 1, 1, 'gsg', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 18:27:05', 1, '2023-09-10 12:57:05', NULL, NULL, NULL),
(16, 'EQ00016', 'John Kotln', 'test', '8309603262', 'tetts@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 1, 1, 1, 'test', 2, '20', 1, 1, 'bobbili', 'tst', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 18:29:26', 1, '2023-09-10 12:59:27', NULL, NULL, NULL),
(17, 'EQ00017', 'John Kotln', 'testsetse', '8309603262', 'test@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 3, 1, 1, 'teststset', 1, '20', 0, 1, 'bobbili', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 18:31:37', 1, '2023-09-10 13:01:37', NULL, NULL, NULL),
(18, 'EQ00018', 'John Kotln', 'test', '8309603262', 'test@gmail.com', 1, 1, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 4, 1, 1, 'testset', 1, '20', 0, 1, 'test', '', 1, 1, 2, 0, '2023-12-31 00:00:00', '2023-09-10 18:33:18', 1, '2023-09-10 13:03:18', NULL, NULL, NULL),
(19, 'EQ00019', 'tsddsdfsf', 'testset', '8309603262', 'testets@gmail.com', 1, 5, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 2, 1, 2, '', 0, '20', 0, 1, 'tsetse', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 18:34:57', 1, '2023-09-10 13:04:57', NULL, NULL, NULL),
(20, 'EQ00020', 'Prathip Kumar', 'setset', '8309603262', 'check@gmail.com', 1, 5, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 1, 1, 2, '', 0, '52', 0, 1, 'bobbili', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 18:36:33', 1, '2023-09-10 13:06:33', NULL, NULL, NULL),
(21, 'EQ00021', 'John Kotln', 'testse', '8309603262', 'test@gmail.com', 1, 5, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 1, 1, 2, '', 0, '20', 0, 1, 'bobbili', '', 1, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 18:40:51', 1, '2023-09-10 13:10:51', NULL, NULL, NULL),
(22, 'EQ00022', 'Mike Sheifen', 'testset', '8309603262', 'testset@gmail.com', 2, 3, 'agraharam street', 'bobbili', 'andhra pradesh', '535558', 1, 1, 2, '', 0, '2000', 0, 1, 'tste', '', 0, 1, 1, 0, '2023-12-31 00:00:00', '2023-09-10 18:44:06', 1, '2023-09-10 13:14:06', NULL, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visa_statuses`
--

INSERT INTO `visa_statuses` (`visa_id`, `visa_status_name`, `visa_state_status`, `created_date`) VALUES
(1, 'Pending', 0, '2023-08-23 10:47:23'),
(2, 'Approved', 0, '2023-08-23 10:47:23'),
(3, 'Declined', 0, '2023-08-23 10:47:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
