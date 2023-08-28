-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2023 at 02:33 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_sname`, `course_status`, `created_date`) VALUES
(1, 'AGING', 'A3', 0, '2023-08-26 15:30:33'),
(2, 'DISABILITY', 'D1', 0, '2023-08-26 15:30:33');

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
  `st_phno` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_course` tinyint(1) NOT NULL,
  `st_fee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `st_visa_status` tinyint(1) NOT NULL,
  `st_enquiry_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enquiry`
--

INSERT INTO `student_enquiry` (`st_id`, `st_enquiry_id`, `st_name`, `st_phno`, `st_email`, `st_course`, `st_fee`, `st_visa_status`, `st_enquiry_status`, `created_date`) VALUES
(1, 'EQ00001', 'Mike Sheifen', '9876443216', 'test2@gmail.com', 1, '2000', 1, 0, '2023-08-26 15:40:12');

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
  `st_mobile` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `st_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
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
