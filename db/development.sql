# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.34-log)
# Database: gamespot
# Generation Time: 2014-08-24 12:03:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table accessories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `accessories`;

CREATE TABLE `accessories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `release_date` date DEFAULT NULL,
  `producer` varchar(200) DEFAULT NULL,
  `description` text,
  `console_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accessory_belongs_to_console` (`console_id`),
  CONSTRAINT `accessory_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;

INSERT INTO `accessories` (`id`, `name`, `release_date`, `producer`, `description`, `console_id`)
VALUES
	(1,'PlayStation Camera','2013-11-11','Sony','Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce in mauris orci. In imperdiet aliquet gravida. Quisque suscipit egestas convallis. Quisque mattis nisi at urna rhoncus faucibus. Ut sed sapien in libero porta gravida et eget risus. Curabitur blandit interdum lobortis. Aenean vitae mattis libero, ut pellentesque ligula. Aenean urna velit, semper eu sollicitudin a, fermentum a libero. Praesent pharetra volutpat justo, non iaculis mi porttitor mattis. Donec vel nulla orci. Suspendisse blandit orci arcu, eu placerat augue ultrices nec. Curabitur lectus metus, cursus nec condimentum eu, bibendum quis urna.',1),
	(2,'PlayStation Eye','2008-08-01','Sony','Integer in volutpat massa. Aenean eleifend felis ligula, varius interdum elit ultricies vitae. Pellentesque eget elementum mauris. Aenean elementum mauris vitae orci eleifend, luctus rutrum leo tincidunt. Fusce consectetur massa nec elementum ultrices. Nam varius adipiscing tellus, ut hendrerit nunc eleifend non. Nulla in enim at tortor congue aliquam. Ut mi felis, euismod quis nunc eleifend, tristique pellentesque orci. Cras dignissim quis nulla quis ultricies. Nam in elit venenatis, aliquam leo at, venenatis velit. In tristique velit sit amet adipiscing ultricies. Fusce et posuere felis. Quisque at nibh libero. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus non egestas libero. Maecenas auctor, enim ut tempus iaculis, ante elit dictum metus, sit amet tempor neque dui nec urna.',2),
	(3,'Xbox Kinect','2009-04-22','Microsoft','Donec quis pharetra tellus. Suspendisse molestie massa eu hendrerit laoreet. Proin est tellus, sollicitudin eu tincidunt at, egestas adipiscing odio. Etiam nec dolor placerat, tincidunt enim eu, vehicula lacus. Nulla sit amet luctus velit, ut posuere sapien. Nam lacinia lacus ac enim hendrerit, quis condimentum lacus faucibus. Suspendisse id lectus ac risus porttitor faucibus at a tellus. Curabitur imperdiet enim nec fringilla malesuada. Pellentesque congue accumsan neque.',3);

/*!40000 ALTER TABLE `accessories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table accessories_ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `accessories_ads`;

CREATE TABLE `accessories_ads` (
  `ad_id` int(11) unsigned NOT NULL,
  `accessory_id` int(11) unsigned NOT NULL,
  KEY `accessories_ads_references_ad` (`ad_id`),
  KEY `accessories_ads_references_accessory` (`accessory_id`),
  CONSTRAINT `accessories_ads_references_accessory` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `accessories_ads_references_ad` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `accessories_ads` WRITE;
/*!40000 ALTER TABLE `accessories_ads` DISABLE KEYS */;

INSERT INTO `accessories_ads` (`ad_id`, `accessory_id`)
VALUES
	(22,1),
	(22,1),
	(22,1),
	(22,1),
	(22,2);

/*!40000 ALTER TABLE `accessories_ads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ads`;

CREATE TABLE `ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` float unsigned NOT NULL,
  `description` text,
  `city` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT '',
  `published` tinyint(1) unsigned DEFAULT '0',
  `author_id` int(11) unsigned NOT NULL,
  `console_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_belongs_to_user` (`author_id`),
  KEY `ad_belongs_to_console` (`console_id`),
  CONSTRAINT `ad_belongs_to_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ad_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;

INSERT INTO `ads` (`id`, `published_at`, `price`, `description`, `city`, `type`, `published`, `author_id`, `console_id`)
VALUES
	(6,'2014-08-17 19:24:35',87.45,'Cras dictum augue id iaculis dignissim. Nunc consequat mi in porta interdum. Nam tortor neque, auctor eget enim sit amet, ultrices semper mi. Sed non pharetra lacus, nec bibendum orci. Phasellus lobortis neque tortor, vitae ultrices arcu porttitor eu. Mauris non facilisis felis, interdum blandit enim. Proin mollis dignissim urna, id dignissim purus commodo vitae. Morbi tincidunt id sem vitae blandit. Proin mattis luctus nulla, eu congue quam eleifend lacinia. Quisque commodo, lectus sed tristique consectetur, felis felis condimentum neque, eu egestas diam tortor quis nisl. Nulla eleifend adipiscing tortor et rutrum. Duis vitae mauris augue. In tincidunt, lorem a malesuada egestas, urna arcu imperdiet metus, sed sodales justo est non odio. Nullam vestibulum vel sapien vitae aliquam. Suspendisse sagittis est sem, vel iaculis mi elementum a. Etiam dictum lectus magna, vitae porta est porttitor non.','Terni','game',1,1,3),
	(8,'2014-08-17 19:24:37',77.9,'Nunc elementum dolor non pretium consequat. Donec feugiat tincidunt tortor vitae eleifend. Vestibulum rhoncus justo et est bibendum, in sollicitudin turpis scelerisque. Nulla euismod ultricies eros, nec mattis magna dapibus vitae. Praesent lobortis laoreet gravida. Quisque nec arcu non lectus pharetra posuere non id diam. Vestibulum tincidunt mi non libero blandit tincidunt. Integer venenatis, nibh eget fringilla ornare, nulla enim tempor neque, at varius mauris nulla at nibh. Integer a pretium mauris, eget lacinia orci. Mauris viverra magna ut faucibus elementum. Morbi aliquam risus vel justo laoreet varius. Mauris sit amet nibh ipsum. In et luctus dolor. Nam dolor purus, eleifend non massa vel, suscipit elementum nibh. Nulla aliquet velit vitae dapibus elementum. Nunc nulla odio, malesuada eget gravida a, consectetur sed mi.','Pescara','game',1,1,4),
	(22,'2014-08-19 15:44:22',33,'r2r23r21','r2r','accessory',1,4,1),
	(23,'2014-08-19 17:41:25',33,'Hello description','Rome','game',1,4,1);

/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories_games
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories_games`;

CREATE TABLE `categories_games` (
  `category_id` int(11) unsigned NOT NULL,
  `game_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table consoles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `consoles`;

CREATE TABLE `consoles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `release_year` int(4) unsigned NOT NULL,
  `producer` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `consoles` WRITE;
/*!40000 ALTER TABLE `consoles` DISABLE KEYS */;

INSERT INTO `consoles` (`id`, `name`, `release_year`, `producer`)
VALUES
	(1,'PlayStation 3.4',2005,'Sony'),
	(2,'PlayStation 4',2013,'Sony'),
	(3,'Xbox 360',2005,'Microsoft'),
	(4,'Xbox One',2013,'Microsoft');

/*!40000 ALTER TABLE `consoles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table consoles_games
# ------------------------------------------------------------

DROP TABLE IF EXISTS `consoles_games`;

CREATE TABLE `consoles_games` (
  `game_id` int(11) unsigned NOT NULL,
  `console_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table game_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `game_categories`;

CREATE TABLE `game_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `game_categories` WRITE;
/*!40000 ALTER TABLE `game_categories` DISABLE KEYS */;

INSERT INTO `game_categories` (`id`, `name`)
VALUES
	(1,'RPG'),
	(2,'FPS'),
	(3,'Sport'),
	(4,'Puzzle-like'),
	(5,'Kids');

/*!40000 ALTER TABLE `game_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table games
# ------------------------------------------------------------

DROP TABLE IF EXISTS `games`;

CREATE TABLE `games` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `release_date` date DEFAULT NULL,
  `description` text,
  `software_house` varchar(50) DEFAULT '',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `console_id` int(11) unsigned DEFAULT NULL,
  `game_category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_belongs_to_console` (`console_id`),
  KEY `game_belongs_to_game_category` (`game_category_id`),
  CONSTRAINT `game_belongs_to_game_category` FOREIGN KEY (`game_category_id`) REFERENCES `game_categories` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `game_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`id`, `name`, `release_date`, `description`, `software_house`, `created_at`, `console_id`, `game_category_id`)
VALUES
	(1,'1886: The Order','2014-02-22','Integer turpis erat, gravida vitae lacinia id, congue ac eros. Etiam sodales velit porttitor iaculis porttitor. Nullam condimentum lorem sit amet interdum euismod. Nulla cursus eros sed condimentum pharetra. Fusce sodales sed justo et consectetur. Duis congue odio nunc, ut accumsan elit euismod eget. Aenean tempor velit in lectus elementum, quis semper lacus auctor. Ut nisi enim, mattis vel lorem ac, vehicula dictum sapien. Praesent auctor mauris turpis, ac venenatis metus rutrum vitae. Aliquam dolor tellus, rhoncus ac tincidunt mattis, consectetur eget risus.','SWHouse','2014-02-23 12:17:19',2,NULL),
	(2,'Battlefield 4','2013-11-29','Curabitur convallis tortor vitae massa vehicula, sed tincidunt turpis malesuada. Curabitur aliquet eu nunc nec commodo. Maecenas faucibus augue id sem porta, sed ultricies tortor posuere. Nullam sed nulla sed lectus placerat tristique. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin eros erat, venenatis sit amet leo non, scelerisque auctor tellus. Quisque vel tellus ut sem euismod pharetra. Ut iaculis magna volutpat laoreet venenatis. Integer quis massa mauris. In luctus eros quis purus vehicula posuere. Phasellus sed sapien neque. Proin bibendum leo vitae lectus luctus, sed convallis eros pulvinar. Ut interdum turpis nisl, non commodo orci facilisis eget. Nunc faucibus urna ac dolor semper, quis iaculis nisi consequat.','Dice','2014-02-24 00:50:17',2,2),
	(3,'Beyond','2013-05-05','Nullam venenatis quis augue vel pellentesque. Fusce sed neque quam. Praesent ante purus, ultrices quis augue ut, cursus vehicula diam. In non eros justo. Ut molestie mattis placerat. Vestibulum et lobortis arcu, ac tempus diam. Integer eget lacinia leo. Aenean at neque accumsan, suscipit lacus vitae, convallis libero. Etiam sit amet eros a augue dapibus semper nec viverra augue. Praesent id malesuada nisi. Sed ultricies, neque ac euismod adipiscing, velit enim porta elit, sed feugiat nunc nunc n','Bethesda','2014-02-23 12:17:18',NULL,NULL),
	(4,'Call Of Duty: Ghosts','2013-11-14','Donec aliquet, velit sed mollis luctus, orci lacus tincidunt tellus, ac blandit est orci quis metus. In gravida elit ligula. Donec vel augue sit amet lorem imperdiet tincidunt ut lacinia elit. Morbi eleifend viverra diam non rhoncus. Proin suscipit tortor non mauris congue, eget tristique ligula commodo. Sed pellentesque dapibus molestie. Aenean dui mi, pretium at nulla in, suscipit euismod mauris. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi laoreet diam ut ligula ullamcorper blandit. Mauris vulputate posuere magna ut feugiat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor non felis et placerat. Pellentesque dignissim odio malesuada felis placerat dignissim sit amet vitae magna. Suspendisse nec aliquam magna, sit amet aliquam augue. Praesent dictum egestas est, sit amet scelerisque leo pellentesque sit amet. Mauris et interdum lacus, in tristique eros.','Activision','2014-02-23 12:23:04',1,2),
	(5,'Fifa 14','2013-09-09','Nullam tincidunt gravida leo, vitae gravida lorem. Aenean tellus nisl, euismod vel risus in, scelerisque bibendum dolor. Suspendisse lacinia tortor sem, et pulvinar orci adipiscing vitae. Cras rutrum nisi et varius tincidunt. Nam semper nunc lectus, at molestie ligula ultrices eu. Nam pretium neque quis turpis varius semper. Fusce vestibulum libero auctor augue fringilla, sed luctus magna elementum. Curabitur eu eros nec lacus aliquam lacinia a non est. Ut nec diam non justo gravida blandit. Pha','EA Sports','2014-02-23 12:17:29',1,3),
	(6,'Knack','2014-01-01','Quisque aliquam mi ac posuere dignissim. Aliquam erat volutpat. Cras pellentesque quam et massa pretium, sed tincidunt mi consectetur. Sed in tortor in augue tempus tristique. In pulvinar tortor vel sem tempus posuere. Ut nec dolor blandit, accumsan enim a, ullamcorper lectus. Etiam hendrerit non enim vel suscipit. Quisque neque ipsum, blandit eu fringilla id, feugiat eu ante. Morbi vulputate tincidunt nulla, eget luctus leo sollicitudin quis. Fusce bibendum dictum convallis.','Sony','2014-02-24 00:55:17',2,4),
	(7,'The Last of Us','2013-01-01','Curabitur lobortis suscipit porta. Nulla.','Naughty Dogs','2014-02-23 12:17:10',1,2);

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table games_ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `games_ads`;

CREATE TABLE `games_ads` (
  `ad_id` int(11) unsigned NOT NULL,
  `game_id` int(11) unsigned NOT NULL,
  UNIQUE KEY `ad_id` (`ad_id`),
  KEY `games_ads_references_game` (`game_id`),
  KEY `game_ads_references_ad` (`ad_id`),
  CONSTRAINT `game_ads_references_games` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `game_ads_references_ad` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `games_ads` WRITE;
/*!40000 ALTER TABLE `games_ads` DISABLE KEYS */;

INSERT INTO `games_ads` (`ad_id`, `game_id`)
VALUES
	(6,3),
	(23,4),
	(8,5);

/*!40000 ALTER TABLE `games_ads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `can_blog` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_moderate_blog` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_manage_products` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_manage_ads` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_manage_support` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_block_users` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `can_blog`, `can_moderate_blog`, `can_manage_products`, `can_manage_ads`, `can_manage_support`, `can_block_users`, `is_admin`)
VALUES
	(1,'admins',1,1,1,1,1,1,1),
	(2,'bloggers',1,0,0,0,0,0,0),
	(3,'staff',0,0,1,1,1,1,0),
	(4,'moderators',0,1,0,1,0,0,0),
	(5,'support',0,0,0,0,1,0,0);

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_belongs_to_user` (`author_id`),
  CONSTRAINT `post_belongs_to_user` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `title`, `content`, `author_id`, `published_at`)
VALUES
	(1,'Donec eu eros ligula. Mauris.','Mauris id nunc bibendum augue interdum iaculis. Donec hendrerit lacus eu rhoncus sodales. Quisque at ante dignissim, ullamcorper nunc sit amet, iaculis metus. Phasellus quis semper massa. Mauris sit amet auctor elit. In posuere aliquam ante. Sed erat tortor, mattis vel euismod dignissim, bibendum nec turpis.\n',1,'2014-08-17 13:06:59'),
	(2,'Lorem ipsum dolor sit amet.','Phasellus dignissim tempor urna eget consequat. Vestibulum bibendum porta eleifend. Mauris auctor, metus et fringilla hendrerit, lectus magna facilisis erat, non imperdiet sapien lectus eu sem. Integer interdum felis eu est lobortis, sed scelerisque dolor vestibulum. Mauris sit amet pulvinar ligula. Donec tincidunt dui laoreet, pharetra turpis quis, laoreet neque. Etiam ut mattis elit. In vel turpis at urna suscipit dignissim. Donec ullamcorper velit sit amet dapibus malesuada. Nullam at lorem diam. Nullam consectetur venenatis diam, in posuere mauris sollicitudin fermentum. Morbi eu tellus sit amet elit pulvinar ullamcorper. Vivamus sed dolor sit amet arcu porta pretium at sit amet erat. Morbi ac dolor ornare, faucibus nibh sed, scelerisque justo. Proin vel condimentum nibh.',1,'2014-08-17 13:07:01');

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_tags`;

CREATE TABLE `posts_tags` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `posts_tags` WRITE;
/*!40000 ALTER TABLE `posts_tags` DISABLE KEYS */;

INSERT INTO `posts_tags` (`post_id`, `tag_id`)
VALUES
	(1,0),
	(1,0),
	(2,0);

/*!40000 ALTER TABLE `posts_tags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts_uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_uploads`;

CREATE TABLE `posts_uploads` (
  `post_id` int(11) unsigned NOT NULL,
  `upload_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `uploads`;

CREATE TABLE `uploads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL DEFAULT '',
  `size` bigint(20) unsigned DEFAULT NULL,
  `mime_type` varchar(200) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_profile_picture_id` int(11) unsigned DEFAULT NULL,
  `game_cover_id` int(11) unsigned DEFAULT NULL,
  `accessory_image_id` int(11) unsigned DEFAULT NULL,
  `console_image_id` int(11) unsigned DEFAULT NULL,
  `ad_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upload_belongs_to_game` (`game_cover_id`),
  KEY `upload_belongs_to_user_as_profile_picture` (`user_profile_picture_id`),
  KEY `upload_belongs_to_accessory` (`accessory_image_id`),
  KEY `upload_belongs_to_ad` (`ad_id`),
  KEY `upload_belongs_to_console` (`console_image_id`),
  CONSTRAINT `upload_belongs_to_console` FOREIGN KEY (`console_image_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_accessory` FOREIGN KEY (`accessory_image_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_ad` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_game` FOREIGN KEY (`game_cover_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_user_as_profile_picture` FOREIGN KEY (`user_profile_picture_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;

INSERT INTO `uploads` (`id`, `url`, `size`, `mime_type`, `uploaded_at`, `user_profile_picture_id`, `game_cover_id`, `accessory_image_id`, `console_image_id`, `ad_id`)
VALUES
	(18,'18/1373496404.jpg',331732,'image/jpeg','2014-08-19 18:02:02',NULL,NULL,NULL,NULL,23),
	(19,'19/1373299467.jpg',230637,'image/jpeg','2014-08-19 18:21:56',NULL,NULL,NULL,NULL,23),
	(20,'20/1373298726.jpg',193272,'image/jpeg','2014-08-19 18:21:56',NULL,NULL,NULL,NULL,23),
	(21,'21/1373334244.jpg',352374,'image/jpeg','2014-08-19 18:21:56',NULL,NULL,NULL,NULL,23),
	(25,'',0,'','2014-08-20 21:13:55',NULL,NULL,NULL,NULL,NULL),
	(36,'36/ypUQDz7.jpg',86203,'image/jpeg','2014-08-20 21:54:45',4,NULL,NULL,NULL,NULL),
	(39,'',0,'','2014-08-21 20:53:05',NULL,NULL,NULL,NULL,NULL),
	(40,'',0,'','2014-08-21 20:55:48',NULL,NULL,NULL,NULL,NULL),
	(41,'',0,'','2014-08-21 20:59:58',NULL,NULL,NULL,NULL,NULL),
	(43,'43/5IljutD.jpg',24264,'image/jpeg','2014-08-22 02:10:29',10,NULL,NULL,NULL,NULL),
	(51,'51/112213-national-xbox-one-playstation-4-matchup-camera.jpg',252381,'image/jpeg','2014-08-22 13:45:02',NULL,NULL,1,NULL,NULL);

/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `hashed_password` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `blocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `confirmation_token` varchar(255) DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_email` (`email`),
  KEY `user_belongs_to_group` (`group_id`),
  CONSTRAINT `user_belongs_to_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `hashed_password`, `created_at`, `first_name`, `last_name`, `blocked`, `confirmed`, `confirmation_token`, `group_id`)
VALUES
	(1,'admin@gamespot.com','21232f297a57a5a743894a0e4a801fc3','2014-02-23 12:20:13','Ammi','Nistratore',0,1,NULL,1),
	(4,'staff@gamespot.com','1253208465b1efa876f982d8a9e73eef','2014-02-24 23:49:05','Membero','Dello Staff',0,1,NULL,3),
	(10,'regular@gamespot.com','af37d08ae228a87dc6b265fd1019c97d','2014-08-21 14:16:34','Regolare','Userone',0,1,NULL,NULL),
	(11,'support@gamespot.com','434990c8a25d2be94863561ae98bd682','2014-08-21 15:07:29','Suppor','Tomini',0,1,NULL,5);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
