-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 10 2016 г., 03:17
-- Версия сервера: 10.1.13-MariaDB
-- Версия PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `apple_store`
--

DELIMITER $$
--
-- Процедуры
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
-- Структура таблицы `callback_messages`
--

CREATE TABLE `callback_messages` (
  `message_id` int(11) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `callback_messages`
--

INSERT INTO `callback_messages` (`message_id`, `client_name`, `email`, `message`) VALUES
(4, 'Тест Макс', 'max.test.gg@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum velit metus, sollicitudin cursus diam a, vehicula ultrices tellus. Praesent ligula neque, semper eget lacus sit amet, molestie volutpat augue. Cras at nibh quam. Praesent blandit tempor ex ac semper. Aliquam dictum faucibus lorem, a faucibus augue volutpat in. Suspendisse tristique laoreet imperdiet. Suspendisse accumsan in massa sit amet finibus. Vivamus aliquam imperdiet purus, non suscipit diam iaculis non.\r\n\r\nInteger nec lacinia tellus. Integer fermentum eu nisl vel tempus. Curabitur tincidunt venenatis sollicitudin. Nulla vel maximus mauris. Praesent et tempus nibh. Suspendisse a interdum mi. Sed nec mauris eleifend diam convallis posuere. Curabitur ac libero vel diam semper tincidunt. Praesent enim sem, bibendum eget tellus ut, fringilla rutrum quam. Curabitur lacinia faucibus nulla.\r\n\r\nEtiam gravida neque eget laoreet efficitur. Vivamus pellentesque, eros eu elementum pharetra, felis sem semper nisl, vitae sodales eros orci non ex. Nam ut neque turpis. Donec et dui interdum, posuere augue id, tincidunt libero. Quisque dictum, ipsum et eleifend faucibus, elit massa ultricies elit, a imperdiet mi nisl consectetur dolor. Quisque volutpat pretium accumsan. Phasellus purus nunc, ullamcorper id ex eget, fringilla vehicula augue.\r\n\r\nPhasellus eu diam nec odio tempus condimentum id ut risus. Proin hendrerit viverra mi, nec iaculis odio porttitor vitae. Aliquam et interdum neque. Nunc sollicitudin dui sed lectus efficitur, id gravida tellus dictum. Nunc laoreet orci eget quam ullamcorper finibus. Quisque sed lorem sit amet erat lobortis iaculis ac at tortor. Nunc eu porttitor nisi.\r\n\r\nProin sagittis nibh id maximus scelerisque. Vestibulum volutpat semper finibus. Quisque eu est elit. Nulla facilisi. Morbi maximus eu mauris nec consectetur. Etiam blandit elit nibh, a fermentum lorem dictum non. Cras eget dictum est, ac congue orci. Nunc a velit quis diam euismod lobortis. Aliquam erat volutpat. Ut pellentesque nisi id mollis lacinia. Nam fringilla efficitur dictum. Aenean mattis urna eros, at posuere massa consequat et. Duis vestibulum id odio sed feugiat. Aenean posuere interdum eros rutrum rhoncus. Etiam sollicitudin quam quis sapien pulvinar efficitur. Aliquam feugiat a erat nec feugiat.');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `has_parent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `parent_id`, `has_parent`) VALUES
(1, 'Смартфоны', 0, 0),
(2, 'Чехлы', 3, 1),
(3, 'Аксессуары', 0, 0),
(4, 'Наушники', 3, 1),
(6, 'Новый смартфоны', 1, 0),
(11, 'Цветные чехлы', 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
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
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `surname`, `email`, `phone`, `notes`) VALUES
(1, 'Уолтер', 'Уайт', 'vasiliy.228@email.com', '555-54-53', 'Первый тестовый клиент. А ещё он мет варит'),
(2, 'Джесси', 'Пинкман', 'coolman@email.dot', '555-84-15', 'Наркоман, наверное');

-- --------------------------------------------------------

--
-- Структура таблицы `features`
--

CREATE TABLE `features` (
  `feature_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `features`
--

INSERT INTO `features` (`feature_id`, `name`) VALUES
(1, 'Цвет'),
(2, 'Диагональ экрана'),
(3, 'Оперативная память'),
(4, 'Физическая память'),
(6, 'Объем аккумулятора');

-- --------------------------------------------------------

--
-- Структура таблицы `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `options`
--

INSERT INTO `options` (`option_id`, `name`, `value`) VALUES
(6, 'site_name', 'Интернет-магазин "Яблочник"'),
(7, 'site_decription', 'Тут когда то будет описание. Но мне лень писать'),
(8, 'site_keywords', 'apple,цифровая электроника');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `client_id`, `user_id`, `status_id`, `date_created`) VALUES
(1, 1, 24, 1, '2016-05-09 20:52:24'),
(3, 1, 24, 1, '2016-05-10 04:02:32'),
(4, 1, 24, 1, '2016-05-10 04:02:33'),
(5, 1, 24, 1, '2016-05-10 04:02:33'),
(6, 1, 24, 1, '2016-05-10 04:02:33'),
(7, 1, 24, 1, '2016-05-10 04:02:33'),
(8, 1, 24, 1, '2016-05-10 04:02:33'),
(9, 1, 24, 1, '2016-05-10 04:02:33'),
(10, 1, 24, 1, '2016-05-10 04:02:34'),
(11, 1, 24, 1, '2016-05-10 04:02:34'),
(12, 1, 24, 1, '2016-05-10 04:02:35'),
(13, 1, 24, 1, '2016-05-10 04:02:35'),
(14, 1, 24, 1, '2016-05-10 04:02:35'),
(15, 1, 24, 1, '2016-05-10 04:02:36'),
(16, 1, 24, 1, '2016-05-10 04:02:36'),
(17, 1, 24, 1, '2016-05-10 04:02:36'),
(18, 1, 24, 1, '2016-05-10 04:02:36'),
(19, 1, 24, 1, '2016-05-10 04:02:37'),
(20, 1, 24, 1, '2016-05-10 04:02:37'),
(21, 1, 24, 1, '2016-05-10 04:02:38'),
(22, 1, 24, 1, '2016-05-10 04:02:38'),
(23, 1, 24, 1, '2016-05-10 04:02:38'),
(24, 1, 24, 1, '2016-05-10 04:02:39'),
(25, 1, 24, 1, '2016-05-10 04:02:39'),
(26, 1, 24, 1, '2016-05-10 04:02:39'),
(27, 1, 24, 1, '2016-05-10 04:02:40'),
(28, 1, 24, 1, '2016-05-10 04:02:40'),
(29, 1, 24, 1, '2016-05-10 04:02:40'),
(30, 1, 24, 1, '2016-05-10 04:02:41'),
(31, 1, 24, 1, '2016-05-10 04:02:41'),
(32, 1, 24, 1, '2016-05-10 04:02:41'),
(33, 1, 24, 1, '2016-05-10 04:02:41'),
(34, 1, 24, 1, '2016-05-10 04:02:42'),
(35, 1, 24, 1, '2016-05-10 04:02:42'),
(36, 1, 24, 1, '2016-05-10 04:02:42'),
(37, 1, 24, 1, '2016-05-10 04:02:42'),
(38, 1, 24, 1, '2016-05-10 04:02:42'),
(39, 1, 24, 1, '2016-05-10 04:02:43'),
(40, 1, 24, 1, '2016-05-10 04:02:43'),
(41, 1, 24, 1, '2016-05-10 04:02:44'),
(42, 1, 24, 1, '2016-05-10 04:02:44'),
(43, 1, 24, 1, '2016-05-10 04:02:44'),
(44, 1, 24, 1, '2016-05-10 04:02:45'),
(45, 1, 24, 1, '2016-05-10 04:02:45'),
(46, 1, 24, 1, '2016-05-10 04:02:46'),
(47, 1, 24, 1, '2016-05-10 04:02:46'),
(48, 1, 24, 1, '2016-05-10 04:02:47'),
(49, 1, 24, 1, '2016-05-10 04:02:47'),
(50, 1, 24, 1, '2016-05-10 04:02:47'),
(51, 1, 24, 1, '2016-05-10 04:02:47'),
(52, 1, 24, 1, '2016-05-10 04:02:48'),
(53, 1, 24, 1, '2016-05-10 04:02:48'),
(54, 1, 24, 1, '2016-05-10 04:02:48'),
(55, 1, 24, 1, '2016-05-10 04:02:49'),
(56, 1, 24, 1, '2016-05-10 04:02:49'),
(57, 1, 24, 1, '2016-05-10 04:02:49'),
(58, 1, 24, 1, '2016-05-10 04:02:49'),
(59, 1, 24, 1, '2016-05-10 04:02:49'),
(60, 1, 24, 1, '2016-05-10 04:02:50'),
(61, 1, 24, 1, '2016-05-10 04:02:50'),
(62, 1, 24, 1, '2016-05-10 04:02:50'),
(63, 1, 24, 1, '2016-05-10 04:02:50'),
(64, 1, 24, 1, '2016-05-10 04:02:50'),
(65, 1, 24, 1, '2016-05-10 04:02:50'),
(66, 1, 24, 1, '2016-05-10 04:02:51'),
(67, 1, 24, 1, '2016-05-10 04:02:51'),
(68, 1, 24, 1, '2016-05-10 04:02:51'),
(69, 1, 24, 1, '2016-05-10 04:02:51'),
(70, 1, 24, 1, '2016-05-10 04:02:51'),
(71, 1, 24, 1, '2016-05-10 04:02:52'),
(72, 1, 24, 1, '2016-05-10 04:02:52'),
(73, 1, 24, 1, '2016-05-10 04:02:52'),
(74, 1, 24, 1, '2016-05-10 04:02:52'),
(75, 1, 24, 1, '2016-05-10 04:02:53'),
(76, 1, 24, 1, '2016-05-10 04:02:53'),
(77, 1, 24, 1, '2016-05-10 04:02:53'),
(78, 1, 24, 1, '2016-05-10 04:02:53'),
(79, 1, 24, 1, '2016-05-10 04:02:53'),
(80, 1, 24, 1, '2016-05-10 04:02:53'),
(81, 1, 24, 1, '2016-05-10 04:02:53'),
(82, 1, 24, 1, '2016-05-10 04:02:54'),
(83, 1, 24, 1, '2016-05-10 04:02:54'),
(84, 1, 24, 1, '2016-05-10 04:02:54'),
(85, 1, 24, 1, '2016-05-10 04:02:54'),
(86, 1, 24, 1, '2016-05-10 04:02:55'),
(87, 1, 24, 1, '2016-05-10 04:02:55'),
(88, 1, 24, 1, '2016-05-10 04:02:56'),
(89, 1, 24, 1, '2016-05-10 04:02:56'),
(90, 1, 24, 1, '2016-05-10 04:02:56'),
(91, 1, 24, 1, '2016-05-10 04:02:57'),
(92, 1, 24, 1, '2016-05-10 04:02:57'),
(93, 1, 24, 1, '2016-05-10 04:02:58'),
(94, 1, 24, 1, '2016-05-10 04:02:58'),
(95, 1, 24, 1, '2016-05-10 04:02:58'),
(96, 1, 24, 1, '2016-05-10 04:02:59'),
(97, 1, 24, 1, '2016-05-10 04:02:59'),
(98, 1, 24, 1, '2016-05-10 04:02:59'),
(99, 1, 24, 1, '2016-05-10 04:03:00'),
(100, 1, 24, 1, '2016-05-10 04:03:00'),
(101, 1, 24, 1, '2016-05-10 04:03:00'),
(102, 1, 24, 1, '2016-05-10 04:03:00'),
(103, 1, 24, 1, '2016-05-10 04:03:01'),
(104, 1, 24, 1, '2016-05-10 04:03:01'),
(105, 1, 24, 1, '2016-05-10 04:03:01'),
(106, 1, 24, 1, '2016-05-10 04:03:01'),
(107, 1, 24, 1, '2016-05-10 04:03:02'),
(108, 1, 24, 1, '2016-05-10 04:03:02'),
(109, 1, 24, 1, '2016-05-10 04:03:02'),
(110, 1, 24, 1, '2016-05-10 04:03:02'),
(111, 1, 24, 1, '2016-05-10 04:03:03'),
(112, 1, 24, 1, '2016-05-10 04:03:03'),
(113, 1, 24, 1, '2016-05-10 04:03:03'),
(114, 1, 24, 1, '2016-05-10 04:03:03'),
(115, 1, 24, 1, '2016-05-10 04:03:04'),
(116, 1, 24, 1, '2016-05-10 04:03:04'),
(117, 1, 24, 1, '2016-05-10 04:03:04'),
(118, 1, 24, 1, '2016-05-10 04:03:04'),
(119, 1, 24, 1, '2016-05-10 04:03:05'),
(120, 1, 24, 1, '2016-05-10 04:03:06'),
(121, 1, 24, 1, '2016-05-10 04:03:06'),
(122, 1, 24, 1, '2016-05-10 04:03:07'),
(123, 1, 24, 1, '2016-05-10 04:03:07'),
(124, 1, 24, 1, '2016-05-10 04:03:08'),
(125, 1, 24, 1, '2016-05-10 04:03:08'),
(126, 1, 24, 1, '2016-05-10 04:03:08'),
(127, 1, 24, 1, '2016-05-10 04:03:08'),
(128, 1, 24, 1, '2016-05-10 04:03:08'),
(129, 1, 24, 1, '2016-05-10 04:03:09'),
(130, 1, 24, 1, '2016-05-10 04:03:09'),
(131, 1, 24, 1, '2016-05-10 04:03:09'),
(132, 1, 24, 1, '2016-05-10 04:03:09'),
(133, 1, 24, 1, '2016-05-10 04:03:09'),
(134, 1, 24, 1, '2016-05-10 04:03:09'),
(135, 1, 24, 1, '2016-05-10 04:03:10'),
(136, 1, 24, 1, '2016-05-10 04:03:10'),
(137, 1, 24, 1, '2016-05-10 04:03:10'),
(138, 1, 24, 1, '2016-05-10 04:03:10'),
(139, 1, 24, 1, '2016-05-10 04:03:10'),
(140, 1, 24, 1, '2016-05-10 04:03:10'),
(141, 1, 24, 1, '2016-05-10 04:03:10'),
(142, 1, 24, 1, '2016-05-10 04:03:11'),
(143, 1, 24, 1, '2016-05-10 04:03:11'),
(144, 1, 24, 1, '2016-05-10 04:03:11'),
(145, 1, 24, 1, '2016-05-10 04:03:11'),
(146, 1, 24, 1, '2016-05-10 04:03:11'),
(147, 1, 24, 1, '2016-05-10 04:03:11'),
(148, 1, 24, 1, '2016-05-10 04:03:11'),
(149, 1, 24, 1, '2016-05-10 04:03:12'),
(150, 1, 24, 1, '2016-05-10 04:03:12'),
(151, 1, 24, 1, '2016-05-10 04:03:12'),
(152, 1, 24, 1, '2016-05-10 04:03:12'),
(153, 1, 24, 1, '2016-05-10 04:03:12'),
(154, 1, 24, 1, '2016-05-10 04:03:12'),
(155, 1, 24, 1, '2016-05-10 04:03:12'),
(156, 1, 24, 1, '2016-05-10 04:03:12'),
(157, 1, 24, 1, '2016-05-10 04:03:12'),
(158, 1, 24, 1, '2016-05-10 04:03:12'),
(159, 1, 24, 1, '2016-05-10 04:03:12'),
(160, 1, 24, 1, '2016-05-10 04:03:12'),
(161, 1, 24, 1, '2016-05-10 04:03:12'),
(162, 1, 24, 1, '2016-05-10 04:03:13'),
(163, 1, 24, 1, '2016-05-10 04:03:13'),
(164, 1, 24, 1, '2016-05-10 04:03:13'),
(165, 1, 24, 1, '2016-05-10 04:03:13'),
(166, 1, 24, 1, '2016-05-10 04:03:13'),
(167, 1, 24, 1, '2016-05-10 04:03:13'),
(168, 1, 24, 1, '2016-05-10 04:03:13'),
(169, 1, 24, 1, '2016-05-10 04:03:13'),
(170, 1, 24, 1, '2016-05-10 04:03:13'),
(171, 1, 24, 1, '2016-05-10 04:03:14'),
(172, 1, 24, 1, '2016-05-10 04:03:14'),
(173, 1, 24, 1, '2016-05-10 04:03:14'),
(174, 1, 24, 1, '2016-05-10 04:03:14'),
(175, 1, 24, 1, '2016-05-10 04:03:14'),
(176, 1, 24, 1, '2016-05-10 04:03:15'),
(177, 1, 24, 1, '2016-05-10 04:03:15'),
(178, 1, 24, 1, '2016-05-10 04:03:15'),
(179, 1, 24, 1, '2016-05-10 04:03:15'),
(180, 1, 24, 1, '2016-05-10 04:03:15'),
(181, 1, 24, 1, '2016-05-10 04:03:15'),
(182, 1, 24, 1, '2016-05-10 04:03:15'),
(183, 1, 24, 1, '2016-05-10 04:03:16'),
(184, 1, 24, 1, '2016-05-10 04:03:16'),
(185, 1, 24, 1, '2016-05-10 04:03:17'),
(186, 1, 24, 1, '2016-05-10 04:03:17'),
(187, 1, 24, 1, '2016-05-10 04:03:18'),
(188, 1, 24, 1, '2016-05-10 04:03:18'),
(189, 1, 24, 1, '2016-05-10 04:03:18'),
(190, 1, 24, 1, '2016-05-10 04:03:18'),
(191, 1, 24, 1, '2016-05-10 04:03:18'),
(192, 1, 24, 1, '2016-05-10 04:03:19'),
(193, 1, 24, 1, '2016-05-10 04:03:19'),
(194, 1, 24, 1, '2016-05-10 04:03:21'),
(195, 1, 24, 1, '2016-05-10 04:03:21'),
(196, 1, 24, 1, '2016-05-10 04:03:21'),
(197, 1, 24, 1, '2016-05-10 04:03:21'),
(198, 1, 24, 1, '2016-05-10 04:03:22'),
(199, 1, 24, 1, '2016-05-10 04:03:22'),
(200, 1, 24, 1, '2016-05-10 04:03:22'),
(201, 1, 24, 1, '2016-05-10 04:03:22'),
(202, 1, 24, 1, '2016-05-10 04:03:22');

-- --------------------------------------------------------

--
-- Структура таблицы `order_content`
--

CREATE TABLE `order_content` (
  `position_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_content`
--

INSERT INTO `order_content` (`position_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 6, 3),
(3, 1, 6, 2),
(4, 2, 6, 2),
(5, 3, 6, 2),
(6, 4, 6, 2),
(7, 5, 6, 2),
(8, 6, 6, 2),
(9, 7, 6, 2),
(10, 8, 6, 2),
(11, 9, 6, 2),
(12, 10, 6, 2),
(13, 11, 6, 2),
(14, 12, 6, 2),
(15, 13, 6, 2),
(16, 14, 6, 2),
(17, 15, 6, 2),
(18, 16, 6, 2),
(19, 17, 6, 2),
(20, 18, 6, 2),
(21, 19, 6, 2),
(22, 20, 6, 2),
(23, 21, 6, 2),
(24, 22, 6, 2),
(25, 23, 6, 2),
(26, 24, 6, 2),
(27, 25, 6, 2),
(28, 26, 6, 2),
(29, 27, 6, 2),
(30, 28, 6, 2),
(31, 29, 6, 2),
(32, 30, 6, 2),
(33, 31, 6, 2),
(34, 32, 6, 2),
(35, 33, 6, 2),
(36, 34, 6, 2),
(37, 35, 6, 2),
(38, 36, 6, 2),
(39, 37, 6, 2),
(40, 38, 6, 2),
(41, 39, 6, 2),
(42, 40, 6, 2),
(43, 41, 6, 2),
(44, 42, 6, 2),
(45, 43, 6, 2),
(46, 44, 6, 2),
(47, 45, 6, 2),
(48, 46, 6, 2),
(49, 47, 6, 2),
(50, 48, 6, 2),
(51, 49, 6, 2),
(52, 50, 6, 2),
(53, 51, 6, 2),
(54, 52, 6, 2),
(55, 53, 6, 2),
(56, 54, 6, 2),
(57, 55, 6, 2),
(58, 56, 6, 2),
(59, 57, 6, 2),
(60, 58, 6, 2),
(61, 59, 6, 2),
(62, 60, 6, 2),
(63, 61, 6, 2),
(64, 62, 6, 2),
(65, 63, 6, 2),
(66, 64, 6, 2),
(67, 65, 6, 2),
(68, 66, 6, 2),
(69, 67, 6, 2),
(70, 68, 6, 2),
(71, 69, 6, 2),
(72, 70, 6, 2),
(73, 71, 6, 2),
(74, 72, 6, 2),
(75, 73, 6, 2),
(76, 74, 6, 2),
(77, 75, 6, 2),
(78, 76, 6, 2),
(79, 77, 6, 2),
(80, 78, 6, 2),
(81, 79, 6, 2),
(82, 80, 6, 2),
(83, 81, 6, 2),
(84, 82, 6, 2),
(85, 83, 6, 2),
(86, 84, 6, 2),
(87, 85, 6, 2),
(88, 86, 6, 2),
(89, 87, 6, 2),
(90, 88, 6, 2),
(91, 89, 6, 2),
(92, 90, 6, 2),
(93, 91, 6, 2),
(94, 92, 6, 2),
(95, 93, 6, 2),
(96, 94, 6, 2),
(97, 95, 6, 2),
(98, 96, 6, 2),
(99, 97, 6, 2),
(100, 98, 6, 2),
(101, 99, 6, 2),
(102, 100, 6, 2),
(103, 101, 6, 2),
(104, 102, 6, 2),
(105, 103, 6, 2),
(106, 104, 6, 2),
(107, 105, 6, 2),
(108, 106, 6, 2),
(109, 107, 6, 2),
(110, 108, 6, 2),
(111, 109, 6, 2),
(112, 110, 6, 2),
(113, 111, 6, 2),
(114, 112, 6, 2),
(115, 113, 6, 2),
(116, 114, 6, 2),
(117, 115, 6, 2),
(118, 116, 6, 2),
(119, 117, 6, 2),
(120, 118, 6, 2),
(121, 119, 6, 2),
(122, 120, 6, 2),
(123, 121, 6, 2),
(124, 122, 6, 2),
(125, 123, 6, 2),
(126, 124, 6, 2),
(127, 125, 6, 2),
(128, 126, 6, 2),
(129, 127, 6, 2),
(130, 128, 6, 2),
(131, 129, 6, 2),
(132, 130, 6, 2),
(133, 131, 6, 2),
(134, 132, 6, 2),
(135, 133, 6, 2),
(136, 134, 6, 2),
(137, 135, 6, 2),
(138, 136, 6, 2),
(139, 137, 6, 2),
(140, 138, 6, 2),
(141, 139, 6, 2),
(142, 140, 6, 2),
(143, 141, 6, 2),
(144, 142, 6, 2),
(145, 143, 6, 2),
(146, 144, 6, 2),
(147, 145, 6, 2),
(148, 146, 6, 2),
(149, 147, 6, 2),
(150, 148, 6, 2),
(151, 149, 6, 2),
(152, 150, 6, 2),
(153, 151, 6, 2),
(154, 152, 6, 2),
(155, 153, 6, 2),
(156, 154, 6, 2),
(157, 155, 6, 2),
(158, 156, 6, 2),
(159, 157, 6, 2),
(160, 158, 6, 2),
(161, 159, 6, 2),
(162, 160, 6, 2),
(163, 161, 6, 2),
(164, 162, 6, 2),
(165, 163, 6, 2),
(166, 164, 6, 2),
(167, 165, 6, 2),
(168, 166, 6, 2),
(169, 167, 6, 2),
(170, 168, 6, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `order_status`
--

CREATE TABLE `order_status` (
  `status_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_status`
--

INSERT INTO `order_status` (`status_id`, `name`) VALUES
(1, 'Не обработан'),
(2, 'Обрабатывается'),
(3, 'Обработан');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
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
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `provider_id`, `caption`, `price`, `image`, `short_description`, `long_description`, `is_published`) VALUES
(6, 1, 'iPhone 5c', 6669, 'http://www.citrus.ua/upload/new_iblock/336/ad01bb85172b517d1d4be43ddf426373.jpg', 'Каждая инновация в iPhone должна отвечать одному условию — улучшить впечатление от его использования', 'Каждая инновация в iPhone должна отвечать одному условию — улучшить впечатление от его использования. Поэтому цвета iPhone 5c инженеры компании Apple продумывали так же тщательно, как и всё остальное. Даже палитра Главного экрана и обоев теперь гармонично сочетается с корпусом. Результат: iPhone стал ещё приятнее и увлекательнее. ', 1),
(7, 3, 'Apple iPhone SE 16Gb', 8999, 'http://www.citrus.ua/upload/new_iblock/6a6/a031bfaefa9bd61180b3010692097a70.jpg', 'Компания Apple представила iPhone SE — самый мощный 4‑дюймовый смартфон в истории. Чтобы создать его', 'Компания Apple представила iPhone SE — самый мощный 4‑дюймовый смартфон в истории. Чтобы создать его, Apple взяли за основу полюбившийся дизайн и полностью поменяли содержание. Установили тот же передовой процессор A9, что и на iPhone 6s, и камеру 12 Мп для съёмки невероятных фотографий и видео 4K. А благодаря Live Photos любой ваш снимок буквально оживёт. Результат? Небольшой iPhone с огромными возможностями.', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_category`
--

CREATE TABLE `product_category` (
  `record_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_category`
--

INSERT INTO `product_category` (`record_id`, `product_id`, `category_id`) VALUES
(22, 6, 2),
(23, 6, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `product_feature`
--

CREATE TABLE `product_feature` (
  `record_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_feature`
--

INSERT INTO `product_feature` (`record_id`, `product_id`, `feature_id`, `value`) VALUES
(1, 6, 2, '5 inch'),
(2, 6, 1, 'black'),
(3, 6, 4, '64 GB');

-- --------------------------------------------------------

--
-- Структура таблицы `provider`
--

CREATE TABLE `provider` (
  `provider_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `provider`
--

INSERT INTO `provider` (`provider_id`, `name`, `email`, `phone`) VALUES
(1, 'Не определен', '', ''),
(6, 'Вася Пупкин', 'ggwp@easy.win', '555 33 55');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
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
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `login`, `password`, `name`, `email`, `phone`) VALUES
(0, 3, 'Не назначен', '0000', 'Не назначен', '', ''),
(1, 1, 'Curious', '2284783635c32da2a5bd96f1bca0c82f', 'Максим', 'maxim.pereginka@outlook.com', '+380637218804'),
(23, 1, 'Shoshka', 'ae77900a23c50dd0a3bab3611307d04c', '', '', ''),
(24, 3, 'user24', '052883054635aeadd004651610465e30', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `user_type`
--

CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_type`
--

INSERT INTO `user_type` (`type_id`, `name`) VALUES
(1, 'Администратор'),
(2, 'Старший менеджер'),
(3, 'Менеджер');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `callback_messages`
--
ALTER TABLE `callback_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_id` (`category_id`),
  ADD UNIQUE KEY `category_id_2` (`category_id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Индексы таблицы `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Индексы таблицы `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Индексы таблицы `order_content`
--
ALTER TABLE `order_content`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `order_id` (`order_id`,`product_id`);

--
-- Индексы таблицы `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Индексы таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `product_id` (`product_id`,`category_id`);

--
-- Индексы таблицы `product_feature`
--
ALTER TABLE `product_feature`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `product_id` (`product_id`,`feature_id`);

--
-- Индексы таблицы `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`provider_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_type` (`user_type`);

--
-- Индексы таблицы `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `callback_messages`
--
ALTER TABLE `callback_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;
--
-- AUTO_INCREMENT для таблицы `order_content`
--
ALTER TABLE `order_content`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
--
-- AUTO_INCREMENT для таблицы `order_status`
--
ALTER TABLE `order_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `product_category`
--
ALTER TABLE `product_category`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `product_feature`
--
ALTER TABLE `product_feature`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `provider`
--
ALTER TABLE `provider`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `user_type`
--
ALTER TABLE `user_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
