-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2025 at 11:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_detail`
--

CREATE TABLE `admin_detail` (
  `admin_detail_id` int(11) NOT NULL,
  `admin_username` varchar(500) NOT NULL,
  `admin_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_detail`
--

INSERT INTO `admin_detail` (`admin_detail_id`, `admin_username`, `admin_password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz`
--

CREATE TABLE `tbl_quiz` (
  `tbl_quiz_id` int(11) NOT NULL,
  `quiz_question` varchar(500) NOT NULL,
  `option_a` varchar(500) NOT NULL,
  `option_b` varchar(500) NOT NULL,
  `option_c` varchar(500) NOT NULL,
  `option_d` varchar(500) NOT NULL,
  `correct_answer` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_result`
--

CREATE TABLE `tbl_result` (
  `tbl_result_id` int(11) NOT NULL,
  `quiz_taker` varchar(100) NOT NULL,
  `year_section` varchar(30) NOT NULL,
  `total_score` int(50) NOT NULL,
  `date_taken` varchar(10) NOT NULL,
  `has_taken_quiz` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `user_detail_id` int(11) NOT NULL,
  `user_name` varchar(500) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_fullname` varchar(200) NOT NULL,
  `user_department` varchar(200) NOT NULL,
  `mat_no` varchar(200) NOT NULL,
  `quiz_taken` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_detail`
--
ALTER TABLE `admin_detail`
  ADD PRIMARY KEY (`admin_detail_id`);

--
-- Indexes for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  ADD PRIMARY KEY (`tbl_quiz_id`);

--
-- Indexes for table `tbl_result`
--
ALTER TABLE `tbl_result`
  ADD PRIMARY KEY (`tbl_result_id`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`user_detail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_detail`
--
ALTER TABLE `admin_detail`
  MODIFY `admin_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  MODIFY `tbl_quiz_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_result`
--
ALTER TABLE `tbl_result`
  MODIFY `tbl_result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_detail`
--
ALTER TABLE `user_detail`
  MODIFY `user_detail_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
