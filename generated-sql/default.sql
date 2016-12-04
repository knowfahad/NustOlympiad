
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- ambassador
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ambassador`;

CREATE TABLE `ambassador`
(
    `AmbassadorID` VARCHAR(20) NOT NULL,
    `CNIC` VARCHAR(13) NOT NULL,
    `FirstName` VARCHAR(25) NOT NULL,
    `LastName` VARCHAR(15),
    `Email` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`AmbassadorID`),
    UNIQUE INDEX `CNIC` (`CNIC`),
    UNIQUE INDEX `Email` (`Email`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ambassador_participant
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ambassador_participant`;

CREATE TABLE `ambassador_participant`
(
    `id` INTEGER(10) NOT NULL,
    `ParticipantCNIC` VARCHAR(13) NOT NULL,
    `AmbassadorID` VARCHAR(20) NOT NULL,
    `EventID` INTEGER,
    `SportID` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `Refered Participant` (`ParticipantCNIC`),
    INDEX `Referer Ambassador` (`AmbassadorID`),
    INDEX `Event Refered` (`EventID`),
    INDEX `Sports Refered` (`SportID`),
    CONSTRAINT `Event Refered`
        FOREIGN KEY (`EventID`)
        REFERENCES `events` (`EventID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `Refered Participant`
        FOREIGN KEY (`ParticipantCNIC`)
        REFERENCES `participant` (`CNIC`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `Referer Ambassador`
        FOREIGN KEY (`AmbassadorID`)
        REFERENCES `ambassador` (`AmbassadorID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `Sports Refered`
        FOREIGN KEY (`SportID`)
        REFERENCES `sports` (`SportID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- challan
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `challan`;

CREATE TABLE `challan`
(
    `ChallanID` VARCHAR(30) NOT NULL,
    `AmountPayable` INTEGER(10) NOT NULL,
    `DueDate` DATE NOT NULL,
    `PaymentStatus` INTEGER(1) NOT NULL,
    PRIMARY KEY (`ChallanID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- eventparticipants
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `eventparticipants`;

CREATE TABLE `eventparticipants`
(
    `ParticipantCNIC` VARCHAR(13) NOT NULL,
    `EventID` INTEGER NOT NULL,
    `ChallanID` VARCHAR(30) NOT NULL,
    `PaymentStatus` INTEGER(1) NOT NULL,
    `DueDate` DATE NOT NULL,
    PRIMARY KEY (`ParticipantCNIC`,`EventID`),
    INDEX `FKEventParti290858` (`ParticipantCNIC`),
    INDEX `FKEventParti6428` (`EventID`),
    CONSTRAINT `FKEventParti290858`
        FOREIGN KEY (`ParticipantCNIC`)
        REFERENCES `participant` (`CNIC`),
    CONSTRAINT `FKEventParti6428`
        FOREIGN KEY (`EventID`)
        REFERENCES `events` (`EventID`)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- events
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events`
(
    `EventID` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(30) NOT NULL,
    `EventFee` INTEGER(10) NOT NULL,
    `EventType` INTEGER(1) NOT NULL,
    PRIMARY KEY (`EventID`),
    UNIQUE INDEX `Name` (`Name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- participant
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `participant`;

CREATE TABLE `participant`
(
    `ParticipantID` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `CNIC` VARCHAR(13) NOT NULL,
    `RegistrationChallanID` VARCHAR(30) NOT NULL,
    `AccomodationChallanID` VARCHAR(30),
    `FirstName` VARCHAR(25) NOT NULL,
    `LastName` VARCHAR(15),
    `Gender` VARCHAR(6) DEFAULT 'Male' NOT NULL,
    `Address` VARCHAR(100),
    `PhoneNo` VARCHAR(13) NOT NULL,
    `NUSTRegNo` VARCHAR(35),
    `AmbassadorID` VARCHAR(20),
    PRIMARY KEY (`ParticipantID`),
    UNIQUE INDEX `CNINC` (`CNIC`),
    UNIQUE INDEX `RegistrationChallanID` (`RegistrationChallanID`),
    UNIQUE INDEX `NUSTRegNo` (`NUSTRegNo`),
    UNIQUE INDEX `AmbassadorID` (`AmbassadorID`),
    UNIQUE INDEX `AccomodationChallanID` (`AccomodationChallanID`),
    INDEX `Registration Fee` (`RegistrationChallanID`),
    INDEX `AccomodationFee` (`AccomodationChallanID`),
    INDEX `FKparticipan905517` (`AmbassadorID`),
    CONSTRAINT `AccomodationFee`
        FOREIGN KEY (`AccomodationChallanID`)
        REFERENCES `challan` (`ChallanID`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `FKparticipan905517`
        FOREIGN KEY (`AmbassadorID`)
        REFERENCES `ambassador` (`AmbassadorID`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `Registration Fee`
        FOREIGN KEY (`RegistrationChallanID`)
        REFERENCES `challan` (`ChallanID`)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sports
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sports`;

CREATE TABLE `sports`
(
    `SportID` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(30) NOT NULL,
    `FeePerParticipant` INTEGER(10) NOT NULL,
    `MaxParticipants` INTEGER(2) NOT NULL,
    PRIMARY KEY (`SportID`),
    UNIQUE INDEX `Name` (`Name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sportsparticipants
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sportsparticipants`;

CREATE TABLE `sportsparticipants`
(
    `TeamID` INTEGER NOT NULL,
    `ParticipantCNIC` VARCHAR(13) NOT NULL,
    PRIMARY KEY (`TeamID`,`ParticipantCNIC`),
    INDEX `FKSportsPart534001` (`ParticipantCNIC`),
    INDEX `FKSportsPart30093` (`TeamID`),
    CONSTRAINT `FKSportsPart30093`
        FOREIGN KEY (`TeamID`)
        REFERENCES `sportsteam` (`TeamID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `FKSportsPart534001`
        FOREIGN KEY (`ParticipantCNIC`)
        REFERENCES `participant` (`CNIC`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sportsteam
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sportsteam`;

CREATE TABLE `sportsteam`
(
    `TeamID` INTEGER NOT NULL AUTO_INCREMENT,
    `SportID` INTEGER NOT NULL,
    `TeamName` VARCHAR(30) NOT NULL,
    `HeadCNIC` VARCHAR(13) NOT NULL,
    `ChallanID` VARCHAR(30) NOT NULL,
    `AmountPayable` INTEGER(10) NOT NULL,
    `DueData` DATE NOT NULL,
    `PaymentStatus` INTEGER(1) NOT NULL,
    PRIMARY KEY (`TeamID`),
    INDEX `Sports Teams` (`SportID`),
    INDEX `Team Head` (`HeadCNIC`),
    CONSTRAINT `Sports Teams`
        FOREIGN KEY (`SportID`)
        REFERENCES `sports` (`SportID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `Team Head`
        FOREIGN KEY (`HeadCNIC`)
        REFERENCES `participant` (`CNIC`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- useraccount
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `useraccount`;

CREATE TABLE `useraccount`
(
    `Username` VARCHAR(15) NOT NULL,
    `ParticipantCNIC` VARCHAR(13) NOT NULL,
    `Email` VARCHAR(100) NOT NULL,
    `Password` VARCHAR(50) NOT NULL,
    `AccountStatus` INTEGER(1) NOT NULL,
    `ActivationCode` VARCHAR(10),
    `ResetCode` VARCHAR(10),
    PRIMARY KEY (`Username`),
    UNIQUE INDEX `Email` (`Email`),
    UNIQUE INDEX `ParticipantCNIC` (`ParticipantCNIC`),
    INDEX `FKUserAccoun194287` (`ParticipantCNIC`),
    CONSTRAINT `FKUserAccoun194287`
        FOREIGN KEY (`ParticipantCNIC`)
        REFERENCES `participant` (`CNIC`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
