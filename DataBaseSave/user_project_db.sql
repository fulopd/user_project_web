-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Feb 04. 21:45
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
  `content` mediumtext NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `news`
--

INSERT INTO `news` (`id`, `author`, `content`, `creation_date`) VALUES
(1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum molestie purus, in posuere erat finibus eu. Sed luctus quis libero non euismod. Ut sit amet egestas lectus. Sed pulvinar dui ac libero porta rhoncus. Nunc blandit risus ligula, nec accumsan tortor aliquam et. Donec luctus, purus quis vulputate commodo, risus libero posuere odio, vel dignissim lacus augue et mi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam vulputate nunc id nisl congue aliquet. Maecenas et odio a erat ullamcorper tempor. Suspendisse facilisis nec justo non faucibus. Sed feugiat consectetur luctus.', '2020-02-04 17:28:28'),
(2, 1, '<p>Sziasztok,</p>\r\n<p>Ezzel a bejegyz&eacute;ssel szeretn&eacute;m tesztelni, hogy HTML elemek hogyan jelenek meg a bejegyz&eacute;sben.</p>\r\n<ol>\r\n<li>Ha minden j&oacute;l megy</li>\r\n<li>Ez egy felsorol&aacute;s lesz.</li>\r\n</ol>\r\n<p><strong>Ez a sz&ouml;vegr&eacute;sz ki lesz emelve.</strong></p>\r\n<p style=\"text-align: center;\">&Eacute;s h&aacute;t egy kis k&ouml;z&eacute;pre igaz&iacute;t&eacute;s sem maradhat ki a sorb&oacute;l :)</p>\r\n<p style=\"text-align: left;\">Rem&eacute;lem a sort&ouml;r&eacute;sek is megmaradnak.&nbsp;<img src=\"https://html-online.com/editor/tinymce4_6_5/plugins/emoticons/img/smiley-cool.gif\" alt=\"cool\" /></p>', '2020-02-04 18:01:29'),
(3, 1, 'Na majd most \r\nTalánnnn', '2020-02-04 18:53:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `permission`
--

INSERT INTO `permission` (`id`, `permission_name`, `description`) VALUES
(1, 'Olvasás - Saját adatok', 'Saját adatok megtekintése'),
(2, 'Olvasás - Saját beosztás', 'Saját beosztás megtekintése'),
(3, 'Írás - Hírek', 'Kezdőoldalon megjelenő hírek írása és módosítása');

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
(1, 'Supervisor', 30, 'Minden ami jó', '1,2,3,9', '10:00:00'),
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

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
(18, 7, '2020-02-04 06:00:00', '2020-02-06 18:00:00', 0, 0, '2020-02-04 13:25:03');

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
