-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2017 at 02:14 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mi151_00_master_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL,
  `activity_status` varchar(45) DEFAULT NULL,
  `activity_description` varchar(45) DEFAULT NULL,
  `email_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `activity_status`, `activity_description`, `email_id`) VALUES
(1, 'Bounced', 'Email has bounced.', 4),
(2, 'Sent', 'Email has been sent.', 5),
(3, 'Forwarded', 'Email has been forwarded.', 2),
(4, 'Opened', 'Email has been opened.', 2),
(5, 'Sent', 'Email has been sent.', 2),
(6, 'Bounced', 'Email has bounced.', 3),
(7, 'Sent', 'Email has been sent.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

CREATE TABLE IF NOT EXISTS `attendee` (
  `id` int(11) NOT NULL,
  `attendee_fname` varchar(45) NOT NULL,
  `attendee_Surname` varchar(45) DEFAULT NULL,
  `attendee_password` varchar(45) DEFAULT NULL,
  `attendee_email` varchar(45) NOT NULL,
  `attendee_birthdate` varchar(45) DEFAULT NULL,
  `attendee_gender` varchar(45) DEFAULT NULL,
  `attendee_contact_num` varchar(45) DEFAULT NULL,
  `attendee_date_created` varchar(45) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_id1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE IF NOT EXISTS `checklist` (
  `id` int(11) NOT NULL,
  `checklist_equipment` varchar(45) DEFAULT NULL,
  `checklist_quantity_on_hand` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `checklist_category`
--

CREATE TABLE IF NOT EXISTS `checklist_category` (
  `id` int(11) NOT NULL,
  `checklist_category_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `checklist_items`
--

CREATE TABLE IF NOT EXISTS `checklist_items` (
  `id` int(11) NOT NULL,
  `checklist_ref_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `checklist_ref`
--

CREATE TABLE IF NOT EXISTS `checklist_ref` (
  `id` int(11) NOT NULL,
  `checklist_description` varchar(60) DEFAULT NULL,
  `checklist_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `checklist_template`
--

CREATE TABLE IF NOT EXISTS `checklist_template` (
  `id` int(11) NOT NULL,
  `checklist_template_type` varchar(10) DEFAULT NULL,
  `checklist_template_equipment` varchar(45) DEFAULT NULL,
  `checklist_template_temperature` varchar(45) DEFAULT NULL,
  `checklist_template_equipment_number` int(11) DEFAULT NULL,
  `checklist_template_equipment_description` varchar(60) DEFAULT NULL,
  `checklist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `check_in`
--

CREATE TABLE IF NOT EXISTS `check_in` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `collaboration_space_has_attendee`
--

CREATE TABLE IF NOT EXISTS `collaboration_space_has_attendee` (
  `id` int(11) NOT NULL,
  `attendee_id` int(11) NOT NULL,
  `collaboration_space_attendee_id` int(11) NOT NULL,
  `message` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL,
  `customer_type` enum('Guest','Prospect') DEFAULT NULL,
  `customer_email` varchar(45) NOT NULL,
  `customer_fname` varchar(45) DEFAULT NULL,
  `customer_mname` varchar(45) DEFAULT NULL,
  `customer_lname` varchar(45) DEFAULT NULL,
  `customer_contact_number` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_type`, `customer_email`, `customer_fname`, `customer_mname`, `customer_lname`, `customer_contact_number`) VALUES
(1, 'Guest', 'shierenecervantes23@gmail.com', 'Noelle Shierene', 'Villamayor', 'Cervantes', 639213788284),
(2, 'Guest', 'sbgutierrez@student.apc.edu.ph', 'Shella Mae', 'Barcelo', 'Gutierrez', 639213788284),
(3, 'Guest', 'mtcomia@student.apc.edu.ph', 'Mary Hazel', 'Terte', 'Comia', 639213788284),
(4, 'Prospect', 'jbeclipse@student.apc.edu.ph', 'Jeline', '', 'Eclipse', 639029374831),
(5, 'Prospect', 'nbpenaverde@student.apc.edu.ph', 'Norrie', 'Bernardo', 'Penaverde', 639029374831),
(8, 'Guest', 'noelleshierenecervantes@gmail.com', 'Noelle Shierene', 'Villamayor', 'Cervantes', 639029374831),
(9, 'Guest', 'shierenecervantes234@gmail.com', 'Shierene', 'Villamayor', 'Cervantes', 639128918499);

-- --------------------------------------------------------

--
-- Table structure for table `customer1`
--

CREATE TABLE IF NOT EXISTS `customer1` (
  `id` int(11) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_history`
--

CREATE TABLE IF NOT EXISTS `customer_history` (
  `id` int(11) NOT NULL,
  `customer_history_checkin` varchar(45) DEFAULT NULL,
  `customer_history_checkout` varchar(45) DEFAULT NULL,
  `customer_history_numberdays` varchar(45) DEFAULT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_history`
--

INSERT INTO `customer_history` (`id`, `customer_history_checkin`, `customer_history_checkout`, `customer_history_numberdays`, `customer_id`) VALUES
(1, '2017-02-02', '2017-02-04', '2', 1),
(2, '2017-02-07', '2017-02-11', '4', 2),
(3, '2017-02-11', '2017-02-15', '4', 3),
(4, '2017-02-15', '2017-02-18', '3', 1),
(5, '2017-03-15', '2017-03-20', '5', 2),
(6, '2017-03-16', '2017-03-18', '2', 3),
(7, '2017-03-20', '2017-03-23', '3', 2),
(8, '2017-03-27', '2017-03-29', '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_preference`
--

CREATE TABLE IF NOT EXISTS `customer_preference` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `preference_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_preference`
--

INSERT INTO `customer_preference` (`id`, `customer_id`, `preference_id`) VALUES
(1, 1, 2),
(2, 2, 4),
(3, 3, 3),
(4, 1, 7),
(5, 5, 8),
(6, 5, 3),
(7, 4, 3),
(8, 1, 5),
(9, 5, 6),
(10, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL,
  `dept_name` varchar(45) NOT NULL,
  `dept_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL,
  `email_date` datetime DEFAULT NULL,
  `email_template` varchar(45) DEFAULT NULL,
  `email_status` enum('Active','Inactive') DEFAULT NULL,
  `template_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `email_date`, `email_template`, `email_status`, `template_id`, `customer_id`) VALUES
(1, '2017-08-29 04:08:14', NULL, 'Active', 4, 1),
(2, '2017-08-29 04:08:27', NULL, 'Active', 3, 4),
(3, '2017-08-29 04:08:38', NULL, 'Inactive', 4, 5),
(4, '2017-08-29 04:08:49', NULL, 'Inactive', 5, 2),
(5, '2017-08-29 04:08:02', NULL, 'Active', 2, 3),
(6, '2017-09-27 02:09:29', NULL, 'Active', 1, 1),
(7, '2017-09-27 02:13:01', NULL, 'Inactive', 4, 3),
(8, '2017-09-27 02:13:18', NULL, 'Active', 3, 5),
(9, '2017-10-12 10:24:35', NULL, 'Active', 3, 5),
(10, '2017-10-16 10:46:50', NULL, 'Active', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_event`
--

CREATE TABLE IF NOT EXISTS `email_event` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_event`
--

INSERT INTO `email_event` (`id`, `event_id`, `email_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 1, 2),
(7, 3, 5),
(8, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL,
  `employee_type` varchar(45) DEFAULT NULL,
  `employee_fname` varchar(45) DEFAULT NULL,
  `employee_mname` varchar(45) DEFAULT NULL,
  `employee_lname` varchar(45) DEFAULT NULL,
  `employee_contact_number` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `employee_type`, `employee_fname`, `employee_mname`, `employee_lname`, `employee_contact_number`) VALUES
(1, 'Marketeer', 'Neil', '', 'Rumbaoa', 639198273891),
(2, 'Marketeer', 'Joe Gene', '', 'Quesada', 639198273891),
(3, 'Marketeer', 'Maricel', 'Paganda nang paganda', 'Naviamos', 6391276317431),
(4, 'Marketeer', 'Jacob', '', 'Catayoc', 639198273891),
(5, 'Marketeer', 'Roselle Wednesday', '', 'Gardon', 6391276317431),
(6, 'Marketeer', 'Manuel', '', 'Calimlim', 639198273891),
(7, 'Marketeer', 'Sebastian', '', 'Sanchez', 639198273891),
(8, 'Marketeer', 'Joan', '', 'Dela Cuesta', 6391874183781);

-- --------------------------------------------------------

--
-- Table structure for table `employee1`
--

CREATE TABLE IF NOT EXISTS `employee1` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `position` varchar(45) NOT NULL,
  `supervisor` int(11) NOT NULL,
  `sched_start` time NOT NULL,
  `sched_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee2`
--

CREATE TABLE IF NOT EXISTS `employee2` (
  `id` int(11) NOT NULL,
  `employee_lastname` varchar(45) DEFAULT NULL,
  `employee_firstname` varchar(45) DEFAULT NULL,
  `employee_number` int(11) DEFAULT NULL,
  `employee_email` varchar(45) DEFAULT NULL,
  `employee_occupation` varchar(45) DEFAULT NULL,
  `employee_user_type` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee3`
--

CREATE TABLE IF NOT EXISTS `employee3` (
  `id` int(11) NOT NULL,
  `emp_name` varchar(45) DEFAULT NULL,
  `emp_surname` varchar(45) DEFAULT NULL,
  `emp_dept` varchar(45) DEFAULT NULL,
  `emp_position` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee4`
--

CREATE TABLE IF NOT EXISTS `employee4` (
  `id` int(11) NOT NULL,
  `employee_fname` varchar(45) DEFAULT NULL,
  `employee_lname` varchar(45) DEFAULT NULL,
  `employee_mi` varchar(3) DEFAULT NULL,
  `employee_position` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_has_facility`
--

CREATE TABLE IF NOT EXISTS `employee_has_facility` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `facility_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_has_schedule`
--

CREATE TABLE IF NOT EXISTS `employee_has_schedule` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL,
  `event_date_created` datetime DEFAULT NULL,
  `event_description` varchar(400) DEFAULT NULL,
  `event_start_date` date DEFAULT NULL,
  `event_end_date` date DEFAULT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `event_date_created`, `event_description`, `event_start_date`, `event_end_date`, `employee_id`) VALUES
(1, '2017-08-29 04:08:25', '50% Off ', '2017-03-02', '2017-04-03', 1),
(2, '2017-08-29 04:08:28', '10% Off when you visit the hotel from January 15-17, 2018', '2018-01-15', '2018-01-18', 2),
(3, '2017-08-29 08:08:31', 'Hotel discount of 25% for your next stay', '2017-03-02', '2017-04-03', 3),
(4, '2017-08-29 08:08:09', 'Get up to 20% off on your next stay', '2017-07-10', '2017-08-03', 4),
(5, '2017-08-29 08:08:23', '30% Off when you visit the hotel November 2-8, 2017', '2017-11-02', '2017-11-08', 5);

-- --------------------------------------------------------

--
-- Table structure for table `event1`
--

CREATE TABLE IF NOT EXISTS `event1` (
  `id` int(11) NOT NULL,
  `event_name` varchar(120) DEFAULT NULL,
  `event_venue` varchar(120) DEFAULT NULL,
  `event_start_date` date DEFAULT NULL,
  `event_end_date` date DEFAULT NULL,
  `event_type` varchar(45) DEFAULT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr;

-- --------------------------------------------------------

--
-- Table structure for table `event_collaboration`
--

CREATE TABLE IF NOT EXISTS `event_collaboration` (
  `collaboration_id` int(11) NOT NULL,
  `message` varchar(140) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `attendee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event_has_room`
--

CREATE TABLE IF NOT EXISTS `event_has_room` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr;

-- --------------------------------------------------------

--
-- Table structure for table `event_schedule`
--

CREATE TABLE IF NOT EXISTS `event_schedule` (
  `id` int(11) NOT NULL,
  `event_speaker` varchar(45) DEFAULT NULL,
  `event_time` varchar(45) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `event_has_room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `existing`
--

CREATE TABLE IF NOT EXISTS `existing` (
  `customer_ID` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE IF NOT EXISTS `facility` (
  `id` int(11) NOT NULL,
  `facility_type` varchar(45) DEFAULT NULL,
  `facility_status` varchar(45) DEFAULT NULL,
  `facility_qrcode` varchar(45) DEFAULT NULL,
  `checklist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL,
  `feedback_rating` varchar(45) DEFAULT NULL,
  `feedback_comment` varchar(45) DEFAULT NULL,
  `attendee_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `employee_id1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE IF NOT EXISTS `guest` (
  `guest_id` int(11) NOT NULL,
  `guest_name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `housekeeping_log`
--

CREATE TABLE IF NOT EXISTS `housekeeping_log` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_room_type_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `housekeeping_log_status` varchar(45) DEFAULT NULL,
  `housekeeping_log_timein` datetime DEFAULT NULL,
  `housekeeping_log_timeout` datetime DEFAULT NULL,
  `cleaning_status` varchar(45) DEFAULT NULL,
  `inspected_by_employee_id` int(11) DEFAULT NULL,
  `inspection_status` varchar(45) DEFAULT NULL,
  `housekeeping_log_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `housekeeping_log_details`
--

CREATE TABLE IF NOT EXISTS `housekeeping_log_details` (
  `id` int(11) NOT NULL,
  `housekeeping_log_details_checklist` varchar(45) DEFAULT NULL,
  `housekeeping_log_details_status` varchar(45) DEFAULT NULL,
  `housekeeping_log_details_timecompleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `landmark`
--

CREATE TABLE IF NOT EXISTS `landmark` (
  `id` int(11) NOT NULL,
  `landmark_name` varchar(45) DEFAULT NULL,
  `landmark_address` varchar(45) DEFAULT NULL,
  `landmark_distance_from_attendee` varchar(45) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1508117786),
('m130524_201442_init', 1508117790);

-- --------------------------------------------------------

--
-- Table structure for table `newsfeed`
--

CREATE TABLE IF NOT EXISTS `newsfeed` (
  `id` int(11) NOT NULL,
  `newsfeed_post` varchar(140) DEFAULT NULL,
  `newsfeed_comment` varchar(45) DEFAULT NULL,
  `attendee_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

CREATE TABLE IF NOT EXISTS `preference` (
  `id` int(11) NOT NULL,
  `preference_category` varchar(45) DEFAULT NULL,
  `preference_description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`id`, `preference_category`, `preference_description`) VALUES
(1, 'Dining', 'For restaurants, etc.'),
(2, 'Superior Room', 'For customers with interest in superior rooms'),
(3, 'Deluxe Room', 'For customers with interest in deluxe rooms'),
(4, 'Premier Room', 'For customers with interest in premier rooms'),
(5, 'Corner Deluxe Room', 'Interest in corner deluxe rooms'),
(6, 'Penthouse Loft Rooms', 'Interest in penthouse loft rooms'),
(7, 'Spa', 'For customers with interest in spa'),
(8, 'Promotions', 'For customers with interest in promotions');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL,
  `room_type` varchar(45) NOT NULL,
  `room_loc` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `room1`
--

CREATE TABLE IF NOT EXISTS `room1` (
  `id` int(11) NOT NULL,
  `room_name` varchar(45) DEFAULT NULL,
  `room_type` varchar(45) DEFAULT NULL,
  `room_desc` varchar(150) DEFAULT NULL,
  `room_capacity` int(11) DEFAULT NULL,
  `venue_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `room2`
--

CREATE TABLE IF NOT EXISTS `room2` (
  `id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_qr` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE IF NOT EXISTS `room_type` (
  `id` int(11) NOT NULL,
  `room_type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule1`
--

CREATE TABLE IF NOT EXISTS `schedule1` (
  `id` int(11) NOT NULL,
  `schudule_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_has_facility`
--

CREATE TABLE IF NOT EXISTS `schedule_has_facility` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `facility_id` int(11) DEFAULT NULL,
  `facility_checklist_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) NOT NULL,
  `template_type` varchar(45) DEFAULT NULL,
  `template_description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `template_type`, `template_description`) VALUES
(1, 'Promotional', 'For emails with more than 5 events'),
(2, 'Room Promotions', 'For rooms as a preference'),
(3, 'Dining Promotion', 'For dining as a preference'),
(4, 'Spa Promotions', 'For spa as a preference'),
(5, 'Amenities Promotion', 'For amenities as a preference'),
(6, 'Multiple Events', 'For emails with multiple events');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `time_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_end` timestamp NULL DEFAULT NULL,
  `time_alloted` time NOT NULL,
  `escalation_level` int(11) NOT NULL,
  `desc` text NOT NULL,
  `check_in_id` int(11) NOT NULL,
  `emp_repond_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `emp_create_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transcript`
--

CREATE TABLE IF NOT EXISTS `transcript` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `by_employee` int(11) NOT NULL,
  `current_emp_resp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'shierenecervantes', 'FCCYYfaa-ibX9VTuM_rA3J9SrmlYOFXL', '$2y$13$A7.YGEiICSDaG0OKWIW.nOC/BYi5Y.AHbEGXhsGqY8lsmMYehxZ.u', NULL, 'shierenecervantes23@gmail.com', 10, 1506422657, 1509174833),
(2, 'shellagutierrez', 'PN-6eJNoVVzTmXP0E61cLl-Mg1GdoOFg', '$2y$13$bcolUk7bRWZZg3tVQSwE1u0RD2Q0uKuIcoo/pJQjJFR.uTmOoSW2S', NULL, 'sbgutierrez@student.apc.edu.ph', 10, 1506485319, 1506485319),
(3, 'ericsalalima', 'BATYcMeA86BTddtZvpm3YyhFs7BdhdoM', '$2y$13$HyQzKWaroi8ij4AwSRY2kOR9A.X313jv9DVYgtV7ywY8cxO4/.tXu', NULL, 'erics@apc.edu.ph', 10, 1507003648, 1507003648),
(4, 'ericsalalima3', '0xJmL-y1z3WidyQFzweL2cB2YIv3G8t7', '$2y$13$x5LvHsji5gvbp6QGj0RwGOup4.XfRCh1xf9JcPMeU1oHhPwLPxKGO', NULL, 'erics3@apc.edu.ph', 10, 1508245258, 1508245258),
(5, 'nvcervantes', 'cDTbwI49kvvVWZuHl6drO5SNC9wneoVq', '$2y$13$ep79LJ/GXJxdjcn4/slEJ.blsiriUKvQLdQ.wu0PxF9n0qI0L.IcO', 'VNGK51fEEch5DPgylQzDtPEXIt2xvqJy_1509174949', 'noelleshierenecervantes@gmail.com', 10, 1509155508, 1509174949),
(6, 'svcervantes2323', '846QEBYq-otEA1APE2HTylUEncM0Ylpr', '$2y$13$bHcV0kcUGdqlJh.rVAxyEeT/uNHnYwHLM8SrmZN0hBRyVEgu/uFE2', '5DpgY8DNt4cKeyphxyPZtGNVS4GdVxpa_1509175046', 'svcervantes@student.apc.edu.ph', 10, 1509175019, 1509175046);

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE IF NOT EXISTS `venue` (
  `id` int(11) NOT NULL,
  `venue_name` varchar(120) DEFAULT NULL,
  `venue_address` varchar(120) DEFAULT NULL,
  `venue_desc` varchar(150) DEFAULT NULL,
  `venue_contact_num` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `webvisit_history`
--

CREATE TABLE IF NOT EXISTS `webvisit_history` (
  `id` int(11) NOT NULL,
  `wvh_date` datetime DEFAULT NULL,
  `wvh_ip_address` varchar(20) DEFAULT NULL,
  `wvh_url` varchar(100) DEFAULT NULL,
  `wvh_cookie_information` varchar(45) DEFAULT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `webvisit_history`
--

INSERT INTO `webvisit_history` (`id`, `wvh_date`, `wvh_ip_address`, `wvh_url`, `wvh_cookie_information`, `customer_id`) VALUES
(1, '2017-08-29 08:08:56', '192.168.23.22', 'http://localhost/yii/web/index.php?r=website%2Fsuperior', '1', 5),
(2, '2017-08-29 08:08:26', '192.168.23.23', 'http://localhost/yii/web/index.php?r=website%2Fdeluxe', '2', 4),
(3, '2017-08-29 08:08:55', '192.168.23.17', 'http://localhost/yii/web/index.php?r=website%2Frandb', '5', 1),
(4, '2017-08-29 08:08:35', '192.168.23.18', 'http://localhost/yii/web/index.php?r=website%2Fspa', '4', 2),
(5, '2017-08-29 08:08:04', '192.168.43.17', 'http://localhost/yii/web/index.php?r=website%2Fcornerdeluxe', '2', 3),
(6, '2017-10-28 02:14:11', '192.168.23.45', 'http://localhost/ems/backend/web/index.php?r=webvisit-history%2Fcreate', '7', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_activity_email1_idx` (`email_id`);

--
-- Indexes for table `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_attendee_employee1_idx` (`employee_id1`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_category_department1_idx` (`department_id`);

--
-- Indexes for table `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checklist_category`
--
ALTER TABLE `checklist_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checklist_items`
--
ALTER TABLE `checklist_items`
  ADD PRIMARY KEY (`id`,`checklist_ref_id`,`room_type_id`), ADD KEY `fk_checklist_ref_has_room_type_room_type1_idx` (`room_type_id`), ADD KEY `fk_checklist_ref_has_room_type_checklist_ref1_idx` (`checklist_ref_id`);

--
-- Indexes for table `checklist_ref`
--
ALTER TABLE `checklist_ref`
  ADD PRIMARY KEY (`id`,`checklist_category_id`), ADD KEY `fk_checklist_ref_checklist_category1_idx` (`checklist_category_id`);

--
-- Indexes for table `checklist_template`
--
ALTER TABLE `checklist_template`
  ADD PRIMARY KEY (`id`,`checklist_id`), ADD KEY `fk_checklist_template_checklist1_idx` (`checklist_id`);

--
-- Indexes for table `check_in`
--
ALTER TABLE `check_in`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_ticket_room1_idx` (`room_id`), ADD KEY `fk_ticket_customer1_idx` (`customer_id`);

--
-- Indexes for table `collaboration_space_has_attendee`
--
ALTER TABLE `collaboration_space_has_attendee`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_collaboration_space_has_attendee_attendee1_idx` (`attendee_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `customer_email` (`customer_email`);

--
-- Indexes for table `customer1`
--
ALTER TABLE `customer1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_history`
--
ALTER TABLE `customer_history`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_customer_history_customer1_idx` (`customer_id`);

--
-- Indexes for table `customer_preference`
--
ALTER TABLE `customer_preference`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_customer_has_preference_preference1_idx` (`preference_id`), ADD KEY `fk_customer_has_preference_customer1_idx` (`customer_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_email_template1_idx` (`template_id`), ADD KEY `fk_email_customer1_idx` (`customer_id`);

--
-- Indexes for table `email_event`
--
ALTER TABLE `email_event`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_event_has_email_email1_idx` (`email_id`), ADD KEY `fk_event_has_email_event1_idx` (`event_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee1`
--
ALTER TABLE `employee1`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_employee_department1_idx` (`department_id`), ADD KEY `fk_employee_employee1_idx` (`supervisor`);

--
-- Indexes for table `employee2`
--
ALTER TABLE `employee2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee3`
--
ALTER TABLE `employee3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee4`
--
ALTER TABLE `employee4`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_has_facility`
--
ALTER TABLE `employee_has_facility`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_employee_has_facility_facility1_idx` (`facility_id`), ADD KEY `fk_employee_has_facility_employee_idx` (`employee_id`);

--
-- Indexes for table `employee_has_schedule`
--
ALTER TABLE `employee_has_schedule`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_employee_has_schedule_schedule1_idx` (`schedule_id`), ADD KEY `fk_employee_has_schedule_employee1_idx` (`employee_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_event_employee1_idx` (`employee_id`);

--
-- Indexes for table `event1`
--
ALTER TABLE `event1`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_event1_employee1_idx` (`employee_id`);

--
-- Indexes for table `event_collaboration`
--
ALTER TABLE `event_collaboration`
  ADD PRIMARY KEY (`collaboration_id`), ADD KEY `fk_event_collaboration_event1_idx` (`event_id`), ADD KEY `fk_event_collaboration_attendee1_idx` (`attendee_id`);

--
-- Indexes for table `event_has_room`
--
ALTER TABLE `event_has_room`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_event_has_room_event1_idx` (`event_id`), ADD KEY `fk_event_has_room_room1_idx` (`room_id`);

--
-- Indexes for table `event_schedule`
--
ALTER TABLE `event_schedule`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_event_schedule_event1_idx` (`event_id`), ADD KEY `fk_event_schedule_event_has_room1_idx` (`event_has_room_id`);

--
-- Indexes for table `existing`
--
ALTER TABLE `existing`
  ADD PRIMARY KEY (`customer_ID`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`id`,`checklist_id`), ADD KEY `fk_facility_checklist1_idx` (`checklist_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_feedback_user1_idx` (`attendee_id`), ADD KEY `fk_feedback_event1_idx` (`event_id`), ADD KEY `fk_feedback_employee1_idx` (`employee_id1`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `housekeeping_log`
--
ALTER TABLE `housekeeping_log`
  ADD PRIMARY KEY (`id`,`room_id`,`room_room_type_id`,`employee_id`,`housekeeping_log_details_id`), ADD KEY `fk_room_has_employee_employee1_idx` (`employee_id`), ADD KEY `fk_room_has_employee_room1_idx` (`room_id`,`room_room_type_id`), ADD KEY `fk_housekeeping_log_housekeeping_log_details1_idx` (`housekeeping_log_details_id`);

--
-- Indexes for table `housekeeping_log_details`
--
ALTER TABLE `housekeeping_log_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landmark`
--
ALTER TABLE `landmark`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_landmark_event1_idx` (`event_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `newsfeed`
--
ALTER TABLE `newsfeed`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_newsfeed_attendee1_idx` (`attendee_id`), ADD KEY `fk_newsfeed_event1_idx` (`event_id`);

--
-- Indexes for table `preference`
--
ALTER TABLE `preference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room1`
--
ALTER TABLE `room1`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_room_venue1_idx` (`venue_id`);

--
-- Indexes for table `room2`
--
ALTER TABLE `room2`
  ADD PRIMARY KEY (`id`,`room_type_id`), ADD KEY `fk_room_room_type_idx` (`room_type_id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule1`
--
ALTER TABLE `schedule1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_has_facility`
--
ALTER TABLE `schedule_has_facility`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_schedule_has_facility_facility1_idx` (`facility_id`,`facility_checklist_id`), ADD KEY `fk_schedule_has_facility_schedule1_idx` (`schedule_id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_ticket_check_in1_idx` (`check_in_id`), ADD KEY `fk_ticket_employee1_idx` (`emp_repond_id`), ADD KEY `fk_ticket_category1_idx` (`category_id`), ADD KEY `fk_ticket_employee2_idx` (`emp_create_id`);

--
-- Indexes for table `transcript`
--
ALTER TABLE `transcript`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_transcript_ticket1_idx` (`ticket_id`), ADD KEY `fk_transcript_employee1_idx` (`by_employee`), ADD KEY `fk_transcript_employee2_idx` (`current_emp_resp`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webvisit_history`
--
ALTER TABLE `webvisit_history`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_webvisit_history_customer1_idx` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `attendee`
--
ALTER TABLE `attendee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checklist_category`
--
ALTER TABLE `checklist_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checklist_items`
--
ALTER TABLE `checklist_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checklist_ref`
--
ALTER TABLE `checklist_ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checklist_template`
--
ALTER TABLE `checklist_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `check_in`
--
ALTER TABLE `check_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `customer1`
--
ALTER TABLE `customer1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_history`
--
ALTER TABLE `customer_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `customer_preference`
--
ALTER TABLE `customer_preference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `email_event`
--
ALTER TABLE `email_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `employee1`
--
ALTER TABLE `employee1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee2`
--
ALTER TABLE `employee2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee3`
--
ALTER TABLE `employee3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee4`
--
ALTER TABLE `employee4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_has_facility`
--
ALTER TABLE `employee_has_facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_has_schedule`
--
ALTER TABLE `employee_has_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `event1`
--
ALTER TABLE `event1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_has_room`
--
ALTER TABLE `event_has_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_schedule`
--
ALTER TABLE `event_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `housekeeping_log`
--
ALTER TABLE `housekeeping_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `housekeeping_log_details`
--
ALTER TABLE `housekeeping_log_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `landmark`
--
ALTER TABLE `landmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `newsfeed`
--
ALTER TABLE `newsfeed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `preference`
--
ALTER TABLE `preference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `room1`
--
ALTER TABLE `room1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `room2`
--
ALTER TABLE `room2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedule1`
--
ALTER TABLE `schedule1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedule_has_facility`
--
ALTER TABLE `schedule_has_facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transcript`
--
ALTER TABLE `transcript`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `webvisit_history`
--
ALTER TABLE `webvisit_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
ADD CONSTRAINT `fk_activity_email1` FOREIGN KEY (`email_id`) REFERENCES `email` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attendee`
--
ALTER TABLE `attendee`
ADD CONSTRAINT `fk_attendee_employee1` FOREIGN KEY (`employee_id1`) REFERENCES `employee3` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
ADD CONSTRAINT `fk_category_department1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `checklist_items`
--
ALTER TABLE `checklist_items`
ADD CONSTRAINT `fk_checklist_ref_has_room_type_checklist_ref1` FOREIGN KEY (`checklist_ref_id`) REFERENCES `checklist_ref` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_checklist_ref_has_room_type_room_type1` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `checklist_ref`
--
ALTER TABLE `checklist_ref`
ADD CONSTRAINT `fk_checklist_ref_checklist_category1` FOREIGN KEY (`checklist_category_id`) REFERENCES `checklist_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `checklist_template`
--
ALTER TABLE `checklist_template`
ADD CONSTRAINT `fk_checklist_template_checklist1` FOREIGN KEY (`checklist_id`) REFERENCES `checklist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `check_in`
--
ALTER TABLE `check_in`
ADD CONSTRAINT `fk_ticket_customer1X` FOREIGN KEY (`customer_id`) REFERENCES `customer1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ticket_room1X` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `collaboration_space_has_attendee`
--
ALTER TABLE `collaboration_space_has_attendee`
ADD CONSTRAINT `fk_collaboration_space_has_attendee_attendee1` FOREIGN KEY (`attendee_id`) REFERENCES `attendee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customer_history`
--
ALTER TABLE `customer_history`
ADD CONSTRAINT `fk_customer_history_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customer_preference`
--
ALTER TABLE `customer_preference`
ADD CONSTRAINT `fk_customer_has_preference_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_customer_has_preference_preference1` FOREIGN KEY (`preference_id`) REFERENCES `preference` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `email`
--
ALTER TABLE `email`
ADD CONSTRAINT `fk_email_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_email_template1` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `email_event`
--
ALTER TABLE `email_event`
ADD CONSTRAINT `fk_event_has_email_email1` FOREIGN KEY (`email_id`) REFERENCES `email` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_event_has_email_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee1`
--
ALTER TABLE `employee1`
ADD CONSTRAINT `fk_employee_department1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employee_employee1` FOREIGN KEY (`supervisor`) REFERENCES `employee1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee_has_facility`
--
ALTER TABLE `employee_has_facility`
ADD CONSTRAINT `fk_employee_has_facility_employee` FOREIGN KEY (`employee_id`) REFERENCES `employee2` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employee_has_facility_facility1` FOREIGN KEY (`facility_id`) REFERENCES `facility` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee_has_schedule`
--
ALTER TABLE `employee_has_schedule`
ADD CONSTRAINT `fk_employee_has_schedule_employee1` FOREIGN KEY (`employee_id`) REFERENCES `employee2` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employee_has_schedule_schedule1` FOREIGN KEY (`schedule_id`) REFERENCES `schedule1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
ADD CONSTRAINT `fk_event_employee1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event1`
--
ALTER TABLE `event1`
ADD CONSTRAINT `fk_event1_employee1` FOREIGN KEY (`employee_id`) REFERENCES `employee3` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event_collaboration`
--
ALTER TABLE `event_collaboration`
ADD CONSTRAINT `fk_event_collaboration_attendee1` FOREIGN KEY (`attendee_id`) REFERENCES `attendee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_event_collaboration_event1` FOREIGN KEY (`event_id`) REFERENCES `event1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event_has_room`
--
ALTER TABLE `event_has_room`
ADD CONSTRAINT `fk_event_has_room_event1` FOREIGN KEY (`event_id`) REFERENCES `event1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_event_has_room_room1` FOREIGN KEY (`room_id`) REFERENCES `room1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event_schedule`
--
ALTER TABLE `event_schedule`
ADD CONSTRAINT `fk_event_schedule_event1` FOREIGN KEY (`event_id`) REFERENCES `event1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_event_schedule_event_has_room1` FOREIGN KEY (`event_has_room_id`) REFERENCES `event_has_room` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `facility`
--
ALTER TABLE `facility`
ADD CONSTRAINT `fk_facility_checklist1` FOREIGN KEY (`checklist_id`) REFERENCES `checklist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
ADD CONSTRAINT `fk_feedback_employee1` FOREIGN KEY (`employee_id1`) REFERENCES `employee3` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_feedback_event1` FOREIGN KEY (`event_id`) REFERENCES `event1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_feedback_user1` FOREIGN KEY (`attendee_id`) REFERENCES `attendee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `housekeeping_log`
--
ALTER TABLE `housekeeping_log`
ADD CONSTRAINT `fk_housekeeping_log_housekeeping_log_details1` FOREIGN KEY (`housekeeping_log_details_id`) REFERENCES `housekeeping_log_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_room_has_employee_employee1` FOREIGN KEY (`employee_id`) REFERENCES `employee4` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_room_has_employee_room1` FOREIGN KEY (`room_id`, `room_room_type_id`) REFERENCES `room2` (`id`, `room_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `landmark`
--
ALTER TABLE `landmark`
ADD CONSTRAINT `fk_landmark_event1` FOREIGN KEY (`event_id`) REFERENCES `event1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `newsfeed`
--
ALTER TABLE `newsfeed`
ADD CONSTRAINT `fk_newsfeed_attendee1` FOREIGN KEY (`attendee_id`) REFERENCES `attendee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_newsfeed_event1` FOREIGN KEY (`event_id`) REFERENCES `event1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `room1`
--
ALTER TABLE `room1`
ADD CONSTRAINT `fk_room_venue1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `room2`
--
ALTER TABLE `room2`
ADD CONSTRAINT `fk_room_room_type` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `schedule_has_facility`
--
ALTER TABLE `schedule_has_facility`
ADD CONSTRAINT `fk_schedule_has_facility_facility1` FOREIGN KEY (`facility_id`, `facility_checklist_id`) REFERENCES `facility` (`id`, `checklist_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_schedule_has_facility_schedule1` FOREIGN KEY (`schedule_id`) REFERENCES `schedule1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
ADD CONSTRAINT `fk_ticket_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ticket_check_in1` FOREIGN KEY (`check_in_id`) REFERENCES `check_in` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ticket_employee1` FOREIGN KEY (`emp_repond_id`) REFERENCES `employee1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ticket_employee2` FOREIGN KEY (`emp_create_id`) REFERENCES `employee1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transcript`
--
ALTER TABLE `transcript`
ADD CONSTRAINT `fk_transcript_employee1` FOREIGN KEY (`by_employee`) REFERENCES `employee1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_transcript_employee2` FOREIGN KEY (`current_emp_resp`) REFERENCES `employee1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_transcript_ticket1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `webvisit_history`
--
ALTER TABLE `webvisit_history`
ADD CONSTRAINT `fk_webvisit_history_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
