-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2021 at 08:42 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaagha`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `p_id` bigint(50) NOT NULL,
  `user_name` text NOT NULL,
  `bank_name` text NOT NULL,
  `sort_code` text NOT NULL,
  `account_num` text NOT NULL,
  `com_tandc` text NOT NULL,
  `tandc_date` text NOT NULL,
  `p_tandc` text NOT NULL,
  `p_tandc_date` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `u_id`, `p_id`, `user_name`, `bank_name`, `sort_code`, `account_num`, `com_tandc`, `tandc_date`, `p_tandc`, `p_tandc_date`, `status`) VALUES
(5, 22, 9, 'abc', 'AGSHA', '123456', '12345678', '1', '2021-03-24\r\n', '1', '2021-03-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(50) NOT NULL,
  `reg_num` text NOT NULL,
  `com_name` text NOT NULL,
  `address` text NOT NULL,
  `tr_address` text NOT NULL,
  `post` text NOT NULL,
  `cpost` text NOT NULL,
  `vat` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL,
  `logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `reg_num`, `com_name`, `address`, `tr_address`, `post`, `cpost`, `vat`, `time_stamp`, `status`, `logo`) VALUES
(6, '123456', 'Cyber Flow', 'Village-Kanhra,PO-Dagroli\r\nDistt-Charkhi Dadri,haryana', 'Village-Kanhra,PO-Dagroli\r\nDistt-Charkhi Dadri,haryana', '127306', '123', '231efds', '2021-03-27 04:14:01', 1, './uploads/medium/7061609903739.jpg'),
(9, '789105678', 'Raaaass', 'Gayatri puram miyanwala dehradun', 'Gayatri puram miyanwala dehradun', '248005', '', 'r34352', '2021-02-26 02:49:40', 1, ''),
(16, '13044297', 'VAAGHA TECHNOLOGY SERVICE LIMITED', '89  Wemborough Road, Stanmore, England, HA7 2ED', '89  Wemborough Road, Stanmore, England, HA7 2ED', 'HA7 2ED', 'HA7 2ED', '1234', '2021-03-24 18:36:02', 1, ''),
(17, '8976', 'newnewtest', 'Gayatri puram miyanwala dehradun', '', '248001', '', '4567', '2021-03-24 18:35:53', 1, ''),
(18, '8976', 'Raaaass', 'rrrr', '', '248001', '', '345', '2021-03-24 18:35:51', 1, ''),
(21, '1211', 'fgh', 'Gayatri puram miyanwala dehradun', 'gg', '1212', '567', '345sdcfgrtew', '2021-03-24 18:43:39', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `com_admins`
--

CREATE TABLE `com_admins` (
  `id` bigint(50) NOT NULL,
  `c_id` bigint(20) NOT NULL,
  `f_name` text NOT NULL,
  `l_name` text NOT NULL,
  `email` text NOT NULL,
  `m_num` text NOT NULL,
  `password` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `com_admins`
--

INSERT INTO `com_admins` (`id`, `c_id`, `f_name`, `l_name`, `email`, `m_num`, `password`, `time_stamp`, `type`, `status`) VALUES
(5, 6, 'Sumit', 'Kumar', 'p@gmail.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '2021-03-24 18:32:14', 1, 1),
(6, 6, 'asd', 'ewrdfs', 'email@gmail.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '2021-04-08 14:48:14', 2, 1),
(12, 10, 'ds', 'dscvsdcv', 'a@gmail.com', '', '202cb962ac59075b964b07152d234b70', '2021-02-23 14:08:48', 0, 1),
(19, 16, 'com', 'last', 'c1@gmail.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '2021-03-02 15:34:42', 1, 1),
(20, 6, 'pmananager', 'mannager ', 'r@gmail.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '2021-04-11 01:52:33', 2, 1),
(21, 6, 'pmm', 'last', 'pm@gmail.comm', '12345', '', '2021-04-08 14:48:00', 2, 1),
(22, 6, 'pne', 'hjj', 'mail@gmail.com', '5567', '', '2021-04-08 14:47:46', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` bigint(50) NOT NULL,
  `name` text NOT NULL,
  `greetings` text NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `endgreetings` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `name`, `greetings`, `subject`, `body`, `endgreetings`) VALUES
(3, 'Provide Bank Details', 'Dear [SALUTATION] [FIRST NAME] [LAST NAME]', 'Bank details for payment of research project [PROJECT TITLE]', 'Many thanks for taking part in our research about [PROJECT TITLE].\r\n\r\nYou are now eligible for a payment of £[INCENTIVE].  To pay you the incentive amount we need your bank details. Kindly click on the link below to provide your bank details.\r\n\r\nEnter bank details [LINK].\r\n', 'Sincerely, [PM FIRST Name] [PM LAST Name], [PM CONTACT NUMBER]'),
(4, '1st reminder – Pending bank details', 'Dear [SALUTATION] [FIRST NAME] [LAST NAME]', 'Gentle Reminder - Pending bank details for research project [PROJECT TITLE]', 'Many thanks for taking part in our research about [PROJECT TITLE].\r\n\r\nYou are now eligible for a payment of £[INCENTIVE]. To pay you the incentive amount we need your bank details. Kindly click on the link below to provide your bank details.\r\nThis is a gentle reminder to provide your bank details. \r\nEnter bank details [LINK]\r\n\r\n', 'Sincerely , [PM FIRST Name] [PM LAST Name], [PM CONTACT NUMBER]'),
(5, '1st reminder - Pending T&Cs', 'Dear [SALUTATION] [FIRST NAME] [LAST NAME]', 'Pending T&Cs signature for research project [PROJECT TITLE]', '<br>Many thanks for taking part in our research about [PROJECT TITLE] and providing your bank details.<br><br>To enable us to pay you the incentive amount we need you need to digitally sign the project terms & conditions.<br><br>Kindly click on the link below to digitally sign the project terms & conditions.<br>Sign T&Cs now [LINK]<br>\r\n', 'Sincerely,<br>[PM FIRST Name] [PM LAST Name]<br>[PM CONTACT NUMBER]');

-- --------------------------------------------------------

--
-- Table structure for table `group_details`
--

CREATE TABLE `group_details` (
  `id` bigint(50) NOT NULL,
  `p_id` bigint(50) NOT NULL,
  `user_count` text NOT NULL,
  `name` text NOT NULL,
  `recruiter` text NOT NULL,
  `incentive` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` text NOT NULL,
  `venue` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_details`
--

INSERT INTO `group_details` (`id`, `p_id`, `user_count`, `name`, `recruiter`, `incentive`, `time_stamp`, `email`, `venue`, `status`) VALUES
(231, 69, '11', 'group1', '', '101', '2021-02-26 04:26:50', '', '', 1),
(232, 69, '11', 'group2', '', '101', '2021-02-26 04:26:50', '', '', 1),
(233, 69, '10', 'group3', '', '101', '2021-02-26 04:26:50', '', '', 1),
(234, 69, '10', 'group4', '', '101', '2021-02-26 04:26:50', '', '', 1),
(235, 69, '10', 'group5', '', '101', '2021-02-26 04:26:50', '', '', 1),
(236, 69, '10', 'group6', '', '101', '2021-02-26 04:26:50', '', '', 1),
(237, 69, '10', 'group7', '', '101', '2021-02-26 04:26:50', '', '', 1),
(238, 69, '10', 'group8', '', '101', '2021-02-26 04:26:50', '', '', 1),
(239, 69, '10', 'group9', '', '101', '2021-02-26 04:26:50', '', '', 1),
(240, 69, '10', 'group10', '', '101', '2021-02-26 04:26:50', '', '', 1),
(241, 69, '10', 'group11', '', '101', '2021-02-26 04:26:50', '', '', 1),
(242, 69, '10', 'group12', '', '10', '2021-02-26 03:17:15', '', '', 1),
(243, 71, '20', 'group1', '', '5000', '2021-02-26 06:48:21', '', '', 1),
(244, 71, '20', 'group2', '', '5000', '2021-02-26 06:48:21', '', '', 1),
(245, 72, '20', 'group1', '', '5000', '2021-02-26 06:49:12', '', '', 1),
(246, 72, '20', 'group2', '', '5000', '2021-02-26 06:49:12', '', '', 1),
(247, 73, '20', 'group1', '', '5000', '2021-02-26 06:49:45', '', '', 1),
(248, 73, '20', 'group2', '', '5000', '2021-02-26 06:49:45', '', '', 1),
(249, 74, '1', 'group1', '', '1212', '2021-02-26 07:18:23', '', '', 1),
(250, 75, '1', 'group1', '', '1', '2021-02-26 07:23:51', '', '', 1),
(251, 76, '21', 'group1', '', '1', '2021-02-26 07:25:34', '', '', 1),
(252, 78, '10', 'group1', '', '1000', '2021-03-02 13:21:23', '', '', 1),
(253, 78, '10', 'group2', '', '1000', '2021-03-02 13:21:23', '', '', 1),
(254, 78, '10', 'group3', '', '1000', '2021-03-02 13:21:23', '', '', 1),
(255, 78, '10', 'group4', '', '1000', '2021-03-02 13:21:23', '', '', 1),
(256, 78, '10', 'group5', '', '1000', '2021-03-02 13:21:23', '', '', 1),
(257, 78, '10', 'group6', '', '1000', '2021-03-02 13:21:23', '', '', 1),
(258, 78, '10', 'group7', '', '1000', '2021-03-02 13:21:23', '', '', 1),
(259, 78, '10', 'group8', '', '1000', '2021-03-02 13:21:23', '', '', 1),
(260, 78, '10', 'group9', '', '1000', '2021-03-02 13:21:24', '', '', 1),
(261, 78, '10', 'group10', '', '1000', '2021-03-02 13:21:24', '', '', 1),
(262, 79, '-3', 'group1', '', '13', '2021-03-02 15:08:22', '', '', 1),
(263, 80, '1', 'group1', '', '500', '2021-03-02 15:11:25', '', '', 1),
(264, 80, '0', 'group2', '', '500', '2021-03-02 15:11:25', '', '', 1),
(265, 9, '3', 'group1', '', '4750', '2021-03-26 16:28:44', '', '', 1),
(266, 9, '3', 'group2', '', '4750', '2021-03-26 16:28:44', '', '', 1),
(267, 9, '3', 'group3', '', '4750', '2021-03-26 16:28:44', '', '', 1),
(268, 9, '3', 'group4', '', '4750', '2021-03-26 16:28:44', '', '', 1),
(269, 81, '11', 'group1', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(270, 81, '10', 'group2', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(271, 81, '10', 'group3', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(272, 81, '10', 'group4', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(273, 81, '10', 'group5', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(274, 81, '10', 'group6', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(275, 81, '10', 'group7', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(276, 81, '10', 'group8', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(277, 81, '10', 'group9', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(278, 81, '10', 'group10', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(279, 81, '10', 'group11', '', '3806', '2021-03-26 16:29:24', '', '', 1),
(280, 81, '10', 'group12', '', '3806', '2021-03-26 16:29:24', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE `group_users` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `g_id` bigint(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_users`
--

INSERT INTO `group_users` (`id`, `u_id`, `g_id`, `status`) VALUES
(17, 4, 252, 1),
(18, 5, 232, 1),
(19, 6, 233, 1),
(20, 20, 252, 3),
(21, 4, 153, 1),
(22, 5, 153, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_admin`
--

CREATE TABLE `master_admin` (
  `id` bigint(50) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_pic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_admin`
--

INSERT INTO `master_admin` (`id`, `email`, `password`, `name`, `time_stamp`, `user_pic`) VALUES
(1, 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', '2021-02-18 12:57:54', './uploads/medium/5801613653074.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(50) NOT NULL,
  `pm_id` bigint(20) NOT NULL,
  `cm_id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `incentive` text NOT NULL,
  `start_date` text NOT NULL,
  `group_num` text NOT NULL,
  `participants` text NOT NULL,
  `project_reference` text NOT NULL,
  `termandcondition` int(11) DEFAULT NULL COMMENT '1-yes\r\n2-no',
  `signortick` int(11) DEFAULT NULL COMMENT '1-sign\r\n2-tick',
  `tandcfile` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `pm_id`, `cm_id`, `title`, `description`, `incentive`, `start_date`, `group_num`, `participants`, `project_reference`, `termandcondition`, `signortick`, `tandcfile`, `status`) VALUES
(9, 20, 6, 'pqrst', 'urioednbfhjv ', '19000', '2021-03-23', '4', '12', 'pro_ref', NULL, NULL, '', 0),
(10, 2, 6, 'uvwxyz', 'yridkcmv nmv cxdkjfhv', '31500', '28-04-2020', '', '', '', NULL, NULL, '', 0),
(11, 3, 9, 'abcdefgh', 'nfkmd hdvf fn ewhsdj', '34254', '03-03-2021', '', '', '', NULL, NULL, '', 0),
(12, 5, 9, 'ijklmnopq', 'djasjcvv efjnd wejfnws ejhesjwnd', '12345', '29-01-2020', '', '', '', NULL, NULL, '', 1),
(13, 3, 9, 'raaaa', 'nvjfhyr teiwopdej fdhcnxm', '23452', '12-09-2021', '', '', '', NULL, NULL, '', 1),
(14, 5, 9, 'p112', 'hello hello', '15000', '11-11-2020', '', '', '', NULL, NULL, '', 1),
(15, 2, 6, 'p221', '   heeeeeeeee hiiiiii', '10000', '07-09-2021', '', '', 'pp', NULL, NULL, '', 1),
(16, 6, 6, 'hjkl', '     gfcfc rtyuhj nbvc ', '2111', '2021-01-24', '', '', '', 1, 2, '', 1),
(18, 3, 9, 'jhhjhj', '   xcvbnm', '33333', '09-04-2021', '', '', '', NULL, NULL, '', 1),
(19, 2, 6, 'qwer', '   gbb', '76453', '26-10-2021', '', '', '', NULL, NULL, '', 1),
(69, 9, 9, 'np', '     ghsabjxck ', '1220', '2021-03-03', '12', '122', '', NULL, NULL, '', 1),
(82, 20, 6, 'testtitle', ' descwewefsds', '45678', '2021-04-28', '11', '122', 'pay check', 1, 0, '', 1),
(83, 20, 6, 'hjkl', ' sdfghfgfdsdewrty', '10000', '2021-04-22', '10', '100', 'pay check', 1, 0, '', 1),
(84, 20, 6, 'abcd', ' dsncxkmdsjkwe', '10000', '2021-04-29', '10', '100', 'pay check', 1, 0, '', 1),
(85, 20, 6, 'wdsf', ' xsdcfgbdsa', '10000', '2021-04-20', '10', '115', 'pay check', 1, 1, '', 1),
(86, 20, 6, 'ahsxmjasmk', ' gsajhsjmaksjz', '10000', '2021-04-20', '10', '100', 'ppp1', 1, 1, '', 1),
(87, 20, 6, 'axscsscxdhj', ' HZXgyuiaKJXZhx', '10000', '2021-04-27', '10', '100', 'ppp1', 1, 1, 'uploads/Java outputs Comlete except 1 question.1617364123.docx', 1),
(88, 20, 0, 'csv check', 'csv check test', '20000', '', '10', '100', 'rashi', 1, NULL, '', 0),
(89, 20, 0, 'csv check', 'csv check test', '20000', '', '10', '100', 'rashi', 1, NULL, '', 0),
(90, 6, 0, 'check2', 'test', '1000', '', '11', '121', 'p2', 2, NULL, '', 0),
(91, 6, 0, 'chck 3', 'test2', '1000', '', '10', '100', 'p3', 2, NULL, '', 0),
(92, 20, 6, 'newtest', ' descripton test', '15000', '2021-04-15', '10', '111', 'reff', 1, 1, 'uploads/ProjectWize_Payments Module Workflow _DraftV0.5.1617861394.docx', 1),
(93, 6, 6, 'test2', ' hbmn ,m', '12345', '2021-04-28', '10', '100', 'fhgvh', 2, 0, '', 1),
(94, 20, 6, 'csv check', 'csv check test', '20000', '', '10', '100', 'rashi', 1, NULL, '', 0),
(95, 6, 0, 'check2', 'test', '1000', '', '11', '121', 'p2', 2, NULL, '', 0),
(96, 6, 0, 'chck 3', 'test2', '1000', '', '10', '100', 'p3', 2, NULL, '', 0),
(97, 20, 0, 'csv check', 'csv check test', '20000', '', '10', '100', 'rashi', 1, NULL, '', 0),
(98, 6, 0, 'check2', 'test', '1000', '', '11', '121', 'p2', 2, NULL, '', 0),
(99, 6, 0, 'chck 3', 'test2', '1000', '', '10', '100', 'p3', 2, NULL, '', 0),
(100, 20, 0, 'csv check', 'csv check test', '20000', '', '10', '100', 'rashi', 1, NULL, '', 0),
(101, 6, 0, 'check2', 'test', '1000', '', '11', '121', 'p2', 2, NULL, '', 0),
(102, 6, 0, 'chck 3', 'test2', '1000', '', '10', '100', 'p3', 2, NULL, '', 0),
(103, 0, 0, 'csv check', 'csv check test', '20000', '', '10', '100', 'rashi', 1, NULL, '', 0),
(104, 6, 0, 'check2', 'test', '1000', '', '11', '121', 'p2', 2, NULL, '', 0),
(105, 6, 0, 'chck 3', 'test2', '1000', '', '10', '100', 'p3', 2, NULL, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` bigint(50) NOT NULL,
  `p_id` bigint(50) NOT NULL,
  `file` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_files`
--

INSERT INTO `project_files` (`id`, `p_id`, `file`, `time_stamp`) VALUES
(2, 45, 'http://localhost/vaagha/manager/uploads./SYLLOG 2.1613315614.pdf', '2021-02-14 15:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(50) NOT NULL,
  `com_id` bigint(50) NOT NULL,
  `pm_id` bigint(50) NOT NULL,
  `p_id` bigint(50) NOT NULL,
  `salutation` text NOT NULL,
  `f_name` text NOT NULL,
  `l_name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `m_num` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address` text NOT NULL,
  `status` int(11) NOT NULL,
  `user_pic` longtext NOT NULL,
  `pay_reference` text NOT NULL,
  `p_tandc` text NOT NULL,
  `incentive` text NOT NULL,
  `pay_status` text NOT NULL COMMENT '1-email\r\n2-bank_details\r\n3-bank_detailsconfirm\r\n4-tandc\r\n5-paid\r\n6-nothing',
  `email_date` date NOT NULL,
  `paid_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `com_id`, `pm_id`, `p_id`, `salutation`, `f_name`, `l_name`, `email`, `password`, `m_num`, `timestamp`, `address`, `status`, `user_pic`, `pay_reference`, `p_tandc`, `incentive`, `pay_status`, `email_date`, `paid_date`) VALUES
(1, 6, 10, 21, '', 'tgh', 'user1.1', 'user1.1@gmail.com', '24c9e15e52afc47c225b757e7bee1f9d', '2567837467', '2021-04-08 12:00:18', 'dehradun2', 0, '', '', '', '', '', '0000-00-00', ''),
(2, 6, 13, 31, '', '', 'user2', 'user2@gmail.com', '7e58d63b60197ceb55a1c487989a3720', '1234567890', '2021-04-04 06:45:11', 'Gayatri puram ', 1, '', '', '', '', '', '0000-00-00', ''),
(5, 6, 16, 5, '', '', 'user5', 'user5@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', '8726453289', '2021-04-04 06:44:49', 'isbt', 1, '', '', '', '', '', '0000-00-00', ''),
(9, 6, 6, 16, 'Miss', 'Raashi', 'Khatri', 'rashikhatri0013@gmail.com', '', '7654345890', '2021-04-11 02:19:54', 'Gayatri puram miyanwala dehradun', 2, '', '', '', '1234', '1', '2021-04-11', ''),
(10, 6, 9, 10, '', '', '', 'user9@gmail.com', '', '', '2021-02-18 07:17:16', '', 2, '', '', '', '', '', '0000-00-00', ''),
(11, 6, 15, 25, '', '', '', 'user10@gmail.com', '', '', '2021-04-04 06:44:40', '', 2, '', '', '', '', '', '0000-00-00', ''),
(13, 6, 6, 16, 'Mr.', 'Pancham', 'Sheoran', 'panchamsheoran@gmail.com', '', '', '2021-04-11 05:34:13', '', 2, '', '', '', '34', '6', '2021-03-25', ''),
(14, 6, 20, 84, '', '', '', 'unew@gmail.com', '', '', '2021-04-11 05:34:28', '', 2, '', '', '', '', '6', '2021-01-12', ''),
(15, 6, 20, 94, ' ', 'FIRST', 'p11', 'user11@gmail.com', '1234', '74389', '2021-04-11 06:21:54', 'Gayatri puram miyanwala dehradun', 1, '', 'payref', '', '432', '6', '2020-05-12', ''),
(16, 6, 9, 27, '', '', 'anzs', 'user12@gmail.com', '', '7654345890', '2021-03-26 16:13:20', 'Gayatri puram miyanwala dehradun', 1, '', '', '', '', '', '0000-00-00', ''),
(17, 6, 20, 9, '', '', 'raashi', 'ppppp@gmail.com', '', '2345', '2021-04-11 05:34:54', 'Gayatri puram miyanwala dehradun', 1, '', '', '', '1234', '5', '2020-12-17', ''),
(22, 6, 20, 9, '', '', 'raa', 'pay@gmail.com', '12345', '81268285', '2021-04-11 05:35:08', 'harrawala', 1, '', '', '', '11233', '4', '2021-01-17', ''),
(28, 6, 20, 9, '', 'f', 'l', 'u@gmail.com', '', '7302248', '2021-04-11 05:35:42', '', 1, '', 'pay_ref', '', '2345', '1', '2021-02-22', ''),
(29, 6, 20, 92, '', '', 'check2', 'raashikhatri3473@gmail.com', '', '2345432', '2021-04-11 03:56:04', 'Gayatri puram miyanwala dehradun', 1, '', 'pay\'-ref', '', '123456', '3', '2021-04-11', ''),
(30, 6, 20, 94, 'Miss.', 'ras', 'last', 'ugvh2@gmail.com', '', '76789', '2021-04-11 01:53:48', '', 1, '', '', '', '432', '', '0000-00-00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_id` (`u_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_admins`
--
ALTER TABLE `com_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_details`
--
ALTER TABLE `group_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_users`
--
ALTER TABLE `group_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_admin`
--
ALTER TABLE `master_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
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
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `com_admins`
--
ALTER TABLE `com_admins`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `group_details`
--
ALTER TABLE `group_details`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `group_users`
--
ALTER TABLE `group_users`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `master_admin`
--
ALTER TABLE `master_admin`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
