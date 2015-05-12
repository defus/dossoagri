-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 11 Mai 2015 à 23:05
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `dossoagri`
--
CREATE DATABASE IF NOT EXISTS `dossoagri` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dossoagri`;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(32) NOT NULL,
  `Role` enum('OPERATEUR','SUPERUTILISATEUR','ALERT','AGRICULTEUR','ACHETEUR') NOT NULL DEFAULT 'OPERATEUR',
  `record_id` int(11) NOT NULL,
  PRIMARY KEY (`RoleID`),
  KEY `record_id` (`record_id`),
  KEY `roles_ibfk_2` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`RoleID`, `Username`, `Role`, `record_id`) VALUES
(1, 'agri', 'OPERATEUR', 1),
(5, 'agri', '', 2),
(11, 'agri', 'OPERATEUR', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `UtilisateurID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `Mail` varchar(100) DEFAULT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`UtilisateurID`),
  UNIQUE KEY `identifiant` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`UtilisateurID`, `Username`, `password`, `Mail`, `isadmin`, `remember_token`) VALUES
(1, 'admin', 'c8520774f9240cfe9d240d2ee7b9fb1f', NULL, 1, 'ZTI8VI8kvGd7gEYCZUZUUEgpPpP6wvfQoz190NNkqHaGCyvYvsKxqNdD5m59'),
(2, 'Utilisateur_test', 'd8578edf8458ce06fbc5bb76a58c5ca4', NULL, 0, NULL),
(3, 'agri', 'c8520774f9240cfe9d240d2ee7b9fb1f', '', 0, 'my930wN8mKrUn5KcEFfGxef5wqJ3LGYCxr7CiIvZg2AlZ9XUu30FKhXxnWxw'),
(5, 'test', '', NULL, 0, NULL),
(7, 'test1', '', 'me@test.com', 0, NULL),
(8, 'test2', '', 'me@test.com', 1, NULL),
(9, 'aaa', '08f8e0260c64418510cefb2b06eee5cd', 'me@test.com', 1, '9CxfWZG5NdGVN2ZEkEBnQgF7TF7LdJ6f4wTXaEuxqI6kPRRasrA6FkQiQpLQ'),
(10, 'Tree lll mmo', '361228d0a65bd2355b029b2fe0aad7c6', 'tree@tree.com', 0, NULL);
