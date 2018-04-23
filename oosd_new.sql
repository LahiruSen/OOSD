-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2018 at 12:06 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oosd`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL,
  `registration_deadline` datetime DEFAULT NULL,
  `course_deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`id`, `title`, `description`, `from_date`, `to_date`, `status`, `date_of_create`, `date_of_update`, `registration_deadline`, `course_deadline`) VALUES
(1, 'Batch 14', 'This is the registration year for the batch 14th student.', '2014-01-01', '2015-01-01', -1, '2018-04-23 00:00:00', '2018-04-23 00:00:00', '2014-01-15 00:00:00', '2014-02-01 00:00:00'),
(2, 'Batch 15', 'This is the registration year for the batch 15th student.', '2015-01-01', '2016-01-01', -1, '2018-04-23 00:00:00', '2018-04-23 00:00:00', '2015-01-15 00:00:00', '2015-02-01 00:00:00'),
(3, 'Batch 16', 'This is the registration year for the batch 16th student.', '2015-01-01', '2017-01-01', -1, '2018-04-23 00:00:00', '2018-04-23 00:00:00', '2016-01-15 00:00:00', '2016-02-01 00:00:00'),
(4, 'Batch 17', 'This is the registration year for the batch 17th student.', '2016-01-01', '2018-01-01', -1, '2018-04-23 00:00:00', '2018-04-23 00:00:00', '2017-01-15 00:00:00', '2017-02-01 00:00:00'),
(5, 'Batch 18', 'This is the registration year for the batch 18th student.', '2018-01-01', '2019-01-01', 1, '2018-04-23 00:00:00', '2018-04-23 00:00:00', '2018-01-15 00:00:00', '2018-02-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_id` varchar(8) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `attachment_link` mediumtext NOT NULL,
  `title` text NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `mark` int(11) NOT NULL,
  `pdf_link` mediumtext NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `course_registration_id` int(11) NOT NULL,
  `no_of_attendant` int(11) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(8) NOT NULL,
  `tite` text NOT NULL,
  `field` text NOT NULL,
  `description` longtext NOT NULL,
  `credits` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `assigned_teacher_id` int(11) NOT NULL,
  `no_of_working_hours` int(11) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_availability`
--

CREATE TABLE `course_availability` (
  `id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `course_id` varchar(8) NOT NULL,
  `availability` tinyint(4) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_mark`
--

CREATE TABLE `course_mark` (
  `id` int(11) NOT NULL,
  `course_registration_id` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `attendance` float NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_registration`
--

CREATE TABLE `course_registration` (
  `id` int(11) NOT NULL,
  `registration_number` varchar(10) NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL,
  `course_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_data`
--

CREATE TABLE `employee_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` char(1) NOT NULL,
  `address_line_1` text NOT NULL,
  `address_line_2` text NOT NULL,
  `title` text NOT NULL,
  `full_name` text NOT NULL,
  `phone_number` int(11) NOT NULL,
  `city` text NOT NULL,
  `postal_code` int(11) NOT NULL,
  `dob` date NOT NULL,
  `civil_status` text NOT NULL,
  `sex` text NOT NULL,
  `nic` int(13) NOT NULL,
  `is_approved` text NOT NULL,
  `employee_type_id` int(2) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL,
  `is_locked` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_types`
--

CREATE TABLE `employee_types` (
  `id` int(11) NOT NULL,
  `title` mediumtext,
  `description` longtext,
  `user_level` int(11) NOT NULL DEFAULT '0',
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_types`
--

INSERT INTO `employee_types` (`id`, `title`, `description`, `user_level`, `date_of_create`, `date_of_update`) VALUES
(1, 'Administrator', 'The description of the administration.', 4, '2018-04-20 00:00:00', '2018-04-21 00:00:00'),
(2, 'Teacher', 'The description of the teaching position.', 1, '2018-04-20 00:00:00', '2018-04-21 00:00:00'),
(3, 'Principal', 'The description of the principal position.', 2, '2018-04-20 00:00:00', '2018-04-21 00:00:00'),
(4, 'HR Manager', 'The description of the HR Manager position.', 3, '2018-04-20 00:00:00', '2018-04-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `leave_details`
--

CREATE TABLE `leave_details` (
  `id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `max_leave` int(11) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_notifications`
--

CREATE TABLE `leave_notifications` (
  `id` int(11) NOT NULL,
  `leave_submission_id` int(11) NOT NULL,
  `view_status` tinyint(4) NOT NULL,
  `employ_type_id` int(11) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_submission`
--

CREATE TABLE `leave_submission` (
  `id` int(11) NOT NULL,
  `employ_id` int(11) NOT NULL,
  `reason_for_leave` mediumtext NOT NULL,
  `description` longtext NOT NULL,
  `number_of_dates` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `approved_by_pricipal` tinyint(4) NOT NULL,
  `approved_by_hr` tinyint(4) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `time` datetime NOT NULL,
  `place` text,
  `duration` text NOT NULL,
  `target_user_ids` mediumtext NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_submissions`
--

CREATE TABLE `scholarship_submissions` (
  `id` int(11) NOT NULL,
  `registration_number` char(1) NOT NULL,
  `pdf_url` longtext,
  `scholarship_id` int(11) NOT NULL,
  `is_approved` tinyint(4) NOT NULL,
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_data`
--

CREATE TABLE `student_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_line_1` mediumtext NOT NULL,
  `address_line_2` mediumtext NOT NULL,
  `city` text NOT NULL,
  `title` text NOT NULL,
  `phone_number` int(11) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `father_full_name` text NOT NULL,
  `mother_full_name` text NOT NULL,
  `contact_person_full_name` text NOT NULL,
  `contact_person_phone_number` int(11) NOT NULL,
  `full_name` text NOT NULL,
  `dob` date NOT NULL,
  `civil_status` text NOT NULL,
  `sex` text NOT NULL,
  `nic` int(13) NOT NULL,
  `is_physically_disabled` text,
  `is_approved` tinyint(4) DEFAULT '0',
  `al_index_number` int(12) NOT NULL,
  `registration_number` varchar(10) DEFAULT NULL,
  `date_of_create` datetime DEFAULT NULL,
  `date_of_update` datetime DEFAULT NULL,
  `registered_ayear_id` int(11) NOT NULL,
  `is_locked` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_data`
--

INSERT INTO `student_data` (`id`, `user_id`, `address_line_1`, `address_line_2`, `city`, `title`, `phone_number`, `postal_code`, `father_full_name`, `mother_full_name`, `contact_person_full_name`, `contact_person_phone_number`, `full_name`, `dob`, `civil_status`, `sex`, `nic`, `is_physically_disabled`, `is_approved`, `al_index_number`, `registration_number`, `date_of_create`, `date_of_update`, `registered_ayear_id`, `is_locked`) VALUES
(1, 13, 'Thrijaya', 'Kapukoratuwa, Indigahena, Narawelpita east', 'Hakmana', 'Miss', 713232323, 81300, 'Gamage Nimal Karunarathne', 'Gamage Ashoka kumari', 'Gamage Nimal Karunarathne', 713232323, 'Gamage Bhagya Minuwandi Karunarathne', '1997-05-17', 'Single', 'Female', 920182216, 'off', 0, 23332245, NULL, '2018-04-23 11:56:31', '2018-04-23 11:56:31', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_final_grade`
--

CREATE TABLE `student_final_grade` (
  `id` int(11) NOT NULL,
  `registration_number` char(1) NOT NULL,
  `level_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `mark` int(4) NOT NULL DEFAULT '0',
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `types` tinyint(1) NOT NULL DEFAULT '0',
  `date_of_create` datetime NOT NULL,
  `date_of_update` datetime NOT NULL,
  `two_step` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `hash`, `active`, `types`, `date_of_create`, `date_of_update`, `two_step`) VALUES
(13, 'Bhagya', 'Karunarathne', 'kumudusweerasinghe@gmail.com', '$2y$10$pZha.OJfBNXD.ThxWHR/ZeP0oEACGKLbXcsy37Rhuh0b32GM5Gd1.', 'ab817c9349cf9c4f6877e1894a1faa00', 1, 2, '2018-03-26 14:06:50', '2018-03-26 14:06:50', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_availability`
--
ALTER TABLE `course_availability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_mark`
--
ALTER TABLE `course_mark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_registration`
--
ALTER TABLE `course_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_data`
--
ALTER TABLE `employee_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_types`
--
ALTER TABLE `employee_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_details`
--
ALTER TABLE `leave_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_notifications`
--
ALTER TABLE `leave_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_submission`
--
ALTER TABLE `leave_submission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarship_submissions`
--
ALTER TABLE `scholarship_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_data`
--
ALTER TABLE `student_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_final_grade`
--
ALTER TABLE `student_final_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_availability`
--
ALTER TABLE `course_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_mark`
--
ALTER TABLE `course_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_registration`
--
ALTER TABLE `course_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_data`
--
ALTER TABLE `employee_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_types`
--
ALTER TABLE `employee_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leave_details`
--
ALTER TABLE `leave_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_notifications`
--
ALTER TABLE `leave_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_submission`
--
ALTER TABLE `leave_submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scholarship_submissions`
--
ALTER TABLE `scholarship_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_data`
--
ALTER TABLE `student_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_final_grade`
--
ALTER TABLE `student_final_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
