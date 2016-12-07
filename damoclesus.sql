-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 05. pro 2016, 22:45
-- Verze serveru: 10.1.16-MariaDB
-- Verze PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `damoclesus`
--
CREATE DATABASE IF NOT EXISTS `damoclesus` DEFAULT CHARACTER SET utf16 COLLATE utf16_czech_ci;
USE `damoclesus`;

-- --------------------------------------------------------

--
-- Struktura tabulky `contact`
--

CREATE TABLE `contact` (
  `user_id` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `house_number` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `contact`
--

INSERT INTO `contact` (`user_id`, `city`, `street`, `house_number`, `phone`, `email`) VALUES
(3, 'City', 'Street', 9, '99999999', 'mail@damoclesus.com');

-- --------------------------------------------------------

--
-- Struktura tabulky `pause`
--

CREATE TABLE `pause` (
  `id` int(11) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `time` time NOT NULL,
  `duration` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `performance`
--

CREATE TABLE `performance` (
  `id` int(11) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `performance_actors`
--

CREATE TABLE `performance_actors` (
  `Performance_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `play`
--

CREATE TABLE `play` (
  `id` int(11) NOT NULL,
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `time_needed` time NOT NULL,
  `photo` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `production`
--

CREATE TABLE `production` (
  `id` int(11) NOT NULL,
  `director_id` int(11) DEFAULT NULL,
  `play_id` int(11) DEFAULT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `scene` enum('small','big') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `state` enum('nová','použitá','poškozená','velmi poškozená') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `rehearsal`
--

CREATE TABLE `rehearsal` (
  `id` int(11) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `difficulty` enum('nízká','střední','vysoká') COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_difficulty` enum('nízká','střední','vysoká') COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `role_actors`
--

CREATE TABLE `role_actors` (
  `Role_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role` enum('director','actor','organizer') COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sir_name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` enum('male','female') COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `role`, `username`, `sir_name`, `last_name`, `sex`, `password`) VALUES
(3, 'organizer', 'organizer', NULL, NULL, NULL, '$2y$10$iM6BVRTaNWVKfGDsMKT8hO9EuaYE76bRgua4jKDnotCxivHJf9NAK');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`user_id`);

--
-- Klíče pro tabulku `pause`
--
ALTER TABLE `pause`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D79A92EDECC6147F` (`production_id`);

--
-- Klíče pro tabulku `performance`
--
ALTER TABLE `performance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_82D79681ECC6147F` (`production_id`);

--
-- Klíče pro tabulku `performance_actors`
--
ALTER TABLE `performance_actors`
  ADD PRIMARY KEY (`Performance_id`,`User_id`),
  ADD UNIQUE KEY `UNIQ_E28566B768D3EA09` (`User_id`),
  ADD KEY `IDX_E28566B7747EA636` (`Performance_id`);

--
-- Klíče pro tabulku `play`
--
ALTER TABLE `play`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D3EDB1E0899FB366` (`director_id`),
  ADD KEY `IDX_D3EDB1E025576DBD` (`play_id`);

--
-- Klíče pro tabulku `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8BF21CDED60322AC` (`role_id`);

--
-- Klíče pro tabulku `rehearsal`
--
ALTER TABLE `rehearsal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B065A3FECC6147F` (`production_id`);

--
-- Klíče pro tabulku `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_57698A6AECC6147F` (`production_id`);

--
-- Klíče pro tabulku `role_actors`
--
ALTER TABLE `role_actors`
  ADD PRIMARY KEY (`Role_id`,`User_id`),
  ADD UNIQUE KEY `UNIQ_F2919E8368D3EA09` (`User_id`),
  ADD KEY `IDX_F2919E8319BE1B30` (`Role_id`);

--
-- Klíče pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `pause`
--
ALTER TABLE `pause`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `performance`
--
ALTER TABLE `performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `play`
--
ALTER TABLE `play`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `rehearsal`
--
ALTER TABLE `rehearsal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_4C62E638A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Omezení pro tabulku `pause`
--
ALTER TABLE `pause`
  ADD CONSTRAINT `FK_D79A92EDECC6147F` FOREIGN KEY (`production_id`) REFERENCES `production` (`id`);

--
-- Omezení pro tabulku `performance`
--
ALTER TABLE `performance`
  ADD CONSTRAINT `FK_82D79681ECC6147F` FOREIGN KEY (`production_id`) REFERENCES `production` (`id`);

--
-- Omezení pro tabulku `performance_actors`
--
ALTER TABLE `performance_actors`
  ADD CONSTRAINT `FK_E28566B768D3EA09` FOREIGN KEY (`User_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_E28566B7747EA636` FOREIGN KEY (`Performance_id`) REFERENCES `performance` (`id`);

--
-- Omezení pro tabulku `production`
--
ALTER TABLE `production`
  ADD CONSTRAINT `FK_D3EDB1E025576DBD` FOREIGN KEY (`play_id`) REFERENCES `play` (`id`),
  ADD CONSTRAINT `FK_D3EDB1E0899FB366` FOREIGN KEY (`director_id`) REFERENCES `user` (`id`);

--
-- Omezení pro tabulku `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `FK_8BF21CDED60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Omezení pro tabulku `rehearsal`
--
ALTER TABLE `rehearsal`
  ADD CONSTRAINT `FK_4B065A3FECC6147F` FOREIGN KEY (`production_id`) REFERENCES `production` (`id`);

--
-- Omezení pro tabulku `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `FK_57698A6AECC6147F` FOREIGN KEY (`production_id`) REFERENCES `production` (`id`);

--
-- Omezení pro tabulku `role_actors`
--
ALTER TABLE `role_actors`
  ADD CONSTRAINT `FK_F2919E8319BE1B30` FOREIGN KEY (`Role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `FK_F2919E8368D3EA09` FOREIGN KEY (`User_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
