-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Feb 09. 19:22
-- Kiszolgáló verziója: 10.1.39-MariaDB
-- PHP verzió: 7.3.5

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
-- Tábla szerkezet ehhez a táblához `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `news`
--

INSERT INTO `news` (`id`, `author`, `title`, `content`, `public`, `creation_date`) VALUES
(1, 1, '321', 'update', 1, '2020-02-01 11:11:00'),
(2, 1, 'HTML teszt bejegyzés', '<p>Sziasztok,</p>\r\n<p>Ezzel a bejegyz&eacute;ssel szeretn&eacute;m tesztelni, hogy HTML elemek hogyan jelenek meg a bejegyz&eacute;sben.</p>\r\n<ol>\r\n<li>Ha minden j&oacute;l megy</li>\r\n<li>Ez egy felsorol&aacute;s lesz.</li>\r\n</ol>\r\n<p><strong>Ez a sz&ouml;vegr&eacute;sz ki lesz emelve.</strong></p>\r\n<p style=\"text-align: center;\">&Eacute;s h&aacute;t egy kis k&ouml;z&eacute;pre igaz&iacute;t&eacute;s sem maradhat ki a sorb&oacute;l :)</p>\r\n<p style=\"text-align: left;\">Rem&eacute;lem a sort&ouml;r&eacute;sek is megmaradnak.&nbsp;<img src=\"https://html-online.com/editor/tinymce4_6_5/plugins/emoticons/img/smiley-cool.gif\" alt=\"cool\" /></p>', 0, '2020-02-04 18:01:29'),
(3, 1, 'Ezt már oldalról töltöttem fel', 'Na majd most \r\nTalánnnn', 1, '2020-02-04 18:53:06'),
(4, 1, '', 'Ez már a create php -ból kerül feltöltésre\r\nés van jelölő box is hogy kilegyen e rakva a főoldalra\r\namit kiveszek hogy ne legyen kirakva', 0, '2020-02-05 11:34:57'),
(5, 1, '', 'ez ki fog menni', 1, '2020-02-05 11:35:44'),
(6, 1, 'Most már ennek is van címe', 'checkbox jooo csak a Title nem lett bekötve :)', 1, '2020-02-05 11:37:38'),
(7, 1, 'dweedfwef', 'wefwefwefwef', 1, '2020-02-05 11:38:59'),
(8, 1, 'dfgdfgdfg', 'sdfgdsfgdsfg', 0, '2020-02-05 11:45:02'),
(9, 1, 'vvvvvvvvvv', 'vvvvvvvvvvvvvv', 0, '2020-02-05 11:45:53'),
(10, 1, 'vvvvvvvvvv', 'vvvvvvvvvvvvvv', 0, '2020-02-05 11:46:40'),
(11, 1, 'fgdfg', 'dfgdfgdfg', 1, '2020-02-05 11:46:49'),
(12, 1, 'fgdfg', 'dfgdfgdfg', 1, '2020-02-05 11:49:14'),
(13, 1, 'sdfsdf', 'dsfsdfsdf', 1, '2020-02-05 11:49:20'),
(14, 1, '333', '3333', 1, '2020-02-05 11:49:29'),
(15, 1, 'yyyyyyyyyy', 'yyyyyyyyyyyy', 0, '2020-02-05 11:50:04'),
(16, 1, 'yyyyywwwwww', 'wwwwwwwwwwwwwwwww', 0, '2020-02-05 11:50:12'),
(17, 1, 'aaaaaa', 'aaaaaaaaaaa', 1, '2020-02-05 11:50:34'),
(18, 1, 'sdsadasdsa', 'asdasdasd', 0, '2020-02-05 11:50:39'),
(19, 1, 'qwe', 'asd', 1, '2020-02-05 12:31:38'),
(20, 1, 'Ez egy uj hír ', 'híír híír híír\r\nsdfsdfsdfsdf', 1, '2020-02-09 16:32:35');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `permission`
--

INSERT INTO `permission` (`id`, `permission_name`, `description`) VALUES
(1, 'Olvasás - Saját adatok', 'Saját adatok megtekintése'),
(2, 'Olvasás - Saját beosztás', 'Saját beosztás megtekintése'),
(3, 'Írás - Hírek', 'Kezdőoldalon megjelenő hírek írása és módosítása'),
(4, 'Olvasás - Teljes beosztás', 'Összes alkalmazott beosztása'),
(5, 'Olvasás - Tabló', 'Tabló megjelenítése');

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
(2, 'Bubi', 'Adél', 'Bubba Bubi', '1964-03-22', 'Kecskemét', 'adi64@freemail.hu', NULL, '2.jpeg'),
(3, 'Tollas', 'Béla', 'Béláné', '2020-01-01', 'Szeged', 'bela@gmail.com', '036301224557', 'profile.jpg'),
(4, 'Heladi', 'Piroska', 'Árpád Enikő', '1987-01-01', 'Szeged', 'zellerke21@gmail.com', '03620544788', '4.jpg'),
(5, 'Koronás', 'Géza', 'Hamo Ilona', '1984-03-03', 'Kerekerdő', 'bocika@gmail.com', '0123456789', '5.jpg'),
(6, 'Fele', 'Botond', 'Kiss Éva', '1965-01-01', 'Szeged', 'kevebocs@gmail.com', '+36547884115', '6.jpg'),
(7, 'Katyusa', 'Annamária', 'Ismeretlen', '1977-02-05', 'Röszke', 'annus44@gmail.com', '+36504115887', 'profile.jpg'),
(8, 'Bubi', 'Gerda', 'Puti Ibolya', '1978-05-05', 'Szeged', 'gerda@gmail.com', '+36506552118', 'profile.jpg'),
(9, 'Tollas', 'Benedek', 'Szegfű Annamária', '2020-02-02', 'szeged', 'Benedek@gmail.com', '+36204117884', '8.png');

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
(1, 'Supervisor', 30, 'Minden ami jó', '1,2,3,4,5', '10:00:00'),
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
  `paid_leave` tinyint(1) DEFAULT '0',
  `sick_leave` tinyint(1) DEFAULT '0',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `time_table`
--

INSERT INTO `time_table` (`id`, `user_id`, `start_date`, `end_date`, `paid_leave`, `sick_leave`, `update_at`) VALUES
(1, 1, '2020-01-02 06:00:00', '2020-01-02 16:00:00', 0, 0, '2020-01-30 08:47:06'),
(2, 1, '2020-01-03 00:00:00', NULL, 1, 0, '2020-01-30 08:47:49'),
(3, 1, '2020-01-04 00:00:00', NULL, 0, 1, '2020-01-30 08:48:44'),
(4, 1, '2020-01-20 18:00:00', '2020-01-21 06:00:00', 0, 0, '2020-01-30 11:11:42'),
(5, 7, '2020-01-20 18:00:00', '2020-01-21 06:00:00', 0, 0, '2020-02-03 12:39:16'),
(6, 3, '2020-02-02 06:00:00', '2020-02-02 18:00:00', 0, 0, '2020-02-03 12:40:00'),
(7, 1, '2020-05-13 06:00:00', '2020-05-13 16:00:00', 0, 0, '2020-02-04 10:21:55'),
(8, 1, '2020-02-05 06:00:00', '2020-02-05 16:00:00', 0, 0, '2020-02-04 10:24:17'),
(9, 1, '2020-02-04 06:00:00', '2020-02-04 16:00:00', 0, 0, '2020-02-04 10:25:09'),
(10, 2, '2020-02-06 18:00:00', '2020-02-07 06:00:00', 0, 0, '2020-02-04 11:40:01'),
(11, 3, '2020-02-05 05:00:00', '2020-02-05 16:00:00', 0, 0, '2020-02-04 11:40:34'),
(12, 4, '2020-02-05 06:00:00', '2020-02-05 16:00:00', 0, 0, '2020-02-04 11:41:02'),
(13, 5, '2020-02-11 06:00:00', '2020-02-11 16:00:00', 0, 0, '2020-02-04 11:41:32'),
(14, 6, '2020-02-10 18:00:00', '2020-02-11 06:00:00', 0, 0, '2020-02-04 11:41:53'),
(15, 7, '2020-02-10 06:00:00', '2020-02-10 16:00:00', 0, 0, '2020-02-04 11:42:22'),
(16, 8, '2020-02-04 18:00:00', '2020-02-05 06:00:00', 0, 0, '2020-02-04 11:43:15'),
(17, 9, '2020-02-13 06:00:00', '2020-02-13 16:00:00', 0, 0, '2020-02-04 11:43:40'),
(18, 7, '2020-02-04 06:00:00', '2020-02-06 18:00:00', 0, 0, '2020-02-04 13:25:03'),
(19, 1, '2020-02-12 06:00:00', '2020-02-12 16:00:00', 0, 0, '2020-02-09 15:57:07');

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
-- Megkötések a táblához `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user_data` (`id`);

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
