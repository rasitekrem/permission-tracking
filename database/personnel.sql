-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 18 Mar 2017, 13:34:22
-- Sunucu sürümü: 10.1.21-MariaDB
-- PHP Sürümü: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `personnel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `permissionControl`
--

CREATE TABLE `permissionControl` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `PERMISSION_APPROVAL` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Approval Waiting',
  `PERMISSION_START` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `PERMISSION_END` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `PERMISSION_DAY` int(10) NOT NULL,
  `NEW_PERMISSION_DAY` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Tablo döküm verisi `permissionControl`
--

INSERT INTO `permissionControl` (`ID`, `USERNAME`, `PERMISSION_APPROVAL`, `PERMISSION_START`, `PERMISSION_END`, `PERMISSION_DAY`, `NEW_PERMISSION_DAY`) VALUES
(2, 'oliverquenn', 'Permitted', '2017-03-20', '2017-03-22', 2, 28);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `systemTable`
--

CREATE TABLE `systemTable` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `NAME` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `SURNAME` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `DEPARTMENT` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `PHONE_NO` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `IDENTITY_NO` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `PERMISSION_DAY` int(10) NOT NULL DEFAULT '30',
  `PERMISSION_STATUS` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Working',
  `PERMISSION_START` varchar(55) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `PERMISSION_END` varchar(55) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Tablo döküm verisi `systemTable`
--

INSERT INTO `systemTable` (`ID`, `USERNAME`, `NAME`, `SURNAME`, `DEPARTMENT`, `PHONE_NO`, `IDENTITY_NO`, `PERMISSION_DAY`, `PERMISSION_STATUS`, `PERMISSION_START`, `PERMISSION_END`) VALUES
(1, 'admin', 'Raşit Ekrem', 'Ataklı', 'Administrator', '+905549068449', '123123123', 30, 'Working', NULL, NULL),
(3, 'johndiggle', 'John', 'Diggle', 'Data Processing', '05553211212', '123123321321', 30, 'Working', NULL, NULL),
(4, 'oliverquenn', 'Oliver', 'Quenn', 'Data Processing', '0543321123', '123456789', 28, 'Permitted', '2017-03-20', '2017-03-22'),
(5, 'theaquenn', 'Thea', 'Quenn', 'Public Relations', '345345345', '333444555', 30, 'Working', NULL, NULL),
(6, 'louralance', 'Loura', 'Lance', 'Technical Support', '987654321', '123456789', 30, 'Working', NULL, NULL),
(7, 'saralance', 'Sara', 'Lance', 'Sales Responsible', '05431231212', '132245234', 30, 'Working', NULL, NULL),
(8, 'barryallen', 'Barry', 'Allen', 'R & D (Research-Development)', '05324321234', '989123432', 30, 'Working', NULL, NULL),
(9, 'caitlynsnow', 'Caitlyn', 'Snow', 'R & D (Research-Development)', '0532323232', '123456788', 30, 'Working', NULL, NULL),
(10, 'ciscoramon', 'Cisco', 'Ramon', 'Technical Support', '053212312342', '432123456', 30, 'Working', NULL, NULL),
(11, 'harrisonwells', 'Harrison', 'Wells', 'Data Processing', '05431232334', '123456123', 30, 'Working', NULL, NULL),
(12, 'felicitysmoak', 'Felicity', 'Smoak', 'R & D (Research-Development)', '05352331212', '234123412', 30, 'Working', NULL, NULL),
(13, 'royharper', 'Roy', 'Harper', 'Public Relations', '05431234321', '1234321234', 30, 'Working', NULL, NULL),
(14, 'quentinlance', 'Quentin', 'Lance', 'Sales Responsible', '05553211213', '1235431234', 30, 'Working', NULL, NULL),
(15, 'sladewilson', 'Slade', 'Wilson', 'Public Relations', '05451234321', '1234343123', 30, 'Working', NULL, NULL),
(16, 'curtisholt', 'Curtis', 'Holt', 'Technical Support', '0543654321', '43214321232', 30, 'Working', NULL, NULL),
(17, 'juliandorn', 'Julian', 'Dorn', 'Public Relations', '0532632541', '1236549841', 30, 'Working', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `PASSWORD` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `PASSWORD`) VALUES
(1, 'admin', '123456'),
(2, 'johndiggle', 'johndiggle'),
(3, 'oliverquenn', 'oliverquenn'),
(4, 'theaquenn', 'theaquenn'),
(5, 'louralance', 'louralance'),
(6, 'saralance', 'saralance'),
(7, 'barryallen', 'barryallen'),
(8, 'caitlynsnow', 'caitlynsnow'),
(9, 'ciscoramon', 'ciscoramon'),
(10, 'harrisonwells', 'harrisonwells'),
(11, 'felicitysmoak', 'felicitysmoak'),
(12, 'royharper', 'royharper'),
(13, 'quentinlance', 'quentinlance'),
(14, 'sladewilson', 'sladewilson'),
(15, 'curtisholt', 'curtisholt'),
(16, 'juliandorn', 'juliandorn');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `permissionControl`
--
ALTER TABLE `permissionControl`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `systemTable`
--
ALTER TABLE `systemTable`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `permissionControl`
--
ALTER TABLE `permissionControl`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `systemTable`
--
ALTER TABLE `systemTable`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
