-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2023 at 03:21 PM
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
-- Table structure for table `cat`
--

CREATE TABLE `cat` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `cat_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cat`
--

INSERT INTO `cat` (`cat_id`, `cat_name`, `cat_path`) VALUES
(1, 'สุขภาพ', 'health'),
(2, 'อาหาร', 'foods'),
(4, 'การเงิน', 'finance'),
(6, 'อื่นๆ', 'others');

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

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_detail`, `post_date`, `post_usr_id`, `post_cat_id`, `post_img`, `post_view`) VALUES
(4, 'asdfasdfasdfasfasfasf', '2023-01-03', 5, 4, '0c6aa560d2eef28e44a10e01cecba117.jpg', 78),
(7, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 5, 1, '53bdc3d17a12319e4f6ca38039cc7539.jpg', 84),
(8, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 5, 2, 'db76392ac9ba3e50b34f75972c0486d4.jpg', 83),
(9, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 5, 4, '3ab5f56c443d245e21cea3478bd1d800.jpg', 77),
(10, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 5, 6, '91f3382a3b691792a9627f33162b6ec2.jpg', 77);

-- --------------------------------------------------------

--
-- Table structure for table `post_detail`
--

CREATE TABLE `post_detail` (
  `pd_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `pd_name` varchar(200) NOT NULL,
  `pd_date` date NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `post_detail`
--

INSERT INTO `post_detail` (`pd_id`, `post_id`, `pd_name`, `pd_date`, `usr_id`) VALUES
(1, 5, 'hello world', '2023-01-04', 5),
(3, 4, 'hello world', '2023-01-04', 5),
(4, 4, 'world com', '2023-01-04', 5),
(6, 5, 'hello world', '2023-01-04', 5);

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE `post_like` (
  `pl_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `post_like`
--

INSERT INTO `post_like` (`pl_id`, `post_id`, `usr_id`) VALUES
(5, 4, 5),
(6, 4, 5),
(7, 5, 5),
(8, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `usr`
--

CREATE TABLE `usr` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(200) NOT NULL,
  `usr_address` text NOT NULL,
  `usr_date` date NOT NULL,
  `usr_email` varchar(100) NOT NULL,
  `usr_tel` varchar(10) NOT NULL,
  `usr_username` varchar(50) NOT NULL,
  `usr_password` varchar(50) NOT NULL,
  `usr_status` varchar(10) NOT NULL,
  `usr_view` int(11) NOT NULL,
  `usr_regis_date` date NOT NULL,
  `usr_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `usr`
--

INSERT INTO `usr` (`usr_id`, `usr_name`, `usr_address`, `usr_date`, `usr_email`, `usr_tel`, `usr_username`, `usr_password`, `usr_status`, `usr_view`, `usr_regis_date`, `usr_img`) VALUES
(4, 'name last-name', 'address', '2002-02-22', 'e@e', '0293039240', 'name', '900150983cd24fb0d6963f7d28e17f72', 'user', 0, '2023-01-03', '3d2ce37ae52e87bab6b305619ac7cb9e.jpg'),
(5, 'Nawasan Wisitsingkhon', '221b', '2001-11-29', 'arikato110011@gmail.com', '0920392039', 'nawasan', '83878c91171338902e0fe0fb97a8c47a', 'user', 0, '2023-01-03', '6b6f8debe9fea43347ffb4b9ebe28253.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cat`
--
ALTER TABLE `cat`
  ADD PRIMARY KEY (`cat_id`);

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
-- AUTO_INCREMENT for table `cat`
--
ALTER TABLE `cat`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_detail`
--
ALTER TABLE `post_detail`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `post_like`
--
ALTER TABLE `post_like`
  MODIFY `pl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usr`
--
ALTER TABLE `usr`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
