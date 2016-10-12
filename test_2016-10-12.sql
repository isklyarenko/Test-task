# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.11)
# Database: test
# Generation Time: 2016-10-12 06:56:35 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table brands
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table keywords
# ------------------------------------------------------------

CREATE TABLE  IF NOT EXISTS `keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table product_keywords
# ------------------------------------------------------------

CREATE TABLE  IF NOT EXISTS `product_keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL,
  `word_id` int(11) unsigned NOT NULL,
  `frequency` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_word_unique` (`product_id`,`word_id`),
  KEY `FK_product_keywords_products` (`product_id`),
  KEY `FK_product_keywords_keywords` (`word_id`),
  CONSTRAINT `FK_product_keywords_keywords` FOREIGN KEY (`word_id`) REFERENCES `keywords` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_product_keywords_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table product_sizes
# ------------------------------------------------------------

CREATE TABLE  IF NOT EXISTS `product_sizes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL,
  `size_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_sizes_products` (`product_id`),
  KEY `FK_product_sizes_sizes` (`size_id`),
  CONSTRAINT `FK_product_sizes_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_product_sizes_sizes` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table products
# ------------------------------------------------------------

CREATE TABLE  IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL DEFAULT '',
  `brand_id` int(11) unsigned NOT NULL,
  `type_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_products_brands` (`brand_id`),
  KEY `FK_products_types` (`type_id`),
  CONSTRAINT `FK_products_brands` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `FK_products_types` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sizes
# ------------------------------------------------------------

CREATE TABLE  IF NOT EXISTS `sizes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL DEFAULT '',
  `type_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sizes_types` (`type_id`),
  CONSTRAINT `FK_sizes_types` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

LOCK TABLES `sizes` WRITE;
/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;

INSERT INTO `sizes` (`id`, `name`, `type_id`)
VALUES
	(1,'S',1),
	(2,'M',1),
	(3,'L',1),
	(4,'35',2),
	(5,'36',2),
	(6,'37',2),
	(7,'38',2),
	(8,'39',2),
	(9,'40',2),
	(10,'41',2),
	(11,'42',2),
	(12,'43',2),
	(13,'44',2),
	(14,'45',2);

/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table types
# ------------------------------------------------------------

CREATE TABLE  IF NOT EXISTS `types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;

INSERT INTO `types` (`id`, `name`)
VALUES
	(1,'Dress'),
	(2,'Shoes');

/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
