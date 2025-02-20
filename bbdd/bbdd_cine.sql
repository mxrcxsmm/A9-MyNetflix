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

CREATE TABLE likes_pelicula (
    id_like INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_pelicula INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_pelicula) REFERENCES pelicula(id_pelicula) ON DELETE CASCADE ON UPDATE CASCADE
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


-- INSERTS ROLES
INSERT INTO rol (id_rol, rol) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- INSERTS USUARIOS
INSERT INTO usuario (id_usuario, nombre, apellidos, contrasena, correo, id_rol) VALUES
(1, 'Juan', 'Pérez', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'juan.perez@example.com', 1),
(2, 'María', 'Gómez', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'maria.gomez@example.com', 2),
(3, 'Carlos', 'López', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'carlos.lopez@example.com', 2),
(4, 'Ana', 'Martínez', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'ana.martinez@example.com', 2),
(5, 'Luis', 'Hernández', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'luis.hernandez@example.com', 2),
(6, 'Laura', 'Díaz', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'laura.diaz@example.com', 2),
(7, 'José', 'Rodríguez', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'jose.rodriguez@example.com', 2),
(8, 'Elena', 'Fernández', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'elena.fernandez@example.com', 2),
(9, 'Miguel', 'García', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'miguel.garcia@example.com', 2),
(10, 'Lucía', 'Sánchez', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'lucia.sanchez@example.com', 2),
(11, 'David', 'Ramírez', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'david.ramirez@example.com', 2),
(12, 'Sara', 'Torres', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'sara.torres@example.com', 2),
(13, 'Javier', 'Flores', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'javier.flores@example.com', 2),
(14, 'Carmen', 'Ruiz', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'carmen.ruiz@example.com', 2),
(15, 'Raúl', 'Moreno', '$2a$12$SCi1wSZlgq1Ln/6DHa5HA.xN9ryaKIvIrthrdjxEQI1NZW3cGOQHe', 'raul.moreno@example.com', 2);

-- INSERTS PELICULAS
INSERT INTO pelicula (titulo, ano_estreno, duracion, nacionalidad, sinopsis, portada) VALUES
-- Saga Torrente
('Torrente, el brazo tonto de la ley', 1998, 97, 'España', 'Un policía corrupto y alcohólico intenta resolver un caso.', 'torrente1.jpg'),
('Torrente 2: Misión en Marbella', 2001, 99, 'España', 'Torrente se infiltra en una red de narcotráfico en Marbella.', 'torrente2.jpg'),
('Torrente 3: El protector', 2005, 104, 'España', 'Torrente protege a una joven de una banda de traficantes.', 'torrente3.jpg'),
('Torrente 4: Lethal Crisis', 2011, 102, 'España', 'Torrente se enfrenta a una organización criminal internacional.', 'torrente4.jpg'),
('Torrente 5: Operación Eurovegas', 2014, 100, 'España', 'Torrente investiga un caso relacionado con Eurovegas.', 'torrente5.jpg'),

-- Otras películas
('Death Race', 2008, 105, 'Estados Unidos', 'Un exconvicto compite en una carrera mortal para ganar su libertad.', 'deathrace.jpg'),
('The Fast and the Furious', 2001, 106, 'Estados Unidos', 'Un policía se infiltra en el mundo de las carreras callejeras.', 'fast1.jpg'),
('Fast & Furious 7', 2015, 137, 'Estados Unidos', 'Dom y su equipo buscan venganza tras la muerte de un amigo.', 'fast7.jpg'),
('Fast & Furious 9', 2021, 145, 'Estados Unidos', 'Dom y su familia enfrentan una nueva amenaza global.', 'fast9.jpg'),
('Fast X', 2023, 141, 'Estados Unidos', 'Dom y su equipo se enfrentan a un enemigo inesperado.', 'fastx.jpg');

-- INSERTS GENERO
INSERT INTO genero (id_genero, nombre_genero, desc_genero) VALUES
(1, 'Comedia', 'Películas diseñadas para provocar risas.'),
(2, 'Acción', 'Películas llenas de emocionantes secuencias de acción.'),
(3, 'Crimen', 'Películas que involucran actividades criminales.'),
(4, 'Aventura', 'Películas con viajes y situaciones emocionantes.'),
(5, 'Drama', 'Películas que se centran en el desarrollo de personajes y temas emocionales.');

-- INSERTS INT_GENERO_PELICULA
INSERT INTO int_genero_pelicula (id_genero, id_pelicula) VALUES
-- Torrente
(1, 1), (2, 1), (3, 1),  -- Torrente 1: Comedia, Acción, Crimen
(1, 2), (2, 2), (3, 2),  -- Torrente 2: Comedia, Acción, Crimen
(1, 3), (2, 3), (3, 3),  -- Torrente 3: Comedia, Acción, Crimen
(1, 4), (2, 4), (3, 4),  -- Torrente 4: Comedia, Acción, Crimen
(1, 5), (2, 5), (3, 5),  -- Torrente 5: Comedia, Acción, Crimen

-- Otras películas
(2, 6), (4, 6),          -- Death Race: Acción, Aventura
(2, 7), (4, 7),          -- The Fast and the Furious: Acción, Aventura
(2, 8), (4, 8),          -- Fast & Furious 7: Acción, Aventura
(2, 9), (4, 9),          -- Fast & Furious 9: Acción, Aventura
(2, 10), (4, 10);        -- Fast X: Acción, Aventura

-- INSERTS FUNCION_PERSONAL
INSERT INTO funcion_personal (id_rolPersonal, rolPersonal) VALUES
(1, 'Director'),
(2, 'Actor'),
(3, 'Guionista'),
(4, 'Productor');

-- INSERTS PERSONAL
INSERT INTO personal (nombre_personal, apellidos_personal, id_rolPersonal) VALUES
-- Directores
('Santiago', 'Segura', 1),  -- Director de Torrente
('Paul', 'Anderson', 1),    -- Director de Death Race
('Rob', 'Cohen', 1),        -- Director de The Fast and the Furious
('James', 'Wan', 1),        -- Director de Fast & Furious 7
('Justin', 'Lin', 1),       -- Director de Fast & Furious 9 y Fast X

-- Actores
('Santiago', 'Segura', 2),  -- Protagonista de Torrente
('Jason', 'Statham', 2),    -- Protagonista de Death Race
('Vin', 'Diesel', 2),       -- Protagonista de Fast & Furious
('Paul', 'Walker', 2),      -- Protagonista de Fast & Furious
('Michelle', 'Rodriguez', 2); -- Actriz de Fast & Furious

-- INSERTS INT_PERSONAL_PELICULA
INSERT INTO int_personal_pelicula (id_personal, id_pelicula) VALUES
-- Torrente
(1, 1), (6, 1),  -- Santiago Segura (Director y Actor) en Torrente 1
(1, 2), (6, 2),  -- Santiago Segura en Torrente 2
(1, 3), (6, 3),  -- Santiago Segura en Torrente 3
(1, 4), (6, 4),  -- Santiago Segura en Torrente 4
(1, 5), (6, 5),  -- Santiago Segura en Torrente 5

-- Death Race
(2, 6), (7, 6),  -- Paul Anderson (Director) y Jason Statham (Actor) en Death Race

-- Fast & Furious
(3, 7), (8, 7), (9, 7),  -- Rob Cohen (Director), Vin Diesel y Paul Walker en Fast 1
(4, 8), (8, 8), (10, 8), -- James Wan (Director), Vin Diesel y Michelle Rodriguez en Fast 7
(5, 9), (8, 9), (10, 9), -- Justin Lin (Director), Vin Diesel y Michelle Rodriguez en Fast 9
(5, 10), (8, 10), (10, 10); -- Justin Lin (Director), Vin Diesel y Michelle Rodriguez en Fast X

-- INSERTS LIKES_PELICULA
INSERT INTO likes_pelicula (id_usuario, id_pelicula) VALUES
-- Torrente 3 tiene más likes
(1, 3), (2, 3), (3, 3), (4, 3), (5, 3), (6, 3), (7, 3), (8, 3), (9, 3), (10, 3),

-- Otras películas con menos likes
(1, 1), (2, 1), (3, 1),  -- Torrente 1
(1, 2), (2, 2),          -- Torrente 2
(1, 4), (2, 4),          -- Torrente 4
(1, 5),                  -- Torrente 5
(1, 6), (2, 6), (3, 6),  -- Death Race
(1, 7), (2, 7),          -- Fast 1
(1, 8), (2, 8), (3, 8),  -- Fast 7
(1, 9),                  -- Fast 9
(1, 10);                 -- Fast X