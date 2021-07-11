-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: localhost    Database: meteo41
-- ------------------------------------------------------
-- Server version	5.7.31

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
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `observation`
--

DROP TABLE IF EXISTS `observation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `observation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `weather_station_id` int(11) NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C576DBE0A76ED395` (`user_id`),
  KEY `IDX_C576DBE09E475DA2` (`weather_station_id`),
  KEY `message` (`message`),
  CONSTRAINT `FK_C576DBE09E475DA2` FOREIGN KEY (`weather_station_id`) REFERENCES `weather_station` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C576DBE0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `observation`
--

LOCK TABLES `observation` WRITE;
/*!40000 ALTER TABLE `observation` DISABLE KEYS */;
INSERT INTO `observation` VALUES (12,1,3,'Petite pluie','2021-07-03 18:44:32','2021-07-03 18:44:32');
/*!40000 ALTER TABLE `observation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  KEY `name` (`name`),
  CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temperature_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `speed_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `rain_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `solar_radiation_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `pm_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `humidity_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `cloud_base_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `wind_dir_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `pressure_unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES (2,'°C','km/h','mm','W/m²','μg/m³','%','Metric','2021-05-02 13:59:10','2021-05-02 14:45:18','m','°','hPa'),(3,'°F','mph','inch','W/m²','μg/m³','%','Imperial','2021-05-02 13:59:10','2021-07-03 18:45:37','feet','°','inHg');
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Test','TEST','test@test.fr','$argon2id$v=19$m=65536,t=4,p=1$P/ueWKohAmr6T0wsMW4cBA$mKTWY4d26rOy5Xh+usNnc1JpbDg11E+xTSxxzxbhCOY','[\"ROLE_ADMIN\"]','2021-04-24 15:14:45','2021-07-03 18:31:33');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weather_data`
--

DROP TABLE IF EXISTS `weather_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `weather_station_id` int(11) NOT NULL,
  `temperature` decimal(3,1) NOT NULL,
  `humidity` int(11) NOT NULL,
  `relative_pressure` decimal(5,1) NOT NULL,
  `absolute_pressure` decimal(5,1) NOT NULL,
  `wind_direction` int(11) NOT NULL,
  `wind_direction_avg` int(11) NOT NULL,
  `wind_speed` decimal(4,1) NOT NULL,
  `wind_speed_avg` decimal(4,1) NOT NULL,
  `wind_gust` decimal(4,1) NOT NULL,
  `wind_max_daily_gust` decimal(4,1) NOT NULL,
  `rain_rate` decimal(4,1) NOT NULL,
  `rain_event` decimal(4,1) NOT NULL,
  `rain_hourly` decimal(4,1) NOT NULL,
  `rain_daily` decimal(4,1) NOT NULL,
  `rain_weekly` decimal(4,1) NOT NULL,
  `rain_monthly` decimal(4,1) NOT NULL,
  `rain_yearly` decimal(5,1) NOT NULL,
  `solar_radiation` decimal(5,1) NOT NULL,
  `uv` int(11) NOT NULL,
  `pm25` decimal(4,1) NOT NULL,
  `pm25_avg` decimal(4,1) NOT NULL,
  `humidex` decimal(3,1) NOT NULL,
  `dew_point` decimal(3,1) NOT NULL,
  `wind_chill` decimal(3,1) DEFAULT NULL,
  `cloud_base` int(11) NOT NULL,
  `beaufort_scale` int(11) NOT NULL,
  `aqi` int(11) NOT NULL,
  `aqi_avg` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `heat_index` decimal(3,1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3370691AF8BD700D` (`unit_id`),
  KEY `IDX_3370691A9E475DA2` (`weather_station_id`),
  CONSTRAINT `FK_3370691A9E475DA2` FOREIGN KEY (`weather_station_id`) REFERENCES `weather_station` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3370691AF8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_data`
--

LOCK TABLES `weather_data` WRITE;
/*!40000 ALTER TABLE `weather_data` DISABLE KEYS */;
INSERT INTO `weather_data` VALUES (8,2,3,23.5,74,1023.6,1013.6,223,223,14.5,12.9,27.9,33.4,1.5,0.0,0.0,5.1,5.1,5.1,112.6,563.0,5,25.3,25.6,12.6,11.4,18.8,220,2,55,55,'2021-06-20 15:04:21',23.9),(9,2,3,22.1,74,1023.6,1013.6,223,223,14.5,12.9,27.9,33.4,1.5,0.0,0.0,5.1,5.1,5.1,112.6,563.0,5,25.3,25.6,12.6,11.4,12.1,220,2,55,55,'2021-07-09 14:04:23',23.9),(11,2,3,23.5,74,1023.6,1013.6,223,223,14.5,12.9,27.9,33.4,33.2,0.0,0.0,33.2,56.6,44.2,112.6,563.0,5,25.3,25.6,12.6,11.4,18.8,220,2,55,55,'2021-07-03 18:04:21',23.9),(12,2,3,22.1,74,1023.6,1013.6,223,223,14.5,12.9,27.9,33.4,1.5,0.0,0.0,5.1,5.1,5.1,112.6,563.0,5,25.3,25.6,12.6,11.4,21.5,220,2,55,55,'2021-07-10 15:05:30',23.9);
/*!40000 ALTER TABLE `weather_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weather_station`
--

DROP TABLE IF EXISTS `weather_station`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather_station` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lat` decimal(6,4) NOT NULL,
  `lng` decimal(6,4) NOT NULL,
  `api_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `elevation` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `prefered_unit_id` int(11) NOT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3B061BFAAEA34913` (`reference`),
  KEY `name` (`name`),
  KEY `IDX_3B061BFAF246D619` (`prefered_unit_id`),
  CONSTRAINT `FK_3B061BFAF246D619` FOREIGN KEY (`prefered_unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_station`
--

LOCK TABLES `weather_station` WRITE;
/*!40000 ALTER TABLE `weather_station` DISABLE KEYS */;
INSERT INTO `weather_station` VALUES (3,'Saint-Sulpice','La station météo utilisée est une Froggit (1000SE PRO), et ces pages sont mises à jour toutes les minutes. Je possède cette station depuis Juillet 2020. Toutes les données sont transmises sur d\'autres sites dont Ecowitt, Wunderground et WeatherCloud. La station est équipée d\'un capteur principal (capteur 7 en 1) et d\'un capteur externe pour mesurer la qualité de l\'air.','La station météo utilisée est une Froggit (HP1000SE PRO), et ces pages sont mises à jour chaque minute. Je possède cette station depuis Juillet 2020. ','FR','Rue des test','France',65.7678,4.0865,'5','HP1000SE PRO','110m','2021-05-02 14:08:19','2021-05-02 14:08:23',2,'XXSDEF');
/*!40000 ALTER TABLE `weather_station` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'meteo41'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-11 14:39:32
