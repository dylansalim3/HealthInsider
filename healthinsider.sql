-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2019 at 06:06 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2
use health_insider;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `healthinsider`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `APPOINTMENT_ID` int(11) NOT NULL,
  `PATIENT_ID` int(11) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL,
  `DATE` date NOT NULL,
  `TIME` time NOT NULL,
  `DOCTOR_ID` int(11) NOT NULL,
  `STATUS` int(3) NOT NULL,
  `REJECT_REASON` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`APPOINTMENT_ID`, `PATIENT_ID`, `DESCRIPTION`, `DATE`, `TIME`, `DOCTOR_ID`, `STATUS`, `REJECT_REASON`) VALUES
(1, 15, 'HELLO', '2019-01-02', '00:00:00', 1, 0, ''),
(2, 15, 'HELLO', '2019-01-02', '08:00:00', 1, 0, ''),
(3, 15, 'HELLO', '2019-01-02', '08:00:00', 1, 0, ''),
(4, 15, 'HELLO', '2019-01-02', '08:00:00', 1, 0, ''),
(5, 15, 'HELLO', '2019-01-02', '08:00:00', 1, 0, ''),
(6, 15, 'sfdfdsfs', '2019-05-01', '09:00:00', 1, 0, ''),
(7, 15, 'sfdfdsfs', '2019-05-01', '09:00:00', 2, 0, ''),
(8, 15, 'sfdfdsfs', '2019-05-01', '09:00:00', 3, 0, ''),
(9, 15, 'sfdfdsfs', '2019-05-01', '09:00:00', 4, 0, ''),
(10, 15, 'sfdfdsfs', '2019-05-01', '09:00:00', 5, 0, ''),
(11, 15, 'sfdfdsfs', '2019-05-01', '09:00:00', 6, 0, ''),
(12, 15, 'sfdfdsfs', '2019-05-01', '09:00:00', 7, 0, ''),
(13, 15, '', '2019-05-01', '08:00:00', 1, 0, ''),
(14, 15, '', '2019-05-01', '08:00:00', 2, 0, ''),
(15, 15, '', '2019-05-01', '08:00:00', 3, 0, ''),
(16, 15, '', '2019-05-01', '08:00:00', 4, 0, ''),
(17, 15, '', '2019-05-01', '08:00:00', 5, 0, ''),
(18, 15, '', '2019-05-01', '08:00:00', 6, 0, ''),
(19, 15, '', '2019-05-01', '08:00:00', 7, 0, ''),
(20, 15, '', '2019-05-01', '08:00:00', 2, 0, ''),
(21, 15, '', '2019-05-01', '08:00:00', 2, 0, ''),
(22, 15, 'Pain', '2019-05-17', '08:00:00', 3, 2, ''),
(23, 15, 'Flu', '2019-05-01', '10:00:00', 2, 2, ''),
(24, 15, 'Stomach Pain', '2019-05-18', '08:00:00', 3, 0, 'Dr. having a meeting');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `DOCTOR_ID` int(11) NOT NULL,
  `DOCTOR_NAME` varchar(100) NOT NULL,
  `SPECIALIZATION` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`DOCTOR_ID`, `DOCTOR_NAME`, `SPECIALIZATION`) VALUES
(1, 'DR. ALI', 'CARDIOLOGIST'),
(2, 'DR. Lim Bee Seng', 'Anesthesiologist'),
(3, 'DR. Liew Li Ping', 'Urologists'),
(4, 'DR. Chan Hoo Chin', 'Oncologists'),
(5, 'DR. Muhammad Hussein Bin Ali Husaini', 'Anesthesiologist'),
(6, 'DR. Ridzuan', 'Urologists'),
(7, 'DR. Siti', 'Oncologists');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_slot`
--

CREATE TABLE `doctor_slot` (
  `DOCTOR_SLOT_ID` int(11) NOT NULL,
  `DOCTOR_ID` int(11) NOT NULL,
  `DOCTOR_DAY` date NOT NULL,
  `DOCTOR_TIME` time NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor_slot`
--

INSERT INTO `doctor_slot` (`DOCTOR_SLOT_ID`, `DOCTOR_ID`, `DOCTOR_DAY`, `DOCTOR_TIME`, `STATUS`) VALUES
(1, 1, '2019-05-01', '08:00:00', 1),
(2, 2, '2019-05-01', '08:00:00', 1),
(3, 3, '2019-05-01', '08:00:00', 1),
(4, 1, '2019-05-01', '09:00:00', 1),
(5, 1, '2019-05-01', '10:00:00', 0),
(6, 2, '2019-05-01', '09:00:00', 0),
(7, 2, '2019-05-01', '10:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `PATIENT_ID` int(11) NOT NULL,
  `PATIENT_NAME` varchar(100) NOT NULL,
  `DOB` date DEFAULT NULL,
  `NRIC` varchar(40) NOT NULL,
  `ADDR` varchar(200) NOT NULL,
  `HEIGHT` decimal(3,1) DEFAULT NULL,
  `WEIGHT` decimal(3,1) DEFAULT NULL,
  `LDC` int(11) DEFAULT NULL,
  `SYSTOLIC` int(11) DEFAULT NULL,
  `HEART_RATE` int(11) DEFAULT NULL,
  `WARD_ID` int(11) DEFAULT NULL,
  `PHONE` varchar(11) NOT NULL,
  `GENDER` tinyint(1) NOT NULL,
  `DIASTOLIC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`PATIENT_ID`, `PATIENT_NAME`, `DOB`, `NRIC`, `ADDR`, `HEIGHT`, `WEIGHT`, `LDC`, `SYSTOLIC`, `HEART_RATE`, `WARD_ID`, `PHONE`, `GENDER`, `DIASTOLIC`) VALUES
(15, 'Patient 1', '1996-10-18', 'test123', 'No. 17', NULL, NULL, NULL, NULL, NULL, NULL, '017-1234567', 1, 0),
(16, 'David', '1997-08-09', 'test123', 'No.10', NULL, NULL, NULL, NULL, NULL, NULL, '010-1234567', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient_history`
--

CREATE TABLE `patient_history` (
  `PATIENT_HISTORY_ID` int(11) NOT NULL,
  `PATIENT_ID` int(11) NOT NULL,
  `PATIENT_HISTORY` varchar(400) NOT NULL,
  `DATE` date NOT NULL,
  `TIME` time NOT NULL,
  `DOCTOR_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_history`
--

INSERT INTO `patient_history` (`PATIENT_HISTORY_ID`, `PATIENT_ID`, `PATIENT_HISTORY`, `DATE`, `TIME`, `DOCTOR_ID`) VALUES
(1, 15, 'Chest Pain, Muscle Pain.', '0000-00-00', '00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reset_pw`
--

CREATE TABLE `reset_pw` (
  `RESET_PW_ID` int(11) NOT NULL,
  `RESET_PW_EMAIL` text NOT NULL,
  `RESET_PW_SELECTOR` text NOT NULL,
  `RESET_PW_TOKEN` longtext NOT NULL,
  `RESET_PW_EXPIRES` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reset_pw`
--

INSERT INTO `reset_pw` (`RESET_PW_ID`, `RESET_PW_EMAIL`, `RESET_PW_SELECTOR`, `RESET_PW_TOKEN`, `RESET_PW_EXPIRES`) VALUES
(0, 'anything@hotmail.com', '527e0788faff77fc', '$2y$12$Y6PgDFIo4ZdZH0h5p/40C.GdX51N.u4.FoCho5Qkocbi1LZIpJzp6', '1557444849'),
(0, 'whatsoever@gmail.com', '9b04aa6457521a02', '$2y$12$tDR.Bteys9de16GKywsrRekSe5l26zKLYZcg7sLnZGg.apOipYv9K', '1557514499');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `STAFF_ID` int(11) NOT NULL,
  `STAFF_NAME` varchar(100) NOT NULL,
  `DOB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NRIC` int(12) NOT NULL,
  `ADDR` varchar(200) NOT NULL,
  `CONTACT` int(11) NOT NULL,
  `GENDER` int(11) NOT NULL,
  `PROFILE_PIC` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PW` text NOT NULL,
  `STAFF_ID` int(11) DEFAULT NULL,
  `PATIENT_ID` int(11) DEFAULT NULL,
  `USERNAME` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `EMAIL`, `PW`, `STAFF_ID`, `PATIENT_ID`, `USERNAME`) VALUES
(7, 'user1@gmail.com', '$2y$12$GOnxyOGSh.gx94ylXZY1Fue9YciBT4/7KElQn8B3R2Pnlh6RQ/Mfy', NULL, 15, 'User1'),
(8, 'user2@email.com', '$2y$12$GOnxyOGSh.gx94ylXZY1Fue9YciBT4/7KElQn8B3R2Pnlh6RQ/Mfy', NULL, 16, 'david_tan');

-- --------------------------------------------------------

--
-- Table structure for table `ward`
--

CREATE TABLE `ward` (
  `WARD_ID` int(11) NOT NULL,
  `PATIENT_ID` int(11) NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`APPOINTMENT_ID`),
  ADD KEY `PATIENT_ID` (`PATIENT_ID`),
  ADD KEY `DOCTOR_ID` (`DOCTOR_ID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`DOCTOR_ID`);

--
-- Indexes for table `doctor_slot`
--
ALTER TABLE `doctor_slot`
  ADD PRIMARY KEY (`DOCTOR_SLOT_ID`),
  ADD KEY `DOCTOR_ID` (`DOCTOR_ID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`PATIENT_ID`);

--
-- Indexes for table `patient_history`
--
ALTER TABLE `patient_history`
  ADD PRIMARY KEY (`PATIENT_HISTORY_ID`),
  ADD KEY `fk_doctor_id` (`DOCTOR_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`STAFF_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`),
  ADD KEY `STAFF_ID` (`STAFF_ID`),
  ADD KEY `PATIENT_ID` (`PATIENT_ID`);

--
-- Indexes for table `ward`
--
ALTER TABLE `ward`
  ADD PRIMARY KEY (`WARD_ID`),
  ADD KEY `PATIENT_ID` (`PATIENT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `APPOINTMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `DOCTOR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctor_slot`
--
ALTER TABLE `doctor_slot`
  MODIFY `DOCTOR_SLOT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `PATIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `patient_history`
--
ALTER TABLE `patient_history`
  MODIFY `PATIENT_HISTORY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `STAFF_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ward`
--
ALTER TABLE `ward`
  MODIFY `WARD_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`PATIENT_ID`) REFERENCES `patient` (`PATIENT_ID`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`DOCTOR_ID`) REFERENCES `doctor` (`DOCTOR_ID`);

--
-- Constraints for table `doctor_slot`
--
ALTER TABLE `doctor_slot`
  ADD CONSTRAINT `doctor_slot_ibfk_1` FOREIGN KEY (`DOCTOR_ID`) REFERENCES `doctor` (`DOCTOR_ID`);

--
-- Constraints for table `patient_history`
--
ALTER TABLE `patient_history`
  ADD CONSTRAINT `fk_doctor_id` FOREIGN KEY (`DOCTOR_ID`) REFERENCES `doctor` (`DOCTOR_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`STAFF_ID`) REFERENCES `staff` (`STAFF_ID`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`PATIENT_ID`) REFERENCES `patient` (`PATIENT_ID`);

--
-- Constraints for table `ward`
--
ALTER TABLE `ward`
  ADD CONSTRAINT `ward_ibfk_1` FOREIGN KEY (`PATIENT_ID`) REFERENCES `patient` (`PATIENT_ID`);
COMMIT;

INSERT INTO health_insider.users (USER_ID,EMAIL,PW,STAFF_ID,PATIENT_ID,USERNAME) VALUES (9,'staff1@gmail.com','$2y$12$GOnxyOGSh.gx94ylXZY1Fue9YciBT4/7KElQn8B3R2Pnlh6RQ/Mfy',1,null,'michelle_lee')
INSERT INTO health_insider.staff (STAFF_ID,STAFF_NAME,DOB,NRIC,ADDR,CONTACT,GENDER,PROFILE_PIC) VALUES(1,"STAFF 1","2008-08-09","961114890909","0123456789",1,"https://img.webmd.com/dtmcms/live/webmd/consumer_assets/site_images/article_thumbnails/other/cat_relaxing_on_patio_other/1800x1200_cat_relaxing_on_patio_other.jpg");