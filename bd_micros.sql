-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 15 juin 2023 à 15:59
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_micros`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`ID`, `login`, `mdp`) VALUES
(1, 'admin', 'ed0d6f86a8ed2a0707edd0bcf8b9c916824dea41');

-- --------------------------------------------------------

--
-- Structure de la table `coord_cases`
--

CREATE TABLE `coord_cases` (
  `ID` int(11) NOT NULL,
  `num_case` int(2) NOT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `MIC1` int(11) NOT NULL,
  `MIC2` int(11) NOT NULL,
  `MIC3` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `coord_points`
--

CREATE TABLE `coord_points` (
  `ID` int(11) NOT NULL,
  `ID_mesure` int(11) NOT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `coord_points`
--

INSERT INTO `coord_points` (`ID`, `ID_mesure`, `x`, `y`) VALUES
(1, 1, 0.25, 1.75),
(2, 2, 5.5, 4.5),
(194, 2, 3.5, 2.5);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `coord_cases`
--
ALTER TABLE `coord_cases`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `num_case` (`num_case`);

--
-- Index pour la table `coord_points`
--
ALTER TABLE `coord_points`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `coord_cases`
--
ALTER TABLE `coord_cases`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT pour la table `coord_points`
--
ALTER TABLE `coord_points`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
