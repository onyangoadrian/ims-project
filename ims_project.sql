-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 10:45 PM
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
-- Database: `ims_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `username`, `full_name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'client1', 'Adrian Odhiambo Onyango', 'adrianprince30@gmail.com', '0715638207', 'Maasai lodge-Rongai', '2025-08-25 12:23:36'),
(235, 'client2', 'Abigael Khaemba', 'Abigael.khaemba@gmail.com', '0114589020', 'Syokimau', '2025-08-26 09:58:09'),
(236, 'client3', 'Imani Gathitu Nyambura', 'imani.gathitu@gmail.com', '0712351137', 'South C', '2025-08-29 12:06:27'),
(237, 'client4', 'Debra Rono', 'Debra.Rono@gmail.com', '0713560022', 'Membley', '2025-08-29 12:08:24'),
(238, 'client5', 'Turell Konya', 'Turell.Konya@gmail.com', '0765985655', 'Langata', '2025-08-29 12:09:55'),
(239, 'client6', 'Sandra Bernards', 'sandra.bernards@gmail.com', '0114676788', 'Kilimani', '2025-08-29 12:11:40'),
(240, 'client7', 'Simon Rodricks', 'Simon.rodricks@gmail.com', '0716789257', 'Komarock', '2025-08-29 12:13:13'),
(241, 'client8', 'Glenn Otieno', 'glennotieno@gmail.com', '0714734412', 'Kasarani', '2025-08-29 12:14:37'),
(242, 'client9', 'Rutoni wantum', 'wantum.rutoni@gmail.com', '0711111111', 'Karen', '2025-08-29 12:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `quantity`, `price`) VALUES
(1, 'Desktop Computer Case', 12, 4500.00),
(2, 'Laptop Battery', 14, 6500.00),
(3, 'Motherboard ATX', 10, 12000.00),
(4, 'CPU Intel i5', 8, 22000.00),
(5, 'CPU AMD Ryzen 5', 6, 24000.00),
(6, '8GB DDR4 RAM Stick', 20, 3500.00),
(7, '16GB DDR4 RAM Stick', 12, 6500.00),
(8, '256GB SSD Drive', 14, 6000.00),
(9, '1TB HDD Drive', 9, 6500.00),
(10, 'Power Supply Unit 500W', 7, 5500.00),
(11, 'Cooling Fan', 25, 1500.00),
(12, 'Keyboard (USB)', 29, 1200.00),
(13, 'Mouse (Optical USB)', 37, 500.00),
(14, 'LED Monitor 21 inch', 10, 7500.00),
(15, 'Laptop Charger 65W', 17, 2500.00),
(16, 'WiFi Router', 10, 4500.00),
(17, 'Network Switch 8-Port', 6, 5500.00),
(18, 'Ethernet Cable (5m)', 49, 300.00),
(19, 'Printer Ink Cartridge Black', 19, 3000.00),
(20, 'Printer Ink Cartridge Color', 15, 3500.00),
(21, 'Laser Printer Drum Kit', 5, 8000.00),
(22, 'External Hard Drive 1TB', 12, 9500.00),
(23, 'USB Flash Drive 32GB', 22, 1200.00),
(24, 'Wireless Access Point', 8, 6500.00),
(25, 'Monitor', 10, 7500.00),
(26, 'Mouse', 20, 500.00),
(27, 'Keyboard', 15, 1200.00),
(28, 'Laptop Charger', 11, 2500.00),
(29, 'Desktop Power Supply', 8, 5500.00),
(30, 'RAM 8GB', 14, 3500.00),
(31, 'RAM 16GB', 6, 6500.00),
(32, 'Hard Drive 1TB', 9, 6500.00),
(33, 'SSD 512GB', 7, 8500.00),
(34, 'Motherboard', 4, 12000.00),
(35, 'CPU Fan', 11, 1500.00),
(36, 'Graphics Card', 3, 35000.00),
(37, 'Ethernet Cable', 25, 300.00),
(38, 'Wi-Fi Router', 6, 4500.00),
(39, 'Switch (8 Port)', 4, 5500.00),
(40, 'Printer Cartridge', 9, 3000.00),
(41, 'Scanner', 2, 15000.00),
(42, 'UPS Battery Backup', 5, 8000.00),
(43, 'HDMI Cable', 18, 600.00),
(44, 'External Hard Drive 2TB', 4, 11000.00),
(45, 'Projector', 0, 35000.00),
(46, 'Webcam', 7, 2500.00),
(47, 'Headset with Mic', 10, 1800.00),
(48, 'Cooling Pad', 6, 1200.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `client_username` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parts_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `labor_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `request_id`, `client_username`, `amount`, `created_at`, `parts_total`, `labor_total`, `tax`, `total`, `notes`) VALUES
(3, 9, 'client1', NULL, '2025-08-25 11:52:34', 7500.00, 500.00, 1280.00, 9280.00, NULL),
(4, 10, 'client1', NULL, '2025-08-26 03:32:38', 2500.00, 500.00, 480.00, 3480.00, NULL),
(5, 11, 'client1', NULL, '2025-08-26 03:54:35', 0.00, 500.00, 80.00, 580.00, NULL),
(6, 12, 'client1', NULL, '2025-08-26 04:00:36', 3000.00, 500.00, 560.00, 4060.00, NULL),
(7, 14, 'client2', NULL, '2025-08-26 07:04:06', 2500.00, 500.00, 480.00, 3480.00, NULL),
(8, 13, 'client1', NULL, '2025-08-26 07:04:55', 0.00, 500.00, 80.00, 580.00, NULL),
(9, 15, 'client2', NULL, '2025-08-26 07:04:56', 0.00, 500.00, 80.00, 580.00, NULL),
(10, 16, 'client2', NULL, '2025-08-26 07:05:24', 300.00, 500.00, 128.00, 928.00, NULL),
(11, 17, 'client2', NULL, '2025-08-26 07:15:08', 12000.00, 500.00, 2000.00, 14500.00, NULL),
(12, 19, 'client1', NULL, '2025-08-27 17:42:16', 500.00, 500.00, 160.00, 1160.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `work_order_id` int(11) DEFAULT NULL,
  `technician_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `client_username` varchar(50) NOT NULL,
  `ticket_number` varchar(20) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `device` varchar(100) DEFAULT NULL,
  `issue` text DEFAULT NULL,
  `priority` enum('Low','Medium','High','Urgent') DEFAULT 'Low',
  `technician_id` int(11) DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `client_username`, `ticket_number`, `customer_id`, `device`, `issue`, `priority`, `technician_id`, `scheduled_date`, `invoice_id`, `status`, `created_at`, `description`) VALUES
(1, 'client1', NULL, NULL, NULL, NULL, 'High', 5, '2025-03-02 05:00:00', NULL, 'completed', '2025-08-23 07:59:35', 'Hard disk failure'),
(2, 'client1', NULL, NULL, NULL, NULL, 'Low', 6, '2025-09-08 05:00:00', 1, 'completed', '2025-08-23 08:00:40', 'System failure'),
(3, 'client1', NULL, NULL, NULL, NULL, 'Medium', 7, '2025-09-01 09:00:00', NULL, 'completed', '2025-08-23 08:23:29', 'Network issues'),
(4, 'client1', NULL, NULL, NULL, NULL, 'High', 6, '2025-08-30 14:00:00', NULL, 'completed', '2025-08-23 08:23:42', 'Network'),
(5, 'client1', NULL, NULL, NULL, NULL, 'High', 5, '2025-08-30 14:00:00', NULL, 'completed', '2025-08-25 08:11:18', 'System maintenance and upgrade'),
(6, 'client1', NULL, NULL, NULL, NULL, 'Medium', 6, '2925-08-26 16:00:00', NULL, 'completed', '2025-08-25 09:29:11', 'Faulty Mouse'),
(7, 'client1', NULL, NULL, NULL, NULL, 'Low', 7, '2025-09-09 16:00:00', 2, 'completed', '2025-08-25 10:09:25', 'Regular maintenance'),
(8, 'client1', NULL, NULL, NULL, NULL, 'High', 6, '2025-09-09 15:00:00', NULL, 'completed', '2025-08-25 11:19:54', 'Faulty monigtor'),
(9, 'client1', NULL, NULL, NULL, NULL, 'Medium', 7, '2025-09-09 14:00:00', 3, 'completed', '2025-08-25 11:49:07', 'faulty \r\nmonitor '),
(10, 'client1', NULL, NULL, NULL, NULL, 'Urgent', 8, '2925-08-27 15:00:00', 4, 'completed', '2025-08-25 11:49:58', 'new laptop charger 65W'),
(11, 'client1', NULL, NULL, NULL, NULL, 'Low', 10, '2025-08-29 12:00:00', 5, 'completed', '2025-08-25 11:50:21', 'Faulty keyboard'),
(12, 'client1', NULL, NULL, NULL, NULL, 'High', 1, '2025-08-29 15:00:00', 6, 'completed', '2025-08-26 03:58:34', 'printer black ink refill'),
(13, 'client1', NULL, NULL, NULL, NULL, 'Medium', 1, '2025-09-09 15:00:00', 8, 'completed', '2025-08-26 04:01:19', 'regular maintenance'),
(14, 'client2', NULL, NULL, NULL, NULL, 'High', 6, '2025-09-09 15:00:00', 7, 'completed', '2025-08-26 06:58:46', 'Faulty Charger in need of replacement'),
(15, 'client2', NULL, NULL, NULL, NULL, 'Medium', 10, '2025-09-08 17:00:00', 9, 'completed', '2025-08-26 07:01:28', 'Maintenance'),
(16, 'client2', NULL, NULL, NULL, NULL, 'Low', 3, '2025-08-29 15:00:00', 10, 'completed', '2025-08-26 07:02:53', 'Ethernet cable not working'),
(17, 'client2', NULL, NULL, NULL, NULL, 'Low', 9, '2025-08-30 16:00:00', 11, 'completed', '2025-08-26 07:09:23', 'System Maintenance and Upgrade'),
(18, 'client1', NULL, NULL, NULL, NULL, 'Low', 3, '2025-09-09 12:00:00', NULL, 'in_progress', '2025-08-26 07:13:05', 'SYSTEM MAINTENANCE'),
(19, 'client1', NULL, NULL, NULL, NULL, 'Medium', 3, '2025-09-01 14:59:00', 12, 'completed', '2025-08-27 17:38:04', 'faulty mouse'),
(20, 'client1', NULL, NULL, NULL, NULL, 'Medium', NULL, '2025-09-01 14:00:00', NULL, 'pending', '2025-08-27 17:41:18', 'SYSTEM MAINTENANC'),
(21, 'client1', NULL, NULL, NULL, NULL, 'Low', NULL, '2025-09-01 14:00:00', NULL, 'pending', '2025-09-01 09:24:02', 'system');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('available','busy') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `name`, `specialty`, `phone`, `status`) VALUES
(1, 'Adrian', 'software', '0715638207', 'available'),
(2, 'ALVIN KYalo', 'software', '0723487722', 'available'),
(3, 'Julian Sanya', 'Hardware', '0712345789', 'busy'),
(4, 'Videll', 'Konya', '0114589020', 'available'),
(5, 'Rod wvae', 'Technical repairs', '0723487722', 'available'),
(6, 'Vivian Jumbe', NULL, '071648564', 'available'),
(7, 'Ben Amolo', NULL, '0722385332', 'available'),
(8, 'Jane Abila', NULL, '0765916742', 'available'),
(9, 'Sheillah Awuor', NULL, '0115689969', 'available'),
(10, 'Nicolette Upendo', NULL, '0764987480', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','client') NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(123, 'admin1', '$2y$10$Lugl7nwMGeQw7SXKCE1tpOlQIdi3fc1E7kaY4s1LF5CV9MZAMPaaK', 'admin'),
(234, 'client2', '$2y$10$24xfVq5spac3JVe4yovWnOR0.TTn8QQgLQ/c7n2KTHwnhvcNjS4ea', 'client'),
(1234, 'client1', '$2y$10$Guv4TPM/G2naE0EQpGjlOOU7GH6t7vRrDmEHuzUPy1VW.AQzS5up.', 'client'),
(1046072, 'client3', '$2y$10$V8jxDIr3Kn0R7dyFoo0hiOjZvul5uQvqy59ERtiXz/XaU6ajJMg0y', 'client'),
(1046074, 'client4', '$2y$10$o39VCXoUVSWlSSzKliY3be3wdOq25VZpKJaUBlj9vtHroOK1xQ/h6', 'client'),
(1046075, 'client5', '$2y$10$VBr7fZ.QsoFasoHdQukViuJXEUGnDuOg6u3eI7CLZjzTtz1wDCvdS', 'client'),
(1046076, 'client6', '$2y$10$ErJD/jrls65g/bWvwJisnuL9JVmvi6m448I0EKkxsJna/lAQ9m6.e', 'client'),
(1046077, 'client7', '$2y$10$OE0R4R5Njv2g1XGDg4ZWm.YxA0l.NJslvHpLCoKrIhoOlx5dezjO.', 'client'),
(1046078, 'client8', '$2y$10$KQooZZ7HFFM.BQtHw4NwFekM86wd3C7vHgZwm3kP2VUzIeJNLVT62', 'client'),
(1046079, 'client9', '$2y$10$X.ij0YvscdnTsiQS0XsZDe13wIqmBIsyARbi9gM22a2AlhOKHgJrK', 'client'),
(1046080, 'client10', '$2y$10$fFKE66B1xwsLljGHVqdwBOHLOcUep46DZqBDI216TXsj1XT2B2CKC', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `work_orders`
--

CREATE TABLE `work_orders` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `technician_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('Queued','In Progress','Awaiting Parts','Completed','Cancelled') DEFAULT 'Queued',
  `notes` text DEFAULT NULL,
  `part_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_orders`
--

INSERT INTO `work_orders` (`id`, `request_id`, `technician_id`, `start_date`, `due_date`, `status`, `notes`, `part_id`) VALUES
(9, 12, NULL, NULL, NULL, 'Queued', NULL, 19),
(10, 14, NULL, NULL, NULL, 'Queued', NULL, 28),
(11, 16, NULL, NULL, NULL, 'Queued', NULL, 18),
(12, 17, NULL, NULL, NULL, 'Queued', NULL, 34),
(13, 19, NULL, NULL, NULL, 'Queued', NULL, 13),
(14, 18, NULL, NULL, NULL, 'Queued', NULL, 45),
(15, 18, NULL, NULL, NULL, 'Queued', NULL, 45);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_id` (`work_order_id`),
  ADD KEY `technician_id` (`technician_id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_number` (`ticket_number`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `work_orders`
--
ALTER TABLE `work_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `technician_id` (`technician_id`),
  ADD KEY `fk_part` (`part_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1046081;

--
-- AUTO_INCREMENT for table `work_orders`
--
ALTER TABLE `work_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`);

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `work_orders`
--
ALTER TABLE `work_orders`
  ADD CONSTRAINT `fk_part` FOREIGN KEY (`part_id`) REFERENCES `inventory` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `work_orders_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `service_requests` (`id`),
  ADD CONSTRAINT `work_orders_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
