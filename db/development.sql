# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.34)
# Database: gamespot
# Generation Time: 2014-08-17 11:08:16 +0000
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
  `name` varchar(50) NOT NULL DEFAULT '',
  `release_date` date DEFAULT NULL,
  `description` text,
  `console_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accessory_belongs_to_console` (`console_id`),
  CONSTRAINT `accessory_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;

INSERT INTO `accessories` (`id`, `name`, `release_date`, `description`, `console_id`)
VALUES
	(1,'PlayStation Camera','2013-11-11','Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce in mauris orci. In imperdiet aliquet gravida. Quisque suscipit egestas convallis. Quisque mattis nisi at urna rhoncus faucibus. Ut sed sapien in libero porta gravida et eget risus. Curabitur blandit interdum lobortis. Aenean vitae mattis libero, ut pellentesque ligula. Aenean urna velit, semper eu sollicitudin a, fermentum a libero. Praesent pharetra volutpat justo, non iaculis mi porttitor mattis. Donec vel nulla orci. Suspendisse blandit orci arcu, eu placerat augue ultrices nec. Curabitur lectus metus, cursus nec condimentum eu, bibendum quis urna.',1),
	(2,'PlayStation Eye','2008-08-01','Integer in volutpat massa. Aenean eleifend felis ligula, varius interdum elit ultricies vitae. Pellentesque eget elementum mauris. Aenean elementum mauris vitae orci eleifend, luctus rutrum leo tincidunt. Fusce consectetur massa nec elementum ultrices. Nam varius adipiscing tellus, ut hendrerit nunc eleifend non. Nulla in enim at tortor congue aliquam. Ut mi felis, euismod quis nunc eleifend, tristique pellentesque orci. Cras dignissim quis nulla quis ultricies. Nam in elit venenatis, aliquam leo at, venenatis velit. In tristique velit sit amet adipiscing ultricies. Fusce et posuere felis. Quisque at nibh libero. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus non egestas libero. Maecenas auctor, enim ut tempus iaculis, ante elit dictum metus, sit amet tempor neque dui nec urna.',2),
	(3,'Xbox Kinect','2009-04-22','Donec quis pharetra tellus. Suspendisse molestie massa eu hendrerit laoreet. Proin est tellus, sollicitudin eu tincidunt at, egestas adipiscing odio. Etiam nec dolor placerat, tincidunt enim eu, vehicula lacus. Nulla sit amet luctus velit, ut posuere sapien. Nam lacinia lacus ac enim hendrerit, quis condimentum lacus faucibus. Suspendisse id lectus ac risus porttitor faucibus at a tellus. Curabitur imperdiet enim nec fringilla malesuada. Pellentesque congue accumsan neque.',3);

/*!40000 ALTER TABLE `accessories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table accessory_ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `accessory_ads`;

CREATE TABLE `accessory_ads` (
  `ad_id` int(11) unsigned NOT NULL,
  `accessory_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ads`;

CREATE TABLE `ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` float unsigned NOT NULL,
  `description` text,
  `city` varchar(50) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `console_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_belongs_to_user` (`user_id`),
  KEY `ad_belongs_to_console` (`console_id`),
  CONSTRAINT `ad_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ad_belongs_to_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;

INSERT INTO `ads` (`id`, `created_at`, `price`, `description`, `city`, `user_id`, `console_id`)
VALUES
	(3,'2014-08-17 12:56:18',69.99,'Sed cursus rhoncus erat et porta. Cras in sem porttitor, pretium sapien vel, dignissim dolor. Quisque feugiat est eu lectus lobortis scelerisque. Donec mollis eros ut nibh rhoncus, quis facilisis nunc eleifend. Donec imperdiet gravida mattis. Maecenas hendrerit placerat velit nec pulvinar. Mauris accumsan eros non neque ultricies, id gravida purus sollicitudin. Donec lacinia dapibus lectus ultrices placerat.','Roma',1,1),
	(5,'2014-08-17 12:56:19',66,'Donec lectus orci, vehicula quis mi at, eleifend euismod dolor. Suspendisse euismod tempus diam non vehicula. Duis lacinia porta nibh, id porta nisi posuere nec. Morbi consectetur velit et elit ornare aliquam. Cras pellentesque purus ut dignissim euismod. Nunc varius lobortis massa non pretium. Nam convallis sed dui non euismod. Maecenas consequat metus non magna ultrices vestibulum. Vestibulum egestas volutpat est ac condimentum. Maecenas neque lacus, venenatis auctor placerat vel, consectetur id magna. Donec vel consequat turpis, non gravida diam.','Roma',1,2),
	(6,'2014-08-17 12:56:19',87.45,'Cras dictum augue id iaculis dignissim. Nunc consequat mi in porta interdum. Nam tortor neque, auctor eget enim sit amet, ultrices semper mi. Sed non pharetra lacus, nec bibendum orci. Phasellus lobortis neque tortor, vitae ultrices arcu porttitor eu. Mauris non facilisis felis, interdum blandit enim. Proin mollis dignissim urna, id dignissim purus commodo vitae. Morbi tincidunt id sem vitae blandit. Proin mattis luctus nulla, eu congue quam eleifend lacinia. Quisque commodo, lectus sed tristique consectetur, felis felis condimentum neque, eu egestas diam tortor quis nisl. Nulla eleifend adipiscing tortor et rutrum. Duis vitae mauris augue. In tincidunt, lorem a malesuada egestas, urna arcu imperdiet metus, sed sodales justo est non odio. Nullam vestibulum vel sapien vitae aliquam. Suspendisse sagittis est sem, vel iaculis mi elementum a. Etiam dictum lectus magna, vitae porta est porttitor non.','Terni',1,3),
	(7,'2014-08-17 12:56:20',55,'Aliquam vulputate hendrerit tortor quis venenatis. Phasellus id nulla nec justo interdum feugiat in quis augue. Maecenas at turpis et nunc condimentum fermentum. Nulla vitae tortor eget justo aliquet tincidunt ut at velit. Maecenas tempor, quam vitae pellentesque cursus, tellus orci hendrerit mauris, vitae porttitor leo quam id nibh. Integer suscipit purus vel scelerisque scelerisque. Morbi posuere ante sagittis placerat varius.','Roma',1,4),
	(8,'2014-08-17 12:56:23',77.9,'Nunc elementum dolor non pretium consequat. Donec feugiat tincidunt tortor vitae eleifend. Vestibulum rhoncus justo et est bibendum, in sollicitudin turpis scelerisque. Nulla euismod ultricies eros, nec mattis magna dapibus vitae. Praesent lobortis laoreet gravida. Quisque nec arcu non lectus pharetra posuere non id diam. Vestibulum tincidunt mi non libero blandit tincidunt. Integer venenatis, nibh eget fringilla ornare, nulla enim tempor neque, at varius mauris nulla at nibh. Integer a pretium mauris, eget lacinia orci. Mauris viverra magna ut faucibus elementum. Morbi aliquam risus vel justo laoreet varius. Mauris sit amet nibh ipsum. In et luctus dolor. Nam dolor purus, eleifend non massa vel, suscipit elementum nibh. Nulla aliquet velit vitae dapibus elementum. Nunc nulla odio, malesuada eget gravida a, consectetur sed mi.','Pescara',1,4);

/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `name` varchar(40) NOT NULL DEFAULT '',
  `description` text,
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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
	(1,'PlayStation 3',2005,'Sony'),
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`id`, `name`, `release_date`, `description`, `software_house`, `created_at`)
VALUES
	(1,'1886: The Order','2014-02-22','Integer turpis erat, gravida vitae lacinia id, congue ac eros. Etiam sodales velit porttitor iaculis porttitor. Nullam condimentum lorem sit amet interdum euismod. Nulla cursus eros sed condimentum pharetra. Fusce sodales sed justo et consectetur. Duis congue odio nunc, ut accumsan elit euismod eget. Aenean tempor velit in lectus elementum, quis semper lacus auctor. Ut nisi enim, mattis vel lorem ac, vehicula dictum sapien. Praesent auctor mauris turpis, ac venenatis metus rutrum vitae. Aliquam dolor tellus, rhoncus ac tincidunt mattis, consectetur eget risus.','SWHouse','2014-02-23 12:17:19'),
	(2,'Battlefield 4','2013-11-29','Curabitur convallis tortor vitae massa vehicula, sed tincidunt turpis malesuada. Curabitur aliquet eu nunc nec commodo. Maecenas faucibus augue id sem porta, sed ultricies tortor posuere. Nullam sed nulla sed lectus placerat tristique. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin eros erat, venenatis sit amet leo non, scelerisque auctor tellus. Quisque vel tellus ut sem euismod pharetra. Ut iaculis magna volutpat laoreet venenatis. Integer quis massa mauris. In luctus eros quis purus vehicula posuere. Phasellus sed sapien neque. Proin bibendum leo vitae lectus luctus, sed convallis eros pulvinar. Ut interdum turpis nisl, non commodo orci facilisis eget. Nunc faucibus urna ac dolor semper, quis iaculis nisi consequat.','Dice','2014-02-24 00:50:17'),
	(3,'Beyond','2013-05-05','Nullam venenatis quis augue vel pellentesque. Fusce sed neque quam. Praesent ante purus, ultrices quis augue ut, cursus vehicula diam. In non eros justo. Ut molestie mattis placerat. Vestibulum et lobortis arcu, ac tempus diam. Integer eget lacinia leo. Aenean at neque accumsan, suscipit lacus vitae, convallis libero. Etiam sit amet eros a augue dapibus semper nec viverra augue. Praesent id malesuada nisi. Sed ultricies, neque ac euismod adipiscing, velit enim porta elit, sed feugiat nunc nunc n','Bethesda','2014-02-23 12:17:18'),
	(4,'Call Of Duty: Ghosts','2013-11-14','Donec aliquet, velit sed mollis luctus, orci lacus tincidunt tellus, ac blandit est orci quis metus. In gravida elit ligula. Donec vel augue sit amet lorem imperdiet tincidunt ut lacinia elit. Morbi eleifend viverra diam non rhoncus. Proin suscipit tortor non mauris congue, eget tristique ligula commodo. Sed pellentesque dapibus molestie. Aenean dui mi, pretium at nulla in, suscipit euismod mauris. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi laoreet diam ut ligula ullamcorper blandit. Mauris vulputate posuere magna ut feugiat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor non felis et placerat. Pellentesque dignissim odio malesuada felis placerat dignissim sit amet vitae magna. Suspendisse nec aliquam magna, sit amet aliquam augue. Praesent dictum egestas est, sit amet scelerisque leo pellentesque sit amet. Mauris et interdum lacus, in tristique eros.','Activision','2014-02-23 12:23:04'),
	(5,'Fifa \'14','2013-09-09','Nullam tincidunt gravida leo, vitae gravida lorem. Aenean tellus nisl, euismod vel risus in, scelerisque bibendum dolor. Suspendisse lacinia tortor sem, et pulvinar orci adipiscing vitae. Cras rutrum nisi et varius tincidunt. Nam semper nunc lectus, at molestie ligula ultrices eu. Nam pretium neque quis turpis varius semper. Fusce vestibulum libero auctor augue fringilla, sed luctus magna elementum. Curabitur eu eros nec lacus aliquam lacinia a non est. Ut nec diam non justo gravida blandit. Pha','EA Sports','2014-02-23 12:17:29'),
	(6,'Knack','2014-01-01','Quisque aliquam mi ac posuere dignissim. Aliquam erat volutpat. Cras pellentesque quam et massa pretium, sed tincidunt mi consectetur. Sed in tortor in augue tempus tristique. In pulvinar tortor vel sem tempus posuere. Ut nec dolor blandit, accumsan enim a, ullamcorper lectus. Etiam hendrerit non enim vel suscipit. Quisque neque ipsum, blandit eu fringilla id, feugiat eu ante. Morbi vulputate tincidunt nulla, eget luctus leo sollicitudin quis. Fusce bibendum dictum convallis.','Sony','2014-02-24 00:55:17'),
	(7,'The Last of Us','2013-01-01','Curabitur lobortis suscipit porta. Nulla.','Naughty Dogs','2014-02-23 12:17:10');

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table games_ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `games_ads`;

CREATE TABLE `games_ads` (
  `ad_id` int(11) unsigned NOT NULL,
  `game_id` int(11) unsigned NOT NULL,
  KEY `games_ads_references_game` (`game_id`),
  KEY `game_ads_references_ad` (`ad_id`),
  CONSTRAINT `game_ads_references_ad` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `games_ads_references_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `games_ads` WRITE;
/*!40000 ALTER TABLE `games_ads` DISABLE KEYS */;

INSERT INTO `games_ads` (`ad_id`, `game_id`)
VALUES
	(3,1),
	(5,2),
	(6,3),
	(7,4),
	(8,5);

/*!40000 ALTER TABLE `games_ads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `can_see_backend` tinyint(1) NOT NULL DEFAULT '0',
  `can_blog` tinyint(1) NOT NULL DEFAULT '0',
  `can_manage_blog` tinyint(1) NOT NULL DEFAULT '0',
  `can_manage_products` tinyint(1) NOT NULL DEFAULT '0',
  `can_manage_ads` tinyint(1) NOT NULL DEFAULT '0',
  `is_support` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `description`, `can_see_backend`, `can_blog`, `can_manage_blog`, `can_manage_products`, `can_manage_ads`, `is_support`, `is_admin`)
VALUES
	(1,'admins','The admins of the website.',1,1,1,1,1,0,1),
	(2,'bloggers','People who can blog.',1,1,0,0,0,0,0),
	(3,'content_editors','People who can manage ads and games.',0,0,0,1,1,0,0),
	(4,'staff','Staff of the website.',1,1,0,1,1,1,0),
	(5,'support','Contact for support.',1,0,0,0,0,1,0);

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups_users`;

CREATE TABLE `groups_users` (
  `user_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `groups_users` WRITE;
/*!40000 ALTER TABLE `groups_users` DISABLE KEYS */;

INSERT INTO `groups_users` (`user_id`, `group_id`)
VALUES
	(0,0),
	(0,0),
	(0,0),
	(0,0);

/*!40000 ALTER TABLE `groups_users` ENABLE KEYS */;
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
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_profile_picture_id` int(11) unsigned DEFAULT NULL,
  `game_cover_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upload_belongs_to_game` (`game_cover_id`),
  KEY `upload_belongs_to_user_as_profile_picture` (`user_profile_picture_id`),
  CONSTRAINT `upload_belongs_to_user_as_profile_picture` FOREIGN KEY (`user_profile_picture_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_game` FOREIGN KEY (`game_cover_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `hashed_password`, `created_at`, `first_name`, `last_name`)
VALUES
	(1,'admin@gamespot.com','21232f297a57a5a743894a0e4a801fc3','2014-02-23 12:20:13','Ammi','Nistratore'),
	(2,'an.leopardi@gmail.com','9003d1df22eb4d3820015070385194c8','2014-02-23 12:20:13','Andrea','Leopardi'),
	(3,'blogger@gamespot.com','9c1252fa60c847783a5281273c8a5d0c','2014-03-03 00:49:02','Blogga','Tore'),
	(4,'staff@gamespot.com','1253208465b1efa876f982d8a9e73eef','2014-02-24 23:49:05','Membero','Dello Staff');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
