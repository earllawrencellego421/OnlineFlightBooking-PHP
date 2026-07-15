-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2026
-- Server version: 5.6.21
-- PHP Version: 5.6.3
--
-- Localized for Earlines (Philippines domestic flight booking)
-- Same schema as the original ofbsphp dump — only the seed data changed.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ofbsphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_uname` varchar(20) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_pwd` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--
-- NOTE: admin_pwd hash is unchanged from the original dump so existing
-- login credentials keep working — only the e-mail was rebranded.

INSERT INTO `admin` (`admin_id`, `admin_uname`, `admin_email`, `admin_pwd`) VALUES
(1, 'admin', 'admin@earlines.ph', '$2y$10$KRXGkY.dxYjD8FLZclW/Tu04wl76lD7IA4Z3nAsxtpdZxHNbYo4ZW');

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`airline_id`, `name`, `seats`) VALUES
(1, 'Earlines', 186),
(2, 'IslandJet PH', 168),
(3, 'SkyLuzon Air', 78),
(4, 'VisMin Airways', 143),
(5, 'Pacific Wings', 50),
(9, 'Archipelago Air', 180),
(10, 'Bayanihan Air', 195),
(11, 'SunStar Airways', 72),
(12, 'Kalayaan Air', 168),
(13, 'GoIsland Airlines', 186),
(14, 'Mindanao Air', 78);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city`) VALUES
('Manila'),
('Cebu City'),
('Davao City'),
('Iloilo City'),
('Baguio City'),
('Puerto Princesa'),
('Bacolod City'),
('Cagayan de Oro'),
('Zamboanga City'),
('Tacloban City'),
('General Santos'),
('Butuan City'),
('Legazpi City'),
('Kalibo'),
('Dumaguete City'),
('Roxas City'),
('Surigao City'),
('Caticlan');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feed_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `q1` varchar(250) NOT NULL,
  `q2` varchar(20) NOT NULL,
  `q3` varchar(250) NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feed_id`, `email`, `q1`, `q2`, `q3`, `rate`) VALUES
(1, 'maria.santos@gmail.com', 'Super clean, parang app ng malaking airline agad.', 'Facebook ad', 'Wala naman, sana lang may seat map na makikita bago mag-book.', 5),
(2, 'juan.delacruz@gmail.com', 'Mabilis maghanap ng flight papuntang Cebu, madali lang gamitin.', 'Friend referral', 'Sana may push notification pag may delay.', 4),
(3, 'liza.garcia@gmail.com', 'Nagustuhan ko yung presyo, mas mura kesa sa ibang site.', 'Google search', 'Wala na, ang ganda na ng site.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `arrivale` datetime NOT NULL,
  `departure` datetime NOT NULL,
  `Destination` varchar(20) NOT NULL,
  `source` varchar(20) NOT NULL,
  `airline` varchar(20) NOT NULL,
  `Seats` varchar(110) NOT NULL,
  `duration` varchar(20) NOT NULL,
  `Price` int(11) NOT NULL,
  `status` varchar(6) DEFAULT NULL,
  `issue` varchar(50) DEFAULT NULL,
  `last_seat` varchar(5) DEFAULT '',
  `bus_seats` int(11) DEFAULT '20',
  `last_bus_seat` varchar(5) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight`
--
-- All domestic PH routes, priced in PHP. Rows 2-19 are dated "today"
-- (2026-07-10) so the admin dashboard's Today's Flights / Issues /
-- Departed / Arrived boards have live sample data out of the box.

INSERT INTO `flight` (`flight_id`, `admin_id`, `arrivale`, `departure`, `Destination`, `source`, `airline`, `Seats`, `duration`, `Price`, `status`, `issue`, `last_seat`, `bus_seats`, `last_bus_seat`) VALUES
(1, 1, '2026-07-08 07:12:00', '2026-07-08 06:05:00', 'Cebu City', 'Manila', 'Earlines', '150', '1', 2599, '', '', '', 20, ''),
(2, 1, '2026-07-10 08:15:00', '2026-07-10 07:10:00', 'Davao City', 'Cebu City', 'IslandJet PH', '58', '1', 2899, 'arr', '', '14C', 20, ''),
(3, 1, '2026-07-10 08:50:00', '2026-07-10 07:40:00', 'Manila', 'Iloilo City', 'SkyLuzon Air', '52', '1', 2199, 'arr', '', '9A', 20, ''),
(4, 1, '2026-07-10 09:00:00', '2026-07-10 08:05:00', 'Cebu City', 'Bacolod City', 'VisMin Airways', '110', '1', 1899, 'issue', '90', '', 20, ''),
(5, 1, '2026-07-10 09:45:00', '2026-07-10 08:30:00', 'Puerto Princesa', 'Manila', 'Earlines', '160', '1', 3299, '', '', '', 20, ''),
(6, 1, '2026-07-10 10:10:00', '2026-07-10 09:00:00', 'Bacolod City', 'Manila', 'Archipelago Air', '165', '1', 2750, '', '', '', 20, ''),
(7, 1, '2026-07-10 10:05:00', '2026-07-10 09:15:00', 'Tacloban City', 'Cebu City', 'Pacific Wings', '45', '1', 1899, '', '', '', 20, ''),
(8, 1, '2026-07-10 11:20:00', '2026-07-10 09:30:00', 'Zamboanga City', 'Manila', 'Bayanihan Air', '170', '2', 4599, 'arr', '', '21B', 20, ''),
(9, 1, '2026-07-10 10:55:00', '2026-07-10 10:00:00', 'Cagayan de Oro', 'Davao City', 'Mindanao Air', '60', '1', 1799, '', '', '', 20, ''),
(10, 1, '2026-07-10 11:30:00', '2026-07-10 10:20:00', 'Manila', 'Cebu City', 'GoIsland Airlines', '175', '1', 2699, '', '', '', 20, ''),
(11, 1, '2026-07-10 11:55:00', '2026-07-10 10:45:00', 'Kalibo', 'Manila', 'Earlines', '155', '1', 2999, '', '', '', 20, ''),
(12, 1, '2026-07-10 12:30:00', '2026-07-10 11:00:00', 'Butuan City', 'Manila', 'IslandJet PH', '140', '1', 3899, '', '', '', 20, ''),
(13, 1, '2026-07-10 12:15:00', '2026-07-10 11:20:00', 'Legazpi City', 'Manila', 'SkyLuzon Air', '70', '1', 1999, 'issue', '75', '', 20, ''),
(14, 1, '2026-07-10 13:00:00', '2026-07-10 11:45:00', 'General Santos', 'Cebu City', 'VisMin Airways', '130', '1', 3299, 'issue', '110', '', 20, ''),
(15, 1, '2026-07-10 13:35:00', '2026-07-10 12:10:00', 'Dumaguete City', 'Manila', 'Archipelago Air', '175', '1', 3499, 'issue', '95', '', 20, ''),
(16, 1, '2026-07-10 13:45:00', '2026-07-10 12:40:00', 'Roxas City', 'Manila', 'Pacific Wings', '48', '1', 2450, 'dep', '', '', 20, ''),
(17, 1, '2026-07-10 15:05:00', '2026-07-10 13:10:00', 'Manila', 'Davao City', 'Bayanihan Air', '190', '2', 4299, 'arr', '', '', 20, ''),
(18, 1, '2026-07-10 14:40:00', '2026-07-10 13:30:00', 'Puerto Princesa', 'Cebu City', 'GoIsland Airlines', '180', '1', 3199, 'dep', '', '', 20, ''),
(19, 1, '2026-07-10 15:30:00', '2026-07-10 14:00:00', 'Surigao City', 'Manila', 'Earlines', '145', '1', 3699, '', '', '', 20, ''),
(20, 1, '2026-07-10 23:58:00', '2026-07-10 22:14:00', 'Caticlan', 'Manila', 'Mindanao Air', '75', '1', 2899, 'dep', '', '21B', 20, ''),
(21, 1, '2026-07-11 00:20:00', '2026-07-10 23:15:00', 'Cagayan de Oro', 'Zamboanga City', 'IslandJet PH', '65', '1', 1799, '', '', '', 20, '');

-- --------------------------------------------------------

--
-- Table structure for table `passenger_profile`
--

CREATE TABLE `passenger_profile` (
  `passenger_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `mobile` varchar(110) NOT NULL,
  `dob` datetime NOT NULL,
  `f_name` varchar(20) DEFAULT NULL,
  `m_name` varchar(20) DEFAULT NULL,
  `l_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passenger_profile`
--

INSERT INTO `passenger_profile` (`passenger_id`, `user_id`, `flight_id`, `mobile`, `dob`, `f_name`, `m_name`, `l_name`) VALUES
(1, 1, 1, '09171234567', '1995-01-01 00:00:00', 'Maria', 'S', 'Santos'),
(2, 2, 3, '09228675309', '1995-02-13 00:00:00', 'Juan', 'D', 'Dela Cruz'),
(3, 3, 2, '09173456789', '1994-06-21 00:00:00', 'Andres', 'R', 'Reyes'),
(4, 4, 2, '09056789012', '1995-05-16 00:00:00', 'Liza', 'G', 'Garcia'),
(5, 2, 8, '09228675309', '1995-02-13 00:00:00', 'Juan', 'D', 'Dela Cruz'),
(6, 2, 20, '09228675309', '1995-02-13 00:00:00', 'Juan', 'D', 'Dela Cruz');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `card_no` varchar(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `expire_date` varchar(5) DEFAULT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`card_no`, `user_id`, `flight_id`, `expire_date`, `amount`) VALUES
('4013560012345678', 4, 2, '10/28', 2899),
('4013560087654321', 2, 20, '12/27', 2899),
('4571220099887766', 2, 3, '12/27', 2199),
('4571220011223344', 2, 8, '12/27', 4599),
('5289330055667788', 3, 2, '12/27', 2899),
('5289330099001122', 1, 1, '02/28', 2599);

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwd_reset_id` int(11) NOT NULL,
  `pwd_reset_email` varchar(50) NOT NULL,
  `pwd_reset_selector` varchar(80) NOT NULL,
  `pwd_reset_token` varchar(120) NOT NULL,
  `pwd_reset_expires` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seat_no` varchar(10) NOT NULL,
  `cost` int(11) NOT NULL,
  `class` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `passenger_id`, `flight_id`, `user_id`, `seat_no`, `cost`, `class`) VALUES
(1, 1, 1, 1, '12A', 2599, 'E'),
(2, 2, 3, 2, '9A', 2199, 'E'),
(4, 3, 2, 3, '14A', 2899, 'E'),
(6, 4, 2, 4, '14C', 2899, 'E'),
(8, 5, 8, 2, '21A', 4599, 'E'),
(10, 6, 20, 2, '21A', 2899, 'E');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--
-- NOTE: password hashes unchanged from the original dump.

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(1, 'maria.santos', 'maria.santos@gmail.com', '$2y$10$KRXGkY.dxYjD8FLZclW/Tu04wl76lD7IA4Z3nAsxtpdZxHNbYo4ZW'),
(2, 'juan.delacruz', 'juan.delacruz@gmail.com', '$2y$10$KRXGkY.dxYjD8FLZclW/Tu04wl76lD7IA4Z3nAsxtpdZxHNbYo4ZW'),
(3, 'andres.reyes', 'andres.reyes@gmail.com', '$2y$10$KRXGkY.dxYjD8FLZclW/Tu04wl76lD7IA4Z3nAsxtpdZxHNbYo4ZW'),
(4, 'liza.garcia', 'liza.garcia@gmail.com', '$2y$10$KRXGkY.dxYjD8FLZclW/Tu04wl76lD7IA4Z3nAsxtpdZxHNbYo4ZW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feed_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `passenger_profile`
--
ALTER TABLE `passenger_profile`
  ADD PRIMARY KEY (`passenger_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`card_no`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwd_reset_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `passenger_id` (`passenger_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `passenger_profile`
--
ALTER TABLE `passenger_profile`
  MODIFY `passenger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwd_reset_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `passenger_profile`
--
ALTER TABLE `passenger_profile`
  ADD CONSTRAINT `passenger_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `passenger_profile_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`passenger_id`) REFERENCES `passenger_profile` (`passenger_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
