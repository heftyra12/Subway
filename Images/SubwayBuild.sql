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
  `end` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability`
--

LOCK TABLES `availability` WRITE;
/*!40000 ALTER TABLE `availability` DISABLE KEYS */;
INSERT INTO `availability` (`employee_id`, `day`, `start`, `end`) VALUES (1,1,600,1400),(1,2,600,1400),(1,3,600,1400),(1,4,600,1400),(1,6,600,1400),(2,1,1000,1800),(2,2,1000,1800),(2,3,1000,1800),(2,4,1000,1800),(2,5,600,1400),(2,6,600,1200),(2,7,10,1800),(3,1,800,1600),(3,2,800,1600),(3,4,600,1400),(3,5,600,1400),(3,7,600,1400),(4,1,1200,2000),(4,3,1400,2200),(4,5,1600,2200),(5,2,1200,2200),(5,4,1200,2200),(5,6,1200,2200),(6,7,600,2200),(7,1,1400,2200),(7,2,1400,2200),(7,3,1400,2200),(7,4,1400,2200),(7,6,1400,2200),(7,7,1400,2200),(8,1,1000,1400),(8,2,1000,1400),(8,3,1000,1400),(8,4,1000,1400),(8,5,1000,1400),(9,6,600,2200),(9,7,600,2200);
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
  `user_name` varchar(10) NOT NULL,
  `password` varchar(10) DEFAULT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `emp_type` varchar(1) NOT NULL,
  `emp_minor` varchar(1) NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `employee_id_UNIQUE` (`employee_id`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` (`employee_id`, `user_name`, `password`, `first_name`, `last_name`, `email`, `emp_type`, `emp_minor`) VALUES (1,'rob','rob123','Rob','Hefty','heftyra12@uww.edu','F','N'),(2,'troy','troy123','Troy','Halverson','th@uww.edu','F','N'),(3,'katherine','kat123','Katherine','Travis','kt@uww.edu','P','Y'),(4,'nicki','nicki123','Nicki','Edwards','ne@uww.edu','F','N'),(5,'han','han123','Han','Solo','hs@uww.edu','T','Y'),(6,'luke','luke123','Luke','Skywalker','ls@uww.edu','P','N'),(7,'leia','leia123','Leia','Skywalker','ls2@uww.edu','F','N'),(8,'vader','vader123','Darth','Vader','dv@uww.edu','P','N'),(9,'yoda','yoda123','Yoda','Noname','yoda@uww.edu','P','Y'),(10,'r2d2','r2d2123','R2','D2','r2d2@uww.edu','S','N');
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
  `descr` varchar(45) NOT NULL,
  `value0` varchar(45) DEFAULT NULL,
  `value1` varchar(45) DEFAULT NULL,
  `value2` varchar(45) DEFAULT NULL,
  `value3` varchar(45) DEFAULT NULL,
  `value4` varchar(45) DEFAULT NULL,
  `value5` varchar(45) DEFAULT NULL,
  `value6` varchar(45) DEFAULT NULL,
  `value7` varchar(45) DEFAULT NULL,
  `value8` varchar(45) DEFAULT NULL,
  `value9` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`busn_rule_id`),
  UNIQUE KEY `busn_rule_id_UNIQUE` (`busn_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameters`
--

LOCK TABLES `parameters` WRITE;
/*!40000 ALTER TABLE `parameters` DISABLE KEYS */;
INSERT INTO `parameters` (`busn_rule_id`, `descr`, `value0`, `value1`, `value2`, `value3`, `value4`, `value5`, `value6`, `value7`, `value8`, `value9`) VALUES (1,'Minors are less than this','18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Max full time hours per day','8',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Max full time hours per week','40',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'Max part time hours per day','6',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'Max part time hours per week','32',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productivity`
--

DROP TABLE IF EXISTS `productivity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productivity` (
  `day` int(1) NOT NULL,
  `time` int(4) NOT NULL,
  `count` int(2) DEFAULT NULL,
  PRIMARY KEY (`day`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productivity`
--

LOCK TABLES `productivity` WRITE;
/*!40000 ALTER TABLE `productivity` DISABLE KEYS */;
INSERT INTO `productivity` (`day`, `time`, `count`) VALUES (1,600,1),(1,1000,2),(1,1200,3),(1,1500,2),(1,1600,3),(1,1900,2),(2,600,1),(2,800,2),(2,1200,2),(2,1500,1),(2,1600,2),(2,1700,3),(2,1800,2),(3,600,1),(3,1000,2),(4,600,1),(4,1000,2),(5,600,1),(5,1000,2),(6,600,1),(6,1000,2),(7,600,1),(7,1000,2);
/*!40000 ALTER TABLE `productivity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request` (
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request`
--

LOCK TABLES `request` WRITE;
/*!40000 ALTER TABLE `request` DISABLE KEYS */;
INSERT INTO `request` (`employee_id`, `date`, `start`, `end`) VALUES (2,'2013-03-25',1200,2200),(3,'2013-03-27',1400,1600),(8,'2013-03-29',600,2200);
/*!40000 ALTER TABLE `request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule` (
  `day` int(1) NOT NULL,
  `start_time` int(4) NOT NULL,
  `end_time` int(4) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `break` varchar(1) NOT NULL,
  PRIMARY KEY (`day`,`start_time`,`employee_id`,`end_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` (`day`, `start_time`, `end_time`, `employee_id`, `break`) VALUES (1,600,1400,1,'N'),(1,1000,1800,2,'N'),(1,1100,1900,3,'N'),(1,1400,1900,4,'Y'),(1,1700,2200,5,'Y'),(1,1730,2200,6,'Y'),(2,600,1400,1,'N'),(2,800,1600,2,'N'),(2,1200,2000,3,'N'),(2,1600,2200,4,'Y'),(2,1700,2200,5,'Y');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-17 21:53:07
