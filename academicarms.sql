-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 05, 2019 at 04:48 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academicarms`
--

-- --------------------------------------------------------

--
-- Table structure for table `Classes`
--

CREATE TABLE IF NOT EXISTS `Classes` (
  `Class_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `ClassRef` varchar(100) NOT NULL,
  `Status` int(11) DEFAULT '1',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Classes`
--

INSERT INTO `Classes` (`Class_id`, `Name`, `ClassRef`, `Status`, `DateCreated`, `DateUpdated`) VALUES
(1, 'JSS 1', 'ARMS-1573079814', 1, '2019-10-26 06:27:28', '2019-10-26 11:59:57'),
(2, 'JSS 2', 'ARMS-1237704710', 1, '2019-10-26 06:27:46', '0000-00-00 00:00:00'),
(3, 'JSS 3', 'ARMS-1238698837', 1, '2019-10-26 06:28:01', '0000-00-00 00:00:00'),
(4, 'SSS 1', 'ARMS-1526696267', 1, '2019-10-26 06:29:15', '2019-10-26 06:33:22'),
(5, 'Graduates', 'ARMS-1595508969', 1, '2019-10-29 17:47:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE IF NOT EXISTS `general_settings` (
  `id` int(11) NOT NULL,
  `Site_name` varchar(150) NOT NULL,
  `Site_tag` text NOT NULL,
  `Site_shortname` varchar(100) NOT NULL,
  `Site_email` varchar(150) NOT NULL,
  `Maintenance` int(11) NOT NULL,
  `Resultpin_length` int(11) NOT NULL,
  `Pin_usage` int(11) NOT NULL,
  `Teacher_add_students` int(11) NOT NULL,
  `Teacher_add_result` int(11) NOT NULL,
  `footer_text` text NOT NULL,
  `Site_logo` varchar(150) NOT NULL,
  `Current_session` int(11) NOT NULL,
  `Current_term` int(11) NOT NULL,
  `Serialpin_length` int(11) NOT NULL,
  `Result_type` int(11) NOT NULL,
  `Default_password` varchar(100) NOT NULL,
  `Check_result_nologin` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `Site_name`, `Site_tag`, `Site_shortname`, `Site_email`, `Maintenance`, `Resultpin_length`, `Pin_usage`, `Teacher_add_students`, `Teacher_add_result`, `footer_text`, `Site_logo`, `Current_session`, `Current_term`, `Serialpin_length`, `Result_type`, `Default_password`, `Check_result_nologin`) VALUES
(1, 'Academica RMS', 'School Results, Academica Result Management System', 'ARMS', 'academicarms@gmail.com', 2, 10, 4, 1, 1, '&copy; All Rights Reserved.', '1d477299d596505241c1748ea415e920.png', 1, 2, 20, 2, 'ARMSTART', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Grade`
--

CREATE TABLE IF NOT EXISTS `Grade` (
  `Grade_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Min_Score` varchar(100) NOT NULL,
  `Max_Score` varchar(100) NOT NULL,
  `Comment` varchar(100) NOT NULL,
  `Grade_point` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Grade`
--

INSERT INTO `Grade` (`Grade_id`, `Name`, `Min_Score`, `Max_Score`, `Comment`, `Grade_point`, `Status`) VALUES
(1, 'A', '70', '100', 'Excellent', '5', 1),
(2, 'B', '60', '69.99', 'Very Good', '4', 1),
(3, 'C', '50', '59.99', 'Credit', '3', 1),
(4, 'D', '45', '49.99', 'Pass', '2', 1),
(5, 'F', '0', '44.99', 'Failed', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Pin_Usage`
--

CREATE TABLE IF NOT EXISTS `Pin_Usage` (
  `Usage_id` int(11) NOT NULL,
  `Pin_id` int(11) NOT NULL,
  `Session` int(11) NOT NULL,
  `Term` int(11) NOT NULL,
  `Class` int(11) NOT NULL,
  `Student` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Pin_Usage`
--

INSERT INTO `Pin_Usage` (`Usage_id`, `Pin_id`, `Session`, `Term`, `Class`, `Student`) VALUES
(1, 1, 1, 1, 1, 1),
(2, 1, 1, 1, 1, 1),
(3, 1, 1, 1, 1, 1),
(4, 1, 1, 1, 1, 1),
(5, 2, 1, 1, 1, 1),
(6, 2, 1, 1, 1, 1),
(7, 2, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Position`
--

CREATE TABLE IF NOT EXISTS `Position` (
  `Position_id` int(11) NOT NULL,
  `Result_type` int(11) NOT NULL,
  `Student` int(11) NOT NULL,
  `Position` text NOT NULL,
  `Teacher_comment` mediumtext NOT NULL,
  `Headteacher_comment` mediumtext NOT NULL,
  `Principal_comment` mediumtext NOT NULL,
  `Session` int(11) NOT NULL,
  `Term` int(11) NOT NULL,
  `Class` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Position`
--

INSERT INTO `Position` (`Position_id`, `Result_type`, `Student`, `Position`, `Teacher_comment`, `Headteacher_comment`, `Principal_comment`, `Session`, `Term`, `Class`) VALUES
(1, 2, 1, '1st', 'Excellent', 'Wonderful', 'Nice', 1, 1, 1),
(2, 1, 1, '2nd', 'Okay', 'Excellent', 'Satisfactorily', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Result`
--

CREATE TABLE IF NOT EXISTS `Result` (
  `Result_id` int(11) NOT NULL,
  `Session` int(11) NOT NULL,
  `Semester` int(11) NOT NULL,
  `Student` int(11) NOT NULL,
  `Class` int(11) NOT NULL,
  `Subject` int(11) NOT NULL,
  `Exam_score` varchar(100) NOT NULL,
  `Test_score` varchar(100) NOT NULL,
  `Total_score` varchar(100) NOT NULL,
  `Grade` varchar(20) NOT NULL,
  `Status` int(11) NOT NULL,
  `Grade_id` int(11) NOT NULL,
  `Gradepoint` varchar(20) NOT NULL,
  `Unit_load` varchar(50) NOT NULL,
  `Unit_point` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Result`
--

INSERT INTO `Result` (`Result_id`, `Session`, `Semester`, `Student`, `Class`, `Subject`, `Exam_score`, `Test_score`, `Total_score`, `Grade`, `Status`, `Grade_id`, `Gradepoint`, `Unit_load`, `Unit_point`) VALUES
(1, 1, 1, 1, 1, 4, '50', '30', '80', 'A', 1, 1, '5', '3', '15'),
(2, 1, 1, 1, 1, 9, '50', '20', '70', 'A', 1, 1, '5', '4', '20'),
(3, 1, 1, 1, 1, 10, '40', '30', '70', 'A', 1, 1, '5', '2', '10');

-- --------------------------------------------------------

--
-- Table structure for table `Result_pins`
--

CREATE TABLE IF NOT EXISTS `Result_pins` (
  `Pin_id` int(11) NOT NULL,
  `Pin_number` varchar(150) NOT NULL,
  `Serial_number` varchar(150) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Result_pins`
--

INSERT INTO `Result_pins` (`Pin_id`, `Pin_number`, `Serial_number`, `Status`) VALUES
(2, '5FCG9SWP12TL', 'Q0OGSCX5TZAF8JK', 2),
(3, '0KNA4GR2MT1S', '2I4Z78L6MHXDCKR', 1),
(4, 'ENL4BVH1FAOZ', 'M2OSAZ89L53NW0E', 1),
(5, '1E5BNUJ6VH7F', 'BCEHYNK259MFIV7', 1),
(6, 'VR5U64XPWGOE', 'DP2GVZ7KMXANWFJ', 1),
(7, '64KCEW8UQ5LP', 'DHB5LY29MWUZOP7', 1),
(8, '5IZT24XD1WAF', 'UK7E6VCQA28GXN9', 1),
(9, 'AVQHBNYIRUO1', 'KMC80IVUA9BEDHN', 1),
(10, 'HCX2TPLV3MGW', 'NT496Y7E310QWAP', 1),
(11, 'HV06QLZWJS8Y', 'MD7O4NL8JIB9GQF', 1),
(12, 'IJOHN073KAPB', 'BTWAR45KFX9NVSJ', 1),
(13, 'ZBNLWCK67X0U', 'VIR4J0S9BM6ZKDH', 1),
(14, '0BZTSL5DXAJC', 'QYSTDOUI8K6L4GC', 1),
(15, 'MAIUFLRDCZ13', 'C2PX3VL1ARWHUY8', 1),
(16, 'FVT9LGMP8ORB', '9RAYVOT17KCM08B', 1),
(17, 'L4WJOBI281AU', '5STW4ZKPG3QBHVO', 1),
(18, '9B0MF4VXGECI', '28DGFN64MT7V5SJ', 1),
(19, 'C2XJGHLKVUQ5', '8GY1XSQ965T0W2J', 1),
(20, '1NZT7OC5SJ2R', '9W601PFUS8NKJ2V', 1),
(21, 'ZHJFLY4C5P', 'NQZ69WCPT5MDF02UH3IB', 1),
(22, 'SJBO8TKRAU', '54GBV6ALCI0QFM8XWJDK', 1),
(23, 'VQE023CP9L', 'WK5MF0DXO1N7BPST4QCL', 1),
(24, 'LMB7VZI1PT', 'BG8V2NKFM5ZWJQI6CD3U', 1),
(25, 'O3U1LC6INQ', 'EC9DIGJBTMVZ2W6Y70RA', 1),
(26, 'ORWF6JEAQG', 'JRB5SQMH430XNOYP8UVF', 1),
(27, 'V02UXPDOIF', 'AMYGXN5F438RCVE0KUQ2', 1),
(28, 'EKUWVSX4H6', 'TWFZ6HGD8X9JBURSQP7C', 1),
(29, 'HXOY1AFE7S', 'RAX4BG5V321SCMNEUKWT', 1),
(30, '0ORPXED6S9', 'ZL8U46YPONA9XJRSKI21', 1),
(31, 'V1SRFNT3AH', 'RCT1XQISO03UEZMB6DY8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Result_type`
--

CREATE TABLE IF NOT EXISTS `Result_type` (
  `Type_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Result_type`
--

INSERT INTO `Result_type` (`Type_id`, `Name`, `Status`) VALUES
(1, 'Annual', 1),
(2, 'Terminal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Semester`
--

CREATE TABLE IF NOT EXISTS `Semester` (
  `Semester_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Semester`
--

INSERT INTO `Semester` (`Semester_id`, `Name`, `Status`) VALUES
(1, 'First Term', 1),
(2, 'Second Term', 1),
(3, 'Third Term', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Session`
--

CREATE TABLE IF NOT EXISTS `Session` (
  `Session_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Session`
--

INSERT INTO `Session` (`Session_id`, `Name`, `Status`) VALUES
(1, '2015/2016', 1),
(2, '2016/2017', 1),
(3, '2017/2018', 1),
(4, '2018/2019', 1),
(5, '2019/2020', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Student`
--

CREATE TABLE IF NOT EXISTS `Student` (
  `Student_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Reg_no` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Updated_password` int(11) NOT NULL DEFAULT '2',
  `Class` int(11) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL,
  `Password_reset` varchar(100) NOT NULL,
  `Password_code` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Student`
--

INSERT INTO `Student` (`Student_id`, `Name`, `Email`, `Reg_no`, `Password`, `Updated_password`, `Class`, `DateCreated`, `DateUpdated`, `Status`, `Password_reset`, `Password_code`) VALUES
(1, 'Michael Erastus', 'Meritinfos@gmail.com', 'ARMS/2019/373757324', '$2y$10$mnRAXTcK0BwyKK2FhVRMy.Ue.MX3kPIwho/9aaq4ZeLaQnlLpYrie', 2, 1, '2019-11-01 19:55:28', '0000-00-00 00:00:00', 1, '', ''),
(2, 'Michael Erastus', 'Meritinfos1@gmail.com', 'ARMS/2019/308770446', '$2y$10$UVi.VO9eYuk4ybG3V2hDyu3bi4xxSF7D70.WW5StcWFS0jHyb56m2', 2, 2, '2019-11-01 19:56:07', '0000-00-00 00:00:00', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Subject`
--

CREATE TABLE IF NOT EXISTS `Subject` (
  `Subject_id` int(11) NOT NULL,
  `Subject_name` varchar(120) NOT NULL,
  `Subject_code` varchar(120) NOT NULL,
  `Unit_load` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Subject`
--

INSERT INTO `Subject` (`Subject_id`, `Subject_name`, `Subject_code`, `Unit_load`, `Status`) VALUES
(1, 'Basic Inorganic Chemistry', 'CHM 101', '2', 1),
(2, 'Use of English 1', 'GSP 101', '2', 1),
(3, 'Use of Library', 'GSP 111', '2', 1),
(4, 'General Mathematics', 'MTH 101', '3', 1),
(5, 'Agricultural Economics', 'AEC 202', '4', 1),
(9, 'Agricultural Physics', 'AGR 102', '4', 1),
(10, 'Physical Chemistry', 'CHM 112', '2', 1),
(11, 'Basic Organic Chemistry', 'CHM 122', '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Subject_combination`
--

CREATE TABLE IF NOT EXISTS `Subject_combination` (
  `Combination_id` int(11) NOT NULL,
  `Subject` int(11) NOT NULL,
  `Class` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Subject_combination`
--

INSERT INTO `Subject_combination` (`Combination_id`, `Subject`, `Class`, `Status`) VALUES
(4, 4, 1, 1),
(6, 9, 1, 1),
(7, 10, 1, 1),
(9, 1, 2, 1),
(10, 2, 2, 1),
(11, 3, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Sysadmin`
--

CREATE TABLE IF NOT EXISTS `Sysadmin` (
  `admin_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Admin_type` int(11) NOT NULL,
  `AdminSess` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EmailCode` varchar(120) NOT NULL,
  `Email_code` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Sysadmin`
--

INSERT INTO `Sysadmin` (`admin_id`, `Name`, `Email`, `Password`, `Admin_type`, `AdminSess`, `Status`, `UpdateTime`, `RegDate`, `EmailCode`, `Email_code`) VALUES
(1, 'Superadmin', 'superadmin@admin.com', '$2y$10$huNP8vzkjnwpgUiTl04lIO4wpoVQ6v/BSyZrVUOQSqzvuJkul2mfm', 1, '1d7a42b37b7db6f057469d5e9ddcdd77c0777129', 1, '2019-11-05 04:47:08', '2019-10-16 03:20:10', '', ''),
(2, 'Admin', 'admin@admin.com', '$2y$10$ydSQ.89xsdqEhHEEdsD2cOX73CJrjPLD8z9ccQBn50jgEVkyw6suq', 2, '', 1, '0000-00-00 00:00:00', '2019-11-05 04:45:41', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Teacher`
--

CREATE TABLE IF NOT EXISTS `Teacher` (
  `Teacher_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `Password` varchar(150) NOT NULL,
  `Class` int(11) NOT NULL,
  `ClassName` varchar(100) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL,
  `TeacherSess` varchar(150) NOT NULL,
  `EmailCode` varchar(120) NOT NULL,
  `Email_code` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Teacher`
--

INSERT INTO `Teacher` (`Teacher_id`, `Name`, `Email`, `Password`, `Class`, `ClassName`, `RegDate`, `DateUpdated`, `Status`, `TeacherSess`, `EmailCode`, `Email_code`) VALUES
(1, 'Michael Erastus', 'meritinfos@gmail.com', '$2y$10$tB5euSManjT4uYJ8RM1ljeLLetS/xNiHudEUXPIy4J/NMGfgjA5WS', 1, 'JSS 1', '2019-10-26 17:11:34', '2019-11-02 22:36:32', 1, '31c519b6dc229e12d6cda1342596788d2fecf40c', '', ''),
(2, 'Abraham Kelvin', 'Mike@gmail.com', '$2y$10$A2btdliqSjhnnTlAemAJd.O7/pr/ONL0yJQ6GxqXKS1w49qKVaiKW', 2, 'JSS 2', '2019-10-26 17:11:34', '2019-10-26 17:12:15', 1, '', '', ''),
(3, 'Michael chinedu', 'Mikel@gmail.com', '$2y$10$jGQhkyoGmfBMbSCFCpEwAuWMOxVKaRoEFhJfIc/eq4bFD8hVjRzVq', 3, 'JSS 3', '2019-10-26 17:11:35', '2019-10-26 17:12:33', 1, '', '', ''),
(4, 'Ms Cindy Byler', 'Michael@gmail.com', '$2y$10$cNkFomhgnT6W9WDZbWLUV.G2hAnOSUMBiXTxeHaVaSvbV1ulLsSm6', 4, 'SSS 1', '2019-10-26 17:11:35', '2019-10-26 17:12:49', 1, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Classes`
--
ALTER TABLE `Classes`
  ADD PRIMARY KEY (`Class_id`),
  ADD KEY `Name` (`Name`),
  ADD KEY `ClassRef` (`ClassRef`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Grade`
--
ALTER TABLE `Grade`
  ADD PRIMARY KEY (`Grade_id`);

--
-- Indexes for table `Pin_Usage`
--
ALTER TABLE `Pin_Usage`
  ADD PRIMARY KEY (`Usage_id`);

--
-- Indexes for table `Position`
--
ALTER TABLE `Position`
  ADD PRIMARY KEY (`Position_id`);

--
-- Indexes for table `Result`
--
ALTER TABLE `Result`
  ADD PRIMARY KEY (`Result_id`);

--
-- Indexes for table `Result_pins`
--
ALTER TABLE `Result_pins`
  ADD PRIMARY KEY (`Pin_id`);

--
-- Indexes for table `Result_type`
--
ALTER TABLE `Result_type`
  ADD PRIMARY KEY (`Type_id`);

--
-- Indexes for table `Semester`
--
ALTER TABLE `Semester`
  ADD PRIMARY KEY (`Semester_id`);

--
-- Indexes for table `Session`
--
ALTER TABLE `Session`
  ADD PRIMARY KEY (`Session_id`);

--
-- Indexes for table `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`Student_id`);

--
-- Indexes for table `Subject`
--
ALTER TABLE `Subject`
  ADD PRIMARY KEY (`Subject_id`);

--
-- Indexes for table `Subject_combination`
--
ALTER TABLE `Subject_combination`
  ADD PRIMARY KEY (`Combination_id`);

--
-- Indexes for table `Sysadmin`
--
ALTER TABLE `Sysadmin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `Teacher`
--
ALTER TABLE `Teacher`
  ADD PRIMARY KEY (`Teacher_id`),
  ADD KEY `Name` (`Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Classes`
--
ALTER TABLE `Classes`
  MODIFY `Class_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Grade`
--
ALTER TABLE `Grade`
  MODIFY `Grade_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Pin_Usage`
--
ALTER TABLE `Pin_Usage`
  MODIFY `Usage_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Position`
--
ALTER TABLE `Position`
  MODIFY `Position_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Result`
--
ALTER TABLE `Result`
  MODIFY `Result_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Result_pins`
--
ALTER TABLE `Result_pins`
  MODIFY `Pin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `Result_type`
--
ALTER TABLE `Result_type`
  MODIFY `Type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Semester`
--
ALTER TABLE `Semester`
  MODIFY `Semester_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Session`
--
ALTER TABLE `Session`
  MODIFY `Session_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Student`
--
ALTER TABLE `Student`
  MODIFY `Student_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Subject`
--
ALTER TABLE `Subject`
  MODIFY `Subject_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `Subject_combination`
--
ALTER TABLE `Subject_combination`
  MODIFY `Combination_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `Sysadmin`
--
ALTER TABLE `Sysadmin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Teacher`
--
ALTER TABLE `Teacher`
  MODIFY `Teacher_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
