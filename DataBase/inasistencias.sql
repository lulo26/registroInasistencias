-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-02-2025 a las 22:42:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inasistencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE `aprendices` (
  `idaprendiz` int(11) NOT NULL,
  `nombre_aprendiz` varchar(50) NOT NULL,
  `apellido_aprendiz` varchar(50) NOT NULL,
  `generos_idgenero` int(11) NOT NULL,
  `numdoc` varchar(50) NOT NULL,
  `estado_aprendiz` varchar(50) NOT NULL,
  `codigo_aprendiz` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloques`
--

CREATE TABLE `bloques` (
  `idbloque` int(11) NOT NULL,
  `tipo_bloque` varchar(45) NOT NULL,
  `hora_bloque` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `idcurso` int(11) NOT NULL,
  `nombre_curso` varchar(45) NOT NULL,
  `tipo_curso` varchar(50) NOT NULL,
  `descripcion_curso` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `excepciones`
--

CREATE TABLE `excepciones` (
  `idexcepcion` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `motivo_excepcion` text NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  `excepcionescol` varchar(45) DEFAULT NULL,
  `bloques_idbloque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `excusas`
--

CREATE TABLE `excusas` (
  `idexcusa` int(11) NOT NULL,
  `fecha_excusa` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `filename_excusa` varchar(500) DEFAULT NULL,
  `filepath_excusa` varchar(500) DEFAULT NULL,
  `aprendices_idusuario` int(11) NOT NULL,
  `registro_inasistencias_idregistro` int(11) NOT NULL,
  `estado_excusa` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `idficha` int(11) NOT NULL,
  `numero_ficha` int(11) NOT NULL,
  `cursos_idcurso` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `modalidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idhorario` int(11) NOT NULL,
  `fecha_horario` date NOT NULL,
  `Jornada` varchar(45) NOT NULL,
  `fichas_idficha` int(11) NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  `bloques_idbloque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inasistencias`
--

CREATE TABLE `inasistencias` (
  `idregistro` int(11) NOT NULL,
  `aprendices_idusuario` int(11) NOT NULL,
  `fecha_inasistencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `registro_idusuario` int(11) NOT NULL,
  `estado_inasistencia` varchar(45) NOT NULL,
  `hora_inasistencia` time NOT NULL,
  `retardos_inasistencia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `numdoc_usuarios` varchar(45) NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `password_usuario` varchar(45) NOT NULL,
  `correo_usuario` varchar(45) NOT NULL,
  `telefono_usuario` varchar(45) NOT NULL,
  `roles_usuarios` varchar(30) NOT NULL,
  `codigo_usuarios` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  ADD PRIMARY KEY (`idaprendiz`),
  ADD UNIQUE KEY `numdoc_UNIQUE` (`numdoc`);

--
-- Indices de la tabla `bloques`
--
ALTER TABLE `bloques`
  ADD PRIMARY KEY (`idbloque`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`idcurso`);

--
-- Indices de la tabla `excepciones`
--
ALTER TABLE `excepciones`
  ADD PRIMARY KEY (`idexcepcion`),
  ADD KEY `fk_excepciones_usuarios1_idx` (`usuarios_idusuario`),
  ADD KEY `fk_excepciones_bloques1_idx` (`bloques_idbloque`);

--
-- Indices de la tabla `excusas`
--
ALTER TABLE `excusas`
  ADD PRIMARY KEY (`idexcusa`),
  ADD KEY `fk_excusas_aprendices1_idx` (`aprendices_idusuario`),
  ADD KEY `fk_excusas_registro_inasistencias1_idx` (`registro_inasistencias_idregistro`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`idficha`),
  ADD KEY `fk_fichas_cursos1_idx` (`cursos_idcurso`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`idhorario`),
  ADD KEY `fk_horarios_fichas1_idx` (`fichas_idficha`),
  ADD KEY `fk_horarios_usuarios1_idx` (`usuarios_idusuario`),
  ADD KEY `fk_horarios_bloques1_idx` (`bloques_idbloque`);

--
-- Indices de la tabla `inasistencias`
--
ALTER TABLE `inasistencias`
  ADD PRIMARY KEY (`idregistro`),
  ADD KEY `fk_registro_inasistencias_aprendices1_idx` (`aprendices_idusuario`),
  ADD KEY `fk_registro_inasistencias_usuarios1_idx` (`registro_idusuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `idaprendiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `bloques`
--
ALTER TABLE `bloques`
  MODIFY `idbloque` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `idcurso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `excepciones`
--
ALTER TABLE `excepciones`
  MODIFY `idexcepcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `excusas`
--
ALTER TABLE `excusas`
  MODIFY `idexcusa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `idficha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `idhorario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inasistencias`
--
ALTER TABLE `inasistencias`
  MODIFY `idregistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `excepciones`
--
ALTER TABLE `excepciones`
  ADD CONSTRAINT `fk_excepciones_bloques1` FOREIGN KEY (`bloques_idbloque`) REFERENCES `bloques` (`idbloque`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_excepciones_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `excusas`
--
ALTER TABLE `excusas`
  ADD CONSTRAINT `fk_excusas_aprendices1` FOREIGN KEY (`aprendices_idusuario`) REFERENCES `aprendices` (`idaprendiz`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_excusas_registro_inasistencias1` FOREIGN KEY (`registro_inasistencias_idregistro`) REFERENCES `inasistencias` (`idregistro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD CONSTRAINT `fk_fichas_cursos1` FOREIGN KEY (`cursos_idcurso`) REFERENCES `cursos` (`idcurso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_bloques1` FOREIGN KEY (`bloques_idbloque`) REFERENCES `bloques` (`idbloque`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_horarios_fichas1` FOREIGN KEY (`fichas_idficha`) REFERENCES `fichas` (`idficha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_horarios_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inasistencias`
--
ALTER TABLE `inasistencias`
  ADD CONSTRAINT `fk_registro_inasistencias_aprendices1` FOREIGN KEY (`aprendices_idusuario`) REFERENCES `aprendices` (`idaprendiz`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registro_inasistencias_usuarios1` FOREIGN KEY (`registro_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
