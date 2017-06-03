-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Sam 03 Juin 2017 à 10:36
-- Version du serveur :  5.6.35
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `artist`
--

-- --------------------------------------------------------

--
-- Structure de la table `covers`
--

CREATE TABLE `covers` (
  `id` int(11) NOT NULL,
  `image` longtext NOT NULL,
  `album` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `covers`
--

INSERT INTO `covers` (`id`, `image`, `album`) VALUES
(1, 'http://images.genius.com/37291e01ab860f66509cc60d0f0c75bf.1000x1000x1.jpg', '4 Your Eyez Only'),
(2, 'https://images.genius.com/7154c6dafd6f6f883c099f033a4aa5e3.1000x1000x1.jpg', 'Forest Hills Drive');

-- --------------------------------------------------------

--
-- Structure de la table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `year` year(4) NOT NULL,
  `duration` varchar(10) NOT NULL,
  `album_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `songs`
--

INSERT INTO `songs` (`id`, `title`, `slug`, `year`, `duration`, `album_id`) VALUES
(1, 'For Whom The Bell Tolls', 'for-whom-the-bell-tolls', 2016, '2:08', 1),
(2, 'Immortal', 'immortal', 2016, '3:22', 1),
(3, 'Deja Vu', 'deja-vu', 2016, '4:25', 1),
(4, 'Ville Mentality', 'ville-mentality', 2016, '3:14', 1),
(5, 'She\'s Mine Pt.1', 'shes-mine-pt-1', 2016, '3:29', 1),
(6, 'Change', 'change', 2016, '5:31', 1),
(7, 'Neighbors', 'neighbors', 2016, '3:29', 1),
(8, 'Foldin Clothes', 'foldin-clothes', 2016, '5:17', 1),
(9, 'She\'s Mine Pt.2', 'shes-mine-pt-2', 2016, '4:39', 1),
(10, '4 Your Eyez Only', '4-your-eyez-only', 2016, '8:50', 1),
(11, 'Intro', 'intro', 2014, '2:29', 2),
(12, 'January 28th', 'january-28th', 2014, '4:03', 2),
(13, 'Wet Dreamz', 'wet-dreamz', 2014, '3:59', 2),
(14, '03 Adolescence ', '03-adolescence ', 2014, '4:24', 2),
(15, 'A Tales of 2 Citiez ', 'a-tales-of-2-citiez', 2014, '4:30', 2),
(16, 'Fire Squad', 'fire-squad', 2014, '4:48', 2),
(17, 'St. Tropez', 'st-tropez', 2014, '4:18', 2),
(18, 'G.O.M.D', 'gomd', 2014, '5:01', 2),
(19, 'No Role Modelz', 'no-role-modelz', 2014, '4:53', 2),
(20, 'Hello', 'hello', 2014, '3:39', 2),
(21, 'Apparently', 'apparently', 2014, '4:53', 2),
(22, 'Love Yourz', 'love-yourz', 2014, '3:32', 2),
(23, 'Note to Self', 'note-to-self', 2014, '14:35', 2);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `covers`
--
ALTER TABLE `covers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `covers`
--
ALTER TABLE `covers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
