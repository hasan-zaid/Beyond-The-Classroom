-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2023 at 04:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fwdd`
--
CREATE DATABASE IF NOT EXISTS `fwdd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fwdd`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) DEFAULT NULL,
  `admin_email` varchar(30) DEFAULT NULL,
  `admin_password` varchar(100) DEFAULT NULL,
  `admin_dob` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `admin_dob`) VALUES
(1, 'Admin A', 'admin1@mail.com', '21232f297a57a5a743894a0e4a801fc3', '01-01-2000');

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `assessment_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_completion`
--

CREATE TABLE `assessment_completion` (
  `comp_id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `result` double DEFAULT NULL,
  `comp_date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `material_name` varchar(40) DEFAULT NULL,
  `material_link` varchar(255) DEFAULT NULL,
  `date_added` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `module_id`, `material_name`, `material_link`, `date_added`) VALUES
(1, 16, 'fsgihg', 'https://google.com', '22-05-2023'),
(2, 20, 'mat b', 'https://apu.edu.my', '22-05-2023'),
(3, 20, 'mat a', 'https://google.com', '22-05-2023'),
(4, 21, 'Material B for Test Module', 'https://apu.edu.my', '22-05-2023'),
(5, 21, 'Material A for Test Module', 'https://google.com', '22-05-2023'),
(6, 33, 'sasasas', 'asasas', '28-05-2023'),
(7, 33, 'sasasa', 'sasasas', '28-05-2023');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `module_name` varchar(30) DEFAULT NULL,
  `module_desc` varchar(255) DEFAULT NULL,
  `module_time` int(11) DEFAULT NULL,
  `module_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `tutor_id`, `module_name`, `module_desc`, `module_time`, `module_status`) VALUES
(1, 1, 'Module A', 'This is a long description for Module A by Tutor A.', 5, 1),
(2, 1, 'Module B', 'This is a description for Module B.', 6, 1),
(3, 1, 'Module C', 'bsdiushgsiuhgse', 7, 1),
(16, 1, 'Module E', 'this is a test module with a few materials', 1, 1),
(17, 1, 'Module D', 'this is a test', 1, 1),
(18, 1, 'sdghsdioghds', 'this is a test', 1, 1),
(19, 1, 'test', 'test', 1, 1),
(20, 1, 'asdf', 'test', 1, 1),
(21, 1, 'Test Module', 'Module with 3 Materials', 7, 1),
(22, 1, 'asasad', 'asasasa', 1, 1),
(23, 1, 'asasad', 'asasasa', 1, 1),
(24, 1, 'asasasa', 'asas', 1, 1),
(25, 1, 'sasasasasa', 'sasasasas', 1, 1),
(26, 1, 'sasasasas', 'asasasasasas', 1, 1),
(27, 1, 'sasasasas', 'asasasasa', 1, 1),
(28, 1, 'sasasasasas', 'asasasasasas', 1, 1),
(29, 1, 'sasasas', 'asasasa', 1, 1),
(30, 1, 'sasasas', 'asasasas', 1, 1),
(31, 1, 'sasasas', 'asasasas', 1, 1),
(32, 1, 'sasasasas', 'asasasasa', 1, 1),
(33, 1, 'sasasa', 'asasasasa', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_enrollment`
--

CREATE TABLE `module_enrollment` (
  `enroll_id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `enroll_date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `question_title` varchar(255) DEFAULT NULL,
  `choices` varchar(255) NOT NULL,
  `answer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `stud_id` int(11) NOT NULL,
  `stud_name` varchar(100) DEFAULT NULL,
  `stud_email` varchar(30) DEFAULT NULL,
  `stud_password` varchar(100) DEFAULT NULL,
  `stud_dob` varchar(10) DEFAULT NULL,
  `stud_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stud_id`, `stud_name`, `stud_email`, `stud_password`, `stud_dob`, `stud_status`) VALUES
(1, 'Student A', 'student1@mail.com', 'e4a6a34a2c625d52f26846f5e3d22064', '02-02-2002', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `tutor_id` int(11) NOT NULL,
  `tutor_name` varchar(100) DEFAULT NULL,
  `tutor_email` varchar(30) DEFAULT NULL,
  `tutor_password` varchar(100) DEFAULT NULL,
  `tutor_dob` varchar(10) DEFAULT NULL,
  `tutor_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_id`, `tutor_name`, `tutor_email`, `tutor_password`, `tutor_dob`, `tutor_status`) VALUES
(1, 'Tutor A', 'tutor1@email.com', 'e99a18c428cb38d5f260853678922e03', '31-12-2002', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `assessment_completion`
--
ALTER TABLE `assessment_completion`
  ADD PRIMARY KEY (`comp_id`),
  ADD KEY `stud_id` (`stud_id`),
  ADD KEY `assessment_id` (`assessment_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `module_enrollment`
--
ALTER TABLE `module_enrollment`
  ADD PRIMARY KEY (`enroll_id`),
  ADD KEY `stud_id` (`stud_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `assessment_id` (`assessment_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stud_id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`tutor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_completion`
--
ALTER TABLE `assessment_completion`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `module_enrollment`
--
ALTER TABLE `module_enrollment`
  MODIFY `enroll_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON UPDATE CASCADE;

--
-- Constraints for table `assessment_completion`
--
ALTER TABLE `assessment_completion`
  ADD CONSTRAINT `assessment_completion_ibfk_1` FOREIGN KEY (`stud_id`) REFERENCES `students` (`stud_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `assessment_completion_ibfk_2` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`assessment_id`) ON UPDATE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON UPDATE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_enrollment`
--
ALTER TABLE `module_enrollment`
  ADD CONSTRAINT `module_enrollment_ibfk_1` FOREIGN KEY (`stud_id`) REFERENCES `students` (`stud_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `module_enrollment_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`assessment_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
