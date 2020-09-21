-- MySQL dump 10.17  Distrib 10.3.17-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bts_test
-- ------------------------------------------------------
-- Server version	10.3.17-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
  `currentstrikes` int(3) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `current_strikes_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `misc`
--

DROP TABLE IF EXISTS `misc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `misc` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending_del_strikes_add`
--

DROP TABLE IF EXISTS `pending_del_strikes_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_del_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psaid` int(10) NOT NULL,
  `validations_needed` int(10) NOT NULL,
  `validations_acc` int(10) NOT NULL DEFAULT 0,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_pending_del_strikes_add_pending_strikes_add` (`psaid`),
  CONSTRAINT `fk_pending_del_strikes_add_pending_strikes_add` FOREIGN KEY (`psaid`) REFERENCES `pending_strikes_add` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending_del_strikes_del`
--

DROP TABLE IF EXISTS `pending_del_strikes_del`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_del_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psdid` int(10) NOT NULL,
  `validations_needed` int(10) NOT NULL,
  `validations_acc` int(10) NOT NULL DEFAULT 0,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_pending_del_strikes_del_pending_strikes_del` (`psdid`),
  CONSTRAINT `fk_pending_del_strikes_del_pending_strikes_del` FOREIGN KEY (`psdid`) REFERENCES `pending_strikes_del` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending_strikes_add`
--

DROP TABLE IF EXISTS `pending_strikes_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `date` date NOT NULL,
  `validations_needed` int(10) NOT NULL,
  `validations_acc` int(10) NOT NULL DEFAULT 0,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `pending_strikes_add_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending_strikes_del`
--

DROP TABLE IF EXISTS `pending_strikes_del`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `date` date NOT NULL,
  `validations_needed` int(10) NOT NULL,
  `validations_acc` int(10) NOT NULL DEFAULT 0,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `pending_strikes_del_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
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
  `password` varchar(255) NOT NULL,
  `veteran` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validate_del_strikes_add`
--

DROP TABLE IF EXISTS `validate_del_strikes_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate_del_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pdsaid` int(10) NOT NULL,
  `userid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_validate_del_strikes_add_pending_del_strikes_add` (`pdsaid`),
  KEY `fk_validate_del_strikes_add_user` (`userid`),
  CONSTRAINT `fk_validate_del_strikes_add_pending_del_strikes_add` FOREIGN KEY (`pdsaid`) REFERENCES `pending_del_strikes_add` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_validate_del_strikes_add_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validate_del_strikes_del`
--

DROP TABLE IF EXISTS `validate_del_strikes_del`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate_del_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pdsdid` int(10) NOT NULL,
  `userid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_validate_del_strikes_del_pending_del_strikes_del` (`pdsdid`),
  KEY `fk_validate_del_strikes_del_user` (`userid`),
  CONSTRAINT `fk_validate_del_strikes_del_pending_del_strikes_del` FOREIGN KEY (`pdsdid`) REFERENCES `pending_del_strikes_del` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_validate_del_strikes_del_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validate_strikes_add`
--

DROP TABLE IF EXISTS `validate_strikes_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psaid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `validate_strikes_add_ibfk_2_idx` (`psaid`),
  KEY `fk_validate_strikes_add_user` (`userid`),
  CONSTRAINT `fk_validate_strikes_add_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `validate_strikes_add_ibfk_2` FOREIGN KEY (`psaid`) REFERENCES `pending_strikes_add` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validate_strikes_del`
--

DROP TABLE IF EXISTS `validate_strikes_del`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psdid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `psdid` (`psdid`),
  KEY `fk_validate_strikes_del_user` (`userid`),
  CONSTRAINT `fk_validate_strikes_del_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `validate_strikes_del_ibfk_2` FOREIGN KEY (`psdid`) REFERENCES `pending_strikes_del` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `veterans`
--

DROP TABLE IF EXISTS `veterans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `veterans` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `veteranid` int(10) DEFAULT NULL,
  `notice` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk__veterans` (`veteranid`),
  CONSTRAINT `fk__veterans` FOREIGN KEY (`veteranid`) REFERENCES `veterans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-21 20:31:16
