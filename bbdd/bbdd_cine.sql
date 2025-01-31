DROP DATABASE IF EXISTS netflix;

CREATE DATABASE netflix;
USE netflix;

CREATE TABLE Rol (
    id_rol INT PRIMARY KEY NOT NULL,
    rol VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE Usuario (
    id_usuario INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE genero (
    id_genero INT PRIMARY KEY NOT NULL,
    nombre_genero VARCHAR(255) NOT NULL,
    desc_genero VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE pelicula (
    id_pelicula INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    ano_estreno YEAR NOT NULL,
    duracion INT(6) NOT NULL,
    nacionalidad VARCHAR(255) NOT NULL,
    sinopsis TEXT NOT NULL,
    portada VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE int_genero_pelicula (
    id_generos_pelicula INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_genero INT NOT NULL,
    id_pelicula INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE funcion_personal (
    id_rolPersonal INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    rolPersonal VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE personal (
    id_personal INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre_personal VARCHAR(255) NOT NULL,
    apellidos_personal VARCHAR(255) NOT NULL,
    id_rolPersonal INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE int_personal_pelicula (
    id_personal_pelicula INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_personal INT NOT NULL,
    id_pelicula INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- RELACIONES TABLAS USUARIO/ROL
ALTER TABLE `netflix`.`usuario` 
ADD INDEX `fk_rol_usuario_idx` (`id_rol` ASC) VISIBLE;
;
ALTER TABLE `netflix`.`usuario` 
ADD CONSTRAINT `fk_rol_usuario`
  FOREIGN KEY (`id_rol`)
  REFERENCES `netflix`.`rol` (`id_rol`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


-- RELACIONES TABLAS PERSONAL/PELICULA
ALTER TABLE `netflix`.`int_personal_pelicula` 
ADD INDEX `fk_personal_idx` (`id_personal` ASC) VISIBLE,
ADD INDEX `fk_pelicula_idx` (`id_pelicula` ASC) VISIBLE;
;
ALTER TABLE `netflix`.`int_personal_pelicula` 
ADD CONSTRAINT `fk_personal`
  FOREIGN KEY (`id_personal`)
  REFERENCES `netflix`.`personal` (`id_personal`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pelicula`
  FOREIGN KEY (`id_pelicula`)
  REFERENCES `netflix`.`pelicula` (`id_pelicula`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

-- RELACIONES TABLAS PERSONAL/FUNCION PERSONAL
ALTER TABLE `netflix`.`personal` 
ADD INDEX `fk_funcion_personal_idx` (`id_rolPersonal` ASC) VISIBLE;
;
ALTER TABLE `netflix`.`personal` 
ADD CONSTRAINT `fk_funcion_personal`
  FOREIGN KEY (`id_rolPersonal`)
  REFERENCES `netflix`.`funcion_personal` (`id_rolPersonal`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

-- RELACIONES TABLAS PELICULA/GENERO

ALTER TABLE `netflix`.`int_genero_pelicula` 
ADD INDEX `fk_generoPelicula_idx` (`id_pelicula` ASC) VISIBLE,
ADD INDEX `fk_genero_idx` (`id_genero` ASC) VISIBLE;
;
ALTER TABLE `netflix`.`int_genero_pelicula` 
ADD CONSTRAINT `fk_generoPelicula`
  FOREIGN KEY (`id_pelicula`)
  REFERENCES `netflix`.`pelicula` (`id_pelicula`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_genero`
  FOREIGN KEY (`id_genero`)
  REFERENCES `netflix`.`genero` (`id_genero`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;