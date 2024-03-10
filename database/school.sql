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
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastlogintime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `userimg` varchar(255) NOT NULL,
  `adedadminid` int(11) NOT NULL,
  `adedadminname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `admins` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `lastupdate`, `lastlogintime`, `userimg`, `adedadminid`, `adedadminname`) VALUES
(1,	'Admin',	'admin@gmail.com',	'$2y$10$KiJGRPAyVQpk5xjkMIXEgO61qgVxRZnNA5qc6hd7vOSMoliu96QqW',	'M',	1,	'2024-01-30 18:00:41',	'2024-03-02 12:28:13',	'2024-03-06 13:54:42',	'IMG-65b90f199e75b6.61068605.jpg',	1,	'Admin'),
(2,	'Admin 2',	'admin2@gmail.com',	'$2y$10$Vl/POjjK9Y5ZVF9b4.jQ5unloIpLDnVg7h77VQkWOkOF/sOA/4GCy',	'F',	1,	'2024-01-30 18:01:43',	'2024-03-02 11:34:02',	'2024-03-02 10:28:51',	'IMG-65b90f57e40c18.69953318.png',	1,	'Admin');

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `announcementid` int(11) NOT NULL AUTO_INCREMENT,
  `senderid` int(11) NOT NULL,
  `sendername` varchar(50) NOT NULL,
  `senderrole` int(11) NOT NULL,
  `receiverrole` int(11) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `announcementtitle` varchar(50) NOT NULL,
  `startdate` date NOT NULL,
  `lastdate` date NOT NULL,
  `ispublish` char(1) NOT NULL,
  `announcement` text NOT NULL,
  `readcount` int(11) NOT NULL,
  PRIMARY KEY (`announcementid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `announcements` (`announcementid`, `senderid`, `sendername`, `senderrole`, `receiverrole`, `createdate`, `lastupdate`, `announcementtitle`, `startdate`, `lastdate`, `ispublish`, `announcement`, `readcount`) VALUES
(1,	1,	'Kaan Kaltakkıran',	2,	3,	'2024-03-02 12:37:20',	'2024-03-02 12:39:36',	'Register Unit To Teachers',	'2024-02-29',	'2024-03-31',	'1',	'This Announcement Register Unit To Teachers          ',	73),
(2,	1,	'Veli Yıldız',	3,	4,	'2024-02-29 20:09:39',	'2024-03-02 12:37:52',	'Teacher To Students',	'2024-02-29',	'2024-05-01',	'1',	'This Annoucement Teacher To Students',	34),
(3,	1,	'Kaan Kaltakkıran',	2,	4,	'2024-03-02 12:37:20',	'2024-03-04 20:33:47',	'Register Unit To Students',	'2024-02-29',	'2024-04-01',	'0',	'    This Annoucement Register Unit To Students    ',	68),
(4,	1,	'Kaan Kaltakkıran',	2,	3,	'2024-03-04 20:34:40',	'2024-03-04 20:34:40',	'Date Problem Announcement',	'2024-01-20',	'2024-02-10',	'1',	'Date Problem Announcement Description',	27),
(5,	1,	'Kaan Kaltakkıran',	2,	2,	'2024-03-04 20:54:29',	'2024-03-04 20:54:29',	'Date Problem And Not Published Announcement',	'2024-02-04',	'0000-00-00',	'0',	'Date Problem And Not Published Announcement Description',	8),
(6,	1,	'Veli Yıldız',	3,	5,	'2024-03-10 18:30:43',	'2024-03-10 18:30:43',	'The Announcement For Parent\'s',	'2024-03-10',	'2025-09-10',	'1',	'The Announcement For Parent\'s Content',	5);

DROP TABLE IF EXISTS `attendances`;
CREATE TABLE `attendances` (
  `attendanceid` int(11) NOT NULL AUTO_INCREMENT,
  `studentid` int(11) NOT NULL,
  `studentimg` varchar(255) NOT NULL,
  `ishere` varchar(1) NOT NULL,
  `studentname` varchar(50) NOT NULL,
  `studentclassid` int(11) NOT NULL,
  `studentclassname` varchar(50) NOT NULL,
  `studentlessonid` varchar(50) NOT NULL,
  `studentlessonname` varchar(50) NOT NULL,
  `addedteacherid` int(11) NOT NULL,
  `addedteachername` varchar(50) NOT NULL,
  `createdate` date NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `attendanceid` (`attendanceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `attendances` (`attendanceid`, `studentid`, `studentimg`, `ishere`, `studentname`, `studentclassid`, `studentclassname`, `studentlessonid`, `studentlessonname`, `addedteacherid`, `addedteachername`, `createdate`, `lastupdate`) VALUES
(1,	3,	'IMG-65e75cbea3cb65.35268383.jpg',	'1',	'Student 1',	1,	'9/A',	'1',	'Math',	1,	'Veli Yıldız',	'2024-03-07',	'2024-03-10 13:25:07'),
(2,	7,	'IMG-65e9ddef154650.56374619.jpg',	'0',	'Student 5',	1,	'9/A',	'1',	'Math',	1,	'Veli Yıldız',	'2024-03-07',	'2024-03-10 13:25:07'),
(3,	3,	'IMG-65e75cbea3cb65.35268383.jpg',	'0',	'Student 1',	1,	'9/A',	'1',	'Math',	1,	'Veli Yıldız',	'2024-03-08',	'2024-03-08 20:47:31'),
(4,	7,	'IMG-65e9ddef154650.56374619.jpg',	'1',	'Student 5',	1,	'9/A',	'1',	'Math',	1,	'Veli Yıldız',	'2024-03-08',	'2024-03-08 20:47:31'),
(5,	1,	'IMG-65e75b469b0850.36446039.png',	'1',	'Ali Yılmaz',	6,	'10/B',	'1',	'Math',	1,	'Veli Yıldız',	'2024-03-08',	'2024-03-08 20:47:31'),
(6,	3,	'IMG-65e75cbea3cb65.35268383.jpg',	'0',	'Student 1',	1,	'9/A',	'1',	'Math',	1,	'Veli Yıldız',	'2024-03-10',	'2024-03-10 13:34:06'),
(7,	7,	'IMG-65e9ddef154650.56374619.jpg',	'1',	'Student 5',	1,	'9/A',	'1',	'Math',	1,	'Veli Yıldız',	'2024-03-10',	'2024-03-10 13:34:06'),
(8,	1,	'IMG-65e75b469b0850.36446039.png',	'1',	'Ali Yılmaz',	6,	'10/B',	'1',	'Math',	1,	'Veli Yıldız',	'2024-03-10',	'2024-03-10 13:17:37'),
(9,	3,	'IMG-65e75cbea3cb65.35268383.jpg',	'1',	'Student 1',	1,	'9/A',	'3',	'Turkish',	2,	'Ayse Yılmaz',	'2024-03-10',	'2024-03-10 13:27:20');

DROP TABLE IF EXISTS `classes`;
CREATE TABLE `classes` (
  `classid` int(11) NOT NULL AUTO_INCREMENT,
  `classnumber` varchar(2) NOT NULL,
  `classletter` char(1) NOT NULL,
  `classname` varchar(4) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`classid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `classes` (`classid`, `classnumber`, `classletter`, `classname`, `createdate`, `lastupdate`, `addedunitid`, `addedunitname`) VALUES
(1,	'9',	'A',	'9/A',	'2024-01-30 20:27:52',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(2,	'9',	'B',	'9/B',	'2024-01-30 20:27:56',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(3,	'9',	'C',	'9/C',	'2024-01-30 20:28:00',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(4,	'9',	'D',	'9/D',	'2024-01-30 20:28:03',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(5,	'10',	'A',	'10/A',	'2024-01-30 20:28:07',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(6,	'10',	'B',	'10/B',	'2024-01-30 20:28:10',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(7,	'10',	'C',	'10/C',	'2024-01-30 20:28:14',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(8,	'10',	'D',	'10/D',	'2024-01-30 20:28:17',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(9,	'11',	'A',	'11/A',	'2024-01-30 20:28:22',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(10,	'11',	'B',	'11/B',	'2024-01-30 20:28:25',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(11,	'11',	'C',	'11/C',	'2024-01-30 20:28:29',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(12,	'11',	'D',	'11/D',	'2024-01-30 20:28:33',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(13,	'12',	'A',	'12/A',	'2024-01-30 20:29:17',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(14,	'12',	'B',	'12/B',	'2024-01-30 20:29:22',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(15,	'12',	'C',	'12/C',	'2024-01-30 20:29:25',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran'),
(16,	'12',	'D',	'12/D',	'2024-01-30 20:29:35',	'2024-03-02 11:34:35',	1,	'Kaan Kaltakkıran');

DROP TABLE IF EXISTS `exams`;
CREATE TABLE `exams` (
  `examid` int(11) NOT NULL AUTO_INCREMENT,
  `examimg` varchar(255) NOT NULL,
  `examtitle` varchar(50) NOT NULL,
  `lessonname` varchar(50) NOT NULL,
  `examdescription` varchar(100) NOT NULL,
  `examstartdate` date NOT NULL,
  `examenddate` date NOT NULL,
  `examtime` char(2) NOT NULL,
  `ispublish` char(1) NOT NULL,
  `classid` text NOT NULL,
  `classname` text NOT NULL,
  `addedid` int(11) NOT NULL,
  `addedname` varchar(50) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`examid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `exams` (`examid`, `examimg`, `examtitle`, `lessonname`, `examdescription`, `examstartdate`, `examenddate`, `examtime`, `ispublish`, `classid`, `classname`, `addedid`, `addedname`, `createdate`, `lastupdate`) VALUES
(1,	'IMG-65d9f46b758223.72202667.jpg',	'Exam 1',	'Math',	'Exam 1 Description',	'2024-03-02',	'2024-06-01',	'10',	'1',	'6',	'10/B',	1,	'Veli Yıldız',	'2024-02-29 20:41:26',	'2024-03-09 13:54:08'),
(2,	'IMG-65e0bccbe765d9.72184758.jpg',	'Exam 2',	'Math',	'Exam 2 Description',	'2024-02-29',	'2024-06-29',	'45',	'1',	'1',	'9/A',	1,	'Veli Yıldız',	'2024-02-29 20:20:29',	'2024-02-24 16:53:34'),
(3,	'IMG-65e0c24ce0c1a1.52900404.jpg',	'Exam 3',	'Turkish',	'Exam 3 Description',	'2024-02-29',	'2024-06-30',	'60',	'1',	'10',	'11/B',	2,	'Ayse Yılmaz',	'2024-02-29 20:43:40',	'2024-02-24 16:54:14'),
(4,	'IMG-65e33bdc046f70.33858521.jpg',	'Exam  Date problem',	'Spor',	'Exam Date problem Description',	'2024-02-29',	'2024-03-01',	'10',	'1',	'2',	'9/B',	3,	'Spor Teacher',	'2024-03-02 17:46:52',	'2024-03-02 17:46:52'),
(5,	'IMG-65e33d69738090.67583037.jpg',	'Exam Publish Problem',	'Spor',	'Exam Publish Problem Description',	'2024-03-02',	'2024-03-10',	'30',	'0',	'7',	'10/C',	3,	'Spor Teacher',	'2024-03-02 17:53:29',	'2024-03-02 17:53:29'),
(6,	'IMG-65e34bd3d48ee2.69414558.jpg',	'Exam Available',	'Spor',	'Exam Available Description',	'2024-03-02',	'2024-03-10',	'60',	'1',	'13',	'12/A',	3,	'Spor Teacher',	'2024-03-02 18:54:59',	'2024-03-02 18:54:59'),
(7,	'IMG-65e350f0a71b39.23498431.jpg',	'Exam Not Date And Publish',	'Spor',	'Exam Not Date And Publish',	'2024-02-28',	'2024-03-01',	'45',	'0',	'4',	'9/D',	3,	'Spor Teacher',	'2024-03-02 19:16:48',	'2024-03-02 19:16:48');

DROP TABLE IF EXISTS `foodlist`;
CREATE TABLE `foodlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day1` text NOT NULL,
  `day2` text NOT NULL,
  `day3` text NOT NULL,
  `day4` text NOT NULL,
  `day5` text NOT NULL,
  `day6` text NOT NULL,
  `day7` text NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `foodlist` (`id`, `day1`, `day2`, `day3`, `day4`, `day5`, `day6`, `day7`, `createdate`, `lastupdate`, `addedunitid`, `addedunitname`) VALUES
(1,	'TARHANA ÇORBA, TAVUK KAVURMA, PEYNİRLİ MİLFÖY, AYRAN',	'KIRMIZI MERC. ÇORBA, KIYMALI TAZE FASULYE, Bulgur Pilavı, ŞEKERPARE',	'YAYLA ÇORBA, PÜRELİ HASAN P. KÖFTE, SEBZELİ MAKARNA, MEYVE',	'ŞEH. TAVUK SUYU ÇORBA, ETLİ KURUFASULYE, SADE PİRİNÇ PİLAVI, KEŞKÜL',	'DOMATES ÇORBA,  MANTARLI ET SOTE, Arpa Şehriyeli Pirinç Pilavı, KARIŞIK SALATA',	'KÖY ÇORBA,  TAS KEBAP,  MISIRLI PİRİÇ PİLAVI	, YOĞURT',	'EZOGELİN ÇORBA, ETLİ FIRIN TÜRLÜ, YOĞURTLU MAKARNA, CEV. TEL KADAYIF',	'2024-02-22 18:20:55',	'2024-03-02 11:36:11',	1,	'Kaan Kaltakkıran');

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
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`schoolid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `informations` (`schoolid`, `schoolname`, `schoolyear`, `schoolterm`, `schoolabout`, `schoolsummary`, `schooladdress`, `addedunitid`, `addedunitname`, `createdate`, `lastupdate`) VALUES
(1,	'School 1',	'2000',	'I',	' School 1 About        ',	'School 1 About Summary        ',	'School 1 About Address        ',	1,	'Kaan Kaltakkıran',	'2024-02-29 20:08:48',	'2024-03-02 11:36:38'),
(2,	'School 2',	'1990',	'II',	'    School 2 About    ',	'    School 2 Summary    ',	'    School 2 Address    ',	2,	'Ahmet Yıldız',	'2024-02-12 20:53:39',	'2024-03-02 11:36:38');

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons` (
  `lessonid` int(11) NOT NULL AUTO_INCREMENT,
  `lessonname` text NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`lessonid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `lessons` (`lessonid`, `lessonname`, `createdate`, `lastupdate`, `addedunitid`, `addedunitname`) VALUES
(1,	'Math',	'2024-01-30 18:12:08',	'2024-03-02 11:36:58',	1,	'Kaan Kaltakkıran'),
(2,	'Spor',	'2024-01-30 18:12:15',	'2024-03-02 11:36:58',	1,	'Kaan Kaltakkıran'),
(3,	'Turkish',	'2024-01-30 18:12:17',	'2024-03-02 11:36:58',	1,	'Kaan Kaltakkıran'),
(4,	'English',	'2024-01-30 18:12:19',	'2024-03-02 11:36:58',	1,	'Kaan Kaltakkıran'),
(5,	'Science',	'2024-01-30 18:12:21',	'2024-03-02 11:36:58',	1,	'Kaan Kaltakkıran');

DROP TABLE IF EXISTS `parents`;
CREATE TABLE `parents` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `useraddress` varchar(100) NOT NULL,
  `phonenumber` varchar(50) NOT NULL,
  `studentid` int(11) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 5,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastlogintime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `birthdate` date NOT NULL,
  `userimg` varchar(255) NOT NULL,
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `parents` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `useraddress`, `phonenumber`, `studentid`, `roleuser`, `createdate`, `lastupdate`, `lastlogintime`, `birthdate`, `userimg`, `addedunitid`, `addedunitname`) VALUES
(1,	'Ali Father',	'alifather@gmail.com',	'$2y$10$BeRSlp5lH/6K3m616IR2KOyXKXNspm/mcSQaZw7caWfJyZIHaCWAC',	'M',	'Address 1',	'05076600843',	1,	5,	'2024-03-05 20:52:27',	'2024-03-05 20:52:27',	'2024-03-10 18:17:05',	'1975-01-01',	'IMG-65e75bdba58a94.69243554.jpg',	1,	'Kaan Kaltakkıran'),
(2,	'Selin Mother',	'selinmother@gmail.com',	'$2y$10$jGmv7b0XYkB3HKyha6uac.1XSA2/HHQfoFLDTYfM5lk3vIL1bl8TS',	'F',	'Address 2',	'13123123123',	2,	5,	'2024-03-05 20:55:10',	'2024-03-05 20:55:10',	'2024-03-10 18:05:47',	'1980-10-12',	'IMG-65e75c7eb526a0.88437860.jpg',	1,	'Kaan Kaltakkıran'),
(3,	'Student 1 Father',	'student1father@gmail.com',	'$2y$10$dju03lLr83vBbrfHwQTpEeG/WkXNyD83e5cx0xSbyEexr515p8sya',	'M',	'Address 3',	'05076601174',	3,	5,	'2024-03-05 20:57:40',	'2024-03-05 20:57:40',	'2024-03-10 19:28:30',	'1975-08-10',	'IMG-65e75d142e1868.42959435.jpg',	1,	'Kaan Kaltakkıran'),
(4,	'Student 2 Mother',	'student2mother@gmail.com',	'$2y$10$5jpi5QuQxjgQogbZV/Esa.kYjauqorv5iHMkHPb6a1gZ9uhYhS9.6',	'F',	'Address 4',	'05043854589',	4,	5,	'2024-03-05 21:00:52',	'2024-03-06 15:27:18',	'2024-03-06 12:27:18',	'1987-05-06',	'IMG-65e86126df4d16.68545243.jpg',	1,	'Kaan Kaltakkıran'),
(5,	'Student 3 Mother',	'student3mother@gmail.com',	'$2y$10$bAgwfkiLUH2vzBQJa..F..lLxfYYftJ0tqDz0sEbs7FPPgRI8ncmq',	'F',	'Address 5',	'05045845984',	5,	5,	'2024-03-05 21:03:47',	'2024-03-05 21:03:47',	'2024-03-05 18:03:47',	'1969-07-05',	'IMG-65e75e83cdafe9.07375785.jpg',	1,	'Kaan Kaltakkıran'),
(6,	'Student 4 Father',	'student4father@gmail.com',	'$2y$10$b8rF.76NjZw49ltBdapil.HABl.daMYezoOzC6/XPHcGzvB00nrKG',	'M',	'Address 6',	'05046454981',	6,	5,	'2024-03-05 21:06:22',	'2024-03-05 21:06:22',	'2024-03-05 18:06:22',	'1973-07-08',	'IMG-65e75f1ee29986.92849517.jpg',	1,	'Kaan Kaltakkıran'),
(7,	'Student 5 Father',	'student5father@gmail.com',	'$2y$10$GW9KxWDn19rjaysFg3OvJuN994hGQsBi4dIikWsb88eYTLSJwgS6K',	'M',	'Address 5',	'05076458498',	7,	5,	'2024-03-07 18:34:17',	'2024-03-07 18:34:17',	'2024-03-07 15:34:17',	'1967-08-01',	'IMG-65e9de79e68888.26558422.jpg',	1,	'Kaan Kaltakkıran');

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `questionid` int(11) NOT NULL AUTO_INCREMENT,
  `questiontitle` varchar(150) NOT NULL,
  `answera` text NOT NULL,
  `answerb` text NOT NULL,
  `answerc` text NOT NULL,
  `answerd` text NOT NULL,
  `trueanswer` text NOT NULL,
  `examid` int(11) NOT NULL,
  `addedid` int(11) NOT NULL,
  `addedname` varchar(50) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`questionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `questions` (`questionid`, `questiontitle`, `answera`, `answerb`, `answerc`, `answerd`, `trueanswer`, `examid`, `addedid`, `addedname`, `createdate`, `lastupdate`) VALUES
(1,	'PHP\'de &quot;echo&quot; ve &quot;print&quot; arasındaki fark nedir?',	'&quot;print&quot; değişkenleri çıktıya yazdırırken &quot;echo&quot; sadece metni çıktılar.',	'&quot;echo&quot; sadece bir değişkeni yazdırırken &quot;print&quot; birden fazla değişkeni yazdırabilir.',	'&quot;echo&quot; daha hızlıdır ve herhangi bir değer döndürmezken &quot;print&quot; bir değer döndürür.',	' &quot;print&quot; metni çift tırnak içinde yazdırırken &quot;echo&quot; tek tırnak içinde yazdırır.',	'&quot;echo&quot; daha hızlıdır ve herhangi bir değer döndürmezken &quot;print&quot; bir değer döndürür.',	1,	1,	'Veli Yıldız',	'2024-02-28 00:00:46',	'2024-03-02 11:40:00'),
(2,	'PHP\'de &quot;include&quot; ve &quot;require&quot; arasındaki fark nedir?',	'&quot;include&quot; dosya bulunamazsa uyarı döndürürken, &quot;require&quot; hata üretir.',	'&quot;include&quot; ile dahil edilen dosya isteğe bağlıdır, &quot;require&quot; ise zorunludur.',	'&quot;include&quot; ile dahil edilen dosya sadece bir kez dahil edilirken, &quot;require&quot; birden fazla kez dahil edilebilir.',	'&quot;include&quot; ile dahil edilen dosyada bir hata oluşursa işlem devam ederken, &quot;require&quot; durumu kontrol eder ve devam etmez',	'&quot;include&quot; dosya bulunamazsa uyarı döndürürken, &quot;require&quot; hata üretir.',	1,	1,	'Veli Yıldız',	'2024-02-28 00:01:45',	'2024-02-28 00:01:45'),
(3,	' PHP\'nin kullanımıyla ilgili hangisi doğrudur?',	'PHP, sadece sunucu taraflı bir betik dili olarak kullanılabilir.',	'PHP, yalnızca Linux işletim sistemi üzerinde çalışabilir.',	'PHP, HTML içine gömülerek web sayfalarının dinamik içeriğini oluşturmak için kullanılabilir.',	'PHP, sadece front-end web geliştirmesi için kullanılır.',	'PHP, HTML içine gömülerek web sayfalarının dinamik içeriğini oluşturmak için kullanılabilir.',	3,	2,	'Ayse Yılmaz',	'2024-02-28 13:02:35',	'2024-02-28 00:02:59'),
(4,	'PHP\'de &quot;GET&quot; ve &quot;POST&quot; metodları arasındaki fark nedir?',	'&quot;GET&quot; metodu, verileri URL\'nin bir parçası olarak gönderirken, &quot;POST&quot; metodu ise HTTP gövdesinde verileri gönderir.',	'&quot;GET&quot; metoduyla sadece metin verileri gönderilirken, &quot;POST&quot; metoduyla dosya da gönderilebilir.',	'&quot;GET&quot; metodu sınırlı miktarda veri gönderirken, &quot;POST&quot; metodu daha fazla veri gönderebilir.',	'&quot;GET&quot; metodu güvenliği artırırken, &quot;POST&quot; metodu güvenlik zafiyetlerine yol açar.',	'&quot;GET&quot; metodu, verileri URL\'nin bir parçası olarak gönderirken, &quot;POST&quot; metodu ise HTTP gövdesinde verileri gönderir.',	3,	2,	'Ayse Yılmaz',	'2024-02-28 13:04:45',	'2024-02-28 00:04:06'),
(5,	'Aşağıdaki uzantılardan hangisi doğru bir PHP dosya uzantısıdır?',	'.cpp',	'.html',	'.css',	'.php',	'.php',	2,	1,	'Veli Yıldız',	'2024-02-29 20:22:36',	'2024-02-29 20:22:36'),
(6,	'PHP\'de &quot;Merhaba Dünya&quot; nasıl yazılır ?',	'Document.Write(&quot;Hello World&quot;);',	'&quot;Hello World&quot;;',	'echo &quot;Merhaba Dünya&quot;;',	'Consol.log(&quot;Merhaba Dünya&quot;);',	'echo &quot;Merhaba Dünya&quot;;',	2,	1,	'Veli Yıldız',	'2024-02-29 20:23:38',	'2024-02-29 20:23:38'),
(7,	'PHP\'deki tüm değişkenler hangi sembolle başlar?',	'$',	'!',	'&amp;',	'?',	'$',	1,	1,	'Veli Yıldız',	'2024-02-29 20:24:29',	'2024-02-29 20:24:29'),
(8,	'Aşağıda yazılan PHP\'nin çalışması ile ilgili açıklamalardan hangisi yanlıştır?',	'Sunucu taraflı çalışır.',	'PHP kodlarının karşığı olan HTML kodları istemciye gönderilir.',	'PHP sayfalarının uzantısı .php\'dir.',	'HTML ve PHP kodları aynı sayfada olamaz.',	'HTML ve PHP kodları aynı sayfada olamaz.',	1,	1,	'Veli Yıldız',	'2024-02-29 20:27:05',	'2024-02-29 20:27:05');

DROP TABLE IF EXISTS `registerunits`;
CREATE TABLE `registerunits` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 2,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastlogintime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `useraddress` varchar(100) NOT NULL,
  `phonenumber` char(11) NOT NULL,
  `birthdate` date NOT NULL,
  `userimg` varchar(255) NOT NULL,
  `adedadminid` int(11) NOT NULL,
  `adedadminname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `registerunits` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `lastupdate`, `lastlogintime`, `useraddress`, `phonenumber`, `birthdate`, `userimg`, `adedadminid`, `adedadminname`) VALUES
(1,	'Kaan Kaltakkıran',	'kaan_fb_aslan@hotmail.com',	'$2y$10$8Lt16VFU4ZHyRGOfW7FA3O2s9G2rJ51.Ih/dnHqSZiJOckffwEQb.',	'M',	2,	'2024-01-30 18:06:22',	'2024-03-02 11:37:41',	'2024-03-10 18:13:09',	'Adress 1',	'05076600884',	'2000-01-01',	'IMG-65b9106edde915.94476959.jpg',	1,	'Admin'),
(2,	'Ahmet Yıldız',	'ahmet@gmail.com',	'$2y$10$gUuy9WL.muHiht7i0Oyh4e/fisBgNIJORR5.bybkKWaeZoPbHavCG',	'M',	2,	'2024-01-30 18:07:09',	'2024-03-02 11:37:41',	'2024-03-04 17:56:08',	'Address 2',	'23123112323',	'1987-01-01',	'IMG-65b9109d6e3128.04596518.png',	1,	'Admin');

DROP TABLE IF EXISTS `results`;
CREATE TABLE `results` (
  `resultid` int(11) NOT NULL AUTO_INCREMENT,
  `examid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `totalquestions` text NOT NULL,
  `totaltrueanswer` text NOT NULL,
  `totalfalseanswer` text NOT NULL,
  `totalscore` varchar(3) NOT NULL,
  `examresult` varchar(6) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`resultid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `results` (`resultid`, `examid`, `userid`, `totalquestions`, `totaltrueanswer`, `totalfalseanswer`, `totalscore`, `examresult`, `createdate`, `lastupdate`) VALUES
(1,	2,	3,	'2',	'2',	'0',	'100',	'Passed',	'2024-03-09 17:07:12',	'2024-03-09 17:47:14'),
(2,	3,	2,	'2',	'1',	'1',	'50',	'Failed',	'2024-03-09 17:08:29',	'2024-03-09 18:00:22');

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `useraddress` varchar(100) NOT NULL,
  `phonenumber` varchar(11) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 4,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastlogintime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `classid` int(11) NOT NULL,
  `classname` varchar(4) NOT NULL,
  `birthdate` date NOT NULL,
  `userimg` varchar(255) NOT NULL,
  `lessonid` text NOT NULL,
  `lessonname` text NOT NULL,
  `addedunitid` int(11) NOT NULL,
  `addedunitname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `students` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `useraddress`, `phonenumber`, `roleuser`, `createdate`, `lastupdate`, `lastlogintime`, `classid`, `classname`, `birthdate`, `userimg`, `lessonid`, `lessonname`, `addedunitid`, `addedunitname`) VALUES
(1,	'Ali Yılmaz',	'ali@gmail.com',	'$2y$10$8frvU6dpcIi/F4KPMSNrVO5aOXgm2GqyyKL7ew2aGJJ67YJHJ5tj2',	'M',	'Address 1',	'05076600884',	4,	'2024-03-05 20:49:58',	'2024-03-07 18:24:26',	'2024-03-10 17:06:42',	6,	'10/B',	'1999-12-23',	'IMG-65e75b469b0850.36446039.png',	'1,3',	'Math,Turkish',	1,	'Kaan Kaltakkıran'),
(2,	'Selin Yıldız',	'selin@gmail.com',	'$2y$10$YUG495d471iU52Reygnmku1Wb5ohFBKgP6BwKJnCqmKUg.tKiyW6W',	'F',	'Address 2',	'12312312312',	4,	'2024-03-05 20:53:49',	'2024-03-05 20:53:49',	'2024-03-10 15:35:06',	10,	'11/B',	'1998-01-01',	'IMG-65e75c2d14ad39.37956423.jpg',	'3',	'Turkish',	1,	'Kaan Kaltakkıran'),
(3,	'Student 1',	'student1@gmail.com',	'$2y$10$GKNyGHgaALdilNtPEOVIBuCjCKg1PU.oft0Fr0M2hRPO7tZZI3TKO',	'M',	'Address 3',	'23123112323',	4,	'2024-03-05 20:56:14',	'2024-03-05 20:56:14',	'2024-03-10 19:19:58',	1,	'9/A',	'1999-10-01',	'IMG-65e75cbea3cb65.35268383.jpg',	'1,3,5',	'Math,Turkish,Science',	1,	'Kaan Kaltakkıran'),
(4,	'Student 2',	'student2@gmail.com',	'$2y$10$ACTIViIKnMD1VrfQ.KX79OYY2DnxU.L6C8pSO3hOIJUFvGHK92bSy',	'F',	'Address 4',	'05058429441',	4,	'2024-03-05 20:59:19',	'2024-03-05 20:59:19',	'2024-03-05 17:59:19',	2,	'9/B',	'1999-04-09',	'IMG-65e75d772c4684.82295265.jpg',	'1,2,3,4,5',	'Math,Spor,Turkish,English,Science',	1,	'Kaan Kaltakkıran'),
(5,	'Student 3',	'student3@gmail.com',	'$2y$10$EXkRoFHvq7t7mgU0w/Nr8ORcZf7vrioFA8F/5UqAEKKmxhw1DzygC',	'M',	'Address 5',	'05054344498',	4,	'2024-03-05 21:02:19',	'2024-03-05 21:02:19',	'2024-03-05 18:02:19',	7,	'10/C',	'1997-06-01',	'IMG-65e75e2b41b5e5.77661806.jpg',	'1,2,3,5',	'Math,Spor,Turkish,Science',	1,	'Kaan Kaltakkıran'),
(6,	'Student 4',	'student4@gmail.com',	'$2y$10$30aN..wMqZH.2y87cHLCies3LGXlOa0FmFsL2xoeCwIUXMzxXvkJm',	'F',	'Address 6',	'05056787676',	4,	'2024-03-05 21:04:49',	'2024-03-05 21:04:49',	'2024-03-05 18:04:49',	9,	'11/A',	'1999-06-02',	'IMG-65e75ec1c00929.50490604.jpg',	'1,3,4',	'Math,Turkish,English',	1,	'Kaan Kaltakkıran'),
(7,	'Student 5',	'student5@gmail.com',	'$2y$10$vBJ6IZDGBufY/xguDbPm8.bvGQ1bSzarEo2u.PHVTGUUZw/Me.8ne',	'M',	'Address 5',	'05056578687',	4,	'2024-03-07 18:31:59',	'2024-03-07 18:31:59',	'2024-03-07 15:31:59',	1,	'9/A',	'1998-01-01',	'IMG-65e9ddef154650.56374619.jpg',	'1,5',	'Math,Science',	1,	'Kaan Kaltakkıran');

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `usergender` char(1) NOT NULL,
  `roleuser` int(11) NOT NULL DEFAULT 3,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastlogintime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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

INSERT INTO `teachers` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `lastupdate`, `lastlogintime`, `classid`, `classname`, `useraddress`, `phonenumber`, `birthdate`, `userimg`, `lessonid`, `lessonname`, `addedunitid`, `addedunitname`) VALUES
(1,	'Veli Yıldız',	'veli@gmail.com',	'$2y$10$F8BOCVniVNOqHhjl7gWf8e5ptBp1wNP.KhGPA3GA9pEJx0hPGEZOm',	'M',	3,	'2024-02-10 12:43:06',	'2024-03-02 12:34:35',	'2024-03-10 15:31:36',	'1,6,11,16',	'9/A,10/B,11/C,12/D',	'Address 1',	'23123112323',	'1975-08-20',	'IMG-65cf8e230c7946.47057921.png',	'1',	'Math',	1,	'Kaan Kaltakkıran'),
(2,	'Ayse Yılmaz',	'ayse@gmail.com',	'$2y$10$a7xTEd88iyzI43udPEmrSeTmxBBaj9nf.JXtJV8NadXoRV1/GGe7q',	'F',	3,	'2024-02-10 12:43:40',	'2024-03-02 11:38:36',	'2024-03-10 14:32:17',	'1,10',	'9/A,11/B',	'Address 2',	'12331223123',	'1980-01-15',	'IMG-65c7454cee1627.24858158.png',	'3',	'Turkish',	1,	'Kaan Kaltakkıran'),
(3,	'Spor Teacher',	'sporteacher@gmail.com',	'$2y$10$9drgD7QvkdJm9HMBMHzg.uDfJfWmGBpNnf5TchsIA2r5VT2x0Dkga',	'F',	3,	'2024-02-29 19:09:23',	'2024-03-02 17:45:31',	'2024-03-09 11:01:28',	'2,4,7,10,13',	'9/B,9/D,10/C,11/B,12/A',	'Address 3',	'05076600889',	'1968-01-01',	'IMG-65e0ac33d8e721.72086549.jpg',	'2',	'Spor',	1,	'Kaan Kaltakkıran'),
(4,	'English Teacher',	'englishteacher@gmail.com',	'$2y$10$F1qye9/3AUWDCT4hzW2Bt.4ZavJlq4PFAc4OtMSMBhbRIrws3vWji',	'F',	3,	'2024-02-29 19:10:39',	'2024-03-05 16:00:37',	'2024-03-06 16:58:42',	'1,2,9,11,16',	'9/A,9/B,11/A,11/C,12/D',	'Address 4',	'12312312312',	'1972-10-10',	'IMG-65e0ac7fbcfa54.07364665.jpg',	'4',	'English',	1,	'Kaan Kaltakkıran'),
(5,	'Science Teacher',	'scienceteacher@gmail.com',	'$2y$10$7VWTS5FjJRZCxkuWQSN94uyYh8gjvHHSXvJx7jK6h4KjBvrmG76Su',	'M',	3,	'2024-02-29 19:12:09',	'2024-03-02 11:38:36',	'2024-03-07 09:52:19',	'1,6,10,13,15',	'9/A,10/B,11/B,12/A,12/C',	'Address 5',	'12312312312',	'1965-07-08',	'IMG-65e0acd98f8b82.08350264.jpg',	'5',	'Science',	1,	'Kaan Kaltakkıran');

-- 2024-03-10 19:29:12
