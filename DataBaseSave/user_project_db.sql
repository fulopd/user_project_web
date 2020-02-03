-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Feb 03. 15:21
-- Kiszolgáló verziója: 10.4.8-MariaDB
-- PHP verzió: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `user_project_db`
--
CREATE DATABASE IF NOT EXISTS `user_project_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `user_project_db`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `permission`
--

INSERT INTO `permission` (`id`, `permission_name`, `description`) VALUES
(1, 'Olvasás - Saját adatok', 'Saját adatok megtekintése'),
(2, 'Olvasás - Saját beosztás', 'Saját beosztás megtekintése');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `personal_data`
--

DROP TABLE IF EXISTS `personal_data`;
CREATE TABLE IF NOT EXISTS `personal_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `mother` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `picture` varchar(150) DEFAULT 'profile.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `personal_data`
--

INSERT INTO `personal_data` (`id`, `first_name`, `last_name`, `mother`, `birth_date`, `location`, `email`, `phone`, `picture`) VALUES
(1, 'Első', 'Felhasználó', 'Kelemen Emőke', '1987-01-01', 'Szeged', 'elso.felhasznalo@gmail.com', '+36301234567', '1.jpg'),
(2, 'Bubi', 'Adél', 'Bubba Bubi', '1964-03-22', 'Kecskemét', 'adi64@freemail.hu', NULL, 'profile.jpg'),
(3, 'Tollas', 'Béla', 'Béláné', '2020-01-01', 'Szeged', 'bela@gmail.com', '036301224557', 'profile.jpg'),
(4, 'Heladi', 'Piroska', 'Árpád Enikő', '1987-01-01', 'Szeged', 'zellerke21@gmail.com', '03620544788', 'profile.jpg'),
(5, 'Koronás', 'Géza', 'Hamo Ilona', '1984-03-03', 'Kerekerdő', 'bocika@gmail.com', '0123456789', 'profile.jpg'),
(6, 'Fele', 'Botond', 'Kiss Éva', '1965-01-01', 'Szeged', 'kevebocs@gmail.com', '+36547884115', 'profile.jpg'),
(7, 'Katyusá', 'Annamária', 'Ismeretlen', '1977-02-05', 'Röszke', 'annus44@gmail.com', '+36504115887', 'profile.jpg'),
(8, 'Bubi', 'Gerda', 'Puti Ibolya', '1978-05-05', 'Szeged', 'gerda@gmail.com', '+36506552118', 'profile.jpg'),
(9, 'Tollas', 'Benedek', 'Szegfű Annamária', '2020-02-02', 'szeged', 'Benedek@gmail.com', '+36204117884', 'profile.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(50) NOT NULL,
  `priority` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `permission_ids` varchar(100) NOT NULL,
  `work_schedules` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `position`
--

INSERT INTO `position` (`id`, `position_name`, `priority`, `description`, `permission_ids`, `work_schedules`) VALUES
(1, 'Supervisor', 30, 'Minden ami jó', '1,2,9', '10:00:00'),
(2, 'Járatszedő', 100, 'Járatok összekészítésért felelős', '1,2', '12:00:00'),
(3, 'Végellenőr', 70, 'Járatok ellenőrzése', '1,2', '12:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `time_table`
--

DROP TABLE IF EXISTS `time_table`;
CREATE TABLE IF NOT EXISTS `time_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `paid_leave` tinyint(1) DEFAULT 0,
  `sick_leave` tinyint(1) DEFAULT 0,
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `time_table`
--

INSERT INTO `time_table` (`id`, `user_id`, `start_date`, `end_date`, `paid_leave`, `sick_leave`, `update_at`) VALUES
(1, 1, '2020-01-02 06:00:00', '2020-01-02 16:00:00', 0, 0, '2020-01-30 08:47:06'),
(2, 1, '2020-01-03 00:00:00', NULL, 1, 0, '2020-01-30 08:47:49'),
(3, 1, '2020-01-04 00:00:00', NULL, 0, 1, '2020-01-30 08:48:44'),
(4, 1, '2020-01-20 18:00:00', '2020-01-21 06:00:00', 0, 0, '2020-01-30 11:11:42'),
(5, 7, '2020-01-20 18:00:00', '2020-01-21 06:00:00', 0, 0, '2020-02-03 12:39:16'),
(6, 3, '2020-02-02 06:00:00', '2020-02-02 18:00:00', 0, 0, '2020-02-03 12:40:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_data`
--

DROP TABLE IF EXISTS `user_data`;
CREATE TABLE IF NOT EXISTS `user_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personal_data_id` int(11) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `first_working_day` date DEFAULT NULL,
  `last_working_day` date DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `personal_data_id` (`personal_data_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `user_data`
--

INSERT INTO `user_data` (`id`, `personal_data_id`, `user_name`, `password`, `first_working_day`, `last_working_day`, `position_id`) VALUES
(1, 1, 'admin', 'admin', '2020-01-29', NULL, 1),
(2, 2, 'bubi', 'bubi', '2020-01-31', NULL, 2),
(3, 3, 'bela', 'bela', '2020-01-07', NULL, 2),
(4, 4, 'piri', 'piri', '2020-01-19', NULL, 1),
(5, 5, 'kori', 'kori', '2020-01-07', NULL, 1),
(6, 6, 'boti', 'boti', '2020-01-11', NULL, 2),
(7, 7, 'annus', 'annus', '2020-01-20', NULL, 2),
(8, 8, 'gere', 'gere', '2020-01-29', NULL, 2),
(9, 9, 'benedek', 'benedek', '2020-02-03', NULL, 3);

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `time_table`
--
ALTER TABLE `time_table`
  ADD CONSTRAINT `time_table_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_data` (`id`);

--
-- Megkötések a táblához `user_data`
--
ALTER TABLE `user_data`
  ADD CONSTRAINT `user_data_ibfk_1` FOREIGN KEY (`personal_data_id`) REFERENCES `personal_data` (`id`),
  ADD CONSTRAINT `user_data_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
