-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 24 2020 г., 23:27
-- Версия сервера: 8.0.19
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bauinvest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__accountingentities`
--

CREATE TABLE `bauinvest__accountingentities` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__accountingentities`
--

INSERT INTO `bauinvest__accountingentities` (`id`, `title`, `_updated`, `_deleted`) VALUES
(1, 'Бауинвест', '2020-10-14 17:30:24', 0),
(2, 'Он-Строй', '2020-10-14 17:30:44', 0),
(3, 'Баупласт', '2020-10-14 17:30:53', 0),
(4, 'Бауинвест-юг', '2020-10-14 17:31:02', 0),
(5, 'Бауинвест-восточный', '2020-10-14 17:31:10', 0),
(6, 'РТК', '2020-10-14 17:31:20', 0),
(7, 'ИП различные', '2020-10-14 17:31:28', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__agencies`
--

CREATE TABLE `bauinvest__agencies` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__agencies`
--

INSERT INTO `bauinvest__agencies` (`id`, `title`, `params`, `_updated`, `_deleted`) VALUES
(1, 'ООО \"Чайка\"', '{\"comName\":\"\\u0427\\u0430\\u0435\\u0447\\u043a\\u0430\",\"inn\":123123142341234,\"paymentProcent\":10}', '2020-10-15 12:16:44', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__autos`
--

CREATE TABLE `bauinvest__autos` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bauinvest__autos`
--

INSERT INTO `bauinvest__autos` (`id`, `title`, `params`, `_updated`, `_deleted`) VALUES
(1, 'Мазда1', '{\"label\":\"\",\"color\":0}', '2020-10-13 20:46:27', 0),
(2, 'тест', '{\"label\":\"\",\"color\":0}', '2020-10-13 20:51:18', 0),
(3, 'Тест 2', '{\"label\":\"\",\"color\":0}', '2020-10-13 20:51:42', 0),
(4, '1111111111111111', '{\"label\":\"\",\"color\":0}', '2020-10-14 10:38:11', 1),
(5, 'семерка', '{\"label\":\"\",\"color\":0}', '2020-10-14 11:31:09', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__buildings`
--

CREATE TABLE `bauinvest__buildings` (
  `id` int NOT NULL,
  `complex` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `liter` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `entrance` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bauinvest__buildings`
--

INSERT INTO `bauinvest__buildings` (`id`, `complex`, `liter`, `entrance`, `params`, `_updated`, `_deleted`) VALUES
(1, 'Почта', '18', '1', '{\"levels\":22,\"flatsOnLvl\":10}', '2020-10-18 18:16:03', 0),
(2, 'Почта', '18', '2', '{\"levels\":22,\"flatsOnLvl\":9}', '2020-10-18 23:26:27', 0),
(3, 'Почта', '17', '1', '{\"levels\":16,\"flatsOnLvl\":6}', '2020-10-18 23:56:41', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__calculationforms`
--

CREATE TABLE `bauinvest__calculationforms` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__calculationforms`
--

INSERT INTO `bauinvest__calculationforms` (`id`, `title`, `_updated`, `_deleted`) VALUES
(1, '100% расчет собственными средствами', '2020-10-15 22:09:17', 0),
(2, 'Ипотека', '2020-10-15 22:09:38', 0),
(3, 'Ипотека военная', '2020-10-15 22:09:49', 0),
(4, 'Ипотека с МК ', '2020-10-15 22:09:58', 0),
(5, 'Маткапитал и собственные средства', '2020-10-15 22:10:09', 0),
(6, 'Рассрочка', '2020-10-15 22:10:20', 0),
(7, 'Субсидии', '2020-10-15 22:10:27', 0),
(8, 'Сертификат', '2020-10-15 22:10:36', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__contracts`
--

CREATE TABLE `bauinvest__contracts` (
  `id` int NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bauinvest__contracts`
--

INSERT INTO `bauinvest__contracts` (`id`, `params`, `_updated`, `_deleted`) VALUES
(1, '{\"accountingEntity\":\"3\",\"contractNumber\":312312,\"contractDate\":\"2020-10-01\",\"creationDate\":\"\",\"registrationDate\":\"2020-10-22\",\"saleType\":\"1\",\"contractTypes\":\"4\",\"contractStatus\":\"2\",\"contractPrice\":30000000,\"rosFinMon\":0,\"NDS\":0,\"agency\":\"1\",\"realtorReward\":0,\"promotion\":\"1\",\"calculationForm\":\"1\",\"mortgageBank\":\"0\",\"paymentSchedule\":\"1234\",\"saleObject\":\"1\",\"facingType\":\"1\",\"stageStatus\":1}', '2020-10-17 22:40:05', 0),
(2, '{\"accountingEntity\":\"1\",\"contractNumber\":111,\"contractDate\":\"2020-10-17\",\"creationDate\":\"\",\"registrationDate\":\"2020-10-28\",\"saleType\":\"1\",\"contractTypes\":\"1\",\"contractStatus\":\"2\",\"contractPrice\":123,\"rosFinMon\":0,\"NDS\":0,\"agency\":\"1\",\"realtorReward\":123,\"promotion\":\"12\",\"calculationForm\":\"7\",\"mortgageBank\":\"1\",\"paymentSchedule\":\"1122\",\"saleObject\":\"1\",\"facingType\":\"2\",\"stageStatus\":2}', '2020-10-18 16:04:03', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__contractstatuses`
--

CREATE TABLE `bauinvest__contractstatuses` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__contractstatuses`
--

INSERT INTO `bauinvest__contractstatuses` (`id`, `title`, `_updated`, `_deleted`) VALUES
(1, 'Ходатайство', '2020-10-15 07:18:40', 0),
(2, 'Зарегистрирован', '2020-10-15 07:19:12', 0),
(3, 'Расторгнут', '2020-10-15 07:19:19', 0),
(4, 'Подписан', '2020-10-15 07:19:27', 0),
(5, 'Оплачен', '2020-10-15 07:19:35', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__contracttypes`
--

CREATE TABLE `bauinvest__contracttypes` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__contracttypes`
--

INSERT INTO `bauinvest__contracttypes` (`id`, `title`, `_updated`, `_deleted`) VALUES
(1, 'Реализация недвижимости', '2020-10-14 17:14:40', 0),
(2, 'Аренда помещений (недвижимость)', '2020-10-14 17:14:48', 0),
(3, 'Юридические услуги', '2020-10-14 17:14:54', 0),
(4, 'Бронирование (недвижимость)', '2020-10-14 17:15:02', 0),
(5, 'Долевое участие (недвижимость)', '2020-10-14 17:15:10', 0),
(6, 'Уступка права требования (недвижимость)', '2020-10-14 17:15:21', 0),
(7, 'Купля-продажа (недвижимость)', '2020-10-14 17:15:29', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__facingtypes`
--

CREATE TABLE `bauinvest__facingtypes` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__facingtypes`
--

INSERT INTO `bauinvest__facingtypes` (`id`, `title`, `_updated`, `_deleted`) VALUES
(1, 'Предчистовая', NULL, 0),
(2, 'Стандартный ремонт', NULL, 0),
(3, 'Улучшенный ремонт', NULL, 0),
(4, 'Черновая отделка', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__flats`
--

CREATE TABLE `bauinvest__flats` (
  `id` int NOT NULL,
  `id_b` text NOT NULL,
  `x` int NOT NULL,
  `y` int NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bauinvest__flats`
--

INSERT INTO `bauinvest__flats` (`id`, `id_b`, `x`, `y`, `params`, `_updated`, `_deleted`) VALUES
(1, '1', 1, 22, '{\"number\":122,\"rooms\":\"1\",\"spaceFull\":44,\"spaceWithoutBalc\":36,\"sqmtPrice\":52000,\"totalPrice\":2700000,\"flatStatus\":\"4\",\"img\":\"1_16-22_1_41,0.png\"}', '2020-10-18 20:22:44', 0),
(2, '1', 2, 21, '{\"number\":143,\"rooms\":\"2\",\"spaceFull\":44,\"spaceWithoutBalc\":36,\"sqmtPrice\":52000,\"totalPrice\":2700000,\"flatStatus\":\"2\",\"img\":\"1_16-22_2_53,3.png\"}', '2020-10-18 23:21:42', 0),
(3, '2', 1, 1, '{\"number\":1,\"rooms\":\"3\",\"spaceFull\":44,\"spaceWithoutBalc\":36,\"sqmtPrice\":52000,\"totalPrice\":2700000,\"flatStatus\":\"1\",\"img\":\"1_16-22_3_82.png\"}', '2020-10-18 23:54:25', 0),
(4, '3', 6, 16, '{\"number\":123,\"rooms\":\"1\",\"spaceFull\":44,\"spaceWithoutBalc\":36,\"sqmtPrice\":52000,\"totalPrice\":2700000,\"flatStatus\":\"2\",\"img\":\"1_16-22_1_37,5.png\"}', '2020-10-18 23:57:31', 0),
(83, '2', 1, 11, '{\"number\":122,\"rooms\":\"0\",\"spaceFull\":42,\"spaceWithoutBalc\":33,\"sqmtPrice\":52000,\"totalPrice\":2700000,\"flatStatus\":\"2\",\"img\":\"1_16-22_1_24,1.png\"}', '2020-10-22 20:29:12', 0),
(104, '3', 1, 16, '{\"number\":53,\"rooms\":\"0\",\"spaceFull\":25,\"spaceWithoutBalc\":22,\"sqmtPrice\":47000,\"totalPrice\":1750000,\"flatStatus\":\"1\",\"img\":\"1_16-22_1_24,1.png\"}', '2020-10-24 19:50:33', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__log`
--

CREATE TABLE `bauinvest__log` (
  `id` int NOT NULL,
  `e_type` varchar(255) NOT NULL,
  `action` varchar(500) NOT NULL,
  `message` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `params` text,
  `_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bauinvest__log`
--

INSERT INTO `bauinvest__log` (`id`, `e_type`, `action`, `message`, `user_id`, `params`, `_updated`, `_deleted`) VALUES
(1, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-11 19:34:41', 0),
(2, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-11 19:34:49', 0),
(3, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-11 19:38:35', 0),
(4, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-11 19:38:45', 0),
(5, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-11 19:38:57', 0),
(6, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 09:23:22', 0),
(7, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:04:56', 0),
(8, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:05:47', 0),
(9, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:06:17', 0),
(10, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:06:27', 0),
(11, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:08:11', 0),
(12, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:08:37', 0),
(13, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:09:20', 0),
(14, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:10:35', 0),
(15, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:11:04', 0),
(16, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-12 10:12:06', 0),
(17, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:35:19', 0),
(18, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:44:41', 0),
(19, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:45:08', 0),
(20, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:45:19', 0),
(21, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:47:45', 0),
(22, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:48:02', 0),
(23, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:48:34', 0),
(24, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:48:36', 0),
(25, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:48:45', 0),
(26, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-13 05:48:53', 0),
(27, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:49:52', 0),
(28, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:50:30', 0),
(29, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:50:56', 0),
(30, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:51:06', 0),
(31, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:51:45', 0),
(32, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:52:07', 0),
(33, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:59:07', 0),
(34, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 05:59:31', 0),
(35, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 06:00:06', 0),
(36, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 06:02:13', 0),
(37, 'SECURITY', 'Logout', 'successful', 1, NULL, '2020-10-13 06:02:17', 0),
(38, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 06:02:24', 0),
(39, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-13 06:06:37', 0),
(40, 'SECURITY', 'Logout', 'successful', 0, NULL, '2020-10-14 14:16:13', 0),
(41, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-17 17:44:26', 0),
(42, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-17 18:27:13', 0),
(43, 'SECURITY', 'Auth', 'successful', 2, NULL, '2020-10-17 18:57:38', 0),
(44, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-17 19:33:58', 0),
(45, 'SECURITY', 'Auth', 'successful', 2, NULL, '2020-10-17 19:37:47', 0),
(46, 'SECURITY', 'Auth', 'successful', 2, NULL, '2020-10-17 19:37:59', 0),
(47, 'SECURITY', 'Auth', 'successful', 2, NULL, '2020-10-17 19:38:30', 0),
(48, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-17 19:38:57', 0),
(49, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-17 20:04:18', 0),
(50, 'SECURITY', 'Logout', 'successful', 1, NULL, '2020-10-17 20:07:31', 0),
(51, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:07:41', 0),
(52, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:27:48', 0),
(53, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:29:01', 0),
(54, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:33:57', 0),
(55, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:34:30', 0),
(56, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:34:52', 0),
(57, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:35:01', 0),
(58, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:35:10', 0),
(59, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:35:26', 0),
(60, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:36:37', 0),
(61, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 20:36:59', 0),
(62, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-17 22:20:44', 0),
(63, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 22:23:31', 0),
(64, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-17 22:32:26', 0),
(65, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-17 22:37:14', 0),
(66, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-17 22:48:33', 0),
(67, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-18 12:00:45', 0),
(68, 'SECURITY', 'Logout', 'successful', 1, NULL, '2020-10-18 13:39:47', 0),
(69, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-18 13:40:05', 0),
(70, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 06:22:40', 0),
(71, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-19 10:09:52', 0),
(72, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 10:10:01', 0),
(73, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-19 10:53:39', 0),
(74, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 10:53:49', 0),
(75, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 12:41:15', 0),
(76, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 12:41:49', 0),
(77, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 12:42:51', 0),
(78, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 14:11:39', 0),
(79, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 14:21:57', 0),
(80, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-19 14:22:06', 0),
(81, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-20 17:08:07', 0),
(82, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-21 18:02:02', 0),
(83, 'SECURITY', 'Auth', 'successful', 2, NULL, '2020-10-22 16:17:51', 0),
(84, 'SECURITY', 'Auth', 'successful', 2, NULL, '2020-10-22 16:18:14', 0),
(85, 'SECURITY', 'Auth', 'unsuccessful: wrong login or password', 0, NULL, '2020-10-22 17:08:49', 0),
(86, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-22 17:09:16', 0),
(87, 'SECURITY', 'Auth', 'successful', 1, NULL, '2020-10-22 17:24:01', 0),
(88, 'SECURITY', 'Auth', 'successful', 7, NULL, '2020-10-24 10:31:23', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__mortgagebanks`
--

CREATE TABLE `bauinvest__mortgagebanks` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__mortgagebanks`
--

INSERT INTO `bauinvest__mortgagebanks` (`id`, `title`, `params`, `_updated`, `_deleted`) VALUES
(1, 'Жилфинанс банк', '{\"inn\":0,\"isActive\":\"\\u0414\\u0430\"}', '2020-10-15 13:30:35', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__objectstatuses`
--

CREATE TABLE `bauinvest__objectstatuses` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__objectstatuses`
--

INSERT INTO `bauinvest__objectstatuses` (`id`, `title`, `_updated`, `_deleted`) VALUES
(1, 'Свободно к продаже', '2020-10-19 15:13:08', 0),
(2, 'Бронь', '2020-10-19 15:13:13', 0),
(3, 'VIP бронь без срока', '2020-10-19 15:13:15', 0),
(4, 'Продана', '2020-10-20 01:03:31', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__partners`
--

CREATE TABLE `bauinvest__partners` (
  `id` int NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__partners`
--

INSERT INTO `bauinvest__partners` (`id`, `params`, `_updated`, `_deleted`) VALUES
(6, '{\"f\":\"\\u041f\\u0435\\u0442\\u0440\\u043e\\u0432\\u0430\",\"i\":\"\\u0410\\u043b\\u043b\\u0430\",\"o\":\"\\u0410\\u043d\\u0430\\u0442\\u043e\\u043b\\u044c\\u0435\\u0432\\u043d\\u0430\",\"phoneNumber\":\"8-918-123-45-67\",\"email\":\"petya@mail.ru\",\"connectionToContract\":\"\\u041a\\u043e\\u043d\\u0442\\u0440\\u0430\\u043a\\u0442 \\u2116123\"}', '2020-10-14 13:34:39', 0),
(7, '{\"f\":\"1\",\"i\":\"1\",\"o\":\"1\",\"phoneNumber\":\"1\",\"email\":\"1\",\"connectionToContract\":\"1\"}', '2020-10-15 06:50:06', 1),
(8, '{\"f\":\"111\",\"i\":\"1\",\"o\":\"1\",\"phoneNumber\":\"1\",\"email\":\"1\",\"connectionToContract\":\"1\"}', '2020-10-15 23:20:27', 1),
(9, '{\"f\":\"1\",\"i\":\"2\",\"o\":\"3\",\"phoneNumber\":\"4\",\"email\":\"5\",\"connectionToContract\":\"6\"}', '2020-10-15 23:22:09', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__promotions`
--

CREATE TABLE `bauinvest__promotions` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__promotions`
--

INSERT INTO `bauinvest__promotions` (`id`, `title`, `params`, `_updated`, `_deleted`) VALUES
(1, 'НЕТ (продажа без скидки и изменения сроков оплаты)', '{\"startDate\":\"2020-10-01\",\"finishDate\":\"2020-10-31\",\"discountAmount\":\"10\",\"isActive\":\"\\u0414\\u0430\"}', '2020-10-15 07:29:35', 0),
(2, 'Военная ипотека', '{\"startDate\":\"2020-10-15 11-07-48\",\"finishDate\":\"2020-10-15 11-07-48\",\"dicountAmount\":\"\",\"isActive\":\"\\u0414\\u0430\"}', '2020-10-15 07:29:43', 0),
(3, 'Квартира для студента', '', '2020-10-15 07:29:51', 0),
(4, 'Квартира от партнера', '', '2020-10-15 07:30:00', 0),
(5, 'Квартира для пенсионера', '', '2020-10-15 07:30:24', 0),
(6, 'Квартира для сотрудника', '', '2020-10-15 07:30:31', 0),
(7, 'Квартира в рассрочку', '', '2020-10-15 07:30:47', 0),
(8, 'Индивидуальные условия', '', '2020-10-15 07:30:55', 0),
(9, 'Ярмарки', '', '2020-10-15 07:31:09', 0),
(10, 'Повторное приобретение', '', '2020-10-15 07:31:16', 0),
(11, 'Старт продаж', '', '2020-10-15 07:31:33', 0),
(12, 'Быстрая оплата', '', '2020-10-15 07:31:49', 0),
(13, 'Квартира + парковка', '', '2020-10-15 07:32:14', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__saleobjects`
--

CREATE TABLE `bauinvest__saleobjects` (
  `id` int NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bauinvest__saleobjects`
--

INSERT INTO `bauinvest__saleobjects` (`id`, `params`, `_updated`, `_deleted`) VALUES
(1, '{\"liter\":\"14\\u0410\",\"level\":22,\"number\":324,\"rooms\":2,\"spaceFull\":44,\"spaceWithoutBalc\":38,\"sqmtPrice\":52000,\"totalPrice\":2635000}', '2020-10-15 22:57:28', 0),
(2, '{\"liter\":\"14\\u0410\",\"level\":12,\"number\":94,\"rooms\":\"0\",\"spaceFull\":44,\"spaceWithoutBalc\":36,\"sqmtPrice\":52000,\"totalPrice\":2707000}', '2020-10-17 15:43:51', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__saletypes`
--

CREATE TABLE `bauinvest__saletypes` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bauinvest__saletypes`
--

INSERT INTO `bauinvest__saletypes` (`id`, `title`, `_updated`, `_deleted`) VALUES
(1, 'РТК', '2020-10-15 12:42:38', 0),
(2, 'Сторонние агенства', '2020-10-15 12:42:48', 0),
(3, 'ВКБ', '2020-10-15 12:42:55', 0),
(4, 'Подрядчики', '2020-10-15 12:43:02', 0),
(5, 'От руководства', '2020-10-15 12:43:08', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `bauinvest__users`
--

CREATE TABLE `bauinvest__users` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int NOT NULL DEFAULT '0',
  `device_key` varchar(255) NOT NULL,
  `token_key` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bauinvest__users`
--

INSERT INTO `bauinvest__users` (`id`, `login`, `password`, `role`, `device_key`, `token_key`, `params`, `_updated`, `_deleted`) VALUES
(1, 'user1', 'user1', 2, '127.0.0.1', 'da9a775c5947fcf989f26a1c7fcd77ca', '{\"f\":\"\\u0418\\u0432\\u0430\\u043d\\u043e\\u0432\",\"i\":\"\\u0418\\u0432\\u0430\\u043d\"}', '2020-10-11 15:25:17', 0),
(2, 'user2', 'user2', 1, '127.0.0.1', 'd739b5bc2e09664ca641f96565d50e0f', '{\"f\":\"\\u041f\\u0435\\u0442\\u0440\\u043e\\u0432\",\"i\":\"\\u041f\\u0435\\u0442\\u0440\"}', '2020-10-11 18:44:26', 0),
(7, 'user3', 'user3', 4, '127.0.0.1', 'fb4a9368872919f1c69d6334465c80ac', '{\"f\":\"\\u0421\\u0438\\u0434\\u043e\\u0440\\u043e\\u0432\",\"i\":\"\\u0421\\u0438\\u0434\\u043e\\u0440\"}', '2020-10-17 20:07:24', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bauinvest__accountingentities`
--
ALTER TABLE `bauinvest__accountingentities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__agencies`
--
ALTER TABLE `bauinvest__agencies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__autos`
--
ALTER TABLE `bauinvest__autos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__buildings`
--
ALTER TABLE `bauinvest__buildings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__calculationforms`
--
ALTER TABLE `bauinvest__calculationforms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__contracts`
--
ALTER TABLE `bauinvest__contracts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__contractstatuses`
--
ALTER TABLE `bauinvest__contractstatuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__contracttypes`
--
ALTER TABLE `bauinvest__contracttypes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__facingtypes`
--
ALTER TABLE `bauinvest__facingtypes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__flats`
--
ALTER TABLE `bauinvest__flats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__log`
--
ALTER TABLE `bauinvest__log`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__mortgagebanks`
--
ALTER TABLE `bauinvest__mortgagebanks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__objectstatuses`
--
ALTER TABLE `bauinvest__objectstatuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__partners`
--
ALTER TABLE `bauinvest__partners`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__promotions`
--
ALTER TABLE `bauinvest__promotions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__saleobjects`
--
ALTER TABLE `bauinvest__saleobjects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__saletypes`
--
ALTER TABLE `bauinvest__saletypes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bauinvest__users`
--
ALTER TABLE `bauinvest__users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bauinvest__accountingentities`
--
ALTER TABLE `bauinvest__accountingentities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `bauinvest__agencies`
--
ALTER TABLE `bauinvest__agencies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `bauinvest__autos`
--
ALTER TABLE `bauinvest__autos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `bauinvest__buildings`
--
ALTER TABLE `bauinvest__buildings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `bauinvest__calculationforms`
--
ALTER TABLE `bauinvest__calculationforms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `bauinvest__contracts`
--
ALTER TABLE `bauinvest__contracts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bauinvest__contractstatuses`
--
ALTER TABLE `bauinvest__contractstatuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `bauinvest__contracttypes`
--
ALTER TABLE `bauinvest__contracttypes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `bauinvest__facingtypes`
--
ALTER TABLE `bauinvest__facingtypes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `bauinvest__flats`
--
ALTER TABLE `bauinvest__flats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT для таблицы `bauinvest__log`
--
ALTER TABLE `bauinvest__log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT для таблицы `bauinvest__mortgagebanks`
--
ALTER TABLE `bauinvest__mortgagebanks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `bauinvest__objectstatuses`
--
ALTER TABLE `bauinvest__objectstatuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `bauinvest__partners`
--
ALTER TABLE `bauinvest__partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `bauinvest__promotions`
--
ALTER TABLE `bauinvest__promotions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `bauinvest__saleobjects`
--
ALTER TABLE `bauinvest__saleobjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bauinvest__saletypes`
--
ALTER TABLE `bauinvest__saletypes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `bauinvest__users`
--
ALTER TABLE `bauinvest__users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
