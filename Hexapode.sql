-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 03 fév. 2022 à 15:04
-- Version du serveur :  8.0.27-0ubuntu0.20.04.1
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Hexapode`
--

-- --------------------------------------------------------

--
-- Structure de la table `Mvt`
--

CREATE TABLE `Mvt` (
  `idMvt` int NOT NULL,
  `idPARCOURS` int NOT NULL,
  `CodeMvt` varchar(3) NOT NULL,
  `TimingMvt` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Mvt`
--

INSERT INTO `Mvt` (`idMvt`, `idPARCOURS`, `CodeMvt`, `TimingMvt`) VALUES
(1, 1, '1A', 1),
(2, 1, '1B', 1),
(3, 1, '1C', 2),
(4, 1, '1D', 3),
(5, 1, '1E', 3);

-- --------------------------------------------------------

--
-- Structure de la table `PARCOURS`
--

CREATE TABLE `PARCOURS` (
  `idPARCOURS` int NOT NULL,
  `idUtilisateur` int NOT NULL,
  `idMvt` int NOT NULL,
  `NomParcours` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `PARCOURS`
--

INSERT INTO `PARCOURS` (`idPARCOURS`, `idUtilisateur`, `idMvt`, `NomParcours`) VALUES
(1, 1, 1, 'Test');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `idUtilisateur` int NOT NULL,
  `Identifiant` int NOT NULL,
  `Mdp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='	';

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`idUtilisateur`, `Identifiant`, `Mdp`) VALUES
(1, 1, 'paul'),
(2, 2, 'fathy'),
(3, 3, 'rayan'),
(4, 4, 'louis');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Mvt`
--
ALTER TABLE `Mvt`
  ADD PRIMARY KEY (`idMvt`),
  ADD KEY `idPARCOURS_idx` (`idPARCOURS`);

--
-- Index pour la table `PARCOURS`
--
ALTER TABLE `PARCOURS`
  ADD PRIMARY KEY (`idPARCOURS`),
  ADD KEY `idUtilisateur_idx` (`idUtilisateur`),
  ADD KEY `idMvt_idx` (`idMvt`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Mvt`
--
ALTER TABLE `Mvt`
  MODIFY `idMvt` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `PARCOURS`
--
ALTER TABLE `PARCOURS`
  MODIFY `idPARCOURS` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `idUtilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Mvt`
--
ALTER TABLE `Mvt`
  ADD CONSTRAINT `idParcours` FOREIGN KEY (`idPARCOURS`) REFERENCES `PARCOURS` (`idPARCOURS`);

--
-- Contraintes pour la table `PARCOURS`
--
ALTER TABLE `PARCOURS`
  ADD CONSTRAINT `idMvt` FOREIGN KEY (`idMvt`) REFERENCES `Mvt` (`idMvt`),
  ADD CONSTRAINT `idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`idUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
