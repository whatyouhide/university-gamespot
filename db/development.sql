# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.34-log)
# Database: gamespot
# Generation Time: 2014-09-01 22:05:07 +0000
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `console_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accessory_belongs_to_console` (`console_id`),
  CONSTRAINT `accessory_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;

INSERT INTO `accessories` (`id`, `name`, `release_date`, `producer`, `description`, `created_at`, `console_id`)
VALUES
	(1,'PlayStation Camera','2013-11-11','Sony','Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce in mauris orci. In imperdiet aliquet gravida. Quisque suscipit egestas convallis. Quisque mattis nisi at urna rhoncus faucibus. Ut sed sapien in libero porta gravida et eget risus. Curabitur blandit interdum lobortis. Aenean vitae mattis libero, ut pellentesque ligula. Aenean urna velit, semper eu sollicitudin a, fermentum a libero. Praesent pharetra volutpat justo, non iaculis mi porttitor mattis. Donec vel nulla orci. Suspendisse blandit orci arcu, eu placerat augue ultrices nec. Curabitur lectus metus, cursus nec condimentum eu, bibendum quis urna.','0000-00-00 00:00:00',1),
	(2,'PlayStation Eye','2008-08-01','Sony','Integer in volutpat massa. Aenean eleifend felis ligula, varius interdum elit ultricies vitae. Pellentesque eget elementum mauris. Aenean elementum mauris vitae orci eleifend, luctus rutrum leo tincidunt. Fusce consectetur massa nec elementum ultrices. Nam varius adipiscing tellus, ut hendrerit nunc eleifend non. Nulla in enim at tortor congue aliquam. Ut mi felis, euismod quis nunc eleifend, tristique pellentesque orci. Cras dignissim quis nulla quis ultricies. Nam in elit venenatis, aliquam leo at, venenatis velit. In tristique velit sit amet adipiscing ultricies. Fusce et posuere felis. Quisque at nibh libero. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus non egestas libero. Maecenas auctor, enim ut tempus iaculis, ante elit dictum metus, sit amet tempor neque dui nec urna.','0000-00-00 00:00:00',2),
	(3,'Xbox Kinect','2009-04-22','Microsoft','Donec quis pharetra tellus. Suspendisse molestie massa eu hendrerit laoreet. Proin est tellus, sollicitudin eu tincidunt at, egestas adipiscing odio. Etiam nec dolor placerat, tincidunt enim eu, vehicula lacus. Nulla sit amet luctus velit, ut posuere sapien. Nam lacinia lacus ac enim hendrerit, quis condimentum lacus faucibus. Suspendisse id lectus ac risus porttitor faucibus at a tellus. Curabitur imperdiet enim nec fringilla malesuada. Pellentesque congue accumsan neque.','0000-00-00 00:00:00',3);

/*!40000 ALTER TABLE `accessories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table accessory_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `accessory_notifications`;

CREATE TABLE `accessory_notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `accessory_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `accessory_id` (`accessory_id`),
  CONSTRAINT `accessory_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `accessory_notifications_ibfk_2` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `accessory_notifications` WRITE;
/*!40000 ALTER TABLE `accessory_notifications` DISABLE KEYS */;

INSERT INTO `accessory_notifications` (`id`, `user_id`, `accessory_id`)
VALUES
	(1,15,1),
	(2,15,2);

/*!40000 ALTER TABLE `accessory_notifications` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ads`;

CREATE TABLE `ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` float unsigned DEFAULT NULL,
  `description` text,
  `city` varchar(50) DEFAULT '',
  `type` varchar(10) NOT NULL DEFAULT '',
  `published` tinyint(1) unsigned DEFAULT '0',
  `author_id` int(11) unsigned NOT NULL,
  `console_id` int(11) unsigned DEFAULT NULL,
  `game_id` int(11) unsigned DEFAULT NULL,
  `accessory_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_belongs_to_user` (`author_id`),
  KEY `ad_belongs_to_console` (`console_id`),
  KEY `ad_belongs_to_game` (`game_id`),
  KEY `ad_belongs_to_accessory` (`accessory_id`),
  CONSTRAINT `ad_belongs_to_accessory` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ad_belongs_to_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ad_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ad_belongs_to_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;

INSERT INTO `ads` (`id`, `published_at`, `price`, `description`, `city`, `type`, `published`, `author_id`, `console_id`, `game_id`, `accessory_id`)
VALUES
	(6,'2014-08-31 15:55:57',87.45,'Cras dictum augue id iaculis dignissim. Nunc consequat mi in porta interdum. Nam tortor neque, auctor eget enim sit amet, ultrices semper mi. Sed non pharetra lacus, nec bibendum orci. Phasellus lobortis neque tortor, vitae ultrices arcu porttitor eu. Mauris non facilisis felis, interdum blandit enim. Proin mollis dignissim urna, id dignissim purus commodo vitae. Morbi tincidunt id sem vitae blandit. Proin mattis luctus nulla, eu congue quam eleifend lacinia. Quisque commodo, lectus sed tristique consectetur, felis felis condimentum neque, eu egestas diam tortor quis nisl. Nulla eleifend adipiscing tortor et rutrum. Duis vitae mauris augue. In tincidunt, lorem a malesuada egestas, urna arcu imperdiet metus, sed sodales justo est non odio. Nullam vestibulum vel sapien vitae aliquam. Suspendisse sagittis est sem, vel iaculis mi elementum a. Etiam dictum lectus magna, vitae porta est porttitor non.','Terni','game',1,1,3,1,NULL),
	(8,'2014-08-31 15:55:59',77.9,'Nunc elementum dolor non pretium consequat. Donec feugiat tincidunt tortor vitae eleifend. Vestibulum rhoncus justo et est bibendum, in sollicitudin turpis scelerisque. Nulla euismod ultricies eros, nec mattis magna dapibus vitae. Praesent lobortis laoreet gravida. Quisque nec arcu non lectus pharetra posuere non id diam. Vestibulum tincidunt mi non libero blandit tincidunt. Integer venenatis, nibh eget fringilla ornare, nulla enim tempor neque, at varius mauris nulla at nibh. Integer a pretium mauris, eget lacinia orci. Mauris viverra magna ut faucibus elementum. Morbi aliquam risus vel justo laoreet varius. Mauris sit amet nibh ipsum. In et luctus dolor. Nam dolor purus, eleifend non massa vel, suscipit elementum nibh. Nulla aliquet velit vitae dapibus elementum. Nunc nulla odio, malesuada eget gravida a, consectetur sed mi.','Pescara','game',1,1,4,2,NULL),
	(22,'2014-08-31 15:56:00',33,'r2r23r21','r2r','accessory',1,4,1,NULL,1),
	(23,'2014-08-31 15:56:00',33,'Hello description','Rome','game',1,4,1,1,NULL),
	(27,'2014-09-01 02:00:37',34.9,'Nunc sem magna, ornare non mi vitae, pellentesque condimentum lectus. Donec accumsan mattis interdum. Fusce quis dictum diam, nec pharetra felis. In arcu odio, consectetur eget eleifend eget, posuere vel turpis. Maecenas bibendum urna eu felis sollicitudin, id ultricies massa interdum. Nulla eget scelerisque tortor. Suspendisse posuere nisl eget leo congue aliquet. Integer euismod nibh eget ligula hendrerit eleifend id sit amet nisl. Morbi vitae iaculis velit, sit amet fringilla dolor. Ut sed nisi tortor. Vestibulum quis arcu sed augue ornare rhoncus. Nam enim lacus, hendrerit quis ex eget, euismod dictum nibh. Proin dui tortor, pellentesque in libero et, consequat elementum neque. Suspendisse consequat dui non massa lacinia imperdiet.','L\'Aquila','game',1,15,2,6,NULL),
	(28,'2014-09-01 13:13:04',99.9,'Sed ornare nunc ut massa hendrerit, nec pulvinar nibh sagittis. Cras pulvinar enim id nulla egestas viverra. Duis luctus metus quis ligula imperdiet, in tristique urna porta. Phasellus et ante vitae dui pulvinar faucibus. Ut eleifend nulla ut nibh ultrices feugiat. Sed viverra sit amet dolor eu semper. Curabitur et interdum ligula. Integer fringilla auctor turpis. Proin viverra tristique mi, ut maximus sapien imperdiet sit amet. Sed laoreet consequat est, non semper lectus placerat eget. In at leo eu leo tincidunt mattis. Praesent finibus urna eu velit efficitur eleifend non vitae lectus. Vestibulum varius lacinia pellentesque. Vestibulum euismod quam ultrices, eleifend libero vitae, lacinia lacus. Nulla ornare porta lorem quis molestie. Praesent blandit libero nisl, vel tincidunt risus viverra rutrum.','Los Angeles','accessory',1,15,1,NULL,1),
	(29,'2014-09-01 23:44:26',33,'qwdeqwedqwdqwedeqwdewqdqwdeqwdqewdqqw','rwqfqwdqwe','game',1,10,2,1,NULL),
	(30,'2014-09-01 23:58:02',22,'dewqdeqwd','dqwdqw','accessory',1,10,1,NULL,1);

/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table game_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `game_notifications`;

CREATE TABLE `game_notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `game_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `game_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `game_notifications_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `game_notifications` WRITE;
/*!40000 ALTER TABLE `game_notifications` DISABLE KEYS */;

INSERT INTO `game_notifications` (`id`, `user_id`, `game_id`)
VALUES
	(1,15,1),
	(3,15,2),
	(4,15,3),
	(5,15,4),
	(6,15,6);

/*!40000 ALTER TABLE `game_notifications` ENABLE KEYS */;
UNLOCK TABLES;


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


# Dump of table errors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `errors`;

CREATE TABLE `errors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `happened_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `errors` WRITE;
/*!40000 ALTER TABLE `errors` DISABLE KEYS */;

INSERT INTO `errors` (`id`, `message`, `happened_at`)
VALUES
	(1,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/c0048680948c34502569b43f15461084cc250e32.file.index.tpl.php','2014-08-31 18:53:00'),
	(2,'Uncaught  --> Smarty Compiler: Syntax error in template \"/Users/whatyouhide/Sites/gamespot/app/views/backend/index.tpl\"  on line 12 \"{if}\" missing if condition <-- \n  thrown','2014-08-31 18:53:45'),
	(3,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/fdc9d9744e0b87c43428b6557e3164b806f4df30.file.index.tpl.php','2014-08-31 19:00:01'),
	(4,'Uncaught exception \'Exception\' with message \'Error with the database: Unknown column \'online\' in \'where clause\'\nQuery: SELECT COUNT(*) FROM `users` WHERE `online` = \'1\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT COUNT(*)...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT COUNT(*)...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(68): Common\\Db::get_rows(\'SELECT COUNT(*)...\')\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(80): Common\\Db::array_from_one_column_query(\'SELECT COUNT(*)...\')\n#4 /Users/whatyouhide/Sites/gamespot/app/models/user.php(204): Common\\Db::number_from_query(\'SELECT COUNT(*)...\')\n#5 /Users/whatyouhide/Sites/gamespot/app/controllers/backend_application_controller.php(30): Models\\User::online_count()\n#6 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(10','2014-08-31 19:28:43'),
	(5,'Uncaught exception \'Exception\' with message \'Error with the database: Unknown column \'online\' in \'where clause\'\nQuery: SELECT COUNT(*) FROM `users` WHERE `online` = \'1\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT COUNT(*)...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT COUNT(*)...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(68): Common\\Db::get_rows(\'SELECT COUNT(*)...\')\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(80): Common\\Db::array_from_one_column_query(\'SELECT COUNT(*)...\')\n#4 /Users/whatyouhide/Sites/gamespot/app/models/user.php(204): Common\\Db::number_from_query(\'SELECT COUNT(*)...\')\n#5 /Users/whatyouhide/Sites/gamespot/app/controllers/backend_application_controller.php(30): Models\\User::online_count()\n#6 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(10','2014-08-31 19:30:47'),
	(6,'Uncaught exception \'Exception\' with message \'Error with the database: Unknown column \'online\' in \'where clause\'\nQuery: SELECT COUNT(*) FROM `users` WHERE `online` = 1\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT COUNT(*)...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT COUNT(*)...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(68): Common\\Db::get_rows(\'SELECT COUNT(*)...\')\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(80): Common\\Db::array_from_one_column_query(\'SELECT COUNT(*)...\')\n#4 /Users/whatyouhide/Sites/gamespot/app/models/user.php(204): Common\\Db::number_from_query(\'SELECT COUNT(*)...\')\n#5 /Users/whatyouhide/Sites/gamespot/app/controllers/backend_application_controller.php(30): Models\\User::online_count()\n#6 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(104)','2014-08-31 19:31:14'),
	(7,'Uncaught exception \'Exception\' with message \'Error with the database: Unknown column \'users.online\' in \'where clause\'\nQuery: SELECT * FROM `users` WHERE `users`.`online` = \'1\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT * FROM `...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT * FROM `...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(293): Common\\Db::get_rows(\'SELECT * FROM `...\')\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(215): Models\\Model::new_instances_from_query(\'SELECT * FROM `...\')\n#4 /Users/whatyouhide/Sites/gamespot/app/models/user.php(202): Models\\Model::where(Array)\n#5 /Users/whatyouhide/Sites/gamespot/app/controllers/backend_application_controller.php(30): Models\\User::online_count()\n#6 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(104): Contr','2014-08-31 19:32:47'),
	(8,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/93630bc495f480351daf742356d8552aa7293379.file.index.tpl.php','2014-08-31 19:40:15'),
	(9,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/0a3d6f5ffc25f54ddfa7beac4ceb0aaf29c271f4.file.index.tpl.php','2014-08-31 19:40:15'),
	(10,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/2e3257d90af80828975f66a0f3b65516bfba89d1.file.profile.tpl.php','2014-09-01 01:57:14'),
	(11,'Uncaught exception \'Exception\' with message \'Error with the database: Cannot add or update a child row: a foreign key constraint fails (`gamespot`.`ads`, CONSTRAINT `ad_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION)\nQuery: INSERT INTO `ads`(`type`, `author_id`) VALUES (\'game\', \'15\')\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'INSERT INTO `ad...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(250): Common\\Db::query(\'INSERT INTO `ad...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/controllers/ads_controller.php(64): Models\\Model::create(Array)\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(104): Controllers\\AdsController->nuevo()\n#4 /Users/whatyouhide/Sites/gamespot/app/classes/router.class.php(115): Controllers\\Controller->dispatch()\n#5 /Users/whatyouhide/Sites/gamesp','2014-09-01 01:57:17'),
	(12,'Uncaught exception \'Exception\' with message \'Error with the database: Cannot add or update a child row: a foreign key constraint fails (`gamespot`.`ads`, CONSTRAINT `ad_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION)\nQuery: INSERT INTO `ads`(`type`, `author_id`) VALUES (\'game\', \'15\')\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'INSERT INTO `ad...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(250): Common\\Db::query(\'INSERT INTO `ad...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/controllers/ads_controller.php(64): Models\\Model::create(Array)\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(104): Controllers\\AdsController->nuevo()\n#4 /Users/whatyouhide/Sites/gamespot/app/classes/router.class.php(115): Controllers\\Controller->dispatch()\n#5 /Users/whatyouhide/Sites/gamesp','2014-09-01 01:57:50'),
	(13,'Undefined index: accessory','2014-09-01 01:57:52'),
	(14,'Uncaught exception \'Exception\' with message \'Error with the database: Cannot add or update a child row: a foreign key constraint fails (`gamespot`.`ads`, CONSTRAINT `ad_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION)\nQuery: INSERT INTO `ads`(`type`, `author_id`) VALUES (\'game\', \'15\')\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'INSERT INTO `ad...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(250): Common\\Db::query(\'INSERT INTO `ad...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/controllers/ads_controller.php(64): Models\\Model::create(Array)\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(104): Controllers\\AdsController->nuevo()\n#4 /Users/whatyouhide/Sites/gamespot/app/classes/router.class.php(115): Controllers\\Controller->dispatch()\n#5 /Users/whatyouhide/Sites/gamesp','2014-09-01 01:57:53'),
	(15,'Undefined index: accessory','2014-09-01 01:59:34'),
	(16,'Trying to get property of non-object','2014-09-01 01:59:35'),
	(17,'Indirect modification of overloaded property Models\\Ad::$images has no effect','2014-09-01 02:00:31'),
	(18,'Undefined index: accessory','2014-09-01 02:00:39'),
	(19,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/2ae02da038d59bb04be0c498cfeef024e5db68ee.file.show.tpl.php','2014-09-01 02:01:26'),
	(20,'Call to undefined method Common\\Mailer::error_info()','2014-09-01 02:03:54'),
	(21,'Undefined index: accessory','2014-09-01 02:23:37'),
	(22,'Uncaught  --> Smarty Compiler: Syntax error in template \"/Users/whatyouhide/Sites/gamespot/app/views/index.tpl\"  on line 5 \"{image_path src=logo.png hoverable=true}\"  - Unexpected \".\", expected one of: \"}\" <-- \n  thrown','2014-09-01 09:21:14'),
	(23,'Trying to get property of non-object','2014-09-01 09:32:24'),
	(24,'Trying to get property of non-object','2014-09-01 09:32:30'),
	(25,'Uncaught exception \'Exception\' with message \'Error with the database: Unknown column \'\' in \'order clause\'\nQuery: SELECT * FROM `ads` ORDER BY `` DESC LIMIT 1\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT * FROM `...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT * FROM `...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT * FROM `...\')\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(238): Models\\Model::new_instances_from_query(\'SELECT * FROM `...\')\n#4 /Users/whatyouhide/Sites/gamespot/app/controllers/application_controller.php(21): Models\\Model::lastest_by_attribute(\'published_at\')\n#5 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(104): Controllers\\ApplicationController->index()\n#6 /Users/whatyouhide/Sites/gamespot/app/classes/router','2014-09-01 09:32:56'),
	(26,'Trying to get property of non-object','2014-09-01 09:33:14'),
	(27,'Call to undefined method Models\\Ad::lastest_by_attribute()','2014-09-01 09:33:50'),
	(28,'Trying to get property of non-object','2014-09-01 09:34:01'),
	(29,'Trying to get property of non-object','2014-09-01 09:34:24'),
	(30,'Trying to get property of non-object','2014-09-01 09:34:56'),
	(31,'Trying to get property of non-object','2014-09-01 10:30:43'),
	(32,'Trying to get property of non-object','2014-09-01 10:31:18'),
	(33,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/b148867a3b093f9353de21917a7427d8cba1008e.file.index.tpl.php','2014-09-01 10:35:07'),
	(34,'Trying to get property of non-object','2014-09-01 10:40:29'),
	(35,'Trying to get property of non-object','2014-09-01 10:40:40'),
	(36,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/902e1dacd39365737347fbe2feb4a2d0f34f3edd.file.edit.tpl.php','2014-09-01 11:15:30'),
	(37,'Undefined index: accessory','2014-09-01 12:09:47'),
	(38,'Undefined index: accessory','2014-09-01 12:41:22'),
	(39,'Undefined index: accessory','2014-09-01 12:42:54'),
	(40,'Undefined index: accessory','2014-09-01 12:43:13'),
	(41,'Uncaught exception \'Exception\' with message \'Error with the database: Table \'gamespot.games_ads\' doesn\'t exist\nQuery: SELECT\n      `ads`.`id` AS `ad_id`, `games`.*,\n      COUNT(*) `number_of_ads`\n      FROM `games_ads`\n      JOIN `games` ON `games_ads`.`game_id` = `games`.`id`\n      JOIN `ads` ON `games_ads`.`ad_id` = `ads`.`id`\n      GROUP BY `games`.`name`\n      ORDER BY `number_of_ads` DESC\n      LIMIT 5\n    \' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT?      `a...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT?      `a...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT?      `a...\')\n#3 /Users/whatyouhide/Sites/gamespot/app/models/game.php(113): Models\\Model::new_instances_from_query(\'SELECT?      `a...\')\n#4 /Users/whatyouhide/Sites/gamespot/app/controllers/games_c','2014-09-01 12:43:45'),
	(42,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/3d45c270fe4e4986585d5e7d0afd11e5b20c96e3.file.index.tpl.php','2014-09-01 12:43:49'),
	(43,'Undefined index: accessory','2014-09-01 12:44:00'),
	(44,'Undefined index: accessory','2014-09-01 12:44:18'),
	(45,'Undefined index: accessory','2014-09-01 12:44:21'),
	(46,'Undefined index: accessory','2014-09-01 12:45:09'),
	(47,'Undefined index: accessory','2014-09-01 12:45:40'),
	(48,'Undefined index: accessory','2014-09-01 12:45:41'),
	(49,'Undefined index: accessory','2014-09-01 12:45:53'),
	(50,'Undefined index: accessory','2014-09-01 12:45:54'),
	(51,'Undefined index: accessory','2014-09-01 12:45:55'),
	(52,'Undefined index: accessory','2014-09-01 12:45:56'),
	(53,'Undefined index: accessory','2014-09-01 12:46:01'),
	(54,'Undefined index: accessory','2014-09-01 12:46:02'),
	(55,'Undefined index: accessory','2014-09-01 12:46:32'),
	(56,'Undefined index: accessory','2014-09-01 12:46:33'),
	(57,'Undefined index: accessory','2014-09-01 12:47:19'),
	(58,'Undefined index: accessory','2014-09-01 12:47:20'),
	(59,'Undefined index: accessory','2014-09-01 12:48:01'),
	(60,'Undefined index: accessory','2014-09-01 12:48:01'),
	(61,'Undefined index: accessory','2014-09-01 12:48:03'),
	(62,'Undefined index: accessory','2014-09-01 12:48:10'),
	(63,'Undefined index: accessory','2014-09-01 12:48:51'),
	(64,'Undefined index: accessory','2014-09-01 12:48:52'),
	(65,'Undefined index: accessory','2014-09-01 12:49:05'),
	(66,'Undefined index: accessory','2014-09-01 12:49:06'),
	(67,'Undefined index: accessory','2014-09-01 12:49:17'),
	(68,'Undefined index: accessory','2014-09-01 12:49:18'),
	(69,'Undefined index: accessory','2014-09-01 12:49:40'),
	(70,'Undefined index: accessory','2014-09-01 12:50:56'),
	(71,'Undefined index: accessory','2014-09-01 12:50:57'),
	(72,'Undefined index: accessory','2014-09-01 12:51:10'),
	(73,'Undefined index: accessory','2014-09-01 12:51:10'),
	(74,'Undefined index: accessory','2014-09-01 12:51:17'),
	(75,'Undefined index: accessory','2014-09-01 12:51:39'),
	(76,'Undefined index: accessory','2014-09-01 12:51:40'),
	(77,'Undefined index: accessory','2014-09-01 12:51:41'),
	(78,'Undefined index: accessory','2014-09-01 12:51:49'),
	(79,'Undefined index: accessory','2014-09-01 12:51:50'),
	(80,'Undefined index: accessory','2014-09-01 12:52:04'),
	(81,'Undefined index: accessory','2014-09-01 12:52:23'),
	(82,'Undefined index: accessory','2014-09-01 12:52:44'),
	(83,'Undefined index: accessory','2014-09-01 12:52:57'),
	(84,'Undefined index: accessory','2014-09-01 12:52:58'),
	(85,'Undefined index: accessory','2014-09-01 12:53:06'),
	(86,'Undefined index: accessory','2014-09-01 12:53:07'),
	(87,'Undefined index: accessory','2014-09-01 12:53:25'),
	(88,'Undefined index: accessory','2014-09-01 12:53:37'),
	(89,'Undefined index: accessory','2014-09-01 12:53:55'),
	(90,'Undefined index: accessory','2014-09-01 12:53:56'),
	(91,'Undefined index: accessory','2014-09-01 12:53:57'),
	(92,'Undefined index: accessory','2014-09-01 12:53:57'),
	(93,'Undefined index: accessory','2014-09-01 12:54:01'),
	(94,'Undefined index: accessory','2014-09-01 12:54:23'),
	(95,'Undefined index: accessory','2014-09-01 12:54:24'),
	(96,'Undefined index: accessory','2014-09-01 12:54:24'),
	(97,'Undefined index: accessory','2014-09-01 12:54:26'),
	(98,'Undefined index: accessory','2014-09-01 12:54:44'),
	(99,'Undefined index: accessory','2014-09-01 12:54:45'),
	(100,'Undefined index: accessory','2014-09-01 12:54:59'),
	(101,'Undefined index: accessory','2014-09-01 12:54:59'),
	(102,'Indirect modification of overloaded property Models\\Ad::$images has no effect','2014-09-01 12:59:28'),
	(103,'Indirect modification of overloaded property Models\\Ad::$images has no effect','2014-09-01 12:59:31'),
	(104,'Undefined index: accessory','2014-09-01 13:09:12'),
	(105,'Trying to get property of non-object','2014-09-01 13:09:14'),
	(106,'Indirect modification of overloaded property Models\\Ad::$images has no effect','2014-09-01 13:09:35'),
	(107,'Indirect modification of overloaded property Models\\Ad::$images has no effect','2014-09-01 13:09:37'),
	(108,'Indirect modification of overloaded property Models\\Ad::$images has no effect','2014-09-01 13:09:39'),
	(109,'Call to a member function signed_out() on a non-object','2014-09-01 13:46:09'),
	(110,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/956b40e4486b55f7edb2247dbb2c6d7f14bb8424.file.edit.tpl.php','2014-09-01 17:53:56'),
	(111,'filemtime(): stat failed for /Users/whatyouhide/Sites/gamespot/templates_c/2264ec2b4ce86a90412f9d4cc6a07926f4fac73f.file.index.tpl.php','2014-09-01 18:13:33'),
	(112,'Uncaught exception \'Exception\' with message \'Error with the database: Undeclared variable: 1\nQuery: SELECT `games`.*, COUNT(*) `ads_count`\nFROM `ads`\nJOIN `games` ON `ads`.`game_id` = `games`.`id`\nWHERE `ads`.`type` = \'game\'\nGROUP BY `games`.`id`\nORDER BY `ads_count`\nLIMIT `1`\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT `games`....\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT `games`....\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT `games`....\')\n#3 /Users/whatyouhide/Sites/gamespot/app/models/game.php(109): Models\\Model::new_instances_from_query(\'SELECT `games`....\')\n#4 /Users/whatyouhide/Sites/gamespot/app/controllers/games_controller.php(20): Models\\Game::with_most_ads()\n#5 /Users/whatyouhide/Sites/gamespot/app/classes/controller.class.php(104): Controllers\\Ga','2014-09-01 18:14:58'),
	(113,'Uncaught exception \'Exception\' with message \'Error with the database: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\'1\'\' at line 7\nQuery: SELECT `games`.*, COUNT(*) `ads_count`\nFROM `ads`\nJOIN `games` ON `ads`.`game_id` = `games`.`id`\nWHERE `ads`.`type` = \'game\'\nGROUP BY `games`.`id`\nORDER BY `ads_count`\nLIMIT \'1\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT `games`....\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT `games`....\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT `games`....\')\n#3 /Users/whatyouhide/Sites/gamespot/app/models/game.php(109): Models\\Model::new_instances_from_query(\'SELECT `games`....\')\n#4 /Users/whatyouhide/Sites/gamespot/app/controllers/games_controller.p','2014-09-01 18:15:19'),
	(114,'Uncaught exception \'Exception\' with message \'Error with the database: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\'1\'\' at line 7\nQuery: SELECT `games`.*, COUNT(*) `ads_count`\nFROM `ads`\nJOIN `games` ON `ads`.`game_id` = `games`.`id`\nWHERE `ads`.`type` = \'game\'\nGROUP BY `games`.`id`\nORDER BY `ads_count`\nLIMIT \'1\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT `games`....\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT `games`....\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT `games`....\')\n#3 /Users/whatyouhide/Sites/gamespot/app/models/game.php(109): Models\\Model::new_instances_from_query(\'SELECT `games`....\')\n#4 /Users/whatyouhide/Sites/gamespot/app/controllers/games_controller.p','2014-09-01 18:15:22'),
	(115,'Uncaught exception \'Exception\' with message \'Error with the database: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\'1\'\' at line 7\nQuery: SELECT `games`.*, COUNT(*) ads_count\nFROM `ads`\nJOIN `games` ON `ads`.`game_id` = `games`.`id`\nWHERE `ads`.`type` = \'game\'\nGROUP BY `games`.`id`\nORDER BY ads_count\nLIMIT \'1\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT `games`....\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT `games`....\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT `games`....\')\n#3 /Users/whatyouhide/Sites/gamespot/app/models/game.php(109): Models\\Model::new_instances_from_query(\'SELECT `games`....\')\n#4 /Users/whatyouhide/Sites/gamespot/app/controllers/games_controller.php(2','2014-09-01 18:15:51'),
	(116,'Uncaught exception \'Exception\' with message \'Error with the database: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\'1\'\' at line 7\nQuery: SELECT `games`.*, COUNT(*) ads_count\nFROM `ads`\nJOIN `games` ON `ads`.`game_id` = `games`.`id`\nWHERE `ads`.`type` = \'game\'\nGROUP BY `games`.`id`\nORDER BY ads_count\nLIMIT \'1\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT `games`....\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT `games`....\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT `games`....\')\n#3 /Users/whatyouhide/Sites/gamespot/app/models/game.php(109): Models\\Model::new_instances_from_query(\'SELECT `games`....\')\n#4 /Users/whatyouhide/Sites/gamespot/app/controllers/games_controller.php(2','2014-09-01 18:15:53'),
	(117,'Uncaught exception \'Exception\' with message \'Error with the database: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\'1\'\' at line 7\nQuery: SELECT `games`.*, COUNT(*) ads_count\nFROM `ads`\nJOIN `games` ON `ads`.`game_id` = `games`.`id`\nWHERE `ads`.`type` = \'game\'\nGROUP BY `games`.`id`\nORDER BY ads_count DESC\nLIMIT \'1\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT `games`....\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT `games`....\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT `games`....\')\n#3 /Users/whatyouhide/Sites/gamespot/app/models/game.php(109): Models\\Model::new_instances_from_query(\'SELECT `games`....\')\n#4 /Users/whatyouhide/Sites/gamespot/app/controllers/games_controller.','2014-09-01 18:16:17'),
	(118,'Object of class Models\\Game could not be converted to string','2014-09-01 18:17:26'),
	(119,'Object of class Models\\Game could not be converted to string','2014-09-01 18:17:35'),
	(120,'Trying to get property of non-object','2014-09-01 18:21:04'),
	(121,'Undefined index: max-price','2014-09-01 18:54:24'),
	(122,'Undefined index: max-price','2014-09-01 18:54:31'),
	(123,'Undefined index: max-price','2014-09-01 18:54:36'),
	(124,'Undefined index: max-price','2014-09-01 18:55:31'),
	(125,'Undefined index: max-price','2014-09-01 18:56:22'),
	(126,'Trying to get property of non-object','2014-09-01 19:08:42'),
	(127,'Trying to get property of non-object','2014-09-01 19:08:44'),
	(128,'Undefined index: max-price','2014-09-01 19:43:13'),
	(129,'Undefined index: max-price','2014-09-01 19:43:16'),
	(130,'Call to undefined method Models\\GameNotification::create()','2014-09-01 22:55:31'),
	(131,'Uncaught exception \'Exception\' with message \'Error with the database: Unknown column \'game_notifications.id\' in \'where clause\'\nQuery: SELECT * FROM `game_notifications` WHERE `game_notifications`.`id` = \'0\'\' in /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php:140\nStack trace:\n#0 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(44): Common\\Db::throw_exception_if_error(\'SELECT * FROM `...\')\n#1 /Users/whatyouhide/Sites/gamespot/app/classes/db.class.php(53): Common\\Db::query(\'SELECT * FROM `...\')\n#2 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(308): Common\\Db::get_rows(\'SELECT * FROM `...\')\n#3 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(215): Models\\Model::new_instances_from_query(\'SELECT * FROM `...\')\n#4 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(184): Models\\Model::where(Array)\n#5 /Users/whatyouhide/Sites/gamespot/app/classes/model.class.php(268): Models\\Model::find(0)\n#6 /Users/whatyouhide/Sites/gamespot/app/controllers/games_controller.','2014-09-01 22:55:56'),
	(132,'session_start(): Cannot send session cache limiter - headers already sent (output started at /Users/whatyouhide/Sites/gamespot/app/models/accessory_notification.php:33)','2014-09-01 23:06:33'),
	(133,'Class \'Controllers\\AccessoryNotification\' not found','2014-09-01 23:06:34'),
	(134,'Call to undefined method Models\\AccessoryNotification::tie_up_user_and_accessory()','2014-09-01 23:07:37'),
	(135,'Cannot modify header information - headers already sent by (output started at /Users/whatyouhide/Sites/gamespot/app/models/accessory_notification.php:33)','2014-09-01 23:08:04'),
	(136,'Call to undefined method Models\\GameNotification::tie_up_user_and_accessory()','2014-09-01 23:29:12'),
	(137,'Undefined index: accessory','2014-09-01 23:34:28'),
	(138,'Trying to get property of non-object','2014-09-01 23:34:30'),
	(139,'Undefined index: from_name','2014-09-01 23:34:49'),
	(140,'Cannot modify header information - headers already sent by (output started at /Users/whatyouhide/Sites/gamespot/app/functions.php:39)','2014-09-01 23:45:13'),
	(141,'Cannot modify header information - headers already sent by (output started at /Users/whatyouhide/Sites/gamespot/app/functions.php:39)','2014-09-01 23:45:34'),
	(142,'Cannot modify header information - headers already sent by (output started at /Users/whatyouhide/Sites/gamespot/app/functions.php:39)','2014-09-01 23:45:57'),
	(143,'Undefined index: accessory','2014-09-01 23:57:03'),
	(144,'Trying to get property of non-object','2014-09-01 23:57:05'),
	(145,'Undefined index: max-price','2014-09-02 00:00:27');

/*!40000 ALTER TABLE `errors` ENABLE KEYS */;
UNLOCK TABLES;


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
	(6,'Sport'),
	(7,'Strategy'),
	(8,'Adventure'),
	(9,'Test category');

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
  CONSTRAINT `game_belongs_to_console` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `game_belongs_to_game_category` FOREIGN KEY (`game_category_id`) REFERENCES `game_categories` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`id`, `name`, `release_date`, `description`, `software_house`, `created_at`, `console_id`, `game_category_id`)
VALUES
	(1,'1886: The Order','2014-02-23','Integer turpis erat, gravida vitae lacinia id, congue ac eros. Etiam sodales velit porttitor iaculis porttitor. Nullam condimentum lorem sit amet interdum euismod. Nulla cursus eros sed condimentum pharetra. Fusce sodales sed justo et consectetur. Duis congue odio nunc, ut accumsan elit euismod eget. Aenean tempor velit in lectus elementum, quis semper lacus auctor. Ut nisi enim, mattis vel lorem ac, vehicula dictum sapien. Praesent auctor mauris turpis, ac venenatis metus rutrum vitae. Aliquam dolor tellus, rhoncus ac tincidunt mattis, consectetur eget risus.','SWHouse','2014-02-23 12:17:19',2,8),
	(2,'Battlefield 4','2013-11-29','Curabitur convallis tortor vitae massa vehicula, sed tincidunt turpis malesuada. Curabitur aliquet eu nunc nec commodo. Maecenas faucibus augue id sem porta, sed ultricies tortor posuere. Nullam sed nulla sed lectus placerat tristique. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin eros erat, venenatis sit amet leo non, scelerisque auctor tellus. Quisque vel tellus ut sem euismod pharetra. Ut iaculis magna volutpat laoreet venenatis. Integer quis massa mauris. In luctus eros quis purus vehicula posuere. Phasellus sed sapien neque. Proin bibendum leo vitae lectus luctus, sed convallis eros pulvinar. Ut interdum turpis nisl, non commodo orci facilisis eget. Nunc faucibus urna ac dolor semper, quis iaculis nisi consequat.','Dice','2014-02-24 00:50:17',2,2),
	(3,'Beyond','2013-05-05','Nullam venenatis quis augue vel pellentesque. Fusce sed neque quam. Praesent ante purus, ultrices quis augue ut, cursus vehicula diam. In non eros justo. Ut molestie mattis placerat. Vestibulum et lobortis arcu, ac tempus diam. Integer eget lacinia leo. Aenean at neque accumsan, suscipit lacus vitae, convallis libero. Etiam sit amet eros a augue dapibus semper nec viverra augue. Praesent id malesuada nisi. Sed ultricies, neque ac euismod adipiscing, velit enim porta elit, sed feugiat nunc nunc n','Bethesda','2014-02-23 12:17:18',1,7),
	(4,'Call Of Duty: Ghosts','2013-11-14','Donec aliquet, velit sed mollis luctus, orci lacus tincidunt tellus, ac blandit est orci quis metus. In gravida elit ligula. Donec vel augue sit amet lorem imperdiet tincidunt ut lacinia elit. Morbi eleifend viverra diam non rhoncus. Proin suscipit tortor non mauris congue, eget tristique ligula commodo. Sed pellentesque dapibus molestie. Aenean dui mi, pretium at nulla in, suscipit euismod mauris. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi laoreet diam ut ligula ullamcorper blandit. Mauris vulputate posuere magna ut feugiat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor non felis et placerat. Pellentesque dignissim odio malesuada felis placerat dignissim sit amet vitae magna. Suspendisse nec aliquam magna, sit amet aliquam augue. Praesent dictum egestas est, sit amet scelerisque leo pellentesque sit amet. Mauris et interdum lacus, in tristique eros.','Activision','2014-02-23 12:23:04',1,2),
	(5,'Fifa 14','2013-09-09','Nullam tincidunt gravida leo, vitae gravida lorem. Aenean tellus nisl, euismod vel risus in, scelerisque bibendum dolor. Suspendisse lacinia tortor sem, et pulvinar orci adipiscing vitae. Cras rutrum nisi et varius tincidunt. Nam semper nunc lectus, at molestie ligula ultrices eu. Nam pretium neque quis turpis varius semper. Fusce vestibulum libero auctor augue fringilla, sed luctus magna elementum. Curabitur eu eros nec lacus aliquam lacinia a non est. Ut nec diam non justo gravida blandit. Pha','EA Sports','2014-02-23 12:17:29',1,6),
	(6,'Knack','2014-01-01','Quisque aliquam mi ac posuere dignissim. Aliquam erat volutpat. Cras pellentesque quam et massa pretium, sed tincidunt mi consectetur. Sed in tortor in augue tempus tristique. In pulvinar tortor vel sem tempus posuere. Ut nec dolor blandit, accumsan enim a, ullamcorper lectus. Etiam hendrerit non enim vel suscipit. Quisque neque ipsum, blandit eu fringilla id, feugiat eu ante. Morbi vulputate tincidunt nulla, eget luctus leo sollicitudin quis. Fusce bibendum dictum convallis.','Sony','2014-02-24 00:55:17',2,8),
	(7,'The Last of Us','2013-01-01','Curabitur lobortis suscipit porta. Nulla.','Naughty Dogs','2014-02-23 12:17:10',1,2);

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_blog` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_manage_products` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_manage_ads` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_manage_support` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_block_users` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `is_admin`, `can_blog`, `can_manage_products`, `can_manage_ads`, `can_manage_support`, `can_block_users`)
VALUES
	(1,'admins',1,1,1,1,1,1),
	(2,'bloggers',0,1,0,0,0,0),
	(3,'staff',0,0,1,1,1,1),
	(4,'moderators',0,0,0,1,0,0),
	(5,'support',0,0,0,0,1,0);

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `excerpt` text,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published_at` timestamp NULL DEFAULT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_belongs_to_user` (`author_id`),
  CONSTRAINT `post_belongs_to_user` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `title`, `excerpt`, `content`, `updated_at`, `published_at`, `published`, `author_id`)
VALUES
	(2,'The post with tags','A nice excerpt isn\'t long.','<p>Phasellus dignissim tempor urna eget consequat. Vestibulum bibendum porta eleifend. Mauris auctor, metus et fringilla hendrerit, lectus magna facilisis erat, non imperdiet sapien lectus eu sem. Integer interdum felis eu est lobortis, sed scelerisque dolor vestibulum. Mauris sit amet pulvinar ligula. Donec tincidunt dui laoreet, pharetra turpis quis, laoreet neque. Etiam ut mattis elit. In vel turpis at urna suscipit dignissim. Donec ullamcorper velit sit amet dapibus malesuada. Nullam at lorem diam. Nullam consectetur venenatis diam, in posuere mauris sollicitudin fermentum. Morbi eu tellus sit amet elit pulvinar ullamcorper. Vivamus sed dolor sit amet arcu porta pretium at sit amet erat. Morbi ac dolor ornare, faucibus nibh sed, scelerisque justo. Proin vel condimentum nibh.</p>','2014-09-01 11:15:33',NULL,0,1),
	(6,'dqewdqw','dqewdqew','<p>dqwdqwed</p>','2014-08-27 13:02:38','2014-08-27 13:02:38',1,14),
	(7,'Dedicato a teh','ChissÃ  dove chissÃ  coooome?','<p>E ascoltare senza <strong>interruzioniiiiiiiiiiiii</strong>!</p>','2014-09-01 11:23:53','2014-08-29 19:52:03',1,1);

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_tags`;

CREATE TABLE `posts_tags` (
  `post_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL,
  KEY `posts_tags_references_posts` (`post_id`),
  KEY `posts_tags_references_tags` (`tag_id`),
  CONSTRAINT `posts_tags_references_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `posts_tags_references_tags` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `posts_tags` WRITE;
/*!40000 ALTER TABLE `posts_tags` DISABLE KEYS */;

INSERT INTO `posts_tags` (`post_id`, `tag_id`)
VALUES
	(2,7),
	(2,4),
	(2,8),
	(2,26),
	(2,25),
	(2,18),
	(2,24),
	(7,2),
	(7,27);

/*!40000 ALTER TABLE `posts_tags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table support_tickets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `support_tickets`;

CREATE TABLE `support_tickets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `topic` varchar(255) DEFAULT NULL,
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `support_ticket_belongs_to_author` (`author_id`),
  CONSTRAINT `support_ticket_belongs_to_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `support_tickets` WRITE;
/*!40000 ALTER TABLE `support_tickets` DISABLE KEYS */;

INSERT INTO `support_tickets` (`id`, `title`, `closed`, `content`, `topic`, `author_id`)
VALUES
	(1,'Test ticket',0,'This is a support ticket. It works, doesn\'t it?','help',1),
	(2,'Another ticket, you suck.',0,'Vestibulum a condimentum nisl. Pellentesque ac feugiat quam, et ullamcorper metus. Fusce sed mauris dapibus, vestibulum ex vel, ornare erat. Fusce sed consectetur urna. Aenean tincidunt nunc a pellentesque elementum. Donec finibus ex ac nulla tempus, eu dictum lorem facilisis. Praesent pellentesque lectus id erat tristique, id elementum est imperdiet. Ut ut placerat ante. Duis maximus arcu quis eros dignissim, vitae sagittis odio scelerisque. Maecenas malesuada, sem ac malesuada faucibus, turpis turpis posuere dui, in iaculis arcu eros et tortor. Integer eget blandit metus. Nam accumsan volutpat pellentesque. Nunc tempor ex id dui ullamcorper placerat. Curabitur semper augue sed viverra lobortis. Sed pellentesque turpis vel viverra scelerisque. Aliquam erat volutpat.\r\n\r\nVivamus ac purus aliquet, imperdiet leo quis, pharetra ipsum. Etiam urna ex, hendrerit sit amet turpis non, accumsan vestibulum urna. Aliquam tempus sem consectetur pellentesque egestas. Maecenas convallis, nibh nec egestas lobortis, dui neque hendrerit mi, id finibus ex sapien vel ligula. Pellentesque cursus consequat leo vitae vestibulum. Nunc risus eros, vehicula non risus in, imperdiet mattis ante. Pellentesque elit risus, hendrerit in erat at, pretium ullamcorper augue. Sed ante nibh, pulvinar eu nisl vel, congue tincidunt dui. Phasellus accumsan turpis a tortor condimentum sollicitudin. Nam ut tincidunt sem, in elementum quam. Sed fringilla sit amet nisl non pharetra. Cras dui dolor, faucibus quis malesuada ut, interdum ut ipsum. Quisque nec ipsum dolor. Nullam a orci rhoncus, posuere ligula id, eleifend mauris. Vestibulum scelerisque placerat nulla in tincidunt.\r\n\r\nDonec sed gravida purus, vitae porta orci. Praesent pulvinar magna ante, quis tempus massa rhoncus et. Cras congue lorem lectus. Sed euismod ac sem nec egestas. Nullam ac eros vel sapien auctor sollicitudin vel eget odio. Suspendisse fermentum vestibulum mattis. Duis sit amet dolor commodo, ultricies enim eget, accumsan nisi. Morbi blandit nulla vel ex tincidunt maximus. Aenean dictum ex eget nisl rhoncus vestibulum.','complain',10);

/*!40000 ALTER TABLE `support_tickets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;

INSERT INTO `tags` (`id`, `name`)
VALUES
	(10,'4'),
	(2,'announcements'),
	(27,'cool-stuff'),
	(4,'dew'),
	(9,'dewdew'),
	(26,'diosololosa'),
	(8,'dw'),
	(7,'dwedeqwedqwfqw'),
	(24,'eeeeeeeeeeeeeeee'),
	(11,'ewfqw'),
	(25,'ppopopopopop'),
	(3,'promotions'),
	(18,'qcwnckqepfvqerqr'),
	(23,'qdqewdqwdqwdqwdqewdqweowjooooo'),
	(16,'qwfe'),
	(19,'sane-tag'),
	(1,'test-tag'),
	(20,'ttttt'),
	(22,'wdewdewdewdew');

/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;


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
  `post_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upload_belongs_to_game` (`game_cover_id`),
  KEY `upload_belongs_to_user_as_profile_picture` (`user_profile_picture_id`),
  KEY `upload_belongs_to_accessory` (`accessory_image_id`),
  KEY `upload_belongs_to_ad` (`ad_id`),
  KEY `upload_belongs_to_console` (`console_image_id`),
  KEY `upload_belongs_to_post` (`post_id`),
  CONSTRAINT `upload_belongs_to_accessory` FOREIGN KEY (`accessory_image_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_ad` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_console` FOREIGN KEY (`console_image_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_game` FOREIGN KEY (`game_cover_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `upload_belongs_to_user_as_profile_picture` FOREIGN KEY (`user_profile_picture_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;

INSERT INTO `uploads` (`id`, `url`, `size`, `mime_type`, `uploaded_at`, `user_profile_picture_id`, `game_cover_id`, `accessory_image_id`, `console_image_id`, `ad_id`, `post_id`)
VALUES
	(18,'18/1373496404.jpg',331732,'image/jpeg','2014-08-19 18:02:02',NULL,NULL,NULL,NULL,23,NULL),
	(19,'19/1373299467.jpg',230637,'image/jpeg','2014-08-19 18:21:56',NULL,NULL,NULL,NULL,23,NULL),
	(20,'20/1373298726.jpg',193272,'image/jpeg','2014-08-19 18:21:56',NULL,NULL,NULL,NULL,23,NULL),
	(21,'21/1373334244.jpg',352374,'image/jpeg','2014-08-19 18:21:56',NULL,NULL,NULL,NULL,23,NULL),
	(54,'54/ClitIrD.jpg',113613,'image/jpeg','2014-08-26 19:10:21',10,NULL,NULL,NULL,NULL,NULL),
	(56,'56/2013-08-24 21.47.15.jpg',2117499,'image/jpeg','2014-08-29 17:24:47',4,NULL,NULL,NULL,NULL,NULL),
	(57,'57/1370955297-knack-2.jpg',1659155,'image/jpeg','2014-09-01 02:00:31',NULL,NULL,NULL,NULL,27,NULL),
	(58,'58/3EtzCi3.jpg',105741,'image/jpeg','2014-09-01 12:59:28',NULL,NULL,NULL,NULL,27,NULL),
	(59,'59/5IljutD.jpg',24264,'image/jpeg','2014-09-01 12:59:31',NULL,NULL,NULL,NULL,27,NULL),
	(60,'60/4fQKn7c.png',465936,'image/png','2014-09-01 13:09:35',NULL,NULL,NULL,NULL,28,NULL),
	(61,'61/8l15GYP.jpg',100841,'image/jpeg','2014-09-01 13:09:37',NULL,NULL,NULL,NULL,28,NULL),
	(62,'62/bmOq96z.png',2032377,'image/png','2014-09-01 13:09:39',NULL,NULL,NULL,NULL,28,NULL),
	(63,'63/fifa14-poland-cover.jpg',500669,'image/jpeg','2014-09-01 19:30:24',NULL,5,NULL,NULL,NULL,NULL);

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
  `signed_in` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `blocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `resetting` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reset_token` varchar(255) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `email`, `hashed_password`, `created_at`, `first_name`, `last_name`, `signed_in`, `blocked`, `resetting`, `reset_token`, `confirmed`, `confirmation_token`, `group_id`)
VALUES
	(1,'admin@gamespot.com','21232f297a57a5a743894a0e4a801fc3','2014-02-23 12:20:13','Ammi','Nistratore',0,0,0,NULL,1,NULL,1),
	(4,'staff@gamespot.com','1253208465b1efa876f982d8a9e73eef','2014-02-24 23:49:05','Membero','Dello Staff',0,0,0,NULL,1,NULL,3),
	(10,'regular@gamespot.com','af37d08ae228a87dc6b265fd1019c97d','2014-08-21 14:16:34','Regolare','Userone',1,0,0,NULL,1,NULL,NULL),
	(11,'support@gamespot.com','434990c8a25d2be94863561ae98bd682','2014-08-21 15:07:29','Suppor','Tomini',0,0,0,NULL,1,NULL,5),
	(14,'blogger@gamespot.com','c8eb6ea7e78913e97329f6eee2cdef5d','2014-08-24 19:31:38','Blo','Ghero',0,0,0,NULL,1,NULL,2),
	(15,'an.leopardi@gmail.com','9003d1df22eb4d3820015070385194c8','2014-08-25 19:05:09','Andrea','Leopardi',1,0,0,NULL,1,NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table visits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `visits`;

CREATE TABLE `visits` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `visited_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `count` bigint(20) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;

INSERT INTO `visits` (`id`, `url`, `ip`, `visited_at`, `count`)
VALUES
	(5,'/backend/game_categories','::1','2014-08-31 18:21:31',16),
	(6,'/backend/ads','::1','2014-08-31 18:21:48',6),
	(7,'/backend/groups','::1','2014-08-31 18:26:06',16),
	(8,'/backend','::1','2014-08-31 18:33:57',134),
	(9,'/backend/accessories','::1','2014-08-31 18:50:47',16),
	(10,'/backend/posts','::1','2014-08-31 18:52:59',83),
	(11,'/backend/support_tickets','::1','2014-08-31 18:53:01',28),
	(12,'/backend/users','::1','2014-08-31 18:53:02',18),
	(13,'/backend/errors','::1','2014-08-31 19:00:01',11),
	(14,'/backend/consoles','::1','2014-08-31 19:40:15',45),
	(15,'/backend/games','::1','2014-08-31 19:40:15',18),
	(16,'/','::1','2014-08-31 19:41:21',170),
	(17,'/users/sign_out','::1','2014-08-31 19:41:25',18),
	(18,'/users/sign_in','::1','2014-08-31 19:41:25',45),
	(19,'/users/forgot_password','::1','2014-09-01 01:56:10',1),
	(20,'/users/profile','::1','2014-09-01 01:57:14',74),
	(21,'/ads/nuevo?type=game','::1','2014-09-01 01:57:17',5),
	(22,'/ads/edit?id=27','::1','2014-09-01 01:59:35',54),
	(23,'/ads/update?id=27','::1','2014-09-01 01:59:54',3),
	(24,'/ads/upload_image?id=27','::1','2014-09-01 02:00:31',3),
	(25,'/ads','::1','2014-09-01 02:01:21',95),
	(26,'/ads/show?id=27','::1','2014-09-01 02:01:25',65),
	(27,'/ads/contact','::1','2014-09-01 02:01:31',14),
	(28,'/backend/users/block?id=10','::1','2014-09-01 10:31:56',1),
	(29,'/backend/users/block?id=15','::1','2014-09-01 10:34:14',1),
	(30,'/backend/users/unblock?id=15','::1','2014-09-01 10:34:16',1),
	(31,'/backend/users/unblock?id=10','::1','2014-09-01 10:34:18',1),
	(32,'/backend/staff_members','::1','2014-09-01 10:34:23',8),
	(33,'/backend/posts/edit?id=2','::1','2014-09-01 11:15:30',2),
	(34,'/backend/posts/toggle_published?id=2','::1','2014-09-01 11:15:33',1),
	(35,'/backend/posts/edit?id=7','::1','2014-09-01 11:21:22',22),
	(36,'/backend/posts/update?id=7','::1','2014-09-01 11:21:25',4),
	(37,'/backend/tags/create','::1','2014-09-01 11:21:32',1),
	(38,'/backend/support_tickets/show?id=1','::1','2014-09-01 11:36:34',15),
	(39,'/backend/support_tickets/toggle_closed?id=1','::1','2014-09-01 11:38:04',2),
	(40,'/backend/support_tickets/show?id=2','::1','2014-09-01 11:40:27',1),
	(41,'/support','::1','2014-09-01 11:41:11',2),
	(42,'/ads/show?id=23','::1','2014-09-01 12:19:15',2),
	(43,'/ads/show?id=6','::1','2014-09-01 12:20:01',2),
	(44,'/users/settings','::1','2014-09-01 12:43:25',2),
	(45,'/games','::1','2014-09-01 12:43:45',149),
	(46,'/accessories','::1','2014-09-01 12:43:49',42),
	(47,'/ads/nuevo?type=accessory','::1','2014-09-01 13:09:14',2),
	(48,'/ads/edit?id=28','::1','2014-09-01 13:09:14',14),
	(49,'/ads/update?id=28','::1','2014-09-01 13:09:31',2),
	(50,'/ads/upload_image?id=28','::1','2014-09-01 13:09:35',3),
	(51,'/backend/game_categories/create','::1','2014-09-01 13:58:17',1),
	(52,'/backend/games/edit?id=1','::1','2014-09-01 17:53:56',13),
	(53,'/backend/games/update?id=1','::1','2014-09-01 17:57:22',1),
	(54,'/backend/games/edit?id=2','::1','2014-09-01 17:57:24',1),
	(55,'/ads/by_game?id=1','::1','2014-09-01 18:54:24',2),
	(56,'/ads/filter?game=1&type=game','::1','2014-09-01 18:54:24',2),
	(57,'/ads/by_game?id=2','::1','2014-09-01 18:54:35',1),
	(58,'/ads/filter?game=2&type=game','::1','2014-09-01 18:54:36',1),
	(59,'/ads/by_accessory?id=1','::1','2014-09-01 18:55:31',3),
	(60,'/ads/filter?accessory=1&type=accessory','::1','2014-09-01 18:55:31',4),
	(61,'/ads/filter?console=&city=&type=game&game=3&max-price=0','::1','2014-09-01 18:55:35',1),
	(62,'/ads/by_game?id=6','::1','2014-09-01 18:56:22',1),
	(63,'/ads/filter?game=6&type=game','::1','2014-09-01 18:56:22',1),
	(64,'/ads/show?id=28','::1','2014-09-01 18:56:26',18),
	(65,'/backend/games/edit?id=5','::1','2014-09-01 19:30:17',2),
	(66,'/backend/games/update?id=5','::1','2014-09-01 19:30:24',1),
	(67,'/games/subscribe?id=1','::1','2014-09-01 22:55:31',8),
	(68,'/games/subscribe?id=2','::1','2014-09-01 23:02:57',2),
	(69,'/accessories/subscribe?id=1','::1','2014-09-01 23:06:34',6),
	(70,'/accessories/subscribe?id=2','::1','2014-09-01 23:08:48',1),
	(71,'/games/subscribe?id=3','::1','2014-09-01 23:33:48',1),
	(72,'/games/subscribe?id=4','::1','2014-09-01 23:33:51',1),
	(73,'/games/subscribe?id=6','::1','2014-09-01 23:33:55',1),
	(74,'/ads/edit?id=29','::1','2014-09-01 23:34:30',8),
	(75,'/ads/update?id=29','::1','2014-09-01 23:34:43',12),
	(76,'/ads/show?id=29','::1','2014-09-01 23:48:19',1),
	(77,'/ads/edit?id=30','::1','2014-09-01 23:57:05',4),
	(78,'/ads/update?id=30','::1','2014-09-01 23:57:13',5),
	(79,'/ads/show?id=30','::1','2014-09-01 23:58:38',1);

/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
