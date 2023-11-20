# ************************************************************
# Sequel Ace SQL dump
# Version 20062
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 11.1.2-MariaDB-1:11.1.2+maria~ubu2204)
# Database: dvdcollection
# Generation Time: 2023-11-20 12:22:51 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table actors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `actors`;

CREATE TABLE `actors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `actors` WRITE;
/*!40000 ALTER TABLE `actors` DISABLE KEYS */;

INSERT INTO `actors` (`id`, `name`)
VALUES
	(1,'Tom Hanks'),
	(2,'Daryl Hannah'),
	(3,'John Candy'),
	(4,'Arnold Schwarzenegger'),
	(5,'Harrison Ford'),
	(6,'Sean Young'),
	(7,'Dolph Lungren'),
	(8,'Courtney Cox');

/*!40000 ALTER TABLE `actors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dvd
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvd`;

CREATE TABLE `dvd` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `run_time` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `dvd` WRITE;
/*!40000 ALTER TABLE `dvd` DISABLE KEYS */;

INSERT INTO `dvd` (`id`, `title`, `description`, `run_time`, `genre_id`)
VALUES
	(1,'Splash','Allen Bauer (Tom Hanks), a successful yet single New York Businessman, is knocked unconscious during a boating accident.  His beautiful rescuer (Daryl Hannah) is the firl of his dreams.  There\'s only one slight complication - Allen\'s fallen hook, line and sinker for a mermaid.',105,3),
	(2,'Big','A 12 year old boy trapped inside a thirty year old body.  At a carnival, young Josh Baskin (Hanks) wishes he was big - only to awake the next morning and discover he is! ',99,3),
	(3,'Total Recall','it\'s 2084 AD: and Douglas Quaid is haunted by reoccuring dreams about a journey to Mars.  A visit to a vaction parlour unlocks erased memories in Quaid\'s mind.',108,4),
	(4,'Blade Runner','Rick Deckard prowls the steel and microchip jungle of 21st century Los Angele.  He\'s a \"blade runner\" stalking genetically made criminal replicants.  His aaignment: Kill them.  Their crime: wanting to be human',112,4),
	(5,'Masters of the Universe','Planet Eternia and the Castle of Greyskull are under threat from the evil Skeletor, who wants to take over the planet.',102,1);

/*!40000 ALTER TABLE `dvd` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dvdactor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvdactor`;

CREATE TABLE `dvdactor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dvd_id` int(11) DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `dvdactor` WRITE;
/*!40000 ALTER TABLE `dvdactor` DISABLE KEYS */;

INSERT INTO `dvdactor` (`id`, `dvd_id`, `actor_id`)
VALUES
	(1,1,1),
	(2,1,2),
	(3,2,1),
	(4,3,4),
	(5,1,3),
	(6,4,5),
	(7,4,6),
	(8,5,7),
	(9,5,8);

/*!40000 ALTER TABLE `dvdactor` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table genre
# ------------------------------------------------------------

DROP TABLE IF EXISTS `genre`;

CREATE TABLE `genre` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `genre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;

INSERT INTO `genre` (`id`, `genre`)
VALUES
	(1,'science_fiction'),
	(2,'romantic_comedy'),
	(3,'classic_80\'s_comedy '),
	(4,'dystopian'),
	(5,'Action');

/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
