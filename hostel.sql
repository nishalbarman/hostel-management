-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2023 at 04:53 AM
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
-- Database: `hostel`
--

-- --------------------------------------------------------

--
-- Table structure for table `44401_714158_1234_repayment`
--

CREATE TABLE `44401_714158_1234_repayment` (
  `id` int(255) NOT NULL,
  `payment_id` int(255) NOT NULL,
  `roll` int(255) NOT NULL,
  `amount` float NOT NULL,
  `roomno` text NOT NULL,
  `status` text NOT NULL DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `44401_714158_1234_repayment`
--

INSERT INTO `44401_714158_1234_repayment` (`id`, `payment_id`, `roll`, `amount`, `roomno`, `status`) VALUES
(1, 1, 44401, 2000, '1234', 'Unpaid'),
(2, 2, 44401, 2000, '1234', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `44401_986154_1234_repayment`
--

CREATE TABLE `44401_986154_1234_repayment` (
  `id` int(255) NOT NULL,
  `payment_id` int(255) NOT NULL,
  `roll` int(255) NOT NULL,
  `amount` float NOT NULL,
  `roomno` text NOT NULL,
  `status` text NOT NULL DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `44401_986154_1234_repayment`
--

INSERT INTO `44401_986154_1234_repayment` (`id`, `payment_id`, `roll`, `amount`, `roomno`, `status`) VALUES
(1, 1, 44401, 2000, '1234', 'Unpaid'),
(2, 2, 44401, 2000, '1234', 'Unpaid'),
(3, 3, 44401, 2000, '1234', 'Unpaid'),
(4, 4, 44401, 2000, '1234', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `44401_992366_1234_repayment`
--

CREATE TABLE `44401_992366_1234_repayment` (
  `id` int(255) NOT NULL,
  `payment_id` int(255) NOT NULL,
  `roll` int(255) NOT NULL,
  `amount` float NOT NULL,
  `roomno` text NOT NULL,
  `status` text NOT NULL DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `44401_992366_1234_repayment`
--

INSERT INTO `44401_992366_1234_repayment` (`id`, `payment_id`, `roll`, `amount`, `roomno`, `status`) VALUES
(1, 1, 44401, 2000, '1234', 'Unpaid'),
(2, 2, 44401, 2000, '1234', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `phone`, `email`, `password`) VALUES
(1, 'NISHAL', 'BARMAN', '9101114906', 'nishalbarman@gmail.com', '$2y$10$Ui13oSLHNmEtU75nmeA0WOHeWEB5IaZR4zKqxgGwLqt3gJ3wBjN9u'),
(2, 'Prabal', 'Sarma', '1234567890', 'prabal@gmail.com', '$2y$10$7niyJ03oVGJJfeM.1TXa5..2UAqSc8hPe55h3DgR9zR5GM03rYrmC');

-- --------------------------------------------------------

--
-- Table structure for table `applied_rooms`
--

CREATE TABLE `applied_rooms` (
  `id` int(255) NOT NULL,
  `roll_no` int(255) NOT NULL,
  `room_table_name` varchar(255) NOT NULL,
  `room_no` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applied_rooms`
--

INSERT INTO `applied_rooms` (`id`, `roll_no`, `room_table_name`, `room_no`) VALUES
(8, 44401, '44401_986154_1234_repayment', 1234),
(9, 44401, '44401_714158_1234_repayment', 1234),
(10, 44401, '44401_992366_1234_repayment', 1234);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(255) NOT NULL,
  `roll` int(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(255) NOT NULL,
  `roomno` int(255) NOT NULL,
  `foodoption` tinyint(1) NOT NULL,
  `starting_date` date NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `duration` int(255) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `guardian_contact` varchar(13) NOT NULL,
  `guardian_relation` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(40) NOT NULL,
  `pincode` int(25) NOT NULL,
  `status` varchar(30) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `address` varchar(255) NOT NULL,
  `active` int(255) NOT NULL,
  `repay_table_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `roll`, `firstname`, `lastname`, `phone`, `email`, `roomno`, `foodoption`, `starting_date`, `end_date`, `duration`, `guardian_name`, `guardian_contact`, `guardian_relation`, `city`, `state`, `pincode`, `status`, `paid`, `address`, `active`, `repay_table_name`) VALUES
(20, 44401, 'NISHAL', 'BARMAN', '', 'nishalbarman@gmail.com', 1234, 0, '2023-02-08', '2023-05-08', 4, 'Debananda Barman', '9101114906', 'Father', 'NALBARI', 'ASSAM', 781341, 'Under Review', 0, 'Vill./P.O. - Balikaria, Nalbari, Nalbari - Kaithalkuchi Road', 1, ''),
(21, 44401, 'Nishal', 'Barman', '', 'nishalbarman@gmail.com', 1234, 0, '2023-02-08', '2023-05-08', 2, 'd', '1113', 'd', 'Nalbari', 'Assam', 781341, 'Under Review', 0, 'Vill./P.O. - Balikaria, Nalbari - Kaithalkuchi Road', 1, ''),
(22, 44401, 'Nishal', 'Barman', '+919101114906', 'nishalbarman@gmail.com', 1234, 0, '2023-02-08', '2023-05-08', 2, 'd', '1113', 'd', 'Nalbari', 'Assam', 781341, 'Under Review', 0, 'Vill./P.O. - Balikaria, Nalbari - Kaithalkuchi Road', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `fooditems`
--

CREATE TABLE `fooditems` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `stocks` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `reviews` int(255) NOT NULL,
  `total-feedbacks` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fooditems`
--

INSERT INTO `fooditems` (`id`, `title`, `subtitle`, `stocks`, `amount`, `reviews`, `total-feedbacks`, `image`, `category`) VALUES
(1, 'Burger', 'Best burger of our locality we are proud', '101', 1000, 0, 0, 'burger.jpg', 'Non-Veg Items'),
(2, 'Roti', 'Best roti of our locality we are proud', '10', 100, 0, 0, 'roti.webp', 'Veg Items'),
(3, 'Fried Chicken', 'Best fried chicken of our locality we are proud', '10', 100, 0, 0, 'chicken.jpeg', 'Non-Veg Items'),
(4, 'Momos', 'Best Momos of the decade you will love it', '10', 100, 0, 0, 'momos.jpeg', 'Non-Veg Items'),
(5, 'Chicken Tandoori', 'Best of 2022 you will love it', '100', 500, 0, 0, 'chickentandori.jpg', 'Non-Veg Items'),
(6, 'Veg Pulao', 'Pulao that is awsome and will kill you.', '100', 100, 5, 100, 'vegpulao.jpg', 'Non-Veg Items'),
(8, 'Dal Vat', 'It is an assamese tradional food', '13', 154, 0, 0, '1671370105_Dal-Bhat-Tarkari-1.jpg', 'Veg Items'),
(9, 'Chicken Roll', 'This is a Calcutta-style roll in which chicken kathi (skewered) kababs are wrapped in sweet', '213', 75, 0, 0, '1671374481_roll.jpg', 'Non-Veg Items'),
(10, 'Fried Rice', 'Transform leftover rice with peas, eggs, soy sauce, and carrots. Delicious on its own, or alongside', '103', 142, 0, 0, '1671429103_79543-fried-rice-restaurant-style-mfs-51-155e83b4e4444e2292707287a56ddd93.jpg', 'Veg Items'),
(11, 'Chicken Hakka Noodles', 'Indo Chinese Chicken Hakka Noodles is a quite popular street food in India', '211', 132, 0, 0, '1671429184_Chicken-Hakka-Noodles-2-3.jpg', 'Non-Veg Items'),
(12, 'Egg Chowmein', 'This version of chowmein is popular in roadside stalls across Calcutta', '212', 213, 0, 0, '1671429633_maxresdefault.jpg', 'Veg Items'),
(13, 'Paneer Chowmein', 'For a speedy vegetarian delight', '122', 131, 0, 0, '1671429780_paneer-chowmein-copy-440x396.jpg', 'Veg Items'),
(14, 'Chicken Chowmein', 'A super tasty Chicken Chow Mein with succulent pieces of marinated chicken and lots of fresh veggies ...', '123', 132, 0, 0, '1671429833_chicken_chow_mein_recipe_card.jpg', 'Non-Veg Items'),
(0, 'Bugga Food', 'This is the greatest food of all time, we can see', '165', 100, 0, 0, '1675702454_till-bugga-recipe-main-photo.jpg', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(6) NOT NULL,
  `payment_id` varchar(20) NOT NULL,
  `roll_no` int(8) NOT NULL,
  `fName` varchar(15) NOT NULL,
  `lName` varchar(15) NOT NULL,
  `amount` int(8) NOT NULL,
  `email` varchar(255) NOT NULL,
  `room_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `payment_id`, `roll_no`, `fName`, `lName`, `amount`, `email`, `room_no`) VALUES
(7, '1', 2510, 'NISHAL', 'BARMAN', 1000, 'nishalbarman@gmail.com', '2510_511797_1234_repayment'),
(8, '2', 2510, 'NISHAL', 'BARMAN', 1000, 'nishalbarman@gmail.com', '2510_511797_1234_repayment'),
(9, '3', 2510, 'NISHAL', 'BARMAN', 1000, 'nishalbarman@gmail.com', '2510_511797_1234_repayment'),
(10, '4', 2510, 'NISHAL', 'BARMAN', 1000, 'nishalbarman@gmail.com', '2510_511797_1234_repayment'),
(11, '1', 2509, 'Prabal', 'Sarma', 1000, 'prabaljyotisarma@gmail.com', '2509_543240_1234_repayment');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(255) NOT NULL,
  `roomno` int(255) NOT NULL,
  `seats` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `roomno`, `seats`) VALUES
(1, 1234, 38);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `roll` varchar(255) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `booked` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `firstname`, `lastname`, `phone`, `email`, `roll`, `gender`, `booked`, `password`) VALUES
(21, 'Prabal', 'Sarma', '123456789', 'prabaljyotisarma@gmail.com', '2509', 'Male', 1, '$2y$10$7niyJ03oVGJJfeM.1TXa5..2UAqSc8hPe55h3DgR9zR5GM03rYrmC'),
(22, 'NISHAL', 'BARMAN', '09101114906', 'nishal@gmail.com', '44401', '', 1, '$2y$10$Ui13oSLHNmEtU75nmeA0WOHeWEB5IaZR4zKqxgGwLqt3gJ3wBjN9u');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `applied_rooms`
--
ALTER TABLE `applied_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roomno` (`roomno`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `roll` (`roll`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applied_rooms`
--
ALTER TABLE `applied_rooms`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
