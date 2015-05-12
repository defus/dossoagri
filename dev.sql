-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 12 Mai 2015 à 07:22
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `dossoagri`
--
CREATE DATABASE IF NOT EXISTS `dossoagri` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dossoagri`;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(32) NOT NULL,
  `Role` enum('OPERATEUR','SUPERUTILISATEUR','ALERT','AGRICULTEUR','ACHETEUR','PARTENAIRE') NOT NULL DEFAULT 'OPERATEUR',
  PRIMARY KEY (`RoleID`),
  KEY `roles_ibfk_2` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`RoleID`, `Username`, `Role`) VALUES
(11, 'agri', 'OPERATEUR'),
(12, 'vend1', 'OPERATEUR'),
(13, 'part1', 'OPERATEUR');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `UtilisateurID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `Mail` varchar(100) DEFAULT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`UtilisateurID`),
  UNIQUE KEY `identifiant` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`UtilisateurID`, `Username`, `password`, `Mail`, `isadmin`, `remember_token`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@dossoagri.com', 1, 'vbso8SrsKX6A2ndmaQOjIkzn38LRAl0WmgpTttgNjKV2Doj0RxXlK697zSqb'),
(3, 'agri1', '41c54f22770240ebaa4c69902e8bb54b', 'agri1@dossoagri.com', 0, 'my930wN8mKrUn5KcEFfGxef5wqJ3LGYCxr7CiIvZg2AlZ9XUu30FKhXxnWxw'),
(11, 'vend1', 'faf315ac71cc8ac07143c30f86655096', 'vend1@dossoagri.com', 0, NULL),
(12, 'part1', 'ffc88b4ca90a355f8ddba6b2c3b2af5c', 'part1@dossoagri.com', 0, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
