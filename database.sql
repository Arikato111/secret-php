-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2023 at 06:47 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aden`
--

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `b_id` int(11) NOT NULL,
  `b_name` text NOT NULL,
  `b_date` date NOT NULL,
  `usr_id` int(11) NOT NULL,
  `b_view` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `board_detail`
--

CREATE TABLE `board_detail` (
  `bd_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL,
  `bd_name` varchar(200) NOT NULL,
  `bd_date` date NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cat`
--

CREATE TABLE `cat` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `cat_path` varchar(50) NOT NULL,
  `cat_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `fol_id` int(11) NOT NULL,
  `fol_atk` int(11) NOT NULL,
  `fol_def` int(11) NOT NULL,
  `fol_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `log_id` int(11) NOT NULL,
  `token1` varchar(40) NOT NULL,
  `token2` varchar(40) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `log_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE `poll` (
  `poll_id` int(11) NOT NULL,
  `poll_name` varchar(200) NOT NULL,
  `poll_date` date NOT NULL,
  `usr_id` int(11) NOT NULL,
  `poll_view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll_detail`
--

CREATE TABLE `poll_detail` (
  `pd_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `pd_name` varchar(100) NOT NULL,
  `pd_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll_log`
--

CREATE TABLE `poll_log` (
  `pl_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_detail` text NOT NULL,
  `post_date` date NOT NULL,
  `post_usr_id` int(11) NOT NULL,
  `post_cat_id` int(11) NOT NULL,
  `post_img` varchar(50) NOT NULL,
  `post_view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_detail`
--

CREATE TABLE `post_detail` (
  `pd_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `pd_name` text NOT NULL,
  `pd_date` date NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE `post_like` (
  `pl_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usr`
--

CREATE TABLE `usr` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(200) NOT NULL,
  `usr_bio` varchar(200) NOT NULL,
  `usr_address` text NOT NULL,
  `usr_date` date NOT NULL,
  `usr_email` varchar(100) NOT NULL,
  `usr_tel` varchar(10) NOT NULL,
  `usr_username` varchar(50) NOT NULL,
  `usr_password` varchar(50) NOT NULL,
  `usr_status` varchar(10) NOT NULL,
  `usr_view` int(11) NOT NULL,
  `usr_regis_date` date NOT NULL,
  `usr_img` varchar(50) NOT NULL,
  `google-token` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `usr`
--

INSERT INTO `usr` (`usr_id`, `usr_name`, `usr_bio`, `usr_address`, `usr_date`, `usr_email`, `usr_tel`, `usr_username`, `usr_password`, `usr_status`, `usr_view`, `usr_regis_date`, `usr_img`) VALUES
(5, 'Nawasan Wisitsingkhon', 'Hello world\r\n', '221b.', '2001-11-29', 'arikato110011@gmail.com', '0920392039', 'nawasan', '21232f297a57a5a743894a0e4a801fc3', 'admin', 0, '2023-01-03', 'fd01b05e63706f8b7bccc4e13dac6142.jpg');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `board_detail`
--
ALTER TABLE `board_detail`
  ADD PRIMARY KEY (`bd_id`);

--
-- Indexes for table `cat`
--
ALTER TABLE `cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`fol_id`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`poll_id`);

--
-- Indexes for table `poll_detail`
--
ALTER TABLE `poll_detail`
  ADD PRIMARY KEY (`pd_id`);

--
-- Indexes for table `poll_log`
--
ALTER TABLE `poll_log`
  ADD PRIMARY KEY (`pl_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `post_detail`
--
ALTER TABLE `post_detail`
  ADD PRIMARY KEY (`pd_id`);

--
-- Indexes for table `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`pl_id`);

--
-- Indexes for table `usr`
--
ALTER TABLE `usr`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `board_detail`
--
ALTER TABLE `board_detail`
  MODIFY `bd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cat`
--
ALTER TABLE `cat`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `fol_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `poll_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_detail`
--
ALTER TABLE `poll_detail`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_log`
--
ALTER TABLE `poll_log`
  MODIFY `pl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_detail`
--
ALTER TABLE `post_detail`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_like`
--
ALTER TABLE `post_like`
  MODIFY `pl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usr`
--
ALTER TABLE `usr`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
