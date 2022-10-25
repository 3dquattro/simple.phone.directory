-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 25 2022 г., 16:29
-- Версия сервера: 10.4.20-MariaDB
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `phones`
--
CREATE DATABASE IF NOT EXISTS `phones` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `phones`;

-- --------------------------------------------------------

--
-- Структура таблицы `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `subid` int(11) NOT NULL DEFAULT 1,
  `name` varchar(1000) NOT NULL DEFAULT 'Наименование',
  `phone` varchar(50) NOT NULL DEFAULT 'Телефон',
  `innerphone` varchar(50) NOT NULL DEFAULT 'Внутренний телефон',
  `email` varchar(100) NOT NULL,
  `cabinet` varchar(100) NOT NULL DEFAULT 'Кабинет',
  `housing` varchar(100) NOT NULL,
  `posn` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `depid` int(11) NOT NULL DEFAULT 1,
  `name` varchar(1000) NOT NULL DEFAULT 'ФИО',
  `phone` varchar(200) NOT NULL DEFAULT 'Телефон',
  `innerphone` varchar(200) NOT NULL DEFAULT 'Внутренний телефон',
  `email` varchar(100) NOT NULL,
  `housing` varchar(100) NOT NULL,
  `cabinet` varchar(200) NOT NULL DEFAULT 'Кабинет',
  `position` varchar(250) NOT NULL DEFAULT 'Должность',
  `posn` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `subdivision`
--

CREATE TABLE `subdivision` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `housing` varchar(100) NOT NULL,
  `cabinet` varchar(100) NOT NULL,
  `posn` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subdivision`
--
ALTER TABLE `subdivision`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `subdivision`
--
ALTER TABLE `subdivision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
