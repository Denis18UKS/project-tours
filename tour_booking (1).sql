-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 24 2025 г., 15:13
-- Версия сервера: 8.0.30
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
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `date` date NOT NULL,
  `seats_booked` int NOT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `tour_id`, `date`, `seats_booked`, `status`, `created_at`, `updated_at`) VALUES
(11, 5, 2, '2025-07-10', 5, 'confirmed', '2025-02-22 00:10:50', '2025-02-24 08:17:21'),
(12, 6, 2, '2025-07-10', 10, 'canceled', '2025-02-22 01:51:15', '2025-02-24 08:24:18'),
(14, 5, 25, '2025-03-02', 12, 'pending', '2025-02-24 09:01:49', '2025-02-24 09:01:49'),
(15, 5, 2, '2025-07-20', 2, 'pending', '2025-02-24 09:02:03', '2025-02-24 09:02:03');

-- --------------------------------------------------------

--
-- Структура таблицы `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `location` varchar(255) NOT NULL,
  `duration` int NOT NULL COMMENT 'Продолжительность в часах',
  `price` decimal(10,2) NOT NULL,
  `available_dates` text COMMENT 'Список дат в формате JSON',
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tours`
--

INSERT INTO `tours` (`id`, `name`, `description`, `location`, `duration`, `price`, `available_dates`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(2, 'тур  с китами 123', 'Уникальное путешествие на Камчатку.123', 'Камчатка', 5, '7000.00', '[\"2025-07-10\", \"2025-07-20\"]', '/photo/photo2.jpg', 'active', '0000-00-00 00:00:00', '2025-02-22 01:11:10'),
(3, 'Белухи в Белом море 123', 'Наблюдение за белухами в Белом море. 123', 'Белое море', 3, '4500.00', '[\"2025-08-05\", \"2025-08-15\"]', '/photo/1740197402.jpg', 'inactive', '0000-00-00 00:00:00', '2025-02-22 01:10:29'),
(25, 'Тур с касатками', 'Тур с касатками', 'Океан', 12, '12999.00', '[\"2025-02-26\",\"2025-02-28\",\"2025-03-02\",\"2025-03-08\"]', 'photo/1740397519.jpg', 'active', '2025-02-24 08:45:19', '2025-02-24 08:45:19');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `role` enum('client','admin') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `password`, `full_name`, `phone_number`, `created_at`, `updated_at`) VALUES
(5, 'client', 'lakos208@gmail.com', '$2y$10$J6/z2Mkuiq6pjpKgrNaIs.CB6tQyjQGR14rwx5503ztOoTCyabHTm', 'Карпов Денис Витальевич', '+79867074777', '2025-02-22 00:09:44', '2025-02-22 00:09:44'),
(6, 'admin', 'honorxpremium75@gmail.com', '$2y$10$oaLtyANaT9XSVJreIhgvkevy9Nblj5J1.HZmSeUSsJlCReQ1URbgS', 'Карпов Денис Витальевич', '+79867074776', '2025-02-22 00:11:59', '2025-02-22 03:12:20');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
