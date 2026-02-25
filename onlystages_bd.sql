-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+deb12u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 25 fév. 2026 à 15:44
-- Version du serveur : 10.11.14-MariaDB-0+deb12u2
-- Version de PHP : 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `onlystages_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `ONL_COMPTE`
--

CREATE TABLE `ONL_COMPTE` (
  `COM_ID` smallint(8) NOT NULL,
  `TYPE_COMPTE_ID` smallint(1) NOT NULL,
  `COM_NOM` char(32) DEFAULT NULL,
  `COM_PRENOM` char(32) DEFAULT NULL,
  `COM_MOT_DE_PASSE` char(100) DEFAULT NULL,
  `COM_EMAIL` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ONL_COMPTE`
--

INSERT INTO `ONL_COMPTE` (`COM_ID`, `TYPE_COMPTE_ID`, `COM_NOM`, `COM_PRENOM`, `COM_MOT_DE_PASSE`, `COM_EMAIL`) VALUES
(1, 3, 'ADMIN', 'ADMIN', '$2y$10$UyOkCBXLdqW.Xhjgx7rKyOYZkrOCrBJ78f2ISqQ4nh6eATzS7PLve', 'ADMIN@ADMIN'),
(2, 2, 'ENS', 'ENS', '$2y$10$pS/1rMCZgf9Ng2qK4hFcH.na8JkY4mJzXKghvoqY4Pl2CnuC6ApvG', 'ENS@ENS'),
(3, 1, 'Dupont', 'Jean', '$2y$10$87JuTLFF5jDZSf.6G3fqiO7VJgM8CimvR1Yu2q8hRo8xCg5hiKUEq', 'jean.dupont@etu.unicaen.fr'),
(7, 1, 'Test', 'User', '$2y$10$kimtYP7FHUo1F2FJeu68Me.FMx7OA2F91wcqWhUnmJMuiOo5xYsQ6', 'test@test.com');

-- --------------------------------------------------------

--
-- Structure de la table `ONL_ENTREPRISE`
--

CREATE TABLE `ONL_ENTREPRISE` (
  `SIREN` int(10) NOT NULL,
  `ENT_DATE_CREATION` int(6) NOT NULL,
  `ENT_ACTIVITE` varchar(6) NOT NULL,
  `ENT_CATEGORIE` varchar(3) NOT NULL,
  `ENT_ADRESSE` char(64) DEFAULT NULL,
  `ENT_CODE_POSTAL` int(5) DEFAULT NULL,
  `ENT_VILLE` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ONL_LISTESTAGE`
--

CREATE TABLE `ONL_LISTESTAGE` (
  `LIS_ID` int(5) NOT NULL,
  `LIS_NOM` varchar(32) DEFAULT NULL,
  `LIS_PRENOM` varchar(32) DEFAULT NULL,
  `LIS_DATEDEBUT` date DEFAULT NULL,
  `LIS_DATEFIN` date DEFAULT NULL,
  `LIS_TELETRAVAIL` tinyint(1) DEFAULT NULL,
  `LIS_ENTREPRISE` varchar(64) DEFAULT NULL,
  `LIS_ADRESSE` varchar(64) DEFAULT NULL,
  `LIS_CP` varchar(64) DEFAULT NULL,
  `LIS_VILLE` varchar(64) DEFAULT NULL,
  `LIS_TUTEUR` varchar(64) DEFAULT NULL,
  `LIS_MAILTUTEUR` varchar(64) DEFAULT NULL,
  `LIS_TELTUTEUR` varchar(32) DEFAULT NULL,
  `LIS_SUJET` varchar(128) DEFAULT NULL,
  `LIS_TACHES` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ONL_LISTESTAGE`
--

INSERT INTO `ONL_LISTESTAGE` (`LIS_ID`, `LIS_NOM`, `LIS_PRENOM`, `LIS_DATEDEBUT`, `LIS_DATEFIN`, `LIS_TELETRAVAIL`, `LIS_ENTREPRISE`, `LIS_ADRESSE`, `LIS_CP`, `LIS_VILLE`, `LIS_TUTEUR`, `LIS_MAILTUTEUR`, `LIS_TELTUTEUR`, `LIS_SUJET`, `LIS_TACHES`) VALUES
(55, 'Dubois', 'Marie', '2024-12-12', '2024-12-13', 1, '88 rue des fleurs', 'Orange', '14000', 'Caen', 'Michel', 'marie.dubois@test.com', '663785848', 'Reseau', 'routage, mise em place reseau'),
(56, 'Martin', 'Pierre', '2024-04-04', '2024-06-04', 0, '32 rue de la soif', 'Unither', '50210', 'Coutances', 'Jean Bonbeurre', 'pierre.martin@test.com', '618743366', 'Chaine de production', 'automatisation chaines de prod, usinage'),
(59, 'Leroy', 'Sophie', '2026-04-07', '2026-06-05', 0, 'BMW', 'rue des roses', '14000', 'Lisieux', 'Monsieur BMW', 'sophie.leroy@test.com', '0102030405', 'Dev web', 'Fournir site web');

-- --------------------------------------------------------

--
-- Structure de la table `ONL_STAGE`
--

CREATE TABLE `ONL_STAGE` (
  `STA_ID` int(8) NOT NULL,
  `ENT_ID` int(8) NOT NULL,
  `COM_ID` smallint(8) NOT NULL,
  `STA_DATE_DEBUT` date DEFAULT NULL,
  `SAT_DATE_FIN` date DEFAULT NULL,
  `STA_TELETRAVAIL` tinyint(1) DEFAULT NULL,
  `STA_SUJET` char(64) DEFAULT NULL,
  `STA_TACHES` char(112) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ONL_TYPE_COMPTE`
--

CREATE TABLE `ONL_TYPE_COMPTE` (
  `TYPE_COMPTE_ID` smallint(1) NOT NULL,
  `TYPE_COMPTE_LIBELLE` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ONL_TYPE_COMPTE`
--

INSERT INTO `ONL_TYPE_COMPTE` (`TYPE_COMPTE_ID`, `TYPE_COMPTE_LIBELLE`) VALUES
(1, 'ETUDIANT'),
(2, 'ENSEIGNANT'),
(3, 'ADMINISTRATEUR');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ONL_COMPTE`
--
ALTER TABLE `ONL_COMPTE`
  ADD PRIMARY KEY (`COM_ID`),
  ADD KEY `I_FK_ONL_COMPTE_ONL_TYPE_COMPTE` (`TYPE_COMPTE_ID`);

--
-- Index pour la table `ONL_ENTREPRISE`
--
ALTER TABLE `ONL_ENTREPRISE`
  ADD PRIMARY KEY (`SIREN`);

--
-- Index pour la table `ONL_LISTESTAGE`
--
ALTER TABLE `ONL_LISTESTAGE`
  ADD PRIMARY KEY (`LIS_ID`);

--
-- Index pour la table `ONL_STAGE`
--
ALTER TABLE `ONL_STAGE`
  ADD PRIMARY KEY (`STA_ID`);

--
-- Index pour la table `ONL_TYPE_COMPTE`
--
ALTER TABLE `ONL_TYPE_COMPTE`
  ADD PRIMARY KEY (`TYPE_COMPTE_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ONL_COMPTE`
--
ALTER TABLE `ONL_COMPTE`
  MODIFY `COM_ID` smallint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `ONL_LISTESTAGE`
--
ALTER TABLE `ONL_LISTESTAGE`
  MODIFY `LIS_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `ONL_STAGE`
--
ALTER TABLE `ONL_STAGE`
  MODIFY `STA_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ONL_COMPTE`
--
ALTER TABLE `ONL_COMPTE`
  ADD CONSTRAINT `FK_ONL_COMPTE_ONL_TYPE_COMPTE` FOREIGN KEY (`TYPE_COMPTE_ID`) REFERENCES `ONL_TYPE_COMPTE` (`TYPE_COMPTE_ID`);

--
-- Contraintes pour la table `ONL_STAGE`
--
ALTER TABLE `ONL_STAGE`
  ADD CONSTRAINT `FK_ONL_STAGE_ONL_COMPTE` FOREIGN KEY (`COM_ID`) REFERENCES `ONL_COMPTE` (`COM_ID`),
  ADD CONSTRAINT `FK_ONL_STAGE_ONL_ENTREPRISE` FOREIGN KEY (`ENT_ID`) REFERENCES `ONL_ENTREPRISE` (`SIREN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
