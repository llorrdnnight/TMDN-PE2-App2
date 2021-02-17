-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 17 feb 2021 om 11:11
-- Serverversie: 10.4.13-MariaDB
-- PHP-versie: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testdb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `absences`
--

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `employee` int(11) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `benefit`
--

CREATE TABLE `benefit` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `head` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `mailAddress` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `salary` float DEFAULT NULL,
  `job` int(10) DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `job`
--

CREATE TABLE `job` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `available` tinyint(1) DEFAULT NULL,
  `description` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `jobbenefit`
--

CREATE TABLE `jobbenefit` (
  `job` int(11) DEFAULT NULL,
  `benefit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `jobdescription`
--

CREATE TABLE `jobdescription` (
  `id` int(11) NOT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `general` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `joboffers`
--

CREATE TABLE `joboffers` (
  `id` int(11) NOT NULL,
  `job` int(11) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `description` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee` (`employee`);

--
-- Indexen voor tabel `benefit`
--
ALTER TABLE `benefit`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job` (`job`);

--
-- Indexen voor tabel `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`),
  ADD KEY `description` (`description`);

--
-- Indexen voor tabel `jobbenefit`
--
ALTER TABLE `jobbenefit`
  ADD KEY `job` (`job`),
  ADD KEY `benefit` (`benefit`);

--
-- Indexen voor tabel `jobdescription`
--
ALTER TABLE `jobdescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `joboffers`
--
ALTER TABLE `joboffers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job` (`job`),
  ADD KEY `description` (`description`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `benefit`
--
ALTER TABLE `benefit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `job`
--
ALTER TABLE `job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `jobdescription`
--
ALTER TABLE `jobdescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `joboffers`
--
ALTER TABLE `joboffers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`employee`) REFERENCES `employee` (`id`);

--
-- Beperkingen voor tabel `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`job`) REFERENCES `job` (`id`);

--
-- Beperkingen voor tabel `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `job_ibfk_2` FOREIGN KEY (`description`) REFERENCES `jobdescription` (`id`);

--
-- Beperkingen voor tabel `jobbenefit`
--
ALTER TABLE `jobbenefit`
  ADD CONSTRAINT `jobbenefit_ibfk_1` FOREIGN KEY (`job`) REFERENCES `job` (`id`),
  ADD CONSTRAINT `jobbenefit_ibfk_2` FOREIGN KEY (`benefit`) REFERENCES `benefit` (`id`);

--
-- Beperkingen voor tabel `joboffers`
--
ALTER TABLE `joboffers`
  ADD CONSTRAINT `joboffers_ibfk_1` FOREIGN KEY (`job`) REFERENCES `job` (`id`),
  ADD CONSTRAINT `joboffers_ibfk_2` FOREIGN KEY (`description`) REFERENCES `jobdescription` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
