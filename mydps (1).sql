-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2024 at 10:03 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydps`
--

-- --------------------------------------------------------

--
-- Table structure for table `deposit_am`
--

CREATE TABLE `deposit_am` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `rujukan` varchar(255) DEFAULT NULL,
  `subsidiasi` int(11) DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `tempoh` int(11) DEFAULT NULL,
  `kontrak` varchar(255) DEFAULT NULL,
  `amaun` decimal(10,2) DEFAULT NULL,
  `emel` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `myfile` varchar(255) DEFAULT NULL,
  `status` enum('Disahkan','Belum Disahkan') NOT NULL DEFAULT 'Belum Disahkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit_am`
--

INSERT INTO `deposit_am` (`id`, `fname`, `rujukan`, `subsidiasi`, `tarikh`, `tempoh`, `kontrak`, `amaun`, `emel`, `phone`, `myfile`, `status`) VALUES
(36, 'wan2', '', 0, '2024-08-30', 0, '', '1.00', 'example@gmail.com', '', '', 'Disahkan'),
(37, 'testing2', '', 0, '2024-07-01', 0, '', '3.00', 'example3@gmail.com', '', NULL, 'Disahkan');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_cagaran`
--

CREATE TABLE `deposit_cagaran` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `rujukan` varchar(255) DEFAULT NULL,
  `subsidiasi` int(11) DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `tempoh` int(11) DEFAULT NULL,
  `kontrak` varchar(255) DEFAULT NULL,
  `amaun` decimal(10,2) DEFAULT NULL,
  `emel` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `myfile` varchar(255) DEFAULT NULL,
  `status` enum('Disahkan','Belum Disahkan') NOT NULL DEFAULT 'Belum Disahkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit_cagaran`
--

INSERT INTO `deposit_cagaran` (`id`, `fname`, `rujukan`, `subsidiasi`, `tarikh`, `tempoh`, `kontrak`, `amaun`, `emel`, `phone`, `myfile`, `status`) VALUES
(16, 'testing', '', 0, '2024-08-01', 0, '', '2.00', 'example2@gmail.com', '', NULL, 'Disahkan'),
(17, 'example', '', 0, '2024-03-15', 0, '346457jkyu', '700.00', 'example2@gmail.com', '', NULL, 'Disahkan'),
(18, 'example', '', 0, '2024-10-11', 0, '', '0.00', 'example3@gmail.com', '', NULL, 'Disahkan');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_kuarters`
--

CREATE TABLE `deposit_kuarters` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `rujukan` varchar(255) DEFAULT NULL,
  `subsidiasi` int(11) DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `tempoh` int(11) DEFAULT NULL,
  `kontrak` varchar(255) DEFAULT NULL,
  `amaun` decimal(10,2) DEFAULT NULL,
  `emel` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `myfile` varchar(255) DEFAULT NULL,
  `status` enum('Disahkan','Belum Disahkan') NOT NULL DEFAULT 'Belum Disahkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit_kuarters`
--

INSERT INTO `deposit_kuarters` (`id`, `fname`, `rujukan`, `subsidiasi`, `tarikh`, `tempoh`, `kontrak`, `amaun`, `emel`, `phone`, `myfile`, `status`) VALUES
(13, 'Berahil sarahil', '', 0, '2023-08-01', 0, '', '6.00', 'suhaimimajid04@gmail.com', '', NULL, 'Disahkan'),
(14, 'Abdul mallan', 'df4t5768790ghfgh', 2147483647, '2024-08-15', 30, '346457jkyu', '100.00', 'example@gmail.com', '019-472 0107', NULL, 'Disahkan');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `rujukan` varchar(255) DEFAULT NULL,
  `subsidiasi` int(11) DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `tempoh` int(11) DEFAULT NULL,
  `kontrak` varchar(255) DEFAULT NULL,
  `amaun` decimal(10,2) DEFAULT NULL,
  `emel` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `myfile` varchar(255) DEFAULT NULL,
  `source_table` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `fname`, `rujukan`, `subsidiasi`, `tarikh`, `tempoh`, `kontrak`, `amaun`, `emel`, `phone`, `myfile`, `source_table`) VALUES
(46, 'wan', '', 0, '2024-08-30', 0, '', '1.00', 'example@gmail.com', '', NULL, 'Am'),
(47, 'wan', '', 0, '2024-08-30', 0, '', '1.00', 'example@gmail.com', '', NULL, 'Am'),
(48, 'testing', '', 0, '2024-08-01', 0, '', '2.00', 'example2@gmail.com', '', NULL, 'Cagaran'),
(49, 'testing2', '', 0, '2024-07-01', 0, '', '3.00', 'example3@gmail.com', '', NULL, 'Am'),
(50, 'Berahil sarahil', '', 0, '2023-08-01', 0, '', '6.00', 'suhaimimajid04@gmail.com', '', NULL, 'Kuarters'),
(51, 'Abdul mallan', 'df4t5768790ghfgh', 2147483647, '2024-08-15', 30, '346457jkyu', '100.00', 'example@gmail.com', '019-472 0107', NULL, 'Kuarters'),
(52, 'example', '', 0, '2024-03-15', 0, '346457jkyu', '700.00', 'example2@gmail.com', '', NULL, 'Cagaran'),
(53, 'testing2', '', 0, '2023-08-30', 0, '', '8000.00', 'suhaimimajid04@gmail.com', '', NULL, 'Am'),
(54, 'example', '', 0, '2024-10-11', 0, '', '0.00', 'example3@gmail.com', '', NULL, 'Cagaran');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `created_at`) VALUES
(3, 'wan', 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', '2024-09-02 14:11:02'),
(4, 'wan', 'example@gmail.com', 'b59c67bf196a4758191e42f76670ceba', 'staff', '2024-09-02 14:14:28'),
(5, 'wan', 'ridzuanmajidd@gmail.com', 'c5fe25896e49ddfe996db7508cf00534', 'staff', '2024-09-03 06:51:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deposit_am`
--
ALTER TABLE `deposit_am`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_cagaran`
--
ALTER TABLE `deposit_cagaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_kuarters`
--
ALTER TABLE `deposit_kuarters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deposit_am`
--
ALTER TABLE `deposit_am`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `deposit_cagaran`
--
ALTER TABLE `deposit_cagaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `deposit_kuarters`
--
ALTER TABLE `deposit_kuarters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
