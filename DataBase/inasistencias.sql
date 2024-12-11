-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema inasistencias
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema inasistencias
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `inasistencias` DEFAULT CHARACTER SET utf8 ;
USE `inasistencias` ;

-- -----------------------------------------------------
-- Table `inasistencias`.`aprendices`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`aprendices` (
  `idaprendiz` INT NOT NULL AUTO_INCREMENT,
  `nombre_aprendiz` VARCHAR(50) NOT NULL,
  `apellido_aprendiz` VARCHAR(50) NOT NULL,
  `generos_idgenero` INT NOT NULL,
  `numdoc` VARCHAR(50) NOT NULL,
  `estado_aprendiz` VARCHAR(50) NOT NULL,
  `codigo_aprendiz` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`idaprendiz`),
  UNIQUE INDEX `numdoc_UNIQUE` (`numdoc` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`roles` (
  `idrol` INT NOT NULL AUTO_INCREMENT,
  `nombre_rol` VARCHAR(45) NOT NULL,
  `descripcion_rol` TEXT NULL,
  PRIMARY KEY (`idrol`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`cursos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`cursos` (
  `idcurso` INT NOT NULL AUTO_INCREMENT,
  `nombre_curso` VARCHAR(45) NOT NULL,
  `tipo_curso` VARCHAR(50) NOT NULL,
  `descripcion_curso` TINYTEXT NULL,
  PRIMARY KEY (`idcurso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`fichas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`fichas` (
  `idficha` INT NOT NULL AUTO_INCREMENT,
  `numero_ficha` INT NOT NULL,
  `cursos_idcurso` INT NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `modalidad` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idficha`),
  INDEX `fk_fichas_cursos1_idx` (`cursos_idcurso` ASC) ,
  CONSTRAINT `fk_fichas_cursos1`
    FOREIGN KEY (`cursos_idcurso`)
    REFERENCES `inasistencias`.`cursos` (`idcurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`usuarios` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `numdoc_usuarios` VARCHAR(45) NOT NULL,
  `nombre_usuario` VARCHAR(45) NOT NULL,
  `password_usuario` VARCHAR(45) NOT NULL,
  `correo_usuario` VARCHAR(45) NOT NULL,
  `telefono_usuario` VARCHAR(45) NOT NULL,
  `roles_idrol` INT NOT NULL,
  `codigo_usuarios` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`idusuario`),
  INDEX `fk_usuarios_roles1_idx` (`roles_idrol` ASC) ,
  CONSTRAINT `fk_usuarios_roles1`
    FOREIGN KEY (`roles_idrol`)
    REFERENCES `inasistencias`.`roles` (`idrol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`bloques`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`bloques` (
  `idbloque` INT NOT NULL AUTO_INCREMENT,
  `tipo_bloque` VARCHAR(45) NOT NULL,
  `hora_bloque` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idbloque`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`horarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`horarios` (
  `idhorario` INT NOT NULL AUTO_INCREMENT,
  `fecha_horario` DATE NOT NULL,
  `Jornada` VARCHAR(45) NOT NULL,
  `fichas_idficha` INT NOT NULL,
  `usuarios_idusuario` INT NOT NULL,
  `bloques_idbloque` INT NOT NULL,
  PRIMARY KEY (`idhorario`),
  INDEX `fk_horarios_fichas1_idx` (`fichas_idficha` ASC) ,
  INDEX `fk_horarios_usuarios1_idx` (`usuarios_idusuario` ASC) ,
  INDEX `fk_horarios_bloques1_idx` (`bloques_idbloque` ASC) ,
  CONSTRAINT `fk_horarios_fichas1`
    FOREIGN KEY (`fichas_idficha`)
    REFERENCES `inasistencias`.`fichas` (`idficha`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_horarios_usuarios1`
    FOREIGN KEY (`usuarios_idusuario`)
    REFERENCES `inasistencias`.`usuarios` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_horarios_bloques1`
    FOREIGN KEY (`bloques_idbloque`)
    REFERENCES `inasistencias`.`bloques` (`idbloque`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`registro_inasistencias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`registro_inasistencias` (
  `idregistro` INT NOT NULL AUTO_INCREMENT,
  `aprendices_idusuario` INT NOT NULL,
  `fecha_inasistencia` TIMESTAMP NOT NULL,
  `registro_idusuario` INT NOT NULL,
  `estado_inasistencia` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idregistro`),
  INDEX `fk_registro_inasistencias_aprendices1_idx` (`aprendices_idusuario` ASC) ,
  INDEX `fk_registro_inasistencias_usuarios1_idx` (`registro_idusuario` ASC) ,
  CONSTRAINT `fk_registro_inasistencias_aprendices1`
    FOREIGN KEY (`aprendices_idusuario`)
    REFERENCES `inasistencias`.`aprendices` (`idaprendiz`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_inasistencias_usuarios1`
    FOREIGN KEY (`registro_idusuario`)
    REFERENCES `inasistencias`.`usuarios` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`excusas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`excusas` (
  `idexcusa` INT NOT NULL AUTO_INCREMENT,
  `aprendices_idusuario` INT NOT NULL,
  `fecha_excusa` TIMESTAMP NOT NULL,
  `descripcion_excusa` LONGTEXT NOT NULL,
  `tipo_excusa` VARCHAR(50) NOT NULL,
  `estado_excusa` VARCHAR(45) NOT NULL,
  `registro_inasistencias_idregistro` INT NOT NULL,
  PRIMARY KEY (`idexcusa`),
  INDEX `fk_excusas_aprendices1_idx` (`aprendices_idusuario` ASC) ,
  INDEX `fk_excusas_registro_inasistencias1_idx` (`registro_inasistencias_idregistro` ASC) ,
  CONSTRAINT `fk_excusas_aprendices1`
    FOREIGN KEY (`aprendices_idusuario`)
    REFERENCES `inasistencias`.`aprendices` (`idaprendiz`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_excusas_registro_inasistencias1`
    FOREIGN KEY (`registro_inasistencias_idregistro`)
    REFERENCES `inasistencias`.`registro_inasistencias` (`idregistro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inasistencias`.`excepciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inasistencias`.`excepciones` (
  `idexcepcion` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL,
  `motivo_excepcion` TEXT NOT NULL,
  `usuarios_idusuario` INT NOT NULL,
  `excepcionescol` VARCHAR(45) NULL,
  `bloques_idbloque` INT NOT NULL,
  PRIMARY KEY (`idexcepcion`),
  INDEX `fk_excepciones_usuarios1_idx` (`usuarios_idusuario` ASC) ,
  INDEX `fk_excepciones_bloques1_idx` (`bloques_idbloque` ASC) ,
  CONSTRAINT `fk_excepciones_usuarios1`
    FOREIGN KEY (`usuarios_idusuario`)
    REFERENCES `inasistencias`.`usuarios` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_excepciones_bloques1`
    FOREIGN KEY (`bloques_idbloque`)
    REFERENCES `inasistencias`.`bloques` (`idbloque`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
