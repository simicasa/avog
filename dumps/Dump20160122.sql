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
  `codiceSede` varchar(20) DEFAULT NULL,
  `codiceProgetto` varchar(20) DEFAULT NULL,
  `dataInizio` date DEFAULT NULL,
  `limitePartecipanti` int(5) DEFAULT NULL,
  PRIMARY KEY (`codice`),
  KEY `codiceProgetto` (`codiceProgetto`),
  KEY `codiceSede` (`codiceSede`),
  CONSTRAINT `esame_ibfk_1` FOREIGN KEY (`codiceProgetto`) REFERENCES `progetto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `esame_ibfk_2` FOREIGN KEY (`codiceSede`) REFERENCES `sede` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `esame`
--

LOCK TABLES `esame` WRITE;
/*!40000 ALTER TABLE `esame` DISABLE KEYS */;
INSERT INTO `esame` VALUES (3,'4886','3121','2016-01-21',22),(4,'4886','3121','2000-01-01',33);
/*!40000 ALTER TABLE `esame` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES ('simone','napoli');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opzioni`
--

DROP TABLE IF EXISTS `opzioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opzioni` (
  `esaminandiGiornalieri` int(4) DEFAULT NULL,
  `postiMattina` int(3) DEFAULT NULL,
  `postiPomeriggio` int(3) DEFAULT NULL,
  `orarioMattina` varchar(10) DEFAULT NULL,
  `orarioPomeriggio` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opzioni`
--

LOCK TABLES `opzioni` WRITE;
/*!40000 ALTER TABLE `opzioni` DISABLE KEYS */;
INSERT INTO `opzioni` VALUES (2,1,1,'5:20','20:14');
/*!40000 ALTER TABLE `opzioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `nome` varchar(20) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `dataNascita` date DEFAULT NULL,
  `cf` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`cf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES ('dd','dd','2018-01-23','25jkk'),('aa','aa','2010-10-10','aa'),('ss','ss','1971-01-23','ss');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona_esame`
--

DROP TABLE IF EXISTS `persona_esame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona_esame` (
  `cf` varchar(20) NOT NULL DEFAULT '',
  `codiceEsame` int(6) NOT NULL DEFAULT '0',
  `dataConsegna` date DEFAULT NULL,
  `dataEsame` date DEFAULT NULL,
  `seMattina` int(1) DEFAULT NULL,
  PRIMARY KEY (`cf`,`codiceEsame`),
  KEY `codiceEsame` (`codiceEsame`),
  CONSTRAINT `persona_esame_ibfk_1` FOREIGN KEY (`cf`) REFERENCES `persona` (`cf`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `persona_esame_ibfk_2` FOREIGN KEY (`codiceEsame`) REFERENCES `esame` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona_esame`
--

LOCK TABLES `persona_esame` WRITE;
/*!40000 ALTER TABLE `persona_esame` DISABLE KEYS */;
INSERT INTO `persona_esame` VALUES ('25jkk',3,'2016-01-22','2016-01-22',0),('aa',3,'2016-01-22','2016-01-21',1),('ss',3,'2016-01-22','2016-01-21',0);
/*!40000 ALTER TABLE `persona_esame` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `progetto`
--

LOCK TABLES `progetto` WRITE;
/*!40000 ALTER TABLE `progetto` DISABLE KEYS */;
INSERT INTO `progetto` VALUES ('222','ppp'),('3121','Pollo'),('aaassddd','aaassddd'),('prog\'s','prog\'s');
/*!40000 ALTER TABLE `progetto` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `sede`
--

LOCK TABLES `sede` WRITE;
/*!40000 ALTER TABLE `sede` DISABLE KEYS */;
INSERT INTO `sede` VALUES ('111','aaa'),('4886','Pipposede'),('987','Qwerty'),('aa','ss'),('ass\'d','ass\'d'),('codice1nuovo','nome1nuovo'),('ddd','fff'),('fff','fff'),('ssss','aaaa');
/*!40000 ALTER TABLE `sede` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Dumping data for table `sede_progetto`
--

LOCK TABLES `sede_progetto` WRITE;
/*!40000 ALTER TABLE `sede_progetto` DISABLE KEYS */;
INSERT INTO `sede_progetto` VALUES ('4886','3121',100),('987','3121',77),('ass\'d','prog\'s',20),('fff','aaassddd',1000);
/*!40000 ALTER TABLE `sede_progetto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-22 15:56:20
