-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: hcbc
-- ------------------------------------------------------
-- Server version	5.7.19

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
-- Table structure for table `HcbcInstitutions`
--

DROP TABLE IF EXISTS `HcbcInstitutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HcbcInstitutions` (
  `Id` varchar(40) NOT NULL,
  `Code` varchar(20) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Contact` varchar(100) NOT NULL,
  `PostalAddress` varchar(255) DEFAULT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `Phone1` varchar(40) DEFAULT NULL,
  `Phone2` varchar(40) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Website` varchar(255) DEFAULT NULL,
  `PhysicalLocation` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `CountryCode` varchar(5) DEFAULT NULL,
  `TaxNumber` varchar(20) DEFAULT NULL,
  `Logopath` varchar(255) DEFAULT NULL,
  `Disabled` tinyint(1) NOT NULL,
  `DefaultInst` tinyint(1) NOT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `ix_code` (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HcbcInstitutions`
--

LOCK TABLES `HcbcInstitutions` WRITE;
/*!40000 ALTER TABLE `HcbcInstitutions` DISABLE KEYS */;
/*!40000 ALTER TABLE `HcbcInstitutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `HcbcUsers`
--

DROP TABLE IF EXISTS `HcbcUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HcbcUsers` (
  `Id` varchar(128) NOT NULL,
  `UserCode` varchar(40) NOT NULL,
  `InstId` varchar(40) NOT NULL,
  `DepartmentId` varchar(40) NOT NULL,
  `JobTitleId` varchar(40) DEFAULT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `PhoneNumber` longtext,
  `PhoneNumberConfirmed` tinyint(1) NOT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `EmailConfirmed` tinyint(1) NOT NULL,
  `UserName` varchar(256) NOT NULL,
  `PasswordHash` longtext NOT NULL,
  `SecurityStamp` longtext,
  `Root` tinyint(1) NOT NULL,
  `RegKey` varchar(128) NOT NULL,
  `Registered` tinyint(1) NOT NULL,
  `ImgPath` varchar(256) DEFAULT NULL,
  `TwoFactorEnabled` tinyint(1) NOT NULL,
  `LockoutEndDateUtc` datetime DEFAULT NULL,
  `LockoutEnabled` tinyint(1) NOT NULL,
  `AccessFailedCount` int(11) NOT NULL,
  `Disabled` tinyint(1) NOT NULL,
  `Theme` varchar(40) DEFAULT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `HcbcUsers_HcbcInstitutions` (`InstId`),
  CONSTRAINT `HcbcUsers_HcbcInstitutions` FOREIGN KEY (`InstId`) REFERENCES `HcbcInstitutions` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HcbcUsers`
--

LOCK TABLES `HcbcUsers` WRITE;
/*!40000 ALTER TABLE `HcbcUsers` DISABLE KEYS */;
/*!40000 ALTER TABLE `HcbcUsers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'hcbc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-03 11:43:51
