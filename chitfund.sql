-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2024 at 11:42 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chitfund`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `CreatedDate` varchar(100) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`ID`, `Name`, `Amount`, `CreatedDate`, `Status`) VALUES
(1, 'sadfsdf', 100000.00, NULL, NULL),
(2, 'group1', 20000.00, '0000-00-00', '1'),
(3, 'group3', 100000.00, '04-03-2024 18:34:08', '1'),
(4, 'group3', 30000.00, '04-03-2024 19:00:21', '1'),
(5, 'group4', 400000.00, '04-03-2024 19:05:14', '1'),
(6, 'nhugg', 10000.00, '05-03-2024 10:28:31', '1'),
(7, 'asdf', 233333.00, '05-03-2024 19:02:57', '1');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Zip` int(100) NOT NULL,
  `ContributionAmount` decimal(10,2) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `ReferBy` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`ID`, `GroupID`, `Name`, `Email`, `Phone`, `Address`, `City`, `State`, `Zip`, `ContributionAmount`, `Status`, `ReferBy`) VALUES
(1, 0, 'Harish Kumar', 'harish.mymovies@gmail.com', '+917087196464', '20A, Bank Colony, 33 Feet Road, Mundian Kalan', 'LUDHIANA', 'PB', 141015, NULL, NULL, 0),
(4, 0, 'Zareen', 'someemail@gmail.com', '+917087196464', 'street add', 'LUDHIANA', 'PB', 141015, NULL, NULL, 0),
(5, 4, 'Neelam Khanna', 'neelamkhanna@gmail.com', '76543216', 'some address  009', 'Delhi', 'DL', 110020, NULL, NULL, 0),
(7, 1, 'Sooriya', 'sooriya@gmail.com', '765545578', 'Lane #1', 'Bangalore', 'KA', 11111, NULL, NULL, 0),
(8, 3, 'Suresh', 'suresh@gmail.com', '8978675645', 'lane #2', 'Banagalore', 'KA', 11111, NULL, NULL, 0),
(9, 1, 'Jeewan Jagga', 'jeewanjagga@gmail.com', '8989898989', '78 Jhabewal', 'Ludhiana', 'PB', 141010, NULL, NULL, 0),
(10, 6, 'Krishna', 'krishna@gmail.com', '898979797', '#23B. Model Town', 'Ludhiana', 'PB', 101010, NULL, NULL, 0),
(11, 4, 'Roshan', 'roshan@gmail.com', '8978675653', 'Kalkaji', 'New Delhi', 'DL', 41414, NULL, NULL, 0),
(12, 3, 'Vinod', 'vinod@gmail.com', '565656565', '675B', 'Kanpur', 'UP', 57874, NULL, NULL, 0),
(13, 4, 'Pinki', 'pinki@gmail.com', '675767676', 'House no 2', 'Patiala', 'PB', 12121, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
