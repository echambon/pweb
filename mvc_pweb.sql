-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 28 Février 2016 à 14:57
-- Version du serveur :  5.6.28-0ubuntu0.15.10.1
-- Version de PHP :  5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mvc_pweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `pw_config`
--

CREATE TABLE IF NOT EXISTS `pw_config` (
  `id` int(11) NOT NULL,
  `val` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pw_config`
--

INSERT INTO `pw_config` (`id`, `val`) VALUES
(1, 'John Smith'),
(2, 'Researcher'),
(3, 'john@smith.com'),
(4, 'pweb,cms'),
(5, '2016/02/01'),
(6, '&lt;p&gt;&lt;b&gt;Welcome on my contact page!&lt;/b&gt;&lt;/p&gt;&lt;p&gt;\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel \r\nsapien lorem. Aenean porttitor tellus orci, sit amet varius elit ornare \r\nnec. Fusce sagittis pretium ultricies. Pellentesque in neque blandit, \r\nhendrerit nulla vitae, sodales mi. Donec porta massa elementum sapien \r\nlobortis vestibulum. Aliquam blandit sodales turpis. Sed non ex ut \r\nlectus mattis efficitur. Praesent a dignissim justo. Aenean nulla nisl, \r\neuismod eget neque in, pulvinar placerat mauris. Aenean id augue mattis,\r\n gravida purus ut, imperdiet felis. Mauris laoreet congue nisl, sit amet\r\n pulvinar tellus elementum eget. Pellentesque tincidunt, turpis vitae \r\nefficitur ultricies, erat dolor convallis turpis, non condimentum felis \r\nmagna ac sem. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n&lt;/p&gt;&lt;p&gt;\r\nVestibulum ornare leo urna, vel vehicula risus finibus id. Cras auctor \r\nluctus lectus non tincidunt. Praesent interdum, nulla sed commodo \r\nsollicitudin, risus massa laoreet eros, at molestie nisi elit id lorem. \r\nVestibulum vitae magna ac mi lacinia posuere. Maecenas ipsum lectus, \r\nposuere dignissim fermentum non, maximus a velit. Mauris maximus ante \r\nvel sapien ultrices fringilla. Sed vestibulum vitae risus ut faucibus. \r\nSed lacinia et sem at gravida. Aenean iaculis, lectus ut laoreet \r\nimperdiet, tellus neque varius turpis, a vehicula mauris mi id nunc. \r\nInteger sed purus pulvinar, ultricies mauris sed, fringilla est.\r\n&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Structure de la table `pw_menu`
--

CREATE TABLE IF NOT EXISTS `pw_menu` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `order_menu` int(11) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `protected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pw_pages`
--

CREATE TABLE IF NOT EXISTS `pw_pages` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pw_pages`
--

INSERT INTO `pw_pages` (`id`, `name`, `url`, `content`) VALUES
(1, 'testpage', 'testpage', '&lt;h1&gt;This is a testpage&lt;/h1&gt;&lt;p&gt;Test page. Test.&lt;/p&gt;&lt;h2&gt;Heading 2 test&lt;/h2&gt;&lt;p&gt;this is a test&lt;/p&gt;&lt;h3&gt;Heading 3 test&lt;/h3&gt;&lt;p&gt;\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam mauris \r\nleo, eleifend eget tincidunt nec, dictum sit amet magna. Sed diam urna, \r\naliquam ut tortor ac, commodo egestas quam. Proin ornare euismod tempor.\r\n Nunc luctus lacus a orci elementum rhoncus. Suspendisse mi mauris, \r\naccumsan nec est in, viverra sollicitudin enim. Nulla tincidunt dui in \r\nodio dapibus porttitor dictum sit amet odio. Quisque in lorem ac turpis \r\naliquam semper. Nam posuere est elementum, porttitor nibh id, tempus \r\nlacus.\r\n&lt;/p&gt;&lt;p&gt;\r\nMaecenas et tempus nibh. Quisque id leo lorem. Sed mattis nulla ac arcu \r\npulvinar fermentum. Donec a massa eu nisl lacinia pharetra. Nulla \r\nfacilisi. Sed scelerisque finibus mi. Sed orci mauris, gravida vitae \r\naliquam id, elementum in est. Phasellus ex enim, lobortis sed maximus \r\neu, feugiat at dolor. Nullam maximus dui lacus, nec tempus dolor \r\nvestibulum sollicitudin. Integer sed erat nec lorem tempus porta cursus \r\nsit amet nunc. Praesent lectus nulla, dictum eu volutpat et, consectetur\r\n eget massa. Donec pulvinar condimentum magna, nec cursus quam pulvinar \r\nsed. Sed lacinia mi blandit, posuere risus nec, cursus dolor. Donec \r\ninterdum a arcu a convallis.&amp;nbsp;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;this&lt;/li&gt;&lt;li&gt;is&lt;/li&gt;&lt;li&gt;a&lt;/li&gt;&lt;li&gt;list&lt;/li&gt;&lt;/ul&gt;&lt;ol&gt;&lt;li&gt;this is&lt;/li&gt;&lt;li&gt;an enumerated&lt;/li&gt;&lt;li&gt;list&lt;/li&gt;&lt;/ol&gt;&lt;h2&gt;Heading 2 test&lt;/h2&gt;&lt;p class=&quot;buttons&quot;&gt;&lt;a href=&quot;github&quot; class=&quot;githubLink&quot;&gt;link to github&lt;/a&gt;&lt;/p&gt;'),
(2, 'testpage2', 'test-page', '&lt;p&gt;Testing the apostrophe: I''m&lt;/p&gt;'),
(3, 'Lorem 1', 'lorem-1', '&lt;h1&gt;Lorem 1&lt;/h1&gt;&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque egestas eros est, a iaculis felis convallis eu. Integer vitae nunc ornare, laoreet augue id, vestibulum neque. Sed ipsum mi, tincidunt ut nisi ullamcorper, volutpat malesuada elit. Duis in mattis eros. Vivamus eu dolor magna. Nunc tincidunt enim sit amet vehicula volutpat. Nulla id ipsum feugiat, commodo magna sed, volutpat tortor.&lt;/p&gt;'),
(4, 'Lorem 2', 'lorem-2', '&lt;h1&gt;Lorem 2&lt;/h1&gt;&lt;p&gt;Morbi scelerisque aliquet nisi, in bibendum neque elementum non. Ut ultrices neque orci, vel luctus nulla interdum eu. Curabitur aliquet felis urna, in fermentum nisi dapibus non. Ut aliquam tellus ut volutpat auctor. Praesent ultrices leo sed bibendum faucibus. In tempus sagittis nulla, non volutpat erat mollis a. Pellentesque gravida, nunc sed iaculis imperdiet, purus orci sodales neque, eget bibendum ligula ante sit amet quam. Curabitur congue nulla molestie magna pulvinar tristique. Ut ligula eros, laoreet eleifend dolor eget, semper interdum erat. Mauris feugiat pulvinar nulla id finibus. Proin ultricies condimentum nulla non sollicitudin.&lt;/p&gt;'),
(5, 'Lorem 3', 'lorem-3', '&lt;h1&gt;Lorem 3&lt;/h1&gt;&lt;p&gt;Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Quisque porta pulvinar diam, quis malesuada augue vestibulum at. Vestibulum fermentum mauris vitae purus porttitor, vitae rutrum diam dictum. Nam vitae consectetur neque, porttitor mollis lacus. Nulla facilisi. Etiam mollis nisl sed dui consectetur, at euismod neque ultrices. Fusce convallis sed nulla ut lobortis. Donec in neque at risus sagittis congue sed ornare mauris. Duis scelerisque, diam id hendrerit sodales, arcu orci feugiat mi, quis tincidunt turpis turpis a tortor. Aliquam maximus congue leo, luctus finibus nunc scelerisque molestie. Mauris luctus dapibus venenatis.&lt;/p&gt;'),
(6, 'Lorem 4', 'lorem-4', '&lt;h1&gt;Lorem 4&lt;/h1&gt;&lt;p&gt;Etiam lacinia malesuada arcu a mollis. Vivamus quam purus, consectetur sed ultrices quis, varius a metus. Aliquam erat volutpat. Suspendisse mollis maximus ultricies. Quisque vestibulum aliquet tincidunt. Aliquam pulvinar nisi id urna volutpat, id auctor ex cursus. Donec laoreet blandit mauris, id fringilla diam.&lt;/p&gt;'),
(7, 'Lorem 5', 'lorem-5', '&lt;h1&gt;Lorem 5&lt;/h1&gt;&lt;p&gt;Curabitur porttitor sodales tellus, fringilla vestibulum arcu cursus ut. Quisque ut varius tellus, sed vehicula arcu. Etiam imperdiet tortor et nulla luctus vestibulum. Phasellus sed velit est. Ut vitae laoreet est, at placerat erat. Phasellus tempor orci sit amet velit imperdiet, nec egestas purus finibus. Nunc efficitur efficitur est vel semper. Donec sit amet velit et risus interdum eleifend id in orci. Phasellus id accumsan lorem. Vestibulum condimentum, lorem eget elementum scelerisque, eros orci pretium quam, vehicula aliquet dolor ex vel mi. Integer diam sem, facilisis eu nisl imperdiet, aliquam porttitor nibh. Sed aliquet fringilla nibh, vitae pharetra odio vulputate dapibus. Vestibulum sed commodo neque, et fringilla mauris. Sed euismod sit amet metus et fringilla. Integer felis mauris, volutpat sit amet nibh quis, gravida rhoncus eros.&lt;/p&gt;'),
(8, 'Lorem 6', 'lorem-6', '&lt;h1&gt;Lorem 6&lt;/h1&gt;&lt;p&gt;Morbi iaculis sit amet est nec interdum. Donec massa nulla, mollis a congue ac, suscipit sit amet felis. Morbi et tortor pellentesque, lacinia lacus eget, consectetur enim. Cras quis commodo felis. Fusce rhoncus massa quis ex euismod interdum. Donec aliquam nec ex eu commodo. Nunc at hendrerit nibh, consectetur elementum lectus. Pellentesque est odio, luctus id dignissim sed, vulputate sed enim. Nunc id ante cursus, maximus erat vel, tempus tortor. Maecenas vitae iaculis sem, eu pharetra justo. Cras quis finibus velit, id sagittis nisi. Fusce maximus augue mauris, ac commodo urna congue quis.&lt;/p&gt;'),
(17, 'Lorem 7', 'lorem-7', '&lt;h1&gt;Lorem 7&lt;/h1&gt;&lt;p&gt;Nam sem felis, finibus vel eros non, pulvinar bibendum purus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce nec orci lectus. Sed sed pretium nunc. Ut in cursus massa, sit amet pharetra neque. Mauris id turpis eu dui maximus elementum. Donec semper in est sit amet gravida. Aliquam a vehicula ante. Donec magna orci, mollis sit amet malesuada varius, maximus quis sapien. Curabitur eu rutrum tortor. Duis maximus orci aliquet magna eleifend, ac accumsan ante vehicula. Aliquam eget lobortis nunc. Cras consectetur scelerisque sagittis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.&lt;/p&gt;'),
(18, 'Lorem 8', 'lorem-8', '&lt;h1&gt;Lorem 8&lt;/h1&gt;&lt;p&gt;Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In cursus eros magna, at dapibus est tempor eget. Nam pretium urna nulla, sit amet consequat orci finibus eu. Quisque a aliquet nibh, molestie gravida quam. Curabitur pellentesque orci ac sem rutrum blandit. Morbi tempus malesuada augue, vitae vehicula odio semper sit amet. Aenean sit amet egestas mauris. Aenean dictum, nisi in tincidunt commodo, lacus libero pulvinar nulla, eget laoreet quam nulla eget lorem. In tincidunt erat vel odio mollis, non pellentesque quam pellentesque. Sed lobortis enim turpis, et malesuada purus dapibus a. Aenean imperdiet justo eget arcu molestie, sit amet pretium leo tristique. Vestibulum feugiat gravida ante vitae condimentum.&lt;/p&gt;'),
(19, 'Lorem 9', 'lorem-9', '&lt;h1&gt;Lorem 9&lt;/h1&gt;&lt;p&gt;Pellentesque porttitor lobortis sodales. Praesent eleifend faucibus pulvinar. Nunc rutrum sollicitudin quam, et congue sapien malesuada vel. Aenean quis blandit leo. Morbi erat erat, gravida a lobortis ut, posuere lacinia dui. Vivamus vitae odio id lectus sagittis volutpat. Vivamus laoreet metus nec nisi egestas, eu congue urna suscipit. Quisque pretium luctus nulla, non dapibus mi malesuada quis. Nulla ullamcorper molestie sapien, sit amet consectetur dui. Integer tincidunt diam eget ultricies faucibus.&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Structure de la table `pw_users`
--

CREATE TABLE IF NOT EXISTS `pw_users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pw_users`
--

INSERT INTO `pw_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$09$5VGZ/vMMpq07wcuHiNwFR.YXMJnFU8zV3AAeRhfPSe5ZHLZ0XJrj2');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `pw_config`
--
ALTER TABLE `pw_config`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pw_menu`
--
ALTER TABLE `pw_menu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pw_pages`
--
ALTER TABLE `pw_pages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pw_users`
--
ALTER TABLE `pw_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `pw_config`
--
ALTER TABLE `pw_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `pw_menu`
--
ALTER TABLE `pw_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pw_pages`
--
ALTER TABLE `pw_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `pw_users`
--
ALTER TABLE `pw_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
