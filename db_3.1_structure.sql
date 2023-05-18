/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apikey` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `auth_sessions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `sessionid` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL,
  `api` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_auth_sessions_user` (`userid`),
  CONSTRAINT `fk_auth_sessions_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `beers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `breweryid` int(10) NOT NULL,
  `style` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brewery` (`breweryid`) USING BTREE,
  CONSTRAINT `brewery` FOREIGN KEY (`breweryid`) REFERENCES `breweries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `breweries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DELIMITER //
CREATE EVENT `clear_sessions` ON SCHEDULE EVERY 30 SECOND STARTS '2022-04-15 01:16:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN

DELETE FROM auth_sessions WHERE create_date < (NOW() - INTERVAL 30 MINUTE);

END//
DELIMITER ;

CREATE TABLE IF NOT EXISTS `current_stock` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `amount` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `current_strikes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `currentstrikes` int(3) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `current_strikes_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `misc` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `object` varchar(100) NOT NULL,
  `attribute` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `motd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `change` date DEFAULT NULL,
  `quoteid` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_motd_quotes` (`quoteid`),
  CONSTRAINT `fk_motd_quotes` FOREIGN KEY (`quoteid`) REFERENCES `quotes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `pending_del_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psaid` int(10) NOT NULL,
  `validations_needed` int(10) NOT NULL,
  `validations_acc` int(10) NOT NULL DEFAULT 0,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_pending_del_strikes_add_pending_strikes_add` (`psaid`),
  CONSTRAINT `fk_pending_del_strikes_add_pending_strikes_add` FOREIGN KEY (`psaid`) REFERENCES `pending_strikes_add` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `pending_del_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psdid` int(10) NOT NULL,
  `validations_needed` int(10) NOT NULL,
  `validations_acc` int(10) NOT NULL DEFAULT 0,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_pending_del_strikes_del_pending_strikes_del` (`psdid`),
  CONSTRAINT `fk_pending_del_strikes_del_pending_strikes_del` FOREIGN KEY (`psdid`) REFERENCES `pending_strikes_del` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `pending_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `date` date NOT NULL,
  `validations_needed` int(10) NOT NULL,
  `validations_acc` int(10) NOT NULL DEFAULT 0,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `event` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `pending_strikes_add_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `pending_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `date` date NOT NULL,
  `validations_needed` int(10) NOT NULL,
  `validations_acc` int(10) NOT NULL DEFAULT 0,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `event` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `pending_strikes_del_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `quote` varchar(255) DEFAULT NULL,
  `lastused` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `ranking_beers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `beerid` int(10) NOT NULL,
  `rating` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`userid`),
  KEY `beer` (`beerid`),
  CONSTRAINT `beer` FOREIGN KEY (`beerid`) REFERENCES `beers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sms` bigint(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `veteran` tinyint(1) NOT NULL DEFAULT 0,
  `last_pay` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `validate_del_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pdsaid` int(10) NOT NULL,
  `userid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_validate_del_strikes_add_pending_del_strikes_add` (`pdsaid`),
  KEY `fk_validate_del_strikes_add_user` (`userid`),
  CONSTRAINT `fk_validate_del_strikes_add_pending_del_strikes_add` FOREIGN KEY (`pdsaid`) REFERENCES `pending_del_strikes_add` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_validate_del_strikes_add_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `validate_del_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pdsdid` int(10) NOT NULL,
  `userid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_validate_del_strikes_del_pending_del_strikes_del` (`pdsdid`),
  KEY `fk_validate_del_strikes_del_user` (`userid`),
  CONSTRAINT `fk_validate_del_strikes_del_pending_del_strikes_del` FOREIGN KEY (`pdsdid`) REFERENCES `pending_del_strikes_del` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_validate_del_strikes_del_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `validate_strikes_add` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psaid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `validate_strikes_add_ibfk_2_idx` (`psaid`),
  KEY `fk_validate_strikes_add_user` (`userid`),
  CONSTRAINT `fk_validate_strikes_add_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `validate_strikes_add_ibfk_2` FOREIGN KEY (`psaid`) REFERENCES `pending_strikes_add` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `validate_strikes_del` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `psdid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `psdid` (`psdid`),
  KEY `fk_validate_strikes_del_user` (`userid`),
  CONSTRAINT `fk_validate_strikes_del_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `validate_strikes_del_ibfk_2` FOREIGN KEY (`psdid`) REFERENCES `pending_strikes_del` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `veterans` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sms` bigint(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_veterans_user` (`userid`),
  CONSTRAINT `fk_veterans_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `visits` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `veteranid` int(10) DEFAULT NULL,
  `notice` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk__veterans` (`veteranid`),
  CONSTRAINT `fk__veterans` FOREIGN KEY (`veteranid`) REFERENCES `veterans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
