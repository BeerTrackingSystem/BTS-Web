-- MySQL dump 10.14  Distrib 5.5.64-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: infrabeer
-- ------------------------------------------------------
-- Server version	5.5.64-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `current_stock`
--

DROP TABLE IF EXISTS `current_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `current_stock` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `current_strikes`
--

DROP TABLE IF EXISTS `current_strikes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `current_strikes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `currentstrikes` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `current_strikes_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `motd`
--

DROP TABLE IF EXISTS `motd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `change` date DEFAULT NULL,
  `quoteid` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_motd_quotes` (`quoteid`),
  CONSTRAINT `fk_motd_quotes` FOREIGN KEY (`quoteid`) REFERENCES `quotes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending_del_strikes_add`
--

DROP TABLE IF EXISTS `pending_del_strikes_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_del_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psaid` int(10) DEFAULT NULL,
  `uservalidate1` tinyint(1) DEFAULT '0',
  `uservalidate2` tinyint(1) DEFAULT '0',
  `uservalidate3` tinyint(1) DEFAULT '0',
  `validated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_pending_del_strikes_add_pending_strikes_add` (`psaid`),
  CONSTRAINT `fk_pending_del_strikes_add_pending_strikes_add` FOREIGN KEY (`psaid`) REFERENCES `pending_strikes_add` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending_del_strikes_del`
--

DROP TABLE IF EXISTS `pending_del_strikes_del`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_del_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psdid` int(10) DEFAULT NULL,
  `uservalidate1` tinyint(1) DEFAULT '0',
  `uservalidate2` tinyint(1) DEFAULT '0',
  `uservalidate3` tinyint(1) DEFAULT '0',
  `validated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_pending_del_strikes_del_pending_strikes_del` (`psdid`),
  CONSTRAINT `fk_pending_del_strikes_del_pending_strikes_del` FOREIGN KEY (`psdid`) REFERENCES `pending_strikes_del` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending_strikes_add`
--

DROP TABLE IF EXISTS `pending_strikes_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `uservalidate1` tinyint(1) DEFAULT '0',
  `uservalidate2` tinyint(1) DEFAULT '0',
  `uservalidate3` tinyint(1) DEFAULT '0',
  `validated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `pending_strikes_add_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending_strikes_del`
--

DROP TABLE IF EXISTS `pending_strikes_del`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `uservalidate1` tinyint(1) DEFAULT '0',
  `uservalidate2` tinyint(1) DEFAULT '0',
  `uservalidate3` tinyint(1) DEFAULT '0',
  `validated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `pending_strikes_del_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotes`
--

DROP TABLE IF EXISTS `quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `quote` varchar(255) DEFAULT NULL,
  `lastused` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sms` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validate_del_strikes_add`
--

DROP TABLE IF EXISTS `validate_del_strikes_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate_del_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pdsaid` int(10) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_validate_del_strikes_add_pending_del_strikes_add` (`pdsaid`),
  CONSTRAINT `fk_validate_del_strikes_add_pending_del_strikes_add` FOREIGN KEY (`pdsaid`) REFERENCES `pending_del_strikes_add` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validate_del_strikes_del`
--

DROP TABLE IF EXISTS `validate_del_strikes_del`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate_del_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pdsdid` int(10) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_validate_del_strikes_del_pending_del_strikes_del` (`pdsdid`),
  CONSTRAINT `fk_validate_del_strikes_del_pending_del_strikes_del` FOREIGN KEY (`pdsdid`) REFERENCES `pending_del_strikes_del` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validate_strikes_add`
--

DROP TABLE IF EXISTS `validate_strikes_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psaid` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `validate_strikes_add_ibfk_2_idx` (`psaid`),
  CONSTRAINT `validate_strikes_add_ibfk_2` FOREIGN KEY (`psaid`) REFERENCES `pending_strikes_add` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validate_strikes_del`
--

DROP TABLE IF EXISTS `validate_strikes_del`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psdid` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `psdid` (`psdid`),
  CONSTRAINT `validate_strikes_del_ibfk_2` FOREIGN KEY (`psdid`) REFERENCES `pending_strikes_del` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-10  0:26:49
