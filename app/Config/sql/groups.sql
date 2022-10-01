-- MySQL dump 10.13  Distrib 5.1.46, for suse-linux-gnu (x86_64)
--
-- Host: localhost    Database: measurements
-- ------------------------------------------------------
-- Server version	5.1.46-log

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
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/* All Groups INSERT INTO `groups` VALUES (1,'Fibratus'),(2,'Lenticularis'),(3,'Stratiformis'),(4,'Spissatus'),(5,'Uncinus'),(6,'Humilis'),(7,'Castellanus'),(8,'Mediocris'),(9,'Calvus'),(21,'Capillatus'),(11,'Intortus'),(22,'Floccus'),(23,'Fractus'), (24,'Volutus'),(15,'Nebulosus'),(16,'Congestus'),(17,'Undulatus'),(18,'Radiatus'),(19,'Vertebratus'), (20,'Lacunosus'), (10,'Actual'),(12,'Staff'),(13,'Percy Persistence'),(14,'Enola Ensemble'); */
INSERT INTO `groups` VALUES (1,'Fibratus'),(2,'Lenticularis'),(3,'Stratiformis'),(4,'Spissatus'),(5,'Uncinus'),(6,'Humilis'),(7,'Castellanus'),(22,'Floccus'),(23,'Fractus'), (24,'Volutus'),(15,'Nebulosus'),(16,'Congestus'),(17,'Undulatus'),(18,'Radiatus'),(19,'Vertebratus'), (20,'Lacunosus'), (10,'Actual'),(12,'Staff'),(13,'Percy Persistence'),(14,'Enola Ensemble');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-08-17 16:05:32
