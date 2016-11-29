-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2016 at 06:53 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olympiad`
--

-- --------------------------------------------------------

--
-- Table structure for table `ambassador`
--

create schema olympiad;
use olympiad;


DROP TABLE IF EXISTS `ambassador`;
CREATE TABLE IF NOT EXISTS `ambassador` (
  `AmbassadorID` varchar(20) NOT NULL,
  `CNIC` varchar(13) NOT NULL,
  `FirstName` varchar(25) NOT NULL,
  `LastName` varchar(15) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`AmbassadorID`),
  UNIQUE KEY `CNIC` (`CNIC`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `challan`
--

DROP TABLE IF EXISTS `challan`;
CREATE TABLE IF NOT EXISTS `challan` (
  `ChallanID` varchar(30) NOT NULL,
  `AmountPayable` int(10) NOT NULL,
  `DueDate` date NOT NULL,
  `PaymentStatus` int(1) NOT NULL,
  PRIMARY KEY (`ChallanID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eventparticipants`
--

DROP TABLE IF EXISTS `eventparticipants`;
CREATE TABLE IF NOT EXISTS `eventparticipants` (
  `ParticipantCNIC` varchar(13) NOT NULL,
  `EventID` int(11) NOT NULL,
  `ChallanID` varchar(30) NOT NULL,
  `PaymentStatus` int(1) NOT NULL,
  `DueDate` date NOT NULL,
  PRIMARY KEY (`ParticipantCNIC`,`EventID`),
  KEY `FKEventParti290858` (`ParticipantCNIC`),
  KEY `FKEventParti6428` (`EventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `EventID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `EventFee` int(10) NOT NULL,
  `EventType` int(1) NOT NULL,
  PRIMARY KEY (`EventID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

DROP TABLE IF EXISTS `participant`;
CREATE TABLE IF NOT EXISTS `participant` (
  `ParticipantID` int(10) AUTO_INCREMENT,
  `CNIC` varchar(13) NOT NULL ,
  `RegistrationChallanID` varchar(30) NOT NULL,
  `AccomodationChallanID` varchar(30) DEFAULT NULL,
  `FirstName` varchar(25) NOT NULL,
  `LastName` varchar(15) DEFAULT NULL,
  `Gender` varchar(6) NOT NULL DEFAULT 'Male',
  `Address` varchar(100) DEFAULT NULL,
  `PhoneNo` varchar(13) NOT NULL,
  `NUSTRegNo` varchar(35) DEFAULT NULL,
  `AmbassadorID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ParticipantID`),
  UNIQUE KEY `CNINC` (`CNIC`),
  UNIQUE KEY `RegistrationChallanID` (`RegistrationChallanID`),
  UNIQUE KEY `NUSTRegNo` (`NUSTRegNo`),
  UNIQUE KEY `AmbassadorID` (`AmbassadorID`),
  UNIQUE KEY `AccomodationChallanID` (`AccomodationChallanID`),
  KEY `Registration Fee` (`RegistrationChallanID`),
  KEY `AccomodationFee` (`AccomodationChallanID`),
  KEY `FKparticipan905517` (`AmbassadorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1478;

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

DROP TABLE IF EXISTS `sports`;
CREATE TABLE IF NOT EXISTS `sports` (
  `SportID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `FeePerParticipant` int(10) NOT NULL,
  `MaxParticipants` int(2) NOT NULL,
  PRIMARY KEY (`SportID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sportsparticipants`
--

DROP TABLE IF EXISTS `sportsparticipants`;
CREATE TABLE IF NOT EXISTS `sportsparticipants` (
  `TeamID` int(11) NOT NULL,
`ParticipantCNIC` VARCHAR(13) NOT NULL,
  PRIMARY KEY (`ParticipantCNIC`,`TeamID`),
  KEY `FKSportsPart534001` (`ParticipantCNIC`),
  KEY `FKSportsPart30093` (`TeamID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sportsteam`
--

DROP TABLE IF EXISTS `sportsteam`;
CREATE TABLE IF NOT EXISTS `sportsteam` (
  `TeamID` int(11) NOT NULL AUTO_INCREMENT,
  `SportID` int(11) NOT NULL,
  `TeamName` varchar(30) NOT NULL,
  `HeadCNIC` varchar(13) NOT NULL,
  `ChallanID` varchar(30) NOT NULL,
  `AmountPayable` int(10) NOT NULL,
  `DueData` date NOT NULL,
  `PaymentStatus` int(1) NOT NULL,
  PRIMARY KEY (`TeamID`),
  KEY `Sports Teams` (`SportID`),
  KEY `Team Head` (`HeadCNIC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE IF NOT EXISTS `useraccount` (
  `Username` varchar(15) NOT NULL,
  `ParticipantCNIC` varchar(13) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `AccountStatus` int(1) NOT NULL,
  `ActivationCode` varchar(10) DEFAULT NULL,
  `ResetCode` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Username`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `ParticipantCNIC` (`ParticipantCNIC`),
  KEY `FKUserAccoun194287` (`ParticipantCNIC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

DROP TABLE IF EXISTS `ambassador_participant`;
CREATE TABLE IF NOT EXISTS `ambassador_participant` (
  `id` int(10),
  `ParticipantCNIC` varchar(13) NOT NULL,
  `AmbassadorID`   varchar(20) NOT NULL,
  `EventID` int(11),
  `SportID` int(11),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventparticipants`
--
ALTER TABLE `eventparticipants`
  ADD CONSTRAINT `FKEventParti290858` FOREIGN KEY (`ParticipantCNIC`) REFERENCES `participant` (`CNIC`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FKEventParti6428` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`) ON UPDATE CASCADE;

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `AccomodationFee` FOREIGN KEY (`AccomodationChallanID`) REFERENCES `challan` (`ChallanID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FKparticipan905517` FOREIGN KEY (`AmbassadorID`) REFERENCES `ambassador` (`AmbassadorID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Registration Fee` FOREIGN KEY (`RegistrationChallanID`) REFERENCES `challan` (`ChallanID`) ON UPDATE CASCADE;

--
-- Constraints for table `sportsparticipants`
--
ALTER TABLE `sportsparticipants`
  ADD CONSTRAINT `FKSportsPart30093` FOREIGN KEY (`TeamID`) REFERENCES `sportsteam` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKSportsPart534001` FOREIGN KEY (`ParticipantCNIC`) REFERENCES `participant` (`CNIC`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sportsteam`
--
ALTER TABLE `sportsteam`
  ADD CONSTRAINT `Sports Teams` FOREIGN KEY (`SportID`) REFERENCES `sports` (`SportID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Team Head` FOREIGN KEY (`HeadCNIC`) REFERENCES `participant` (`CNIC`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD CONSTRAINT `FKUserAccoun194287` FOREIGN KEY (`ParticipantCNIC`) REFERENCES `participant` (`CNIC`) ON DELETE CASCADE ON UPDATE CASCADE;
  --
  -- Constraints for table `ambassador_participant`
  --
ALTER TABLE `ambassador_participant`
  ADD CONSTRAINT `Refered Participant` FOREIGN KEY (`ParticipantCNIC`) REFERENCES `participant` (`CNIC`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Referer Ambassador` FOREIGN KEY (`AmbassadorID`) REFERENCES `ambassador` (`AmbassadorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Event Refered` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Sports Refered` FOREIGN KEY (`SportID`) REFERENCES `sports` (`SportID`) ON DELETE CASCADE ON UPDATE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

