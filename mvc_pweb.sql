-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 22, 2016 at 01:16 PM
-- Server version: 5.6.28-0ubuntu0.15.10.1
-- PHP Version: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvc_pweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `pw_config`
--

CREATE TABLE IF NOT EXISTS `pw_config` (
  `id` int(11) NOT NULL,
  `val` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pw_config`
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
-- Table structure for table `pw_menu`
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
-- Table structure for table `pw_pages`
--

CREATE TABLE IF NOT EXISTS `pw_pages` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pw_pages`
--

INSERT INTO `pw_pages` (`id`, `name`, `url`, `content`) VALUES
(1, 'testpage', 'testpage', '&lt;h1&gt;This is a testpage&lt;/h1&gt;&lt;p&gt;Test page. Test.&lt;/p&gt;&lt;h2&gt;Heading 2 test&lt;/h2&gt;&lt;p&gt;this is a test&lt;/p&gt;&lt;h3&gt;Heading 3 test&lt;/h3&gt;&lt;p&gt;\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam mauris \r\nleo, eleifend eget tincidunt nec, dictum sit amet magna. Sed diam urna, \r\naliquam ut tortor ac, commodo egestas quam. Proin ornare euismod tempor.\r\n Nunc luctus lacus a orci elementum rhoncus. Suspendisse mi mauris, \r\naccumsan nec est in, viverra sollicitudin enim. Nulla tincidunt dui in \r\nodio dapibus porttitor dictum sit amet odio. Quisque in lorem ac turpis \r\naliquam semper. Nam posuere est elementum, porttitor nibh id, tempus \r\nlacus.\r\n&lt;/p&gt;&lt;p&gt;\r\nMaecenas et tempus nibh. Quisque id leo lorem. Sed mattis nulla ac arcu \r\npulvinar fermentum. Donec a massa eu nisl lacinia pharetra. Nulla \r\nfacilisi. Sed scelerisque finibus mi. Sed orci mauris, gravida vitae \r\naliquam id, elementum in est. Phasellus ex enim, lobortis sed maximus \r\neu, feugiat at dolor. Nullam maximus dui lacus, nec tempus dolor \r\nvestibulum sollicitudin. Integer sed erat nec lorem tempus porta cursus \r\nsit amet nunc. Praesent lectus nulla, dictum eu volutpat et, consectetur\r\n eget massa. Donec pulvinar condimentum magna, nec cursus quam pulvinar \r\nsed. Sed lacinia mi blandit, posuere risus nec, cursus dolor. Donec \r\ninterdum a arcu a convallis.&amp;nbsp;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;this&lt;/li&gt;&lt;li&gt;is&lt;/li&gt;&lt;li&gt;a&lt;/li&gt;&lt;li&gt;list&lt;/li&gt;&lt;/ul&gt;&lt;ol&gt;&lt;li&gt;this is&lt;/li&gt;&lt;li&gt;an enumerated&lt;/li&gt;&lt;li&gt;list&lt;/li&gt;&lt;/ol&gt;&lt;h2&gt;Heading 2 test&lt;/h2&gt;&lt;p class=&quot;buttons&quot;&gt;&lt;a href=&quot;github&quot; class=&quot;githubLink&quot;&gt;link to github&lt;/a&gt;&lt;/p&gt;'),
(2, 'testpage2', 'test-page', '&lt;p&gt;Testing the apostrophe: I''m&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `pw_users`
--

CREATE TABLE IF NOT EXISTS `pw_users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pw_users`
--

INSERT INTO `pw_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$09$5VGZ/vMMpq07wcuHiNwFR.YXMJnFU8zV3AAeRhfPSe5ZHLZ0XJrj2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pw_config`
--
ALTER TABLE `pw_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pw_menu`
--
ALTER TABLE `pw_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pw_pages`
--
ALTER TABLE `pw_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pw_users`
--
ALTER TABLE `pw_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pw_config`
--
ALTER TABLE `pw_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pw_menu`
--
ALTER TABLE `pw_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pw_pages`
--
ALTER TABLE `pw_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pw_users`
--
ALTER TABLE `pw_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
