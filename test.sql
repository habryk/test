-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 24 2013 г., 22:54
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` int(3) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `author`, `text`, `lang`, `date`) VALUES
(36, 'English', 39, 'English', 'en', 1361284976),
(37, 'Ukraine!', 39, 'Ukraine', 'ua', 1361457131);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `title`, `text`, `lang`) VALUES
(1, 'Главная', 'Мы рады приветствовать Вас на нашем сайте!', 'ru'),
(22, 'Home', 'Welcome to our website!', 'en'),
(23, 'Головна', 'Ми раді вітати Вас на нашому сайті!', 'ua');

-- --------------------------------------------------------

--
-- Структура таблицы `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `permission` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `permission`
--

INSERT INTO `permission` (`id`, `permission`) VALUES
(1, 'admin'),
(2, 'editor'),
(3, 'defualt'),
(4, 'blocked');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `permission` int(1) NOT NULL DEFAULT '3',
  `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/avatars/default_avatar.png',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `skype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(20) NOT NULL,
  `lastDate` int(20) NOT NULL,
  `activation` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `permission`, `login`, `password`, `avatar`, `name`, `surname`, `email`, `skype`, `date`, `lastDate`, `activation`) VALUES
(39, 1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'images/avatars/1361398346.jpg', 'Жека', 'Габрик', 'habryk@mail.ru', 'habryk', 1360957995, 1361652170, 1),
(41, 2, 'gekaman', '283f02d100c5d4cef2b1709567ee0e7f', 'images/avatars/default_avatar.png', '', '', 'gekaman15@mail.ru', '', 1361044437, 1361460600, 1),
(42, 3, 'Жека', '202cb962ac59075b964b07152d234b70', 'images/avatars/default_avatar.png', '', '', 'жека@mail.ru', '', 1361044778, 1361051296, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
