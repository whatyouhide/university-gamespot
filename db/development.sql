-- MySQL dump 10.13  Distrib 5.5.34, for osx10.6 (i386)
--
-- Host: localhost    Database: gamespot
-- ------------------------------------------------------
-- Server version	5.5.34

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
-- Table structure for table `accessories`
--

DROP TABLE IF EXISTS `accessories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accessories` (
  `name` varchar(50) NOT NULL DEFAULT '',
  `release_date` date DEFAULT NULL,
  `description` text,
  `console_name` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accessories`
--

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;
INSERT INTO `accessories` VALUES ('PlayStation Camera','2013-11-11','Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce in mauris orci. In imperdiet aliquet gravida. Quisque suscipit egestas convallis. Quisque mattis nisi at urna rhoncus faucibus. Ut sed sapien in libero porta gravida et eget risus. Curabitur blandit interdum lobortis. Aenean vitae mattis libero, ut pellentesque ligula. Aenean urna velit, semper eu sollicitudin a, fermentum a libero. Praesent pharetra volutpat justo, non iaculis mi porttitor mattis. Donec vel nulla orci. Suspendisse blandit orci arcu, eu placerat augue ultrices nec. Curabitur lectus metus, cursus nec condimentum eu, bibendum quis urna.','PlayStation 4');
INSERT INTO `accessories` VALUES ('PlayStation Eye','2008-08-01','Integer in volutpat massa. Aenean eleifend felis ligula, varius interdum elit ultricies vitae. Pellentesque eget elementum mauris. Aenean elementum mauris vitae orci eleifend, luctus rutrum leo tincidunt. Fusce consectetur massa nec elementum ultrices. Nam varius adipiscing tellus, ut hendrerit nunc eleifend non. Nulla in enim at tortor congue aliquam. Ut mi felis, euismod quis nunc eleifend, tristique pellentesque orci. Cras dignissim quis nulla quis ultricies. Nam in elit venenatis, aliquam leo at, venenatis velit. In tristique velit sit amet adipiscing ultricies. Fusce et posuere felis. Quisque at nibh libero. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus non egestas libero. Maecenas auctor, enim ut tempus iaculis, ante elit dictum metus, sit amet tempor neque dui nec urna.','PlayStation 3');
INSERT INTO `accessories` VALUES ('Xbox Kinect','2009-04-22','Donec quis pharetra tellus. Suspendisse molestie massa eu hendrerit laoreet. Proin est tellus, sollicitudin eu tincidunt at, egestas adipiscing odio. Etiam nec dolor placerat, tincidunt enim eu, vehicula lacus. Nulla sit amet luctus velit, ut posuere sapien. Nam lacinia lacus ac enim hendrerit, quis condimentum lacus faucibus. Suspendisse id lectus ac risus porttitor faucibus at a tellus. Curabitur imperdiet enim nec fringilla malesuada. Pellentesque congue accumsan neque.','Xbox 360');
/*!40000 ALTER TABLE `accessories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accessory_ads`
--

DROP TABLE IF EXISTS `accessory_ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accessory_ads` (
  `ad_id` int(11) unsigned NOT NULL,
  `accessory_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accessory_ads`
--

LOCK TABLES `accessory_ads` WRITE;
/*!40000 ALTER TABLE `accessory_ads` DISABLE KEYS */;
INSERT INTO `accessory_ads` VALUES (4,'PlayStation Eye');
/*!40000 ALTER TABLE `accessory_ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `street` varchar(60) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` float unsigned NOT NULL,
  `description` text,
  `city` varchar(50) NOT NULL,
  `console_name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='TODO: vincolo di integrità per fare in modo che ci siano un solo gioco o un solo accessorio (mai entrambi nulli/non nulli) per annuncio.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
INSERT INTO `ads` VALUES (3,'admin@gamespot.com','2014-02-23 11:18:53',69.99,'Sed cursus rhoncus erat et porta. Cras in sem porttitor, pretium sapien vel, dignissim dolor. Quisque feugiat est eu lectus lobortis scelerisque. Donec mollis eros ut nibh rhoncus, quis facilisis nunc eleifend. Donec imperdiet gravida mattis. Maecenas hendrerit placerat velit nec pulvinar. Mauris accumsan eros non neque ultricies, id gravida purus sollicitudin. Donec lacinia dapibus lectus ultrices placerat.','Roma','PlayStation 4');
INSERT INTO `ads` VALUES (4,'admin@gamespot.com','2014-02-23 11:18:54',9.9,'Phasellus viverra sagittis sem sed commodo. Nulla facilisi. Curabitur iaculis molestie tempus. Aenean dolor tortor, luctus et dolor et, malesuada interdum turpis. Aenean hendrerit lacus justo, sit amet iaculis arcu ornare vitae. Mauris lectus turpis, ultrices quis ullamcorper sit amet, hendrerit a orci. Donec nec vestibulum lorem, et interdum sem. Integer mi nisi, fermentum sit amet justo sed, laoreet dignissim mi. Aliquam id pulvinar elit. Nunc mattis neque id massa gravida tincidunt. Sed vel augue ac purus mollis venenatis.','Torino','PlayStation 3');
INSERT INTO `ads` VALUES (5,'admin@gamespot.com','2014-02-23 20:35:22',66,'Donec lectus orci, vehicula quis mi at, eleifend euismod dolor. Suspendisse euismod tempus diam non vehicula. Duis lacinia porta nibh, id porta nisi posuere nec. Morbi consectetur velit et elit ornare aliquam. Cras pellentesque purus ut dignissim euismod. Nunc varius lobortis massa non pretium. Nam convallis sed dui non euismod. Maecenas consequat metus non magna ultrices vestibulum. Vestibulum egestas volutpat est ac condimentum. Maecenas neque lacus, venenatis auctor placerat vel, consectetur id magna. Donec vel consequat turpis, non gravida diam.','Roma','PlayStation 4');
INSERT INTO `ads` VALUES (6,'admin@gamespot.com','2014-02-23 20:35:39',87.45,'Cras dictum augue id iaculis dignissim. Nunc consequat mi in porta interdum. Nam tortor neque, auctor eget enim sit amet, ultrices semper mi. Sed non pharetra lacus, nec bibendum orci. Phasellus lobortis neque tortor, vitae ultrices arcu porttitor eu. Mauris non facilisis felis, interdum blandit enim. Proin mollis dignissim urna, id dignissim purus commodo vitae. Morbi tincidunt id sem vitae blandit. Proin mattis luctus nulla, eu congue quam eleifend lacinia. Quisque commodo, lectus sed tristique consectetur, felis felis condimentum neque, eu egestas diam tortor quis nisl. Nulla eleifend adipiscing tortor et rutrum. Duis vitae mauris augue. In tincidunt, lorem a malesuada egestas, urna arcu imperdiet metus, sed sodales justo est non odio. Nullam vestibulum vel sapien vitae aliquam. Suspendisse sagittis est sem, vel iaculis mi elementum a. Etiam dictum lectus magna, vitae porta est porttitor non.','Terni','PlayStation 4');
INSERT INTO `ads` VALUES (7,'admin@gamespot.com','2014-02-23 20:35:56',55,'Aliquam vulputate hendrerit tortor quis venenatis. Phasellus id nulla nec justo interdum feugiat in quis augue. Maecenas at turpis et nunc condimentum fermentum. Nulla vitae tortor eget justo aliquet tincidunt ut at velit. Maecenas tempor, quam vitae pellentesque cursus, tellus orci hendrerit mauris, vitae porttitor leo quam id nibh. Integer suscipit purus vel scelerisque scelerisque. Morbi posuere ante sagittis placerat varius.','Roma','PlayStation 3');
INSERT INTO `ads` VALUES (8,'admin@gamespot.com','2014-02-23 20:36:18',77.9,'Nunc elementum dolor non pretium consequat. Donec feugiat tincidunt tortor vitae eleifend. Vestibulum rhoncus justo et est bibendum, in sollicitudin turpis scelerisque. Nulla euismod ultricies eros, nec mattis magna dapibus vitae. Praesent lobortis laoreet gravida. Quisque nec arcu non lectus pharetra posuere non id diam. Vestibulum tincidunt mi non libero blandit tincidunt. Integer venenatis, nibh eget fringilla ornare, nulla enim tempor neque, at varius mauris nulla at nibh. Integer a pretium mauris, eget lacinia orci. Mauris viverra magna ut faucibus elementum. Morbi aliquam risus vel justo laoreet varius. Mauris sit amet nibh ipsum. In et luctus dolor. Nam dolor purus, eleifend non massa vel, suscipit elementum nibh. Nulla aliquet velit vitae dapibus elementum. Nunc nulla odio, malesuada eget gravida a, consectetur sed mi.','Pescara','PlayStation 3');
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `author_email` varchar(200) NOT NULL DEFAULT '',
  `posted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,'Lorem','Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin hendrerit ipsum sapien, sed porttitor velit semper a. Aliquam sed laoreet lectus, id volutpat lectus. Ut scelerisque lacus nec est tristique accumsan. Integer ullamcorper, eros nec ullamcorper faucibus, est urna euismod nulla, et aliquet augue nulla eget libero. Donec diam mauris, porta in est vulputate, tempor tempus leo. Phasellus a justo ullamcorper, blandit ipsum eget, eleifend libero. Quisque consectetur varius risus, ac cursus risus semper eu. Donec eu nunc vel purus viverra egestas ut in eros. Fusce vitae mi pulvinar, tempus eros volutpat, ultrices leo. Duis mi urna, suscipit et turpis sit amet, laoreet fermentum nisi. Donec sapien mauris, tristique ac enim eget, aliquam consequat neque. Nam ultricies nisl erat, in ultricies erat molestie lacinia.','blogger@gamespot.com','2014-01-01 10:00:00');
INSERT INTO `blog_posts` VALUES (2,'Altro','Nam nec pharetra urna, et sodales magna. Ut pretium augue metus, ut pharetra risus ullamcorper vitae. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed scelerisque fringilla augue, ut bibendum quam interdum sed. Fusce fringilla rhoncus augue, at tempor ligula placerat id. Quisque tincidunt id magna sit amet tempor. Duis gravida at eros vel scelerisque. Proin sodales odio eget nulla vehicula molestie. Cras molestie tellus non nisi tristique, ut tincidunt felis lacinia. Nam convallis ligula ac nibh consectetur tempus. Duis id imperdiet orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse turpis lorem, pulvinar eu facilisis in, ultricies at tellus. Praesent in scelerisque est.','blogger@gamespot.com','2014-01-01 10:00:01');
INSERT INTO `blog_posts` VALUES (3,'Minchia','Donec sit amet justo in augue consequat adipiscing. Proin eleifend aliquam justo nec condimentum. Ut faucibus mi lectus, ut scelerisque mi imperdiet sit amet. Nam at vehicula diam, nec convallis libero. Proin dictum molestie nunc, quis luctus sapien accumsan sed. Etiam vulputate egestas euismod. Nulla nulla leo, rhoncus eget orci nec, mollis facilisis dolor. Ut iaculis, felis id mattis vestibulum, libero dolor gravida purus, at lacinia lectus diam sed lectus. In vel tellus semper, congue libero eu, tempor orci. Nulla facilisi. Suspendisse potenti. In ultricies diam id erat ullamcorper, eu tempus enim hendrerit. In vitae risus non mauris euismod viverra.','blogger@gamespot.com','2014-01-01 10:00:02');
INSERT INTO `blog_posts` VALUES (4,'Ciao','Praesent accumsan pulvinar libero, quis lacinia turpis blandit at. Nunc pretium lectus id elit laoreet, sed convallis odio consequat. Morbi odio elit, porttitor ut pellentesque quis, pretium quis libero. Vestibulum tempus odio et purus porttitor ultricies. In viverra aliquam nunc in viverra. Donec eget posuere nulla, ut feugiat magna. Nam ut dui sed nunc sollicitudin fermentum et in metus. Donec mattis risus ipsum, a tincidunt purus porta lacinia. Sed dapibus tincidunt lacus, sit amet ultrices nulla congue consequat. Donec porttitor hendrerit turpis et malesuada. Sed consequat posuere massa at varius. Etiam arcu mauris, sagittis eu augue quis, pretium eleifend libero. Aenean vitae quam eu eros condimentum commodo. Quisque venenatis, nibh vitae aliquam molestie, eros magna aliquet dui, in rhoncus libero diam at augue. Curabitur volutpat, velit vitae molestie gravida, urna ligula sollicitudin elit, id pulvinar sapien ipsum ut dolor.','blogger@gamespot.com','2014-01-01 10:00:03');
INSERT INTO `blog_posts` VALUES (5,'Bu!','In cursus tellus sit amet quam dapibus vulputate. Quisque non fermentum urna, at pharetra mi. Nullam egestas diam ante, sed feugiat enim gravida nec. Suspendisse adipiscing fermentum lacus nec vehicula. Proin feugiat nulla nunc, quis condimentum nunc pharetra sed. Ut laoreet accumsan nunc, ac ultrices leo consectetur nec. Nullam eleifend urna eget iaculis facilisis. Ut rutrum, ante et semper interdum, neque enim ultrices dolor, eget vestibulum lacus felis posuere ipsum. Quisque adipiscing bibendum dui dignissim rhoncus.','blogger@gamespot.com','2014-01-01 10:00:04');
INSERT INTO `blog_posts` VALUES (6,'Pappa','Quisque fermentum urna ut magna laoreet, vitae venenatis nulla dictum. Cras accumsan elit quis vulputate vehicula. Nunc vehicula massa at lacus fringilla semper. Curabitur condimentum venenatis ornare. Etiam consectetur porttitor egestas. Curabitur nec aliquam risus. Proin vitae urna nec risus imperdiet consequat. Phasellus tincidunt lectus eget augue tempor, ut auctor est sodales. Suspendisse facilisis pharetra ipsum ac ultrices. Morbi eget sapien sollicitudin, varius nisi nec, pulvinar enim. Etiam porta quam non velit scelerisque, ut sollicitudin mi convallis.','blogger@gamespot.com','2014-01-01 10:00:05');
INSERT INTO `blog_posts` VALUES (7,'Test browser','defqq','staff@gamespot.com','2014-04-20 21:11:59');
INSERT INTO `blog_posts` VALUES (8,'Altro test','frefr','staff@gamespot.com','2014-04-20 21:25:44');
INSERT INTO `blog_posts` VALUES (9,'Terzo test','Hello there.','staff@gamespot.com','2014-04-20 21:26:00');
INSERT INTO `blog_posts` VALUES (10,'Eddaje','Hello mama.','staff@gamespot.com','2014-04-20 21:28:04');
INSERT INTO `blog_posts` VALUES (11,'E ultimo...','Hello','staff@gamespot.com','2014-04-20 21:30:32');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `name` varchar(40) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_games`
--

DROP TABLE IF EXISTS `categories_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_games` (
  `category_name` varchar(40) NOT NULL DEFAULT '',
  `game_name` varchar(60) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_games`
--

LOCK TABLES `categories_games` WRITE;
/*!40000 ALTER TABLE `categories_games` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consoles`
--

DROP TABLE IF EXISTS `consoles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consoles` (
  `name` varchar(40) NOT NULL DEFAULT '',
  `release_year` int(4) unsigned NOT NULL,
  `producer` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consoles`
--

LOCK TABLES `consoles` WRITE;
/*!40000 ALTER TABLE `consoles` DISABLE KEYS */;
INSERT INTO `consoles` VALUES ('PlayStation 3',2005,'Sony');
INSERT INTO `consoles` VALUES ('PlayStation 4',2013,'Sony');
INSERT INTO `consoles` VALUES ('Xbox 360',2005,'Microsoft');
INSERT INTO `consoles` VALUES ('Xbox One',2013,'Microsoft');
/*!40000 ALTER TABLE `consoles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consoles_games`
--

DROP TABLE IF EXISTS `consoles_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consoles_games` (
  `game_name` varchar(60) NOT NULL DEFAULT '',
  `console_name` varchar(40) NOT NULL DEFAULT '',
  KEY `habtm_consoles` (`console_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consoles_games`
--

LOCK TABLES `consoles_games` WRITE;
/*!40000 ALTER TABLE `consoles_games` DISABLE KEYS */;
/*!40000 ALTER TABLE `consoles_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_ads`
--

DROP TABLE IF EXISTS `game_ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_ads` (
  `ad_id` int(11) NOT NULL,
  `game_name` varchar(60) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_ads`
--

LOCK TABLES `game_ads` WRITE;
/*!40000 ALTER TABLE `game_ads` DISABLE KEYS */;
INSERT INTO `game_ads` VALUES (3,'1886: The Order');
INSERT INTO `game_ads` VALUES (5,'1886: The Order');
INSERT INTO `game_ads` VALUES (6,'1886: The Order');
INSERT INTO `game_ads` VALUES (7,'Beyond');
INSERT INTO `game_ads` VALUES (8,'Call Of Duty: Ghosts');
INSERT INTO `game_ads` VALUES (0,'Battlefield 4');
/*!40000 ALTER TABLE `game_ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `name` varchar(60) NOT NULL DEFAULT '',
  `release_date` date DEFAULT NULL,
  `description` text,
  `software_house` varchar(50) DEFAULT '',
  `cover_image` varchar(300) DEFAULT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES ('1886: The Order','2014-02-22','Integer turpis erat, gravida vitae lacinia id, congue ac eros. Etiam sodales velit porttitor iaculis porttitor. Nullam condimentum lorem sit amet interdum euismod. Nulla cursus eros sed condimentum pharetra. Fusce sodales sed justo et consectetur. Duis congue odio nunc, ut accumsan elit euismod eget. Aenean tempor velit in lectus elementum, quis semper lacus auctor. Ut nisi enim, mattis vel lorem ac, vehicula dictum sapien. Praesent auctor mauris turpis, ac venenatis metus rutrum vitae. Aliquam dolor tellus, rhoncus ac tincidunt mattis, consectetur eget risus.','SWHouse','the_order.jpg','2014-02-23 11:17:19');
INSERT INTO `games` VALUES ('Battlefield 4','2013-11-29','Curabitur convallis tortor vitae massa vehicula, sed tincidunt turpis malesuada. Curabitur aliquet eu nunc nec commodo. Maecenas faucibus augue id sem porta, sed ultricies tortor posuere. Nullam sed nulla sed lectus placerat tristique. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin eros erat, venenatis sit amet leo non, scelerisque auctor tellus. Quisque vel tellus ut sem euismod pharetra. Ut iaculis magna volutpat laoreet venenatis. Integer quis massa mauris. In luctus eros quis purus vehicula posuere. Phasellus sed sapien neque. Proin bibendum leo vitae lectus luctus, sed convallis eros pulvinar. Ut interdum turpis nisl, non commodo orci facilisis eget. Nunc faucibus urna ac dolor semper, quis iaculis nisi consequat.','Dice','Battlefield_4_Cover.jpg','2014-02-23 23:50:17');
INSERT INTO `games` VALUES ('Beyond','2013-05-05','Nullam venenatis quis augue vel pellentesque. Fusce sed neque quam. Praesent ante purus, ultrices quis augue ut, cursus vehicula diam. In non eros justo. Ut molestie mattis placerat. Vestibulum et lobortis arcu, ac tempus diam. Integer eget lacinia leo. Aenean at neque accumsan, suscipit lacus vitae, convallis libero. Etiam sit amet eros a augue dapibus semper nec viverra augue. Praesent id malesuada nisi. Sed ultricies, neque ac euismod adipiscing, velit enim porta elit, sed feugiat nunc nunc n','Bethesda','TheLastOfUs.jpg','2014-02-23 11:17:18');
INSERT INTO `games` VALUES ('Call Of Duty: Ghosts','2013-11-14','Donec aliquet, velit sed mollis luctus, orci lacus tincidunt tellus, ac blandit est orci quis metus. In gravida elit ligula. Donec vel augue sit amet lorem imperdiet tincidunt ut lacinia elit. Morbi eleifend viverra diam non rhoncus. Proin suscipit tortor non mauris congue, eget tristique ligula commodo. Sed pellentesque dapibus molestie. Aenean dui mi, pretium at nulla in, suscipit euismod mauris. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi laoreet diam ut ligula ullamcorper blandit. Mauris vulputate posuere magna ut feugiat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor non felis et placerat. Pellentesque dignissim odio malesuada felis placerat dignissim sit amet vitae magna. Suspendisse nec aliquam magna, sit amet aliquam augue. Praesent dictum egestas est, sit amet scelerisque leo pellentesque sit amet. Mauris et interdum lacus, in tristique eros.','Activision','codg.jpg','2014-02-23 11:23:04');
INSERT INTO `games` VALUES ('Fifa \'14','2013-09-09','Nullam tincidunt gravida leo, vitae gravida lorem. Aenean tellus nisl, euismod vel risus in, scelerisque bibendum dolor. Suspendisse lacinia tortor sem, et pulvinar orci adipiscing vitae. Cras rutrum nisi et varius tincidunt. Nam semper nunc lectus, at molestie ligula ultrices eu. Nam pretium neque quis turpis varius semper. Fusce vestibulum libero auctor augue fringilla, sed luctus magna elementum. Curabitur eu eros nec lacus aliquam lacinia a non est. Ut nec diam non justo gravida blandit. Pha','EA Sports','fifa-14-cover.jpg','2014-02-23 11:17:29');
INSERT INTO `games` VALUES ('Knack','2014-01-01','Quisque aliquam mi ac posuere dignissim. Aliquam erat volutpat. Cras pellentesque quam et massa pretium, sed tincidunt mi consectetur. Sed in tortor in augue tempus tristique. In pulvinar tortor vel sem tempus posuere. Ut nec dolor blandit, accumsan enim a, ullamcorper lectus. Etiam hendrerit non enim vel suscipit. Quisque neque ipsum, blandit eu fringilla id, feugiat eu ante. Morbi vulputate tincidunt nulla, eget luctus leo sollicitudin quis. Fusce bibendum dictum convallis.','Sony','53801-knack.png','2014-02-23 23:55:17');
INSERT INTO `games` VALUES ('The Last of Us','2013-01-01','Curabitur lobortis suscipit porta. Nulla.','Naughty Dogs','beyond-two-souls-cover-art.jpg','2014-02-23 11:17:10');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `can_see_backend` tinyint(1) NOT NULL DEFAULT '0',
  `can_blog` tinyint(1) NOT NULL DEFAULT '0',
  `can_manage_blog` tinyint(1) DEFAULT '0',
  `can_manage_products` tinyint(1) NOT NULL DEFAULT '0',
  `can_manage_ads` tinyint(1) NOT NULL DEFAULT '0',
  `is_support` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES ('admins','The admins of the website.',1,1,1,1,1,0,1);
INSERT INTO `groups` VALUES ('bloggers','People who can blog.',1,1,0,0,0,0,0);
INSERT INTO `groups` VALUES ('content_editors','People who can manage ads and games.',0,0,0,1,1,0,0);
INSERT INTO `groups` VALUES ('staff','Staff of the website.',1,1,0,1,1,1,0);
INSERT INTO `groups` VALUES ('support','Contact for support.',1,0,0,0,0,1,0);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups_users`
--

DROP TABLE IF EXISTS `groups_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups_users` (
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `group_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups_users`
--

LOCK TABLES `groups_users` WRITE;
/*!40000 ALTER TABLE `groups_users` DISABLE KEYS */;
INSERT INTO `groups_users` VALUES ('admin@gamespot.com','admins');
INSERT INTO `groups_users` VALUES ('admin@gamespot.com','staff');
INSERT INTO `groups_users` VALUES ('staff@gamespot.com','staff');
INSERT INTO `groups_users` VALUES ('blogger@gamespot.com','bloggers');
/*!40000 ALTER TABLE `groups_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `author_email` varchar(100) NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_email` (`author_email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Donec eu eros ligula. Mauris.','Mauris id nunc bibendum augue interdum iaculis. Donec hendrerit lacus eu rhoncus sodales. Quisque at ante dignissim, ullamcorper nunc sit amet, iaculis metus. Phasellus quis semper massa. Mauris sit amet auctor elit. In posuere aliquam ante. Sed erat tortor, mattis vel euismod dignissim, bibendum nec turpis.\n','0','0000-00-00 00:00:00');
INSERT INTO `posts` VALUES (2,'Lorem ipsum dolor sit amet.','Phasellus dignissim tempor urna eget consequat. Vestibulum bibendum porta eleifend. Mauris auctor, metus et fringilla hendrerit, lectus magna facilisis erat, non imperdiet sapien lectus eu sem. Integer interdum felis eu est lobortis, sed scelerisque dolor vestibulum. Mauris sit amet pulvinar ligula. Donec tincidunt dui laoreet, pharetra turpis quis, laoreet neque. Etiam ut mattis elit. In vel turpis at urna suscipit dignissim. Donec ullamcorper velit sit amet dapibus malesuada. Nullam at lorem diam. Nullam consectetur venenatis diam, in posuere mauris sollicitudin fermentum. Morbi eu tellus sit amet elit pulvinar ullamcorper. Vivamus sed dolor sit amet arcu porta pretium at sit amet erat. Morbi ac dolor ornare, faucibus nibh sed, scelerisque justo. Proin vel condimentum nibh.','0','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_tags`
--

DROP TABLE IF EXISTS `posts_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_tags` (
  `post_id` int(11) DEFAULT NULL,
  `tag_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_tags`
--

LOCK TABLES `posts_tags` WRITE;
/*!40000 ALTER TABLE `posts_tags` DISABLE KEYS */;
INSERT INTO `posts_tags` VALUES (1,'a tag');
INSERT INTO `posts_tags` VALUES (1,'another tag');
INSERT INTO `posts_tags` VALUES (2,'a tag');
/*!40000 ALTER TABLE `posts_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_uploads`
--

DROP TABLE IF EXISTS `posts_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_uploads` (
  `post_id` int(11) unsigned NOT NULL,
  `upload_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_uploads`
--

LOCK TABLES `posts_uploads` WRITE;
/*!40000 ALTER TABLE `posts_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_users`
--

DROP TABLE IF EXISTS `staff_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_users` (
  `user_email` int(11) NOT NULL,
  `can_blog` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_users`
--

LOCK TABLES `staff_users` WRITE;
/*!40000 ALTER TABLE `staff_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uploads` (
  `url` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(10) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uploads`
--

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `email` varchar(100) NOT NULL,
  `hashed_password` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin@gamespot.com','21232f297a57a5a743894a0e4a801fc3','2014-02-23 11:20:13','Ammi','Nistratore',NULL);
INSERT INTO `users` VALUES ('an.leopardi@gmail.com','9003d1df22eb4d3820015070385194c8','2014-02-23 11:20:13','Andrea','Leopardi',NULL);
INSERT INTO `users` VALUES ('blogger@gamespot.com','9c1252fa60c847783a5281273c8a5d0c','2014-03-02 23:49:02','Blogga','Tore',NULL);
INSERT INTO `users` VALUES ('staff@gamespot.com','1253208465b1efa876f982d8a9e73eef','2014-02-24 22:49:05','Membero','Dello Staff',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-06 12:04:32
