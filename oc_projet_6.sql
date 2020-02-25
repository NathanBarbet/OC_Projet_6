-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 25 fév. 2020 à 10:20
-- Version du serveur :  8.0.18
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `oc_projet_6`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Content` text COLLATE utf8_unicode_ci NOT NULL,
  `Date_publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Tricks_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Tricks_ID` (`Tricks_ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`ID`, `Content`, `Date_publish`, `Tricks_ID`, `User_ID`) VALUES
(23, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut bibendum molestie tortor consequat luctus. Proin eget libero ac nisl rutrum gravida non eget ipsum. Proin tortor diam, mattis at venenatis eget, commodo sed felis. Mauris nibh felis, malesuada at egestas eu, feugiat et mauris. Nulla in neque magna. Pellentesque et felis dignissim, vulputate odio eu, tristique ligula. Donec congue viverra bibendum. Quisque ac metus vitae tortor viverra dictum sodales et massa. Nunc vel tortor est. Phasellus eu dolor interdum, tristique leo nec, lacinia risus. Etiam feugiat facilisis nisl vel viverra. Cras ultrices luctus suscipit.', '2020-02-20 09:30:19', 1, 1),
(24, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut bibendum molestie tortor consequat luctus. Proin eget libero ac nisl rutrum gravida non eget ipsum. Proin tortor diam, mattis at venenatis eget, commodo sed felis. Mauris nibh felis, malesuada at egestas eu, feugiat et mauris. Nulla in neque magna. Pellentesque et felis dignissim, vulputate odio eu, tristique ligula. Donec congue viverra bibendum. Quisque ac metus vitae tortor viverra dictum sodales et massa. Nunc vel tortor est. Phasellus eu dolor interdum, tristique leo nec, lacinia risus. Etiam feugiat facilisis nisl vel viverra. Cras ultrices luctus suscipit.', '2020-02-20 09:30:19', 1, 1),
(25, 'Curabitur vitae consequat augue. Praesent purus lectus, tincidunt ut nibh vel, lacinia hendrerit nisi. Vestibulum hendrerit faucibus nisl, a vestibulum justo. Sed mi odio, tincidunt et congue eu, blandit quis lorem. Praesent eu nisl ultricies, consequat ex in, dapibus erat. Sed rhoncus, nisi at consectetur fringilla, est ipsum fermentum purus, non semper ligula ex sed sem. Integer consequat ante sed sapien sagittis, a vulputate mauris pharetra. Curabitur pretium, turpis eu viverra consequat, libero libero gravida orci, faucibus molestie tortor mi eget velit. Cras semper suscipit orci vel blandit. Nulla eget auctor augue, placerat efficitur nunc. Duis luctus gravida lobortis. Cras ornare sem ipsum, a volutpat arcu porta eu.', '2020-02-20 09:30:39', 1, 1),
(26, 'Super !', '2020-02-20 09:30:39', 1, 1),
(27, 'Sed turpis tortor, convallis ut dolor sit amet, tempor tincidunt purus. Aliquam sit amet vulputate erat, sit amet ullamcorper lacus. Ut vitae malesuada risus.', '2020-02-20 09:30:58', 1, 1),
(28, 'Sed turpis tortor, convallis ut dolor sit amet, tempor tincidunt purus. Aliquam sit amet vulputate erat, sit amet ullamcorper lacus. Ut vitae malesuada risus.', '2020-02-20 09:30:58', 1, 22),
(29, 'Donec mattis tortor in ipsum elementum, et pretium nisl feugiat. Morbi nunc lorem, consequat ut ullamcorper vitae, auctor nec dui.', '2020-02-20 09:31:17', 1, 1),
(30, 'Nulla eget auctor augue, placerat efficitur nunc. Duis luctus gravida lobortis. Cras ornare sem ipsum, a volutpat arcu porta eu.', '2020-02-20 09:31:17', 1, 1),
(31, 'Praesent tincidunt enim sit amet mauris faucibus elementum. Mauris viverra libero et justo luctus, eget finibus sem convallis. Curabitur elementum quam sit amet dolor ullamcorper tempor. Proin non odio sed lectus volutpat laoreet. Donec sed interdum lorem. Curabitur lectus tellus, efficitur vitae sem in, fringilla finibus tellus. Aenean venenatis aliquet ligula malesuada facilisis. ', '2020-02-20 09:31:32', 1, 1),
(32, 'Praesent tincidunt enim sit amet mauris faucibus elementum. Mauris viverra libero et justo luctus, eget finibus sem convallis. Curabitur elementum quam sit amet dolor ullamcorper tempor. Proin non odio sed lectus volutpat laoreet. Donec sed interdum lorem. Curabitur lectus tellus, efficitur vitae sem in, fringilla finibus tellus. Aenean venenatis aliquet ligula malesuada facilisis. ', '2020-02-20 09:31:32', 1, 1),
(34, 'Nullam commodo gravida velit, nec dictum purus lacinia vitae. Sed vehicula enim vitae pretium placerat.', '2020-02-20 09:33:02', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE IF NOT EXISTS `groupe` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Groupe` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`ID`, `Groupe`) VALUES
(1, 'Grab'),
(2, 'Rotation'),
(3, 'Slide'),
(4, 'Flip');

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Image_medias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Date_publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Tricks_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Tricks_ID` (`Tricks_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `medias`
--

INSERT INTO `medias` (`ID`, `Image_medias`, `filename`, `Date_publish`, `Type`, `Tricks_ID`) VALUES
(25, NULL, '5e3c10829dcca973391881.jpg', '2020-02-06 13:11:30', 'image', 1),
(26, NULL, '5e3c109c28758425212066.jpg', '2020-02-06 13:11:56', 'image', 7),
(31, NULL, 'CA5bURVJ5zk', '2020-02-06 14:15:57', 'youtube', 1),
(32, NULL, 'SlhGVnFPTDE', '2020-02-06 14:22:44', 'youtube', 25),
(49, NULL, '5e4e419d70379.jpeg', '2020-02-20 08:21:49', 'image', 44),
(50, NULL, 'KEdFwJ4SWq4', '2020-02-20 08:22:18', 'youtube', 44),
(51, NULL, '5e4e4214b01a0.jpeg', '2020-02-20 08:23:48', 'image', 3);

-- --------------------------------------------------------

--
-- Structure de la table `tricks`
--

DROP TABLE IF EXISTS `tricks`;
CREATE TABLE IF NOT EXISTS `tricks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `Image_home` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Image_background` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_background` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Date_publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date_modify` datetime DEFAULT NULL,
  `Groupe_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `User_ID_Modify` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`),
  KEY `Groupe_ID` (`Groupe_ID`),
  KEY `User_ID` (`User_ID`),
  KEY `User_ID_Modify` (`User_ID_Modify`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tricks`
--

INSERT INTO `tricks` (`ID`, `Name`, `Description`, `Image_home`, `filename`, `Image_background`, `img_background`, `Date_publish`, `Date_modify`, `Groupe_ID`, `User_ID`, `User_ID_Modify`) VALUES
(1, 'Mute Grab', '<p><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">&nbsp;Saisie de la carre&nbsp;</span><em style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">frontside</em><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\"> de la planche entre les deux pieds avec la main avant.</span></p>', NULL, '5e3992777fbb7975241295.jpg', NULL, '5e4e40a7d7d0a.jpeg', '2020-01-28 12:29:56', '2020-02-20 08:31:52', 1, 1, 1),
(2, 'Indy Grab', '<p><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">Saisie de la carre </span><em style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">frontside</em><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">&nbsp;de la planche, entre les deux pieds, avec la main arri&egrave;re.</span></p>', NULL, '5e39972134f16733769499.jpg', NULL, '5e4a51a162c5b.jpeg', '2020-01-30 10:56:25', '2020-02-20 08:24:44', 1, 1, 1),
(3, 'Japan Air', '<p><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">Saisie de l\'avant de la planche, avec la main avant, du c&ocirc;t&eacute; de la carre </span><em style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">frontside</em><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">.</span></p>', NULL, '5e3997794959c472053114.jpg', NULL, '5e4e42099f918.jpeg', '2020-01-30 10:56:25', '2020-02-20 08:24:05', 1, 1, 1),
(4, '180°', '<p><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">Un </span><em style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">180</em><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">&nbsp;d&eacute;signe un demi-tour, soit 180 degr&eacute;s d\'angle.</span></p>', NULL, '5e39982fad98e162781800.jpg', NULL, '5e4e42727a117.jpeg', '2020-01-31 10:04:45', '2020-02-20 08:25:22', 2, 1, 1),
(5, '1080°', '<p>Aussi appeller <em>big foot, </em>3 tours.</p>', NULL, '5e39a638cf28c599838796.jpg', NULL, '5e4e42a548835.jpeg', '2020-01-31 10:05:33', '2020-02-20 08:26:13', 2, 1, 1),
(6, 'Flip', '<p><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">Un&nbsp;</span><strong style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">flip</strong><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">&nbsp;est une rotation verticale.</span></p>', NULL, '5e54e7ab6d825.jpeg', NULL, '5e54e7ab6e0b4.jpeg', '2020-01-31 10:11:01', '2020-02-25 09:23:55', 4, 1, 1),
(7, 'Slide', '<p>U<span style=\"background-color: #ffffff; color: #222222; font-family: sans-serif; font-size: 14px;\">n</span><span style=\"background-color: #ffffff; color: #222222; font-family: sans-serif; font-size: 14px;\">&nbsp;</span><strong style=\"color: #222222; font-family: sans-serif; font-size: 14px;\">slide</strong><span style=\"background-color: #ffffff; color: #222222; font-family: sans-serif; font-size: 14px;\">&nbsp;</span><span style=\"background-color: #ffffff; color: #222222; font-family: sans-serif; font-size: 14px;\">consiste &agrave; glisser sur une barre de slide.</span><span style=\"background-color: #ffffff; color: #222222; font-family: sans-serif; font-size: 14px;\">&nbsp;Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins d&eacute;sax&eacute;.</span></p>\r\n<p style=\"margin: 0.5em 0px; color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">On peut slider avec la planche centr&eacute;e par rapport &agrave; la barre (celle-ci se situe approximativement au-dessous des pieds du rideur), mais aussi en&nbsp;<strong>nose slide</strong>, c\'est-&agrave;-dire l\'avant de la planche sur la barre, ou en&nbsp;<strong>tail slide</strong>, l\'arri&egrave;re de la planche sur la barre.</p>', NULL, '5e39a652dbe1a765212780.jpg', NULL, '5e4e42e44f90d.jpeg', '2020-01-31 10:11:01', '2020-02-20 08:28:23', 3, 1, 1),
(25, 'Back flip', '<p>Un<strong style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\"> back flip </strong>est une<span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">&nbsp;rotations en arri&egrave;re.</span></p>', NULL, '5e54e7bce0f00.jpeg', NULL, '5e54e7bce19e3.jpeg', '2020-02-06 14:21:56', '2020-02-25 09:24:12', 4, 1, 1),
(44, 'Sad Grab', '<p><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">Saisie de la carre </span><em style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">backside</em><span style=\"color: #222222; font-family: sans-serif; font-size: 14px; background-color: #ffffff;\">&nbsp;de la planche, entre les deux pieds, avec la main avant .</span></p>', NULL, '5e4e418acd8ba.jpeg', NULL, '5e4e418ace6e2.jpeg', '2020-02-20 08:21:30', '2020-02-20 08:22:23', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Firstname` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Date_register` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Password` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Admin` tinyint(4) NOT NULL DEFAULT '0',
  `Token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT '0',
  `isValide` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Firstname`, `Email`, `Date_register`, `filename`, `Avatar`, `Password`, `Admin`, `Token`, `isActive`, `isValide`) VALUES
(1, 'Barbet', 'Nathan', 'nathan.barbet@hotmail.fr', '2020-02-04 09:57:57', '5e453caa7c6ad.jpeg', NULL, '$argon2id$v=19$m=65536,t=4,p=1$cDI5ZEFCM2RXUFRobzBIQQ$fcujPUeym0JDiPhlEv4FdHerZN73GaHenUgp4/IoHvw', 1, NULL, 1, 1),
(22, 'Test', 'test', 'test@test.fr', '2020-02-13 18:04:04', '5e459002729d2.jpeg', NULL, '$argon2id$v=19$m=65536,t=4,p=1$NFhseDd1T1I5NGVBNUN6Rw$2B7WoGkMGoEXTuDeHPV8Hj2vtKDcKCoDjKuK0b7oaNw', 0, NULL, 1, 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Comments_Tricks_ID` FOREIGN KEY (`Tricks_ID`) REFERENCES `tricks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Comments_User_ID` FOREIGN KEY (`User_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `Tricks_ID` FOREIGN KEY (`Tricks_ID`) REFERENCES `tricks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD CONSTRAINT `Groupe_ID` FOREIGN KEY (`Groupe_ID`) REFERENCES `groupe` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_ID` FOREIGN KEY (`User_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_ID_Modify` FOREIGN KEY (`User_ID_Modify`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
