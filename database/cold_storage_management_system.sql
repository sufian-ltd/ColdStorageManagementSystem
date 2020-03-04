-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2020 at 06:33 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cold_storage_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `storageid` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `description` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `storageid` int(11) NOT NULL,
  `product` varchar(100) NOT NULL,
  `totalcapacity` int(11) NOT NULL,
  `availablecapacity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `storageid`, `product`, `totalcapacity`, `availablecapacity`, `price`) VALUES
(1, 1, 'Potato', 150, 120, 100),
(2, 1, 'Rice', 100, 70, 100),
(3, 1, 'Onion', 100, 100, 100),
(4, 1, 'Tomato', 200, 70, 100);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `storageid` int(11) NOT NULL,
  `storagename` varchar(100) NOT NULL,
  `productid` int(11) NOT NULL,
  `product` varchar(100) NOT NULL,
  `farmerid` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `ownerId`, `storageid`, `storagename`, `productid`, `product`, `farmerid`, `capacity`, `price`, `date`, `status`) VALUES
(1, 1, 1, 'Storage 1', 1, 'Potato', 2, 50, 100, '2020-01-15', 'checkout'),
(2, 1, 1, 'Storage 1', 2, 'Rice', 2, 30, 100, '2020-01-17', 'accepted'),
(3, 1, 1, 'Storage 1', 4, 'Tomato', 2, 50, 100, '2020-01-22', 'accepted'),
(4, 1, 1, 'Storage 1', 1, 'Potato', 2, 30, 100, '2020-01-22', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `storages`
--

CREATE TABLE `storages` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `totalcapacity` int(11) NOT NULL,
  `availablecapacity` int(11) NOT NULL,
  `division` varchar(200) NOT NULL,
  `district` varchar(200) NOT NULL,
  `thana` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `isactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `storages`
--

INSERT INTO `storages` (`id`, `userId`, `name`, `type`, `totalcapacity`, `availablecapacity`, `division`, `district`, `thana`, `location`, `latitude`, `longitude`, `isactive`) VALUES
(1, 1, 'Storage 1', 'AC', 2000, 1450, 'Dhaka', 'Chittagong', 'Pachlaish', 'Probortok', 0, 0, 1),
(2, 1, 'Storage 2', 'AC', 3000, 3000, 'Chittagong', 'Chittagong', 'Kotowali', 'Kotowali', 0, 0, 1),
(3, 1, 'Storage 3', 'AC', 2500, 2500, 'Chittagong', 'Chittagong', 'Pachlaish', 'Chokbajar', 0, 0, 1),
(4, 1, 'Storage 4', 'AC', 4000, 4000, 'Chittagong', 'Chittagong', 'Chokbajar', 'Muradpur', 0, 0, 1),
(5, 1, 'Storage 5', 'AC', 3500, 3500, 'Chittagong', 'Chittagong', 'Bakolia', 'Kalamia Bajar', 0, 0, 1),
(6, 1, 'Storage 6', 'AC', 4500, 4500, 'Chittagong', 'Chittagong', 'Halishor', 'Market', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `userType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `contact`, `address`, `userType`) VALUES
(1, 'Iqbal Mahmud', 'abiraka@yahoo.com', '827ccb0eea8a706c4c34a16891f84e7b', '018745632145', 'Chittagong', 'Owner'),
(2, 'Zahidul Islam', 'shuvo@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '01248556254', 'Chittagong', 'Farmer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storages`
--
ALTER TABLE `storages`
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
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `storages`
--
ALTER TABLE `storages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
