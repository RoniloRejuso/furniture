

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



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
(4, 'ronilorejuso21@gmail.com', 'username03', '$2y$10$BBcxQeBzvWMpOmjrgyejF.PvCtF.kXT/3lg41d46EXmBa4BgFMy9y', NULL),
(10, 'rejusocute101@gmail.com', 'username02', '$2y$10$4rkUM1J.QiRAxgOiUaD2WuXD1o8vfgSOhki5C2VbZzMudKcrXhM5.', NULL);



CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(1, 1);

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
(15, 1, 6, 1, 30000.00),
(16, 1, 4, 1, 30000.00),
(17, 1, 3, 1, 30000.00),
(18, 1, 3, 1, 30000.00),
(19, 1, 7, 1, 30000.00);

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
(3, NULL, 'FurniView FurniView christan sectional sofa', 'living_room', 'Available', 30000.00, 2, 'grey', 'Queen 60 x 75 in', '95 kg', 'very comfortable to use', 'uploads/nesting-tables.png', 'uploads/sofa 1.jpg', '0000-00-00'),
(4, NULL, 'FurniView FurniView christan sectional sofa', 'dining_room', 'Available', 30000.00, 100, 'grey', 'Queen 60 x 75 in', '120 kg', 'very comfortable', 'uploads/nesting-tables.png', 'uploads/sofa 1.jpg', '0000-00-00'),
(5, NULL, 'FurniView FurniView sofa', 'living_room', 'Available', 30000.00, 12, 'white', 'Queen 60 x 75 in', '10kg -15kg', 'Very comfy to use', 'uploads/sofa 1.jpg', 'uploads/sofa 1.jpg', '2024-06-22'),
(6, NULL, 'FurniView FurniView sofa', 'dining_room', 'Available', 30000.00, 1, 'white', 'Queen 60 x 75 in', '120 kg', 'very comfy', 'uploads/table 1.jpg', 'uploads/armchair.glb', '2024-06-24'),
(7, NULL, 'FurniView FurniView sofa', 'living_room', 'Available', 30000.00, 12, 'grey', 'Queen 60 x 75 in', '120 kg', 'very comfy', 'uploads/armchair.png', 'uploads/bed1.jpg', '2024-06-25');

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
  `is_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `phone_number`, `address`, `is_user`) VALUES
(1, 'Ronilo', 'Rejuso', 'ronilorejuso21@gmail.com', '$2y$10$lBM4blVF2xr.AWO00V7Hyepm9QEZMoCyC189R8B3uF.u55hcMoGnW', NULL, NULL, NULL),
(2, 'Ronilo', 'Rejuso', '', '$2y$10$xqvzpalKezi.IQTXX2AnSeyJ8YNNhAfsHF3n7P0O/T0Le4hf6y12q', NULL, NULL, NULL),
(3, 'Ronilo', 'Rejuso', 'ronie@gmail.com', '$2y$10$5nS9US5civt.UN0G750ATuWNx4UNHgw/aoQhr8PWRtV4fgrcIBYz2', NULL, NULL, NULL),
(4, 'Ronilo', 'Rejuso', 'reno@gmail.com', '$2y$10$LdZD5GviRUgtdhe7vY4v1uBKrbHYK0/zsSdb51hFYm5XSpEK1hq7S', NULL, NULL, NULL),
(5, 'Ronilo', 'Rejuso', 'renoli@gmail.com', '$2y$10$v6S.AQOwJWIhZoQ/GJjV6OM3GeO3.xZWlhPlA3hHtM52OIAyLAoCa', NULL, NULL, NULL),
(6, 'Ronilo', 'Rejuso', 'rolly@gmail.com', '$2y$10$44C.aBwILHliou.D7TUQyuQUmdeJQBXqZ0h0HFOzlppVhDSfCPnoi', NULL, NULL, NULL),
(7, 'Ronilo', 'Rejuso', 'loni@gmail.com', '$2y$10$0yISCPjVG2tECIZvnAJnxuiSJZoxEKHTsYMi6MzaI20r99FuPyRS6', NULL, NULL, NULL);

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


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
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
