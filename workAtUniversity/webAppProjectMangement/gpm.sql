SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `GPM` ;
CREATE SCHEMA IF NOT EXISTS `GPM` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `GPM` ;

-- -----------------------------------------------------
-- Table `GPM`.`SOURCE_OF_BUDGET`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`SOURCE_OF_BUDGET` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`SOURCE_OF_BUDGET` (
  `SourceOfBudget_ID` INT NOT NULL AUTO_INCREMENT ,
  `SourceOfBudget_Name` TEXT NULL ,
  `SourceOfBudget_Description` LONGTEXT NULL ,
  PRIMARY KEY (`SourceOfBudget_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`PLAN_TYPE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`PLAN_TYPE` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`PLAN_TYPE` (
  `Plan_Type_Name` TEXT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`ANNUAL_OBJECTIVE_PLAN`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`ANNUAL_OBJECTIVE_PLAN` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`ANNUAL_OBJECTIVE_PLAN` (
  `Plan_ID` INT NOT NULL AUTO_INCREMENT ,
  `Plan_Name` TEXT NULL ,
  `Fiscal_Year` YEAR NULL ,
  `Plan_Type` TEXT NULL ,
  PRIMARY KEY (`Plan_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`STRATEGY`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`STRATEGY` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`STRATEGY` (
  `Strategy_ID` INT NOT NULL AUTO_INCREMENT ,
  `Strategy_Number` TEXT NULL ,
  `Strategy_Description` LONGTEXT NULL ,
  `Strategy_Type` TEXT NULL ,
  `Strategy_Status` TEXT NULL ,
  `Plan_ID` INT NOT NULL ,
  PRIMARY KEY (`Strategy_ID`) ,
  INDEX `fk_STRATEGY_ANNUAL_OBJECTIVE_PLAN1_idx` (`Plan_ID` ASC) ,
  CONSTRAINT `fk_STRATEGY_ANNUAL_OBJECTIVE_PLAN1`
    FOREIGN KEY (`Plan_ID` )
    REFERENCES `GPM`.`ANNUAL_OBJECTIVE_PLAN` (`Plan_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`STRATEGY_REVISE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`STRATEGY_REVISE` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`STRATEGY_REVISE` (
  `Strategy_Revise_ID` INT NOT NULL AUTO_INCREMENT ,
  `Revise_Number` INT NULL ,
  `Revise_Date` DATETIME NULL ,
  `Notes` LONGTEXT NULL ,
  `Strategy_ID` INT NOT NULL ,
  `Previous_Strategy_ID` INT NULL ,
  PRIMARY KEY (`Strategy_Revise_ID`) ,
  INDEX `fk_STRATEGY_REVISE_STRATEGY1_idx` (`Strategy_ID` ASC) ,
  CONSTRAINT `fk_STRATEGY_REVISE_STRATEGY1`
    FOREIGN KEY (`Strategy_ID` )
    REFERENCES `GPM`.`STRATEGY` (`Strategy_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`PROJECT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`PROJECT` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`PROJECT` (
  `Project_ID` INT NOT NULL AUTO_INCREMENT ,
  `Project_Name` TEXT NULL ,
  `Project_Goal` LONGTEXT NULL ,
  `Project_Principles_Rationale` LONGTEXT NULL ,
  `Project_Location` TEXT NULL ,
  `Project_Status` TEXT NULL ,
  `Project_Type` TEXT NULL ,
  `Project_Manager` TEXT NULL ,
  `Project_Coordinator` TEXT NULL ,
  `Project_Target` LONGTEXT NULL ,
  `Consistency_With_Overall_Objective` LONGTEXT NULL ,
  `Notes` LONGTEXT NULL ,
  `Expected_Outcome_Result` LONGTEXT NULL ,
  `Expected_Output_Result` LONGTEXT NULL ,
  `Reserved_Fund` FLOAT NULL ,
  `Outcome_Indicator` LONGTEXT NULL ,
  `Productive_Indicator` LONGTEXT NULL ,
  `Task_Force` TEXT NULL ,
  `Project_Tracking_And_Evalution` MEDIUMTEXT NULL ,
  `Anticipated_Deliverable` LONGTEXT NULL ,
  `Return_On_Project` MEDIUMTEXT NULL ,
  `Is_Approved` TINYINT(1) NULL ,
  PRIMARY KEY (`Project_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`AIM`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`AIM` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`AIM` (
  `Aim_ID` INT NOT NULL AUTO_INCREMENT ,
  `Aim_Number` INT NULL ,
  `Aim_Description` LONGTEXT NULL ,
  `Strategy_ID` INT NOT NULL ,
  PRIMARY KEY (`Aim_ID`) ,
  INDEX `fk_AIM_STRATEGY1_idx` (`Strategy_ID` ASC) ,
  CONSTRAINT `fk_AIM_STRATEGY1`
    FOREIGN KEY (`Strategy_ID` )
    REFERENCES `GPM`.`STRATEGY` (`Strategy_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`FISCAL_YEAR_PROJECT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`FISCAL_YEAR_PROJECT` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`FISCAL_YEAR_PROJECT` (
  `Fiscal_Year_Project_Number` INT NOT NULL AUTO_INCREMENT ,
  `Project_ID` INT NOT NULL ,
  `Fiscal_Year` YEAR NULL ,
  `Planned_Starting_Date` DATETIME NULL ,
  `Planned_Ending_Date` DATETIME NULL ,
  `Actual_Starting_Date` DATETIME NULL ,
  `Actual_Ending_Date` DATETIME NULL ,
  `Notes` LONGTEXT NULL ,
  PRIMARY KEY (`Fiscal_Year_Project_Number`) ,
  INDEX `fk_FISCAL_YEAR_PROJECT_PROJECT1_idx` (`Project_ID` ASC) ,
  CONSTRAINT `fk_FISCAL_YEAR_PROJECT_PROJECT1`
    FOREIGN KEY (`Project_ID` )
    REFERENCES `GPM`.`PROJECT` (`Project_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`AIM_PROJECT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`AIM_PROJECT` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`AIM_PROJECT` (
  `Aim_Project_ID` INT NOT NULL AUTO_INCREMENT ,
  `Aim_ID` INT NOT NULL ,
  `Project_ID` INT NOT NULL ,
  `Notes` LONGTEXT NULL ,
  PRIMARY KEY (`Aim_Project_ID`) ,
  INDEX `fk_AIM_PROJECT_PROJECT1_idx` (`Project_ID` ASC) ,
  INDEX `fk_AIM_PROJECT_AIM1_idx` (`Aim_ID` ASC) ,
  CONSTRAINT `fk_AIM_PROJECT_PROJECT1`
    FOREIGN KEY (`Project_ID` )
    REFERENCES `GPM`.`PROJECT` (`Project_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AIM_PROJECT_AIM1`
    FOREIGN KEY (`Aim_ID` )
    REFERENCES `GPM`.`AIM` (`Aim_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`GOVERNMENT_SECTOR`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`GOVERNMENT_SECTOR` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`GOVERNMENT_SECTOR` (
  `Government_Sector_ID` INT NOT NULL AUTO_INCREMENT ,
  `Name` TEXT NULL ,
  `Acronym` VARCHAR(6) NULL ,
  `Address` TEXT NULL ,
  `Phone_Number` VARCHAR(10) NULL ,
  PRIMARY KEY (`Government_Sector_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`SECTOR_PROJECT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`SECTOR_PROJECT` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`SECTOR_PROJECT` (
  `Sector_Project_ID` INT NOT NULL AUTO_INCREMENT ,
  `Government_Sector_ID` INT NOT NULL ,
  `Project_ID` INT NOT NULL ,
  `Contact_Name` VARCHAR(50) NULL ,
  `Contact_Phone_Number` VARCHAR(10) NULL ,
  `Contact_Email` VARCHAR(50) NULL ,
  `Is_Main_Handler` TINYINT(1) NULL ,
  PRIMARY KEY (`Sector_Project_ID`) ,
  INDEX `fk_SECTOR_PROJECT_PROJECT1_idx` (`Project_ID` ASC) ,
  INDEX `fk_SECTOR_PROJECT_GOVERNMENT_SECTOR1_idx` (`Government_Sector_ID` ASC) ,
  CONSTRAINT `fk_SECTOR_PROJECT_PROJECT1`
    FOREIGN KEY (`Project_ID` )
    REFERENCES `GPM`.`PROJECT` (`Project_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_SECTOR_PROJECT_GOVERNMENT_SECTOR1`
    FOREIGN KEY (`Government_Sector_ID` )
    REFERENCES `GPM`.`GOVERNMENT_SECTOR` (`Government_Sector_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`ACTIVITY`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`ACTIVITY` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`ACTIVITY` (
  `Activity_ID` INT NOT NULL AUTO_INCREMENT ,
  `Activity_Name` TEXT NULL ,
  `Planned_Starting_Date` DATETIME NULL ,
  `Planned_Ending_Date` DATETIME NULL ,
  `Actual_Starting_Date` DATETIME NULL ,
  `Actual_Ending_Date` DATETIME NULL ,
  `Budget_Spent_Amount` FLOAT NULL ,
  `Operational_Outcome` LONGTEXT NULL ,
  `Problem_and_Obstacle` LONGTEXT NULL ,
  `Activity_Location` TEXT NULL ,
  `Activity_Duration` INT NULL ,
  `Notes` LONGTEXT NULL ,
  `Section_Project_ID` INT NOT NULL ,
  `Source_of_Budget_ID` INT NOT NULL ,
  PRIMARY KEY (`Activity_ID`) ,
  INDEX `fk_ACTIVITY_SECTOR_PROJECT1_idx` (`Section_Project_ID` ASC) ,
  INDEX `fk_ACTIVITY_SOURCE_OF_BUDGET1_idx` (`Source_of_Budget_ID` ASC) ,
  CONSTRAINT `fk_ACTIVITY_SECTOR_PROJECT1`
    FOREIGN KEY (`Section_Project_ID` )
    REFERENCES `GPM`.`SECTOR_PROJECT` (`Sector_Project_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ACTIVITY_SOURCE_OF_BUDGET1`
    FOREIGN KEY (`Source_of_Budget_ID` )
    REFERENCES `GPM`.`SOURCE_OF_BUDGET` (`SourceOfBudget_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`USER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`USER` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`USER` (
  `User_ID` INT NOT NULL AUTO_INCREMENT ,
  `User_Name` VARCHAR(45) NOT NULL ,
  `User_Password` VARCHAR(45) NOT NULL ,
  `User_Firstname` VARCHAR(45) NOT NULL ,
  `User_Lastname` VARCHAR(45) NOT NULL ,
  `User_Contact_PhoneNumber` VARCHAR(10) NOT NULL ,
  `User_Email` VARCHAR(30) NOT NULL ,
  `Government_Sector_ID` INT NOT NULL ,
  `User_Role` VARCHAR(30) NOT NULL ,
  PRIMARY KEY (`User_ID`) ,
  INDEX `fk_USER_GOVERNMENT_SECTOR1_idx` (`Government_Sector_ID` ASC) ,
  CONSTRAINT `fk_USER_GOVERNMENT_SECTOR1`
    FOREIGN KEY (`Government_Sector_ID` )
    REFERENCES `GPM`.`GOVERNMENT_SECTOR` (`Government_Sector_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GPM`.`USER_ACTIVITY`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GPM`.`USER_ACTIVITY` ;

CREATE  TABLE IF NOT EXISTS `GPM`.`USER_ACTIVITY` (
  `User_Activity_ID` INT NOT NULL AUTO_INCREMENT ,
  `Type_Of_System_Activity` ENUM('Create','Delete','Modify','Grant','Ban','UnBan') NOT NULL ,
  `DateTime_Of_Activity` TIMESTAMP NOT NULL ,
  `Target_Entity` TEXT NOT NULL ,
  `User_ID` INT NOT NULL ,
  PRIMARY KEY (`User_Activity_ID`) ,
  INDEX `fk_SYSTEM_ACTIVITY_USER1_idx` (`User_ID` ASC) ,
  CONSTRAINT `fk_SYSTEM_ACTIVITY_USER1`
    FOREIGN KEY (`User_ID` )
    REFERENCES `GPM`.`USER` (`User_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `GPM` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
