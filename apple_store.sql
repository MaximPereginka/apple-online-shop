-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2016 at 10:45 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apple_store`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_product` (IN `pr_id` INT)  SQL SECURITY INVOKER
BEGIN 
	DELETE FROM product_feature WHERE product_id = pr_id;
	DELETE FROM product_category WHERE product_id = pr_id;
	DELETE FROM products WHERE product_id = pr_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `callback_messages`
--

CREATE TABLE `callback_messages` (
  `message_id` int(11) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `callback_messages`
--

INSERT INTO `callback_messages` (`message_id`, `client_name`, `email`, `message`) VALUES
(4, 'Тест Макс', 'max.test.gg@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum velit metus, sollicitudin cursus diam a, vehicula ultrices tellus. Praesent ligula neque, semper eget lacus sit amet, molestie volutpat augue. Cras at nibh quam. Praesent blandit tempor ex ac semper. Aliquam dictum faucibus lorem, a faucibus augue volutpat in. Suspendisse tristique laoreet imperdiet. Suspendisse accumsan in massa sit amet finibus. Vivamus aliquam imperdiet purus, non suscipit diam iaculis non.\r\n\r\nInteger nec lacinia tellus. Integer fermentum eu nisl vel tempus. Curabitur tincidunt venenatis sollicitudin. Nulla vel maximus mauris. Praesent et tempus nibh. Suspendisse a interdum mi. Sed nec mauris eleifend diam convallis posuere. Curabitur ac libero vel diam semper tincidunt. Praesent enim sem, bibendum eget tellus ut, fringilla rutrum quam. Curabitur lacinia faucibus nulla.\r\n\r\nEtiam gravida neque eget laoreet efficitur. Vivamus pellentesque, eros eu elementum pharetra, felis sem semper nisl, vitae sodales eros orci non ex. Nam ut neque turpis. Donec et dui interdum, posuere augue id, tincidunt libero. Quisque dictum, ipsum et eleifend faucibus, elit massa ultricies elit, a imperdiet mi nisl consectetur dolor. Quisque volutpat pretium accumsan. Phasellus purus nunc, ullamcorper id ex eget, fringilla vehicula augue.\r\n\r\nPhasellus eu diam nec odio tempus condimentum id ut risus. Proin hendrerit viverra mi, nec iaculis odio porttitor vitae. Aliquam et interdum neque. Nunc sollicitudin dui sed lectus efficitur, id gravida tellus dictum. Nunc laoreet orci eget quam ullamcorper finibus. Quisque sed lorem sit amet erat lobortis iaculis ac at tortor. Nunc eu porttitor nisi.\r\n\r\nProin sagittis nibh id maximus scelerisque. Vestibulum volutpat semper finibus. Quisque eu est elit. Nulla facilisi. Morbi maximus eu mauris nec consectetur. Etiam blandit elit nibh, a fermentum lorem dictum non. Cras eget dictum est, ac congue orci. Nunc a velit quis diam euismod lobortis. Aliquam erat volutpat. Ut pellentesque nisi id mollis lacinia. Nam fringilla efficitur dictum. Aenean mattis urna eros, at posuere massa consequat et. Duis vestibulum id odio sed feugiat. Aenean posuere interdum eros rutrum rhoncus. Etiam sollicitudin quam quis sapien pulvinar efficitur. Aliquam feugiat a erat nec feugiat.');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `has_parent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `parent_id`, `has_parent`) VALUES
(1, 'Смартфоны', 0, 0),
(2, 'Чехлы', 3, 1),
(3, 'Аксессуары', 0, 0),
(4, 'Наушники', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `notes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `surname`, `email`, `phone`, `notes`) VALUES
(1, 'Уолтер', 'Уайт', 'vasiliy.228@email.com', '555-54-53', 'Первый тестовый клиент. А ещё он мет варит'),
(2, 'Джесси', 'Пинкман', 'coolman@email.dot', '555-84-15', 'Наркоман, наверное');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feature_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feature_id`, `name`) VALUES
(1, 'Цвет'),
(2, 'Диагональ экрана'),
(3, 'Оперативная память'),
(4, 'Физическая память');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `client_id`, `user_id`) VALUES
(1, 1, 2),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_content`
--

CREATE TABLE `order_content` (
  `position_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantiny` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_content`
--

INSERT INTO `order_content` (`position_id`, `order_id`, `product_id`, `quantiny`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `caption` varchar(30) NOT NULL,
  `price` int(7) NOT NULL,
  `image` varchar(200) NOT NULL,
  `short_description` varchar(200) NOT NULL,
  `long_description` longtext NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `provider_id`, `caption`, `price`, `image`, `short_description`, `long_description`, `is_published`) VALUES
(6, 2, 'iPhone 5c', 6669, 'http://www.citrus.ua/upload/new_iblock/336/ad01bb85172b517d1d4be43ddf426373.jpg', 'Каждая инновация в iPhone должна отвечать одному условию — улучшить впечатление от его использования', 'Каждая инновация в iPhone должна отвечать одному условию — улучшить впечатление от его использования. Поэтому цвета iPhone 5c инженеры компании Apple продумывали так же тщательно, как и всё остальное. Даже палитра Главного экрана и обоев теперь гармонично сочетается с корпусом. Результат: iPhone стал ещё приятнее и увлекательнее. ', 1),
(7, 3, 'Apple iPhone SE 16Gb', 8999, 'http://www.citrus.ua/upload/new_iblock/6a6/a031bfaefa9bd61180b3010692097a70.jpg', 'Компания Apple представила iPhone SE — самый мощный 4‑дюймовый смартфон в истории. Чтобы создать его', 'Компания Apple представила iPhone SE — самый мощный 4‑дюймовый смартфон в истории. Чтобы создать его, Apple взяли за основу полюбившийся дизайн и полностью поменяли содержание. Установили тот же передовой процессор A9, что и на iPhone 6s, и камеру 12 Мп для съёмки невероятных фотографий и видео 4K. А благодаря Live Photos любой ваш снимок буквально оживёт. Результат? Небольшой iPhone с огромными возможностями.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `record_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`record_id`, `product_id`, `category_id`) VALUES
(22, 6, 2),
(23, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_feature`
--

CREATE TABLE `product_feature` (
  `record_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `provider_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`provider_id`, `name`, `email`, `phone`) VALUES
(1, 'Не определен', '', ''),
(2, 'Поставщик 1', '', ''),
(3, 'Поставщик 2', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `login` varchar(15) NOT NULL,
  `password` varchar(41) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `login`, `password`, `name`, `email`, `phone`) VALUES
(1, 1, 'Curious', 'ae77900a23c50dd0a3bab3611307d04c', 'Максим', 'maxim.pereginka@outlook.com', '+380637218804');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`type_id`, `name`) VALUES
(1, 'Администратор'),
(2, 'Старший менеджер'),
(3, 'Менеджер');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `callback_messages`
--
ALTER TABLE `callback_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_id` (`category_id`),
  ADD UNIQUE KEY `category_id_2` (`category_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_content`
--
ALTER TABLE `order_content`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `order_id` (`order_id`,`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `product_id` (`product_id`,`category_id`);

--
-- Indexes for table `product_feature`
--
ALTER TABLE `product_feature`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `product_id` (`product_id`,`feature_id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_type` (`user_type`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `callback_messages`
--
ALTER TABLE `callback_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `order_content`
--
ALTER TABLE `order_content`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `product_feature`
--
ALTER TABLE `product_feature`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
