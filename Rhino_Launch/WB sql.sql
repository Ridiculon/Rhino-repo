SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Video`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`Video` (
  `Video_id` INT NOT NULL ,
  `Title` VARCHAR(45) NOT NULL ,
  `Link` VARCHAR(45) NOT NULL ,
  `Rating` INT NULL ,
  `Rank` INT NULL ,
  `Contest id` INT NOT NULL ,
  `User id` INT NOT NULL ,
  `Flag` TINYINT(1)  NULL ,
  `Date Added` DATETIME NOT NULL ,
  `Description` VARCHAR(45) NULL ,
  PRIMARY KEY (`Video_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`User`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`User` (
  `User_id` INT NOT NULL ,
  `Uname` VARCHAR(45) NOT NULL ,
  `Password` VARCHAR(45) NOT NULL ,
  `Name` VARCHAR(45) NOT NULL ,
  `Age` INT NOT NULL ,
  `Picture` VARCHAR(45) NULL ,
  `Email` VARCHAR(45) NOT NULL ,
  `RPoints` INT NULL ,
  `Video_Video id` INT NOT NULL ,
  PRIMARY KEY (`User_id`, `Video_Video id`) ,
  INDEX `fk_User_Video` (`Video_Video id` ASC) ,
  CONSTRAINT `fk_User_Video`
    FOREIGN KEY (`Video_Video id` )
    REFERENCES `mydb`.`Video` (`Video_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = IBMDB2I;


-- -----------------------------------------------------
-- Table `mydb`.`Contest`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`Contest` (
  `Contest_id` INT NOT NULL ,
  `Video_Video id` INT NOT NULL ,
  `Summary` VARCHAR(45) NULL ,
  `Name` VARCHAR(45) NULL ,
  `Prize$` DECIMAL NULL ,
  `PrizeR` INT NULL ,
  `Icon` VARCHAR(45) NULL ,
  `StartDate` DATE NULL ,
  `EndDate` DATE NULL ,
  `Type` VARCHAR(45) NULL ,
  `BizSummary` VARCHAR(45) NULL ,
  `BizPicture` VARCHAR(45) NULL ,
  PRIMARY KEY (`Contest_id`, `Video_Video id`) ,
  INDEX `fk_Contest_Video1` (`Video_Video id` ASC) ,
  CONSTRAINT `fk_Contest_Video1`
    FOREIGN KEY (`Video_Video id` )
    REFERENCES `mydb`.`Video` (`Video_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- procedure get_contest_by_id
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`get_contest_by_id` ()
BEGIN

SELECT Prize$, PrizeR, Summary, StartDate, EndDate, Title, Contest_id FROM Contest WHERE Contest_id = Contest.contestid;
END





$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure get_contest_order_by_desc
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`get_contest_order_by_desc` ()
BEGIN

SELECT Prize$, PrizeR, Summary, StartDate, EndDate, Title, Contest_id FROM Contest ORDER BY EndDate DESC;
END



$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure get_contest_by_search
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`get_contest_by_search` ()
BEGIN
SELECT Prize$, PrizeR, Summary, StartDate, EndDate, Title, Contest_id FROM Contest WHERE Summary LIKE '%".$contestsearch."%' OR Title LIKE '%".$contestsearch."%';
END



$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure logon
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`logon` ()
BEGIN

SELECT Uname, Password FROM User WHERE Uname = '".$Uname."' AND Password = '".$Password."';

END

$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure get_prefered_user
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`get_prefered_user` ()
BEGIN

SELECT Uname, RPoints, User_id FROM User WHERE RPoints > 90 AND User_id = '".$id"'; 
END


$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure get_points_order_by_desc
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`get_points_order_by_desc` ()
BEGIN

SELECT Uname, RPoints FROM User WHERE RPoints > 90 ORDER BY Points DESC; 

END
$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure search_preferred_users
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`search_preferred_users` ()
BEGIN

SELECT Uname, RPoints, User_id FROM User WHERE RPoints > 90 AND Uname LIKE '%".$searchname."%'; 

END
$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure get_username
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`get_username` ()
BEGIN

SELECT Uname FROM User WHERE Uname = '".$username."';

END
$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure get_video
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`get_video` ()
BEGIN

SELECT Description, Title, Link, Rating, Rank, Video_id FROM Video WHERE Video_id = '".$videoid."';

END
$$

DELIMITER ;
-- -----------------------------------------------------
-- procedure get_video_by_contest_id
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE PROCEDURE `mydb`.`get_video_by_contest_id` ()
BEGIN

SELECT Description, Title, Link, Rating, Rank, Video_id FROM Video WHERE Contest_id = '".$videoid."';

END
$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
