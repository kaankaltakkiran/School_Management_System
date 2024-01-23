-- Adminer 4.8.1 MySQL 5.5.5-10.4.27-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 1,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `userimg` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `admins` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `userimg`) VALUES
(1,	'Admin',	'admin@gmail.com',	'$2y$10$nDi3kgm//7E8omudAa1cQO7FCYmWywR4spIf3HM1yBNkyHYyW4O16',	'M',	1,	'2024-01-20 19:13:12',	'IMG-65abf118dd3d20.69279538.jpg'),
(2,	'Admin 2 ',	'admin2@gmail.com',	'$2y$10$tYagcdPVPrmAdPjgMqqu.Ok3m/62O3gg2wO4hbMXKwe7U.pTIOF36',	'F',	1,	'2024-01-20 19:13:31',	'IMG-65abf12b7123b1.64554763.png');

DROP TABLE IF EXISTS `classes`;
CREATE TABLE `classes` (
  `classid` int(11) NOT NULL AUTO_INCREMENT,
  `classnumber` varchar(2) NOT NULL,
  `classletter` char(1) NOT NULL,
  `classname` varchar(4) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`classid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `classes` (`classid`, `classnumber`, `classletter`, `classname`, `createdate`) VALUES
(1,	'9',	'A',	'9/A',	'2024-01-22 21:16:27'),
(2,	'9',	'B',	'9/B',	'2024-01-22 21:16:30'),
(3,	'9',	'C',	'9/C',	'2024-01-22 21:16:33'),
(4,	'9',	'D',	'9/D',	'2024-01-22 21:16:36'),
(5,	'10',	'A',	'10/A',	'2024-01-22 21:16:40'),
(6,	'10',	'B',	'10/B',	'2024-01-22 21:16:43'),
(7,	'10',	'C',	'10/C',	'2024-01-22 21:16:46'),
(8,	'10',	'D',	'10/D',	'2024-01-22 21:16:49'),
(9,	'11',	'A',	'11/A',	'2024-01-22 21:16:52'),
(10,	'11',	'B',	'11/B',	'2024-01-22 21:16:56'),
(11,	'11',	'C',	'11/C',	'2024-01-22 21:17:00'),
(12,	'11',	'D',	'11/D',	'2024-01-22 21:17:03'),
(13,	'12',	'A',	'12/A',	'2024-01-22 21:17:07'),
(14,	'12',	'B',	'12/B',	'2024-01-22 21:17:14'),
(15,	'12',	'C',	'12/C',	'2024-01-22 21:17:17'),
(16,	'12',	'D',	'12/D',	'2024-01-22 21:17:20');

DROP TABLE IF EXISTS `registerunits`;
CREATE TABLE `registerunits` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 2,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `useraddress` varchar(100) NOT NULL,
  `phonenumber` char(11) NOT NULL,
  `birthdate` date NOT NULL,
  `userimg` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `registerunits` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `useraddress`, `phonenumber`, `birthdate`, `userimg`) VALUES
(1,	'Kaan Kaltakkıran',	'kaan_fb_aslan@hotmail.com',	'$2y$10$yQMIEbk4WZVdkB9ja8LiFOdr211UwLn4v9L7mjmwMdPxy.z/LhtN.',	'M',	2,	'2024-01-20 19:14:21',	'Address 1',	'05076600884',	'1999-12-23',	'IMG-65abf15d153db8.41188102.jpg'),
(2,	'Ahmet Yıldız',	'ahmet@gmail.com',	'$2y$10$g0CiMeLld8MDdKI/9f1/wuj5fADvv24c1975xDNpZdDKKi0Jq9Uvm',	'M',	2,	'2024-01-20 19:14:40',	'CUMHURİYET MAH. NECİP FAZIL KISAKÜREK SK. BAHAR APT NO: 18  İÇ KAPI NO: 25',	'05076600889',	'2000-01-01',	'IMG-65abf170824ad6.64819139.png');

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 3,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `classid` varchar(50) NOT NULL,
  `useraddress` varchar(100) NOT NULL,
  `phonenumber` char(11) NOT NULL,
  `birthdate` date NOT NULL,
  `userimg` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `teachers` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `classid`, `useraddress`, `phonenumber`, `birthdate`, `userimg`) VALUES
(1,	'Ayse Yılmaz',	'ayse@gmail.com',	'$2y$10$1ggUZ/04nXCIJhuJu20h/uC1PwrB36imKd5d.L1fUuYOo82Vp7Owy',	'F',	3,	'2024-01-20 19:15:30',	'',	'CUMHURİYET MAH. NECİP FAZIL KISAKÜREK SK. BAHAR APT NO: 18  İÇ KAPI NO: 25',	'31232312132',	'1983-12-10',	'IMG-65abf1a2820575.85303979.png'),
(2,	'Veli Yıldız',	'veli@gmail.com',	'$2y$10$nZzJEBIlSRatkGa/MCSlb.1/KcgnqxRXURNxF5JpjuPTvseB0TtLe',	'M',	3,	'2024-01-20 19:16:58',	'',	'CUMHURİYET MAH. NECİP FAZIL KISAKÜREK SK. BAHAR APT NO: 18  İÇ KAPI NO: 25',	'31232312132',	'1987-10-15',	'IMG-65abf1fa295884.68984613.png');

-- 2024-01-23 10:24:05
