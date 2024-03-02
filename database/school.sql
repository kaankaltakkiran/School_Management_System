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
  `userimg` varchar(255) NOT NULL,
  `adedadminid` int(11) NOT NULL,
  `adedadminname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `admins` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `lastupdate`, `userimg`, `adedadminid`, `adedadminname`) VALUES
(1,	'Admin',	'admin@gmail.com',	'$2y$10$KiJGRPAyVQpk5xjkMIXEgO61qgVxRZnNA5qc6hd7vOSMoliu96QqW',	'M',	1,	'2024-01-30 18:00:41',	'2024-03-02 12:28:13',	'IMG-65b90f199e75b6.61068605.jpg',	1,	'Admin'),
(2,	'Admin 2',	'admin2@gmail.com',	'$2y$10$Vl/POjjK9Y5ZVF9b4.jQ5unloIpLDnVg7h77VQkWOkOF/sOA/4GCy',	'F',	1,	'2024-01-30 18:01:43',	'2024-03-02 11:34:02',	'IMG-65b90f57e40c18.69953318.png',	1,	'Admin');

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
(1,	1,	'Kaan Kaltakkıran',	2,	3,	'2024-03-02 12:37:20',	'2024-03-02 12:39:36',	'Register Unit To Teachers',	'2024-02-29',	'2024-03-31',	'1',	'This Announcement Register Unit To Teachers          ',	39),
(2,	1,	'Veli Yıldız',	3,	4,	'2024-02-29 20:09:39',	'2024-03-02 12:37:52',	'Teacher To Students',	'2024-02-29',	'2024-05-01',	'1',	'This Annoucement Teacher To Students',	20),
(3,	1,	'Kaan Kaltakkıran',	2,	4,	'2024-03-02 12:37:20',	'2024-03-02 12:37:52',	'Register Unit To Students',	'2024-02-29',	'2024-04-01',	'0',	'This Annoucement Register Unit To Students',	28);

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

INSERT INTO `exams` (`examid`, `examimg`, `examtitle`, `examdescription`, `examstartdate`, `examenddate`, `examtime`, `ispublish`, `classid`, `classname`, `addedid`, `addedname`, `createdate`, `lastupdate`) VALUES
(1,	'IMG-65d9f46b758223.72202667.jpg',	'Exam 1',	'Exam 1 Description',	'2024-02-29',	'2024-04-01',	'10',	'1',	'6',	'10/B',	1,	'Veli Yıldız',	'2024-02-29 20:41:26',	'2024-02-24 16:51:39'),
(2,	'IMG-65e0bccbe765d9.72184758.jpg',	'Exam 2',	'Exam 2 Description',	'2024-02-29',	'2024-04-29',	'45',	'1',	'1',	'9/A',	1,	'Veli Yıldız',	'2024-02-29 20:20:29',	'2024-02-24 16:53:34'),
(3,	'IMG-65e0c24ce0c1a1.52900404.jpg',	'Exam 3',	'Exam 3 Description',	'2024-02-29',	'2024-04-30',	'60',	'1',	'10',	'11/B',	2,	'Ayse Yılmaz',	'2024-02-29 20:43:40',	'2024-02-24 16:54:14');

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
  `useraddress` varchar(100) NOT NULL,
  `phonenumber` char(11) NOT NULL,
  `birthdate` date NOT NULL,
  `userimg` varchar(255) NOT NULL,
  `adedadminid` int(11) NOT NULL,
  `adedadminname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `registerunits` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `lastupdate`, `useraddress`, `phonenumber`, `birthdate`, `userimg`, `adedadminid`, `adedadminname`) VALUES
(1,	'Kaan Kaltakkıran',	'kaan_fb_aslan@hotmail.com',	'$2y$10$8Lt16VFU4ZHyRGOfW7FA3O2s9G2rJ51.Ih/dnHqSZiJOckffwEQb.',	'M',	2,	'2024-01-30 18:06:22',	'2024-03-02 11:37:41',	'Adress 1',	'05076600884',	'2000-01-01',	'IMG-65b9106edde915.94476959.jpg',	1,	'Admin'),
(2,	'Ahmet Yıldız',	'ahmet@gmail.com',	'$2y$10$gUuy9WL.muHiht7i0Oyh4e/fisBgNIJORR5.bybkKWaeZoPbHavCG',	'M',	2,	'2024-01-30 18:07:09',	'2024-03-02 11:37:41',	'Address 2',	'23123112323',	'1987-01-01',	'IMG-65b9109d6e3128.04596518.png',	1,	'Admin');

DROP TABLE IF EXISTS `results`;
CREATE TABLE `results` (
  `resultid` int(11) NOT NULL AUTO_INCREMENT,
  `examid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `totalquestions` text NOT NULL,
  `totaltrueanswer` text NOT NULL,
  `totalfalseanswer` text NOT NULL,
  `result` varchar(10) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`resultid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `results` (`resultid`, `examid`, `userid`, `totalquestions`, `totaltrueanswer`, `totalfalseanswer`, `result`, `createdate`, `lastupdate`) VALUES
(1,	2,	3,	'2',	'2',	'0',	'Passed',	'2024-02-29 20:31:19',	'2024-02-29 20:31:19'),
(2,	3,	2,	'2',	'1',	'1',	'Failed',	'2024-02-29 20:32:01',	'2024-02-29 20:32:01');

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
  `lastupdate` datetime NOT NULL DEFAULT current_timestamp(),
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

INSERT INTO `students` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `useraddress`, `phonenumber`, `roleuser`, `createdate`, `lastupdate`, `classid`, `classname`, `birthdate`, `userimg`, `parentname`, `parentnumber`, `lessonid`, `lessonname`, `addedunitid`, `addedunitname`) VALUES
(1,	'Ali Yılmaz',	'ali@gmail.com',	'$2y$10$UFHeEWCOJioUY.qdE.71o.egEaETLBqjiYquIYv450X3/PJl7F9fC',	'M',	'Adress 1',	'12331223123',	4,	'2024-01-30 18:13:53',	'2024-03-02 11:38:16',	6,	'10/B',	'2000-01-01',	'IMG-65cf8d6b14ec89.64266568.png',	'Ali Father',	'12331223123',	'1,3',	'Math,Turkish',	1,	'Kaan Kaltakkıran'),
(2,	'Selin Yıldız',	'selin@gmail.com',	'$2y$10$QKjJT6hdDZidt0PE5w0puOJGBpG.AT4HzuXxtnlYIKnLbzsBjHhLO',	'F',	'Address 2',	'31232312132',	4,	'2024-01-30 18:14:25',	'2024-03-02 11:38:16',	10,	'11/B',	'1996-01-01',	'IMG-65b91251666283.15293271.jpg',	'Selin Mother',	'31232312132',	'3',	'Turkish',	1,	'Kaan Kaltakkıran'),
(3,	'Student 1',	'student1@gmail.com',	'$2y$10$Mnmitc7xaYt/4Yv.N1/4wOQeG7HFcW2CwFbLjnV2K8eFFniHSOlmy',	'M',	'Address 3',	'12331223123',	4,	'2024-02-29 19:21:10',	'2024-03-02 11:38:16',	1,	'9/A',	'2000-01-01',	'IMG-65e0aef60f1b43.07278008.jpg',	'Student 1 Father',	'12331223123',	'1,3,5',	'Math,Turkish,Science',	1,	'Kaan Kaltakkıran'),
(4,	'Student 2',	'student2@gmail.com',	'$2y$10$XRl2j6Xul5TMt2s5B.NLEuCkpWAD0Jyu6JRdkKNOFIvoJ648wpBIG',	'F',	'Address 4',	'12312312312',	4,	'2024-02-29 19:32:50',	'2024-03-02 11:38:16',	2,	'9/B',	'2000-10-01',	'IMG-65e0b1b21084d4.16246724.jpg',	'Studnet 2 Mother',	'76546554464',	'1,2,3,4,5',	'Math,Spor,Turkish,English,Science',	1,	'Kaan Kaltakkıran'),
(5,	'Student 3',	'student3@gmail.com',	'$2y$10$56UjhjG9E2ZrwRRjwd9xXOwogOy77fQuCa4pX.m1uDYBAnb1hEwJu',	'M',	'Adress 5',	'23123112323',	4,	'2024-02-29 19:34:13',	'2024-03-02 11:38:16',	7,	'10/C',	'1999-01-01',	'IMG-65e0b205dfb589.02415346.jpg',	'Student 3 Father',	'56678667867',	'1,3,4,5',	'Math,Turkish,English,Science',	1,	'Kaan Kaltakkıran'),
(6,	'Student 6',	'student6@gmail.com',	'$2y$10$fMhOVy.t8vEGs8I5Wh9DYe7gV6cZ/lzDnFY2UBHp1na4CiNBW2nh6',	'F',	'Adress 6',	'12312312312',	4,	'2024-02-29 19:35:32',	'2024-03-02 11:38:16',	9,	'11/A',	'1998-01-01',	'IMG-65e0b254c8f867.54354519.jpg',	'Student 6 Father',	'12331223121',	'1,3,4',	'Math,Turkish,English',	1,	'Kaan Kaltakkıran');

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

INSERT INTO `teachers` (`userid`, `username`, `useremail`, `userpassword`, `usergender`, `roleuser`, `createdate`, `lastupdate`, `classid`, `classname`, `useraddress`, `phonenumber`, `birthdate`, `userimg`, `lessonid`, `lessonname`, `addedunitid`, `addedunitname`) VALUES
(1,	'Veli Yıldız',	'veli@gmail.com',	'$2y$10$F8BOCVniVNOqHhjl7gWf8e5ptBp1wNP.KhGPA3GA9pEJx0hPGEZOm',	'M',	3,	'2024-02-10 12:43:06',	'2024-03-02 12:34:35',	'1,6,11,16',	'9/A,10/B,11/C,12/D',	'Address 1',	'23123112323',	'1975-08-20',	'IMG-65cf8e230c7946.47057921.png',	'1',	'Math',	1,	'Kaan Kaltakkıran'),
(2,	'Ayse Yılmaz',	'ayse@gmail.com',	'$2y$10$a7xTEd88iyzI43udPEmrSeTmxBBaj9nf.JXtJV8NadXoRV1/GGe7q',	'F',	3,	'2024-02-10 12:43:40',	'2024-03-02 11:38:36',	'1,10',	'9/A,11/B',	'Address 2',	'12331223123',	'1980-01-15',	'IMG-65c7454cee1627.24858158.png',	'3',	'Turkish',	1,	'Kaan Kaltakkıran'),
(3,	'Spor Teacher',	'sporteacher@gmail.com',	'$2y$10$9drgD7QvkdJm9HMBMHzg.uDfJfWmGBpNnf5TchsIA2r5VT2x0Dkga',	'F',	3,	'2024-02-29 19:09:23',	'2024-03-02 11:38:36',	'4,7,10,13',	'9/D,10/C,11/B,12/A',	'Address 3',	'05076600889',	'1968-01-01',	'IMG-65e0ac33d8e721.72086549.jpg',	'2',	'Spor',	1,	'Kaan Kaltakkıran'),
(4,	'English Teacher',	'englishteacher@gmail.com',	'$2y$10$RHkpNyJ4JHTQxMKfrcLn0.q8xni0akO9voQtVG0f/ZwlVzRL1QosK',	'F',	3,	'2024-02-29 19:10:39',	'2024-03-02 11:38:36',	'1,2,9,11,16',	'9/A,9/B,11/A,11/C,12/D',	'Address 4',	'12312312312',	'1972-10-10',	'IMG-65e0ac7fbcfa54.07364665.jpg',	'4',	'English',	1,	'Kaan Kaltakkıran'),
(5,	'Science Teacher',	'scienceteacher@gmail.com',	'$2y$10$7VWTS5FjJRZCxkuWQSN94uyYh8gjvHHSXvJx7jK6h4KjBvrmG76Su',	'M',	3,	'2024-02-29 19:12:09',	'2024-03-02 11:38:36',	'1,6,10,13,15',	'9/A,10/B,11/B,12/A,12/C',	'Address 5',	'12312312312',	'1965-07-08',	'IMG-65e0acd98f8b82.08350264.jpg',	'5',	'Science',	1,	'Kaan Kaltakkıran');

-- 2024-03-02 09:40:57