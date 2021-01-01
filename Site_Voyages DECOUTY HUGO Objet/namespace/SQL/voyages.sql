-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 15 déc. 2019 à 15:30
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
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `idclient` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(15) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `tel` varchar(14) NOT NULL,
  `handicap` char(1) DEFAULT 'N',
  `statut` varchar(5) DEFAULT 'User',
  PRIMARY KEY (`idclient`),
  UNIQUE KEY `id_client` (`idclient`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idclient`, `nom`, `prenom`, `mdp`, `mail`, `tel`, `handicap`, `statut`) VALUES
(13, 'monNom', 'monPrenom', 'monMdp', 'monEmail@gmail.com', '00-00-00-00-00', 'Y', 'User'),
(14, 'Decouty', 'Hugo', 'oui', 'oui@gmail.com', '00-12-03-01-06', 'Y', 'Admin'),
(16, 'Guerry', 'Simon', 'fifa2020', 'rastavroumvroum@gmail.com', '06-47-27-37-16', 'N', 'User'),
(18, 'Juju', 'Baptou', 'mdp', 'jujubaptou@gmail.com', '05-36-21-71-44', 'Y', 'User'),
(23, 'Barbot', 'Antoine', 'antoine', 'coolantoine@gmail.com', '05-37-46-26-36', 'N', 'User'),
(24, 'Barreau', 'Nathan', 'feu', 'nathbarreau@gmail.com', '00-00-01-04-40', 'N', 'User'),
(25, 'Decouty', 'Hugo', 'oui', 'hugo@gmail.com', '00-02-04-06-08', 'N', 'User');

-- --------------------------------------------------------

--
-- Structure de la table `destination`
--

DROP TABLE IF EXISTS `destination`;
CREATE TABLE IF NOT EXISTS `destination` (
  `iddestination` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) NOT NULL,
  `description` varchar(300) NOT NULL,
  `transport` varchar(10) DEFAULT 'Autres',
  `nbplaces` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `handicap` char(1) DEFAULT 'N',
  `image` varchar(250) NOT NULL DEFAULT 'images/image_default.jpg',
  PRIMARY KEY (`iddestination`),
  UNIQUE KEY `id_destination` (`iddestination`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `destination`
--

INSERT INTO `destination` (`iddestination`, `nom`, `description`, `transport`, `nbplaces`, `prix`, `handicap`, `image`) VALUES
(1, 'Voyage en Grèce', 'Profitez d’un voyage reposant à bord du B16, dernier avion de Boing, avec une vue à couper le souffle sur l’île de Santorin. Vous aurez aussi des activités ludiques autour de la Grèce, sa culture, son histoire, notamment un expert de la Grèce qui racontera les plus belles anecdotes grecques.', 'Avion', 350, '300.00', 'Y', 'images/greace-ile de santorin.jpg'),
(2, 'Voyage en Egypte', 'Découvrez l’Égypte à bord d’un bus touristique, accompagné des meilleurs guides de la région qui vous feront part de l’histoire de l’Égypte, et de certaines anecdotes sur celle-ci. Découvrez notamment le Sphynx et la Pyramide de Kheops, grands trésors architecturaux de l’Égypte.', 'Route', 70, '425.00', 'Y', 'images/egyptian-sphinx.jpg'),
(3, 'Voyage au coeur de l\'Amérique', 'Make America Great Again. Admirez les magnifiques paysages américains à bord du B16, dernier avion de Boing, avec des activités pour petits et grands, et un service de qualité. Parmi les richesses américaines à découvrir : le Colorado River et le Mississipi, splendides fleuves américains ! ', 'Avion', 50, '399.99', 'Y', 'images/american-Colorado river.jpg'),
(4, 'Voyage à travers l\'Amazonie', 'Contemplez l’Amazonie, trésor naturel du Brésil qui respire l’aventure et la beauté. À bord de barques prévues pour l’expédition, vous pourrez profiter d’anecdotes auprès de guides spécialisés dans la visite de l’Amazonie. Provisions telles que l’eau et la nourriture prévues dans le prix du voyage.', 'Bateau', 100, '599.99', 'Y', 'images/amazone- district de puyo.jpg'),
(5, 'Voyage au Japon', 'N’aviez-vous jamais voulu visiter le Japon de nuit ? Maintenant, le rêve devient réalité. Appréciez la magnifique vue de Tokyo, de Yokohama, de Kyoto et de Osaka de nuit. Vous pourrez discuter avec des bénévoles japonais, venu vous faire découvrir leurs vies et les traditions japonaises.', 'Avion', 250, '439.99', 'Y', 'images/japan-bouddhanist temple.jpg'),
(6, 'Voyage Paradisiaque', 'Découvrez Hawaï et ses magnifiques plages. Vous pourrez notamment admirer la plage de Kona et l’île de O’ahu, contenant la plage de Waikiki et la capitale locale : Honolulu. Pour les personnes Premium et Affaires, profiter de quelques heures sur la plage de Kona, avant de continuer le périple.', 'Bateau', 30, '850.00', 'N', 'images/paradise-Kona Plage Hawai.jpg'),
(7, 'Voyage à travers la Sibérie', 'Contemplez la vaste province russe, composée de toundra, de forêts et de conifères et de chaînes de montagnes comme l’Altaï. Vous découvrirez aussi le lac Baïkal, réputé pour ses randonnées avec une vue splendide, ainsi que la ville de Iekaterinbourg, incluant la très célèbre Sevastyanov\'s House.', 'Avion', 140, '499.99', 'Y', 'images/siberian - altai.jpg'),
(8, 'Voyage à travers la Belgique', 'Admirez la magnifique ville de Bruxelles, de nuit dans le TranSmart, en compagnie de bénévoles bruxellois qui vous feront découvrir la Belgique par leur vie et leur culture. Ainsi, vous découvrirez la banque de Bruxelles, l’Atomium, l’hôtel de ville, et plein d’autres monuments.', 'Train', 400, '40.00', 'Y', 'images/belgian - bruxelles.jpg'),
(9, 'Voyage au coeur du continent africain', 'Explorez l’Afrique en sillonnant les routes célébres africaines et découvrez la faune et la flore qui vivent sur ce magnifique continent. Vous pourrez découvrir notamment le Rwanda, pays des milles Collines, ainsi que le Mozambique et l’archipel de Bazaruto, sans oublier les plaines de l’Ouganda.', 'Route', 120, '800.00', 'N', 'images/african - safari.jpg'),
(10, 'Voyage en Antarctique', 'Découvrez l’Antarctique, ou « le continent blanc », et sa beauté naturelle que l’on ne retrouve nulle part ailleurs. Admirez la faune unique. Équipement offert pour les personnes Premium et Affaires. Une activité avec des bénévoles est disponible en cours d’expédition.', 'Bateau', 200, '299.00', 'N', 'images/antarctic- Neco Bay fjord.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `idreservation` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `datedebut` date NOT NULL,
  `nombrepersonnes` int(11) NOT NULL DEFAULT '0',
  `nbhandicapes` int(11) DEFAULT NULL,
  `nbbilletsEco` int(11) DEFAULT NULL,
  `nbbilletsPremium` int(11) DEFAULT NULL,
  `nbbilletsAffaires` int(11) DEFAULT NULL,
  `prix` decimal(14,2) NOT NULL,
  `iddestination` bigint(20) UNSIGNED NOT NULL,
  `idclient` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`idreservation`),
  UNIQUE KEY `id_reservation` (`idreservation`),
  KEY `id_destination` (`iddestination`) USING BTREE,
  KEY `id_client` (`idclient`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`idreservation`, `datedebut`, `nombrepersonnes`, `nbhandicapes`, `nbbilletsEco`, `nbbilletsPremium`, `nbbilletsAffaires`, `prix`, `iddestination`, `idclient`) VALUES
(106, '2019-12-26', 350, 0, 0, 350, 0, '157500.00', 1, 14),
(113, '2019-12-28', 23, 0, 23, 0, 0, '9775.00', 2, 14),
(121, '2019-12-27', 5, 2, 2, 3, 0, '2762.50', 2, 14),
(127, '2019-12-24', 12, 0, 12, 0, 0, '10200.00', 6, 14),
(129, '2019-12-18', 21, 1, 1, 2, 18, '16015.64', 5, 14);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservations_clients_C` FOREIGN KEY (`idclient`) REFERENCES `client` (`idclient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_dest_C` FOREIGN KEY (`iddestination`) REFERENCES `destination` (`iddestination`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
