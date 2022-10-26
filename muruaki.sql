-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2021 at 07:13 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `muruaki`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) NOT NULL,
  `farmer_id` int(10) NOT NULL,
  `total_delivered` decimal(10,1) NOT NULL,
  `gross_pay` decimal(10,2) NOT NULL,
  `total_deduction` decimal(10,2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `farmer_id`, `total_delivered`, `gross_pay`, `total_deduction`, `date`) VALUES
(1, 3, '185.0', '9250.00', '5500.00', '2021-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `input_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `farmer_id` int(10) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(10) NOT NULL,
  `farmer_id` int(10) NOT NULL,
  `litres_delivered` decimal(5,1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`id`, `farmer_id`, `litres_delivered`, `date`) VALUES
(1, 3, '10.0', '2021-12-09'),
(2, 3, '15.0', '2021-12-09'),
(3, 3, '5.0', '2021-12-09'),
(4, 3, '5.0', '2021-12-09'),
(5, 3, '150.0', '2021-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `farm_inputs`
--

CREATE TABLE `farm_inputs` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(10) NOT NULL,
  `manufacturer_id` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit_of_measure` varchar(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `sold` int(10) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `farm_inputs`
--

INSERT INTO `farm_inputs` (`id`, `name`, `description`, `category_id`, `manufacturer_id`, `price`, `unit_of_measure`, `quantity`, `sold`, `photo`, `date`, `modified`) VALUES
(1, 'Curefluke', 'An effective dewormer for cow flukes.', 1, '1', '1000.00', '1 Litre', 5, 2, 'plantol-organic-fertilizer.jpg', '2021-11-14', '2021-12-11'),
(2, 'Calf Feed', 'Nutrients rich feed for young calves', 2, '1', '700.00', '20kgs', 20, 5, NULL, '2021-11-26', '2021-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `input_category`
--

CREATE TABLE `input_category` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `input_category`
--

INSERT INTO `input_category` (`id`, `name`, `description`) VALUES
(1, 'Dewormers', 'Remove worms from cows and other livestock'),
(2, 'Value Feeds', 'Nutrients rich feeds for a healthy cow'),
(3, 'Fertilizers', 'Make soil more nutritious with new fertilizers'),
(4, 'Mineral Supplements', 'Supplements for healthy livestock'),
(5, 'Pesticides', 'Exterminate pests from livestock.'),
(6, '2021-12-11', '');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`) VALUES
(1, 'Agrovet'),
(2, 'Supkem');

-- --------------------------------------------------------

--
-- Table structure for table `milkrate`
--

CREATE TABLE `milkrate` (
  `rate` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `milkrate`
--

INSERT INTO `milkrate` (`rate`) VALUES
('50.00');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_inputs`
--

CREATE TABLE `ordered_inputs` (
  `id` int(11) NOT NULL,
  `input_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0-pending, 1- processing, 2 -completed 3 - cancelled',
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ordered_inputs`
--

INSERT INTO `ordered_inputs` (`id`, `input_id`, `order_id`, `quantity`, `total`, `status`, `created`, `modified`) VALUES
(1, 2, 1, 1, '700.00', 2, '2021-12-10', '2021-12-10'),
(2, 2, 2, 1, '700.00', 2, '2021-12-11', '2021-12-11'),
(3, 1, 3, 2, '2000.00', 2, '2021-12-11', '2021-12-11'),
(4, 2, 3, 3, '2100.00', 2, '2021-12-11', '2021-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `farmer_id` int(10) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0-pending, 1-processing, 2- completed, 3 - cancelled',
  `total` decimal(10,2) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `farmer_id`, `status`, `total`, `created`, `modified`) VALUES
(1, 3, 2, '700.00', '2021-12-10', '2021-12-10'),
(2, 3, 2, '700.00', '2021-12-11', '2021-12-11'),
(3, 3, 2, '4100.00', '2021-12-11', '2021-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `route` varchar(50) DEFAULT NULL,
  `password` varchar(512) NOT NULL,
  `access_right` int(1) NOT NULL COMMENT '0 - admin, 1 - staff 2- farmer',
  `status` int(1) NOT NULL COMMENT '0 - suspended\r\n1 - active',
  `password_updated` int(1) NOT NULL,
  `access_code` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `route`, `password`, `access_right`, `status`, `password_updated`, `access_code`, `date`) VALUES
(1, 'Helu Bore', 'helubore@gmail.com', '0798134606', NULL, '$2y$10$z0xnO2CXeb9KDUwIsGkaIuEogBCLa0cS/8hCEfXtqFonF8r6OqqJW', 0, 1, 1, 'EQ8kKFRFVwRjhydGtKfeIRWkWz3wFhnj', '2021-12-11'),
(2, 'Elias Bore', 'borehelu@gmail.com', '0726559012', NULL, '$2y$10$fOYg6LTyQOxk3PBfzh.SCupO/Br0/MKSRyKubr9bDuy7FoHFj.PIC', 1, 1, 0, 'KGPQo42ySL4zuYfwzhbRke0GiNpbbaAz', '2021-12-11'),
(3, 'Helu Sandbox', 'helussandbox@gmail.com', '0726559011', 'Kianjai - Karumo', '$2y$10$7HV3NfZF4x8oU3WHCo45gOBIRRCmJhSs4LLP03MOMIvQiWhqhmmSK', 2, 1, 1, 'eZCtjyEpQrBHHQYUXmg8YdXPwPlbLimP', '2021-12-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_inputs`
--
ALTER TABLE `farm_inputs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `input_category`
--
ALTER TABLE `input_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordered_inputs`
--
ALTER TABLE `ordered_inputs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
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
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `farm_inputs`
--
ALTER TABLE `farm_inputs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `input_category`
--
ALTER TABLE `input_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ordered_inputs`
--
ALTER TABLE `ordered_inputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
