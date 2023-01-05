-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2023 at 06:44 AM
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
  `b_name` varchar(200) NOT NULL,
  `b_date` date NOT NULL,
  `usr_id` int(11) NOT NULL,
  `b_view` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`b_id`, `b_name`, `b_date`, `usr_id`, `b_view`, `cat_id`) VALUES
(1, 'วิ่งตอนเช้าหรือตอนนี้ดี', '2023-01-04', 5, 1, 1),
(4, 'ตอนเช้ากินอะไรดี', '2023-01-04', 5, 0, 2),
(6, 'อาหารสุดโปรดของคุณคือ', '2023-01-04', 5, 3, 2),
(7, 'เทคนิคการเก็บเงินที่ใช้บ่อย?', '2023-01-04', 5, 14, 4),
(8, 'ใครเคยกินน้ำแข็งต้มบ้าง อร่อยไหม', '2023-01-05', 5, 4, 6),
(9, 'ขอวิธีนอน 8 ชม. ใน 3 ชม.', '2023-01-05', 5, 11, 1);

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

--
-- Dumping data for table `board_detail`
--

INSERT INTO `board_detail` (`bd_id`, `b_id`, `bd_name`, `bd_date`, `usr_id`) VALUES
(1, 7, 'hello', '2023-01-04', 5),
(2, 7, 'world', '2023-01-04', 5),
(3, 5, 'blockdont', '2023-01-04', 5),
(4, 5, 'asdfasdf', '2023-01-04', 5),
(8, 4, 'ไม่รู้สิ', '2023-01-04', 5),
(9, 4, 'เอ้า ! ถามเองตอบเอง', '2023-01-04', 5);

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
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `fol_id` int(11) NOT NULL,
  `fol_atk` int(11) NOT NULL,
  `fol_def` int(11) NOT NULL,
  `fol_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`fol_id`, `fol_atk`, `fol_def`, `fol_date`) VALUES
(7, 5, 4, '2023-01-04'),
(8, 4, 5, '2023-01-05');

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

--
-- Dumping data for table `poll`
--

INSERT INTO `poll` (`poll_id`, `poll_name`, `poll_date`, `usr_id`, `poll_view`) VALUES
(1, 'block or inline ?', '2023-01-05', 5, 0),
(3, 'asdfasdf', '2023-01-05', 5, 1),
(4, 'asdfsadfads', '2023-01-05', 5, 11),
(6, 'a or b or c?', '2023-01-05', 5, 114);

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

--
-- Dumping data for table `poll_detail`
--

INSERT INTO `poll_detail` (`pd_id`, `poll_id`, `pd_name`, `pd_count`) VALUES
(1, 6, 'hello world', 11),
(2, 6, 'blockdont', 5);

-- --------------------------------------------------------

--
-- Table structure for table `poll_log`
--

CREATE TABLE `poll_log` (
  `pl_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `poll_log`
--

INSERT INTO `poll_log` (`pl_id`, `poll_id`, `usr_id`) VALUES
(1, 6, 5);

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
(4, 'asdfasdfasdfasfasfasf', '2023-01-03', 5, 4, '0c6aa560d2eef28e44a10e01cecba117.jpg', 432),
(7, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 5, 1, '53bdc3d17a12319e4f6ca38039cc7539.jpg', 444),
(8, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 5, 2, 'db76392ac9ba3e50b34f75972c0486d4.jpg', 447),
(9, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 5, 4, '3ab5f56c443d245e21cea3478bd1d800.jpg', 427),
(10, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 5, 6, '91f3382a3b691792a9627f33162b6ec2.jpg', 404),
(11, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore excepturi nesciunt eveniet similique beatae. Quibusdam delectus adipisci repellat voluptas esse eos, doloribus voluptatem vel hic ullam quo ratione odit perspiciatis fugit accusantium ipsam nam ad, dicta rem amet? At dignissimos reprehenderit, veritatis illo perferendis ut rem ipsa? Fugit a soluta distinctio magnam officiis nulla ducimus cupiditate suscipit quas et veritatis officia, minus voluptatem nihil quis commodi accusamus? Reprehenderit exercitationem beatae sequi cupiditate, repudiandae minima vero nihil fugiat, et qui reiciendis eum itaque vel voluptatem officia officiis debitis, quaerat natus! Vitae qui sunt modi dolores quo explicabo quaerat facere eius recusandae!', '2023-01-04', 4, 2, '2d55a1eb9f6412aaf7879375f16934af.jpg', 327);

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
(6, 5, 'hello world', '2023-01-04', 5),
(7, 9, 'hello world', '2023-01-04', 4),
(8, 7, 'comment', '2023-01-04', 4);

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
(8, 7, 5),
(9, 11, 4),
(10, 10, 4),
(11, 9, 4);

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
(4, 'name last-name', 'address', '2002-02-22', 'e@e', '0293039240', 'name', '83878c91171338902e0fe0fb97a8c47a', 'user', 0, '2023-01-03', 'dd9ccc9505a7e220262fd063bea48bde.jpg'),
(5, 'Nawasan Wisitsingkhon', '221b', '2001-11-29', 'arikato110011@gmail.com', '0920392039', 'nawasan', '83878c91171338902e0fe0fb97a8c47a', 'admin', 0, '2023-01-03', '6b6f8debe9fea43347ffb4b9ebe28253.jpg');

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
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `board_detail`
--
ALTER TABLE `board_detail`
  MODIFY `bd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cat`
--
ALTER TABLE `cat`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `fol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `poll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `poll_detail`
--
ALTER TABLE `poll_detail`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `poll_log`
--
ALTER TABLE `poll_log`
  MODIFY `pl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `post_detail`
--
ALTER TABLE `post_detail`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `post_like`
--
ALTER TABLE `post_like`
  MODIFY `pl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usr`
--
ALTER TABLE `usr`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
