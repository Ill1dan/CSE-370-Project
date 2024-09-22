-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 08:06 PM
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
-- Database: `donatered`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `Area_ID` int(11) NOT NULL,
  `Area_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`Area_ID`, `Area_Name`) VALUES
(1, 'Adabar'),
(2, 'Badda'),
(3, 'Bangsall'),
(4, 'Bimanbandar'),
(5, 'Cantonment'),
(6, 'Chowkbazar'),
(7, 'Demra'),
(8, 'Dhakshinkhan'),
(9, 'Dhanmondi'),
(10, 'Gendaria'),
(11, 'Gulshan');

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `Req_ID` int(11) NOT NULL,
  `Req_date` date NOT NULL,
  `Description` text DEFAULT NULL,
  `Expire_date` date DEFAULT NULL,
  `Seeker_ID` int(11) NOT NULL,
  `Requested_type` int(11) NOT NULL,
  `Req_Area` int(11) DEFAULT NULL,
  `Is_patient` enum('yes','no') DEFAULT NULL,
  `Patient_name` varchar(100) DEFAULT NULL,
  `Patient_age` int(11) DEFAULT NULL,
  `Patient_gender` enum('male','female','other') DEFAULT NULL,
  `Patient_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`Req_ID`, `Req_date`, `Description`, `Expire_date`, `Seeker_ID`, `Requested_type`, `Req_Area`, `Is_patient`, `Patient_name`, `Patient_age`, `Patient_gender`, `Patient_phone`) VALUES
(1, '2024-09-16', 'I am gonna die. Need blood fast', '2024-12-15', 1, 3, 2, NULL, NULL, NULL, NULL, NULL),
(2, '2024-09-17', 'I am also gonna die. Need blood fast', '2025-01-12', 2, 7, 5, NULL, NULL, NULL, NULL, NULL),
(3, '2024-09-20', 'Fast give me blood', '2024-12-13', 4, 8, 4, NULL, NULL, NULL, NULL, NULL),
(4, '2024-09-16', 'I am gonna die. Need blood fast', '2024-12-15', 4, 1, 1, NULL, NULL, NULL, NULL, NULL),
(5, '2024-09-16', 'I am gonna die. Need blood fast', '2024-12-15', 5, 2, 10, NULL, NULL, NULL, NULL, NULL),
(6, '2024-09-16', 'I am gonna die. Need blood fast', '2024-12-15', 5, 4, 11, NULL, NULL, NULL, NULL, NULL),
(7, '2024-09-16', 'I am gonna die. Need blood fast', '2024-12-15', 5, 5, 7, NULL, NULL, NULL, NULL, NULL),
(8, '2024-09-16', 'I am gonna die. Need blood fast', '2024-12-15', 5, 6, 6, NULL, NULL, NULL, NULL, NULL),
(9, '2024-09-16', 'I am gonna die. Need blood fast', '2024-12-15', 3, 8, 11, NULL, NULL, NULL, NULL, NULL),
(10, '2024-09-16', 'I am gonna die. Need blood fast', '2024-12-15', 3, 6, 5, NULL, NULL, NULL, NULL, NULL),
(11, '2024-09-25', 'No extra information provided. ', '2024-09-28', 6, 5, 11, 'no', 'Rakib', 58, 'male', '6565656565'),
(12, '2024-09-27', 'No extra information provided. ', '2024-09-07', 6, 6, 11, 'yes', NULL, NULL, NULL, NULL),
(13, '2024-09-18', 'No extra information provided. ', '2024-09-27', 6, 5, 11, 'yes', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blood_types`
--

CREATE TABLE `blood_types` (
  `BloodType_ID` int(11) NOT NULL,
  `BloodType` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_types`
--

INSERT INTO `blood_types` (`BloodType_ID`, `BloodType`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Table structure for table `donor_areas`
--

CREATE TABLE `donor_areas` (
  `Donor_ID` int(11) NOT NULL,
  `Area_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_areas`
--

INSERT INTO `donor_areas` (`Donor_ID`, `Area_ID`) VALUES
(3, 2),
(5, 4),
(6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `donor_profile`
--

CREATE TABLE `donor_profile` (
  `Donor_ID` int(11) NOT NULL,
  `BloodType_ID` int(11) DEFAULT NULL,
  `Last_dono_date` date DEFAULT NULL,
  `Req_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_profile`
--

INSERT INTO `donor_profile` (`Donor_ID`, `BloodType_ID`, `Last_dono_date`, `Req_ID`) VALUES
(3, 5, '2024-06-06', NULL),
(5, 2, '2024-02-01', NULL),
(6, 5, '2024-03-08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `Notif_ID` int(11) NOT NULL,
  `Notif_Type` enum('DonorInfo','ListingInfo') NOT NULL,
  `Content` text NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Receiver_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `User_type` enum('Donor','Seeker') NOT NULL,
  `User_name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password_hash` varchar(255) NOT NULL,
  `First_name` varchar(50) DEFAULT NULL,
  `Last_name` varchar(50) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Phone_num` varchar(15) DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `User_type`, `User_name`, `Email`, `Password_hash`, `First_name`, `Last_name`, `DateOfBirth`, `Phone_num`, `Gender`) VALUES
(1, 'Donor', 'Ahad', 'ahad@dummy.com', 'test', 'Abdul', 'Ahad', '2001-07-18', '01234567891', 'Male'),
(2, 'Donor', 'Test Subject', 'test@subject.com', 'rizz', 'Richard', 'Steve', '2005-05-12', '01234567859', 'Male'),
(3, 'Donor', 'Shahina Akter', 'shahina@gmail.com', 'f12d0d2b478285ca6bf25df9bf87363c', 'Shahina', 'Akter', '2007-02-15', '01234567892', 'Female'),
(4, 'Seeker', 'Rahtul Akbar', 'rahtul@gmail.com', '537c09c9a2f41a57248db8c7f185944e', 'Rahtul', 'Akbar', '2003-07-10', '1231231231', 'Male'),
(5, 'Donor', 'Ibrahim Ali', 'ibrahim@gmail.com', 'f1c083e61b32d3a9be76bc21266b0648', 'Ibrahim', 'Ali', '2024-09-05', '52525252523', 'Male'),
(6, 'Donor', 'Fahim Ibrahim', 'fahim@gmail.com', 'dcbb9006afaee1296ff36eabe1cddb28', 'Fahim', 'Ibrahim', '2016-07-07', '1234567891', 'Male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`Area_ID`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`Req_ID`),
  ADD KEY `Seeker_ID` (`Seeker_ID`),
  ADD KEY `Requested_type` (`Requested_type`),
  ADD KEY `Req_Area` (`Req_Area`);

--
-- Indexes for table `blood_types`
--
ALTER TABLE `blood_types`
  ADD PRIMARY KEY (`BloodType_ID`);

--
-- Indexes for table `donor_areas`
--
ALTER TABLE `donor_areas`
  ADD PRIMARY KEY (`Donor_ID`,`Area_ID`),
  ADD KEY `Area_ID` (`Area_ID`);

--
-- Indexes for table `donor_profile`
--
ALTER TABLE `donor_profile`
  ADD PRIMARY KEY (`Donor_ID`),
  ADD KEY `BloodType_ID` (`BloodType_ID`),
  ADD KEY `Req_ID` (`Req_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`Notif_ID`),
  ADD KEY `Receiver_ID` (`Receiver_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `Area_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `Req_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `blood_types`
--
ALTER TABLE `blood_types`
  MODIFY `BloodType_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `Notif_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`Seeker_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `blood_requests_ibfk_2` FOREIGN KEY (`Requested_type`) REFERENCES `blood_types` (`BloodType_ID`),
  ADD CONSTRAINT `blood_requests_ibfk_3` FOREIGN KEY (`Req_Area`) REFERENCES `areas` (`Area_ID`);

--
-- Constraints for table `donor_areas`
--
ALTER TABLE `donor_areas`
  ADD CONSTRAINT `donor_areas_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `donor_profile` (`Donor_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `donor_areas_ibfk_2` FOREIGN KEY (`Area_ID`) REFERENCES `areas` (`Area_ID`) ON DELETE CASCADE;

--
-- Constraints for table `donor_profile`
--
ALTER TABLE `donor_profile`
  ADD CONSTRAINT `donor_profile_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `donor_profile_ibfk_2` FOREIGN KEY (`BloodType_ID`) REFERENCES `blood_types` (`BloodType_ID`),
  ADD CONSTRAINT `donor_profile_ibfk_3` FOREIGN KEY (`Req_ID`) REFERENCES `blood_requests` (`Req_ID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`Receiver_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
