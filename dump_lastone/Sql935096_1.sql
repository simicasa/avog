-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: 62.149.150.178
-- Generato il: Gen 25, 2016 alle 22:40
-- Versione del server: 5.5.45
-- Versione PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Sql935096_1`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `esame`
--

CREATE TABLE IF NOT EXISTS `esame` (
  `codice` int(6) NOT NULL AUTO_INCREMENT,
  `codiceSede` varchar(20) DEFAULT NULL,
  `codiceProgetto` varchar(20) DEFAULT NULL,
  `dataInizio` date DEFAULT NULL,
  `limitePartecipanti` int(5) DEFAULT NULL,
  PRIMARY KEY (`codice`),
  KEY `codiceProgetto` (`codiceProgetto`),
  KEY `codiceSede` (`codiceSede`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dump dei dati per la tabella `esame`
--

INSERT INTO `esame` (`codice`, `codiceSede`, `codiceProgetto`, `dataInizio`, `limitePartecipanti`) VALUES
(7, ' 49869', '1', '2016-02-15', 100000),
(8, '49858', '1', '2016-02-15', 100000),
(9, '49891', '1', '2016-02-15', 100000),
(10, '71341', '1', '2016-02-15', 100000),
(11, '76873', '1', '2016-02-15', 100000),
(12, '76925', '1', '2016-02-15', 100000),
(13, '76996', '1', '2016-02-15', 100000),
(14, '95068', '1', '2016-02-15', 100000),
(15, '21098', '2', '2016-02-15', 100000),
(16, '21110', '2', '2016-02-15', 100000),
(17, '21113', '2', '2016-02-15', 100000),
(18, '21115', '2', '2016-02-15', 100000),
(19, '21139', '2', '2016-02-15', 100000),
(20, '49837', '2', '2016-02-15', 100000),
(21, '49850', '2', '2016-02-15', 100000),
(22, '49857', '2', '2016-02-15', 100000),
(23, '77932', '2', '2016-02-15', 100000),
(24, '49828', '3', '2016-02-15', 100000),
(25, '49831', '3', '2016-02-15', 100000),
(26, '49868', '3', '2016-02-15', 100000),
(27, '49870', '3', '2016-02-15', 100000),
(28, '71396', '3', '2016-02-15', 100000),
(29, '76829', '3', '2016-02-15', 100000),
(30, '76896', '3', '2016-02-15', 100000),
(31, '76983', '3', '2016-02-15', 100000),
(32, '76984', '3', '2016-02-15', 100000),
(33, '77267', '3', '2016-02-15', 100000),
(34, '80824', '3', '2016-02-15', 100000),
(35, '49827', '4', '2016-02-15', 100000),
(36, '49829', '4', '2016-02-15', 100000),
(37, '49855', '4', '2016-02-15', 100000),
(38, '49861', '4', '2016-02-15', 100000),
(39, '49886', '4', '2016-02-15', 100000),
(40, '49887', '4', '2016-02-15', 100000),
(41, '49888', '4', '2016-02-15', 100000),
(42, '76807', '4', '2016-02-15', 100000),
(43, '76845', '4', '2016-02-15', 100000),
(44, '76995', '4', '2016-02-15', 100000),
(45, '86527', '4', '2016-02-15', 100000);

-- --------------------------------------------------------

--
-- Struttura della tabella `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `utente` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`utente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `login`
--

INSERT INTO `login` (`utente`, `password`) VALUES
('admin', 'avog2016'),
('simone', 'napoli');

-- --------------------------------------------------------

--
-- Struttura della tabella `opzioni`
--

CREATE TABLE IF NOT EXISTS `opzioni` (
  `esaminandiGiornalieri` int(4) DEFAULT NULL,
  `postiMattina` int(3) DEFAULT NULL,
  `postiPomeriggio` int(3) DEFAULT NULL,
  `orarioMattina` varchar(10) DEFAULT NULL,
  `orarioPomeriggio` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `opzioni`
--

INSERT INTO `opzioni` (`esaminandiGiornalieri`, `postiMattina`, `postiPomeriggio`, `orarioMattina`, `orarioPomeriggio`) VALUES
(100, 0, 100, '09:00:', '14:30:');

-- --------------------------------------------------------

--
-- Struttura della tabella `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `cognome` varchar(100) DEFAULT NULL,
  `dataNascita` date DEFAULT NULL,
  `cf` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cf` (`cf`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dump dei dati per la tabella `persona`
--

INSERT INTO `persona` (`id`, `nome`, `cognome`, `dataNascita`, `cf`) VALUES
(17, 'pippo', 'baudo', NULL, 'mmmmmmmmmm'),
(18, 'pippo', 'baudo', NULL, 'fpasafsa'),
(19, 'pippo', 'baudo', NULL, 'fpasafsa1'),
(20, 'pippo', 'baudo', NULL, 'asdfrgthyujiko'),
(21, 'asd', 'asd', '1990-07-06', 'asd');

-- --------------------------------------------------------

--
-- Struttura della tabella `persona_esame`
--

CREATE TABLE IF NOT EXISTS `persona_esame` (
  `cf` varchar(20) NOT NULL DEFAULT '',
  `personaID` int(7) DEFAULT NULL,
  `codiceEsame` int(6) NOT NULL DEFAULT '0',
  `dataConsegna` date DEFAULT NULL,
  `dataEsame` date DEFAULT NULL,
  `seMattina` int(1) DEFAULT NULL,
  PRIMARY KEY (`cf`,`codiceEsame`),
  KEY `codiceEsame` (`codiceEsame`),
  KEY `personaID` (`personaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `persona_esame`
--

INSERT INTO `persona_esame` (`cf`, `personaID`, `codiceEsame`, `dataConsegna`, `dataEsame`, `seMattina`) VALUES
('asd', 21, 7, '2016-01-25', '2016-02-15', 1),
('asdfrgthyujiko', 20, 35, '2016-01-25', '2016-02-15', 1),
('fpasafsa', 18, 36, '2016-01-25', '2016-02-15', 1),
('fpasafsa1', 19, 36, '2016-01-25', '2016-02-15', 1),
('mmmmmmmmmm', 17, 35, '2016-01-25', '2016-02-15', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `progetto`
--

CREATE TABLE IF NOT EXISTS `progetto` (
  `codice` varchar(20) NOT NULL DEFAULT '',
  `nome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`codice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `progetto`
--

INSERT INTO `progetto` (`codice`, `nome`) VALUES
('1', 'UNITI NELLA DIVERSITA'''),
('2', 'SCAMPIA CON LA SCUOLA'),
('3', 'COSTRUIAMO IL FUTURO'),
('4', 'LA SCUOLA E'' SPERANZA');

-- --------------------------------------------------------

--
-- Struttura della tabella `sede`
--

CREATE TABLE IF NOT EXISTS `sede` (
  `codice` varchar(20) NOT NULL DEFAULT '',
  `nome` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `sede`
--

INSERT INTO `sede` (`codice`, `nome`) VALUES
(' 49869', 'I.C. STATALE F. RUSSO II 1'),
('21098', 'IST. COMPRENSIVO C.D. 82- S.M.S. S. D&#039;ACQUISTO'),
('21110', 'I.C. 43Â° C. D. S.M.S. S. GAETANO'),
('21113', '87Â° CIRCOLO'),
('21115', 'S.M.S ERRICO- PASCOLI'),
('21139', 'ASSOCIAZIONE A.VO.G. 4'),
('49827', '1Â° CIRCOLO DI ARZANO'),
('49828', '2Â° CIRCOLO DI MUGNANO 1'),
('49829', '2Â° CIRCOLO DI MUGNANO 2'),
('49831', '39Â° CIRCOLO DIDATTICO â€œG.LEOPARDIâ€'),
('49837', '61Â° C. D. N. SAURO plesso Saverio Piantedosi'),
('49850', 'C.D. S. GIOVANNI PASCOLI '),
('49855', 'DIREZIONE DIDATTICA STATALE NÂ° 38a'),
('49857', 'A.VO.G. - EVER GREEN'),
('49858', 'I.C. 45Â° C.D. SMS BONGHI  I(ELEMENTARE)'),
('49861', 'I.C. N. ROMEO'),
('49868', 'I.C. STATALE F. RUSSO II'),
('49870', 'I.C. XI C.D. M.S. P. SCURA'),
('49880', 'S.M.S. A. SOGLIANO'),
('49886', 'S.M.S. G. MARCONI 1'),
('49887', 'S.M.S. G.B. BASILE'),
('49888', 'S.M.S. GIANCARLO SIANI'),
('49891', ' SMS BORDIGA/NAPOLITANO'),
('71341', 'CONVITTO NAZIONALE VITTORIO EMANUELE II'),
('71396', ' S.M.S. GIACINTO GIGANTE '),
('76807', '88Â° CIRCOLO EDUARDO DE FILIPPO'),
('76829', '42Â° CIRCOLO ETTORE CARAFA'),
('76845', '76Â° C. D. F. MASTRIANI'),
('76873', 'I.C.S BERLINGUER'),
('76896', 'I.S. ITALO SVEVO'),
('76925', 'I.C.S A. CUSTRA'),
('76983', '61Â° C. DI MUGNANO '),
('76984', 'I.C.S. F. DI CAPUA'),
('76995', 'SS. 1Â° GRADO FILIPPO ILLUMINATO'),
('76996', 'S.M.S. M. D&#039;AZEGLIO'),
('77267', 'S.S DI 1Â° GRADO E. BORRELLI'),
('77932', 'AVOG URBAN'),
('80824', '61. C. SAVIO-ALFIERI'),
('86527', '7. C.D. SALVATORE DI GIACOMO'),
('95068', 'I.C.S BOVIO-COLLETTA');

-- --------------------------------------------------------

--
-- Struttura della tabella `sede_progetto`
--

CREATE TABLE IF NOT EXISTS `sede_progetto` (
  `codiceSede` varchar(20) NOT NULL DEFAULT '',
  `codiceProgetto` varchar(20) NOT NULL DEFAULT '',
  `posti` int(4) DEFAULT NULL,
  PRIMARY KEY (`codiceSede`,`codiceProgetto`),
  KEY `codiceProgetto` (`codiceProgetto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `sede_progetto`
--

INSERT INTO `sede_progetto` (`codiceSede`, `codiceProgetto`, `posti`) VALUES
(' 49869', '1', 4),
('21098', '2', 4),
('21110', '2', 4),
('21113', '2', 4),
('21115', '2', 4),
('21139', '2', 4),
('49827', '4', 5),
('49828', '3', 4),
('49829', '4', 4),
('49831', '3', 5),
('49837', '2', 4),
('49850', '2', 4),
('49855', '4', 4),
('49857', '2', 4),
('49858', '1', 3),
('49861', '4', 5),
('49868', '3', 4),
('49870', '3', 5),
('49886', '4', 5),
('49887', '4', 5),
('49888', '4', 5),
('49891', '1', 4),
('71341', '1', 4),
('71396', '3', 5),
('76807', '4', 4),
('76829', '3', 5),
('76845', '4', 5),
('76873', '1', 4),
('76896', '3', 5),
('76925', '1', 4),
('76983', '3', 5),
('76984', '3', 4),
('76995', '4', 4),
('76996', '1', 4),
('77267', '3', 3),
('77932', '2', 4),
('80824', '3', 5),
('86527', '4', 4),
('95068', '1', 3);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `esame`
--
ALTER TABLE `esame`
  ADD CONSTRAINT `esame_ibfk_1` FOREIGN KEY (`codiceProgetto`) REFERENCES `progetto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `esame_ibfk_2` FOREIGN KEY (`codiceSede`) REFERENCES `sede` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `persona_esame`
--
ALTER TABLE `persona_esame`
  ADD CONSTRAINT `persona_esame_ibfk_1` FOREIGN KEY (`codiceEsame`) REFERENCES `esame` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persona_esame_ibfk_2` FOREIGN KEY (`personaID`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `sede_progetto`
--
ALTER TABLE `sede_progetto`
  ADD CONSTRAINT `sede_progetto_ibfk_1` FOREIGN KEY (`codiceSede`) REFERENCES `sede` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sede_progetto_ibfk_2` FOREIGN KEY (`codiceProgetto`) REFERENCES `progetto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
