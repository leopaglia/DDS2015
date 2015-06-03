-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema dds2015
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dds2015
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dds2015` DEFAULT CHARACTER SET latin1 ;
USE `dds2015` ;

-- -----------------------------------------------------
-- Table `dds2015`.`complexion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`complexion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`condiciones_de_salud`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`condiciones_de_salud` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`condimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`condimento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `tipo` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`temporada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`temporada` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `evento_social` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`receta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`receta` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `dificultad` INT(11) NULL DEFAULT NULL,
  `fotos` INT(11) NULL DEFAULT NULL,
  `procedimiento` VARCHAR(45) NULL DEFAULT NULL,
  `temporada` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `temporadaFK_idx` (`temporada` ASC),
  CONSTRAINT `temporadaFK`
    FOREIGN KEY (`temporada`)
    REFERENCES `dds2015`.`temporada` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`condimento_receta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`condimento_receta` (
  `idReceta` INT(11) NOT NULL,
  `idCondimento` INT(11) NOT NULL,
  PRIMARY KEY (`idReceta`, `idCondimento`),
  INDEX `condimentoFK_idx` (`idCondimento` ASC),
  INDEX `condimento_FK_idx` (`idCondimento` ASC),
  CONSTRAINT `condimento_FK`
    FOREIGN KEY (`idCondimento`)
    REFERENCES `dds2015`.`condimento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `receta_FK`
    FOREIGN KEY (`idReceta`)
    REFERENCES `dds2015`.`receta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`dieta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`dieta` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`grupos_alimenticios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`grupos_alimenticios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `contraindicaciones` INT(11) NULL DEFAULT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `descripcion` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`ingrediente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`ingrediente` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `porcion` INT(11) NULL DEFAULT NULL,
  `calorias_porcion` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`ingrediente_receta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`ingrediente_receta` (
  `idReceta` INT(11) NOT NULL,
  `idIngrediente` INT(11) NOT NULL,
  PRIMARY KEY (`idReceta`, `idIngrediente`),
  INDEX `ingredienteFK_idx` (`idIngrediente` ASC),
  CONSTRAINT `ingredienteFK`
    FOREIGN KEY (`idIngrediente`)
    REFERENCES `dds2015`.`ingrediente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `recetaFK`
    FOREIGN KEY (`idReceta`)
    REFERENCES `dds2015`.`receta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`rutina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`rutina` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `descripcion` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dds2015`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dds2015`.`usuario` (
  `dni` INT(11) NOT NULL,
  `username` VARCHAR(45) NULL DEFAULT NULL,
  `sexo` TINYINT(1) NULL DEFAULT NULL,
  `edad` INT(11) NULL DEFAULT NULL,
  `altura` INT(11) NULL DEFAULT NULL,
  `complexion` INT(11) NULL DEFAULT NULL,
  `dieta` INT(11) NULL DEFAULT NULL,
  `preferencias` INT(11) NULL DEFAULT NULL,
  `rutina` INT(11) NULL DEFAULT NULL,
  `condicion` INT(11) NULL DEFAULT NULL,
  `password` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`dni`),
  INDEX `complexionFK_idx` (`complexion` ASC),
  INDEX `condicionSaludFK_idx` (`condicion` ASC),
  INDEX `dietaFK_idx` (`dieta` ASC),
  INDEX `rutinaFK_idx` (`rutina` ASC),
  INDEX `preferenciasFK_idx` (`preferencias` ASC),
  CONSTRAINT `complexionFK`
    FOREIGN KEY (`complexion`)
    REFERENCES `dds2015`.`complexion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `condicionSaludFK`
    FOREIGN KEY (`condicion`)
    REFERENCES `dds2015`.`condiciones_de_salud` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `dietaFK`
    FOREIGN KEY (`dieta`)
    REFERENCES `dds2015`.`dieta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `preferenciasFK`
    FOREIGN KEY (`preferencias`)
    REFERENCES `dds2015`.`grupos_alimenticios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `rutinaFK`
    FOREIGN KEY (`rutina`)
    REFERENCES `dds2015`.`rutina` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

CREATE TABLE `dds2015`.`condiciones_usuario` (
  `idCondiciones` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idCondiciones`, `idUsuario`),
  INDEX `FK_Usuario_idx` (`idUsuario` ASC),
  CONSTRAINT `FK_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `dds2015`.`usuario` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Condicion`
    FOREIGN KEY (`idCondiciones`)
    REFERENCES `dds2015`.`condiciones_de_salud` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

ALTER TABLE `dds2015`.`usuario` 
DROP FOREIGN KEY `condicionSaludFK`;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


