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
  `adedadminid` int(11) NOT NULL,
  `adedadminname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `admins` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `userimg`, `adedadminid`, `adedadminname`) VALUES
(1,	'Admin',	'admin@gmail.com',	'$2y$10$KiJGRPAyVQpk5xjkMIXEgO61qgVxRZnNA5qc6hd7vOSMoliu96QqW',	'M',	1,	'2024-01-30 18:00:41',	'IMG-65b90f199e75b6.61068605.jpg',	1,	'Admin'),
(2,	'Admin 2 ',	'admin2@gmail.com',	'$2y$10$Vl/POjjK9Y5ZVF9b4.jQ5unloIpLDnVg7h77VQkWOkOF/sOA/4GCy',	'F',	1,	'2024-01-30 18:01:43',	'IMG-65b90f57e40c18.69953318.png',	1,	'Admin');

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `announcementid` int(11) NOT NULL AUTO_INCREMENT,
  `senderid` int(11) NOT NULL,
  `senderrole` int(11) NOT NULL,
  `receiverid` int(11) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `announcementtitle` varchar(50) NOT NULL,
  `startdate` date NOT NULL,
  `lastdate` date NOT NULL,
  `ispublish` char(1) NOT NULL,
  `announcement` text NOT NULL,
  PRIMARY KEY (`announcementid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `announcements` (`announcementid`, `senderid`, `senderrole`, `receiverid`, `createdate`, `announcementtitle`, `startdate`, `lastdate`, `ispublish`, `announcement`) VALUES
(1,	1,	2,	2,	'2024-02-10 11:28:00',	'Title 1',	'2024-02-07',	'2024-02-15',	'1',	'  Title 1  '),
(2,	1,	2,	3,	'2024-02-09 17:59:51',	'Title 2',	'2024-02-07',	'2024-02-15',	'0',	'Title 2'),
(3,	1,	3,	4,	'2024-02-09 15:11:29',	'Title 3',	'2024-02-09',	'2024-02-12',	'1',	'Title 3');

DROP TABLE IF EXISTS `classes`;
CREATE TABLE `classes` (
  `classid` int(11) NOT NULL AUTO_INCREMENT,
  `classnumber` varchar(2) NOT NULL,
  `classletter` char(1) NOT NULL,
  `classname` varchar(4) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`classid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `classes` (`classid`, `classnumber`, `classletter`, `classname`, `createdate`, `addedunitid`, `addedunitname`) VALUES
(1,	'9',	'A',	'9/A',	'2024-01-30 20:27:52',	1,	'Kaan Kaltakkıran'),
(2,	'9',	'B',	'9/B',	'2024-01-30 20:27:56',	1,	'Kaan Kaltakkıran'),
(3,	'9',	'C',	'9/C',	'2024-01-30 20:28:00',	1,	'Kaan Kaltakkıran'),
(4,	'9',	'D',	'9/D',	'2024-01-30 20:28:03',	1,	'Kaan Kaltakkıran'),
(5,	'10',	'A',	'10/A',	'2024-01-30 20:28:07',	1,	'Kaan Kaltakkıran'),
(6,	'10',	'B',	'10/B',	'2024-01-30 20:28:10',	1,	'Kaan Kaltakkıran'),
(7,	'10',	'C',	'10/C',	'2024-01-30 20:28:14',	1,	'Kaan Kaltakkıran'),
(8,	'10',	'D',	'10/D',	'2024-01-30 20:28:17',	1,	'Kaan Kaltakkıran'),
(9,	'11',	'A',	'11/A',	'2024-01-30 20:28:22',	1,	'Kaan Kaltakkıran'),
(10,	'11',	'B',	'11/B',	'2024-01-30 20:28:25',	1,	'Kaan Kaltakkıran'),
(11,	'11',	'C',	'11/C',	'2024-01-30 20:28:29',	1,	'Kaan Kaltakkıran'),
(12,	'11',	'D',	'11/D',	'2024-01-30 20:28:33',	1,	'Kaan Kaltakkıran'),
(13,	'12',	'A',	'12/A',	'2024-01-30 20:29:17',	1,	'Kaan Kaltakkıran'),
(14,	'12',	'B',	'12/B',	'2024-01-30 20:29:22',	1,	'Kaan Kaltakkıran'),
(15,	'12',	'C',	'12/C',	'2024-01-30 20:29:25',	1,	'Kaan Kaltakkıran'),
(16,	'12',	'D',	'12/D',	'2024-01-30 20:29:35',	1,	'Kaan Kaltakkıran');

DROP TABLE IF EXISTS `informations`;
CREATE TABLE `informations` (
  `schoolid` int(11) NOT NULL AUTO_INCREMENT,
  `schoolname` varchar(50) NOT NULL,
  `schoolyear` year(4) NOT NULL,
  `schoolterm` char(2) NOT NULL,
  `schoolabout` text NOT NULL,
  `schoolsummary` varchar(255) NOT NULL,
  `schooladdress` varchar(255) NOT NULL,
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`schoolid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `informations` (`schoolid`, `schoolname`, `schoolyear`, `schoolterm`, `schoolabout`, `schoolsummary`, `schooladdress`, `addedunitid`, `addedunitname`, `createdate`) VALUES
(1,	'School 1',	'2016',	'I',	'School 1 About',	'School 1 About Summary',	'School 1 Address',	1,	'Kaan Kaltakkıran',	'2024-02-11 09:32:24'),
(2,	'School 2',	'2023',	'II',	'School 2 About',	'School 2 About Summary',	'School 2 Address',	1,	'Kaan Kaltakkıran',	'2024-02-11 10:36:54');

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons` (
  `lessonid` int(11) NOT NULL AUTO_INCREMENT,
  `lessonname` text NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`lessonid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `lessons` (`lessonid`, `lessonname`, `createdate`, `addedunitid`, `addedunitname`) VALUES
(1,	'Math',	'2024-01-30 18:12:08',	1,	'Kaan Kaltakkıran'),
(2,	'Spor',	'2024-01-30 18:12:15',	1,	'Kaan Kaltakkıran'),
(3,	'Turkish',	'2024-01-30 18:12:17',	1,	'Kaan Kaltakkıran'),
(4,	'English',	'2024-01-30 18:12:19',	1,	'Kaan Kaltakkıran'),
(5,	'Science',	'2024-01-30 18:12:21',	1,	'Kaan Kaltakkıran');

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
  `adedadminid` int(11) NOT NULL,
  `adedadminname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `registerunits` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `useraddress`, `phonenumber`, `birthdate`, `userimg`, `adedadminid`, `adedadminname`) VALUES
(1,	'Kaan Kaltakkıran',	'kaan_fb_aslan@hotmail.com',	'$2y$10$8Lt16VFU4ZHyRGOfW7FA3O2s9G2rJ51.Ih/dnHqSZiJOckffwEQb.',	'M',	2,	'2024-01-30 18:06:22',	'Adress 1',	'05076600884',	'2000-01-01',	'IMG-65b9106edde915.94476959.jpg',	1,	'Admin'),
(2,	'Ahmet Yıldız',	'ahmet@gmail.com',	'$2y$10$gUuy9WL.muHiht7i0Oyh4e/fisBgNIJORR5.bybkKWaeZoPbHavCG',	'M',	2,	'2024-01-30 18:07:09',	'Address 2',	'23123112323',	'1987-01-01',	'IMG-65b9109d6e3128.04596518.png',	1,	'Admin');

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `useraddress` varchar(100) NOT NULL,
  `phonenumber` varchar(50) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 4,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `classid` int(11) NOT NULL,
  `classname` varchar(4) NOT NULL,
  `birthdate` date NOT NULL,
  `userimg` varchar(255) NOT NULL,
  `parentname` varchar(50) NOT NULL,
  `parentnumber` varchar(50) NOT NULL,
  `lessonid` text NOT NULL,
  `lessonname` text NOT NULL,
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `students` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `useraddress`, `phonenumber`, `roleuser`, `createdate`, `classid`, `classname`, `birthdate`, `userimg`, `parentname`, `parentnumber`, `lessonid`, `lessonname`, `addedunitid`, `addedunitname`) VALUES
(1,	'Ali Yılmaz',	'ali@gmail.com',	'$2y$10$UFHeEWCOJioUY.qdE.71o.egEaETLBqjiYquIYv450X3/PJl7F9fC',	'M',	'Adress 1',	'12331223123',	4,	'2024-01-30 18:13:53',	1,	'9/A',	'2000-01-01',	'IMG-65b9123121ed96.87847858.jpg',	'Ali Father',	'12331223123',	'1,5',	'Math,Science',	1,	'Kaan Kaltakkıran'),
(2,	'Selin Yıldız',	'selin@gmail.com',	'$2y$10$QKjJT6hdDZidt0PE5w0puOJGBpG.AT4HzuXxtnlYIKnLbzsBjHhLO',	'F',	'Address 2',	'31232312132',	4,	'2024-01-30 18:14:25',	2,	'12/D',	'1996-01-01',	'IMG-65b91251666283.15293271.jpg',	'Selin Mother',	'76546554464',	'3,4,5',	'Turkish,English,Science',	1,	'Kaan Kaltakkıran');

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 3,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `classid` text NOT NULL,
  `classname` text NOT NULL,
  `useraddress` varchar(100) NOT NULL,
  `phonenumber` char(11) NOT NULL,
  `birthdate` date NOT NULL,
  `userimg` varchar(255) NOT NULL,
  `lessonid` text NOT NULL,
  `lessonname` text NOT NULL,
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `teachers` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `classid`, `classname`, `useraddress`, `phonenumber`, `birthdate`, `userimg`, `lessonid`, `lessonname`, `addedunitid`, `addedunitname`) VALUES
(1,	'Veli Yıldız',	'veli@gmail.com',	'$2y$10$F8BOCVniVNOqHhjl7gWf8e5ptBp1wNP.KhGPA3GA9pEJx0hPGEZOm',	'M',	3,	'2024-02-10 12:43:06',	'1,6,11,16',	'9/A,10/B,11/C,12/D',	'Address 1',	'23123112323',	'1975-01-01',	'IMG-65c7452a37d2d7.23094001.png',	'1',	'Math',	1,	'Kaan Kaltakkıran'),
(2,	'Ayse Yılmaz',	'ayse@gmail.com',	'$2y$10$a7xTEd88iyzI43udPEmrSeTmxBBaj9nf.JXtJV8NadXoRV1/GGe7q',	'F',	3,	'2024-02-10 12:43:40',	'1,10',	'9/A,11/B',	'Address 2',	'12331223123',	'1980-01-01',	'IMG-65c7454cee1627.24858158.png',	'3',	'Turkish',	1,	'Kaan Kaltakkıran');

-- 2024-02-11 10:38:57
