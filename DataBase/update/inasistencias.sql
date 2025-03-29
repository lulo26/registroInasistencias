-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-03-2025 a las 07:21:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
  `idusuario` int(11) NOT NULL,
  `nombre_aprendiz` varchar(50) NOT NULL,
  `apellido_aprendiz` varchar(50) NOT NULL,
  `generos_idgenero` int(11) NOT NULL,
  `numdoc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `idcurso` int(11) NOT NULL,
  `nombre_curso` varchar(45) NOT NULL,
  `tipo_curso` varchar(50) NOT NULL,
  `descripcion_curso` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`idcurso`, `nombre_curso`, `tipo_curso`, `descripcion_curso`) VALUES
(1, 'PHP', 'tecnologo', 'curso de php'),
(3, 'cocina', 'tecnico', 'curso de cocina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `excusas`
--

CREATE TABLE `excusas` (
  `idexcusa` int(11) NOT NULL,
  `aprendices_idusuario` int(11) NOT NULL,
  `fecha_excusa` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `descripcion_excusa` longtext NOT NULL,
  `tipo_excusa` varchar(50) NOT NULL,
  `estado_excusa` varchar(45) NOT NULL,
  `registro_inasistencias_idregistro` int(11) NOT NULL
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

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`idficha`, `numero_ficha`, `cursos_idcurso`, `fecha_inicio`, `fecha_fin`, `modalidad`) VALUES
(1, 2827725, 1, '2024-09-04', '2024-12-18', 'presencial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idhorario` int(11) NOT NULL,
  `fecha_horario` date NOT NULL,
  `fecha_inicio` varchar(45) NOT NULL,
  `fichas_idficha` int(11) NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  `fecha_fin` int(11) NOT NULL,
  `ficha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_inasistencias`
--

CREATE TABLE `registro_inasistencias` (
  `idregistro` int(11) NOT NULL,
  `aprendices_idusuario` int(11) NOT NULL,
  `fehca_inasistencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `registro_idusuario` int(11) NOT NULL,
  `estado_inasistencia` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `nombre_rol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idrol`, `nombre_rol`) VALUES
(1, 'administrador'),
(2, 'profesor'),
(3, 'alumno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `password_usuario` varchar(45) NOT NULL,
  `correo_usuario` varchar(45) NOT NULL,
  `numero_usuario` varchar(45) NOT NULL,
  `roles_idrol` int(11) NOT NULL,
  `apellido_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre_usuario`, `password_usuario`, `correo_usuario`, `numero_usuario`, `roles_idrol`, `apellido_usuario`) VALUES
(1, 'luis', '123456', 'luis@gmail', '214552', 3, ''),
(2, 'Juan Camilo', '123456', 'camilo@correo', '542313', 2, 'Vanegas González'),
(3, 'master', '123456', 'master@correo', '2254562', 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `numdoc_UNIQUE` (`numdoc`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`idcurso`);

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
  ADD KEY `fk_horarios_usuarios1_idx` (`usuarios_idusuario`);

--
-- Indices de la tabla `registro_inasistencias`
--
ALTER TABLE `registro_inasistencias`
  ADD PRIMARY KEY (`idregistro`),
  ADD KEY `fk_registro_inasistencias_aprendices1_idx` (`aprendices_idusuario`),
  ADD KEY `fk_registro_inasistencias_usuarios1_idx` (`registro_idusuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `fk_usuarios_roles1_idx` (`roles_idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `idcurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `excusas`
--
ALTER TABLE `excusas`
  MODIFY `idexcusa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `idficha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `idhorario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_inasistencias`
--
ALTER TABLE `registro_inasistencias`
  MODIFY `idregistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `excusas`
--
ALTER TABLE `excusas`
  ADD CONSTRAINT `fk_excusas_aprendices1` FOREIGN KEY (`aprendices_idusuario`) REFERENCES `aprendices` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_excusas_registro_inasistencias1` FOREIGN KEY (`registro_inasistencias_idregistro`) REFERENCES `registro_inasistencias` (`idregistro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD CONSTRAINT `fk_fichas_cursos1` FOREIGN KEY (`cursos_idcurso`) REFERENCES `cursos` (`idcurso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_fichas1` FOREIGN KEY (`fichas_idficha`) REFERENCES `fichas` (`idficha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_horarios_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `registro_inasistencias`
--
ALTER TABLE `registro_inasistencias`
  ADD CONSTRAINT `fk_registro_inasistencias_aprendices1` FOREIGN KEY (`aprendices_idusuario`) REFERENCES `aprendices` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registro_inasistencias_usuarios1` FOREIGN KEY (`registro_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles1` FOREIGN KEY (`roles_idrol`) REFERENCES `roles` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
