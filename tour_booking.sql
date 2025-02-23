-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 19 2025 г., 18:48
-- Версия сервера: 5.7.39
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tour_booking`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `seats_booked` int(11) NOT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `tour_id`, `date`, `seats_booked`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 2, '2025-02-14', 6, 'canceled', '2025-02-14 15:35:22', '2025-02-18 15:15:11'),
(6, 3, 2, '2025-02-18', 3, 'canceled', '2025-02-18 11:27:38', '2025-02-18 15:15:24'),
(7, 3, 2, '2025-02-18', 3, 'canceled', '2025-02-18 11:28:15', '2025-02-18 15:15:27'),
(8, 3, 2, '2025-02-18', 5, 'pending', '2025-02-18 11:28:31', '2025-02-18 11:28:31'),
(9, 3, 2, '2025-07-10', 5, 'pending', '2025-02-18 11:32:03', '2025-02-18 11:32:03'),
(10, 3, 3, '2025-08-05', 5, 'pending', '2025-02-19 12:37:48', '2025-02-19 12:37:48');

-- --------------------------------------------------------

--
-- Структура таблицы `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `location` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Продолжительность в часах',
  `price` decimal(10,2) NOT NULL,
  `available_dates` text COMMENT 'Список дат в формате JSON',
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tours`
--

INSERT INTO `tours` (`id`, `name`, `description`, `location`, `duration`, `price`, `available_dates`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(2, 'тур  с китами', 'Уникальное путешествие на Камчатку.1', 'Камчатка', 5, '7000.00', '[\"2025-07-10\", \"2025-07-20\"]', '/photo/photo2.jpg', 'active', '0000-00-00 00:00:00', '2025-02-19 05:33:04'),
(3, 'Белухи в Белом море', 'Наблюдение за белухами в Белом море.', 'Белое море', 3, '4500.00', '[\"2025-08-05\", \"2025-08-15\"]', '/photo/photo2.jpg', 'inactive', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'Тур с касатками', 'увлекательный тур', 'фйывмаип', 2, '6000.00', '[\"2025-02-20\"]', 'photo/1739979599.jpg', 'inactive', '2025-02-19 12:39:59', '2025-02-19 12:41:08');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('client','admin') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `password`, `full_name`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'client', 'nigmatullina.karina733@yandex.ru', '$2y$10$YBnTq8HmytuRFkb7CwVy8.inOrAjQqnJ/x/Fnwk5XoI3slFQRtqFG', 'карина нигматуллина', '+79959455301', '2025-02-13 16:05:09', '2025-02-13 16:05:09'),
(2, 'admin', 'mir@mail.ru', '$2y$10$TE31KZ81WzcpDQXonMAWpuJff7QlQ98RFkkr./0y7TxRA2TqWojTS', 'миронова наталья евгеньевна', '+79870252334', '2025-02-16 08:06:25', '2025-02-18 14:39:00'),
(3, 'client', 'mironova@mail.ru', '$2y$10$D2WblqrWAbuGH2/fjHZRf.41kmm3jpa7C4dxGjeOW/Q51.fKALxua', 'миронова наталья евгеньевна', '+79870252335', '2025-02-16 08:07:34', '2025-02-16 08:07:34'),
(4, 'client', 'mir13@mail.ru', '$2y$10$yOEYZJSBH8Qm5u36ZpZAW.IBuAKMT5DO9V91tRQ9WvfIXRe6H5Kj6', 'миронова наталья евгеньевна', '+77870252333', '2025-02-16 08:09:02', '2025-02-16 08:09:02');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Индексы таблицы `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
