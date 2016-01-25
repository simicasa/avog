-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: lavoro1
-- ------------------------------------------------------
-- Server version	5.6.22-log

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
-- Table structure for table `esame`
--

DROP TABLE IF EXISTS `esame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `esame` (
  `codice` int(6) NOT NULL AUTO_INCREMENT,
  `codiceProgetto` varchar(20) DEFAULT NULL,
  `dataInizio` date DEFAULT NULL,
  `limitePartecipanti` int(5) DEFAULT NULL,
  PRIMARY KEY (`codice`),
  KEY `codiceProgetto` (`codiceProgetto`),
  CONSTRAINT `esame_ibfk_1` FOREIGN KEY (`codiceProgetto`) REFERENCES `progetto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `utente` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`utente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `opzioni`
--

DROP TABLE IF EXISTS `opzioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opzioni` (
  `esaminandiGiornalieri` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `nome` varchar(20) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `cf` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`cf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `persona_esame`
--

DROP TABLE IF EXISTS `persona_esame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona_esame` (
  `cf` varchar(20) NOT NULL DEFAULT '',
  `codiceEsame` int(6) NOT NULL DEFAULT '0',
  `dataEsame` date DEFAULT NULL,
  PRIMARY KEY (`cf`,`codiceEsame`),
  KEY `codiceEsame` (`codiceEsame`),
  CONSTRAINT `persona_esame_ibfk_1` FOREIGN KEY (`cf`) REFERENCES `persona` (`cf`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `persona_esame_ibfk_2` FOREIGN KEY (`codiceEsame`) REFERENCES `esame` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `progetto`
--

DROP TABLE IF EXISTS `progetto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `progetto` (
  `codice` varchar(20) NOT NULL DEFAULT '',
  `nome` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`codice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sede`
--

DROP TABLE IF EXISTS `sede`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sede` (
  `codice` varchar(20) NOT NULL DEFAULT '',
  `nome` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`codice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sede_progetto`
--

DROP TABLE IF EXISTS `sede_progetto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sede_progetto` (
  `codiceSede` varchar(20) NOT NULL DEFAULT '',
  `codiceProgetto` varchar(20) NOT NULL DEFAULT '',
  `posti` int(4) DEFAULT NULL,
  PRIMARY KEY (`codiceSede`,`codiceProgetto`),
  KEY `codiceProgetto` (`codiceProgetto`),
  CONSTRAINT `sede_progetto_ibfk_1` FOREIGN KEY (`codiceSede`) REFERENCES `sede` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sede_progetto_ibfk_2` FOREIGN KEY (`codiceProgetto`) REFERENCES `progetto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-21 10:01:47
