# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.12)
# Database: webshop-sandbox
# Generation Time: 2014-04-13 15:47:20 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table customer_billing_shipping
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_billing_shipping`;

CREATE TABLE `customer_billing_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL DEFAULT '' COMMENT 'BT = Billing Type\\nST = Shipping Type',
  `company_name` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `insertion` varchar(50) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `address_1` varchar(200) NOT NULL DEFAULT '',
  `address_2` varchar(200) DEFAULT NULL,
  `zipcode` varchar(7) NOT NULL DEFAULT '',
  `city` varchar(200) NOT NULL DEFAULT '',
  `country` varchar(200) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL DEFAULT '',
  `phone_1` varchar(15) DEFAULT NULL,
  `phone_2` varchar(15) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `customer_billing_shipping_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table manufacturer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `manufacturer`;

CREATE TABLE `manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(7) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `email_1` varchar(150) DEFAULT NULL,
  `email_2` varchar(150) DEFAULT NULL,
  `phone_1` varchar(15) DEFAULT NULL,
  `phone_2` varchar(15) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_04_12_174243_confide_setup_users_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status_id` int(11) NOT NULL,
  `reference` text,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_order_status1_idx` (`order_status_id`),
  KEY `fk_order_customer1_idx` (`users_id`),
  CONSTRAINT `fk_order_order_status1` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_customer1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table order_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_product`;

CREATE TABLE `order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` int(11) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_vat` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_item_order1_idx` (`order_id`),
  KEY `fk_order_item_product1_idx` (`product_id`),
  CONSTRAINT `fk_order_item_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table order_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_status`;

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table password_reminders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_reminders`;

CREATE TABLE `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `descr` text,
  `product_detail_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_product_detail1_idx` (`product_detail_id`),
  KEY `fk_product_product_category1_idx` (`product_category_id`),
  CONSTRAINT `fk_product_product_category1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;

INSERT INTO `product` (`id`, `sku`, `name`, `descr`, `product_detail_id`, `product_category_id`, `created_on`, `updated_on`)
VALUES
	(1,'P001','Fishing Hat','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in eros odio. Pellentesque elit odio, pretium eget arcu vitae, tristique mollis tortor. Nullam rhoncus orci ultrices leo sodales, eu hendrerit leo facilisis. Cras pellentesque metus cursus lacus cursus dignissim. Pellentesque viverra tincidunt orci, vitae imperdiet ligula tempor non. Donec elit metus, congue quis turpis at, rhoncus lobortis turpis. Sed nisl mi, condimentum eu porttitor ut, pharetra adipiscing metus.',0,1,'2014-04-12 21:56:09',NULL),
	(2,'P002','Camping Hat','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in eros odio. Pellentesque elit odio, pretium eget arcu vitae, tristique mollis tortor. Nullam rhoncus orci ultrices leo sodales, eu hendrerit leo facilisis. Cras pellentesque metus cursus lacus cursus dignissim. Pellentesque viverra tincidunt orci, vitae imperdiet ligula tempor non. Donec elit metus, congue quis turpis at, rhoncus lobortis turpis. Sed nisl mi, condimentum eu porttitor ut, pharetra adipiscing metus.',0,1,'2014-04-12 21:56:09',NULL),
	(3,'P003','Biker Hat','Hat to go fishing with',0,1,'2014-04-12 21:56:09',NULL),
	(4,'P004','Bycicle Hat','Hat to go fishing with',0,1,'2014-04-12 21:56:09',NULL),
	(5,'P005','Training Hat','Hat to go fishing with',0,1,'2014-04-12 21:56:09',NULL),
	(6,'P006','Fitness Hat','Hat to go fishing with',0,1,'2014-04-12 21:56:09',NULL),
	(7,'P007','Football Hat','Hat to go fishing with',0,1,'2014-04-12 21:56:09',NULL);

/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_category`;

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default.png',
  `published` int(11) DEFAULT '1',
  `ordering` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;

INSERT INTO `product_category` (`id`, `name`, `image`, `published`, `ordering`, `created_on`, `updated_on`)
VALUES
	(1,'Hats','default.png',1,NULL,NULL,NULL);

/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_detail`;

CREATE TABLE `product_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `weight` decimal(10,4) DEFAULT NULL,
  `weight_uom` varchar(50) DEFAULT NULL,
  `length` decimal(10,4) DEFAULT NULL,
  `width` decimal(10,4) DEFAULT NULL,
  `height` decimal(10,4) DEFAULT NULL,
  `lwh_uom` varchar(50) DEFAULT NULL,
  `delivery_time` int(11) DEFAULT NULL COMMENT 'in days',
  `vat` int(11) DEFAULT NULL COMMENT 'belasting toegevoegde waarde',
  `price` decimal(10,2) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product_detail` WRITE;
/*!40000 ALTER TABLE `product_detail` DISABLE KEYS */;

INSERT INTO `product_detail` (`id`, `product_id`, `weight`, `weight_uom`, `length`, `width`, `height`, `lwh_uom`, `delivery_time`, `vat`, `price`, `created_on`, `updated_on`)
VALUES
	(1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,21,20.00,'2014-04-12 23:12:27',NULL),
	(2,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,21,15.00,'2014-04-12 23:12:27',NULL);

/*!40000 ALTER TABLE `product_detail` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `insertion` varchar(30) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL COMMENT 'encrypted string won''t fit into 256 characters',
  `email` varchar(255) DEFAULT NULL,
  `confirmation_code` varchar(255) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `firstname`, `insertion`, `lastname`, `username`, `password`, `email`, `confirmation_code`, `confirmed`, `created_at`, `updated_at`)
VALUES
	(1,NULL,NULL,NULL,'admin','$2y$10$UMbporCAI3vX0osrpT1swetZNwLR2hublCssXQKL.oqT/yj6sH1fu','c.smits91@gmail.com','f099d608f821a733652d73dbe24f3c8a',1,'2014-04-12 19:44:02','2014-04-12 19:44:02');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
