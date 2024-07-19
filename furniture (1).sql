-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 03:50 PM
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
-- Database: `furniture`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `username`, `password`, `is_admin`) VALUES
(1, 'ivanrodi229@gmail.com', 'Rodi', '$2y$10$wsYJPAyILQC5lq7MzQC9cewppPgzfNPPbvUimw3IAdd75y8nH9Wqy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(9) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `amount`) VALUES
(9, 1, 4, 1, 30000.00),
(12, 1, 5, 1, 30000.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `cart_id`, `payment_method`, `date`) VALUES
(1, 2, 'cash_on_delivery', '2024-07-19'),
(2, 2, 'cash_on_delivery', '2024-07-19'),
(5, 2, 'cash_on_delivery', '2024-07-19'),
(6, 2, 'cash_on_delivery', '2024-07-19'),
(7, 2, 'cash_on_delivery', '2024-07-19');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `orders_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `orders_id`, `product_id`, `quantity`, `price`, `amount`) VALUES
(1, 5, 6, 1, 30000, 30000),
(2, 5, 7, 1, 30000, 30000),
(3, 7, 12, 1, 29000, 29000),
(4, 7, 8, 1, 33000, 33000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `category` enum('living_room','dining_room','bedroom','home_office') DEFAULT NULL,
  `status` enum('Available','Not available') DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `weight_capacity` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `admin_id`, `product_name`, `category`, `status`, `price`, `quantity`, `color`, `size`, `weight_capacity`, `description`, `product_image`, `file_path`, `date`) VALUES
(3, NULL, 'Nesting Table', 'living_room', 'Available', 30000.00, 2, 'grey', 'Queen 60 x 75 in', '95 kg', 'very comfortable to use', 'uploads/nestingtable.png', 'models/nestingtable.glb', '2024-06-25'),
(4, NULL, 'Yellow Armchair', 'dining_room', 'Available', 30000.00, 100, 'grey', 'Queen 60 x 75 in', '120 kg', 'very comfortable', 'uploads/yellowarmchair.png', 'models/yellowarmchair.glb', '2024-06-25'),
(5, NULL, 'Lounger', 'living_room', 'Available', 30000.00, 12, 'white', 'Queen 60 x 75 in', '10kg -15kg', 'Very comfy to use', 'uploads/lounger.png', 'models/lounger.glb', '2024-06-25'),
(6, NULL, 'Marble Coffee Table', 'dining_room', 'Available', 30000.00, 1, 'white', 'Queen 60 x 75 in', '120 kg', 'very comfy', 'uploads/marblecoffeetable.png', 'models/marblecoffeetable.glb', '2024-06-25'),
(7, NULL, 'Chair with Gold', 'living_room', 'Available', 30000.00, 12, 'grey', 'Queen 60 x 75 in', '120 kg', 'very comfy', 'uploads/chairwithgold.png', 'models/chairwithgold.glb', '2024-06-25'),
(8, NULL, 'Sagara Bed', 'bedroom', 'Available', 33000.00, 2, 'grey', 'Queen 60 x 75 in', '95 kg', 'very comfortable to use', 'uploads/sagarabed.png', 'models/sagarabed.glb', '2024-06-25'),
(9, NULL, 'Victorian Bed', 'bedroom', 'Available', 44000.00, 100, 'grey', 'Queen 60 x 75 in', '120 kg', 'very comfortable', 'uploads/victorianbed.png', 'models/victorianbed.glb', '2024-06-25'),
(10, NULL, 'Dining Table Glass', 'dining_room', 'Available', 35000.00, 12, 'white', 'Queen 60 x 75 in', '10kg -15kg', 'Very comfy to use', 'uploads/diningtableglass.png', 'models/diningtableglass.glb', '2024-06-25'),
(11, NULL, 'Agape Bed', 'bedroom', 'Available', 27000.00, 1, 'white', 'Queen 60 x 75 in', '120 kg', 'very comfy', 'uploads/agapebed.png', 'models/agapebed.glb', '2024-06-25'),
(12, NULL, 'Orson 2-Seater Sofa', 'living_room', 'Available', 29000.00, 12, 'grey', 'Queen 60 x 75 in', '120 kg', 'very comfy', 'uploads/orson2seatersofa.png', 'models/orson2seatersofa.glb', '2024-06-25'),
(13, NULL, 'Corner Sectional Sofa', 'living_room', 'Available', 33000.00, 12, 'grey', 'Queen 60 x 75 in', '120 kg', 'very comfy', 'uploads/cornersectionalsofa.png', 'models/cornersectionalsofa.glb', '2024-06-25'),
(14, NULL, 'Office Desk Metallic', 'home_office', 'Available', 33000.00, 2, 'grey', 'Queen 60 x 75 in', '95 kg', 'very comfortable to use', 'uploads/officedeskmetallic.png', 'models/officedeskmetallic.glb', '2024-06-25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_user` int(11) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `phone_number`, `address`, `is_user`, `profile_picture`) VALUES
(1, 'Ronilo', 'Rejuso', 'ronilorejuso21@gmail.com', '$2y$10$xuWIy/1WtlP65UCJG3UUZuDLjvQTvAnoW/RWznDZMJLAgKwX2Kf.G', NULL, NULL, 1, NULL),
(2, 'Ivan', 'Rodriguez', 'ivanrodi229@gmail.com', '$2y$10$mnGsbgqsoLQE.tdCp0G5i.zXBweinC/p3HkmfPi2iZEn.ZAKCXLO.', '09773637200', 'Blk 3 Lot 13 Phase 4, Dila, City of Santa Rosa, Laguna, 4026', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`orders_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `admin_id` (`admin_id`);

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_cart_id` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`),
  ADD CONSTRAINT `fk_orders_id` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
