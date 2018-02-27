-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: hcbcmis
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
-- Table structure for table `Clients`
--

DROP TABLE IF EXISTS `Clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Clients` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Code` varchar(20) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `SurName` varchar(100) DEFAULT NULL,
  `PostalAddress` varchar(255) DEFAULT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `Phone1` varchar(40) NOT NULL,
  `Phone2` varchar(40) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `PhysicalLocation` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `CountryCode` varchar(5) DEFAULT NULL,
  `NextOfKin` varchar(100) NOT NULL,
  `NOKPhone1` varchar(40) NOT NULL,
  `NOKPhone2` varchar(40) DEFAULT NULL,
  `NOKPhysicalLocation` varchar(255) DEFAULT NULL,
  `Imagepath` varchar(255) DEFAULT NULL,
  `IsPatient` tinyint(1) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Clients`
--

LOCK TABLES `Clients` WRITE;
/*!40000 ALTER TABLE `Clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `Clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Companies`
--

DROP TABLE IF EXISTS `Companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Companies` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `DefaultCompany` tinyint(1) NOT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Companies`
--

LOCK TABLES `Companies` WRITE;
/*!40000 ALTER TABLE `Companies` DISABLE KEYS */;
INSERT INTO `Companies` VALUES (1,'10001','Community Care','Daniel','1234','00100','0722000001','0733000001','info@hcbc.org','www.hcbc.org','T-UK, Haile Selassie Avenue','Nairobi','KE',NULL,NULL,0,1,'2018-02-11 00:00:00');
/*!40000 ALTER TABLE `Companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Facilities`
--

DROP TABLE IF EXISTS `Facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Facilities` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `FacilityCode` varchar(20) NOT NULL,
  `CompanyId` bigint(20) NOT NULL,
  `FacilityName` varchar(100) NOT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Facilities_ Companies_idx` (`CompanyId`),
  CONSTRAINT `Facilities_Companies` FOREIGN KEY (`CompanyId`) REFERENCES `companies` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Facilities`
--

LOCK TABLES `Facilities` WRITE;
/*!40000 ALTER TABLE `Facilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `Facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserCode` varchar(40) NOT NULL,
  `JobTitleId` varchar(40) NOT NULL,
  `FacilityId` bigint(20) DEFAULT NULL,
  `NationalId` varchar(20) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `UserName` varchar(40) NOT NULL,
  `Root` tinyint(1) NOT NULL,
  `Password` longtext NOT NULL,
  `SecurityStamp` longtext,
  `RegKey` varchar(128) NOT NULL,
  `Registered` tinyint(1) NOT NULL,
  `ImgPath` varchar(256) DEFAULT NULL,
  `TwoFactorEnabled` tinyint(1) NOT NULL,
  `LockoutEndDateUtc` datetime DEFAULT NULL,
  `LockoutEnabled` tinyint(1) NOT NULL,
  `AccessFailedCount` int(11) NOT NULL,
  `PhoneNumber` varchar(100) NOT NULL,
  `PhoneNumberConfirmed` tinyint(1) NOT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `EmailConfirmed` tinyint(1) NOT NULL,
  `Disabled` int(1) NOT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `ix_NationalId` (`NationalId`),
  KEY `Users_Facilities` (`FacilityId`),
  CONSTRAINT `Users_Facilities` FOREIGN KEY (`FacilityId`) REFERENCES `Facilities` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'hcbcmis'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-27 18:44:41
