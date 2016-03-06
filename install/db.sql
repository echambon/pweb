-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 06 Mars 2016 à 15:54
-- Version du serveur :  5.6.28-0ubuntu0.15.10.1
-- Version de PHP :  5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `emmanuel-chambon-prod`
--

-- --------------------------------------------------------

--
-- Structure de la table `pw_config`
--

CREATE TABLE IF NOT EXISTS `pw_config` (
  `id` int(8) NOT NULL,
  `val` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pw_config`
--

INSERT INTO `pw_config` (`id`, `val`) VALUES
(1, '2016/02/01'),
(2, 'John Smith'),
(3, 'Researcher'),
(4, 'admin'),
(5, '$2y$10$sIg4w2oNvi6eMxdMX4eoFens19StiQBApcr1sCKFqBtm6KVb8F/MW'),
(6, 'john@smith.com'),
(7, 'id.png'),
(8, '&lt;p&gt;&lt;b&gt;Welcome on my contact page!&lt;/b&gt;&lt;/p&gt;&lt;p&gt;\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel \r\nsapien lorem. Aenean porttitor tellus orci, sit amet varius elit ornare \r\nnec. Fusce sagittis pretium ultricies. Pellentesque in neque blandit, \r\nhendrerit nulla vitae, sodales mi. Donec porta massa elementum sapien \r\nlobortis vestibulum. Aliquam blandit sodales turpis. Sed non ex ut \r\nlectus mattis efficitur. Praesent a dignissim justo. Aenean nulla nisl, \r\neuismod eget neque in, pulvinar placerat mauris. Aenean id augue mattis,\r\n gravida purus ut, imperdiet felis. Mauris laoreet congue nisl, sit amet\r\n pulvinar tellus elementum eget. Pellentesque tincidunt, turpis vitae \r\nefficitur ultricies, erat dolor convallis turpis, non condimentum felis \r\nmagna ac sem. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n&lt;/p&gt;&lt;p&gt;\r\nVestibulum ornare leo urna, vel vehicula risus finibus id. Cras auctor \r\nluctus lectus non tincidunt. Praesent interdum, nulla sed commodo \r\nsollicitudin, risus massa laoreet eros, at molestie nisi elit id lorem. \r\nVestibulum vitae magna ac mi lacinia posuere. Maecenas ipsum lectus, \r\nposuere dignissim fermentum non, maximus a velit. Mauris maximus ante \r\nvel sapien ultrices fringilla. Sed vestibulum vitae risus ut faucibus. \r\nSed lacinia et sem at gravida. Aenean iaculis, lectus ut laoreet \r\nimperdiet, tellus neque varius turpis, a vehicula mauris mi id nunc. \r\nInteger sed purus pulvinar, ultricies mauris sed, fringilla est. &lt;/p&gt;&lt;p&gt;&lt;b&gt;Ceci est un essai&lt;/b&gt;&lt;/p&gt;&lt;p&gt;Prout prout I&#039;m&lt;/p&gt;'),
(9, 'pweb');

-- --------------------------------------------------------

--
-- Structure de la table `pw_pages`
--

CREATE TABLE IF NOT EXISTS `pw_pages` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pw_pages`
--

INSERT INTO `pw_pages` (`id`, `name`, `content`) VALUES
(0, 'Publications', '');

-- --------------------------------------------------------

--
-- Structure de la table `pw_pages_order`
--

CREATE TABLE IF NOT EXISTS `pw_pages_order` (
  `id` int(8) NOT NULL,
  `page_id` int(8) NOT NULL,
  `order_menu` int(8) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `protected` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pw_pages_order`
--

INSERT INTO `pw_pages_order` (`id`, `page_id`, `order_menu`, `hidden`, `disabled`, `protected`) VALUES
(2, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `pw_publis`
--

CREATE TABLE IF NOT EXISTS `pw_publis` (
  `id` int(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` int(8) NOT NULL,
  `status` int(8) NOT NULL,
  `authors` varchar(255) NOT NULL,
  `source` text NOT NULL,
  `pages` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `address` text NOT NULL,
  `month` int(8) NOT NULL,
  `year` int(8) NOT NULL,
  `abstract` text NOT NULL,
  `bibtex_id` varchar(255) NOT NULL,
  `pdf` text NOT NULL,
  `pdfslides` text NOT NULL,
  `zipfile` text NOT NULL,
  `disabled` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `pw_config`
--
ALTER TABLE `pw_config`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pw_pages`
--
ALTER TABLE `pw_pages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pw_pages_order`
--
ALTER TABLE `pw_pages_order`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pw_publis`
--
ALTER TABLE `pw_publis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `pw_pages`
--
ALTER TABLE `pw_pages`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `pw_pages_order`
--
ALTER TABLE `pw_pages_order`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `pw_publis`
--
ALTER TABLE `pw_publis`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
