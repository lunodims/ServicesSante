-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 13 mai 2024 à 15:21
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `service`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `nom_a` varchar(50) NOT NULL,
  `prenom_a` varchar(50) NOT NULL,
  `adresse_a` varchar(255) DEFAULT NULL,
  `numTel_a` varchar(15) DEFAULT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`idAdmin`, `nom_a`, `prenom_a`, `adresse_a`, `numTel_a`, `idUser`) VALUES
(1, 'Ndiaye', 'Fatou', 'Dakar', '787654321', 1);

-- --------------------------------------------------------

--
-- Structure de la table `infirmier`
--

CREATE TABLE `infirmier` (
  `idInfirmier` int(11) NOT NULL,
  `nom_i` varchar(50) NOT NULL,
  `prenom_i` varchar(50) NOT NULL,
  `adresse_i` varchar(255) DEFAULT NULL,
  `specialite_i` varchar(100) DEFAULT NULL,
  `numTel_i` varchar(15) DEFAULT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `infirmier`
--

INSERT INTO `infirmier` (`idInfirmier`, `nom_i`, `prenom_i`, `adresse_i`, `specialite_i`, `numTel_i`, `idUser`) VALUES
(1, 'Diallo', 'Massata', 'Castors', 'dentiste', '782914781', 6);

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `idMedecin` int(11) NOT NULL,
  `nom_m` varchar(50) NOT NULL,
  `prenom_m` varchar(50) NOT NULL,
  `adresse_m` varchar(255) DEFAULT NULL,
  `grade_m` varchar(50) DEFAULT NULL,
  `specialite_m` varchar(100) DEFAULT NULL,
  `numTel_m` varchar(15) DEFAULT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`idMedecin`, `nom_m`, `prenom_m`, `adresse_m`, `grade_m`, `specialite_m`, `numTel_m`, `idUser`) VALUES
(1, 'Diop', 'Pape Maguette', 'Mbao', 'docteur', 'Cardiologue', '789876543', 5),
(2, 'Dime', 'Alioune', 'Keur Massar', 'Docteur', 'Dentiste', '776543212', 3),
(3, 'Diallo', 'Moustapha', 'Mbao', 'docteur', 'ophtalmologue', '778307656', 2),
(4, 'Gueye', 'Yacine', 'sicap', 'Docteur', 'cardiologue', '77908987', 4);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `idPatient` int(11) NOT NULL,
  `nom_p` varchar(50) NOT NULL,
  `prenom_p` varchar(50) NOT NULL,
  `adresse_p` varchar(255) DEFAULT NULL,
  `numTel_p` varchar(15) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  `email_p` varchar(50) NOT NULL,
  `password_p` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`idPatient`, `nom_p`, `prenom_p`, `adresse_p`, `numTel_p`, `idUser`, `email_p`, `password_p`) VALUES
(1, 'Ndiaye', 'Coumba', NULL, NULL, 12, 'coumbandiaye@esp.sn', 'passer'),
(2, 'Ndiaye', 'Coumba', NULL, NULL, 13, 'coumbandiaye@esp.sn', 'passer');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `idRendezvous` int(11) NOT NULL,
  `idMedecin` int(11) DEFAULT NULL,
  `idPatient` int(11) DEFAULT NULL,
  `date_rdv` date DEFAULT NULL,
  `heure_rdv` time DEFAULT NULL,
  `description_rdv` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`idRendezvous`, `idMedecin`, `idPatient`, `date_rdv`, `heure_rdv`, `description_rdv`) VALUES
(1, 3, 1, '2024-05-23', '15:00:00', 'maladie'),
(2, 3, 1, '2024-05-23', '15:00:00', 'maladie'),
(3, 1, 1, '2024-05-23', '15:00:00', 'hemoragie');

-- --------------------------------------------------------

--
-- Structure de la table `secretaire`
--

CREATE TABLE `secretaire` (
  `idSecretaire` int(11) NOT NULL,
  `nom_s` varchar(50) NOT NULL,
  `prenom_s` varchar(50) NOT NULL,
  `adresse_s` varchar(255) DEFAULT NULL,
  `numTel_s` varchar(15) DEFAULT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `typeUser` enum('medecin','infirmier','patient','secretaire','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `username`, `password`, `typeUser`) VALUES
(1, 'FatouNdiaye', 'passer', 'admin'),
(2, 'MoustaphaDiallo', 'passer', 'medecin'),
(3, 'AliouneDime', 'passer', 'medecin'),
(4, 'YacineGueye', 'passer', 'medecin'),
(5, 'PapeMaguetteDiop', 'passer', 'medecin'),
(6, 'MassataDiallo', 'passer', 'infirmier'),
(7, 'PapeKasse', 'passer', 'secretaire'),
(8, 'CoumbaNdiaye', 'passer', 'patient'),
(9, 'CoumbaNdiaye', 'passer', 'patient'),
(10, 'CoumbaNdiaye', 'passer', 'patient'),
(11, 'CoumbaNdiaye', 'passer', 'patient'),
(12, 'CoumbaNdiaye', 'passer', 'patient'),
(13, 'CoumbaNdiaye', 'passer', 'patient');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `infirmier`
--
ALTER TABLE `infirmier`
  ADD PRIMARY KEY (`idInfirmier`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`idMedecin`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`idPatient`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`idRendezvous`),
  ADD KEY `idMedecin` (`idMedecin`),
  ADD KEY `idPatient` (`idPatient`);

--
-- Index pour la table `secretaire`
--
ALTER TABLE `secretaire`
  ADD PRIMARY KEY (`idSecretaire`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `infirmier`
--
ALTER TABLE `infirmier`
  MODIFY `idInfirmier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `idMedecin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `idPatient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `idRendezvous` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `secretaire`
--
ALTER TABLE `secretaire`
  MODIFY `idSecretaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `infirmier`
--
ALTER TABLE `infirmier`
  ADD CONSTRAINT `infirmier_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD CONSTRAINT `medecin_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `patient`
--
  ALTER TABLE `patient`
    ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`idMedecin`),
  ADD CONSTRAINT `rendezvous_ibfk_2` FOREIGN KEY (`idPatient`) REFERENCES `patient` (`idPatient`);

--
-- Contraintes pour la table `secretaire`
--
ALTER TABLE `secretaire`
  ADD CONSTRAINT `secretaire_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
