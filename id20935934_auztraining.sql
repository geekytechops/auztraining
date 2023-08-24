-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 24, 2023 at 11:37 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

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
  `course_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_status`, `created_date`) VALUES
(1, 'Basic', 0, '2023-08-23 10:40:46'),
(2, 'Intermediate', 0, '2023-08-23 10:40:46'),
(3, 'Expert', 0, '2023-08-23 10:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `inv_id` int NOT NULL AUTO_INCREMENT,
  `inv_auto_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `st_unique_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inv_std_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inv_course` tinyint(1) NOT NULL,
  `inv_fee` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inv_paid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inv_due` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inv_payment_date` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inv_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`inv_id`, `inv_auto_id`, `st_unique_id`, `inv_std_name`, `inv_course`, `inv_fee`, `inv_paid`, `inv_due`, `inv_payment_date`, `created_date`, `inv_status`) VALUES
(1, 'INV00001', '', 'mike sheifen', 3, '6000', '5000', '2000', '2023-08-11', '2023-08-24 05:43:16', 0),
(2, 'INV00002', '2023E30002', 'test', 2, '5000', '20000', '20000', '2023-08-25', '2023-08-24 06:04:13', 0);

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
(1, 'Masters Degree', 0, '2023-08-23 11:37:08'),
(2, 'Bachelors Degree', 0, '2023-08-23 11:37:08'),
(3, 'MCA', 0, '2023-08-23 11:37:16');

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
-- Table structure for table `student_enquiry`
--

DROP TABLE IF EXISTS `student_enquiry`;
CREATE TABLE IF NOT EXISTS `student_enquiry` (
  `st_id` int NOT NULL AUTO_INCREMENT,
  `st_enquiry_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `st_phno` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `st_email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `st_course` tinyint(1) NOT NULL,
  `st_fee` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `st_visa_status` tinyint(1) NOT NULL,
  `st_enquiry_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enquiry`
--

INSERT INTO `student_enquiry` (`st_id`, `st_enquiry_id`, `st_name`, `st_phno`, `st_email`, `st_course`, `st_fee`, `st_visa_status`, `st_enquiry_status`, `created_date`) VALUES
(1, 'EQ00001', 'Testing', '6554654655', 'tester@gmail.com', 1, '5000', 1, 0, '2023-08-23 11:18:46'),
(2, 'EQ00002', 'Testing new', '9879879877', 'tester132@gmail.com', 3, '2000', 3, 0, '2023-08-23 11:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `student_enrolment`
--

DROP TABLE IF EXISTS `student_enrolment`;
CREATE TABLE IF NOT EXISTS `student_enrolment` (
  `st_enrol_id` int NOT NULL AUTO_INCREMENT,
  `st_unique_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_enquiry_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `st_qualifications` tinyint(1) NOT NULL,
  `st_enrol_course` tinyint(1) DEFAULT NULL,
  `st_venue` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `st_middle_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `st_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `st_source` tinyint(1) NOT NULL,
  `st_given_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `st_enrol_status` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`st_enrol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enrolment`
--

INSERT INTO `student_enrolment` (`st_enrol_id`, `st_unique_id`, `st_enquiry_id`, `st_qualifications`, `st_enrol_course`, `st_venue`, `st_middle_name`, `st_name`, `st_source`, `st_given_name`, `st_enrol_status`, `created_date`) VALUES
(1, '2023I20001', '', 2, 2, '2', 'john', 'Mikers', 2, 'Mike', 0, '2023-08-24 05:36:08'),
(2, '2023E30002', 'EQ00001', 3, 3, '3', 'test 3', 'test 2', 3, 'new mike', 0, '2023-08-24 05:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_log_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
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
(1, 'ST56F54', 'test1', 'test123@gmail.com', 'test', 1, 0, '2023-08-20 10:06:13', NULL),
(2, 'HH56FH4', 'test2', 'test234@gmail.com', 'test2', 0, 0, '2023-08-20 10:06:13', NULL);

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
