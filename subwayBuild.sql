CREATE DATABASE  IF NOT EXISTS `subway` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `subway`;
-- MySQL dump 10.13  Distrib 5.6.10, for osx10.7 (x86_64)
--
-- Host: localhost    Database: subway
-- ------------------------------------------------------
-- Server version	5.6.10

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
-- Table structure for table `availability`
--

DROP TABLE IF EXISTS `availability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availability` (
  `employee_id` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`employee_id`,`day`,`start`,`end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability`
--

LOCK TABLES `availability` WRITE;
/*!40000 ALTER TABLE `availability` DISABLE KEYS */;
INSERT INTO `availability` (`employee_id`, `day`, `start`, `end`) VALUES (1,1,600,1400),(1,2,600,1400),(1,3,600,1400),(1,4,600,1400),(1,6,600,1400),(2,1,1000,1800),(2,2,1000,1800),(2,3,1000,1800),(2,4,1000,1800),(2,5,600,1400),(2,6,600,1200),(2,7,1000,1800),(3,1,800,1600),(3,2,800,1600),(3,4,600,1400),(3,5,600,1400),(3,7,600,1400),(4,1,1200,2000),(4,3,1400,2200),(4,5,1600,2200),(5,2,1200,2200),(5,4,1200,2200),(5,6,1200,2200),(6,7,600,2200),(7,1,1400,2200),(7,2,1400,2200),(7,3,1400,2200),(7,4,1400,2200),(7,6,1400,2200),(7,7,1400,2200),(8,1,1000,1400),(8,2,1000,1400),(8,3,1000,1400),(8,4,1000,1400),(8,5,1000,1400),(9,6,600,2200),(9,7,600,2200);
/*!40000 ALTER TABLE `availability` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `password` varchar(10) DEFAULT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `emp_type` varchar(1) NOT NULL,
  `emp_minor` varchar(1) NOT NULL,
  `monday_start` int(4) DEFAULT NULL,
  `monday_end` int(4) DEFAULT NULL,
  `tuesday_start` int(4) DEFAULT NULL,
  `tuesday_end` int(4) DEFAULT NULL,
  `wednesday_start` int(4) DEFAULT NULL,
  `wednesday_end` int(4) DEFAULT NULL,
  `thursday_start` int(4) DEFAULT NULL,
  `thursday_end` int(4) DEFAULT NULL,
  `friday_start` int(4) DEFAULT NULL,
  `friday_end` int(4) DEFAULT NULL,
  `saturday_start` int(4) DEFAULT NULL,
  `saturday_end` int(4) DEFAULT NULL,
  `sunday_start` int(4) DEFAULT NULL,
  `sunday_end` int(4) DEFAULT NULL,
  PRIMARY KEY (`employee_id`,`store_id`),
  UNIQUE KEY `employee_id_UNIQUE` (`employee_id`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` (`employee_id`, `store_id`, `user_name`, `password`, `first_name`, `last_name`, `email`, `emp_type`, `emp_minor`, `monday_start`, `monday_end`, `tuesday_start`, `tuesday_end`, `wednesday_start`, `wednesday_end`, `thursday_start`, `thursday_end`, `friday_start`, `friday_end`, `saturday_start`, `saturday_end`, `sunday_start`, `sunday_end`) VALUES (1,1,'rob','rob','Rob','Hefty','heftyra12@uww.edu','F','N',600,1400,600,1400,600,1400,600,930,600,1400,600,1400,NULL,NULL),(2,1,'troy','troy123','Troy','Halverson','th@uww.edu','F','N',600,1800,1000,1800,1000,1800,800,1400,NULL,NULL,NULL,NULL,1000,1800),(3,1,'katherine','kat123','Katherine','Travis','kt@uww.edu','P','Y',600,2000,1200,2000,1200,2000,1200,2000,1100,2000,NULL,NULL,NULL,NULL),(4,1,'nicki','nicki123','Nicki','Edwards','ne@uww.edu','F','N',1700,2200,1700,2200,1700,2200,1700,2200,1700,2200,1700,2200,1700,2200),(5,1,'han','han123','Han','Solo','hs@uww.edu','T','Y',1200,2200,1200,2200,1200,2200,1200,2200,1200,2200,1200,2200,1200,2200),(6,1,'luke','luke123','Luke','Skywalker','ls@uww.edu','F','N',1600,2200,1700,2200,1600,2200,1600,2200,1600,2200,600,2200,600,2200),(7,1,'leia','leia123','Leia','Skywalker','ls2@uww.edu','F','N',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,600,2200,600,2200),(8,1,'vader','vader123','Darth','Vader','dv@uww.edu','P','N',600,2200,600,2200,NULL,NULL,NULL,NULL,600,2200,600,2200,600,2200),(9,1,'yoda','yoda123','Yoda','Noname','yoda@uww.edu','P','Y',NULL,NULL,NULL,NULL,600,2000,600,1200,NULL,NULL,NULL,NULL,NULL,NULL),(10,1,'r2d2','r2d2123','R2','D2','r2d2@uww.edu','S','N',NULL,NULL,1200,2200,NULL,1200,2200,NULL,1200,2200,1200,2200,1200,2200),(11,1,'emperor','blah','Emperor','Palpatine','ep@sw.com','P','N',1000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parameters` (
  `busn_rule_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `descr` varchar(45) NOT NULL,
  `value0` varchar(45) DEFAULT NULL,
  `value1` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`busn_rule_id`,`store_id`),
  UNIQUE KEY `busn_rule_id_UNIQUE` (`busn_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameters`
--

LOCK TABLES `parameters` WRITE;
/*!40000 ALTER TABLE `parameters` DISABLE KEYS */;
INSERT INTO `parameters` (`busn_rule_id`, `store_id`, `descr`, `value0`, `value1`) VALUES (1,1,'Minors are less than this','18','0'),(2,1,'Max full time hours per day','8','0'),(3,1,'Max full time hours per week','40','0'),(4,1,'Max part time hours per day','6','0'),(5,1,'Max part time hours per week','32','0'),(6,1,'Minimum shift hours','2','0');
/*!40000 ALTER TABLE `parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productivity`
--

DROP TABLE IF EXISTS `productivity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productivity` (
  `store_id` int(11) NOT NULL,
  `week_no` int(2) NOT NULL,
  `day` int(1) NOT NULL,
  `units` int(3) DEFAULT NULL,
  PRIMARY KEY (`store_id`,`week_no`,`day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productivity`
--

LOCK TABLES `productivity` WRITE;
/*!40000 ALTER TABLE `productivity` DISABLE KEYS */;
INSERT INTO `productivity` (`store_id`, `week_no`, `day`, `units`) VALUES (1,1,1,170),(1,1,2,175),(1,1,3,180),(1,1,4,185),(1,1,5,190),(1,1,6,195),(1,1,7,200),(1,2,1,175),(1,2,2,180),(1,2,3,185),(1,2,4,190),(1,2,5,200),(1,2,6,220),(1,2,7,200),(1,15,1,123),(1,15,2,121),(1,15,3,12),(1,15,4,1231),(1,15,5,123),(1,15,6,32),(1,15,7,12),(1,16,1,100),(1,16,2,101),(1,16,3,102),(1,16,4,120),(1,16,5,199),(1,16,6,121),(1,16,7,131),(1,17,1,100),(1,17,2,100),(1,17,3,100),(1,17,4,100),(1,17,5,100),(1,17,6,100),(1,17,7,100),(1,18,1,120),(1,18,2,120),(1,18,3,210),(1,18,4,120),(1,18,5,120),(1,18,6,120),(1,18,7,120),(1,19,1,101),(1,19,2,102),(1,19,3,103),(1,19,4,104),(1,19,5,105),(1,19,6,106),(1,19,7,107),(1,20,1,787),(1,20,2,787),(1,20,3,787),(1,20,4,8787),(1,20,5,787),(1,20,6,34),(1,20,7,38);
/*!40000 ALTER TABLE `productivity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request`
--

LOCK TABLES `request` WRITE;
/*!40000 ALTER TABLE `request` DISABLE KEYS */;
INSERT INTO `request` (`request_id`, `employee_id`, `start_date`, `end_date`, `start_time`, `end_time`) VALUES (1,1,'2013-05-18','2013-05-20',600,2200);
/*!40000 ALTER TABLE `request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `week_no` int(2) NOT NULL,
  `day` int(1) NOT NULL,
  `start_time` int(4) NOT NULL,
  `end_time` int(4) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `break` varchar(1) NOT NULL,
  PRIMARY KEY (`schedule_id`),
  UNIQUE KEY `schedule_id_UNIQUE` (`schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` (`schedule_id`, `store_id`, `week_no`, `day`, `start_time`, `end_time`, `employee_id`, `break`) VALUES (1,1,1,1,600,1400,1,'N'),(2,1,1,1,800,1600,2,'N'),(3,1,1,2,600,1400,1,'N'),(4,1,2,1,600,1400,1,'N');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shifts`
--

DROP TABLE IF EXISTS `shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shifts` (
  `shift_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `day` int(1) NOT NULL,
  `start_time` int(4) NOT NULL,
  `end_time` int(4) NOT NULL,
  PRIMARY KEY (`shift_id`),
  UNIQUE KEY `shift_id_UNIQUE` (`shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shifts`
--

LOCK TABLES `shifts` WRITE;
/*!40000 ALTER TABLE `shifts` DISABLE KEYS */;
INSERT INTO `shifts` (`shift_id`, `store_id`, `day`, `start_time`, `end_time`) VALUES (1,1,1,600,1400),(2,1,1,1000,1800),(3,1,1,1030,1400),(4,1,1,1600,2100),(5,1,1,1700,2200),(6,1,2,600,1400),(7,1,2,1000,1800),(8,1,2,1100,1800),(9,1,2,1600,2100),(10,1,2,1700,2200),(11,1,3,600,1400),(12,1,3,1000,1800),(13,1,3,1100,1800),(14,1,3,1600,2200),(15,1,3,1700,2200),(16,1,4,600,1400),(17,1,4,1000,1800),(18,1,4,1100,1800),(19,1,5,600,1400),(20,1,6,600,1400),(21,1,7,600,1400),(22,1,5,1100,1800),(23,1,5,700,1500),(24,1,6,700,1500),(25,1,7,700,1500);
/*!40000 ALTER TABLE `shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store` (
  `store_id` int(11) NOT NULL,
  `location` varchar(45) NOT NULL,
  PRIMARY KEY (`store_id`),
  UNIQUE KEY `location_UNIQUE` (`location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store`
--

LOCK TABLES `store` WRITE;
/*!40000 ALTER TABLE `store` DISABLE KEYS */;
INSERT INTO `store` (`store_id`, `location`) VALUES (1,'Milton');
/*!40000 ALTER TABLE `store` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-04-30 16:07:20
