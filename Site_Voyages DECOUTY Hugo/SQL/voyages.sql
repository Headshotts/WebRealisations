-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 23 nov. 2019 à 19:23
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `voyages`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(15) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `mail` varchar(80) DEFAULT NULL,
  `tel` varchar(14) NOT NULL,
  `handicap` char(1) DEFAULT 'N',
  `statut` varchar(5) DEFAULT 'User',
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `id_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `mdp`, `mail`, `tel`, `handicap`, `statut`) VALUES
(13, 'monNom', 'monPrenom', 'monMdp', 'monEmail@gmail.com', '00-00-00-00-00', 'Y', 'User'),
(14, 'Decouty', 'Hugo', 'oui', 'oui@gmail.com', '05-27-16-25-36', 'Y', 'Admin'),
(16, 'Guerry', 'Simon', 'fifa2020', 'rastavroumvroum@gmail.com', '06-47-27-37-16', 'N', 'User'),
(18, 'Juju', 'Baptou', 'mdp', 'jujubaptou@gmail.com', '05-36-21-71-44', 'Y', 'User'),
(23, 'Barbot', 'Antoine', 'antoine', 'coolantoine@gmail.com', '05-37-46-26-36', 'N', 'User'),
(24, 'Barreau', 'Nathan', 'feu', 'nathbarreau@gmail.com', '00-00-01-04-40', 'N', 'User');

-- --------------------------------------------------------

--
-- Structure de la table `destination`
--

DROP TABLE IF EXISTS `destination`;
CREATE TABLE IF NOT EXISTS `destination` (
  `id_destination` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) NOT NULL,
  `description` varchar(300) NOT NULL,
  `transport` varchar(10) DEFAULT 'Autres',
  `nb_places` int(11) NOT NULL,
  `nb_reserves` int(11) NOT NULL DEFAULT '0',
  `prix` decimal(7,2) NOT NULL,
  `handicap` char(1) DEFAULT 'N',
  `image` varchar(250) NOT NULL DEFAULT 'images/image_default.jpg',
  PRIMARY KEY (`id_destination`),
  UNIQUE KEY `id_destination` (`id_destination`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `destination`
--

INSERT INTO `destination` (`id_destination`, `nom`, `description`, `transport`, `nb_places`, `nb_reserves`, `prix`, `handicap`, `image`) VALUES
(1, 'Voyage en Grèce', 'Studiis deterruisset De non quidem artibus cetero video artibus te videri ita deterritum fuisset non qui alios quamquam video videri esse esse tibi studiis fuisset aut eruditi studiis doctrinis enim ita probo ita artibus doctrinis artibus aut cetero aut igitur doctrinis ita instructior a non quod te', 'Avion', 350, 32, '300.00', 'Y', 'images/image_default.jpg'),
(2, 'Voyage en Egypte', 'description2', 'Bateau', 130, 32, '425.00', 'Y', 'images/image_default.jpg'),
(3, 'Voyage au coeur de l\'Amérique', 'description3', 'Avion', 50, 0, '399.99', 'N', 'images/image_default.jpg'),
(4, 'Voyage à travers l\'Amazone', 'description4', 'Route', 100, 0, '599.99', 'Y', 'images/image_default.jpg'),
(5, 'Voyage au Japon', 'description5', 'Avion', 250, 0, '439.99', 'Y', 'images/image_default.jpg'),
(6, 'Voyage Paradisiaque', 'description6', 'Autres', 20, 0, '850.00', 'N', 'images/image_default.jpg'),
(7, 'Voyage à travers la Sibérie', 'description7', 'Train', 140, 0, '499.99', 'N', 'images/image_default.jpg'),
(8, 'Voyage à travers la Belgique', 'description8', 'Train', 400, 390, '40.00', 'Y', 'images/image_default.jpg'),
(9, 'Voyage au coeur du continent africain', 'description9', 'Bateau', 120, 0, '800.00', 'Y', 'images/image_default.jpg'),
(10, 'Voyage en Antarctique', 'description10', 'Bateau', 200, 0, '299.00', 'Y', 'images/image_default.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id_reservation` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `nombre_personnes` int(11) DEFAULT NULL,
  `nb_handicapes` int(11) DEFAULT NULL,
  `nb_billets_Eco` int(11) DEFAULT NULL,
  `nb_billets_Premium` int(11) DEFAULT NULL,
  `nb_billets_Affaires` int(11) DEFAULT NULL,
  `prix` decimal(7,2) NOT NULL,
  `id_destination` bigint(20) UNSIGNED NOT NULL,
  `id_client` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_reservation`),
  UNIQUE KEY `id_reservation` (`id_reservation`),
  KEY `id_destination` (`id_destination`) USING BTREE,
  KEY `id_client` (`id_client`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `date_debut`, `date_fin`, `nombre_personnes`, `nb_handicapes`, `nb_billets_Eco`, `nb_billets_Premium`, `nb_billets_Affaires`, `prix`, `id_destination`, `id_client`) VALUES
(72, '2019-11-30', NULL, 357, 0, 343, 14, 0, '14560.00', 8, 13),
(76, '2019-11-29', NULL, 33, 0, 33, 0, 0, '1320.00', 8, 13),
(79, '2019-11-30', NULL, 32, 0, 0, 32, 0, '14400.00', 1, 14),
(80, '2019-11-26', NULL, 32, 0, 32, 0, 0, '13600.00', 2, 24);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_clients_C` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_dest_C` FOREIGN KEY (`id_destination`) REFERENCES `destination` (`id_destination`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
