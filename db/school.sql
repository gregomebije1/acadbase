-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2017 at 04:40 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL,
  `account_type_id` int(11) NOT NULL DEFAULT '0',
  `entity_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `code` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `d_created` date DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `children` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `account_type_id`, `entity_id`, `name`, `code`, `description`, `d_created`, `parent`, `children`) VALUES
(1, 5, 1, 'Cash', NULL, NULL, '2012-09-11', 0, 0),
(2, 5, 1, 'Petty Cash', NULL, NULL, '2012-09-11', 0, 0),
(3, 5, 1, 'Bank', NULL, NULL, '2012-09-11', 0, 0),
(4, 10, 1, 'Sales', NULL, NULL, '2012-09-11', 0, 0),
(5, 5, 1, 'Inventory', NULL, NULL, '2012-09-11', 0, 0),
(6, 4, 1, 'VAT', NULL, NULL, '2012-09-11', 0, 0),
(7, 4, 1, 'WHT', NULL, NULL, '2012-09-11', 0, 0),
(8, 3, 1, 'FOSLA ACADEMY', '', '', '2012-09-11', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

DROP TABLE IF EXISTS `account_type`;
CREATE TABLE IF NOT EXISTS `account_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`id`, `name`) VALUES
(1, 'Fixed Assets'),
(2, 'Account Payable'),
(3, 'Account Receivable'),
(4, 'Other Currrent Liabilities'),
(5, 'Other Currrent Assets'),
(6, 'Long Term Liabilities'),
(7, 'Expenses'),
(8, 'Equity'),
(9, 'Sales Returns and Allowances'),
(10, 'Income'),
(11, 'Opening Stock'),
(12, 'Purchases Returns and Allowances'),
(13, 'Purchases'),
(14, 'Closing Stock');

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

DROP TABLE IF EXISTS `audit_trail`;
CREATE TABLE IF NOT EXISTS `audit_trail` (
  `id` int(11) NOT NULL,
  `dt` datetime DEFAULT NULL,
  `staff_id` varchar(100) DEFAULT NULL,
  `descr` text,
  `ot` text,
  `dt2` date DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id`, `dt`, `staff_id`, `descr`, `ot`, `dt2`) VALUES
(1, '2012-09-11 09:12:31', '2', 'Date of Payment: 2012-09-11 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-11\n    Expiration Date: 2012-10-11 1 month free subscription - 0', '', '2012-09-11'),
(2, '2012-09-12 13:37:25', '28', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(3, '2012-09-12 13:49:23', '30', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(4, '2012-09-12 13:53:53', '31', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(5, '2012-09-12 13:55:02', '32', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(6, '2012-09-12 13:59:43', '34', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(7, '2012-09-12 14:09:41', '35', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(8, '2012-09-12 14:26:49', '37', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(9, '2012-09-12 14:29:52', '38', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(10, '2012-09-12 14:32:02', '39', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(11, '2012-09-12 09:42:23', '40', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(12, '2012-09-12 10:41:59', '43', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(13, '2012-09-12 13:26:55', '46', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', '', '2012-09-12'),
(14, '2012-09-13 02:16:31', '50', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(15, '2012-09-13 02:21:45', '52', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(16, '2012-09-13 02:56:20', '53', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(17, '2012-09-13 04:15:08', '54', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(18, '2012-09-13 04:35:44', '55', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(19, '2012-09-13 10:11:50', '58', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(20, '2012-09-13 11:33:35', '61', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(21, '2012-09-13 15:13:51', '66', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(22, '2012-09-13 15:32:59', '67', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(23, '2012-09-13 15:40:30', '68', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', '', '2012-09-13'),
(24, '2012-09-14 04:14:32', '70', 'Date of Payment: 2012-09-14 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-14\n    Expiration Date: 2012-10-14 1 month free subscription - 0', '', '2012-09-14'),
(25, '2012-09-17 06:37:14', '73', 'Date of Payment: 2012-09-17 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-17\n    Expiration Date: 2012-10-17 1 month free subscription - 0', '', '2012-09-17'),
(26, '2012-10-02 02:08:42', '74', 'Date of Payment: 2012-10-02 \n    Years of Subscription: 1 month\n    Activation Date: 2012-10-02\n    Expiration Date: 2012-11-02 1 month free subscription - 0', '', '2012-10-02'),
(27, '2012-10-20 09:25:02', '75', 'Date of Payment: 2012-10-20 \n    Years of Subscription: 1 month\n    Activation Date: 2012-10-20\n    Expiration Date: 2012-11-20 1 month free subscription - 0', '', '2012-10-20'),
(28, '2012-11-02 00:37:33', '76', 'Date of Payment: 2012-11-02 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-02\n    Expiration Date: 2012-12-02 1 month free subscription - 0', '', '2012-11-02'),
(29, '2012-11-08 04:36:41', '77', 'Date of Payment: 2012-11-08 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-08\n    Expiration Date: 2012-12-08 1 month free subscription - 0', '', '2012-11-08'),
(30, '2012-11-10 23:30:54', '78', 'Date of Payment: 2012-11-10 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-10\n    Expiration Date: 2012-12-10 1 month free subscription - 0', '', '2012-11-10'),
(31, '2012-11-12 08:54:22', '79', 'Date of Payment: 2012-11-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-12\n    Expiration Date: 2012-12-12 1 month free subscription - 0', '', '2012-11-12'),
(32, '2012-11-13 03:08:04', '80', 'Date of Payment: 2012-11-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-13\n    Expiration Date: 2012-12-13 1 month free subscription - 0', '', '2012-11-13'),
(33, '2012-11-15 00:52:19', '83', 'Date of Payment: 2012-11-15 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-15\n    Expiration Date: 2013-11-15 1 month free subscription - 0', '', '2012-11-15'),
(34, '2012-11-21 16:05:41', '84', 'Date of Payment: 2012-11-21 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-21\n    Expiration Date: 2013-11-21 1 month free subscription - 0', '', '2012-11-21'),
(35, '2012-11-22 04:06:26', '85', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', '', '2012-11-22'),
(36, '2012-11-22 04:11:15', '86', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', '', '2012-11-22'),
(37, '2012-11-22 04:42:33', '87', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', '', '2012-11-22'),
(38, '2012-11-22 05:55:38', '88', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', '', '2012-11-22'),
(39, '2012-11-22 11:32:50', '89', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', '', '2012-11-22'),
(40, '2012-11-22 14:42:23', '90', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', '', '2012-11-22'),
(41, '2012-11-28 04:15:41', '91', 'Date of Payment: 2012-11-28 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-28\n    Expiration Date: 2013-11-28 1 month free subscription - 0', '', '2012-11-28'),
(42, '2012-12-03 09:43:50', '92', 'Date of Payment: 2012-12-03 \n    Years of Subscription: 1 year\n    Activation Date: 2012-12-03\n    Expiration Date: 2013-12-03 1 month free subscription - 0', '', '2012-12-03'),
(43, '2012-12-03 10:09:19', '95', 'Date of Payment: 2012-12-03 \n    Years of Subscription: 1 year\n    Activation Date: 2012-12-03\n    Expiration Date: 2013-12-03 1 month free subscription - 0', '', '2012-12-03');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `class_type_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`, `class_type_id`, `school_id`) VALUES
(1, 'Nursery 1', 1, 1),
(2, 'Class 1', 2, 1),
(3, 'JSS1A', 3, 1),
(4, 'JSS1B', 3, 1),
(180, 'JSS2B', 3, 1),
(179, 'JSS2A', 3, 1),
(181, 'JSS3A', 3, 1),
(182, 'JSS3B', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `class_type`
--

DROP TABLE IF EXISTS `class_type`;
CREATE TABLE IF NOT EXISTS `class_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_type`
--

INSERT INTO `class_type` (`id`, `name`, `description`, `school_id`) VALUES
(1, 'Nursery', 'Nursery', 1),
(2, 'Primary', 'Primary', 1),
(3, 'JSS', 'Junior Secondary School', 1),
(4, 'SSS', 'Senior Secondary School', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grade_settings`
--

DROP TABLE IF EXISTS `grade_settings`;
CREATE TABLE IF NOT EXISTS `grade_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `low` varchar(100) DEFAULT NULL,
  `high` varchar(100) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=247 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade_settings`
--

INSERT INTO `grade_settings` (`id`, `name`, `low`, `high`, `school_id`) VALUES
(1, 'A', '75', '100', 1),
(2, 'B', '60', '74', 1),
(3, 'C', '50', '59', 1),
(4, 'D', '45', '49', 1),
(5, 'E', '40', '44', 1),
(6, 'F', '0', '39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

DROP TABLE IF EXISTS `journal`;
CREATE TABLE IF NOT EXISTS `journal` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `entity_id` int(11) NOT NULL DEFAULT '0',
  `d_entry` date NOT NULL DEFAULT '0000-00-00',
  `descr` text NOT NULL,
  `t_type` varchar(100) NOT NULL DEFAULT '',
  `amt` varchar(100) NOT NULL DEFAULT '',
  `folio` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`id`, `account_id`, `entity_id`, `d_entry`, `descr`, `t_type`, `amt`, `folio`) VALUES
(1, 8, 1, '2012-09-11', 'Date of Payment: 2012-09-11 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-11\n    Expiration Date: 2012-10-11 1 month free subscription - 0', 'Debit', '0', ''),
(2, 4, 1, '2012-09-11', 'Date of Payment: 2012-09-11 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-11\n    Expiration Date: 2012-10-11 1 month free subscription - 0', 'Credit', '0', ''),
(3, 8, 1, '2012-09-11', 'Date of Payment: 2012-09-11 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-11\n    Expiration Date: 2012-10-11 1 month free subscription - 0', 'Credit', '0', '4'),
(4, 1, 1, '2012-09-11', 'Date of Payment: 2012-09-11 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-11\n    Expiration Date: 2012-10-11 1 month free subscription - 0', 'Debit', '0', '3'),
(6, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(8, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '7'),
(10, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(12, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '11'),
(14, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(16, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '15'),
(18, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(20, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '19'),
(22, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(24, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '23'),
(26, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(28, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '27'),
(30, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(32, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '31'),
(34, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(36, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '35'),
(38, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(40, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '39'),
(42, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(82, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(44, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '43'),
(46, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(84, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '83'),
(48, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '47'),
(50, 4, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Credit', '0', ''),
(78, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(52, 1, 1, '2012-09-12', 'Date of Payment: 2012-09-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-12\n    Expiration Date: 2012-10-12 1 month free subscription - 0', 'Debit', '0', '51'),
(54, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(56, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '55'),
(76, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '75'),
(74, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(58, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(60, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '59'),
(72, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '71'),
(62, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(70, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(64, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '63'),
(66, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(80, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '79'),
(68, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '67'),
(86, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(88, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '87'),
(90, 4, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Credit', '0', ''),
(92, 1, 1, '2012-09-13', 'Date of Payment: 2012-09-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-13\n    Expiration Date: 2012-10-13 1 month free subscription - 0', 'Debit', '0', '91'),
(94, 4, 1, '2012-09-14', 'Date of Payment: 2012-09-14 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-14\n    Expiration Date: 2012-10-14 1 month free subscription - 0', 'Credit', '0', ''),
(96, 1, 1, '2012-09-14', 'Date of Payment: 2012-09-14 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-14\n    Expiration Date: 2012-10-14 1 month free subscription - 0', 'Debit', '0', '95'),
(98, 4, 1, '2012-09-17', 'Date of Payment: 2012-09-17 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-17\n    Expiration Date: 2012-10-17 1 month free subscription - 0', 'Credit', '0', ''),
(100, 1, 1, '2012-09-17', 'Date of Payment: 2012-09-17 \n    Years of Subscription: 1 month\n    Activation Date: 2012-09-17\n    Expiration Date: 2012-10-17 1 month free subscription - 0', 'Debit', '0', '99'),
(102, 4, 1, '2012-10-02', 'Date of Payment: 2012-10-02 \n    Years of Subscription: 1 month\n    Activation Date: 2012-10-02\n    Expiration Date: 2012-11-02 1 month free subscription - 0', 'Credit', '0', ''),
(104, 1, 1, '2012-10-02', 'Date of Payment: 2012-10-02 \n    Years of Subscription: 1 month\n    Activation Date: 2012-10-02\n    Expiration Date: 2012-11-02 1 month free subscription - 0', 'Debit', '0', '103'),
(106, 4, 1, '2012-10-20', 'Date of Payment: 2012-10-20 \n    Years of Subscription: 1 month\n    Activation Date: 2012-10-20\n    Expiration Date: 2012-11-20 1 month free subscription - 0', 'Credit', '0', ''),
(108, 1, 1, '2012-10-20', 'Date of Payment: 2012-10-20 \n    Years of Subscription: 1 month\n    Activation Date: 2012-10-20\n    Expiration Date: 2012-11-20 1 month free subscription - 0', 'Debit', '0', '107'),
(110, 4, 1, '2012-11-02', 'Date of Payment: 2012-11-02 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-02\n    Expiration Date: 2012-12-02 1 month free subscription - 0', 'Credit', '0', ''),
(112, 1, 1, '2012-11-02', 'Date of Payment: 2012-11-02 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-02\n    Expiration Date: 2012-12-02 1 month free subscription - 0', 'Debit', '0', '111'),
(114, 4, 1, '2012-11-08', 'Date of Payment: 2012-11-08 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-08\n    Expiration Date: 2012-12-08 1 month free subscription - 0', 'Credit', '0', ''),
(116, 1, 1, '2012-11-08', 'Date of Payment: 2012-11-08 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-08\n    Expiration Date: 2012-12-08 1 month free subscription - 0', 'Debit', '0', '115'),
(118, 4, 1, '2012-11-10', 'Date of Payment: 2012-11-10 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-10\n    Expiration Date: 2012-12-10 1 month free subscription - 0', 'Credit', '0', ''),
(120, 1, 1, '2012-11-10', 'Date of Payment: 2012-11-10 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-10\n    Expiration Date: 2012-12-10 1 month free subscription - 0', 'Debit', '0', '119'),
(122, 4, 1, '2012-11-12', 'Date of Payment: 2012-11-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-12\n    Expiration Date: 2012-12-12 1 month free subscription - 0', 'Credit', '0', ''),
(124, 1, 1, '2012-11-12', 'Date of Payment: 2012-11-12 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-12\n    Expiration Date: 2012-12-12 1 month free subscription - 0', 'Debit', '0', '123'),
(126, 4, 1, '2012-11-13', 'Date of Payment: 2012-11-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-13\n    Expiration Date: 2012-12-13 1 month free subscription - 0', 'Credit', '0', ''),
(128, 1, 1, '2012-11-13', 'Date of Payment: 2012-11-13 \n    Years of Subscription: 1 month\n    Activation Date: 2012-11-13\n    Expiration Date: 2012-12-13 1 month free subscription - 0', 'Debit', '0', '127'),
(130, 4, 1, '2012-11-15', 'Date of Payment: 2012-11-15 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-15\n    Expiration Date: 2013-11-15 1 month free subscription - 0', 'Credit', '0', ''),
(132, 1, 1, '2012-11-15', 'Date of Payment: 2012-11-15 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-15\n    Expiration Date: 2013-11-15 1 month free subscription - 0', 'Debit', '0', '131'),
(134, 4, 1, '2012-11-21', 'Date of Payment: 2012-11-21 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-21\n    Expiration Date: 2013-11-21 1 month free subscription - 0', 'Credit', '0', ''),
(136, 1, 1, '2012-11-21', 'Date of Payment: 2012-11-21 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-21\n    Expiration Date: 2013-11-21 1 month free subscription - 0', 'Debit', '0', '135'),
(138, 4, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Credit', '0', ''),
(140, 1, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Debit', '0', '139'),
(142, 4, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Credit', '0', ''),
(144, 1, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Debit', '0', '143'),
(146, 4, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Credit', '0', ''),
(148, 1, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Debit', '0', '147'),
(150, 4, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Credit', '0', ''),
(152, 1, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Debit', '0', '151'),
(154, 4, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Credit', '0', ''),
(156, 1, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Debit', '0', '155'),
(158, 4, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Credit', '0', ''),
(160, 1, 1, '2012-11-22', 'Date of Payment: 2012-11-22 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-22\n    Expiration Date: 2013-11-22 1 month free subscription - 0', 'Debit', '0', '159'),
(162, 4, 1, '2012-11-28', 'Date of Payment: 2012-11-28 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-28\n    Expiration Date: 2013-11-28 1 month free subscription - 0', 'Credit', '0', ''),
(164, 1, 1, '2012-11-28', 'Date of Payment: 2012-11-28 \n    Years of Subscription: 1 year\n    Activation Date: 2012-11-28\n    Expiration Date: 2013-11-28 1 month free subscription - 0', 'Debit', '0', '163'),
(166, 4, 1, '2012-12-03', 'Date of Payment: 2012-12-03 \n    Years of Subscription: 1 year\n    Activation Date: 2012-12-03\n    Expiration Date: 2013-12-03 1 month free subscription - 0', 'Credit', '0', ''),
(168, 1, 1, '2012-12-03', 'Date of Payment: 2012-12-03 \n    Years of Subscription: 1 year\n    Activation Date: 2012-12-03\n    Expiration Date: 2013-12-03 1 month free subscription - 0', 'Debit', '0', '167'),
(170, 4, 1, '2012-12-03', 'Date of Payment: 2012-12-03 \n    Years of Subscription: 1 year\n    Activation Date: 2012-12-03\n    Expiration Date: 2013-12-03 1 month free subscription - 0', 'Credit', '0', ''),
(172, 1, 1, '2012-12-03', 'Date of Payment: 2012-12-03 \n    Years of Subscription: 1 year\n    Activation Date: 2012-12-03\n    Expiration Date: 2013-12-03 1 month free subscription - 0', 'Debit', '0', '171');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL,
  `dt_login` datetime DEFAULT NULL,
  `dt_logout` datetime DEFAULT NULL,
  `uid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mail_alert`
--

DROP TABLE IF EXISTS `mail_alert`;
CREATE TABLE IF NOT EXISTS `mail_alert` (
  `ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8_unicode_ci,
  `comment` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mail_alert`
--

INSERT INTO `mail_alert` (`ip`, `date`, `subject`, `comment`) VALUES
('41.203.64.130', '2012-09-13 09:43:43', 'Test Subject', 'Test Comment');

-- --------------------------------------------------------

--
-- Table structure for table `non_academic`
--

DROP TABLE IF EXISTS `non_academic`;
CREATE TABLE IF NOT EXISTS `non_academic` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=517 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `non_academic`
--

INSERT INTO `non_academic` (`id`, `name`, `school_id`) VALUES
(1, 'Handwriting', 1),
(2, 'Fluency', 1),
(3, 'Punctuality', 1),
(4, 'Reliability', 1),
(5, 'Neatness', 1),
(6, 'Politeness', 1),
(7, 'Honesty', 1),
(8, 'Self Control', 1),
(9, 'Spirit of Cooperation', 1),
(10, 'Sense Of Responsibility', 1),
(11, 'Attentiveness In Class', 1),
(12, 'Perseverance', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Accounts'),
(3, 'Expenditure'),
(4, 'Exams'),
(5, 'Records'),
(6, 'Student'),
(7, 'Proprietor');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
CREATE TABLE IF NOT EXISTS `school` (
  `id` int(11) NOT NULL,
  `name` text,
  `address` text,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `other_information` text,
  `account_id` int(11) DEFAULT NULL,
  `signup_date` date DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `name`, `address`, `phone`, `email`, `website`, `logo`, `other_information`, `account_id`, `signup_date`) VALUES
(1, 'FOSLA ACADEMY', 'Along Karshi/Karu Road Opp. Karshi Police Station Beside S.C.C Karshi F.C.T Abuja Nigeria', '+2348076748877', 'foslaacademy@yahoo.com', 'www.foslaacademy.com', 'fosla_Logo.jpg', '', 8, '2012-09-11');

-- --------------------------------------------------------

--
-- Table structure for table `school_account`
--

DROP TABLE IF EXISTS `school_account`;
CREATE TABLE IF NOT EXISTS `school_account` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `years_of_subscription` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `activation_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_account`
--

INSERT INTO `school_account` (`id`, `school_id`, `years_of_subscription`, `payment_date`, `activation_date`, `expiry_date`, `status`) VALUES
(1, 1, 1, '2012-09-11', '2012-09-11', '2014-10-10', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `begin_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `name`, `begin_date`, `end_date`, `school_id`) VALUES
(1, '2011/2012', '2011-09-16', '2012-07-12', 1),
(59, '2012/2013', '2012-09-16', '2013-07-31', 1),
(60, '2013/2014', '2014-01-12', '2014-01-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL,
  `admission_number` varchar(100) DEFAULT NULL,
  `date_of_admission` date DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `house` varchar(100) DEFAULT NULL,
  `state_of_origin` varchar(100) DEFAULT NULL,
  `scholarship` varchar(100) DEFAULT NULL,
  `parent_guardian_name` varchar(100) DEFAULT NULL,
  `parent_guardian_email` varchar(100) DEFAULT NULL,
  `parent_guardian_phone` varchar(100) DEFAULT NULL,
  `parent_guardian_address` text,
  `any_other_information` text,
  `passport_image` text,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `admission_number`, `date_of_admission`, `firstname`, `lastname`, `date_of_birth`, `class_id`, `gender`, `house`, `state_of_origin`, `scholarship`, `parent_guardian_name`, `parent_guardian_email`, `parent_guardian_phone`, `parent_guardian_address`, `any_other_information`, `passport_image`, `school_id`) VALUES
(1, '011', '2011-09-16', 'Musa', 'Abdullahi', '2001-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(2, '008', '2011-09-16', 'Jibrin', 'Dauda', '2001-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(3, '024', '2011-09-16', 'Philemon', 'Elisha', '2001-09-11', 179, 'Male', '', '', 'No', '', '', '', '', '', '', 1),
(4, '021', '2011-09-16', 'Stephen', 'Emmanuel', '1999-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(5, '005', '2011-09-16', 'Ali', 'Friday', '2000-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', 'FOSLA LOGO.docx', 1),
(6, '022', '2011-09-16', 'Usman', 'Jibrin', '1999-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(7, '006', '2011-09-16', 'Ejeh', 'Joseph', '2000-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(8, '018', '2011-09-16', 'Onyeke Andrew', 'Junior', '2000-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(9, '012', '2011-09-16', 'Mustapha', 'Kehinde', '2000-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(64, 'FA/ADM/038', '2013-09-16', 'Abdullahi', 'Amodu', '2002-01-22', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(11, '015', '2011-09-16', 'Okafor', 'Prosper', '2000-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(12, '003', '2011-09-16', 'Abraham', 'Solomon', '1999-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(13, '013', '2011-09-16', 'Nabala', 'Vincent', '1999-09-11', 179, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(14, '023', '2011-09-16', 'Yusuf', 'Abdulazeez', '1999-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(15, '001', '2011-09-16', 'Abdullahi A.', 'Abdullahi', '2000-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(16, '007', '2011-09-16', 'Haruna', 'Allayi', '1999-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(17, '016', '2011-09-16', 'Omagu', 'Augustine', '1999-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(18, '019', '2011-09-16', 'Peter', 'Emmanuel', '1999-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(19, '017', '2011-09-16', 'Omodunusi Azeez', 'Ganiyu', '1997-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(20, '010', '2011-09-16', 'Joshua', 'Issac', '1999-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(21, '002', '2011-09-16', 'Abdullahi', 'Mohammed', '1999-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(22, '009', '2011-09-16', 'John', 'Philemon', '2000-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(23, '004', '2011-09-16', 'Adamu', 'Rabiu', '1998-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(24, '020', '2011-09-16', 'Peter', 'Shedrack', '1999-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(25, '014', '2011-09-16', 'Ofozie', 'ThankGod', '2000-09-12', 180, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(55, 'FA/ADM/029', '2012-09-16', 'Hassan', 'Abdulsalam', '2000-06-29', 3, 'Male', '', '', 'YES', '', '', '', '', '', '', 1),
(54, 'FA/ADM/028', '2012-12-03', 'Ibrahim A.', 'Gimba', '1999-01-20', 3, 'Male', '', '', 'YES', '', '', '', '', '', '', 1),
(53, 'FA/ADM/027', '2012-09-16', 'Mishack', 'Awoje', '1999-02-05', 3, 'Male', '', '', 'YES', '', '', '', '', '', '', 1),
(52, 'FA/ADM/026', '2012-09-16', 'Achu Gabriel', 'Egbo', '2000-01-08', 3, 'Male', '', '', 'YES', '', '', '', '', '', '', 1),
(56, 'FA/ADM/030', '2012-09-16', 'Danladi Isah', 'Ileanwa', '1999-09-15', 3, 'Male', '', '', 'YES', '', '', '', '', '', '', 1),
(57, 'FA/ADM/031', '2012-09-16', 'Sabo Manasseh', 'Moses', '1999-01-01', 3, 'Male', '', '', 'YES', '', '', '', '', '', '', 1),
(58, 'FA/ADM/032', '2012-09-16', 'Abubakar', 'Suleiman', '2000-03-18', 3, 'Male', '', '', 'YES', '', '', '', '', '', '', 1),
(59, 'FA/ADM/033', '2012-09-16', 'Yunusa', 'Usman', '2012-12-03', 3, 'Male', '', '', '', '', '', '', '', '', '', 1),
(60, 'FA/ADM/034', '2012-09-16', 'Izuchukwu', 'Okoro', '1999-07-03', 3, 'Male', '', '', 'YES', '', '', '', '', '', '', 1),
(61, 'FA/ADM/035', '2012-09-16', 'Ezeangwuna', 'Emeka', '2001-07-03', 3, 'Male', '', '', '', '', '', '', '', '', '', 1),
(63, '036', '2012-09-16', 'Nzube', 'Okeke', '1996-09-11', 180, 'Male', '', '', '', '', '', '', '', '', '', 1),
(65, 'FA/ADM/039', '2013-09-16', 'Abdullahi', 'Bashiru', '2002-09-05', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(66, 'FA/ADM/040', '2013-09-16', 'Adejoh', 'Gabriel Haruna', '2003-10-15', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(67, 'FA/ADM/041', '2013-09-16', 'Amodu', 'Zakari', '2001-09-08', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(68, 'FA/ADM/042', '2013-09-16', 'Modu', 'Benjamin', '2000-11-25', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(69, 'FA/ADM/043', '2013-09-16', 'Mohammed', 'Munir', '2000-04-19', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(70, 'FA/ADM/044', '2013-09-16', 'Odey', 'Sunday', '2000-02-15', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(71, 'FA/ADM/045', '2013-09-16', 'Ojukwu', 'Chidera Prosper', '2002-02-22', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(72, 'FA/ADM/046', '2013-09-16', 'Reuben', 'Michael Ojonimi', '2001-06-12', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(73, 'FA/ADM/047', '2013-09-16', 'Yahaya', 'Rabiu', '2002-05-25', 3, 'Male', '', '', 'Yes', '', '', '', '', '', '', 1),
(74, 'FA/ADM/048', '2013-12-03', 'Abdullahi', 'Idris Senator', '2002-11-05', 3, 'Male', '', '', 'No', '', '', '', '', '', '', 1),
(75, 'FA/ADM/049', '2013-09-16', 'Kalu', 'Elvis', '2002-10-03', 3, 'Male', '', '', 'No', '', '', '', '', '', '', 1),
(76, 'FA/ADM/050', '2013-09-16', 'Powell', 'Dibarrhe David', '2002-08-25', 3, 'Male', '', '', 'No', '', '', '', '', '', '', 1),
(77, 'FA/ADM/051', '2013-09-16', 'Jiri', 'Adamu Midala', '2003-08-12', 3, 'Male', '', '', 'No', '', '', '', '', '', '', 1),
(78, 'FA/ADM/052', '2013-09-16', 'Panda', 'Louis Junior', '1998-06-28', 179, 'Male', '', '', 'No', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `class_type_id` varchar(100) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=388 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `class_type_id`, `school_id`) VALUES
(1, 'Mathematics', '1', 1),
(2, 'English Language', '1', 1),
(3, 'Mathematics', '2', 1),
(4, 'English Language', '2', 1),
(5, 'Mathematics', '3', 1),
(6, 'English Language', '3', 1),
(7, 'Mathematics', '4', 1),
(8, 'English Language', '4', 1),
(9, 'Business Studies', '3', 1),
(10, 'Agricultural Science', '3', 1),
(11, 'French', '3', 1),
(12, 'Computer Education', '3', 1),
(13, 'Home Economics', '3', 1),
(14, 'CRS/IRK', '3', 1),
(15, 'Physical and Health Education', '3', 1),
(16, 'Basic Technology', '3', 1),
(17, 'Basic Science', '3', 1),
(18, 'Civic Education', '3', 1),
(19, 'Creative Art', '3', 1),
(21, 'Hausa/Igbo/Yoruba', '3', 1),
(22, 'Social Studies', '3', 1),
(23, 'Information Tech', '4', 1),
(24, 'Government', '4', 1),
(25, 'French', '4', 1),
(26, 'Christian Religious Knowledge/Islamic Religious Knowledge', '4', 1),
(27, 'Further Mathematics', '4', 1),
(28, 'Biology', '4', 1),
(29, 'Literature In English', '4', 1),
(30, 'Health Science', '4', 1),
(31, 'Physics', '4', 1),
(32, 'Chemistry', '4', 1),
(33, 'History', '4', 1),
(34, 'Religious Studies', '4', 1),
(35, 'Geography', '4', 1),
(36, 'Hausa or a major Nigerian Language', '4', 1),
(37, 'Agricultural Science', '4', 1),
(38, 'Book-keeping and Accounting', '4', 1),
(39, 'Commerce', '4', 1),
(40, 'Home Management', '4', 1),
(41, 'Computer Education', '4', 1),
(42, 'Food and Nutrition', '4', 1),
(43, 'Hausa/Igbo/Yoruba', '4', 1),
(386, 'Arabic Language', '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

DROP TABLE IF EXISTS `term`;
CREATE TABLE IF NOT EXISTS `term` (
  `id` int(11) NOT NULL,
  `name` enum('FIRST','SECOND','THIRD') DEFAULT NULL,
  `begin_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `times_school_open` varchar(100) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `term`
--

INSERT INTO `term` (`id`, `name`, `begin_date`, `end_date`, `session_id`, `times_school_open`, `school_id`) VALUES
(1, 'FIRST', '2011-09-16', '2011-12-09', 1, '85 days', 1),
(2, 'SECOND', '2012-01-09', '2012-03-03', 1, '110 days', 1),
(3, 'THIRD', '2012-04-22', '2012-07-12', 1, '110 days', 1),
(177, 'THIRD', '2012-09-16', '2013-12-01', 59, '0', 1),
(176, 'SECOND', '2013-01-13', '2013-01-13', 59, '0', 1),
(175, 'FIRST', '2012-09-16', '2012-12-13', 59, '116 Days', 1),
(178, 'FIRST', '2014-01-12', '2014-01-12', 60, '116', 1),
(179, 'SECOND', '2014-01-12', '2014-01-12', 60, '85 days', 1),
(180, 'THIRD', '2013-11-07', '2013-11-07', 60, '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(100) NOT NULL DEFAULT '',
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `school_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `passwd`, `firstname`, `lastname`, `school_id`) VALUES
(1, 'accounting', 'b31debbb5ee59cfd2948f299b4a8c3a1c2bfb847', NULL, NULL, 0),
(2, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', NULL, NULL, 1),
(3, '011', '282565635', 'Musa', 'Abdullahi', 1),
(4, '008', '1982571466', 'Jibrin', 'Dauda', 1),
(5, '024', '1935966614', 'Philemon', 'Elisha', 1),
(6, '021', '1908699227', 'Stephen', 'Emmanuel', 1),
(7, '005', '1581146210', 'Ali', 'Friday', 1),
(8, '022', '1901426476', 'Usman', 'Jibrin', 1),
(9, '006', '1420549966', 'Ejeh', 'Joseph', 1),
(10, '018', '1205449578', 'Onyeke Andrew', 'Junior', 1),
(11, '012', '1497723732', 'Mustapha', 'Kehinde', 1),
(12, '025', '120641427', 'Uche', 'Obey', 1),
(13, '015', '1678546278', 'Okafor', 'Prosper', 1),
(14, '003', '1496037388', 'Abraham', 'Solomon', 1),
(15, '013', '1901388032', 'Nabala', 'Vincent', 1),
(16, '023', '627235222', 'Yusuf', 'Abdulazeez', 1),
(17, '001', '881549729', 'Abdullahi A.', 'Abdullahi', 1),
(18, '007', '284103366', 'Haruna', 'Allayi', 1),
(19, '016', '310869255', 'Omagu', 'Augustine', 1),
(20, '019', '1414549819', 'Peter', 'Emmanuel', 1),
(21, '017', '1531022722', 'Omodunusi Azeez', 'Ganiyu', 1),
(22, '010', '1864582178', 'Joshua', 'Issac', 1),
(23, '002', '65252639', 'Abdullahi', 'Mohammed', 1),
(24, '009', '892025365', 'John', 'Philemon', 1),
(25, '004', '550430799', 'Adamu', 'Rabiu', 1),
(26, '020', '277417654', 'Peter', 'Shedrack', 1),
(27, '014', '92005537', 'Ofozie', 'ThankGod', 1),
(101, 'FA/ADM/031', '1076385380', 'Sabo Manasseh', 'Moses', 1),
(100, 'FA/ADM/030', '1775244207', 'Danladi Isah', 'Ileanwa', 1),
(96, 'FA/ADM/026', '1355138222', 'Achu Gabriel', 'Egbo', 1),
(99, 'FA/ADM/029', '106289295', 'Hassan', 'Abdulsalam', 1),
(98, 'FA/ADM/028', '103623952', 'Ibrahim A.', 'Gimba', 1),
(97, 'FA/ADM/027', '1261944147', 'Mishark', 'Awoje', 1),
(102, 'FA/ADM/032', '1146079927', 'Abubakar', 'Suleiman', 1),
(103, 'FA/ADM/033', '1854017530', 'Yunusa', 'Usman', 1),
(104, 'FA/ADM/034', '1359707405', 'Izuchukwu', 'Okoro', 1),
(105, 'FA/ADM/035', '1157154413', 'Ezeangwuna', 'Emeka', 1),
(106, '037', '984876337', 'Adam Tunde', 'Adigum', 1),
(107, '036', '1811240369', 'Nzube', 'Okeke', 1),
(108, 'FA/ADM/038', '197586019', 'Abdullahi', 'Amodu', 1),
(109, 'FA/ADM/039', '1376375854', 'Abdullahi', 'Bashiru', 1),
(110, 'FA/ADM/040', '435030599', 'Adejoh', 'Gabriel Haruna', 1),
(111, 'FA/ADM/041', '1326234469', 'Amodu', 'Zakari', 1),
(112, 'FA/ADM/042', '18464943', 'Modu', 'Benjamin', 1),
(113, 'FA/ADM/043', '1947815892', 'Mohammed', 'Munir', 1),
(114, 'FA/ADM/044', '540581362', 'Odey', 'Sunday', 1),
(115, 'FA/ADM/045', '2014747222', 'Ojukwu', 'Chidera Prosper', 1),
(116, 'FA/ADM/046', '97579149', 'Reuben', 'Michael Ojonimi', 1),
(117, 'FA/ADM/047', '909690964', 'Yahaya', 'Rabiu', 1),
(118, 'FA/ADM/048', '28028326', 'Abdullahi', 'Idris Senator', 1),
(119, 'FA/ADM/049', '1874319102', 'Kalu', 'Elvis', 1),
(120, 'FA/ADM/050', '829230730', 'Powell', 'Dibarrhe David', 1),
(121, 'FA/ADM/051', '870349994', 'Jiri', 'Adamu Midala', 1),
(122, 'FA/ADM/052', '1991971848', 'Panda', 'Louis Junior', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `uid`, `pid`, `school_id`) VALUES
(1, 1, 1, NULL),
(2, 2, 7, NULL),
(3, 3, 6, NULL),
(4, 4, 6, NULL),
(5, 5, 6, NULL),
(6, 6, 6, NULL),
(7, 7, 6, NULL),
(8, 8, 6, NULL),
(9, 9, 6, NULL),
(10, 10, 6, NULL),
(11, 11, 6, NULL),
(12, 12, 6, NULL),
(13, 13, 6, NULL),
(14, 14, 6, NULL),
(15, 15, 6, NULL),
(16, 16, 6, NULL),
(17, 17, 6, NULL),
(18, 18, 6, NULL),
(19, 19, 6, NULL),
(20, 20, 6, NULL),
(21, 21, 6, NULL),
(22, 22, 6, NULL),
(23, 23, 6, NULL),
(24, 24, 6, NULL),
(25, 25, 6, NULL),
(26, 26, 6, NULL),
(27, 27, 6, NULL),
(28, 28, 7, NULL),
(29, 29, 6, NULL),
(30, 30, 7, NULL),
(31, 31, 7, NULL),
(32, 32, 7, NULL),
(33, 33, 6, NULL),
(34, 34, 7, NULL),
(35, 35, 7, NULL),
(36, 36, 6, NULL),
(37, 37, 7, NULL),
(38, 38, 7, NULL),
(39, 39, 7, NULL),
(40, 40, 7, NULL),
(41, 41, 6, NULL),
(42, 42, 6, NULL),
(43, 43, 7, NULL),
(44, 44, 6, NULL),
(45, 45, 6, NULL),
(46, 46, 7, NULL),
(47, 47, 6, NULL),
(48, 48, 6, NULL),
(49, 49, 6, NULL),
(50, 50, 7, NULL),
(51, 51, 6, NULL),
(52, 52, 7, NULL),
(53, 53, 7, NULL),
(54, 54, 7, NULL),
(55, 55, 7, NULL),
(56, 56, 6, NULL),
(57, 57, 6, NULL),
(58, 58, 7, NULL),
(59, 59, 6, NULL),
(60, 60, 6, NULL),
(61, 61, 7, NULL),
(62, 62, 6, NULL),
(63, 63, 6, NULL),
(64, 64, 6, NULL),
(65, 65, 6, NULL),
(66, 66, 7, NULL),
(67, 67, 7, NULL),
(68, 68, 7, NULL),
(69, 69, 6, NULL),
(70, 70, 7, NULL),
(71, 71, 6, NULL),
(72, 72, 6, NULL),
(73, 73, 7, NULL),
(74, 74, 7, NULL),
(75, 75, 7, NULL),
(76, 76, 7, NULL),
(77, 77, 7, NULL),
(78, 78, 7, NULL),
(79, 79, 7, NULL),
(80, 80, 7, NULL),
(81, 81, 6, NULL),
(82, 82, 6, NULL),
(83, 83, 7, NULL),
(84, 84, 7, NULL),
(85, 85, 7, NULL),
(86, 86, 7, NULL),
(87, 87, 7, NULL),
(88, 88, 7, NULL),
(89, 89, 7, NULL),
(90, 90, 7, NULL),
(91, 91, 7, NULL),
(92, 92, 7, NULL),
(93, 93, 6, NULL),
(94, 94, 6, NULL),
(95, 95, 7, NULL),
(96, 96, 6, NULL),
(97, 97, 6, NULL),
(98, 98, 6, NULL),
(99, 99, 6, NULL),
(100, 100, 6, NULL),
(101, 101, 6, NULL),
(102, 102, 6, NULL),
(103, 103, 6, NULL),
(104, 104, 6, NULL),
(105, 105, 6, NULL),
(106, 106, 6, NULL),
(107, 107, 6, NULL),
(108, 108, 6, NULL),
(109, 109, 6, NULL),
(110, 110, 6, NULL),
(111, 111, 6, NULL),
(112, 112, 6, NULL),
(113, 113, 6, NULL),
(114, 114, 6, NULL),
(115, 115, 6, NULL),
(116, 116, 6, NULL),
(117, 117, 6, NULL),
(118, 118, 6, NULL),
(119, 119, 6, NULL),
(120, 120, 6, NULL),
(121, 121, 6, NULL),
(122, 122, 6, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_type`
--
ALTER TABLE `class_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_settings`
--
ALTER TABLE `grade_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `non_academic`
--
ALTER TABLE `non_academic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_account`
--
ALTER TABLE `school_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=183;
--
-- AUTO_INCREMENT for table `class_type`
--
ALTER TABLE `class_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT for table `grade_settings`
--
ALTER TABLE `grade_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `non_academic`
--
ALTER TABLE `non_academic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=517;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `school_account`
--
ALTER TABLE `school_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=388;
--
-- AUTO_INCREMENT for table `term`
--
ALTER TABLE `term`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=123;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
