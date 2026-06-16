-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2026 at 09:22 PM
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
-- Database: `gogreen`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Midul', 'admin@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `points_delta` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `points_delta`, `created_at`) VALUES
(1, 1, 'warning', 'Not enough points', 'You tried to redeem Bonsai Tree but only have 25 points.', NULL, '2026-06-16 15:57:51'),
(2, 1, 'success', 'Reward Redeemed', 'Mango Tree has been redeemed and 10 points were deducted.', -10, '2026-06-16 15:58:00'),
(3, 1, 'success', 'Reward Redeemed', 'Mango Tree has been redeemed and 10 points were deducted.', -10, '2026-06-16 16:00:45'),
(4, 5, 'success', 'Reward Redeemed', 'Mango Tree has been redeemed and 10 points were deducted.', -10, '2026-06-16 17:36:16'),
(5, 6, 'success', 'Reward Redeemed', 'Mango Tree has been redeemed and 10 points were deducted.', -10, '2026-06-16 18:15:13'),
(6, 5, 'success', 'Reward Redeemed', 'Mango Tree has been redeemed and 10 points were deducted.', -10, '2026-06-16 19:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reward_redemptions`
--

CREATE TABLE `reward_redemptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward_name` varchar(100) NOT NULL,
  `reward_cost` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `bonus_given` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `points`, `bonus_given`) VALUES
(1, ' md mahamudul hasan ', 'mahmudulmidul496@gmail.com', '1234', 5, 1),
(5, 'hello', 'mahmudulmidul@gmail.com', '1234', 5, 1),
(6, 'user', 'user@gmail.com', '1234', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `waste_submissions`
--

CREATE TABLE `waste_submissions` (
  `id` int(11) NOT NULL,
  `waste_type` varchar(50) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `pickup_date` date DEFAULT NULL,
  `time_slot` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `submitter_email` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `points_awarded` int(11) DEFAULT 0,
  `points_granted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waste_submissions`
--

INSERT INTO `waste_submissions` (`id`, `waste_type`, `weight`, `description`, `address`, `pickup_date`, `time_slot`, `image_path`, `submitted_at`, `user_id`, `submitter_email`, `status`, `points_awarded`, `points_granted`) VALUES
(1, 'Plastic', 20.00, 'hello', 'Azimpur', '2026-05-30', 'Morning', 'uploads/1777965958_r15-v3-black1.png', '2026-05-05 07:25:58', NULL, NULL, 'Pending', 0, 0),
(2, 'Glass', 15.00, 'Solid Glass', 'Banani', '2026-05-10', 'Afternoon', 'uploads/1777966200_r15-v3-black1.png', '2026-05-05 07:30:00', NULL, NULL, 'Pending', 0, 0),
(3, 'Metal', 100.00, 'Metal Circuit', 'UIU', '2026-05-05', 'Afternoon', 'uploads/1777969131_Capture.PNG', '2026-05-05 08:18:51', NULL, NULL, 'Pending', 0, 0),
(4, 'Plastic', 10.00, 'jhggccgc', 'mbjgugu', '2022-04-05', 'Morning', 'uploads/1781593740_Screenshot 2026-06-16 011838.png', '2026-06-16 07:09:00', NULL, NULL, 'Pending', 0, 0),
(5, 'Plastic', 12.00, 'ddd', 'dds', '4444-03-31', 'Morning', 'uploads/1781628024_Screenshot 2025-12-16 165621.png', '2026-06-16 16:40:24', NULL, NULL, 'Pending', 0, 0),
(6, 'Plastic', 10.00, 'scxc', 'sscsc', '3435-03-04', 'Morning', 'uploads/1781628480_Screenshot 2025-12-16 160232.png', '2026-06-16 16:48:00', 1, 'mahmudulmidul496@gmail.com', 'Pending', 0, 0),
(7, 'E-waste', 10.00, 'dgg', 'dfdfa', '5555-12-31', 'Afternoon', 'uploads/1781630537_Screenshot 2026-01-01 170025.png', '2026-06-16 17:22:17', 1, 'mahmudulmidul496@gmail.com', 'Pending', 0, 0),
(8, 'Paper', 10.00, 'sddgdg', 'dgdgdg', '4444-12-31', 'Morning', 'uploads/1781631343_Screenshot 2025-12-16 160232.png', '2026-06-16 17:35:43', 5, NULL, 'Pending', 0, 0),
(9, 'Plastic', 12.00, '2qaad', 'dssd', '3322-12-11', 'Morning', 'uploads/1781632042_Screenshot 2026-06-16 223947.png', '2026-06-16 17:47:22', 5, NULL, 'Pending', 0, 0),
(10, 'Plastic', 20.00, 'huggiugyv', 'tddt', '5555-12-31', 'Evening', 'uploads/1781633226_Screenshot 2026-01-21 121118.png', '2026-06-16 18:07:06', 5, 'mahmudulmidul@gmail.com', 'Pending', 0, 0),
(11, 'Paper', 12.00, 'sqqws', 'assxaa', '2016-12-31', 'Morning', 'uploads/1781633639_Screenshot 2026-01-21 120758.png', '2026-06-16 18:13:59', 6, 'user@gmail.com', 'Pending', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `waste_submissions`
--
ALTER TABLE `waste_submissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `waste_submissions`
--
ALTER TABLE `waste_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  ADD CONSTRAINT `reward_redemptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
