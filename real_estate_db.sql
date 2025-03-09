-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 06:06 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `real_estate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `id` int(11) NOT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `agency` varchar(100) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`id`, `agent_id`, `agency`, `experience`, `bio`, `status`, `created_at`) VALUES
(1, 7, 'In quidem nulla dele', 65, 'Officia consectetur', 1, '2025-03-05 18:13:31'),
(4, 8, 'Dicta in vero offici', 19, 'Fugiat ut sapiente d', 1, '2025-03-06 02:38:56'),
(5, 14, 'Sed autem mollitia s', 10, 'Iusto nulla fugiat m', 1, '2025-03-08 07:12:33'),
(6, 15, 'Kevin Page', 1998, 'Nesciunt in nisi ut', 1, '2025-03-08 09:58:07'),
(7, NULL, 'Marah Wilcox', 2018, 'Cupidatat natus et e', 0, '2025-03-08 11:00:56'),
(8, NULL, 'Tobias Hopper', 2011, 'Veniam amet ipsam', 0, '2025-03-08 11:02:13'),
(9, NULL, 'Kyla Welch', 1977, 'Hic consequatur omn', 0, '2025-03-08 11:05:29'),
(10, 20, 'Howard Carney', 1809, 'Quam ut dolores temp', 1, '2025-03-08 11:07:06'),
(11, 21, 'David Walter', 2007, 'Deserunt molestiae v', 1, '2025-03-08 11:11:35'),
(12, 22, 'Aut autem magna sunt', 65, 'Vel quis aut qui fug', 1, '2025-03-08 12:40:42');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Emerald Santos', 'Sequi cupidatat volu', '2025-03-02 17:29:19'),
(2, 'Natalie Fields', 'Eos quas dignissimo', '2025-03-02 17:29:29'),
(3, 'Wallace Le', 'Reiciendis omnis qua', '2025-03-08 12:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `hiring_requests`
--

CREATE TABLE `hiring_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `transaction_type` enum('rent','buy','sell') NOT NULL,
  `property_category` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `min_budget` decimal(10,2) DEFAULT NULL,
  `max_budget` decimal(10,2) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `requirements` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hiring_requests`
--

INSERT INTO `hiring_requests` (`id`, `user_id`, `agent_id`, `transaction_type`, `property_category`, `location`, `min_budget`, `max_budget`, `bedrooms`, `requirements`, `created_at`) VALUES
(1, 29, 7, 'rent', 2, 'Quia omnis esse lab', 15.00, 63.00, 3, 'Tempore doloribus e', '2025-03-09 02:50:52'),
(2, 29, 8, 'sell', 2, 'Consequatur Tempora', 86.00, 85.00, 3, 'Corporis mollit enim', '2025-03-09 03:31:07'),
(3, 29, 8, 'buy', 1, 'Quo ut ex sed laboru', 2.00, 3.00, 4, 'Soluta vitae et id e', '2025-03-09 03:32:56'),
(4, 24, 15, 'buy', 3, 'Modi fugiat velit p', 79.00, 19.00, 4, 'Harum quam non commo', '2025-03-09 03:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','bank_transfer','paypal') NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `rent_price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `status` enum('available','sold','rented') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `category_id`, `title`, `description`, `location`, `rent_price`, `old_price`, `bedrooms`, `bathrooms`, `area`, `image_url`, `agent_id`, `status`, `created_at`) VALUES
(1, 2, 'Doloremque sapiente', 'Dolorum aspernatur c', 'Lahore', 721.00, 143.00, 24, 66, 59, 'uploads/properties/property_67c90bb64562f7.15240213.jpeg', 8, 'available', '2025-03-06 02:43:02'),
(2, 1, 'Aut sit tempore vit', 'Ut minim asperiores', 'Nihil ut qui amet m', 646.00, 772.00, 48, 76, 33, 'uploads/properties/property_67cc355f71ccb8.74960539.png', 21, 'available', '2025-03-08 12:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `property_amenities`
--

CREATE TABLE `property_amenities` (
  `property_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_amenities`
--

INSERT INTO `property_amenities` (`property_id`, `amenity_id`) VALUES
(1, 1),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `property_categories`
--

CREATE TABLE `property_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_categories`
--

INSERT INTO `property_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Vera Jenkins', 'Adipisci ut qui omni', '2025-03-02 17:28:47'),
(2, 'Oleg Trevino', 'Dignissimos in quasi', '2025-03-02 17:28:58'),
(3, 'Victoria Gillespie', 'Omnis non anim quo m', '2025-03-08 12:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `specializations_agent_categories`
--

CREATE TABLE `specializations_agent_categories` (
  `id` int(11) NOT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specializations_agent_categories`
--

INSERT INTO `specializations_agent_categories` (`id`, `agent_id`, `category_id`, `created_at`) VALUES
(3, 7, 1, '2025-03-06 01:56:07'),
(4, 8, 2, '2025-03-06 02:38:56'),
(5, 8, 1, '2025-03-06 02:38:56'),
(6, 14, 2, '2025-03-08 07:12:33'),
(7, 14, 1, '2025-03-08 07:12:33'),
(8, 15, 2, '2025-03-08 09:58:07'),
(9, NULL, 2, '2025-03-08 11:00:56'),
(10, NULL, 1, '2025-03-08 11:02:13'),
(11, NULL, 2, '2025-03-08 11:02:13'),
(12, NULL, 1, '2025-03-08 11:05:29'),
(13, NULL, 2, '2025-03-08 11:05:29'),
(14, 20, 1, '2025-03-08 11:07:06'),
(16, 21, 2, '2025-03-08 12:30:24'),
(17, 22, 2, '2025-03-08 12:40:42'),
(18, 22, 1, '2025-03-08 12:40:42'),
(19, 22, 3, '2025-03-08 12:40:42');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `transaction_type` enum('hire','buy','sell') NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `property_id`, `image_url`) VALUES
(1, 1, 'uploads/properties/gallery_67c90bb645e9e5.04420550.png'),
(2, 1, 'uploads/properties/gallery_67c90bb64756f3.96866136.png'),
(3, 1, 'uploads/properties/gallery_67c90bb648fe45.68465713.png'),
(4, 1, 'uploads/properties/gallery_67c90bb6499e17.14637778.png'),
(5, 2, 'uploads/properties/gallery_67cc355f721720.71091451.png'),
(6, 2, 'uploads/properties/gallery_67cc355f723357.93437653.png'),
(7, 2, 'uploads/properties/gallery_67cc355f725390.18836969.png'),
(8, 2, 'uploads/properties/gallery_67cc355f727410.77561855.png'),
(9, 2, 'uploads/properties/gallery_67cc355f763869.64058528.png'),
(10, 2, 'uploads/properties/gallery_67cc355f765793.81964065.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `role` enum('end-user','agent','admin') NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password_hash`, `role`, `profile_pic`, `contact`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin@example.com', '$2y$10$m.4H0MmfaidsC1GzUVrAwu.dOqF6LodAlAhzR2nH9qEaruGygbMle', 'admin', 'assets/img/avatar.png', NULL, '2025-03-02 18:07:05'),
(7, 'hyredyfiz', 'a', 'hyredyfiz@mailinator.com', '$2y$10$9d/xfmmvmSNzD0gTgQYuhet4F3qDYFLllavH5fOChbisW63YhETgC', 'agent', 'uploads/avatars/agent_67c8a352148591.14389546.jpeg', '+1 (757) 804-26', '2025-03-05 18:07:36'),
(8, 'Mara Weber', 'b', 'cutyvehu@mailinator.com', '$2y$10$1RZR6WpDWqtyv4cNahCEW.tmfoUajD9b0FWD7HcG12vB9/e/L1P1.', 'agent', 'uploads/avatars/agent_67c90ac08e8845.48979356.png', '+1 (988) 471-92', '2025-03-06 02:37:32'),
(10, 'Julian Whitley update', 'c', 'fope@mailinator.com', '$2y$10$ErhfP5wOSTDRq1E5W6PPs.hHzfMpDfU8gq8R0Q2jHvU3tbNs/AF9.', 'end-user', 'uploads/avatars/Screenshot 2025-02-07 011046.png', '923001234567', '2025-03-06 16:30:29'),
(11, 'Kermit Turner', 'Kermit', 'pudywyqas@mailinator.com', '$2y$10$vIhEEVo8u2mN0Erp2nIiiO9CKHOvKXZIHTNsgGGERkXaa0JcP5v3e', 'end-user', 'uploads/avatars/user_67c9f6ef8645e3.93961276.png', '923001234567', '2025-03-06 18:37:36'),
(12, 'Cooper Moses', 'sitexa', 'guqaqez@mailinator.com', '$2y$10$2loeE4INiLW4ZeJBTsCOIu2NjUBp3JmHW/4i8Z3GmVFduGp3NeQES', 'end-user', 'uploads/avatars/user_67cbdf6d400ce4.51251256.png', '+1 (877) 259-69', '2025-03-08 06:10:10'),
(13, 'Aidan Vasquez', 'wupim', 'gojow@mailinator.com', '$2y$10$cAV55AegQv/lCodkTCrF.OyTJik77VtzC9OzF3dFn22B1ssJF0VmO', 'end-user', 'uploads/avatars/user_67cbecc8adb0f7.46256273.png', '+1 (646) 616-30', '2025-03-08 06:34:47'),
(14, 'Ariana Travis', 'arianatravis', 'cygux@mailinator.com', '$2y$10$6McVh9u3ulmfLw9l/2S6yeGejURD5pxynM4jKykYMJnJz6DuiblYi', 'agent', 'uploads/avatars/agent_67cbede1d33570.67701812.png', '+1 (199) 815-79', '2025-03-08 07:11:59'),
(15, 'Hedy Witt', 'hedywitt', 'xatiqidu@mailinator.com', '$2y$10$aAXH.1S8C.iGUBQsZWsg/uoSO6c4LQOGdfJ25FNVU/owbpGiZ21SO', 'agent', 'uploads/avatars/agent_67cc14af2eb409.56182686.png', '110', '2025-03-08 09:58:07'),
(16, 'Ruth Fernandez', NULL, 'ximafibew@mailinator.com', '$2y$10$1PNkrMari/N9EWmtU9V2L.ax/CBUmpfqvaDUKmQb5RAMfnmb5XCpy', 'end-user', NULL, '12', '2025-03-08 10:44:41'),
(20, 'Selma Gates', 'selmagates', 'iramjaved751@gmail.com', '$2y$10$5UHTAhJdOVTQfKO8XzK7VujVlQIJpOClX6/PaygcYvwkVOrrZbBNC', 'agent', 'uploads/avatars/agent_67cc24da310233.45293646.png', '214', '2025-03-08 11:07:06'),
(21, 'Erin Mann', 'erinmann', 'cuzo@mailinator.com', '$2y$10$xYhUl/xzRSDd2P8lrT9yBe/msPYbag3H0keLHej4t3rOXTds77DZS', 'agent', 'assets/img/avatar.png', '283', '2025-03-08 11:11:35'),
(22, 'Pearl Ortega', 'pearlortega', 'hixuluraj@mailinator.com', '$2y$10$BgkCt/V.2oiuIWSjsywgoOlpFkQfJ8MhTQxzImmmF3ZkeWaLJ6xZy', 'agent', 'uploads/avatars/agent_67cc3aca4d96a2.69459963.png', '+1 (301) 548-87', '2025-03-08 12:39:45'),
(23, 'Marshall Dunn', 'tesatt', 'gepip@mailinator.com', '$2y$10$F9X1qaqtkqZsci2l9P0A1OnOmL2heFwvfg2uBoga56c14aFuIyYB.', 'end-user', 'uploads/avatars/user_67ccef4bd5b285.22882853.png', '+1 (881) 349', '2025-03-09 01:18:13'),
(24, 'Dai Mooney', 'lucec', 'xidynog@mailinator.com', '$2y$10$zzrIrI2cLIYNpRmFKVNdz.aJpIVomOIJpRxzrlAdvSxXbZ0auxZLa', 'end-user', 'uploads/avatars/user_67ccefb5befa57.65703708.png', '+1 (643) 648-27', '2025-03-09 01:32:00'),
(25, 'Tucker Pope', 'tuvekor', 'xocymonev@mailinator.com', '$2y$10$cPxTe8pIFL8zbwMsNxINQeCseRRSL7ds.5wZSINYRFyd14g6iSo2C', 'end-user', 'images/avatar.png', '+1 (786) 263-45', '2025-03-09 01:33:05'),
(26, 'Nomlanga Golden', 'kanimicab', 'pekejolyj@mailinator.com', '$2y$10$jZARsmPLpB63Zv0/78L2n.sm/n4WOjg0sme93raXs7sdnoPAsRkry', 'end-user', 'uploads/avatars/user_67ccf0243155e0.02890189.png', '+1 (455) 707-94', '2025-03-09 01:34:03'),
(27, 'Jasper Parker', 'neqoly', 'wokis@mailinator.com', '$2y$10$BDifDn2JNgmShaFm9h7J4e6KXRf./X2Eo59M46JRDY2RFzJGaWMi6', 'end-user', 'uploads/avatars/user_67ccf1122e5cb3.36425163.png', '+1 (711) 106-37', '2025-03-09 01:36:49'),
(28, 'Autumn Morrow', 'tujakewev', 'huwezusug@mailinator.com', '$2y$10$UbDFM.glqb1tbg3yTuUAGeBTBXgHT9IwhxcjxXknTaauJtepQvjAC', 'end-user', 'images/avatar.png', '+1 (905) 302-42', '2025-03-09 01:42:07'),
(29, 'Hanna Richardson', 'jihyt', 'hefe@mailinator.com', '$2y$10$9mN28phIdG0HYrRIw2ttZeewP68e9zCjCZDSDuS9okmSDTNlwLlIC', 'end-user', 'images/avatar.png', '+1 (753) 289-55', '2025-03-09 01:45:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hiring_requests`
--
ALTER TABLE `hiring_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD PRIMARY KEY (`property_id`,`amenity_id`),
  ADD KEY `amenity_id` (`amenity_id`);

--
-- Indexes for table `property_categories`
--
ALTER TABLE `property_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specializations_agent_categories`
--
ALTER TABLE `specializations_agent_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_id` (`agent_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hiring_requests`
--
ALTER TABLE `hiring_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_categories`
--
ALTER TABLE `property_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `specializations_agent_categories`
--
ALTER TABLE `specializations_agent_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent`
--
ALTER TABLE `agent`
  ADD CONSTRAINT `agent_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `property_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `properties_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD CONSTRAINT `property_amenities_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_amenities_ibfk_2` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `specializations_agent_categories`
--
ALTER TABLE `specializations_agent_categories`
  ADD CONSTRAINT `specializations_agent_categories_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `specializations_agent_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `property_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
