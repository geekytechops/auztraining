-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2023 at 04:20 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auztraining`
--

-- --------------------------------------------------------

--
-- Table structure for table `counseling_details`
--

CREATE TABLE `counseling_details` (
  `counsil_id` int(11) NOT NULL,
  `st_enquiry_id` varchar(255) DEFAULT NULL,
  `counsil_mem_name` varchar(255) DEFAULT NULL,
  `counsil_vaccine_status` tinyint(1) DEFAULT NULL,
  `counsil_job_nature` varchar(255) DEFAULT NULL,
  `counsil_module_result` varchar(100) DEFAULT NULL,
  `counsil_timing` timestamp NULL DEFAULT NULL,
  `counsil_end_time` timestamp NULL DEFAULT NULL,
  `counsil_pref_comments` text DEFAULT NULL,
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
  `counsil_remarks` text DEFAULT NULL,
  `counsil_created_date` datetime DEFAULT current_timestamp(),
  `counsil_createdby` int(11) DEFAULT NULL,
  `counsil_modified_date` date DEFAULT NULL,
  `counsil_modified_by` int(11) DEFAULT NULL,
  `counsil_delete_note` varchar(255) DEFAULT NULL,
  `counsil_enquiry_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `counseling_details`
--

INSERT INTO `counseling_details` (`counsil_id`, `st_enquiry_id`, `counsil_mem_name`, `counsil_vaccine_status`, `counsil_job_nature`, `counsil_module_result`, `counsil_timing`, `counsil_end_time`, `counsil_pref_comments`, `counsil_eng_rate`, `counsil_migration_test`, `counsil_overall_result`, `counsil_course`, `counsil_university`, `counsil_qualification`, `counsil_type`, `counsil_aus_stay_time`, `counsil_visa_condition`, `counsil_education`, `counsil_aus_study_status`, `counsil_work_status`, `counsil_remarks`, `counsil_created_date`, `counsil_createdby`, `counsil_modified_date`, `counsil_modified_by`, `counsil_delete_note`, `counsil_enquiry_status`) VALUES
(1, 'EQ00002', 'surya', 1, '', '', '2023-10-02 14:30:00', '2023-10-02 16:30:00', 'nothing', '2', 2, '', '', '', 'nothing', 1, '2 years', 1, 'nothing', 2, 2, '[\"1\"]', '2023-10-01 20:02:58', 1, '2023-10-10', 1, NULL, 0),
(2, 'EQ00004', 'test name', 2, '', '', '2023-09-08 18:30:00', '2023-09-08 20:30:00', '', '2', 2, '', '', '', 'test adge', 1, '2 years', 1, 'name edic', 2, 2, '', '2023-10-02 19:58:16', 1, '2023-10-10', 1, NULL, 0),
(3, 'EQ00003', 'fdvfcbf', 1, 'vfdgdf', ' cbfbf', '2023-10-06 00:19:00', '2023-10-06 01:41:00', 'vvd', 'regrgr', 1, ' fcbcbc', ' vbvgbg', 'bfff', 'bfbgf', 1, 'bcfbg', 1, 'cbvc b', 1, 1, '[\"1\",\"2\",\"3\"]', '2023-10-03 12:50:42', 1, '2023-10-07', 1, NULL, 0),
(4, 'EQ00010', 'Krishna', 1, 'Yes', '5.2,6.2', '2023-10-05 13:00:00', '2023-10-05 14:30:00', 'Fast Track', '8', 1, '8.5', 'Aged Care', 'OXFORD', '1', 1, '1 Year', 2, 'BTECH', 1, 2, '[\"2\",\"3\",\"13\"]', '2023-10-04 11:01:47', 1, '2023-10-10', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_sname` varchar(255) NOT NULL,
  `course_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `document_shortcode` varchar(255) NOT NULL,
  `document_status` tinyint(1) NOT NULL DEFAULT 0,
  `document_created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `enquiry_forms` (
  `enq_form_id` int(11) NOT NULL,
  `enq_admin_id` int(11) DEFAULT NULL,
  `enq_status` tinyint(1) NOT NULL,
  `enq_created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `followup_calls`
--

CREATE TABLE `followup_calls` (
  `flw_id` int(11) NOT NULL,
  `enquiry_id` varchar(255) DEFAULT NULL,
  `flw_name` varchar(255) DEFAULT NULL,
  `flw_phone` varchar(100) DEFAULT NULL,
  `flw_contacted_person` varchar(255) DEFAULT NULL,
  `flw_contacted_time` datetime DEFAULT NULL,
  `flw_date` date DEFAULT NULL,
  `flw_progress_state` varchar(255) DEFAULT NULL,
  `flw_remarks` text NOT NULL,
  `flw_comments` text NOT NULL,
  `flw_mode_contact` varchar(100) DEFAULT NULL,
  `flw_created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `flw_created_by` int(11) DEFAULT NULL,
  `flw_modified_date` timestamp NULL DEFAULT NULL,
  `flw_modifiedby` int(11) DEFAULT NULL,
  `flw_enquiry_status` tinyint(4) NOT NULL DEFAULT 0,
  `flw_delete_note` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followup_calls`
--

INSERT INTO `followup_calls` (`flw_id`, `enquiry_id`, `flw_name`, `flw_phone`, `flw_contacted_person`, `flw_contacted_time`, `flw_date`, `flw_progress_state`, `flw_remarks`, `flw_comments`, `flw_mode_contact`, `flw_created_date`, `flw_created_by`, `flw_modified_date`, `flw_modifiedby`, `flw_enquiry_status`, `flw_delete_note`) VALUES
(1, 'EQ00002', 'Jacob Shane', '8309603262', 'test person name', '2023-10-19 20:00:00', '2023-10-12', '', '', 'test', 'phone', '2023-10-01 20:01:28', 1, '2023-10-01 09:01:46', 1, 0, NULL),
(2, 'EQ00008', 'jaswanth kumar', '7306468658', 'regrg', '2023-10-11 22:19:00', '2023-10-05', NULL, '[\"1\",\"2\"]', 'vfbf', 'vfdf', '2023-10-03 12:49:46', 1, NULL, NULL, 0, NULL),
(3, 'EQ00010', 'Prathip', '9302265123', 'Sumanth', '2023-10-05 09:00:00', '2023-10-05', NULL, '[\"1\",\"14\"]', '', 'Phone', '2023-10-04 10:58:29', 1, NULL, NULL, 0, NULL),
(4, 'EQ00008', 'jaswanth kumar', '7306468658', 'Parry', '2023-10-05 15:38:00', '2023-10-05', NULL, '[\"1\",\"5\"]', '', 'phone', '2023-10-05 01:09:17', 1, NULL, NULL, 0, NULL),
(5, 'EQ00012', 'krishna', '0411439235', 'Shambhu', '2023-10-12 11:00:00', '2023-10-12', NULL, '[\"1\"]', 'He was busy doing his Uni work. Asked us to call him back in 2 hours time', '3cx', '2023-10-12 06:12:01', 1, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `inv_id` int(11) NOT NULL,
  `inv_auto_id` varchar(255) NOT NULL,
  `st_unique_id` varchar(255) NOT NULL,
  `inv_std_name` varchar(255) NOT NULL,
  `inv_course` tinyint(1) NOT NULL,
  `inv_fee` varchar(255) NOT NULL,
  `inv_paid` varchar(255) NOT NULL,
  `inv_due` varchar(255) NOT NULL,
  `inv_payment_date` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `inv_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `qualifications` (
  `qualification_id` int(11) NOT NULL,
  `qualification_name` varchar(255) NOT NULL,
  `qualification_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `regular_group_form` (
  `reg_grp_id` int(11) NOT NULL,
  `reg_grp_names` text DEFAULT NULL,
  `enq_form_id` int(11) DEFAULT NULL,
  `reg_grp_status` tinyint(4) NOT NULL DEFAULT 0,
  `reg_grp_created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rpl_enquries`
--

CREATE TABLE `rpl_enquries` (
  `rpl_enq_id` int(11) NOT NULL,
  `enq_form_id` int(11) DEFAULT NULL,
  `rpl_exp_in` varchar(255) DEFAULT NULL,
  `rpl_exp_role` varchar(255) DEFAULT NULL,
  `rpl_exp_years` varchar(255) DEFAULT NULL,
  `rpl_exp_docs` varchar(1) DEFAULT '0',
  `rpl_exp_prev_qual` varchar(1) DEFAULT '0',
  `rpl_exp_qual_name` varchar(255) NOT NULL,
  `rpl_exp` varchar(1) NOT NULL DEFAULT '0',
  `rpl_exp_created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rpl_enquries`
--

INSERT INTO `rpl_enquries` (`rpl_enq_id`, `enq_form_id`, `rpl_exp_in`, `rpl_exp_role`, `rpl_exp_years`, `rpl_exp_docs`, `rpl_exp_prev_qual`, `rpl_exp_qual_name`, `rpl_exp`, `rpl_exp_created_date`) VALUES
(1, 2, '2', 'test rolls', '5 months ', '1', '2', '', '1', '2023-10-01 14:26:04'),
(2, 3, '2', 'roles ntest', '5 months ', '1', '2', '', '1', '2023-10-01 14:29:22'),
(3, 5, '', '', '', '', '', '', '2', '2023-10-02 15:28:50'),
(4, 8, '1', 'test', '10', '1', '1', 'ffgngf', '1', '2023-10-03 16:49:07'),
(5, 10, '1', 'Senior Helper ', '2Years 5 Months', '1', '1', 'Post Diploma in Hospitality ', '1', '2023-10-04 14:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `short_group_form`
--

CREATE TABLE `short_group_form` (
  `sh_grp_id` int(11) NOT NULL,
  `enq_form_id` int(11) DEFAULT NULL,
  `sh_org_name` varchar(255) DEFAULT NULL,
  `sh_grp_org_type` tinyint(1) DEFAULT NULL,
  `sh_grp_campus` tinyint(1) DEFAULT NULL,
  `sh_grp_date` date DEFAULT NULL,
  `sh_grp_num_stds` int(11) DEFAULT NULL,
  `sh_grp_ind_exp` tinyint(1) DEFAULT NULL,
  `sh_grp_train_bef` tinyint(1) DEFAULT NULL,
  `sh_grp_con_us` varchar(255) DEFAULT NULL,
  `sh_grp_phone` varchar(255) DEFAULT NULL,
  `sh_grp_name` varchar(255) DEFAULT NULL,
  `sh_grp_email` varchar(255) DEFAULT NULL,
  `sh_grp_status` tinyint(1) NOT NULL DEFAULT 0,
  `sh_grp_created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `short_group_form`
--

INSERT INTO `short_group_form` (`sh_grp_id`, `enq_form_id`, `sh_org_name`, `sh_grp_org_type`, `sh_grp_campus`, `sh_grp_date`, `sh_grp_num_stds`, `sh_grp_ind_exp`, `sh_grp_train_bef`, `sh_grp_con_us`, `sh_grp_phone`, `sh_grp_name`, `sh_grp_email`, `sh_grp_status`, `sh_grp_created_date`) VALUES
(1, 1, '', 0, 0, '0000-00-00', 0, 0, 0, '', '', '', '', 0, '2023-10-01 14:24:25'),
(2, 6, '', 0, 0, '0000-00-00', 0, 0, 0, 'phone call', '', '', '', 0, '2023-10-01 14:52:01'),
(3, 11, 'MAXWELLL', 1, 2, '2023-11-19', 7, 1, 1, 'PHONE', '0466666677', 'JULIA', '', 0, '2023-10-12 09:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `slot_book`
--

CREATE TABLE `slot_book` (
  `slot_bk_id` int(11) NOT NULL,
  `enq_form_id` int(11) NOT NULL,
  `slot_bk_datetime` timestamp NULL DEFAULT NULL,
  `slot_bk_purpose` varchar(255) NOT NULL,
  `slot_bk_on` datetime NOT NULL DEFAULT current_timestamp(),
  `slot_book_by` varchar(150) NOT NULL,
  `slot_bk_attend` tinyint(4) NOT NULL DEFAULT 1,
  `slot_book_email_link` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slot_book`
--

INSERT INTO `slot_book` (`slot_bk_id`, `enq_form_id`, `slot_bk_datetime`, `slot_bk_purpose`, `slot_bk_on`, `slot_book_by`, `slot_bk_attend`, `slot_book_email_link`) VALUES
(1, 4, '2023-10-12 14:36:00', 'visiting', '2023-09-14 00:00:00', 'surya', 1, 1),
(2, 8, '2023-10-06 02:18:00', 'vcvc', '2023-10-19 00:00:00', 'vsdfd', 1, 1),
(3, 10, '2023-10-05 14:30:00', 'Inqury', '2023-10-05 00:00:00', 'Sumanth', 1, 1),
(4, 1, '2023-10-06 00:23:00', 'Inqury', '2023-10-05 00:00:00', 'Prathip', 1, 1),
(5, 11, '2023-10-13 08:25:00', 'counseling', '2023-10-12 00:00:00', 'raj', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE `source` (
  `source_id` int(11) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `source_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `student_attendance` (
  `st_at_id` int(11) NOT NULL,
  `st_unique_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `st_course_unit` varchar(255) NOT NULL,
  `st_unit_date` date NOT NULL,
  `st_unit_status` tinyint(1) NOT NULL DEFAULT 0,
  `st_unit_created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `student_docs` (
  `st_doc_id` int(11) NOT NULL,
  `st_unique_id` varchar(255) NOT NULL,
  `st_doc_names` text NOT NULL,
  `st_doc_status` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `st_modified_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_docs`
--

INSERT INTO `student_docs` (`st_doc_id`, `st_unique_id`, `st_doc_names`, `st_doc_status`, `created_date`, `st_modified_date`) VALUES
(1, '082623DSB0001', '[\"includes/uploads/ADHAAR_1693107526480.pdf||dob\"]', 0, '2023-08-27 03:08:04', '2023-08-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student_enquiry`
--

CREATE TABLE `student_enquiry` (
  `st_id` int(11) NOT NULL,
  `st_enquiry_id` varchar(255) DEFAULT NULL,
  `st_name` varchar(255) NOT NULL,
  `st_member_name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `st_surname` varchar(255) NOT NULL,
  `st_phno` varchar(10) NOT NULL,
  `st_email` varchar(100) NOT NULL,
  `st_course` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `st_course_type` tinyint(1) NOT NULL DEFAULT 0,
  `st_street_details` varchar(255) NOT NULL,
  `st_suburb` varchar(255) NOT NULL,
  `st_state` varchar(1) CHARACTER SET utf8mb4 DEFAULT '0',
  `st_post_code` varchar(10) NOT NULL,
  `st_visited` tinyint(1) NOT NULL,
  `st_heared` text CHARACTER SET utf8mb4 NOT NULL,
  `st_hearedby` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `st_refered` tinyint(1) NOT NULL,
  `st_refer_name` text DEFAULT NULL,
  `st_refer_alumni` tinyint(1) NOT NULL,
  `st_fee` varchar(255) NOT NULL,
  `st_remarks` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `st_shore` tinyint(1) NOT NULL,
  `st_ethnicity` varchar(255) DEFAULT NULL,
  `st_comments` text NOT NULL,
  `st_pref_comments` text DEFAULT NULL,
  `st_appoint_book` tinyint(1) NOT NULL,
  `st_enquiry_for` tinyint(1) NOT NULL DEFAULT 1,
  `st_visa_status` tinyint(1) DEFAULT 0,
  `st_visa_condition` tinyint(4) DEFAULT 1,
  `st_visa_note` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `st_enquiry_status` tinyint(1) NOT NULL DEFAULT 0,
  `st_delete_note` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `st_startplan_date` datetime DEFAULT NULL,
  `st_enquiry_date` datetime NOT NULL DEFAULT current_timestamp(),
  `st_created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `st_modified_by` int(11) DEFAULT NULL,
  `st_modified_date` datetime DEFAULT NULL,
  `st_gen_enq_type` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_enquiry`
--

INSERT INTO `student_enquiry` (`st_id`, `st_enquiry_id`, `st_name`, `st_member_name`, `st_surname`, `st_phno`, `st_email`, `st_course`, `st_course_type`, `st_street_details`, `st_suburb`, `st_state`, `st_post_code`, `st_visited`, `st_heared`, `st_hearedby`, `st_refered`, `st_refer_name`, `st_refer_alumni`, `st_fee`, `st_remarks`, `st_shore`, `st_ethnicity`, `st_comments`, `st_pref_comments`, `st_appoint_book`, `st_enquiry_for`, `st_visa_status`, `st_visa_condition`, `st_visa_note`, `st_enquiry_status`, `st_delete_note`, `st_startplan_date`, `st_enquiry_date`, `st_created_by`, `created_date`, `st_modified_by`, `st_modified_date`, `st_gen_enq_type`) VALUES
(1, 'EQ00001', 'test surya', 'John Kotln', 'mangs', '8309603262', 'saikiran.m.v.s.s@gmail.com', '[\"14\"]', 4, 'street test', 'subrub streets', '3', '535552', 2, '[\"9\"]', 'friends', 1, 'test1,tests2test3', 1, 'this  is discusseed 3000', '', 1, '', '', '', 1, 2, 0, 1, '', 0, NULL, '2023-10-20 00:00:00', '2023-10-14 00:00:00', 1, '2023-10-04 14:54:11', 1, '2023-10-04 14:54:11', NULL),
(2, 'EQ00002', 'Jacob Shane', 'Jacob Shane', 'test surnamsdf', '8309603262', 'saisatya51@gmail.com', '[\"7\"]', 1, 'stretasdf asdfa', 'test surbuasd ', '4', '538779', 1, '[\"3\"]', '', 2, '', 0, '988', '', 0, '', '', '', 0, 1, 0, 1, '', 0, NULL, '0000-00-00 00:00:00', '2023-10-05 00:00:00', 1, '2023-10-01 14:25:57', NULL, NULL, NULL),
(3, 'EQ00003', 'Mike Sheifen', 'Mike Sheifen', 'test surnamess s', '8309603262', 'saisatya51@gmail.com', '[\"9\"]', 1, 'test setset', 'test setset', '1', '535558', 1, '[\"2\"]', '', 2, '', 2, '7986', '', 1, '', '', '', 0, 1, 0, 1, '', 0, NULL, '0000-00-00 00:00:00', '2023-10-12 00:00:00', 1, '2023-10-03 15:06:24', 1, '2023-10-03 15:06:24', NULL),
(4, 'EQ00004', 'test surya', 'test surya', 'surnam test', '8309603263', 'testsai@gmail.com', '[\"6\"]', 1, 'test street', 'sub rubs ', '2', '598798', 1, '[\"3\"]', '', 2, '', 0, '987', '[\"5\",\"6\"]', 1, 'indian', 'no comments', 'test nothinh', 1, 1, 0, 1, '', 0, NULL, '0000-00-00 00:00:00', '2023-10-05 00:00:00', 1, '2023-10-01 14:44:06', NULL, NULL, NULL),
(5, 'EQ00005', 'test surya', 'test surya', 'test surasd', '8309603265', 'testsurya@gmail.com', '[\"2\",\"3\",\"4\"]', 1, 'street es', 'sub asdfa', '2', '535558', 1, '[\"2\"]', '', 2, '', 2, '98798', '[\"3\",\"4\"]', 2, 'test indian', '', '', 0, 1, 0, 1, '', 0, NULL, '0000-00-00 00:00:00', '2023-10-12 00:00:00', 1, '2023-10-02 15:28:50', 1, '2023-10-02 15:28:50', NULL),
(6, 'EQ00006', 'test suryas', 'test suryas', 'tes adasd', '8309603262', 'saikira@gmail.com', '[\"4\",\"5\"]', 5, 'strsf you', 'sub jjs', '1', '549897', 1, '[\"4\"]', '', 2, '', 2, 'ads 879879', '', 2, '', '', '', 0, 1, 0, 1, '', 0, NULL, '0000-00-00 00:00:00', '2023-10-20 00:00:00', 1, '2023-10-02 17:20:12', 1, '2023-10-02 17:20:12', NULL),
(7, 'EQ00007', 'test surya', 'test surya', 'asdf', '8309607987', 'asdfa@gmail.com', '[\"4\"]', 2, 'agraharam street', 'bobbili', '0', '535558', 2, '[\"3\"]', '', 2, '', 0, 'asdf', '', 0, '', '', '', 0, 1, 0, 1, '', 0, NULL, '0000-00-00 00:00:00', '2023-12-31 00:00:00', 1, '2023-10-02 15:28:32', NULL, NULL, NULL),
(8, 'EQ00008', 'jaswanth kumar', 'jaswanth kumar', 'kottugummada', '7306468658', 'jaswanthkumar431@gmail.com', '[\"1\",\"2\",\"3\",\"4\"]', 1, 'cdsfs', 'bfbfd', '1', '123456', 1, '[\"1\",\"3\",\"4\",\"8\"]', '', 1, 'bfdbfbf', 1, '455', '[\"1\",\"2\",\"3\",\"4\"]', 1, 'bfdbfdb', ' vcbb', 'bfbfd', 1, 1, 1, 1, '', 0, NULL, '2023-10-05 00:00:00', '2023-10-04 00:00:00', 1, '2023-10-03 16:49:06', NULL, NULL, NULL),
(9, 'EQ00009', 'jaswanth kumar', 'jaswanth kumar', 'kottugummada', '7306468657', 'jaswanthkumar431@gmail.com', '[\"1\"]', 0, 'fvfdb', 'vfdb', '1', '134556', 1, '[\"1\",\"2\"]', '', 1, 'cbcb', 2, '', NULL, 0, NULL, '', ' fv', 0, 1, 0, 1, NULL, 0, NULL, '2023-10-04 00:00:00', '2023-10-03 13:02:39', 0, '2023-10-03 17:02:39', NULL, NULL, 1),
(10, 'EQ00010', 'Prathip', 'Prathip', 'Potnuru', '9302265123', 'ppk.eee@gmail.com', '[\"1\",\"7\",\"17\"]', 1, 'Matam', 'Narasannapeta', '2', '532421', 1, '[\"1\",\"4\",\"9\"]', 'Testing', 1, 'Kiran, Krishna', 1, '1500', '[\"1\",\"9\",\"13\",\"14\"]', 2, 'Indian', 'Test', 'TEST_2', 1, 1, 2, 1, '', 0, NULL, '2023-10-10 00:00:00', '2023-10-04 00:00:00', 1, '2023-10-04 14:44:49', NULL, NULL, NULL),
(11, 'EQ00011', 'bindu', 'bindu', 'jami', '0466978278', 'bindumadhavi.kottakota@gmail.com', '[\"1\"]', 2, '65A Fosters road', 'greenacres', '7', '5086', 1, '[\"1\",\"2\",\"4\"]', '', 1, 'krishna', 1, '1000', '[\"1\",\"4\",\"6\",\"7\"]', 1, 'middle east', 'she is a very tough lady', '', 1, 1, 2, 1, '', 0, NULL, '2023-10-16 00:00:00', '1977-05-30 00:00:00', 1, '2023-10-12 09:44:21', 1, '2023-10-12 09:44:21', NULL),
(12, 'EQ00012', 'krishna', 'krishna', 'jami', '0411439235', 'JAMI.KRISHNAKUMAR@GMAIL.COM', '[\"7\"]', 2, '', '', '0', '5086', 2, '[\"1\"]', '', 2, '', 0, '1', '', 0, '', '', '', 0, 1, 0, 1, '', 0, NULL, '2023-10-13 00:00:00', '2023-10-12 00:00:00', 1, '2023-10-12 10:01:03', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_enrolment`
--

CREATE TABLE `student_enrolment` (
  `st_enrol_id` int(11) NOT NULL,
  `st_unique_id` varchar(255) DEFAULT NULL,
  `st_enquiry_id` varchar(255) DEFAULT NULL,
  `st_qualifications` varchar(1) DEFAULT NULL,
  `st_enrol_course` text DEFAULT NULL,
  `st_venue` varchar(15) NOT NULL,
  `st_middle_name` varchar(255) NOT NULL,
  `st_name` varchar(255) NOT NULL,
  `st_mobile` varchar(255) NOT NULL,
  `st_email` varchar(255) NOT NULL,
  `st_source` varchar(1) DEFAULT NULL,
  `st_given_name` varchar(255) NOT NULL,
  `st_enrol_status` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_enrolments`
--

CREATE TABLE `student_enrolments` (
  `st_enrol_id` int(11) NOT NULL,
  `st_unique_id` varchar(255) DEFAULT NULL,
  `st_enquiry_id` varchar(255) DEFAULT NULL,
  `st_rto_name` varchar(255) DEFAULT NULL,
  `st_courses` text DEFAULT NULL,
  `st_branch` varchar(255) DEFAULT NULL,
  `st_photo` varchar(255) DEFAULT NULL,
  `st_given_name` varchar(255) DEFAULT NULL,
  `st_surname` varchar(255) DEFAULT NULL,
  `st_dob` date DEFAULT NULL,
  `st_country_birth` varchar(255) DEFAULT NULL,
  `st_street` varchar(255) DEFAULT NULL,
  `st_suburb` varchar(255) DEFAULT NULL,
  `st_state` varchar(255) DEFAULT NULL,
  `st_post_code` varchar(255) DEFAULT NULL,
  `st_tel_num` varchar(255) DEFAULT NULL,
  `st_email` varchar(255) DEFAULT NULL,
  `st_mobile` varchar(255) DEFAULT NULL,
  `st_emerg_name` varchar(255) DEFAULT NULL,
  `st_emerg_relation` varchar(255) DEFAULT NULL,
  `st_emerg_mobile` varchar(255) DEFAULT NULL,
  `st_emerg_agree` varchar(1) DEFAULT NULL,
  `st_usi` varchar(255) DEFAULT NULL,
  `st_emp_status` varchar(1) DEFAULT NULL,
  `st_self_status` varchar(1) DEFAULT NULL,
  `st_citizenship` varchar(1) DEFAULT NULL,
  `st_gender` varchar(1) DEFAULT NULL,
  `st_credit_transfer` varchar(1) DEFAULT NULL,
  `st_highest_school` varchar(1) DEFAULT NULL,
  `st_secondary_school` varchar(1) DEFAULT NULL,
  `st_born_country` varchar(1) DEFAULT NULL,
  `st_born_country_other` varchar(255) DEFAULT NULL,
  `st_origin` varchar(1) DEFAULT NULL,
  `st_lan_spoken` varchar(1) DEFAULT NULL,
  `st_lan_spoken_other` varchar(255) DEFAULT NULL,
  `st_disability` varchar(1) DEFAULT NULL,
  `st_disability_type` text DEFAULT NULL,
  `st_disability_type_other` varchar(255) DEFAULT NULL,
  `st_study_reason` varchar(1) DEFAULT NULL,
  `st_study_reason_other` varchar(255) DEFAULT NULL,
  `st_qual_1` varchar(1) DEFAULT NULL,
  `st_qual_2` varchar(1) DEFAULT NULL,
  `st_qual_3` varchar(1) DEFAULT NULL,
  `st_qual_4` varchar(1) DEFAULT NULL,
  `st_qual_5` varchar(1) DEFAULT NULL,
  `st_qual_6` varchar(1) DEFAULT NULL,
  `st_qual_7` varchar(1) DEFAULT NULL,
  `st_qual_8` varchar(1) DEFAULT NULL,
  `st_qual_9` varchar(1) DEFAULT NULL,
  `st_qual_10` varchar(1) DEFAULT NULL,
  `st_qual_8_other` varchar(255) DEFAULT NULL,
  `st_qual_9_other` date DEFAULT NULL,
  `st_qual_10_other` varchar(255) DEFAULT NULL,
  `st_status` tinyint(1) DEFAULT 0,
  `st_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `st_created_by` int(11) DEFAULT NULL,
  `st_modified_date` date DEFAULT NULL,
  `st_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_enrolments`
--

INSERT INTO `student_enrolments` (`st_enrol_id`, `st_unique_id`, `st_enquiry_id`, `st_rto_name`, `st_courses`, `st_branch`, `st_photo`, `st_given_name`, `st_surname`, `st_dob`, `st_country_birth`, `st_street`, `st_suburb`, `st_state`, `st_post_code`, `st_tel_num`, `st_email`, `st_mobile`, `st_emerg_name`, `st_emerg_relation`, `st_emerg_mobile`, `st_emerg_agree`, `st_usi`, `st_emp_status`, `st_self_status`, `st_citizenship`, `st_gender`, `st_credit_transfer`, `st_highest_school`, `st_secondary_school`, `st_born_country`, `st_born_country_other`, `st_origin`, `st_lan_spoken`, `st_lan_spoken_other`, `st_disability`, `st_disability_type`, `st_disability_type_other`, `st_study_reason`, `st_study_reason_other`, `st_qual_1`, `st_qual_2`, `st_qual_3`, `st_qual_4`, `st_qual_5`, `st_qual_6`, `st_qual_7`, `st_qual_8`, `st_qual_9`, `st_qual_10`, `st_qual_8_other`, `st_qual_9_other`, `st_qual_10_other`, `st_status`, `st_created_date`, `st_created_by`, `st_modified_date`, `st_modified_by`) VALUES
(1, '1', '', 'rto nam asdf', '[\"3\"]', 'branch babsdf', '930837test.png', 'agia test', 'surn asdf', '2023-12-31', 'adsfas', 'adfsd', 'dfsdfg', '1', '798798', '987987987', 'asdfa@gmail.com', '87788', 'asdfsafd', 'dsfgsdf', '989879879898', '1', 'asdfasdf', '1', '3', '1', '1', '1', '3', '1', '1', '', '1', '2', '', '2', '[]', '', '1', 'asdfas', '1', '1', '1', '1', '1', '1', '1', '2', '2', '2', '', '0000-00-00', '', 0, '2023-10-18', 1, NULL, NULL),
(2, '1', 'EQ0002', 'rto nam asdf', '[\"3\"]', 'branch babsdf', '675734test.png', 'agia test', 'surn asdf', '2023-12-31', 'adsfas', 'adfsd', 'dfsdfg', '1', '798798', '987987987', 'asdfa@gmail.com', '87788', 'asdfsafd', 'dsfgsdf', '989879879898', '1', 'asdfasdf', '1', '3', '1', '1', '1', '3', '1', '1', '', '1', '2', '', '2', '[]', '', '1', 'asdfas', '1', '1', '1', '1', '1', '1', '1', '2', '2', '2', '', '0000-00-00', '', 0, '2023-10-18', 1, NULL, NULL),
(3, '1', 'EQ0002', 'rto nam asdf', '[\"3\"]', 'branch babsdf', '509731test.png', 'agia test', 'surn asdf', '2023-12-31', 'adsfas', 'adfsd', 'dfsdfg', '1', '798798', '987987987', 'asdfa@gmail.com', '87788', 'asdfsafd', 'dsfgsdf', '989879879898', '1', 'asdfasdf', '1', '3', '1', '1', '1', '3', '1', '2', 'testsdfsd', '1', '2', '', '2', '[]', '', '1', 'asdfas', '1', '1', '1', '1', '1', '1', '1', '2', '2', '2', '', '0000-00-00', '', 0, '2023-10-18', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_log_id` varchar(255) NOT NULL DEFAULT '0',
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `venue` (
  `venue_id` int(11) NOT NULL,
  `venue_name` varchar(255) NOT NULL,
  `venue_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `visa_statuses` (
  `visa_id` int(11) NOT NULL,
  `visa_status_name` varchar(255) NOT NULL,
  `visa_state_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `counseling_details`
--
ALTER TABLE `counseling_details`
  ADD PRIMARY KEY (`counsil_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `enquiry_forms`
--
ALTER TABLE `enquiry_forms`
  ADD PRIMARY KEY (`enq_form_id`);

--
-- Indexes for table `followup_calls`
--
ALTER TABLE `followup_calls`
  ADD PRIMARY KEY (`flw_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`qualification_id`);

--
-- Indexes for table `regular_group_form`
--
ALTER TABLE `regular_group_form`
  ADD PRIMARY KEY (`reg_grp_id`);

--
-- Indexes for table `rpl_enquries`
--
ALTER TABLE `rpl_enquries`
  ADD PRIMARY KEY (`rpl_enq_id`);

--
-- Indexes for table `short_group_form`
--
ALTER TABLE `short_group_form`
  ADD PRIMARY KEY (`sh_grp_id`);

--
-- Indexes for table `slot_book`
--
ALTER TABLE `slot_book`
  ADD PRIMARY KEY (`slot_bk_id`);

--
-- Indexes for table `source`
--
ALTER TABLE `source`
  ADD PRIMARY KEY (`source_id`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`st_at_id`);

--
-- Indexes for table `student_docs`
--
ALTER TABLE `student_docs`
  ADD PRIMARY KEY (`st_doc_id`);

--
-- Indexes for table `student_enquiry`
--
ALTER TABLE `student_enquiry`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `student_enrolment`
--
ALTER TABLE `student_enrolment`
  ADD PRIMARY KEY (`st_enrol_id`);

--
-- Indexes for table `student_enrolments`
--
ALTER TABLE `student_enrolments`
  ADD PRIMARY KEY (`st_enrol_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_log_id` (`user_log_id`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`venue_id`);

--
-- Indexes for table `visa_statuses`
--
ALTER TABLE `visa_statuses`
  ADD PRIMARY KEY (`visa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `counseling_details`
--
ALTER TABLE `counseling_details`
  MODIFY `counsil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiry_forms`
--
ALTER TABLE `enquiry_forms`
  MODIFY `enq_form_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followup_calls`
--
ALTER TABLE `followup_calls`
  MODIFY `flw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `qualification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `regular_group_form`
--
ALTER TABLE `regular_group_form`
  MODIFY `reg_grp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rpl_enquries`
--
ALTER TABLE `rpl_enquries`
  MODIFY `rpl_enq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `short_group_form`
--
ALTER TABLE `short_group_form`
  MODIFY `sh_grp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slot_book`
--
ALTER TABLE `slot_book`
  MODIFY `slot_bk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `source`
--
ALTER TABLE `source`
  MODIFY `source_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `st_at_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `student_docs`
--
ALTER TABLE `student_docs`
  MODIFY `st_doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_enquiry`
--
ALTER TABLE `student_enquiry`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student_enrolment`
--
ALTER TABLE `student_enrolment`
  MODIFY `st_enrol_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_enrolments`
--
ALTER TABLE `student_enrolments`
  MODIFY `st_enrol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visa_statuses`
--
ALTER TABLE `visa_statuses`
  MODIFY `visa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
