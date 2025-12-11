-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 09:40 PM
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
-- Database: `airline_db`
--
CREATE DATABASE IF NOT EXISTS `airline_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `airline_db`;

-- --------------------------------------------------------

--
-- Table structure for table `aircraft`
--

CREATE TABLE `aircraft` (
  `aircraft_id` int(11) NOT NULL,
  `model` varchar(60) DEFAULT NULL,
  `manufacturer` varchar(60) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aircraft`
--

INSERT INTO `aircraft` (`aircraft_id`, `model`, `manufacturer`, `capacity`) VALUES
(1, 'Boeing 737', 'Boeing', 160),
(2, 'Airbus A320', 'Airbus', 150),
(3, 'Boeing 777', 'Boeing', 300),
(4, 'Airbus A350', 'Airbus', 280),
(5, 'Boeing 787', 'Boeing', 250);

-- --------------------------------------------------------

--
-- Stand-in structure for view `aircraft_view`
-- (See below for the actual view)
--
CREATE TABLE `aircraft_view` (
`aircraft_id` int(11)
,`model` varchar(60)
,`manufacturer` varchar(60)
,`capacity` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `airline_company`
--

CREATE TABLE `airline_company` (
  `airline_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airline_company`
--

INSERT INTO `airline_company` (`airline_id`, `name`) VALUES
(1, 'SkyHigh Airlines'),
(2, 'Global Wings'),
(3, 'AeroExpress'),
(4, 'FlyAway Airways'),
(5, 'CloudNine Flights');

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `airport_code` varchar(10) NOT NULL,
  `city` varchar(120) DEFAULT NULL,
  `country` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`airport_code`, `city`, `country`) VALUES
('CDG', 'Paris', 'France'),
('DXB', 'Dubai', 'UAE'),
('HND', 'Tokyo', 'Japan'),
('JFK', 'New York', 'USA'),
('LHR', 'London', 'UK');

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_number` int(11) NOT NULL,
  `airline_id` int(11) DEFAULT NULL,
  `aircraft_id` int(11) DEFAULT NULL,
  `departure_time` datetime DEFAULT NULL,
  `arrival_time` datetime DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `departure_airport_code` varchar(10) DEFAULT NULL,
  `arrival_airport_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_number`, `airline_id`, `aircraft_id`, `departure_time`, `arrival_time`, `duration_minutes`, `departure_airport_code`, `arrival_airport_code`) VALUES
(1001, 1, 1, '2024-02-01 08:00:00', '2024-02-01 12:00:00', 240, 'JFK', 'LHR'),
(1002, 2, 2, '2024-02-02 09:00:00', '2024-02-02 13:30:00', 270, 'LHR', 'CDG'),
(1003, 3, 3, '2024-02-03 10:00:00', '2024-02-03 18:00:00', 480, 'CDG', 'HND'),
(1004, 4, 4, '2024-02-04 11:00:00', '2024-02-04 15:00:00', 240, 'HND', 'DXB'),
(1005, 5, 5, '2024-02-05 12:00:00', '2024-02-05 16:30:00', 270, 'DXB', 'JFK');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `passenger_id` int(11) NOT NULL,
  `passenger_name` varchar(120) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `nationality` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`passenger_id`, `passenger_name`, `date_of_birth`, `phone_number`, `email`, `nationality`) VALUES
(1, 'Terry Paranych', '1985-06-15', '973-555-1234', 'terry.paranych@gmail.com', 'USA'),
(2, 'Linda Green', '1990-09-22', '618-746-0958', 'linda.green@AOL.com', 'Mexico'),
(3, 'Mac DeMarco', '1978-12-05', '415-555-7890', 'MKvideotape@gmail.com', 'Canada'),
(4, 'Sophie Turner', '1995-02-21', '212-555-4567', 'sophie.turner@example.com', 'UK'),
(5, 'Ethan Kumar', '1988-11-30', '987-555-3210', 'EthanKumar@myspace.com', 'India');

-- --------------------------------------------------------

--
-- Table structure for table `payment_record`
--

CREATE TABLE `payment_record` (
  `payment_id` int(11) NOT NULL,
  `ticket_number` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_record`
--

INSERT INTO `payment_record` (`payment_id`, `ticket_number`, `payment_date`, `amount`, `payment_method`) VALUES
(301, 201, '2024-01-10 10:05:00', 300.00, 'Credit Card'),
(302, 202, '2024-01-11 11:05:00', 1500.00, 'PayPal'),
(303, 203, '2024-01-12 12:05:00', 800.00, 'Debit Card'),
(304, 204, '2024-01-13 13:05:00', 250.00, 'Bank Transfer'),
(305, 205, '2024-01-14 14:05:00', 900.00, 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `staff_member`
--

CREATE TABLE `staff_member` (
  `employee_id` int(11) NOT NULL,
  `airline_id` int(11) DEFAULT NULL,
  `staff_name` varchar(120) DEFAULT NULL,
  `staff_position` varchar(60) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `flight_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_member`
--

INSERT INTO `staff_member` (`employee_id`, `airline_id`, `staff_name`, `staff_position`, `salary`, `flight_number`) VALUES
(101, 1, 'Alice Johnson', 'pilots', 90000, 1001),
(102, 1, 'Bob Smith', 'crew', 50000, 1001),
(103, 2, 'Charlie Brown', 'pilots', 95000, 1002),
(104, 2, 'Diana Prince', 'crew', 52000, 1002),
(105, 3, 'Ethan Hunt', 'pilots', 92000, 1003);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_number` int(11) NOT NULL,
  `passenger_id` int(11) DEFAULT NULL,
  `flight_number` int(11) DEFAULT NULL,
  `booking_date` datetime DEFAULT NULL,
  `seat_number` varchar(6) DEFAULT NULL,
  `travel_class` varchar(60) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_number`, `passenger_id`, `flight_number`, `booking_date`, `seat_number`, `travel_class`, `status`, `user_id`) VALUES
(201, 1, 1001, '2024-01-10 10:00:00', '12A', 'Economy', 'Booked', NULL),
(202, 2, 1002, '2024-01-11 11:00:00', '1B', 'First', 'Checked-in', NULL),
(203, 3, 1003, '2024-01-12 12:00:00', '5C', 'Business', 'Cancelled', NULL),
(204, 4, 1004, '2024-01-13 13:00:00', '20D', 'Economy', 'Booked', NULL),
(205, 5, 1005, '2024-01-14 14:00:00', '3E', 'Business', 'Checked-in', NULL),
(206, NULL, 1001, '2025-12-09 02:11:47', '12B', 'Economy', 'Cancelled', 8),
(207, NULL, 1002, '2025-12-09 02:20:26', '12B', 'Economy', 'Booked', 8),
(208, NULL, 1004, '2025-12-09 23:27:31', '12C', 'First', 'Cancelled', 10);

-- --------------------------------------------------------

--
-- Table structure for table `update_record`
--

CREATE TABLE `update_record` (
  `change_id` int(11) NOT NULL,
  `ticket_number` int(11) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL,
  `new_status` varchar(20) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `update_record`
--

INSERT INTO `update_record` (`change_id`, `ticket_number`, `change_date`, `new_status`, `remarks`) VALUES
(401, 201, '2024-01-15 09:00:00', 'Checked-in', 'Passenger checked in online'),
(402, 202, '2024-01-16 10:00:00', 'Cancelled', 'Flight cancelled due to weather'),
(403, 203, '2024-01-17 11:00:00', 'Booked', 'Rebooked after cancellation'),
(404, 204, '2024-01-18 12:00:00', 'Checked-in', 'Checked in at airport counter'),
(405, 205, '2024-01-19 13:00:00', 'Cancelled', 'Passenger requested cancellation'),
(406, 206, '2025-12-09 02:19:24', 'Cancelled', 'Cancelled by user (web app)'),
(407, 208, '2025-12-09 23:27:41', 'Cancelled', 'Cancelled by user (web app)');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `is_admin`) VALUES
(1, 'admin', 'admin@example.com', 'admin123', 1),
(2, 'AlexPeralta2', 'Ajperalta901@gmail.com', 'Sgtpepper18!', 0),
(8, 'AlexPeralta1', 'Ajperalta902@gmail.com', 'Y2k', 0),
(10, 'JoelWalker2', 'jw37@njit.edu', 'Y2k', 0);

-- --------------------------------------------------------

--
-- Structure for view `aircraft_view`
--
DROP TABLE IF EXISTS `aircraft_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aircraft_view`  AS SELECT `aircraft`.`aircraft_id` AS `aircraft_id`, `aircraft`.`model` AS `model`, `aircraft`.`manufacturer` AS `manufacturer`, `aircraft`.`capacity` AS `capacity` FROM `aircraft` WHERE `aircraft`.`capacity` > 150 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aircraft`
--
ALTER TABLE `aircraft`
  ADD PRIMARY KEY (`aircraft_id`);

--
-- Indexes for table `airline_company`
--
ALTER TABLE `airline_company`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`airport_code`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_number`),
  ADD KEY `fk_flight_airline` (`airline_id`),
  ADD KEY `fk_flight_aircraft` (`aircraft_id`),
  ADD KEY `fk_flight_dep_airport` (`departure_airport_code`),
  ADD KEY `fk_flight_arr_airport` (`arrival_airport_code`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`passenger_id`);

--
-- Indexes for table `payment_record`
--
ALTER TABLE `payment_record`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payment_ticket` (`ticket_number`);

--
-- Indexes for table `staff_member`
--
ALTER TABLE `staff_member`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `fk_staff_airline` (`airline_id`),
  ADD KEY `fk_staff_flight` (`flight_number`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_number`),
  ADD UNIQUE KEY `unique_passenger_flight` (`passenger_id`,`flight_number`),
  ADD KEY `fk_ticket_flight` (`flight_number`),
  ADD KEY `fk_ticket_user` (`user_id`);

--
-- Indexes for table `update_record`
--
ALTER TABLE `update_record`
  ADD PRIMARY KEY (`change_id`),
  ADD KEY `fk_update_ticket` (`ticket_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `fk_flight_aircraft` FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft` (`aircraft_id`),
  ADD CONSTRAINT `fk_flight_airline` FOREIGN KEY (`airline_id`) REFERENCES `airline_company` (`airline_id`),
  ADD CONSTRAINT `fk_flight_arr_airport` FOREIGN KEY (`arrival_airport_code`) REFERENCES `airport` (`airport_code`),
  ADD CONSTRAINT `fk_flight_dep_airport` FOREIGN KEY (`departure_airport_code`) REFERENCES `airport` (`airport_code`);

--
-- Constraints for table `payment_record`
--
ALTER TABLE `payment_record`
  ADD CONSTRAINT `fk_payment_ticket` FOREIGN KEY (`ticket_number`) REFERENCES `ticket` (`ticket_number`);

--
-- Constraints for table `staff_member`
--
ALTER TABLE `staff_member`
  ADD CONSTRAINT `fk_staff_airline` FOREIGN KEY (`airline_id`) REFERENCES `airline_company` (`airline_id`),
  ADD CONSTRAINT `fk_staff_flight` FOREIGN KEY (`flight_number`) REFERENCES `flight` (`flight_number`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `fk_ticket_flight` FOREIGN KEY (`flight_number`) REFERENCES `flight` (`flight_number`),
  ADD CONSTRAINT `fk_ticket_passenger` FOREIGN KEY (`passenger_id`) REFERENCES `passenger` (`passenger_id`),
  ADD CONSTRAINT `fk_ticket_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `update_record`
--
ALTER TABLE `update_record`
  ADD CONSTRAINT `fk_update_ticket` FOREIGN KEY (`ticket_number`) REFERENCES `ticket` (`ticket_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
