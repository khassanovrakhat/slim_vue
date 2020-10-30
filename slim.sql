-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 30 2020 г., 13:54
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `slim`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `last_name`, `patronymic`, `password`, `hash`, `email`, `active`) VALUES
(1, 'Rakhat', 'Khassanov', 'Askaruly', '7c4a8d09ca3762af61e59520943dc26494f8941b', '03c6b06952c750899bb03d998e631860', 'khassanovrakhat@gmail.com', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cv`
--

CREATE TABLE `cv` (
  `id` int(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `nationality` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `lBirth` varchar(255) NOT NULL,
  `dBirth` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `education` text NOT NULL,
  `work_experience` text NOT NULL,
  `languages` varchar(255) NOT NULL,
  `skills` text NOT NULL,
  `additional_info` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cv`
--

INSERT INTO `cv` (`id`, `user_id`, `full_name`, `nationality`, `email`, `phone`, `lBirth`, `dBirth`, `address`, `education`, `work_experience`, `languages`, `skills`, `additional_info`, `active`) VALUES
(5, 1, 'Rakhat Khassanov', 'kazakh', 'khassanovrakhat@gmail.com', '7011049093', 'Kazakhstan, region Mangystau', '04.01.1993', 'city. Aktau, 5 dist', 'IT', '6 yaers', 'kz, en, ru', 'hardworking', 'nothing', 0),
(6, 2, 'Asan Shakabaev', 'kazakh', 'shakabaev@gmail.com', '7077896541', 'Kazakhstan, region Mangystau', '19.01.2000', 'city. Aktau, 6 dist', 'IT', '1 yaers', 'kz, en, ru', 'hardworking', 'nothing', 0),
(7, 3, 'Serik Serikbaev', 'kazakh', 'serikbaev@gmail.com', '7076547896', 'Kazakhstan, region Mangystau', '19.01.2001', 'city. Aktau, 8 dist', 'IT', '1 yaers', 'kz, en, ru', 'hardworking', 'supermen', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `patronymic`, `password`, `hash`, `email`, `active`) VALUES
(1, 'Rakhat', 'Khassanov', 'Askaruly', '7c4a8d09ca3762af61e59520943dc26494f8941b', '5c936263f3428a40227908d5a3847c0b', 'khassanovrakhat@gmail.com', 0),
(2, 'Asan', 'Shakabaev', 'KhojaAkhmetuly', '7c4a8d09ca3762af61e59520943dc26494f8941b', '25ddc0f8c9d3e22e03d3076f98d83cb2', 'shakabaev@gmail.com', 0),
(3, 'Serik', 'Serikbaev', 'Serikuly', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0d3180d672e08b4c5312dcdafdf6ef36', 'serikbaev@gmail.com', 0),
(18, 'Gulmira', 'Shatenova', 'Shatenkyzy', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'f90f2aca5c640289d0a29417bcb63a37', 'shatenova@gmail.com', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `vacancy`
--

CREATE TABLE `vacancy` (
  `id` int(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL,
  `postedOn` int(11) NOT NULL DEFAULT current_timestamp(),
  `action` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vacancy`
--

INSERT INTO `vacancy` (`id`, `title`, `description`, `status`, `postedOn`, `action`) VALUES
(1, 'Ищем Бэк енд разработчика', 'Вакансия: Middle/Senior Frontend developer\nЛокация: Алматы\nОтрасль: Fintech\nКомпания: ТОО «МФО «Smart Finance»\nСпециализация: онлайн кредитование\nЗадачи:\n- Разработка фронтенда для процесса кредитования (заявка, личный кабинет и т.п.)\n- Написание юнит-тестов, тестирование\nТребования:\n- Уверенное владение JavaScript\n- Опыт работы с React, Redux\n- Опыт кросс-браузерной разработки\n- Хорошее знание HTML и CSS\n- Знакомство с js/css препроцессорами\n- Знание систем сборки (webpack)\n- Умение работать с GIT\n- Опыт написания тестов\n- Приветствуется опыт работы с Angular и Vue.\nСтек:\n- HTML\n- CSS\n- Javascript\n- Typescript\n- React\n- Redux\nУсловия:\n- Достойная оплата труда\n- Комфортные условия\n- Оформление по Трудовому Законодательству РК', 0, 2147483647, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vacancy`
--
ALTER TABLE `vacancy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `cv`
--
ALTER TABLE `cv`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `vacancy`
--
ALTER TABLE `vacancy`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
